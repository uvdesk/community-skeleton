<?php

abstract class Swift_Transport_StreamBuffer_AbstractStreamBufferAcceptanceTest extends \PHPUnit\Framework\TestCase
{
    protected $buffer;

    abstract protected function initializeBuffer();

    protected function setUp()
    {
        if (true == getenv('TRAVIS')) {
            $this->markTestSkipped(
                'Will fail on travis-ci if not skipped due to travis blocking '.
                'socket mailing tcp connections.'
             );
        }

        $this->buffer = new Swift_Transport_StreamBuffer(
            $this->getMockBuilder('Swift_ReplacementFilterFactory')->getMock()
        );
    }

    public function testReadLine()
    {
        $this->initializeBuffer();

        $line = $this->buffer->readLine(0);
        $this->assertRegExp('/^[0-9]{3}.*?\r\n$/D', $line);
        $seq = $this->buffer->write("QUIT\r\n");
        $this->assertTrue((bool) $seq);
        $line = $this->buffer->readLine($seq);
        $this->assertRegExp('/^[0-9]{3}.*?\r\n$/D', $line);
        $this->buffer->terminate();
    }

    public function testWrite()
    {
        $this->initializeBuffer();

        $line = $this->buffer->readLine(0);
        $this->assertRegExp('/^[0-9]{3}.*?\r\n$/D', $line);

        $seq = $this->buffer->write("HELO foo\r\n");
        $this->assertTrue((bool) $seq);
        $line = $this->buffer->readLine($seq);
        $this->assertRegExp('/^[0-9]{3}.*?\r\n$/D', $line);

        $seq = $this->buffer->write("QUIT\r\n");
        $this->assertTrue((bool) $seq);
        $line = $this->buffer->readLine($seq);
        $this->assertRegExp('/^[0-9]{3}.*?\r\n$/D', $line);
        $this->buffer->terminate();
    }

    public function testBindingOtherStreamsMirrorsWriteOperations()
    {
        $this->initializeBuffer();

        $is1 = $this->createMockInputStream();
        $is2 = $this->createMockInputStream();

        $is1->expects($this->at(0))
            ->method('write')
            ->with('x');
        $is1->expects($this->at(1))
            ->method('write')
            ->with('y');
        $is2->expects($this->at(0))
            ->method('write')
            ->with('x');
        $is2->expects($this->at(1))
            ->method('write')
            ->with('y');

        $this->buffer->bind($is1);
        $this->buffer->bind($is2);

        $this->buffer->write('x');
        $this->buffer->write('y');
    }

    public function testBindingOtherStreamsMirrorsFlushOperations()
    {
        $this->initializeBuffer();

        $is1 = $this->createMockInputStream();
        $is2 = $this->createMockInputStream();

        $is1->expects($this->once())
            ->method('flushBuffers');
        $is2->expects($this->once())
            ->method('flushBuffers');

        $this->buffer->bind($is1);
        $this->buffer->bind($is2);

        $this->buffer->flushBuffers();
    }

    public function testUnbindingStreamPreventsFurtherWrites()
    {
        $this->initializeBuffer();

        $is1 = $this->createMockInputStream();
        $is2 = $this->createMockInputStream();

        $is1->expects($this->at(0))
            ->method('write')
            ->with('x');
        $is1->expects($this->at(1))
            ->method('write')
            ->with('y');
        $is2->expects($this->once())
            ->method('write')
            ->with('x');

        $this->buffer->bind($is1);
        $this->buffer->bind($is2);

        $this->buffer->write('x');

        $this->buffer->unbind($is2);

        $this->buffer->write('y');
    }

    private function createMockInputStream()
    {
        return $this->getMockBuilder('Swift_InputByteStream')->getMock();
    }
}
