<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Flex;

use Composer\IO\IOInterface;
use Composer\Util\ProcessExecutor;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Options
{
    private $options;
    private $writtenFiles = [];
    private $io;

    public function __construct(array $options = [], IOInterface $io = null)
    {
        $this->options = $options;
        $this->io = $io;
    }

    public function get(string $name)
    {
        return $this->options[$name] ?? null;
    }

    public function expandTargetDir(string $target): string
    {
        return preg_replace_callback('{%(.+?)%}', function ($matches) {
            $option = str_replace('_', '-', strtolower($matches[1]));
            if (!isset($this->options[$option])) {
                return $matches[0];
            }

            return rtrim($this->options[$option], '/');
        }, $target);
    }

    public function shouldWriteFile(string $file, bool $overwrite): bool
    {
        if (isset($this->writtenFiles[$file])) {
            return false;
        }
        $this->writtenFiles[$file] = true;

        if (!file_exists($file)) {
            return true;
        }

        if (!$overwrite) {
            return false;
        }

        if (!filesize($file)) {
            return true;
        }

        exec('git status --short --ignored -- '.ProcessExecutor::escape($file).' 2>&1', $output, $status);

        if (0 !== $status) {
            return (bool) $this->io && $this->io->askConfirmation(sprintf('Cannot determine the state of the "%s" file, overwrite anyway? [y/N] ', $file), false);
        }

        if (empty($output[0]) || preg_match('/^[ AMDRCU][ D][ \t]/', $output[0])) {
            return true;
        }

        $name = basename($file);
        $name = \strlen($output[0]) - \strlen($name) === strrpos($output[0], $name) ? substr($output[0], 3) : $name;

        return (bool) $this->io && $this->io->askConfirmation(sprintf('File "%s" has uncommitted changes, overwrite? [y/N] ', $name), false);
    }

    public function toArray(): array
    {
        return $this->options;
    }
}
