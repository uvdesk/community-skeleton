<?php

namespace Webkul\UVDesk\AutomationBundle\Workflow;

use Symfony\Component\DependencyInjection\ContainerInterface;

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
