<?php

class Swift_Events_SendEventTest extends \PHPUnit\Framework\TestCase
{
    public function testMessageCanBeFetchedViaGetter()
    {
        $message = $this->createMessage();
        $transport = $this->createTransport();

        $evt = $this->createEvent($transport, $message);

        $ref = $evt->getMessage();
        $this->assertEquals($message, $ref,
            '%s: Message should be returned from getMessage()'
            );
    }

    public function testTransportCanBeFetchViaGetter()
    {
        $message = $this->createMessage();
        $transport = $this->createTransport();

        $evt = $this->createEvent($transport, $message);

        $ref = $evt->getTransport();
        $this->assertEquals($transport, $ref,
            '%s: Transport should be returned from getTransport()'
            );
    }

    public function testTransportCanBeFetchViaGetSource()
    {
        $message = $this->createMessage();
        $transport = $this->createTransport();

        $evt = $this->createEvent($transport, $message);

        $ref = $evt->getSource();
        $this->assertEquals($transport, $ref,
            '%s: Transport should be returned from getSource()'
            );
    }

    public function testResultCanBeSetAndGet()
    {
        $message = $this->createMessage();
        $transport = $this->createTransport();

        $evt = $this->createEvent($transport, $message);

        $evt->setResult(
            Swift_Events_SendEvent::RESULT_SUCCESS | Swift_Events_SendEvent::RESULT_TENTATIVE
            );

        $this->assertTrue((bool) ($evt->getResult() & Swift_Events_SendEvent::RESULT_SUCCESS));
        $this->assertTrue((bool) ($evt->getResult() & Swift_Events_SendEvent::RESULT_TENTATIVE));
    }

    public function testFailedRecipientsCanBeSetAndGet()
    {
        $message = $this->createMessage();
        $transport = $this->createTransport();

        $evt = $this->createEvent($transport, $message);

        $evt->setFailedRecipients(['foo@bar', 'zip@button']);

        $this->assertEquals(['foo@bar', 'zip@button'], $evt->getFailedRecipients(),
            '%s: FailedRecipients should be returned from getter'
            );
    }

    public function testFailedRecipientsGetsPickedUpCorrectly()
    {
        $message = $this->createMessage();
        $transport = $this->createTransport();

        $evt = $this->createEvent($transport, $message);
        $this->assertEquals([], $evt->getFailedRecipients());
    }

    private function createEvent(Swift_Transport $source, Swift_Mime_SimpleMessage $message)
    {
        return new Swift_Events_SendEvent($source, $message);
    }

    private function createTransport()
    {
        return $this->getMockBuilder('Swift_Transport')->getMock();
    }

    private function createMessage()
    {
        return $this->getMockBuilder('Swift_Mime_SimpleMessage')->disableOriginalConstructor()->getMock();
    }
}
