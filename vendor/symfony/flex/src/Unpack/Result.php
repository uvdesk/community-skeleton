<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Flex\Unpack;

use Composer\Package\PackageInterface;

class Result
{
    private $unpacked = [];
    private $required = [];

    public function addUnpacked(PackageInterface $package)
    {
        $this->unpacked[] = $package;
    }

    /**
     * @return PackageInterface[]
     */
    public function getUnpacked(): array
    {
        return $this->unpacked;
    }

    public function addRequired(string $package)
    {
        $this->required[] = $package;
    }

    /**
     * @return string[]
     */
    public function getRequired(): array
    {
        // we need at least one package for the command to work properly
        return $this->required ?: ['symfony/flex'];
    }
}
