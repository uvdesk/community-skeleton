<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailTemplatesCompany
 * 
 * @ORM\Entity(repositoryClass="Webkul\UVDesk\CoreFrameworkBundle\Repository\SavedRepliesRepository")
 * @ORM\Table(name="uv_saved_replies")
 * @ORM\HasLifecycleCallbacks
 */
class SavedReplies
{
    /**
     * @var integer
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="subject", type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $message;

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
     * @return Savedreplies
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
     * @return Savedreplies
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
     * @return Savedreplies
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
     * @var integer
     * @ORM\Column(name="template_id", type="integer", nullable=true)
     */
    private $templateId;

    /**
     * Set templateId
     * 
     * @param integer $templateId
     * @return Savedreplies
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;

        return $this;
    }

    /**
     * Get templateId
     *
     * @return integer 
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }
    /**
     * @var \Webkul\UserBundle\Entity\UserData
     * @ORM\ManyToOne(targetEntity="UserInstance", inversedBy="userSaveReplies")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $user;


    /**
     * Set user
     *
     * @return Savedreplies
     */
    public function setUser(\Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Webkul\UserBundle\Entity\UserData 
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @ORM\Column(type="boolean", options={"default": true}, nullable=true)
     */
    private $isPredefind;


    /**
     * Set isPredefind
     *
     * @param boolean $isPredefind
     * @return Savedreplies
     */
    public function setIsPredefind($isPredefind)
    {
        $this->isPredefind = $isPredefind;

        return $this;
    }

    /**
     * Get isPredefind
     *
     * @return boolean 
     */
    public function getIsPredefind()
    {   
        return $this->isPredefind;
    }
    /**
     * @var string
     * 
     * @ORM\Column(name="message_inline", type="text", nullable=true)
     * 
     */
    private $messageInline;


    /**
     * Set messageInline
     *
     * @param string $messageInline
     * @return Savedreplies
     */
    public function setMessageInline($messageInline)
    {
        $this->messageInline = $messageInline;

        return $this;
    }

    /**
     * Get messageInline
     *
     * @return string 
     */
    public function getMessageInline()
    {
        return $this->messageInline;
    }
    /**
     * @var string
     * @ORM\Column(name="template_for", type="string", nullable=true, options={"default": null})
     */
    private $templateFor;


    /**
     * Set templateFor
     *
     * @param string $templateFor
     * @return Savedreplies
     */
    public function setTemplateFor($templateFor)
    {
        $this->templateFor = $templateFor;

        return $this;
    }

    /**
     * Get templateFor
     *
     * @return string 
     */
    public function getTemplateFor()
    {
        return $this->templateFor;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="SupportGroup")
     * @ORM\JoinTable(name="uv_saved_replies_groups",
     *      joinColumns={@ORM\JoinColumn(name="savedReply_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="CASCADE")},
     * )
     * 
     */
    private $groups;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add groups
     *
     * @return Savedreplies
     */
    public function addSupportGroup(\Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Webkul\UserBundle\Entity\UserGroup $groups
     */
    public function removeSupportGroups(\Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSupportGroups()
    {
        return $this->groups;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="SupportTeam")
     * @ORM\JoinTable(name="uv_saved_replies_teams",     
     *      joinColumns={@ORM\JoinColumn(name="savedReply_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="subgroup_id", referencedColumnName="id", onDelete="CASCADE")},
     * )
     */
    private $teams;


    /**
     * Add teams
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam $teams
     * @return EmailTemplatesCompany
     */
    public function addSupportTeam(\Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam $teams)
    {
        $this->teams[] = $teams;

        return $this;
    }

    /**
     * Remove teams
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam $teams
     */
    public function removeSupportTeam(\Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam $teams)
    {
        $this->teams->removeElement($teams);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSupportTeams()
    {
        return $this->teams;
    }
}
