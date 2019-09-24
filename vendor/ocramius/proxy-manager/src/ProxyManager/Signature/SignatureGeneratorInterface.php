<?php

declare(strict_types=1);

namespace ProxyManager\Signature;

/**
 * Generator for signatures to be used to check the validity of generated code
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
interface SignatureGeneratorInterface
{
    /**
     * Generates a signature to be used to verify generated code validity
     */
    public function generateSignature(array $parameters) : string;

    /**
     * Generates a signature key to be looked up when verifying generated code validity
     */
    public function generateSignatureKey(array $parameters) : string;
}
