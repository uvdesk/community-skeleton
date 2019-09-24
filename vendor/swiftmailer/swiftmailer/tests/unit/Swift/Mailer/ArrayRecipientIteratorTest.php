<?php

class Swift_Mailer_ArrayRecipientIteratorTest extends \PHPUnit\Framework\TestCase
{
    public function testHasNextReturnsFalseForEmptyArray()
    {
        $it = new Swift_Mailer_ArrayRecipientIterator([]);
        $this->assertFalse($it->hasNext());
    }

    public function testHasNextReturnsTrueIfItemsLeft()
    {
        $it = new Swift_Mailer_ArrayRecipientIterator(['foo@bar' => 'Foo']);
        $this->assertTrue($it->hasNext());
    }

    public function testReadingToEndOfListCausesHasNextToReturnFalse()
    {
        $it = new Swift_Mailer_ArrayRecipientIterator(['foo@bar' => 'Foo']);
        $this->assertTrue($it->hasNext());
        $it->nextRecipient();
        $this->assertFalse($it->hasNext());
    }

    public function testReturnedValueHasPreservedKeyValuePair()
    {
        $it = new Swift_Mailer_ArrayRecipientIterator(['foo@bar' => 'Foo']);
        $this->assertEquals(['foo@bar' => 'Foo'], $it->nextRecipient());
    }

    public function testIteratorMovesNextAfterEachIteration()
    {
        $it = new Swift_Mailer_ArrayRecipientIterator([
            'foo@bar' => 'Foo',
            'zip@button' => 'Zip thing',
            'test@test' => null,
            ]);
        $this->assertEquals(['foo@bar' => 'Foo'], $it->nextRecipient());
        $this->assertEquals(['zip@button' => 'Zip thing'], $it->nextRecipient());
        $this->assertEquals(['test@test' => null], $it->nextRecipient());
    }
}
