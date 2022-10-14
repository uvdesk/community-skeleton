<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\EventListener;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Command as SymfonyFrameworkCommand;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\MappingResource;

class Console
{
    private $kernel;
    private $container;

    public function __construct(ContainerInterface $container, KernelInterface $kernel, MappingResource $mappingResource)
    {
        $this->kernel = $kernel;
        $this->container = $container;
        $this->mappingResource = $mappingResource;
    }

    public function onConsoleCommand(ConsoleCommandEvent $event)
    {
        $command = $event->getCommand();

        switch (true) {
            case $command instanceof SymfonyFrameworkCommand\CacheClearCommand:
                // $application = new Application($this->kernel);

                // $application->setAutoExit(false);
                // $application->run(new ArrayInput(['command' => 'uvdesk_extensions:build']), $event->getOutput());
                break;
            case $command instanceof SymfonyFrameworkCommand\AssetsInstallCommand:
                // Update symbolic links between packages
                $this->symlinkAvailablePackageResources();

                break;
            default:
                break;
        }

        return;
    }

    public function onConsoleTerminate(ConsoleTerminateEvent $event)
    {
        return;
    }

    private function scanDirectory(string $path, bool $return_full_path = true)
    {
        if (!file_exists($path) || !is_dir($path)) {
            throw new \Exception("Not a directory : '$path'");
        }

        $scannedFiles = array_diff(scandir($path), ['.', '..']);

        if ($return_full_path) {
            $scannedFiles = array_map(function ($file) use ($path) {
                return "$path/$file";
            }, $scannedFiles);    
        }

        return $scannedFiles;
    }

    private function emptyDirectory(string $path)
    {
        if (!file_exists($path) || !is_dir($path)) {
            throw new \Exception("Not a directory : '$path'");
        }
        
        $scannedFiles = $this->scanDirectory($path);

        if (!empty($scannedFiles)) {
            foreach ($scannedFiles as $filepath) {
                if (!is_dir($filepath) || is_link($filepath)) {
                    unlink($filepath);
                } else {
                    if (null != $this->scanDirectory($filepath)) {
                        $this->emptyDirectory($filepath);
                    }

                    rmdir($filepath);
                }
            }
        }
    }

    private function symlinkAvailablePackageResources()
    {
        $collection = [];
        $prefix = dirname(__DIR__) . '/Resources/public/extensions';
        $prefix = $this->container->getParameter('kernel.project_dir') . '/public/community-packages';

        foreach (array_keys($this->mappingResource->getPackages()) as $id) {
            $packageReflectionClass = new \ReflectionClass($id);
            $attributes = $this->mappingResource->getPackage($id);

            list($vendorName, $packageName) = explode('/', $attributes['metadata']['name']);

            $source = dirname($packageReflectionClass->getFileName()) . '/Resources/public';

            if (file_exists($source) && is_dir($source)) {
                $collection[] = [
                    'source' => $source,
                    'destination' => [
                        'base' => "$prefix/$vendorName",
                        'path' => "$prefix/$vendorName/$packageName",
                    ],
                ];
            }
        }

        // Clear existing resources from extensions directory
        if (file_exists($prefix) && is_dir($prefix)) {
            $this->emptyDirectory($prefix);
        }

        // Link package assets within bundle assets
        foreach ($collection as $package) {
            if (!is_dir($package['destination']['base'])) {
                mkdir($package['destination']['base'], 0755, true);
            }

            symlink($package['source'], $package['destination']['path']);
        }
    }
}
