<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensio\Bundle\FrameworkExtraBundle\Tests\Routing;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Routing\AnnotatedRouteControllerLoader;

/**
 * @group legacy
 */
class AnnotatedRouteControllerLoaderTest extends \PHPUnit\Framework\TestCase
{
    public function testServiceOptionIsAllowedOnClass()
    {
        $route = $this->getMockBuilder('Symfony\Component\Routing\Route')
            ->setMethods(['setDefault'])
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $route
            ->expects($this->once())
            ->method('setDefault')
            ->with('_controller', 'service:testServiceOptionIsAllowedOnClass')
        ;

        $annotation = new Route([]);
        $annotation->setService('service');

        $reader = $this->getMockBuilder('Doctrine\Common\Annotations\Reader')
            ->setMethods(['getClassAnnotation', 'getMethodAnnotations'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;

        $reader
            ->expects($this->once())
            ->method('getClassAnnotation')
            ->willReturn($annotation)
        ;

        $reader
            ->expects($this->once())
            ->method('getMethodAnnotations')
            ->willReturn([])
        ;

        $loader = $this->getMockBuilder('Sensio\Bundle\FrameworkExtraBundle\Routing\AnnotatedRouteControllerLoader')
            ->setConstructorArgs([$reader])
            ->getMock()
        ;

        $r = new \ReflectionMethod($loader, 'configureRoute');
        $r->setAccessible(true);
        $r->invoke($loader, $route, new \ReflectionClass($this), new \ReflectionMethod($this, 'testServiceOptionIsAllowedOnClass'), null);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage The service option can only be specified at class level.
     */
    public function testServiceOptionIsNotAllowedOnMethod()
    {
        $route = $this->getMockBuilder('Symfony\Component\Routing\Route')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $reader = $this->getMockBuilder('Doctrine\Common\Annotations\Reader')
            ->setMethods(['getClassAnnotation', 'getMethodAnnotations'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;

        $annotation = new Route([]);
        $annotation->setService('service');

        $reader
            ->expects($this->once())
            ->method('getClassAnnotation')
            ->willReturn(null)
        ;

        $reader
            ->expects($this->once())
            ->method('getMethodAnnotations')
            ->willReturn([$annotation])
        ;

        $loader = $this->getMockBuilder('Sensio\Bundle\FrameworkExtraBundle\Routing\AnnotatedRouteControllerLoader')
            ->setConstructorArgs([$reader])
            ->getMock()
        ;

        $r = new \ReflectionMethod($loader, 'configureRoute');
        $r->setAccessible(true);
        $r->invoke($loader, $route, new \ReflectionClass($this), new \ReflectionMethod($this, 'testServiceOptionIsNotAllowedOnMethod'), null);
    }

    public function testLoad()
    {
        $loader = new AnnotatedRouteControllerLoader(new AnnotationReader());
        AnnotationRegistry::registerLoader('class_exists');

        $rc = $loader->load('Sensio\Bundle\FrameworkExtraBundle\Tests\Routing\Fixtures\FoobarController');

        $this->assertInstanceOf('Symfony\Component\Routing\RouteCollection', $rc);
        $this->assertCount(3, $rc);

        $this->assertInstanceOf('Symfony\Component\Routing\Route', $rc->get('index'));
        // depending on the Symfony version, it can return GET or an empty array (on 2.3)
        // which has the same behavior anyway
        $methods = $rc->get('index')->getMethods();
        $this->assertTrue(empty($methods) || ['GET'] == $methods);

        $this->assertInstanceOf('Symfony\Component\Routing\Route', $rc->get('new'));
        $this->assertEquals(['POST'], $rc->get('new')->getMethods());

        $noNameRoute = $rc->get('sensio_frameworkextra_tests_routing_fixtures_foobar_noname');
        $this->assertInstanceOf('Symfony\Component\Routing\Route', $noNameRoute);
        $methods = $noNameRoute->getMethods();
        $this->assertTrue(empty($methods) || ['GET'] == $methods);
    }

    public function testInvokableControllerLoad()
    {
        $loader = new AnnotatedRouteControllerLoader(new AnnotationReader());
        AnnotationRegistry::registerLoader('class_exists');

        $rc = $loader->load('Sensio\Bundle\FrameworkExtraBundle\Tests\Routing\Fixtures\InvokableController');

        $this->assertInstanceOf('Symfony\Component\Routing\RouteCollection', $rc);
        $this->assertCount(1, $rc);

        $route = $rc->get('index');

        $this->assertInstanceOf('Symfony\Component\Routing\Route', $route);
        $this->assertSame(['_controller' => 'Sensio\Bundle\FrameworkExtraBundle\Tests\Routing\Fixtures\InvokableController'], $route->getDefaults());
    }
}
