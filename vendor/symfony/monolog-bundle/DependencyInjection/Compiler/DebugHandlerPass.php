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

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Definition;
use Monolog\Logger;

/**
 * Adds the DebugHandler when the profiler is enabled and kernel.debug is true.
 *
 * @author Christophe Coevoet <stof@notk.org>
 * @author Jordi Boggiano <j.boggiano@seld.be>
 *
 * @deprecated since version 2.12, to be removed in 4.0. Use AddDebugLogProcessorPass in FrameworkBundle instead.
 */
class DebugHandlerPass implements CompilerPassInterface
{
    private $channelPass;

    public function __construct(LoggerChannelPass $channelPass)
    {
        @trigger_error('The '.__CLASS__.' class is deprecated since version 2.12 and will be removed in 4.0. Use AddDebugLogProcessorPass in FrameworkBundle instead.', E_USER_DEPRECATED);

        $this->channelPass = $channelPass;
    }

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('profiler')) {
            return;
        }

        if (!$container->getParameter('kernel.debug')) {
            return;
        }

        $debugHandler = new Definition('Symfony\Bridge\Monolog\Handler\DebugHandler', array(Logger::DEBUG, true));
        $container->setDefinition('monolog.handler.debug', $debugHandler);

        foreach ($this->channelPass->getChannels() as $channel) {
            $container
                ->getDefinition($channel === 'app' ? 'monolog.logger' : 'monolog.logger.'.$channel)
                ->addMethodCall('pushHandler', array(new Reference('monolog.handler.debug')));
        }
    }
}
