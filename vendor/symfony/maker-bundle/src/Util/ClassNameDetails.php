<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Util;

use Symfony\Bundle\MakerBundle\Str;

final class ClassNameDetails
{
    private $fullClassName;

    private $namespacePrefix;

    private $suffix;

    public function __construct(string $fullClassName, string $namespacePrefix, string $suffix = null)
    {
        $this->fullClassName = $fullClassName;
        $this->namespacePrefix = trim($namespacePrefix, '\\');
        $this->suffix = $suffix;
    }

    public function getFullName(): string
    {
        return $this->fullClassName;
    }

    public function getShortName(): string
    {
        return Str::getShortClassName($this->fullClassName);
    }

    /**
     * Returns the original class name the user entered (after
     * being cleaned up).
     *
     * For example, assuming the namespace is App\Entity:
     *      App\Entity\Admin\User => Admin\User
     *
     * @return string
     */
    public function getRelativeName(): string
    {
        return str_replace($this->namespacePrefix.'\\', '', $this->fullClassName);
    }

    public function getRelativeNameWithoutSuffix(): string
    {
        return Str::removeSuffix($this->getRelativeName(), $this->suffix);
    }
}
