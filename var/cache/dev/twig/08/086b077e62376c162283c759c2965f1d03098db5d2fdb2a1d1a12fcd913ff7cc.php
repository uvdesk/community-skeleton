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

/* @UVDeskSupportCenter/Knowledgebase/lightSkin.html.twig */
class __TwigTemplate_cf1b8c07c6ea6eb26d292aa1ebda4b3e4438aa949ab99ceab3824eb4ebf8b77d extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Knowledgebase/lightSkin.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Knowledgebase/lightSkin.html.twig"));

        // line 1
        $context["brandColor"] = ((twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 1, $this->source); })()), "brandColor", [], "any", false, false, false, 1)) ? (twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 1, $this->source); })()), "brandColor", [], "any", false, false, false, 1)) : ("#7C70F4"));
        // line 2
        if ((((isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 2, $this->source); })()) != "#7C70F4") && ((isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 2, $this->source); })()) != "#7c70f4"))) {
            // line 3
            echo "<style>
    .uv-btn-small,
    .uv-btn,
    .uv-btn-large,
    .uv-btn-action,
    .uv-btn-label {
        background: ";
            // line 9
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 9, $this->source); })()), "html", null, true);
            echo ";
    }

    .uv-btn-small:hover,
    .uv-btn:hover,
    .uv-btn-large:hover,
    .uv-btn-action:hover,
    .btn:hover,
    .uv-btn-label:hover {
        background: ";
            // line 18
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 18, $this->source); })()), "html", null, true);
            echo ";
        opacity: .85;
    }

    .uv-btn-small:active,
    .uv-btn:active,
    .uv-btn-large:active,
    .uv-btn-action:active,
    .btn:active,
    .uv-btn-label:active {
        background: ";
            // line 28
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 28, $this->source); })()), "html", null, true);
            echo ";
        opacity: .65;
    }

    .uv-btn-stroke:active {
        border-color: ";
            // line 33
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 33, $this->source); })()), "html", null, true);
            echo ";
    }

    .uv-dropdown .uv-dropdown-btn-active {
        border: solid 1px ";
            // line 37
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 37, $this->source); })()), "html", null, true);
            echo ";
    }

    .uv-select:focus,
    .uv-field:focus,
    .uv-search-inline:focus {
        border-color: ";
            // line 43
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 43, $this->source); })()), "html", null, true);
            echo ";
    }

    .uv-loader span:before,
    .uv-loader span:after {
        background: ";
            // line 48
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 48, $this->source); })()), "html", null, true);
            echo ";
    }

    .bootstrap-datetimepicker-widget table td.active,
    .bootstrap-datetimepicker-widget table td.active:hover {
        background-color: ";
            // line 53
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 53, $this->source); })()), "html", null, true);
            echo ";
    }

    .btn-primary,
    .btn-primary:hover,
    .btn-primary:active {
        background-color: ";
            // line 59
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 59, $this->source); })()), "html", null, true);
            echo ";
    }

    .uv-hero {
        background-color: ";
            // line 63
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 63, $this->source); })()), "html", null, true);
            echo ";
    }

    .uv-cta-wrapper .uv-cta-lt svg path {
        fill: ";
            // line 67
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 67, $this->source); })()), "html", null, true);
            echo ";
    }
    .uv-kb-layout-folder .uv-kb-folder {
        border-color: ";
            // line 70
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 70, $this->source); })()), "html", null, true);
            echo ";
    }
    .uv-kb-layout-folder .uv-kb-folder .uv-kb-folder-lt {
        background-position: -90px 0px;
        background-color: ";
            // line 74
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 74, $this->source); })()), "html", null, true);
            echo ";
    }

    .uv-paper-article .uv-paper-section .uv-folder-title:after {
        background-color: ";
            // line 78
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 78, $this->source); })()), "html", null, true);
            echo ";
    }

    .uv-kb-layout-category .uv-kb-folder {
        border-bottom-color: ";
            // line 82
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 82, $this->source); })()), "html", null, true);
            echo ";
    }

    .uv-brand {
        color: ";
            // line 86
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 86, $this->source); })()), "html", null, true);
            echo ";
    }

    .uv-pagination a:hover {
        background-color: ";
            // line 90
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 90, $this->source); })()), "html", null, true);
            echo ";
        border-color: rgba(0,0,0,.1);
    }

    .uv-nav-tab ul.uv-nav-tab-label li .uv-nav-tab-active,
    .uv-nav-tab ul.uv-nav-tab-label li a:hover {
        border-bottom-color: ";
            // line 96
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 96, $this->source); })()), "html", null, true);
            echo ";
    }
    .uv-skin-dark .uv-ticket-view .uv-ticket-accordion .uv-ticket-count-stat,
    .uv-skin-dark .uv-ticket-view .uv-ticket-accordion .uv-ticket-count-stat:hover {
        background: ";
            // line 100
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 100, $this->source); })()), "html", null, true);
            echo ";
    }
</style>
";
        }
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Knowledgebase/lightSkin.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  200 => 100,  193 => 96,  184 => 90,  177 => 86,  170 => 82,  163 => 78,  156 => 74,  149 => 70,  143 => 67,  136 => 63,  129 => 59,  120 => 53,  112 => 48,  104 => 43,  95 => 37,  88 => 33,  80 => 28,  67 => 18,  55 => 9,  47 => 3,  45 => 2,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% set brandColor = websiteConfiguration.brandColor ?: '#7C70F4' %}
{% if brandColor != '#7C70F4' and brandColor != '#7c70f4' %}
<style>
    .uv-btn-small,
    .uv-btn,
    .uv-btn-large,
    .uv-btn-action,
    .uv-btn-label {
        background: {{ brandColor }};
    }

    .uv-btn-small:hover,
    .uv-btn:hover,
    .uv-btn-large:hover,
    .uv-btn-action:hover,
    .btn:hover,
    .uv-btn-label:hover {
        background: {{ brandColor }};
        opacity: .85;
    }

    .uv-btn-small:active,
    .uv-btn:active,
    .uv-btn-large:active,
    .uv-btn-action:active,
    .btn:active,
    .uv-btn-label:active {
        background: {{ brandColor }};
        opacity: .65;
    }

    .uv-btn-stroke:active {
        border-color: {{ brandColor }};
    }

    .uv-dropdown .uv-dropdown-btn-active {
        border: solid 1px {{ brandColor }};
    }

    .uv-select:focus,
    .uv-field:focus,
    .uv-search-inline:focus {
        border-color: {{ brandColor }};
    }

    .uv-loader span:before,
    .uv-loader span:after {
        background: {{ brandColor }};
    }

    .bootstrap-datetimepicker-widget table td.active,
    .bootstrap-datetimepicker-widget table td.active:hover {
        background-color: {{ brandColor }};
    }

    .btn-primary,
    .btn-primary:hover,
    .btn-primary:active {
        background-color: {{ brandColor }};
    }

    .uv-hero {
        background-color: {{ brandColor }};
    }

    .uv-cta-wrapper .uv-cta-lt svg path {
        fill: {{ brandColor }};
    }
    .uv-kb-layout-folder .uv-kb-folder {
        border-color: {{ brandColor }};
    }
    .uv-kb-layout-folder .uv-kb-folder .uv-kb-folder-lt {
        background-position: -90px 0px;
        background-color: {{ brandColor }};
    }

    .uv-paper-article .uv-paper-section .uv-folder-title:after {
        background-color: {{ brandColor }};
    }

    .uv-kb-layout-category .uv-kb-folder {
        border-bottom-color: {{ brandColor }};
    }

    .uv-brand {
        color: {{ brandColor }};
    }

    .uv-pagination a:hover {
        background-color: {{ brandColor }};
        border-color: rgba(0,0,0,.1);
    }

    .uv-nav-tab ul.uv-nav-tab-label li .uv-nav-tab-active,
    .uv-nav-tab ul.uv-nav-tab-label li a:hover {
        border-bottom-color: {{ brandColor }};
    }
    .uv-skin-dark .uv-ticket-view .uv-ticket-accordion .uv-ticket-count-stat,
    .uv-skin-dark .uv-ticket-view .uv-ticket-accordion .uv-ticket-count-stat:hover {
        background: {{ brandColor }};
    }
</style>
{% endif %}", "@UVDeskSupportCenter/Knowledgebase/lightSkin.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Knowledgebase/lightSkin.html.twig");
    }
}
