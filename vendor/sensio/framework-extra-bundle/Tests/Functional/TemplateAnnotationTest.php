<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class TemplateAnnotationTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testController($url, $checkHtml)
    {
        $client = self::createClient();
        $crawler = $client->request('GET', $url);

        $this->assertEquals($checkHtml, $crawler->filterXPath('//body')->html());
    }

    public static function urlProvider()
    {
        return [
            ['/multi/one-template/1/', 'bar'],
            ['/multi/one-template/2/', 'bar'],
            ['/multi/one-template/3/', 'bar'],
            ['/multi/one-template/4/', 'foo bar baz'],
            ['/invokable/predefined/service/', 'bar'],
            ['/invokable/class-level/service/', 'bar'],
            ['/simple/multiple/', 'a, b, c'],
            ['/simple/multiple/henk/bar/', 'henk, bar, c'],
            ['/simple/multiple-with-vars/', 'a, b'],
            ['/invokable/predefined/container/', 'bar'],
            ['/invokable/variable/container/the-var/', 'the-var'],
            ['/invokable/another-variable/container/another-var/', 'another-var'],
            ['/invokable/variable/container/the-var/another-var/', 'the-var,another-var'],
            ['/no-listener/', 'I did not get rendered via twig'],
        ];
    }

    public function testStreamedControllerResponse()
    {
        $uri = '/streamed/';

        ob_start();
        $client = self::createClient();
        $client->request('GET', $uri);

        $crawler = new Crawler(null, $uri);
        $crawler->addContent(ob_get_clean());

        $this->assertEquals('foo, bar', $crawler->filterXPath('//body')->html());
    }
}
