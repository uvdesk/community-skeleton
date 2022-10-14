<?php

namespace Webkul\UVDesk\SupportCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleTags
 * @ORM\Entity(repositoryClass=null)
 * @ORM\Table(name="uv_article_tags")
 */
class ArticleTags
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
    private $articleId;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $tagId;


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
     * @return ArticleTags
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
     * Set tagId
     *
     * @param integer $tagId
     * @return ArticleTags
     */
    public function setTagId($tagId)
    {
        $this->tagId = $tagId;

        return $this;
    }

    /**
     * Get tagId
     *
     * @return integer 
     */
    public function getTagId()
    {
        return $this->tagId;
    }
}
