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
class ContainerConfigurator extends AbstractConfigurator
{
    public function configure(Recipe $recipe, $parameters, Lock $lock, array $options = [])
    {
        $this->write('Setting parameters');
        $this->addParameters($parameters);
    }

    public function unconfigure(Recipe $recipe, $parameters, Lock $lock)
    {
        $this->write('Unsetting parameters');
        $target = $this->options->get('root-dir').'/'.$this->options->expandTargetDir('%CONFIG_DIR%/services.yaml');
        $lines = [];
        foreach (file($target) as $line) {
            if ($this->removeParameters(1, $parameters, $line)) {
                continue;
            }
            $lines[] = $line;
        }
        file_put_contents($target, implode('', $lines));
    }

    private function addParameters(array $parameters)
    {
        $target = $this->options->get('root-dir').'/'.$this->options->expandTargetDir('%CONFIG_DIR%/services.yaml');
        $endAt = 0;
        $isParameters = false;
        $lines = [];
        foreach (file($target) as $i => $line) {
            $lines[] = $line;
            if (!$isParameters && !preg_match('/^parameters\:/', $line)) {
                continue;
            }
            if (!$isParameters) {
                $isParameters = true;
                continue;
            }
            if (!preg_match('/^\s+.*/', $line) && '' !== trim($line)) {
                $endAt = $i - 1;
                $isParameters = false;
                continue;
            }
            foreach ($parameters as $key => $value) {
                if (preg_match(sprintf('/^\s+%s\:/', preg_quote($key, '/')), $line)) {
                    unset($parameters[$key]);
                }
            }
        }
        if (!$parameters) {
            return;
        }

        $parametersLines = [];
        if (!$endAt) {
            $parametersLines[] = "parameters:\n";
        }
        foreach ($parameters as $key => $value) {
            if (\is_array($value)) {
                $parametersLines[] = sprintf("    %s:\n%s", $key, $this->dumpYaml(2, $value));
                continue;
            }
            $parametersLines[] = sprintf("    %s: '%s'%s", $key, str_replace("'", "''", $value), "\n");
        }
        if (!$endAt) {
            $parametersLines[] = "\n";
        }
        array_splice($lines, $endAt, 0, $parametersLines);
        file_put_contents($target, implode('', $lines));
    }

    private function removeParameters($level, $params, $line)
    {
        foreach ($params as $key => $value) {
            if (\is_array($value) && $this->removeParameters($level + 1, $value, $line)) {
                return true;
            }
            if (preg_match(sprintf('/^(\s{%d}|\t{%d})+%s\:/', 4 * $level, $level, preg_quote($key, '/')), $line)) {
                return true;
            }
        }

        return false;
    }

    private function dumpYaml($level, $array): string
    {
        $line = '';
        foreach ($array as $key => $value) {
            $line .= str_repeat('    ', $level);
            if (!\is_array($value)) {
                $line .= sprintf("%s: '%s'\n", $key, str_replace("'", "''", $value));
                continue;
            }
            $line .= sprintf("%s:\n", $key).$this->dumpYaml($level + 1, $value);
        }

        return $line;
    }
}
