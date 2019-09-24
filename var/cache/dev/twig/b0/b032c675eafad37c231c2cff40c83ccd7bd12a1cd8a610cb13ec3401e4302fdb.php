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

/* @UVDeskCoreFramework/Templates/lightskin.html.twig */
class __TwigTemplate_6941730bce5b95d95cd617c2bc94cbefad363b805393bcf4c2ee28314009a35c extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Templates/lightskin.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Templates/lightskin.html.twig"));

        // line 1
        $context["brandColor"] = ((twig_get_attribute($this->env, $this->source, (isset($context["website"]) || array_key_exists("website", $context) ? $context["website"] : (function () { throw new RuntimeError('Variable "website" does not exist.', 1, $this->source); })()), "themeColor", [], "any", false, false, false, 1)) ? (twig_get_attribute($this->env, $this->source, (isset($context["website"]) || array_key_exists("website", $context) ? $context["website"] : (function () { throw new RuntimeError('Variable "website" does not exist.', 1, $this->source); })()), "themeColor", [], "any", false, false, false, 1)) : ("#7C70F4"));
        // line 2
        echo "
<style>
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

    .uv-btn-stroke:active{
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
    .uv-field:focus, .uv-search-inline:focus {
        border-color: ";
        // line 42
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 42, $this->source); })()), "html", null, true);
        echo ";
    }

    .uv-sidebar .uv-soft-top .uv-logo svg path, 
    .uv-inner-section .uv-view .uv-image-upload-wrapper .uv-image-upload-brick .uv-image-upload-placeholder svg path {
        fill: ";
        // line 47
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 47, $this->source); })()), "html", null, true);
        echo ";
    }

    .uv-inner-section .uv-view .uv-image-upload-wrapper .uv-image-upload-brick:hover .uv-image-upload-placeholder svg path {
    fill: ";
        // line 51
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 51, $this->source); })()), "html", null, true);
        echo ";
    opacity: .85;
    }

    li.uv-active-sidebar {
\t\tcolor: ";
        // line 56
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 56, $this->source); })()), "html", null, true);
        echo ";
\t\tborder-left: solid 3px ";
        // line 57
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 57, $this->source); })()), "html", null, true);
        echo ";
    }

    .uv-sidebar ul.uv-menubar li:not(.uv-active-sidebar) a:hover,
    .uv-sidebar ul.uv-menubar li .uv-item-active {
        color: ";
        // line 62
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 62, $this->source); })()), "html", null, true);
        echo ";
        border-left: solid 3px ";
        // line 63
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 63, $this->source); })()), "html", null, true);
        echo ";
    }

    .uv-sidebar .uv-soft-top .uv-hamburger:hover svg path {
        fill: ";
        // line 67
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 67, $this->source); })()), "html", null, true);
        echo ";
    }

    .uv-sidebar ul.uv-menubar li a:hover .uv-icon svg path,
    .uv-sidebar ul.uv-menubar li .uv-item-active .uv-icon svg path {
    fill: ";
        // line 72
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 72, $this->source); })()), "html", null, true);
        echo ";
    }

    .uv-paper .uv-navbar .uv-notification-icon-count {
        background-color: ";
        // line 76
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 76, $this->source); })()), "html", null, true);
        echo ";
    }

    .uv-paper .uv-container .uv-brick .uv-brick-section .uv-brick-icon:hover svg path {
        fill: ";
        // line 80
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 80, $this->source); })()), "html", null, true);
        echo ";
    }

    .uv-paper .uv-container .uv-brick .uv-brick-section .uv-brick-icon {
        background-image: -webkit-linear-gradient(left, ";
        // line 84
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 84, $this->source); })()), "html", null, true);
        echo " 0%, ";
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 84, $this->source); })()), "html", null, true);
        echo " 100%);
        background-image: -o-linear-gradient(left, ";
        // line 85
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 85, $this->source); })()), "html", null, true);
        echo " 0%, ";
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 85, $this->source); })()), "html", null, true);
        echo " 100%);
        background-image: linear-gradient(to right, ";
        // line 86
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 86, $this->source); })()), "html", null, true);
        echo " 0%, ";
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 86, $this->source); })()), "html", null, true);
        echo " 100%);
    }
    .uv-paper .uv-container .uv-home-tabs ul li{
        border-color: ";
        // line 89
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 89, $this->source); })()), "html", null, true);
        echo ";
    }
    .uv-paper .uv-container .uv-home-tabs ul .home-tab-active{
        background-color: ";
        // line 92
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 92, $this->source); })()), "html", null, true);
        echo ";
    }
    .uv-inner-section .uv-view .uv-tabs ul .uv-tab-active{
        border-bottom-color: ";
        // line 95
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 95, $this->source); })()), "html", null, true);
        echo ";
    }
    .uv-inner-section .uv-view .uv-tabs ul li:hover{
        border-bottom-color: ";
        // line 98
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 98, $this->source); })()), "html", null, true);
        echo ";
    }
    .uv-loader span:before,.uv-loader span:after{
        background: ";
        // line 101
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 101, $this->source); })()), "html", null, true);
        echo ";
    }

    .bootstrap-datetimepicker-widget table td.active, .bootstrap-datetimepicker-widget table td.active:hover {
        background-color: ";
        // line 105
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 105, $this->source); })()), "html", null, true);
        echo ";
    }

    .btn-primary, .btn-primary:hover, .btn-primary:active {
        background-color: ";
        // line 109
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 109, $this->source); })()), "html", null, true);
        echo ";
    }

    .uv-app-screen .uv-app-list-channels .uv-app-list-brick .uv-app-list-brick-lt{
        background-color: ";
        // line 113
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 113, $this->source); })()), "html", null, true);
        echo ";
        background-image: none !important;
    }

    .uv-app-screen .uv-app-list-channels .uv-app-list-brick{
        border-color: ";
        // line 118
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 118, $this->source); })()), "html", null, true);
        echo ";
    }

    .uv-inner-section .uv-view .uv-ticket-section .uv-ticket-accordion .uv-ticket-count-stat, .uv-inner-section .uv-view .uv-ticket-section .uv-ticket-accordion .uv-ticket-count-stat:hover{
        background: ";
        // line 122
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 122, $this->source); })()), "html", null, true);
        echo ";
    }
    .uv-pagination a:hover {
        background-color: ";
        // line 125
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 125, $this->source); })()), "html", null, true);
        echo ";
        border-color: rgba(0,0,0,.1);
    }
    .uv-box-tab ul > li a:hover, .uv-box-tab ul > li .uv-box-tab-active {
        background-color: #333333;
        border-color: #333333;
    }
    .uv-box-tab ul > li a:hover, .uv-box-tab ul > li .uv-box-tab-active {
        background-color: ";
        // line 133
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 133, $this->source); })()), "html", null, true);
        echo ";
        border-color: ";
        // line 134
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 134, $this->source); })()), "html", null, true);
        echo ";
    }
    .uv-paper .uv-search-result-row .uv-brick-icon {
        background-image: -webkit-linear-gradient(left, ";
        // line 137
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 137, $this->source); })()), "html", null, true);
        echo " 0%, ";
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 137, $this->source); })()), "html", null, true);
        echo " 100%) !important;
        background-image: -o-linear-gradient(left, ";
        // line 138
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 138, $this->source); })()), "html", null, true);
        echo " 0%, ";
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 138, $this->source); })()), "html", null, true);
        echo " 100%) !important;
        background-image: linear-gradient(to right, ";
        // line 139
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 139, $this->source); })()), "html", null, true);
        echo " 0%, ";
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 139, $this->source); })()), "html", null, true);
        echo " 100%) !important;
    }
    .uv-onboard-wrapper .uv-onboard-count:before{
        border-right-color: ";
        // line 142
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 142, $this->source); })()), "html", null, true);
        echo ";
    }

    .uv-onboard-wrapper .uv-onboard-container .uv-onboard-navigator-active{
        background-color: ";
        // line 146
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 146, $this->source); })()), "html", null, true);
        echo ";
    }
    .uv-icon-aside-menu,.uv-paper .uv-got-whats-new {
        background-color: ";
        // line 149
        echo twig_escape_filter($this->env, (isset($context["brandColor"]) || array_key_exists("brandColor", $context) ? $context["brandColor"] : (function () { throw new RuntimeError('Variable "brandColor" does not exist.', 149, $this->source); })()), "html", null, true);
        echo ";   
    }
</style>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework/Templates/lightskin.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  317 => 149,  311 => 146,  304 => 142,  296 => 139,  290 => 138,  284 => 137,  278 => 134,  274 => 133,  263 => 125,  257 => 122,  250 => 118,  242 => 113,  235 => 109,  228 => 105,  221 => 101,  215 => 98,  209 => 95,  203 => 92,  197 => 89,  189 => 86,  183 => 85,  177 => 84,  170 => 80,  163 => 76,  156 => 72,  148 => 67,  141 => 63,  137 => 62,  129 => 57,  125 => 56,  117 => 51,  110 => 47,  102 => 42,  94 => 37,  87 => 33,  79 => 28,  66 => 18,  54 => 9,  45 => 2,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% set brandColor = website.themeColor ?: '#7C70F4' %}

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

    .uv-btn-stroke:active{
        border-color: {{ brandColor }}; 
    }

    .uv-dropdown .uv-dropdown-btn-active {
        border: solid 1px {{ brandColor }};
    }

    .uv-select:focus,
    .uv-field:focus, .uv-search-inline:focus {
        border-color: {{ brandColor }};
    }

    .uv-sidebar .uv-soft-top .uv-logo svg path, 
    .uv-inner-section .uv-view .uv-image-upload-wrapper .uv-image-upload-brick .uv-image-upload-placeholder svg path {
        fill: {{ brandColor }};
    }

    .uv-inner-section .uv-view .uv-image-upload-wrapper .uv-image-upload-brick:hover .uv-image-upload-placeholder svg path {
    fill: {{ brandColor }};
    opacity: .85;
    }

    li.uv-active-sidebar {
\t\tcolor: {{ brandColor }};
\t\tborder-left: solid 3px {{ brandColor }};
    }

    .uv-sidebar ul.uv-menubar li:not(.uv-active-sidebar) a:hover,
    .uv-sidebar ul.uv-menubar li .uv-item-active {
        color: {{ brandColor }};
        border-left: solid 3px {{ brandColor }};
    }

    .uv-sidebar .uv-soft-top .uv-hamburger:hover svg path {
        fill: {{ brandColor }};
    }

    .uv-sidebar ul.uv-menubar li a:hover .uv-icon svg path,
    .uv-sidebar ul.uv-menubar li .uv-item-active .uv-icon svg path {
    fill: {{ brandColor }};
    }

    .uv-paper .uv-navbar .uv-notification-icon-count {
        background-color: {{ brandColor }};
    }

    .uv-paper .uv-container .uv-brick .uv-brick-section .uv-brick-icon:hover svg path {
        fill: {{ brandColor }};
    }

    .uv-paper .uv-container .uv-brick .uv-brick-section .uv-brick-icon {
        background-image: -webkit-linear-gradient(left, {{ brandColor }} 0%, {{ brandColor }} 100%);
        background-image: -o-linear-gradient(left, {{ brandColor }} 0%, {{ brandColor }} 100%);
        background-image: linear-gradient(to right, {{ brandColor }} 0%, {{ brandColor }} 100%);
    }
    .uv-paper .uv-container .uv-home-tabs ul li{
        border-color: {{ brandColor }};
    }
    .uv-paper .uv-container .uv-home-tabs ul .home-tab-active{
        background-color: {{ brandColor }};
    }
    .uv-inner-section .uv-view .uv-tabs ul .uv-tab-active{
        border-bottom-color: {{ brandColor }};
    }
    .uv-inner-section .uv-view .uv-tabs ul li:hover{
        border-bottom-color: {{ brandColor }};
    }
    .uv-loader span:before,.uv-loader span:after{
        background: {{ brandColor }};
    }

    .bootstrap-datetimepicker-widget table td.active, .bootstrap-datetimepicker-widget table td.active:hover {
        background-color: {{ brandColor }};
    }

    .btn-primary, .btn-primary:hover, .btn-primary:active {
        background-color: {{ brandColor }};
    }

    .uv-app-screen .uv-app-list-channels .uv-app-list-brick .uv-app-list-brick-lt{
        background-color: {{ brandColor }};
        background-image: none !important;
    }

    .uv-app-screen .uv-app-list-channels .uv-app-list-brick{
        border-color: {{ brandColor }};
    }

    .uv-inner-section .uv-view .uv-ticket-section .uv-ticket-accordion .uv-ticket-count-stat, .uv-inner-section .uv-view .uv-ticket-section .uv-ticket-accordion .uv-ticket-count-stat:hover{
        background: {{ brandColor }};
    }
    .uv-pagination a:hover {
        background-color: {{ brandColor }};
        border-color: rgba(0,0,0,.1);
    }
    .uv-box-tab ul > li a:hover, .uv-box-tab ul > li .uv-box-tab-active {
        background-color: #333333;
        border-color: #333333;
    }
    .uv-box-tab ul > li a:hover, .uv-box-tab ul > li .uv-box-tab-active {
        background-color: {{ brandColor }};
        border-color: {{ brandColor }};
    }
    .uv-paper .uv-search-result-row .uv-brick-icon {
        background-image: -webkit-linear-gradient(left, {{ brandColor }} 0%, {{ brandColor }} 100%) !important;
        background-image: -o-linear-gradient(left, {{ brandColor }} 0%, {{ brandColor }} 100%) !important;
        background-image: linear-gradient(to right, {{ brandColor }} 0%, {{ brandColor }} 100%) !important;
    }
    .uv-onboard-wrapper .uv-onboard-count:before{
        border-right-color: {{ brandColor }};
    }

    .uv-onboard-wrapper .uv-onboard-container .uv-onboard-navigator-active{
        background-color: {{ brandColor }};
    }
    .uv-icon-aside-menu,.uv-paper .uv-got-whats-new {
        background-color: {{ brandColor }};   
    }
</style>", "@UVDeskCoreFramework/Templates/lightskin.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/Templates/lightskin.html.twig");
    }
}
