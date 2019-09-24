<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MonologBundle\Tests\DependencyInjection\Compiler;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\MonologBundle\DependencyInjection\Compiler\FixEmptyLoggerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FixEmptyLoggerPassTest extends TestCase
{
    public function testProcess()
    {
        $loggerChannelPass = $this->getMockBuilder('Symfony\Bundle\MonologBundle\DependencyInjection\Compiler\LoggerChannelPass')->getMock();
        $loggerChannelPass->expects($this->any())->method('getChannels')->will($this->returnValue(array('foo', 'bar')));

        $container = new ContainerBuilder();
        $container->register('monolog.logger.foo', 'Monolog\Logger');
        $container->register('monolog.logger.bar', 'Monolog\Logger')->addMethodCall('pushHandler');

        $pass = new FixEmptyLoggerPass($loggerChannelPass);
        $pass->process($container);

        $calls = $container->getDefinition('monolog.logger.foo')->getMethodCalls();
        $this->assertCount(1, $calls);
        $this->assertSame('pushHandler', $calls[0][0]);
        $this->assertSame('monolog.handler.null_internal', (string) $calls[0][1][0]);

        $calls = $container->getDefinition('monolog.logger.bar')->getMethodCalls();
        $this->assertCount(1, $calls);
    }
}
