<?php


class Swift_Mime_MimePartTest extends Swift_Mime_AbstractMimeEntityTest
{
    public function testNestingLevelIsSubpart()
    {
        $part = $this->createMimePart($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $this->assertEquals(
            Swift_Mime_SimpleMimeEntity::LEVEL_ALTERNATIVE, $part->getNestingLevel()
            );
    }

    public function testCharsetIsReturnedFromHeader()
    {
        /* -- RFC 2046, 4.1.2.
        A critical parameter that may be specified in the Content-Type field
        for "text/plain" data is the character set.  This is specified with a
        "charset" parameter, as in:

     Content-type: text/plain; charset=iso-8859-1

        Unlike some other parameter values, the values of the charset
        parameter are NOT case sensitive.  The default character set, which
        must be assumed in the absence of a charset parameter, is US-ASCII.
        */

        $cType = $this->createHeader('Content-Type', 'text/plain',
            ['charset' => 'iso-8859-1']
            );
        $part = $this->createMimePart($this->createHeaderSet([
            'Content-Type' => $cType, ]),
            $this->createEncoder(), $this->createCache()
            );
        $this->assertEquals('iso-8859-1', $part->getCharset());
    }

    public function testCharsetIsSetInHeader()
    {
        $cType = $this->createHeader('Content-Type', 'text/plain',
            ['charset' => 'iso-8859-1'], false
            );
        $cType->shouldReceive('setParameter')->once()->with('charset', 'utf-8');

        $part = $this->createMimePart($this->createHeaderSet([
            'Content-Type' => $cType, ]),
            $this->createEncoder(), $this->createCache()
            );
        $part->setCharset('utf-8');
    }

    public function testCharsetIsSetInHeaderIfPassedToSetBody()
    {
        $cType = $this->createHeader('Content-Type', 'text/plain',
            ['charset' => 'iso-8859-1'], false
            );
        $cType->shouldReceive('setParameter')->once()->with('charset', 'utf-8');

        $part = $this->createMimePart($this->createHeaderSet([
            'Content-Type' => $cType, ]),
            $this->createEncoder(), $this->createCache()
            );
        $part->setBody('', 'text/plian', 'utf-8');
    }

    public function testSettingCharsetNotifiesEncoder()
    {
        $encoder = $this->createEncoder('quoted-printable', false);
        $encoder->expects($this->once())
                ->method('charsetChanged')
                ->with('utf-8');

        $part = $this->createMimePart($this->createHeaderSet(),
            $encoder, $this->createCache()
            );
        $part->setCharset('utf-8');
    }

    public function testSettingCharsetNotifiesHeaders()
    {
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('charsetChanged')
                ->zeroOrMoreTimes()
                ->with('utf-8');

        $part = $this->createMimePart($headers, $this->createEncoder(),
            $this->createCache()
            );
        $part->setCharset('utf-8');
    }

    public function testSettingCharsetNotifiesChildren()
    {
        $child = $this->createChild(0, '', false);
        $child->shouldReceive('charsetChanged')
              ->once()
              ->with('windows-874');

        $part = $this->createMimePart($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $part->setChildren([$child]);
        $part->setCharset('windows-874');
    }

    public function testCharsetChangeUpdatesCharset()
    {
        $cType = $this->createHeader('Content-Type', 'text/plain',
            ['charset' => 'iso-8859-1'], false
            );
        $cType->shouldReceive('setParameter')->once()->with('charset', 'utf-8');

        $part = $this->createMimePart($this->createHeaderSet([
            'Content-Type' => $cType, ]),
            $this->createEncoder(), $this->createCache()
            );
        $part->charsetChanged('utf-8');
    }

    public function testSettingCharsetClearsCache()
    {
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('toString')
                ->zeroOrMoreTimes()
                ->andReturn("Content-Type: text/plain; charset=utf-8\r\n");

        $cache = $this->createCache(false);

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $cache
            );

        $entity->setBody("blah\r\nblah!");
        $entity->toString();

        // Initialize the expectation here because we only care about what happens in setCharset()
        $cache->shouldReceive('clearKey')
                ->once()
                ->with(\Mockery::any(), 'body');

        $entity->setCharset('iso-2022');
    }

    public function testFormatIsReturnedFromHeader()
    {
        /* -- RFC 3676.
     */

        $cType = $this->createHeader('Content-Type', 'text/plain',
            ['format' => 'flowed']
            );
        $part = $this->createMimePart($this->createHeaderSet([
            'Content-Type' => $cType, ]),
            $this->createEncoder(), $this->createCache()
            );
        $this->assertEquals('flowed', $part->getFormat());
    }

    public function testFormatIsSetInHeader()
    {
        $cType = $this->createHeader('Content-Type', 'text/plain', [], false);
        $cType->shouldReceive('setParameter')->once()->with('format', 'fixed');

        $part = $this->createMimePart($this->createHeaderSet([
            'Content-Type' => $cType, ]),
            $this->createEncoder(), $this->createCache()
            );
        $part->setFormat('fixed');
    }

    public function testDelSpIsReturnedFromHeader()
    {
        /* -- RFC 3676.
     */

        $cType = $this->createHeader('Content-Type', 'text/plain',
            ['delsp' => 'no']
            );
        $part = $this->createMimePart($this->createHeaderSet([
            'Content-Type' => $cType, ]),
            $this->createEncoder(), $this->createCache()
            );
        $this->assertFalse($part->getDelSp());
    }

    public function testDelSpIsSetInHeader()
    {
        $cType = $this->createHeader('Content-Type', 'text/plain', [], false);
        $cType->shouldReceive('setParameter')->once()->with('delsp', 'yes');

        $part = $this->createMimePart($this->createHeaderSet([
            'Content-Type' => $cType, ]),
            $this->createEncoder(), $this->createCache()
            );
        $part->setDelSp(true);
    }

    public function testFluidInterface()
    {
        $part = $this->createMimePart($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );

        $this->assertSame($part,
            $part
            ->setContentType('text/plain')
            ->setEncoder($this->createEncoder())
            ->setId('foo@bar')
            ->setDescription('my description')
            ->setMaxLineLength(998)
            ->setBody('xx')
            ->setBoundary('xyz')
            ->setChildren([])
            ->setCharset('utf-8')
            ->setFormat('flowed')
            ->setDelSp(true)
            );
    }

    //abstract
    protected function createEntity($headers, $encoder, $cache)
    {
        return $this->createMimePart($headers, $encoder, $cache);
    }

    protected function createMimePart($headers, $encoder, $cache)
    {
        $idGenerator = new Swift_Mime_IdGenerator('example.com');

        return new Swift_Mime_MimePart($headers, $encoder, $cache, $idGenerator);
    }
}
