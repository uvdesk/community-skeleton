<?php

class Swift_Transport_Esmtp_AuthHandlerTest extends \SwiftMailerTestCase
{
    private $agent;

    protected function setUp()
    {
        $this->agent = $this->getMockery('Swift_Transport_SmtpAgent')->shouldIgnoreMissing();
    }

    public function testKeywordIsAuth()
    {
        $auth = $this->createHandler([]);
        $this->assertEquals('AUTH', $auth->getHandledKeyword());
    }

    public function testUsernameCanBeSetAndFetched()
    {
        $auth = $this->createHandler([]);
        $auth->setUsername('jack');
        $this->assertEquals('jack', $auth->getUsername());
    }

    public function testPasswordCanBeSetAndFetched()
    {
        $auth = $this->createHandler([]);
        $auth->setPassword('pass');
        $this->assertEquals('pass', $auth->getPassword());
    }

    public function testAuthModeCanBeSetAndFetched()
    {
        $auth = $this->createHandler([]);
        $auth->setAuthMode('PLAIN');
        $this->assertEquals('PLAIN', $auth->getAuthMode());
    }

    public function testMixinMethods()
    {
        $auth = $this->createHandler([]);
        $mixins = $auth->exposeMixinMethods();
        $this->assertTrue(in_array('getUsername', $mixins),
            '%s: getUsername() should be accessible via mixin'
            );
        $this->assertTrue(in_array('setUsername', $mixins),
            '%s: setUsername() should be accessible via mixin'
            );
        $this->assertTrue(in_array('getPassword', $mixins),
            '%s: getPassword() should be accessible via mixin'
            );
        $this->assertTrue(in_array('setPassword', $mixins),
            '%s: setPassword() should be accessible via mixin'
            );
        $this->assertTrue(in_array('setAuthMode', $mixins),
            '%s: setAuthMode() should be accessible via mixin'
            );
        $this->assertTrue(in_array('getAuthMode', $mixins),
            '%s: getAuthMode() should be accessible via mixin'
            );
    }

    public function testAuthenticatorsAreCalledAccordingToParamsAfterEhlo()
    {
        $a1 = $this->createMockAuthenticator('PLAIN');
        $a2 = $this->createMockAuthenticator('LOGIN');

        $a1->shouldReceive('authenticate')
           ->never()
           ->with($this->agent, 'jack', 'pass');
        $a2->shouldReceive('authenticate')
           ->once()
           ->with($this->agent, 'jack', 'pass')
           ->andReturn(true);

        $auth = $this->createHandler([$a1, $a2]);
        $auth->setUsername('jack');
        $auth->setPassword('pass');

        $auth->setKeywordParams(['CRAM-MD5', 'LOGIN']);
        $auth->afterEhlo($this->agent);
    }

    public function testAuthenticatorsAreNotUsedIfNoUsernameSet()
    {
        $a1 = $this->createMockAuthenticator('PLAIN');
        $a2 = $this->createMockAuthenticator('LOGIN');

        $a1->shouldReceive('authenticate')
           ->never()
           ->with($this->agent, 'jack', 'pass');
        $a2->shouldReceive('authenticate')
           ->never()
           ->with($this->agent, 'jack', 'pass')
           ->andReturn(true);

        $auth = $this->createHandler([$a1, $a2]);

        $auth->setKeywordParams(['CRAM-MD5', 'LOGIN']);
        $auth->afterEhlo($this->agent);
    }

    public function testSeveralAuthenticatorsAreTriedIfNeeded()
    {
        $a1 = $this->createMockAuthenticator('PLAIN');
        $a2 = $this->createMockAuthenticator('LOGIN');

        $a1->shouldReceive('authenticate')
           ->once()
           ->with($this->agent, 'jack', 'pass')
           ->andReturn(false);
        $a2->shouldReceive('authenticate')
           ->once()
           ->with($this->agent, 'jack', 'pass')
           ->andReturn(true);

        $auth = $this->createHandler([$a1, $a2]);
        $auth->setUsername('jack');
        $auth->setPassword('pass');

        $auth->setKeywordParams(['PLAIN', 'LOGIN']);
        $auth->afterEhlo($this->agent);
    }

    public function testFirstAuthenticatorToPassBreaksChain()
    {
        $a1 = $this->createMockAuthenticator('PLAIN');
        $a2 = $this->createMockAuthenticator('LOGIN');
        $a3 = $this->createMockAuthenticator('CRAM-MD5');

        $a1->shouldReceive('authenticate')
           ->once()
           ->with($this->agent, 'jack', 'pass')
           ->andReturn(false);
        $a2->shouldReceive('authenticate')
           ->once()
           ->with($this->agent, 'jack', 'pass')
           ->andReturn(true);
        $a3->shouldReceive('authenticate')
           ->never()
           ->with($this->agent, 'jack', 'pass');

        $auth = $this->createHandler([$a1, $a2]);
        $auth->setUsername('jack');
        $auth->setPassword('pass');

        $auth->setKeywordParams(['PLAIN', 'LOGIN', 'CRAM-MD5']);
        $auth->afterEhlo($this->agent);
    }

    private function createHandler($authenticators)
    {
        return new Swift_Transport_Esmtp_AuthHandler($authenticators);
    }

    private function createMockAuthenticator($type)
    {
        $authenticator = $this->getMockery('Swift_Transport_Esmtp_Authenticator')->shouldIgnoreMissing();
        $authenticator->shouldReceive('getAuthKeyword')
                      ->zeroOrMoreTimes()
                      ->andReturn($type);

        return $authenticator;
    }
}
