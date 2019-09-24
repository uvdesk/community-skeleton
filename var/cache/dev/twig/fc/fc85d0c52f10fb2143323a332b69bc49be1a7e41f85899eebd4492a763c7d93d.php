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

/* @UVDeskSupportCenter/Staff/branding.html.twig */
class __TwigTemplate_752405240dcd51ce194d4179ef8705ba1526a398f11e775f174b5bc111fe6352 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'pageContent' => [$this, 'block_pageContent'],
            'footer' => [$this, 'block_footer'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "@UVDeskCoreFramework//Templates//layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Staff/branding.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Staff/branding.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskSupportCenter/Staff/branding.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        // line 4
        echo "\t";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Branding"), "html", null, true);
        echo "
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 7
    public function block_pageContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        // line 8
        echo "    <style>
        .uv-image-upload-brick {
            margin: 10px 0px;
        }
        .uv-color-field {
            color: #fff;
            width: 100px;
            text-transform: uppercase;
        }
        .uv-header-link-wrapper {
            padding-bottom: 20px;
        }
        .uv-footer-link-wrapper {
            border-top: solid 1px #D3D3D3;
            padding-top: 20px;
        }
        .uv-knowledgebase-layout  {
            border-top: solid 1px #D3D3D3;
            padding-top: 20px;
            margin-top: 20px;
        }
        .uv-knowledgebase-layout input[type='radio'] {
            display: none;
        }
        #links .uv-field-block input:first-child {
            width: 200px;
            margin-bottom: 0;
        }
        #links .remove-link {
            margin-left: 10px;
        }
\t\t.grammarly-fix-broadcast {
\t\t\tmax-width: 518px;
\t\t}
        #uv-reset-colors {
            float: right;
            cursor: pointer;
            position: relative;
            z-index:1 ;
        }
    </style>
\t<div class=\"uv-inner-section\">\t\t
\t\t";
        // line 51
        echo "\t\t";
        $context["asideTemplate"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\AsideTemplate";
        // line 52
        echo "\t\t";
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Branding";
        // line 53
        echo "
\t\t";
        // line 54
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 54, $this->source); })()), "getRegisteredComponent", [0 => (isset($context["asideTemplate"]) || array_key_exists("asideTemplate", $context) ? $context["asideTemplate"] : (function () { throw new RuntimeError('Variable "asideTemplate" does not exist.', 54, $this->source); })())], "method", false, false, false, 54), "renderSidebar", [0 => (isset($context["asideSidebarReference"]) || array_key_exists("asideSidebarReference", $context) ? $context["asideSidebarReference"] : (function () { throw new RuntimeError('Variable "asideSidebarReference" does not exist.', 54, $this->source); })())], "method", false, false, false, 54);
        echo "

\t\t<div class=\"uv-view ";
        // line 56
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 56, $this->source); })()), "request", [], "any", false, false, false, 56), "cookies", [], "any", false, false, false, 56) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 56, $this->source); })()), "request", [], "any", false, false, false, 56), "cookies", [], "any", false, false, false, 56), "get", [0 => "uv-asideView"], "method", false, false, false, 56))) {
            echo "uv-aside-view";
        }
        echo "\">
\t\t\t<h1>";
        // line 57
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Branding"), "html", null, true);
        echo "</h1>
\t\t\t<!--Tabs-->
\t\t\t<div class=\"uv-tabs\">
\t\t\t\t<ul>
\t\t\t\t\t<li for=\"general\" ";
        // line 61
        if ((((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 61, $this->source); })()) == "general") || ((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 61, $this->source); })()) == ""))) {
            echo "class=\"uv-tab-active\"";
        }
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("General"), "html", null, true);
        echo "</li>
\t\t\t\t\t<li for=\"knowledgebase\" ";
        // line 62
        if (((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 62, $this->source); })()) == "knowledgebase")) {
            echo " class=\"uv-tab-active\"";
        }
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Knowledgebase"), "html", null, true);
        echo "</li>
                    <li for=\"time\" ";
        // line 63
        if (((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 63, $this->source); })()) == "time")) {
            echo "class=\"uv-tab-active\"";
        }
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Time"), "html", null, true);
        echo "</li>
\t\t\t\t\t<li for=\"seo\" ";
        // line 64
        if (((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 64, $this->source); })()) == "seo")) {
            echo "class=\"uv-tab-active\"";
        }
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("SEO"), "html", null, true);
        echo "</li>
\t\t\t\t\t<li for=\"links\" ";
        // line 65
        if (((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 65, $this->source); })()) == "links")) {
            echo "class=\"uv-tab-active\"";
        }
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Links"), "html", null, true);
        echo "</li>
                    <li for=\"advanced\" ";
        // line 66
        if (((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 66, $this->source); })()) == "advanced")) {
            echo "class=\"uv-tab-active\"";
        }
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Advanced"), "html", null, true);
        echo "</li>
\t\t\t\t\t<li for=\"broadcasting\" ";
        // line 67
        if (((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 67, $this->source); })()) == "broadcasting")) {
            echo "class=\"uv-tab-active\"";
        }
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Broadcast Message"), "html", null, true);
        echo "</li>                  
\t\t\t\t</ul>
\t\t\t</div>
\t\t\t<!--Tabs-->

\t\t\t<!--Tab View-->
\t\t\t<div class=\"uv-tab-view ";
        // line 73
        if ((((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 73, $this->source); })()) == "general") || ((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 73, $this->source); })()) == ""))) {
            echo "uv-tab-view-active";
        }
        echo "\" id=\"general\">
\t\t\t\t<!--Form-->
\t\t\t\t<form method=\"post\" action=\"";
        // line 75
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_theme", ["type" => "general"]);
        echo "\" id=\"generalSettingForm\" enctype=\"multipart/form-data\">
                    <!-- Image block -->
                    <div class=\"uv-image-upload-wrapper uv-no-error-success-icon\">
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">";
        // line 79
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Wide Logo"), "html", null, true);
        echo "</label>
                            <div class=\"uv-field-block\">
                                ";
        // line 81
        $context["isLogo"] = ((twig_get_attribute($this->env, $this->source, (isset($context["websiteData"]) || array_key_exists("websiteData", $context) ? $context["websiteData"] : (function () { throw new RuntimeError('Variable "websiteData" does not exist.', 81, $this->source); })()), "logo", [], "any", false, false, false, 81)) ? (1) : (0));
        // line 82
        echo "                                <div class=\"uv-image-upload-brick uv-image-upload-brick-200 ";
        if ((isset($context["isLogo"]) || array_key_exists("isLogo", $context) ? $context["isLogo"] : (function () { throw new RuntimeError('Variable "isLogo" does not exist.', 82, $this->source); })())) {
            echo "uv-on-drop-shadow";
        }
        echo "\" ";
        if ((isset($context["isLogo"]) || array_key_exists("isLogo", $context) ? $context["isLogo"] : (function () { throw new RuntimeError('Variable "isLogo" does not exist.', 82, $this->source); })())) {
            echo "style=\"border-color: transparent;\"";
        }
        echo ">
                                    <input type=\"file\" name=\"website[logo]\" id=\"uv-upload-profile\" accept=\"image/*\">
                                    <div class=\"uv-image-upload-placeholder\">
                                        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"48\" height=\"32\" viewBox=\"0 0 48 32\">
                                            <path fill=\"#7c74f1\" fill-rule=\"evenodd\" d=\"M26.516,22.252H21.477V17.226h-3.75L24,11.031l6.269,6.195h-3.75v5.026ZM29.973,8.138A9.1,9.1,0,0,0,24,6.005a8.947,8.947,0,0,0-4.863,1.4,9.78,9.78,0,0,0-3.457,3.682A7.494,7.494,0,0,0,9,18.512a7.2,7.2,0,0,0,2.2,5.289,7.234,7.234,0,0,0,5.3,2.192H32.727A6.294,6.294,0,0,0,39,19.739,5.933,5.933,0,0,0,37.3,15.5a6.113,6.113,0,0,0-4.1-1.958A9.112,9.112,0,0,0,29.973,8.138Z\"/>
                                        </svg>
                                    </div>
                                    <img id=\"dynamic-image-upload\" ";
        // line 89
        if ((isset($context["isLogo"]) || array_key_exists("isLogo", $context) ? $context["isLogo"] : (function () { throw new RuntimeError('Variable "isLogo" does not exist.', 89, $this->source); })())) {
            echo " src=\"";
            echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 89, $this->source); })()), "request", [], "any", false, false, false, 89), "scheme", [], "any", false, false, false, 89) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 89, $this->source); })()), "request", [], "any", false, false, false, 89), "httpHost", [], "any", false, false, false, 89)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")), "html", null, true);
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["websiteData"]) || array_key_exists("websiteData", $context) ? $context["websiteData"] : (function () { throw new RuntimeError('Variable "websiteData" does not exist.', 89, $this->source); })()), "logo", [], "any", false, false, false, 89), "html", null, true);
            echo "\" ";
        }
        echo ">

                                </div>
                                <div class=\"uv-image-info-brick\">
                                    <span class=\"uv-field-info\">";
        // line 93
        echo $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Upload an Image (200px x 48px) in</br> PNG or JPG Format");
        echo "</span>
                                </div>
                            </div>
                            <span class=\"uv-field-info\">";
        // line 96
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("It will be shown as Logo on Knowledgebase and Helpdesk"), "html", null, true);
        echo "</span>
                        </div>
                    </div>
                    <!-- //Image block -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t  \t<label class=\"uv-field-label\">";
        // line 103
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Website Status"), "html", null, true);
        echo "</label>
                          <div class=\"uv-field-block\">
                            <div class=\"uv-checkbox uv-margin-top-5\">
                                <input type=\"checkbox\" name=\"website[status]\" style=\"cursor:pointer;\" ";
        // line 106
        echo ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 106, $this->source); })()), "status", [], "any", false, false, false, 106)) ? ("checked=\"checked\"") : (""));
        echo " >
                                <span class=\"uv-checkbox-view\"></span>
                            </div>
                            <span class=\"uv-field-info uv-margin-top-5\">";
        // line 109
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Enable front end website and knowledgebase for customer(s)"), "html", null, true);
        echo "</span>
                        </div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        ";
        // line 117
        echo "\t\t\t\t\t  \t<label class=\"uv-field-label\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Brand Color"), "html", null, true);
        echo "</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[brandColor]\" class=\"uv-field uv-color-field\" type=\"text\" value=\"";
        // line 119
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 119, $this->source); })()), "brandColor", [], "any", false, false, false, 119)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 119, $this->source); })()), "brandColor", [], "any", false, false, false, 119), "html", null, true))) : (print ("#7C70F4")));
        echo "\" style=\"background:";
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 119, $this->source); })()), "brandColor", [], "any", false, false, false, 119)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 119, $this->source); })()), "brandColor", [], "any", false, false, false, 119), "html", null, true))) : (print ("#7C70F4")));
        echo "\" placeholder=\"#7C70F4\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->
                    
\t\t\t\t\t<!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t  \t<label class=\"uv-field-label\">";
        // line 126
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Name"), "html", null, true);
        echo "</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[name]\" class=\"uv-field\" type=\"text\" value=\"";
        // line 128
        ((twig_get_attribute($this->env, $this->source, (isset($context["websiteData"]) || array_key_exists("websiteData", $context) ? $context["websiteData"] : (function () { throw new RuntimeError('Variable "websiteData" does not exist.', 128, $this->source); })()), "name", [], "any", false, false, false, 128)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["websiteData"]) || array_key_exists("websiteData", $context) ? $context["websiteData"] : (function () { throw new RuntimeError('Variable "websiteData" does not exist.', 128, $this->source); })()), "name", [], "any", false, false, false, 128), "html", null, true))) : (print ("")));
        echo "\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t<!--CTA-->
\t\t\t\t\t<input class=\"uv-btn general-btn\" href=\"#\" value=\"";
        // line 134
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"button\">
\t\t\t\t\t<!--//CTA-->
\t\t\t\t</form>
\t\t\t\t<!--//Form-->
\t\t\t</div>
\t\t\t<!--//Tab View-->

\t\t\t<!--Tab View-->
            <div class=\"uv-tab-view ";
        // line 142
        if (((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 142, $this->source); })()) == "knowledgebase")) {
            echo "uv-tab-view-active";
        }
        echo "\" id=\"knowledgebase\">
                <!--Form-->
\t\t\t\t<form method=\"post\" action=\"";
        // line 144
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_theme", ["type" => "knowledgebase"]);
        echo "\" id=\"knowledgebaseForm\">
                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        <span  id=\"uv-reset-colors\" class=\"uv-icon-history\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"";
        // line 147
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Use Default Colors"), "html", null, true);
        echo "\"></span>
                        ";
        // line 149
        echo "\t\t\t\t\t  \t<label class=\"uv-field-label\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Page Background Color"), "html", null, true);
        echo "</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[pageBackgroundColor]\" class=\"uv-field uv-color-field\" type=\"text\" value=\"";
        // line 151
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 151, $this->source); })()), "pageBackgroundColor", [], "any", false, false, false, 151), "html", null, true);
        echo "\" style=\"background: ";
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 151, $this->source); })()), "pageBackgroundColor", [], "any", false, false, false, 151)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 151, $this->source); })()), "pageBackgroundColor", [], "any", false, false, false, 151), "html", null, true))) : (print ("#FFFFFF")));
        echo "\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        ";
        // line 159
        echo "\t\t\t\t\t  \t<label class=\"uv-field-label\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Header Background Color"), "html", null, true);
        echo "</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[headerBackgroundColor]\" class=\"uv-field uv-color-field\" type=\"text\" value=\"";
        // line 161
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 161, $this->source); })()), "headerBackgroundColor", [], "any", false, false, false, 161)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 161, $this->source); })()), "headerBackgroundColor", [], "any", false, false, false, 161), "html", null, true))) : (print ("#FFFFFF")));
        echo "\" style=\"background: ";
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 161, $this->source); })()), "pageBackgroundColor", [], "any", false, false, false, 161)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 161, $this->source); })()), "headerBackgroundColor", [], "any", false, false, false, 161), "html", null, true))) : (print ("#FFFFFF")));
        echo "\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        ";
        // line 169
        echo "\t\t\t\t\t  \t<label class=\"uv-field-label\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Banner Background Color"), "html", null, true);
        echo "</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[bannerBackgroundColor]\" class=\"uv-field uv-color-field\" type=\"text\" value=\"";
        // line 171
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 171, $this->source); })()), "bannerBackgroundColor", [], "any", false, false, false, 171)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 171, $this->source); })()), "bannerBackgroundColor", [], "any", false, false, false, 171), "html", null, true))) : (print ("#70B5F4")));
        echo "\" style=\"background: ";
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 171, $this->source); })()), "bannerBackgroundColor", [], "any", false, false, false, 171)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 171, $this->source); })()), "bannerBackgroundColor", [], "any", false, false, false, 171), "html", null, true))) : (print ("#70B5F4")));
        echo "\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        ";
        // line 179
        echo "\t\t\t\t\t  \t<label class=\"uv-field-label\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Page Link Color"), "html", null, true);
        echo "</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[linkColor]\" class=\"uv-field uv-color-field\" type=\"text\" value=\"";
        // line 181
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 181, $this->source); })()), "linkColor", [], "any", false, false, false, 181)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 181, $this->source); })()), "linkColor", [], "any", false, false, false, 181), "html", null, true))) : (print ("#C427A1")));
        echo "\" style=\"background: ";
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 181, $this->source); })()), "linkColor", [], "any", false, false, false, 181)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 181, $this->source); })()), "linkColor", [], "any", false, false, false, 181), "html", null, true))) : (print ("#C427A1")));
        echo "\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        ";
        // line 189
        echo "\t\t\t\t\t  \t<label class=\"uv-field-label\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Page Link Hover Color"), "html", null, true);
        echo "</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[linkHoverColor]\" class=\"uv-field uv-color-field\" type=\"text\" value=\"";
        // line 191
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 191, $this->source); })()), "linkHoverColor", [], "any", false, false, false, 191)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 191, $this->source); })()), "linkHoverColor", [], "any", false, false, false, 191), "html", null, true))) : (print ("#2750C4")));
        echo "\" style=\"background: ";
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 191, $this->source); })()), "linkColor", [], "any", false, false, false, 191)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 191, $this->source); })()), "linkHoverColor", [], "any", false, false, false, 191), "html", null, true))) : (print ("#2750C4")));
        echo "\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        ";
        // line 199
        echo "\t\t\t\t\t  \t<label class=\"uv-field-label\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Article Text Color"), "html", null, true);
        echo "</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[articleTextColor]\" class=\"uv-field uv-color-field\" type=\"text\" value=\"";
        // line 201
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 201, $this->source); })()), "articleTextColor", [], "any", false, false, false, 201)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 201, $this->source); })()), "articleTextColor", [], "any", false, false, false, 201), "html", null, true))) : (print ("#333333")));
        echo "\" style=\"background: ";
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 201, $this->source); })()), "linkColor", [], "any", false, false, false, 201)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 201, $this->source); })()), "articleTextColor", [], "any", false, false, false, 201), "html", null, true))) : (print ("#333333")));
        echo "\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t  \t<label class=\"uv-field-label\">";
        // line 208
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Tag Line"), "html", null, true);
        echo "</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[siteDescription]\" class=\"uv-field\" type=\"text\" value=\"";
        // line 210
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 210, $this->source); })()), "siteDescription", [], "any", false, false, false, 210)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 210, $this->source); })()), "siteDescription", [], "any", false, false, false, 210), "html", null, true))) : (print ("")));
        echo "\" placeholder=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Hi! how can we help?"), "html", null, true);
        echo " \">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <div class=\"uv-knowledgebase-layout uv-no-error-success-icon\">
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">";
        // line 217
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Layout "), "html", null, true);
        echo "</label>
                            <div class=\"uv-layout-icon-wrapper\">
                                <label for=\"homepage-masonry\" class=\"uv-layout-icon uv-layout-grid ";
        // line 219
        if ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 219, $this->source); })()), "homepageContent", [], "any", false, false, false, 219) && (twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 219, $this->source); })()), "homepageContent", [], "any", false, false, false, 219) == "masonry"))) {
            echo "uv-layout-icon-active";
        }
        echo "\" data-toggle=\"tooltip\" title=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Masonry"), "html", null, true);
        echo "\"></label>
                                <input name=\"website[homepageContent]\" type=\"radio\" id=\"homepage-masonry\" value=\"masonry\" ";
        // line 220
        if ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 220, $this->source); })()), "homepageContent", [], "any", false, false, false, 220) && (twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 220, $this->source); })()), "homepageContent", [], "any", false, false, false, 220) == "masonry"))) {
            echo "checked";
        }
        echo "/>

                                <label for=\"homepage-folder\" class=\"uv-layout-icon uv-layout-folder ";
        // line 222
        if ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 222, $this->source); })()), "homepageContent", [], "any", false, false, false, 222) && (twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 222, $this->source); })()), "homepageContent", [], "any", false, false, false, 222) == "folder"))) {
            echo "uv-layout-icon-active";
        }
        echo "\" data-toggle=\"tooltip\" title=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Folder"), "html", null, true);
        echo "\"></label>
                                <input name=\"website[homepageContent]\" type=\"radio\" id=\"homepage-folder\" value=\"folder\" ";
        // line 223
        if ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 223, $this->source); })()), "homepageContent", [], "any", false, false, false, 223) && (twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 223, $this->source); })()), "homepageContent", [], "any", false, false, false, 223) == "folder"))) {
            echo "checked";
        }
        echo "/>

                                <label for=\"homepage-category\" class=\"uv-layout-icon uv-layout-category ";
        // line 225
        if ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 225, $this->source); })()), "homepageContent", [], "any", false, false, false, 225) && (twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 225, $this->source); })()), "homepageContent", [], "any", false, false, false, 225) == "category"))) {
            echo "uv-layout-icon-active";
        }
        echo "\" data-toggle=\"tooltip\" title=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Category"), "html", null, true);
        echo "\"></label>
                                <input name=\"website[homepageContent]\" type=\"radio\" id=\"homepage-category\" value=\"category\" ";
        // line 226
        if ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 226, $this->source); })()), "homepageContent", [], "any", false, false, false, 226) && (twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 226, $this->source); })()), "homepageContent", [], "any", false, false, false, 226) == "category"))) {
            echo "checked";
        }
        echo "/>

                                <label for=\"homepage-article\" class=\"uv-layout-icon uv-layout-article ";
        // line 228
        if ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 228, $this->source); })()), "homepageContent", [], "any", false, false, false, 228) && (twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 228, $this->source); })()), "homepageContent", [], "any", false, false, false, 228) == "article"))) {
            echo "uv-layout-icon-active";
        }
        echo "\" data-toggle=\"tooltip\" title=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Popular Article"), "html", null, true);
        echo "\"></label>
                                <input name=\"website[homepageContent]\" type=\"radio\" id=\"homepage-article\" value=\"article\" ";
        // line 229
        if ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 229, $this->source); })()), "homepageContent", [], "any", false, false, false, 229) && (twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 229, $this->source); })()), "homepageContent", [], "any", false, false, false, 229) == "article"))) {
            echo "checked";
        }
        echo "/>
                            </div>
                        </div>

                        <!-- Field -->
                        <div class=\"uv-element-block\" style=\"margin: 20px 0\">
                            <label>
                                <div class=\"uv-checkbox\">
                                    <input name=\"website[ticketCreateOption]\" type=\"checkbox\" ";
        // line 237
        echo ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 237, $this->source); })()), "ticketCreateOption", [], "any", false, false, false, 237)) ? ("checked=\"checked\"") : (""));
        echo " />
                                    <span class=\"uv-checkbox-view\"></span>
                                </div>
                                <span class=\"uv-checkbox-label\">";
        // line 240
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Ticket Create Option"), "html", null, true);
        echo "</span>
                            </label>
                        </div>
\t\t\t\t\t    <!-- //Field -->

                        <!-- Field -->
                        <div class=\"uv-element-block\" style=\"margin: 20px 0\">
                            <label>
                                <div class=\"uv-checkbox\">
                                    <input name=\"website[loginRequiredToCreate]\" type=\"checkbox\" ";
        // line 249
        echo ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 249, $this->source); })()), "loginRequiredToCreate", [], "any", false, false, false, 249)) ? ("checked=\"checked\"") : (""));
        echo "/>
                                    <span class=\"uv-checkbox-view\"></span>
                                </div>
                                <span class=\"uv-checkbox-label\">";
        // line 252
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Login Required To Create Tickets"), "html", null, true);
        echo "</span>
                            </label>
                        </div>
\t\t\t\t\t    <!-- //Field -->

                        <!-- Field -->
                        <div class=\"uv-element-block\" style=\"margin: 20px 0\">
                            <label>
                                <div class=\"uv-checkbox\">
                                    <input name=\"website[removeCustomerLoginButton]\" type=\"checkbox\" value=\"1\" ";
        // line 261
        echo ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 261, $this->source); })()), "removeCustomerLoginButton", [], "any", false, false, false, 261)) ? ("checked=\"checked\"") : (""));
        echo " />
                                    <span class=\"uv-checkbox-view\"></span>
                                </div>
                                <span class=\"uv-checkbox-label\">";
        // line 264
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Remove Customer Login/Signin Button"), "html", null, true);
        echo "</span>
                            </label>
                        </div>
                        <!-- //Field -->

                        <!-- Field -->
                        <div class=\"uv-element-block\" style=\"margin: 20px 0\">
                            <label>
                                <div class=\"uv-checkbox\">
                                    <input name=\"website[disableCustomerLogin]\" type=\"checkbox\" value=\"1\" ";
        // line 273
        echo ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 273, $this->source); })()), "disableCustomerLogin", [], "any", false, false, false, 273)) ? ("checked=\"checked\"") : (""));
        echo " />
                                    <span class=\"uv-checkbox-view\"></span>
                                </div>
                                <span class=\"uv-checkbox-label\">";
        // line 276
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Disable Customer Login"), "html", null, true);
        echo "</span>
                            </label>
                        </div>
                        <!-- //Field -->
                    </div>

                    <!-- CSRF token Field -->
                    ";
        // line 284
        echo "                    <!-- //CSRF token Field -->

\t\t\t\t\t<!--CTA-->
\t\t\t\t\t<input class=\"uv-btn knowledgebase-btn\" href=\"#\" value=\"";
        // line 287
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"button\">
\t\t\t\t\t<!--//CTA-->
                </form>
\t\t\t</div>
\t\t\t<!--//Tab View-->

            <!--Tab View-->
            <div class=\"uv-tab-view ";
        // line 294
        if (((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 294, $this->source); })()) == "seo")) {
            echo "uv-tab-view-active";
        }
        echo "\" id=\"seo\">
                <form method=\"post\" action=\"";
        // line 295
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_theme", ["type" => "seo"]);
        echo "\" id=\"seoForm\">

\t\t\t\t\t<!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 299
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Meta Description (Recommended)"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <textarea name=\"metaDescription\" class=\"uv-field\">";
        // line 301
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 301, $this->source); })()), "metaDescription", [], "any", false, false, false, 301)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 301, $this->source); })()), "metaDescription", [], "any", false, false, false, 301), "html", null, true))) : (print ("")));
        echo "</textarea>
                        </div>
                    </div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 308
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Meta Keywords (Recommended)"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <textarea name=\"metaKeywords\" class=\"uv-field\">";
        // line 310
        ((twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 310, $this->source); })()), "metaKeywords", [], "any", false, false, false, 310)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 310, $this->source); })()), "metaKeywords", [], "any", false, false, false, 310), "html", null, true))) : (print ("")));
        echo "</textarea>
                        </div>
                    </div>
\t\t\t\t\t<!-- //Field -->

                    <!-- CSRF token Field -->
                    <input type=\"hidden\" name=\"_token\" value=\"\"/>
                    <!-- //CSRF token Field -->

\t\t\t\t\t<!--CTA-->
\t\t\t\t\t<input class=\"uv-btn seo-btn\" href=\"#\" value=\"";
        // line 320
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"button\">
\t\t\t\t\t<!--//CTA-->
                </form>
\t\t\t</div>
\t\t\t<!--//Tab View-->

            <!--Tab View-->
            <div class=\"uv-tab-view ";
        // line 327
        if (((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 327, $this->source); })()) == "links")) {
            echo "uv-tab-view-active";
        }
        echo "\" id=\"links\">
                <form method=\"post\" action=\"";
        // line 328
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_theme", ["type" => "links"]);
        echo "\" id=\"linksForm\" class=\"uv-no-error-success-icon\">

                    <div class=\"uv-header-link-wrapper\">
                        <div class=\"links\">
                            ";
        // line 332
        if (twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 332, $this->source); })()), "headerLinks", [], "any", false, false, false, 332))) {
            // line 333
            echo "                                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 333, $this->source); })()), "headerLinks", [], "any", false, false, false, 333));
            foreach ($context['_seq'] as $context["key"] => $context["link"]) {
                // line 334
                echo "                                    <!-- Field -->
                                    <div class=\"uv-element-block\">
                                        <label class=\"uv-field-label\">";
                // line 336
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Header Link"), "html", null, true);
                echo " #";
                echo twig_escape_filter($this->env, $context["key"], "html", null, true);
                echo "</label>
                                        <div class=\"uv-field-block\">
                                            <input type=\"text\" class=\"uv-field\" name=\"headerLinks[";
                // line 338
                echo twig_escape_filter($this->env, $context["key"], "html", null, true);
                echo "][label]\" value=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["link"], "label", [], "any", false, false, false, 338), "html", null, true);
                echo "\"  placeholder=\"";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Label"), "html", null, true);
                echo "\"/>
                                            <input type=\"text\" class=\"uv-field\" name=\"headerLinks[";
                // line 339
                echo twig_escape_filter($this->env, $context["key"], "html", null, true);
                echo "][url]\" value=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["link"], "url", [], "any", false, false, false, 339), "html", null, true);
                echo "\"  placeholder=\"";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("URL (with http:// or https://)"), "html", null, true);
                echo "\" />
                                            <a class=\"uv-btn-tag remove-link\" href=\"#\"><span class=\"uv-icon-remove-dark-box\"></span></a>
                                        </div>
                                    </div>
                                    <!-- //Field -->
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['link'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 345
            echo "                            ";
        } else {
            // line 346
            echo "                                <!-- Field -->
                                <div class=\"uv-element-block\">
                                    <label class=\"uv-field-label\">";
            // line 348
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Header Link"), "html", null, true);
            echo " #1</label>
                                    <div class=\"uv-field-block\">
                                        <input type=\"text\" class=\"uv-field\" name=\"headerLinks[1][label]\" placeholder=\"";
            // line 350
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Label"), "html", null, true);
            echo "\" />
                                        <input type=\"text\" class=\"uv-field\" name=\"headerLinks[1][url]\" placeholder=\"";
            // line 351
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("URL (with http:// or https://)"), "html", null, true);
            echo "\" />
                                        <a class=\"uv-btn-tag remove-link\" href=\"#\"><span class=\"uv-icon-remove-dark-box\"></span></a>
                                    </div>
                                </div>
                                <!-- //Field -->
                            ";
        }
        // line 357
        echo "                        </div>

                        <a class=\"uv-btn-tag btn-add\" href=\"#\" data-type=\"header\">
                            <span class=\"uv-icon-add-dark\"></span> ";
        // line 360
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add More"), "html", null, true);
        echo "
                        </a>
                    </div>

                    <div class=\"uv-footer-link-wrapper\">
                        <div class=\"links\">
                            ";
        // line 366
        if (twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 366, $this->source); })()), "footerLinks", [], "any", false, false, false, 366))) {
            // line 367
            echo "                                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 367, $this->source); })()), "footerLinks", [], "any", false, false, false, 367));
            foreach ($context['_seq'] as $context["key"] => $context["link"]) {
                // line 368
                echo "                                    <!-- Field -->
                                    <div class=\"uv-element-block\">
                                        <label class=\"uv-field-label\">";
                // line 370
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Footer Link"), "html", null, true);
                echo " #";
                echo twig_escape_filter($this->env, $context["key"], "html", null, true);
                echo "</label>
                                        <div class=\"uv-field-block\">
                                            <input type=\"text\" class=\"uv-field\" name=\"footerLinks[";
                // line 372
                echo twig_escape_filter($this->env, $context["key"], "html", null, true);
                echo "][label]\" value=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["link"], "label", [], "any", false, false, false, 372), "html", null, true);
                echo "\"  placeholder=\"";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Label"), "html", null, true);
                echo "\"/>
                                            <input type=\"text\" class=\"uv-field\" name=\"footerLinks[";
                // line 373
                echo twig_escape_filter($this->env, $context["key"], "html", null, true);
                echo "][url]\" value=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["link"], "url", [], "any", false, false, false, 373), "html", null, true);
                echo "\"  placeholder=\"";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("URL (with http:// or https://)"), "html", null, true);
                echo "\" />
                                            <a class=\"uv-btn-tag remove-link\" href=\"#\"><span class=\"uv-icon-remove-dark-box\"></span></a>
                                        </div>
                                    </div>
                                    <!-- //Field -->
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['link'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 379
            echo "                            ";
        } else {
            // line 380
            echo "                                <!-- Field -->
                                <div class=\"uv-element-block\">
                                    <label class=\"uv-field-label\">";
            // line 382
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Footer Link"), "html", null, true);
            echo " #1</label>
                                    <div class=\"uv-field-block\">
                                        <input type=\"text\" class=\"uv-field\" name=\"footerLinks[1][label]\" placeholder=\"";
            // line 384
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Label"), "html", null, true);
            echo "\" />
                                        <input type=\"text\" class=\"uv-field\" name=\"footerLinks[1][url]\" placeholder=\"";
            // line 385
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("URL (with http:// or https://)"), "html", null, true);
            echo "\" />
                                        <a class=\"uv-btn-tag remove-link\" href=\"#\"><span class=\"uv-icon-remove-dark-box\"></span></a>
                                    </div>
                                </div>
                                <!-- //Field -->
                            ";
        }
        // line 391
        echo "
                        </div>

                        <a class=\"uv-btn-tag btn-add\" href=\"#\" data-type=\"footer\">
                            <span class=\"uv-icon-add-dark\"></span> ";
        // line 395
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add More"), "html", null, true);
        echo "
                        </a>
                    </div>

                    <!--CTA-->
                    <input class=\"uv-btn links-btn\" style=\"margin-top: 15px;\" href=\"#\" value=\"";
        // line 400
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"button\">
                    <!--//CTA-->
                </form>
            </div>
            <!--//Tab View-->


                <!--Tab View-->
                <div class=\"uv-tab-view ";
        // line 408
        if (((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 408, $this->source); })()) == "advanced")) {
            echo "uv-tab-view-active";
        }
        echo "\" id=\"advanced\">
                    <form method=\"post\" action=\"";
        // line 409
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_theme", ["type" => "advanced"]);
        echo "\" id=\"advancedForm\">
                        <!-- Field -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">";
        // line 412
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Custom CSS (Optional)"), "html", null, true);
        echo "</label>
                            <div class=\"uv-field-block\">
                                <textarea name=\"customCSS\" class=\"uv-field\">";
        // line 414
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 414, $this->source); })()), "customCSS", [], "any", false, false, false, 414), "html", null, true);
        echo "</textarea>
                            </div>
                            <span class=\"uv-field-info\">";
        // line 416
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("It will be add to the frontend knowledgebase only"), "html", null, true);
        echo "</span>
                        </div>
                        <!-- //Field -->

                        <!-- Field -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">";
        // line 422
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Custom Javascript (Optional)"), "html", null, true);
        echo "</label>
                            <div class=\"uv-field-block\">
                                <textarea name=\"script\" class=\"uv-field\">";
        // line 424
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["configuration"]) || array_key_exists("configuration", $context) ? $context["configuration"] : (function () { throw new RuntimeError('Variable "configuration" does not exist.', 424, $this->source); })()), "script", [], "any", false, false, false, 424), "html", null, true);
        echo "</textarea>
                            </div>
                            <span class=\"uv-field-info\">";
        // line 426
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("It will be add to the frontend knowledgebase only"), "html", null, true);
        echo "</span>
                        </div>
                        <!-- //Field -->

                        <!-- CSRF token Field -->
                        <input type=\"hidden\" name=\"form[_token]\" value=\"";
        // line 431
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_service"]) || array_key_exists("uvdesk_service", $context) ? $context["uvdesk_service"] : (function () { throw new RuntimeError('Variable "uvdesk_service" does not exist.', 431, $this->source); })()), "generateCsrfToken", [0 => "form"], "method", false, false, false, 431), "html", null, true);
        echo "\"/>
                        <!-- //CSRF token Field -->

                        <!--CTA-->
                        <input class=\"uv-btn advanced-btn\" href=\"#\" value=\"";
        // line 435
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"button\">
                        <!--//CTA-->
                    </form>
                </div>
                <!--//Tab View-->
        
            <!--Tab View-->
            <div class=\"uv-tab-view ";
        // line 442
        if (((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 442, $this->source); })()) == "broadcasting")) {
            echo "uv-tab-view-active";
        }
        echo "\" id=\"broadcasting\">
                ";
        // line 444
        echo "                <form method=\"post\" action=\"";
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_theme", ["type" => "broadcasting"]);
        echo "\" id=\"broadcastingForm\">
                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 447
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Broadcast Message"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <textarea name=\"broadcasting[message]\" class=\"uv-field grammarly-fix-broadcast\">";
        // line 449
        ((twig_get_attribute($this->env, $this->source, ($context["broadcast"] ?? null), "message", [], "any", true, true, false, 449)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["broadcast"]) || array_key_exists("broadcast", $context) ? $context["broadcast"] : (function () { throw new RuntimeError('Variable "broadcast" does not exist.', 449, $this->source); })()), "message", [], "any", false, false, false, 449), "html", null, true))) : (print ("")));
        echo "</textarea>
                        </div>
                        <span class=\"uv-field-info\">";
        // line 451
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Broadcast message content to show on helpdesk"), "html", null, true);
        echo "</span>
                    </div>
                    <!-- //Field -->

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label>";
        // line 457
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("From"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block date\">
                            <input type=\"text\" name=\"broadcasting[from]\" class=\"uv-field datetime date-from\" value=\"";
        // line 459
        ((twig_get_attribute($this->env, $this->source, ($context["broadcast"] ?? null), "from", [], "any", true, true, false, 459)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["broadcast"]) || array_key_exists("broadcast", $context) ? $context["broadcast"] : (function () { throw new RuntimeError('Variable "broadcast" does not exist.', 459, $this->source); })()), "from", [], "any", false, false, false, 459), "html", null, true))) : (print ("")));
        echo "\">
                        </div>
                        <label>";
        // line 461
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("To"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block date\">
                            <input type=\"text\" name=\"broadcasting[to]\" class=\"uv-field datetime date-to\" value=\"";
        // line 463
        ((twig_get_attribute($this->env, $this->source, ($context["broadcast"] ?? null), "to", [], "any", true, true, false, 463)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["broadcast"]) || array_key_exists("broadcast", $context) ? $context["broadcast"] : (function () { throw new RuntimeError('Variable "broadcast" does not exist.', 463, $this->source); })()), "to", [], "any", false, false, false, 463), "html", null, true))) : (print ("")));
        echo "\">
                        </div>
                        <span class=\"uv-field-info\">";
        // line 465
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Time duration between which message will be displayed(if applicable)"), "html", null, true);
        echo "</span>
                    </div>
                    <!-- //Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 469
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Broadcasting Status"), "html", null, true);
        echo "</label>
                        <div class=\"uv-element-block\">
                            <label>
                                <div class=\"uv-checkbox\">
                                    <input type=\"checkbox\" name=\"broadcasting[isActive]\" value=\"";
        // line 473
        echo ((( !twig_test_empty((isset($context["broadcast"]) || array_key_exists("broadcast", $context) ? $context["broadcast"] : (function () { throw new RuntimeError('Variable "broadcast" does not exist.', 473, $this->source); })())) && twig_get_attribute($this->env, $this->source, (isset($context["broadcast"]) || array_key_exists("broadcast", $context) ? $context["broadcast"] : (function () { throw new RuntimeError('Variable "broadcast" does not exist.', 473, $this->source); })()), "isActive", [], "any", false, false, false, 473))) ? (1) : (0));
        echo "\" ";
        echo ((( !twig_test_empty((isset($context["broadcast"]) || array_key_exists("broadcast", $context) ? $context["broadcast"] : (function () { throw new RuntimeError('Variable "broadcast" does not exist.', 473, $this->source); })())) && twig_get_attribute($this->env, $this->source, (isset($context["broadcast"]) || array_key_exists("broadcast", $context) ? $context["broadcast"] : (function () { throw new RuntimeError('Variable "broadcast" does not exist.', 473, $this->source); })()), "isActive", [], "any", false, false, false, 473))) ? ("checked") : (""));
        echo ">
                                    <span class=\"uv-checkbox-view\"></span>
                                </div>
                                <span class=\"uv-checkbox-label\">";
        // line 476
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Broadcasting is Active"), "html", null, true);
        echo "</span>
                            </label>
                        </div>
                    </div>
                    <!-- CSRF token Field -->
                    <input type=\"hidden\" name=\"form[_token]\" value=\"\"/>
                    <!-- //CSRF token Field -->

                    <!--CTA-->
                    <input class=\"uv-btn broadcasting-btn \" href=\"#\" value=\"";
        // line 485
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"button\">
                    <!--//CTA-->
                </form>
            </div>
            <!--//Tab View-->

            <!--Tab View-->
\t\t\t<div class=\"uv-tab-view ";
        // line 492
        if (((isset($context["type"]) || array_key_exists("type", $context) ? $context["type"] : (function () { throw new RuntimeError('Variable "type" does not exist.', 492, $this->source); })()) == "time")) {
            echo "uv-tab-view-active";
        }
        echo "\" id=\"time\">
\t\t\t\t<!--Form-->
                
\t\t\t\t<form method=\"post\" action=\"";
        // line 495
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_theme", ["type" => "time"]);
        echo "\" id=\"timeSettingForm\">
\t\t\t\t\t<!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 498
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Timezone"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t    <select name=\"form[timezone]\" class=\"uv-select\">
\t\t\t\t\t\t        ";
        // line 501
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_service"]) || array_key_exists("uvdesk_service", $context) ? $context["uvdesk_service"] : (function () { throw new RuntimeError('Variable "uvdesk_service" does not exist.', 501, $this->source); })()), "getTimezones", [], "method", false, false, false, 501));
        foreach ($context['_seq'] as $context["_key"] => $context["timezone"]) {
            // line 502
            echo "\t\t\t\t\t\t        \t<option value=\"";
            echo twig_escape_filter($this->env, $context["timezone"], "html", null, true);
            echo "\" ";
            if ((twig_get_attribute($this->env, $this->source, (isset($context["websiteData"]) || array_key_exists("websiteData", $context) ? $context["websiteData"] : (function () { throw new RuntimeError('Variable "websiteData" does not exist.', 502, $this->source); })()), "timezone", [], "any", false, false, false, 502) == $context["timezone"])) {
                echo "selected";
            }
            echo ">";
            echo twig_escape_filter($this->env, $context["timezone"], "html", null, true);
            echo "</option>
\t\t\t\t\t\t    \t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['timezone'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 504
        echo "\t\t\t\t\t\t    </select>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 506
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Choose a default company's timezone"), "html", null, true);
        echo "</span>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t<!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 512
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Date Time Format"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t    <select name=\"form[timeFormat]\" class=\"uv-select\">
\t\t\t\t\t\t        ";
        // line 515
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_service"]) || array_key_exists("uvdesk_service", $context) ? $context["uvdesk_service"] : (function () { throw new RuntimeError('Variable "uvdesk_service" does not exist.', 515, $this->source); })()), "getTimeFormats", [], "method", false, false, false, 515));
        foreach ($context['_seq'] as $context["key"] => $context["timeFormat"]) {
            // line 516
            echo "\t\t\t\t\t\t        \t<option value=\"";
            echo twig_escape_filter($this->env, $context["key"], "html", null, true);
            echo "\" ";
            if ((twig_get_attribute($this->env, $this->source, (isset($context["websiteData"]) || array_key_exists("websiteData", $context) ? $context["websiteData"] : (function () { throw new RuntimeError('Variable "websiteData" does not exist.', 516, $this->source); })()), "timeFormat", [], "any", false, false, false, 516) == $context["key"])) {
                echo "selected";
            }
            echo ">";
            echo twig_escape_filter($this->env, $context["timeFormat"], "html", null, true);
            echo "</option>
\t\t\t\t\t\t    \t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['timeFormat'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 518
        echo "\t\t\t\t\t\t    </select>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 520
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Choose a format to convert date to specified date time format"), "html", null, true);
        echo "</span>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t<!--CTA-->
\t\t\t\t\t<input class=\"uv-btn timezone-btn\" href=\"#\" value=\"";
        // line 525
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"button\">
\t\t\t\t\t<!--//CTA-->
\t\t\t\t</form>
\t\t\t\t<!--//Form-->
\t\t\t</div>
\t\t\t<!--//Tab View-->

\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 535
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 536
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
 <link rel=\"stylesheet\" type=\"text/css\" href=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.0/css/bootstrap-colorpicker.min.css\">
    <script type=\"text/javascript\" src=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.0/js/bootstrap-colorpicker.min.js\"></script>

    <script>
  \t\t\$('.datetime').datetimepicker({
\t\t\tformat: 'YYYY-MM-DD H:mm:ss'
\t\t});
    </script>
    <!-- Header Link template -->
\t<script id=\"header_link_tmp\" type=\"text/template\">
        <div class=\"uv-element-block\">
            <label class=\"uv-field-label\">";
        // line 548
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Header Link"), "html", null, true);
        echo " #<%= count %></label>
            <div class=\"uv-field-block\">
                <input type=\"text\" class=\"uv-field\" name=\"headerLinks[<%= count %>][label]\" placeholder=\"";
        // line 550
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Label"), "html", null, true);
        echo "\" />
                <input type=\"text\" class=\"uv-field\" name=\"headerLinks[<%= count %>][url]\" placeholder=\"";
        // line 551
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("URL (with http:// or https://)"), "html", null, true);
        echo "\" />
                <a class=\"uv-btn-tag remove-link\" href=\"#\"><span class=\"uv-icon-remove-dark-box\"></span></a>
            </div>
        </div>
    </script>
    <!-- //Header Link template -->

    <!-- Footer Link template -->
\t<script id=\"footer_link_tmp\" type=\"text/template\">
        <div class=\"uv-element-block\">
            <label class=\"uv-field-label\">";
        // line 561
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Footer Link"), "html", null, true);
        echo " #<%= count %></label>
            <div class=\"uv-field-block\">
                <input type=\"text\" class=\"uv-field\" name=\"footerLinks[<%= count %>][label]\" placeholder=\"";
        // line 563
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Label"), "html", null, true);
        echo "\" />
                <input type=\"text\" class=\"uv-field\" name=\"footerLinks[<%= count %>][url]\" placeholder=\"";
        // line 564
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("URL (with http:// or https://)"), "html", null, true);
        echo "\" />
                <a class=\"uv-btn-tag remove-link\" href=\"#\"><span class=\"uv-icon-remove-dark-box\"></span></a>
            </div>
        </div>
    </script>
    <!-- //Footer Link template -->

\t<script type=\"text/javascript\">
\t\t\$(function () {
            \$('.uv-color-field').colorpicker({format: \"hex\"}).on('changeColor', function(ev) {
                \$(this).css('background', \$(this).val())
                textColor = app.appView.getTextColorBasedBackground(\$(this).val());
                \$(this).css('color', textColor)
            });

\t\t\tvar BrandingModel = Backbone.Model.extend({
\t\t\t    validation: {
\t\t\t    \t'website[name]': {
\t\t\t\t      \trequired: true,
\t\t\t\t       \tmsg: '";
        // line 583
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
\t\t\t\t    },
\t\t\t    \t                  
                    'website[favicon]': [{
                            notEmptyFile: true,
                            msg: \"";
        // line 588
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("An empty file is not allowed."), "html", null, true);
        echo "\",
                        }, {
                            sizeLimit: true,
                            msg: \"";
        // line 591
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("File size must not be greater than 200KB !!"), "html", null, true);
        echo "\",
                        }, {
                            imageFile: true,
                            msg: \"";
        // line 594
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please upload valid Image file (Only JPEG, JPG, PNG allowed)!!"), "html", null, true);
        echo "\",
                        }
                    ],
                    'website[logo]': [{
                            notEmptyFile: true,
                            msg: \"";
        // line 599
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("An empty file is not allowed."), "html", null, true);
        echo "\",
                        }, {
                            sizeLimit: true,
                            msg: \"";
        // line 602
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("File size must not be greater than 200KB !!"), "html", null, true);
        echo "\",
                        }, {
                            imageFile: true,
                            msg: \"";
        // line 605
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please upload valid Image file (Only JPEG, JPG, PNG allowed)!!"), "html", null, true);
        echo "\",
                        }
                    ],
\t\t\t    }
\t\t\t});

            _.extend(Backbone.Validation.validators, {
                notEmptyFile: function(value, attr) {
                    var field = \$('input[name=\"' + attr + '\"]');
                    if(field.length && field[0].files && field[0].files.length ) {
                        var file = field[0].files[0];
                        if(file && 0 == file.size) {
                            return true; //error
                        }
                    }                    
                },
                sizeLimit: function(value, attr) {
                    var field = \$('input[name=\"' + attr + '\"]');
                    if(field.length && field[0].files && field[0].files.length ) {
                        var file = field[0].files[0];
                        if(file && file.size/1024 > 200) {
                            return true; //error                            
                        }
                    }                    
                },
                imageFile: function(value, attr) { 
                    var field = \$('input[name=\"' + attr + '\"]');
                    if(field.length && field[0].files && field[0].files.length ) {
                        var file = field[0].files[0];
                        if(file && file.type.indexOf('image/') != 0) {
                            return true; //error                            
                        }
                    }
                }
            });

\t\t\tvar BrandingForm = Backbone.View.extend({
\t\t\t    events: {
\t\t\t    \t'click .general-btn': 'generalBrandingFormSubmit',
\t\t\t        'click .pending-response-btn': 'pendingResponseSettingFormSubmit',
\t\t\t\t\t'click .uv-btn': 'disableButton',
\t\t\t        'blur input:not[type=\"file\"]': 'formChanegd',
                    'change input[type=\"file\"]': 'formChanegd',
                    'change .convertToSlug': 'convertToSlug',
                    'click .uv-btn-tag.btn-add': 'addMoreLink',
                    'click .remove-link': 'removeLink',
                    \"change .uv-knowledgebase-layout input[type='radio']\": 'layoutChanged',
                    'click #uv-reset-colors': 'resetDefaultColors',
\t\t\t    },
                resetDefaultColors: function(e) {
                    var defaultColorArray = {
                        'pageBackgroundColor': '#FFFFFF',
                        'headerBackgroundColor': '#FFFFFF',
                        'bannerBackgroundColor': '#7C70F4',
                        'linkColor': '#2750C4',
                        'linkHoverColor': '#2750C4',
                        'articleTextColor': '#333333',
                        'brandColor': '#7C70F4',
                    };
                    \$(e.target).addClass('uv-icon-history-active');
                    setTimeout(function () { 
                        \$(e.target).removeClass('uv-icon-history-active');
                    }, 500);
                    \$.each(defaultColorArray, function(index, value) {
                        var selectedField = \$('input[name=\"website['+ index +']\"]');
                        selectedField.val(value);
                        selectedField.trigger('changeColor');
                    });
                },
                headerLinkTemplate : _.template(\$(\"#header_link_tmp\").html()),
                footerLinkTemplate : _.template(\$(\"#footer_link_tmp\").html()),
\t\t\t    initialize: function () {
                    \$('.uv-color-field').each(function() {
                        textColor = app.appView.getTextColorBasedBackground(\$(this).val());
                        \$(this).css('color', textColor)
                    });

\t\t\t        Backbone.Validation.bind(this);\t\t\t      
\t\t\t    },
\t\t\t    formChanegd: function(e) {
                    if(!Backbone.\$(e.currentTarget).parents('.links').length) {
                        this.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
                        this.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
                    }
\t\t\t    },          
\t\t\t    generalBrandingFormSubmit: function (e) {
\t\t\t        e.preventDefault();
\t\t\t        this.model.set(\$('#generalSettingForm').serializeObject());
                        console.log(\"form_submited fail\");
                    
\t\t\t        if(this.model.isValid(true)) {
\t\t\t           \$(\"#generalSettingForm\").submit();
\t\t\t        }
\t\t\t    },
\t\t\t    pendingResponseSettingFormSubmit: function (e) {
\t\t\t        e.preventDefault();
\t\t\t        this.model.set(\$('#pendingResponseSettingForm').serializeObject());
\t\t\t        if(this.model.isValid('website[pendingSince]')) {
\t\t\t\t\t\t\$('.pending-response-btn').attr('disabled', 'disabled');
\t\t\t            \$(\"#pendingResponseSettingForm\").submit();
\t\t\t        }
\t\t\t    },
\t\t\t\tdisableButton: function(e) {
\t\t\t\t\tvar form = Backbone.\$(e.currentTarget).parents('form');
\t\t\t\t\tif(form.attr('id') == 'seoForm' || form.attr('id') == 'advancedForm' || form.attr('id') == 'knowledgebaseForm') {
\t\t\t\t\t\tBackbone.\$(e.currentTarget).attr('disabled', 'disabled');
\t\t\t\t\t\tform.submit()
\t\t\t\t\t}
\t\t\t\t},
                convertToSlug: function(e) {
                    Backbone.\$(e.currentTarget).val(app.appView.convertToSlug(Backbone.\$(e.currentTarget).val()));
                },
                addMoreLink: function(e) {
                    e.preventDefault();

                    var currentElement = Backbone.\$(e.currentTarget);
                    if(currentElement.attr('data-type') == 'header') {
                        count = \$('.uv-header-link-wrapper .uv-element-block').length + 1;
                        \$('.uv-header-link-wrapper .links').append(this.headerLinkTemplate({'count' : count}))
                    } else {
                        count = \$('.uv-footer-link-wrapper .uv-element-block').length + 1;
                        \$('.uv-footer-link-wrapper .links').append(this.footerLinkTemplate({'count' : count}))
                    }
                },
                removeLink: function(e) {
                    e.preventDefault()
                    Backbone.\$(e.currentTarget).parents('.uv-element-block').remove()
                },
                layoutChanged: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    \$('.uv-layout-icon').removeClass('uv-layout-icon-active');

                    \$(\"label[for='\" + currentElement.attr('id') + \"']\").addClass('uv-layout-icon-active');
                }
\t\t\t});

\t\t    var brandingForm = new BrandingForm({
\t\t        el: 'form',
\t\t        model: new BrandingModel()
\t\t    });
            
            var BroadcastModel = Backbone.Model.extend({
\t\t\t    validation: {
\t\t\t    \t'broadcasting[message]': {
\t\t\t\t      \trequired: true,
\t\t\t\t       \tmsg: '";
        // line 750
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
\t\t\t\t    },
\t\t\t    }
\t\t\t});

\t\t\tvar BroadcastForm = Backbone.View.extend({
                el: '#broadcastingForm',
\t\t\t    events: {
\t\t\t    \t'click .broadcasting-btn': 'broadcastingFormSubmit',
                    'change textarea': 'formChanged',
\t\t\t    },
                initialize: function() {
                    Backbone.Validation.bind(this);
                },
\t\t\t    formChanged: function(e) {
                    if(!Backbone.\$(e.currentTarget).parents('.links').length) {
                        this.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
                        this.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
                    }
\t\t\t    },
                broadcastingFormSubmit: function(e) {
\t\t\t\t\tvar form = Backbone.\$(e.currentTarget).closest('form')
                    if(form.attr('id') == 'broadcastingForm') {
                        data = form.serializeObject();
                        this.model.set(data);
                        if(this.model.isValid(true)) {
                            Backbone.\$(e.currentTarget).attr('disabled', 'disabled');
                            form.submit()
                        }
                    }
                }
\t\t    });

            var LinksModel = Backbone.Model.extend({
\t\t\t    validation: {
\t\t\t    }
\t\t\t});

\t\t\tvar LinksForm = Backbone.View.extend({
                el: '#linksForm',
                initialize: function() {
                    Backbone.Validation.bind(this);
                },                
                events: {
                    'click .links-btn': 'validateLinks',
                },
                validateLinks: function(e) {
                    e.preventDefault();
                    var data = \$('#linksForm').serializeObject();
                    var self = this; var valid = true;
                    \$.each(data, function(key, value) {
                        if(key.indexOf('[url]') != -1 && value && !value.match('^(http:\\/\\/www\\.|https:\\/\\/www\\.|http:\\/\\/|https:\\/\\/)[a-z0-9]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}(:[0-9]{1,5})?(\\/.*)?\$')) {
    \t\t    \t\t\tBackbone.Validation.callbacks.invalid(self, key, '";
        // line 802
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Provide a valid url(with protocol)"), "html", null, true);
        echo "', 'input');
                            valid = false;
                        } else {
    \t\t    \t\t\tBackbone.Validation.callbacks.valid(self, key, '";
        // line 805
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Provide a valid url(with protocol)"), "html", null, true);
        echo "', 'input');                            
                        }
                    });
                    if(valid) {
\t\t\t\t\t\t\$('.links-btn').attr('disabled', 'disabled');
\t\t\t            \$(\"#linksForm\").submit();
\t\t\t        }
                },                      
            });

            var TimezoneForm = Backbone.View.extend({
                el: '#timeSettingForm',
\t\t\t    events: {
\t\t\t    \t'click .timezone-btn': 'timezoneFormSubmit',
                    
\t\t\t    },
                timezoneFormSubmit: function(e) {
\t\t\t\t\tvar form = Backbone.\$(e.currentTarget).closest('form')
                    if (form.attr('id') == 'timeSettingForm') {
                        data = form.serializeObject();
                        form.submit()
                    }
                }
\t\t    });

            var time = new TimezoneForm();

            var broadcastForm = new BroadcastForm({
                model: new BroadcastModel()
            });

\t\t\tvar linksForm = new LinksForm({
                model: new LinksModel()                
            });
        });
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Staff/branding.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1495 => 805,  1489 => 802,  1434 => 750,  1286 => 605,  1280 => 602,  1274 => 599,  1266 => 594,  1260 => 591,  1254 => 588,  1246 => 583,  1224 => 564,  1220 => 563,  1215 => 561,  1202 => 551,  1198 => 550,  1193 => 548,  1177 => 536,  1167 => 535,  1147 => 525,  1139 => 520,  1135 => 518,  1120 => 516,  1116 => 515,  1110 => 512,  1101 => 506,  1097 => 504,  1082 => 502,  1078 => 501,  1072 => 498,  1066 => 495,  1058 => 492,  1048 => 485,  1036 => 476,  1028 => 473,  1021 => 469,  1014 => 465,  1009 => 463,  1004 => 461,  999 => 459,  994 => 457,  985 => 451,  980 => 449,  975 => 447,  968 => 444,  962 => 442,  952 => 435,  945 => 431,  937 => 426,  932 => 424,  927 => 422,  918 => 416,  913 => 414,  908 => 412,  902 => 409,  896 => 408,  885 => 400,  877 => 395,  871 => 391,  862 => 385,  858 => 384,  853 => 382,  849 => 380,  846 => 379,  830 => 373,  822 => 372,  815 => 370,  811 => 368,  806 => 367,  804 => 366,  795 => 360,  790 => 357,  781 => 351,  777 => 350,  772 => 348,  768 => 346,  765 => 345,  749 => 339,  741 => 338,  734 => 336,  730 => 334,  725 => 333,  723 => 332,  716 => 328,  710 => 327,  700 => 320,  687 => 310,  682 => 308,  672 => 301,  667 => 299,  660 => 295,  654 => 294,  644 => 287,  639 => 284,  629 => 276,  623 => 273,  611 => 264,  605 => 261,  593 => 252,  587 => 249,  575 => 240,  569 => 237,  556 => 229,  548 => 228,  541 => 226,  533 => 225,  526 => 223,  518 => 222,  511 => 220,  503 => 219,  498 => 217,  486 => 210,  481 => 208,  469 => 201,  463 => 199,  451 => 191,  445 => 189,  433 => 181,  427 => 179,  415 => 171,  409 => 169,  397 => 161,  391 => 159,  379 => 151,  373 => 149,  369 => 147,  363 => 144,  356 => 142,  345 => 134,  336 => 128,  331 => 126,  319 => 119,  313 => 117,  303 => 109,  297 => 106,  291 => 103,  281 => 96,  275 => 93,  263 => 89,  246 => 82,  244 => 81,  239 => 79,  232 => 75,  225 => 73,  212 => 67,  204 => 66,  196 => 65,  188 => 64,  180 => 63,  172 => 62,  164 => 61,  157 => 57,  151 => 56,  146 => 54,  143 => 53,  140 => 52,  137 => 51,  93 => 8,  83 => 7,  70 => 4,  60 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %}
\t{{ 'Branding'|trans }}
{% endblock %}

{% block pageContent %}
    <style>
        .uv-image-upload-brick {
            margin: 10px 0px;
        }
        .uv-color-field {
            color: #fff;
            width: 100px;
            text-transform: uppercase;
        }
        .uv-header-link-wrapper {
            padding-bottom: 20px;
        }
        .uv-footer-link-wrapper {
            border-top: solid 1px #D3D3D3;
            padding-top: 20px;
        }
        .uv-knowledgebase-layout  {
            border-top: solid 1px #D3D3D3;
            padding-top: 20px;
            margin-top: 20px;
        }
        .uv-knowledgebase-layout input[type='radio'] {
            display: none;
        }
        #links .uv-field-block input:first-child {
            width: 200px;
            margin-bottom: 0;
        }
        #links .remove-link {
            margin-left: 10px;
        }
\t\t.grammarly-fix-broadcast {
\t\t\tmax-width: 518px;
\t\t}
        #uv-reset-colors {
            float: right;
            cursor: pointer;
            position: relative;
            z-index:1 ;
        }
    </style>
\t<div class=\"uv-inner-section\">\t\t
\t\t{# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Branding' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}

\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
\t\t\t<h1>{{ 'Branding'|trans }}</h1>
\t\t\t<!--Tabs-->
\t\t\t<div class=\"uv-tabs\">
\t\t\t\t<ul>
\t\t\t\t\t<li for=\"general\" {% if type == 'general' or type == '' %}class=\"uv-tab-active\"{% endif %}>{{ 'General'|trans }}</li>
\t\t\t\t\t<li for=\"knowledgebase\" {% if type == 'knowledgebase' %} class=\"uv-tab-active\"{% endif %}>{{ 'Knowledgebase'|trans }}</li>
                    <li for=\"time\" {% if type == 'time' %}class=\"uv-tab-active\"{% endif %}>{{ 'Time'|trans }}</li>
\t\t\t\t\t<li for=\"seo\" {% if type == 'seo' %}class=\"uv-tab-active\"{% endif %}>{{ 'SEO'|trans }}</li>
\t\t\t\t\t<li for=\"links\" {% if type == 'links' %}class=\"uv-tab-active\"{% endif %}>{{ 'Links'|trans }}</li>
                    <li for=\"advanced\" {% if type == 'advanced' %}class=\"uv-tab-active\"{% endif %}>{{ 'Advanced'|trans }}</li>
\t\t\t\t\t<li for=\"broadcasting\" {% if type == 'broadcasting' %}class=\"uv-tab-active\"{% endif %}>{{ 'Broadcast Message'|trans }}</li>                  
\t\t\t\t</ul>
\t\t\t</div>
\t\t\t<!--Tabs-->

\t\t\t<!--Tab View-->
\t\t\t<div class=\"uv-tab-view {% if type == 'general' or type == '' %}uv-tab-view-active{% endif %}\" id=\"general\">
\t\t\t\t<!--Form-->
\t\t\t\t<form method=\"post\" action=\"{{ path('helpdesk_member_knowledgebase_theme', {'type': 'general'}) }}\" id=\"generalSettingForm\" enctype=\"multipart/form-data\">
                    <!-- Image block -->
                    <div class=\"uv-image-upload-wrapper uv-no-error-success-icon\">
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">{{ 'Wide Logo'|trans }}</label>
                            <div class=\"uv-field-block\">
                                {% set isLogo = websiteData.logo ? 1 : 0 %}
                                <div class=\"uv-image-upload-brick uv-image-upload-brick-200 {% if isLogo %}uv-on-drop-shadow{% endif %}\" {% if isLogo %}style=\"border-color: transparent;\"{% endif %}>
                                    <input type=\"file\" name=\"website[logo]\" id=\"uv-upload-profile\" accept=\"image/*\">
                                    <div class=\"uv-image-upload-placeholder\">
                                        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"48\" height=\"32\" viewBox=\"0 0 48 32\">
                                            <path fill=\"#7c74f1\" fill-rule=\"evenodd\" d=\"M26.516,22.252H21.477V17.226h-3.75L24,11.031l6.269,6.195h-3.75v5.026ZM29.973,8.138A9.1,9.1,0,0,0,24,6.005a8.947,8.947,0,0,0-4.863,1.4,9.78,9.78,0,0,0-3.457,3.682A7.494,7.494,0,0,0,9,18.512a7.2,7.2,0,0,0,2.2,5.289,7.234,7.234,0,0,0,5.3,2.192H32.727A6.294,6.294,0,0,0,39,19.739,5.933,5.933,0,0,0,37.3,15.5a6.113,6.113,0,0,0-4.1-1.958A9.112,9.112,0,0,0,29.973,8.138Z\"/>
                                        </svg>
                                    </div>
                                    <img id=\"dynamic-image-upload\" {% if isLogo %} src=\"{{ app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') }}{{ websiteData.logo }}\" {% endif %}>

                                </div>
                                <div class=\"uv-image-info-brick\">
                                    <span class=\"uv-field-info\">{{ 'Upload an Image (200px x 48px) in</br> PNG or JPG Format'|trans|raw }}</span>
                                </div>
                            </div>
                            <span class=\"uv-field-info\">{{ 'It will be shown as Logo on Knowledgebase and Helpdesk'|trans }}</span>
                        </div>
                    </div>
                    <!-- //Image block -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t  \t<label class=\"uv-field-label\">{{ 'Website Status'|trans }}</label>
                          <div class=\"uv-field-block\">
                            <div class=\"uv-checkbox uv-margin-top-5\">
                                <input type=\"checkbox\" name=\"website[status]\" style=\"cursor:pointer;\" {{ configuration.status ? 'checked=\"checked\"' : '' }} >
                                <span class=\"uv-checkbox-view\"></span>
                            </div>
                            <span class=\"uv-field-info uv-margin-top-5\">{{ 'Enable front end website and knowledgebase for customer(s)'|trans }}</span>
                        </div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        {##564DA8#}
\t\t\t\t\t  \t<label class=\"uv-field-label\">{{ 'Brand Color'|trans }}</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[brandColor]\" class=\"uv-field uv-color-field\" type=\"text\" value=\"{{ configuration.brandColor ? configuration.brandColor : '#7C70F4'}}\" style=\"background:{{ configuration.brandColor ? configuration.brandColor : '#7C70F4'}}\" placeholder=\"#7C70F4\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->
                    
\t\t\t\t\t<!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t  \t<label class=\"uv-field-label\">{{ 'Name'|trans }}</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[name]\" class=\"uv-field\" type=\"text\" value=\"{{ websiteData.name ? websiteData.name : '' }}\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t<!--CTA-->
\t\t\t\t\t<input class=\"uv-btn general-btn\" href=\"#\" value=\"{{ 'Save Changes'|trans }}\" type=\"button\">
\t\t\t\t\t<!--//CTA-->
\t\t\t\t</form>
\t\t\t\t<!--//Form-->
\t\t\t</div>
\t\t\t<!--//Tab View-->

\t\t\t<!--Tab View-->
            <div class=\"uv-tab-view {% if type == 'knowledgebase' %}uv-tab-view-active{% endif %}\" id=\"knowledgebase\">
                <!--Form-->
\t\t\t\t<form method=\"post\" action=\"{{ path('helpdesk_member_knowledgebase_theme', {'type': 'knowledgebase'}) }}\" id=\"knowledgebaseForm\">
                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        <span  id=\"uv-reset-colors\" class=\"uv-icon-history\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"{{ 'Use Default Colors'|trans }}\"></span>
                        {##564DA8#}
\t\t\t\t\t  \t<label class=\"uv-field-label\">{{ 'Page Background Color'|trans }}</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[pageBackgroundColor]\" class=\"uv-field uv-color-field\" type=\"text\" value=\"{{ configuration.pageBackgroundColor}}\" style=\"background: {{ configuration.pageBackgroundColor ? configuration.pageBackgroundColor : '#FFFFFF' }}\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        {##564DA8#}
\t\t\t\t\t  \t<label class=\"uv-field-label\">{{ 'Header Background Color'|trans }}</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[headerBackgroundColor]\" class=\"uv-field uv-color-field\" type=\"text\" value=\"{{ configuration.headerBackgroundColor ? configuration.headerBackgroundColor : '#FFFFFF' }}\" style=\"background: {{ configuration.pageBackgroundColor ? configuration.headerBackgroundColor : '#FFFFFF' }}\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        {##564DA8#}
\t\t\t\t\t  \t<label class=\"uv-field-label\">{{ 'Banner Background Color'|trans }}</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[bannerBackgroundColor]\" class=\"uv-field uv-color-field\" type=\"text\" value=\"{{ configuration.bannerBackgroundColor ? configuration.bannerBackgroundColor : '#70B5F4' }}\" style=\"background: {{ configuration.bannerBackgroundColor ? configuration.bannerBackgroundColor : '#70B5F4' }}\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        {##564DA8#}
\t\t\t\t\t  \t<label class=\"uv-field-label\">{{ 'Page Link Color'|trans }}</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[linkColor]\" class=\"uv-field uv-color-field\" type=\"text\" value=\"{{ configuration.linkColor  ? configuration.linkColor : '#C427A1' }}\" style=\"background: {{ configuration.linkColor  ? configuration.linkColor : '#C427A1' }}\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        {##564DA8#}
\t\t\t\t\t  \t<label class=\"uv-field-label\">{{ 'Page Link Hover Color'|trans }}</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[linkHoverColor]\" class=\"uv-field uv-color-field\" type=\"text\" value=\"{{ configuration.linkHoverColor  ? configuration.linkHoverColor : '#2750C4' }}\" style=\"background: {{ configuration.linkColor  ? configuration.linkHoverColor : '#2750C4' }}\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        {##564DA8#}
\t\t\t\t\t  \t<label class=\"uv-field-label\">{{ 'Article Text Color'|trans }}</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[articleTextColor]\" class=\"uv-field uv-color-field\" type=\"text\" value=\"{{ configuration.articleTextColor  ? configuration.articleTextColor : '#333333' }}\" style=\"background: {{ configuration.linkColor  ? configuration.articleTextColor : '#333333' }}\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t  \t<label class=\"uv-field-label\">{{ 'Tag Line'|trans }}</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"website[siteDescription]\" class=\"uv-field\" type=\"text\" value=\"{{ configuration.siteDescription ? configuration.siteDescription : '' }}\" placeholder=\"{{ 'Hi! how can we help?'|trans }} \">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <div class=\"uv-knowledgebase-layout uv-no-error-success-icon\">
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">{{ 'Layout '|trans }}</label>
                            <div class=\"uv-layout-icon-wrapper\">
                                <label for=\"homepage-masonry\" class=\"uv-layout-icon uv-layout-grid {% if configuration.homepageContent and configuration.homepageContent == 'masonry' %}uv-layout-icon-active{% endif %}\" data-toggle=\"tooltip\" title=\"{{ 'Masonry'|trans }}\"></label>
                                <input name=\"website[homepageContent]\" type=\"radio\" id=\"homepage-masonry\" value=\"masonry\" {% if configuration.homepageContent and configuration.homepageContent == 'masonry' %}checked{% endif %}/>

                                <label for=\"homepage-folder\" class=\"uv-layout-icon uv-layout-folder {% if configuration.homepageContent and configuration.homepageContent == 'folder' %}uv-layout-icon-active{% endif %}\" data-toggle=\"tooltip\" title=\"{{ 'Folder'|trans }}\"></label>
                                <input name=\"website[homepageContent]\" type=\"radio\" id=\"homepage-folder\" value=\"folder\" {% if configuration.homepageContent and configuration.homepageContent == 'folder' %}checked{% endif %}/>

                                <label for=\"homepage-category\" class=\"uv-layout-icon uv-layout-category {% if configuration.homepageContent and configuration.homepageContent == 'category' %}uv-layout-icon-active{% endif %}\" data-toggle=\"tooltip\" title=\"{{ 'Category'|trans }}\"></label>
                                <input name=\"website[homepageContent]\" type=\"radio\" id=\"homepage-category\" value=\"category\" {% if configuration.homepageContent and configuration.homepageContent == 'category' %}checked{% endif %}/>

                                <label for=\"homepage-article\" class=\"uv-layout-icon uv-layout-article {% if configuration.homepageContent and configuration.homepageContent == 'article' %}uv-layout-icon-active{% endif %}\" data-toggle=\"tooltip\" title=\"{{ 'Popular Article'|trans }}\"></label>
                                <input name=\"website[homepageContent]\" type=\"radio\" id=\"homepage-article\" value=\"article\" {% if configuration.homepageContent and configuration.homepageContent == 'article' %}checked{% endif %}/>
                            </div>
                        </div>

                        <!-- Field -->
                        <div class=\"uv-element-block\" style=\"margin: 20px 0\">
                            <label>
                                <div class=\"uv-checkbox\">
                                    <input name=\"website[ticketCreateOption]\" type=\"checkbox\" {{ configuration.ticketCreateOption ? 'checked=\"checked\"':\"\"}} />
                                    <span class=\"uv-checkbox-view\"></span>
                                </div>
                                <span class=\"uv-checkbox-label\">{{ 'Ticket Create Option'|trans }}</span>
                            </label>
                        </div>
\t\t\t\t\t    <!-- //Field -->

                        <!-- Field -->
                        <div class=\"uv-element-block\" style=\"margin: 20px 0\">
                            <label>
                                <div class=\"uv-checkbox\">
                                    <input name=\"website[loginRequiredToCreate]\" type=\"checkbox\" {{ configuration.loginRequiredToCreate ? 'checked=\"checked\"':\"\"}}/>
                                    <span class=\"uv-checkbox-view\"></span>
                                </div>
                                <span class=\"uv-checkbox-label\">{{ 'Login Required To Create Tickets'|trans }}</span>
                            </label>
                        </div>
\t\t\t\t\t    <!-- //Field -->

                        <!-- Field -->
                        <div class=\"uv-element-block\" style=\"margin: 20px 0\">
                            <label>
                                <div class=\"uv-checkbox\">
                                    <input name=\"website[removeCustomerLoginButton]\" type=\"checkbox\" value=\"1\" {{ configuration.removeCustomerLoginButton ? 'checked=\"checked\"':\"\"}} />
                                    <span class=\"uv-checkbox-view\"></span>
                                </div>
                                <span class=\"uv-checkbox-label\">{{ 'Remove Customer Login/Signin Button'|trans }}</span>
                            </label>
                        </div>
                        <!-- //Field -->

                        <!-- Field -->
                        <div class=\"uv-element-block\" style=\"margin: 20px 0\">
                            <label>
                                <div class=\"uv-checkbox\">
                                    <input name=\"website[disableCustomerLogin]\" type=\"checkbox\" value=\"1\" {{ configuration.disableCustomerLogin ? 'checked=\"checked\"':\"\"}} />
                                    <span class=\"uv-checkbox-view\"></span>
                                </div>
                                <span class=\"uv-checkbox-label\">{{ 'Disable Customer Login'|trans }}</span>
                            </label>
                        </div>
                        <!-- //Field -->
                    </div>

                    <!-- CSRF token Field -->
                    {# <input type=\"hidden\" name=\"website[_token]\" value=\"{{ uvdesk_service.generateCsrfToken('website') }}\"/> #}
                    <!-- //CSRF token Field -->

\t\t\t\t\t<!--CTA-->
\t\t\t\t\t<input class=\"uv-btn knowledgebase-btn\" href=\"#\" value=\"{{ 'Save Changes'|trans }}\" type=\"button\">
\t\t\t\t\t<!--//CTA-->
                </form>
\t\t\t</div>
\t\t\t<!--//Tab View-->

            <!--Tab View-->
            <div class=\"uv-tab-view {% if type == 'seo' %}uv-tab-view-active{% endif %}\" id=\"seo\">
                <form method=\"post\" action=\"{{ path('helpdesk_member_knowledgebase_theme', {'type': 'seo'}) }}\" id=\"seoForm\">

\t\t\t\t\t<!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Meta Description (Recommended)'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <textarea name=\"metaDescription\" class=\"uv-field\">{{configuration.metaDescription ? configuration.metaDescription : \"\" }}</textarea>
                        </div>
                    </div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Meta Keywords (Recommended)'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <textarea name=\"metaKeywords\" class=\"uv-field\">{{ configuration.metaKeywords ? configuration.metaKeywords : \"\" }}</textarea>
                        </div>
                    </div>
\t\t\t\t\t<!-- //Field -->

                    <!-- CSRF token Field -->
                    <input type=\"hidden\" name=\"_token\" value=\"\"/>
                    <!-- //CSRF token Field -->

\t\t\t\t\t<!--CTA-->
\t\t\t\t\t<input class=\"uv-btn seo-btn\" href=\"#\" value=\"{{ 'Save Changes'|trans }}\" type=\"button\">
\t\t\t\t\t<!--//CTA-->
                </form>
\t\t\t</div>
\t\t\t<!--//Tab View-->

            <!--Tab View-->
            <div class=\"uv-tab-view {% if type == 'links' %}uv-tab-view-active{% endif %}\" id=\"links\">
                <form method=\"post\" action=\"{{ path('helpdesk_member_knowledgebase_theme', {'type': 'links'}) }}\" id=\"linksForm\" class=\"uv-no-error-success-icon\">

                    <div class=\"uv-header-link-wrapper\">
                        <div class=\"links\">
                            {% if configuration.headerLinks|length %}
                                {% for key, link in configuration.headerLinks %}
                                    <!-- Field -->
                                    <div class=\"uv-element-block\">
                                        <label class=\"uv-field-label\">{{ 'Header Link'|trans }} #{{key}}</label>
                                        <div class=\"uv-field-block\">
                                            <input type=\"text\" class=\"uv-field\" name=\"headerLinks[{{key}}][label]\" value=\"{{ link.label }}\"  placeholder=\"{{ 'Label'|trans }}\"/>
                                            <input type=\"text\" class=\"uv-field\" name=\"headerLinks[{{key}}][url]\" value=\"{{ link.url }}\"  placeholder=\"{{ 'URL (with http:// or https://)'|trans }}\" />
                                            <a class=\"uv-btn-tag remove-link\" href=\"#\"><span class=\"uv-icon-remove-dark-box\"></span></a>
                                        </div>
                                    </div>
                                    <!-- //Field -->
                                {% endfor %}
                            {% else %}
                                <!-- Field -->
                                <div class=\"uv-element-block\">
                                    <label class=\"uv-field-label\">{{ 'Header Link'|trans }} #1</label>
                                    <div class=\"uv-field-block\">
                                        <input type=\"text\" class=\"uv-field\" name=\"headerLinks[1][label]\" placeholder=\"{{ 'Label'|trans }}\" />
                                        <input type=\"text\" class=\"uv-field\" name=\"headerLinks[1][url]\" placeholder=\"{{ 'URL (with http:// or https://)'|trans }}\" />
                                        <a class=\"uv-btn-tag remove-link\" href=\"#\"><span class=\"uv-icon-remove-dark-box\"></span></a>
                                    </div>
                                </div>
                                <!-- //Field -->
                            {% endif %}
                        </div>

                        <a class=\"uv-btn-tag btn-add\" href=\"#\" data-type=\"header\">
                            <span class=\"uv-icon-add-dark\"></span> {{ 'Add More'|trans }}
                        </a>
                    </div>

                    <div class=\"uv-footer-link-wrapper\">
                        <div class=\"links\">
                            {% if configuration.footerLinks|length %}
                                {% for key, link in configuration.footerLinks %}
                                    <!-- Field -->
                                    <div class=\"uv-element-block\">
                                        <label class=\"uv-field-label\">{{ 'Footer Link'|trans }} #{{key}}</label>
                                        <div class=\"uv-field-block\">
                                            <input type=\"text\" class=\"uv-field\" name=\"footerLinks[{{key}}][label]\" value=\"{{ link.label }}\"  placeholder=\"{{ 'Label'|trans }}\"/>
                                            <input type=\"text\" class=\"uv-field\" name=\"footerLinks[{{key}}][url]\" value=\"{{ link.url }}\"  placeholder=\"{{ 'URL (with http:// or https://)'|trans }}\" />
                                            <a class=\"uv-btn-tag remove-link\" href=\"#\"><span class=\"uv-icon-remove-dark-box\"></span></a>
                                        </div>
                                    </div>
                                    <!-- //Field -->
                                {% endfor %}
                            {% else %}
                                <!-- Field -->
                                <div class=\"uv-element-block\">
                                    <label class=\"uv-field-label\">{{ 'Footer Link'|trans }} #1</label>
                                    <div class=\"uv-field-block\">
                                        <input type=\"text\" class=\"uv-field\" name=\"footerLinks[1][label]\" placeholder=\"{{ 'Label'|trans }}\" />
                                        <input type=\"text\" class=\"uv-field\" name=\"footerLinks[1][url]\" placeholder=\"{{ 'URL (with http:// or https://)'|trans }}\" />
                                        <a class=\"uv-btn-tag remove-link\" href=\"#\"><span class=\"uv-icon-remove-dark-box\"></span></a>
                                    </div>
                                </div>
                                <!-- //Field -->
                            {% endif %}

                        </div>

                        <a class=\"uv-btn-tag btn-add\" href=\"#\" data-type=\"footer\">
                            <span class=\"uv-icon-add-dark\"></span> {{ 'Add More'|trans }}
                        </a>
                    </div>

                    <!--CTA-->
                    <input class=\"uv-btn links-btn\" style=\"margin-top: 15px;\" href=\"#\" value=\"{{ 'Save Changes'|trans }}\" type=\"button\">
                    <!--//CTA-->
                </form>
            </div>
            <!--//Tab View-->


                <!--Tab View-->
                <div class=\"uv-tab-view {% if type == 'advanced' %}uv-tab-view-active{% endif %}\" id=\"advanced\">
                    <form method=\"post\" action=\"{{ path('helpdesk_member_knowledgebase_theme', {'type': 'advanced'}) }}\" id=\"advancedForm\">
                        <!-- Field -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">{{ 'Custom CSS (Optional)'|trans }}</label>
                            <div class=\"uv-field-block\">
                                <textarea name=\"customCSS\" class=\"uv-field\">{{ configuration.customCSS }}</textarea>
                            </div>
                            <span class=\"uv-field-info\">{{ 'It will be add to the frontend knowledgebase only'|trans }}</span>
                        </div>
                        <!-- //Field -->

                        <!-- Field -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">{{ 'Custom Javascript (Optional)'|trans }}</label>
                            <div class=\"uv-field-block\">
                                <textarea name=\"script\" class=\"uv-field\">{{ configuration.script }}</textarea>
                            </div>
                            <span class=\"uv-field-info\">{{ 'It will be add to the frontend knowledgebase only'|trans }}</span>
                        </div>
                        <!-- //Field -->

                        <!-- CSRF token Field -->
                        <input type=\"hidden\" name=\"form[_token]\" value=\"{{ uvdesk_service.generateCsrfToken('form') }}\"/>
                        <!-- //CSRF token Field -->

                        <!--CTA-->
                        <input class=\"uv-btn advanced-btn\" href=\"#\" value=\"{{ 'Save Changes'|trans }}\" type=\"button\">
                        <!--//CTA-->
                    </form>
                </div>
                <!--//Tab View-->
        
            <!--Tab View-->
            <div class=\"uv-tab-view {% if type == 'broadcasting' %}uv-tab-view-active{% endif %}\" id=\"broadcasting\">
                {# {% set broadcastMessage = website.broadcastMessage|json_decode %} #}
                <form method=\"post\" action=\"{{ path('helpdesk_member_knowledgebase_theme', {'type': 'broadcasting'}) }}\" id=\"broadcastingForm\">
                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Broadcast Message'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <textarea name=\"broadcasting[message]\" class=\"uv-field grammarly-fix-broadcast\">{{ broadcast.message is defined ? broadcast.message : '' }}</textarea>
                        </div>
                        <span class=\"uv-field-info\">{{ 'Broadcast message content to show on helpdesk'|trans }}</span>
                    </div>
                    <!-- //Field -->

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label>{{ 'From'|trans }}</label>
                        <div class=\"uv-field-block date\">
                            <input type=\"text\" name=\"broadcasting[from]\" class=\"uv-field datetime date-from\" value=\"{{ broadcast.from is defined ? broadcast.from : '' }}\">
                        </div>
                        <label>{{ 'To'|trans }}</label>
                        <div class=\"uv-field-block date\">
                            <input type=\"text\" name=\"broadcasting[to]\" class=\"uv-field datetime date-to\" value=\"{{ broadcast.to is defined ? broadcast.to : '' }}\">
                        </div>
                        <span class=\"uv-field-info\">{{ 'Time duration between which message will be displayed(if applicable)'|trans }}</span>
                    </div>
                    <!-- //Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{'Broadcasting Status'|trans}}</label>
                        <div class=\"uv-element-block\">
                            <label>
                                <div class=\"uv-checkbox\">
                                    <input type=\"checkbox\" name=\"broadcasting[isActive]\" value=\"{{ broadcast is not empty and broadcast.isActive ? 1 : 0 }}\" {{ broadcast is not empty and broadcast.isActive ? 'checked' : '' }}>
                                    <span class=\"uv-checkbox-view\"></span>
                                </div>
                                <span class=\"uv-checkbox-label\">{{'Broadcasting is Active'|trans}}</span>
                            </label>
                        </div>
                    </div>
                    <!-- CSRF token Field -->
                    <input type=\"hidden\" name=\"form[_token]\" value=\"\"/>
                    <!-- //CSRF token Field -->

                    <!--CTA-->
                    <input class=\"uv-btn broadcasting-btn \" href=\"#\" value=\"{{ 'Save Changes'|trans }}\" type=\"button\">
                    <!--//CTA-->
                </form>
            </div>
            <!--//Tab View-->

            <!--Tab View-->
\t\t\t<div class=\"uv-tab-view {% if type == 'time' %}uv-tab-view-active{% endif %}\" id=\"time\">
\t\t\t\t<!--Form-->
                
\t\t\t\t<form method=\"post\" action=\"{{ path('helpdesk_member_knowledgebase_theme', {'type': 'time'}) }}\" id=\"timeSettingForm\">
\t\t\t\t\t<!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Timezone'|trans }}</label>
\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t    <select name=\"form[timezone]\" class=\"uv-select\">
\t\t\t\t\t\t        {% for timezone in uvdesk_service.getTimezones() %}
\t\t\t\t\t\t        \t<option value=\"{{ timezone }}\" {% if websiteData.timezone == timezone %}selected{% endif %}>{{ timezone }}</option>
\t\t\t\t\t\t    \t{% endfor %}
\t\t\t\t\t\t    </select>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<span class=\"uv-field-info\">{{ \"Choose a default company's timezone\"|trans }}</span>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t<!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Date Time Format'|trans }}</label>
\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t    <select name=\"form[timeFormat]\" class=\"uv-select\">
\t\t\t\t\t\t        {% for key, timeFormat in uvdesk_service.getTimeFormats() %}
\t\t\t\t\t\t        \t<option value=\"{{ key }}\" {% if websiteData.timeFormat == key %}selected{% endif %}>{{ timeFormat }}</option>
\t\t\t\t\t\t    \t{% endfor %}
\t\t\t\t\t\t    </select>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<span class=\"uv-field-info\">{{ 'Choose a format to convert date to specified date time format'|trans }}</span>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t<!--CTA-->
\t\t\t\t\t<input class=\"uv-btn timezone-btn\" href=\"#\" value=\"{{ 'Save Changes'|trans }}\" type=\"button\">
\t\t\t\t\t<!--//CTA-->
\t\t\t\t</form>
\t\t\t\t<!--//Form-->
\t\t\t</div>
\t\t\t<!--//Tab View-->

\t\t</div>
\t</div>
{% endblock %}
{% block footer %}
\t{{ parent() }}
 <link rel=\"stylesheet\" type=\"text/css\" href=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.0/css/bootstrap-colorpicker.min.css\">
    <script type=\"text/javascript\" src=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.0/js/bootstrap-colorpicker.min.js\"></script>

    <script>
  \t\t\$('.datetime').datetimepicker({
\t\t\tformat: 'YYYY-MM-DD H:mm:ss'
\t\t});
    </script>
    <!-- Header Link template -->
\t<script id=\"header_link_tmp\" type=\"text/template\">
        <div class=\"uv-element-block\">
            <label class=\"uv-field-label\">{{ 'Header Link'|trans }} #<%= count %></label>
            <div class=\"uv-field-block\">
                <input type=\"text\" class=\"uv-field\" name=\"headerLinks[<%= count %>][label]\" placeholder=\"{{ 'Label'|trans }}\" />
                <input type=\"text\" class=\"uv-field\" name=\"headerLinks[<%= count %>][url]\" placeholder=\"{{ 'URL (with http:// or https://)'|trans }}\" />
                <a class=\"uv-btn-tag remove-link\" href=\"#\"><span class=\"uv-icon-remove-dark-box\"></span></a>
            </div>
        </div>
    </script>
    <!-- //Header Link template -->

    <!-- Footer Link template -->
\t<script id=\"footer_link_tmp\" type=\"text/template\">
        <div class=\"uv-element-block\">
            <label class=\"uv-field-label\">{{ 'Footer Link'|trans }} #<%= count %></label>
            <div class=\"uv-field-block\">
                <input type=\"text\" class=\"uv-field\" name=\"footerLinks[<%= count %>][label]\" placeholder=\"{{ 'Label'|trans }}\" />
                <input type=\"text\" class=\"uv-field\" name=\"footerLinks[<%= count %>][url]\" placeholder=\"{{ 'URL (with http:// or https://)'|trans }}\" />
                <a class=\"uv-btn-tag remove-link\" href=\"#\"><span class=\"uv-icon-remove-dark-box\"></span></a>
            </div>
        </div>
    </script>
    <!-- //Footer Link template -->

\t<script type=\"text/javascript\">
\t\t\$(function () {
            \$('.uv-color-field').colorpicker({format: \"hex\"}).on('changeColor', function(ev) {
                \$(this).css('background', \$(this).val())
                textColor = app.appView.getTextColorBasedBackground(\$(this).val());
                \$(this).css('color', textColor)
            });

\t\t\tvar BrandingModel = Backbone.Model.extend({
\t\t\t    validation: {
\t\t\t    \t'website[name]': {
\t\t\t\t      \trequired: true,
\t\t\t\t       \tmsg: '{{ \"This field is mandatory\"|trans }}'
\t\t\t\t    },
\t\t\t    \t                  
                    'website[favicon]': [{
                            notEmptyFile: true,
                            msg: \"{{ 'An empty file is not allowed.'|trans }}\",
                        }, {
                            sizeLimit: true,
                            msg: \"{{ 'File size must not be greater than 200KB !!'|trans }}\",
                        }, {
                            imageFile: true,
                            msg: \"{{ 'Please upload valid Image file (Only JPEG, JPG, PNG allowed)!!'|trans }}\",
                        }
                    ],
                    'website[logo]': [{
                            notEmptyFile: true,
                            msg: \"{{ 'An empty file is not allowed.'|trans }}\",
                        }, {
                            sizeLimit: true,
                            msg: \"{{ 'File size must not be greater than 200KB !!'|trans }}\",
                        }, {
                            imageFile: true,
                            msg: \"{{ 'Please upload valid Image file (Only JPEG, JPG, PNG allowed)!!'|trans }}\",
                        }
                    ],
\t\t\t    }
\t\t\t});

            _.extend(Backbone.Validation.validators, {
                notEmptyFile: function(value, attr) {
                    var field = \$('input[name=\"' + attr + '\"]');
                    if(field.length && field[0].files && field[0].files.length ) {
                        var file = field[0].files[0];
                        if(file && 0 == file.size) {
                            return true; //error
                        }
                    }                    
                },
                sizeLimit: function(value, attr) {
                    var field = \$('input[name=\"' + attr + '\"]');
                    if(field.length && field[0].files && field[0].files.length ) {
                        var file = field[0].files[0];
                        if(file && file.size/1024 > 200) {
                            return true; //error                            
                        }
                    }                    
                },
                imageFile: function(value, attr) { 
                    var field = \$('input[name=\"' + attr + '\"]');
                    if(field.length && field[0].files && field[0].files.length ) {
                        var file = field[0].files[0];
                        if(file && file.type.indexOf('image/') != 0) {
                            return true; //error                            
                        }
                    }
                }
            });

\t\t\tvar BrandingForm = Backbone.View.extend({
\t\t\t    events: {
\t\t\t    \t'click .general-btn': 'generalBrandingFormSubmit',
\t\t\t        'click .pending-response-btn': 'pendingResponseSettingFormSubmit',
\t\t\t\t\t'click .uv-btn': 'disableButton',
\t\t\t        'blur input:not[type=\"file\"]': 'formChanegd',
                    'change input[type=\"file\"]': 'formChanegd',
                    'change .convertToSlug': 'convertToSlug',
                    'click .uv-btn-tag.btn-add': 'addMoreLink',
                    'click .remove-link': 'removeLink',
                    \"change .uv-knowledgebase-layout input[type='radio']\": 'layoutChanged',
                    'click #uv-reset-colors': 'resetDefaultColors',
\t\t\t    },
                resetDefaultColors: function(e) {
                    var defaultColorArray = {
                        'pageBackgroundColor': '#FFFFFF',
                        'headerBackgroundColor': '#FFFFFF',
                        'bannerBackgroundColor': '#7C70F4',
                        'linkColor': '#2750C4',
                        'linkHoverColor': '#2750C4',
                        'articleTextColor': '#333333',
                        'brandColor': '#7C70F4',
                    };
                    \$(e.target).addClass('uv-icon-history-active');
                    setTimeout(function () { 
                        \$(e.target).removeClass('uv-icon-history-active');
                    }, 500);
                    \$.each(defaultColorArray, function(index, value) {
                        var selectedField = \$('input[name=\"website['+ index +']\"]');
                        selectedField.val(value);
                        selectedField.trigger('changeColor');
                    });
                },
                headerLinkTemplate : _.template(\$(\"#header_link_tmp\").html()),
                footerLinkTemplate : _.template(\$(\"#footer_link_tmp\").html()),
\t\t\t    initialize: function () {
                    \$('.uv-color-field').each(function() {
                        textColor = app.appView.getTextColorBasedBackground(\$(this).val());
                        \$(this).css('color', textColor)
                    });

\t\t\t        Backbone.Validation.bind(this);\t\t\t      
\t\t\t    },
\t\t\t    formChanegd: function(e) {
                    if(!Backbone.\$(e.currentTarget).parents('.links').length) {
                        this.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
                        this.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
                    }
\t\t\t    },          
\t\t\t    generalBrandingFormSubmit: function (e) {
\t\t\t        e.preventDefault();
\t\t\t        this.model.set(\$('#generalSettingForm').serializeObject());
                        console.log(\"form_submited fail\");
                    
\t\t\t        if(this.model.isValid(true)) {
\t\t\t           \$(\"#generalSettingForm\").submit();
\t\t\t        }
\t\t\t    },
\t\t\t    pendingResponseSettingFormSubmit: function (e) {
\t\t\t        e.preventDefault();
\t\t\t        this.model.set(\$('#pendingResponseSettingForm').serializeObject());
\t\t\t        if(this.model.isValid('website[pendingSince]')) {
\t\t\t\t\t\t\$('.pending-response-btn').attr('disabled', 'disabled');
\t\t\t            \$(\"#pendingResponseSettingForm\").submit();
\t\t\t        }
\t\t\t    },
\t\t\t\tdisableButton: function(e) {
\t\t\t\t\tvar form = Backbone.\$(e.currentTarget).parents('form');
\t\t\t\t\tif(form.attr('id') == 'seoForm' || form.attr('id') == 'advancedForm' || form.attr('id') == 'knowledgebaseForm') {
\t\t\t\t\t\tBackbone.\$(e.currentTarget).attr('disabled', 'disabled');
\t\t\t\t\t\tform.submit()
\t\t\t\t\t}
\t\t\t\t},
                convertToSlug: function(e) {
                    Backbone.\$(e.currentTarget).val(app.appView.convertToSlug(Backbone.\$(e.currentTarget).val()));
                },
                addMoreLink: function(e) {
                    e.preventDefault();

                    var currentElement = Backbone.\$(e.currentTarget);
                    if(currentElement.attr('data-type') == 'header') {
                        count = \$('.uv-header-link-wrapper .uv-element-block').length + 1;
                        \$('.uv-header-link-wrapper .links').append(this.headerLinkTemplate({'count' : count}))
                    } else {
                        count = \$('.uv-footer-link-wrapper .uv-element-block').length + 1;
                        \$('.uv-footer-link-wrapper .links').append(this.footerLinkTemplate({'count' : count}))
                    }
                },
                removeLink: function(e) {
                    e.preventDefault()
                    Backbone.\$(e.currentTarget).parents('.uv-element-block').remove()
                },
                layoutChanged: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    \$('.uv-layout-icon').removeClass('uv-layout-icon-active');

                    \$(\"label[for='\" + currentElement.attr('id') + \"']\").addClass('uv-layout-icon-active');
                }
\t\t\t});

\t\t    var brandingForm = new BrandingForm({
\t\t        el: 'form',
\t\t        model: new BrandingModel()
\t\t    });
            
            var BroadcastModel = Backbone.Model.extend({
\t\t\t    validation: {
\t\t\t    \t'broadcasting[message]': {
\t\t\t\t      \trequired: true,
\t\t\t\t       \tmsg: '{{ \"This field is mandatory\"|trans }}'
\t\t\t\t    },
\t\t\t    }
\t\t\t});

\t\t\tvar BroadcastForm = Backbone.View.extend({
                el: '#broadcastingForm',
\t\t\t    events: {
\t\t\t    \t'click .broadcasting-btn': 'broadcastingFormSubmit',
                    'change textarea': 'formChanged',
\t\t\t    },
                initialize: function() {
                    Backbone.Validation.bind(this);
                },
\t\t\t    formChanged: function(e) {
                    if(!Backbone.\$(e.currentTarget).parents('.links').length) {
                        this.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
                        this.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
                    }
\t\t\t    },
                broadcastingFormSubmit: function(e) {
\t\t\t\t\tvar form = Backbone.\$(e.currentTarget).closest('form')
                    if(form.attr('id') == 'broadcastingForm') {
                        data = form.serializeObject();
                        this.model.set(data);
                        if(this.model.isValid(true)) {
                            Backbone.\$(e.currentTarget).attr('disabled', 'disabled');
                            form.submit()
                        }
                    }
                }
\t\t    });

            var LinksModel = Backbone.Model.extend({
\t\t\t    validation: {
\t\t\t    }
\t\t\t});

\t\t\tvar LinksForm = Backbone.View.extend({
                el: '#linksForm',
                initialize: function() {
                    Backbone.Validation.bind(this);
                },                
                events: {
                    'click .links-btn': 'validateLinks',
                },
                validateLinks: function(e) {
                    e.preventDefault();
                    var data = \$('#linksForm').serializeObject();
                    var self = this; var valid = true;
                    \$.each(data, function(key, value) {
                        if(key.indexOf('[url]') != -1 && value && !value.match('^(http:\\/\\/www\\.|https:\\/\\/www\\.|http:\\/\\/|https:\\/\\/)[a-z0-9]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}(:[0-9]{1,5})?(\\/.*)?\$')) {
    \t\t    \t\t\tBackbone.Validation.callbacks.invalid(self, key, '{{ \"Provide a valid url(with protocol)\"|trans }}', 'input');
                            valid = false;
                        } else {
    \t\t    \t\t\tBackbone.Validation.callbacks.valid(self, key, '{{ \"Provide a valid url(with protocol)\"|trans }}', 'input');                            
                        }
                    });
                    if(valid) {
\t\t\t\t\t\t\$('.links-btn').attr('disabled', 'disabled');
\t\t\t            \$(\"#linksForm\").submit();
\t\t\t        }
                },                      
            });

            var TimezoneForm = Backbone.View.extend({
                el: '#timeSettingForm',
\t\t\t    events: {
\t\t\t    \t'click .timezone-btn': 'timezoneFormSubmit',
                    
\t\t\t    },
                timezoneFormSubmit: function(e) {
\t\t\t\t\tvar form = Backbone.\$(e.currentTarget).closest('form')
                    if (form.attr('id') == 'timeSettingForm') {
                        data = form.serializeObject();
                        form.submit()
                    }
                }
\t\t    });

            var time = new TimezoneForm();

            var broadcastForm = new BroadcastForm({
                model: new BroadcastModel()
            });

\t\t\tvar linksForm = new LinksForm({
                model: new LinksModel()                
            });
        });
\t</script>
{% endblock %}", "@UVDeskSupportCenter/Staff/branding.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Staff/branding.html.twig");
    }
}
