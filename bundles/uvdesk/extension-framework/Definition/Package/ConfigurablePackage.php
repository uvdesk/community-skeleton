<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package;

use Symfony\Component\Config\Definition\ConfigurationInterface;

abstract class ConfigurablePackage extends Package implements ConfigurablePackageInterface
{
    protected $configurationFilepath;
    protected $configurationParameters = [];

    public abstract function getConfiguration() : ConfigurationInterface;

    final public function setConfigurationFilepath(string $configurationFilepath) : ConfigurablePackageInterface
    {
        if (empty($this->configurationFilepath)) {
            $this->configurationFilepath = $configurationFilepath;
        }

        return $this;
    }

    final public function getConfigurationFilepath() : string
    {
        return $this->configurationFilepath;
    }

    final public function setConfigurationParameters(array $configurationParameters) : ConfigurablePackageInterface
    {
        if (empty($this->configurationParameters)) {
            $this->configurationParameters = $configurationParameters;
        }

        return $this;
    }

    final public function getConfigurationParameters() : array
    {
        return $this->configurationParameters;
    }

    public function install() : void
    {
        return;
    }

    public function updatePackageConfiguration(string $content) : void
    {
        if (empty($content)) {
            throw new \Exception('Configuration file cannot be empty');
        }

        file_put_contents($this->getConfigurationFilepath(), $content);
    }
}