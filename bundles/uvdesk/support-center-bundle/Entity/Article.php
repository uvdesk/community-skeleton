<?php

namespace Webkul\UVDesk\SupportCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Article
 * @ORM\Entity(repositoryClass="Webkul\UVDesk\SupportCenterBundle\Repository\Article")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="uv_article", indexes={@ORM\Index(name="search_idx", columns={"slug"})})
 */
class Article
{
    /**
     * @var integer
     * @ORM\Id
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
    private $slug;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var string
     */
    public $contentFile;
    
    /**
     * @var string
     * @ORM\Column(type="text", length=2000, nullable=true, name="meta_description")
     */
    private $metaDescription;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $keywords;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $viewed;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true, options={"default": 0})
     */
    private $status;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="date_added")
     */
    private $dateAdded;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="date_updated")
     */
    private $dateUpdated;

    /**
     * @var array
     */
    public $category;


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
     * @return Article
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
     * Set slug
     *
     * @param string $slug
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     * @return Article
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string 
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     * @return Article
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set viewed
     *
     * @param integer $viewed
     * @return Article
     */
    public function setViewed($viewed)
    {
        $this->viewed = $viewed;

        return $this;
    }

    /**
     * Get viewed
     *
     * @return integer 
     */
    public function getViewed()
    {
        return $this->viewed;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Article
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateAdded
     *
     * @param \DateTime $dateAdded
     * @return Article
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
     * @return Article
     * 
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

    public function setFileHtmlToContent()
    {   
        if (null === $this->contentFile || !($this->contentFile instanceof UploadedFile))
            $this->setContent('');
        else{
            $this->setContent(file_get_contents($this->contentFile->getRealPath()));
        }
    }

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stared;


    /**
     * Set stared
     *
     * @param integer $stared
     * @return Article
     */
    public function setStared($stared)
    {
        $this->stared = $stared;

        return $this;
    }

    /**
     * Get stared
     *
     * @return integer 
     */
    public function getStared()
    {
        return $this->stared;
    }
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $metaTitle;


    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     * @return Article
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string 
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }
}
