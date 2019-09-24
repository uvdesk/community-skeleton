<?php

class Swift_Events_ResponseEventTest extends \PHPUnit\Framework\TestCase
{
    public function testResponseCanBeFetchViaGetter()
    {
        $evt = $this->createEvent($this->createTransport(), "250 Ok\r\n", true);
        $this->assertEquals("250 Ok\r\n", $evt->getResponse(),
            '%s: Response should be available via getResponse()'
            );
    }

    public function testResultCanBeFetchedViaGetter()
    {
        $evt = $this->createEvent($this->createTransport(), "250 Ok\r\n", false);
        $this->assertFalse($evt->isValid(),
            '%s: Result should be checkable via isValid()'
            );
    }

    public function testSourceIsBuffer()
    {
        $transport = $this->createTransport();
        $evt = $this->createEvent($transport, "250 Ok\r\n", true);
        $ref = $evt->getSource();
        $this->assertEquals($transport, $ref);
    }

    private function createEvent(Swift_Transport $source, $response, $result)
    {
        return new Swift_Events_ResponseEvent($source, $response, $result);
    }

    private function createTransport()
    {
        return $this->getMockBuilder('Swift_Transport')->getMock();
    }
}
