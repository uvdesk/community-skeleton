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

use Composer\Composer;
use Composer\IO\IOInterface;
use Symfony\Flex\Configurator\AbstractConfigurator;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Configurator
{
    private $composer;
    private $io;
    private $options;
    private $configurators;
    private $cache;

    public function __construct(Composer $composer, IOInterface $io, Options $options)
    {
        $this->composer = $composer;
        $this->io = $io;
        $this->options = $options;
        // ordered list of configurators
        $this->configurators = [
            'bundles' => Configurator\BundlesConfigurator::class,
            'copy-from-recipe' => Configurator\CopyFromRecipeConfigurator::class,
            'copy-from-package' => Configurator\CopyFromPackageConfigurator::class,
            'env' => Configurator\EnvConfigurator::class,
            'container' => Configurator\ContainerConfigurator::class,
            'makefile' => Configurator\MakefileConfigurator::class,
            'composer-scripts' => Configurator\ComposerScriptsConfigurator::class,
            'gitignore' => Configurator\GitignoreConfigurator::class,
            'dockerfile' => Configurator\DockerfileConfigurator::class,
            'docker-compose' => Configurator\DockerComposeConfigurator::class,
        ];
    }

    public function install(Recipe $recipe, Lock $lock, array $options = [])
    {
        $manifest = $recipe->getManifest();
        foreach (array_keys($this->configurators) as $key) {
            if (isset($manifest[$key])) {
                $this->get($key)->configure($recipe, $manifest[$key], $lock, $options);
            }
        }
    }

    public function unconfigure(Recipe $recipe, Lock $lock)
    {
        $manifest = $recipe->getManifest();
        foreach (array_keys($this->configurators) as $key) {
            if (isset($manifest[$key])) {
                $this->get($key)->unconfigure($recipe, $manifest[$key], $lock);
            }
        }
    }

    private function get($key): AbstractConfigurator
    {
        if (!isset($this->configurators[$key])) {
            throw new \InvalidArgumentException(sprintf('Unknown configurator "%s".', $key));
        }

        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }

        $class = $this->configurators[$key];

        return $this->cache[$key] = new $class($this->composer, $this->io, $this->options);
    }
}
