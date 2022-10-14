<?php

namespace Webkul\UVDesk\AutomationBundle\Workflow;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

abstract class Event
{
    public static function getId()
    {
        return null;
    }

    public static function getDescription()
    {
        return null;
    }

    public static function getFunctionalGroup()
    {
        return null;
    }
}
