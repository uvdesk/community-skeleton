<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensio\Bundle\FrameworkExtraBundle\Tests\EventListener;

use Sensio\Bundle\FrameworkExtraBundle\EventListener\PsrResponseListener;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Tests\Fixtures\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;

/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @requires PHP 5.4
 */
class PsrResponseListenerTest extends \PHPUnit\Framework\TestCase
{
    public function testConvertsControllerResult()
    {
        $listener = new PsrResponseListener(new HttpFoundationFactory());
        $event = $this->createEventMock(new Response());
        $event->expects($this->once())->method('setResponse')->with($this->isInstanceOf('Symfony\Component\HttpFoundation\Response'));
        $listener->onKernelView($event);
    }

    public function testDoesNotConvertControllerResult()
    {
        $listener = new PsrResponseListener(new HttpFoundationFactory());
        $event = $this->createEventMock([]);
        $event->expects($this->never())->method('setResponse');

        $listener->onKernelView($event);

        $event = $this->createEventMock(null);
        $event->expects($this->never())->method('setResponse');

        $listener->onKernelView($event);
    }

    private function createEventMock($controllerResult)
    {
        $eventClass = class_exists(ViewEvent::class) ? ViewEvent::class : GetResponseForControllerResultEvent::class;

        $event = $this
            ->getMockBuilder($eventClass)
            ->disableOriginalConstructor()
            ->getMock();

        $event
            ->expects($this->any())
            ->method('getControllerResult')
            ->willReturn($controllerResult);

        return $event;
    }
}
