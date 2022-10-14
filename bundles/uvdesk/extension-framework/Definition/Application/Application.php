<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Application;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Package\PackageInterface;

abstract class Application implements ApplicationInterface, EventSubscriberInterface
{
    protected $package;

    public static abstract function getMetadata() : ApplicationMetadata;

    public static abstract function getSubscribedEvents();

    final public function setPackage(PackageInterface $package) : ApplicationInterface
	{
        if (empty($this->package)) {
            $this->package = $package;
        }

        return $this;
    }
    
    final public function getPackage() : PackageInterface
    {
        return $this->package;
    }
}
