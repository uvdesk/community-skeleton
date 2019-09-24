<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Flex;

use Composer\Repository\ComposerRepository as BaseComposerRepository;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ComposerRepository extends BaseComposerRepository
{
    private $providerFiles;

    protected function loadProviderListings($data)
    {
        if (null !== $this->providerFiles) {
            parent::loadProviderListings($data);

            return;
        }

        $data = [$data];

        while ($data) {
            $this->providerFiles = [];
            foreach ($data as $data) {
                $this->loadProviderListings($data);
            }

            $loadingFiles = $this->providerFiles;
            $this->providerFiles = null;
            $data = [];
            $this->rfs->download($loadingFiles, function (...$args) use (&$data) {
                $data[] = $this->fetchFile(...$args);
            });
        }
    }

    protected function fetchFile($filename, $cacheKey = null, $sha256 = null, $storeLastModifiedTime = false)
    {
        if (null !== $this->providerFiles) {
            $this->providerFiles[] = [$filename, $cacheKey, $sha256, $storeLastModifiedTime];

            return [];
        }

        return parent::fetchFile($filename, $cacheKey, $sha256, $storeLastModifiedTime);
    }
}
