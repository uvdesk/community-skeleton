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

use Sensio\Bundle\FrameworkExtraBundle\Request\ArgumentNameConverter;
use Sensio\Bundle\FrameworkExtraBundle\Security\ExpressionLanguage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\SecurityListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerArgumentsEvent;

class SecurityListenerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function testAccessDenied()
    {
        $eventClass = class_exists(ControllerArgumentsEvent::class) ? ControllerArgumentsEvent::class : FilterControllerArgumentsEvent::class;

        $request = $this->createRequest(new Security(['expression' => 'is_granted("ROLE_ADMIN") or is_granted("FOO")']));
        $event = new $eventClass($this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')->getMock(), function () {
            return new Response();
        }, [], $request, null);

        $this->getListener()->onKernelControllerArguments($event);
    }

    /**
     * @expectedException        \Symfony\Component\HttpKernel\Exception\HttpException
     * @expectedExceptionMessage Not found
     */
    public function testNotFoundHttpException()
    {
        $eventClass = class_exists(ControllerArgumentsEvent::class) ? ControllerArgumentsEvent::class : FilterControllerArgumentsEvent::class;

        $request = $this->createRequest(new Security(['expression' => 'is_granted("ROLE_ADMIN") or is_granted("FOO")', 'statusCode' => 404, 'message' => 'Not found']));
        $event = new $eventClass($this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')->getMock(), function () {
            return new Response();
        }, [], $request, null);

        $this->getListener()->onKernelControllerArguments($event);
    }

    private function getListener()
    {
        $getRolesMethod = class_exists(ControllerArgumentsEvent::class) ? 'getRoleNames' : 'getRoles';
        $getReachableRolesMethod = class_exists(ControllerArgumentsEvent::class) ? 'getReachableRoleNames' : 'getReachableRoles';

        $roleHierarchy = $this->getMockBuilder('Symfony\Component\Security\Core\Role\RoleHierarchy')->disableOriginalConstructor()->getMock();
        $roleHierarchy->expects($this->once())->method($getReachableRolesMethod)->willReturn([]);

        $token = $this->getMockBuilder('Symfony\Component\Security\Core\Authentication\Token\AbstractToken')->getMock();
        $token->expects($this->once())->method($getRolesMethod)->willReturn([]);

        $tokenStorage = $this->getMockBuilder('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface')->getMock();
        $tokenStorage->expects($this->exactly(2))->method('getToken')->willReturn($token);

        $authChecker = $this->getMockBuilder('Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface')->getMock();
        $authChecker->expects($this->exactly(2))->method('isGranted')->willReturn(false);

        $trustResolver = $this->getMockBuilder('Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolverInterface')->getMock();

        $argNameConverter = $this->createArgumentNameConverter([]);

        $language = new ExpressionLanguage();

        return new SecurityListener($argNameConverter, $language, $trustResolver, $roleHierarchy, $tokenStorage, $authChecker);
    }

    private function createRequest(Security $security = null)
    {
        return new Request([], [], [
            '_security' => [
                $security,
                $security,
            ],
        ]);
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
