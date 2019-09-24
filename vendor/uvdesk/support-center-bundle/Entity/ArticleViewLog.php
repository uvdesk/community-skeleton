<?php

namespace Webkul\UVDesk\SupportCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleViewLog
 * @ORM\Entity(repositoryClass=null)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="uv_article_view_log")
 */
class ArticleViewLog
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $viewedAt;

    /**
     * @var \Webkul\UserBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="Webkul\UVDesk\CoreFrameworkBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    private $user;

    /**
     * @var \Webkul\SupportCenterBundle\Entity\Article
     * @ORM\ManyToOne(targetEntity="Webkul\UVDesk\SupportCenterBundle\Entity\Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $article;


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
     * Set viewedAt
     *
     * @param \DateTime $viewedAt
     * @return ArticleViewLog
     */
    public function setViewedAt($viewedAt)
    {
        $this->viewedAt = $viewedAt;

        return $this;
    }

    /**
     * Get viewedAt
     *
     * @return \DateTime 
     */
    public function getViewedAt()
    {
        return $this->viewedAt;
    }

    /**
     * Set user
     *
     * @param \Webkul\UserBundle\Entity\User $user
     * @return ArticleViewLog
     */
    public function setUser(\Webkul\UVDesk\CoreFrameworkBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Webkul\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

   

    /**
     * Set article
     *
     * @param \Webkul\SupportCenterBundle\Entity\Article $article
     * @return ArticleViewLog
     */
    public function setArticle(\Webkul\UVDesk\SupportCenterBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Webkul\SupportCenterBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }
}
