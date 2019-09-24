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

/* @WebProfiler/Icon/config.svg */
class __TwigTemplate_7bbb0a87ef0eaf7be2389dd91019c43e259e730890fab1fc57cec37d188449db extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Icon/config.svg"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Icon/config.svg"));

        // line 1
        echo "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"><path fill=\"#AAA\" d=\"M11 5.1C11 3.4 9.6 2 7.9 2H5.1A3.1 3.1 0 0 0 2 5.1V18c0 1.6 1.4 3 3.1 3H8c1.7 0 3.1-1.4 3.1-3.1V5.1zM5.2 4h2.7C8.4 4 9 4.8 9 5.3V11H4V5.3C4 4.8 4.6 4 5.2 4zM22 5.1C22 3.4 20.6 2 18.9 2H16c-1.6 0-3 1.4-3 3.1V18c0 1.7 1.4 3.1 3.1 3.1H19c1.7 0 3.1-1.4 3.1-3.1V5.1zM16 4h2.8c.6 0 1.2.8 1.2 1.3V8h-5V5.3c0-.5.5-1.3 1-1.3z\"/></svg>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Icon/config.svg";
    }

    public function getDebugInfo()
    {
        return array (  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"><path fill=\"#AAA\" d=\"M11 5.1C11 3.4 9.6 2 7.9 2H5.1A3.1 3.1 0 0 0 2 5.1V18c0 1.6 1.4 3 3.1 3H8c1.7 0 3.1-1.4 3.1-3.1V5.1zM5.2 4h2.7C8.4 4 9 4.8 9 5.3V11H4V5.3C4 4.8 4.6 4 5.2 4zM22 5.1C22 3.4 20.6 2 18.9 2H16c-1.6 0-3 1.4-3 3.1V18c0 1.7 1.4 3.1 3.1 3.1H19c1.7 0 3.1-1.4 3.1-3.1V5.1zM16 4h2.8c.6 0 1.2.8 1.2 1.3V8h-5V5.3c0-.5.5-1.3 1-1.3z\"/></svg>
", "@WebProfiler/Icon/config.svg", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/symfony/web-profiler-bundle/Resources/views/Icon/config.svg");
    }
}
