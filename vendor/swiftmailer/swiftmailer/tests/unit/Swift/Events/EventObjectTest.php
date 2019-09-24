<?php

class Swift_Events_EventObjectTest extends \PHPUnit\Framework\TestCase
{
    public function testEventSourceCanBeReturnedViaGetter()
    {
        $source = new stdClass();
        $evt = $this->createEvent($source);
        $ref = $evt->getSource();
        $this->assertEquals($source, $ref);
    }

    public function testEventDoesNotHaveCancelledBubbleWhenNew()
    {
        $source = new stdClass();
        $evt = $this->createEvent($source);
        $this->assertFalse($evt->bubbleCancelled());
    }

    public function testBubbleCanBeCancelledInEvent()
    {
        $source = new stdClass();
        $evt = $this->createEvent($source);
        $evt->cancelBubble();
        $this->assertTrue($evt->bubbleCancelled());
    }

    private function createEvent($source)
    {
        return new Swift_Events_EventObject($source);
    }
}
