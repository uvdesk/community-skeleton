<?php

require_once __DIR__.'/AbstractSmtpTest.php';

abstract class Swift_Transport_AbstractSmtpEventSupportTest extends Swift_Transport_AbstractSmtpTest
{
    public function testRegisterPluginLoadsPluginInEventDispatcher()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $listener = $this->getMockery('Swift_Events_EventListener');
        $smtp = $this->getTransport($buf, $dispatcher);
        $dispatcher->shouldReceive('bindEventListener')
                   ->once()
                   ->with($listener);

        $smtp->registerPlugin($listener);
    }

    public function testSendingDispatchesBeforeSendEvent()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $message = $this->createMessage();
        $smtp = $this->getTransport($buf, $dispatcher);
        $evt = $this->getMockery('Swift_Events_SendEvent')->shouldIgnoreMissing();

        $message->shouldReceive('getFrom')
                ->zeroOrMoreTimes()
                ->andReturn(['chris@swiftmailer.org' => null]);
        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn(['mark@swiftmailer.org' => 'Mark']);
        $dispatcher->shouldReceive('createSendEvent')
                   ->once()
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'beforeSendPerformed');
        $dispatcher->shouldReceive('dispatchEvent')
                   ->zeroOrMoreTimes();
        $evt->shouldReceive('bubbleCancelled')
            ->zeroOrMoreTimes()
            ->andReturn(false);

        $this->finishBuffer($buf);
        $smtp->start();
        $this->assertEquals(1, $smtp->send($message));
    }

    public function testSendingDispatchesSendEvent()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $message = $this->createMessage();
        $smtp = $this->getTransport($buf, $dispatcher);
        $evt = $this->getMockery('Swift_Events_SendEvent')->shouldIgnoreMissing();

        $message->shouldReceive('getFrom')
                ->zeroOrMoreTimes()
                ->andReturn(['chris@swiftmailer.org' => null]);
        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn(['mark@swiftmailer.org' => 'Mark']);
        $dispatcher->shouldReceive('createSendEvent')
                   ->once()
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'sendPerformed');
        $dispatcher->shouldReceive('dispatchEvent')
                   ->zeroOrMoreTimes();
        $evt->shouldReceive('bubbleCancelled')
            ->zeroOrMoreTimes()
            ->andReturn(false);

        $this->finishBuffer($buf);
        $smtp->start();
        $this->assertEquals(1, $smtp->send($message));
    }

    public function testSendEventCapturesFailures()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $evt = $this->getMockery('Swift_Events_SendEvent')->shouldIgnoreMissing();
        $smtp = $this->getTransport($buf, $dispatcher);
        $message = $this->createMessage();

        $message->shouldReceive('getFrom')
                ->zeroOrMoreTimes()
                ->andReturn(['chris@swiftmailer.org' => null]);
        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn(['mark@swiftmailer.org' => 'Mark']);
        $buf->shouldReceive('write')
            ->once()
            ->with("MAIL FROM:<chris@swiftmailer.org>\r\n")
            ->andReturn(1);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn("250 OK\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with("RCPT TO:<mark@swiftmailer.org>\r\n")
            ->andReturn(2);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(2)
            ->andReturn("500 Not now\r\n");
        $dispatcher->shouldReceive('createSendEvent')
                   ->zeroOrMoreTimes()
                   ->with($smtp, \Mockery::any())
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'sendPerformed');
        $dispatcher->shouldReceive('dispatchEvent')
                   ->zeroOrMoreTimes();
        $evt->shouldReceive('bubbleCancelled')
            ->zeroOrMoreTimes()
            ->andReturn(false);
        $evt->shouldReceive('setFailedRecipients')
            ->once()
            ->with(['mark@swiftmailer.org']);

        $this->finishBuffer($buf);
        $smtp->start();
        $this->assertEquals(0, $smtp->send($message));
    }

    public function testSendEventHasResultFailedIfAllFailures()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $evt = $this->getMockery('Swift_Events_SendEvent')->shouldIgnoreMissing();
        $smtp = $this->getTransport($buf, $dispatcher);
        $message = $this->createMessage();

        $message->shouldReceive('getFrom')
                ->zeroOrMoreTimes()
                ->andReturn(['chris@swiftmailer.org' => null]);
        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn(['mark@swiftmailer.org' => 'Mark']);
        $buf->shouldReceive('write')
            ->once()
            ->with("MAIL FROM:<chris@swiftmailer.org>\r\n")
            ->andReturn(1);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn("250 OK\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with("RCPT TO:<mark@swiftmailer.org>\r\n")
            ->andReturn(2);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(2)
            ->andReturn("500 Not now\r\n");
        $dispatcher->shouldReceive('createSendEvent')
                   ->zeroOrMoreTimes()
                   ->with($smtp, \Mockery::any())
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'sendPerformed');
        $dispatcher->shouldReceive('dispatchEvent')
                   ->zeroOrMoreTimes();
        $evt->shouldReceive('bubbleCancelled')
            ->zeroOrMoreTimes()
            ->andReturn(false);
        $evt->shouldReceive('setResult')
            ->once()
            ->with(Swift_Events_SendEvent::RESULT_FAILED);

        $this->finishBuffer($buf);
        $smtp->start();
        $this->assertEquals(0, $smtp->send($message));
    }

    public function testSendEventHasResultTentativeIfSomeFailures()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $evt = $this->getMockery('Swift_Events_SendEvent')->shouldIgnoreMissing();
        $smtp = $this->getTransport($buf, $dispatcher);
        $message = $this->createMessage();

        $message->shouldReceive('getFrom')
                ->zeroOrMoreTimes()
                ->andReturn(['chris@swiftmailer.org' => null]);
        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn([
                    'mark@swiftmailer.org' => 'Mark',
                    'chris@site.tld' => 'Chris',
                ]);
        $buf->shouldReceive('write')
            ->once()
            ->with("MAIL FROM:<chris@swiftmailer.org>\r\n")
            ->andReturn(1);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn("250 OK\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with("RCPT TO:<mark@swiftmailer.org>\r\n")
            ->andReturn(2);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(2)
            ->andReturn("500 Not now\r\n");
        $dispatcher->shouldReceive('createSendEvent')
                   ->zeroOrMoreTimes()
                   ->with($smtp, \Mockery::any())
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'sendPerformed');
        $dispatcher->shouldReceive('dispatchEvent')
                   ->zeroOrMoreTimes();
        $evt->shouldReceive('bubbleCancelled')
            ->zeroOrMoreTimes()
            ->andReturn(false);
        $evt->shouldReceive('setResult')
            ->once()
            ->with(Swift_Events_SendEvent::RESULT_TENTATIVE);

        $this->finishBuffer($buf);
        $smtp->start();
        $this->assertEquals(1, $smtp->send($message));
    }

    public function testSendEventHasResultSuccessIfNoFailures()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $evt = $this->getMockery('Swift_Events_SendEvent')->shouldIgnoreMissing();
        $smtp = $this->getTransport($buf, $dispatcher);
        $message = $this->createMessage();

        $message->shouldReceive('getFrom')
                ->zeroOrMoreTimes()
                ->andReturn(['chris@swiftmailer.org' => null]);
        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn([
                    'mark@swiftmailer.org' => 'Mark',
                    'chris@site.tld' => 'Chris',
                ]);
        $dispatcher->shouldReceive('createSendEvent')
                   ->zeroOrMoreTimes()
                   ->with($smtp, \Mockery::any())
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'sendPerformed');
        $dispatcher->shouldReceive('dispatchEvent')
                   ->zeroOrMoreTimes();
        $evt->shouldReceive('bubbleCancelled')
            ->zeroOrMoreTimes()
            ->andReturn(false);
        $evt->shouldReceive('setResult')
            ->once()
            ->with(Swift_Events_SendEvent::RESULT_SUCCESS);

        $this->finishBuffer($buf);
        $smtp->start();
        $this->assertEquals(2, $smtp->send($message));
    }

    public function testCancellingEventBubbleBeforeSendStopsEvent()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $evt = $this->getMockery('Swift_Events_SendEvent')->shouldIgnoreMissing();
        $smtp = $this->getTransport($buf, $dispatcher);
        $message = $this->createMessage();

        $message->shouldReceive('getFrom')
                ->zeroOrMoreTimes()
                ->andReturn(['chris@swiftmailer.org' => null]);
        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn(['mark@swiftmailer.org' => 'Mark']);
        $dispatcher->shouldReceive('createSendEvent')
                   ->zeroOrMoreTimes()
                   ->with($smtp, \Mockery::any())
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'beforeSendPerformed');
        $dispatcher->shouldReceive('dispatchEvent')
                   ->zeroOrMoreTimes();
        $evt->shouldReceive('bubbleCancelled')
            ->atLeast()->once()
            ->andReturn(true);

        $this->finishBuffer($buf);
        $smtp->start();
        $this->assertEquals(0, $smtp->send($message));
    }

    public function testStartingTransportDispatchesTransportChangeEvent()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $evt = $this->getMockery('Swift_Events_TransportChangeEvent');
        $smtp = $this->getTransport($buf, $dispatcher);

        $dispatcher->shouldReceive('createTransportChangeEvent')
                   ->atLeast()->once()
                   ->with($smtp)
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'transportStarted');
        $dispatcher->shouldReceive('dispatchEvent')
                   ->zeroOrMoreTimes();
        $evt->shouldReceive('bubbleCancelled')
            ->atLeast()->once()
            ->andReturn(false);

        $this->finishBuffer($buf);
        $smtp->start();
    }

    public function testStartingTransportDispatchesBeforeTransportChangeEvent()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $evt = $this->getMockery('Swift_Events_TransportChangeEvent');
        $smtp = $this->getTransport($buf, $dispatcher);

        $dispatcher->shouldReceive('createTransportChangeEvent')
                   ->atLeast()->once()
                   ->with($smtp)
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'beforeTransportStarted');
        $dispatcher->shouldReceive('dispatchEvent')
                   ->zeroOrMoreTimes();
        $evt->shouldReceive('bubbleCancelled')
            ->atLeast()->once()
            ->andReturn(false);

        $this->finishBuffer($buf);
        $smtp->start();
    }

    public function testCancellingBubbleBeforeTransportStartStopsEvent()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $evt = $this->getMockery('Swift_Events_TransportChangeEvent');
        $smtp = $this->getTransport($buf, $dispatcher);

        $dispatcher->shouldReceive('createTransportChangeEvent')
                   ->atLeast()->once()
                   ->with($smtp)
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'beforeTransportStarted');
        $dispatcher->shouldReceive('dispatchEvent')
                   ->zeroOrMoreTimes();
        $evt->shouldReceive('bubbleCancelled')
            ->atLeast()->once()
            ->andReturn(true);

        $this->finishBuffer($buf);
        $smtp->start();

        $this->assertFalse($smtp->isStarted(),
            '%s: Transport should not be started since event bubble was cancelled'
        );
    }

    public function testStoppingTransportDispatchesTransportChangeEvent()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $evt = $this->getMockery('Swift_Events_TransportChangeEvent')->shouldIgnoreMissing();
        $smtp = $this->getTransport($buf, $dispatcher);

        $dispatcher->shouldReceive('createTransportChangeEvent')
                   ->atLeast()->once()
                   ->with($smtp)
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'transportStopped');
        $dispatcher->shouldReceive('dispatchEvent')
                   ->zeroOrMoreTimes();

        $this->finishBuffer($buf);
        $smtp->start();
        $smtp->stop();
    }

    public function testStoppingTransportDispatchesBeforeTransportChangeEvent()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $evt = $this->getMockery('Swift_Events_TransportChangeEvent')->shouldIgnoreMissing();
        $smtp = $this->getTransport($buf, $dispatcher);

        $dispatcher->shouldReceive('createTransportChangeEvent')
                   ->atLeast()->once()
                   ->with($smtp)
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'beforeTransportStopped');
        $dispatcher->shouldReceive('dispatchEvent')
                   ->zeroOrMoreTimes();

        $this->finishBuffer($buf);
        $smtp->start();
        $smtp->stop();
    }

    public function testCancellingBubbleBeforeTransportStoppedStopsEvent()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $evt = $this->getMockery('Swift_Events_TransportChangeEvent');
        $smtp = $this->getTransport($buf, $dispatcher);

        $hasRun = false;
        $dispatcher->shouldReceive('createTransportChangeEvent')
                   ->atLeast()->once()
                   ->with($smtp)
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'beforeTransportStopped')
                   ->andReturnUsing(function () use (&$hasRun) {
                       $hasRun = true;
                   });
        $dispatcher->shouldReceive('dispatchEvent')
                   ->zeroOrMoreTimes();
        $evt->shouldReceive('bubbleCancelled')
            ->zeroOrMoreTimes()
            ->andReturnUsing(function () use (&$hasRun) {
                return $hasRun;
            });

        $this->finishBuffer($buf);
        $smtp->start();
        $smtp->stop();

        $this->assertTrue($smtp->isStarted(),
            '%s: Transport should not be stopped since event bubble was cancelled'
        );
    }

    public function testResponseEventsAreGenerated()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $evt = $this->getMockery('Swift_Events_ResponseEvent');
        $smtp = $this->getTransport($buf, $dispatcher);

        $dispatcher->shouldReceive('createResponseEvent')
                   ->atLeast()->once()
                   ->with($smtp, \Mockery::any(), \Mockery::any())
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->atLeast()->once()
                   ->with($evt, 'responseReceived');

        $this->finishBuffer($buf);
        $smtp->start();
    }

    public function testCommandEventsAreGenerated()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $evt = $this->getMockery('Swift_Events_CommandEvent');
        $smtp = $this->getTransport($buf, $dispatcher);

        $dispatcher->shouldReceive('createCommandEvent')
                   ->once()
                   ->with($smtp, \Mockery::any(), \Mockery::any())
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'commandSent');

        $this->finishBuffer($buf);
        $smtp->start();
    }

    public function testExceptionsCauseExceptionEvents()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $evt = $this->getMockery('Swift_Events_TransportExceptionEvent');
        $smtp = $this->getTransport($buf, $dispatcher);

        $buf->shouldReceive('readLine')
            ->atLeast()->once()
            ->andReturn("503 I'm sleepy, go away!\r\n");
        $dispatcher->shouldReceive('createTransportExceptionEvent')
                   ->zeroOrMoreTimes()
                   ->with($smtp, \Mockery::any())
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->once()
                   ->with($evt, 'exceptionThrown');
        $evt->shouldReceive('bubbleCancelled')
            ->atLeast()->once()
            ->andReturn(false);

        try {
            $smtp->start();
            $this->fail('TransportException should be thrown on invalid response');
        } catch (Swift_TransportException $e) {
        }
    }

    public function testExceptionBubblesCanBeCancelled()
    {
        $buf = $this->getBuffer();
        $dispatcher = $this->createEventDispatcher(false);
        $evt = $this->getMockery('Swift_Events_TransportExceptionEvent');
        $smtp = $this->getTransport($buf, $dispatcher);

        $buf->shouldReceive('readLine')
            ->atLeast()->once()
            ->andReturn("503 I'm sleepy, go away!\r\n");
        $dispatcher->shouldReceive('createTransportExceptionEvent')
                   ->twice()
                   ->with($smtp, \Mockery::any())
                   ->andReturn($evt);
        $dispatcher->shouldReceive('dispatchEvent')
                   ->twice()
                   ->with($evt, 'exceptionThrown');
        $evt->shouldReceive('bubbleCancelled')
            ->atLeast()->once()
            ->andReturn(true);

        $this->finishBuffer($buf);
        $smtp->start();
    }

    protected function createEventDispatcher($stub = true)
    {
        return $this->getMockery('Swift_Events_EventDispatcher')->shouldIgnoreMissing();
    }
}
