<?php

namespace Webkul\UVDesk\PackageManager\Composer;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Console\Output\ConsoleOutput;

final class ComposerPackage
{
    private $extension;
    private $consoleText;
    private $movableResources = [];
    private $combineResources = [];

    private function isArrayAssociative(array $array)
    {
        if ([] === $array) {
            return false;
        }

        return array_keys($array) !== range(0, count($array) - 1);
    }

    private function calculateArrayDepth(array $array)
    {
        $indentationLimit = 1;
        $lines = explode("\n", print_r($array, true));
    
        foreach ($lines as $line) {
            $indentation = (strlen($line) - strlen(ltrim($line))) / 4;
    
            if ($indentation > $indentationLimit) {
                $indentationLimit = $indentation;
            }
        }
    
        return (int) ceil(($indentationLimit - 1) / 2) + 1;
    }

    private function resolveToLowestDepth($array)
    {
        if (is_array($array)) {
            if ($this->calculateArrayDepth($array) > 1) {
                foreach ($array as $index => $element) {
                    if (is_array($element) && $this->calculateArrayDepth($element) === 1) {
                        $array[$index] = $this->isArrayAssociative($element) ? $element : array_unique($element, SORT_REGULAR);
                    } else {
                        $array[$index] = $this->resolveToLowestDepth($element);
                    }
                }
                
            }
            
            if ($this->isArrayAssociative($array)) {
                foreach ($array as $index => $element) {
                    if (is_array($element) && count($element) === 1 && $this->calculateArrayDepth($element) === 1 && false === $this->isArrayAssociative($element)) {
                        $array[$index] = array_pop($element);
                    }
                }

                return $array;
            }

            return $this->isArrayAssociative($array) ? array_filter(array_unique($array, SORT_REGULAR)) : array_values(array_filter(array_unique($array, SORT_REGULAR)));
        }

        return $array;
    }

    public function writeToConsole($packageText = null)
    {
        $this->consoleText = !empty($packageText) && is_string($packageText) ? $packageText : null;

        return $this;
    }

    public function movePackageConfig($destination, $source)
    {
        $this->movableResources[$destination] = $source;

        return $this;
    }

    public function combineProjectConfig($destination, $source)
    {
        $this->combineResources[$destination] = $source;

        return $this;
    }

    public function autoConfigureExtension($installationPath)
    {
        $projectDirectory = getcwd();

        // Dump package resources
        foreach ($this->movableResources as $destination => $source) {
            $resourceSourcePath = "$installationPath/$source";
            $resourceDestinationPath = "$projectDirectory/$destination";

            if (file_exists($resourceSourcePath)) {
                // Create directory if it doesn't exist
                $destinationDirectory = substr($resourceDestinationPath, 0, strrpos($resourceDestinationPath, '/'));
                $missingDirectoryTreePath = substr($destinationDirectory, strlen(getcwd()));

                $baseDirectoryPath = getcwd();
                $missingDirectoryTree = explode("/", $missingDirectoryTreePath);

                foreach (array_filter($missingDirectoryTree) as $directory) {
                    $baseDirectoryPath .= "/$directory";

                    if (!is_dir($baseDirectoryPath)) {
                        mkdir($baseDirectoryPath);
                    }
                }

                // Move the contents of the source file to destination file
                file_put_contents($resourceDestinationPath, file_get_contents($resourceSourcePath));
            }
        }

        // Perform security updates
        if (!empty($this->combineResources)) {
            foreach ($this->combineResources as $sourcePath => $destinationPath) {
                if (file_exists("$installationPath/$destinationPath")) {
                    $config = file_exists("$projectDirectory/$sourcePath") ? Yaml::parseFile("$projectDirectory/$sourcePath") : [];
                    $extensionConfig = Yaml::parseFile("$installationPath/$destinationPath");

                    $config = $this->resolveToLowestDepth(array_merge_recursive($config, $extensionConfig));
                    
                    file_put_contents("$projectDirectory/$sourcePath", Yaml::dump($config, 6));
                }
            }
        }

        return $this;
    }

    public function outputPackageInstallationMessage()
    {
        $console = new ConsoleOutput();
        $console->writeln($this->consoleText);
    }
}