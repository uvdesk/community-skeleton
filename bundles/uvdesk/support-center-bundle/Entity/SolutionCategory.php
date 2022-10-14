<?php

namespace Webkul\UVDesk\SupportCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SolutionCategory
 * @ORM\Entity(repositoryClass="Webkul\UVDesk\SupportCenterBundle\Repository\SolutionCategory")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="uv_solution_category")
 */
class SolutionCategory
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
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $description;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true, options={"default": 1})
     */
    private $sortOrder;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, options={"default": "ascending"}, nullable=true)
     */
    private $sorting;

    /**
     * @var string
     * @ORM\Column(type="datetime")
     */
    private $dateAdded;


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
     * @return SolutionCategory
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
     * @return SolutionCategory
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
     * Set sortOrder.
     *
     * @param int $sortOrder
     *
     * @return SolutionCategory
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
     * Set sorting.
     *
     * @param string $sorting
     *
     * @return SolutionCategory
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;

        return $this;
    }

    /**
     * Get sorting.
     *
     * @return string
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * Set dateAdded.
     *
     * @param string $dateAdded
     *
     * @return SolutionCategory
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded.
     *
     * @return string
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }
    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true, options={"default": 0})
     */
    private $status = 0;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateUpdated;


    /**
     * Set status.
     *
     * @param int|null $status
     *
     * @return SolutionCategory
     */
    public function setStatus($status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return int|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateUpdated.
     *
     * @param \DateTime $dateUpdated
     *
     * @return SolutionCategory
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
}
