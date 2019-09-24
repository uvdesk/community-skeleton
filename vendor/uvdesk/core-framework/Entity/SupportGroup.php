<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SupportGroup
 * @ORM\Entity(repositoryClass="Webkul\UVDesk\CoreFrameworkBundle\Repository\SupportGroupRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="uv_support_group")
 */
class SupportGroup
{
    /**
     * @var integer
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=191)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var boolean
     * @ORM\Column(name="is_active", type="boolean", options={"default": false})
     */
    private $isActive = false;

    /**
     * @var boolean
     * @ORM\Column(name="user_view", type="boolean", options={"default": false})
     */
    private $userView = false;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="UserInstance", mappedBy="supportGroups")
     */
    private $users;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="UserInstance", mappedBy="adminSupportGroups")
     */
    private $admins;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="SupportTeam", inversedBy="supportGroups")
     * @ORM\JoinTable(
     *      name="uv_support_groups_teams",
     *      joinColumns={@ORM\JoinColumn(name="supportGroup_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="supportTeam_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $supportTeams;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->admins = new \Doctrine\Common\Collections\ArrayCollection();
        $this->supportTeams = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return SupportGroup
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
     *
     * @return SupportGroup
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return SupportGroup
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return SupportGroup
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set userView
     *
     * @param boolean $userView
     *
     * @return SupportGroup
     */
    public function setUserView($userView)
    {
        $this->userView = $userView;

        return $this;
    }

    /**
     * Get userView
     *
     * @return boolean
     */
    public function getUserView()
    {
        return $this->userView;
    }

    /**
     * Add user
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $user
     *
     * @return SupportGroup
     */
    public function addUser(\Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $user
     */
    public function removeUser(\Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add admin
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $admin
     *
     * @return SupportGroup
     */
    public function addAdmin(\Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $admin)
    {
        $this->admins[] = $admin;

        return $this;
    }

    /**
     * Remove admin
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $admin
     */
    public function removeAdmin(\Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $admin)
    {
        $this->admins->removeElement($admin);
    }

    /**
     * Get admins
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdmins()
    {
        return $this->admins;
    }

    /**
     * Add supportTeam
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam $supportTeam
     *
     * @return SupportGroup
     */
    public function addSupportTeam(\Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam $supportTeam)
    {
        $this->supportTeams[] = $supportTeam;

        return $this;
    }

    /**
     * Remove supportTeam
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam $supportTeam
     */
    public function removeSupportTeam(\Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam $supportTeam)
    {
        $this->supportTeams->removeElement($supportTeam);
    }

    /**
     * Get supportTeams
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSupportTeams()
    {
        return $this->supportTeams;
    }
    /**
     * @ORM\PrePersist
     */
    public function initializeTimestamp()
    {
        $this->createdAt = new \DateTime('now');
    }
}

