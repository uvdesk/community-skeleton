<?php

namespace Test\Pager\Subscriber;

use Knp\Component\Pager\Event\BeforeEvent;
use Knp\Component\Pager\Event\Subscriber\Filtration\FiltrationSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Test\Tool\BaseTestCase;

final class FiltrationSubscriberTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldRegisterExpectedSubscribersOnlyOnce(): void
    {
        $dispatcher = $this->getMockBuilder(EventDispatcherInterface::class)->getMock();
        $dispatcher->expects($this->exactly(2))->method('addSubscriber');

        $subscriber = new FiltrationSubscriber;

        $requestStack = $this->createRequestStack([]);
        $beforeEvent = new BeforeEvent($dispatcher, $requestStack->getCurrentRequest());
        $subscriber->before($beforeEvent);

        // Subsequent calls do not add more subscribers
        $subscriber->before($beforeEvent);
    }
}