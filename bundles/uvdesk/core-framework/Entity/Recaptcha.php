<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Webkul\UVDesk\CoreFrameworkBundle\Repository\RecaptchaRepository")
 */
class Recaptcha
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siteKey;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $secretKey;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteKey(): ?string
    {
        return $this->siteKey;
    }

    public function setSiteKey(?string $siteKey): self
    {
        $this->siteKey = $siteKey;

        return $this;
    }

    public function getSecretKey(): ?string
    {
        return $this->secretKey;
    }

    public function setSecretKey(?string $secretKey): self
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
