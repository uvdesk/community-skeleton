<?php

namespace Webkul\UVDesk\AutomationBundle\PreparedResponse;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

abstract class Action
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
    
    abstract public static function getOptions(ContainerInterface $container);
    abstract public static function applyAction(ContainerInterface $container, $entity, $value);
}
