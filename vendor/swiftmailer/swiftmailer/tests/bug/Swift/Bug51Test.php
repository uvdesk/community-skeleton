<?php

class Swift_Bug51Test extends \SwiftMailerTestCase
{
    private $attachmentFile;
    private $outputFile;

    protected function setUp()
    {
        $this->attachmentFile = sys_get_temp_dir().'/attach.rand.bin';
        file_put_contents($this->attachmentFile, '');

        $this->outputFile = sys_get_temp_dir().'/attach.out.bin';
        file_put_contents($this->outputFile, '');
    }

    protected function tearDown()
    {
        unlink($this->attachmentFile);
        unlink($this->outputFile);
    }

    public function testAttachmentsDoNotGetTruncatedUsingToByteStream()
    {
        //Run 100 times with 10KB attachments
        for ($i = 0; $i < 10; ++$i) {
            $message = $this->createMessageWithRandomAttachment(
                10000, $this->attachmentFile
            );

            file_put_contents($this->outputFile, '');
            $message->toByteStream(
                new Swift_ByteStream_FileByteStream($this->outputFile, true)
            );

            $emailSource = file_get_contents($this->outputFile);

            $this->assertAttachmentFromSourceMatches(
                file_get_contents($this->attachmentFile),
                $emailSource
            );
        }
    }

    public function testAttachmentsDoNotGetTruncatedUsingToString()
    {
        //Run 100 times with 10KB attachments
        for ($i = 0; $i < 10; ++$i) {
            $message = $this->createMessageWithRandomAttachment(
                10000, $this->attachmentFile
            );

            $emailSource = $message->toString();

            $this->assertAttachmentFromSourceMatches(
                file_get_contents($this->attachmentFile),
                $emailSource
            );
        }
    }

    public function assertAttachmentFromSourceMatches($attachmentData, $source)
    {
        $encHeader = 'Content-Transfer-Encoding: base64';
        $base64declaration = strpos($source, $encHeader);

        $attachmentDataStart = strpos($source, "\r\n\r\n", $base64declaration);
        $attachmentDataEnd = strpos($source, "\r\n--", $attachmentDataStart);

        if (false === $attachmentDataEnd) {
            $attachmentBase64 = trim(substr($source, $attachmentDataStart));
        } else {
            $attachmentBase64 = trim(substr(
                $source, $attachmentDataStart,
                $attachmentDataEnd - $attachmentDataStart
            ));
        }

        $this->assertIdenticalBinary($attachmentData, base64_decode($attachmentBase64));
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

    private function createMessageWithRandomAttachment($size, $attachmentPath)
    {
        $this->fillFileWithRandomBytes($size, $attachmentPath);

        $message = (new Swift_Message())
            ->setSubject('test')
            ->setBody('test')
            ->setFrom('a@b.c')
            ->setTo('d@e.f')
            ->attach(Swift_Attachment::fromPath($attachmentPath))
            ;

        return $message;
    }
}
