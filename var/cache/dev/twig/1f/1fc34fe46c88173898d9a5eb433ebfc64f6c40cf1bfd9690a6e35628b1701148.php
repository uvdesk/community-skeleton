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

/* @UVDeskSupportCenter/Templates/header.html.twig */
class __TwigTemplate_899f2d3c0285a609c127f3c3aa9f4faead58ca928727202e7f95d054f86dbbfe extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Templates/header.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Templates/header.html.twig"));

        // line 1
        $context["currentUser"] = ((twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 1, $this->source); })()), "user", [], "any", false, false, false, 1)) ? (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 1, $this->source); })()), "getCustomerPartialDetailById", [0 => twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 1, $this->source); })()), "user", [], "any", false, false, false, 1), "id", [], "any", false, false, false, 1)], "method", false, false, false, 1)) : (null));
        // line 2
        echo "<!--Header-->
<style>
    .uv-dropdown-list  {
        text-align: left;
    }
    .uv-dropdown-list ul li {
        width: 100%;
    }
    .uv-header .uv-header-rt .uv-dropdown-list ul li a {
        color: #333;
        font-size: 16px;
        padding: 0;
    }
    .uv-header .uv-header-rt .uv-dropdown-list ul li a:hover {
        color: #2750C4;
        text-decoration: none;
    }
    .uv-profile-block .uv-dropdown-list {
        top: 0;
    }
    .uv-rtl header .uv-header-rt > span {
        display: block;
    }
    .uv-rtl header .uv-header-rt > span > .uv-dropdown-list {
        right: unset;
        left: 0px;
        top: 70px;
        text-align: right;
    }
    ";
        // line 31
        if (((isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context)) && twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 31, $this->source); })()), "bannerBackgroundColor", [], "any", false, false, false, 31))) {
            // line 32
            echo "\t\t.uv-hero {
\t\t\tbackground-color: ";
            // line 33
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 33, $this->source); })()), "bannerBackgroundColor", [], "any", false, false, false, 33), "html", null, true);
            echo ";
\t\t}
        .uv-header .uv-header-rt .uv-hamburger svg path {
            fill: ";
            // line 36
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 36, $this->source); })()), "bannerBackgroundColor", [], "any", false, false, false, 36), "html", null, true);
            echo ";
        }
        .uv-skin-dark .uv-hero {
\t\t\tbackground-color: ";
            // line 39
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 39, $this->source); })()), "bannerBackgroundColor", [], "any", false, false, false, 39), "html", null, true);
            echo ";
\t\t}
\t";
        }
        // line 42
        echo "    ";
        if (((isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context)) && twig_get_attribute($this->env, $this->source, ($context["websiteConfiguration"] ?? null), "linkColor", [], "any", true, true, false, 42))) {
            // line 43
            echo "        a:not(.uv-btn):not(.uv-btn-small):not(.uv-btn-social):not(.uv-table):not(.not-shiny) {
            color: ";
            // line 44
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 44, $this->source); })()), "linkColor", [], "any", false, false, false, 44), "html", null, true);
            echo " !important;
        }
    ";
        }
        // line 47
        echo "    ";
        if (((isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context)) && twig_get_attribute($this->env, $this->source, ($context["websiteConfiguration"] ?? null), "linkHoverColor", [], "any", true, true, false, 47))) {
            // line 48
            echo "        a:not(.uv-btn):not(.uv-btn-small):not(.uv-btn-social):not(.uv-table):not(.not-shiny):hover {
            color: ";
            // line 49
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 49, $this->source); })()), "linkHoverColor", [], "any", false, false, false, 49), "html", null, true);
            echo " !important;
        }
    ";
        }
        // line 52
        echo "    .goog-te-gadget-simple .goog-te-menu-value, .goog-te-gadget-simple .goog-te-menu-value:hover {
        color: #333!important;
    }
</style>
<div class=\"uv-header\">
    <div class=\"uv-container\">
        <header>
            <div class=\"uv-header-lt\">
                <a class=\"uv-logo\" href=\"";
        // line 60
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_folder");
        echo "\">
                    ";
        // line 61
        if (((isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context)) &&  !twig_test_empty(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 61, $this->source); })()), "website", [], "any", false, false, false, 61), "logo", [], "any", false, false, false, 61)))) {
            // line 62
            echo "                        <img src=\"";
            echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 62, $this->source); })()), "request", [], "any", false, false, false, 62), "scheme", [], "any", false, false, false, 62) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 62, $this->source); })()), "request", [], "any", false, false, false, 62), "httpHost", [], "any", false, false, false, 62)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")), "html", null, true);
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 62, $this->source); })()), "website", [], "any", false, false, false, 62), "logo", [], "any", false, false, false, 62), "html", null, true);
            echo "\" alt=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 62, $this->source); })()), "website", [], "any", false, false, false, 62), "name", [], "any", false, false, false, 62), "html", null, true);
            echo "\" />
                    ";
        } else {
            // line 64
            echo "                        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"122\" height=\"48\" viewBox=\"0 0 122 48\">
                            <defs>
                                <style>
                                .cls-1 {
                                    fill: #9f9f9f;
                                    fill-rule: evenodd;
                                    }
                                </style>
                            </defs>
                            <path id=\"uvdesk-icon\" class=\"cls-1\" d=\"M43.5,23A1.5,1.5,0,0,1,45,24.5V25H42V24.5A1.5,1.5,0,0,1,43.5,23ZM39,31H38V18h1a2.257,2.257,0,0,1,2,2v9A2.257,2.257,0,0,1,39,31Zm6-5H42s1.769,15.329-15,17c0.011-.1-0.027,1.292,0,2C33.324,44.708,45.563,40.575,45,26ZM25.987,44A1.988,1.988,0,1,1,24,41.989,2,2,0,0,1,25.987,44ZM8,41A18.173,18.173,0,0,1,3.386,29.28L3,24a14.906,14.906,0,0,0,9-5,14.838,14.838,0,0,0,5,4,17.2,17.2,0,0,0,16-1l4-3a2.479,2.479,0,0,0,0-1C36.692,8.308,27.872,0,18,0h0A17.913,17.913,0,0,0,0,18V29A21.17,21.17,0,0,0,5,43a16.677,16.677,0,0,0,7,5l1-3C10.936,44.167,9.633,42.824,8,41Zm2.492-15A3.5,3.5,0,1,0,14,29.5,3.5,3.5,0,0,0,10.492,26ZM27.5,33A3.5,3.5,0,1,0,24,29.5,3.5,3.5,0,0,0,27.5,33Z\"/>
                            <path id=\"uvdesk\" class=\"cls-1\" d=\"M53.078,25.329c0,2.976,1.1,4.56,3.576,4.56a4.931,4.931,0,0,0,3.84-2.112h0.072L60.734,29.6h1.632V17.937H60.4v8.281c-1.1,1.368-1.944,1.968-3.144,1.968-1.536,0-2.184-.936-2.184-3.12V17.937H53.078v7.393ZM68.822,29.6h2.3l4.128-11.665H73.31L71.1,24.561c-0.336,1.152-.72,2.328-1.056,3.432h-0.1c-0.36-1.1-.744-2.28-1.08-3.432l-2.208-6.625h-2.04Zm7.752-5.809c0,3.888,1.9,6.1,4.824,6.1a5.262,5.262,0,0,0,3.528-1.656H85L85.166,29.6H86.8V12.512H84.806V17l0.1,1.992a4.806,4.806,0,0,0-3.264-1.344C78.973,17.649,76.573,20,76.573,23.793Zm2.04-.024c0-2.664,1.488-4.464,3.36-4.464a4.06,4.06,0,0,1,2.832,1.224v6.1a3.948,3.948,0,0,1-2.976,1.608C79.789,28.233,78.613,26.553,78.613,23.769Zm11.256,0.024c0,3.816,2.472,6.1,5.593,6.1a6.947,6.947,0,0,0,3.84-1.2l-0.7-1.3a5.271,5.271,0,0,1-2.9.912c-2.232,0-3.744-1.584-3.888-4.1h7.873a6.956,6.956,0,0,0,.072-1.08c0-3.336-1.68-5.472-4.656-5.472C92.437,17.649,89.869,19.977,89.869,23.793Zm1.92-.888c0.24-2.352,1.728-3.7,3.36-3.7,1.824,0,2.88,1.32,2.88,3.7H91.789Zm9.552,5.376a7.021,7.021,0,0,0,4.344,1.608c2.76,0,4.272-1.584,4.272-3.48,0-2.208-1.872-2.9-3.552-3.528-1.32-.5-2.592-0.936-2.592-2.016,0-.888.672-1.68,2.136-1.68a4.331,4.331,0,0,1,2.664,1.032l0.936-1.248a5.822,5.822,0,0,0-3.624-1.32c-2.52,0-4.008,1.44-4.008,3.312,0,1.968,1.824,2.76,3.48,3.36,1.272,0.48,2.664,1.008,2.664,2.208,0,1.008-.768,1.824-2.3,1.824a5.245,5.245,0,0,1-3.432-1.392Zm11.352,1.32h1.944V26.529l2.184-2.544,3.408,5.617h2.16l-4.44-6.985,3.912-4.68h-2.184l-4.968,6.145h-0.072V12.512h-1.944V29.6Z\"/>
                        </svg>
                    ";
        }
        // line 77
        echo "                </a>
            </div>
            <div class=\"uv-header-rt\">
                ";
        // line 80
        if ((isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 80, $this->source); })())) {
            // line 81
            echo "                    <span style=\"position: relative\" class=\"uv-profile-block\">
                        <div class=\"uv-profile-wrapper uv-dropdown-other\">
                            <div class=\"uv-profile-avatar\">
                                <img src=\"";
            // line 84
            echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 84, $this->source); })()), "smallThumbnail", [], "any", false, false, false, 84)) ? (((((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 84, $this->source); })()), "request", [], "any", false, false, false, 84), "scheme", [], "any", false, false, false, 84) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 84, $this->source); })()), "request", [], "any", false, false, false, 84), "httpHost", [], "any", false, false, false, 84)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")) . twig_get_attribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 84, $this->source); })()), "smallThumbnail", [], "any", false, false, false, 84))) : ($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((isset($context["default_customer_image_path"]) || array_key_exists("default_customer_image_path", $context) ? $context["default_customer_image_path"] : (function () { throw new RuntimeError('Variable "default_customer_image_path" does not exist.', 84, $this->source); })())))), "html", null, true);
            echo "\">                       
                            </div>
                            <div class=\"uv-profile-howdy\">
                                <span>";
            // line 87
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Howdy!"), "html", null, true);
            echo "</span>
                                <span class=\"uv-username\">";
            // line 88
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 88, $this->source); })()), "firstName", [], "any", false, false, false, 88), "html", null, true);
            echo "</span>
                            </div>
                            <div class=\"uv-drop-icon\"></div>
                        </div>
                        <div class=\"uv-dropdown-list uv-bottom-right uv-text-left\">
                            <div class=\"uv-dropdown-container\">
                                <label>";
            // line 94
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Account"), "html", null, true);
            echo "</label>
                                <ul>
                                    <li>
                                        <a href=\"";
            // line 97
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_ticket_collection");
            echo "\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Tickets"), "html", null, true);
            echo "</a>
                                    </li>
                                    ";
            // line 99
            if ((twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 99, $this->source); })()), "ticketCreateOption", [], "any", false, false, false, 99) == 1)) {
                // line 100
                echo "                                        <li>
                                            <a href=\"";
                // line 101
                echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_create_ticket");
                echo "\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("New Ticket Request"), "html", null, true);
                echo "</a>
                                        </li>
                                    ";
            }
            // line 104
            echo "                                    <li>
                                        <a href=\"";
            // line 105
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_account");
            echo "\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Profile"), "html", null, true);
            echo "</a>
                                    </li>
                                    <li>
                                        <a class=\"uv-text-danger\" href=\"";
            // line 108
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_logout");
            echo "\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Sign Out"), "html", null, true);
            echo "</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </span>
                ";
        } else {
            // line 115
            echo "                    <nav id=\"front_nav\">
                        <ul>
                            <li><a href=\"";
            // line 117
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_folder");
            echo "\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Home"), "html", null, true);
            echo "</a></li>
                            ";
            // line 118
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 118, $this->source); })()), "headerLinks", [], "any", false, false, false, 118));
            foreach ($context['_seq'] as $context["_key"] => $context["headerLink"]) {
                // line 119
                echo "                                <li><a href=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["headerLink"], "url", [], "any", false, false, false, 119), "html", null, true);
                echo "\" target=\"_blank\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["headerLink"], "label", [], "any", false, false, false, 119), "html", null, true);
                echo "</a></li>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['headerLink'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 121
            echo "
                            ";
            // line 122
            if (((isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context)) && twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 122, $this->source); })()), "ticketCreateOption", [], "any", false, false, false, 122))) {
                // line 123
                echo "                                ";
                if (( !twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 123, $this->source); })()), "loginRequiredToCreate", [], "any", false, false, false, 123) || twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 123, $this->source); })()), "user", [], "any", false, false, false, 123))) {
                    // line 124
                    echo "                                    <li><a href=\"";
                    echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_create_ticket");
                    echo "\" class=\"uv-btn-small\">";
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Contact Us", [], "messages");
                    echo "</a></li>
                                ";
                }
                // line 126
                echo "                            ";
            }
            // line 127
            echo "
                            ";
            // line 128
            if (((isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context)) && twig_get_attribute($this->env, $this->source, ($context["websiteConfiguration"] ?? null), "removeCustomerLoginButton", [], "any", true, true, false, 128))) {
                // line 129
                echo "                                ";
                if ( !twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 129, $this->source); })()), "removeCustomerLoginButton", [], "any", false, false, false, 129)) {
                    // line 130
                    echo "                                    <li><a href=\"";
                    echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_login");
                    echo "\" class=\"uv-btn-small\">";
                    echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Sign In", [], "messages");
                    echo "</a></li>
                                ";
                }
                // line 131
                echo "  
                            ";
            }
            // line 133
            echo "                        </ul>
                    </nav>
                    <div class=\"uv-hamburger\">
                        <svg
                        xmlns=\"http://www.w3.org/2000/svg\"
                        xmlns:xlink=\"http://www.w3.org/1999/xlink\"
                        width=\"20px\" height=\"15px\">
                        <path fill-rule=\"evenodd\"
                        d=\"M18.500,9.000 L1.500,9.000 C0.672,9.000 0.000,8.328 0.000,7.500 C0.000,6.672 0.672,6.000 1.500,6.000 L18.500,6.000 C19.328,6.000 20.000,6.672 20.000,7.500 C20.000,8.328 19.328,9.000 18.500,9.000 ZM18.500,3.000 L1.500,3.000 C0.672,3.000 0.000,2.328 0.000,1.500 C0.000,0.672 0.672,-0.000 1.500,-0.000 L18.500,-0.000 C19.328,-0.000 20.000,0.672 20.000,1.500 C20.000,2.328 19.328,3.000 18.500,3.000 ZM1.500,12.000 L18.500,12.000 C19.328,12.000 20.000,12.672 20.000,13.500 C20.000,14.328 19.328,15.000 18.500,15.000 L1.500,15.000 C0.672,15.000 0.000,14.328 0.000,13.500 C0.000,12.672 0.672,12.000 1.500,12.000 Z\"/>
                        </svg>
                    </div>
                ";
        }
        // line 145
        echo "            </div>
        </header>
    </div>
</div>
<!--//Header-->
";
        // line 150
        if (((isset($context["searchDisable"]) || array_key_exists("searchDisable", $context)) && ((isset($context["searchDisable"]) || array_key_exists("searchDisable", $context) ? $context["searchDisable"] : (function () { throw new RuntimeError('Variable "searchDisable" does not exist.', 150, $this->source); })()) == false))) {
            // line 151
            echo "    <form method=\"get\" action=\"";
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_search");
            echo "\">
        <!--Hero-->
        <div class=\"uv-hero\">
            <div class=\"uv-container\">
                <article>
                    <h1>
                        ";
            // line 157
            if (((isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context)) && twig_get_attribute($this->env, $this->source, ($context["websiteConfiguration"] ?? null), "siteDescription", [], "any", true, true, false, 157))) {
                // line 158
                echo "                            ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 158, $this->source); })()), "siteDescription", [], "any", false, false, false, 158), "html", null, true);
                echo "
                        ";
            } else {
                // line 160
                echo "                            ";
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Hi! how can we help?", [], "messages");
                // line 161
                echo "                        ";
            }
            // line 162
            echo "                    </h1>
                    <input type=\"text\" name=\"s\" class=\"uv-kb-search-lg\" placeholder=\"";
            // line 163
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Enter search keyword"), "html", null, true);
            echo "\">
                </article>
            </div>
        </div>
        <!--Hero-->
    </form>
";
        }
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Templates/header.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  357 => 163,  354 => 162,  351 => 161,  348 => 160,  342 => 158,  340 => 157,  330 => 151,  328 => 150,  321 => 145,  307 => 133,  303 => 131,  295 => 130,  292 => 129,  290 => 128,  287 => 127,  284 => 126,  276 => 124,  273 => 123,  271 => 122,  268 => 121,  257 => 119,  253 => 118,  247 => 117,  243 => 115,  231 => 108,  223 => 105,  220 => 104,  212 => 101,  209 => 100,  207 => 99,  200 => 97,  194 => 94,  185 => 88,  181 => 87,  175 => 84,  170 => 81,  168 => 80,  163 => 77,  148 => 64,  139 => 62,  137 => 61,  133 => 60,  123 => 52,  117 => 49,  114 => 48,  111 => 47,  105 => 44,  102 => 43,  99 => 42,  93 => 39,  87 => 36,  81 => 33,  78 => 32,  76 => 31,  45 => 2,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% set currentUser = app.user ? user_service.getCustomerPartialDetailById(app.user.id) : null %}
<!--Header-->
<style>
    .uv-dropdown-list  {
        text-align: left;
    }
    .uv-dropdown-list ul li {
        width: 100%;
    }
    .uv-header .uv-header-rt .uv-dropdown-list ul li a {
        color: #333;
        font-size: 16px;
        padding: 0;
    }
    .uv-header .uv-header-rt .uv-dropdown-list ul li a:hover {
        color: #2750C4;
        text-decoration: none;
    }
    .uv-profile-block .uv-dropdown-list {
        top: 0;
    }
    .uv-rtl header .uv-header-rt > span {
        display: block;
    }
    .uv-rtl header .uv-header-rt > span > .uv-dropdown-list {
        right: unset;
        left: 0px;
        top: 70px;
        text-align: right;
    }
    {% if websiteConfiguration is defined and websiteConfiguration.bannerBackgroundColor %}
\t\t.uv-hero {
\t\t\tbackground-color: {{websiteConfiguration.bannerBackgroundColor}};
\t\t}
        .uv-header .uv-header-rt .uv-hamburger svg path {
            fill: {{ websiteConfiguration.bannerBackgroundColor }};
        }
        .uv-skin-dark .uv-hero {
\t\t\tbackground-color: {{websiteConfiguration.bannerBackgroundColor}};
\t\t}
\t{% endif %}
    {% if websiteConfiguration is defined and websiteConfiguration.linkColor is defined %}
        a:not(.uv-btn):not(.uv-btn-small):not(.uv-btn-social):not(.uv-table):not(.not-shiny) {
            color: {{ websiteConfiguration.linkColor }} !important;
        }
    {% endif %}
    {% if websiteConfiguration is defined and websiteConfiguration.linkHoverColor is defined %}
        a:not(.uv-btn):not(.uv-btn-small):not(.uv-btn-social):not(.uv-table):not(.not-shiny):hover {
            color: {{ websiteConfiguration.linkHoverColor }} !important;
        }
    {% endif %}
    .goog-te-gadget-simple .goog-te-menu-value, .goog-te-gadget-simple .goog-te-menu-value:hover {
        color: #333!important;
    }
</style>
<div class=\"uv-header\">
    <div class=\"uv-container\">
        <header>
            <div class=\"uv-header-lt\">
                <a class=\"uv-logo\" href=\"{{path('helpdesk_knowledgebase_folder')}}\">
                    {% if websiteConfiguration is defined and websiteConfiguration.website.logo is not empty %}
                        <img src=\"{{ app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') }}{{ websiteConfiguration.website.logo }}\" alt=\"{{ websiteConfiguration.website.name}}\" />
                    {% else %}
                        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"122\" height=\"48\" viewBox=\"0 0 122 48\">
                            <defs>
                                <style>
                                .cls-1 {
                                    fill: #9f9f9f;
                                    fill-rule: evenodd;
                                    }
                                </style>
                            </defs>
                            <path id=\"uvdesk-icon\" class=\"cls-1\" d=\"M43.5,23A1.5,1.5,0,0,1,45,24.5V25H42V24.5A1.5,1.5,0,0,1,43.5,23ZM39,31H38V18h1a2.257,2.257,0,0,1,2,2v9A2.257,2.257,0,0,1,39,31Zm6-5H42s1.769,15.329-15,17c0.011-.1-0.027,1.292,0,2C33.324,44.708,45.563,40.575,45,26ZM25.987,44A1.988,1.988,0,1,1,24,41.989,2,2,0,0,1,25.987,44ZM8,41A18.173,18.173,0,0,1,3.386,29.28L3,24a14.906,14.906,0,0,0,9-5,14.838,14.838,0,0,0,5,4,17.2,17.2,0,0,0,16-1l4-3a2.479,2.479,0,0,0,0-1C36.692,8.308,27.872,0,18,0h0A17.913,17.913,0,0,0,0,18V29A21.17,21.17,0,0,0,5,43a16.677,16.677,0,0,0,7,5l1-3C10.936,44.167,9.633,42.824,8,41Zm2.492-15A3.5,3.5,0,1,0,14,29.5,3.5,3.5,0,0,0,10.492,26ZM27.5,33A3.5,3.5,0,1,0,24,29.5,3.5,3.5,0,0,0,27.5,33Z\"/>
                            <path id=\"uvdesk\" class=\"cls-1\" d=\"M53.078,25.329c0,2.976,1.1,4.56,3.576,4.56a4.931,4.931,0,0,0,3.84-2.112h0.072L60.734,29.6h1.632V17.937H60.4v8.281c-1.1,1.368-1.944,1.968-3.144,1.968-1.536,0-2.184-.936-2.184-3.12V17.937H53.078v7.393ZM68.822,29.6h2.3l4.128-11.665H73.31L71.1,24.561c-0.336,1.152-.72,2.328-1.056,3.432h-0.1c-0.36-1.1-.744-2.28-1.08-3.432l-2.208-6.625h-2.04Zm7.752-5.809c0,3.888,1.9,6.1,4.824,6.1a5.262,5.262,0,0,0,3.528-1.656H85L85.166,29.6H86.8V12.512H84.806V17l0.1,1.992a4.806,4.806,0,0,0-3.264-1.344C78.973,17.649,76.573,20,76.573,23.793Zm2.04-.024c0-2.664,1.488-4.464,3.36-4.464a4.06,4.06,0,0,1,2.832,1.224v6.1a3.948,3.948,0,0,1-2.976,1.608C79.789,28.233,78.613,26.553,78.613,23.769Zm11.256,0.024c0,3.816,2.472,6.1,5.593,6.1a6.947,6.947,0,0,0,3.84-1.2l-0.7-1.3a5.271,5.271,0,0,1-2.9.912c-2.232,0-3.744-1.584-3.888-4.1h7.873a6.956,6.956,0,0,0,.072-1.08c0-3.336-1.68-5.472-4.656-5.472C92.437,17.649,89.869,19.977,89.869,23.793Zm1.92-.888c0.24-2.352,1.728-3.7,3.36-3.7,1.824,0,2.88,1.32,2.88,3.7H91.789Zm9.552,5.376a7.021,7.021,0,0,0,4.344,1.608c2.76,0,4.272-1.584,4.272-3.48,0-2.208-1.872-2.9-3.552-3.528-1.32-.5-2.592-0.936-2.592-2.016,0-.888.672-1.68,2.136-1.68a4.331,4.331,0,0,1,2.664,1.032l0.936-1.248a5.822,5.822,0,0,0-3.624-1.32c-2.52,0-4.008,1.44-4.008,3.312,0,1.968,1.824,2.76,3.48,3.36,1.272,0.48,2.664,1.008,2.664,2.208,0,1.008-.768,1.824-2.3,1.824a5.245,5.245,0,0,1-3.432-1.392Zm11.352,1.32h1.944V26.529l2.184-2.544,3.408,5.617h2.16l-4.44-6.985,3.912-4.68h-2.184l-4.968,6.145h-0.072V12.512h-1.944V29.6Z\"/>
                        </svg>
                    {% endif %}
                </a>
            </div>
            <div class=\"uv-header-rt\">
                {% if currentUser %}
                    <span style=\"position: relative\" class=\"uv-profile-block\">
                        <div class=\"uv-profile-wrapper uv-dropdown-other\">
                            <div class=\"uv-profile-avatar\">
                                <img src=\"{{ currentUser.smallThumbnail ?  app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') ~ currentUser.smallThumbnail : asset(default_customer_image_path) }}\">                       
                            </div>
                            <div class=\"uv-profile-howdy\">
                                <span>{{ 'Howdy!'|trans }}</span>
                                <span class=\"uv-username\">{{ currentUser.firstName }}</span>
                            </div>
                            <div class=\"uv-drop-icon\"></div>
                        </div>
                        <div class=\"uv-dropdown-list uv-bottom-right uv-text-left\">
                            <div class=\"uv-dropdown-container\">
                                <label>{{ 'Account'|trans }}</label>
                                <ul>
                                    <li>
                                        <a href=\"{{ path('helpdesk_customer_ticket_collection') }}\">{{ 'Tickets'|trans }}</a>
                                    </li>
                                    {% if websiteConfiguration.ticketCreateOption == 1 %}
                                        <li>
                                            <a href=\"{{ path('helpdesk_customer_create_ticket') }}\">{{ 'New Ticket Request'|trans }}</a>
                                        </li>
                                    {% endif %}
                                    <li>
                                        <a href=\"{{ path('helpdesk_customer_account') }}\">{{ 'Profile'|trans }}</a>
                                    </li>
                                    <li>
                                        <a class=\"uv-text-danger\" href=\"{{ path('helpdesk_customer_logout') }}\">{{ 'Sign Out'|trans }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </span>
                {% else %}
                    <nav id=\"front_nav\">
                        <ul>
                            <li><a href=\"{{path('helpdesk_knowledgebase_folder')}}\">{{\"Home\"|trans}}</a></li>
                            {% for headerLink in websiteConfiguration.headerLinks %}
                                <li><a href=\"{{headerLink.url}}\" target=\"_blank\">{{headerLink.label}}</a></li>
                            {% endfor %}

                            {% if websiteConfiguration is defined and websiteConfiguration.ticketCreateOption %}
                                {% if not websiteConfiguration.loginRequiredToCreate or app.user %}
                                    <li><a href=\"{{path('helpdesk_customer_create_ticket')}}\" class=\"uv-btn-small\">{% trans %}Contact Us{% endtrans %}</a></li>
                                {% endif %}
                            {% endif %}

                            {% if websiteConfiguration is defined and websiteConfiguration.removeCustomerLoginButton is defined %}
                                {% if not websiteConfiguration.removeCustomerLoginButton %}
                                    <li><a href=\"{{path('helpdesk_customer_login')}}\" class=\"uv-btn-small\">{% trans %}Sign In{% endtrans %}</a></li>
                                {% endif %}  
                            {% endif %}
                        </ul>
                    </nav>
                    <div class=\"uv-hamburger\">
                        <svg
                        xmlns=\"http://www.w3.org/2000/svg\"
                        xmlns:xlink=\"http://www.w3.org/1999/xlink\"
                        width=\"20px\" height=\"15px\">
                        <path fill-rule=\"evenodd\"
                        d=\"M18.500,9.000 L1.500,9.000 C0.672,9.000 0.000,8.328 0.000,7.500 C0.000,6.672 0.672,6.000 1.500,6.000 L18.500,6.000 C19.328,6.000 20.000,6.672 20.000,7.500 C20.000,8.328 19.328,9.000 18.500,9.000 ZM18.500,3.000 L1.500,3.000 C0.672,3.000 0.000,2.328 0.000,1.500 C0.000,0.672 0.672,-0.000 1.500,-0.000 L18.500,-0.000 C19.328,-0.000 20.000,0.672 20.000,1.500 C20.000,2.328 19.328,3.000 18.500,3.000 ZM1.500,12.000 L18.500,12.000 C19.328,12.000 20.000,12.672 20.000,13.500 C20.000,14.328 19.328,15.000 18.500,15.000 L1.500,15.000 C0.672,15.000 0.000,14.328 0.000,13.500 C0.000,12.672 0.672,12.000 1.500,12.000 Z\"/>
                        </svg>
                    </div>
                {% endif %}
            </div>
        </header>
    </div>
</div>
<!--//Header-->
{% if searchDisable is defined and searchDisable == false %}
    <form method=\"get\" action=\"{{path('helpdesk_knowledgebase_search')}}\">
        <!--Hero-->
        <div class=\"uv-hero\">
            <div class=\"uv-container\">
                <article>
                    <h1>
                        {% if websiteConfiguration is defined and websiteConfiguration.siteDescription is defined %}
                            {{ websiteConfiguration.siteDescription }}
                        {% else %}
                            {% trans %}Hi! how can we help?{% endtrans %}
                        {% endif %}
                    </h1>
                    <input type=\"text\" name=\"s\" class=\"uv-kb-search-lg\" placeholder=\"{{\"Enter search keyword\"|trans}}\">
                </article>
            </div>
        </div>
        <!--Hero-->
    </form>
{% endif %}
", "@UVDeskSupportCenter/Templates/header.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Templates/header.html.twig");
    }
}
