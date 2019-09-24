<?php

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class Swift_Mime_IdGeneratorTest extends \PHPUnit\Framework\TestCase
{
    protected $emailValidator;
    protected $originalServerName;

    public function testIdGeneratorSetRightId()
    {
        $idGenerator = new Swift_Mime_IdGenerator('example.net');
        $this->assertEquals('example.net', $idGenerator->getIdRight());

        $idGenerator->setIdRight('example.com');
        $this->assertEquals('example.com', $idGenerator->getIdRight());
    }

    public function testIdGenerateId()
    {
        $idGenerator = new Swift_Mime_IdGenerator('example.net');
        $emailValidator = new EmailValidator();

        $id = $idGenerator->generateId();
        $this->assertTrue($emailValidator->isValid($id, new RFCValidation()));
        $this->assertRegExp('/^.{32}@example.net$/', $id);

        $anotherId = $idGenerator->generateId();
        $this->assertNotEquals($id, $anotherId);
    }
}
