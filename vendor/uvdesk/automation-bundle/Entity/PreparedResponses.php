<?php

namespace Webkul\UVDesk\AutomationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PreparedResponses
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Webkul\UVDesk\AutomationBundle\Repository\PreparedResponsesRepository")
 * @ORM\Table(name="uv_prepared_responses")
 */

class PreparedResponses
{
    /**
     * @var integer
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true, options={"default": "public"})
     */
    private $type;

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    private $actions;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true, options={"default": true})
     */
    private $status;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateAdded;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateUpdated;

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
     * @return PreparedResponses
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
     * Set description
     *
     * @param string $description
     * @return PreparedResponses
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return PreparedResponses
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set actions
     *
     * @param array $actions
     * @return PreparedResponses
     */
    public function setActions($actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Get actions
     *
     * @return array 
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return PreparedResponses
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateAdded
     *
     * @param \DateTime $dateAdded
     * @return PreparedResponses
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded
     *
     * @return \DateTime 
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     * @return PreparedResponses
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime 
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->dateAdded = new \DateTime();
        $this->dateUpdated = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->dateUpdated = new \DateTime();
    }
    /**
     * @var \Webkul\UserBundle\Entity\UserData
     * @ORM\ManyToOne(targetEntity="Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $user;


    /**
     * Set user
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $user
     * @return PreparedResponses
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
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup")
     * @ORM\JoinTable(name="uv_prepared_response_support_groups",
     *      joinColumns={@ORM\JoinColumn(name="savedReply_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="CASCADE")}
     *  )
     */
    private $groups;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam")
     * @ORM\JoinTable(name="uv_prepared_response_support_teams",
     *      joinColumns={@ORM\JoinColumn(name="savedReply_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="subgroup_id", referencedColumnName="id", onDelete="CASCADE")}
     *  )
     */
    private $teams;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add groups
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup $groups
     * @return PreparedResponses
     */
    public function addGroup(\Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup $groups
     */
    public function removeGroup(\Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Add teams
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam $teams
     * @return PreparedResponses
     */
    public function addTeam(\Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam $teams)
    {
        $this->teams[] = $teams;

        return $this;
    }

    /**
     * Remove teams
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam $teams
     */
    public function removeTeam(\Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam $teams)
    {
        $this->teams->removeElement($teams);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeams()
    {
        return $this->teams;
    }
}
