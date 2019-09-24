<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Definition;

class MappingResource
{
    private $packages = [];
    private $applications = [];

    public function setPackage($id, array $tags)
    {
        $this->packages[$id]['tags'] = $tags;
    }

    public function setPackageMetadata($id, array $metadata)
    {
        $this->packages[$id]['metadata'] = $metadata;
    }

    public function setPackageConfigurations($id, array $configurations)
    {
        $this->packages[$id]['configurations'] = $configurations;
    }

    public function setApplication($id, array $tags)
    {
        $this->applications[$id]['tags'] = $tags;
    }

    public function getPackage($id)
    {
        return $this->packages[$id];
    }

    public function getPackages()
    {
        return $this->packages;
    }

    public function getApplications()
    {
        return $this->applications;
    }
}
