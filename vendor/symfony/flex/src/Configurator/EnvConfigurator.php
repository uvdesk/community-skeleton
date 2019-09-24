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
class EnvConfigurator extends AbstractConfigurator
{
    public function configure(Recipe $recipe, $vars, Lock $lock, array $options = [])
    {
        $this->write('Added environment variable defaults');

        $this->configureEnvDist($recipe, $vars, $options['force'] ?? false);
        if (!file_exists($this->options->get('root-dir').'/.env.test')) {
            $this->configurePhpUnit($recipe, $vars, $options['force'] ?? false);
        }
    }

    public function unconfigure(Recipe $recipe, $vars, Lock $lock)
    {
        $this->unconfigureEnvFiles($recipe, $vars);
        $this->unconfigurePhpUnit($recipe, $vars);
    }

    private function configureEnvDist(Recipe $recipe, $vars, bool $update)
    {
        foreach (['.env.dist', '.env'] as $file) {
            $env = $this->options->get('root-dir').'/'.$file;
            if (!is_file($env)) {
                continue;
            }

            if (!$update && $this->isFileMarked($recipe, $env)) {
                continue;
            }

            $data = '';
            foreach ($vars as $key => $value) {
                $value = $this->evaluateValue($value);
                if ('#' === $key[0] && is_numeric(substr($key, 1))) {
                    $data .= '# '.$value."\n";

                    continue;
                }

                $value = $this->options->expandTargetDir($value);
                if (false !== strpbrk($value, " \t\n&!\"")) {
                    $value = '"'.str_replace(['\\', '"', "\t", "\n"], ['\\\\', '\\"', '\t', '\n'], $value).'"';
                }
                $data .= "$key=$value\n";
            }
            $data = $this->markData($recipe, $data);

            if (!$this->updateData($env, $data)) {
                file_put_contents($env, $data, FILE_APPEND);
            }
        }
    }

    private function configurePhpUnit(Recipe $recipe, $vars, bool $update)
    {
        foreach (['phpunit.xml.dist', 'phpunit.xml'] as $file) {
            $phpunit = $this->options->get('root-dir').'/'.$file;
            if (!is_file($phpunit)) {
                continue;
            }

            if (!$update && $this->isFileXmlMarked($recipe, $phpunit)) {
                continue;
            }

            $data = '';
            foreach ($vars as $key => $value) {
                $value = $this->evaluateValue($value);
                if ('#' === $key[0]) {
                    if (is_numeric(substr($key, 1))) {
                        $doc = new \DOMDocument();
                        $data .= '        '.$doc->saveXML($doc->createComment(' '.$value.' '))."\n";
                    } else {
                        $value = $this->options->expandTargetDir($value);
                        $doc = new \DOMDocument();
                        $fragment = $doc->createElement('env');
                        $fragment->setAttribute('name', substr($key, 1));
                        $fragment->setAttribute('value', $value);
                        $data .= '        '.str_replace(['<', '/>'], ['<!-- ', ' -->'], $doc->saveXML($fragment))."\n";
                    }
                } else {
                    $value = $this->options->expandTargetDir($value);
                    $doc = new \DOMDocument();
                    $fragment = $doc->createElement('env');
                    $fragment->setAttribute('name', $key);
                    $fragment->setAttribute('value', $value);
                    $data .= '        '.$doc->saveXML($fragment)."\n";
                }
            }
            $data = $this->markXmlData($recipe, $data);

            if (!$this->updateData($phpunit, $data)) {
                file_put_contents($phpunit, preg_replace('{^(\s+</php>)}m', $data.'$1', file_get_contents($phpunit)));
            }
        }
    }

    private function unconfigureEnvFiles(Recipe $recipe, $vars)
    {
        foreach (['.env', '.env.dist'] as $file) {
            $env = $this->options->get('root-dir').'/'.$file;
            if (!file_exists($env)) {
                continue;
            }

            $contents = preg_replace(sprintf('{%s*###> %s ###.*###< %s ###%s+}s', "\n", $recipe->getName(), $recipe->getName(), "\n"), "\n", file_get_contents($env), -1, $count);
            if (!$count) {
                continue;
            }

            $this->write(sprintf('Removing environment variables from %s', $file));
            file_put_contents($env, $contents);
        }
    }

    private function unconfigurePhpUnit(Recipe $recipe, $vars)
    {
        foreach (['phpunit.xml.dist', 'phpunit.xml'] as $file) {
            $phpunit = $this->options->get('root-dir').'/'.$file;
            if (!is_file($phpunit)) {
                continue;
            }

            $contents = preg_replace(sprintf('{%s*\s+<!-- ###\+ %s ### -->.*<!-- ###- %s ### -->%s+}s', "\n", $recipe->getName(), $recipe->getName(), "\n"), "\n", file_get_contents($phpunit), -1, $count);
            if (!$count) {
                continue;
            }

            $this->write(sprintf('Removed environment variables from %s', $file));
            file_put_contents($phpunit, $contents);
        }
    }

    private function evaluateValue($value)
    {
        if ('%generate(secret)%' === $value) {
            return $this->generateRandomBytes();
        }
        if (preg_match('~^%generate\(secret,\s*([0-9]+)\)%$~', $value, $matches)) {
            return $this->generateRandomBytes($matches[1]);
        }

        return $value;
    }

    private function generateRandomBytes($length = 16)
    {
        return bin2hex(random_bytes($length));
    }
}
