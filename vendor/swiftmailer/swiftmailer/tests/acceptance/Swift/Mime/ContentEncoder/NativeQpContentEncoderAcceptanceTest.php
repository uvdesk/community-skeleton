<?php

class Swift_Mime_ContentEncoder_NativeQpContentEncoderAcceptanceTest extends \PHPUnit\Framework\TestCase
{
    protected $_samplesDir;

    /**
     * @var Swift_Mime_ContentEncoder_NativeQpContentEncoder
     */
    protected $encoder;

    protected function setUp()
    {
        $this->samplesDir = realpath(__DIR__.'/../../../../_samples/charsets');
        $this->encoder = new Swift_Mime_ContentEncoder_NativeQpContentEncoder();
    }

    public function testEncodingAndDecodingSamples()
    {
        $sampleFp = opendir($this->samplesDir);
        while (false !== $encodingDir = readdir($sampleFp)) {
            if ('.' == substr($encodingDir, 0, 1)) {
                continue;
            }

            $sampleDir = $this->samplesDir.'/'.$encodingDir;

            if (is_dir($sampleDir)) {
                $fileFp = opendir($sampleDir);
                while (false !== $sampleFile = readdir($fileFp)) {
                    if ('.' == substr($sampleFile, 0, 1)) {
                        continue;
                    }

                    $text = file_get_contents($sampleDir.'/'.$sampleFile);

                    $os = new Swift_ByteStream_ArrayByteStream();
                    $os->write($text);

                    $is = new Swift_ByteStream_ArrayByteStream();
                    $this->encoder->encodeByteStream($os, $is);

                    $encoded = '';
                    while (false !== $bytes = $is->read(8192)) {
                        $encoded .= $bytes;
                    }

                    $this->assertEquals(
                        quoted_printable_decode($encoded),
                        // CR and LF are converted to CRLF
                        preg_replace('~\r(?!\n)|(?<!\r)\n~', "\r\n", $text),
                        '%s: Encoded string should decode back to original string for sample '.$sampleDir.'/'.$sampleFile
                    );
                }
                closedir($fileFp);
            }
        }
        closedir($sampleFp);
    }

    public function testEncodingAndDecodingSamplesFromDiConfiguredInstance()
    {
        $encoder = $this->createEncoderFromContainer();
        $this->assertSame('=C3=A4=C3=B6=C3=BC=C3=9F', $encoder->encodeString('äöüß'));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCharsetChangeNotImplemented()
    {
        $this->encoder->charsetChanged('utf-8');
        $this->encoder->charsetChanged('charset');
        $this->encoder->encodeString('foo');
    }

    public function testGetName()
    {
        $this->assertSame('quoted-printable', $this->encoder->getName());
    }

    private function createEncoderFromContainer()
    {
        return Swift_DependencyContainer::getInstance()
            ->lookup('mime.nativeqpcontentencoder')
            ;
    }
}
