<?php
namespace Doctrine\Common\Proxy;

/**
 * Definition structure how to create a proxy.
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 *
 * @deprecated The Doctrine\Common\Proxy component is deprecated, please use ocramius/proxy-manager instead.
 */
class ProxyDefinition
{
    /**
     * @var string
     */
    public $proxyClassName;

    /**
     * @var array
     */
    public $identifierFields;

    /**
     * @var \ReflectionProperty[]
     */
    public $reflectionFields;

    /**
     * @var callable
     */
    public $initializer;

    /**
     * @var callable
     */
    public $cloner;

    /**
     * @param string   $proxyClassName
     * @param array    $identifierFields
     * @param array    $reflectionFields
     * @param callable $initializer
     * @param callable $cloner
     */
    public function __construct($proxyClassName, array $identifierFields, array $reflectionFields, $initializer, $cloner)
    {
        $this->proxyClassName   = $proxyClassName;
        $this->identifierFields = $identifierFields;
        $this->reflectionFields = $reflectionFields;
        $this->initializer      = $initializer;
        $this->cloner           = $cloner;
    }
}
