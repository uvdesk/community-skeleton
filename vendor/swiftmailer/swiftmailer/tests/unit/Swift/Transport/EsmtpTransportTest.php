<?php

class Swift_Transport_EsmtpTransportTest extends Swift_Transport_AbstractSmtpEventSupportTest
{
    protected function getTransport($buf, $dispatcher = null, $addressEncoder = null)
    {
        $dispatcher = $dispatcher ?? $this->createEventDispatcher();
        $addressEncoder = $addressEncoder ?? new Swift_AddressEncoder_IdnAddressEncoder();

        return new Swift_Transport_EsmtpTransport($buf, [], $dispatcher, 'example.org', $addressEncoder);
    }

    public function testHostCanBeSetAndFetched()
    {
        $buf = $this->getBuffer();
        $smtp = $this->getTransport($buf);
        $smtp->setHost('foo');
        $this->assertEquals('foo', $smtp->getHost(), '%s: Host should be returned');
    }

    public function testPortCanBeSetAndFetched()
    {
        $buf = $this->getBuffer();
        $smtp = $this->getTransport($buf);
        $smtp->setPort(25);
        $this->assertEquals(25, $smtp->getPort(), '%s: Port should be returned');
    }

    public function testTimeoutCanBeSetAndFetched()
    {
        $buf = $this->getBuffer();
        $buf->shouldReceive('setParam')
            ->once()
            ->with('timeout', 10);

        $smtp = $this->getTransport($buf);
        $smtp->setTimeout(10);
        $this->assertEquals(10, $smtp->getTimeout(), '%s: Timeout should be returned');
    }

    public function testEncryptionCanBeSetAndFetched()
    {
        $buf = $this->getBuffer();
        $smtp = $this->getTransport($buf);
        $smtp->setEncryption('tls');
        $this->assertEquals('tls', $smtp->getEncryption(), '%s: Crypto should be returned');
    }

    public function testStartSendsHeloToInitiate()
    {
        // previous loop would fail if there is an issue
        $this->addToAssertionCount(1);
    }

    public function testStartSendsEhloToInitiate()
    {
        /* -- RFC 2821, 3.2.

            3.2 Client Initiation

         Once the server has sent the welcoming message and the client has
         received it, the client normally sends the EHLO command to the
         server, indicating the client's identity.  In addition to opening the
         session, use of EHLO indicates that the client is able to process
         service extensions and requests that the server provide a list of the
         extensions it supports.  Older SMTP systems which are unable to
         support service extensions and contemporary clients which do not
         require service extensions in the mail session being initiated, MAY
         use HELO instead of EHLO.  Servers MUST NOT return the extended
         EHLO-style response to a HELO command.  For a particular connection
         attempt, if the server returns a "command not recognized" response to
         EHLO, the client SHOULD be able to fall back and send HELO.

         In the EHLO command the host sending the command identifies itself;
         the command may be interpreted as saying "Hello, I am <domain>" (and,
         in the case of EHLO, "and I support service extension requests").

       -- RFC 2281, 4.1.1.1.

       ehlo            = "EHLO" SP Domain CRLF
       helo            = "HELO" SP Domain CRLF

       -- RFC 2821, 4.3.2.

       EHLO or HELO
           S: 250
           E: 504, 550

     */

        $buf = $this->getBuffer();
        $smtp = $this->getTransport($buf);

        $buf->shouldReceive('initialize')
            ->once();
        $buf->shouldReceive('readLine')
            ->once()
            ->with(0)
            ->andReturn("220 some.server.tld bleh\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with('~^EHLO .+?\r\n$~D')
            ->andReturn(1);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn('250 ServerName'."\r\n");

        $this->finishBuffer($buf);
        try {
            $smtp->start();
        } catch (Exception $e) {
            $this->fail('Starting Esmtp should send EHLO and accept 250 response: '.$e->getMessage());
        }
    }

    public function testHeloIsUsedAsFallback()
    {
        /* -- RFC 2821, 4.1.4.

       If the EHLO command is not acceptable to the SMTP server, 501, 500,
       or 502 failure replies MUST be returned as appropriate.  The SMTP
       server MUST stay in the same state after transmitting these replies
       that it was in before the EHLO was received.
        */

        $buf = $this->getBuffer();
        $smtp = $this->getTransport($buf);

        $buf->shouldReceive('initialize')
            ->once();
        $buf->shouldReceive('readLine')
            ->once()
            ->with(0)
            ->andReturn("220 some.server.tld bleh\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with('~^EHLO .+?\r\n$~D')
            ->andReturn(1);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn('501 WTF'."\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with('~^HELO .+?\r\n$~D')
            ->andReturn(2);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(2)
            ->andReturn('250 HELO'."\r\n");

        $this->finishBuffer($buf);
        try {
            $smtp->start();
        } catch (Exception $e) {
            $this->fail(
                'Starting Esmtp should fallback to HELO if needed and accept 250 response'
                );
        }
    }

    public function testInvalidHeloResponseCausesException()
    {
        //Overridden to first try EHLO
        $buf = $this->getBuffer();
        $smtp = $this->getTransport($buf);

        $buf->shouldReceive('initialize')
            ->once();
        $buf->shouldReceive('readLine')
            ->once()
            ->with(0)
            ->andReturn("220 some.server.tld bleh\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with('~^EHLO .+?\r\n$~D')
            ->andReturn(1);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn('501 WTF'."\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with('~^HELO .+?\r\n$~D')
            ->andReturn(2);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(2)
            ->andReturn('504 WTF'."\r\n");
        $this->finishBuffer($buf);

        try {
            $this->assertFalse($smtp->isStarted(), '%s: SMTP should begin non-started');
            $smtp->start();
            $this->fail('Non 250 HELO response should raise Exception');
        } catch (Exception $e) {
            $this->assertFalse($smtp->isStarted(), '%s: SMTP start() should have failed');
        }
    }

    public function testDomainNameIsPlacedInEhlo()
    {
        /* -- RFC 2821, 4.1.4.

       The SMTP client MUST, if possible, ensure that the domain parameter
       to the EHLO command is a valid principal host name (not a CNAME or MX
       name) for its host.  If this is not possible (e.g., when the client's
       address is dynamically assigned and the client does not have an
       obvious name), an address literal SHOULD be substituted for the
       domain name and supplemental information provided that will assist in
       identifying the client.
        */

        $buf = $this->getBuffer();
        $smtp = $this->getTransport($buf);
        $buf->shouldReceive('initialize')
            ->once();
        $buf->shouldReceive('readLine')
            ->once()
            ->with(0)
            ->andReturn("220 some.server.tld bleh\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with("EHLO mydomain.com\r\n")
            ->andReturn(1);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn('250 ServerName'."\r\n");

        $this->finishBuffer($buf);
        $smtp->setLocalDomain('mydomain.com');
        $smtp->start();
    }

    public function testDomainNameIsPlacedInHelo()
    {
        //Overridden to include ESMTP
        /* -- RFC 2821, 4.1.4.

       The SMTP client MUST, if possible, ensure that the domain parameter
       to the EHLO command is a valid principal host name (not a CNAME or MX
       name) for its host.  If this is not possible (e.g., when the client's
       address is dynamically assigned and the client does not have an
       obvious name), an address literal SHOULD be substituted for the
       domain name and supplemental information provided that will assist in
       identifying the client.
        */

        $buf = $this->getBuffer();
        $smtp = $this->getTransport($buf);
        $buf->shouldReceive('initialize')
            ->once();
        $buf->shouldReceive('readLine')
            ->once()
            ->with(0)
            ->andReturn("220 some.server.tld bleh\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with('~^EHLO .+?\r\n$~D')
            ->andReturn(1);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn('501 WTF'."\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with("HELO mydomain.com\r\n")
            ->andReturn(2);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(2)
            ->andReturn('250 ServerName'."\r\n");

        $this->finishBuffer($buf);
        $smtp->setLocalDomain('mydomain.com');
        $smtp->start();
    }

    public function testPipelining()
    {
        $buf = $this->getBuffer();
        $smtp = $this->getTransport($buf);
        $this->assertNull($smtp->getPipelining());

        $message = $this->createMessage();
        $message->shouldReceive('getFrom')
                ->zeroOrMoreTimes()
                ->andReturn(['me@domain.com' => 'Me']);
        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn(['foo@bar' => null]);

        $buf->shouldReceive('initialize')
            ->once();
        $buf->shouldReceive('readLine')
            ->once()
            ->with(0)
            ->andReturn("220 some.server.tld bleh\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with('~^EHLO .+?\r\n$~D')
            ->andReturn(1);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn('250-ServerName'."\r\n");
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn('250 PIPELINING'."\r\n");

        $buf->shouldReceive('write')
            ->ordered()
            ->once()
            ->with("MAIL FROM:<me@domain.com>\r\n")
            ->andReturn(1);
        $buf->shouldReceive('write')
            ->ordered()
            ->once()
            ->with("RCPT TO:<foo@bar>\r\n")
            ->andReturn(2);
        $buf->shouldReceive('write')
            ->ordered()
            ->once()
            ->with("DATA\r\n")->andReturn(3);
        $buf->shouldReceive('readLine')
            ->ordered()
            ->once()
            ->with(1)->andReturn("250 OK\r\n");
        $buf->shouldReceive('readLine')
            ->ordered()
            ->once()
            ->with(2)->andReturn("250 OK\r\n");
        $buf->shouldReceive('readLine')
            ->ordered()
            ->once()
            ->with(3)->andReturn("354 OK\r\n");

        $this->finishBuffer($buf);
        $smtp->start();
        $sent = $smtp->send($message, $failedRecipients);

        $this->assertEquals(1, $sent);
        $this->assertEmpty($failedRecipients);

        $this->assertTrue($smtp->getPipelining());
    }

    public function testPipeliningWithRecipientFailure()
    {
        $buf = $this->getBuffer();
        $smtp = $this->getTransport($buf);
        $this->assertNull($smtp->getPipelining());

        $message = $this->createMessage();
        $message->shouldReceive('getFrom')
                ->zeroOrMoreTimes()
                ->andReturn(['me@domain.com' => 'Me']);
        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn([
                    'good@foo' => null,
                    'bad@foo' => null,
                    'good@bar' => null,
                ]);

        $buf->shouldReceive('initialize')
            ->once();
        $buf->shouldReceive('readLine')
            ->once()
            ->with(0)
            ->andReturn("220 some.server.tld bleh\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with('~^EHLO .+?\r\n$~D')
            ->andReturn(1);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn('250-ServerName'."\r\n");
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn('250 PIPELINING'."\r\n");

        $buf->shouldReceive('write')
            ->ordered()
            ->once()
            ->with("MAIL FROM:<me@domain.com>\r\n")
            ->andReturn(1);
        $buf->shouldReceive('write')
            ->ordered()
            ->once()
            ->with("RCPT TO:<good@foo>\r\n")
            ->andReturn(2);
        $buf->shouldReceive('write')
            ->ordered()
            ->once()
            ->with("RCPT TO:<bad@foo>\r\n")
            ->andReturn(3);
        $buf->shouldReceive('write')
            ->ordered()
            ->once()
            ->with("RCPT TO:<good@bar>\r\n")
            ->andReturn(4);
        $buf->shouldReceive('write')
            ->ordered()
            ->once()
            ->with("DATA\r\n")
            ->andReturn(5);
        $buf->shouldReceive('readLine')
            ->ordered()
            ->once()
            ->with(1)
            ->andReturn("250 OK\r\n");
        $buf->shouldReceive('readLine')
            ->ordered()
            ->once()
            ->with(2)
            ->andReturn("250 OK\r\n");
        $buf->shouldReceive('readLine')
            ->ordered()
            ->once()
            ->with(3)
            ->andReturn("450 Unknown address bad@foo\r\n");
        $buf->shouldReceive('readLine')
            ->ordered()
            ->once()
            ->with(4)
            ->andReturn("250 OK\r\n");
        $buf->shouldReceive('readLine')
            ->ordered()
            ->once()
            ->with(5)
            ->andReturn("354 OK\r\n");

        $this->finishBuffer($buf);
        $smtp->start();
        $sent = $smtp->send($message, $failedRecipients);

        $this->assertEquals(2, $sent);
        $this->assertEquals(['bad@foo'], $failedRecipients);

        $this->assertTrue($smtp->getPipelining());
    }

    public function testPipeliningWithSenderFailure()
    {
        $buf = $this->getBuffer();
        $smtp = $this->getTransport($buf);
        $this->assertNull($smtp->getPipelining());

        $message = $this->createMessage();
        $message->shouldReceive('getFrom')
                ->zeroOrMoreTimes()
                ->andReturn(['me@domain.com' => 'Me']);
        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn(['foo@bar' => null]);

        $buf->shouldReceive('initialize')
            ->once();
        $buf->shouldReceive('readLine')
            ->once()
            ->with(0)
            ->andReturn("220 some.server.tld bleh\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with('~^EHLO .+?\r\n$~D')
            ->andReturn(1);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn('250-ServerName'."\r\n");
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn('250 PIPELINING'."\r\n");

        $buf->shouldReceive('write')
            ->ordered()
            ->once()
            ->with("MAIL FROM:<me@domain.com>\r\n")
            ->andReturn(1);
        $buf->shouldReceive('write')
            ->ordered()
            ->once()
            ->with("RCPT TO:<foo@bar>\r\n")
            ->andReturn(2);
        $buf->shouldReceive('write')
            ->ordered()
            ->once()
            ->with("DATA\r\n")->andReturn(3);
        $buf->shouldReceive('readLine')
            ->ordered()
            ->once()
            ->with(1)
            ->andReturn("550 Unknown address me@domain.com\r\n");

        $smtp->start();

        $this->expectException('Swift_TransportException');
        $this->expectExceptionMessage('Expected response code 250 but got code "550"');
        $smtp->send($message, $failedRecipients);
    }

    public function testPipeliningWithDataFailure()
    {
        $buf = $this->getBuffer();
        $smtp = $this->getTransport($buf);
        $this->assertNull($smtp->getPipelining());

        $message = $this->createMessage();
        $message->shouldReceive('getFrom')
                ->zeroOrMoreTimes()
                ->andReturn(['me@domain.com' => 'Me']);
        $message->shouldReceive('getTo')
                ->zeroOrMoreTimes()
                ->andReturn(['foo@bar' => null]);

        $buf->shouldReceive('initialize')
            ->once();
        $buf->shouldReceive('readLine')
            ->once()
            ->with(0)
            ->andReturn("220 some.server.tld bleh\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with('~^EHLO .+?\r\n$~D')
            ->andReturn(1);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn('250-ServerName'."\r\n");
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn('250 PIPELINING'."\r\n");

        $buf->shouldReceive('write')
            ->ordered()
            ->once()
            ->with("MAIL FROM:<me@domain.com>\r\n")
            ->andReturn(1);
        $buf->shouldReceive('write')
            ->ordered()
            ->once()
            ->with("RCPT TO:<foo@bar>\r\n")
            ->andReturn(2);
        $buf->shouldReceive('write')
            ->ordered()
            ->once()
            ->with("DATA\r\n")->andReturn(3);
        $buf->shouldReceive('readLine')
            ->ordered()
            ->once()
            ->with(1)
            ->andReturn("250 OK\r\n");
        $buf->shouldReceive('readLine')
            ->ordered()
            ->once()
            ->with(2)
            ->andReturn("250 OK\r\n");
        $buf->shouldReceive('readLine')
            ->ordered()
            ->once()
            ->with(3)
            ->andReturn("452 Insufficient system storage\r\n");

        $smtp->start();

        $this->expectException('Swift_TransportException');
        $this->expectExceptionMessage('Expected response code 354 but got code "452"');
        $smtp->send($message, $failedRecipients);
    }

    public function providerPipeliningOverride()
    {
        return [
            [null, true, true],
            [null, false, false],
            [true, false, true],
            [true, true, true],
            [false, false, false],
            [false, true, false],
        ];
    }

    /**
     * @dataProvider providerPipeliningOverride
     */
    public function testPipeliningOverride($enabled, bool $supported, bool $expected)
    {
        $buf = $this->getBuffer();
        $smtp = $this->getTransport($buf);
        $this->assertNull($smtp->getPipelining());

        $smtp->setPipelining($enabled);
        $this->assertSame($enabled, $smtp->getPipelining());

        $message = $this->createMessage();
        $message->shouldReceive('getFrom')
                ->zeroOrMoreTimes()
                ->andReturn(['me@domain.com' => 'Me']);

        $buf->shouldReceive('initialize')
            ->once();
        $buf->shouldReceive('readLine')
            ->once()
            ->with(0)
            ->andReturn("220 some.server.tld bleh\r\n");
        $buf->shouldReceive('write')
            ->once()
            ->with('~^EHLO .+?\r\n$~D')
            ->andReturn(1);
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn('250-ServerName'."\r\n");
        $buf->shouldReceive('readLine')
            ->once()
            ->with(1)
            ->andReturn('250 '.($supported ? 'PIPELINING' : 'FOOBAR')."\r\n");

        $this->finishBuffer($buf);
        $smtp->start();
        $smtp->send($message);

        $this->assertSame($expected, $smtp->getPipelining());
    }

    public function testFluidInterface()
    {
        $buf = $this->getBuffer();
        $smtp = $this->getTransport($buf);
        $buf->shouldReceive('setParam')
            ->once()
            ->with('timeout', 30);

        $ref = $smtp
            ->setHost('foo')
            ->setPort(25)
            ->setEncryption('tls')
            ->setTimeout(30)
            ->setPipelining(false)
            ;
        $this->assertEquals($ref, $smtp);
    }
}
