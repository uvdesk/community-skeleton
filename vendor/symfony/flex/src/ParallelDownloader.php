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

use Composer\Config;
use Composer\Downloader\TransportException;
use Composer\IO\IOInterface;
use Composer\Util\RemoteFilesystem;

/**
 * Speedup Composer by downloading packages in parallel.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ParallelDownloader extends RemoteFilesystem
{
    private $io;
    private $downloader;
    private $quiet = true;
    private $progress = true;
    private $nextCallback;
    private $downloadCount;
    private $nextOptions = [];
    private $sharedState;
    private $fileName;
    private $lastHeaders;

    public static $cacheNext = false;
    protected static $cache = [];

    public function __construct(IOInterface $io, Config $config, array $options = [], $disableTls = false)
    {
        $this->io = $io;
        if (!method_exists(parent::class, 'getRemoteContents')) {
            $this->io->writeError('Composer >=1.7 not found, downloads will happen in sequence', true, IOInterface::DEBUG);
        } elseif (!\extension_loaded('curl')) {
            $this->io->writeError('ext-curl not found, downloads will happen in sequence', true, IOInterface::DEBUG);
        } else {
            $this->downloader = new CurlDownloader();
        }
        parent::__construct($io, $config, $options, $disableTls);
    }

    public function download(array &$nextArgs, callable $nextCallback, bool $quiet = true, bool $progress = true)
    {
        $previousState = [$this->quiet, $this->progress, $this->downloadCount, $this->nextCallback, $this->sharedState];
        $this->quiet = $quiet;
        $this->progress = $progress;
        $this->downloadCount = \count($nextArgs);
        $this->nextCallback = $nextCallback;
        $this->sharedState = (object) [
            'bytesMaxCount' => 0,
            'bytesMax' => 0,
            'bytesTransferred' => 0,
            'nextArgs' => &$nextArgs,
            'nestingLevel' => 0,
            'maxNestingReached' => false,
            'lastProgress' => 0,
            'lastUpdate' => microtime(true),
        ];

        if (!$this->quiet) {
            if (!$this->downloader && method_exists(parent::class, 'getRemoteContents')) {
                $this->io->writeError('<warning>Enable the "cURL" PHP extension for faster downloads</warning>');
            }

            $note = '';
            if ($this->io->isDecorated()) {
                $note = '\\' === \DIRECTORY_SEPARATOR ? '' : (false !== stripos(PHP_OS, 'darwin') ? '🎵' : '🎶');
                $note .= $this->downloader ? ('\\' !== \DIRECTORY_SEPARATOR ? ' 💨' : '') : '';
            }

            $this->io->writeError('');
            $this->io->writeError(sprintf('<info>Prefetching %d packages</info> %s', $this->downloadCount, $note));
            $this->io->writeError('  - Downloading', false);
            if ($this->progress) {
                $this->io->writeError(' (<comment>0%</comment>)', false);
            }
        }
        try {
            $this->getNext();
            if ($this->quiet) {
                // no-op
            } elseif ($this->progress) {
                $this->io->overwriteError(' (<comment>100%</comment>)');
            } else {
                $this->io->writeError(' (<comment>100%</comment>)');
            }
        } finally {
            if (!$this->quiet) {
                $this->io->writeError('');
            }
            list($this->quiet, $this->progress, $this->downloadCount, $this->nextCallback, $this->sharedState) = $previousState;
        }
    }

    public function getOptions()
    {
        $options = array_replace_recursive(parent::getOptions(), $this->nextOptions);
        $this->nextOptions = [];

        return $options;
    }

    public function setNextOptions(array $options)
    {
        $this->nextOptions = parent::getOptions() !== $options ? $options : [];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastHeaders()
    {
        return $this->lastHeaders ?? parent::getLastHeaders();
    }

    /**
     * {@inheritdoc}
     */
    public function copy($originUrl, $fileUrl, $fileName, $progress = true, $options = [])
    {
        $options = array_replace_recursive($this->nextOptions, $options);
        $this->nextOptions = [];
        $rfs = clone $this;
        $rfs->fileName = $fileName;
        $rfs->progress = $this->progress && $progress;

        try {
            return $rfs->get($originUrl, $fileUrl, $options, $fileName, $rfs->progress);
        } finally {
            $rfs->lastHeaders = null;
            $this->lastHeaders = $rfs->getLastHeaders();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getContents($originUrl, $fileUrl, $progress = true, $options = [])
    {
        return $this->copy($originUrl, $fileUrl, null, $progress, $options);
    }

    /**
     * @internal
     */
    public function callbackGet($notificationCode, $severity, $message, $messageCode, $bytesTransferred, $bytesMax, $nativeDownload = true)
    {
        if (!$nativeDownload && STREAM_NOTIFY_SEVERITY_ERR === $severity) {
            throw new TransportException($message, $messageCode);
        }

        parent::callbackGet($notificationCode, $severity, $message, $messageCode, $bytesTransferred, $bytesMax);

        if (!$state = $this->sharedState) {
            return;
        }

        if (STREAM_NOTIFY_FILE_SIZE_IS === $notificationCode) {
            ++$state->bytesMaxCount;
            $state->bytesMax += $bytesMax;
        }

        if (!$bytesMax || STREAM_NOTIFY_PROGRESS !== $notificationCode) {
            if ($state->nextArgs && !$nativeDownload) {
                $this->getNext();
            }

            return;
        }

        if (0 < $state->bytesMax) {
            $progress = $state->bytesMaxCount / $this->downloadCount;
            $progress *= 100 * ($state->bytesTransferred + $bytesTransferred) / $state->bytesMax;
        } else {
            $progress = 0;
        }

        if ($bytesTransferred === $bytesMax) {
            $state->bytesTransferred += $bytesMax;
        }

        if (null !== $state->nextArgs && !$this->quiet && $this->progress && 1 <= $progress - $state->lastProgress) {
            $progressTime = microtime(true);

            if (5 <= $progress - $state->lastProgress || 1 <= $progressTime - $state->lastUpdate) {
                $state->lastProgress = $progress;
                $this->io->overwriteError(sprintf(' (<comment>%d%%</comment>)', $progress), false);
                $state->lastUpdate = microtime(true);
            }
        }

        if (!$nativeDownload || !$state->nextArgs || $bytesTransferred === $bytesMax || $state->maxNestingReached) {
            return;
        }

        if (5 < $state->nestingLevel) {
            $state->maxNestingReached = true;
        } else {
            $this->getNext();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getRemoteContents($originUrl, $fileUrl, $context, array &$responseHeaders = null)
    {
        if (isset(self::$cache[$fileUrl])) {
            self::$cacheNext = false;

            $result = self::$cache[$fileUrl];

            if (3 < \func_num_args()) {
                list($responseHeaders, $result) = $result;
            }

            return $result;
        }

        if (self::$cacheNext) {
            self::$cacheNext = false;

            if (3 < \func_num_args()) {
                $result = $this->getRemoteContents($originUrl, $fileUrl, $context, $responseHeaders);
                self::$cache[$fileUrl] = [$responseHeaders, $result];
            } else {
                $result = $this->getRemoteContents($originUrl, $fileUrl, $context);
                self::$cache[$fileUrl] = $result;
            }

            return $result;
        }

        if (!$this->downloader) {
            return parent::getRemoteContents($originUrl, $fileUrl, $context, $responseHeaders);
        }

        try {
            $result = $this->downloader->get($originUrl, $fileUrl, $context, $this->fileName);

            if (3 < \func_num_args()) {
                list($responseHeaders, $result) = $result;
            }

            return $result;
        } catch (TransportException $e) {
            $this->io->writeError('Retrying download: '.$e->getMessage(), true, IOInterface::DEBUG);

            return parent::getRemoteContents($originUrl, $fileUrl, $context, $responseHeaders);
        } catch (\Throwable $e) {
            $responseHeaders = [];
            throw $e;
        }
    }

    private function getNext()
    {
        $state = $this->sharedState;
        ++$state->nestingLevel;

        try {
            while ($state->nextArgs && (!$state->maxNestingReached || 1 === $state->nestingLevel)) {
                try {
                    $state->maxNestingReached = false;
                    ($this->nextCallback)(...array_shift($state->nextArgs));
                } catch (TransportException $e) {
                    $this->io->writeError('Skipping download: '.$e->getMessage(), true, IOInterface::DEBUG);
                }
            }
        } finally {
            --$state->nestingLevel;
        }
    }
}
