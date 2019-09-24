<?php

class Swift_Mime_ContentEncoder_QpContentEncoderAcceptanceTest extends \PHPUnit\Framework\TestCase
{
    private $samplesDir;
    private $factory;

    protected function setUp()
    {
        $this->samplesDir = realpath(__DIR__.'/../../../../_samples/charsets');
        $this->factory = new Swift_CharacterReaderFactory_SimpleCharacterReaderFactory();
    }

    protected function tearDown()
    {
        Swift_Preferences::getInstance()->setQPDotEscape(false);
    }

    public function testEncodingAndDecodingSamples()
    {
        $sampleFp = opendir($this->samplesDir);
        while (false !== $encodingDir = readdir($sampleFp)) {
            if ('.' == substr($encodingDir, 0, 1)) {
                continue;
            }

            $encoding = $encodingDir;
            $charStream = new Swift_CharacterStream_NgCharacterStream(
                $this->factory, $encoding);
            $encoder = new Swift_Mime_ContentEncoder_QpContentEncoder($charStream);

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
                    $encoder->encodeByteStream($os, $is);

                    $encoded = '';
                    while (false !== $bytes = $is->read(8192)) {
                        $encoded .= $bytes;
                    }

                    $this->assertEquals(
                        quoted_printable_decode($encoded), $text,
                        '%s: Encoded string should decode back to original string for sample '.
                        $sampleDir.'/'.$sampleFile
                        );
                }
                closedir($fileFp);
            }
        }
        closedir($sampleFp);
    }

    public function testEncodingAndDecodingSamplesFromDiConfiguredInstance()
    {
        $sampleFp = opendir($this->samplesDir);
        while (false !== $encodingDir = readdir($sampleFp)) {
            if ('.' == substr($encodingDir, 0, 1)) {
                continue;
            }

            $encoding = $encodingDir;
            $encoder = $this->createEncoderFromContainer();

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
                    $encoder->encodeByteStream($os, $is);

                    $encoded = '';
                    while (false !== $bytes = $is->read(8192)) {
                        $encoded .= $bytes;
                    }

                    $this->assertEquals(
                        str_replace("\r\n", "\n", quoted_printable_decode($encoded)), str_replace("\r\n", "\n", $text),
                        '%s: Encoded string should decode back to original string for sample '.
                        $sampleDir.'/'.$sampleFile
                        );
                }
                closedir($fileFp);
            }
        }
        closedir($sampleFp);
    }

    public function testEncodingLFTextWithDiConfiguredInstance()
    {
        $encoder = $this->createEncoderFromContainer();
        $this->assertEquals("a\r\nb\r\nc", $encoder->encodeString("a\nb\nc"));
    }

    public function testEncodingCRTextWithDiConfiguredInstance()
    {
        $encoder = $this->createEncoderFromContainer();
        $this->assertEquals("a\r\nb\r\nc", $encoder->encodeString("a\rb\rc"));
    }

    public function testEncodingLFCRTextWithDiConfiguredInstance()
    {
        $encoder = $this->createEncoderFromContainer();
        $this->assertEquals("a\r\n\r\nb\r\n\r\nc", $encoder->encodeString("a\n\rb\n\rc"));
    }

    public function testEncodingCRLFTextWithDiConfiguredInstance()
    {
        $encoder = $this->createEncoderFromContainer();
        $this->assertEquals("a\r\nb\r\nc", $encoder->encodeString("a\r\nb\r\nc"));
    }

    public function testEncodingDotStuffingWithDiConfiguredInstance()
    {
        // Enable DotEscaping
        Swift_Preferences::getInstance()->setQPDotEscape(true);
        $encoder = $this->createEncoderFromContainer();
        $this->assertEquals("a=2E\r\n=2E\r\n=2Eb\r\nc", $encoder->encodeString("a.\r\n.\r\n.b\r\nc"));
        // Return to default
        Swift_Preferences::getInstance()->setQPDotEscape(false);
        $encoder = $this->createEncoderFromContainer();
        $this->assertEquals("a.\r\n.\r\n.b\r\nc", $encoder->encodeString("a.\r\n.\r\n.b\r\nc"));
    }

    public function testDotStuffingEncodingAndDecodingSamplesFromDiConfiguredInstance()
    {
        // Enable DotEscaping
        Swift_Preferences::getInstance()->setQPDotEscape(true);
        $this->testEncodingAndDecodingSamplesFromDiConfiguredInstance();
    }

    private function createEncoderFromContainer()
    {
        return Swift_DependencyContainer::getInstance()
            ->lookup('mime.qpcontentencoder')
            ;
    }
}
