<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Definition\Application;

abstract class ApplicationMetadata
{
    public abstract function getName() : string;

    public abstract function getQualifiedName() : string;

    public function getIconPath() : string
    {
        return '';
    }
}
