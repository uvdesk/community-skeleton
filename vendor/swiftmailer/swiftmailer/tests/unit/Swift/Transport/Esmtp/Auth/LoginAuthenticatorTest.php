<?php

class Swift_Transport_Esmtp_Auth_LoginAuthenticatorTest extends \SwiftMailerTestCase
{
    private $agent;

    protected function setUp()
    {
        $this->agent = $this->getMockery('Swift_Transport_SmtpAgent')->shouldIgnoreMissing();
    }

    public function testKeywordIsLogin()
    {
        $login = $this->getAuthenticator();
        $this->assertEquals('LOGIN', $login->getAuthKeyword());
    }

    public function testSuccessfulAuthentication()
    {
        $login = $this->getAuthenticator();

        $this->agent->shouldReceive('executeCommand')
             ->once()
             ->with("AUTH LOGIN\r\n", [334]);
        $this->agent->shouldReceive('executeCommand')
             ->once()
             ->with(base64_encode('jack')."\r\n", [334]);
        $this->agent->shouldReceive('executeCommand')
             ->once()
             ->with(base64_encode('pass')."\r\n", [235]);

        $this->assertTrue($login->authenticate($this->agent, 'jack', 'pass'),
            '%s: The buffer accepted all commands authentication should succeed'
            );
    }

    /**
     * @expectedException \Swift_TransportException
     */
    public function testAuthenticationFailureSendRset()
    {
        $login = $this->getAuthenticator();

        $this->agent->shouldReceive('executeCommand')
             ->once()
             ->with("AUTH LOGIN\r\n", [334]);
        $this->agent->shouldReceive('executeCommand')
             ->once()
             ->with(base64_encode('jack')."\r\n", [334]);
        $this->agent->shouldReceive('executeCommand')
             ->once()
             ->with(base64_encode('pass')."\r\n", [235])
             ->andThrow(new Swift_TransportException(''));
        $this->agent->shouldReceive('executeCommand')
             ->once()
             ->with("RSET\r\n", [250]);

        $login->authenticate($this->agent, 'jack', 'pass');
    }

    private function getAuthenticator()
    {
        return new Swift_Transport_Esmtp_Auth_LoginAuthenticator();
    }
}
