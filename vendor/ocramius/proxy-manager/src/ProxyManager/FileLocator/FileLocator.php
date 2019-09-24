<?php

declare(strict_types=1);

namespace ProxyManager\FileLocator;

use ProxyManager\Exception\InvalidProxyDirectoryException;

/**
 * {@inheritDoc}
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
class FileLocator implements FileLocatorInterface
{
    /**
     * @var string
     */
    protected $proxiesDirectory;

    /**
     * @param string $proxiesDirectory
     *
     * @throws \ProxyManager\Exception\InvalidProxyDirectoryException
     */
    public function __construct(string $proxiesDirectory)
    {
        $absolutePath = realpath($proxiesDirectory);

        if (false === $absolutePath) {
            throw InvalidProxyDirectoryException::proxyDirectoryNotFound($proxiesDirectory);
        }

        $this->proxiesDirectory = $absolutePath;
    }

    /**
     * {@inheritDoc}
     */
    public function getProxyFileName(string $className) : string
    {
        return $this->proxiesDirectory . DIRECTORY_SEPARATOR . str_replace('\\', '', $className) . '.php';
    }
}
