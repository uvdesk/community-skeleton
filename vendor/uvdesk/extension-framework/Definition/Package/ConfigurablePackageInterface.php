<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package;

use Symfony\Component\Config\Definition\ConfigurationInterface;

interface ConfigurablePackageInterface extends PackageInterface
{
    public function getConfiguration() : ConfigurationInterface;

    public function setConfigurationFilepath(string $configurationFilepath) : ConfigurablePackageInterface;

    public function getConfigurationFilepath() : string;

    public function setConfigurationParameters(array $configurationParameters) : ConfigurablePackageInterface;

    public function getConfigurationParameters() : array;

    public function install();
}