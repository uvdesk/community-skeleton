<?php

namespace Symfony\Bundle\SwiftmailerBundle\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\SwiftmailerBundle\Command\SendEmailCommand;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class SendEmailCommandTest extends \PHPUnit\Framework\TestCase
{
    public function testRecoverSpoolTransport()
    {
        $realTransport = $this->getMockBuilder('Swift_Transport')->getMock();

        $spool = $this->getMockBuilder('Swift_Spool')->getMock();
        $spool
            ->expects($this->once())
            ->method('flushQueue')
            ->with($realTransport)
            ->will($this->returnValue(5))
        ;

        $spoolTransport = new \Swift_Transport_SpoolTransport(new \Swift_Events_SimpleEventDispatcher(), $spool);

        $container = $this->buildContainer($spoolTransport, $realTransport);
        $tester = $this->executeCommand($container);

        $this->assertStringEndsWith("5 emails sent\n", $tester->getDisplay());
    }

    public function testTimeLimitInteger()
    {
        $realTransport = $this->getMockBuilder('Swift_Transport')->getMock();

        $spool = $this->configurableSpool();

        $spoolTransport = new \Swift_Transport_SpoolTransport(new \Swift_Events_SimpleEventDispatcher(), $spool);

        $container = $this->buildContainer($spoolTransport, $realTransport);
        $this->executeCommand($container, ['--time-limit' => 5]);

        $this->assertSame(5, $spool->getTimeLimit());
    }

    public function testTimeLimitNull()
    {
        $realTransport = $this->getMockBuilder('Swift_Transport')->getMock();

        $spool = $this->configurableSpool();

        $spoolTransport = new \Swift_Transport_SpoolTransport(new \Swift_Events_SimpleEventDispatcher(), $spool);

        $container = $this->buildContainer($spoolTransport, $realTransport);
        $this->executeCommand($container);

        $this->assertNull($spool->getTimeLimit());
    }

    public function testMessageLimitInteger()
    {
        $realTransport = $this->getMockBuilder('Swift_Transport')->getMock();

        $spool = $this->configurableSpool();

        $spoolTransport = new \Swift_Transport_SpoolTransport(new \Swift_Events_SimpleEventDispatcher(), $spool);

        $container = $this->buildContainer($spoolTransport, $realTransport);
        $this->executeCommand($container, ['--message-limit' => 5]);

        $this->assertSame(5, $spool->getMessageLimit());
    }

    public function testMessageLimitNull()
    {
        $realTransport = $this->getMockBuilder('Swift_Transport')->getMock();

        $spool = $this->configurableSpool();

        $spoolTransport = new \Swift_Transport_SpoolTransport(new \Swift_Events_SimpleEventDispatcher(), $spool);

        $container = $this->buildContainer($spoolTransport, $realTransport);
        $this->executeCommand($container);

        $this->assertNull($spool->getMessageLimit());
    }

    public function testRecoverLoadbalancedTransportWithSpool()
    {
        $realTransport = $this->getMockBuilder('Swift_Transport')->getMock();

        $spool = $this->getMockBuilder('Swift_Spool')->getMock();
        $spool
            ->expects($this->once())
            ->method('flushQueue')
            ->with($realTransport)
            ->will($this->returnValue(7))
        ;

        $spoolTransport = new \Swift_Transport_SpoolTransport(new \Swift_Events_SimpleEventDispatcher(), $spool);

        $loadBalancedTransport = new \Swift_Transport_LoadBalancedTransport();
        $loadBalancedTransport->setTransports([$spoolTransport]);

        $container = $this->buildContainer($loadBalancedTransport, $realTransport);
        $tester = $this->executeCommand($container);

        $this->assertStringEndsWith("7 emails sent\n", $tester->getDisplay());
    }

    /**
     * @return Container
     */
    private function buildContainer(\Swift_Transport $transport, \Swift_Transport $realTransport, $name = 'default')
    {
        $mailer = new \Swift_Mailer($transport);

        $container = new Container();
        $container->set(sprintf('swiftmailer.mailer.%s', $name), $mailer);
        $container->set(sprintf('swiftmailer.mailer.%s.transport.real', $name), $realTransport);
        $container->setParameter('swiftmailer.mailers', [$name => $mailer]);
        $container->setParameter(sprintf('swiftmailer.mailer.%s.spool.enabled', $name), true);

        return $container;
    }

    /**
     * @return CommandTester
     */
    private function executeCommand(ContainerInterface $container, $input = [], $options = [])
    {
        $kernel = $this->getMockBuilder(KernelInterface::class)->getMock();
        $kernel->expects($this->any())->method('getContainer')->willReturn($container);
        $kernel->expects($this->any())->method('getBundles')->willReturn([]);

        $application = new Application($kernel);
        $application->add(new SendEmailCommand());

        $tester = new CommandTester($application->get('swiftmailer:spool:send'));
        $tester->execute($input, $options);

        return $tester;
    }

    /**
     * @return \Swift_ConfigurableSpool
     */
    private function configurableSpool(): \Swift_ConfigurableSpool
    {
        return new class() extends \Swift_ConfigurableSpool {
            public function start()
            {
            }

            public function stop()
            {
            }

            public function isStarted()
            {
            }

            public function queueMessage(\Swift_Mime_SimpleMessage $message)
            {
            }

            public function flushQueue(\Swift_Transport $transport, &$failedRecipients = null)
            {
            }
        };
    }
}
