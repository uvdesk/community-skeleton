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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener;
use Sensio\Bundle\FrameworkExtraBundle\Tests\EventListener\Fixture\FooControllerNullableParameter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class ParamConverterListenerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getControllerWithNoArgsFixtures
     */
    public function testRequestIsSkipped($controllerCallable)
    {
        $kernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')->getMock();
        $request = new Request();
        $eventClass = class_exists(ControllerEvent::class) ? ControllerEvent::class : FilterControllerEvent::class;

        $listener = new ParamConverterListener($this->getParamConverterManager($request, []));
        $event = new $eventClass($kernel, $controllerCallable, $request, null);

        $listener->onKernelController($event);
    }

    public function getControllerWithNoArgsFixtures()
    {
        return [
            [[new TestController(), 'noArgAction']],
            [new InvokableNoArgController()],
        ];
    }

    /**
     * @dataProvider getControllerWithArgsFixtures
     */
    public function testAutoConvert($controllerCallable)
    {
        $kernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')->getMock();
        $request = new Request([], [], ['date' => '2014-03-14 09:00:00']);
        $eventClass = class_exists(ControllerEvent::class) ? ControllerEvent::class : FilterControllerEvent::class;

        $converter = new ParamConverter(['name' => 'date', 'class' => 'DateTime']);

        $listener = new ParamConverterListener($this->getParamConverterManager($request, ['date' => $converter]));
        $event = new $eventClass($kernel, $controllerCallable, $request, null);

        $listener->onKernelController($event);
    }

    /**
     * @dataProvider settingOptionalParamProvider
     * @requires PHP 7.1
     */
    public function testSettingOptionalParam($function, $isOptional)
    {
        $kernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')->getMock();
        $request = new Request();
        $eventClass = class_exists(ControllerEvent::class) ? ControllerEvent::class : FilterControllerEvent::class;

        $converter = new ParamConverter(['name' => 'param', 'class' => 'DateTime']);
        $converter->setIsOptional($isOptional);

        $listener = new ParamConverterListener($this->getParamConverterManager($request, ['param' => $converter]), true);
        $event = new $eventClass(
            $kernel,
            [
                new FooControllerNullableParameter(),
                $function,
            ],
            $request,
            null
        );

        $listener->onKernelController($event);
    }

    public function settingOptionalParamProvider()
    {
        return [
            ['requiredParamAction', false],
            ['defaultParamAction', true],
            ['nullableParamAction', true],
        ];
    }

    /**
     * @dataProvider getControllerWithArgsFixtures
     */
    public function testNoAutoConvert($controllerCallable)
    {
        $kernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')->getMock();
        $request = new Request([], [], ['date' => '2014-03-14 09:00:00']);
        $eventClass = class_exists(ControllerEvent::class) ? ControllerEvent::class : FilterControllerEvent::class;

        $listener = new ParamConverterListener($this->getParamConverterManager($request, []), false);
        $event = new $eventClass($kernel, $controllerCallable, $request, null);

        $listener->onKernelController($event);
    }

    public function getControllerWithArgsFixtures()
    {
        return [
            [[new TestController(), 'dateAction']],
            [new InvokableController()],
        ];
    }

    private function getParamConverterManager(Request $request, $configurations)
    {
        $manager = $this->getMockBuilder('Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterManager')->getMock();
        $manager
            ->expects($this->once())
            ->method('apply')
            ->with($this->equalTo($request), $this->equalTo($configurations))
        ;

        return $manager;
    }
}

class TestController
{
    public function noArgAction(Request $request)
    {
    }

    public function dateAction(\DateTime $date)
    {
    }
}

class InvokableNoArgController
{
    public function __invoke(Request $request)
    {
    }
}

class InvokableController
{
    public function __invoke(\DateTime $date)
    {
    }
}
