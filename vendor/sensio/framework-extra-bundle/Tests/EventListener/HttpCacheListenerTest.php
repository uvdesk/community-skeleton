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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\HttpCacheListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class HttpCacheListenerTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        $this->listener = new HttpCacheListener();
        $this->response = new Response();
        $this->cache = new Cache([]);
        $this->request = $this->createRequest($this->cache);
        $this->event = $this->createEventMock($this->request, $this->response);
    }

    public function testWontReassignResponseWhenResponseIsUnsuccessful()
    {
        $this->event
            ->expects($this->never())
            ->method('setResponse')
        ;

        $this->response->setStatusCode(500);

        $this->assertInternalType('null', $this->listener->onKernelResponse($this->event));
    }

    public function testWontReassignResponseWhenNoConfigurationIsPresent()
    {
        $this->event
            ->expects($this->never())
            ->method('setResponse')
        ;

        $this->request->attributes->remove('_cache');

        $this->assertInternalType('null', $this->listener->onKernelResponse($this->event));
    }

    public function testResponseIsPublicIfConfigurationIsPublicTrue()
    {
        $request = $this->createRequest(new Cache([
            'public' => true,
        ]));

        $this->listener->onKernelResponse($this->createEventMock($request, $this->response));

        $this->assertTrue($this->response->headers->hasCacheControlDirective('public'));
        $this->assertFalse($this->response->headers->hasCacheControlDirective('private'));
    }

    public function testResponseIsPrivateIfConfigurationIsPublicFalse()
    {
        $request = $this->createRequest(new Cache([
                    'public' => false,
                ]));

        $this->listener->onKernelResponse($this->createEventMock($request, $this->response));

        $this->assertFalse($this->response->headers->hasCacheControlDirective('public'));
        $this->assertTrue($this->response->headers->hasCacheControlDirective('private'));
    }

    public function testResponseVary()
    {
        $vary = ['foobar'];
        $request = $this->createRequest(new Cache(['vary' => $vary]));

        $this->listener->onKernelResponse($this->createEventMock($request, $this->response));
        $this->assertTrue($this->response->hasVary());
        $result = $this->response->getVary();
        $this->assertEquals($vary, $result);
    }

    public function testResponseVaryWhenVaryNotSet()
    {
        $request = $this->createRequest(new Cache([]));
        $vary = ['foobar'];
        $this->response->setVary($vary);

        $this->listener->onKernelResponse($this->createEventMock($request, $this->response));
        $this->assertTrue($this->response->hasVary());
        $result = $this->response->getVary();
        $this->assertNotEmpty($result, 'Existing vary headers should not be removed');
        $this->assertEquals($vary, $result, 'Vary header should not be changed');
    }

    public function testResponseIsPrivateIfConfigurationIsPublicNotSet()
    {
        $request = $this->createRequest(new Cache([]));

        $this->listener->onKernelResponse($this->createEventMock($request, $this->response));

        $this->assertFalse($this->response->headers->hasCacheControlDirective('public'));
    }

    public function testConfigurationAttributesAreSetOnResponse()
    {
        $this->assertInternalType('null', $this->response->getMaxAge());
        $this->assertInternalType('null', $this->response->getExpires());
        $this->assertFalse($this->response->headers->hasCacheControlDirective('s-maxage'));
        $this->assertFalse($this->response->headers->hasCacheControlDirective('max-stale'));

        $this->request->attributes->set('_cache', new Cache([
            'expires' => 'tomorrow',
            'smaxage' => '15',
            'maxage' => '15',
            'maxstale' => '5',
        ]));

        $this->listener->onKernelResponse($this->event);

        $this->assertEquals('15', $this->response->getMaxAge());
        $this->assertEquals('15', $this->response->headers->getCacheControlDirective('s-maxage'));
        $this->assertEquals('5', $this->response->headers->getCacheControlDirective('max-stale'));
        $this->assertInstanceOf('DateTime', $this->response->getExpires());
    }

    public function testCacheMaxAgeSupportsStrtotimeFormat()
    {
        $this->request->attributes->set('_cache', new Cache([
            'smaxage' => '1 day',
            'maxage' => '1 day',
            'maxstale' => '1 day',
        ]));

        $this->listener->onKernelResponse($this->event);

        $this->assertEquals(60 * 60 * 24, $this->response->headers->getCacheControlDirective('s-maxage'));
        $this->assertEquals(60 * 60 * 24, $this->response->getMaxAge());
        $this->assertEquals(60 * 60 * 24, $this->response->headers->getCacheControlDirective('max-stale'));
    }

    public function testLastModifiedNotModifiedResponse()
    {
        $request = $this->createRequest(new Cache(['lastModified' => 'test.getDate()']));
        $request->attributes->set('test', new TestEntity());
        $request->headers->add(['If-Modified-Since' => 'Fri, 23 Aug 2013 00:00:00 GMT']);
        $eventClass = class_exists(ControllerEvent::class) ? ControllerEvent::class : FilterControllerEvent::class;

        $listener = new HttpCacheListener();
        $controllerEvent = new $eventClass($this->getKernel(), function () {
            return new Response(500);
        }, $request, null);

        $listener->onKernelController($controllerEvent);
        $response = \call_user_func($controllerEvent->getController());

        $this->assertEquals(304, $response->getStatusCode());
    }

    public function testLastModifiedHeader()
    {
        $request = $this->createRequest(new Cache(['lastModified' => 'test.getDate()']));
        $request->attributes->set('test', new TestEntity());
        $response = new Response();
        $eventClass = class_exists(ControllerEvent::class) ? ControllerEvent::class : FilterControllerEvent::class;

        $listener = new HttpCacheListener();
        $controllerEvent = new $eventClass($this->getKernel(), function () {
            return new Response();
        }, $request, null);
        $listener->onKernelController($controllerEvent);
        $eventClass = class_exists(ResponseEvent::class) ? ResponseEvent::class : FilterResponseEvent::class;

        $responseEvent = new $eventClass($this->getKernel(), $request, HttpKernelInterface::MASTER_REQUEST, \call_user_func($controllerEvent->getController()));
        $listener->onKernelResponse($responseEvent);

        $response = $responseEvent->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->has('Last-Modified'));
        $this->assertEquals('Fri, 23 Aug 2013 00:00:00 GMT', $response->headers->get('Last-Modified'));
    }

    public function testEtagNotModifiedResponse()
    {
        $request = $this->createRequest(new Cache(['etag' => 'test.getId()']));
        $request->attributes->set('test', $entity = new TestEntity());
        $request->headers->add(['If-None-Match' => sprintf('"%s"', hash('sha256', $entity->getId()))]);
        $eventClass = class_exists(ControllerEvent::class) ? ControllerEvent::class : FilterControllerEvent::class;

        $listener = new HttpCacheListener();
        $controllerEvent = new $eventClass($this->getKernel(), function () {
            return new Response(500);
        }, $request, null);

        $listener->onKernelController($controllerEvent);
        $response = \call_user_func($controllerEvent->getController());

        $this->assertEquals(304, $response->getStatusCode());
    }

    public function testEtagHeader()
    {
        $request = $this->createRequest(new Cache(['ETag' => 'test.getId()']));
        $request->attributes->set('test', $entity = new TestEntity());
        $response = new Response();
        $eventClass = class_exists(ControllerEvent::class) ? ControllerEvent::class : FilterControllerEvent::class;

        $listener = new HttpCacheListener();
        $controllerEvent = new $eventClass($this->getKernel(), function () {
            return new Response();
        }, $request, null);
        $listener->onKernelController($controllerEvent);

        $eventClass = class_exists(ResponseEvent::class) ? ResponseEvent::class : FilterResponseEvent::class;

        $responseEvent = new $eventClass($this->getKernel(), $request, HttpKernelInterface::MASTER_REQUEST, \call_user_func($controllerEvent->getController()));
        $listener->onKernelResponse($responseEvent);

        $response = $responseEvent->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->has('ETag'));
        $this->assertContains(hash('sha256', $entity->getId()), $response->headers->get('ETag'));
    }

    public function testConfigurationDoesNotOverrideAlreadySetResponseHeaders()
    {
        $request = $this->createRequest(new Cache([
            'ETag' => '"12345"',
            'lastModified' => new \DateTime('Fri, 23 Aug 2013 00:00:00 GMT'),
            'expires' => new \DateTime('Fri, 24 Aug 2013 00:00:00 GMT'),
            'smaxage' => '15',
            'maxage' => '15',
            'vary' => ['foobar'],
        ]));

        $response = new Response();
        $response->setEtag('"54321"');
        $response->setLastModified(new \DateTime('Fri, 23 Aug 2014 00:00:00 GMT'));
        $response->setExpires(new \DateTime('Fri, 24 Aug 2014 00:00:00 GMT'));
        $response->setSharedMaxAge(30);
        $response->setMaxAge(30);
        $response->setVary(['foobaz']);

        $eventClass = class_exists(ResponseEvent::class) ? ResponseEvent::class : FilterResponseEvent::class;

        $listener = new HttpCacheListener();
        $responseEvent = new $eventClass($this->getKernel(), $request, HttpKernelInterface::MASTER_REQUEST, $response);
        $listener->onKernelResponse($responseEvent);

        $this->assertEquals('"54321"', $response->getEtag());
        $this->assertEquals(new \DateTime('Fri, 23 Aug 2014 00:00:00 GMT'), $response->getLastModified());
        $this->assertEquals(new \DateTime('Fri, 24 Aug 2014 00:00:00 GMT'), $response->getExpires());
        $this->assertEquals(30, $response->headers->getCacheControlDirective('s-maxage'));
        $this->assertEquals(30, $response->getMaxAge());
        $this->assertEquals(['foobaz'], $response->getVary());
    }

    private function createRequest(Cache $cache = null)
    {
        return new Request([], [], [
            '_cache' => $cache,
        ]);
    }

    private function createEventMock(Request $request, Response $response)
    {
        $eventClass = class_exists(ResponseEvent::class) ? ResponseEvent::class : FilterResponseEvent::class;

        $event = $this
            ->getMockBuilder($eventClass)
            ->disableOriginalConstructor()
            ->getMock();

        $event
            ->expects($this->any())
            ->method('getRequest')
            ->willReturn($request);

        $event
            ->expects($this->any())
            ->method('getResponse')
            ->willReturn($response);

        return $event;
    }

    private function getKernel()
    {
        return $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')->getMock();
    }
}

class TestEntity
{
    public function getDate()
    {
        return new \DateTime('Fri, 23 Aug 2013 00:00:00 GMT');
    }

    public function getId()
    {
        return '12345';
    }
}
