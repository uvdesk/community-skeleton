<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @requires PHP 7.1
 */
class NullableAnnotationTest extends WebTestCase
{
    public function testMissingRequiredArgumentWillResultWithError()
    {
        $client = self::createClient();
        $client->request('GET', '/nullable-arguments/without-default');

        $this->assertSame(500, $client->getResponse()->getStatusCode());
    }

    public function testArgumentWithDefaultIsOptional()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/nullable-arguments/with-default');

        $this->assertSame('yes', $crawler->text());
    }

    public function testNullableArgumentIsOptional()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/nullable-arguments/nullable');

        $this->assertSame('yes', $crawler->text());
    }
}
