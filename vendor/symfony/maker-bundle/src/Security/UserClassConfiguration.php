<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Security;

/**
 * Configuration about the user's new User class.
 *
 * @internal
 */
final class UserClassConfiguration
{
    private $isEntity;

    private $identityPropertyName;

    private $hasPassword;

    private $useArgon2 = false;

    private $userProviderClass;

    public function __construct(bool $isEntity, string $identityPropertyName, bool $hasPassword)
    {
        $this->isEntity = $isEntity;
        $this->identityPropertyName = $identityPropertyName;
        $this->hasPassword = $hasPassword;
    }

    public function isEntity(): bool
    {
        return $this->isEntity;
    }

    public function getIdentityPropertyName(): string
    {
        return $this->identityPropertyName;
    }

    public function hasPassword(): bool
    {
        return $this->hasPassword;
    }

    /**
     * @deprecated since MakerBundle 1.12
     */
    public function useArgon2(bool $shouldUse)
    {
        $this->useArgon2 = $shouldUse;
    }

    /**
     * @deprecated since MakerBundle 1.12
     */
    public function shouldUseArgon2(): bool
    {
        return $this->useArgon2;
    }

    public function getUserProviderClass()
    {
        return $this->userProviderClass;
    }

    public function setUserProviderClass(string $userProviderClass)
    {
        if ($this->isEntity()) {
            throw new \LogicException('No custom user class allowed for entity user.');
        }

        $this->userProviderClass = $userProviderClass;
    }
}
