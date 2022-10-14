<?php

namespace Webkul\UVDesk\SupportCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup;

/**
 * @ORM\Entity(repositoryClass="Webkul\UVDesk\SupportCenterBundle\Repository\AnnouncementRepository")
 */
class Announcement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $group;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $promoText;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $promoTag;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tagColor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $linkText;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $linkUrl;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroup(): ?SupportGroup
    {
        return $this->group;
    }

    public function setGroup(?SupportGroup $group): self
    {
        $this->group = $group;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPromoText(): ?string
    {
        return $this->promoText;
    }

    public function setPromoText(string $promoText): self
    {
        $this->promoText = $promoText;

        return $this;
    }

    public function getPromoTag(): ?string
    {
        return $this->promoTag;
    }

    public function setPromoTag(string $promoTag): self
    {
        $this->promoTag = $promoTag;

        return $this;
    }

    public function getTagColor(): ?string
    {
        return $this->tagColor;
    }

    public function setTagColor(?string $tagColor): self
    {
        $this->tagColor = $tagColor;

        return $this;
    }

    public function getLinkText(): ?string
    {
        return $this->linkText;
    }

    public function setLinkText(string $linkText): self
    {
        $this->linkText = $linkText;

        return $this;
    }

    public function getLinkUrl(): ?string
    {
        return $this->linkUrl;
    }

    public function setLinkUrl(string $linkUrl): self
    {
        $this->linkUrl = $linkUrl;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
