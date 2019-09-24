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

/* @WebProfiler/Icon/validator.svg */
class __TwigTemplate_0b7de105728beffb14507147222c40ee3a30122a7b90c0a211d8e0a55bc151a0 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Icon/validator.svg"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Icon/validator.svg"));

        // line 1
        echo "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"><path fill=\"#aaa\" d=\"M19.5 22.5H4.3a2.9 2.9 0 0 1-2.9-2.9V4.4a2.9 2.9 0 0 1 2.9-2.9h14.2a1 1 0 0 1 0 2H4.3a.9.9 0 0 0-.9.9v15.2a.9.9 0 0 0 .9.9h15.2a.9.9 0 0 0 1-.9v-8.3a1 1 0 1 1 2 0v8.3a2.9 2.9 0 0 1-3 2.9zM13 17.3L22.9 6a1.5 1.5 0 1 0-2.3-2L12 14 8 9.1A1.5 1.5 0 0 0 5.7 11l5 6.3a1.5 1.5 0 0 0 1.2.5 1.5 1.5 0 0 0 1.1-.5z\"/></svg>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Icon/validator.svg";
    }

    public function getDebugInfo()
    {
        return array (  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"><path fill=\"#aaa\" d=\"M19.5 22.5H4.3a2.9 2.9 0 0 1-2.9-2.9V4.4a2.9 2.9 0 0 1 2.9-2.9h14.2a1 1 0 0 1 0 2H4.3a.9.9 0 0 0-.9.9v15.2a.9.9 0 0 0 .9.9h15.2a.9.9 0 0 0 1-.9v-8.3a1 1 0 1 1 2 0v8.3a2.9 2.9 0 0 1-3 2.9zM13 17.3L22.9 6a1.5 1.5 0 1 0-2.3-2L12 14 8 9.1A1.5 1.5 0 0 0 5.7 11l5 6.3a1.5 1.5 0 0 0 1.2.5 1.5 1.5 0 0 0 1.1-.5z\"/></svg>
", "@WebProfiler/Icon/validator.svg", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/symfony/web-profiler-bundle/Resources/views/Icon/validator.svg");
    }
}
