<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Doctrine;

/**
 * @internal
 */
abstract class BaseSingleRelation extends BaseRelation
{
    private $isNullable;

    public function isNullable(): bool
    {
        return $this->isNullable;
    }

    public function setIsNullable($isNullable)
    {
        $this->isNullable = $isNullable;

        return $this;
    }
}
