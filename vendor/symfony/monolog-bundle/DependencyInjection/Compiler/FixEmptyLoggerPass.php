<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MonologBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Fixes loggers with no handlers (by registering a "null" one).
 *
 * Monolog 1.x adds a default handler logging on STDERR when a logger has
 * no registered handlers. This is NOT what what we want in Symfony, so in such
 * cases, we add a "null" handler to avoid the issue.
 *
 * Note that Monolog 2.x does not register a default handler anymore, so this pass can
 * be removed when MonologBundle minimum version of Monolog is bumped to 2.0.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @see https://github.com/Seldaek/monolog/commit/ad37b7b2d11f300cbace9f5e84f855d329519e28
 */
class FixEmptyLoggerPass implements CompilerPassInterface
{
    private $channelPass;

    public function __construct(LoggerChannelPass $channelPass)
    {
        $this->channelPass = $channelPass;
    }

    public function process(ContainerBuilder $container)
    {
        $container->register('monolog.handler.null_internal', 'Monolog\Handler\NullHandler');
        foreach ($this->channelPass->getChannels() as $channel) {
            $def = $container->getDefinition($channel === 'app' ? 'monolog.logger' : 'monolog.logger.'.$channel);
            foreach ($def->getMethodCalls() as $method) {
                if ('pushHandler' === $method[0]) {
                    continue 2;
                }
            }

            $def->addMethodCall('pushHandler', array(new Reference('monolog.handler.null_internal')));
        }
    }
}
