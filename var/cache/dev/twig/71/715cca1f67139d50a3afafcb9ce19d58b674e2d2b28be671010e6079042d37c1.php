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

/* @WebProfiler/Icon/event.svg */
class __TwigTemplate_1a4e0a0ca3118382d409be971507dc160b6581082b6e27eb529b65353dc0df2b extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Icon/event.svg"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Icon/event.svg"));

        // line 1
        echo "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"><path fill=\"#AAA\" d=\"M19.2 20.8c.4.7.1 1.6-.6 2l-.7.2c-.5 0-1-.3-1.3-.8l-3.7-6.7-1 .1-.9-.1-3.7 6.7c-.4.5-.9.8-1.5.8l-.7-.2c-.7-.4-1-1.3-.6-2l3.8-6.9c-.5-.7-.9-1.6-.9-2.6.1-2.4 2-4.3 4.4-4.3s4.3 1.9 4.3 4.3c0 .9-.3 1.8-.8 2.5l3.9 7zM5.2 11c.6 0 1-.3 1-.8 0-2.1 1.6-3.8 3.7-4.1.5-.1.9-.6.8-1.2-.1-.5-.6-.9-1.1-.9-3.1.5-5.3 3-5.3 6.1-.1.6.4.9.9.9zm8.4-5c2.1.3 3.7 2.1 3.8 4.2 0 .5.5.8 1 .8.6 0 1-.3 1-.8 0-3.1-2.4-5.6-5.5-6.1-.5-.1-1.1.3-1.1.8-.2.6.2 1 .8 1.1zM9 3c.5-.1.9-.6.8-1.1-.1-.6-.6-.9-1.1-.8a9 9 0 0 0-7.4 8.7c0 .6.4 1.2 1 1.2.5 0 1-.6 1-1.2C3.3 6.5 5.7 3.5 9 3zm5.7-2c-.5-.1-1.1.3-1.1.9s.3 1.1.8 1.1c3.3.5 5.8 3.4 5.8 6.8 0 .5.5 1.2 1 1.2.6 0 1-.7 1-1.2A9 9 0 0 0 14.7 1z\"/></svg>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Icon/event.svg";
    }

    public function getDebugInfo()
    {
        return array (  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"><path fill=\"#AAA\" d=\"M19.2 20.8c.4.7.1 1.6-.6 2l-.7.2c-.5 0-1-.3-1.3-.8l-3.7-6.7-1 .1-.9-.1-3.7 6.7c-.4.5-.9.8-1.5.8l-.7-.2c-.7-.4-1-1.3-.6-2l3.8-6.9c-.5-.7-.9-1.6-.9-2.6.1-2.4 2-4.3 4.4-4.3s4.3 1.9 4.3 4.3c0 .9-.3 1.8-.8 2.5l3.9 7zM5.2 11c.6 0 1-.3 1-.8 0-2.1 1.6-3.8 3.7-4.1.5-.1.9-.6.8-1.2-.1-.5-.6-.9-1.1-.9-3.1.5-5.3 3-5.3 6.1-.1.6.4.9.9.9zm8.4-5c2.1.3 3.7 2.1 3.8 4.2 0 .5.5.8 1 .8.6 0 1-.3 1-.8 0-3.1-2.4-5.6-5.5-6.1-.5-.1-1.1.3-1.1.8-.2.6.2 1 .8 1.1zM9 3c.5-.1.9-.6.8-1.1-.1-.6-.6-.9-1.1-.8a9 9 0 0 0-7.4 8.7c0 .6.4 1.2 1 1.2.5 0 1-.6 1-1.2C3.3 6.5 5.7 3.5 9 3zm5.7-2c-.5-.1-1.1.3-1.1.9s.3 1.1.8 1.1c3.3.5 5.8 3.4 5.8 6.8 0 .5.5 1.2 1 1.2.6 0 1-.7 1-1.2A9 9 0 0 0 14.7 1z\"/></svg>
", "@WebProfiler/Icon/event.svg", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/symfony/web-profiler-bundle/Resources/views/Icon/event.svg");
    }
}
