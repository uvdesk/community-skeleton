<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package;

class PackageMetadata
{
    private static $supportedTypes = ['uvdesk-module'];
    
    public function __construct($root = '')
    {
        if (!empty($root)) {
            $path = "$root/extension.json";

            if (!file_exists($path) || is_dir($path)) {
                throw new \Exception("Unable to initialize package. File '$path' does not exists.");
            }

            $this->setRoot($root);

            foreach (json_decode(file_get_contents($path), true) as $attribute => $value) {
                switch ($attribute) {
                    case 'name':
                        $this->setName($value);
                        break;
                    case 'description':
                        $this->setDescription($value);
                        break;
                    case 'type':
                        $this->setType($value);
                        break;
                    case 'authors':
                        // $this->setName($value);
                        break;
                    case 'autoload':
                        $this->setDefinedNamespaces($value);
                        break;
                    case 'package':
                        foreach ($value as $reference => $env) {
                            $this->addPackageReference($reference, $env);
                        }

                        break;
                    default:
                        break;
                }
            }
        }
    }

    public function setRoot(string $root) : PackageMetadata
    {
        $this->root = $root;

        return $this;
    }

    public function getRoot() : string
    {
        return $this->root;
    }

    public function setName(string $name) : PackageMetadata
    {
        list($vendor, $package) = explode('/', $name);

        $this->name = $name;
        $this->vendor = $vendor;
        $this->package = $package;

        return $this;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getVendor() : string
    {
        return $this->vendor;
    }

    public function getPackage() : string
    {
        return $this->package;
    }

    public function setDescription(string $description) : PackageMetadata
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setType(string $type) : PackageMetadata
    {
        if (!in_array($type, self::$supportedTypes)) {
            throw new \Exception("Invalid package type " . $type . ". Supported types are [" . implode(", ", self::$supportedTypes) . "]");
        }

        $this->type = $type;

        return $this;
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function setDefinedNamespaces(array $definedNamespaces)
    {
        $this->definedNamespaces = $definedNamespaces;

        return $this;
    }

    public function getDefinedNamespaces() : array
    {
        return $this->definedNamespaces;
    }

    public function addPackageReference($reference, $env)
    {
        $this->packageReference[$reference] = $env;

        return $this;
    }

    public function getPackageReferences()
    {
        return $this->packageReference;
    }
}