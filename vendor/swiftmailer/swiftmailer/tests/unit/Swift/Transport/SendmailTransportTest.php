<?php

class Swift_Transport_SendmailTransportTest extends Swift_Transport_AbstractSmtpEventSupportTest
{
    protected function getTransport($buf, $dispatcher = null, $addressEncoder = null, $command = '/usr/sbin/sendmail -bs')
    {
        if (!$dispatcher) {
            $dispatcher = $this->createEventDispatcher();
        }
        $transport = new Swift_Transport_SendmailTransport($buf, $dispatcher, 'example.org', $addressEncoder);
        $transport->setCommand($command);

        return $transport;
    }

    protected function getSendmail($buf, $dispatcher = null)
    {
        if (!$dispatcher) {
            $dispatcher = $this->createEventDispatcher();
        }

        return new Swift_Transport_SendmailTransport($buf, $dispatcher);
    }

    public function testCommandCanBeSetAndFetched()
    {
        $buf = $this->getBuffer();
        $sendmail = $this->getSendmail($buf);

        $sendmail->setCommand('/usr/sbin/sendmail -bs');
        $this->assertEquals('/usr/sbin/sendmail -bs', $sendmail->getCommand());
        $sendmail->setCommand('/usr/sbin/sendmail -oi -t');
        $this->assertEquals('/usr/sbin/sendmail -oi -t', $sendmail->getCommand());
    }

    public function testSendingMessageIn_t_ModeUsesSimplePipe()
    {
        $buf = $this->getBuffer();
        $sendmail = $this->getSendmail($buf);
        $message = $this->createMessage();

        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn(['foo@bar' => 'Foobar', 'zip@button' => 'Zippy']);
        $message->shouldReceive('toByteStream')
                ->once()
                ->with($buf);
        $buf->shouldReceive('initialize')
            ->once();
        $buf->shouldReceive('terminate')
            ->once();
        $buf->shouldReceive('setWriteTranslations')
            ->once()
            ->with(["\r\n" => "\n", "\n." => "\n.."]);
        $buf->shouldReceive('setWriteTranslations')
            ->once()
            ->with([]);

        $sendmail->setCommand('/usr/sbin/sendmail -t');
        $this->assertEquals(2, $sendmail->send($message));
    }

    public function testSendingIn_t_ModeWith_i_FlagDoesntEscapeDot()
    {
        $buf = $this->getBuffer();
        $sendmail = $this->getSendmail($buf);
        $message = $this->createMessage();

        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn(['foo@bar' => 'Foobar', 'zip@button' => 'Zippy']);
        $message->shouldReceive('toByteStream')
                ->once()
                ->with($buf);
        $buf->shouldReceive('initialize')
            ->once();
        $buf->shouldReceive('terminate')
            ->once();
        $buf->shouldReceive('setWriteTranslations')
            ->once()
            ->with(["\r\n" => "\n"]);
        $buf->shouldReceive('setWriteTranslations')
            ->once()
            ->with([]);

        $sendmail->setCommand('/usr/sbin/sendmail -i -t');
        $this->assertEquals(2, $sendmail->send($message));
    }

    public function testSendingInTModeWith_oi_FlagDoesntEscapeDot()
    {
        $buf = $this->getBuffer();
        $sendmail = $this->getSendmail($buf);
        $message = $this->createMessage();

        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn(['foo@bar' => 'Foobar', 'zip@button' => 'Zippy']);
        $message->shouldReceive('toByteStream')
                ->once()
                ->with($buf);
        $buf->shouldReceive('initialize')
            ->once();
        $buf->shouldReceive('terminate')
            ->once();
        $buf->shouldReceive('setWriteTranslations')
            ->once()
            ->with(["\r\n" => "\n"]);
        $buf->shouldReceive('setWriteTranslations')
            ->once()
            ->with([]);

        $sendmail->setCommand('/usr/sbin/sendmail -oi -t');
        $this->assertEquals(2, $sendmail->send($message));
    }

    public function testSendingMessageRegeneratesId()
    {
        $buf = $this->getBuffer();
        $sendmail = $this->getSendmail($buf);
        $message = $this->createMessage();

        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn(['foo@bar' => 'Foobar', 'zip@button' => 'Zippy']);
        $message->shouldReceive('generateId');
        $buf->shouldReceive('initialize')
            ->once();
        $buf->shouldReceive('terminate')
            ->once();
        $buf->shouldReceive('setWriteTranslations')
            ->once()
            ->with(["\r\n" => "\n", "\n." => "\n.."]);
        $buf->shouldReceive('setWriteTranslations')
            ->once()
            ->with([]);

        $sendmail->setCommand('/usr/sbin/sendmail -t');
        $this->assertEquals(2, $sendmail->send($message));
    }

    public function testFluidInterface()
    {
        $buf = $this->getBuffer();
        $sendmail = $this->getTransport($buf);

        $ref = $sendmail->setCommand('/foo');
        $this->assertEquals($ref, $sendmail);
    }
}
