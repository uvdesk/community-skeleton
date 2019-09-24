<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Doctrine\Bundle\DoctrineCacheBundle\DependencyInjection\Definition;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * PhpFile definition.
 *
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class PhpFileDefinition extends CacheDefinition
{
    /**
     * {@inheritDoc}
     */
    public function configure($name, array $config, Definition $service, ContainerBuilder $container)
    {
        $service->setArguments(array(
            $config['php_file']['directory'],
            $config['php_file']['extension'],
            $config['php_file']['umask']
        ));
    }
}
