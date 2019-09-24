<?php

declare(strict_types=1);

namespace ProxyManager\Exception;

use UnexpectedValueException;

/**
 * Exception for non writable files
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
class FileNotWritableException extends UnexpectedValueException implements ExceptionInterface
{
    public static function fromInvalidMoveOperation(string $fromPath, string $toPath) : self
    {
        return new self(sprintf(
            'Could not move file "%s" to location "%s": '
            . 'either the source file is not readable, or the destination is not writable',
            $fromPath,
            $toPath
        ));
    }

    /**
     * @deprecated this method is unused, and will be removed in ProxyManager 3.0.0
     */
    public static function fromNonWritableLocation($path) : self
    {
        $messages    = [];
        $destination = realpath($path);

        if (! $destination) {
            $messages[] = 'path does not exist';
        }

        if ($destination && ! is_file($destination)) {
            $messages[] = 'exists and is not a file';
        }

        if ($destination && ! is_writable($destination)) {
            $messages[] = 'is not writable';
        }

        return new self(sprintf('Could not write to path "%s": %s', $path, implode(', ', $messages)));
    }
}
