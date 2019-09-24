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

/* @WebProfiler/Icon/router.svg */
class __TwigTemplate_973f1937b2ef38157375d2d35352d1d3ede1e902ddc6ec3c1bf59df35d23161b extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Icon/router.svg"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Icon/router.svg"));

        // line 1
        echo "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"><path fill=\"#AAA\" d=\"M13 3v18c0 1.1-.9 2-2 2s-2-.9-2-2V3c0-1.1.9-2 2-2s2 .9 2 2zm10.2 1.6l-1.8-1.4c-.2-.3-.6-.2-1-.2H14v5h6.4c.4 0 .8-.3 1.1-.5l1.8-1.6c.3-.3.3-1-.1-1.3zm-3.7 4.8c-.3-.3-.7-.4-1.1-.4H14v5h4.4a2 2 0 0 0 1.1-.3l1.8-1.5c.4-.3.4-.9 0-1.3l-1.8-1.5zM3.5 7c-.4 0-.7 0-1 .3L.7 8.8c-.4.3-.4.9 0 1.3l1.8 1.6c.3.2.6.3 1 .3H8V7H3.5z\"/></svg>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Icon/router.svg";
    }

    public function getDebugInfo()
    {
        return array (  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"><path fill=\"#AAA\" d=\"M13 3v18c0 1.1-.9 2-2 2s-2-.9-2-2V3c0-1.1.9-2 2-2s2 .9 2 2zm10.2 1.6l-1.8-1.4c-.2-.3-.6-.2-1-.2H14v5h6.4c.4 0 .8-.3 1.1-.5l1.8-1.6c.3-.3.3-1-.1-1.3zm-3.7 4.8c-.3-.3-.7-.4-1.1-.4H14v5h4.4a2 2 0 0 0 1.1-.3l1.8-1.5c.4-.3.4-.9 0-1.3l-1.8-1.5zM3.5 7c-.4 0-.7 0-1 .3L.7 8.8c-.4.3-.4.9 0 1.3l1.8 1.6c.3.2.6.3 1 .3H8V7H3.5z\"/></svg>
", "@WebProfiler/Icon/router.svg", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/symfony/web-profiler-bundle/Resources/views/Icon/router.svg");
    }
}
