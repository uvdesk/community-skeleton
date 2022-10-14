<?php

namespace Webkul\UVDesk\MailboxBundle\Utils\Mailbox;

use Webkul\UVDesk\CoreFrameworkBundle\Utils\TokenGenerator;
use Webkul\UVDesk\MailboxBundle\Utils\Imap\ConfigurationInterface as ImapConfiguration;
use Webkul\UVDesk\CoreFrameworkBundle\Utils\SwiftMailer\BaseConfiguration as SwiftMailerConfiguration;

class Mailbox
{
    CONST TOKEN_RANGE = '12345';
    const TEMPLATE = __DIR__ . "/../../Templates/PackageConfigurations/Mailbox.php";

    private $id = null;
    private $name = null;
    private $isEnabled = false;
    private $isDeleted = false;
    private $imapConfiguration = null;
    private $swiftmailerConfiguration = null;

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    private function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setIsEnabled(bool $isEnabled)
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    public function getIsEnabled() : bool
    {
        return $this->isEnabled;
    }

    public function getIsDeleted() : bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }


    public function setImapConfiguration(ImapConfiguration $imapConfiguration)
    {
        $this->imapConfiguration = $imapConfiguration;

        return $this;
    }

    public function getImapConfiguration() : ?ImapConfiguration
    {
        return $this->imapConfiguration;
    }

    public function setSwiftMailerConfiguration(SwiftMailerConfiguration $swiftmailerConfiguration)
    {
        $this->swiftmailerConfiguration = $swiftmailerConfiguration;

        return $this;
    }

    public function getSwiftMailerConfiguration() : ?SwiftMailerConfiguration
    {
        return $this->swiftmailerConfiguration;
    }

    public function __toString()
    {
        if (null == $this->getId()) {
            // Set random id
            $this->setId(sprintf("mailbox_%s", TokenGenerator::generateToken(4, self::TOKEN_RANGE)));
        }

        $imapConfiguration = $this->getImapConfiguration();
        $swiftmailerConfiguration = $this->getSwiftMailerConfiguration();

        return strtr(require self::TEMPLATE, [
            '[[ id ]]' => $this->getId(),
            '[[ name ]]' => $this->getName(),
            '[[ status ]]' => $this->getIsEnabled() ? 'true' : 'false',
            '[[ delete_status ]]' => $this->getIsDeleted() ? 'true' : 'false',
            '[[ swiftmailer_id ]]' => $swiftmailerConfiguration ? $swiftmailerConfiguration->getId() : '~',
            '[[ imap_host ]]' => $imapConfiguration->getHost(),
            '[[ imap_username ]]' => $imapConfiguration->getUsername(),
            '[[ imap_password ]]' => $imapConfiguration->getPassword(),
        ]);
    }
}
