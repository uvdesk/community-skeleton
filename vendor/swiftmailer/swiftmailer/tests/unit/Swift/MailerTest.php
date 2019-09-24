<?php

class Swift_MailerTest extends \SwiftMailerTestCase
{
    public function testTransportIsStartedWhenSending()
    {
        $transport = $this->createTransport();
        $message = $this->createMessage();

        $started = false;
        $transport->shouldReceive('isStarted')
                  ->zeroOrMoreTimes()
                  ->andReturnUsing(function () use (&$started) {
                      return $started;
                  });
        $transport->shouldReceive('start')
                  ->once()
                  ->andReturnUsing(function () use (&$started) {
                      $started = true;

                      return;
                  });

        $mailer = $this->createMailer($transport);
        $mailer->send($message);
    }

    public function testTransportIsOnlyStartedOnce()
    {
        $transport = $this->createTransport();
        $message = $this->createMessage();

        $started = false;
        $transport->shouldReceive('isStarted')
                  ->zeroOrMoreTimes()
                  ->andReturnUsing(function () use (&$started) {
                      return $started;
                  });
        $transport->shouldReceive('start')
                  ->once()
                  ->andReturnUsing(function () use (&$started) {
                      $started = true;

                      return;
                  });

        $mailer = $this->createMailer($transport);
        for ($i = 0; $i < 10; ++$i) {
            $mailer->send($message);
        }
    }

    public function testMessageIsPassedToTransport()
    {
        $transport = $this->createTransport();
        $message = $this->createMessage();
        $transport->shouldReceive('send')
                  ->once()
                  ->with($message, \Mockery::any());

        $mailer = $this->createMailer($transport);
        $mailer->send($message);
    }

    public function testSendReturnsCountFromTransport()
    {
        $transport = $this->createTransport();
        $message = $this->createMessage();
        $transport->shouldReceive('send')
                  ->once()
                  ->with($message, \Mockery::any())
                  ->andReturn(57);

        $mailer = $this->createMailer($transport);
        $this->assertEquals(57, $mailer->send($message));
    }

    public function testFailedRecipientReferenceIsPassedToTransport()
    {
        $failures = [];

        $transport = $this->createTransport();
        $message = $this->createMessage();
        $transport->shouldReceive('send')
                  ->once()
                  ->with($message, $failures)
                  ->andReturn(57);

        $mailer = $this->createMailer($transport);
        $mailer->send($message, $failures);
    }

    public function testSendRecordsRfcComplianceExceptionAsEntireSendFailure()
    {
        $failures = [];

        $rfcException = new Swift_RfcComplianceException('test');
        $transport = $this->createTransport();
        $message = $this->createMessage();
        $message->shouldReceive('getTo')
                  ->once()
                  ->andReturn(['foo&invalid' => 'Foo', 'bar@valid.tld' => 'Bar']);
        $transport->shouldReceive('send')
                  ->once()
                  ->with($message, $failures)
                  ->andThrow($rfcException);

        $mailer = $this->createMailer($transport);
        $this->assertEquals(0, $mailer->send($message, $failures), '%s: Should return 0');
        $this->assertEquals(['foo&invalid', 'bar@valid.tld'], $failures, '%s: Failures should contain all addresses since the entire message failed to compile');
    }

    public function testRegisterPluginDelegatesToTransport()
    {
        $plugin = $this->createPlugin();
        $transport = $this->createTransport();
        $mailer = $this->createMailer($transport);

        $transport->shouldReceive('registerPlugin')
                  ->once()
                  ->with($plugin);

        $mailer->registerPlugin($plugin);
    }

    private function createPlugin()
    {
        return $this->getMockery('Swift_Events_EventListener')->shouldIgnoreMissing();
    }

    private function createTransport()
    {
        return $this->getMockery('Swift_Transport')->shouldIgnoreMissing();
    }

    private function createMessage()
    {
        return $this->getMockery('Swift_Mime_SimpleMessage')->shouldIgnoreMissing();
    }

    private function createMailer(Swift_Transport $transport)
    {
        return new Swift_Mailer($transport);
    }
}
