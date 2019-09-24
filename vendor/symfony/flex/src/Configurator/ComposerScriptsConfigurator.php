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

use Composer\Factory;
use Composer\Json\JsonFile;
use Composer\Json\JsonManipulator;
use Symfony\Flex\Lock;
use Symfony\Flex\Recipe;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ComposerScriptsConfigurator extends AbstractConfigurator
{
    public function configure(Recipe $recipe, $scripts, Lock $lock, array $options = [])
    {
        $json = new JsonFile(Factory::getComposerFile());

        $jsonContents = $json->read();
        $autoScripts = $jsonContents['scripts']['auto-scripts'] ?? [];
        $autoScripts = array_merge($autoScripts, $scripts);

        $manipulator = new JsonManipulator(file_get_contents($json->getPath()));
        $manipulator->addSubNode('scripts', 'auto-scripts', $autoScripts);

        file_put_contents($json->getPath(), $manipulator->getContents());
    }

    public function unconfigure(Recipe $recipe, $scripts, Lock $lock)
    {
        $json = new JsonFile(Factory::getComposerFile());

        $jsonContents = $json->read();
        $autoScripts = $jsonContents['scripts']['auto-scripts'] ?? [];
        foreach (array_keys($scripts) as $cmd) {
            unset($autoScripts[$cmd]);
        }

        $manipulator = new JsonManipulator(file_get_contents($json->getPath()));
        $manipulator->addSubNode('scripts', 'auto-scripts', $autoScripts);

        file_put_contents($json->getPath(), $manipulator->getContents());
    }
}
