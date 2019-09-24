<?php

class Swift_Transport_Esmtp_Auth_CramMd5AuthenticatorTest extends \SwiftMailerTestCase
{
    private $agent;

    protected function setUp()
    {
        $this->agent = $this->getMockery('Swift_Transport_SmtpAgent')->shouldIgnoreMissing();
    }

    public function testKeywordIsCramMd5()
    {
        /* -- RFC 2195, 2.
        The authentication type associated with CRAM is "CRAM-MD5".
        */

        $cram = $this->getAuthenticator();
        $this->assertEquals('CRAM-MD5', $cram->getAuthKeyword());
    }

    public function testSuccessfulAuthentication()
    {
        $cram = $this->getAuthenticator();

        $this->agent->shouldReceive('executeCommand')
             ->once()
             ->with("AUTH CRAM-MD5\r\n", [334])
             ->andReturn('334 '.base64_encode('<foo@bar>')."\r\n");
        $this->agent->shouldReceive('executeCommand')
             ->once()
             ->with(\Mockery::any(), [235]);

        $this->assertTrue($cram->authenticate($this->agent, 'jack', 'pass'),
            '%s: The buffer accepted all commands authentication should succeed'
            );
    }

    /**
     * @expectedException \Swift_TransportException
     */
    public function testAuthenticationFailureSendRset()
    {
        $cram = $this->getAuthenticator();

        $this->agent->shouldReceive('executeCommand')
             ->once()
             ->with("AUTH CRAM-MD5\r\n", [334])
             ->andReturn('334 '.base64_encode('<foo@bar>')."\r\n");
        $this->agent->shouldReceive('executeCommand')
             ->once()
             ->with(\Mockery::any(), [235])
             ->andThrow(new Swift_TransportException(''));
        $this->agent->shouldReceive('executeCommand')
             ->once()
             ->with("RSET\r\n", [250]);

        $cram->authenticate($this->agent, 'jack', 'pass');
    }

    private function getAuthenticator()
    {
        return new Swift_Transport_Esmtp_Auth_CramMd5Authenticator();
    }
}
