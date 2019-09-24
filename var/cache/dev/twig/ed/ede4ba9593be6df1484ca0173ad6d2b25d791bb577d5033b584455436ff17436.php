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

/* @UVDeskCoreFramework/account.html.twig */
class __TwigTemplate_1e648fc5040d7c9825d04c6ee1d79c19337159a53a2531f5ea36554e8edbb9f8 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'templateCSS' => [$this, 'block_templateCSS'],
            'body' => [$this, 'block_body'],
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/account.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/account.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskCoreFramework/account.html.twig", 1);
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

        echo "Edit Agent";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 5
    public function block_templateCSS($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "templateCSS"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "templateCSS"));

        // line 6
        echo "    <style>
        .uv-element-block .uv-element-block {
            margin: 6px 0;
        }
        
        .uv-tab-error {
            border-bottom: 3px solid #FF5656 !important;
        }
        
        .uv-paper .uv-view .uv-element-block .uv-error-message {
            color: #FF5656;
        }
        
        .uv-new-tab-link {
            width: 14px;
            height: 14px;
            display: inline-block;
            background-image: url(\"../../../../bundles/webkulcore/images/uvdesk-binaka-sprite.svg\");
            background-position:-13px -158px;
            margin: 5px 0 0 10px;
            float: right;
            vertical-align: top;
        }

        .uv-xtra-info {
            font-weight: bold;
            margin-left: 6px;
            font-style: normal;
            cursor: help;
        }
    </style>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 39
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 40
        echo "\t<div class=\"uv-inner-section\">
\t\t";
        // line 42
        echo "\t\t";
        $context["asideTemplate"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\AsideTemplate";
        // line 43
        echo "\t\t";
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Account";
        // line 44
        echo "
\t\t";
        // line 45
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 45, $this->source); })()), "getRegisteredComponent", [0 => (isset($context["asideTemplate"]) || array_key_exists("asideTemplate", $context) ? $context["asideTemplate"] : (function () { throw new RuntimeError('Variable "asideTemplate" does not exist.', 45, $this->source); })())], "method", false, false, false, 45), "renderSidebar", [0 => (isset($context["asideSidebarReference"]) || array_key_exists("asideSidebarReference", $context) ? $context["asideSidebarReference"] : (function () { throw new RuntimeError('Variable "asideSidebarReference" does not exist.', 45, $this->source); })())], "method", false, false, false, 45);
        echo "
        
\t\t<div class=\"uv-view ";
        // line 47
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 47, $this->source); })()), "request", [], "any", false, false, false, 47), "cookies", [], "any", false, false, false, 47) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 47, $this->source); })()), "request", [], "any", false, false, false, 47), "cookies", [], "any", false, false, false, 47), "get", [0 => "uv-asideView"], "method", false, false, false, 47))) {
            echo "uv-aside-view";
        }
        echo "\">
            <h1>Edit Agent</h1>
            
            ";
        // line 50
        $context["userDetails"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 50, $this->source); })()), "getAgentDetailById", [0 => twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 50, $this->source); })()), "id", [], "any", false, false, false, 50)], "method", false, false, false, 50);
        // line 51
        echo "            
            <!-- Form -->
\t\t\t<form method=\"post\" action=\"\" id=\"user-form\" enctype=\"multipart/form-data\">

                <!--Tabs-->
                <div class=\"uv-tabs\">
                    <ul>
                        <li for=\"profile\" class=\"uv-tab-active\">";
        // line 58
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("General"), "html", null, true);
        echo "</li>
                        <li for=\"groups\">";
        // line 59
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Groups"), "html", null, true);
        echo "</li>
                        ";
        // line 60
        if (!twig_in_filter("ROLE_SUPER_ADMIN", twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 60, $this->source); })()), "roles", [], "any", false, false, false, 60))) {
            // line 61
            echo "                            <li for=\"permission\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Permission"), "html", null, true);
            echo "</li>
                        ";
        }
        // line 63
        echo "                    </ul>
                </div>
                <!--Tabs-->

                <!--Tab View-->
                <div class=\"uv-tab-view uv-tab-view-active\" id=\"profile\">
                    <!-- Profile image -->
                    <div class=\"uv-image-upload-wrapper\">
                        ";
        // line 71
        $context["isHaveImage"] = ((((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 71, $this->source); })()) && twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 71, $this->source); })()), "profileImage", [], "any", false, false, false, 71))) ? (1) : (0));
        // line 72
        echo "\t\t\t\t\t    <div class=\"uv-image-upload-brick ";
        if ((isset($context["isHaveImage"]) || array_key_exists("isHaveImage", $context) ? $context["isHaveImage"] : (function () { throw new RuntimeError('Variable "isHaveImage" does not exist.', 72, $this->source); })())) {
            echo "uv-on-drop-shadow";
        }
        echo "\" ";
        if ((isset($context["isHaveImage"]) || array_key_exists("isHaveImage", $context) ? $context["isHaveImage"] : (function () { throw new RuntimeError('Variable "isHaveImage" does not exist.', 72, $this->source); })())) {
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
        // line 79
        if ((isset($context["isHaveImage"]) || array_key_exists("isHaveImage", $context) ? $context["isHaveImage"] : (function () { throw new RuntimeError('Variable "isHaveImage" does not exist.', 79, $this->source); })())) {
            echo "src=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 79, $this->source); })()), "profileImage", [], "any", false, false, false, 79), "html", null, true);
            echo "\"";
        }
        echo ">

                        </div>
                        <div class=\"uv-image-info-brick\">
                            <span class=\"uv-field-info\">";
        // line 83
        echo $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Upload a Profile Image (100px x 100px)<br> in PNG or JPG Format");
        echo "</span>
                        </div>
                    </div>
                    <!-- //Profile image -->

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 90
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("First Name"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[firstName]\" class=\"uv-field\" type=\"text\" value=\"";
        // line 92
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 92, $this->source); })()), "firstName", [], "any", false, false, false, 92)) ? (twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 92, $this->source); })()), "firstName", [], "any", false, false, false, 92)) : ((((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 92, $this->source); })())) ? (twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 92, $this->source); })()), "firstName", [], "any", false, false, false, 92)) : ("")))), "html", null, true);
        echo "\">
                        </div>
                    </div>
                    <!-- //Field -->

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 99
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Last Name"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[lastName]\" class=\"uv-field\" type=\"text\" value=\"";
        // line 101
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 101, $this->source); })()), "lastName", [], "any", false, false, false, 101)) ? (twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 101, $this->source); })()), "lastName", [], "any", false, false, false, 101)) : ((((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 101, $this->source); })())) ? (twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 101, $this->source); })()), "lastName", [], "any", false, false, false, 101)) : ("")))), "html", null, true);
        echo "\">
                        </div>
                    </div>
                    <!-- //Field -->

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 108
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[email]\" class=\"uv-field\" type=\"text\" value=\"";
        // line 110
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 110, $this->source); })()), "email", [], "any", false, false, false, 110), "html", null, true);
        echo "\">
                        </div>
                    </div>
                    <!-- //Field -->

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 117
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Designation"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[jobTitle]\" class=\"uv-field\" type=\"text\" value=\"";
        // line 119
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 119, $this->source); })()), "jobTitle", [], "any", false, false, false, 119)) ? (twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 119, $this->source); })()), "jobTitle", [], "any", false, false, false, 119)) : ((((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 119, $this->source); })())) ? (twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 119, $this->source); })()), "jobTitle", [], "any", false, false, false, 119)) : ("")))), "html", null, true);
        echo "\">
                        </div>
                    </div>
                    <!-- //Field -->

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 126
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Contact Number"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[contactNumber]\" class=\"uv-field\" type=\"text\" value=\"";
        // line 128
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 128, $this->source); })()), "contactNumber", [], "any", false, false, false, 128)) ? (twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 128, $this->source); })()), "contactNumber", [], "any", false, false, false, 128)) : ((((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 128, $this->source); })())) ? (twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 128, $this->source); })()), "contactNumber", [], "any", false, false, false, 128)) : ("")))), "html", null, true);
        echo "\">
                        </div>
                    </div>
                    <!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 135
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Timezone"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t    <select name=\"user_form[timezone]\" class=\"uv-select\">
\t\t\t\t\t\t        ";
        // line 138
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 138, $this->source); })()), "getTimezones", [], "method", false, false, false, 138));
        foreach ($context['_seq'] as $context["_key"] => $context["timezone"]) {
            // line 139
            echo "\t\t\t\t\t\t        \t<option value=\"";
            echo twig_escape_filter($this->env, $context["timezone"], "html", null, true);
            echo "\" ";
            if (((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 139, $this->source); })()) && (twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 139, $this->source); })()), "timezone", [], "any", false, false, false, 139) == $context["timezone"]))) {
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
        // line 141
        echo "\t\t\t\t\t\t    </select>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 143
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Choose a user's default timezone"), "html", null, true);
        echo "</span>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 149
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Signature"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <textarea name=\"user_form[signature]\" class=\"uv-field\">";
        // line 151
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 151, $this->source); })()), "signature", [], "any", false, false, false, 151)) ? (twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 151, $this->source); })()), "signature", [], "any", false, false, false, 151)) : ((((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 151, $this->source); })())) ? (twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 151, $this->source); })()), "signature", [], "any", false, false, false, 151)) : ("")))), "html", null, true);
        echo "</textarea>
                        </div>
                        <span class=\"uv-field-info\">";
        // line 153
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("User signature will be append in the bottom of ticket reply box"), "html", null, true);
        echo "</span>
                    </div>
                    <!-- //Field -->

                    ";
        // line 157
        if (((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 157, $this->source); })()) && twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 157, $this->source); })()), "isVerified", [], "any", false, false, false, 157))) {
            // line 158
            echo "                        <!-- Field -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">";
            // line 160
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
            // line 169
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Confirm Password"), "html", null, true);
            echo "</label>
                            <div class=\"uv-field-block\">
                                <input type=\"password\" name=\"user_form[password][second]\" class=\"uv-field\" value=\"\" />
                            </div>
                        </div>
                        <!-- //Field -->
                    ";
        }
        // line 176
        echo "
                    ";
        // line 177
        if (((isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 177, $this->source); })()) && (twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 177, $this->source); })()), "id", [], "any", false, false, false, 177) == twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 177, $this->source); })()), "user", [], "any", false, false, false, 177), "id", [], "any", false, false, false, 177)))) {
            // line 178
            echo "                    ";
        } else {
            // line 179
            echo "                        <!-- Field -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">";
            // line 181
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Account Status"), "html", null, true);
            echo "</label>
                            <div class=\"uv-element-block\">
                                <label>
                                    <div class=\"uv-checkbox\">
                                        <input type=\"checkbox\" name=\"user_form[isActive]\" value=\"";
            // line 185
            echo ((((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 185, $this->source); })()) && twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 185, $this->source); })()), "isActive", [], "any", false, false, false, 185))) ? (1) : (0));
            echo "\" ";
            echo ((((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 185, $this->source); })()) && twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 185, $this->source); })()), "isActive", [], "any", false, false, false, 185))) ? ("checked") : (""));
            echo ">
                                        <span class=\"uv-checkbox-view\"></span>
                                    </div>
                                    <span class=\"uv-checkbox-label\">";
            // line 188
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Account is Active"), "html", null, true);
            echo "</span>
                                </label>
                            </div>
                        </div>
                        <!-- //Field -->
                    ";
        }
        // line 194
        echo "
                </div>
                <!--//Tab View-->

                <!--Tab View-->
                <div class=\"uv-tab-view\" id=\"groups\">
                    ";
        // line 200
        $context["userGroups"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 200, $this->source); })()), "getUserGroupIds", [0 => twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 200, $this->source); })()), "id", [], "any", false, false, false, 200)], "method", false, false, false, 200);
        // line 201
        echo "                    <div class=\"uv-scroll-plank\">
                        <!-- Checkbox Block -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">";
        // line 204
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Groups"), "html", null, true);
        echo "</label>
                            <span class=\"uv-field-info uv-margin-top-5\">";
        // line 205
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Assigning group(s) to user to view tickets regardless assignment."), "html", null, true);
        echo "</span>
                        </div>

                        <div>
                            <!--Block-->
                            <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                ";
        // line 211
        $context["groups"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 211, $this->source); })()), "getGroups", [], "method", false, false, false, 211);
        // line 212
        echo "                                ";
        if ((isset($context["groups"]) || array_key_exists("groups", $context) ? $context["groups"] : (function () { throw new RuntimeError('Variable "groups" does not exist.', 212, $this->source); })())) {
            // line 213
            echo "                                    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["groups"]) || array_key_exists("groups", $context) ? $context["groups"] : (function () { throw new RuntimeError('Variable "groups" does not exist.', 213, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["group"]) {
                // line 214
                echo "                                        <!-- / -->
                                        <div class=\"uv-element-block\">
                                            <label>
                                                <div class=\"uv-checkbox\">
                                                    <input name=\"user_form[groups][]\" type=\"checkbox\" value=\"";
                // line 218
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["group"], "id", [], "any", false, false, false, 218), "html", null, true);
                echo "\" ";
                if (((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 218, $this->source); })()) && twig_in_filter(twig_get_attribute($this->env, $this->source, $context["group"], "id", [], "any", false, false, false, 218), (isset($context["userGroups"]) || array_key_exists("userGroups", $context) ? $context["userGroups"] : (function () { throw new RuntimeError('Variable "userGroups" does not exist.', 218, $this->source); })())))) {
                    echo "checked";
                }
                echo ">
                                                    <span class=\"uv-checkbox-view\"></span>
                                                </div>
                                                <span class=\"uv-checkbox-label\">";
                // line 221
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["group"], "name", [], "any", false, false, false, 221), "html", null, true);
                echo "</span>
                                            </label>
                                        </div>
                                        <!-- /// -->
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['group'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 226
            echo "                                ";
        } else {
            // line 227
            echo "                                    <div class=\"uv-element-block\">
                                        <a class=\"uv-error-message\" href=\"";
            // line 228
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_support_group_collection");
            echo "\" target=\"_blank\">";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("No Group added, Please add Group(s) first !", [], "messages");
            echo "</a>
                                    </div>
                                ";
        }
        // line 231
        echo "                            </div>
                            <!--//Block-->

                        </div>
                        <div class=\"uv-element-block\">
                            <a href=\"#\" class=\"select\">";
        // line 236
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Select All"), "html", null, true);
        echo "</a>
                            <a href=\"#\" class=\"deselect\">";
        // line 237
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Remove All"), "html", null, true);
        echo "</a>
                        </div>
                    </div>

                    ";
        // line 241
        $context["userSubGroups"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 241, $this->source); })()), "getUserSubGroupIds", [0 => twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 241, $this->source); })()), "id", [], "any", false, false, false, 241)], "method", false, false, false, 241);
        // line 242
        echo "                    <div class=\"uv-scroll-plank\">
                        <!-- Checkbox Block -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">";
        // line 245
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Teams"), "html", null, true);
        echo "</label>
                            <span class=\"uv-field-info uv-margin-top-5\">";
        // line 246
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Assigning team(s) to user to view tickets regardless assignment."), "html", null, true);
        echo "</span>
                        </div>

                        <div>
                            <!--Block-->
                            <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                ";
        // line 252
        $context["teams"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 252, $this->source); })()), "getSubGroups", [], "method", false, false, false, 252);
        // line 253
        echo "                                ";
        if ((isset($context["teams"]) || array_key_exists("teams", $context) ? $context["teams"] : (function () { throw new RuntimeError('Variable "teams" does not exist.', 253, $this->source); })())) {
            // line 254
            echo "                                    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["teams"]) || array_key_exists("teams", $context) ? $context["teams"] : (function () { throw new RuntimeError('Variable "teams" does not exist.', 254, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["team"]) {
                // line 255
                echo "                                        <!-- / -->
                                        <div class=\"uv-element-block\">
                                            <label>
                                                <div class=\"uv-checkbox\">
                                                    <input name=\"user_form[userSubGroup][]\" type=\"checkbox\" value=\"";
                // line 259
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "id", [], "any", false, false, false, 259), "html", null, true);
                echo "\" ";
                if (((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 259, $this->source); })()) && twig_in_filter(twig_get_attribute($this->env, $this->source, $context["team"], "id", [], "any", false, false, false, 259), (isset($context["userSubGroups"]) || array_key_exists("userSubGroups", $context) ? $context["userSubGroups"] : (function () { throw new RuntimeError('Variable "userSubGroups" does not exist.', 259, $this->source); })())))) {
                    echo "checked";
                }
                echo ">
                                                    <span class=\"uv-checkbox-view\"></span>
                                                </div>
                                                <span class=\"uv-checkbox-label\">";
                // line 262
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "name", [], "any", false, false, false, 262), "html", null, true);
                echo "</span>
                                            </label>
                                        </div>
                                        <!-- /// -->
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['team'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 267
            echo "                                ";
        } else {
            // line 268
            echo "                                    <div class=\"uv-element-block\">
                                        <a href=\"";
            // line 269
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_support_team_collection");
            echo "\" target=\"_blank\">";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("No Team added !", [], "messages");
            echo "</a>
                                    </div>
                                ";
        }
        // line 272
        echo "
                            </div>
                            <!--//Block-->

                        </div>
                        <div class=\"uv-element-block\">
                            <a href=\"#\" class=\"select\">";
        // line 278
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Select All"), "html", null, true);
        echo "</a>
                            <a href=\"#\" class=\"deselect\">";
        // line 279
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Remove All"), "html", null, true);
        echo "</a>
                        </div>
                    </div>
                </div>
                <!--//Tab View-->

                <!--Tab View-->
                <div class=\"uv-tab-view\" id=\"permission\">
                    ";
        // line 287
        if (!twig_in_filter("ROLE_SUPER_ADMIN", twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 287, $this->source); })()), "roles", [], "any", false, false, false, 287))) {
            // line 288
            echo "                        <!-- Field -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">";
            // line 290
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Role"), "html", null, true);
            echo "</label>
                            <div class=\"uv-field-block\">
                                <select name=\"user_form[role]\" class=\"uv-select\" id=\"user_form_role\" ";
            // line 292
            if (((isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 292, $this->source); })()) && (twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 292, $this->source); })()), "id", [], "any", false, false, false, 292) == twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 292, $this->source); })()), "user", [], "any", false, false, false, 292), "id", [], "any", false, false, false, 292)))) {
                echo "disabled=\"disabled\"";
            }
            echo ">
                                    <option value=\"ROLE_ADMIN\" ";
            // line 293
            if (twig_in_filter("ROLE_ADMIN", twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 293, $this->source); })()), "roles", [], "any", false, false, false, 293))) {
                echo "selected";
            }
            echo ">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Administrator"), "html", null, true);
            echo "</option>
                                    <option value=\"ROLE_AGENT\" ";
            // line 294
            if (twig_in_filter("ROLE_AGENT", twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 294, $this->source); })()), "roles", [], "any", false, false, false, 294))) {
                echo "selected";
            }
            echo ">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent"), "html", null, true);
            echo "</option>
                                </select>
                            </div>
                            <span class=\"uv-field-info\">";
            // line 297
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Select agent role"), "html", null, true);
            echo "</span>
                        </div>
                        <!-- //Field -->

                        <!-- Role dependent fields -->
                        <div class=\"role-dependent-fields\">
                            <div class=\"uv-scroll-plank\">
                                <!-- Checkbox Block -->
                                <div class=\"uv-element-block\">
                                    <label class=\"uv-field-label\">";
            // line 306
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent Privileges"), "html", null, true);
            echo "</label>
                                    <span class=\"uv-field-info uv-margin-top-5\">";
            // line 307
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent Privilege represents overall permissions in System."), "html", null, true);
            echo "</span>
                                </div>

                                ";
            // line 310
            $context["privileges"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 310, $this->source); })()), "getSupportPrivileges", [], "method", false, false, false, 310);
            // line 311
            echo "                                ";
            if ((isset($context["privileges"]) || array_key_exists("privileges", $context) ? $context["privileges"] : (function () { throw new RuntimeError('Variable "privileges" does not exist.', 311, $this->source); })())) {
                // line 312
                echo "                                    <div>
                                        <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                            ";
                // line 314
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable((isset($context["privileges"]) || array_key_exists("privileges", $context) ? $context["privileges"] : (function () { throw new RuntimeError('Variable "privileges" does not exist.', 314, $this->source); })()));
                foreach ($context['_seq'] as $context["_key"] => $context["privilege"]) {
                    // line 315
                    echo "                                                <!-- / -->
                                                <div class=\"uv-element-block\">
                                                    <label>
                                                        <div class=\"uv-checkbox\">
                                                            <input name=\"user_form[agentPrivilege][]\" type=\"checkbox\" value=\"";
                    // line 319
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["privilege"], "id", [], "any", false, false, false, 319), "html", null, true);
                    echo "\" ";
                    if ((((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 319, $this->source); })()) && twig_in_filter(twig_get_attribute($this->env, $this->source, $context["privilege"], "id", [], "any", false, false, false, 319), twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 319, $this->source); })()), "agentPrivilege", [], "any", false, false, false, 319))) || (twig_get_attribute($this->env, $this->source, ($context["userDetails"] ?? null), "agentPrivilege", [], "any", true, true, false, 319) && (twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 319, $this->source); })()), "agentPrivilege", [], "any", false, false, false, 319) == twig_get_attribute($this->env, $this->source, $context["privilege"], "id", [], "any", false, false, false, 319))))) {
                        echo "checked";
                    }
                    echo ">
                                                            <span class=\"uv-checkbox-view\"></span>
                                                        </div>
                                                        <span class=\"uv-checkbox-label\">";
                    // line 322
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["privilege"], "name", [], "any", false, false, false, 322), "html", null, true);
                    echo "</span>
                                                    </label>
                                                    <a class=\"uv-new-tab-link\" href=\"";
                    // line 324
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("edit_agent_privilege", ["id" => twig_get_attribute($this->env, $this->source, $context["privilege"], "id", [], "any", false, false, false, 324)]), "html", null, true);
                    echo "\" target=\"_blank\"></a>
                                                </div>
                                                <!-- /// -->
                                            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['privilege'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 328
                echo "                                        </div>
                                    </div>

                                    <div class=\"uv-element-block\">
                                        <a href=\"#\" class=\"select\">";
                // line 332
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Select All"), "html", null, true);
                echo "</a>
                                        <a href=\"#\" class=\"deselect\">";
                // line 333
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Remove All"), "html", null, true);
                echo "</a>
                                    </div>
                                ";
            } else {
                // line 336
                echo "                                    <div>
                                        <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                            <div class=\"uv-element-block\">
                                                <input name=\"user_form[agentPrivilege][]\" type=\"hidden\" value=\"\">
                                                <a class=\"uv-error-message\" href=\"";
                // line 340
                echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("agent_privileges_list");
                echo "\" target=\"_blank\">";
                echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("No Privilege added, Please add Privilege(s) first !", [], "messages");
                echo "</a>
                                            </div>
                                        </div>
                                    </div>
                                ";
            }
            // line 345
            echo "\t\t\t\t\t\t\t</div>

                            <div class=\"uv-element-block\">
                                <label class=\"uv-field-label\">";
            // line 348
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Ticket View"), "html", null, true);
            echo "</label>
                                <span class=\"uv-field-info\">";
            // line 349
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("User can view tickets based on selected scope."), "html", null, true);
            echo "
                                    <span class=\"uv-xtra-info\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"";
            // line 350
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("If individual access then user can View assigned Ticket(s) only, If Team access then user can view all Ticket(s) in team(s) he belongs to and so on"), "html", null, true);
            echo "\">[?]</span>
                                </span>
                                <div class=\"uv-element-block\" style=\"margin-top: 10px;\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"1\" type=\"radio\" ";
            // line 355
            if (((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 355, $this->source); })()) && (twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 355, $this->source); })()), "ticketView", [], "any", false, false, false, 355) == 1))) {
                echo "checked";
            }
            echo ">
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">";
            // line 358
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Global Access"), "html", null, true);
            echo "</span>
                                    </label>
                                </div>
                                <div class=\"uv-element-block\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"2\" type=\"radio\" ";
            // line 364
            if (((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 364, $this->source); })()) && (twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 364, $this->source); })()), "ticketView", [], "any", false, false, false, 364) == 2))) {
                echo "checked";
            }
            echo ">
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">";
            // line 367
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Group Access"), "html", null, true);
            echo "</span>
                                    </label>
                                </div>
                                <div class=\"uv-element-block\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"3\" type=\"radio\" ";
            // line 373
            if (((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 373, $this->source); })()) && (twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 373, $this->source); })()), "ticketView", [], "any", false, false, false, 373) == 3))) {
                echo "checked";
            }
            echo ">
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">";
            // line 376
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Team Access"), "html", null, true);
            echo "</span>
                                    </label>
                                </div>
                                <div class=\"uv-element-block\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"4\" type=\"radio\" ";
            // line 382
            if (((isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 382, $this->source); })()) && (twig_get_attribute($this->env, $this->source, (isset($context["userDetails"]) || array_key_exists("userDetails", $context) ? $context["userDetails"] : (function () { throw new RuntimeError('Variable "userDetails" does not exist.', 382, $this->source); })()), "ticketView", [], "any", false, false, false, 382) == 4))) {
                echo "checked";
            }
            echo ">
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">";
            // line 385
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Individual Access"), "html", null, true);
            echo "</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- //Role dependent fields -->
                    ";
        } else {
            // line 392
            echo "                        <input type=\"hidden\" name=\"user_form[role]\" value=\"ROLE_SUPER_ADMIN\">
                    ";
        }
        // line 394
        echo "                </div>
                <!--//Tab View-->

                <!-- CSRF token Field -->
                <input type=\"hidden\" name=\"user_form[_token]\" value=\"";
        // line 398
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["default_service"]) || array_key_exists("default_service", $context) ? $context["default_service"] : (function () { throw new RuntimeError('Variable "default_service" does not exist.', 398, $this->source); })()), "generateCsrfToken", [0 => "user_form"], "method", false, false, false, 398), "html", null, true);
        echo "\"/>
                <!-- //CSRF token Field -->

                <!--CTA-->
\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"";
        // line 402
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"submit\">
\t\t\t\t<!--//CTA-->
            </form>
            <!-- //Form -->
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 409
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 410
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar UserModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'user_form[firstName]': [{
                        required: true,
                        msg: '";
        // line 417
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
                    }, {
                        pattern: /^[A-Za-z][A-Za-z]*[\\sA-Za-z]*\$/,
                        msg: '";
        // line 420
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field must have characters only"), "html", null, true);
        echo "'
                    }],
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
        // line 435
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
                    },{
                        pattern: 'email',
                        msg: '";
        // line 438
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This is not a valid email address"), "html", null, true);
        echo "'
                    }],
                    'user_form[contactNumber]': function(value) {
                        if(value != undefined && value !== '') {
                            if(!value.match('^[0-9]*\$'))
                                return '";
        // line 443
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field must be a number"), "html", null, true);
        echo "';
                        }
                    },
                    'user_form[password][first]' : function(value) {
                        if(value != undefined && value !== '') {
                            if(value.length < 8)
                                return '";
        // line 449
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Password must contains 8 Characters"), "html", null, true);
        echo "';
                        }
                    },
                    'user_form[password][second]': {
                        equalTo: 'user_form[password][first]',
                        msg: '";
        // line 454
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("The passwords does not match"), "html", null, true);
        echo "'
                    },
                    'user_form[groups][]': {
                        required: true,
                        msg: '";
        // line 458
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
                    },
                    'user_form[agentPrivilege][]' : {
                        fn: function(value) {
                            if(\$(\"#user_form_role\").val() == 'ROLE_AGENT') {
                                if(!value)
                                    return true;
                            }

                            return false;
                        },
                        msg: '";
        // line 469
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
                    },
                    'user_form[ticketView]': {
                        fn: function(value) {
                            if(\$(\"#user_form_role\").val() == 'ROLE_AGENT') {
                                if(!value)
                                    return true;
                            }

                            return false;
                        },
                        msg: '";
        // line 480
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
                    },
\t\t\t\t}
\t\t\t});

\t\t\tvar UserForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn' : \"saveUser\",
\t\t\t\t\t'blur input, textarea': 'formChanegd',
                    'change #user_form_role': 'roleChanged',
                    'click a.select': 'selectAll',
\t\t            'click a.deselect': 'deselectAll',
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t\tvar jsonContext = JSON.parse('";
        // line 495
        echo $this->extensions['Webkul\UVDesk\CoreFrameworkBundle\Extension\TwigExtension']->addslashes((isset($context["errors"]) || array_key_exists("errors", $context) ? $context["errors"] : (function () { throw new RuntimeError('Variable "errors" does not exist.', 495, $this->source); })()));
        echo "');
\t\t    \t\tfor (var field in jsonContext) {
                        if(field == 'first') {
                            Backbone.Validation.callbacks.invalid(this, \"user_form[password][\" + field + \"]\", jsonContext[field], 'input');
                        } else {
\t\t    \t\t\t    Backbone.Validation.callbacks.invalid(this, \"user_form[\" + field + \"]\", jsonContext[field], 'input');
                        }
\t\t\t\t\t}
                    ";
        // line 503
        if ( !twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 503, $this->source); })()), "id", [], "any", false, false, false, 503)) {
            // line 504
            echo "                        /* guess timezone and select that one */
                        var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone == 'Asia/Calcutta' ? 'Asia/Kolkata' : Intl.DateTimeFormat().resolvedOptions().timeZone;
                        if(timezone) {
                            var option = \$('select[name=\"user_form[timezone]\"]').find('option[value=\"'+ timezone +'\"]');
                            if(option.length) {
                                option.prop('selected', true);
                            }
                        }
                    ";
        }
        // line 513
        echo "\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t    \tvar fieldName = Backbone.\$(e.currentTarget).attr('name');
                    \$(\".uv-tabs li.uv-tab-active\").removeClass('uv-tab-error')
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
                    \$(\".uv-tabs li\").removeClass('uv-tab-error')
                    this.model.unset('user_form[groups][]', { silent: true });
                    this.model.unset('user_form[agentPrivilege][]', { silent: true });
\t\t\t        this.model.set(this.\$el.serializeObject());
\t\t\t        if(this.model.isValid(true)) {
                        if(\$(\"#user_form_role\").val() == 'ROLE_ADMIN') {
                            \$('input[name=\"user_form[agentPrivilege][]\"]').remove();
                            this.model.unset('user_form[agentPrivilege][]', { silent: true });
                        }
\t\t\t\t\t\tthis.\$el.find('.uv-btn').attr('disabled', 'disabled');
\t\t\t            this.\$el.submit();
\t\t\t        } else {
                        \$('.uv-field-message').each(function(e) {
                            \$(\".uv-tabs li[for='\" + \$(this).parents('.uv-tab-view').attr('id') + \"']:not(.uv-tab-active)\").addClass('uv-tab-error')

                            if(\$(\".uv-tabs li[for='\" + \$(this).parents('.uv-tab-view').attr('id') + \"']:not(.uv-tab-active)\").length ) {
                                \$('.uv-view').animate({
                                    scrollTop: 0
                                }, 'slow');
                            }
                        });
                    }
\t\t\t\t},
                roleChanged: function(e) {
                    if(\$(e.target).val() == 'ROLE_AGENT') {
\t\t            \t\$('.role-dependent-fields').show();
\t\t            } else {
\t\t            \t\$('.role-dependent-fields').hide();
\t\t            }
                },
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

\t\t\tuserForm = new UserForm({
\t\t\t\tel : \$(\"#user-form\"),
\t\t\t\tmodel : new UserModel()
\t\t\t});

            \$('#user_form_role').trigger('change');
\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework/account.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1038 => 513,  1027 => 504,  1025 => 503,  1014 => 495,  996 => 480,  982 => 469,  968 => 458,  961 => 454,  953 => 449,  944 => 443,  936 => 438,  930 => 435,  912 => 420,  906 => 417,  895 => 410,  885 => 409,  868 => 402,  861 => 398,  855 => 394,  851 => 392,  841 => 385,  833 => 382,  824 => 376,  816 => 373,  807 => 367,  799 => 364,  790 => 358,  782 => 355,  774 => 350,  770 => 349,  766 => 348,  761 => 345,  751 => 340,  745 => 336,  739 => 333,  735 => 332,  729 => 328,  719 => 324,  714 => 322,  704 => 319,  698 => 315,  694 => 314,  690 => 312,  687 => 311,  685 => 310,  679 => 307,  675 => 306,  663 => 297,  653 => 294,  645 => 293,  639 => 292,  634 => 290,  630 => 288,  628 => 287,  617 => 279,  613 => 278,  605 => 272,  597 => 269,  594 => 268,  591 => 267,  580 => 262,  570 => 259,  564 => 255,  559 => 254,  556 => 253,  554 => 252,  545 => 246,  541 => 245,  536 => 242,  534 => 241,  527 => 237,  523 => 236,  516 => 231,  508 => 228,  505 => 227,  502 => 226,  491 => 221,  481 => 218,  475 => 214,  470 => 213,  467 => 212,  465 => 211,  456 => 205,  452 => 204,  447 => 201,  445 => 200,  437 => 194,  428 => 188,  420 => 185,  413 => 181,  409 => 179,  406 => 178,  404 => 177,  401 => 176,  391 => 169,  379 => 160,  375 => 158,  373 => 157,  366 => 153,  361 => 151,  356 => 149,  347 => 143,  343 => 141,  328 => 139,  324 => 138,  318 => 135,  308 => 128,  303 => 126,  293 => 119,  288 => 117,  278 => 110,  273 => 108,  263 => 101,  258 => 99,  248 => 92,  243 => 90,  233 => 83,  222 => 79,  205 => 72,  203 => 71,  193 => 63,  187 => 61,  185 => 60,  181 => 59,  177 => 58,  168 => 51,  166 => 50,  158 => 47,  153 => 45,  150 => 44,  147 => 43,  144 => 42,  141 => 40,  131 => 39,  90 => 6,  80 => 5,  61 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %}Edit Agent{% endblock %}

{% block templateCSS %}
    <style>
        .uv-element-block .uv-element-block {
            margin: 6px 0;
        }
        
        .uv-tab-error {
            border-bottom: 3px solid #FF5656 !important;
        }
        
        .uv-paper .uv-view .uv-element-block .uv-error-message {
            color: #FF5656;
        }
        
        .uv-new-tab-link {
            width: 14px;
            height: 14px;
            display: inline-block;
            background-image: url(\"../../../../bundles/webkulcore/images/uvdesk-binaka-sprite.svg\");
            background-position:-13px -158px;
            margin: 5px 0 0 10px;
            float: right;
            vertical-align: top;
        }

        .uv-xtra-info {
            font-weight: bold;
            margin-left: 6px;
            font-style: normal;
            cursor: help;
        }
    </style>
{% endblock %}

{% block body %}
\t<div class=\"uv-inner-section\">
\t\t{# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Account' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}
        
\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
            <h1>Edit Agent</h1>
            
            {% set userDetails = user_service.getAgentDetailById(user.id) %}
            
            <!-- Form -->
\t\t\t<form method=\"post\" action=\"\" id=\"user-form\" enctype=\"multipart/form-data\">

                <!--Tabs-->
                <div class=\"uv-tabs\">
                    <ul>
                        <li for=\"profile\" class=\"uv-tab-active\">{{ 'General'|trans }}</li>
                        <li for=\"groups\">{{ 'Groups'|trans }}</li>
                        {% if \"ROLE_SUPER_ADMIN\" not in user.roles %}
                            <li for=\"permission\">{{ 'Permission'|trans }}</li>
                        {% endif %}
                    </ul>
                </div>
                <!--Tabs-->

                <!--Tab View-->
                <div class=\"uv-tab-view uv-tab-view-active\" id=\"profile\">
                    <!-- Profile image -->
                    <div class=\"uv-image-upload-wrapper\">
                        {% set isHaveImage =  userDetails and userDetails.profileImage ? 1 : 0 %}
\t\t\t\t\t    <div class=\"uv-image-upload-brick {% if isHaveImage %}uv-on-drop-shadow{% endif %}\" {% if isHaveImage %}style=\"border-color: transparent;\"{% endif %}>
                            <input type=\"file\" name=\"user_form[profileImage]\" id=\"uv-upload-profile\">
                            <div class=\"uv-image-upload-placeholder\">
                                <svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"48px\" height=\"32px\">
                                <path fill-rule=\"evenodd\" d=\"M28.026,26.003 L19.964,26.003 L19.964,17.962 L13.964,17.962 L23.995,8.050 L34.025,17.962 L28.026,17.962 L28.026,26.003 ZM33.557,3.421 C30.806,1.146 27.619,0.008 23.995,0.008 C21.182,0.008 18.588,0.756 16.214,2.252 C13.838,3.749 11.996,5.712 10.683,8.143 C7.683,8.456 5.152,9.749 3.090,12.024 C1.027,14.300 -0.004,16.965 -0.004,20.019 C-0.004,23.324 1.168,26.144 3.512,28.481 C5.855,30.819 8.682,31.988 11.996,31.988 L37.963,31.988 C40.712,31.988 43.072,31.006 45.040,29.042 C47.009,27.079 47.993,24.726 47.993,21.983 C47.993,19.364 47.087,17.106 45.275,15.203 C43.461,13.302 41.275,12.258 38.713,12.071 C38.024,8.580 36.306,5.698 33.557,3.421 Z\"></path>
                                </svg>
                            </div>
                            <img id=\"dynamic-image-upload\" {% if isHaveImage %}src=\"{{ userDetails.profileImage }}\"{% endif %}>

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
                            <input name=\"user_form[firstName]\" class=\"uv-field\" type=\"text\" value=\"{{ user.firstName ?: (userDetails ? userDetails.firstName : '') }}\">
                        </div>
                    </div>
                    <!-- //Field -->

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Last Name'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[lastName]\" class=\"uv-field\" type=\"text\" value=\"{{ user.lastName ?: (userDetails ? userDetails.lastName : '') }}\">
                        </div>
                    </div>
                    <!-- //Field -->

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Email'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[email]\" class=\"uv-field\" type=\"text\" value=\"{{ user.email }}\">
                        </div>
                    </div>
                    <!-- //Field -->

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Designation'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[jobTitle]\" class=\"uv-field\" type=\"text\" value=\"{{ user.jobTitle ?: (userDetails ? userDetails.jobTitle : '') }}\">
                        </div>
                    </div>
                    <!-- //Field -->

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Contact Number'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[contactNumber]\" class=\"uv-field\" type=\"text\" value=\"{{ user.contactNumber ?: (userDetails ? userDetails.contactNumber : '') }}\">
                        </div>
                    </div>
                    <!-- //Field -->

                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Timezone'|trans }}</label>
\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t    <select name=\"user_form[timezone]\" class=\"uv-select\">
\t\t\t\t\t\t        {% for timezone in user_service.getTimezones() %}
\t\t\t\t\t\t        \t<option value=\"{{ timezone }}\" {% if userDetails and user.timezone == timezone %}selected{% endif %}>{{ timezone }}</option>
\t\t\t\t\t\t    \t{% endfor %}
\t\t\t\t\t\t    </select>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<span class=\"uv-field-info\">{{ \"Choose a user's default timezone\"|trans }}</span>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Signature'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <textarea name=\"user_form[signature]\" class=\"uv-field\">{{ user.signature ?: (userDetails ? userDetails.signature : '') }}</textarea>
                        </div>
                        <span class=\"uv-field-info\">{{ 'User signature will be append in the bottom of ticket reply box'|trans }}</span>
                    </div>
                    <!-- //Field -->

                    {% if userDetails and userDetails.isVerified %}
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
                    {% endif %}

                    {% if user and user.id == app.user.id %}
                    {% else %}
                        <!-- Field -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">{{ 'Account Status'|trans }}</label>
                            <div class=\"uv-element-block\">
                                <label>
                                    <div class=\"uv-checkbox\">
                                        <input type=\"checkbox\" name=\"user_form[isActive]\" value=\"{{ userDetails and userDetails.isActive ? 1 : 0 }}\" {{ userDetails and userDetails.isActive ? 'checked' : '' }}>
                                        <span class=\"uv-checkbox-view\"></span>
                                    </div>
                                    <span class=\"uv-checkbox-label\">{{ 'Account is Active'|trans }}</span>
                                </label>
                            </div>
                        </div>
                        <!-- //Field -->
                    {% endif %}

                </div>
                <!--//Tab View-->

                <!--Tab View-->
                <div class=\"uv-tab-view\" id=\"groups\">
                    {% set userGroups = user_service.getUserGroupIds(user.id) %}
                    <div class=\"uv-scroll-plank\">
                        <!-- Checkbox Block -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">{{ 'Groups'|trans }}</label>
                            <span class=\"uv-field-info uv-margin-top-5\">{{ 'Assigning group(s) to user to view tickets regardless assignment.'|trans }}</span>
                        </div>

                        <div>
                            <!--Block-->
                            <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                {% set groups = user_service.getGroups() %}
                                {% if groups %}
                                    {% for group in groups %}
                                        <!-- / -->
                                        <div class=\"uv-element-block\">
                                            <label>
                                                <div class=\"uv-checkbox\">
                                                    <input name=\"user_form[groups][]\" type=\"checkbox\" value=\"{{ group.id }}\" {% if userDetails and group.id in userGroups %}checked{% endif %}>
                                                    <span class=\"uv-checkbox-view\"></span>
                                                </div>
                                                <span class=\"uv-checkbox-label\">{{ group.name }}</span>
                                            </label>
                                        </div>
                                        <!-- /// -->
                                    {% endfor %}
                                {% else %}
                                    <div class=\"uv-element-block\">
                                        <a class=\"uv-error-message\" href=\"{{path('helpdesk_member_support_group_collection')}}\" target=\"_blank\">{% trans %}No Group added, Please add Group(s) first !{% endtrans %}</a>
                                    </div>
                                {% endif %}
                            </div>
                            <!--//Block-->

                        </div>
                        <div class=\"uv-element-block\">
                            <a href=\"#\" class=\"select\">{{ 'Select All'|trans }}</a>
                            <a href=\"#\" class=\"deselect\">{{ 'Remove All'|trans }}</a>
                        </div>
                    </div>

                    {% set userSubGroups = user_service.getUserSubGroupIds(user.id) %}
                    <div class=\"uv-scroll-plank\">
                        <!-- Checkbox Block -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">{{ 'Teams'|trans }}</label>
                            <span class=\"uv-field-info uv-margin-top-5\">{{ 'Assigning team(s) to user to view tickets regardless assignment.'|trans }}</span>
                        </div>

                        <div>
                            <!--Block-->
                            <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                {% set teams = user_service.getSubGroups() %}
                                {% if teams %}
                                    {% for team in teams %}
                                        <!-- / -->
                                        <div class=\"uv-element-block\">
                                            <label>
                                                <div class=\"uv-checkbox\">
                                                    <input name=\"user_form[userSubGroup][]\" type=\"checkbox\" value=\"{{ team.id }}\" {% if userDetails and team.id in userSubGroups %}checked{% endif %}>
                                                    <span class=\"uv-checkbox-view\"></span>
                                                </div>
                                                <span class=\"uv-checkbox-label\">{{ team.name }}</span>
                                            </label>
                                        </div>
                                        <!-- /// -->
                                    {% endfor %}
                                {% else %}
                                    <div class=\"uv-element-block\">
                                        <a href=\"{{path('helpdesk_member_support_team_collection')}}\" target=\"_blank\">{% trans %}No Team added !{% endtrans %}</a>
                                    </div>
                                {% endif %}

                            </div>
                            <!--//Block-->

                        </div>
                        <div class=\"uv-element-block\">
                            <a href=\"#\" class=\"select\">{{ 'Select All'|trans }}</a>
                            <a href=\"#\" class=\"deselect\">{{ 'Remove All'|trans }}</a>
                        </div>
                    </div>
                </div>
                <!--//Tab View-->

                <!--Tab View-->
                <div class=\"uv-tab-view\" id=\"permission\">
                    {% if \"ROLE_SUPER_ADMIN\" not in user.roles %}
                        <!-- Field -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">{{ 'Role'|trans }}</label>
                            <div class=\"uv-field-block\">
                                <select name=\"user_form[role]\" class=\"uv-select\" id=\"user_form_role\" {% if user and user.id == app.user.id %}disabled=\"disabled\"{% endif %}>
                                    <option value=\"ROLE_ADMIN\" {% if \"ROLE_ADMIN\" in user.roles %}selected{% endif %}>{{ 'Administrator'|trans }}</option>
                                    <option value=\"ROLE_AGENT\" {% if \"ROLE_AGENT\" in user.roles %}selected{% endif %}>{{ 'Agent'|trans }}</option>
                                </select>
                            </div>
                            <span class=\"uv-field-info\">{{ \"Select agent role\"|trans }}</span>
                        </div>
                        <!-- //Field -->

                        <!-- Role dependent fields -->
                        <div class=\"role-dependent-fields\">
                            <div class=\"uv-scroll-plank\">
                                <!-- Checkbox Block -->
                                <div class=\"uv-element-block\">
                                    <label class=\"uv-field-label\">{{ 'Agent Privileges'|trans }}</label>
                                    <span class=\"uv-field-info uv-margin-top-5\">{{ 'Agent Privilege represents overall permissions in System.'|trans }}</span>
                                </div>

                                {% set privileges = user_service.getSupportPrivileges() %}
                                {% if privileges %}
                                    <div>
                                        <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                            {% for privilege in privileges %}
                                                <!-- / -->
                                                <div class=\"uv-element-block\">
                                                    <label>
                                                        <div class=\"uv-checkbox\">
                                                            <input name=\"user_form[agentPrivilege][]\" type=\"checkbox\" value=\"{{ privilege.id }}\" {% if userDetails and privilege.id in userDetails.agentPrivilege or (userDetails.agentPrivilege is defined and userDetails.agentPrivilege == privilege.id) %}checked{% endif %}>
                                                            <span class=\"uv-checkbox-view\"></span>
                                                        </div>
                                                        <span class=\"uv-checkbox-label\">{{ privilege.name }}</span>
                                                    </label>
                                                    <a class=\"uv-new-tab-link\" href=\"{{ path('edit_agent_privilege', {'id': privilege.id }) }}\" target=\"_blank\"></a>
                                                </div>
                                                <!-- /// -->
                                            {% endfor %}
                                        </div>
                                    </div>

                                    <div class=\"uv-element-block\">
                                        <a href=\"#\" class=\"select\">{{ 'Select All'|trans }}</a>
                                        <a href=\"#\" class=\"deselect\">{{ 'Remove All'|trans }}</a>
                                    </div>
                                {% else %}
                                    <div>
                                        <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                            <div class=\"uv-element-block\">
                                                <input name=\"user_form[agentPrivilege][]\" type=\"hidden\" value=\"\">
                                                <a class=\"uv-error-message\" href=\"{{path('agent_privileges_list')}}\" target=\"_blank\">{% trans %}No Privilege added, Please add Privilege(s) first !{% endtrans %}</a>
                                            </div>
                                        </div>
                                    </div>
                                {% endif %}
\t\t\t\t\t\t\t</div>

                            <div class=\"uv-element-block\">
                                <label class=\"uv-field-label\">{{ 'Ticket View'|trans }}</label>
                                <span class=\"uv-field-info\">{{ 'User can view tickets based on selected scope.'|trans }}
                                    <span class=\"uv-xtra-info\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"{{ 'If individual access then user can View assigned Ticket(s) only, If Team access then user can view all Ticket(s) in team(s) he belongs to and so on'|trans }}\">[?]</span>
                                </span>
                                <div class=\"uv-element-block\" style=\"margin-top: 10px;\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"1\" type=\"radio\" {% if userDetails and userDetails.ticketView == 1 %}checked{% endif %}>
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">{{ 'Global Access'|trans }}</span>
                                    </label>
                                </div>
                                <div class=\"uv-element-block\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"2\" type=\"radio\" {% if userDetails and userDetails.ticketView == 2 %}checked{% endif %}>
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">{{ 'Group Access'|trans }}</span>
                                    </label>
                                </div>
                                <div class=\"uv-element-block\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"3\" type=\"radio\" {% if userDetails and userDetails.ticketView == 3 %}checked{% endif %}>
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">{{ 'Team Access'|trans }}</span>
                                    </label>
                                </div>
                                <div class=\"uv-element-block\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"4\" type=\"radio\" {% if userDetails and userDetails.ticketView == 4 %}checked{% endif %}>
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">{{ 'Individual Access'|trans }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- //Role dependent fields -->
                    {% else %}
                        <input type=\"hidden\" name=\"user_form[role]\" value=\"ROLE_SUPER_ADMIN\">
                    {% endif %}
                </div>
                <!--//Tab View-->

                <!-- CSRF token Field -->
                <input type=\"hidden\" name=\"user_form[_token]\" value=\"{{ default_service.generateCsrfToken('user_form') }}\"/>
                <!-- //CSRF token Field -->

                <!--CTA-->
\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"{{ 'Save Changes'|trans }}\" type=\"submit\">
\t\t\t\t<!--//CTA-->
            </form>
            <!-- //Form -->
\t\t</div>
\t</div>
{% endblock %}
{% block footer %}
\t{{ parent() }}
\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar UserModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'user_form[firstName]': [{
                        required: true,
                        msg: '{{ \"This field is mandatory\"|trans }}'
                    }, {
                        pattern: /^[A-Za-z][A-Za-z]*[\\sA-Za-z]*\$/,
                        msg: '{{ \"This field must have characters only\"|trans }}'
                    }],
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
                        msg: '{{ \"This is not a valid email address\"|trans }}'
                    }],
                    'user_form[contactNumber]': function(value) {
                        if(value != undefined && value !== '') {
                            if(!value.match('^[0-9]*\$'))
                                return '{{ \"This field must be a number\"|trans }}';
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
                    },
                    'user_form[groups][]': {
                        required: true,
                        msg: '{{ \"This field is mandatory\"|trans }}'
                    },
                    'user_form[agentPrivilege][]' : {
                        fn: function(value) {
                            if(\$(\"#user_form_role\").val() == 'ROLE_AGENT') {
                                if(!value)
                                    return true;
                            }

                            return false;
                        },
                        msg: '{{ \"This field is mandatory\"|trans }}'
                    },
                    'user_form[ticketView]': {
                        fn: function(value) {
                            if(\$(\"#user_form_role\").val() == 'ROLE_AGENT') {
                                if(!value)
                                    return true;
                            }

                            return false;
                        },
                        msg: '{{ \"This field is mandatory\"|trans }}'
                    },
\t\t\t\t}
\t\t\t});

\t\t\tvar UserForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn' : \"saveUser\",
\t\t\t\t\t'blur input, textarea': 'formChanegd',
                    'change #user_form_role': 'roleChanged',
                    'click a.select': 'selectAll',
\t\t            'click a.deselect': 'deselectAll',
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t\tvar jsonContext = JSON.parse('{{ errors|addslashes|raw }}');
\t\t    \t\tfor (var field in jsonContext) {
                        if(field == 'first') {
                            Backbone.Validation.callbacks.invalid(this, \"user_form[password][\" + field + \"]\", jsonContext[field], 'input');
                        } else {
\t\t    \t\t\t    Backbone.Validation.callbacks.invalid(this, \"user_form[\" + field + \"]\", jsonContext[field], 'input');
                        }
\t\t\t\t\t}
                    {% if not user.id %}
                        /* guess timezone and select that one */
                        var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone == 'Asia/Calcutta' ? 'Asia/Kolkata' : Intl.DateTimeFormat().resolvedOptions().timeZone;
                        if(timezone) {
                            var option = \$('select[name=\"user_form[timezone]\"]').find('option[value=\"'+ timezone +'\"]');
                            if(option.length) {
                                option.prop('selected', true);
                            }
                        }
                    {% endif %}
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t    \tvar fieldName = Backbone.\$(e.currentTarget).attr('name');
                    \$(\".uv-tabs li.uv-tab-active\").removeClass('uv-tab-error')
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
                    \$(\".uv-tabs li\").removeClass('uv-tab-error')
                    this.model.unset('user_form[groups][]', { silent: true });
                    this.model.unset('user_form[agentPrivilege][]', { silent: true });
\t\t\t        this.model.set(this.\$el.serializeObject());
\t\t\t        if(this.model.isValid(true)) {
                        if(\$(\"#user_form_role\").val() == 'ROLE_ADMIN') {
                            \$('input[name=\"user_form[agentPrivilege][]\"]').remove();
                            this.model.unset('user_form[agentPrivilege][]', { silent: true });
                        }
\t\t\t\t\t\tthis.\$el.find('.uv-btn').attr('disabled', 'disabled');
\t\t\t            this.\$el.submit();
\t\t\t        } else {
                        \$('.uv-field-message').each(function(e) {
                            \$(\".uv-tabs li[for='\" + \$(this).parents('.uv-tab-view').attr('id') + \"']:not(.uv-tab-active)\").addClass('uv-tab-error')

                            if(\$(\".uv-tabs li[for='\" + \$(this).parents('.uv-tab-view').attr('id') + \"']:not(.uv-tab-active)\").length ) {
                                \$('.uv-view').animate({
                                    scrollTop: 0
                                }, 'slow');
                            }
                        });
                    }
\t\t\t\t},
                roleChanged: function(e) {
                    if(\$(e.target).val() == 'ROLE_AGENT') {
\t\t            \t\$('.role-dependent-fields').show();
\t\t            } else {
\t\t            \t\$('.role-dependent-fields').hide();
\t\t            }
                },
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

\t\t\tuserForm = new UserForm({
\t\t\t\tel : \$(\"#user-form\"),
\t\t\t\tmodel : new UserModel()
\t\t\t});

            \$('#user_form_role').trigger('change');
\t\t});
\t</script>
{% endblock %}
", "@UVDeskCoreFramework/account.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/account.html.twig");
    }
}
