<?php

class Swift_Bug38Test extends \PHPUnit\Framework\TestCase
{
    private $attFile;
    private $attFileName;
    private $attFileType;

    protected function setUp()
    {
        $this->attFileName = 'data.txt';
        $this->attFileType = 'text/plain';
        $this->attFile = __DIR__.'/../../_samples/files/data.txt';
        Swift_Preferences::getInstance()->setCharset('utf-8');
    }

    public function testWritingMessageToByteStreamProducesCorrectStructure()
    {
        $message = new Swift_Message();
        $message->setSubject('test subject');
        $message->setTo('user@domain.tld');
        $message->setCc('other@domain.tld');
        $message->setFrom('user@domain.tld');

        $image = new Swift_Image('<data>', 'image.gif', 'image/gif');

        $cid = $message->embed($image);
        $message->setBody('HTML part', 'text/html');

        $id = $message->getId();
        $date = preg_quote($message->getDate()->format('r'), '~');
        $boundary = $message->getBoundary();
        $imgId = $image->getId();

        $stream = new Swift_ByteStream_ArrayByteStream();

        $message->toByteStream($stream);

        $this->assertPatternInStream(
            '~^'.
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date."\r\n".
            'Subject: test subject'."\r\n".
            'From: user@domain.tld'."\r\n".
            'To: user@domain.tld'."\r\n".
            'Cc: other@domain.tld'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: multipart/related;'."\r\n".
            ' boundary="'.$boundary.'"'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'Content-Type: text/html; charset=utf-8'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'HTML part'.
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'Content-Type: image/gif; name=image.gif'."\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            'Content-ID: <'.preg_quote($imgId, '~').'>'."\r\n".
            'Content-Disposition: inline; filename=image.gif'."\r\n".
            "\r\n".
            preg_quote(base64_encode('<data>'), '~').
            "\r\n\r\n".
            '--'.$boundary.'--'."\r\n".
            '$~D',
            $stream
        );
    }

    public function testWritingMessageToByteStreamTwiceProducesCorrectStructure()
    {
        $message = new Swift_Message();
        $message->setSubject('test subject');
        $message->setTo('user@domain.tld');
        $message->setCc('other@domain.tld');
        $message->setFrom('user@domain.tld');

        $image = new Swift_Image('<data>', 'image.gif', 'image/gif');

        $cid = $message->embed($image);
        $message->setBody('HTML part', 'text/html');

        $id = $message->getId();
        $date = preg_quote($message->getDate()->format('r'), '~');
        $boundary = $message->getBoundary();
        $imgId = $image->getId();

        $pattern = '~^'.
        'Message-ID: <'.$id.'>'."\r\n".
        'Date: '.$date."\r\n".
        'Subject: test subject'."\r\n".
        'From: user@domain.tld'."\r\n".
        'To: user@domain.tld'."\r\n".
        'Cc: other@domain.tld'."\r\n".
        'MIME-Version: 1.0'."\r\n".
        'Content-Type: multipart/related;'."\r\n".
        ' boundary="'.$boundary.'"'."\r\n".
        "\r\n\r\n".
        '--'.$boundary."\r\n".
        'Content-Type: text/html; charset=utf-8'."\r\n".
        'Content-Transfer-Encoding: quoted-printable'."\r\n".
        "\r\n".
        'HTML part'.
        "\r\n\r\n".
        '--'.$boundary."\r\n".
        'Content-Type: image/gif; name=image.gif'."\r\n".
        'Content-Transfer-Encoding: base64'."\r\n".
        'Content-ID: <'.preg_quote($imgId, '~').'>'."\r\n".
        'Content-Disposition: inline; filename=image.gif'."\r\n".
        "\r\n".
        preg_quote(base64_encode('<data>'), '~').
        "\r\n\r\n".
        '--'.$boundary.'--'."\r\n".
        '$~D'
        ;

        $streamA = new Swift_ByteStream_ArrayByteStream();
        $streamB = new Swift_ByteStream_ArrayByteStream();

        $message->toByteStream($streamA);
        $message->toByteStream($streamB);

        $this->assertPatternInStream($pattern, $streamA);
        $this->assertPatternInStream($pattern, $streamB);
    }

    public function testWritingMessageToByteStreamTwiceUsingAFileAttachment()
    {
        $message = new Swift_Message();
        $message->setSubject('test subject');
        $message->setTo('user@domain.tld');
        $message->setCc('other@domain.tld');
        $message->setFrom('user@domain.tld');

        $attachment = Swift_Attachment::fromPath($this->attFile);

        $message->attach($attachment);

        $message->setBody('HTML part', 'text/html');

        $id = $message->getId();
        $date = preg_quote($message->getDate()->format('r'), '~');
        $boundary = $message->getBoundary();

        $streamA = new Swift_ByteStream_ArrayByteStream();
        $streamB = new Swift_ByteStream_ArrayByteStream();

        $pattern = '~^'.
            'Message-ID: <'.$id.'>'."\r\n".
            'Date: '.$date."\r\n".
            'Subject: test subject'."\r\n".
            'From: user@domain.tld'."\r\n".
            'To: user@domain.tld'."\r\n".
            'Cc: other@domain.tld'."\r\n".
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: multipart/mixed;'."\r\n".
            ' boundary="'.$boundary.'"'."\r\n".
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'Content-Type: text/html; charset=utf-8'."\r\n".
            'Content-Transfer-Encoding: quoted-printable'."\r\n".
            "\r\n".
            'HTML part'.
            "\r\n\r\n".
            '--'.$boundary."\r\n".
            'Content-Type: '.$this->attFileType.'; name='.$this->attFileName."\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            'Content-Disposition: attachment; filename='.$this->attFileName."\r\n".
            "\r\n".
            preg_quote(base64_encode(file_get_contents($this->attFile)), '~').
            "\r\n\r\n".
            '--'.$boundary.'--'."\r\n".
            '$~D'
            ;

        $message->toByteStream($streamA);
        $message->toByteStream($streamB);

        $this->assertPatternInStream($pattern, $streamA);
        $this->assertPatternInStream($pattern, $streamB);
    }

    public function assertPatternInStream($pattern, $stream, $message = '%s')
    {
        $string = '';
        while (false !== $bytes = $stream->read(8192)) {
            $string .= $bytes;
        }
        $this->assertRegExp($pattern, $string, $message);
    }
}
