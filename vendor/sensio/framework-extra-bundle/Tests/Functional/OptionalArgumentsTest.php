<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OptionalArgumentsTest extends WebTestCase
{
    public function testArgumentWithDefaultFollowedByMandatoryIsOptional()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/optional-arguments/with-default-followed-by-mandatory');

        $this->assertSame('yes', $crawler->text());
    }
}
