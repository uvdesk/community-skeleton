<?php

class Swift_Events_TransportChangeEventTest extends \PHPUnit\Framework\TestCase
{
    public function testGetTransportReturnsTransport()
    {
        $transport = $this->createTransport();
        $evt = $this->createEvent($transport);
        $ref = $evt->getTransport();
        $this->assertEquals($transport, $ref);
    }

    public function testSourceIsTransport()
    {
        $transport = $this->createTransport();
        $evt = $this->createEvent($transport);
        $ref = $evt->getSource();
        $this->assertEquals($transport, $ref);
    }

    private function createEvent(Swift_Transport $source)
    {
        return new Swift_Events_TransportChangeEvent($source);
    }

    private function createTransport()
    {
        return $this->getMockBuilder('Swift_Transport')->getMock();
    }
}
