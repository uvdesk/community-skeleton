<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MonologBundle\SwiftMailer;

/**
 * Helps create Swift_Message objects, lazily
 *
 * @author Ryan Weaver <ryan@knpuniversity.com>
 */
class MessageFactory
{
    private $mailer;

    private $fromEmail;

    private $toEmail;

    private $subject;

    private $contentType;

    public function __construct(\Swift_Mailer $mailer, $fromEmail, $toEmail, $subject, $contentType = null)
    {
        $this->mailer = $mailer;
        $this->fromEmail = $fromEmail;
        $this->toEmail = $toEmail;
        $this->subject = $subject;
        $this->contentType = $contentType;
    }

    /**
     * Creates a Swift_Message template that will be used to send the log message
     *
     * @param string $content formatted email body to be sent
     * @param array  $records Log records that formed the content
     * @return \Swift_Message
     */
    public function createMessage($content, array $records)
    {
        /** @var \Swift_Message $message */
        $message = $this->mailer->createMessage();
        $message->setTo($this->toEmail);
        $message->setFrom($this->fromEmail);
        $message->setSubject($this->subject);

        if ($this->contentType) {
            $message->setContentType($this->contentType);
        }

        return $message;
    }
}
