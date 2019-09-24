<?php

class Swift_Encoder_Base64EncoderAcceptanceTest extends \PHPUnit\Framework\TestCase
{
    private $samplesDir;
    private $encoder;

    protected function setUp()
    {
        $this->samplesDir = realpath(__DIR__.'/../../../_samples/charsets');
        $this->encoder = new Swift_Encoder_Base64Encoder();
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
                    $encodedText = $this->encoder->encodeString($text);

                    $this->assertEquals(
                        base64_decode($encodedText), $text,
                        '%s: Encoded string should decode back to original string for sample '.
                        $sampleDir.'/'.$sampleFile
                        );
                }
                closedir($fileFp);
            }
        }
        closedir($sampleFp);
    }
}
