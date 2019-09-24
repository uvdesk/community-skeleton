<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Console;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package\PackageMetadata;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package\PackageInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package\ConfigurablePackageInterface;

class BuildExtensions extends Command
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('uvdesk_extensions:configure-extensions');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ('dev' != $this->container->get('kernel')->getEnvironment()) {
            $output->writeln("\n<comment>This command is only allowed to be used in development environment.</comment>");

            return;
        }

        $metadata = $this->prepareMetadata();
        $lockfile = $this->updateLockfile($metadata);

        $this->updateComposerJson($lockfile, $output);
        $this->autoconfigurePackages($metadata, $output);
    }

    private function prepareMetadata()
    {
        $metadata = [];
        $path = $this->container->getParameter('uvdesk_extensions.dir');

        if (!file_exists($path) || !is_dir($path)) {
            throw new \Exception("No apps directory found. Looked in $path");
        }

        foreach (array_diff(scandir($path), ['.', '..']) as $vendor) {
            $directory = "$path/$vendor";

            if (file_exists($directory) && is_dir($directory)) {
                foreach (array_diff(scandir($directory), ['.', '..']) as $package) {
                    $root = "$directory/$package";
    
                    if (file_exists($root) && is_dir($root)) {
                        $packageMetadata = new PackageMetadata($root);

                        if ($vendor != $packageMetadata->getVendor() || $package != $packageMetadata->getPackage()) {
                            throw new \Exception("Invalid package extension.json file. The qualified package name should be '$vendor/$package' but the specified name is '" . $packageMetadata->getName() . "'");
                        }

                        $metadata[] = $packageMetadata;
                    }
                }
            }
        }

        // Sort packages alphabetically
        usort($metadata, function($data_a, $data_b) {
			return strcasecmp($data_a->getName(), $data_b->getName());
        });

        return $metadata;
    }

    private function updateLockfile(array $metadata = [])
    {
        $lockfile = [
            '_readme' => [
                "This file locks the dependencies of your project to a known state",
                "This file is @generated automatically. Avoid making changes to this file directly.",
            ],
            'packages' => array_map(function ($packageMetadata) {
                return [
                    'name' => $packageMetadata->getName(),
                    'description' => $packageMetadata->getDescription(),
                    'type' => $packageMetadata->getType(),
                    'autoload' => $packageMetadata->getDefinedNamespaces(),
                    'package' => $packageMetadata->getPackageReferences(),
                ];;
            }, $metadata),
        ];

        $path = $this->container->getParameter('kernel.project_dir') . "/uvdesk.lock";
        file_put_contents($path, json_encode($lockfile, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return $lockfile;
    }

    private function updateComposerJson(array $lockfile = [], $output)
    {
        $path = $this->container->getParameter('kernel.project_dir') . "/composer.json";
        $prefix = str_ireplace($this->container->getParameter('kernel.project_dir') . "/", "", $this->container->getParameter('uvdesk_extensions.dir'));
        
        $json = json_decode(file_get_contents($path), true);
        $psr4_current = $psr4_modified = $json['autoload']['psr-4'] ?? [];

        foreach ($lockfile['packages'] as $package) {
            foreach ($package['autoload'] as $namespace => $relativePath) {
                $psr4_modified[$namespace] = "$prefix/" . $package['name'] . "/" . $relativePath;
            }
        }

        if (array_diff($psr4_modified, $psr4_current) != null) {
            $json['autoload']['psr-4'] = $psr4_modified;
            file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            $output->writeln("New extensions have been found and added to composer.json. Dumping composer autoloader...\n");

            shell_exec('composer dump-autoload');
        }
    }

    private function getUnloadedReflectionClass(string $class, PackageMetadata $metadata) : \ReflectionClass
    {
        try {
            $reflectionClass = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            $classPath = null;
            $iterations = explode('\\', $class);

            foreach ($metadata->getDefinedNamespaces() as $namespace => $path) {
                $depth = 1;
                $namespaceIterations = explode('\\', $namespace);

                foreach ($iterations as $index => $iteration) {
                    if (empty($namespaceIterations[$index]) || $namespaceIterations[$index] != $iteration) {
                        break;
                    }

                    $depth++;
                }

                if (0 === (count($namespaceIterations) - $depth)) {
                    $path .= str_ireplace([$namespace, "\\"], ["", "/"], $class);
                    $classPath = $metadata->getRoot() . "/$path.php";
                    break;
                }
            }
        } finally {
            if (empty($reflectionClass) && !empty($classPath)) {
                include_once $classPath;

                $reflectionClass = new \ReflectionClass($class);
            } else if (empty($reflectionClass)) {
                throw new \Exception("Class $class does not exist");
            }
        }

        return $reflectionClass;
    }

    private function autoconfigurePackages(array $metadata = [], $output)
    {
        $pathToConfig = $this->container->getParameter('kernel.project_dir') . "/config/extensions";
        $pathToDoctrineConfig = $this->container->getParameter('kernel.project_dir') . "/config/packages/doctrine.yaml";

        if (!file_exists($pathToConfig) || !is_dir($pathToConfig)) {
            mkdir($pathToConfig, 0755, true);
        }

        if (file_exists($pathToDoctrineConfig)) {
            $expiredNamespaces = [];
            $doctrine = Yaml::parseFile($pathToDoctrineConfig);
            $doctrineMappings = $doctrine['doctrine']['orm']['mappings'];

            // Filter out existing community package configurations
            foreach ($doctrineMappings as $namespace => $mappingDetails) {
                $namespaceIterations = explode('\\', $namespace);

                if (count($namespaceIterations) >= 2) {
                    if ('UVDesk' == $namespaceIterations[0] && 'CommunityPackages' == $namespaceIterations[1]) {
                        $expiredNamespaces[] = $namespace;
                    }
                }
            }

            foreach ($expiredNamespaces as $namespace) {
                unset($doctrineMappings[$namespace]);
            }
        }

        foreach ($metadata as $packageMetadata) {
            $class = current(array_keys($packageMetadata->getPackageReferences()));
            $packageReflectionClass = $this->getUnloadedReflectionClass($class, $packageMetadata);
            
            if (!$packageReflectionClass->implementsInterface(PackageInterface::class)) {
                throw new \Exception("Class $class could not be registered as an package. Please check that it implements the " . PackageInterface::class . " interface.");
            }

            if (!empty($doctrineMappings)) {
                $packageDoctrineMetadata = $this->getPackageDoctrineMetadata($packageMetadata);

                if (!empty($packageDoctrineMetadata)) {
                    $namespace = current(array_keys($packageDoctrineMetadata));
                    $doctrineMappings[$namespace] = $packageDoctrineMetadata[$namespace];
                }
            }

            if ($packageReflectionClass->implementsInterface(ConfigurablePackageInterface::class)) {
                $configurablePackage = $packageReflectionClass->newInstanceWithoutConstructor();
                $configurablePackage->setConfigurationFilepath($pathToConfig . "/" . str_replace(['/', '-'], '_', $packageMetadata->getName()) . ".yaml");

                if (!file_exists($configurablePackage->getConfigurationFilepath()) || is_dir($configurablePackage->getConfigurationFilepath())) {
                    $configurablePackage->install();
                }
            }
        }

        if (!empty($doctrine) && !empty($doctrineMappings)) {
            // Add quotes, we will remove later any extra quotes
            foreach ($doctrineMappings as $namespace => $attributes) {
                $attributes['dir'] = "'" . $attributes['dir'] . "'";
                $attributes['prefix'] = "'" . $attributes['prefix'] . "'";

                $doctrineMappings[$namespace] = $attributes;
            }

            $doctrine['doctrine']['orm']['mappings'] = $doctrineMappings;

            $originalContent = file_get_contents($pathToDoctrineConfig);
            $modifiedContent = YAML::dump($doctrine, 6);

            $explodedOriginalContent = preg_split("/\r\n|\n|\r/", $originalContent);
            $explodedModifiedContent = preg_split("/\r\n|\n|\r/", $modifiedContent);

            $incr = 0;
            $skipFlag = false;
            $processedModifiedContent = [];

            foreach ($explodedModifiedContent as $index => $content) {
                if ($skipFlag || !isset($explodedOriginalContent[$index + $incr])) {
                    $processedModifiedContent[] = $content;

                    continue;
                }

                if ('mappings:' == trim($explodedOriginalContent[$index + $incr]) || 'mappings:' == trim($explodedModifiedContent[$index])) {
                    $skipFlag = true;
                    $processedModifiedContent[] = $content;

                    continue;
                } else if ($content == $explodedOriginalContent[$index + $incr]) {
                    $processedModifiedContent[] = $content;
                } else {
                    if (str_replace(['\'', '"'], '', $content) == str_replace(['\'', '"'], '', $explodedOriginalContent[$index + $incr])) {
                        $processedModifiedContent[] = $explodedOriginalContent[$index + $incr];

                        continue;
                    }

                    for ($i = $index + $incr; $i < count($explodedOriginalContent); $i++) {
                        if (trim($explodedModifiedContent[$index]) == trim($explodedOriginalContent[$i])) {
                            $processedModifiedContent[] = $content;
                            break;
                        } else if (str_replace(['\'', '"'], '', trim($explodedModifiedContent[$index])) == str_replace(['\'', '"'], '', trim($explodedOriginalContent[$i]))) {
                            $processedModifiedContent[] = $explodedOriginalContent[$i];
                            break;
                        }

                        $incr++;
                        $processedModifiedContent[] = $explodedOriginalContent[$i];
                    }
                }
            }

            $content = str_replace("'''", "'", implode(PHP_EOL, $processedModifiedContent));
            file_put_contents($pathToDoctrineConfig, $content);
        }
    }

    private function getPackageDoctrineMetadata($packageMetadata)
    {
        $params = [
            'is_bundle' => false,
            'type' => 'annotation',
        ];

        $baseNamespace = current(array_keys($packageMetadata->getDefinedNamespaces()));
        $packageClassPath = current(array_keys($packageMetadata->getPackageReferences()));
        $relativePathToNamespace = $packageMetadata->getDefinedNamespaces()[$baseNamespace];

        $baseNamespace = rtrim($baseNamespace, '\\');
        $pathToNamespace = rtrim($packageMetadata->getRoot(), '/') . "/" . rtrim(ltrim($relativePathToNamespace, '/'), '/') . "/";
        $pathToEntities = $pathToNamespace . "Entity";

        if (file_exists($pathToEntities) && is_dir($pathToEntities)) {
            // Parse qualified vendor name
            $p1 = strrpos($baseNamespace, '\\');
            $p2 = strrpos(substr($baseNamespace, 0, $p1), '\\');
            $vendor = substr($baseNamespace, $p2 + 1, $p1 - $p2 - 1);

            // Parse qualified package name
            $p1 = strrpos($packageClassPath, '\\');
            $package = substr($packageClassPath, $p1 + 1);

            $params['dir'] = str_replace($this->container->getParameter('kernel.project_dir'), '%kernel.project_dir%', $pathToEntities);
            $params['prefix'] = "$baseNamespace\\Entity";
            $params['alias'] = "$vendor$package";

            return [$baseNamespace => $params];
        }

        return null;
    }
}
