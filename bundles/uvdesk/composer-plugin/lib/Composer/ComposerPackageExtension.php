<?php

namespace Webkul\UVDesk\PackageManager\Composer;

use Symfony\Component\Yaml\Yaml;
use Composer\Package\PackageInterface;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\Console\Output\ConsoleOutput;
use Composer\DependencyResolver\Operation\UpdateOperation;
use Composer\DependencyResolver\Operation\UninstallOperation;
use Composer\DependencyResolver\Operation\OperationInterface;

abstract class ComposerPackageExtension
{
    private $package;
    private $operation;
    private $installationPath;

    public final function __construct(PackageInterface $package, OperationInterface $operation, $installationPath)
    {
        $this->package = $package;
        $this->operation = $operation;

        if (is_string($installationPath)) {
            $this->installationPath = $installationPath;
        }
    }

    public final function getPackage()
    {
        return $this->package;
    }

    public final function getPackageName()
    {
        return $this->package->getNames()[0];
    }
    
    public final function getPackageOperation()
    {
        return $this->operation;
    }

    public final function getPackageOperationType()
    {
        return $this->operation instanceof UpdateOperation ? 'update' : ($this->operation instanceof UninstallOperation ? 'remove' : 'install');
    }

    public final function handleComposerProjectCreateEvent(Event $event)
    {
        $this
            ->loadConfiguration()
            ->autoConfigureExtension($this->installationPath)
            ->outputPackageInstallationMessage();
    }

    public final function handleComposerPackageUpdateEvent(Event $event)
    {
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->write(sprintf("  - Configuring <info>%s</info>\n", $this->getPackageName()));

        $this
            ->loadConfiguration()
            ->autoConfigureExtension($this->installationPath);
    }
}
