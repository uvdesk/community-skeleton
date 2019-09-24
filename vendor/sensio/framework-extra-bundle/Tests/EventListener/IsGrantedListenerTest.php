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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\IsGrantedListener;
use Sensio\Bundle\FrameworkExtraBundle\Request\ArgumentNameConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerArgumentsEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class IsGrantedListenerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @expectedException \LogicException
     */
    public function testExceptionIfSecurityNotInstalled()
    {
        $listener = new IsGrantedListener($this->createArgumentNameConverter([]));
        $request = $this->createRequest(new IsGranted([]));
        $listener->onKernelControllerArguments($this->createFilterControllerEvent($request));
    }

    public function testNothingHappensWithNoConfig()
    {
        $authChecker = $this->getMockBuilder(AuthorizationCheckerInterface::class)->getMock();
        $authChecker->expects($this->never())
            ->method('isGranted');

        $listener = new IsGrantedListener($this->createArgumentNameConverter([]), $authChecker);
        $request = $this->createRequest();
        $listener->onKernelControllerArguments($this->createFilterControllerEvent($request));
    }

    public function testIsGrantedCalledCorrectly()
    {
        $authChecker = $this->getMockBuilder(AuthorizationCheckerInterface::class)->getMock();
        // createRequest() puts 2 IsGranted annotations into the config
        $authChecker->expects($this->exactly(2))
            ->method('isGranted')
            ->with('ROLE_ADMIN')
            ->willReturn(true);

        $listener = new IsGrantedListener($this->createArgumentNameConverter([]), $authChecker);
        $isGranted = new IsGranted(['attributes' => 'ROLE_ADMIN']);
        $request = $this->createRequest($isGranted);
        $listener->onKernelControllerArguments($this->createFilterControllerEvent($request));
    }

    public function testIsGrantedSubjectFromArguments()
    {
        $authChecker = $this->getMockBuilder(AuthorizationCheckerInterface::class)->getMock();
        // createRequest() puts 2 IsGranted annotations into the config
        $authChecker->expects($this->exactly(2))
            ->method('isGranted')
            // the subject => arg2name will eventually resolve to the 2nd argument, which has this value
            ->with('ROLE_ADMIN', 'arg2Value')
            ->willReturn(true);

        // create metadata for 2 named args for the controller
        $listener = new IsGrantedListener($this->createArgumentNameConverter(['arg1Name' => 'arg1Value', 'arg2Name' => 'arg2Value']), $authChecker);
        $isGranted = new IsGranted(['attributes' => 'ROLE_ADMIN', 'subject' => 'arg2Name']);
        $request = $this->createRequest($isGranted);

        $listener->onKernelControllerArguments($this->createFilterControllerEvent($request));
    }

    public function testIsGrantedSubjectFromArgumentsWithArray()
    {
        $authChecker = $this->getMockBuilder(AuthorizationCheckerInterface::class)->getMock();
        // createRequest() puts 2 IsGranted annotations into the config
        $authChecker->expects($this->exactly(2))
            ->method('isGranted')
            // the subject => arg2name will eventually resolve to the 2nd argument, which has this value
            ->with('ROLE_ADMIN', [
                'arg1Name' => 'arg1Value',
                'arg2Name' => 'arg2Value',
            ])
            ->willReturn(true);

        // create metadata for 2 named args for the controller
        $listener = new IsGrantedListener($this->createArgumentNameConverter(['arg1Name' => 'arg1Value', 'arg2Name' => 'arg2Value']), $authChecker);
        $isGranted = new IsGranted(['attributes' => 'ROLE_ADMIN', 'subject' => ['arg1Name', 'arg2Name']]);
        $request = $this->createRequest($isGranted);

        $listener->onKernelControllerArguments($this->createFilterControllerEvent($request));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionWhenMissingSubjectAttribute()
    {
        $authChecker = $this->getMockBuilder(AuthorizationCheckerInterface::class)->getMock();

        $listener = new IsGrantedListener($this->createArgumentNameConverter([]), $authChecker);
        $isGranted = new IsGranted(['attributes' => 'ROLE_ADMIN', 'subject' => 'non_existent']);
        $request = $this->createRequest($isGranted);
        $listener->onKernelControllerArguments($this->createFilterControllerEvent($request));
    }

    /**
     * @dataProvider getAccessDeniedMessageTests
     */
    public function testAccessDeniedMessages(array $attributes, $subject, $expectedMessage)
    {
        $authChecker = $this->getMockBuilder(AuthorizationCheckerInterface::class)->getMock();
        $authChecker->expects($this->any())
            ->method('isGranted')
            ->willReturn(false);

        // avoid the error of the subject not being found in the request attributes
        $arguments = [];
        if (null !== $subject) {
            $arguments[$subject] = 'bar';
        }

        $listener = new IsGrantedListener($this->createArgumentNameConverter($arguments), $authChecker);
        $isGranted = new IsGranted(['attributes' => $attributes, 'subject' => $subject]);
        $request = $this->createRequest($isGranted);

        try {
            $listener->onKernelControllerArguments($this->createFilterControllerEvent($request));
            $this->fail();
        } catch (\Exception $e) {
            $this->assertEquals(AccessDeniedException::class, \get_class($e));
            $this->assertEquals($expectedMessage, $e->getMessage());
        }
    }

    public function getAccessDeniedMessageTests()
    {
        yield [['ROLE_ADMIN'], null, 'Access Denied by controller annotation @IsGranted("ROLE_ADMIN")'];
        yield [['ROLE_ADMIN', 'ROLE_USER'], null, 'Access Denied by controller annotation @IsGranted(["ROLE_ADMIN", "ROLE_USER"])'];
        yield [['ROLE_ADMIN', 'ROLE_USER'], 'product', 'Access Denied by controller annotation @IsGranted(["ROLE_ADMIN", "ROLE_USER"], product)'];
    }

    /**
     * @expectedException        \Symfony\Component\HttpKernel\Exception\HttpException
     * @expectedExceptionMessage Not found
     */
    public function testNotFoundHttpException()
    {
        $request = $this->createRequest(new IsGranted(['attributes' => 'ROLE_ADMIN', 'statusCode' => 404, 'message' => 'Not found']));
        $event = $this->createFilterControllerEvent($request);

        $authChecker = $this->getMockBuilder(AuthorizationCheckerInterface::class)->getMock();
        $authChecker->expects($this->any())
            ->method('isGranted')
            ->willReturn(false);

        $listener = new IsGrantedListener($this->createArgumentNameConverter([]), $authChecker);
        $listener->onKernelControllerArguments($event);
    }

    private function createRequest(IsGranted $isGranted = null)
    {
        return new Request([], [], [
            '_is_granted' => null === $isGranted ? [] : [
                $isGranted,
                $isGranted,
            ],
        ]);
    }

    private function createFilterControllerEvent(Request $request)
    {
        $eventClass = class_exists(ControllerArgumentsEvent::class) ? ControllerArgumentsEvent::class : FilterControllerArgumentsEvent::class;

        return new $eventClass($this->getMockBuilder(HttpKernelInterface::class)->getMock(), function () {
            return new Response();
        }, [], $request, null);
    }

    private function createArgumentNameConverter(array $arguments)
    {
        $nameConverter = $this->getMockBuilder(ArgumentNameConverter::class)->disableOriginalConstructor()->getMock();

        $nameConverter->expects($this->any())
            ->method('getControllerArguments')
            ->willReturn($arguments);

        return $nameConverter;
    }
}
