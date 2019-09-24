<?php

class Swift_Mime_SimpleHeaderSetTest extends \PHPUnit\Framework\TestCase
{
    public function testAddMailboxHeaderDelegatesToFactory()
    {
        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('createMailboxHeader')
                ->with('From', ['person@domain' => 'Person'])
                ->will($this->returnValue($this->createHeader('From')));

        $set = $this->createSet($factory);
        $set->addMailboxHeader('From', ['person@domain' => 'Person']);
    }

    public function testAddDateHeaderDelegatesToFactory()
    {
        $dateTime = new DateTimeImmutable();

        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('createDateHeader')
                ->with('Date', $dateTime)
                ->will($this->returnValue($this->createHeader('Date')));

        $set = $this->createSet($factory);
        $set->addDateHeader('Date', $dateTime);
    }

    public function testAddTextHeaderDelegatesToFactory()
    {
        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('createTextHeader')
                ->with('Subject', 'some text')
                ->will($this->returnValue($this->createHeader('Subject')));

        $set = $this->createSet($factory);
        $set->addTextHeader('Subject', 'some text');
    }

    public function testAddParameterizedHeaderDelegatesToFactory()
    {
        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('createParameterizedHeader')
                ->with('Content-Type', 'text/plain', ['charset' => 'utf-8'])
                ->will($this->returnValue($this->createHeader('Content-Type')));

        $set = $this->createSet($factory);
        $set->addParameterizedHeader('Content-Type', 'text/plain',
            ['charset' => 'utf-8']
            );
    }

    public function testAddIdHeaderDelegatesToFactory()
    {
        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($this->createHeader('Message-ID')));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
    }

    public function testAddPathHeaderDelegatesToFactory()
    {
        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('createPathHeader')
                ->with('Return-Path', 'some@path')
                ->will($this->returnValue($this->createHeader('Return-Path')));

        $set = $this->createSet($factory);
        $set->addPathHeader('Return-Path', 'some@path');
    }

    public function testHasReturnsFalseWhenNoHeaders()
    {
        $set = $this->createSet($this->createFactory());
        $this->assertFalse($set->has('Some-Header'));
    }

    public function testAddedMailboxHeaderIsSeenByHas()
    {
        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('createMailboxHeader')
                ->with('From', ['person@domain' => 'Person'])
                ->will($this->returnValue($this->createHeader('From')));

        $set = $this->createSet($factory);
        $set->addMailboxHeader('From', ['person@domain' => 'Person']);
        $this->assertTrue($set->has('From'));
    }

    public function testAddedDateHeaderIsSeenByHas()
    {
        $dateTime = new DateTimeImmutable();

        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('createDateHeader')
                ->with('Date', $dateTime)
                ->will($this->returnValue($this->createHeader('Date')));

        $set = $this->createSet($factory);
        $set->addDateHeader('Date', $dateTime);
        $this->assertTrue($set->has('Date'));
    }

    public function testAddedTextHeaderIsSeenByHas()
    {
        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('createTextHeader')
                ->with('Subject', 'some text')
                ->will($this->returnValue($this->createHeader('Subject')));

        $set = $this->createSet($factory);
        $set->addTextHeader('Subject', 'some text');
        $this->assertTrue($set->has('Subject'));
    }

    public function testAddedParameterizedHeaderIsSeenByHas()
    {
        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('createParameterizedHeader')
                ->with('Content-Type', 'text/plain', ['charset' => 'utf-8'])
                ->will($this->returnValue($this->createHeader('Content-Type')));

        $set = $this->createSet($factory);
        $set->addParameterizedHeader('Content-Type', 'text/plain',
            ['charset' => 'utf-8']
            );
        $this->assertTrue($set->has('Content-Type'));
    }

    public function testAddedIdHeaderIsSeenByHas()
    {
        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($this->createHeader('Message-ID')));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $this->assertTrue($set->has('Message-ID'));
    }

    public function testAddedPathHeaderIsSeenByHas()
    {
        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('createPathHeader')
                ->with('Return-Path', 'some@path')
                ->will($this->returnValue($this->createHeader('Return-Path')));

        $set = $this->createSet($factory);
        $set->addPathHeader('Return-Path', 'some@path');
        $this->assertTrue($set->has('Return-Path'));
    }

    public function testNewlySetHeaderIsSeenByHas()
    {
        $factory = $this->createFactory();
        $header = $this->createHeader('X-Foo', 'bar');
        $set = $this->createSet($factory);
        $set->set($header);
        $this->assertTrue($set->has('X-Foo'));
    }

    public function testHasCanAcceptOffset()
    {
        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($this->createHeader('Message-ID')));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $this->assertTrue($set->has('Message-ID', 0));
    }

    public function testHasWithIllegalOffsetReturnsFalse()
    {
        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($this->createHeader('Message-ID')));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $this->assertFalse($set->has('Message-ID', 1));
    }

    public function testHasCanDistinguishMultipleHeaders()
    {
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($this->createHeader('Message-ID')));
        $factory->expects($this->at(1))
                ->method('createIdHeader')
                ->with('Message-ID', 'other@id')
                ->will($this->returnValue($this->createHeader('Message-ID')));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $set->addIdHeader('Message-ID', 'other@id');
        $this->assertTrue($set->has('Message-ID', 1));
    }

    public function testGetWithUnspecifiedOffset()
    {
        $header = $this->createHeader('Message-ID');
        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($header));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $this->assertSame($header, $set->get('Message-ID'));
    }

    public function testGetWithSpeiciedOffset()
    {
        $header0 = $this->createHeader('Message-ID');
        $header1 = $this->createHeader('Message-ID');
        $header2 = $this->createHeader('Message-ID');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($header0));
        $factory->expects($this->at(1))
                ->method('createIdHeader')
                ->with('Message-ID', 'other@id')
                ->will($this->returnValue($header1));
        $factory->expects($this->at(2))
                ->method('createIdHeader')
                ->with('Message-ID', 'more@id')
                ->will($this->returnValue($header2));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $set->addIdHeader('Message-ID', 'other@id');
        $set->addIdHeader('Message-ID', 'more@id');
        $this->assertSame($header1, $set->get('Message-ID', 1));
    }

    public function testGetReturnsNullIfHeaderNotSet()
    {
        $set = $this->createSet($this->createFactory());
        $this->assertNull($set->get('Message-ID', 99));
    }

    public function testGetAllReturnsAllHeadersMatchingName()
    {
        $header0 = $this->createHeader('Message-ID');
        $header1 = $this->createHeader('Message-ID');
        $header2 = $this->createHeader('Message-ID');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($header0));
        $factory->expects($this->at(1))
                ->method('createIdHeader')
                ->with('Message-ID', 'other@id')
                ->will($this->returnValue($header1));
        $factory->expects($this->at(2))
                ->method('createIdHeader')
                ->with('Message-ID', 'more@id')
                ->will($this->returnValue($header2));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $set->addIdHeader('Message-ID', 'other@id');
        $set->addIdHeader('Message-ID', 'more@id');

        $this->assertEquals([$header0, $header1, $header2],
            $set->getAll('Message-ID')
            );
    }

    public function testGetAllReturnsAllHeadersIfNoArguments()
    {
        $header0 = $this->createHeader('Message-ID');
        $header1 = $this->createHeader('Subject');
        $header2 = $this->createHeader('To');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($header0));
        $factory->expects($this->at(1))
                ->method('createIdHeader')
                ->with('Subject', 'thing')
                ->will($this->returnValue($header1));
        $factory->expects($this->at(2))
                ->method('createIdHeader')
                ->with('To', 'person@example.org')
                ->will($this->returnValue($header2));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $set->addIdHeader('Subject', 'thing');
        $set->addIdHeader('To', 'person@example.org');

        $this->assertEquals([$header0, $header1, $header2],
            $set->getAll()
            );
    }

    public function testGetAllReturnsEmptyArrayIfNoneSet()
    {
        $set = $this->createSet($this->createFactory());
        $this->assertEquals([], $set->getAll('Received'));
    }

    public function testRemoveWithUnspecifiedOffset()
    {
        $header = $this->createHeader('Message-ID');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($header));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $set->remove('Message-ID');
        $this->assertFalse($set->has('Message-ID'));
    }

    public function testRemoveWithSpecifiedIndexRemovesHeader()
    {
        $header0 = $this->createHeader('Message-ID');
        $header1 = $this->createHeader('Message-ID');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($header0));
        $factory->expects($this->at(1))
                ->method('createIdHeader')
                ->with('Message-ID', 'other@id')
                ->will($this->returnValue($header1));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $set->addIdHeader('Message-ID', 'other@id');
        $set->remove('Message-ID', 0);
        $this->assertFalse($set->has('Message-ID', 0));
        $this->assertTrue($set->has('Message-ID', 1));
        $this->assertTrue($set->has('Message-ID'));
        $set->remove('Message-ID', 1);
        $this->assertFalse($set->has('Message-ID', 1));
        $this->assertFalse($set->has('Message-ID'));
    }

    public function testRemoveWithSpecifiedIndexLeavesOtherHeaders()
    {
        $header0 = $this->createHeader('Message-ID');
        $header1 = $this->createHeader('Message-ID');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($header0));
        $factory->expects($this->at(1))
                ->method('createIdHeader')
                ->with('Message-ID', 'other@id')
                ->will($this->returnValue($header1));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $set->addIdHeader('Message-ID', 'other@id');
        $set->remove('Message-ID', 1);
        $this->assertTrue($set->has('Message-ID', 0));
    }

    public function testRemoveWithInvalidOffsetDoesNothing()
    {
        $header = $this->createHeader('Message-ID');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($header));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $set->remove('Message-ID', 50);
        $this->assertTrue($set->has('Message-ID'));
    }

    public function testRemoveAllRemovesAllHeadersWithName()
    {
        $header0 = $this->createHeader('Message-ID');
        $header1 = $this->createHeader('Message-ID');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($header0));
        $factory->expects($this->at(1))
                ->method('createIdHeader')
                ->with('Message-ID', 'other@id')
                ->will($this->returnValue($header1));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $set->addIdHeader('Message-ID', 'other@id');
        $set->removeAll('Message-ID');
        $this->assertFalse($set->has('Message-ID', 0));
        $this->assertFalse($set->has('Message-ID', 1));
    }

    public function testHasIsNotCaseSensitive()
    {
        $header = $this->createHeader('Message-ID');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($header));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $this->assertTrue($set->has('message-id'));
    }

    public function testGetIsNotCaseSensitive()
    {
        $header = $this->createHeader('Message-ID');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($header));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $this->assertSame($header, $set->get('message-id'));
    }

    public function testGetAllIsNotCaseSensitive()
    {
        $header = $this->createHeader('Message-ID');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($header));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $this->assertEquals([$header], $set->getAll('message-id'));
    }

    public function testRemoveIsNotCaseSensitive()
    {
        $header = $this->createHeader('Message-ID');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($header));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $set->remove('message-id');
        $this->assertFalse($set->has('Message-ID'));
    }

    public function testRemoveAllIsNotCaseSensitive()
    {
        $header = $this->createHeader('Message-ID');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createIdHeader')
                ->with('Message-ID', 'some@id')
                ->will($this->returnValue($header));

        $set = $this->createSet($factory);
        $set->addIdHeader('Message-ID', 'some@id');
        $set->removeAll('message-id');
        $this->assertFalse($set->has('Message-ID'));
    }

    public function testToStringJoinsHeadersTogether()
    {
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createTextHeader')
                ->with('Foo', 'bar')
                ->will($this->returnValue($this->createHeader('Foo', 'bar')));
        $factory->expects($this->at(1))
                ->method('createTextHeader')
                ->with('Zip', 'buttons')
                ->will($this->returnValue($this->createHeader('Zip', 'buttons')));

        $set = $this->createSet($factory);
        $set->addTextHeader('Foo', 'bar');
        $set->addTextHeader('Zip', 'buttons');
        $this->assertEquals(
            "Foo: bar\r\n".
            "Zip: buttons\r\n",
            $set->toString()
            );
    }

    public function testHeadersWithoutBodiesAreNotDisplayed()
    {
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createTextHeader')
                ->with('Foo', 'bar')
                ->will($this->returnValue($this->createHeader('Foo', 'bar')));
        $factory->expects($this->at(1))
                ->method('createTextHeader')
                ->with('Zip', '')
                ->will($this->returnValue($this->createHeader('Zip', '')));

        $set = $this->createSet($factory);
        $set->addTextHeader('Foo', 'bar');
        $set->addTextHeader('Zip', '');
        $this->assertEquals(
            "Foo: bar\r\n",
            $set->toString()
            );
    }

    public function testHeadersWithoutBodiesCanBeForcedToDisplay()
    {
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createTextHeader')
                ->with('Foo', '')
                ->will($this->returnValue($this->createHeader('Foo', '')));
        $factory->expects($this->at(1))
                ->method('createTextHeader')
                ->with('Zip', '')
                ->will($this->returnValue($this->createHeader('Zip', '')));

        $set = $this->createSet($factory);
        $set->addTextHeader('Foo', '');
        $set->addTextHeader('Zip', '');
        $set->setAlwaysDisplayed(['Foo', 'Zip']);
        $this->assertEquals(
            "Foo: \r\n".
            "Zip: \r\n",
            $set->toString()
            );
    }

    public function testHeaderSequencesCanBeSpecified()
    {
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createTextHeader')
                ->with('Third', 'three')
                ->will($this->returnValue($this->createHeader('Third', 'three')));
        $factory->expects($this->at(1))
                ->method('createTextHeader')
                ->with('First', 'one')
                ->will($this->returnValue($this->createHeader('First', 'one')));
        $factory->expects($this->at(2))
                ->method('createTextHeader')
                ->with('Second', 'two')
                ->will($this->returnValue($this->createHeader('Second', 'two')));

        $set = $this->createSet($factory);
        $set->addTextHeader('Third', 'three');
        $set->addTextHeader('First', 'one');
        $set->addTextHeader('Second', 'two');

        $set->defineOrdering(['First', 'Second', 'Third']);

        $this->assertEquals(
            "First: one\r\n".
            "Second: two\r\n".
            "Third: three\r\n",
            $set->toString()
            );
    }

    public function testUnsortedHeadersAppearAtEnd()
    {
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createTextHeader')
                ->with('Fourth', 'four')
                ->will($this->returnValue($this->createHeader('Fourth', 'four')));
        $factory->expects($this->at(1))
                ->method('createTextHeader')
                ->with('Fifth', 'five')
                ->will($this->returnValue($this->createHeader('Fifth', 'five')));
        $factory->expects($this->at(2))
                ->method('createTextHeader')
                ->with('Third', 'three')
                ->will($this->returnValue($this->createHeader('Third', 'three')));
        $factory->expects($this->at(3))
                ->method('createTextHeader')
                ->with('First', 'one')
                ->will($this->returnValue($this->createHeader('First', 'one')));
        $factory->expects($this->at(4))
                ->method('createTextHeader')
                ->with('Second', 'two')
                ->will($this->returnValue($this->createHeader('Second', 'two')));

        $set = $this->createSet($factory);
        $set->addTextHeader('Fourth', 'four');
        $set->addTextHeader('Fifth', 'five');
        $set->addTextHeader('Third', 'three');
        $set->addTextHeader('First', 'one');
        $set->addTextHeader('Second', 'two');

        $set->defineOrdering(['First', 'Second', 'Third']);

        $this->assertEquals(
            "First: one\r\n".
            "Second: two\r\n".
            "Third: three\r\n".
            "Fourth: four\r\n".
            "Fifth: five\r\n",
            $set->toString()
            );
    }

    public function testSettingCharsetNotifiesAlreadyExistingHeaders()
    {
        $subject = $this->createHeader('Subject', 'some text');
        $xHeader = $this->createHeader('X-Header', 'some text');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createTextHeader')
                ->with('Subject', 'some text')
                ->will($this->returnValue($subject));
        $factory->expects($this->at(1))
                ->method('createTextHeader')
                ->with('X-Header', 'some text')
                ->will($this->returnValue($xHeader));
        $subject->expects($this->once())
                ->method('setCharset')
                ->with('utf-8');
        $xHeader->expects($this->once())
                ->method('setCharset')
                ->with('utf-8');

        $set = $this->createSet($factory);
        $set->addTextHeader('Subject', 'some text');
        $set->addTextHeader('X-Header', 'some text');

        $set->setCharset('utf-8');
    }

    public function testCharsetChangeNotifiesAlreadyExistingHeaders()
    {
        $subject = $this->createHeader('Subject', 'some text');
        $xHeader = $this->createHeader('X-Header', 'some text');
        $factory = $this->createFactory();
        $factory->expects($this->at(0))
                ->method('createTextHeader')
                ->with('Subject', 'some text')
                ->will($this->returnValue($subject));
        $factory->expects($this->at(1))
                ->method('createTextHeader')
                ->with('X-Header', 'some text')
                ->will($this->returnValue($xHeader));
        $subject->expects($this->once())
                ->method('setCharset')
                ->with('utf-8');
        $xHeader->expects($this->once())
                ->method('setCharset')
                ->with('utf-8');

        $set = $this->createSet($factory);
        $set->addTextHeader('Subject', 'some text');
        $set->addTextHeader('X-Header', 'some text');

        $set->charsetChanged('utf-8');
    }

    public function testCharsetChangeNotifiesFactory()
    {
        $factory = $this->createFactory();
        $factory->expects($this->once())
                ->method('charsetChanged')
                ->with('utf-8');

        $set = $this->createSet($factory);

        $set->setCharset('utf-8');
    }

    private function createSet($factory)
    {
        return new Swift_Mime_SimpleHeaderSet($factory);
    }

    private function createFactory()
    {
        return $this->getMockBuilder('Swift_Mime_SimpleHeaderFactory')->disableOriginalConstructor()->getMock();
    }

    private function createHeader($name, $body = '')
    {
        $header = $this->getMockBuilder('Swift_Mime_Header')->getMock();
        $header->expects($this->any())
               ->method('getFieldName')
               ->will($this->returnValue($name));
        $header->expects($this->any())
               ->method('toString')
               ->will($this->returnValue(sprintf("%s: %s\r\n", $name, $body)));
        $header->expects($this->any())
               ->method('getFieldBody')
               ->will($this->returnValue($body));

        return $header;
    }
}
