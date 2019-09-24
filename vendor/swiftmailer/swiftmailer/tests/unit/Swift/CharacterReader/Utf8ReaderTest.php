<?php

class Swift_CharacterReader_Utf8ReaderTest extends \PHPUnit\Framework\TestCase
{
    private $reader;

    protected function setUp()
    {
        $this->reader = new Swift_CharacterReader_Utf8Reader();
    }

    public function testLeading7BitOctetCausesReturnZero()
    {
        for ($ordinal = 0x00; $ordinal <= 0x7F; ++$ordinal) {
            $this->assertSame(
                0, $this->reader->validateByteSequence([$ordinal], 1)
                );
        }
    }

    public function testLeadingByteOf2OctetCharCausesReturn1()
    {
        for ($octet = 0xC0; $octet <= 0xDF; ++$octet) {
            $this->assertSame(
                1, $this->reader->validateByteSequence([$octet], 1)
                );
        }
    }

    public function testLeadingByteOf3OctetCharCausesReturn2()
    {
        for ($octet = 0xE0; $octet <= 0xEF; ++$octet) {
            $this->assertSame(
                2, $this->reader->validateByteSequence([$octet], 1)
                );
        }
    }

    public function testLeadingByteOf4OctetCharCausesReturn3()
    {
        for ($octet = 0xF0; $octet <= 0xF7; ++$octet) {
            $this->assertSame(
                3, $this->reader->validateByteSequence([$octet], 1)
                );
        }
    }

    public function testLeadingByteOf5OctetCharCausesReturn4()
    {
        for ($octet = 0xF8; $octet <= 0xFB; ++$octet) {
            $this->assertSame(
                4, $this->reader->validateByteSequence([$octet], 1)
                );
        }
    }

    public function testLeadingByteOf6OctetCharCausesReturn5()
    {
        for ($octet = 0xFC; $octet <= 0xFD; ++$octet) {
            $this->assertSame(
                5, $this->reader->validateByteSequence([$octet], 1)
                );
        }
    }
}
