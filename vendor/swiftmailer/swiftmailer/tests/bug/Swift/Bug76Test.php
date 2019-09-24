<?php

class Swift_Bug76Test extends \PHPUnit\Framework\TestCase
{
    private $inputFile;
    private $outputFile;
    private $encoder;

    protected function setUp()
    {
        $this->inputFile = sys_get_temp_dir().'/in.bin';
        file_put_contents($this->inputFile, '');

        $this->outputFile = sys_get_temp_dir().'/out.bin';
        file_put_contents($this->outputFile, '');

        $this->encoder = $this->createEncoder();
    }

    protected function tearDown()
    {
        unlink($this->inputFile);
        unlink($this->outputFile);
    }

    public function testBase64EncodedLineLengthNeverExceeds76CharactersEvenIfArgsDo()
    {
        $this->fillFileWithRandomBytes(1000, $this->inputFile);

        $os = $this->createStream($this->inputFile);
        $is = $this->createStream($this->outputFile);

        $this->encoder->encodeByteStream($os, $is, 0, 80); //Exceeds 76

        $this->assertMaxLineLength(76, $this->outputFile,
            '%s: Line length should not exceed 76 characters'
        );
    }

    public function assertMaxLineLength($length, $filePath, $message = '%s')
    {
        $lines = file($filePath);
        foreach ($lines as $line) {
            $this->assertTrue((strlen(trim($line)) <= 76), $message);
        }
    }

    private function fillFileWithRandomBytes($byteCount, $file)
    {
        // I was going to use dd with if=/dev/random but this way seems more
        // cross platform even if a hella expensive!!

        file_put_contents($file, '');
        $fp = fopen($file, 'wb');
        for ($i = 0; $i < $byteCount; ++$i) {
            $byteVal = random_int(0, 255);
            fwrite($fp, pack('i', $byteVal));
        }
        fclose($fp);
    }

    private function createEncoder()
    {
        return new Swift_Mime_ContentEncoder_Base64ContentEncoder();
    }

    private function createStream($file)
    {
        return new Swift_ByteStream_FileByteStream($file, true);
    }
}
