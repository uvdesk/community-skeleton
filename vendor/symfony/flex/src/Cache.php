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

use Composer\Cache as BaseCache;
use Composer\IO\IOInterface;
use Composer\Semver\Constraint\Constraint;
use Composer\Semver\VersionParser;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class Cache extends BaseCache
{
    private $versions;
    private $versionParser;
    private $symfonyRequire;
    private $symfonyConstraints;
    private $downloader;
    private $io;

    public function setSymfonyRequire(string $symfonyRequire, Downloader $downloader, IOInterface $io = null)
    {
        $this->versionParser = new VersionParser();
        $this->symfonyRequire = $symfonyRequire;
        $this->symfonyConstraints = $this->versionParser->parseConstraints($symfonyRequire);
        $this->downloader = $downloader;
        $this->io = $io;
    }

    public function read($file)
    {
        $content = parent::read($file);

        if (0 === strpos($file, 'provider-symfony$') && \is_array($data = json_decode($content, true))) {
            $content = json_encode($this->removeLegacyTags($data));
        }

        return $content;
    }

    public function removeLegacyTags(array $data): array
    {
        if (!$this->symfonyConstraints || !isset($data['packages'])) {
            return $data;
        }

        foreach ($data['packages'] as $name => $versions) {
            if (!isset($this->getVersions()['splits'][$name])) {
                continue;
            }

            foreach ($versions as $version => $composerJson) {
                if ('dev-master' === $version) {
                    if (null === $devMasterAlias = $versions['dev-master']['extra']['branch-alias']['dev-master'] ?? null) {
                        continue;
                    }

                    $normalizedVersion = $this->versionParser->normalize($devMasterAlias);
                } elseif (!isset($composerJson['version_normalized'])) {
                    continue;
                } else {
                    $normalizedVersion = $composerJson['version_normalized'];
                }

                if (!$this->symfonyConstraints->matches(new Constraint('==', $normalizedVersion))) {
                    if (null !== $this->io) {
                        $this->io->writeError(sprintf('<info>Restricting packages listed in "symfony/symfony" to "%s"</info>', $this->symfonyRequire));
                        $this->io = null;
                    }
                    unset($versions[$version]);
                }
            }

            $data['packages'][$name] = $versions;
        }

        if (null === $symfonySymfony = $data['packages']['symfony/symfony'] ?? null) {
            return $data;
        }

        foreach ($symfonySymfony as $version => $composerJson) {
            if ('dev-master' === $version) {
                $normalizedVersion = $this->versionParser->normalize($composerJson['extra']['branch-alias']['dev-master']);
            } elseif (!isset($composerJson['version_normalized'])) {
                continue;
            } else {
                $normalizedVersion = $composerJson['version_normalized'];
            }

            if (!$this->symfonyConstraints->matches(new Constraint('==', $normalizedVersion))) {
                unset($symfonySymfony[$version]);
            }
        }

        if ($symfonySymfony) {
            $data['packages']['symfony/symfony'] = $symfonySymfony;
        }

        return $data;
    }

    private function getVersions(): array
    {
        if (null !== $this->versions) {
            return $this->versions;
        }

        $versions = $this->downloader->getVersions();
        $this->downloader = null;

        foreach ($versions['splits'] as $name => $vers) {
            foreach ($vers as $i => $v) {
                $v = $this->versionParser->normalize($v);

                if (!$this->symfonyConstraints->matches(new Constraint('==', $v))) {
                    unset($vers[$i]);
                }
            }

            if (!$vers || $vers === $versions['splits'][$name]) {
                unset($versions['splits'][$name]);
            }
        }

        return $this->versions = $versions;
    }
}
