<?php

class Swift_Plugins_ReporterPluginTest extends \SwiftMailerTestCase
{
    public function testReportingPasses()
    {
        $message = $this->createMessage();
        $evt = $this->createSendEvent();
        $reporter = $this->createReporter();

        $message->shouldReceive('getTo')->zeroOrMoreTimes()->andReturn(['foo@bar.tld' => 'Foo']);
        $evt->shouldReceive('getMessage')->zeroOrMoreTimes()->andReturn($message);
        $evt->shouldReceive('getFailedRecipients')->zeroOrMoreTimes()->andReturn([]);
        $reporter->shouldReceive('notify')->once()->with($message, 'foo@bar.tld', Swift_Plugins_Reporter::RESULT_PASS);

        $plugin = new Swift_Plugins_ReporterPlugin($reporter);
        $plugin->sendPerformed($evt);
    }

    public function testReportingFailedTo()
    {
        $message = $this->createMessage();
        $evt = $this->createSendEvent();
        $reporter = $this->createReporter();

        $message->shouldReceive('getTo')->zeroOrMoreTimes()->andReturn(['foo@bar.tld' => 'Foo', 'zip@button' => 'Zip']);
        $evt->shouldReceive('getMessage')->zeroOrMoreTimes()->andReturn($message);
        $evt->shouldReceive('getFailedRecipients')->zeroOrMoreTimes()->andReturn(['zip@button']);
        $reporter->shouldReceive('notify')->once()->with($message, 'foo@bar.tld', Swift_Plugins_Reporter::RESULT_PASS);
        $reporter->shouldReceive('notify')->once()->with($message, 'zip@button', Swift_Plugins_Reporter::RESULT_FAIL);

        $plugin = new Swift_Plugins_ReporterPlugin($reporter);
        $plugin->sendPerformed($evt);
    }

    public function testReportingFailedCc()
    {
        $message = $this->createMessage();
        $evt = $this->createSendEvent();
        $reporter = $this->createReporter();

        $message->shouldReceive('getTo')->zeroOrMoreTimes()->andReturn(['foo@bar.tld' => 'Foo']);
        $message->shouldReceive('getCc')->zeroOrMoreTimes()->andReturn(['zip@button' => 'Zip', 'test@test.com' => 'Test']);
        $evt->shouldReceive('getMessage')->zeroOrMoreTimes()->andReturn($message);
        $evt->shouldReceive('getFailedRecipients')->zeroOrMoreTimes()->andReturn(['zip@button']);
        $reporter->shouldReceive('notify')->once()->with($message, 'foo@bar.tld', Swift_Plugins_Reporter::RESULT_PASS);
        $reporter->shouldReceive('notify')->once()->with($message, 'zip@button', Swift_Plugins_Reporter::RESULT_FAIL);
        $reporter->shouldReceive('notify')->once()->with($message, 'test@test.com', Swift_Plugins_Reporter::RESULT_PASS);

        $plugin = new Swift_Plugins_ReporterPlugin($reporter);
        $plugin->sendPerformed($evt);
    }

    public function testReportingFailedBcc()
    {
        $message = $this->createMessage();
        $evt = $this->createSendEvent();
        $reporter = $this->createReporter();

        $message->shouldReceive('getTo')->zeroOrMoreTimes()->andReturn(['foo@bar.tld' => 'Foo']);
        $message->shouldReceive('getBcc')->zeroOrMoreTimes()->andReturn(['zip@button' => 'Zip', 'test@test.com' => 'Test']);
        $evt->shouldReceive('getMessage')->zeroOrMoreTimes()->andReturn($message);
        $evt->shouldReceive('getFailedRecipients')->zeroOrMoreTimes()->andReturn(['zip@button']);
        $reporter->shouldReceive('notify')->once()->with($message, 'foo@bar.tld', Swift_Plugins_Reporter::RESULT_PASS);
        $reporter->shouldReceive('notify')->once()->with($message, 'zip@button', Swift_Plugins_Reporter::RESULT_FAIL);
        $reporter->shouldReceive('notify')->once()->with($message, 'test@test.com', Swift_Plugins_Reporter::RESULT_PASS);

        $plugin = new Swift_Plugins_ReporterPlugin($reporter);
        $plugin->sendPerformed($evt);
    }

    private function createMessage()
    {
        return $this->getMockery('Swift_Mime_SimpleMessage')->shouldIgnoreMissing();
    }

    private function createSendEvent()
    {
        return $this->getMockery('Swift_Events_SendEvent')->shouldIgnoreMissing();
    }

    private function createReporter()
    {
        return $this->getMockery('Swift_Plugins_Reporter')->shouldIgnoreMissing();
    }
}
