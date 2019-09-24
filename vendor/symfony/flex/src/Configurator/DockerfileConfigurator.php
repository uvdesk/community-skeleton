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
 * Adds commands to a Dockerfile.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class DockerfileConfigurator extends AbstractConfigurator
{
    public function configure(Recipe $recipe, $config, Lock $lock, array $options = [])
    {
        $installDocker = $this->composer->getPackage()->getExtra()['symfony']['docker'] ?? false;
        if (!$installDocker) {
            return;
        }

        $dockerfile = $this->options->get('root-dir').'/Dockerfile';
        if (!file_exists($dockerfile) || $this->isFileMarked($recipe, $dockerfile)) {
            return;
        }

        $this->write('Adding Dockerfile entries');

        $lines = [];
        foreach (file($dockerfile) as $line) {
            $lines[] = $line;
            if (!preg_match('/^###> recipes ###$/', $line)) {
                continue;
            }

            $lines[] = ltrim($this->markData($recipe, implode("\n", $config)), "\n");
        }

        file_put_contents($dockerfile, implode('', $lines));
    }

    public function unconfigure(Recipe $recipe, $config, Lock $lock)
    {
        if (!file_exists($dockerfile = $this->options->get('root-dir').'/Dockerfile')) {
            return;
        }

        $name = $recipe->getName();
        $contents = preg_replace(sprintf('{%s+###> %s ###.*?###< %s ###%s+}s', "\n", $name, $name, "\n"), "\n", file_get_contents($dockerfile), -1, $count);
        if (!$count) {
            return;
        }

        $this->write('Removing Dockerfile entries');
        file_put_contents($dockerfile, ltrim($contents, "\n"));
    }
}
