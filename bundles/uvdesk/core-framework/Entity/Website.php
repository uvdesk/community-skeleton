<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * website
 * @ORM\Entity(repositoryClass=null)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="uv_website")
 */
class Website
{
    /**
     * @var int
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
     * @ORM\Column(type="string", length=191, unique=true)
     */
    private $code;

    /**
     * @var string
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $logo;

    /**
     * @var string
     * @ORM\Column(type="string", length=191)
     */
    private $themeColor;

    /**
     * @var string
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $favicon;

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
     * @var bool
     * @ORM\Column(type="boolean", nullable=true, options={"default": true})
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $timezone;

    /**
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $timeformat;


    /**
     * Get id
     *
     * @return int
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
     * @return website
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
     * Set code
     *
     * @param string $code
     *
     * @return website
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return website
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

        /**
     * Set themeColor
     *
     * @param string $themeColor
     *
     * @return website
     */
    public function setThemeColor($themeColor)
    {
        $this->themeColor = $themeColor;

        return $this;
    }

    /**
     * Get themeColor
     *
     * @return string
     */
    public function getThemeColor()
    {
        return $this->themeColor;
    }

    /**
     * Set favicon
     *
     * @param string $favicon
     *
     * @return website
     */
    public function setFavicon($favicon)
    {
        $this->favicon = $favicon;

        return $this;
    }

    /**
     * Get favicon
     *
     * @return string
     */
    public function getFavicon()
    {
        return $this->favicon;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return website
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
     * @return website
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return website
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(?string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getTimeformat(): ?string
    {
        return $this->timeformat;
    }

    public function setTimeformat(?string $timeformat): self
    {
        $this->timeformat = $timeformat;

        return $this;
    }
    
}
