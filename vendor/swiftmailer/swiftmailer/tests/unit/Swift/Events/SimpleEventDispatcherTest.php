<?php

class Swift_Events_SimpleEventDispatcherTest extends \PHPUnit\Framework\TestCase
{
    private $dispatcher;

    protected function setUp()
    {
        $this->dispatcher = new Swift_Events_SimpleEventDispatcher();
    }

    public function testSendEventCanBeCreated()
    {
        $transport = $this->getMockBuilder('Swift_Transport')->getMock();
        $message = $this->getMockBuilder('Swift_Mime_SimpleMessage')->disableOriginalConstructor()->getMock();
        $evt = $this->dispatcher->createSendEvent($transport, $message);
        $this->assertInstanceOf('Swift_Events_SendEvent', $evt);
        $this->assertSame($message, $evt->getMessage());
        $this->assertSame($transport, $evt->getTransport());
    }

    public function testCommandEventCanBeCreated()
    {
        $buf = $this->getMockBuilder('Swift_Transport')->getMock();
        $evt = $this->dispatcher->createCommandEvent($buf, "FOO\r\n", [250]);
        $this->assertInstanceOf('Swift_Events_CommandEvent', $evt);
        $this->assertSame($buf, $evt->getSource());
        $this->assertEquals("FOO\r\n", $evt->getCommand());
        $this->assertEquals([250], $evt->getSuccessCodes());
    }

    public function testResponseEventCanBeCreated()
    {
        $buf = $this->getMockBuilder('Swift_Transport')->getMock();
        $evt = $this->dispatcher->createResponseEvent($buf, "250 Ok\r\n", true);
        $this->assertInstanceOf('Swift_Events_ResponseEvent', $evt);
        $this->assertSame($buf, $evt->getSource());
        $this->assertEquals("250 Ok\r\n", $evt->getResponse());
        $this->assertTrue($evt->isValid());
    }

    public function testTransportChangeEventCanBeCreated()
    {
        $transport = $this->getMockBuilder('Swift_Transport')->getMock();
        $evt = $this->dispatcher->createTransportChangeEvent($transport);
        $this->assertInstanceOf('Swift_Events_TransportChangeEvent', $evt);
        $this->assertSame($transport, $evt->getSource());
    }

    public function testTransportExceptionEventCanBeCreated()
    {
        $transport = $this->getMockBuilder('Swift_Transport')->getMock();
        $ex = new Swift_TransportException('');
        $evt = $this->dispatcher->createTransportExceptionEvent($transport, $ex);
        $this->assertInstanceOf('Swift_Events_TransportExceptionEvent', $evt);
        $this->assertSame($transport, $evt->getSource());
        $this->assertSame($ex, $evt->getException());
    }

    public function testListenersAreNotifiedOfDispatchedEvent()
    {
        $transport = $this->getMockBuilder('Swift_Transport')->getMock();

        $evt = $this->dispatcher->createTransportChangeEvent($transport);

        $listenerA = $this->getMockBuilder('Swift_Events_TransportChangeListener')->getMock();
        $listenerB = $this->getMockBuilder('Swift_Events_TransportChangeListener')->getMock();

        $this->dispatcher->bindEventListener($listenerA);
        $this->dispatcher->bindEventListener($listenerB);

        $listenerA->expects($this->once())
                  ->method('transportStarted')
                  ->with($evt);
        $listenerB->expects($this->once())
                  ->method('transportStarted')
                  ->with($evt);

        $this->dispatcher->dispatchEvent($evt, 'transportStarted');
    }

    public function testListenersAreOnlyCalledIfImplementingCorrectInterface()
    {
        $transport = $this->getMockBuilder('Swift_Transport')->getMock();
        $message = $this->getMockBuilder('Swift_Mime_SimpleMessage')->disableOriginalConstructor()->getMock();

        $evt = $this->dispatcher->createSendEvent($transport, $message);

        $targetListener = $this->getMockBuilder('Swift_Events_SendListener')->getMock();
        $otherListener = $this->getMockBuilder('DummyListener')->getMock();

        $this->dispatcher->bindEventListener($targetListener);
        $this->dispatcher->bindEventListener($otherListener);

        $targetListener->expects($this->once())
                       ->method('sendPerformed')
                       ->with($evt);
        $otherListener->expects($this->never())
                    ->method('sendPerformed');

        $this->dispatcher->dispatchEvent($evt, 'sendPerformed');
    }

    public function testListenersCanCancelBubblingOfEvent()
    {
        $transport = $this->getMockBuilder('Swift_Transport')->getMock();
        $message = $this->getMockBuilder('Swift_Mime_SimpleMessage')->disableOriginalConstructor()->getMock();

        $evt = $this->dispatcher->createSendEvent($transport, $message);

        $listenerA = $this->getMockBuilder('Swift_Events_SendListener')->getMock();
        $listenerB = $this->getMockBuilder('Swift_Events_SendListener')->getMock();

        $this->dispatcher->bindEventListener($listenerA);
        $this->dispatcher->bindEventListener($listenerB);

        $listenerA->expects($this->once())
                  ->method('sendPerformed')
                  ->with($evt)
                  ->will($this->returnCallback(function ($object) {
                      $object->cancelBubble(true);
                  }));
        $listenerB->expects($this->never())
                  ->method('sendPerformed');

        $this->dispatcher->dispatchEvent($evt, 'sendPerformed');

        $this->assertTrue($evt->bubbleCancelled());
    }

    private function createDispatcher(array $map)
    {
        return new Swift_Events_SimpleEventDispatcher($map);
    }
}

class DummyListener implements Swift_Events_EventListener
{
    public function sendPerformed(Swift_Events_SendEvent $evt)
    {
    }
}
