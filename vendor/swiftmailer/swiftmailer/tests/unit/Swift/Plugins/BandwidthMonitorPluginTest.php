<?php

class Swift_Plugins_BandwidthMonitorPluginTest extends \PHPUnit\Framework\TestCase
{
    private $_monitor;

    private $_bytes = 0;

    protected function setUp()
    {
        $this->monitor = new Swift_Plugins_BandwidthMonitorPlugin();
    }

    public function testBytesOutIncreasesWhenCommandsSent()
    {
        $evt = $this->createCommandEvent("RCPT TO:<foo@bar.com>\r\n");

        $this->assertEquals(0, $this->monitor->getBytesOut());
        $this->monitor->commandSent($evt);
        $this->assertEquals(23, $this->monitor->getBytesOut());
        $this->monitor->commandSent($evt);
        $this->assertEquals(46, $this->monitor->getBytesOut());
    }

    public function testBytesInIncreasesWhenResponsesReceived()
    {
        $evt = $this->createResponseEvent("250 Ok\r\n");

        $this->assertEquals(0, $this->monitor->getBytesIn());
        $this->monitor->responseReceived($evt);
        $this->assertEquals(8, $this->monitor->getBytesIn());
        $this->monitor->responseReceived($evt);
        $this->assertEquals(16, $this->monitor->getBytesIn());
    }

    public function testCountersCanBeReset()
    {
        $evt = $this->createResponseEvent("250 Ok\r\n");

        $this->assertEquals(0, $this->monitor->getBytesIn());
        $this->monitor->responseReceived($evt);
        $this->assertEquals(8, $this->monitor->getBytesIn());
        $this->monitor->responseReceived($evt);
        $this->assertEquals(16, $this->monitor->getBytesIn());

        $evt = $this->createCommandEvent("RCPT TO:<foo@bar.com>\r\n");

        $this->assertEquals(0, $this->monitor->getBytesOut());
        $this->monitor->commandSent($evt);
        $this->assertEquals(23, $this->monitor->getBytesOut());
        $this->monitor->commandSent($evt);
        $this->assertEquals(46, $this->monitor->getBytesOut());

        $this->monitor->reset();

        $this->assertEquals(0, $this->monitor->getBytesOut());
        $this->assertEquals(0, $this->monitor->getBytesIn());
    }

    public function testBytesOutIncreasesAccordingToMessageLength()
    {
        $message = $this->createMessageWithByteCount(6);
        $evt = $this->createSendEvent($message);

        $this->assertEquals(0, $this->monitor->getBytesOut());
        $this->monitor->sendPerformed($evt);
        $this->assertEquals(6, $this->monitor->getBytesOut());
        $this->monitor->sendPerformed($evt);
        $this->assertEquals(12, $this->monitor->getBytesOut());
    }

    private function createSendEvent($message)
    {
        $evt = $this->getMockBuilder('Swift_Events_SendEvent')
                    ->disableOriginalConstructor()
                    ->getMock();
        $evt->expects($this->any())
            ->method('getMessage')
            ->will($this->returnValue($message));

        return $evt;
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

    private function createMessageWithByteCount($bytes)
    {
        $this->bytes = $bytes;
        $msg = $this->getMockBuilder('Swift_Mime_SimpleMessage')->disableOriginalConstructor()->getMock();
        $msg->expects($this->any())
            ->method('toByteStream')
            ->will($this->returnCallback([$this, 'write']));
        /*  $this->checking(Expectations::create()
              -> ignoring($msg)->toByteStream(any()) -> calls(array($this, 'write'))
          ); */

        return $msg;
    }

    public function write($is)
    {
        for ($i = 0; $i < $this->bytes; ++$i) {
            $is->write('x');
        }
    }
}
