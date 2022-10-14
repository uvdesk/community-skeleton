<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package;

interface PackageInterface
{
    public function setMetadata(PackageMetadata $metadata) : PackageInterface;
    public function getMetadata() : PackageMetadata;
}
