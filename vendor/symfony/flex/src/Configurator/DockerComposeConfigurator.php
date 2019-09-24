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
 * Adds services and volumes to docker-compose.yml file.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class DockerComposeConfigurator extends AbstractConfigurator
{
    public function configure(Recipe $recipe, $config, Lock $lock, array $options = [])
    {
        $installDocker = $this->composer->getPackage()->getExtra()['symfony']['docker'] ?? false;
        if (!$installDocker) {
            return;
        }

        $rootDir = $this->options->get('root-dir');
        if (
            (
                !file_exists($dockerComposeFile = $rootDir.'/docker-compose.yml') &&
                !file_exists($dockerComposeFile = $rootDir.'/docker-compose.yaml')
            ) || $this->isFileMarked($recipe, $dockerComposeFile)
        ) {
            return;
        }

        $this->write('Adding Docker Compose entries');

        $offset = 8;
        $node = null;
        $endAt = [];
        $lines = [];
        foreach (file($dockerComposeFile) as $i => $line) {
            $lines[] = $line;
            $ltrimedLine = ltrim($line, ' ');

            // Skip blank lines and comments
            if (('' !== $ltrimedLine && 0 === strpos($ltrimedLine, '#')) || '' === trim($line)) {
                continue;
            }

            // Extract Docker Compose keys (usually "services" and "volumes")
            if (!preg_match('/^[\'"]?([a-zA-Z0-9]+)[\'"]?:\s*$/', $line, $matches)) {
                // Detect indentation to use
                $offestLine = \strlen($line) - \strlen($ltrimedLine);
                if ($offset > $offestLine && 0 !== $offestLine) {
                    $offset = $offestLine;
                }
                continue;
            }

            // Keep end in memory (check break line on previous line)
            $endAt[$node] = '' !== trim($lines[$i - 1]) ? $i : $i - 1;
            $node = $matches[1];
        }
        $endAt[$node] = \count($lines) + 1;

        foreach ($config as $key => $value) {
            if (isset($endAt[$key])) {
                array_splice($lines, $endAt[$key], 0, $this->markData($recipe, $this->parse(1, $offset, $value)));
                continue;
            }

            $lines[] = sprintf("\n%s:", $key);
            $lines[] = $this->markData($recipe, $this->parse(1, $offset, $value));
        }

        file_put_contents($dockerComposeFile, implode('', $lines));
    }

    public function unconfigure(Recipe $recipe, $config, Lock $lock)
    {
        $rootDir = $this->options->get('root-dir');
        if (!file_exists($dockerCompose = $rootDir.'/docker-compose.yml') &&
            !file_exists($dockerCompose = $rootDir.'/docker-compose.yaml')
        ) {
            return;
        }

        $name = $recipe->getName();
        // Remove recipe and add break line
        $contents = preg_replace(sprintf('{%s+###> %s ###.*?###< %s ###%s+}s', "\n", $name, $name, "\n"), PHP_EOL.PHP_EOL, file_get_contents($dockerCompose), -1, $count);
        if (!$count) {
            return;
        }

        foreach ($config as $key => $value) {
            if (0 === preg_match(sprintf('{^%s:[ \t\r\n]*([ \t]+\w)}m', $key), $contents, $matches)) {
                $contents = preg_replace(sprintf('{\n?^%s:[ \t\r\n]*}sm', $key), '', $contents, -1, $count);
            }
        }

        $this->write(sprintf('Removing Docker Compose entries from %s', $dockerCompose));
        file_put_contents($dockerCompose, ltrim($contents, "\n"));
    }

    private function parse($level, $indent, $services): string
    {
        $line = '';
        foreach ($services as $key => $value) {
            $line .= str_repeat(' ', $indent * $level);
            if (!\is_array($value)) {
                if (\is_string($key)) {
                    $line .= sprintf('%s:', $key);
                }
                $line .= sprintf("%s\n", $value);
                continue;
            }
            $line .= sprintf("%s:\n", $key).$this->parse($level + 1, $indent, $value);
        }

        return $line;
    }
}
