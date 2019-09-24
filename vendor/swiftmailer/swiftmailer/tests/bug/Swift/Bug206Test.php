<?php

use Egulias\EmailValidator\EmailValidator;

class Swift_Bug206Test extends \PHPUnit\Framework\TestCase
{
    private $factory;

    protected function setUp()
    {
        $factory = new Swift_CharacterReaderFactory_SimpleCharacterReaderFactory();
        $headerEncoder = new Swift_Mime_HeaderEncoder_QpHeaderEncoder(
            new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8')
        );
        $paramEncoder = new Swift_Encoder_Rfc2231Encoder(
            new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8')
        );
        $emailValidator = new EmailValidator();
        $this->factory = new Swift_Mime_SimpleHeaderFactory($headerEncoder, $paramEncoder, $emailValidator);
    }

    public function testMailboxHeaderEncoding()
    {
        $this->doTestHeaderIsFullyEncoded('email@example.org', 'Family Name, Name', ' "Family Name, Name" <email@example.org>');
        $this->doTestHeaderIsFullyEncoded('email@example.org', 'Family Namé, Name', ' Family =?utf-8?Q?Nam=C3=A9=2C?= Name');
        $this->doTestHeaderIsFullyEncoded('email@example.org', 'Family Namé , Name', ' Family =?utf-8?Q?Nam=C3=A9_=2C?= Name');
        $this->doTestHeaderIsFullyEncoded('email@example.org', 'Family Namé ;Name', ' Family =?utf-8?Q?Nam=C3=A9_=3BName?= ');
    }

    private function doTestHeaderIsFullyEncoded($email, $name, $expected)
    {
        $mailboxHeader = $this->factory->createMailboxHeader('To', [
            $email => $name,
        ]);

        $headerBody = substr($mailboxHeader->toString(), 3, strlen($expected));

        $this->assertEquals($expected, $headerBody);
    }
}
