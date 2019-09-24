<?php

class Swift_Events_CommandEventTest extends \PHPUnit\Framework\TestCase
{
    public function testCommandCanBeFetchedByGetter()
    {
        $evt = $this->createEvent($this->createTransport(), "FOO\r\n");
        $this->assertEquals("FOO\r\n", $evt->getCommand());
    }

    public function testSuccessCodesCanBeFetchedViaGetter()
    {
        $evt = $this->createEvent($this->createTransport(), "FOO\r\n", [250]);
        $this->assertEquals([250], $evt->getSuccessCodes());
    }

    public function testSourceIsBuffer()
    {
        $transport = $this->createTransport();
        $evt = $this->createEvent($transport, "FOO\r\n");
        $ref = $evt->getSource();
        $this->assertEquals($transport, $ref);
    }

    private function createEvent(Swift_Transport $source, $command, $successCodes = [])
    {
        return new Swift_Events_CommandEvent($source, $command, $successCodes);
    }

    private function createTransport()
    {
        return $this->getMockBuilder('Swift_Transport')->getMock();
    }
}
