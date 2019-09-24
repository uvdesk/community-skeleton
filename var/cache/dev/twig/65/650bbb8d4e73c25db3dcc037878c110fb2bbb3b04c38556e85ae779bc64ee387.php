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

/* @UVDeskCoreFramework/savedReplyForm.html.twig */
class __TwigTemplate_6b7088856048bb5432364f24ddcc4006f09ae25e4098f39dc089dffbe18b8bed extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/savedReplyForm.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/savedReplyForm.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskCoreFramework/savedReplyForm.html.twig", 1);
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

        echo " 
    ";
        // line 4
        if (twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 4, $this->source); })()), "id", [], "any", false, false, false, 4)) {
            // line 5
            echo "\t\t";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit Saved Reply"), "html", null, true);
            echo "
\t";
        } else {
            // line 7
            echo "\t\t";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Save Reply"), "html", null, true);
            echo "
\t";
        }
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 11
    public function block_pageContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        // line 12
        echo "\t<div class=\"uv-inner-section\">
\t\t";
        // line 14
        echo "\t\t";
        $context["asideTemplate"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\AsideTemplate";
        // line 15
        echo "\t\t";
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Productivity";
        // line 16
        echo "
\t\t";
        // line 17
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 17, $this->source); })()), "getRegisteredComponent", [0 => (isset($context["asideTemplate"]) || array_key_exists("asideTemplate", $context) ? $context["asideTemplate"] : (function () { throw new RuntimeError('Variable "asideTemplate" does not exist.', 17, $this->source); })())], "method", false, false, false, 17), "renderSidebar", [0 => (isset($context["asideSidebarReference"]) || array_key_exists("asideSidebarReference", $context) ? $context["asideSidebarReference"] : (function () { throw new RuntimeError('Variable "asideSidebarReference" does not exist.', 17, $this->source); })())], "method", false, false, false, 17);
        echo "
\t\t
\t\t<div class=\"uv-view ";
        // line 19
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 19, $this->source); })()), "request", [], "any", false, false, false, 19), "cookies", [], "any", false, false, false, 19) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 19, $this->source); })()), "request", [], "any", false, false, false, 19), "cookies", [], "any", false, false, false, 19), "get", [0 => "uv-asideView"], "method", false, false, false, 19))) {
            echo "uv-aside-view";
        }
        echo "\">
\t\t\t<h1>
\t\t\t\t";
        // line 21
        if (twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 21, $this->source); })()), "id", [], "any", false, false, false, 21)) {
            // line 22
            echo "                    ";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit Saved Reply"), "html", null, true);
            echo "
                ";
        } else {
            // line 24
            echo "                    ";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Save Reply"), "html", null, true);
            echo "
                ";
        }
        // line 26
        echo "\t\t\t</h1>
\t\t\t
\t\t\t<!--Form-->
\t\t\t<form method=\"post\" action=\"\" id=\"saved-reply-form\">
\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 32
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Name"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<input type=\"text\" name=\"name\" class=\"uv-field\" value=\"";
        // line 34
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 34, $this->source); })()), "name", [], "any", false, false, false, 34), "html", null, true);
        echo "\" />
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 36
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Saved reply name"), "html", null, true);
        echo "</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t";
        // line 40
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 40, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_ADMIN"], "method", false, false, false, 40)) {
            // line 41
            echo "\t\t\t\t\t<!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label class=\"uv-field-label\">";
            // line 43
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Groups"), "html", null, true);
            echo "</label>
\t\t\t\t\t\t<div class=\"uv-field-block\" id=\"group-filter\">
\t\t\t\t\t\t\t<input type=\"hidden\" name=\"tempGroups\" class=\"uv-field\" value=\"\" />
\t\t\t\t\t\t\t<input name=\"groups\" class=\"uv-field uv-dropdown-other preloaded\" type=\"text\" id=\"group-filter-input\">
                            <span class=\"uv-field-info\">";
            // line 47
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Share saved reply with user(s) in these group(s)"), "html", null, true);
            echo "</span>
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>";
            // line 50
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Filter With"), "html", null, true);
            echo "</label>
\t\t\t\t\t\t\t\t\t<ul class=\"\">
\t\t\t\t\t\t\t\t\t\t";
            // line 52
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 52, $this->source); })()), "getSupportGroups", [], "method", false, false, false, 52));
            foreach ($context['_seq'] as $context["_key"] => $context["group"]) {
                // line 53
                echo "\t\t\t\t\t\t\t\t\t\t\t<li data-id=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["group"], "id", [], "any", false, false, false, 53), "html", null, true);
                echo "\">
\t\t\t\t\t\t\t\t\t\t\t\t";
                // line 54
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["group"], "name", [], "any", false, false, false, 54), "html", null, true);
                echo "
\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['group'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 57
            echo "\t\t\t\t\t\t\t\t\t\t<li class=\"uv-no-results\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t\t";
            // line 58
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("No result found"), "html", null, true);
            echo "
\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"uv-filtered-tags\">
\t\t\t\t\t\t\t\t";
            // line 64
            if (twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 64, $this->source); })()), "getSupportGroups", [], "any", false, false, false, 64)) {
                // line 65
                echo "\t\t\t\t\t\t\t\t\t";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 65, $this->source); })()), "getSupportGroups", [], "method", false, false, false, 65));
                foreach ($context['_seq'] as $context["_key"] => $context["group"]) {
                    // line 66
                    echo "\t\t\t\t\t\t\t\t\t\t";
                    if (twig_get_attribute($this->env, $this->source, $context["group"], "isActive", [], "any", false, false, false, 66)) {
                        // line 67
                        echo "\t\t\t\t\t\t\t\t\t\t\t<a class=\"uv-btn-small default\" href=\"#\" data-id=\"";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["group"], "id", [], "any", false, false, false, 67), "html", null, true);
                        echo "\">
\t\t\t\t\t\t\t\t\t\t\t\t";
                        // line 68
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["group"], "name", [], "any", false, false, false, 68), "html", null, true);
                        echo "
\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"uv-icon-remove\"></span>
\t\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t\t";
                    }
                    // line 72
                    echo "\t\t\t\t\t\t\t\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['group'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 73
                echo "\t\t\t\t\t\t\t\t";
            }
            // line 74
            echo "\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t<!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label class=\"uv-field-label\">";
            // line 81
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Teams"), "html", null, true);
            echo "</label>
\t\t\t\t\t\t<div class=\"uv-field-block\" id=\"team-filter\">
\t\t\t\t\t\t\t<input type=\"hidden\" name=\"tempTeams\" class=\"uv-field\" value=\"\" />
\t\t\t\t\t\t\t<input class=\"uv-field uv-dropdown-other preloaded\" type=\"text\" id=\"team-filter-input\">
                            <span class=\"uv-field-info\">";
            // line 85
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Share saved reply with user(s) in these teams(s)"), "html", null, true);
            echo "</span>
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>";
            // line 88
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Filter With"), "html", null, true);
            echo "</label>
\t\t\t\t\t\t\t\t\t<ul class=\"\">
\t\t\t\t\t\t\t\t\t\t";
            // line 90
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 90, $this->source); })()), "getSupportTeams", [], "method", false, false, false, 90));
            foreach ($context['_seq'] as $context["_key"] => $context["team"]) {
                // line 91
                echo "\t\t\t\t\t\t\t\t\t\t\t<li data-id=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "id", [], "any", false, false, false, 91), "html", null, true);
                echo "\">
\t\t\t\t\t\t\t\t\t\t\t\t";
                // line 92
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "name", [], "any", false, false, false, 92), "html", null, true);
                echo "
\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['team'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 95
            echo "\t\t\t\t\t\t\t\t\t\t<li class=\"uv-no-results\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t\t";
            // line 96
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("No result found"), "html", null, true);
            echo "
\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"uv-filtered-tags\">
\t\t\t\t\t\t\t\t";
            // line 102
            if (twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 102, $this->source); })()), "getSupportTeams", [], "method", false, false, false, 102)) {
                // line 103
                echo "\t\t\t\t\t\t\t\t\t";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 103, $this->source); })()), "getSupportTeams", [], "method", false, false, false, 103));
                foreach ($context['_seq'] as $context["_key"] => $context["team"]) {
                    // line 104
                    echo "\t\t\t\t\t\t\t\t\t\t";
                    if (twig_get_attribute($this->env, $this->source, $context["team"], "isActive", [], "any", false, false, false, 104)) {
                        // line 105
                        echo "\t\t\t\t\t\t\t\t\t\t\t<a class=\"uv-btn-small default\" href=\"#\" data-id=\"";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "id", [], "any", false, false, false, 105), "html", null, true);
                        echo "\">
\t\t\t\t\t\t\t\t\t\t\t\t";
                        // line 106
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "name", [], "any", false, false, false, 106), "html", null, true);
                        echo "
\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"uv-icon-remove\"></span>
\t\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t\t";
                    }
                    // line 110
                    echo "\t\t\t\t\t\t\t\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['team'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 111
                echo "\t\t\t\t\t\t\t\t";
            }
            // line 112
            echo "\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->
\t\t\t\t";
        }
        // line 117
        echo "\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-margin-right-15\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 119
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Body"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block uv-margin-top-5\">
\t\t\t\t\t\t<textarea id=\"message\" name=\"message\" class=\"uv-field\">
\t\t\t\t\t\t\t";
        // line 122
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 122, $this->source); })()), "message", [], "any", false, false, false, 122), "html", null, true);
        echo "
\t\t\t\t\t\t</textarea>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info  uv-margin-top-5\">";
        // line 125
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Saved reply Body"), "html", null, true);
        echo "</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!--CTA-->
\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"";
        // line 130
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"submit\">
\t\t\t\t<!--//CTA-->
\t\t\t</form>
\t\t\t<!--//Form-->
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 137
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 138
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
\t  ";
        // line 139
        echo twig_include($this->env, $context, "@UVDeskCoreFramework/Templates/tinyMCE.html.twig");
        echo "
    <script>
\t\tvar toolbarOptions = sfTinyMce.options.toolbar;
        sfTinyMce.init({
            // selector : 'textarea[name=\"message\"]',
\t\t\ttoolbar: toolbarOptions + ' | placeholders',
\t\t\tsetup: function (editor) {
\t\t\t\teditor.addButton('placeholders', {
\t\t\t\ttype: 'listbox',
\t\t\t\ttext: '";
        // line 148
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Placeholders"), "html", null, true);
        echo "',
\t\t\t\tonselect: function (e) {
\t\t\t\t\teditor.insertContent(this.value());
\t\t\t\t\tthis.text('";
        // line 151
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Placeholders"), "html", null, true);
        echo "');
\t\t\t\t},
\t\t\t\tvalues: [
\t\t\t\t\t";
        // line 154
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["email_service"]) || array_key_exists("email_service", $context) ? $context["email_service"] : (function () { throw new RuntimeError('Variable "email_service" does not exist.', 154, $this->source); })()), "getEmailPlaceHolders", [0 => "savedReply"], "method", false, false, false, 154));
        foreach ($context['_seq'] as $context["basekey"] => $context["placeholders"]) {
            // line 155
            echo "\t\t\t\t\t// { text: '";
            echo twig_escape_filter($this->env, twig_title_string_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans($context["basekey"])), "html", null, true);
            echo "' , menu: [
\t\t\t\t\t\t";
            // line 156
            if (twig_test_iterable($context["placeholders"])) {
                // line 157
                echo "\t\t\t\t\t\t\t";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($context["placeholders"]);
                foreach ($context['_seq'] as $context["fieldKey"] => $context["fieldPlaceholder"]) {
                    // line 158
                    echo "\t\t\t\t\t\t\t\t{ text: \"";
                    echo twig_get_attribute($this->env, $this->source, $context["fieldPlaceholder"], "title", [], "any", false, false, false, 158);
                    echo "\", value: '";
                    echo twig_escape_filter($this->env, (((("{%" . $context["basekey"]) . ".") . $context["fieldKey"]) . "%}"), "html", null, true);
                    echo "' },
\t\t\t\t\t\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['fieldKey'], $context['fieldPlaceholder'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 160
                echo "\t\t\t\t\t\t";
            }
            // line 161
            echo "\t\t\t\t\t// ]}, 
\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['basekey'], $context['placeholders'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 163
        echo "\t\t\t\t],
\t\t\t\t});
\t\t\t},
        });
    </script>

\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar SavedReplyModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'name': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"";
        // line 175
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
\t\t\t\t\t}
\t\t\t\t\t,{
\t\t\t\t\t\tpattern: '^(?!.*[!@#\$%^&*()<_+])',
\t\t\t\t\t\tmsg: \"";
        // line 179
        echo "Name must have characters only";
        echo "\"
\t\t\t\t\t}
\t\t\t\t\t],
\t\t\t\t}
\t\t\t});

\t\t\tvar SavedReplyForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn' : \"saveSavedReply\",
\t\t\t\t\t'blur input': 'formChanegd',
                    'click .uv-dropdown-list li': 'addEntity',
                    'click .uv-filtered-tags .uv-btn-small': 'removeEntity'
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
                    this.setAddedIds('#group-filter');
                    this.setAddedIds('#team-filter');
\t\t\t\t\tvar jsonContext = JSON.parse('";
        // line 196
        echo (isset($context["errors"]) || array_key_exists("errors", $context) ? $context["errors"] : (function () { throw new RuntimeError('Variable "errors" does not exist.', 196, $this->source); })());
        echo "');
\t\t    \t\tfor (var field in jsonContext) {
\t\t    \t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t    \tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t    },
\t\t\t\tsaveSavedReply : function (e) {
\t\t\t\t\te.preventDefault();
\t\t\t        this.model.set(this.\$el.serializeObject());
\t\t\t        if(this.model.isValid(true)) {
\t\t\t\t\t\tthis.\$el.find('.uv-btn').attr('disabled', 'disabled');
\t\t\t            this.\$el.submit();
\t\t\t        }
\t\t\t\t},
                setAddedIds: function(selector) {
                    var ids = [];
                    \$(selector).find('.uv-filtered-tags .uv-btn-small').each(function() {
                        ids.push(\$(this).attr('data-id'))
                    });

                    \$(selector).find(\"input[type='hidden']\").val(ids.join(','))
                },
                addEntity: function(e) {
                    currentElement = Backbone.\$(e.currentTarget);
                    if(id = currentElement.attr(\"data-id\")) {
                        parent = currentElement.parents(\".uv-field-block\");
                        parent.find('input').val('')
                        parent.find(\"li:not(.uv-no-results)\").show();

                        if(!parent.find(\".uv-filtered-tags a[data-id='\" + id + \"']\").length) {
                            parent.find('.uv-filtered-tags').append(\"<a class='uv-btn-small default' href='#' data-id='\" + id + \"'>\"+currentElement.text()+\"<span class='uv-icon-remove'></span></a>\")
                            this.setAddedIds(\"#\" + parent.attr('id'))
                        }
                    }
                },
                removeEntity: function(e) {
                    var parent = Backbone.\$(e.currentTarget).parents(\".uv-field-block\")
                    Backbone.\$(e.currentTarget).remove()
                    this.setAddedIds(\"#\" + parent.attr('id'))
                }
\t\t\t});

\t\t\tsavedReplyForm = new SavedReplyForm({
\t\t\t\tel : \$(\"#saved-reply-form\"),
\t\t\t\tmodel : new SavedReplyModel()
\t\t\t});\t
\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework/savedReplyForm.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  505 => 196,  485 => 179,  478 => 175,  464 => 163,  457 => 161,  454 => 160,  443 => 158,  438 => 157,  436 => 156,  431 => 155,  427 => 154,  421 => 151,  415 => 148,  403 => 139,  398 => 138,  388 => 137,  371 => 130,  363 => 125,  357 => 122,  351 => 119,  347 => 117,  340 => 112,  337 => 111,  331 => 110,  324 => 106,  319 => 105,  316 => 104,  311 => 103,  309 => 102,  300 => 96,  297 => 95,  288 => 92,  283 => 91,  279 => 90,  274 => 88,  268 => 85,  261 => 81,  252 => 74,  249 => 73,  243 => 72,  236 => 68,  231 => 67,  228 => 66,  223 => 65,  221 => 64,  212 => 58,  209 => 57,  200 => 54,  195 => 53,  191 => 52,  186 => 50,  180 => 47,  173 => 43,  169 => 41,  167 => 40,  160 => 36,  155 => 34,  150 => 32,  142 => 26,  136 => 24,  130 => 22,  128 => 21,  121 => 19,  116 => 17,  113 => 16,  110 => 15,  107 => 14,  104 => 12,  94 => 11,  80 => 7,  74 => 5,  72 => 4,  60 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %} 
    {% if template.id %}
\t\t{{ 'Edit Saved Reply'|trans }}
\t{% else %}
\t\t{{ 'Add Save Reply'|trans }}
\t{% endif %}
{% endblock %}

{% block pageContent %}
\t<div class=\"uv-inner-section\">
\t\t{# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Productivity' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}
\t\t
\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
\t\t\t<h1>
\t\t\t\t{% if template.id %}
                    {{ 'Edit Saved Reply'|trans }}
                {% else %}
                    {{ 'Add Save Reply'|trans }}
                {% endif %}
\t\t\t</h1>
\t\t\t
\t\t\t<!--Form-->
\t\t\t<form method=\"post\" action=\"\" id=\"saved-reply-form\">
\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Name'|trans }}</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<input type=\"text\" name=\"name\" class=\"uv-field\" value=\"{{ template.name }}\" />
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">{{ \"Saved reply name\"|trans }}</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t{% if user_service.isAccessAuthorized('ROLE_ADMIN') %}
\t\t\t\t\t<!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Groups'|trans }}</label>
\t\t\t\t\t\t<div class=\"uv-field-block\" id=\"group-filter\">
\t\t\t\t\t\t\t<input type=\"hidden\" name=\"tempGroups\" class=\"uv-field\" value=\"\" />
\t\t\t\t\t\t\t<input name=\"groups\" class=\"uv-field uv-dropdown-other preloaded\" type=\"text\" id=\"group-filter-input\">
                            <span class=\"uv-field-info\">{{ 'Share saved reply with user(s) in these group(s)'|trans }}</span>
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>{{ 'Filter With'|trans }}</label>
\t\t\t\t\t\t\t\t\t<ul class=\"\">
\t\t\t\t\t\t\t\t\t\t{% for group in user_service.getSupportGroups() %}
\t\t\t\t\t\t\t\t\t\t\t<li data-id=\"{{group.id}}\">
\t\t\t\t\t\t\t\t\t\t\t\t{{group.name}}
\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t\t\t\t\t<li class=\"uv-no-results\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t\t{{ 'No result found'|trans }}
\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"uv-filtered-tags\">
\t\t\t\t\t\t\t\t{% if template.getSupportGroups %}
\t\t\t\t\t\t\t\t\t{% for group in template.getSupportGroups() %}
\t\t\t\t\t\t\t\t\t\t{% if group.isActive %}
\t\t\t\t\t\t\t\t\t\t\t<a class=\"uv-btn-small default\" href=\"#\" data-id=\"{{group.id }}\">
\t\t\t\t\t\t\t\t\t\t\t\t{{ group.name }}
\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"uv-icon-remove\"></span>
\t\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t<!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Teams'|trans }}</label>
\t\t\t\t\t\t<div class=\"uv-field-block\" id=\"team-filter\">
\t\t\t\t\t\t\t<input type=\"hidden\" name=\"tempTeams\" class=\"uv-field\" value=\"\" />
\t\t\t\t\t\t\t<input class=\"uv-field uv-dropdown-other preloaded\" type=\"text\" id=\"team-filter-input\">
                            <span class=\"uv-field-info\">{{ 'Share saved reply with user(s) in these teams(s)'|trans }}</span>
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>{{ 'Filter With'|trans }}</label>
\t\t\t\t\t\t\t\t\t<ul class=\"\">
\t\t\t\t\t\t\t\t\t\t{% for team in user_service.getSupportTeams() %}
\t\t\t\t\t\t\t\t\t\t\t<li data-id=\"{{team.id}}\">
\t\t\t\t\t\t\t\t\t\t\t\t{{team.name}}
\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t\t\t\t\t<li class=\"uv-no-results\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t\t{{ 'No result found'|trans }}
\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"uv-filtered-tags\">
\t\t\t\t\t\t\t\t{% if template.getSupportTeams() %}
\t\t\t\t\t\t\t\t\t{% for team in template.getSupportTeams() %}
\t\t\t\t\t\t\t\t\t\t{% if team.isActive %}
\t\t\t\t\t\t\t\t\t\t\t<a class=\"uv-btn-small default\" href=\"#\" data-id=\"{{team.id }}\">
\t\t\t\t\t\t\t\t\t\t\t\t{{ team.name }}
\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"uv-icon-remove\"></span>
\t\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!-- //Field -->
\t\t\t\t{% endif %}
\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-margin-right-15\">
\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Body'|trans }}</label>
\t\t\t\t\t<div class=\"uv-field-block uv-margin-top-5\">
\t\t\t\t\t\t<textarea id=\"message\" name=\"message\" class=\"uv-field\">
\t\t\t\t\t\t\t{{ template.message }}
\t\t\t\t\t\t</textarea>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info  uv-margin-top-5\">{{ \"Saved reply Body\"|trans }}</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!--CTA-->
\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"{{ 'Save Changes'|trans }}\" type=\"submit\">
\t\t\t\t<!--//CTA-->
\t\t\t</form>
\t\t\t<!--//Form-->
\t\t</div>
\t</div>
{% endblock %}
{% block footer %}
\t{{ parent() }}
\t  {{ include(\"@UVDeskCoreFramework/Templates/tinyMCE.html.twig\") }}
    <script>
\t\tvar toolbarOptions = sfTinyMce.options.toolbar;
        sfTinyMce.init({
            // selector : 'textarea[name=\"message\"]',
\t\t\ttoolbar: toolbarOptions + ' | placeholders',
\t\t\tsetup: function (editor) {
\t\t\t\teditor.addButton('placeholders', {
\t\t\t\ttype: 'listbox',
\t\t\t\ttext: '{{ \"Placeholders\"|trans }}',
\t\t\t\tonselect: function (e) {
\t\t\t\t\teditor.insertContent(this.value());
\t\t\t\t\tthis.text('{{ \"Placeholders\"|trans }}');
\t\t\t\t},
\t\t\t\tvalues: [
\t\t\t\t\t{% for basekey, placeholders in email_service.getEmailPlaceHolders('savedReply') %}
\t\t\t\t\t// { text: '{{ basekey | trans | title }}' , menu: [
\t\t\t\t\t\t{% if placeholders is iterable %}
\t\t\t\t\t\t\t{% for fieldKey, fieldPlaceholder in placeholders %}
\t\t\t\t\t\t\t\t{ text: \"{{ fieldPlaceholder.title|raw }}\", value: '{{ \"{%\" ~ basekey ~ \".\" ~ fieldKey ~ \"%}\"}}' },
\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t{% endif %}
\t\t\t\t\t// ]}, 
\t\t\t\t\t{% endfor %}
\t\t\t\t],
\t\t\t\t});
\t\t\t},
        });
    </script>

\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar SavedReplyModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'name': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"{{ 'This field is mandatory'|trans }}\"
\t\t\t\t\t}
\t\t\t\t\t,{
\t\t\t\t\t\tpattern: '^(?!.*[!@#\$%^&*()<_+])',
\t\t\t\t\t\tmsg: \"{{ 'Name must have characters only' }}\"
\t\t\t\t\t}
\t\t\t\t\t],
\t\t\t\t}
\t\t\t});

\t\t\tvar SavedReplyForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn' : \"saveSavedReply\",
\t\t\t\t\t'blur input': 'formChanegd',
                    'click .uv-dropdown-list li': 'addEntity',
                    'click .uv-filtered-tags .uv-btn-small': 'removeEntity'
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
                    this.setAddedIds('#group-filter');
                    this.setAddedIds('#team-filter');
\t\t\t\t\tvar jsonContext = JSON.parse('{{ errors|raw }}');
\t\t    \t\tfor (var field in jsonContext) {
\t\t    \t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t    \tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t    },
\t\t\t\tsaveSavedReply : function (e) {
\t\t\t\t\te.preventDefault();
\t\t\t        this.model.set(this.\$el.serializeObject());
\t\t\t        if(this.model.isValid(true)) {
\t\t\t\t\t\tthis.\$el.find('.uv-btn').attr('disabled', 'disabled');
\t\t\t            this.\$el.submit();
\t\t\t        }
\t\t\t\t},
                setAddedIds: function(selector) {
                    var ids = [];
                    \$(selector).find('.uv-filtered-tags .uv-btn-small').each(function() {
                        ids.push(\$(this).attr('data-id'))
                    });

                    \$(selector).find(\"input[type='hidden']\").val(ids.join(','))
                },
                addEntity: function(e) {
                    currentElement = Backbone.\$(e.currentTarget);
                    if(id = currentElement.attr(\"data-id\")) {
                        parent = currentElement.parents(\".uv-field-block\");
                        parent.find('input').val('')
                        parent.find(\"li:not(.uv-no-results)\").show();

                        if(!parent.find(\".uv-filtered-tags a[data-id='\" + id + \"']\").length) {
                            parent.find('.uv-filtered-tags').append(\"<a class='uv-btn-small default' href='#' data-id='\" + id + \"'>\"+currentElement.text()+\"<span class='uv-icon-remove'></span></a>\")
                            this.setAddedIds(\"#\" + parent.attr('id'))
                        }
                    }
                },
                removeEntity: function(e) {
                    var parent = Backbone.\$(e.currentTarget).parents(\".uv-field-block\")
                    Backbone.\$(e.currentTarget).remove()
                    this.setAddedIds(\"#\" + parent.attr('id'))
                }
\t\t\t});

\t\t\tsavedReplyForm = new SavedReplyForm({
\t\t\t\tel : \$(\"#saved-reply-form\"),
\t\t\t\tmodel : new SavedReplyModel()
\t\t\t});\t
\t\t});
\t</script>
{% endblock %}", "@UVDeskCoreFramework/savedReplyForm.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/savedReplyForm.html.twig");
    }
}
