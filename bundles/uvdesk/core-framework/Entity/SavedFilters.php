<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SavedFilters
 * @ORM\Entity(repositoryClass="Webkul\UVDesk\CoreFrameworkBundle\Repository\SavedRepliesRepository")
 * @ORM\Table(name="uv_saved_filters")
 * @ORM\HasLifecycleCallbacks()
 */
class SavedFilters
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
     * @ORM\Column(name="name", type="string", length=191)
     */
    private $name;

    /**
     * @var array
     * @ORM\Column(name="filtering", type="text", nullable=true)
     */
    private $filtering;

    /**
     * @var string
     * @ORM\Column(name="route", type="string", length=190, nullable=true)
     */
    private $route;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_added", type="datetime")
     */
    private $dateAdded;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_updated", type="datetime")
     */
    private $dateUpdated;

    /**
     * @var \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance
     * 
     * @ORM\ManyToOne(targetEntity="UserInstance", inversedBy="userSavedFilters")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     * 
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
     * @return SavedFilters
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
     * Set filtering
     *
     * @param array $filtering
     *
     * @return SavedFilters
     */
    public function setFiltering($filtering)
    {
        $this->filtering = serialize($filtering);

        return $this;
    }

    /**
     * Get filtering
     *
     * @return array
     */
    public function getFiltering()
    {
        return unserialize($this->filtering);
    }

    /**
     * Set route
     *
     * @param string $route
     *
     * @return SavedFilters
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set dateAdded
     *
     * @param \DateTime $dateAdded
     *
     * @return SavedFilters
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
     *
     * @return SavedFilters
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
     * Set user
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $user
     *
     * @return SavedFilters
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

