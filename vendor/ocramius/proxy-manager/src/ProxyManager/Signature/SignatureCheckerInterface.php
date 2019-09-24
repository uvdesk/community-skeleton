<?php

declare(strict_types=1);

namespace ProxyManager\Signature;

use ReflectionClass;

/**
 * Generator for signatures to be used to check the validity of generated code
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
interface SignatureCheckerInterface
{
    /**
     * Checks whether the given signature is valid or not
     *
     * @return void
     *
     * @throws \ProxyManager\Signature\Exception\InvalidSignatureException
     * @throws \ProxyManager\Signature\Exception\MissingSignatureException
     */
    public function checkSignature(ReflectionClass $class, array $parameters);
}
