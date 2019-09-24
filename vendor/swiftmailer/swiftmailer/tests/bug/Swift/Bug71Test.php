<?php

class Swift_Bug71Test extends \PHPUnit\Framework\TestCase
{
    private $message;

    protected function setUp()
    {
        $this->message = new Swift_Message('test');
    }

    public function testCallingToStringAfterSettingNewBodyReflectsChanges()
    {
        $this->message->setBody('BODY1');
        $this->assertRegExp('/BODY1/', $this->message->toString());

        $this->message->setBody('BODY2');
        $this->assertRegExp('/BODY2/', $this->message->toString());
    }
}
