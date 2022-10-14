<?php

namespace Webkul\UVDesk\SupportCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleCategory
 * @ORM\Entity(repositoryClass=null)
 * @ORM\Table(name="uv_article_category")
 * @ORM\HasLifecycleCallbacks
 * 
 */
class ArticleCategory
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    // /**
    //  * @var integer
    //  */
    // private $companyId;

    /**
     * @var integer
     * @ORM\Column(type="integer", name="article_id")
     */
    private $articleId;

    /**
     * @var integer
     * @ORM\Column(type="integer", name="category_id")
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
     * Set articleId
     *
     * @param integer $articleId
     * @return ArticleCategory
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;

        return $this;
    }

    /**
     * Get articleId
     *
     * @return integer 
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     * @return ArticleCategory
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
