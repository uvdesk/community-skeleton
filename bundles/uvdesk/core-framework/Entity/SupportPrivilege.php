<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SupportPrivilege
 * @ORM\Entity(repositoryClass="Webkul\UVDesk\CoreFrameworkBundle\Repository\SupportPrivilegeRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="uv_support_privilege")
 */
class SupportPrivilege
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
     * @ORM\Column(type="string", length=191)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    private $privileges;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="UserInstance", mappedBy="supportPrivileges")
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return SupportPrivilege
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
     * @return SupportPrivilege
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
     * Set privileges
     *
     * @param array $privileges
     *
     * @return SupportPrivilege
     */
    public function setPrivileges($privileges)
    {
        $this->privileges = $privileges;

        return $this;
    }

    /**
     * Get privileges
     *
     * @return array
     */
    public function getPrivileges()
    {
        return $this->privileges;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return SupportPrivilege
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
     * Add user
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $user
     *
     * @return SupportPrivilege
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
     * @ORM\PrePersist
     */
    public function initializeTimestamp()
    {
        $this->createdAt = new \DateTime('now');
    }
}

