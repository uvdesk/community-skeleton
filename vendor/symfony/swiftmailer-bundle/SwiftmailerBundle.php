<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\SwiftmailerBundle;

use Symfony\Bundle\SwiftmailerBundle\DependencyInjection\Compiler\EnsureNoHotPathPass;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Bundle\SwiftmailerBundle\DependencyInjection\Compiler\RegisterPluginsPass;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SwiftmailerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterPluginsPass());

        // Older supported versions of Symfony don't have the parent class that EnsureNoHotPathPass extends from.
        // But they don't have the hot_path optimization either, so not being able to register our pass is not an issue.
        if (class_exists('Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass')) {
            $container->addCompilerPass(new EnsureNoHotPathPass(), PassConfig::TYPE_AFTER_REMOVING);
        }
    }

    public function registerCommands(Application $application)
    {
        // noop
    }
}
