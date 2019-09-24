<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Configurators;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\MappingResource;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package\PackageMetadata;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package\PackageInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Application\ApplicationInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package\ConfigurablePackageInterface;

class Configurator
{
	private $packages = [];
	private $mappingResource;
	private $isConfigured = false;

	public function __construct(ContainerInterface $container, MappingResource $mappingResource)
	{
		$this->container = $container;
		$this->mappingResource = $mappingResource;
	}

    public function configurePackage(PackageInterface $package)
    {
		$metadata = new PackageMetadata();
		$attributes = $this->mappingResource->getPackage(get_class($package));
		
		// Prepare package metadata
		if (empty($attributes['metadata'])) {
			throw new \Exception("Unable to initialize package '" . get_class($package) . "'. Missing package attributes.");
		}

		$root = $this->container->getParameter("uvdesk_extensions.dir") . "/" . $attributes['metadata']['name'];

		$metadata
			->setRoot($root)
			->setName($attributes['metadata']['name'])
			->setDescription($attributes['metadata']['description'])
			->setType($attributes['metadata']['type'])
			->setDefinedNamespaces($attributes['metadata']['autoload']);
		
		foreach ($attributes['metadata']['package'] as $reference => $env) {
			$metadata->addPackageReference($reference, $env);
		}

		$package->setMetadata($metadata);

		if ($package instanceof ConfigurablePackageInterface) {
			$configurationFilepath = $this->container->getParameter("kernel.project_dir") . "/config/extensions/" . str_replace(['/', '-'], '_', $attributes['metadata']['name']) . ".yaml";

			$package->setConfigurationFilepath($configurationFilepath);
			$package->setConfigurationParameters($attributes['configurations']);
		}
	}
	
	public function configureApplication(ApplicationInterface $application)
    {
		$packageReference = $this->getQualifiedPackageReference(get_class($application));

		if (empty($packageReference)) {
			throw new \Exception("Unable to initialize application '" . get_class($application) . "'. No base package found.");
		}

		$application->setPackage($this->container->get($packageReference));
	}

	public function autoconfigure()
	{
		if (false == $this->isConfigured) {
			foreach ($this->mappingResource->getPackages() as $id => $definition) {
				$namespace = substr($id, 0, strrpos($id, '\\'));

				$this->packages[$namespace] = [
					'id' => $id,
					'tags' => $definition['tags'],
					'metadata' => $definition['metadata'],
				];
			}
		}

		return;
	}
	
	private function getQualifiedPackageReference($class) : ?string
	{
		$namespaceCollection = [];

		foreach (explode('\\', $class) as $index => $section) {
			if ($index == 0) {
				$namespaceCollection[$index] = $section;
				continue;
			}

			$namespaceCollection[$index] = $namespaceCollection[$index - 1] . '\\' . $section;
		}

		$namespaceCollection = array_reverse($namespaceCollection);

		foreach ($namespaceCollection as $namespace) {
			if (isset($this->packages[$namespace])) {
				return $this->packages[$namespace]['id'];
			}
		}

		return null;
	}
}
