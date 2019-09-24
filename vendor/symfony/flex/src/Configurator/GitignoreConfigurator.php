<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Flex\Configurator;

use Symfony\Flex\Lock;
use Symfony\Flex\Recipe;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class GitignoreConfigurator extends AbstractConfigurator
{
    public function configure(Recipe $recipe, $vars, Lock $lock, array $options = [])
    {
        $this->write('Added entries to .gitignore');

        $gitignore = $this->options->get('root-dir').'/.gitignore';
        if (empty($options['force']) && $this->isFileMarked($recipe, $gitignore)) {
            return;
        }

        $data = '';
        foreach ($vars as $value) {
            $value = $this->options->expandTargetDir($value);
            $data .= "$value\n";
        }
        $data = "\n".ltrim($this->markData($recipe, $data), "\r\n");

        if (!$this->updateData($gitignore, $data)) {
            file_put_contents($gitignore, $data, FILE_APPEND);
        }
    }

    public function unconfigure(Recipe $recipe, $vars, Lock $lock)
    {
        $file = $this->options->get('root-dir').'/.gitignore';
        if (!file_exists($file)) {
            return;
        }

        $contents = preg_replace(sprintf('{%s*###> %s ###.*###< %s ###%s+}s', "\n", $recipe->getName(), $recipe->getName(), "\n"), "\n", file_get_contents($file), -1, $count);
        if (!$count) {
            return;
        }

        $this->write('Removed entries in .gitignore');
        file_put_contents($file, ltrim($contents, "\r\n"));
    }
}
