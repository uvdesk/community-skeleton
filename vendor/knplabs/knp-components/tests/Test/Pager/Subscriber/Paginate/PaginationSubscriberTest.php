<?php

namespace Test\Pager\Subscriber\Paginate;

use Knp\Component\Pager\Event\BeforeEvent;
use Knp\Component\Pager\Event\Subscriber\Paginate\PaginationSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Test\Tool\BaseTestCase;

final class PaginationSubscriberTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldRegisterExpectedSubscribersOnlyOnce(): void
    {
        $dispatcher = $this->getMockBuilder(EventDispatcherInterface::class)->getMock();
        $dispatcher->expects($this->exactly(13))->method('addSubscriber');

        $subscriber = new PaginationSubscriber;

        $requestStack = $this->createRequestStack([]);
        $beforeEvent = new BeforeEvent($dispatcher, $requestStack->getCurrentRequest());
        $subscriber->before($beforeEvent);

        // Subsequent calls do not add more subscribers
        $subscriber->before($beforeEvent);
    }
}