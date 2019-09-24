<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailTemplates
 * 
 * @ORM\Entity(repositoryClass="Webkul\UVDesk\CoreFrameworkBundle\Repository\EmailTemplatesRepository")
 * @ORM\Table(name="uv_email_templates")
 * 
 */
class EmailTemplates
{
    /**
     * @var integer
     * 
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(name="name", type="string", length=191)
     */
    private $name;

    /**
     * @var string
     * 
     * @ORM\Column(name="subject", type="string", length=191)
     */
    private $subject;

    /**
     * @var string
     * 
     * @ORM\Column(name="message", type="text")
     * 
     */
    private $message;

    /**
     * @var string
     * 
     * @ORM\Column(name="template_type", type="string", nullable=true)
     */
    private $templateType;

    /**
     * @var boolean
     * 
     * @ORM\Column(name="is_predefined", type="boolean", options={"default": true})
     */
    private $isPredefined = true;

    /**
     * @var \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance
     * @ORM\ManyToOne(targetEntity="Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance", inversedBy="userSavedReplies")
     * @ORM\JoinColumn(name="user_id", nullable=true, onDelete="CASCADE", referencedColumnName="id")
     */
    private $user;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return EmailTemplates
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return EmailTemplates
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return EmailTemplates
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set templateType
     *
     * @param string $templateType
     *
     * @return EmailTemplates
     */
    public function setTemplateType($templateType)
    {
        $this->templateType = $templateType;

        return $this;
    }

    /**
     * Get templateType
     *
     * @return string
     */
    public function getTemplateType()
    {
        return $this->templateType;
    }

    /**
     * Set isPredefined
     *
     * @param boolean $isPredefined
     *
     * @return EmailTemplates
     */
    public function setIsPredefined($isPredefined)
    {
        $this->isPredefined = $isPredefined;

        return $this;
    }

    /**
     * Get isPredefined
     *
     * @return boolean
     */
    public function getIsPredefined()
    {
        return $this->isPredefined;
    }

    /**
     * Set user
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $user
     *
     * @return EmailTemplates
     */
    public function setUser(\Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance
     */
    public function getUser()
    {
        return $this->user;
    }
}

