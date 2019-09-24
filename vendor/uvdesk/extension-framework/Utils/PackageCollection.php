<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Utils;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\MappingResource;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package\PackageMetadata;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package\PackageInterface;

class PackageCollection
{
	private $packages = [];
	private $qualifiedPackageNames = [];
	private $packagesByBaseNamespace = [];
	private $packagesByQualifiedName = [];
	private $packagesByQualifiedVendorName = [];

	private $isOrganized = false;

	public function __construct(ContainerInterface $container, MappingResource $mappingResource)
	{
		$this->container = $container;
		$this->mappingResource = $mappingResource;
	}

	public function organizeCollection()
	{
		if ($this->isOrganized) {
			return;
		}

		// Organize packages by vendors, maintain bi-directional reference between package name & classpath.
		$packages = $this->mappingResource->getPackages();

		foreach ($packages as $id => $attributes) {
			// @TODO: Support tags to modify the package
			$qualifiedName = $attributes['metadata']['name'];
			list($vendorName, $packageName) = explode('/', $qualifiedName);
			
			// Derive base namespace where the package lives
			$baseNamespace = substr($id, 0, strrpos($id, '\\'));
			
			$this->packages[$id] = $this->container->get($id);
			$this->qualifiedPackageNames[$id] = $qualifiedName;
			$this->packagesByBaseNamespace[$baseNamespace] = $id;
			$this->packagesByQualifiedName[$qualifiedName] = $id;
			$this->packagesByQualifiedVendorName[$vendorName][$packageName] = $id;
		}

		$this->isOrganized = true;
	}

	public function getQualifiedPackageReference($class) : ?string
	{
		$iterations = [];

		foreach (explode('\\', $class) as $index => $section) {
			if ($index == 0) {
				$iterations[$index] = $section;
				continue;
			}

			$iterations[$index] = $iterations[$index - 1] . '\\' . $section;
		}

		$iterations = array_reverse($iterations);

		foreach ($iterations as $namespace) {
			if (isset($this->packagesByBaseNamespace[$namespace])) {
				return $this->packagesByBaseNamespace[$namespace];
			}
		}

		return null;
	}

	public function getPackageQualifiedName($id) : ?string
	{
		return $this->qualifiedPackageNames[$id] ?? null;
	}

	public function getPackageReferenceByQualifiedName($name) : ?string
	{
		return $this->packagesByQualifiedName[$name] ?? null;
	}

	public function getCollection()
	{
		return array_values($this->packages);
	}

	public function getPackageByAttributes($vendor, $package)
	{
		$orgpackages = [];
		$packages = $this->mappingResource->getPackages();

		foreach ($packages as $id => $attributes) {
			$orgpackages[$attributes['metadata']['name']] = $id;
		}

		dump($vendor, $package);
		dump($packages);
		dump($orgpackages);

		die;

		// dump($this->packageCollection->getPackageByAttributes($vendor, $package));
		// dump($this->mappingResource);
		// die;
	}
}
