<?php

namespace Webkul\UVDesk\SupportCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SolutionCategoryMapping
 * @ORM\Entity
 * @ORM\Table(name="uv_solution_category_mapping")
 */
class SolutionCategoryMapping
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $solutionId;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $categoryId;


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
     * Set solutionId
     *
     * @param integer $solutionId
     * @return SolutionCategoryMapping
     */
    public function setSolutionId($solutionId)
    {
        $this->solutionId = $solutionId;

        return $this;
    }

    /**
     * Get solutionId
     *
     * @return integer 
     */
    public function getSolutionId()
    {
        return $this->solutionId;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     * @return SolutionCategoryMapping
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }
}
