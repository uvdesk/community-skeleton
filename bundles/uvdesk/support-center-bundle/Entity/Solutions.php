<?php

namespace Webkul\UVDesk\SupportCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solutions
 * @ORM\Entity(repositoryClass="Webkul\UVDesk\SupportCenterBundle\Repository\Solutions")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="uv_solutions")
 */
class Solutions
{
    /**
     * @var int
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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $visibility;

    /**
     * @var int
     * @ORM\Column(type="integer", options={"default": 5})
     */
    private $sortOrder;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Solutions
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Solutions
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set visibility.
     *
     * @param string $visibility
     *
     * @return Solutions
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get visibility.
     *
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set sortOrder.
     *
     * @param int $sortOrder
     *
     * @return Solutions
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * Get sortOrder.
     *
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }
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
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $solutionImage;


    /**
     * Set dateAdded.
     *
     * @param \DateTime $dateAdded
     *
     * @return Solutions
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded.
     *
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * Set dateUpdated.
     *
     * @param \DateTime $dateUpdated
     *
     * @return Solutions
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated.
     *
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set solutionImage.
     *
     * @param string|null $solutionImage
     *
     * @return Solutions
     */
    public function setSolutionImage($solutionImage = null)
    {
        $this->solutionImage = $solutionImage;

        return $this;
    }

    /**
     * Get solutionImage.
     *
     * @return string|null
     */
    public function getSolutionImage()
    {
        return $this->solutionImage;
    }
    //file upload   
    public function upload($file, $container)
    {   
        $container->get('file.service')->setRequiredFileSystem();
        $container->get('file.service')->upload($file);
    }

    public function removeUpload($file, $container)
    {   
        if($this->{$file} AND file_exists($this->{$file})){
            //call service
            $container->get('file.service')->removeUpload($file);
        }
    }
}
