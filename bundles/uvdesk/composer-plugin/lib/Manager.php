<?php

namespace Webkul\UVDesk\PackageManager;

use Composer\Composer;
use Composer\Script\Event;
use Composer\IO\IOInterface;
use Composer\Script\ScriptEvents;
use Composer\Plugin\PluginInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\Package\PackageInterface;
use Composer\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Composer\DependencyResolver\Operation\UpdateOperation;
use Webkul\UVDesk\PackageManager\Composer\ComposerPackageExtension;
use Webkul\UVDesk\PackageManager\Event\ComposerPackageUpdatedEvent;
use Webkul\UVDesk\PackageManager\Event\ComposerProjectCreatedEvent;

class Manager implements PluginInterface, EventSubscriberInterface
{
    private $io;
    private $composer;
    private $packagesOperation = [];

    public function activate(Composer $composer, IOInterface $io)
    {
        if (!extension_loaded('openssl')) {
            self::$activated = false;
            $io->writeError('<warning>UVDesk dependency resolver has been disabled. You must enable the openssl extension in your "php.ini" file.</warning>');

            return;
        }

        $this->io = $io;
        $this->composer = $composer;
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        $this->io = $io;
        $this->composer = $composer;
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        $this->io = $io;
        $this->composer = $composer;
    }

    public function logPackageEvent(PackageEvent $event)
    {
        $this->packagesOperation[] = $event->getOperation();
    }

    private static function getPackageVersion(PackageInterface $package)
    {
        $version = $package->getPrettyVersion();

        if (0 === strpos($version, 'dev-') && isset($package->getExtra()['branch-alias'])) {
            $branchAliases = $package->getExtra()['branch-alias'];

            if (!empty($branchAliases[$version]) || !empty($branchAliases['dev-master'])) {
                return !empty($branchAliases[$version]) ? $branchAliases[$version] : $branchAliases['dev-master'];
            }
        }

        return $version;
    }

    public function loadDependencies(array $packageOperations = [])
    {
        $dependencies = [];

        foreach ($packageOperations as $packageOperation) {
            $package = $packageOperation instanceof UpdateOperation ? $packageOperation->getTargetPackage() : $packageOperation->getPackage();
            $extras = $package->getExtra();

            if (!empty($extras['uvdesk-package-extension']) && class_exists($extras['uvdesk-package-extension'])) {
                try {
                    $pathToPackage = $this->composer->getInstallationManager()->getInstallPath($package);
                    $extensionPackage = new $extras['uvdesk-package-extension']($package, $packageOperation, $pathToPackage);
                    
                    if ($extensionPackage instanceof ComposerPackageExtension) {
                        array_push($dependencies, $extensionPackage);
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        return $dependencies;
    }

    public function postPackagesInstallEvent(Event $event)
    {
        $this->postPackagesUpdateEvent($event);
    }

    public function postPackagesUpdateEvent(Event $event)
    {
        $packages = $this->loadDependencies($this->packagesOperation);

        if (!empty($packages)) {
            $dispatcher = new EventDispatcher();
            $this->io->writeError(sprintf("\n<info>Package Manager: %s package operations</info>", count($packages)));
            
            foreach ($packages as $packageHandler) {
                $dispatcher->addListener('uvdesk.composer.package.updated', [$packageHandler, 'handleComposerPackageUpdateEvent']);
            }

            $composerEvent = new ComposerPackageUpdatedEvent($event);
            $dispatcher->dispatch($composerEvent, ComposerPackageUpdatedEvent::NAME);

            $this->io->writeError("");
        }
    }

    public function postProjectCreationEvent(Event $event)
    {
        $packages = $this->loadDependencies($this->packagesOperation);

        if (!empty($packages)) {
            $dispatcher = new EventDispatcher();

            foreach ($packages as $packageHandler) {
                $dispatcher->addListener('uvdesk.composer.project.created', [$packageHandler, 'handleComposerProjectCreateEvent']);
            }

            $composerEvent = new ComposerProjectCreatedEvent($event);
            $dispatcher->dispatch($composerEvent, ComposerProjectCreatedEvent::NAME);
        }
    }
    
    public static function getSubscribedEvents()
    {
        return [
            PackageEvents::POST_PACKAGE_INSTALL => 'logPackageEvent',
            PackageEvents::POST_PACKAGE_UPDATE => 'logPackageEvent',
            PackageEvents::POST_PACKAGE_UNINSTALL => 'logPackageEvent',
            ScriptEvents::POST_INSTALL_CMD => ['postPackagesInstallEvent', \PHP_INT_MAX],
            ScriptEvents::POST_UPDATE_CMD => ['postPackagesUpdateEvent', \PHP_INT_MAX],
            ScriptEvents::POST_CREATE_PROJECT_CMD => 'postProjectCreationEvent',
        ];
    }
}
