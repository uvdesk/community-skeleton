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

/* @UVDeskCoreFramework/profile.html.twig */
class __TwigTemplate_4a66eda8f72f2314ed94abdf8e46536af6edcfcb6d3b58adb26302fc449bd3ea extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/profile.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/profile.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskCoreFramework/profile.html.twig", 1);
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
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Profile"), "html", null, true);
        echo "
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 7
    public function block_templateCSS($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "templateCSS"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "templateCSS"));

        // line 8
        echo "    <style>
        span.uv-app-list-flag-active {
        font-size: 15px;
        color: #FFFFFF;
        background-color: #2ED04C;
        display: inline-block;
        padding: 0px 7px 1px 7px;
        margin-bottom: 2px;
        border-radius: 3px;
        }
        span.uv-app-list-flag-inactive {
        font-size: 15px;
        color: #FFFFFF;
        background-color: #FF5656;
        display: inline-block;
        padding: 0px 7px 1px 7px;
        margin-bottom: 2px;
        border-radius: 3px;
        }
        .token-list {
            padding-left: 20px;
        }
        .add-token {
            position: absolute;
            right: 10px;
        }
        .token-item .uv-hr {
            margin: 25px 0 15px -20px;
        }
        .token-name {
            margin-right: 5px;
        }
        .mar-right-5 {
            margin-right: 5px;
        }
    </style>  
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 46
    public function block_pageContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        // line 47
        echo "    <div class=\"uv-inner-section\">
        ";
        // line 49
        echo "\t\t";
        $context["asideTemplate"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\AsideTemplate";
        // line 50
        echo "\t\t";
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Account";
        // line 51
        echo "
\t\t";
        // line 52
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 52, $this->source); })()), "getRegisteredComponent", [0 => (isset($context["asideTemplate"]) || array_key_exists("asideTemplate", $context) ? $context["asideTemplate"] : (function () { throw new RuntimeError('Variable "asideTemplate" does not exist.', 52, $this->source); })())], "method", false, false, false, 52), "renderSidebar", [0 => (isset($context["asideSidebarReference"]) || array_key_exists("asideSidebarReference", $context) ? $context["asideSidebarReference"] : (function () { throw new RuntimeError('Variable "asideSidebarReference" does not exist.', 52, $this->source); })())], "method", false, false, false, 52);
        echo "

\t\t<div class=\"uv-view ";
        // line 54
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 54, $this->source); })()), "request", [], "any", false, false, false, 54), "cookies", [], "any", false, false, false, 54) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 54, $this->source); })()), "request", [], "any", false, false, false, 54), "cookies", [], "any", false, false, false, 54), "get", [0 => "uv-asideView"], "method", false, false, false, 54))) {
            echo "uv-aside-view";
        }
        echo "\">
\t\t\t<h1>Profile</h1>
            ";
        // line 56
        $context["agentDetails"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 56, $this->source); })()), "getAgentDetailById", [0 => twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 56, $this->source); })()), "id", [], "any", false, false, false, 56)], "method", false, false, false, 56);
        // line 57
        echo "           
            <div class=\"uv-tabs\">
                <ul>
                    <li for=\"profile\" class=\"uv-tab-active\">Edit Profile</li>
                </ul>
            </div>
            ";
        // line 63
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 63, $this->source); })()), "flashes", [0 => "warning"], "method", false, false, false, 63));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 64
            echo "                <div class=\"flash-notice\">
                    ";
            // line 65
            echo twig_escape_filter($this->env, $context["message"], "html", null, true);
            echo "
                </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 68
        echo "            ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 68, $this->source); })()), "flashes", [0 => "success"], "method", false, false, false, 68));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 69
            echo "                <div class=\"flash-notice\">
                    ";
            // line 70
            echo twig_escape_filter($this->env, $context["message"], "html", null, true);
            echo "
                </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 73
        echo "            <!--Form-->
            <form method=\"post\" action=\"\" id=\"user-form\" enctype=\"multipart/form-data\">
                <div class=\"uv-tab-view uv-tab-view-active\" id=\"profile\">
                    <!-- Profile image -->
                     <div class=\"uv-image-upload-wrapper\">
                        ";
        // line 78
        $context["isHaveImage"] = ((((isset($context["agentDetails"]) || array_key_exists("agentDetails", $context) ? $context["agentDetails"] : (function () { throw new RuntimeError('Variable "agentDetails" does not exist.', 78, $this->source); })()) && twig_get_attribute($this->env, $this->source, (isset($context["agentDetails"]) || array_key_exists("agentDetails", $context) ? $context["agentDetails"] : (function () { throw new RuntimeError('Variable "agentDetails" does not exist.', 78, $this->source); })()), "profileImagePath", [], "any", false, false, false, 78))) ? (1) : (0));
        // line 79
        echo "                        <div class=\"uv-image-upload-brick ";
        if ((isset($context["isHaveImage"]) || array_key_exists("isHaveImage", $context) ? $context["isHaveImage"] : (function () { throw new RuntimeError('Variable "isHaveImage" does not exist.', 79, $this->source); })())) {
            echo "uv-on-drop-shadow";
        }
        echo "\" ";
        if ((isset($context["isHaveImage"]) || array_key_exists("isHaveImage", $context) ? $context["isHaveImage"] : (function () { throw new RuntimeError('Variable "isHaveImage" does not exist.', 79, $this->source); })())) {
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
        // line 86
        if ((isset($context["isHaveImage"]) || array_key_exists("isHaveImage", $context) ? $context["isHaveImage"] : (function () { throw new RuntimeError('Variable "isHaveImage" does not exist.', 86, $this->source); })())) {
            echo "src=\"";
            echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 86, $this->source); })()), "request", [], "any", false, false, false, 86), "scheme", [], "any", false, false, false, 86) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 86, $this->source); })()), "request", [], "any", false, false, false, 86), "httpHost", [], "any", false, false, false, 86)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")), "html", null, true);
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["agentDetails"]) || array_key_exists("agentDetails", $context) ? $context["agentDetails"] : (function () { throw new RuntimeError('Variable "agentDetails" does not exist.', 86, $this->source); })()), "profileImagePath", [], "any", false, false, false, 86), "html", null, true);
            echo "\"";
        }
        echo ">
                        </div>
                        <div class=\"uv-image-info-brick\">
                            <span class=\"uv-field-info\">";
        // line 89
        echo $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Upload a Profile Image (100px x 100px)<br> in PNG or JPG Format");
        echo "</span>
                        </div>
                    </div>

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 95
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("First Name"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input type=\"text\" name=\"user_form[firstName]\" class=\"uv-field\" value=\"";
        // line 97
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 97, $this->source); })()), "firstName", [], "any", false, false, false, 97)) ? (twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 97, $this->source); })()), "firstName", [], "any", false, false, false, 97)) : (twig_get_attribute($this->env, $this->source, (isset($context["agentDetails"]) || array_key_exists("agentDetails", $context) ? $context["agentDetails"] : (function () { throw new RuntimeError('Variable "agentDetails" does not exist.', 97, $this->source); })()), "firstName", [], "any", false, false, false, 97))), "html", null, true);
        echo "\" />
                        </div>
                    </div>

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 103
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Last Name"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input type=\"text\" name=\"user_form[lastName]\" class=\"uv-field\" value=\"";
        // line 105
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 105, $this->source); })()), "lastName", [], "any", false, false, false, 105)) ? (twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 105, $this->source); })()), "lastName", [], "any", false, false, false, 105)) : (twig_get_attribute($this->env, $this->source, (isset($context["agentDetails"]) || array_key_exists("agentDetails", $context) ? $context["agentDetails"] : (function () { throw new RuntimeError('Variable "agentDetails" does not exist.', 105, $this->source); })()), "lastName", [], "any", false, false, false, 105))), "html", null, true);
        echo "\" />
                        </div>
                    </div>

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 111
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input type=\"text\" name=\"user_form[email]\" class=\"uv-field\" value=\"";
        // line 113
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 113, $this->source); })()), "email", [], "any", false, false, false, 113), "html", null, true);
        echo "\" />
                        </div>
                    </div>

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 119
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Contact Number"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input type=\"text\" name=\"user_form[contactNumber]\" class=\"uv-field\" value=\"";
        // line 121
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["agentDetails"]) || array_key_exists("agentDetails", $context) ? $context["agentDetails"] : (function () { throw new RuntimeError('Variable "agentDetails" does not exist.', 121, $this->source); })()), "contactNumber", [], "any", false, false, false, 121)) ? (twig_get_attribute($this->env, $this->source, (isset($context["agentDetails"]) || array_key_exists("agentDetails", $context) ? $context["agentDetails"] : (function () { throw new RuntimeError('Variable "agentDetails" does not exist.', 121, $this->source); })()), "contactNumber", [], "any", false, false, false, 121)) : (twig_get_attribute($this->env, $this->source, (isset($context["agentDetails"]) || array_key_exists("agentDetails", $context) ? $context["agentDetails"] : (function () { throw new RuntimeError('Variable "agentDetails" does not exist.', 121, $this->source); })()), "contactNumber", [], "any", false, false, false, 121))), "html", null, true);
        echo "\" />
                        </div>
                    </div>
                   
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 126
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Timezone"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <select name=\"user_form[timezone]\" class=\"uv-select\">
                                ";
        // line 129
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_service"]) || array_key_exists("uvdesk_service", $context) ? $context["uvdesk_service"] : (function () { throw new RuntimeError('Variable "uvdesk_service" does not exist.', 129, $this->source); })()), "getTimezones", [], "method", false, false, false, 129));
        foreach ($context['_seq'] as $context["_key"] => $context["timezone"]) {
            // line 130
            echo "                                    <option value=\"";
            echo twig_escape_filter($this->env, $context["timezone"], "html", null, true);
            echo "\" ";
            if ((twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 130, $this->source); })()), "timezone", [], "any", false, false, false, 130) == $context["timezone"])) {
                echo "selected";
            }
            echo ">";
            echo twig_escape_filter($this->env, $context["timezone"], "html", null, true);
            echo "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['timezone'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 132
        echo "                            </select>
                        </div>
                        <span class=\"uv-field-info\">";
        // line 134
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Choose your default timezone"), "html", null, true);
        echo "</span>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 138
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Time Format"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <select name=\"user_form[timeformat]\" class=\"uv-select\">
                                ";
        // line 141
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_service"]) || array_key_exists("uvdesk_service", $context) ? $context["uvdesk_service"] : (function () { throw new RuntimeError('Variable "uvdesk_service" does not exist.', 141, $this->source); })()), "getTimeFormats", [], "method", false, false, false, 141));
        foreach ($context['_seq'] as $context["key"] => $context["timeformat"]) {
            echo "   
                                    <option value=\"";
            // line 142
            echo twig_escape_filter($this->env, $context["key"], "html", null, true);
            echo "\" ";
            if ((twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 142, $this->source); })()), "timeformat", [], "any", false, false, false, 142) == $context["key"])) {
                echo "selected";
            }
            echo ">";
            echo twig_escape_filter($this->env, $context["timeformat"], "html", null, true);
            echo "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['timeformat'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 144
        echo "                            </select>
                        </div>
                        <span class=\"uv-field-info\">";
        // line 146
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Choose your default timezone"), "html", null, true);
        echo "</span>
                    </div>

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 151
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Signature"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <textarea name=\"user_form[signature]\" class=\"uv-field\">";
        // line 153
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["agentDetails"]) || array_key_exists("agentDetails", $context) ? $context["agentDetails"] : (function () { throw new RuntimeError('Variable "agentDetails" does not exist.', 153, $this->source); })()), "signature", [], "any", false, false, false, 153)) ? (twig_get_attribute($this->env, $this->source, (isset($context["agentDetails"]) || array_key_exists("agentDetails", $context) ? $context["agentDetails"] : (function () { throw new RuntimeError('Variable "agentDetails" does not exist.', 153, $this->source); })()), "signature", [], "any", false, false, false, 153)) : (twig_get_attribute($this->env, $this->source, (isset($context["agentDetails"]) || array_key_exists("agentDetails", $context) ? $context["agentDetails"] : (function () { throw new RuntimeError('Variable "agentDetails" does not exist.', 153, $this->source); })()), "signature", [], "any", false, false, false, 153))), "html", null, true);
        echo "</textarea>
                        </div>
                        <span class=\"uv-field-info\">";
        // line 155
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("User signature will be append at the bottom of ticket reply box"), "html", null, true);
        echo "</span>
                    </div>

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 160
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Password"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input type=\"password\" name=\"user_form[password][first]\" class=\"uv-field\"  />
                            <span class=\"uv-field-info\">";
        // line 163
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Password will remain same if you are not entering something in this field"), "html", null, true);
        echo "</span>
                        </div>
                    </div>

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 169
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Confirm Password"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input type=\"password\" name=\"user_form[password][second]\" class=\"uv-field\"  />
                        </div>
                    </div>

                    <!-- CSRF token Field -->
                    <input type=\"hidden\" name=\"user_form[_token]\" value=\"";
        // line 176
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_service"]) || array_key_exists("uvdesk_service", $context) ? $context["uvdesk_service"] : (function () { throw new RuntimeError('Variable "uvdesk_service" does not exist.', 176, $this->source); })()), "generateCsrfToken", [0 => "user_form"], "method", false, false, false, 176), "html", null, true);
        echo "\"/>
                    <!-- //CSRF token Field -->

                    <input class=\"uv-btn\" id=\"uv-save-profile\" href=\"#\" value=\"";
        // line 179
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"submit\">
                </div>


                <div class=\"uv-pop-up-overlay\" id=\"confirm-password\">
                    <div class=\"uv-pop-up-box uv-pop-up-slim\">
                        <span class=\"uv-pop-up-close\"></span>
                        <p>";
        // line 186
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Enter your current Password to continue"), "html", null, true);
        echo "</p>
                        <div class=\"uv-element-block\">
                            <input type=\"password\" name=\"user_form[oldPassword]\" class=\"uv-field uv-margin-0\">
                        </div>
                        <div class=\"uv-pop-up-actions\">
                            <a href=\"#\" class=\"uv-btn proceed\">";
        // line 191
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Continue"), "html", null, true);
        echo "</a>
                        </div>
                    </div>
                </div>
                
            </form>

            

\t\t</div>
\t</div>
    
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 204
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 205
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar UserModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'user_form[firstName]': {
                        required: true,
                        msg: '";
        // line 212
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
        // line 227
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
                    },{
                        pattern: 'email',
                        msg: '";
        // line 230
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email address is invalid"), "html", null, true);
        echo "'
                    }],
                    'user_form[contactNumber]': function(value) {
                        if(value != undefined && value !== '') {
                            if(!value.match('^\\\\s*(?:\\\\+?(\\\\d{1,3}))?[-. (]*(\\\\d{3})[-. )]*(\\\\d{3})[-. ]*(\\\\d{4})(?: *x(\\\\d+))?\\\\s*\$'))
                                return '";
        // line 235
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Contact number is invalid"), "html", null, true);
        echo "';
                        }
                    },
                    'user_form[password][first]' : function(value) { 
                        if(value != undefined && value !== '') {
                             if(value.length < 8)
                            return '";
        // line 241
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Password must contains 8 Characters"), "html", null, true);
        echo "';
                        }                      
                    },
                    'user_form[password][second]': {
                        equalTo: 'user_form[password][first]',
                        msg: '";
        // line 246
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("The passwords does not match"), "html", null, true);
        echo "'
                    }
\t\t\t\t}
\t\t\t});

\t\t\tvar UserForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click #uv-save-profile' : \"saveUser\",
\t\t\t\t\t'blur input, textarea': 'formChanged',
                    'click a.select': 'selectAll',
                    'click a.deselect': 'deselectAll',
                    'click #confirm-password .proceed': 'confirmChange',
                },
              
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t\tvar jsonContext = JSON.parse('";
        // line 262
        echo (isset($context["errors"]) || array_key_exists("errors", $context) ? $context["errors"] : (function () { throw new RuntimeError('Variable "errors" does not exist.', 262, $this->source); })());
        echo "');
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
                },
                confirmChange: function(e) {
                    var target = \$('#confirm-password input[name=\"user_form[oldPassword]\"]');
                    var oldPass = target.val();
                    var that = this;
                    if(oldPass && oldPass.length > 7) {
                        \$('#confirm-password .uv-pop-up-close,#uv-save-profile').trigger('click');
                        target.next('.uv-field-message').remove();
                    } else {                    
                        target.addClass('uv-field-error');
                        if(!(target.next() && target.next().hasClass('uv-field-message')) ) {
                            target.after('<span class=\"uv-field-message\">'+ '";
        // line 287
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Password must contains 8 Characters"), "html", null, true);
        echo "'+ '</span>');
                        }
                    }
                },
\t\t\t\tformChanged: function(e) {
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
                    e.preventDefault();
                    var data = this.\$el.serializeObject();
                    this.model.set(data);

\t\t\t        if (this.model.isValid(true)) {
                        this.\$el.find('.uv-btn').attr('disabled', 'disabled');
                        this.\$el.submit();
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

\t\t\tuserForm = new UserForm({
\t\t\t\tel : \$(\"#user-form\"),
\t\t\t\tmodel : new UserModel()
\t\t\t});
\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework/profile.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  599 => 287,  571 => 262,  552 => 246,  544 => 241,  535 => 235,  527 => 230,  521 => 227,  503 => 212,  492 => 205,  482 => 204,  459 => 191,  451 => 186,  441 => 179,  435 => 176,  425 => 169,  416 => 163,  410 => 160,  402 => 155,  397 => 153,  392 => 151,  384 => 146,  380 => 144,  366 => 142,  360 => 141,  354 => 138,  347 => 134,  343 => 132,  328 => 130,  324 => 129,  318 => 126,  310 => 121,  305 => 119,  296 => 113,  291 => 111,  282 => 105,  277 => 103,  268 => 97,  263 => 95,  254 => 89,  243 => 86,  226 => 79,  224 => 78,  217 => 73,  208 => 70,  205 => 69,  200 => 68,  191 => 65,  188 => 64,  184 => 63,  176 => 57,  174 => 56,  167 => 54,  162 => 52,  159 => 51,  156 => 50,  153 => 49,  150 => 47,  140 => 46,  94 => 8,  84 => 7,  71 => 4,  61 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %}
\t{{ 'Profile'|trans }}
{% endblock %}

{% block templateCSS %}
    <style>
        span.uv-app-list-flag-active {
        font-size: 15px;
        color: #FFFFFF;
        background-color: #2ED04C;
        display: inline-block;
        padding: 0px 7px 1px 7px;
        margin-bottom: 2px;
        border-radius: 3px;
        }
        span.uv-app-list-flag-inactive {
        font-size: 15px;
        color: #FFFFFF;
        background-color: #FF5656;
        display: inline-block;
        padding: 0px 7px 1px 7px;
        margin-bottom: 2px;
        border-radius: 3px;
        }
        .token-list {
            padding-left: 20px;
        }
        .add-token {
            position: absolute;
            right: 10px;
        }
        .token-item .uv-hr {
            margin: 25px 0 15px -20px;
        }
        .token-name {
            margin-right: 5px;
        }
        .mar-right-5 {
            margin-right: 5px;
        }
    </style>  
{% endblock %}

{% block pageContent %}
    <div class=\"uv-inner-section\">
        {# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Account' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}

\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
\t\t\t<h1>Profile</h1>
            {%  set agentDetails = user_service.getAgentDetailById(user.id) %}
           
            <div class=\"uv-tabs\">
                <ul>
                    <li for=\"profile\" class=\"uv-tab-active\">Edit Profile</li>
                </ul>
            </div>
            {% for message in app.flashes('warning') %}
                <div class=\"flash-notice\">
                    {{ message }}
                </div>
            {% endfor %}
            {% for message in app.flashes('success') %}
                <div class=\"flash-notice\">
                    {{ message }}
                </div>
            {% endfor %}
            <!--Form-->
            <form method=\"post\" action=\"\" id=\"user-form\" enctype=\"multipart/form-data\">
                <div class=\"uv-tab-view uv-tab-view-active\" id=\"profile\">
                    <!-- Profile image -->
                     <div class=\"uv-image-upload-wrapper\">
                        {% set isHaveImage =  agentDetails and agentDetails.profileImagePath ? 1 : 0 %}
                        <div class=\"uv-image-upload-brick {% if isHaveImage %}uv-on-drop-shadow{% endif %}\" {% if isHaveImage %}style=\"border-color: transparent;\"{% endif %}>
                            <input type=\"file\" name=\"user_form[profileImage]\" id=\"uv-upload-profile\">
                            <div class=\"uv-image-upload-placeholder\">
                                <svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"48px\" height=\"32px\">
                                <path fill-rule=\"evenodd\" d=\"M28.026,26.003 L19.964,26.003 L19.964,17.962 L13.964,17.962 L23.995,8.050 L34.025,17.962 L28.026,17.962 L28.026,26.003 ZM33.557,3.421 C30.806,1.146 27.619,0.008 23.995,0.008 C21.182,0.008 18.588,0.756 16.214,2.252 C13.838,3.749 11.996,5.712 10.683,8.143 C7.683,8.456 5.152,9.749 3.090,12.024 C1.027,14.300 -0.004,16.965 -0.004,20.019 C-0.004,23.324 1.168,26.144 3.512,28.481 C5.855,30.819 8.682,31.988 11.996,31.988 L37.963,31.988 C40.712,31.988 43.072,31.006 45.040,29.042 C47.009,27.079 47.993,24.726 47.993,21.983 C47.993,19.364 47.087,17.106 45.275,15.203 C43.461,13.302 41.275,12.258 38.713,12.071 C38.024,8.580 36.306,5.698 33.557,3.421 Z\"></path>
                                </svg>
                            </div>
                            <img id=\"dynamic-image-upload\" {% if isHaveImage %}src=\"{{ app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') }}{{ agentDetails.profileImagePath }}\"{% endif %}>
                        </div>
                        <div class=\"uv-image-info-brick\">
                            <span class=\"uv-field-info\">{{ 'Upload a Profile Image (100px x 100px)<br> in PNG or JPG Format'|trans|raw }}</span>
                        </div>
                    </div>

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'First Name'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <input type=\"text\" name=\"user_form[firstName]\" class=\"uv-field\" value=\"{{ user.firstName ?: agentDetails.firstName }}\" />
                        </div>
                    </div>

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Last Name'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <input type=\"text\" name=\"user_form[lastName]\" class=\"uv-field\" value=\"{{ user.lastName ?:agentDetails.lastName }}\" />
                        </div>
                    </div>

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Email'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <input type=\"text\" name=\"user_form[email]\" class=\"uv-field\" value=\"{{ user.email}}\" />
                        </div>
                    </div>

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Contact Number'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <input type=\"text\" name=\"user_form[contactNumber]\" class=\"uv-field\" value=\"{{ agentDetails.contactNumber ?: agentDetails.contactNumber }}\" />
                        </div>
                    </div>
                   
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Timezone'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <select name=\"user_form[timezone]\" class=\"uv-select\">
                                {% for timezone in uvdesk_service.getTimezones() %}
                                    <option value=\"{{ timezone }}\" {% if user.timezone == timezone %}selected{% endif %}>{{ timezone }}</option>
                                {% endfor %}
                            </select>
                        </div>
                        <span class=\"uv-field-info\">{{ \"Choose your default timezone\"|trans }}</span>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Time Format'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <select name=\"user_form[timeformat]\" class=\"uv-select\">
                                {% for key, timeformat in uvdesk_service.getTimeFormats() %}   
                                    <option value=\"{{ key }}\" {% if user.timeformat == key %}selected{% endif %}>{{ timeformat }}</option>
                                {% endfor %}
                            </select>
                        </div>
                        <span class=\"uv-field-info\">{{ \"Choose your default timezone\"|trans }}</span>
                    </div>

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Signature'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <textarea name=\"user_form[signature]\" class=\"uv-field\">{{ agentDetails.signature ?: agentDetails.signature }}</textarea>
                        </div>
                        <span class=\"uv-field-info\">{{ 'User signature will be append at the bottom of ticket reply box'|trans }}</span>
                    </div>

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Password'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <input type=\"password\" name=\"user_form[password][first]\" class=\"uv-field\"  />
                            <span class=\"uv-field-info\">{{ 'Password will remain same if you are not entering something in this field'|trans }}</span>
                        </div>
                    </div>

                    <!-- Field -->
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Confirm Password'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <input type=\"password\" name=\"user_form[password][second]\" class=\"uv-field\"  />
                        </div>
                    </div>

                    <!-- CSRF token Field -->
                    <input type=\"hidden\" name=\"user_form[_token]\" value=\"{{ uvdesk_service.generateCsrfToken('user_form') }}\"/>
                    <!-- //CSRF token Field -->

                    <input class=\"uv-btn\" id=\"uv-save-profile\" href=\"#\" value=\"{{ 'Save Changes'|trans }}\" type=\"submit\">
                </div>


                <div class=\"uv-pop-up-overlay\" id=\"confirm-password\">
                    <div class=\"uv-pop-up-box uv-pop-up-slim\">
                        <span class=\"uv-pop-up-close\"></span>
                        <p>{{ 'Enter your current Password to continue'|trans }}</p>
                        <div class=\"uv-element-block\">
                            <input type=\"password\" name=\"user_form[oldPassword]\" class=\"uv-field uv-margin-0\">
                        </div>
                        <div class=\"uv-pop-up-actions\">
                            <a href=\"#\" class=\"uv-btn proceed\">{{ 'Continue'|trans }}</a>
                        </div>
                    </div>
                </div>
                
            </form>

            

\t\t</div>
\t</div>
    
{% endblock %}
{% block footer %}
\t{{ parent() }}
\t<script type=\"text/javascript\">
\t\t\$(function () {
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
\t\t\t\t\t'click #uv-save-profile' : \"saveUser\",
\t\t\t\t\t'blur input, textarea': 'formChanged',
                    'click a.select': 'selectAll',
                    'click a.deselect': 'deselectAll',
                    'click #confirm-password .proceed': 'confirmChange',
                },
              
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t\tvar jsonContext = JSON.parse('{{ errors|raw }}');
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
                },
                confirmChange: function(e) {
                    var target = \$('#confirm-password input[name=\"user_form[oldPassword]\"]');
                    var oldPass = target.val();
                    var that = this;
                    if(oldPass && oldPass.length > 7) {
                        \$('#confirm-password .uv-pop-up-close,#uv-save-profile').trigger('click');
                        target.next('.uv-field-message').remove();
                    } else {                    
                        target.addClass('uv-field-error');
                        if(!(target.next() && target.next().hasClass('uv-field-message')) ) {
                            target.after('<span class=\"uv-field-message\">'+ '{{ \"Password must contains 8 Characters\"|trans }}'+ '</span>');
                        }
                    }
                },
\t\t\t\tformChanged: function(e) {
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
                    e.preventDefault();
                    var data = this.\$el.serializeObject();
                    this.model.set(data);

\t\t\t        if (this.model.isValid(true)) {
                        this.\$el.find('.uv-btn').attr('disabled', 'disabled');
                        this.\$el.submit();
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

\t\t\tuserForm = new UserForm({
\t\t\t\tel : \$(\"#user-form\"),
\t\t\t\tmodel : new UserModel()
\t\t\t});
\t\t});
\t</script>
{% endblock %}
", "@UVDeskCoreFramework/profile.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/profile.html.twig");
    }
}
