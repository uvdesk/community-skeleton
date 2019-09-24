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

/* @UVDeskSupportCenter/Knowledgebase/darkSkin.html.twig */
class __TwigTemplate_6ca8ad7b80d460c7f8f55aa211716a839e378b83cab0fc75854720e47b2a8e7b extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Knowledgebase/darkSkin.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Knowledgebase/darkSkin.html.twig"));

        // line 1
        $context["brandColor"] = ((twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 1, $this->source); })()), "brandColor", [], "any", false, false, false, 1)) ? (twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 1, $this->source); })()), "brandColor", [], "any", false, false, false, 1)) : ("#7C70F4"));
        // line 2
        if ((((isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 2, $this->source); })()) != "#7C70F4") && ((isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 2, $this->source); })()) != "#7c70f4"))) {
            // line 3
            echo "<style>
    .uv-skin-dark .uv-btn-small,
    .uv-skin-dark .uv-btn,
    .uv-skin-dark .uv-btn-large,
    .uv-skin-dark .uv-btn-action,
    .uv-skin-dark .uv-btn-label {
        background: ";
            // line 9
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 9, $this->source); })()), "html", null, true);
            echo ";
        color: #333333 !important;
    }
    .uv-skin-dark .uv-btn-small:hover,
    .uv-skin-dark .uv-btn:hover,
    .uv-skin-dark .uv-btn-large:hover,
    .uv-skin-dark .uv-btn-action:hover,
    .uv-skin-dark .btn:hover,
    .uv-skin-dark .uv-btn-label:hover {
        background: ";
            // line 18
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 18, $this->source); })()), "html", null, true);
            echo ";
        opacity: .85;
    }
    .uv-skin-dark .uv-btn-small:active,
    .uv-skin-dark .uv-btn:active,
    .uv-skin-dark .uv-btn-large:active,
    .uv-skin-dark .uv-btn-action:active,
    .uv-skin-dark .btn:active,
    .uv-skin-dark .uv-btn-label:active {
        background: ";
            // line 27
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 27, $this->source); })()), "html", null, true);
            echo ";
        opacity: .65;
    }
    .uv-skin-dark .uv-btn-stroke:active {
        border-color: ";
            // line 31
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 31, $this->source); })()), "html", null, true);
            echo ";
    }
    .uv-skin-dark .uv-dropdown .uv-dropdown-btn-active {
        border: solid 1px ";
            // line 34
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 34, $this->source); })()), "html", null, true);
            echo ";
    }
    .uv-skin-dark .uv-select:focus,
    .uv-skin-dark .uv-field:focus,
    .uv-skin-dark .uv-search-inline:focus {
        border-color: ";
            // line 39
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 39, $this->source); })()), "html", null, true);
            echo ";
    }
    .uv-skin-dark .uv-loader span:before,
    .uv-skin-dark .uv-loader span:after {
        background: ";
            // line 43
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 43, $this->source); })()), "html", null, true);
            echo ";
    }
    .uv-skin-dark .bootstrap-datetimepicker-widget table td.active,
    .uv-skin-dark .bootstrap-datetimepicker-widget table td.active:hover {
        background-color: ";
            // line 47
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 47, $this->source); })()), "html", null, true);
            echo ";
    }
    .uv-skin-dark .btn-primary,
    .uv-skin-dark .btn-primary:hover,
    .uv-skin-dark .btn-primary:active {
        background-color: ";
            // line 52
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 52, $this->source); })()), "html", null, true);
            echo ";
    }
    .uv-skin-dark .uv-hero {
        background-color: ";
            // line 55
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 55, $this->source); })()), "html", null, true);
            echo ";
    }
    .uv-skin-dark .uv-cta-wrapper .uv-cta-lt svg path {
        fill: ";
            // line 58
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 58, $this->source); })()), "html", null, true);
            echo ";
        opacity: .85;
    }
    .uv-kb-layout-folder .uv-kb-folder {
        border-color: ";
            // line 62
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 62, $this->source); })()), "html", null, true);
            echo ";
    }
    .uv-kb-layout-folder .uv-kb-folder  .uv-kb-folder-lt {
        background-position: -180px 0px;
        background-color: ";
            // line 66
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 66, $this->source); })()), "html", null, true);
            echo ";
        opacity: .85;
    }
    .uv-skin-dark .uv-paper-article .uv-paper-section .uv-folder-title:after {
        background-color: ";
            // line 70
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 70, $this->source); })()), "html", null, true);
            echo ";
        color: #333333;
    }
    .uv-skin-dark .uv-kb-layout-category .uv-kb-folder {
        border-bottom-color: ";
            // line 74
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 74, $this->source); })()), "html", null, true);
            echo ";
    }
    .uv-skin-dark .uv-brand {
        color: ";
            // line 77
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 77, $this->source); })()), "html", null, true);
            echo ";
    }
    .uv-skin-dark .uv-pagination a:hover {
        background-color: ";
            // line 80
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 80, $this->source); })()), "html", null, true);
            echo ";
        border-color: ";
            // line 81
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 81, $this->source); })()), "html", null, true);
            echo ";
    }
    .uv-skin-dark .uv-nav-tab ul.uv-nav-tab-label li .uv-nav-tab-active,
    .uv-skin-dark .uv-nav-tab ul.uv-nav-tab-label li a:hover {
        border-bottom-color: ";
            // line 85
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 85, $this->source); })()), "html", null, true);
            echo ";
    }
    .uv-skin-dark .uv-icon-down-light {
            background-image: url(\"";
            // line 88
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdeskcoreframework/images/arrow-down-dark.svg"), "html", null, true);
            echo "\");
    }
    .uv-skin-dark .uv-ticket-view .uv-ticket-accordion .uv-ticket-count-stat,
    .uv-skin-dark .uv-ticket-view .uv-ticket-accordion .uv-ticket-count-stat:hover {
        background: ";
            // line 92
            echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 92, $this->source); })()), "html", null, true);
            echo ";
        color: #333333;
    }
</style>
";
        }
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Knowledgebase/darkSkin.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  198 => 92,  191 => 88,  185 => 85,  178 => 81,  174 => 80,  168 => 77,  162 => 74,  155 => 70,  148 => 66,  141 => 62,  134 => 58,  128 => 55,  122 => 52,  114 => 47,  107 => 43,  100 => 39,  92 => 34,  86 => 31,  79 => 27,  67 => 18,  55 => 9,  47 => 3,  45 => 2,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% set brandColor = websiteConfiguration.brandColor ?: '#7C70F4' %}
{% if brandColor != '#7C70F4' and brandColor != '#7c70f4' %}
<style>
    .uv-skin-dark .uv-btn-small,
    .uv-skin-dark .uv-btn,
    .uv-skin-dark .uv-btn-large,
    .uv-skin-dark .uv-btn-action,
    .uv-skin-dark .uv-btn-label {
        background: {{ brandColor }};
        color: #333333 !important;
    }
    .uv-skin-dark .uv-btn-small:hover,
    .uv-skin-dark .uv-btn:hover,
    .uv-skin-dark .uv-btn-large:hover,
    .uv-skin-dark .uv-btn-action:hover,
    .uv-skin-dark .btn:hover,
    .uv-skin-dark .uv-btn-label:hover {
        background: {{ brandColor }};
        opacity: .85;
    }
    .uv-skin-dark .uv-btn-small:active,
    .uv-skin-dark .uv-btn:active,
    .uv-skin-dark .uv-btn-large:active,
    .uv-skin-dark .uv-btn-action:active,
    .uv-skin-dark .btn:active,
    .uv-skin-dark .uv-btn-label:active {
        background: {{ brandColor }};
        opacity: .65;
    }
    .uv-skin-dark .uv-btn-stroke:active {
        border-color: {{ brandColor }};
    }
    .uv-skin-dark .uv-dropdown .uv-dropdown-btn-active {
        border: solid 1px {{ brandColor }};
    }
    .uv-skin-dark .uv-select:focus,
    .uv-skin-dark .uv-field:focus,
    .uv-skin-dark .uv-search-inline:focus {
        border-color: {{ brandColor }};
    }
    .uv-skin-dark .uv-loader span:before,
    .uv-skin-dark .uv-loader span:after {
        background: {{ brandColor }};
    }
    .uv-skin-dark .bootstrap-datetimepicker-widget table td.active,
    .uv-skin-dark .bootstrap-datetimepicker-widget table td.active:hover {
        background-color: {{ brandColor }};
    }
    .uv-skin-dark .btn-primary,
    .uv-skin-dark .btn-primary:hover,
    .uv-skin-dark .btn-primary:active {
        background-color: {{ brandColor }};
    }
    .uv-skin-dark .uv-hero {
        background-color: {{ brandColor }};
    }
    .uv-skin-dark .uv-cta-wrapper .uv-cta-lt svg path {
        fill: {{ brandColor }};
        opacity: .85;
    }
    .uv-kb-layout-folder .uv-kb-folder {
        border-color: {{ brandColor }};
    }
    .uv-kb-layout-folder .uv-kb-folder  .uv-kb-folder-lt {
        background-position: -180px 0px;
        background-color: {{ brandColor }};
        opacity: .85;
    }
    .uv-skin-dark .uv-paper-article .uv-paper-section .uv-folder-title:after {
        background-color: {{ brandColor }};
        color: #333333;
    }
    .uv-skin-dark .uv-kb-layout-category .uv-kb-folder {
        border-bottom-color: {{ brandColor }};
    }
    .uv-skin-dark .uv-brand {
        color: {{ brandColor }};
    }
    .uv-skin-dark .uv-pagination a:hover {
        background-color: {{ brandColor }};
        border-color: {{ brandColor }};
    }
    .uv-skin-dark .uv-nav-tab ul.uv-nav-tab-label li .uv-nav-tab-active,
    .uv-skin-dark .uv-nav-tab ul.uv-nav-tab-label li a:hover {
        border-bottom-color: {{ brandColor }};
    }
    .uv-skin-dark .uv-icon-down-light {
            background-image: url(\"{{ asset('bundles/uvdeskcoreframework/images/arrow-down-dark.svg')}}\");
    }
    .uv-skin-dark .uv-ticket-view .uv-ticket-accordion .uv-ticket-count-stat,
    .uv-skin-dark .uv-ticket-view .uv-ticket-accordion .uv-ticket-count-stat:hover {
        background: {{ brandColor }};
        color: #333333;
    }
</style>
{% endif %}", "@UVDeskSupportCenter/Knowledgebase/darkSkin.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Knowledgebase/darkSkin.html.twig");
    }
}
