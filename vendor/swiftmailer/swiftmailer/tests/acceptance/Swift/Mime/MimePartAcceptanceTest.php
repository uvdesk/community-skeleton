<?php

use Egulias\EmailValidator\EmailValidator;

class Swift_Mime_MimePartAcceptanceTest extends \PHPUnit\Framework\TestCase
{
    private $contentEncoder;
    private $cache;
    private $headers;
    private $emailValidator;

    protected function setUp()
    {
        $this->cache = new Swift_KeyCache_ArrayKeyCache(
            new Swift_KeyCache_SimpleKeyCacheInputStream()
            );
        $factory = new Swift_CharacterReaderFactory_SimpleCharacterReaderFactory();
        $this->contentEncoder = new Swift_Mime_ContentEncoder_QpContentEncoder(
            new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8'),
            new Swift_StreamFilters_ByteArrayReplacementFilter(
                [[0x0D, 0x0A], [0x0D], [0x0A]],
                [[0x0A], [0x0A], [0x0D, 0x0A]]
                )
            );

        $headerEncoder = new Swift_Mime_HeaderEncoder_QpHeaderEncoder(
            new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8')
            );
        $paramEncoder = new Swift_Encoder_Rfc2231Encoder(
            new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8')
            );
        $this->emailValidator = new EmailValidator();
        $this->idGenerator = new Swift_Mime_IdGenerator('example.com');
        $this->headers = new Swift_Mime_SimpleHeaderSet(
            new Swift_Mime_SimpleHeaderFactory($headerEncoder, $paramEncoder, $this->emailValidator)
            );
    }

    public function testCharsetIsSetInHeader()
    {
        $part = $this->createMimePart();
        $part->setContentType('text/plain');
        $part->setCharset('utf-8');
        $part->setBody('foobar');
        $this->assertEquals(
            'Content-Type: text/plain; charset=utf-8'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'foobar',
            $part->toString()
            );
    }

    public function testFormatIsSetInHeaders()
    {
        $part = $this->createMimePart();
        $part->setContentType('text/plain');
        $part->setFormat('flowed');
        $part->setBody('> foobar');
        $this->assertEquals(
            'Content-Type: text/plain; format=flowed'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            '> foobar',
            $part->toString()
            );
    }

    public function testDelSpIsSetInHeaders()
    {
        $part = $this->createMimePart();
        $part->setContentType('text/plain');
        $part->setDelSp(true);
        $part->setBody('foobar');
        $this->assertEquals(
            'Content-Type: text/plain; delsp=yes'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'foobar',
            $part->toString()
            );
    }

    public function testAll3ParamsInHeaders()
    {
        $part = $this->createMimePart();
        $part->setContentType('text/plain');
        $part->setCharset('utf-8');
        $part->setFormat('fixed');
        $part->setDelSp(true);
        $part->setBody('foobar');
        $this->assertEquals(
            'Content-Type: text/plain; charset=utf-8; format=fixed; delsp=yes'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'foobar',
            $part->toString()
            );
    }

    public function testBodyIsCanonicalized()
    {
        $part = $this->createMimePart();
        $part->setContentType('text/plain');
        $part->setCharset('utf-8');
        $part->setBody("foobar\r\rtest\ning\r");
        $this->assertEquals(
            'Content-Type: text/plain; charset=utf-8'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            "foobar\r\n".
            "\r\n".
            "test\r\n".
            "ing\r\n",
            $part->toString()
            );
    }

    protected function createMimePart()
    {
        $entity = new Swift_Mime_MimePart(
            $this->headers,
            $this->contentEncoder,
            $this->cache,
            $this->idGenerator
        );

        return $entity;
    }
}
