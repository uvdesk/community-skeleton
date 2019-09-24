<?php

class Swift_Bug111Test extends \PHPUnit\Framework\TestCase
{
    public function testUnstructuredHeaderSlashesShouldNotBeEscaped()
    {
        $complicated_header = [
            'to' => [
                'email1@example.com',
                'email2@example.com',
                'email3@example.com',
                'email4@example.com',
                'email5@example.com',
            ],
            'sub' => [
                '-name-' => [
                    'email1',
                    '"email2"',
                    'email3\\',
                    'email4',
                    'email5',
                ],
                '-url-' => [
                    'http://google.com',
                    'http://yahoo.com',
                    'http://hotmail.com',
                    'http://aol.com',
                    'http://facebook.com',
                ],
            ],
        ];
        $json = json_encode($complicated_header);

        $message = new Swift_Message();
        $headers = $message->getHeaders();
        $headers->addTextHeader('X-SMTPAPI', $json);
        $header = $headers->get('X-SMTPAPI');

        $this->assertEquals('Swift_Mime_Headers_UnstructuredHeader', get_class($header));
        $this->assertEquals($json, $header->getFieldBody());
    }
}
