<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MonologBundle;

use Monolog\Formatter\JsonFormatter;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\HandlerInterface;
use Symfony\Bundle\MonologBundle\DependencyInjection\Compiler\AddSwiftMailerTransportPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Bundle\MonologBundle\DependencyInjection\Compiler\LoggerChannelPass;
use Symfony\Bundle\MonologBundle\DependencyInjection\Compiler\DebugHandlerPass;
use Symfony\Bundle\MonologBundle\DependencyInjection\Compiler\AddProcessorsPass;
use Symfony\Bundle\MonologBundle\DependencyInjection\Compiler\FixEmptyLoggerPass;

/**
 * Bundle.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class MonologBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass($channelPass = new LoggerChannelPass());
        if (!class_exists('Symfony\Bridge\Monolog\Processor\DebugProcessor') || !class_exists('Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler\AddDebugLogProcessorPass')) {
            $container->addCompilerPass(new DebugHandlerPass($channelPass));
        }
        $container->addCompilerPass(new FixEmptyLoggerPass($channelPass));
        $container->addCompilerPass(new AddProcessorsPass());
        $container->addCompilerPass(new AddSwiftMailerTransportPass());
    }

    /**
     * @internal
     */
    public static function includeStacktraces(HandlerInterface $handler)
    {
        $formatter = $handler->getFormatter();
        if ($formatter instanceof LineFormatter || $formatter instanceof JsonFormatter) {
            $formatter->includeStacktraces();
        }
    }
}
