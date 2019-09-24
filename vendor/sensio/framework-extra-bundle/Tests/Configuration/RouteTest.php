<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensio\Bundle\FrameworkExtraBundle\Tests\Configuration;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @author Iltar van der Berg <ivanderberg@hostnet.nl>
 *
 * @group legacy
 */
class RouteTest extends \PHPUnit\Framework\TestCase
{
    public function testSetServiceWithoutPath()
    {
        $route = new Route([]);
        $this->assertNull($route->getPath());
        $this->assertNull($route->getService());

        $route->setService('app.test');

        $this->assertSame('', $route->getPath());
        $this->assertSame('app.test', $route->getService());
    }

    public function testSetServiceWithPath()
    {
        $route = new Route([]);
        $this->assertNull($route->getPath());
        $this->assertNull($route->getService());

        $route->setPath('/test/');
        $route->setService('app.test');

        $this->assertSame('/test/', $route->getPath());
        $this->assertSame('app.test', $route->getService());
    }

    public function testSettersViaConstruct()
    {
        $route = new Route(['service' => 'app.test']);
        $this->assertSame('', $route->getPath());
        $this->assertSame('app.test', $route->getService());

        $route = new Route(['service' => 'app.test', 'path' => '/test/']);
        $this->assertSame('/test/', $route->getPath());
        $this->assertSame('app.test', $route->getService());
    }
}
