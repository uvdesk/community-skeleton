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
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Bundle\MonologBundle\DependencyInjection\Compiler\LoggerChannelPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class LoggerChannelPassTest extends TestCase
{
    public function testProcess()
    {
        $container = $this->getContainer();
        $this->assertTrue($container->hasDefinition('monolog.logger.test'), '->process adds a logger service for tagged service');

        $service = $container->getDefinition('test');
        $this->assertEquals('monolog.logger.test', (string) $service->getArgument(1), '->process replaces the logger by the new one');

        // pushHandlers for service "test"
        $expected = array(
            'test' => array('monolog.handler.a', 'monolog.handler.b', 'monolog.handler.c'),
            'foo'  => array('monolog.handler.b'),
            'bar'  => array('monolog.handler.b', 'monolog.handler.c'),
        );

        foreach ($expected as $serviceName => $handlers) {
            $service = $container->getDefinition($serviceName);
            $channel = $container->getDefinition((string) $service->getArgument(1));

            $calls = $channel->getMethodCalls();
            $this->assertCount(count($handlers), $calls);
            foreach ($handlers as $i => $handler) {
                list($methodName, $arguments) = $calls[$i];
                $this->assertEquals('pushHandler', $methodName);
                $this->assertCount(1, $arguments);
                $this->assertEquals($handler, (string) $arguments[0]);
            }
        }

        $this->assertNotNull($container->getDefinition('monolog.logger.manualchan'));
    }

    public function testProcessSetters()
    {
        $container = $this->getContainerWithSetter();
        $this->assertTrue($container->hasDefinition('monolog.logger.test'), '->process adds a logger service for tagged service');

        $service = $container->getDefinition('foo');
        $calls = $service->getMethodCalls();
        $this->assertEquals('monolog.logger.test', (string) $calls[0][1][0], '->process replaces the logger by the new one in setters');
    }

    public function testAutowiredLoggerArgumentsAreReplacedWithChannelLogger()
    {
        if (!\method_exists('Symfony\Component\DependencyInjection\Definition', 'getBindings')) {
            $this->markTestSkipped('Need DependencyInjection 3.4+ to autowire channel logger.');
        }

        $container = $this->getFunctionalContainer();

        $dummyService = $container->register('dummy_service', 'Symfony\Bundle\MonologBundle\Tests\DependencyInjection\Compiler\DummyService')
            ->setAutowired(true)
            ->setPublic(true)
            ->addTag('monolog.logger', array('channel' => 'test'));

        $container->compile();

        $this->assertEquals('monolog.logger.test', (string) $dummyService->getArgument(0));
    }

    public function testAutowiredLoggerArgumentsAreReplacedWithChannelLoggerWhenAutoconfigured()
    {
        if (!\method_exists('Symfony\Component\DependencyInjection\Definition', 'getBindings')) {
            $this->markTestSkipped('Need DependencyInjection 3.4+ to autowire channel logger.');
        }

        $container = $this->getFunctionalContainer();

        $container->registerForAutoconfiguration('Symfony\Bundle\MonologBundle\Tests\DependencyInjection\Compiler\DummyService')
            ->setProperty('fake', 'dummy');

        $container->register('dummy_service', 'Symfony\Bundle\MonologBundle\Tests\DependencyInjection\Compiler\DummyService')
            ->setAutowired(true)
            ->setAutoconfigured(true)
            ->setPublic(true)
            ->addTag('monolog.logger', array('channel' => 'test'));

        $container->compile();

        $this->assertEquals('monolog.logger.test', (string) $container->getDefinition('dummy_service')->getArgument(0));
    }

    public function testAutowiredLoggerArgumentsAreNotReplacedWithChannelLoggerIfLoggerArgumentIsConfiguredExplicitly()
    {
        if (!\method_exists('Symfony\Component\DependencyInjection\Definition', 'getBindings')) {
            $this->markTestSkipped('Need DependencyInjection 3.4+ to autowire channel logger.');
        }

        $container = $this->getFunctionalContainer();

        $dummyService = $container->register('dummy_service', 'Symfony\Bundle\MonologBundle\Tests\DependencyInjection\Compiler\DummyService')
            ->setAutowired(true)
            ->addArgument(new Reference('monolog.logger'))
            ->addTag('monolog.logger', array('channel' => 'test'));

        $container->compile();

        $this->assertEquals('monolog.logger', (string) $dummyService->getArgument(0));
    }

    public function testTagNotBreakingIfNoLogger()
    {
        $container = $this->getFunctionalContainer();

        $dummyService = $container->register('dummy_service', 'stdClass')
            ->addTag('monolog.logger', array('channel' => 'test'));

        $container->compile();

        $this->assertEquals(array(), $dummyService->getArguments());
    }

    public function testChannelsConfigurationOptionSupportsAppChannel()
    {
        $container = $this->getFunctionalContainer();

        $container->setParameter('monolog.additional_channels', array('app'));
        $container->compile();

        // the test ensures that the validation does not fail (i.e. it does not throw any exceptions)
        $this->addToAssertionCount(1);
    }

    private function getContainer()
    {
        $container = new ContainerBuilder();
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../../../Resources/config'));
        $loader->load('monolog.xml');
        $definition = $container->getDefinition('monolog.logger_prototype');
        $container->set('monolog.handler.test', new Definition('%monolog.handler.null.class%', array(100, false)));
        $definition->addMethodCall('pushHandler', array(new Reference('monolog.handler.test')));

        // Handlers
        $container->set('monolog.handler.a', new Definition('%monolog.handler.null.class%', array(100, false)));
        $container->set('monolog.handler.b', new Definition('%monolog.handler.null.class%', array(100, false)));
        $container->set('monolog.handler.c', new Definition('%monolog.handler.null.class%', array(100, false)));

        // Channels
        foreach (array('test', 'foo', 'bar') as $name) {
            $service = new Definition('TestClass', array('false', new Reference('logger')));
            $service->addTag('monolog.logger', array('channel' => $name));
            $container->setDefinition($name, $service);
        }

        $container->setParameter('monolog.additional_channels', array('manualchan'));
        $container->setParameter('monolog.handlers_to_channels', array(
            'monolog.handler.a' => array(
                'type' => 'inclusive',
                'elements' => array('test')
            ),
            'monolog.handler.b' => null,
            'monolog.handler.c' => array(
                'type' => 'exclusive',
                'elements' => array('foo')
            )
        ));

        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->addCompilerPass(new LoggerChannelPass());
        $container->compile();

        return $container;
    }

    private function getContainerWithSetter()
    {
        $container = new ContainerBuilder();
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../../../Resources/config'));
        $loader->load('monolog.xml');
        $definition = $container->getDefinition('monolog.logger_prototype');
        $container->set('monolog.handler.test', new Definition('%monolog.handler.null.class%', array(100, false)));
        $definition->addMethodCall('pushHandler', array(new Reference('monolog.handler.test')));

        // Channels
        $service = new Definition('TestClass');
        $service->addTag('monolog.logger', array('channel' => 'test'));
        $service->addMethodCall('setLogger', array(new Reference('logger')));
        $container->setDefinition('foo', $service);

        $container->setParameter('monolog.additional_channels', array('manualchan'));
        $container->setParameter('monolog.handlers_to_channels', array());

        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->addCompilerPass(new LoggerChannelPass());
        $container->compile();

        return $container;
    }

    /**
     * @return ContainerBuilder
     */
    private function getFunctionalContainer()
    {
        $container = new ContainerBuilder();
        $container->setParameter('monolog.additional_channels', array());
        $container->setParameter('monolog.handlers_to_channels', array());
        $container->setParameter('monolog.use_microseconds', true);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../../../Resources/config'));
        $loader->load('monolog.xml');

        $container->addCompilerPass(new LoggerChannelPass());

        // disable removing passes to be able to inspect the container before all the inlining optimizations
        $container->getCompilerPassConfig()->setRemovingPasses(array());

        return $container;
    }
}

class DummyService
{
    public function __construct(LoggerInterface $logger)
    {
    }
}
