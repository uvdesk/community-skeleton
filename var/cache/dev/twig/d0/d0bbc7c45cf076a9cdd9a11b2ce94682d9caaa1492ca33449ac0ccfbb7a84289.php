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

/* @UVDeskSupportCenter/Templates/layout.html.twig */
class __TwigTemplate_867924705a78bc519d3623399e60957be0c9bbb1406290defbb4bec8e9c764b6 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'canonical' => [$this, 'block_canonical'],
            'title' => [$this, 'block_title'],
            'metaDescription' => [$this, 'block_metaDescription'],
            'metaKeywords' => [$this, 'block_metaKeywords'],
            'ogtitle' => [$this, 'block_ogtitle'],
            'ogcanonical' => [$this, 'block_ogcanonical'],
            'twtitle' => [$this, 'block_twtitle'],
            'head' => [$this, 'block_head'],
            'templateCSS' => [$this, 'block_templateCSS'],
            'header' => [$this, 'block_header'],
            'tabHeader' => [$this, 'block_tabHeader'],
            'wrapper' => [$this, 'block_wrapper'],
            'body' => [$this, 'block_body'],
            'footer' => [$this, 'block_footer'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Templates/layout.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Templates/layout.html.twig"));

        // line 1
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html lang=\"";
        // line 2
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 2, $this->source); })()), "request", [], "any", false, false, false, 2), "getLocale", [], "method", false, false, false, 2), "html", null, true);
        echo "\">
    <head>
        <link rel=\"stylesheet\" href=\"";
        // line 4
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdesksupportcenter/css/knowledgebase.css"), "html", null, true);
        echo "\">
        
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/backbone.validation/0.11.5/backbone-validation-min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/backbone.paginator/2.0.8/backbone.paginator.min.js\"></script>
        
        <script src = \"";
        // line 12
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdesksupportcenter/js/common.js"), "html", null, true);
        echo "\"></script>
        <script src = \"";
        // line 13
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdesksupportcenter/js/uikit.front.js"), "html", null, true);
        echo "\"></script>
        <script src = \"";
        // line 14
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdeskcoreframework/js/dropdown.js"), "html", null, true);
        echo "\"></script>

        ";
        // line 16
        $context["websiteDetails"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 16, $this->source); })()), "getWebsiteDetails", [0 => "knowledgebase"], "method", false, false, false, 16);
        // line 17
        echo "        ";
        $context["websiteConfiguration"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 17, $this->source); })()), "getWebsiteConfiguration", [0 => "knowledgebase"], "method", false, false, false, 17);
        // line 18
        echo "        ";
        $context["themeTemplate"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 18, $this->source); })()), "getWebsiteView", [], "method", false, false, false, 18);
        // line 19
        echo "
        ";
        // line 20
        $context["canonical"] = (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 20, $this->source); })()), "request", [], "any", false, false, false, 20), "server", [], "any", false, false, false, 20), "get", [0 => "REQUEST_SCHEME"], "method", false, false, false, 20) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 20, $this->source); })()), "request", [], "any", false, false, false, 20), "server", [], "any", false, false, false, 20), "get", [0 => "HTTP_HOST"], "method", false, false, false, 20)) . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 20, $this->source); })()), "request", [], "any", false, false, false, 20), "server", [], "any", false, false, false, 20), "get", [0 => "PATH_INFO"], "method", false, false, false, 20));
        // line 21
        echo "        <link rel=\"canonical\" href=\"";
        $this->displayBlock('canonical', $context, $blocks);
        echo "\">

        ";
        // line 23
        if (((isset($context["websiteDetails"]) || array_key_exists("websiteDetails", $context) ? $context["websiteDetails"] : (function () { throw new RuntimeError('Variable "websiteDetails" does not exist.', 23, $this->source); })()) && twig_get_attribute($this->env, $this->source, (isset($context["websiteDetails"]) || array_key_exists("websiteDetails", $context) ? $context["websiteDetails"] : (function () { throw new RuntimeError('Variable "websiteDetails" does not exist.', 23, $this->source); })()), "favicon", [], "any", false, false, false, 23))) {
            // line 24
            echo "            <link rel=\"icon\" sizes=\"16x16\" href=\"";
            ((twig_get_attribute($this->env, $this->source, (isset($context["websiteDetails"]) || array_key_exists("websiteDetails", $context) ? $context["websiteDetails"] : (function () { throw new RuntimeError('Variable "websiteDetails" does not exist.', 24, $this->source); })()), "favicon", [], "any", false, false, false, 24)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["websiteDetails"]) || array_key_exists("websiteDetails", $context) ? $context["websiteDetails"] : (function () { throw new RuntimeError('Variable "websiteDetails" does not exist.', 24, $this->source); })()), "favicon", [], "any", false, false, false, 24), "html", null, true))) : (print (null)));
            echo "\" />
        ";
        } else {
            // line 26
            echo "            <link rel=\"icon\" sizes=\"16x16\" href=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("favicon.ico"), "html", null, true);
            echo "\" />
        ";
        }
        // line 28
        echo "
        ";
        // line 29
        if ((isset($context["websiteDetails"]) || array_key_exists("websiteDetails", $context) ? $context["websiteDetails"] : (function () { throw new RuntimeError('Variable "websiteDetails" does not exist.', 29, $this->source); })())) {
            // line 30
            echo "            <title>";
            $this->displayBlock('title', $context, $blocks);
            echo "</title>
            ";
            // line 31
            if (twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 31, $this->source); })()), "metaDescription", [], "any", false, false, false, 31)) {
                // line 32
                echo "                <meta name=\"description\" content=\"";
                $this->displayBlock('metaDescription', $context, $blocks);
                echo "\"/>
            ";
            }
            // line 34
            echo "            ";
            if (twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 34, $this->source); })()), "metaKeywords", [], "any", false, false, false, 34)) {
                // line 35
                echo "                <meta name=\"keywords\" content=\"";
                $this->displayBlock('metaKeywords', $context, $blocks);
                echo "\"/>
            ";
            }
            // line 37
            echo "
            <meta http-equiv=\"Content-Type\" content=\"text/html;\" charset=\"";
            // line 38
            echo twig_escape_filter($this->env, $this->env->getCharset(), "html", null, true);
            echo "\"/>
            <meta name=\"robots\" content=\"INDEX,FOLLOW\" />
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">

            <meta property=\"og:locale\" content=\"";
            // line 42
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 42, $this->source); })()), "request", [], "any", false, false, false, 42), "getLocale", [], "method", false, false, false, 42), "html", null, true);
            echo "\" />
            <meta property=\"og:type\" content=\"article\" />
            <meta property=\"og:title\" content=\"";
            // line 44
            $this->displayBlock('ogtitle', $context, $blocks);
            echo "\" />
            <meta property=\"og:url\" content=\"";
            // line 45
            $this->displayBlock('ogcanonical', $context, $blocks);
            echo "\" />
            <meta property=\"og:site_name\" content=\"";
            // line 46
            echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["websiteDetails"]) || array_key_exists("websiteDetails", $context) ? $context["websiteDetails"] : (function () { throw new RuntimeError('Variable "websiteDetails" does not exist.', 46, $this->source); })()), "name", [], "any", false, false, false, 46)) ? (twig_get_attribute($this->env, $this->source, (isset($context["websiteDetails"]) || array_key_exists("websiteDetails", $context) ? $context["websiteDetails"] : (function () { throw new RuntimeError('Variable "websiteDetails" does not exist.', 46, $this->source); })()), "name", [], "any", false, false, false, 46)) : ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Knowledge Base"))), "html", null, true);
            echo "\" />
            ";
            // line 47
            if (twig_get_attribute($this->env, $this->source, (isset($context["websiteDetails"]) || array_key_exists("websiteDetails", $context) ? $context["websiteDetails"] : (function () { throw new RuntimeError('Variable "websiteDetails" does not exist.', 47, $this->source); })()), "logo", [], "any", false, false, false, 47)) {
                // line 48
                echo "                <meta property=\"og:image\" content=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["websiteDetails"]) || array_key_exists("websiteDetails", $context) ? $context["websiteDetails"] : (function () { throw new RuntimeError('Variable "websiteDetails" does not exist.', 48, $this->source); })()), "logo", [], "any", false, false, false, 48), "html", null, true);
                echo "\" />
            ";
            }
            // line 50
            echo "            <meta name=\"twitter:card\" content=\"summary\" />
            <meta name=\"twitter:title\" content=\"";
            // line 51
            $this->displayBlock('twtitle', $context, $blocks);
            echo "\" />

            <link rel='dns-prefetch' href='//www.google.com' />
            <link rel='dns-prefetch' href='//fonts.googleapis.com' />
            <link rel='dns-prefetch' href='//fonts.gstatic.com' />
            <link rel='dns-prefetch' href='//cdn.uvdesk.com' />
        ";
        }
        // line 58
        echo "
        ";
        // line 59
        if ((isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 59, $this->source); })())) {
            // line 60
            echo "            ";
            $this->displayBlock('head', $context, $blocks);
            // line 63
            echo "        ";
        }
        // line 64
        echo "
        ";
        // line 65
        if ((isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 65, $this->source); })())) {
            // line 66
            echo "            ";
            if (twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_service"]) || array_key_exists("uvdesk_service", $context) ? $context["uvdesk_service"] : (function () { throw new RuntimeError('Variable "uvdesk_service" does not exist.', 66, $this->source); })()), "isDarkSkin", [0 => twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 66, $this->source); })()), "brandColor", [], "any", false, false, false, 66)], "method", false, false, false, 66)) {
                // line 67
                echo "                ";
                $this->loadTemplate("@UVDeskSupportCenter/Knowledgebase/darkSkin.html.twig", "@UVDeskSupportCenter/Templates/layout.html.twig", 67)->display($context);
                // line 68
                echo "            ";
            } else {
                // line 69
                echo "                ";
                $this->loadTemplate("@UVDeskSupportCenter/Knowledgebase/lightSkin.html.twig", "@UVDeskSupportCenter/Templates/layout.html.twig", 69)->display($context);
                // line 70
                echo "            ";
            }
            // line 71
            echo "        ";
        }
        // line 72
        echo "
        ";
        // line 73
        $this->displayBlock('templateCSS', $context, $blocks);
        // line 74
        echo "    </head>

    ";
        // line 76
        $context["bodyClass"] = "";
        // line 77
        echo "    ";
        $context["bodySkinClass"] = "";
        // line 78
        echo "   
    <body class=\"";
        // line 79
        echo twig_escape_filter($this->env, (((isset($context["bodySkinClass"]) || array_key_exists("bodySkinClass", $context) ? $context["bodySkinClass"] : (function () { throw new RuntimeError('Variable "bodySkinClass" does not exist.', 79, $this->source); })()) . " ") . (isset($context["bodyClass"]) || array_key_exists("bodyClass", $context) ? $context["bodyClass"] : (function () { throw new RuntimeError('Variable "bodyClass" does not exist.', 79, $this->source); })())), "html", null, true);
        echo "\">
        ";
        // line 80
        $context["broadcastMessage"] = twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_service"]) || array_key_exists("uvdesk_service", $context) ? $context["uvdesk_service"] : (function () { throw new RuntimeError('Variable "uvdesk_service" does not exist.', 80, $this->source); })()), "getValidBroadcastMessage", [0 => ((twig_get_attribute($this->env, $this->source, ($context["websiteConfiguration"] ?? null), "broadcastMessage", [], "any", true, true, false, 80)) ? (twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 80, $this->source); })()), "broadcastMessage", [], "any", false, false, false, 80)) : (""))], "method", false, false, false, 80);
        // line 81
        echo "        ";
        if ((isset($context["broadcastMessage"]) || array_key_exists("broadcastMessage", $context) ? $context["broadcastMessage"] : (function () { throw new RuntimeError('Variable "broadcastMessage" does not exist.', 81, $this->source); })())) {
            // line 82
            echo "            <div class=\"uv-kb-info\" id=\"uv-kb-info-broadcast\">
                <p>";
            // line 83
            ((twig_get_attribute($this->env, $this->source, ($context["broadcastMessage"] ?? null), "message", [], "any", true, true, false, 83)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["broadcastMessage"]) || array_key_exists("broadcastMessage", $context) ? $context["broadcastMessage"] : (function () { throw new RuntimeError('Variable "broadcastMessage" does not exist.', 83, $this->source); })()), "message", [], "any", false, false, false, 83), "html", null, true))) : (print ("")));
            echo "</p>
                <span class=\"uv-kb-info-remove\" onclick=\"document.getElementById('uv-kb-info-broadcast').remove()\"></span>
            </div>
        ";
        }
        // line 87
        echo "
        <div class=\"uv-notifications-wrapper\">
            ";
        // line 89
        if ((twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_service"]) || array_key_exists("uvdesk_service", $context) ? $context["uvdesk_service"] : (function () { throw new RuntimeError('Variable "uvdesk_service" does not exist.', 89, $this->source); })()), "requestHeadersSent", [], "method", false, false, false, 89) == false)) {
            // line 90
            echo "                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 90, $this->source); })()), "session", [], "any", false, false, false, 90), "flashbag", [], "any", false, false, false, 90), "get", [0 => "success"], "method", false, false, false, 90));
            foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
                // line 91
                echo "                    <div class=\"uv-notification page-load uv-success\">
                        <span class=\"uv-notification-close\"></span>
                        <p>";
                // line 93
                echo $context["flashMessage"];
                echo "</p>
                    </div>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 96
            echo "                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 96, $this->source); })()), "session", [], "any", false, false, false, 96), "flashbag", [], "any", false, false, false, 96), "get", [0 => "warning"], "method", false, false, false, 96));
            foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
                // line 97
                echo "                    <div class=\"uv-notification page-load uv-error\">
                        <span class=\"uv-notification-close\"></span>
                        <p>";
                // line 99
                echo $context["flashMessage"];
                echo "</p>
                    </div>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 102
            echo "            ";
        }
        // line 103
        echo "            
            <noscript>
                <div class=\"uv-notification uv-error\">
                    <p>";
        // line 106
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Your browser does not support JavaScript or You disabled JavaScript, Please enable those !", [], "messages");
        echo "</p>
                </div>
                <style>.uv-loader-view {display: none;}</style>
            </noscript>
        </div>


        ";
        // line 113
        $this->displayBlock('header', $context, $blocks);
        // line 117
        echo "
        ";
        // line 118
        $this->loadTemplate("@UVDeskSupportCenter/Templates/breadcrumbs.html.twig", "@UVDeskSupportCenter/Templates/layout.html.twig", 118)->display($context);
        // line 119
        echo "
        ";
        // line 120
        $this->displayBlock('tabHeader', $context, $blocks);
        // line 122
        echo "        ";
        $this->displayBlock('wrapper', $context, $blocks);
        // line 149
        echo "
        ";
        // line 150
        $this->displayBlock('footer', $context, $blocks);
        // line 193
        echo "    </body>
</html>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 21
    public function block_canonical($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "canonical"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "canonical"));

        echo twig_escape_filter($this->env, (isset($context["canonical"]) || array_key_exists("canonical", $context) ? $context["canonical"] : (function () { throw new RuntimeError('Variable "canonical" does not exist.', 21, $this->source); })()), "html", null, true);
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 30
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("HelpDesk", [], "messages");
        echo " ";
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["websiteDetails"]) || array_key_exists("websiteDetails", $context) ? $context["websiteDetails"] : (function () { throw new RuntimeError('Variable "websiteDetails" does not exist.', 30, $this->source); })()), "name", [], "any", false, false, false, 30)) ? (twig_get_attribute($this->env, $this->source, (isset($context["websiteDetails"]) || array_key_exists("websiteDetails", $context) ? $context["websiteDetails"] : (function () { throw new RuntimeError('Variable "websiteDetails" does not exist.', 30, $this->source); })()), "name", [], "any", false, false, false, 30)) : ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Knowledge Base"))), "html", null, true);
        echo " ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 32
    public function block_metaDescription($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "metaDescription"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "metaDescription"));

        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 32, $this->source); })()), "metaDescription", [], "any", false, false, false, 32), "html", null, true);
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 35
    public function block_metaKeywords($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "metaKeywords"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "metaKeywords"));

        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 35, $this->source); })()), "metaKeywords", [], "any", false, false, false, 35), "html", null, true);
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 44
    public function block_ogtitle($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "ogtitle"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "ogtitle"));

        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("HelpDesk", [], "messages");
        echo " ";
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["websiteDetails"]) || array_key_exists("websiteDetails", $context) ? $context["websiteDetails"] : (function () { throw new RuntimeError('Variable "websiteDetails" does not exist.', 44, $this->source); })()), "name", [], "any", false, false, false, 44)) ? (twig_get_attribute($this->env, $this->source, (isset($context["websiteDetails"]) || array_key_exists("websiteDetails", $context) ? $context["websiteDetails"] : (function () { throw new RuntimeError('Variable "websiteDetails" does not exist.', 44, $this->source); })()), "name", [], "any", false, false, false, 44)) : ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Knowledge Base"))), "html", null, true);
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 45
    public function block_ogcanonical($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "ogcanonical"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "ogcanonical"));

        echo twig_escape_filter($this->env, (isset($context["canonical"]) || array_key_exists("canonical", $context) ? $context["canonical"] : (function () { throw new RuntimeError('Variable "canonical" does not exist.', 45, $this->source); })()), "html", null, true);
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 51
    public function block_twtitle($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "twtitle"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "twtitle"));

        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("HelpDesk", [], "messages");
        echo " ";
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["websiteDetails"]) || array_key_exists("websiteDetails", $context) ? $context["websiteDetails"] : (function () { throw new RuntimeError('Variable "websiteDetails" does not exist.', 51, $this->source); })()), "name", [], "any", false, false, false, 51)) ? (twig_get_attribute($this->env, $this->source, (isset($context["websiteDetails"]) || array_key_exists("websiteDetails", $context) ? $context["websiteDetails"] : (function () { throw new RuntimeError('Variable "websiteDetails" does not exist.', 51, $this->source); })()), "name", [], "any", false, false, false, 51)) : ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Knowledge Base"))), "html", null, true);
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 60
    public function block_head($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "head"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "head"));

        // line 61
        echo "                ";
        $this->loadTemplate("@UVDeskSupportCenter/Knowledgebase/websiteSettings.html.twig", "@UVDeskSupportCenter/Templates/layout.html.twig", 61)->display($context);
        // line 62
        echo "            ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 73
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

    // line 113
    public function block_header($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "header"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "header"));

        // line 114
        echo "         
            ";
        // line 115
        $this->loadTemplate("@UVDeskSupportCenter/Templates/header.html.twig", "@UVDeskSupportCenter/Templates/layout.html.twig", 115)->display($context);
        // line 116
        echo "        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 120
    public function block_tabHeader($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "tabHeader"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "tabHeader"));

        // line 121
        echo "        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 122
    public function block_wrapper($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "wrapper"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "wrapper"));

        // line 123
        echo "            <div class=\"uv-body\">
                <div class=\"uv-container\">
                    ";
        // line 125
        $this->displayBlock('body', $context, $blocks);
        // line 147
        echo "            </div>
        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 125
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 126
        echo "                        <div class=\"uv-cta-wrapper\">
                            <div class=\"uv-cta-lt\">
                                <svg
                                xmlns=\"http://www.w3.org/2000/svg\"
                                xmlns:xlink=\"http://www.w3.org/1999/xlink\"
                                width=\"60px\" height=\"60px\">
                                <path fill-rule=\"evenodd\"  fill=\"rgb(124, 116, 241)\"
                                d=\"M57.000,12.000 L51.000,12.000 L50.984,38.993 L12.000,39.000 L12.000,45.000 C12.000,46.649 13.351,48.000 15.000,48.000 L48.000,48.000 L60.000,60.000 L60.000,15.000 C60.000,13.351 58.649,12.000 57.000,12.000 ZM45.000,30.000 L45.000,3.000 C45.000,1.351 43.649,0.000 42.000,0.000 L3.000,0.000 C1.351,0.000 -0.000,1.351 -0.000,3.000 L-0.000,45.000 L12.000,33.000 L42.000,33.000 C43.649,33.000 45.000,31.649 45.000,30.000 Z\"/>
                                </svg>
                            </div>
                            <div class=\"uv-cta-rt\">
                                <h2>";
        // line 137
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Unable to find an answer?"), "html", null, true);
        echo "</h2>
                                <p>";
        // line 138
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Looking for anything specific article which resides in general queries? Just browse the various relevant folders and categories and then you will find the desired article."), "html", null, true);
        echo "
                                </p>
            \t\t\t\t\t";
        // line 140
        if (((isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context)) && twig_get_attribute($this->env, $this->source, ($context["websiteConfiguration"] ?? null), "ticketCreateOption", [], "any", true, true, false, 140))) {
            // line 141
            echo "                                    <a href=\"";
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_create_ticket");
            echo "\" class=\"uv-btn uv-margin-top-15\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Contact Us"), "html", null, true);
            echo "</a>
                                ";
        }
        // line 143
        echo "                            </div>
                        </div>
                    </div>
                ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 150
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 151
        echo "            ";
        $this->loadTemplate("@UVDeskSupportCenter/Templates/footer.html.twig", "@UVDeskSupportCenter/Templates/layout.html.twig", 151)->display($context);
        // line 152
        echo "
            ";
        // line 153
        $this->loadTemplate("@UVDeskSupportCenter/Templates/pagination.html.twig", "@UVDeskSupportCenter/Templates/layout.html.twig", 153)->display($context);
        // line 154
        echo "
            <!-- Loader Template-->
            <script type=\"text/template\" id=\"loader-tmp\">
                <div class=\"uv-loader\">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </script>
            <!-- Loader Template-->

            <!-- Full View Loader Template-->
            <script type=\"text/template\" id=\"full-view-loader\">
                <div class=\"uv-loader-view\">
                    <div class=\"uv-loader\">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </script>
            <!-- //Full View Loader Template-->

            <!-- Notification Template -->
            <script type=\"text/template\" id=\"notification-template\">
                <div class=\"uv-notification <% if(alertClass == 'danger') { %>uv-error<% } else { %> <%= 'uv-' + alertClass %> <% } %>\">
                    <span class=\"uv-notification-close\"></span>
                    <p><%= alertMessage %> </p>
                </div>
            </script>
            <script type=\"text/javascript\">
                var warningResponse = {
                    'alertClass' : 'danger',
                    'alertMessage' : '";
        // line 187
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Error : Something went wrong, please try again later"), "html", null, true);
        echo "',
                };
            </script>

            ";
        // line 191
        $this->loadTemplate("@UVDeskSupportCenter/Themes/cookiePolicy.html.twig", "@UVDeskSupportCenter/Templates/layout.html.twig", 191)->display($context);
        // line 192
        echo "        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Templates/layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  729 => 192,  727 => 191,  720 => 187,  685 => 154,  683 => 153,  680 => 152,  677 => 151,  667 => 150,  654 => 143,  646 => 141,  644 => 140,  639 => 138,  635 => 137,  622 => 126,  612 => 125,  601 => 147,  599 => 125,  595 => 123,  585 => 122,  575 => 121,  565 => 120,  555 => 116,  553 => 115,  550 => 114,  540 => 113,  522 => 73,  512 => 62,  509 => 61,  499 => 60,  478 => 51,  459 => 45,  438 => 44,  419 => 35,  400 => 32,  378 => 30,  359 => 21,  347 => 193,  345 => 150,  342 => 149,  339 => 122,  337 => 120,  334 => 119,  332 => 118,  329 => 117,  327 => 113,  317 => 106,  312 => 103,  309 => 102,  300 => 99,  296 => 97,  291 => 96,  282 => 93,  278 => 91,  273 => 90,  271 => 89,  267 => 87,  260 => 83,  257 => 82,  254 => 81,  252 => 80,  248 => 79,  245 => 78,  242 => 77,  240 => 76,  236 => 74,  234 => 73,  231 => 72,  228 => 71,  225 => 70,  222 => 69,  219 => 68,  216 => 67,  213 => 66,  211 => 65,  208 => 64,  205 => 63,  202 => 60,  200 => 59,  197 => 58,  187 => 51,  184 => 50,  178 => 48,  176 => 47,  172 => 46,  168 => 45,  164 => 44,  159 => 42,  152 => 38,  149 => 37,  143 => 35,  140 => 34,  134 => 32,  132 => 31,  127 => 30,  125 => 29,  122 => 28,  116 => 26,  110 => 24,  108 => 23,  102 => 21,  100 => 20,  97 => 19,  94 => 18,  91 => 17,  89 => 16,  84 => 14,  80 => 13,  76 => 12,  65 => 4,  60 => 2,  57 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html lang=\"{{app.request.getLocale()}}\">
    <head>
        <link rel=\"stylesheet\" href=\"{{ asset('bundles/uvdesksupportcenter/css/knowledgebase.css') }}\">
        
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/backbone.validation/0.11.5/backbone-validation-min.js\"></script>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/backbone.paginator/2.0.8/backbone.paginator.min.js\"></script>
        
        <script src = \"{{ asset('bundles/uvdesksupportcenter/js/common.js') }}\"></script>
        <script src = \"{{ asset('bundles/uvdesksupportcenter/js/uikit.front.js') }}\"></script>
        <script src = \"{{ asset('bundles/uvdeskcoreframework/js/dropdown.js') }}\"></script>

        {% set websiteDetails = user_service.getWebsiteDetails('knowledgebase') %}
        {% set websiteConfiguration = user_service.getWebsiteConfiguration('knowledgebase') %}
        {% set themeTemplate = user_service.getWebsiteView() %}

        {% set canonical = app.request.server.get('REQUEST_SCHEME')~'://'~app.request.server.get('HTTP_HOST')~app.request.server.get('PATH_INFO') %}
        <link rel=\"canonical\" href=\"{% block canonical %}{{canonical}}{% endblock %}\">

        {% if websiteDetails and (websiteDetails.favicon) %}
            <link rel=\"icon\" sizes=\"16x16\" href=\"{{websiteDetails.favicon ? websiteDetails.favicon : null}}\" />
        {% else %}
            <link rel=\"icon\" sizes=\"16x16\" href=\"{{ asset('favicon.ico') }}\" />
        {% endif %}

        {% if websiteDetails %}
            <title>{% block title %}{% trans %}HelpDesk{% endtrans %} {{ websiteDetails.name ? websiteDetails.name : 'Knowledge Base'|trans }} {% endblock %}</title>
            {% if websiteConfiguration.metaDescription %}
                <meta name=\"description\" content=\"{% block metaDescription %}{{ websiteConfiguration.metaDescription }}{% endblock %}\"/>
            {% endif %}
            {% if websiteConfiguration.metaKeywords %}
                <meta name=\"keywords\" content=\"{% block metaKeywords %}{{ websiteConfiguration.metaKeywords }}{% endblock %}\"/>
            {% endif %}

            <meta http-equiv=\"Content-Type\" content=\"text/html;\" charset=\"{{ _charset }}\"/>
            <meta name=\"robots\" content=\"INDEX,FOLLOW\" />
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">

            <meta property=\"og:locale\" content=\"{{app.request.getLocale()}}\" />
            <meta property=\"og:type\" content=\"article\" />
            <meta property=\"og:title\" content=\"{% block ogtitle %}{% trans %}HelpDesk{% endtrans %} {{ websiteDetails.name ? websiteDetails.name : 'Knowledge Base'|trans }}{% endblock %}\" />
            <meta property=\"og:url\" content=\"{% block ogcanonical %}{{canonical}}{% endblock %}\" />
            <meta property=\"og:site_name\" content=\"{{ websiteDetails.name ? websiteDetails.name : 'Knowledge Base'|trans }}\" />
            {% if websiteDetails.logo %}
                <meta property=\"og:image\" content=\"{{ websiteDetails.logo }}\" />
            {% endif %}
            <meta name=\"twitter:card\" content=\"summary\" />
            <meta name=\"twitter:title\" content=\"{% block twtitle %}{% trans %}HelpDesk{% endtrans %} {{ websiteDetails.name ? websiteDetails.name : 'Knowledge Base'|trans }}{% endblock %}\" />

            <link rel='dns-prefetch' href='//www.google.com' />
            <link rel='dns-prefetch' href='//fonts.googleapis.com' />
            <link rel='dns-prefetch' href='//fonts.gstatic.com' />
            <link rel='dns-prefetch' href='//cdn.uvdesk.com' />
        {% endif %}

        {% if websiteConfiguration %}
            {% block head %}
                {% include \"@UVDeskSupportCenter/Knowledgebase/websiteSettings.html.twig\" %}
            {% endblock %}
        {% endif %}

        {% if websiteConfiguration %}
            {% if uvdesk_service.isDarkSkin(websiteConfiguration.brandColor) %}
                {% include '@UVDeskSupportCenter/Knowledgebase/darkSkin.html.twig' %}
            {% else %}
                {% include '@UVDeskSupportCenter/Knowledgebase/lightSkin.html.twig' %}
            {% endif %}
        {% endif %}

        {% block templateCSS %}{% endblock %}
    </head>

    {% set bodyClass = '' %}
    {% set bodySkinClass = '' %}
   
    <body class=\"{{ bodySkinClass ~ ' ' ~ bodyClass }}\">
        {% set broadcastMessage = uvdesk_service.getValidBroadcastMessage(websiteConfiguration.broadcastMessage is defined ? websiteConfiguration.broadcastMessage : '') %}
        {% if broadcastMessage %}
            <div class=\"uv-kb-info\" id=\"uv-kb-info-broadcast\">
                <p>{{ broadcastMessage.message is defined ? broadcastMessage.message : '' }}</p>
                <span class=\"uv-kb-info-remove\" onclick=\"document.getElementById('uv-kb-info-broadcast').remove()\"></span>
            </div>
        {% endif %}

        <div class=\"uv-notifications-wrapper\">
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
            
            <noscript>
                <div class=\"uv-notification uv-error\">
                    <p>{% trans %}Your browser does not support JavaScript or You disabled JavaScript, Please enable those !{% endtrans %}</p>
                </div>
                <style>.uv-loader-view {display: none;}</style>
            </noscript>
        </div>


        {% block header %}
         
            {% include \"@UVDeskSupportCenter/Templates/header.html.twig\" %}
        {% endblock %}

        {% include \"@UVDeskSupportCenter/Templates/breadcrumbs.html.twig\" %}

        {% block tabHeader %}
        {% endblock %}
        {% block wrapper %}
            <div class=\"uv-body\">
                <div class=\"uv-container\">
                    {% block body %}
                        <div class=\"uv-cta-wrapper\">
                            <div class=\"uv-cta-lt\">
                                <svg
                                xmlns=\"http://www.w3.org/2000/svg\"
                                xmlns:xlink=\"http://www.w3.org/1999/xlink\"
                                width=\"60px\" height=\"60px\">
                                <path fill-rule=\"evenodd\"  fill=\"rgb(124, 116, 241)\"
                                d=\"M57.000,12.000 L51.000,12.000 L50.984,38.993 L12.000,39.000 L12.000,45.000 C12.000,46.649 13.351,48.000 15.000,48.000 L48.000,48.000 L60.000,60.000 L60.000,15.000 C60.000,13.351 58.649,12.000 57.000,12.000 ZM45.000,30.000 L45.000,3.000 C45.000,1.351 43.649,0.000 42.000,0.000 L3.000,0.000 C1.351,0.000 -0.000,1.351 -0.000,3.000 L-0.000,45.000 L12.000,33.000 L42.000,33.000 C43.649,33.000 45.000,31.649 45.000,30.000 Z\"/>
                                </svg>
                            </div>
                            <div class=\"uv-cta-rt\">
                                <h2>{{\"Unable to find an answer?\"|trans}}</h2>
                                <p>{{\"Looking for anything specific article which resides in general queries? Just browse the various relevant folders and categories and then you will find the desired article.\"|trans}}
                                </p>
            \t\t\t\t\t{% if websiteConfiguration is defined and websiteConfiguration.ticketCreateOption is defined %}
                                    <a href=\"{{ path('helpdesk_customer_create_ticket') }}\" class=\"uv-btn uv-margin-top-15\">{{'Contact Us'|trans}}</a>
                                {% endif %}
                            </div>
                        </div>
                    </div>
                {% endblock %}
            </div>
        {% endblock %}

        {% block footer %}
            {% include \"@UVDeskSupportCenter/Templates/footer.html.twig\" %}

            {% include \"@UVDeskSupportCenter/Templates/pagination.html.twig\" %}

            <!-- Loader Template-->
            <script type=\"text/template\" id=\"loader-tmp\">
                <div class=\"uv-loader\">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </script>
            <!-- Loader Template-->

            <!-- Full View Loader Template-->
            <script type=\"text/template\" id=\"full-view-loader\">
                <div class=\"uv-loader-view\">
                    <div class=\"uv-loader\">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </script>
            <!-- //Full View Loader Template-->

            <!-- Notification Template -->
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

            {% include('@UVDeskSupportCenter/Themes/cookiePolicy.html.twig') %}
        {% endblock %}
    </body>
</html>
", "@UVDeskSupportCenter/Templates/layout.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Templates/layout.html.twig");
    }
}
