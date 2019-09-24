<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IsGrantedTest extends WebTestCase
{
    public function testIsGrantedNoSubject()
    {
        $client = self::createClient();
        $client->request('GET', '/is_granted/anonymous');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testIsGrantedSubjectFromAttributes()
    {
        $client = self::createClient();
        // allow_access is a special string allowed by the voter
        $client->request('GET', '/is_granted/request/attribute/args/allow_access');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testIsGrantedSubjectFromAttributesDenied()
    {
        $client = self::createClient();
        $client->request('GET', '/is_granted/request/attribute/args/no_access');

        // a redirect
        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testIsGrantedResolvesRequestArgument()
    {
        $client = self::createClient();
        $client->request('GET', '/is_granted/resolved/args');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testRequestArgumentDoesNotConflict()
    {
        $client = self::createClient();
        $client->request('GET', '/is_granted/resolved/conflict');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @requires PHP 5.6
     */
    public function testIsGrantedSubjectFromArguments()
    {
        $client = self::createClient();
        $client->request('GET', '/is_granted/variadic/args');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}
