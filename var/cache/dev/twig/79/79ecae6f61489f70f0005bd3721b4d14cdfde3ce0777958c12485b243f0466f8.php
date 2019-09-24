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

/* @UVDeskSupportCenter/Knowledgebase/customerAccount.html.twig */
class __TwigTemplate_fecca0804ccdaf473f157ca75f8e284ea1fc5bfdb79fc205ea56f7e217e475ad extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'ogtitle' => [$this, 'block_ogtitle'],
            'twtitle' => [$this, 'block_twtitle'],
            'tabHeader' => [$this, 'block_tabHeader'],
            'body' => [$this, 'block_body'],
            'footer' => [$this, 'block_footer'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "@UVDeskSupportCenter/Templates/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Knowledgebase/customerAccount.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Knowledgebase/customerAccount.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskSupportCenter/Templates/layout.html.twig", "@UVDeskSupportCenter/Knowledgebase/customerAccount.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 2
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Edit Profile", [], "messages");
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 3
    public function block_ogtitle($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "ogtitle"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "ogtitle"));

        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Edit Profile", [], "messages");
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 4
    public function block_twtitle($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "twtitle"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "twtitle"));

        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Edit Profile", [], "messages");
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 6
    public function block_tabHeader($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "tabHeader"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "tabHeader"));

        // line 7
        echo "\t<div class=\"uv-nav-bar uv-nav-tab\">
\t\t<div class=\"uv-container\">
\t\t\t<div class=\"uv-nav-bar-lt\">
\t\t\t\t<ul class=\"uv-nav-tab-label\">
\t\t\t\t\t<li><a href=\"#\" for=\"profile\" class=\"uv-nav-tab-active\">";
        // line 11
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Profile"), "html", null, true);
        echo "</a></li>
\t\t\t\t</ul>
\t\t\t</div>
\t\t\t<div class=\"uv-nav-bar-rt\">
\t\t\t\t<form method=\"get\" action=\"";
        // line 15
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_front_article_search");
        echo "\">
\t\t\t\t\t<input name=\"s\" class=\"uv-nav-search\" type=\"text\" placeholder=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Search"), "html", null, true);
        echo "\">
\t\t\t\t</form>
\t\t\t</div>
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 23
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 24
        echo "    <style>
        .uv-nav-tab-view {
            display: none;
        }
        .uv-nav-tab-view.uv-nav-tab-view-active {
            display: block;
        }
        .uv-image-upload-wrapper {
            padding: 5px 0px 10px 0px;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick {
            display: inline-block;
            vertical-align: middle;
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 5px;
            border: dashed 1px #B1B1AE;
            overflow: hidden;
            margin-right: 15px;
            transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .uv-image-upload-wrapper .uv-image-upload-brick input[type=\"file\"] {
            width: 100px;
            height: 100px;
            position: absolute;
            opacity: 0;
            z-index: 3;
        }
        .uv-image-upload-wrapper img {
            width: 100px;
            height: 100px;
            position: absolute;
            z-index: 2;
            border-radius: 5px;
            display: block;
            border: solid 2px #FFFFFF;
        }
        .uv-image-upload-wrapper img:not([src]) {
            display: none;
        }
        .uv-image-upload-wrapper .uv-image-upload-placeholder {
            position: absolute;
            width: 48px;
            height: 32px;
            left: 50%;
            top: 50%;
            margin-left: -24px;
            margin-top: -16px;
            z-index: 1;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick-48 {
            width: 48px;
            height: 48px;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick-48 input[type=\"file\"] {
            width: 48px;
            height: 48px;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick-48 img {
            width: 48px;
            height: auto;
            }
        .uv-image-upload-wrapper .uv-image-upload-brick-200 {
            width: 200px;
            height: 48px;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick-200 input[type=\"file\"] {
            width: 200px;
            height: 48px;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick-200 img {
            width: 200px;
            height: auto;
        }
        .uv-image-upload-wrapper .uv-image-upload-placeholder svg path {
            fill: #7C70F4;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick:hover .uv-image-upload-placeholder svg path {
            fill: #BA81F1;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick .uv-image-upload-placeholder svg {
            transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .uv-image-upload-wrapper .uv-image-upload-brick:hover .uv-image-upload-placeholder svg {
            transform: translateY(-2px);
        }
        .uv-image-upload-wrapper .uv-image-info-brick {
            display: inline-block;
            vertical-align: middle;
            margin: 10px 0px;
        }
        .uv-image-upload-wrapper .uv-on-drag {
            transform: scale(1.08);
            border: dashed 1px #333333;
        }
        .uv-image-upload-wrapper .uv-on-drop-shadow {
            box-shadow: 0px 0px 4.75px 0.25px rgba(0, 0, 0, 0.05), 0px 8px 24px 0px rgba(0, 0, 0, 0.15);
        }
\t\t.accounts-panel {
\t\t\tborder: solid 1px #D3D3D3;
            padding: 15px 15px 5px 15px;
            border-radius: 3px;
            margin: 25px 0px;
\t\t}
\t\t.social-accounts-table {
\t\t\tmargin: 20px 0px 10px;
\t\t}
\t\t.social-accounts-table table {
\t\t\tborder: solid 1px #D3D3D3;
\t\t}
\t\t.social-accounts-table table > tbody > tr > td {
\t\t\tborder-bottom: dashed 1px #D3D3D3;
\t\t}
\t\t.social-accounts-table table > tbody > tr:last-child > td {
\t\t\tborder-bottom: unset;
\t\t}
\t\t.social-accounts-table .social-accounts-pta {
\t\t\ttext-align: right;
\t\t}
\t\t.social-accounts-table .social-accounts-pta > * {
\t\t\ttext-align: left;
\t\t}
\t\t.social-account-banner {
\t\t\tmin-width: 220px;
\t\t\tdisplay: inline-block;
\t\t\tpadding: 3px;
\t\t\tborder-radius: 3px;
\t\t}
\t\t.social-account-banner > * {
\t\t\tdisplay: inline-block;
\t\t\tvertical-align: middle;
\t\t}
\t\t.social-account-name {}
\t\t.social-account-img {
\t\t\twidth: 40px;
\t\t\theight: 40px;
\t\t\tbackground-size: cover;
\t\t\tbackground-position: center;
\t\t\tmargin-right: 10px;
\t\t}
    </style>
    <div class=\"uv-nav-tab-view uv-nav-tab-view-active\" id=\"profile\">
        <h1>";
        // line 167
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Profile"), "html", null, true);
        echo "</h1>
        ";
        // line 168
        $context["customerDetails"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 168, $this->source); })()), "getCustomerDetailsById", [0 => twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 168, $this->source); })()), "id", [], "any", false, false, false, 168)], "method", false, false, false, 168);
        // line 169
        echo "        <!--Form-->
        <form method=\"post\" action=\"\" id=\"user-form\" enctype=\"multipart/form-data\">
            <!--Tab View-->
            <div class=\"uv-tab-view uv-tab-view-active\" id=\"profile\">
                <!-- Profile image -->
                <div class=\"uv-image-upload-wrapper\">
                    ";
        // line 175
        $context["isHaveImage"] = ((((isset($context["customerDetails"]) || array_key_exists("customerDetails", $context) ? $context["customerDetails"] : (function () { throw new RuntimeError('Variable "customerDetails" does not exist.', 175, $this->source); })()) && twig_get_attribute($this->env, $this->source, (isset($context["customerDetails"]) || array_key_exists("customerDetails", $context) ? $context["customerDetails"] : (function () { throw new RuntimeError('Variable "customerDetails" does not exist.', 175, $this->source); })()), "profileImagePath", [], "any", false, false, false, 175))) ? (1) : (0));
        // line 176
        echo "                    <div class=\"uv-image-upload-brick ";
        if ((isset($context["isHaveImage"]) || array_key_exists("isHaveImage", $context) ? $context["isHaveImage"] : (function () { throw new RuntimeError('Variable "isHaveImage" does not exist.', 176, $this->source); })())) {
            echo "uv-on-drop-shadow";
        }
        echo "\" ";
        if ((isset($context["isHaveImage"]) || array_key_exists("isHaveImage", $context) ? $context["isHaveImage"] : (function () { throw new RuntimeError('Variable "isHaveImage" does not exist.', 176, $this->source); })())) {
            echo "style=\"border-color: transparent;\"";
        }
        echo ">
                        <input type=\"file\" name=\"user_form[profileImage]\" id=\"uv-upload-profile\">
                        <div class=\"uv-image-upload-placeholder\">
                            <svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"48px\" height=\"32px\">
                            <path fill-rule=\"evenodd\" d=\"M28.026,26.003 L19.964,26.003 L19.964,17.962 L13.964,17.962 L23.995,8.050 L34.025,17.962 L28.026,17.962 L28.026,26.003 ZM33.557,3.421 C30.806,1.146 27.619,0.008 23.995,0.008 C21.182,0.008 18.588,0.756 16.214,2.252 C13.838,3.749 11.996,5.712 10.683,8.143 C7.683,8.456 5.152,9.749 3.090,12.024 C1.027,14.300 -0.004,16.965 -0.004,20.019 C-0.004,23.324 1.168,26.144 3.512,28.481 C5.855,30.819 8.682,31.988 11.996,31.988 L37.963,31.988 C40.712,31.988 43.072,31.006 45.040,29.042 C47.009,27.079 47.993,24.726 47.993,21.983 C47.993,19.364 47.087,17.106 45.275,15.203 C43.461,13.302 41.275,12.258 38.713,12.071 C38.024,8.580 36.306,5.698 33.557,3.421 Z\"></path>
                            </svg>
                        </div>
                        <img id=\"dynamic-image-upload\" ";
        // line 183
        if ((isset($context["isHaveImage"]) || array_key_exists("isHaveImage", $context) ? $context["isHaveImage"] : (function () { throw new RuntimeError('Variable "isHaveImage" does not exist.', 183, $this->source); })())) {
            echo "src=\"";
            echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 183, $this->source); })()), "request", [], "any", false, false, false, 183), "scheme", [], "any", false, false, false, 183) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 183, $this->source); })()), "request", [], "any", false, false, false, 183), "httpHost", [], "any", false, false, false, 183)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")), "html", null, true);
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["customerDetails"]) || array_key_exists("customerDetails", $context) ? $context["customerDetails"] : (function () { throw new RuntimeError('Variable "customerDetails" does not exist.', 183, $this->source); })()), "profileImagePath", [], "any", false, false, false, 183), "html", null, true);
            echo "\"";
        }
        echo ">
                    </div>
                    <div class=\"uv-image-info-brick\">
                        <span class=\"uv-field-info\">";
        // line 186
        echo $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Upload a Profile Image (100px x 100px)<br> in PNG or JPG Format");
        echo "</span>
                    </div>
                </div>
                <!-- //Profile image -->

                <!-- Field -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">";
        // line 193
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("First Name"), "html", null, true);
        echo "</label>
                    <div class=\"uv-field-block\">
                        <input type=\"text\" name=\"user_form[firstName]\" class=\"uv-field\" value=\"";
        // line 195
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 195, $this->source); })()), "firstName", [], "any", false, false, false, 195)) ? (twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 195, $this->source); })()), "firstName", [], "any", false, false, false, 195)) : (twig_get_attribute($this->env, $this->source, (isset($context["customerDetails"]) || array_key_exists("customerDetails", $context) ? $context["customerDetails"] : (function () { throw new RuntimeError('Variable "customerDetails" does not exist.', 195, $this->source); })()), "firstName", [], "any", false, false, false, 195))), "html", null, true);
        echo "\" />
                    </div>
                </div>
                <!-- //Field -->

                <!-- Field -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">";
        // line 202
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Last Name"), "html", null, true);
        echo "</label>
                    <div class=\"uv-field-block\">
                        <input type=\"text\" name=\"user_form[lastName]\" class=\"uv-field\" value=\"";
        // line 204
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 204, $this->source); })()), "lastName", [], "any", false, false, false, 204)) ? (twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 204, $this->source); })()), "lastName", [], "any", false, false, false, 204)) : (twig_get_attribute($this->env, $this->source, (isset($context["customerDetails"]) || array_key_exists("customerDetails", $context) ? $context["customerDetails"] : (function () { throw new RuntimeError('Variable "customerDetails" does not exist.', 204, $this->source); })()), "lastName", [], "any", false, false, false, 204))), "html", null, true);
        echo "\" />
                    </div>
                </div>
                <!-- //Field -->

                <!-- Field -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">";
        // line 211
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email"), "html", null, true);
        echo "</label>
                    <div class=\"uv-field-block\">
                        <input type=\"text\" name=\"user_form[email]\" class=\"uv-field\" value=\"";
        // line 213
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 213, $this->source); })()), "email", [], "any", false, false, false, 213), "html", null, true);
        echo "\" />
                    </div>
                </div>
                <!-- //Field -->

                <!-- Field -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">";
        // line 220
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Contact Number"), "html", null, true);
        echo "</label>
                    <div class=\"uv-field-block\">
                        <input type=\"text\" name=\"user_form[contactNumber]\" class=\"uv-field\" value=\"";
        // line 222
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["customerDetails"]) || array_key_exists("customerDetails", $context) ? $context["customerDetails"] : (function () { throw new RuntimeError('Variable "customerDetails" does not exist.', 222, $this->source); })()), "contactNumber", [], "any", false, false, false, 222)) ? (twig_get_attribute($this->env, $this->source, (isset($context["customerDetails"]) || array_key_exists("customerDetails", $context) ? $context["customerDetails"] : (function () { throw new RuntimeError('Variable "customerDetails" does not exist.', 222, $this->source); })()), "contactNumber", [], "any", false, false, false, 222)) : (twig_get_attribute($this->env, $this->source, (isset($context["customerDetails"]) || array_key_exists("customerDetails", $context) ? $context["customerDetails"] : (function () { throw new RuntimeError('Variable "customerDetails" does not exist.', 222, $this->source); })()), "contactNumber", [], "any", false, false, false, 222))), "html", null, true);
        echo "\" />
                    </div>
                </div>
                <!-- //Field -->

                <!-- Field -->
                ";
        // line 239
        echo "                <!-- //Field -->

                <!-- Field -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">";
        // line 243
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Password"), "html", null, true);
        echo "</label>
                    <div class=\"uv-field-block\">
                        <input type=\"password\" name=\"user_form[password][first]\" class=\"uv-field\" value=\"\" />
                    </div>
                </div>
                <!-- //Field -->

                <!-- Field -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">";
        // line 252
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Confirm Password"), "html", null, true);
        echo "</label>
                    <div class=\"uv-field-block\">
                        <input type=\"password\" name=\"user_form[password][second]\" class=\"uv-field\" value=\"\" />
                    </div>
                </div>
                <!-- //Field -->

                <!-- CSRF token Field -->
              
                <!-- //CSRF token Field -->

                <!--CTA-->
                <input class=\"uv-btn\" href=\"#\" value=\"";
        // line 264
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"submit\">
                <!--//CTA-->
            </div>
            <!--//Tab View-->

        </form>
        <!--//Form-->
    </div>

";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 275
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 276
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
\t<script type=\"text/javascript\">
\t\t\$(function () {
            var AccountLinkModel = Backbone.Model.extend({
                validation: {
                    'merge_token': function(value) {
                        if (value != undefined && value !== '') {
                            if (value == this.attributes.presentToken) {
                                return \"";
        // line 284
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("You can't merge an account with itself.", [], "messages");
        echo "\";
                            }
                        } else {
                            return '";
        // line 287
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "';
                        }
                    },
                }
            });

\t\t\tvar UserModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'user_form[firstName]': {
                        required: true,
                        msg: '";
        // line 297
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
                    },
                    'user_form[lastName]': function(value) {
                        if(value != undefined && value !== '') {
                            [{
                                pattern: /^[A-Za-z][A-Za-z]*[\\sA-Za-z]*\$/,
                                msg: 'This field must have characters only'
                            },{
                                maxLength:40,
                                msg:'Maximum character length is 40'
                            }]
                        }
                    },
                    'user_form[email]': [{
                        required: true,
                        msg: '";
        // line 312
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
                    },{
                        pattern: 'email',
                        msg: '";
        // line 315
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email address is invalid"), "html", null, true);
        echo "'
                    }],
                    'user_form[contactNumber]': function(value) {
                        if(value != undefined && value !== '') {
                            if(!value.match('^\\\\s*(?:\\\\+?(\\\\d{1,3}))?[-. (]*(\\\\d{3})[-. )]*(\\\\d{3})[-. ]*(\\\\d{4})(?: *x(\\\\d+))?\\\\s*\$'))
                                return '";
        // line 320
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Contact number is invalid"), "html", null, true);
        echo "';
                        }
                    },
                    'user_form[password][first]' : function(value) {
                        if(value != undefined && value !== '') {
                            if(value.length < 8)
                                return '";
        // line 326
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Password must contains 8 Characters"), "html", null, true);
        echo "';
                        }
                    },
                    'user_form[password][second]': {
                        equalTo: 'user_form[password][first]',
                        msg: '";
        // line 331
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("The passwords does not match"), "html", null, true);
        echo "'
                    }
\t\t\t\t}
\t\t\t});

\t\t\tvar UserForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn' : \"saveUser\",
\t\t\t\t\t'blur input, textarea': 'formChanegd',
                    'click a.select': 'selectAll',
\t\t            'click a.deselect': 'deselectAll',
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t    \t\tfor (var field in jsonContext) {
                        if(field == 'first') {
                            Backbone.Validation.callbacks.invalid(this, \"user_form[password][\" + field + \"]\", jsonContext[field], 'input');
                        } else {
\t\t    \t\t\t    Backbone.Validation.callbacks.invalid(this, \"user_form[\" + field + \"]\", jsonContext[field], 'input');
                        }
\t\t\t\t\t}

                    \$('#notifications .uv-scroll-plank .uv-scroll-block').each(function() {
                        if(!\$(this).find('.uv-element-block').length) {
                            \$(this).parents('.uv-scroll-plank').remove()
                        }
                    })
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
                    var fieldName = Backbone.\$(e.currentTarget).attr('name');
                    if(fieldName == 'user_form[password][second]') {
                        if(\$(\"input[name='user_form[password][first]']\").val().length) {
                            this.model.set(fieldName, Backbone.\$(e.currentTarget).val())
                            this.model.isValid([fieldName])
                        } else {
                            if(\$(\"input[name='user_form[password][second]']\").val().length) {
\t\t    \t\t\t        this.model.set(fieldName, Backbone.\$(e.currentTarget).val())
                                this.model.isValid([fieldName])
                            } else {
\t\t    \t\t\t        Backbone.Validation.callbacks.valid(this, fieldName, 'input');
                            }
                        }
                    } else {
                        this.model.set(fieldName, Backbone.\$(e.currentTarget).val())
                        this.model.isValid([fieldName])
                        if(fieldName == 'user_form[password][first]' && !\$(\"input[name='user_form[password][second]']\").val().length) {
\t\t    \t\t\t    Backbone.Validation.callbacks.valid(this, 'user_form[password][second]', 'input');
                        }
                    }
\t\t\t    },
\t\t\t\tsaveUser : function (e) {
\t\t\t\t\te.preventDefault();
\t\t\t        this.model.set(this.\$el.serializeObject());
\t\t\t        if(this.model.isValid(true)) {
\t\t\t\t\t\tthis.\$el.find('.uv-btn').attr('disabled', 'disabled');
\t\t\t            this.\$el.submit();
\t\t\t        }
\t\t\t\t},
                selectAll: function (e) {
                    e.preventDefault();
                    this.\$(e.currentTarget).parents('.uv-scroll-plank')
                            .find('input')
                            .prop('checked', true)
                },
                deselectAll: function (e) {
                    e.preventDefault();
                    this.\$(e.currentTarget).parents('.uv-scroll-plank')
                            .find('input')
                            .prop('checked', false);
\t\t        },
\t\t\t});

\t\t\tvar userForm = new UserForm({
\t\t\t\tel : \$(\"#user-form\"),
\t\t\t\tmodel : new UserModel()
\t\t\t});

\t\t\tvar HelpdeskResourcesView = Backbone.View.extend({
\t            el: '.uv-view',
\t            events: {
\t                'click .initiate-backup': 'initiateBackup',
\t            },
\t            initiateBackup: function(e) {
\t                e.preventDefault();
\t                \$(e.target).attr('disabled', 'disabled');
\t                \$(e.target).closest('form').submit();
\t            },
\t        });

\t        var helpdeskResources = new HelpdeskResourcesView();
\t\t\t
            \$('.uv-nav-tab-label li a').on('click', function(e) {
                e.preventDefault();

                \$('.uv-nav-tab-label li a').removeClass('uv-nav-tab-active');
                \$(this).addClass('uv-nav-tab-active');
                \$('.uv-nav-tab-view').removeClass('uv-nav-tab-view-active')
                \$('#' + \$(this).attr('for')).addClass('uv-nav-tab-view-active')
            });
\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Knowledgebase/customerAccount.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  574 => 331,  566 => 326,  557 => 320,  549 => 315,  543 => 312,  525 => 297,  512 => 287,  506 => 284,  494 => 276,  484 => 275,  464 => 264,  449 => 252,  437 => 243,  431 => 239,  422 => 222,  417 => 220,  407 => 213,  402 => 211,  392 => 204,  387 => 202,  377 => 195,  372 => 193,  362 => 186,  351 => 183,  334 => 176,  332 => 175,  324 => 169,  322 => 168,  318 => 167,  173 => 24,  163 => 23,  147 => 16,  143 => 15,  136 => 11,  130 => 7,  120 => 6,  101 => 4,  82 => 3,  63 => 2,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskSupportCenter/Templates/layout.html.twig\" %}
{% block title %}{% trans %}Edit Profile{% endtrans %}{% endblock %}
{% block ogtitle %}{% trans %}Edit Profile{% endtrans %}{% endblock %}
{% block twtitle %}{% trans %}Edit Profile{% endtrans %}{% endblock %}

{% block tabHeader %}
\t<div class=\"uv-nav-bar uv-nav-tab\">
\t\t<div class=\"uv-container\">
\t\t\t<div class=\"uv-nav-bar-lt\">
\t\t\t\t<ul class=\"uv-nav-tab-label\">
\t\t\t\t\t<li><a href=\"#\" for=\"profile\" class=\"uv-nav-tab-active\">{{ 'Profile'|trans }}</a></li>
\t\t\t\t</ul>
\t\t\t</div>
\t\t\t<div class=\"uv-nav-bar-rt\">
\t\t\t\t<form method=\"get\" action=\"{{path('helpdesk_customer_front_article_search')}}\">
\t\t\t\t\t<input name=\"s\" class=\"uv-nav-search\" type=\"text\" placeholder=\"{{ 'Search'|trans }}\">
\t\t\t\t</form>
\t\t\t</div>
\t\t</div>
\t</div>
{% endblock %}

{% block body %}
    <style>
        .uv-nav-tab-view {
            display: none;
        }
        .uv-nav-tab-view.uv-nav-tab-view-active {
            display: block;
        }
        .uv-image-upload-wrapper {
            padding: 5px 0px 10px 0px;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick {
            display: inline-block;
            vertical-align: middle;
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 5px;
            border: dashed 1px #B1B1AE;
            overflow: hidden;
            margin-right: 15px;
            transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .uv-image-upload-wrapper .uv-image-upload-brick input[type=\"file\"] {
            width: 100px;
            height: 100px;
            position: absolute;
            opacity: 0;
            z-index: 3;
        }
        .uv-image-upload-wrapper img {
            width: 100px;
            height: 100px;
            position: absolute;
            z-index: 2;
            border-radius: 5px;
            display: block;
            border: solid 2px #FFFFFF;
        }
        .uv-image-upload-wrapper img:not([src]) {
            display: none;
        }
        .uv-image-upload-wrapper .uv-image-upload-placeholder {
            position: absolute;
            width: 48px;
            height: 32px;
            left: 50%;
            top: 50%;
            margin-left: -24px;
            margin-top: -16px;
            z-index: 1;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick-48 {
            width: 48px;
            height: 48px;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick-48 input[type=\"file\"] {
            width: 48px;
            height: 48px;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick-48 img {
            width: 48px;
            height: auto;
            }
        .uv-image-upload-wrapper .uv-image-upload-brick-200 {
            width: 200px;
            height: 48px;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick-200 input[type=\"file\"] {
            width: 200px;
            height: 48px;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick-200 img {
            width: 200px;
            height: auto;
        }
        .uv-image-upload-wrapper .uv-image-upload-placeholder svg path {
            fill: #7C70F4;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick:hover .uv-image-upload-placeholder svg path {
            fill: #BA81F1;
        }
        .uv-image-upload-wrapper .uv-image-upload-brick .uv-image-upload-placeholder svg {
            transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .uv-image-upload-wrapper .uv-image-upload-brick:hover .uv-image-upload-placeholder svg {
            transform: translateY(-2px);
        }
        .uv-image-upload-wrapper .uv-image-info-brick {
            display: inline-block;
            vertical-align: middle;
            margin: 10px 0px;
        }
        .uv-image-upload-wrapper .uv-on-drag {
            transform: scale(1.08);
            border: dashed 1px #333333;
        }
        .uv-image-upload-wrapper .uv-on-drop-shadow {
            box-shadow: 0px 0px 4.75px 0.25px rgba(0, 0, 0, 0.05), 0px 8px 24px 0px rgba(0, 0, 0, 0.15);
        }
\t\t.accounts-panel {
\t\t\tborder: solid 1px #D3D3D3;
            padding: 15px 15px 5px 15px;
            border-radius: 3px;
            margin: 25px 0px;
\t\t}
\t\t.social-accounts-table {
\t\t\tmargin: 20px 0px 10px;
\t\t}
\t\t.social-accounts-table table {
\t\t\tborder: solid 1px #D3D3D3;
\t\t}
\t\t.social-accounts-table table > tbody > tr > td {
\t\t\tborder-bottom: dashed 1px #D3D3D3;
\t\t}
\t\t.social-accounts-table table > tbody > tr:last-child > td {
\t\t\tborder-bottom: unset;
\t\t}
\t\t.social-accounts-table .social-accounts-pta {
\t\t\ttext-align: right;
\t\t}
\t\t.social-accounts-table .social-accounts-pta > * {
\t\t\ttext-align: left;
\t\t}
\t\t.social-account-banner {
\t\t\tmin-width: 220px;
\t\t\tdisplay: inline-block;
\t\t\tpadding: 3px;
\t\t\tborder-radius: 3px;
\t\t}
\t\t.social-account-banner > * {
\t\t\tdisplay: inline-block;
\t\t\tvertical-align: middle;
\t\t}
\t\t.social-account-name {}
\t\t.social-account-img {
\t\t\twidth: 40px;
\t\t\theight: 40px;
\t\t\tbackground-size: cover;
\t\t\tbackground-position: center;
\t\t\tmargin-right: 10px;
\t\t}
    </style>
    <div class=\"uv-nav-tab-view uv-nav-tab-view-active\" id=\"profile\">
        <h1>{{ 'Profile'|trans }}</h1>
        {% set customerDetails = user_service.getCustomerDetailsById(user.id) %}
        <!--Form-->
        <form method=\"post\" action=\"\" id=\"user-form\" enctype=\"multipart/form-data\">
            <!--Tab View-->
            <div class=\"uv-tab-view uv-tab-view-active\" id=\"profile\">
                <!-- Profile image -->
                <div class=\"uv-image-upload-wrapper\">
                    {% set isHaveImage =  customerDetails and customerDetails.profileImagePath ? 1 : 0 %}
                    <div class=\"uv-image-upload-brick {% if isHaveImage %}uv-on-drop-shadow{% endif %}\" {% if isHaveImage %}style=\"border-color: transparent;\"{% endif %}>
                        <input type=\"file\" name=\"user_form[profileImage]\" id=\"uv-upload-profile\">
                        <div class=\"uv-image-upload-placeholder\">
                            <svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"48px\" height=\"32px\">
                            <path fill-rule=\"evenodd\" d=\"M28.026,26.003 L19.964,26.003 L19.964,17.962 L13.964,17.962 L23.995,8.050 L34.025,17.962 L28.026,17.962 L28.026,26.003 ZM33.557,3.421 C30.806,1.146 27.619,0.008 23.995,0.008 C21.182,0.008 18.588,0.756 16.214,2.252 C13.838,3.749 11.996,5.712 10.683,8.143 C7.683,8.456 5.152,9.749 3.090,12.024 C1.027,14.300 -0.004,16.965 -0.004,20.019 C-0.004,23.324 1.168,26.144 3.512,28.481 C5.855,30.819 8.682,31.988 11.996,31.988 L37.963,31.988 C40.712,31.988 43.072,31.006 45.040,29.042 C47.009,27.079 47.993,24.726 47.993,21.983 C47.993,19.364 47.087,17.106 45.275,15.203 C43.461,13.302 41.275,12.258 38.713,12.071 C38.024,8.580 36.306,5.698 33.557,3.421 Z\"></path>
                            </svg>
                        </div>
                        <img id=\"dynamic-image-upload\" {% if isHaveImage %}src=\"{{ app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') }}{{ customerDetails.profileImagePath }}\"{% endif %}>
                    </div>
                    <div class=\"uv-image-info-brick\">
                        <span class=\"uv-field-info\">{{ 'Upload a Profile Image (100px x 100px)<br> in PNG or JPG Format'|trans|raw }}</span>
                    </div>
                </div>
                <!-- //Profile image -->

                <!-- Field -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">{{ 'First Name'|trans }}</label>
                    <div class=\"uv-field-block\">
                        <input type=\"text\" name=\"user_form[firstName]\" class=\"uv-field\" value=\"{{ user.firstName ?: customerDetails.firstName }}\" />
                    </div>
                </div>
                <!-- //Field -->

                <!-- Field -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">{{ 'Last Name'|trans }}</label>
                    <div class=\"uv-field-block\">
                        <input type=\"text\" name=\"user_form[lastName]\" class=\"uv-field\" value=\"{{ user.lastName ?:customerDetails.lastName }}\" />
                    </div>
                </div>
                <!-- //Field -->

                <!-- Field -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">{{ 'Email'|trans }}</label>
                    <div class=\"uv-field-block\">
                        <input type=\"text\" name=\"user_form[email]\" class=\"uv-field\" value=\"{{ user.email}}\" />
                    </div>
                </div>
                <!-- //Field -->

                <!-- Field -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">{{ 'Contact Number'|trans }}</label>
                    <div class=\"uv-field-block\">
                        <input type=\"text\" name=\"user_form[contactNumber]\" class=\"uv-field\" value=\"{{ customerDetails.contactNumber ?: customerDetails.contactNumber }}\" />
                    </div>
                </div>
                <!-- //Field -->

                <!-- Field -->
                {# <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">{{ 'Timezone'|trans }}</label>
                    <div class=\"uv-field-block\">
                        <select name=\"user_form[timezone]\" class=\"uv-select\">
                            {% for timezone in user_service.getTimezones() %}
                                <option value=\"{{ timezone }}\" {% if user.timezone == timezone %}selected{% endif %}>{{ timezone }}</option>
                            {% endfor %}
                        </select>
                    </div>
                    <span class=\"uv-field-info\">{{ \"Choose your default timezone\"|trans }}</span>
                </div> #}
                <!-- //Field -->

                <!-- Field -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">{{ 'Password'|trans }}</label>
                    <div class=\"uv-field-block\">
                        <input type=\"password\" name=\"user_form[password][first]\" class=\"uv-field\" value=\"\" />
                    </div>
                </div>
                <!-- //Field -->

                <!-- Field -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">{{ 'Confirm Password'|trans }}</label>
                    <div class=\"uv-field-block\">
                        <input type=\"password\" name=\"user_form[password][second]\" class=\"uv-field\" value=\"\" />
                    </div>
                </div>
                <!-- //Field -->

                <!-- CSRF token Field -->
              
                <!-- //CSRF token Field -->

                <!--CTA-->
                <input class=\"uv-btn\" href=\"#\" value=\"{{ 'Save Changes'|trans }}\" type=\"submit\">
                <!--//CTA-->
            </div>
            <!--//Tab View-->

        </form>
        <!--//Form-->
    </div>

{% endblock %}

{% block footer %}
\t{{ parent() }}
\t<script type=\"text/javascript\">
\t\t\$(function () {
            var AccountLinkModel = Backbone.Model.extend({
                validation: {
                    'merge_token': function(value) {
                        if (value != undefined && value !== '') {
                            if (value == this.attributes.presentToken) {
                                return \"{% trans %}You can't merge an account with itself.{% endtrans %}\";
                            }
                        } else {
                            return '{{ \"This field is mandatory\"|trans }}';
                        }
                    },
                }
            });

\t\t\tvar UserModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'user_form[firstName]': {
                        required: true,
                        msg: '{{ \"This field is mandatory\"|trans }}'
                    },
                    'user_form[lastName]': function(value) {
                        if(value != undefined && value !== '') {
                            [{
                                pattern: /^[A-Za-z][A-Za-z]*[\\sA-Za-z]*\$/,
                                msg: 'This field must have characters only'
                            },{
                                maxLength:40,
                                msg:'Maximum character length is 40'
                            }]
                        }
                    },
                    'user_form[email]': [{
                        required: true,
                        msg: '{{ \"This field is mandatory\"|trans }}'
                    },{
                        pattern: 'email',
                        msg: '{{ \"Email address is invalid\"|trans }}'
                    }],
                    'user_form[contactNumber]': function(value) {
                        if(value != undefined && value !== '') {
                            if(!value.match('^\\\\s*(?:\\\\+?(\\\\d{1,3}))?[-. (]*(\\\\d{3})[-. )]*(\\\\d{3})[-. ]*(\\\\d{4})(?: *x(\\\\d+))?\\\\s*\$'))
                                return '{{ \"Contact number is invalid\"|trans }}';
                        }
                    },
                    'user_form[password][first]' : function(value) {
                        if(value != undefined && value !== '') {
                            if(value.length < 8)
                                return '{{ \"Password must contains 8 Characters\"|trans }}';
                        }
                    },
                    'user_form[password][second]': {
                        equalTo: 'user_form[password][first]',
                        msg: '{{ \"The passwords does not match\"|trans }}'
                    }
\t\t\t\t}
\t\t\t});

\t\t\tvar UserForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn' : \"saveUser\",
\t\t\t\t\t'blur input, textarea': 'formChanegd',
                    'click a.select': 'selectAll',
\t\t            'click a.deselect': 'deselectAll',
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t    \t\tfor (var field in jsonContext) {
                        if(field == 'first') {
                            Backbone.Validation.callbacks.invalid(this, \"user_form[password][\" + field + \"]\", jsonContext[field], 'input');
                        } else {
\t\t    \t\t\t    Backbone.Validation.callbacks.invalid(this, \"user_form[\" + field + \"]\", jsonContext[field], 'input');
                        }
\t\t\t\t\t}

                    \$('#notifications .uv-scroll-plank .uv-scroll-block').each(function() {
                        if(!\$(this).find('.uv-element-block').length) {
                            \$(this).parents('.uv-scroll-plank').remove()
                        }
                    })
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
                    var fieldName = Backbone.\$(e.currentTarget).attr('name');
                    if(fieldName == 'user_form[password][second]') {
                        if(\$(\"input[name='user_form[password][first]']\").val().length) {
                            this.model.set(fieldName, Backbone.\$(e.currentTarget).val())
                            this.model.isValid([fieldName])
                        } else {
                            if(\$(\"input[name='user_form[password][second]']\").val().length) {
\t\t    \t\t\t        this.model.set(fieldName, Backbone.\$(e.currentTarget).val())
                                this.model.isValid([fieldName])
                            } else {
\t\t    \t\t\t        Backbone.Validation.callbacks.valid(this, fieldName, 'input');
                            }
                        }
                    } else {
                        this.model.set(fieldName, Backbone.\$(e.currentTarget).val())
                        this.model.isValid([fieldName])
                        if(fieldName == 'user_form[password][first]' && !\$(\"input[name='user_form[password][second]']\").val().length) {
\t\t    \t\t\t    Backbone.Validation.callbacks.valid(this, 'user_form[password][second]', 'input');
                        }
                    }
\t\t\t    },
\t\t\t\tsaveUser : function (e) {
\t\t\t\t\te.preventDefault();
\t\t\t        this.model.set(this.\$el.serializeObject());
\t\t\t        if(this.model.isValid(true)) {
\t\t\t\t\t\tthis.\$el.find('.uv-btn').attr('disabled', 'disabled');
\t\t\t            this.\$el.submit();
\t\t\t        }
\t\t\t\t},
                selectAll: function (e) {
                    e.preventDefault();
                    this.\$(e.currentTarget).parents('.uv-scroll-plank')
                            .find('input')
                            .prop('checked', true)
                },
                deselectAll: function (e) {
                    e.preventDefault();
                    this.\$(e.currentTarget).parents('.uv-scroll-plank')
                            .find('input')
                            .prop('checked', false);
\t\t        },
\t\t\t});

\t\t\tvar userForm = new UserForm({
\t\t\t\tel : \$(\"#user-form\"),
\t\t\t\tmodel : new UserModel()
\t\t\t});

\t\t\tvar HelpdeskResourcesView = Backbone.View.extend({
\t            el: '.uv-view',
\t            events: {
\t                'click .initiate-backup': 'initiateBackup',
\t            },
\t            initiateBackup: function(e) {
\t                e.preventDefault();
\t                \$(e.target).attr('disabled', 'disabled');
\t                \$(e.target).closest('form').submit();
\t            },
\t        });

\t        var helpdeskResources = new HelpdeskResourcesView();
\t\t\t
            \$('.uv-nav-tab-label li a').on('click', function(e) {
                e.preventDefault();

                \$('.uv-nav-tab-label li a').removeClass('uv-nav-tab-active');
                \$(this).addClass('uv-nav-tab-active');
                \$('.uv-nav-tab-view').removeClass('uv-nav-tab-view-active')
                \$('#' + \$(this).attr('for')).addClass('uv-nav-tab-view-active')
            });
\t\t});
\t</script>
{% endblock %}
", "@UVDeskSupportCenter/Knowledgebase/customerAccount.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Knowledgebase/customerAccount.html.twig");
    }
}
