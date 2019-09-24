<?php

class Swift_Transport_StreamBuffer_SocketTimeoutTest extends \PHPUnit\Framework\TestCase
{
    protected $buffer;
    protected $server;
    protected $randomHighPort;

    protected function setUp()
    {
        if (!defined('SWIFT_SMTP_HOST')) {
            $this->markTestSkipped(
                'Cannot run test without an SMTP host to connect to (define '.
                'SWIFT_SMTP_HOST in tests/acceptance.conf.php if you wish to run this test)'
             );
        }

        $serverStarted = false;
        for ($i = 0; $i < 5; ++$i) {
            $this->randomHighPort = random_int(50000, 65000);
            $this->server = stream_socket_server('tcp://127.0.0.1:'.$this->randomHighPort);
            if ($this->server) {
                $serverStarted = true;
            }
        }

        $this->buffer = new Swift_Transport_StreamBuffer(
            $this->getMockBuilder('Swift_ReplacementFilterFactory')->getMock()
        );
    }

    protected function initializeBuffer()
    {
        $host = '127.0.0.1';
        $port = $this->randomHighPort;

        $this->buffer->initialize([
            'type' => Swift_Transport_IoBuffer::TYPE_SOCKET,
            'host' => $host,
            'port' => $port,
            'protocol' => 'tcp',
            'blocking' => 1,
            'timeout' => 1,
        ]);
    }

    public function testTimeoutException()
    {
        $this->initializeBuffer();
        $e = null;
        try {
            $line = $this->buffer->readLine(0);
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('Swift_IoException', $e, 'IO Exception Not Thrown On Connection Timeout');
        $this->assertRegExp('/Connection to .* Timed Out/', $e->getMessage());
    }

    protected function tearDown()
    {
        if ($this->server) {
            stream_socket_shutdown($this->server, STREAM_SHUT_RDWR);
        }
    }
}
