<?php

class Swift_Mime_Headers_DateHeaderTest extends \PHPUnit\Framework\TestCase
{
    /* --
    The following tests refer to RFC 2822, section 3.6.1 and 3.3.
    */

    public function testTypeIsDateHeader()
    {
        $header = $this->getHeader('Date');
        $this->assertEquals(Swift_Mime_Header::TYPE_DATE, $header->getFieldType());
    }

    public function testGetDateTime()
    {
        $dateTime = new DateTimeImmutable();
        $header = $this->getHeader('Date');
        $header->setDateTime($dateTime);
        $this->assertSame($dateTime, $header->getDateTime());
    }

    public function testDateTimeCanBeSetBySetter()
    {
        $dateTime = new DateTimeImmutable();
        $header = $this->getHeader('Date');
        $header->setDateTime($dateTime);
        $this->assertSame($dateTime, $header->getDateTime());
    }

    public function testDateTimeIsConvertedToImmutable()
    {
        $dateTime = new DateTime();
        $header = $this->getHeader('Date');
        $header->setDateTime($dateTime);
        $this->assertInstanceOf('DateTimeImmutable', $header->getDateTime());
        $this->assertEquals($dateTime->getTimestamp(), $header->getDateTime()->getTimestamp());
        $this->assertEquals($dateTime->getTimezone(), $header->getDateTime()->getTimezone());
    }

    public function testDateTimeIsImmutable()
    {
        $dateTime = new DateTime('2000-01-01 12:00:00 Europe/Berlin');
        $header = $this->getHeader('Date');
        $header->setDateTime($dateTime);

        $dateTime->setDate(2002, 2, 2);
        $this->assertEquals('Sat, 01 Jan 2000 12:00:00 +0100', $header->getDateTime()->format('r'));
        $this->assertEquals('Sat, 01 Jan 2000 12:00:00 +0100', $header->getFieldBody());
    }

    public function testDateTimeIsConvertedToRfc2822Date()
    {
        $dateTime = new DateTimeImmutable('2000-01-01 12:00:00 Europe/Berlin');
        $header = $this->getHeader('Date');
        $header->setDateTime($dateTime);
        $this->assertEquals('Sat, 01 Jan 2000 12:00:00 +0100', $header->getFieldBody());
    }

    public function testSetBodyModel()
    {
        $dateTime = new DateTimeImmutable();
        $header = $this->getHeader('Date');
        $header->setFieldBodyModel($dateTime);
        $this->assertEquals($dateTime->format('r'), $header->getFieldBody());
    }

    public function testGetBodyModel()
    {
        $dateTime = new DateTimeImmutable();
        $header = $this->getHeader('Date');
        $header->setDateTime($dateTime);
        $this->assertEquals($dateTime, $header->getFieldBodyModel());
    }

    public function testToString()
    {
        $dateTime = new DateTimeImmutable('2000-01-01 12:00:00 Europe/Berlin');
        $header = $this->getHeader('Date');
        $header->setDateTime($dateTime);
        $this->assertEquals("Date: Sat, 01 Jan 2000 12:00:00 +0100\r\n",
            $header->toString()
            );
    }

    private function getHeader($name)
    {
        return new Swift_Mime_Headers_DateHeader($name);
    }
}
