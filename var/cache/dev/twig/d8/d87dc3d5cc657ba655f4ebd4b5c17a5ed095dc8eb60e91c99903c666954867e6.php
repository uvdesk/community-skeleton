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

/* @UVDeskCoreFramework/theme.html.twig */
class __TwigTemplate_ca315cabfd1797db408f8a5d8ff4671d8cc576e01cf4f238d99077ef66565dc3 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/theme.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/theme.html.twig"));

        // line 3
        $context["website"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 3, $this->source); })()), "getWebsiteDetails", [0 => "helpdesk"], "method", false, false, false, 3);
        // line 1
        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskCoreFramework/theme.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 5
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        // line 6
        echo "\t";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Branding"), "html", null, true);
        echo "
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 9
    public function block_pageContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        // line 10
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
\t<div class=\"uv-inner-section\">
\t\t";
        // line 53
        echo "\t\t";
        $context["asideTemplate"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\AsideTemplate";
        // line 54
        echo "\t\t";
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Branding";
        // line 55
        echo "
\t\t";
        // line 56
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 56, $this->source); })()), "getRegisteredComponent", [0 => (isset($context["asideTemplate"]) || array_key_exists("asideTemplate", $context) ? $context["asideTemplate"] : (function () { throw new RuntimeError('Variable "asideTemplate" does not exist.', 56, $this->source); })())], "method", false, false, false, 56), "renderSidebar", [0 => (isset($context["asideSidebarReference"]) || array_key_exists("asideSidebarReference", $context) ? $context["asideSidebarReference"] : (function () { throw new RuntimeError('Variable "asideSidebarReference" does not exist.', 56, $this->source); })())], "method", false, false, false, 56);
        echo "

\t\t<div class=\"uv-view ";
        // line 58
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 58, $this->source); })()), "request", [], "any", false, false, false, 58), "cookies", [], "any", false, false, false, 58) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 58, $this->source); })()), "request", [], "any", false, false, false, 58), "cookies", [], "any", false, false, false, 58), "get", [0 => "uv-asideView"], "method", false, false, false, 58))) {
            echo "uv-aside-view";
        }
        echo "\">
\t\t\t<h1>";
        // line 59
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Branding"), "html", null, true);
        echo "</h1>

\t\t\t<!--Tab View-->
            <div class=\"uv-tab-view uv-tab-view-active\" id=\"knowledgebase\">
                <!--Form-->
\t\t\t\t<form method=\"post\" id=\"helpdeskForm\">
                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        ";
        // line 68
        echo "\t\t\t\t\t  \t<label class=\"uv-field-label\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Theme Color"), "html", null, true);
        echo "</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"themeColor\" class=\"uv-field uv-color-field\" type=\"text\" value=\"";
        // line 70
        ((twig_get_attribute($this->env, $this->source, (isset($context["website"]) || array_key_exists("website", $context) ? $context["website"] : (function () { throw new RuntimeError('Variable "website" does not exist.', 70, $this->source); })()), "themeColor", [], "any", false, false, false, 70)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["website"]) || array_key_exists("website", $context) ? $context["website"] : (function () { throw new RuntimeError('Variable "website" does not exist.', 70, $this->source); })()), "themeColor", [], "any", false, false, false, 70), "html", null, true))) : (print ("#7C70F4")));
        echo "\" style=\"color: #FFF;background-color: ";
        ((twig_get_attribute($this->env, $this->source, (isset($context["website"]) || array_key_exists("website", $context) ? $context["website"] : (function () { throw new RuntimeError('Variable "website" does not exist.', 70, $this->source); })()), "themeColor", [], "any", false, false, false, 70)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["website"]) || array_key_exists("website", $context) ? $context["website"] : (function () { throw new RuntimeError('Variable "website" does not exist.', 70, $this->source); })()), "themeColor", [], "any", false, false, false, 70), "html", null, true))) : (print ("#7C70F4")));
        echo "\" placeholder=\"#7C70F4\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->
                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t  \t<label class=\"uv-field-label\">";
        // line 76
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Name"), "html", null, true);
        echo "</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"helpdeskName\" class=\"uv-field\" type=\"text\" value=\"";
        // line 78
        ((twig_get_attribute($this->env, $this->source, (isset($context["website"]) || array_key_exists("website", $context) ? $context["website"] : (function () { throw new RuntimeError('Variable "website" does not exist.', 78, $this->source); })()), "name", [], "any", false, false, false, 78)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["website"]) || array_key_exists("website", $context) ? $context["website"] : (function () { throw new RuntimeError('Variable "website" does not exist.', 78, $this->source); })()), "name", [], "any", false, false, false, 78), "html", null, true))) : (print ("")));
        echo "\" required=\"required\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t<!--CTA-->
\t\t\t\t\t<input class=\"uv-btn knowledgebase-btn\" href=\"#\" value=\"";
        // line 84
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"submit\">
\t\t\t\t\t<!--//CTA-->
                </form>
\t\t\t</div>
\t\t\t<!--//Tab View-->
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 93
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 94
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
    <link rel=\"stylesheet\" type=\"text/css\" href=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.0/css/bootstrap-colorpicker.min.css\">
    <script type=\"text/javascript\" src=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.0/js/bootstrap-colorpicker.min.js\"></script>

    <script type=\"text/javascript\">
        (() => {
            \$('.uv-color-field').colorpicker({format: \"hex\"}).on('changeColor', function(ev) {
                \$(this).css('background', \$(this).val())
                textColor = app.appView.getTextColorBasedBackground(\$(this).val());
                \$(this).css('color', textColor)
            });
        })();
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework/theme.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  230 => 94,  220 => 93,  202 => 84,  193 => 78,  188 => 76,  177 => 70,  171 => 68,  160 => 59,  154 => 58,  149 => 56,  146 => 55,  143 => 54,  140 => 53,  96 => 10,  86 => 9,  73 => 6,  63 => 5,  52 => 1,  50 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% set website = user_service.getWebsiteDetails('helpdesk') %}

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
\t<div class=\"uv-inner-section\">
\t\t{# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Branding' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}

\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
\t\t\t<h1>{{ 'Branding'|trans }}</h1>

\t\t\t<!--Tab View-->
            <div class=\"uv-tab-view uv-tab-view-active\" id=\"knowledgebase\">
                <!--Form-->
\t\t\t\t<form method=\"post\" id=\"helpdeskForm\">
                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
                        {##564DA8#}
\t\t\t\t\t  \t<label class=\"uv-field-label\">{{ 'Theme Color'|trans }}</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"themeColor\" class=\"uv-field uv-color-field\" type=\"text\" value=\"{{ website.themeColor ? website.themeColor : '#7C70F4' }}\" style=\"color: #FFF;background-color: {{ website.themeColor ? website.themeColor : '#7C70F4' }}\" placeholder=\"#7C70F4\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->
                    <!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t  \t<label class=\"uv-field-label\">{{ 'Name'|trans }}</label>
\t\t\t\t\t  \t<div class=\"uv-field-block\">
\t\t\t\t\t    \t<input name=\"helpdeskName\" class=\"uv-field\" type=\"text\" value=\"{{ website.name ? website.name : ''}}\" required=\"required\">
\t\t\t\t\t  \t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t<!--CTA-->
\t\t\t\t\t<input class=\"uv-btn knowledgebase-btn\" href=\"#\" value=\"{{ 'Save Changes'|trans }}\" type=\"submit\">
\t\t\t\t\t<!--//CTA-->
                </form>
\t\t\t</div>
\t\t\t<!--//Tab View-->
\t\t</div>
\t</div>
{% endblock %}

{% block footer %}
\t{{ parent() }}
    <link rel=\"stylesheet\" type=\"text/css\" href=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.0/css/bootstrap-colorpicker.min.css\">
    <script type=\"text/javascript\" src=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.0/js/bootstrap-colorpicker.min.js\"></script>

    <script type=\"text/javascript\">
        (() => {
            \$('.uv-color-field').colorpicker({format: \"hex\"}).on('changeColor', function(ev) {
                \$(this).css('background', \$(this).val())
                textColor = app.appView.getTextColorBasedBackground(\$(this).val());
                \$(this).css('color', textColor)
            });
        })();
\t</script>
{% endblock %}", "@UVDeskCoreFramework/theme.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/theme.html.twig");
    }
}
