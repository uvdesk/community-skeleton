<?php

namespace Webkul\UVDesk\SupportCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleRelatedArticle
 * @ORM\Entity(repositoryClass=null)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="uv_related_articles")
 */
class ArticleRelatedArticle
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
     * 
     */
    private $companyId;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $articleId;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $relatedArticleId;


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
     * @return ArticleRelatedArticle
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
     * Set relatedArticleId
     *
     * @param integer $relatedArticleId
     * @return ArticleRelatedArticle
     */
    public function setRelatedArticleId($relatedArticleId)
    {
        $this->relatedArticleId = $relatedArticleId;

        return $this;
    }

    /**
     * Get relatedArticleId
     *
     * @return integer 
     */
    public function getRelatedArticleId()
    {
        return $this->relatedArticleId;
    }
}
