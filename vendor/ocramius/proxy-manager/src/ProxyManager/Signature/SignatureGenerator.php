<?php

declare(strict_types=1);

namespace ProxyManager\Signature;

use ProxyManager\Inflector\Util\ParameterEncoder;
use ProxyManager\Inflector\Util\ParameterHasher;

/**
 * {@inheritDoc}
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
final class SignatureGenerator implements SignatureGeneratorInterface
{
    /**
     * @var ParameterEncoder
     */
    private $parameterEncoder;

    /**
     * @var ParameterHasher
     */
    private $parameterHasher;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->parameterEncoder = new ParameterEncoder();
        $this->parameterHasher  = new ParameterHasher();
    }

    /**
     * {@inheritDoc}
     */
    public function generateSignature(array $parameters) : string
    {
        return $this->parameterEncoder->encodeParameters($parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function generateSignatureKey(array $parameters) : string
    {
        return $this->parameterHasher->hashParameters($parameters);
    }
}
