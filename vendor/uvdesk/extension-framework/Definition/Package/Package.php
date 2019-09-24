<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package;

abstract class Package implements PackageInterface
{
    protected $metadata;

    final public function setMetadata(PackageMetadata $metadata) : PackageInterface
	{
        $this->metadata = $metadata;

        return $this;
    }
    
    final public function getMetadata() : PackageMetadata
    {
        return $this->metadata;
    }
}