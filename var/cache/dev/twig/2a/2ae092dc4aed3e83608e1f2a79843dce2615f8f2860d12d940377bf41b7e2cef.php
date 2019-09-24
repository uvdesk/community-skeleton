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

/* @UVDeskCoreFramework/Templates/layout.html.twig */
class __TwigTemplate_141fcbb077acfe0acbfe068c799bb86684ccc71a0138ba9fe28637610c600e0e extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'templateCSS' => [$this, 'block_templateCSS'],
            'sidebar' => [$this, 'block_sidebar'],
            'pageWrapper' => [$this, 'block_pageWrapper'],
            'pageHeader' => [$this, 'block_pageHeader'],
            'pageContent' => [$this, 'block_pageContent'],
            'footer' => [$this, 'block_footer'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Templates/layout.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Templates/layout.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <title>";
        // line 4
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        <link rel=\"icon\" type=\"image/x-icon\" sizes=\"16x16 32x32 48x48\" href=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />

        <!-- Stylesheets -->
        <link href=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdeskcoreframework/css/_uikit.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" media=\"all\" />
        <link href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdeskcoreframework/css/_custom.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" media=\"all\" />
        <link href=\"//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\" type=\"text/css\" rel=\"stylesheet\">
        <link href=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css\" type=\"text/css\" rel=\"stylesheet\">

        <!-- Custom CSS -->
        ";
        // line 14
        $context["websiteConfiguration"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 14, $this->source); })()), "getWebsiteConfiguration", [0 => "knowledgebase"], "method", false, false, false, 14);
        // line 15
        echo "        ";
        $context["website"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 15, $this->source); })()), "getWebsiteDetails", [0 => "helpdesk"], "method", false, false, false, 15);
        // line 16
        echo "
        ";
        // line 17
        echo twig_include($this->env, $context, "@UVDeskCoreFramework/Templates/lightskin.html.twig");
        echo "

        <!-- Custom Stylesheets -->
        ";
        // line 20
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 20, $this->source); })()), "getRegisteredComponent", [0 => "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\Dashboard"], "method", false, false, false, 20), "getDashboardTemplate", [], "method", false, false, false, 20), "getStylesheetResources", [], "method", false, false, false, 20));
        foreach ($context['_seq'] as $context["_key"] => $context["stylesheet"]) {
            // line 21
            echo "            <link href=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl($context["stylesheet"]), "html", null, true);
            echo "\" type=\"text/css\" rel=\"stylesheet\" media=\"all\" />
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['stylesheet'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 23
        echo "        
        ";
        // line 24
        $this->displayBlock('templateCSS', $context, $blocks);
        // line 25
        echo "
        <!-- Scripts -->
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/backbone.validation/0.11.5/backbone-validation-min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/backbone.paginator/2.0.8/backbone.paginator.min.js\"></script>
        <script src=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdeskcoreframework/js/_common.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdeskcoreframework/js/_dropdown.js"), "html", null, true);
        echo "\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/d3/5.5.0/d3.min.js\"></script>
        <script src=\"";
        // line 35
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdeskcoreframework/js/viewer.js"), "html", null, true);
        echo "\"></script>
        <script src=\"https://code.jquery.com/ui/1.12.1/jquery-ui.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js\"></script>\t
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js\"></script>
    </head>

    <body>
        <div class=\"uv-notifications-wrapper\">
            <noscript>
                <div class=\"uv-notification page-load uv-error\">
                    <p>";
        // line 45
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Your browser does not support JavaScript or You disabled JavaScript, Please enable those !", [], "messages");
        echo "</p>
                </div>
                <style>.uv-loader-view {display: none;}</style>
            </noscript>

            ";
        // line 50
        if ((twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_service"]) || array_key_exists("uvdesk_service", $context) ? $context["uvdesk_service"] : (function () { throw new RuntimeError('Variable "uvdesk_service" does not exist.', 50, $this->source); })()), "requestHeadersSent", [], "method", false, false, false, 50) == false)) {
            // line 51
            echo "                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 51, $this->source); })()), "session", [], "any", false, false, false, 51), "flashbag", [], "any", false, false, false, 51), "get", [0 => "success"], "method", false, false, false, 51));
            foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
                // line 52
                echo "                    <div class=\"uv-notification page-load uv-success\">
                        <span class=\"uv-notification-close\"></span>
                        <p>";
                // line 54
                echo $context["flashMessage"];
                echo "</p>
                    </div>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 57
            echo "                
                ";
            // line 58
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 58, $this->source); })()), "session", [], "any", false, false, false, 58), "flashbag", [], "any", false, false, false, 58), "get", [0 => "warning"], "method", false, false, false, 58));
            foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
                // line 59
                echo "                    <div class=\"uv-notification page-load uv-error\">
                        <span class=\"uv-notification-close\"></span>
                        <p>";
                // line 61
                echo $context["flashMessage"];
                echo "</p>
                    </div>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 64
            echo "            ";
        }
        // line 65
        echo "        </div>

        <div class=\"uv-pop-up-overlay\" id=\"confirm-modal\">
            <div class=\"uv-pop-up-box uv-pop-up-slim\">
                <span class=\"uv-pop-up-close\"></span>
                <h2>";
        // line 70
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Confirm Action"), "html", null, true);
        echo "</h2>
                <p>";
        // line 71
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Are you sure? You want to perform this action."), "html", null, true);
        echo "</p>

                <div class=\"uv-pop-up-actions\">
                    <a href=\"#\" class=\"uv-btn uv-btn-error confirm\">";
        // line 74
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Confirm"), "html", null, true);
        echo "</a>
                    <a href=\"#\" class=\"uv-btn cancel\">";
        // line 75
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Cancel"), "html", null, true);
        echo "</a>
                </div>
            </div>
        </div>

        ";
        // line 80
        $context["currentUser"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 80, $this->source); })()), "getSessionUser", [], "method", false, false, false, 80);
        // line 81
        echo "        ";
        if ( !twig_test_empty((isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 81, $this->source); })()))) {
            // line 82
            echo "            ";
            $context["currentUserDetails"] = twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 82, $this->source); })()), "getAgentInstance", [], "method", false, false, false, 82), "getPartialDetails", [], "method", false, false, false, 82);
            // line 83
            echo "        ";
        }
        // line 84
        echo "
        ";
        // line 85
        $this->displayBlock('sidebar', $context, $blocks);
        // line 90
        echo "
        ";
        // line 91
        $this->displayBlock('pageWrapper', $context, $blocks);
        // line 104
        echo "        
        ";
        // line 105
        $this->displayBlock('footer', $context, $blocks);
        // line 158
        echo "
        ";
        // line 160
        echo "        ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 160, $this->source); })()), "getRegisteredComponent", [0 => "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\Dashboard"], "method", false, false, false, 160), "getDashboardTemplate", [], "method", false, false, false, 160), "getJavascriptResources", [], "method", false, false, false, 160));
        foreach ($context['_seq'] as $context["_key"] => $context["javascript"]) {
            // line 161
            echo "            <script src=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl($context["javascript"]), "html", null, true);
            echo "\" type=\"text/javascript\"></script>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['javascript'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 163
        echo "    </body>
</html>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 4
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        echo "HelpDesk";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 24
    public function block_templateCSS($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "templateCSS"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "templateCSS"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 85
    public function block_sidebar($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "sidebar"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "sidebar"));

        // line 86
        echo "            ";
        if (((isset($context["currentUser"]) || array_key_exists("currentUser", $context)) &&  !twig_test_empty((isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 86, $this->source); })())))) {
            // line 87
            echo "                ";
            $this->loadTemplate("@UVDeskCoreFramework/Templates/sidebar.html.twig", "@UVDeskCoreFramework/Templates/layout.html.twig", 87)->display($context);
            // line 88
            echo "            ";
        }
        // line 89
        echo "        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 91
    public function block_pageWrapper($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageWrapper"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageWrapper"));

        // line 92
        echo "            <div class=\"uv-paper\">
                ";
        // line 93
        $this->displayBlock('pageHeader', $context, $blocks);
        // line 96
        echo "
                <div class=\"uv-wrapper\">
                    <div class=\"uv-container\">
                        ";
        // line 99
        $this->displayBlock('pageContent', $context, $blocks);
        // line 100
        echo "                    </div>
                </div>
            </div>
        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 93
    public function block_pageHeader($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageHeader"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageHeader"));

        // line 94
        echo "                    ";
        $this->loadTemplate("@UVDeskCoreFramework/Templates/header.html.twig", "@UVDeskCoreFramework/Templates/layout.html.twig", 94)->display($context);
        // line 95
        echo "                ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 99
    public function block_pageContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 105
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 106
        echo "            ";
        $this->loadTemplate("@UVDeskCoreFramework/Templates/pagination.html.twig", "@UVDeskCoreFramework/Templates/layout.html.twig", 106)->display($context);
        // line 107
        echo "
            ";
        // line 109
        echo "            <div class=\"uv-pop-up-overlay\" id=\"confirm-modal\">
                <div class=\"uv-pop-up-box uv-pop-up-slim\">
                    <span class=\"uv-pop-up-close\"></span>
                    <h2>";
        // line 112
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Confirm Action"), "html", null, true);
        echo "</h2>
                    <p>";
        // line 113
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Are you sure? You want to perform this action."), "html", null, true);
        echo "</p>

                    <div class=\"uv-pop-up-actions\">
                        <a href=\"#\" class=\"uv-btn uv-btn-error confirm\">";
        // line 116
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Confirm"), "html", null, true);
        echo "</a>
                        <a href=\"#\" class=\"uv-btn cancel\">";
        // line 117
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Cancel"), "html", null, true);
        echo "</a>
                    </div>
                </div>
            </div>

            ";
        // line 123
        echo "            <script type=\"text/template\" id=\"loader-tmp\">
                <div class=\"uv-loader\">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </script>

            ";
        // line 132
        echo "            <script type=\"text/template\" id=\"full-view-loader\">
                <div class=\"uv-loader-view\">
                    <div class=\"uv-loader\">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </script>

            ";
        // line 143
        echo "            <script type=\"text/template\" id=\"notification-template\">
                <div class=\"uv-notification <% if(alertClass == 'danger') { %>uv-error<% } else { %> <%= 'uv-' + alertClass %> <% } %>\">
                    <span class=\"uv-notification-close\"></span>
                    <p><%= alertMessage %> </p>
                </div>
            </script>

            <script type=\"text/javascript\">
                var warningResponse = {
                    'alertClass' : 'danger',
                    'alertMessage' : '";
        // line 153
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Error : Something went wrong, please try again later"), "html", null, true);
        echo "',
                };
            </script>

        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework/Templates/layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  493 => 153,  481 => 143,  469 => 132,  459 => 123,  451 => 117,  447 => 116,  441 => 113,  437 => 112,  432 => 109,  429 => 107,  426 => 106,  416 => 105,  398 => 99,  388 => 95,  385 => 94,  375 => 93,  362 => 100,  360 => 99,  355 => 96,  353 => 93,  350 => 92,  340 => 91,  330 => 89,  327 => 88,  324 => 87,  321 => 86,  311 => 85,  293 => 24,  274 => 4,  263 => 163,  254 => 161,  249 => 160,  246 => 158,  244 => 105,  241 => 104,  239 => 91,  236 => 90,  234 => 85,  231 => 84,  228 => 83,  225 => 82,  222 => 81,  220 => 80,  212 => 75,  208 => 74,  202 => 71,  198 => 70,  191 => 65,  188 => 64,  179 => 61,  175 => 59,  171 => 58,  168 => 57,  159 => 54,  155 => 52,  150 => 51,  148 => 50,  140 => 45,  127 => 35,  122 => 33,  118 => 32,  109 => 25,  107 => 24,  104 => 23,  95 => 21,  91 => 20,  85 => 17,  82 => 16,  79 => 15,  77 => 14,  69 => 9,  65 => 8,  59 => 5,  55 => 4,  50 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html>
    <head>
        <title>{% block title %}HelpDesk{% endblock %}</title>
        <link rel=\"icon\" type=\"image/x-icon\" sizes=\"16x16 32x32 48x48\" href=\"{{ asset('favicon.ico') }}\" />

        <!-- Stylesheets -->
        <link href=\"{{ asset('bundles/uvdeskcoreframework/css/_uikit.css') }}\" type=\"text/css\" rel=\"stylesheet\" media=\"all\" />
        <link href=\"{{ asset('bundles/uvdeskcoreframework/css/_custom.css') }}\" type=\"text/css\" rel=\"stylesheet\" media=\"all\" />
        <link href=\"//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\" type=\"text/css\" rel=\"stylesheet\">
        <link href=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css\" type=\"text/css\" rel=\"stylesheet\">

        <!-- Custom CSS -->
        {% set websiteConfiguration = user_service.getWebsiteConfiguration('knowledgebase') %}
        {% set website = user_service.getWebsiteDetails('helpdesk') %}

        {{ include('@UVDeskCoreFramework/Templates/lightskin.html.twig') }}

        <!-- Custom Stylesheets -->
        {% for stylesheet in uvdesk_extensibles.getRegisteredComponent('Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\Dashboard').getDashboardTemplate().getStylesheetResources() %}
            <link href=\"{{ asset(stylesheet) }}\" type=\"text/css\" rel=\"stylesheet\" media=\"all\" />
        {% endfor %}
        
        {% block templateCSS %}{% endblock %}

        <!-- Scripts -->
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/backbone.validation/0.11.5/backbone-validation-min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/backbone.paginator/2.0.8/backbone.paginator.min.js\"></script>
        <script src=\"{{ asset('bundles/uvdeskcoreframework/js/_common.js') }}\"></script>
        <script src=\"{{ asset('bundles/uvdeskcoreframework/js/_dropdown.js') }}\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/d3/5.5.0/d3.min.js\"></script>
        <script src=\"{{ asset('bundles/uvdeskcoreframework/js/viewer.js') }}\"></script>
        <script src=\"https://code.jquery.com/ui/1.12.1/jquery-ui.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js\"></script>\t
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js\"></script>
    </head>

    <body>
        <div class=\"uv-notifications-wrapper\">
            <noscript>
                <div class=\"uv-notification page-load uv-error\">
                    <p>{% trans %}Your browser does not support JavaScript or You disabled JavaScript, Please enable those !{% endtrans %}</p>
                </div>
                <style>.uv-loader-view {display: none;}</style>
            </noscript>

            {% if uvdesk_service.requestHeadersSent() == false %}
                {% for flashMessage in app.session.flashbag.get('success') %}
                    <div class=\"uv-notification page-load uv-success\">
                        <span class=\"uv-notification-close\"></span>
                        <p>{{ flashMessage|raw }}</p>
                    </div>
                {% endfor %}
                
                {% for flashMessage in app.session.flashbag.get('warning') %}
                    <div class=\"uv-notification page-load uv-error\">
                        <span class=\"uv-notification-close\"></span>
                        <p>{{ flashMessage|raw }}</p>
                    </div>
                {% endfor %}
            {% endif %}
        </div>

        <div class=\"uv-pop-up-overlay\" id=\"confirm-modal\">
            <div class=\"uv-pop-up-box uv-pop-up-slim\">
                <span class=\"uv-pop-up-close\"></span>
                <h2>{{ 'Confirm Action'|trans }}</h2>
                <p>{{ 'Are you sure? You want to perform this action.'|trans }}</p>

                <div class=\"uv-pop-up-actions\">
                    <a href=\"#\" class=\"uv-btn uv-btn-error confirm\">{{ 'Confirm'|trans }}</a>
                    <a href=\"#\" class=\"uv-btn cancel\">{{ 'Cancel'|trans }}</a>
                </div>
            </div>
        </div>

        {% set currentUser = user_service.getSessionUser() %}
        {% if currentUser is not empty %}
            {% set currentUserDetails = currentUser.getAgentInstance().getPartialDetails() %}
        {% endif %}

        {% block sidebar %}
            {% if currentUser is defined and currentUser is not empty %}
                {% include \"@UVDeskCoreFramework/Templates/sidebar.html.twig\" %}
            {% endif %}
        {% endblock %}

        {% block pageWrapper %}
            <div class=\"uv-paper\">
                {% block pageHeader %}
                    {% include \"@UVDeskCoreFramework/Templates/header.html.twig\" %}
                {% endblock %}

                <div class=\"uv-wrapper\">
                    <div class=\"uv-container\">
                        {% block pageContent %}{% endblock %}
                    </div>
                </div>
            </div>
        {% endblock %}
        
        {% block footer %}
            {% include \"@UVDeskCoreFramework/Templates/pagination.html.twig\" %}

            {# Confirm Action Dialog #}
            <div class=\"uv-pop-up-overlay\" id=\"confirm-modal\">
                <div class=\"uv-pop-up-box uv-pop-up-slim\">
                    <span class=\"uv-pop-up-close\"></span>
                    <h2>{{ 'Confirm Action'|trans }}</h2>
                    <p>{{ 'Are you sure? You want to perform this action.'|trans }}</p>

                    <div class=\"uv-pop-up-actions\">
                        <a href=\"#\" class=\"uv-btn uv-btn-error confirm\">{{ 'Confirm'|trans }}</a>
                        <a href=\"#\" class=\"uv-btn cancel\">{{ 'Cancel'|trans }}</a>
                    </div>
                </div>
            </div>

            {# Loader Template #}
            <script type=\"text/template\" id=\"loader-tmp\">
                <div class=\"uv-loader\">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </script>

            {# Full View Loader Template #}
            <script type=\"text/template\" id=\"full-view-loader\">
                <div class=\"uv-loader-view\">
                    <div class=\"uv-loader\">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </script>

            {# Notification Template #}
            <script type=\"text/template\" id=\"notification-template\">
                <div class=\"uv-notification <% if(alertClass == 'danger') { %>uv-error<% } else { %> <%= 'uv-' + alertClass %> <% } %>\">
                    <span class=\"uv-notification-close\"></span>
                    <p><%= alertMessage %> </p>
                </div>
            </script>

            <script type=\"text/javascript\">
                var warningResponse = {
                    'alertClass' : 'danger',
                    'alertMessage' : '{{ \"Error : Something went wrong, please try again later\"|trans }}',
                };
            </script>

        {% endblock %}

        {# Custom Javascript #}
        {% for javascript in uvdesk_extensibles.getRegisteredComponent('Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\Dashboard').getDashboardTemplate().getJavascriptResources() %}
            <script src=\"{{ asset(javascript) }}\" type=\"text/javascript\"></script>
        {% endfor %}
    </body>
</html>", "@UVDeskCoreFramework/Templates/layout.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/Templates/layout.html.twig");
    }
}
