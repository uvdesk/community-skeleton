<?php

class Swift_Bug118Test extends \PHPUnit\Framework\TestCase
{
    private $message;

    protected function setUp()
    {
        $this->message = new Swift_Message();
    }

    public function testCallingGenerateIdChangesTheMessageId()
    {
        $currentId = $this->message->getId();
        $this->message->generateId();
        $newId = $this->message->getId();

        $this->assertNotEquals($currentId, $newId);
    }
}
