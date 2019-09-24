<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Utils;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\MappingResource;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package\PackageInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Application\ApplicationInterface;

class ApplicationCollection
{
	private $applications = [];
	private $fullyQualifiedApplicationNames = [];
	private $applicationsByFullyQualifiedName = [];
	private $applicationsByQualifiedPackageName = [];

	private $isOrganized = false;

	public function __construct(ContainerInterface $container, MappingResource $mappingResource, PackageCollection $packageCollection)
	{
		$this->container = $container;
		$this->mappingResource = $mappingResource;
		$this->packageCollection = $packageCollection;
	}

	public function organizeCollection()
	{
		if ($this->isOrganized) {
			return;
		}

		// Organize applications by vendors, packages, maintain bi-directional reference between application name & classpath.
		$applications = $this->mappingResource->getApplications();

		foreach ($applications as $id => $tags) {
			// @TODO: Support tags to modify the application
			$class = new \ReflectionClass($id);$application = $class->newInstanceWithoutConstructor();

			$metadata = $application->getMetadata();
			$packageReference = $this->packageCollection->getQualifiedPackageReference($id);
			$packageQualifiedName = $this->packageCollection->getPackageQualifiedName($packageReference);

			$qualifiedName = $metadata->getQualifiedName();
			$fullyQualifiedName = "$packageQualifiedName/$qualifiedName";
			list($vendorName, $packageName) = explode('/', $packageQualifiedName);

			$this->applications[$id] = $this->container->get($id);
			$this->fullyQualifiedApplicationNames[$id] = $fullyQualifiedName;
			$this->applicationsByFullyQualifiedName[$fullyQualifiedName] = $id;
			$this->applicationsByQualifiedPackageName[$vendorName][$packageName][$qualifiedName] = $id;
		}

		$this->isOrganized = true;
	}

	public function getCollection()
	{
		return array_values($this->applications);
	}

	public function findApplicationsByVendor($vendor)
	{
		dump('return applications by vendor name');
		die;
	}

	public function findApplicationsByPackage(PackageInterface $package)
	{
		dump('return applications by package');
		die;
	}

	public function findApplicationByFullyQualifiedName($vendorName, $packageName, $applicationQualifiedName) : ?ApplicationInterface
	{
		$id = $this->applicationsByQualifiedPackageName[$vendorName][$packageName][$applicationQualifiedName] ?? null;

		return !empty($id) ? $this->applications[$id] : null;
	}
}
