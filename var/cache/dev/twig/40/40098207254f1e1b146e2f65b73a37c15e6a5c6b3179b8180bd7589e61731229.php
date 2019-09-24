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

/* @WebProfiler/Icon/exception.svg */
class __TwigTemplate_2e333c5ed6ea183079c606392b586fb78c6138c3c0341c0ca06792770b385c2d extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Icon/exception.svg"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Icon/exception.svg"));

        // line 1
        echo "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"><path fill=\"#AAA\" d=\"M23.5 9.5c0-.2-1.2.2-1.6.2l.4-.8C23 7.4 22 6.6 21 7.5c-.4.4 0 1.1 0 1.8v.3l-.6-.3c-.5-.8-1.1-.2-1.1 0 0 .3.7.9 1.1.9h.2v.5c0 .7-.8 1.1-1.7 1.2V9.1c0-4.3-3.3-6.4-6.9-6.4-3.5 0-6.9 2-6.9 6.4v2.8c-.9-.2-1.8-.5-1.8-1.2v-.2h.2c.5 0 1.1-.2 1.1-.4.2-1.4-.6-.5-1.1-.5h-.3l.1-.4c0-.5 1.2-1.7-.8-1.9-.4 0-.5.9-.4 1.3l.4 1.2c-.1-.2-.3-.2-.5-.3-.2-.2-1.6-1.9-1.9 0-.1 1.1 1 1.2 1.9 1l.3-.1-.2 1.2c0 1.3 1.5 1.6 2.9 1.7v5.2c0 1.6.5 2.8 2.2 2.8 1.8 0 2.4-1.3 2.4-2.9 0 1.6.6 2.9 2.3 2.9s2.3-2.2 2.3-2.8c0 1.7.7 2.8 2.4 2.8s2.2-1.2 2.2-2.9v-5.1c1.4-.1 2.9-.4 2.9-1.7l-.1-1c.4.5 1.1.8 1.7.5 1.2-.7.2-1.4.2-1.6zM6.8 8.4c0-1.5 1-2.5 2.3-2.5 1.3 0 2.3 1.1 2.3 2.5s-1 2.6-2.2 2.6c.6 0 1.1-.5 1.1-1.2 0-.6-.5-1.2-1.2-1.2-.6 0-1.2.5-1.2 1.2 0 .6.5 1.2 1.2 1.2-1.3 0-2.3-1.1-2.3-2.6zm5.1 7.5c-2.9-.1-3.1-1.6-3.1-2.5 0-.9 1.7-.3 3.2-.3 1.5 0 3.1-.7 3.1.2 0 1-.8 2.7-3.2 2.6zM15 11c.6-.1 1-.6 1-1.2s-.5-1.2-1.2-1.2c-.6 0-1.2.5-1.2 1.2 0 .6.5 1.2 1.1 1.2-1.3 0-2.3-1.2-2.3-2.6 0-1.5 1-2.5 2.3-2.5C16 5.9 17 7 17 8.4c.1 1.4-.8 2.5-2 2.6z\"/></svg>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Icon/exception.svg";
    }

    public function getDebugInfo()
    {
        return array (  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"><path fill=\"#AAA\" d=\"M23.5 9.5c0-.2-1.2.2-1.6.2l.4-.8C23 7.4 22 6.6 21 7.5c-.4.4 0 1.1 0 1.8v.3l-.6-.3c-.5-.8-1.1-.2-1.1 0 0 .3.7.9 1.1.9h.2v.5c0 .7-.8 1.1-1.7 1.2V9.1c0-4.3-3.3-6.4-6.9-6.4-3.5 0-6.9 2-6.9 6.4v2.8c-.9-.2-1.8-.5-1.8-1.2v-.2h.2c.5 0 1.1-.2 1.1-.4.2-1.4-.6-.5-1.1-.5h-.3l.1-.4c0-.5 1.2-1.7-.8-1.9-.4 0-.5.9-.4 1.3l.4 1.2c-.1-.2-.3-.2-.5-.3-.2-.2-1.6-1.9-1.9 0-.1 1.1 1 1.2 1.9 1l.3-.1-.2 1.2c0 1.3 1.5 1.6 2.9 1.7v5.2c0 1.6.5 2.8 2.2 2.8 1.8 0 2.4-1.3 2.4-2.9 0 1.6.6 2.9 2.3 2.9s2.3-2.2 2.3-2.8c0 1.7.7 2.8 2.4 2.8s2.2-1.2 2.2-2.9v-5.1c1.4-.1 2.9-.4 2.9-1.7l-.1-1c.4.5 1.1.8 1.7.5 1.2-.7.2-1.4.2-1.6zM6.8 8.4c0-1.5 1-2.5 2.3-2.5 1.3 0 2.3 1.1 2.3 2.5s-1 2.6-2.2 2.6c.6 0 1.1-.5 1.1-1.2 0-.6-.5-1.2-1.2-1.2-.6 0-1.2.5-1.2 1.2 0 .6.5 1.2 1.2 1.2-1.3 0-2.3-1.1-2.3-2.6zm5.1 7.5c-2.9-.1-3.1-1.6-3.1-2.5 0-.9 1.7-.3 3.2-.3 1.5 0 3.1-.7 3.1.2 0 1-.8 2.7-3.2 2.6zM15 11c.6-.1 1-.6 1-1.2s-.5-1.2-1.2-1.2c-.6 0-1.2.5-1.2 1.2 0 .6.5 1.2 1.1 1.2-1.3 0-2.3-1.2-2.3-2.6 0-1.5 1-2.5 2.3-2.5C16 5.9 17 7 17 8.4c.1 1.4-.8 2.5-2 2.6z\"/></svg>
", "@WebProfiler/Icon/exception.svg", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/symfony/web-profiler-bundle/Resources/views/Icon/exception.svg");
    }
}
