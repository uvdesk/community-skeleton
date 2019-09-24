<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Application\Routine;

use Symfony\Component\EventDispatcher\Event;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\DashboardTemplate;
use Webkul\UVDesk\ExtensionFrameworkBundle\Application\RoutineInterface;
use Webkul\UVDesk\ExtensionFrameworkBundle\Definition\ApplicationInterface;

class RenderDashboardRoutine extends Event implements RoutineInterface
{
    const NAME = 'uvdesk_extensions.application_routine.prepare_dashboard';

    private $template;
    private $templateData = [];
    private $dashboardTemplate;

    public function __construct(DashboardTemplate $dashboardTemplate)
    {
        $this->dashboardTemplate = $dashboardTemplate;
    }

    public static function getName() : string
    {
        return self::NAME;
    }

    public function getDashboardTemplate() : DashboardTemplate
    {
        return $this->dashboardTemplate;
    }

    public function setTemplateReference($template)
    {
        $this->template = $template;

        return $this;
    }

    public function getTemplateReference()
    {
        return $this->template;
    }

    public function addTemplateData($name, $value)
    {
        $this->templateData[$name] = $value;

        return $this;
    }

    public function getTemplateData()
    {
        return $this->templateData;
    }
}
