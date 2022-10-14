<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 * @ORM\Entity(repositoryClass="Webkul\UVDesk\CoreFrameworkBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="uv_user")
 */
class User implements UserInterface
{
    /**
     * @var integer
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=191, unique=true, nullable=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=191, unique=true, nullable=true)
     */
    private $proxyId;

    /**
     * @var string
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(type="string", length=191)
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $lastName;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $isEnabled;

    /**
     * @var string
     * @ORM\Column(type="string", length=191, unique=true, nullable=true)
     */
    private $verificationCode;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="UserInstance", mappedBy="user")
     */
    private $userInstance;

    /**
     * @var array
     */
    private $grantedRoles = [];

    /**
     * @var \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance
     */
    private $activeInstance;

     /**
     * @var string
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $timezone;

    /**
     * @var string
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $timeformat;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userInstance = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set proxyId
     *
     * @param string $proxyId
     *
     * @return User
     */
    public function setProxyId($proxyId)
    {
        $this->proxyId = $proxyId;

        return $this;
    }

    /**
     * Get proxyId
     *
     * @return string
     */
    public function getProxyId()
    {
        return $this->proxyId;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Set user instance's granted roles
     *
     * @param array $grantedRoles
     *
     * @return User
     */
    public function setRoles(array $grantedRoles = [])
    {
        $this->grantedRoles = $grantedRoles;

        return $this;
    }

    /**
     * Get user's granted roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->grantedRoles;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return trim(implode(' ', array($this->getFirstName(), $this->getLastName())));
    }

    /**
     * Set isEnabled
     *
     * @param boolean $isEnabled
     *
     * @return User
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    /**
     * Get isEnabled
     *
     * @return boolean
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Set verificationCode
     *
     * @param string $verificationCode
     *
     * @return User
     */
    public function setVerificationCode($verificationCode)
    {
        $this->verificationCode = $verificationCode;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getVerificationCode()
    {
        return $this->verificationCode;
    }

    /**
     * Clears not so important user's credentials
     *
     * @return void
     */
    public function eraseCredentials()
    {
        return;
    }

    /**
     * Checks whether the user's account has expired
     *
     * @return bool
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked
     *
     * @return bool
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Checks whether the user's credentials has expired
     *
     * @return bool
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Add userInstance
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $userInstance
     *
     * @return User
     */
    public function addUserInstance(\Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $userInstance)
    {
        $this->userInstance[] = $userInstance;

        return $this;
    }

    /**
     * Remove userInstance
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $userInstance
     */
    public function removeUserInstance(\Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $userInstance)
    {
        $this->userInstance->removeElement($userInstance);
    }

    /**
     * Get userInstance
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserInstance()
    {
        return $this->userInstance;
    }

    public function getAgentInstance()
    {
        foreach ($this->getUserInstance()->getValues() as $userInstance) {
            if (in_array($userInstance->getSupportRole()->getCode(), ['ROLE_AGENT', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN'])) {
                return $userInstance;
            }
        }

        return null;
    }

    public function getCustomerInstance()
    {
        foreach ($this->getUserInstance()->getValues() as $userInstance) {
            if ('ROLE_CUSTOMER' === $userInstance->getSupportRole()->getCode()) {
                return $userInstance;
            }
        }

        return null;
    }

    /**
     * Set currently active user instance
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $userInstance
     *
     * @return User
     */
    public function setCurrentInstance(\Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance $userInstance = null)
    {
        $this->activeInstance = $userInstance;

        return $this;
    }

    /**
     * Get currently active user instance
     *
     * @return \Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance
     */
    public function getCurrentInstance()
    {
        return $this->activeInstance;
    }


    /**
     * Set timezone
     *
     * @param string $timezone
     * @return User
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set timeformat
     *
     * @param string $timeformat
     * @return User
     */
    public function setTimeformat($timeformat)
    {
        $this->timeformat = $timeformat;
        return $this;
    }

    /**
     * Get timeformat
     *
     * @return string
     */
    public function getTimeformat()
    {
        return $this->timeformat;
    }
}

