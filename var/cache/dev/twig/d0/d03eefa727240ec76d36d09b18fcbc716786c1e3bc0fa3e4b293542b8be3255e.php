<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* @WebProfiler/Icon/time.svg */
class __TwigTemplate_39cda926dd567e3c2ed7d1306827aa6af40d30bb9bfae09514a12c576237a5b2 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Icon/time.svg"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Icon/time.svg"));

        // line 1
        echo "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"><path fill=\"#AAA\" d=\"M15.1 4.3a13 13 0 0 0-6.2 0c-.3 0-.7-.2-.7-.5v-.4c0-1.2 1-2.3 2.3-2.3h3c1.2 0 2.3 1 2.3 2.3v.3c0 .4-.4.6-.7.6zm5.8 9.7a9 9 0 0 1-17.8 0 9 9 0 0 1 17.8 0zm-4.2 1c0-.6-.4-1-1-1H13V8.4c0-.6-.4-1-1-1s-1 .4-1 1v6.2c0 .6.4 1.3 1 1.3h3.7c.5.1 1-.3 1-.9z\"/></svg>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Icon/time.svg";
    }

    public function getDebugInfo()
    {
        return array (  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"><path fill=\"#AAA\" d=\"M15.1 4.3a13 13 0 0 0-6.2 0c-.3 0-.7-.2-.7-.5v-.4c0-1.2 1-2.3 2.3-2.3h3c1.2 0 2.3 1 2.3 2.3v.3c0 .4-.4.6-.7.6zm5.8 9.7a9 9 0 0 1-17.8 0 9 9 0 0 1 17.8 0zm-4.2 1c0-.6-.4-1-1-1H13V8.4c0-.6-.4-1-1-1s-1 .4-1 1v6.2c0 .6.4 1.3 1 1.3h3.7c.5.1 1-.3 1-.9z\"/></svg>
", "@WebProfiler/Icon/time.svg", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/symfony/web-profiler-bundle/Resources/views/Icon/time.svg");
    }
}
