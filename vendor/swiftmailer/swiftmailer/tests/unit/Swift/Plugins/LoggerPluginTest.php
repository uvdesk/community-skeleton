<?php

class Swift_Plugins_LoggerPluginTest extends \SwiftMailerTestCase
{
    public function testLoggerDelegatesAddingEntries()
    {
        $logger = $this->createLogger();
        $logger->expects($this->once())
               ->method('add')
               ->with('foo');

        $plugin = $this->createPlugin($logger);
        $plugin->add('foo');
    }

    public function testLoggerDelegatesDumpingEntries()
    {
        $logger = $this->createLogger();
        $logger->expects($this->once())
               ->method('dump')
               ->will($this->returnValue('foobar'));

        $plugin = $this->createPlugin($logger);
        $this->assertEquals('foobar', $plugin->dump());
    }

    public function testLoggerDelegatesClearingEntries()
    {
        $logger = $this->createLogger();
        $logger->expects($this->once())
               ->method('clear');

        $plugin = $this->createPlugin($logger);
        $plugin->clear();
    }

    public function testCommandIsSentToLogger()
    {
        $evt = $this->createCommandEvent("foo\r\n");
        $logger = $this->createLogger();
        $logger->expects($this->once())
               ->method('add')
               ->with(static::regExp('~foo\r\n~'));

        $plugin = $this->createPlugin($logger);
        $plugin->commandSent($evt);
    }

    public function testResponseIsSentToLogger()
    {
        $evt = $this->createResponseEvent("354 Go ahead\r\n");
        $logger = $this->createLogger();
        $logger->expects($this->once())
               ->method('add')
               ->with(static::regExp('~354 Go ahead\r\n~'));

        $plugin = $this->createPlugin($logger);
        $plugin->responseReceived($evt);
    }

    public function testTransportBeforeStartChangeIsSentToLogger()
    {
        $evt = $this->createTransportChangeEvent();
        $logger = $this->createLogger();
        $logger->expects($this->once())
               ->method('add')
               ->with($this->anything());

        $plugin = $this->createPlugin($logger);
        $plugin->beforeTransportStarted($evt);
    }

    public function testTransportStartChangeIsSentToLogger()
    {
        $evt = $this->createTransportChangeEvent();
        $logger = $this->createLogger();
        $logger->expects($this->once())
               ->method('add')
               ->with($this->anything());

        $plugin = $this->createPlugin($logger);
        $plugin->transportStarted($evt);
    }

    public function testTransportStopChangeIsSentToLogger()
    {
        $evt = $this->createTransportChangeEvent();
        $logger = $this->createLogger();
        $logger->expects($this->once())
               ->method('add')
               ->with($this->anything());

        $plugin = $this->createPlugin($logger);
        $plugin->transportStopped($evt);
    }

    public function testTransportBeforeStopChangeIsSentToLogger()
    {
        $evt = $this->createTransportChangeEvent();
        $logger = $this->createLogger();
        $logger->expects($this->once())
               ->method('add')
               ->with($this->anything());

        $plugin = $this->createPlugin($logger);
        $plugin->beforeTransportStopped($evt);
    }

    public function testExceptionsArePassedToDelegateAndLeftToBubbleUp()
    {
        $transport = $this->createTransport();
        $evt = $this->createTransportExceptionEvent();
        $logger = $this->createLogger();
        $logger->expects($this->once())
               ->method('add')
               ->with($this->anything());

        $plugin = $this->createPlugin($logger);
        try {
            $plugin->exceptionThrown($evt);
            $this->fail('Exception should bubble up.');
        } catch (Swift_TransportException $ex) {
        }
    }

    private function createLogger()
    {
        return $this->getMockBuilder('Swift_Plugins_Logger')->getMock();
    }

    private function createPlugin($logger)
    {
        return new Swift_Plugins_LoggerPlugin($logger);
    }

    private function createCommandEvent($command)
    {
        $evt = $this->getMockBuilder('Swift_Events_CommandEvent')
                    ->disableOriginalConstructor()
                    ->getMock();
        $evt->expects($this->any())
            ->method('getCommand')
            ->will($this->returnValue($command));

        return $evt;
    }

    private function createResponseEvent($response)
    {
        $evt = $this->getMockBuilder('Swift_Events_ResponseEvent')
                    ->disableOriginalConstructor()
                    ->getMock();
        $evt->expects($this->any())
            ->method('getResponse')
            ->will($this->returnValue($response));

        return $evt;
    }

    private function createTransport()
    {
        return $this->getMockBuilder('Swift_Transport')->getMock();
    }

    private function createTransportChangeEvent()
    {
        $evt = $this->getMockBuilder('Swift_Events_TransportChangeEvent')
                    ->disableOriginalConstructor()
                    ->getMock();
        $evt->expects($this->any())
            ->method('getSource')
            ->will($this->returnValue($this->createTransport()));

        return $evt;
    }

    public function createTransportExceptionEvent()
    {
        $evt = $this->getMockBuilder('Swift_Events_TransportExceptionEvent')
                    ->disableOriginalConstructor()
                    ->getMock();
        $evt->expects($this->any())
            ->method('getException')
            ->will($this->returnValue(new Swift_TransportException('')));

        return $evt;
    }
}
