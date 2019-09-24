<?php

class Swift_Plugins_Reporters_HitReporterTest extends \PHPUnit\Framework\TestCase
{
    private $hitReporter;
    private $message;

    protected function setUp()
    {
        $this->hitReporter = new Swift_Plugins_Reporters_HitReporter();
        $this->message = $this->getMockBuilder('Swift_Mime_SimpleMessage')->disableOriginalConstructor()->getMock();
    }

    public function testReportingFail()
    {
        $this->hitReporter->notify($this->message, 'foo@bar.tld',
            Swift_Plugins_Reporter::RESULT_FAIL
            );
        $this->assertEquals(['foo@bar.tld'],
            $this->hitReporter->getFailedRecipients()
            );
    }

    public function testMultipleReports()
    {
        $this->hitReporter->notify($this->message, 'foo@bar.tld',
            Swift_Plugins_Reporter::RESULT_FAIL
            );
        $this->hitReporter->notify($this->message, 'zip@button',
            Swift_Plugins_Reporter::RESULT_FAIL
            );
        $this->assertEquals(['foo@bar.tld', 'zip@button'],
            $this->hitReporter->getFailedRecipients()
            );
    }

    public function testReportingPassIsIgnored()
    {
        $this->hitReporter->notify($this->message, 'foo@bar.tld',
            Swift_Plugins_Reporter::RESULT_FAIL
            );
        $this->hitReporter->notify($this->message, 'zip@button',
            Swift_Plugins_Reporter::RESULT_PASS
            );
        $this->assertEquals(['foo@bar.tld'],
            $this->hitReporter->getFailedRecipients()
            );
    }

    public function testBufferCanBeCleared()
    {
        $this->hitReporter->notify($this->message, 'foo@bar.tld',
            Swift_Plugins_Reporter::RESULT_FAIL
            );
        $this->hitReporter->notify($this->message, 'zip@button',
            Swift_Plugins_Reporter::RESULT_FAIL
            );
        $this->assertEquals(['foo@bar.tld', 'zip@button'],
            $this->hitReporter->getFailedRecipients()
            );
        $this->hitReporter->clear();
        $this->assertEquals([], $this->hitReporter->getFailedRecipients());
    }
}
