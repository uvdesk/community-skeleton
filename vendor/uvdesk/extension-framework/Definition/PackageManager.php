<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Definition;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\ModuleInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\ApplicationInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package\PackageMetadata;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package\PackageInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\ConfigurablePackageInterface;

class PackageManager
{
	private $packages = [];
	private $applications = [];
	private $organizedCollection = [];

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->pathToPackageConfigurations = $container->getParameter("kernel.project_dir") . "/config/extensions";
	}

	public function autoconfigure()
	{
		$twigLoader = $this->container->get('uvdesk_extension.twig_loader');

		foreach ($this->packages as $package) {
			$metadata = $package->getMetadata();
			$class = new \ReflectionClass($package);

			$pathToExtensionsTwigResources = dirname($class->getFileName()) . "/Resources/views";

			if (is_dir($pathToExtensionsTwigResources)) {
				$twigLoader->addPath($pathToExtensionsTwigResources, sprintf("_uvdesk_extension_%s_%s", $metadata->getVendor(), $metadata->getPackage()));
			}
		}
	}

	public function getPackages()
	{
		return $this->packages;
	}

	public function getApplications() : array
	{
		return $this->applications;
	}

	public function getApplicationByReference($reference) : ApplicationInterface
	{
		if (empty($this->applications[$reference])) {
			throw new \Exception('No application found');
		}

		return $this->applications[$reference];
	}

	public function getApplicationByAttributes($vendor, $extension, $qualifiedName) : ApplicationInterface
	{
		if (empty($this->organizedCollection[$vendor][$extension])) {
			throw new \Exception(sprintf("No applications found under the %s/%s extension namespace", $vendor, $extension));
		} else if (empty($this->organizedCollection[$vendor][$extension][$qualifiedName])) {
			throw new \Exception(sprintf("No application %s found under the %s/%s extension namespace", $qualifiedName, $vendor, $extension));
		}

		return $this->organizedCollection[$vendor][$extension][$qualifiedName];
	}
}
