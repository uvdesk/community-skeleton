<?php

class Swift_Plugins_PopBeforeSmtpPluginTest extends \PHPUnit\Framework\TestCase
{
    public function testPluginConnectsToPop3HostBeforeTransportStarts()
    {
        $connection = $this->createConnection();
        $connection->expects($this->once())
                   ->method('connect');

        $plugin = $this->createPlugin('pop.host.tld', 110);
        $plugin->setConnection($connection);

        $transport = $this->createTransport();
        $evt = $this->createTransportChangeEvent($transport);

        $plugin->beforeTransportStarted($evt);
    }

    public function testPluginDisconnectsFromPop3HostBeforeTransportStarts()
    {
        $connection = $this->createConnection();
        $connection->expects($this->once())
                   ->method('disconnect');

        $plugin = $this->createPlugin('pop.host.tld', 110);
        $plugin->setConnection($connection);

        $transport = $this->createTransport();
        $evt = $this->createTransportChangeEvent($transport);

        $plugin->beforeTransportStarted($evt);
    }

    public function testPluginDoesNotConnectToSmtpIfBoundToDifferentTransport()
    {
        $connection = $this->createConnection();
        $connection->expects($this->never())
                   ->method('disconnect');
        $connection->expects($this->never())
                   ->method('connect');

        $smtp = $this->createTransport();

        $plugin = $this->createPlugin('pop.host.tld', 110);
        $plugin->setConnection($connection);
        $plugin->bindSmtp($smtp);

        $transport = $this->createTransport();
        $evt = $this->createTransportChangeEvent($transport);

        $plugin->beforeTransportStarted($evt);
    }

    public function testPluginCanBindToSpecificTransport()
    {
        $connection = $this->createConnection();
        $connection->expects($this->once())
                   ->method('connect');

        $smtp = $this->createTransport();

        $plugin = $this->createPlugin('pop.host.tld', 110);
        $plugin->setConnection($connection);
        $plugin->bindSmtp($smtp);

        $evt = $this->createTransportChangeEvent($smtp);

        $plugin->beforeTransportStarted($evt);
    }

    private function createTransport()
    {
        return $this->getMockBuilder('Swift_Transport')->getMock();
    }

    private function createTransportChangeEvent($transport)
    {
        $evt = $this->getMockBuilder('Swift_Events_TransportChangeEvent')
                    ->disableOriginalConstructor()
                    ->getMock();
        $evt->expects($this->any())
            ->method('getSource')
            ->will($this->returnValue($transport));
        $evt->expects($this->any())
            ->method('getTransport')
            ->will($this->returnValue($transport));

        return $evt;
    }

    public function createConnection()
    {
        return $this->getMockBuilder('Swift_Plugins_Pop_Pop3Connection')->getMock();
    }

    public function createPlugin($host, $port, $crypto = null)
    {
        return new Swift_Plugins_PopBeforeSmtpPlugin($host, $port, $crypto);
    }
}
