<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 * @ORM\Entity(repositoryClass="Webkul\UVDesk\CoreFrameworkBundle\Repository\TicketRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="uv_ticket")
 */
class Ticket
{
    const AGENT_GLOBAL_ACCESS = 'TICKET_GLOBAL';
    const AGENT_GROUP_ACCESS = 'TICKET_GROUP';
    const AGENT_TEAM_ACCESS = 'TICKET_TEAM';
    const AGENT_INDIVIDUAL_ACCESS = 'TICKET_INDIVIDUAL';

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=191)
     */
    private $source;

    /**
     * @var string
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $mailboxEmail;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $subject;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $referenceIds;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $isNew = true;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $isReplied = false;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $isReplyEnabled = true;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $isStarred = false;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $isTrashed = false;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $isAgentViewed = false;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $isCustomerViewed = false;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="Thread", mappedBy="ticket")
     */
    private $threads;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="TicketRating", mappedBy="ticket")
     */
    private $ratings;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="uv_tickets_collaborators",
     *      joinColumns={@ORM\JoinColumn(name="ticket_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $collaborators;

    /**
     * @var \Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketStatus
     * @ORM\ManyToOne(targetEntity="TicketStatus")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status;

    /**
     * @var \Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketPriority
     * @ORM\ManyToOne(targetEntity="TicketPriority")
     * @ORM\JoinColumn(name="priority_id", referencedColumnName="id")
     */
    private $priority;

    /**
     * @var \Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketType
     * @ORM\ManyToOne(targetEntity="TicketType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $type;

    /**
     * @var \Webkul\UVDesk\CoreFrameworkBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $customer;

    /**
     * @var \Webkul\UVDesk\CoreFrameworkBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="agent_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $agent;

    /**
     * @var \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup
     * @ORM\ManyToOne(targetEntity="SupportGroup", inversedBy="tickets")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $supportGroup;

    /**
     * @var \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam
     * @ORM\ManyToOne(targetEntity="SupportTeam")
     * @ORM\JoinColumn(name="subGroup_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $supportTeam;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Tag")
     * @ORM\JoinTable(name="uv_tickets_tags",
     *      joinColumns={@ORM\JoinColumn(name="ticket_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $supportTags;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="SupportLabel")
     * @ORM\JoinTable(name="uv_tickets_labels",
     *      joinColumns={@ORM\JoinColumn(name="ticket_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="label_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $supportLabels;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->threads = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ratings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->supportTags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->supportLabels = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set source
     *
     * @param string $source
     *
     * @return Ticket
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set mailboxEmail
     *
     * @param string $mailboxEmail
     *
     * @return Ticket
     */
    public function setMailboxEmail($mailboxEmail)
    {
        $this->mailboxEmail = $mailboxEmail;

        return $this;
    }

    /**
     * Get mailboxEmail
     *
     * @return string
     */
    public function getMailboxEmail()
    {
        return $this->mailboxEmail;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Ticket
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
     * Set referenceIds
     *
     * @param string $referenceIds
     *
     * @return Ticket
     */
    public function setReferenceIds($referenceIds)
    {
        $this->referenceIds = $referenceIds;

        return $this;
    }

    /**
     * Get referenceIds
     *
     * @return string
     */
    public function getReferenceIds()
    {
        return $this->referenceIds;
    }

    /**
     * Set isNew
     *
     * @param boolean $isNew
     *
     * @return Ticket
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * Get isNew
     *
     * @return boolean
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * Set isReplied
     *
     * @param boolean $isReplied
     *
     * @return Ticket
     */
    public function setIsReplied($isReplied)
    {
        $this->isReplied = $isReplied;

        return $this;
    }

    /**
     * Get isReplied
     *
     * @return boolean
     */
    public function getIsReplied()
    {
        return $this->isReplied;
    }

    /**
     * Set isReplyEnabled
     *
     * @param boolean $isReplyEnabled
     *
     * @return Ticket
     */
    public function setIsReplyEnabled($isReplyEnabled)
    {
        $this->isReplyEnabled = $isReplyEnabled;

        return $this;
    }

    /**
     * Get isReplyEnabled
     *
     * @return boolean
     */
    public function getIsReplyEnabled()
    {
        return $this->isReplyEnabled;
    }

    /**
     * Set isStarred
     *
     * @param boolean $isStarred
     *
     * @return Ticket
     */
    public function setIsStarred($isStarred)
    {
        $this->isStarred = $isStarred;

        return $this;
    }

    /**
     * Get isStarred
     *
     * @return boolean
     */
    public function getIsStarred()
    {
        return $this->isStarred;
    }

    /**
     * Set isTrashed
     *
     * @param boolean $isTrashed
     *
     * @return Ticket
     */
    public function setIsTrashed($isTrashed)
    {
        $this->isTrashed = $isTrashed;

        return $this;
    }

    /**
     * Get isTrashed
     *
     * @return boolean
     */
    public function getIsTrashed()
    {
        return $this->isTrashed;
    }

    /**
     * Set isAgentViewed
     *
     * @param boolean $isAgentViewed
     *
     * @return Ticket
     */
    public function setIsAgentViewed($isAgentViewed)
    {
        $this->isAgentViewed = $isAgentViewed;

        return $this;
    }

    /**
     * Get isAgentViewed
     *
     * @return boolean
     */
    public function getIsAgentViewed()
    {
        return $this->isAgentViewed;
    }

    /**
     * Set isCustomerViewed
     *
     * @param boolean $isCustomerViewed
     *
     * @return Ticket
     */
    public function setIsCustomerViewed($isCustomerViewed)
    {
        $this->isCustomerViewed = $isCustomerViewed;

        return $this;
    }

    /**
     * Get isCustomerViewed
     *
     * @return boolean
     */
    public function getIsCustomerViewed()
    {
        return $this->isCustomerViewed;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Ticket
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Ticket
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add thread
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\Thread $thread
     *
     * @return Ticket
     */
    public function addThread(\Webkul\UVDesk\CoreFrameworkBundle\Entity\Thread $thread)
    {
        $this->threads[] = $thread;

        return $this;
    }

    /**
     * Remove thread
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\Thread $thread
     */
    public function removeThread(\Webkul\UVDesk\CoreFrameworkBundle\Entity\Thread $thread)
    {
        $this->threads->removeElement($thread);
    }

    /**
     * Get threads
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThreads()
    {
        return $this->threads;
    }

    /**
     * Add rating
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketRating $rating
     *
     * @return Ticket
     */
    public function addRating(\Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketRating $rating)
    {
        $this->ratings[] = $rating;

        return $this;
    }

    /**
     * Remove rating
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketRating $rating
     */
    public function removeRating(\Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketRating $rating)
    {
        $this->ratings->removeElement($rating);
    }

    /**
     * Get ratings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * Add collaborators
     *
     * @param \Webkul\UserBundle\Entity\User $collaborators
     * @return Ticket
     */
    public function addCollaborator(\Webkul\UVDesk\CoreFrameworkBundle\Entity\User $collaborators)
    {
        $this->collaborators[] = $collaborators;
        return $this;
    }

    /**
     * Remove collaborators
     *
     * @param \Webkul\UserBundle\Entity\User $collaborators
     */
    public function removeCollaborator(\Webkul\UVDesk\CoreFrameworkBundle\Entity\User $collaborators)
    {
        $this->collaborators->removeElement($collaborators);
    }

    /**
     * Get collaborators
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollaborators()
    {
        return $this->collaborators;
    }

    /**
     * Set status
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketStatus $status
     *
     * @return Ticket
     */
    public function setStatus(\Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set priority
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketPriority $priority
     *
     * @return Ticket
     */
    public function setPriority(\Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketPriority $priority = null)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return \Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketPriority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set type
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketType $type
     *
     * @return Ticket
     */
    public function setType(\Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set customer
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\User $customer
     *
     * @return Ticket
     */
    public function setCustomer(\Webkul\UVDesk\CoreFrameworkBundle\Entity\User $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Webkul\UVDesk\CoreFrameworkBundle\Entity\User
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set agent
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\User $agent
     *
     * @return Ticket
     */
    public function setAgent(\Webkul\UVDesk\CoreFrameworkBundle\Entity\User $agent = null)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return \Webkul\UVDesk\CoreFrameworkBundle\Entity\User
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set supportGroup
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup $supportGroup
     *
     * @return Ticket
     */
    public function setSupportGroup(\Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup $supportGroup = null)
    {
        $this->supportGroup = $supportGroup;

        return $this;
    }

    /**
     * Get supportGroup
     *
     * @return \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup
     */
    public function getSupportGroup()
    {
        return $this->supportGroup;
    }

    /**
     * Set supportTeam
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam $supportTeam
     *
     * @return Ticket
     */
    public function setSupportTeam(\Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam $supportTeam = null)
    {
        $this->supportTeam = $supportTeam;

        return $this;
    }

    /**
     * Get supportTeam
     *
     * @return \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam
     */
    public function getSupportTeam()
    {
        return $this->supportTeam;
    }

    /**
     * Add supportTag
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\Tag $supportTag
     *
     * @return Ticket
     */
    public function addSupportTag(\Webkul\UVDesk\CoreFrameworkBundle\Entity\Tag $supportTag)
    {
        $this->supportTags[] = $supportTag;

        return $this;
    }

    /**
     * Remove supportTag
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\Tag $supportTag
     */
    public function removeSupportTag(\Webkul\UVDesk\CoreFrameworkBundle\Entity\Tag $supportTag)
    {
        $this->supportTags->removeElement($supportTag);
    }

    /**
     * Get supportTags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSupportTags()
    {
        return $this->supportTags;
    }

    /**
     * Add supportLabel
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportLabel $supportLabel
     *
     * @return Ticket
     */
    public function addSupportLabel(\Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportLabel $supportLabel)
    {
        $this->supportLabels[] = $supportLabel;

        return $this;
    }

    /**
     * Remove supportLabel
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportLabel $supportLabel
     */
    public function removeSupportLabel(\Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportLabel $supportLabel)
    {
        $this->supportLabels->removeElement($supportLabel);
    }

    /**
     * Get supportLabels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSupportLabels()
    {
        return $this->supportLabels;
    }

    /**
     * Get formatted $createdAt
     *
     * @return \DateTime
     */
    public function getFormatedCreatedAt()
    {
        return $this->formatedCreatedAt;
    }
}

