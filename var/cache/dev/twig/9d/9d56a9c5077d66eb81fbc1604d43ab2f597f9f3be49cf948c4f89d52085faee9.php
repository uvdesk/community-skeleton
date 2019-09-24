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

/* @UVDeskSupportCenter/Staff/Articles/articleForm.html.twig */
class __TwigTemplate_4eca1f856b1cb28ca17f5e22c921be99a65b1a5106b1304297bf2f63ec6241af extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Staff/Articles/articleForm.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Staff/Articles/articleForm.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskSupportCenter/Staff/Articles/articleForm.html.twig", 1);
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
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Article"), "html", null, true);
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
        echo "\t<style>
\t.uv-tab-error {
\t\tborder-bottom: 3px solid #FF5656 !important;
\t}
\t.mce-menu-item.mce-disabled .mce-text {
\t\tcolor: #333;
\t}
\t.uv-field-block .uv-dropdown-list.uv-top-left, .uv-field-block .uv-dropdown-list.uv-top-right{
    \t/*top: -90px;
\t\tbottom: auto;*/
\t}
\t.uv-vtop {
\t\tvertical-align: top;
\t}
\tdiv + .uv-no-translated-revision {
\t\tdisplay: none;
\t}
\t@media screen and (min-width: 1100px) {
\t\t.uv-inner-section .uv-view .uv-ticket-action-bar .uv-ticket-action-bar-lt {
\t\t\twidth: auto;
\t\t}
\t\t.uv-inner-section .uv-view .uv-ticket-action-bar .uv-ticket-action-bar-rt {
\t\t\twidth: auto;
\t\t\tfloat: right;
\t\t}
\t\t.uv-rtl .uv-inner-section .uv-view .uv-ticket-action-bar .uv-ticket-action-bar-rt {
\t\t\tfloat: left;
\t\t}
\t}
\t</style>

\t<div class=\"uv-inner-section uv-article\">
        <div class=\"uv-aside uv-category\" style=\"overflow-x: hidden;";
        // line 40
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 40, $this->source); })()), "request", [], "any", false, false, false, 40), "cookies", [], "any", false, false, false, 40) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 40, $this->source); })()), "request", [], "any", false, false, false, 40), "cookies", [], "any", false, false, false, 40), "get", [0 => "uv-asideView"], "method", false, false, false, 40))) {
            echo "display: none;";
        }
        echo "\">
\t\t    <div class=\"uv-main-info-block\">
\t\t\t\t<div class=\"uv-aside-head\">
\t\t\t\t\t<div class=\"uv-aside-title\">
\t\t\t\t\t\t<h6>";
        // line 44
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Article"), "html", null, true);
        echo "</h6>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"uv-aside-back\">
\t\t\t\t\t\t<span onclick=\"window.location = '";
        // line 47
        ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 47, $this->source); })()), "request", [], "any", false, false, false, 47), "headers", [], "any", false, false, false, 47), "get", [0 => "referer"], "method", false, false, false, 47)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 47, $this->source); })()), "request", [], "any", false, false, false, 47), "headers", [], "any", false, false, false, 47), "get", [0 => "referer"], "method", false, false, false, 47), "html", null, true))) : (print ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_article_collection"))));
        echo "'\"> ";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Back"), "html", null, true);
        echo "</span>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>

\t\t\t<!--Aside Brick-->
\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t<!--Ticket Actions-->
\t\t\t\t<div class=\"uv-aside-ticket-actions\">

\t\t\t\t\t<!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 59
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Categories"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t<div class=\"uv-field-block\" id=\"categoryUpdate\">
\t\t\t\t\t\t\t<input class=\"uv-field uv-dropdown-other preloaded\" type=\"text\" id=\"category-filter-input\">
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left uv-width-100\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>";
        // line 64
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Filter With"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<ul class=\"uv-agents-list\">
\t\t\t\t\t\t\t\t\t";
        // line 67
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["categories"]) || array_key_exists("categories", $context) ? $context["categories"] : (function () { throw new RuntimeError('Variable "categories" does not exist.', 67, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
            // line 68
            echo "\t\t\t\t\t\t\t\t\t\t<li data-id=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["category"], "id", [], "any", false, false, false, 68), "html", null, true);
            echo "\">
\t\t\t\t\t\t\t\t\t\t\t";
            // line 69
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 69), "html", null, true);
            echo "
\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 72
        echo "\t\t\t\t\t\t\t\t\t<li class=\"uv-no-results\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t";
        // line 73
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("No result found"), "html", null, true);
        echo "
\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"uv-filtered-tags\">
\t\t\t\t\t\t\t\t";
        // line 78
        if ((isset($context["articleCategory"]) || array_key_exists("articleCategory", $context) ? $context["articleCategory"] : (function () { throw new RuntimeError('Variable "articleCategory" does not exist.', 78, $this->source); })())) {
            // line 79
            echo "\t\t\t\t\t\t\t\t\t";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["articleCategory"]) || array_key_exists("articleCategory", $context) ? $context["articleCategory"] : (function () { throw new RuntimeError('Variable "articleCategory" does not exist.', 79, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
                // line 80
                echo "\t\t\t\t\t\t\t\t\t\t<a class=\"uv-btn-small default\" href=\"#\" data-id=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["category"], "id", [], "any", false, false, false, 80), "html", null, true);
                echo "\">
\t\t\t\t\t\t\t\t\t\t\t";
                // line 81
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 81), "html", null, true);
                echo "
\t\t\t\t\t\t\t\t\t\t\t<span class=\"uv-icon-remove\"></span>
\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 85
            echo "\t\t\t\t\t\t\t\t";
        }
        // line 86
        echo "\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t</div>

\t\t\t<!--Aside Brick-->
\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t<!--Ticket Actions-->
\t\t\t\t<div class=\"uv-aside-ticket-actions\">
\t\t\t\t\t<div class=\"uv-aside-select\">
\t\t\t\t\t\t<label class=\"uv-aside-select-label\">";
        // line 98
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t<span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"";
        // line 100
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 100, $this->source); })()), "status", [], "any", false, false, false, 100), "html", null, true);
        echo "\">
\t\t\t\t\t\t\t\t";
        // line 101
        echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 101, $this->source); })()), "status", [], "any", false, false, false, 101) == 1)) ? ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Published")) : ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Draft"))), "html", null, true);
        echo "
\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>";
        // line 105
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t\t<ul class=\"status\" data-action=\"status\">
\t\t\t\t\t\t\t\t\t\t<li data-index=\"1\"><a href=\"#\">";
        // line 107
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Published"), "html", null, true);
        echo "</a></li>
\t\t\t\t\t\t\t\t\t\t<li data-index=\"0\"><a href=\"#\">";
        // line 108
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Draft"), "html", null, true);
        echo "</a></li>
\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t\t<div class=\"uv-aside-select\">
\t\t\t\t\t\t<label class=\"uv-aside-select-label\">";
        // line 116
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Make as Starred"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t<span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"";
        // line 118
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 118, $this->source); })()), "stared", [], "any", false, false, false, 118), "html", null, true);
        echo "\">
\t\t\t\t\t\t\t\t";
        // line 119
        echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 119, $this->source); })()), "stared", [], "any", false, false, false, 119) == 1)) ? ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Yes")) : ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("No"))), "html", null, true);
        echo "
\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>";
        // line 123
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Starred"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t\t<ul class=\"stared\" data-action=\"stared\">
\t\t\t\t\t\t\t\t\t\t<li data-index=\"1\"><a href=\"#\">";
        // line 125
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Yes"), "html", null, true);
        echo "</a></li>
\t\t\t\t\t\t\t\t\t\t<li data-index=\"0\"><a href=\"#\">";
        // line 126
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("No"), "html", null, true);
        echo "</a></li>
\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>

\t\t\t<!--Aside Brick-->
\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t<!--Ticket Actions-->
\t\t\t\t<div class=\"uv-aside-ticket-actions\">
\t\t\t\t\t<div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 140
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Tag"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\" id=\"tagUpdate\">
                            <input class=\"uv-field uv-dropdown-other\" type=\"text\" data-filter-type=\"tag\" id=\"tag-filter-input\">
                            <div class=\"uv-dropdown-list uv-bottom-left uv-width-100\">
                                <div class=\"uv-dropdown-container\">
                                    <label>";
        // line 145
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Filter With"), "html", null, true);
        echo "</label>
                                    <ul class=\"\">
                                        <li class=\"uv-filter-info\">
                                            ";
        // line 148
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Type atleast 2 letters"), "html", null, true);
        echo "
                                        </li>
                                        <li class=\"uv-no-results\" style=\"display: none;\">
                                            ";
        // line 151
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("No result found"), "html", null, true);
        echo "
                                        </li>
\t\t\t\t\t\t\t\t\t\t<li class=\"press-enter-to-add\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t\t";
        // line 154
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Press Enter to add"), "html", null, true);
        echo "
\t\t\t\t\t\t\t\t\t\t</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
\t\t\t\t\t\t<div class=\"uv-filtered-tags tag\">
\t\t\t\t\t\t\t";
        // line 161
        if ((isset($context["articleTags"]) || array_key_exists("articleTags", $context) ? $context["articleTags"] : (function () { throw new RuntimeError('Variable "articleTags" does not exist.', 161, $this->source); })())) {
            // line 162
            echo "\t\t\t\t\t\t\t\t";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["articleTags"]) || array_key_exists("articleTags", $context) ? $context["articleTags"] : (function () { throw new RuntimeError('Variable "articleTags" does not exist.', 162, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
                // line 163
                echo "\t\t\t\t\t\t\t\t\t<a class=\"uv-btn-tag\" href=\"#\" data-id=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tag"], "id", [], "any", false, false, false, 163), "html", null, true);
                echo "\">
\t\t\t\t\t\t\t\t\t\t<span class=\"uv-tag\"><span class=\"uv-icon-remove-dark-before\"></span>";
                // line 164
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tag"], "name", [], "any", false, false, false, 164), "html", null, true);
                echo "</span>
\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tag'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 167
            echo "\t\t\t\t\t\t\t";
        }
        // line 168
        echo "\t\t\t\t\t\t</div>
                    </div>

\t\t\t\t</div>
\t\t\t</div>

\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t<span class=\"uv-text-danger uv-cursor delete-article\">";
        // line 175
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Delete Article"), "html", null, true);
        echo "
\t\t\t</div>

        </div>

\t\t<div class=\"uv-view ";
        // line 180
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 180, $this->source); })()), "request", [], "any", false, false, false, 180), "cookies", [], "any", false, false, false, 180) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 180, $this->source); })()), "request", [], "any", false, false, false, 180), "cookies", [], "any", false, false, false, 180), "get", [0 => "uv-asideView"], "method", false, false, false, 180))) {
            echo "uv-aside-view";
        }
        echo "\">
\t\t\t<div class=\"uv-ticket-scroll-region uv-margin-0 ";
        // line 181
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 181, $this->source); })()), "request", [], "any", false, false, false, 181), "cookies", [], "any", false, false, false, 181) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 181, $this->source); })()), "request", [], "any", false, false, false, 181), "cookies", [], "any", false, false, false, 181), "get", [0 => "uv-asideView"], "method", false, false, false, 181))) {
            echo "uv-aside-view-tv";
        }
        echo "\">
\t\t\t\t<div class=\"uv-ticket-action-bar\">
\t\t\t\t\t<div class=\"uv-ticket-action-bar-lt\">
\t\t\t\t\t\t<!--Tabs-->
\t\t\t\t\t\t<div class=\"uv-tabs\" id=\"article-section-tab\">
\t\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t\t<li for=\"article-edit\" class=\"uv-tab-active\">";
        // line 187
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Article"), "html", null, true);
        echo "</li>
\t\t\t\t\t\t\t\t<li for=\"article-seo\" style=\"display:inline-block;\">";
        // line 188
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("SEO"), "html", null, true);
        echo "</li>
\t\t\t\t\t\t\t\t<li for=\"article-history\" style=\"display:inline-block;\">";
        // line 189
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Revisions"), "html", null, true);
        echo "</li>
\t\t\t\t\t\t\t\t<li for=\"article-related\" class=\"article-other-info\" style=\"display:inline-block;\">";
        // line 190
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Related Articles"), "html", null, true);
        echo "</li>
\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!--Tabs-->
\t\t\t\t\t</div>

\t\t\t\t\t<div class=\"uv-ticket-action-bar-rt\">

\t\t\t\t\t\t<span class=\"uv-action-buttons\">
\t\t\t\t\t\t\t<a href=\"";
        // line 199
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_read_slug_article", ["slug" => twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 199, $this->source); })()), "slug", [], "any", false, false, false, 199)]), "html", null, true);
        echo "\" target=\"_blank\" type=\"button\" class=\"uv-btn-action uv-margin-right-5 uv-button-preview\" ";
        echo ((twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 199, $this->source); })()), "status", [], "any", false, false, false, 199)) ? ("") : ("disabled=\"disabled\""));
        echo " id=\"preview-link\">
\t\t\t\t\t\t\t\t<span class=\"uv-icon-eye-light\"></span> ";
        // line 200
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("view"), "html", null, true);
        echo "
\t\t\t\t\t\t\t</a>

\t\t\t\t\t\t\t<a href=\"#\" type=\"button\" class=\"uv-btn-action uv-margin-right-5\" id=\"preview-article\">
\t\t\t\t\t\t\t\t<span class=\"uv-icon-eye-light\"></span> ";
        // line 204
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preview"), "html", null, true);
        echo "
\t\t\t\t\t\t\t</a>

\t\t\t\t\t\t\t<a href=\"#\" type=\"button\" class=\"uv-btn-action update-btn\">
\t\t\t\t\t\t\t\t<span class=\"uv-icon-publish-light\"></span> ";
        // line 208
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Update"), "html", null, true);
        echo "
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</span>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<!-- Form -->
\t\t\t\t<form method=\"post\" action=\"\" id=\"article-form\" style=\"width: 97%;\">
\t\t\t\t\t<div id=\"original-article\" class=\"article-instances\">
\t\t\t\t\t\t<div class=\"uv-tab-view uv-tab-view-active\" id=\"article-edit\">
\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 220
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Title"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t\t<input name=\"name\" class=\"uv-field\" type=\"text\" value=\"";
        // line 222
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 222, $this->source); })()), "name", [], "any", false, false, false, 222), "html", null, true);
        echo "\">
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block uv-element-block-textarea\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 229
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Content"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block uv-margin-top-5\">
\t\t\t\t\t\t\t\t\t<textarea name=\"content\" class=\"uv-field\" id=\"article_content\">";
        // line 231
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 231, $this->source); })()), "content", [], "any", false, false, false, 231), "html", null, true);
        echo "</textarea>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<div class=\"uv-tab-view\" id=\"article-seo\">
\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 240
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Slug"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t\t<input name=\"slug\" class=\"uv-field\" type=\"text\" value=\"";
        // line 242
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 242, $this->source); })()), "slug", [], "any", false, false, false, 242), "html", null, true);
        echo "\">
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 244
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Slug is the url identity of this article. We will help you to create valid slug at time of typing."), "html", null, true);
        echo "</span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 250
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Meta Title"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t\t<input name=\"metaTitle\" class=\"uv-field\" type=\"text\" value=\"";
        // line 252
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 252, $this->source); })()), "metaTitle", [], "any", false, false, false, 252), "html", null, true);
        echo "\">
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 254
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Title tags and meta descriptions are bits of HTML code in the header of a web page. They help search engines understand the content on a page. A page's title tag and meta description are usually shown whenever that page appears in search engine results"), "html", null, true);
        echo "</span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 260
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Meta Keywords"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t\t<input name=\"keywords\" class=\"uv-field\" type=\"text\" value=\"";
        // line 262
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 262, $this->source); })()), "keywords", [], "any", false, false, false, 262), "html", null, true);
        echo "\">
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 264
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("comma \",\" separated"), "html", null, true);
        echo "</span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 270
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Meta Description"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t\t<textarea name=\"metaDescription\" class=\"uv-field\">";
        // line 272
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 272, $this->source); })()), "metaDescription", [], "any", false, false, false, 272), "html", null, true);
        echo "</textarea>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<div class=\"uv-tab-view\" id=\"article-history\">
\t\t\t\t\t\t\t<div class=\"uv-table uv-list-view\"></div>
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<div class=\"uv-tab-view\" id=\"article-related\">
\t\t\t\t\t\t\t<div class=\"uv-element-block \">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 284
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Article Title"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block related\">
\t\t\t\t\t\t\t\t\t<input class=\"uv-field uv-dropdown-other\" type=\"text\" data-filter-type=\"related\" id=\"related-filter-input\">
\t\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left uv-width-100\">
\t\t\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t\t\t<label>";
        // line 289
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Filter With"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"\">
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"uv-filter-info\">
\t\t\t\t\t\t\t\t\t\t\t\t\t";
        // line 292
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Type atleast 2 letters"), "html", null, true);
        echo "
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"uv-no-results\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t\t\t\t";
        // line 295
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("No result found"), "html", null, true);
        echo "
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 302
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Start typing few charactors and add set of relevant article from the list"), "html", null, true);
        echo "</span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"uv-table uv-list-view\"></div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</form>
\t\t\t</div>
\t\t</div>
\t</div>

\t<style>
\t\t.uv-revision-parent{
\t\t\tmargin-bottom: 20px;
\t\t\twidth: 100%;
\t\t\toverflow: hidden;
\t\t}
\t\t.uv-revision-left{
\t\t\tdisplay: inline-block;
\t\t\twidth: 40px;
\t\t\theight: 100%;
\t\t\tposition: absolute;
\t\t}
\t\t.uv-revision-right{
\t\t\tdisplay: inline-block;
\t\t\twidth: 100%;
\t\t\tmargin-left: 40px;
\t\t\tborder-bottom: solid 1px #D3D3D3;
\t\t\tpadding-bottom: 20px;
\t\t}
\t\t.uv-revision-right div{
\t\t\tmargin-bottom: 3px;
\t\t}
\t\t.uv-revision-right div:nth-child(1){
\t\t\tcolor: #737373;
\t\t}
\t\t.uv-inner-section.uv-article .uv-view .uv-ticket-action-bar{
\t\t\tmargin-top: 20px;
\t\t\tmargin-bottom: 25px;
\t\t}
\t\t.uv-related {
\t\t\twidth: 100%;
\t\t\tborder-top: solid 1px #D3D3D3;
\t\t\tpadding: 10px 0px;
\t\t}
\t\t#article-related a.uv-btn-stroke.remove {
\t\t\tpadding: 2px 4px;
    \t\tmargin-right: 4px;
\t\t}
\t\t.uv-pop-up-box{
\t\t\toverflow: hidden;
\t\t}
\t</style>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 356
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 357
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "

\t<script id=\"article_related_list_item_tmp\" type=\"text/template\">
\t\t<div class=\"uv-related\">
\t\t\t<a class=\"uv-btn-tag remove-event-select remove\" data-id=\"<%= id %>\" data-article-id=\"<%= articleId %>\" href=\"#\">
\t\t\t\t<span class=\"uv-icon-remove-dark-box\"></span>
\t\t\t</a>
\t\t\t<%- name %>
\t\t</div>
    </script>

\t<script id=\"article_history_list_item_tmp\" type=\"text/template\">
\t\t<div class=\"uv-revision-parent\">
\t\t\t<div class=\"uv-revision-left\">
\t\t\t\t<% if(isCurrent){ %>
\t\t\t\t\t<span class=\"uv-icon-history uv-icon-history-active\"></span>
\t\t\t\t<% }else{ %>
\t\t\t\t\t<span class=\"uv-icon-history\"></span>
\t\t\t\t<% } %>
\t\t\t</div>
\t\t\t<div class=\"uv-revision-right\">
\t\t\t\t<div>";
        // line 378
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Revision"), "html", null, true);
        echo " #<%= id %>
\t\t\t\t\t<% if(isCurrent){ %>
\t\t\t\t\t\t<span>(";
        // line 380
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Published"), "html", null, true);
        echo ")</span>
\t\t\t\t\t<% } %>
\t\t\t\t</div>
\t\t\t\t<div><%- name %> ";
        // line 383
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("updated the article"), "html", null, true);
        echo " <span class=\"timeago\" data-timestamp=\"<%= dateAdded.timestamp %>\"> ";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("on"), "html", null, true);
        echo " <%= dateAdded.format %></span></div>
\t\t\t\t<div class=\"uv-action-buttons\">
\t\t\t\t\t<a href=\"#\" type=\"button\" class=\"uv-btn-small history-preview\" data-id=\"<%= id %>\">
\t\t\t\t\t\t";
        // line 386
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Preview"), "html", null, true);
        echo "
\t\t\t\t\t</a>
\t\t\t\t\t<a href=\"#\" type=\"button\" class=\"uv-btn-small <% if(hasContent && !isCurrent){ %>history-restore<% } %>\"  <% if(isCurrent || !hasContent){ %>disabled=\"disabled\" <% } %>>
\t\t\t\t\t\t<% if(isCurrent){ %>
\t\t\t\t\t\t\t";
        // line 390
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Restored"), "html", null, true);
        echo "
\t\t\t\t\t\t<% }else{ %>
\t\t\t\t\t\t\t";
        // line 392
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Restore"), "html", null, true);
        echo "
\t\t\t\t\t\t<% } %>
\t\t\t\t\t</a>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
    </script>

\t<script id=\"article_preview_html\" type=\"text/template\">
\t\t<div class=\"uv-pop-up-overlay\" id=\"preview-modal\" style=\"display:block;\">
\t\t\t<div class=\"uv-pop-up-box uv-pop-up-wide\">
\t\t\t\t<span class=\"uv-pop-up-close\"></span>
\t\t\t\t<div class=\"uv-html-preview\" style=\"margin-bottom: 30px;\">
\t\t\t\t</div>
\t\t\t\t<div class=\"uv-pop-up-actions\">
\t\t\t\t\t<a href=\"#\" class=\"uv-btn cancel\">";
        // line 407
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Close"), "html", null, true);
        echo "</a>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
    </script>

\t<script id=\"article_history_view_html\" type=\"text/template\">
\t\t<div class=\"uv-pop-up-overlay\" id=\"preview-modal\" style=\"display:block;\">
\t\t\t<div class=\"uv-pop-up-box uv-pop-up-wide\">
\t\t\t\t<span class=\"uv-pop-up-close\"></span>
\t\t\t\t<div class=\"uv-html-preview\">
\t\t\t\t</div>
\t\t\t\t<div class=\"uv-pop-up-actions\">
\t\t\t\t\t<a href=\"#\" class=\"uv-btn uv-btn-error restore\">";
        // line 420
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Restore"), "html", null, true);
        echo "</a>
\t\t\t\t\t<a href=\"#\" class=\"uv-btn cancel\">";
        // line 421
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Cancel"), "html", null, true);
        echo "</a>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
    </script>

\t<script type=\"text/javascript\">
\t\tvar path_history = \"";
        // line 428
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_revision_article", ["id" => twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 428, $this->source); })()), "id", [], "any", false, false, false, 428)]), "html", null, true);
        echo "\"
\t\tvar path_related = \"";
        // line 429
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_related_article_xhr", ["id" => twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 429, $this->source); })()), "id", [], "any", false, false, false, 429)]), "html", null, true);
        echo "\"

\t\t\$.fn.serializeFormObject = function () {
\t\t\tvar o = {};
\t\t\tvar outputCopy = o;
\t\t\tvar a = this.serializeArray();
\t\t\tvar regex = /(\\w+)+/g;
\t\t\t\$.each(a, function (index, item) {
\t\t\t\tvar keys = item.name.match(regex);
\t\t\t\tkeys.forEach(function (key, localIndex) {
\t\t\t\t\tif (!outputCopy.hasOwnProperty(key)) {
\t\t\t\t\t\toutputCopy[key] = {};
\t\t\t\t\t}
\t\t\t\t\tif(localIndex == keys.length - 1) {
\t\t\t\t\t\toutputCopy[key] = isNaN(item.value)|| item.value == '' || item.value == null  ? item.value : +item.value;
\t\t\t\t\t}
\t\t\t\t\toutputCopy = outputCopy[key];
\t\t\t\t});
\t\t\t\toutputCopy = o;
\t\t\t});
\t\t\treturn o;
\t\t};

\t\t\$(function () {
\t\t\tvar globalMessageResponse = \"\";

\t\t\tvar ArticleForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn-action.update-btn' : \"saveArticle\",
\t\t\t\t\t'blur input': 'formChanged',

                    'click .uv-dropdown-list li': 'addEntity',
                    'click .uv-filtered-tags .uv-btn-small': 'removeEntity',
                    'click .uv-filtered-tags .uv-btn-tag': 'removeEntity',
\t\t\t\t\t'click .delete-article' : 'confirmRemove'
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.articleId = \"";
        // line 466
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 466, $this->source); })()), "request", [], "any", false, false, false, 466), "attributes", [], "any", false, false, false, 466), "get", [0 => "id"], "method", false, false, false, 466), "html", null, true);
        echo "\";
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t},
                addEntity: function(e) {
                    let currentElement = Backbone.\$(e.currentTarget);
                    if(id = currentElement.attr(\"data-id\")) {
                    \tvar coreParent = Backbone.\$(e.currentTarget).parents('.uv-element-block');
                    \tvar parent = coreParent.find(\".uv-field-block\");
                        parent.find(\"li:not(.uv-no-results)\").show();

                        if(parent.hasClass('related')) {
\t\t\t\t\t\t\tlet parentTab = parent.parents('#article-related');

\t\t\t\t\t\t\tif(!parentTab.find(\".uv-list-view a[data-article-id='\" + id + \"']\").length) {
\t\t\t\t\t\t\t\tvar data = {};
\t\t\t\t\t\t\t\tdata['ids'] = [this.articleId];
\t\t\t\t\t\t\t\tdata['actionType'] = 'relatedUpdate'
\t\t\t\t\t\t\t\tdata['entityId'] = id;
\t\t\t\t\t\t\t\tdata['action'] = 'add';
\t\t\t\t\t\t\t\tthis.articleEntityUpdate(data);
\t\t\t\t\t\t\t}
\t\t\t\t\t\t}else{
\t\t\t\t\t\t\tvar inputElement = Backbone.\$('#tag-filter-input');
\t\t\t\t\t\t\tinputElement.removeClass('uv-field-error');
\t\t\t\t\t\t\tinputElement.parents('.uv-element-block').find('.uv-field-message').remove();

\t\t\t\t\t\t\tinputElement.val('');

\t\t\t\t\t\t\tif(!coreParent.find(\".uv-filtered-tags a[data-id='\" + id + \"']\").length) {
\t\t\t\t\t\t\t\tlet html = '';
\t\t\t\t\t\t\t\tif(parent[0].id == 'tagUpdate'){
\t\t\t\t\t\t\t\t\thtml = `
\t\t\t\t\t\t\t\t\t\t<a class=\"uv-btn-tag\" href=\"#\" data-id=\"\${id}\">
\t\t\t\t\t\t\t\t\t\t\t<span class=\"uv-tag\"><span class=\"uv-icon-remove-dark-before\"></span>\${currentElement.text()}</span>
\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t`;
\t\t\t\t\t\t\t\t}else{
\t\t\t\t\t\t\t\t\thtml = \"<a class='uv-btn-small default' href='#' data-id='\" + id + \"'>\"+currentElement.text()+\"<span class='uv-icon-remove'></span></a>\";
\t\t\t\t\t\t\t\t}

\t\t\t\t\t\t\t\tcoreParent.find('.uv-filtered-tags').append(html)
\t\t\t\t\t\t\t\tvar data = {};
\t\t\t\t\t\t\t\tdata['ids'] = [this.articleId];
\t\t\t\t\t\t\t\tdata['actionType'] = parent[0].id;
\t\t\t\t\t\t\t\tdata['entityId'] = id;
\t\t\t\t\t\t\t\tdata['action'] = 'add';
\t\t\t\t\t\t\t\tthis.articleEntityUpdate(data);
\t\t\t\t\t\t\t}else {
\t\t\t\t\t\t\t\tinputElement.addClass('uv-field-error');
\t\t\t\t\t\t\t\tinputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>";
        // line 515
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Tag with same name already exist"), "html", null, true);
        echo "</span>\");
\t\t\t\t\t\t\t}
\t\t\t\t\t\t}
                    }
                },
                removeEntity: function(e) {
                    var parent = Backbone.\$(e.currentTarget).parents('.uv-element-block').find(\".uv-field-block\")
                    Backbone.\$(e.currentTarget).remove();

\t\t\t\t\tvar data = {};
\t\t\t\t\tdata['ids'] = [this.articleId];
\t\t\t\t\tdata['actionType'] = parent[0].id;
\t\t\t\t\tdata['entityId'] = \$(e.currentTarget).attr(\"data-id\");
\t\t\t\t\tdata['action'] = 'remove';
\t\t\t\t\tthis.articleEntityUpdate(data);
                },
\t\t\t\tarticleEntityUpdate : function(data) {
                    var self = this;
                    app.appView.showLoader();
                    \$.ajax({
                        url : \"";
        // line 535
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_update_article_xhr");
        echo "\",
                        type : 'POST',
                        data : {data : data},
                        dataType : 'json',
                        success : function(response) {
                            app.appView.hideLoader();

\t\t\t\t\t\t\tif (data['actionType'] == 'relatedUpdate') {
\t\t\t\t\t\t\t\tarticleRelatedCollection.syncData();
\t\t\t\t\t\t\t}

\t\t\t\t\t\t\tif(response.alertClass == \"success\") {
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t\t} else{
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t\t\tself.addErrors(response.errors);
\t\t\t\t\t\t\t}
                        },
                        error: function (xhr) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        }
                    });
                },
\t\t\t\tformChanged: function(e) {
\t\t\t    \tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t    },
\t\t\t\tsaveArticle: function (e) {
\t\t\t\t\te.preventDefault();
\t\t\t\t\t\$(\".uv-tabs li\").removeClass('uv-tab-error')
                    currentElement = Backbone.\$(e.currentTarget);
                    this.model.clear();
\t\t\t\t\tlet formData = this.\$el.find('form#article-form').serializeFormObject();
\t\t\t        this.model.set(formData);
                    self = this;
\t\t\t\t\tvar contentNotHasError = this.validateForm(e);
\t\t\t        if(this.model.isValid(true) && contentNotHasError) {
\t\t\t\t\t\tformData['ids'] = [this.articleId];
\t\t\t\t\t\tformData['actionType'] = 'articleUpdate';
\t\t\t\t\t\tformData['content'] = \$('textarea#article_content').val();
\t\t\t\t\t\t";
        // line 582
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_service"]) || array_key_exists("uvdesk_service", $context) ? $context["uvdesk_service"] : (function () { throw new RuntimeError('Variable "uvdesk_service" does not exist.', 582, $this->source); })()), "getLocales", [], "method", false, false, false, 582));
        foreach ($context['_seq'] as $context["localeCode"] => $context["localeName"]) {
            // line 583
            echo "\t\t\t\t\t\t\tvar localeType = '";
            echo twig_escape_filter($this->env, $context["localeCode"], "html", null, true);
            echo "';
\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['localeCode'], $context['localeName'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 585
        echo "\t\t\t\t\t\tthis.articleEntityUpdate(formData);
\t\t\t        } else {
                        \$('.uv-field-message').each(function(e) {
                            \$(\".uv-tabs li[for='\" + \$(this).parents('.uv-tab-view').attr('id') + \"']:not(.uv-tab-active)\").addClass('uv-tab-error')
                        });
                    }
\t\t\t\t},
                validateForm : function(e) {
                    var element = Backbone.\$(e.currentTarget);
                    formType = 'content';
                    form = \$('#article-form');
                    form.find('.uv-field-message').remove()
                    var html = \$('.uv-field').text();
                    if(app.appView.htmlText(html).trim().length != 0) {
\t\t\t\t\t\treturn true;
                    } else {
                        form.find('.uv-element-block-textarea').append(\"<span class='uv-field-message'>";
        // line 601
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "</span>\");
                    }
                },
                addErrors: function(jsonContext) {
\t\t    \t\tfor (var field in jsonContext) {
\t\t    \t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
                },
                confirmRemove: function(e) {
                    e.preventDefault();
                    this.currentEvent = e;

                    app.appView.openConfirmModal(this)
                },
                removeItem: function(e) {
                    var data = {};

                    data['actionType'] = \"delete\";

                    data['ids'] = [\"";
        // line 620
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 620, $this->source); })()), "id", [], "any", false, false, false, 620), "html", null, true);
        echo "\"];
\t\t\t\t\tthis.articleEntityUpdate(data);

\t\t\t\t\tsetTimeout(function(){
                    \twindow.location = '";
        // line 624
        ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 624, $this->source); })()), "request", [], "any", false, false, false, 624), "headers", [], "any", false, false, false, 624), "get", [0 => "referer"], "method", false, false, false, 624)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 624, $this->source); })()), "request", [], "any", false, false, false, 624), "headers", [], "any", false, false, false, 624), "get", [0 => "referer"], "method", false, false, false, 624), "html", null, true))) : (print ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_article_collection"))));
        echo "';
\t\t\t\t\t}, 1000);
                },
\t\t\t});

\t\t\tvar ArticleFullView = Backbone.View.extend({
\t\t\t\tel: \$('body'),
\t\t\t\tpreviewTemplate : _.template(\$(\"#article_preview_html\").html()),
\t\t\t\tevents: {
\t\t\t\t\t'click #preview-link': 'previewArticle',
\t\t\t\t\t'click #preview-article': 'renderArticlePreview',
\t\t\t\t\t'click #article-locale li': 'closeDropdown',
\t\t\t\t},
\t\t\t\tpreviewArticle: function(e) {
\t\t\t\t\tvar target = \$(e.target).closest('.uv-button-preview');
\t\t\t\t\tvar isDisabled = target.attr('disabled') ? true : false;
\t\t\t\t\tvar lang = \$('#article-locale').attr('data-value');
\t\t\t\t\tif(lang && !isDisabled) {
\t\t\t\t\t\te.preventDefault();
\t\t\t\t\t\tvar langSpecificUrl = target.attr('href').replace('";
        // line 643
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 643, $this->source); })()), "request", [], "any", false, false, false, 643), "locale", [], "any", false, false, false, 643), "html", null, true);
        echo "', lang);
\t\t\t\t\t\twindow.open(langSpecificUrl);
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\trenderArticlePreview: function(e){
\t\t\t\t\te.preventDefault();
\t\t\t\t\tvar article_content = \$('#article_content').val();
\t\t\t\t\t//tinyMCE.get('content').focus();
\t\t\t\t\tconsole.log(article_content);
\t\t\t\t\tarticle_content

\t\t\t\t\t\$('body').append(this.previewTemplate());
\t\t\t\t\t\$('body').find('#preview-modal .uv-html-preview').html('<h1 style=\"margin-bottom: 30px;\">' + articlemodel.attributes.name + '</h1>' + article_content);
\t\t\t\t\t
\t\t\t\t\t//\$('body').find('#preview-modal .uv-html-preview').html('<h1 style=\"margin-bottom: 30px;\">' + articlemodel.attributes.name + '</h1>' + tinyMCE.activeEditor.getContent());
\t\t\t\t},
\t\t\t});

            var ArticleModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'name': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: 'This field is mandatory'
\t\t\t\t\t},{
\t\t\t\t\t\tmaxLength:200,
\t\t\t\t\t\tmsg: 'This field contain maximum 200 charecters only'
\t\t\t\t\t}, {
\t\t\t\t\t\tpattern: '^((?![\$%<]).)*\$',
\t\t\t\t\t\tmsg: 'This field must have valid characters only'
\t\t\t\t\t}],
\t\t\t\t\t'metaTitle':[{
\t\t\t\t\t\tmaxLength:200,
\t\t\t\t\t\tmsg: 'This field contain mata title maximum 200 charecters only'
\t\t\t\t\t}],
\t\t\t\t\t'keywords':[{
\t\t\t\t\t\tmaxLength:200,
\t\t\t\t\t\tmsg: 'This field contain keywords maximum 200 charecters only'
\t\t\t\t\t}],
\t\t\t\t\t'slug': function(val, attr, computed) {
\t\t\t\t\t\tvar elSlug = \$(\"[name=\" + attr + \"]\");
\t\t\t\t\t\tvar elSlugValue = '';
\t\t\t\t\t\telSlug.val(elSlugValue = app.appView.convertToSlug(val))
\t\t\t\t\t
\t\t\t\t\t\tif(elSlugValue.trim() == ''){
\t\t\t\t\t\t\treturn '";
        // line 687
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "';
\t\t\t\t\t\t}
\t\t\t\t\t\t
\t\t\t\t\t\tif(elSlugValue.length > 100) {
\t\t\t\t\t\t\treturn \"This field slug contains maximum 100 charecters only.\";
\t\t\t\t\t\t}
\t\t\t\t\t}
\t\t\t\t},
                urlRoot : \"";
        // line 695
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_update_article_xhr");
        echo "\"
\t\t\t});

\t\t\tvar articlemodel = new ArticleModel({
                id : \"";
        // line 699
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 699, $this->source); })()), "id", [], "any", false, false, false, 699), "html", null, true);
        echo "\",
                name : \"";
        // line 700
        echo twig_escape_filter($this->env, twig_replace_filter(twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 700, $this->source); })()), "name", [], "any", false, false, false, 700), ["
" => " ", "" => " "]), "html", null, true);
        echo "\",
                slug : \"";
        // line 701
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 701, $this->source); })()), "slug", [], "any", false, false, false, 701), "html", null, true);
        echo "\",
\t\t\t\tstatus: \"";
        // line 702
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 702, $this->source); })()), "status", [], "any", false, false, false, 702), "html", null, true);
        echo "\",
\t\t\t\tstared: \"";
        // line 703
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 703, $this->source); })()), "stared", [], "any", false, false, false, 703), "html", null, true);
        echo "\",
\t\t\t})

\t\t\tarticleForm = new ArticleForm({
                el: '.uv-paper',
\t\t\t\t//el : \$(\".uv-aside.uv-category\"),
\t\t\t\tmodel : articlemodel
\t\t\t});

\t\t\tvar articleFullView = new ArticleFullView();

            var ArticleHistoryModel = Backbone.Model.extend({
                urlRoot : path_history
\t\t\t});

\t\t\tvar ArticleHistoryCollection = AppCollection.extend({
\t\t\t\tmodel : ArticleHistoryModel,
\t\t\t\turl : path_history,
\t\t\t\tfilterParameters : {
\t\t\t\t\t\"isActive\" : \"\",
\t\t\t\t\t\"search\" : \"\"
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.syncData();
\t\t\t\t},
\t\t\t\tparseRecords: function (resp, options) {
\t\t\t\t\treturn resp;
\t\t\t\t},
\t\t\t\tsyncData : function() {
\t\t\t\t\tapp.appView.showLoader();
\t\t\t\t\tthis.fetch({
\t\t\t\t\t\tdata : this.getValidParameters(),
\t\t\t\t\t\treset: true,
\t\t\t\t\t\tsuccess: function(model, response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tvar articleHistoryListView = new ArticleHistoryList();

\t\t\t\t\t\t\tif(globalMessageResponse)
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(globalMessageResponse);
\t\t\t\t\t\t\tglobalMessageResponse = null;
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t}
\t\t\t});

\t\t\tvar ArticleHistoryItem = Backbone.View.extend({
\t\t\t\ttagName : \"div\",
\t\t\t\ttemplate : _.template(\$(\"#article_history_list_item_tmp\").html()),
\t\t\t\tpreviewTemplate : _.template(\$(\"#article_history_view_html\").html()),
\t\t\t\tevents: {
\t\t\t\t\t'click .history-preview' : \"preview\",
\t\t\t\t\t'click .history-restore' : \"restore\",
\t\t\t\t},
\t\t\t\trender : function() {
\t\t\t\t\tvar tinymceContent = `";
        // line 761
        echo twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 761, $this->source); })()), "content", [], "any", false, false, false, 761);
        echo "`;
\t\t\t\t\tthis.\$el.html(this.template(\$.extend(this.model.toJSON(), {
\t\t\t\t\t\tisCurrent: (this.model.attributes.content.trim() == tinymceContent ? true : false),
\t\t\t\t\t\thasContent: (this.model.attributes.content.trim().length ? true : false)
\t\t\t\t\t}) ));
\t\t\t\t\treturn this;
\t\t\t\t},
\t\t\t\tunrender : function(response) {
\t\t\t\t\tif(response.alertMessage != undefined) {
\t\t\t\t\t\tarticleHistoryCollection.syncData();
\t\t\t\t\t\tapp.appView.renderResponseAlert(response)
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tpreview: function(e){
\t\t\t\t\te.preventDefault();
\t\t\t\t\t\$('body').append(this.previewTemplate());

\t\t\t\t\tif(this.model.attributes.content.trim().length){
\t\t\t\t\t\t\$('body').find('#preview-modal .uv-html-preview').html(this.model.attributes.content);
\t\t\t\t\t}else{
\t\t\t\t\t\t\$('body').find('#preview-modal .uv-html-preview').html(
\t\t\t\t\t\t\t`
\t\t\t\t\t\t\t\t<h2>";
        // line 783
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Oops"), "html", null, true);
        echo "</h2>
\t\t\t\t\t\t\t\t<p>";
        // line 784
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Sorry, there are nothing to display."), "html", null, true);
        echo "</p>
\t\t\t\t\t\t\t`
\t\t\t\t\t\t);
\t\t\t\t\t\t\$('body').find('#preview-modal .restore').attr('disabled', 'disabled');
\t\t\t\t\t\t\$('body').find('#preview-modal .uv-btn.uv-btn-error').removeClass('restore');
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\trestore: function(e){
\t\t\t\t\te.preventDefault();
\t\t\t\t\tformData = {};
\t\t\t\t\tformData['ids'] = ['";
        // line 794
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 794, $this->source); })()), "id", [], "any", false, false, false, 794), "html", null, true);
        echo "'];
\t\t\t\t\tformData['actionType'] = 'contentUpdate';
\t\t\t\t\tformData['content'] = this.model.attributes.content;
\t\t\t\t\ttinyMCE.get('content').setContent(this.model.attributes.content)
\t\t\t\t\tarticleForm.articleEntityUpdate(formData);
\t\t\t\t\tarticleHistoryCollection.syncData();
\t\t\t\t}
\t\t\t});

\t\t\tvar ArticleHistoryList = Backbone.View.extend({
\t\t\t\tel : \$(\"#article-history .uv-list-view\"),
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.render();
\t\t\t\t},
\t\t\t\trender : function () {
\t\t\t\t\tthis.\$el.find(\"div\").remove();
\t\t\t\t\tif(articleHistoryCollection.length) {
\t\t\t\t\t\t_.each(articleHistoryCollection.models, function (item) {
\t\t\t\t\t\t\tthis.renderArticle(item);
\t\t\t\t\t\t}, this);
\t\t\t\t\t\tapp.appView.relativeTime()
\t\t\t\t\t} else {
\t\t\t\t\t\tthis.\$el.append(\"<div class='uv-text-center'>";
        // line 816
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("No Record Found", [], "messages");
        echo "</div>\")
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\trenderArticle : function (item) {
\t\t\t\t\tvar articleHistoryItem = new ArticleHistoryItem({
\t\t\t\t\t\tmodel: item
\t\t\t\t\t});
\t\t\t\t\tthis.\$el.append(articleHistoryItem.render().el);
\t\t\t\t}
\t\t\t});

\t\t\tarticleHistoryCollection = new ArticleHistoryCollection();

            var ArticleRelatedModel = Backbone.Model.extend({
                urlRoot : path_related
\t\t\t});

\t\t\tvar ArticleRelatedCollection = AppCollection.extend({
\t\t\t\tmodel : ArticleRelatedModel,
\t\t\t\turl : path_related,
\t\t\t\tfilterParameters : {
\t\t\t\t\t\"isActive\" : \"\",
\t\t\t\t\t\"search\" : \"\"
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.syncData();
\t\t\t\t},
\t\t\t\tparseRecords: function (resp, options) {
\t\t\t\t\treturn resp;
\t\t\t\t},
\t\t\t\tsyncData : function() {
\t\t\t\t\tapp.appView.showLoader();
\t\t\t\t\tthis.fetch({
\t\t\t\t\t\tdata : this.getValidParameters(),
\t\t\t\t\t\treset: true,
\t\t\t\t\t\tsuccess: function(model, response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tvar articleRelatedListView = new ArticleRelatedList();

\t\t\t\t\t\t\tif(globalMessageResponse)
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(globalMessageResponse);
\t\t\t\t\t\t\tglobalMessageResponse = null;
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t}
\t\t\t});

\t\t\tvar ArticleRelatedItem = Backbone.View.extend({
\t\t\t\ttagName : \"div\",
\t\t\t\ttemplate : _.template(\$(\"#article_related_list_item_tmp\").html()),
\t\t\t\tevents: {
\t\t\t\t\t'click .remove' : \"remove\",
\t\t\t\t},
\t\t\t\trender : function() {
\t\t\t\t\tthis.\$el.html(this.template(this.model.toJSON()));
\t\t\t\t\treturn this;
\t\t\t\t},
\t\t\t\tremove: function(e){
\t\t\t\t\te.preventDefault();
\t\t\t\t\tlet formData = {};
\t\t\t\t\tformData['ids'] = [\"";
        // line 880
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 880, $this->source); })()), "id", [], "any", false, false, false, 880), "html", null, true);
        echo "\"];
\t\t\t\t\tformData['actionType'] = 'relatedUpdate';
\t\t\t\t\tformData['action'] = 'remove';
\t\t\t\t\tformData['entityId'] = this.model.id;
\t\t\t\t\tarticleForm.articleEntityUpdate(formData);

\t\t\t\t\t\$(e.target).parent().parent().remove();
\t\t\t\t}
\t\t\t});

\t\t\tvar ArticleRelatedList = Backbone.View.extend({
\t\t\t\tel : \$(\"#article-related .uv-list-view\"),
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.render();
\t\t\t\t},
\t\t\t\trender : function () {
\t\t\t\t\tthis.\$el.find(\"div\").remove();
\t\t\t\t\tif(articleRelatedCollection.length) {
\t\t\t\t\t\t_.each(articleRelatedCollection.models, function (item) {
\t\t\t\t\t\t\tthis.renderArticle(item);
\t\t\t\t\t\t}, this);
\t\t\t\t\t\tapp.appView.relativeTime()
\t\t\t\t\t} else {
\t\t\t\t\t\tthis.\$el.append(\"<div>";
        // line 903
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("No Record Found", [], "messages");
        echo "</div>\")
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\trenderArticle : function (item) {
\t\t\t\t\tvar articleRelatedItem = new ArticleRelatedItem({
\t\t\t\t\t\tmodel: item
\t\t\t\t\t});
\t\t\t\t\tthis.\$el.append(articleRelatedItem.render().el);
\t\t\t\t}
\t\t\t});

\t\t\tarticleRelatedCollection = new ArticleRelatedCollection();

\t\t\tvar TagList = Backbone.View.extend({
                el : \$(\"#tagUpdate\"),
                events : {
                    'keypress .uv-field' : 'addTag',
                },
                addTag : function(e) {
\t\t\t\t\tvar inputElement = Backbone.\$(e.currentTarget);
\t\t\t\t\tinputElement.removeClass('uv-field-error');
\t\t\t\t\tinputElement.parents('.uv-element-block').find('.uv-field-message').remove()
\t\t\t\t\tvar text = inputElement.val().trim();

\t\t\t\t\tif (e.which === 13 && text) {
\t\t\t\t\t\tif ((text.match(/^((?![!@#\$%^&*()<_+]).)*\$/))) {
\t\t\t\t\t\t\t\tif(text.length <= 35) {
\t\t\t\t\t\t\t\tlet existed = false;
\t\t\t\t\t\t\t\t\$('.uv-filtered-tags .uv-tag').each(function(key, el){
\t\t\t\t\t\t\t\t\tif(\$(el).text().toLowerCase() == text.toLowerCase())
\t\t\t\t\t\t\t\t\t\texisted = true;
\t\t\t\t\t\t\t\t})
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\tif(!existed) {
\t\t\t\t\t\t\t\t\tlet data = {};
\t\t\t\t\t\t\t\t\tapp.appView.showLoader();

\t\t\t\t\t\t\t\t\tdata['ids'] = [\"";
        // line 940
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 940, $this->source); })()), "id", [], "any", false, false, false, 940), "html", null, true);
        echo "\"];
\t\t\t\t\t\t\t\t\tdata['actionType'] = 'tagUpdate';
\t\t\t\t\t\t\t\t\tdata['entityId'] = \$(e.currentTarget).attr(\"data-id\");
\t\t\t\t\t\t\t\t\tdata['action'] = 'create';
\t\t\t\t\t\t\t\t\tdata['name'] = text;

\t\t\t\t\t\t\t\t\t\$.ajax({
\t\t\t\t\t\t\t\t\t\turl : \"";
        // line 947
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_update_article_xhr");
        echo "\",
\t\t\t\t\t\t\t\t\t\ttype : 'POST',
\t\t\t\t\t\t\t\t\t\tdata : {data : data},
\t\t\t\t\t\t\t\t\t\tdataType : 'json',
\t\t\t\t\t\t\t\t\t\tsuccess: function (response) {
\t\t\t\t\t\t\t\t\t\t\tif(response.alertClass == \"success\") {
\t\t\t\t\t\t\t\t\t\t\t\tlet html = `
\t\t\t\t\t\t\t\t\t\t\t\t\t<a class=\"uv-btn-tag\" href=\"#\" data-id=\"\${response.tagId}\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"uv-tag\"><span class=\"uv-icon-remove-dark-before\"></span>\${response.tagName}</span>
\t\t\t\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t\t\t\t`;
\t\t\t\t\t\t\t\t\t\t\t\t\$('.uv-filtered-tags.tag').append(html);
\t\t\t\t\t\t\t\t\t\t\t}
\t\t\t\t\t\t\t\t\t\t\tinputElement.val('');
\t\t\t\t\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t\t\t\t\t},
\t\t\t\t\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t\t\t\t\t\tvar response = warningResponse;
\t\t\t\t\t\t\t\t\t\t\tif(xhr.responseJSON)
\t\t\t\t\t\t\t\t\t\t\t\tresponse = xhr.responseJSON;

\t\t\t\t\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t\t\t\t\t}
\t\t\t\t\t\t\t\t\t});
\t\t\t\t\t\t\t\t} else {
\t\t\t\t\t\t\t\t\tinputElement.addClass('uv-field-error');
\t\t\t\t\t\t\t\t\tinputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>";
        // line 977
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Tag with same name already exist"), "html", null, true);
        echo "</span>\");
\t\t\t\t\t\t\t\t}
\t\t\t\t\t\t\t} else {
\t\t\t\t\t\t\t\tinputElement.addClass('uv-field-error');
\t\t\t\t\t\t\t\tinputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>";
        // line 981
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Text length should be less than 35 charactors"), "html", null, true);
        echo "</span>\");
\t\t\t\t\t\t\t}
\t\t\t\t\t\t} else {
\t\t\t\t\t\t\tinputElement.addClass('uv-field-error');
\t\t\t\t\t\t\tinputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>";
        // line 985
        echo "Only character are allowed";
        echo "</span>\");
\t\t\t\t\t\t}
\t\t\t\t\t}
                },
            });

\t\t\tnew TagList({});

            var BodyView = Backbone.View.extend({
                el: 'body',
                events : {
\t\t\t\t\t'click #preview-modal .uv-pop-up-close' : \"removeModal\",
\t\t\t\t\t'click #preview-modal .uv-btn.cancel' : \"removeModal\",
\t\t\t\t\t'click #preview-modal .uv-btn.restore' : \"restore\",
\t\t\t\t},
\t\t\t\tremoveModal: function(e){
\t\t\t\t\te.preventDefault();
\t\t\t\t\tsetTimeout(function() {
\t\t\t\t\t\t\$(e.target).parents('#preview-modal').remove();
\t\t\t\t\t}, 500);
\t\t\t\t},
\t\t\t\trestore: function(e){
\t\t\t\t\te.preventDefault();

\t\t\t\t\tthis.removeModal(e);

\t\t\t\t\tformData = {};
\t\t\t\t\tformData['ids'] = ['";
        // line 1012
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 1012, $this->source); })()), "id", [], "any", false, false, false, 1012), "html", null, true);
        echo "'];
\t\t\t\t\tformData['actionType'] = 'contentUpdate';
\t\t\t\t\tformData['content'] = \$('#preview-modal .uv-html-preview').html();
\t\t\t\t\ttinyMCE.get('content').setContent(formData['content'])
\t\t\t\t\tarticleForm.articleEntityUpdate(formData);
\t\t\t\t\tarticleHistoryCollection.syncData();
\t\t\t\t},
\t\t\t\taddRelatedArticle: function(){
\t\t\t\t\tarticleRelatedCollection.syncData();
\t\t\t\t}
\t\t\t});
\t\t\tvar bodyView = new BodyView({});

            var PageView = Backbone.View.extend({
                el: '.uv-paper',
                events : {
                    'click .uv-aside-ticket-actions .uv-aside-select .uv-dropdown-list:not(.uv-no-patch) li': 'editArticleProperty',
\t\t\t\t\t'input .uv-field-block input' : 'searchFilterOption',
                },
                editArticleProperty: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    var uvSelect = currentElement.parents('.uv-aside-select');
                    var field = currentElement.parent().attr('data-action');
                    var value = currentElement.attr('data-index');
\t\t\t\t\tif(field == 'status'){
\t\t\t\t\t\tif(value == '1'){
\t\t\t\t\t\t\t\$('.uv-btn-action.uv-button-preview').removeAttr('disabled');
\t\t\t\t\t\t}else{
\t\t\t\t\t\t\t\$('.uv-btn-action.uv-button-preview').attr('disabled', 'disabled');
\t\t\t\t\t\t}
\t\t\t\t\t}
                    if(uvSelect.find('.uv-aside-select-value').attr('data-id') != value) {
                        var name = currentElement.text().trim();
                        app.appView.showLoader();
\t\t\t\t\t\tself = this;
                        this.model.save({ editType: field, value: value, id: self.model.id }, {
                            patch: true,
                            success: function (model, response, options) {
                                uvSelect.find('.uv-aside-select-value').attr('data-id', value).text(name)
                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(response);
                            },
                            error: function (model, xhr, options) {
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;
                                var response = warningResponse;
                                if(xhr.responseJSON)
                                    response = xhr.responseJSON;

                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(response);
                            }
                        });
                    }
                },
                searchFilterOption: function(e) {
                    self = this;
                    currentElement = Backbone.\$(e.currentTarget);
                    dropdown = currentElement.siblings('.uv-dropdown-list');
                    var filterType =  currentElement.attr('data-filter-type');
                    if(jQuery.inArray(filterType, ['tag', 'related']) !== -1) {
                        self.searchFilterXhr(currentElement);
                    }
                },
\t\t\t\tloaderTemplate : _.template(\$(\"#loader-tmp\").html()),
                searchFilterXhr: _.debounce(function(currentElement) {
                    var parent = currentElement.parent();
                    if(\$('.uv-dropdown-other.uv-dropdown-btn-active').parent().attr('id') != parent.attr('id'))
                        return;

                    parent.find(\"li:not(.uv-no-results, .uv-filter-info, .press-enter-to-add)\").remove();
                    parent.find(\".uv-filter-info\").show()
                    if(currentElement.val().length > 1) {
                        parent.append(this.loaderTemplate())
                        parent.find('.uv-filter-info').text(\"";
        // line 1086
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Searching", [], "messages");
        echo " ...\")
                        if(self.xhrReq)
                            self.xhrReq.abort();

\t\t\t\t\t\tlet filterType = currentElement.attr('data-filter-type');
\t\t\t\t\t\tlet path = (filterType == 'tag' ? \"";
        // line 1091
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("search_ticket_filter_options_xhr");
        echo "\" : \"";
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_article_collection_xhr");
        echo "\");
                        self.xhrReq = \$.ajax({
                            url : path,
                            type : 'GET',
                            data: {\"type\" : currentElement.attr('data-filter-type'), \"query\" : currentElement.val()},
                            dataType : 'json',
                            success : function(response) {
                                self.xhrReq = 0;
                                parent.find('.uv-loader').remove()
\t\t\t\t\t\t\t\tif(parent.find('.uv-dropdown-list').length) {
\t\t\t\t\t\t\t\t\tparent.find('.uv-dropdown-list').show();
\t\t\t\t\t\t\t\t}
                                parent.find('.uv-filter-info').text(\"";
        // line 1103
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Type atleast 2 letters"), "html", null, true);
        echo "\").hide();

\t\t\t\t\t\t\t\tif(filterType == 'tag'){
\t\t\t\t\t\t\t\t\tif(response.length == 0) {
\t\t\t\t\t\t\t\t\t\tparent.find('.press-enter-to-add').show()
\t\t\t\t\t\t\t\t\t}else{
\t\t\t\t\t\t\t\t\t\tparent.find('.press-enter-to-add').hide()
\t\t\t\t\t\t\t\t\t\tparent.find('.uv-no-results').hide();
\t\t\t\t\t\t\t\t\t\t_.each(response, function(item) {
\t\t\t\t\t\t\t\t\t\t\tparent.find('.uv-dropdown-list ul').append(\"<li data-id='\" + item.id + \"'>\" + item.name + \"</li>\")
\t\t\t\t\t\t\t\t\t\t});
\t\t\t\t\t\t\t\t\t}
\t\t\t\t\t\t\t\t}else{
\t\t\t\t\t\t\t\t\tif(response.results.length == 0) {
\t\t\t\t\t\t\t\t\t\tparent.find('.press-enter-to-add').hide()
\t\t\t\t\t\t\t\t\t\tparent.find('.uv-no-results').show()
\t\t\t\t\t\t\t\t\t}
\t\t\t\t\t\t\t\t\t_.each(response.results, function(item) {
\t\t\t\t\t\t\t\t\t\tparent.find('.press-enter-to-add').hide()
\t\t\t\t\t\t\t\t\t\tparent.find('.uv-no-results').hide();
\t\t\t\t\t\t\t\t\t\tif(item.id != ";
        // line 1123
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 1123, $this->source); })()), "id", [], "any", false, false, false, 1123), "html", null, true);
        echo ")
\t\t\t\t\t\t\t\t\t\t\tparent.find('.uv-dropdown-list ul').append(\"<li data-id='\" + item.id + \"'>\" + item.name + \"</li>\")
\t\t\t\t\t\t\t\t\t});
\t\t\t\t\t\t\t\t}
                            },
                            error: function (xhr) {
                                self.xhrReq = 0;
                                parent.find('.uv-loader').remove()
                                parent.find('.uv-no-results').hide();
                                parent.find('.uv-filter-info').text(\"";
        // line 1132
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Type atleast 2 letters"), "html", null, true);
        echo "\").show();
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;
                            }
                        });
                    } else {
\t\t\t\t\t\tparent.find('.uv-no-results').hide();
\t\t\t\t\t}
                },1000),
            });

\t\t\tvar pageView = new PageView({
\t\t\t\tmodel : articlemodel
\t\t\t});
\t\t});
\t</script>
\t";
        // line 1148
        echo twig_include($this->env, $context, "@UVDeskSupportCenter/Templates/tinyMCE.html.twig");
        echo "
    <script>
\t\t";
        // line 1157
        echo "\t\t
        
    </script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Staff/Articles/articleForm.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1630 => 1157,  1625 => 1148,  1606 => 1132,  1594 => 1123,  1571 => 1103,  1554 => 1091,  1546 => 1086,  1469 => 1012,  1439 => 985,  1432 => 981,  1425 => 977,  1392 => 947,  1382 => 940,  1342 => 903,  1316 => 880,  1249 => 816,  1224 => 794,  1211 => 784,  1207 => 783,  1182 => 761,  1121 => 703,  1117 => 702,  1113 => 701,  1108 => 700,  1104 => 699,  1097 => 695,  1086 => 687,  1039 => 643,  1017 => 624,  1010 => 620,  988 => 601,  970 => 585,  961 => 583,  957 => 582,  907 => 535,  884 => 515,  832 => 466,  792 => 429,  788 => 428,  778 => 421,  774 => 420,  758 => 407,  740 => 392,  735 => 390,  728 => 386,  720 => 383,  714 => 380,  709 => 378,  684 => 357,  674 => 356,  611 => 302,  601 => 295,  595 => 292,  589 => 289,  581 => 284,  566 => 272,  561 => 270,  552 => 264,  547 => 262,  542 => 260,  533 => 254,  528 => 252,  523 => 250,  514 => 244,  509 => 242,  504 => 240,  492 => 231,  487 => 229,  477 => 222,  472 => 220,  457 => 208,  450 => 204,  443 => 200,  437 => 199,  425 => 190,  421 => 189,  417 => 188,  413 => 187,  402 => 181,  396 => 180,  388 => 175,  379 => 168,  376 => 167,  367 => 164,  362 => 163,  357 => 162,  355 => 161,  345 => 154,  339 => 151,  333 => 148,  327 => 145,  319 => 140,  302 => 126,  298 => 125,  293 => 123,  286 => 119,  282 => 118,  277 => 116,  266 => 108,  262 => 107,  257 => 105,  250 => 101,  246 => 100,  241 => 98,  227 => 86,  224 => 85,  214 => 81,  209 => 80,  204 => 79,  202 => 78,  194 => 73,  191 => 72,  182 => 69,  177 => 68,  173 => 67,  167 => 64,  159 => 59,  142 => 47,  136 => 44,  127 => 40,  93 => 8,  83 => 7,  70 => 4,  60 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %}
\t{{ 'Article'|trans }}
{% endblock %}

{% block pageContent %}
\t<style>
\t.uv-tab-error {
\t\tborder-bottom: 3px solid #FF5656 !important;
\t}
\t.mce-menu-item.mce-disabled .mce-text {
\t\tcolor: #333;
\t}
\t.uv-field-block .uv-dropdown-list.uv-top-left, .uv-field-block .uv-dropdown-list.uv-top-right{
    \t/*top: -90px;
\t\tbottom: auto;*/
\t}
\t.uv-vtop {
\t\tvertical-align: top;
\t}
\tdiv + .uv-no-translated-revision {
\t\tdisplay: none;
\t}
\t@media screen and (min-width: 1100px) {
\t\t.uv-inner-section .uv-view .uv-ticket-action-bar .uv-ticket-action-bar-lt {
\t\t\twidth: auto;
\t\t}
\t\t.uv-inner-section .uv-view .uv-ticket-action-bar .uv-ticket-action-bar-rt {
\t\t\twidth: auto;
\t\t\tfloat: right;
\t\t}
\t\t.uv-rtl .uv-inner-section .uv-view .uv-ticket-action-bar .uv-ticket-action-bar-rt {
\t\t\tfloat: left;
\t\t}
\t}
\t</style>

\t<div class=\"uv-inner-section uv-article\">
        <div class=\"uv-aside uv-category\" style=\"overflow-x: hidden;{% if app.request.cookies and app.request.cookies.get('uv-asideView') %}display: none;{% endif %}\">
\t\t    <div class=\"uv-main-info-block\">
\t\t\t\t<div class=\"uv-aside-head\">
\t\t\t\t\t<div class=\"uv-aside-title\">
\t\t\t\t\t\t<h6>{{ 'Article'|trans }}</h6>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"uv-aside-back\">
\t\t\t\t\t\t<span onclick=\"window.location = '{{ app.request.headers.get('referer') ? app.request.headers.get('referer') : path('helpdesk_member_knowledgebase_article_collection')}}'\"> {{ 'Back'|trans }}</span>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>

\t\t\t<!--Aside Brick-->
\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t<!--Ticket Actions-->
\t\t\t\t<div class=\"uv-aside-ticket-actions\">

\t\t\t\t\t<!-- Field -->
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Categories'|trans }}</label>
\t\t\t\t\t\t<div class=\"uv-field-block\" id=\"categoryUpdate\">
\t\t\t\t\t\t\t<input class=\"uv-field uv-dropdown-other preloaded\" type=\"text\" id=\"category-filter-input\">
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left uv-width-100\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>{{ 'Filter With'|trans }}</label>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<ul class=\"uv-agents-list\">
\t\t\t\t\t\t\t\t\t{% for category in categories %}
\t\t\t\t\t\t\t\t\t\t<li data-id=\"{{category.id}}\">
\t\t\t\t\t\t\t\t\t\t\t{{category.name}}
\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t\t\t\t<li class=\"uv-no-results\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t{{ 'No result found'|trans }}
\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"uv-filtered-tags\">
\t\t\t\t\t\t\t\t{% if articleCategory %}
\t\t\t\t\t\t\t\t\t{% for category in articleCategory %}
\t\t\t\t\t\t\t\t\t\t<a class=\"uv-btn-small default\" href=\"#\" data-id=\"{{ category.id }}\">
\t\t\t\t\t\t\t\t\t\t\t{{ category.name }}
\t\t\t\t\t\t\t\t\t\t\t<span class=\"uv-icon-remove\"></span>
\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t</div>

\t\t\t<!--Aside Brick-->
\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t<!--Ticket Actions-->
\t\t\t\t<div class=\"uv-aside-ticket-actions\">
\t\t\t\t\t<div class=\"uv-aside-select\">
\t\t\t\t\t\t<label class=\"uv-aside-select-label\">{{ 'Status'|trans }}</label>
\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t<span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"{{ article.status }}\">
\t\t\t\t\t\t\t\t{{ article.status == 1 ? 'Published'|trans : 'Draft'|trans  }}
\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>{{ 'Status'|trans }}</label>
\t\t\t\t\t\t\t\t\t<ul class=\"status\" data-action=\"status\">
\t\t\t\t\t\t\t\t\t\t<li data-index=\"1\"><a href=\"#\">{{ 'Published'|trans }}</a></li>
\t\t\t\t\t\t\t\t\t\t<li data-index=\"0\"><a href=\"#\">{{ 'Draft'|trans }}</a></li>
\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t\t<div class=\"uv-aside-select\">
\t\t\t\t\t\t<label class=\"uv-aside-select-label\">{{ 'Make as Starred'|trans }}</label>
\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t<span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"{{ article.stared }}\">
\t\t\t\t\t\t\t\t{{ article.stared == 1 ? 'Yes'|trans : 'No'|trans  }}
\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>{{ 'Starred'|trans }}</label>
\t\t\t\t\t\t\t\t\t<ul class=\"stared\" data-action=\"stared\">
\t\t\t\t\t\t\t\t\t\t<li data-index=\"1\"><a href=\"#\">{{ 'Yes'|trans }}</a></li>
\t\t\t\t\t\t\t\t\t\t<li data-index=\"0\"><a href=\"#\">{{ 'No'|trans }}</a></li>
\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>

\t\t\t<!--Aside Brick-->
\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t<!--Ticket Actions-->
\t\t\t\t<div class=\"uv-aside-ticket-actions\">
\t\t\t\t\t<div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Tag'|trans }}</label>
                        <div class=\"uv-field-block\" id=\"tagUpdate\">
                            <input class=\"uv-field uv-dropdown-other\" type=\"text\" data-filter-type=\"tag\" id=\"tag-filter-input\">
                            <div class=\"uv-dropdown-list uv-bottom-left uv-width-100\">
                                <div class=\"uv-dropdown-container\">
                                    <label>{{ 'Filter With'|trans }}</label>
                                    <ul class=\"\">
                                        <li class=\"uv-filter-info\">
                                            {{ 'Type atleast 2 letters'|trans }}
                                        </li>
                                        <li class=\"uv-no-results\" style=\"display: none;\">
                                            {{ 'No result found'|trans }}
                                        </li>
\t\t\t\t\t\t\t\t\t\t<li class=\"press-enter-to-add\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t\t{{ 'Press Enter to add'|trans }}
\t\t\t\t\t\t\t\t\t\t</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
\t\t\t\t\t\t<div class=\"uv-filtered-tags tag\">
\t\t\t\t\t\t\t{% if articleTags %}
\t\t\t\t\t\t\t\t{% for tag in articleTags %}
\t\t\t\t\t\t\t\t\t<a class=\"uv-btn-tag\" href=\"#\" data-id=\"{{ tag.id }}\">
\t\t\t\t\t\t\t\t\t\t<span class=\"uv-tag\"><span class=\"uv-icon-remove-dark-before\"></span>{{ tag.name }}</span>
\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t</div>
                    </div>

\t\t\t\t</div>
\t\t\t</div>

\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t<span class=\"uv-text-danger uv-cursor delete-article\">{{ \"Delete Article\"|trans }}
\t\t\t</div>

        </div>

\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
\t\t\t<div class=\"uv-ticket-scroll-region uv-margin-0 {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view-tv{% endif %}\">
\t\t\t\t<div class=\"uv-ticket-action-bar\">
\t\t\t\t\t<div class=\"uv-ticket-action-bar-lt\">
\t\t\t\t\t\t<!--Tabs-->
\t\t\t\t\t\t<div class=\"uv-tabs\" id=\"article-section-tab\">
\t\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t\t<li for=\"article-edit\" class=\"uv-tab-active\">{{ 'Article'|trans }}</li>
\t\t\t\t\t\t\t\t<li for=\"article-seo\" style=\"display:inline-block;\">{{ 'SEO'|trans }}</li>
\t\t\t\t\t\t\t\t<li for=\"article-history\" style=\"display:inline-block;\">{{ 'Revisions'|trans }}</li>
\t\t\t\t\t\t\t\t<li for=\"article-related\" class=\"article-other-info\" style=\"display:inline-block;\">{{ 'Related Articles'|trans }}</li>
\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!--Tabs-->
\t\t\t\t\t</div>

\t\t\t\t\t<div class=\"uv-ticket-action-bar-rt\">

\t\t\t\t\t\t<span class=\"uv-action-buttons\">
\t\t\t\t\t\t\t<a href=\"{{path('helpdesk_knowledgebase_read_slug_article', {'slug': article.slug })}}\" target=\"_blank\" type=\"button\" class=\"uv-btn-action uv-margin-right-5 uv-button-preview\" {{ article.status ? '' : 'disabled=\"disabled\"'}} id=\"preview-link\">
\t\t\t\t\t\t\t\t<span class=\"uv-icon-eye-light\"></span> {{'view'|trans}}
\t\t\t\t\t\t\t</a>

\t\t\t\t\t\t\t<a href=\"#\" type=\"button\" class=\"uv-btn-action uv-margin-right-5\" id=\"preview-article\">
\t\t\t\t\t\t\t\t<span class=\"uv-icon-eye-light\"></span> {{'preview'|trans}}
\t\t\t\t\t\t\t</a>

\t\t\t\t\t\t\t<a href=\"#\" type=\"button\" class=\"uv-btn-action update-btn\">
\t\t\t\t\t\t\t\t<span class=\"uv-icon-publish-light\"></span> {{'Update'|trans}}
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</span>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<!-- Form -->
\t\t\t\t<form method=\"post\" action=\"\" id=\"article-form\" style=\"width: 97%;\">
\t\t\t\t\t<div id=\"original-article\" class=\"article-instances\">
\t\t\t\t\t\t<div class=\"uv-tab-view uv-tab-view-active\" id=\"article-edit\">
\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Title'|trans }}</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t\t<input name=\"name\" class=\"uv-field\" type=\"text\" value=\"{{ article.name }}\">
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block uv-element-block-textarea\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Content'|trans }}</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block uv-margin-top-5\">
\t\t\t\t\t\t\t\t\t<textarea name=\"content\" class=\"uv-field\" id=\"article_content\">{{article.content}}</textarea>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<div class=\"uv-tab-view\" id=\"article-seo\">
\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Slug'|trans }}</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t\t<input name=\"slug\" class=\"uv-field\" type=\"text\" value=\"{{ article.slug }}\">
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<span class=\"uv-field-info\">{{'Slug is the url identity of this article. We will help you to create valid slug at time of typing.'|trans}}</span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Meta Title'|trans }}</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t\t<input name=\"metaTitle\" class=\"uv-field\" type=\"text\" value=\"{{ article.metaTitle }}\">
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<span class=\"uv-field-info\">{{\"Title tags and meta descriptions are bits of HTML code in the header of a web page. They help search engines understand the content on a page. A page's title tag and meta description are usually shown whenever that page appears in search engine results\"|trans}}</span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Meta Keywords'|trans }}</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t\t<input name=\"keywords\" class=\"uv-field\" type=\"text\" value=\"{{ article.keywords }}\">
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<span class=\"uv-field-info\">{{'comma \",\" separated'|trans}}</span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Meta Description'|trans }}</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t\t<textarea name=\"metaDescription\" class=\"uv-field\">{{article.metaDescription}}</textarea>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<div class=\"uv-tab-view\" id=\"article-history\">
\t\t\t\t\t\t\t<div class=\"uv-table uv-list-view\"></div>
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<div class=\"uv-tab-view\" id=\"article-related\">
\t\t\t\t\t\t\t<div class=\"uv-element-block \">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Article Title'|trans }}</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block related\">
\t\t\t\t\t\t\t\t\t<input class=\"uv-field uv-dropdown-other\" type=\"text\" data-filter-type=\"related\" id=\"related-filter-input\">
\t\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left uv-width-100\">
\t\t\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t\t\t<label>{{ 'Filter With'|trans }}</label>
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"\">
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"uv-filter-info\">
\t\t\t\t\t\t\t\t\t\t\t\t\t{{ 'Type atleast 2 letters'|trans }}
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"uv-no-results\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t\t\t\t{{ 'No result found'|trans }}
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t<span class=\"uv-field-info\">{{'Start typing few charactors and add set of relevant article from the list'|trans}}</span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"uv-table uv-list-view\"></div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</form>
\t\t\t</div>
\t\t</div>
\t</div>

\t<style>
\t\t.uv-revision-parent{
\t\t\tmargin-bottom: 20px;
\t\t\twidth: 100%;
\t\t\toverflow: hidden;
\t\t}
\t\t.uv-revision-left{
\t\t\tdisplay: inline-block;
\t\t\twidth: 40px;
\t\t\theight: 100%;
\t\t\tposition: absolute;
\t\t}
\t\t.uv-revision-right{
\t\t\tdisplay: inline-block;
\t\t\twidth: 100%;
\t\t\tmargin-left: 40px;
\t\t\tborder-bottom: solid 1px #D3D3D3;
\t\t\tpadding-bottom: 20px;
\t\t}
\t\t.uv-revision-right div{
\t\t\tmargin-bottom: 3px;
\t\t}
\t\t.uv-revision-right div:nth-child(1){
\t\t\tcolor: #737373;
\t\t}
\t\t.uv-inner-section.uv-article .uv-view .uv-ticket-action-bar{
\t\t\tmargin-top: 20px;
\t\t\tmargin-bottom: 25px;
\t\t}
\t\t.uv-related {
\t\t\twidth: 100%;
\t\t\tborder-top: solid 1px #D3D3D3;
\t\t\tpadding: 10px 0px;
\t\t}
\t\t#article-related a.uv-btn-stroke.remove {
\t\t\tpadding: 2px 4px;
    \t\tmargin-right: 4px;
\t\t}
\t\t.uv-pop-up-box{
\t\t\toverflow: hidden;
\t\t}
\t</style>
{% endblock %}

{% block footer %}
\t{{ parent() }}

\t<script id=\"article_related_list_item_tmp\" type=\"text/template\">
\t\t<div class=\"uv-related\">
\t\t\t<a class=\"uv-btn-tag remove-event-select remove\" data-id=\"<%= id %>\" data-article-id=\"<%= articleId %>\" href=\"#\">
\t\t\t\t<span class=\"uv-icon-remove-dark-box\"></span>
\t\t\t</a>
\t\t\t<%- name %>
\t\t</div>
    </script>

\t<script id=\"article_history_list_item_tmp\" type=\"text/template\">
\t\t<div class=\"uv-revision-parent\">
\t\t\t<div class=\"uv-revision-left\">
\t\t\t\t<% if(isCurrent){ %>
\t\t\t\t\t<span class=\"uv-icon-history uv-icon-history-active\"></span>
\t\t\t\t<% }else{ %>
\t\t\t\t\t<span class=\"uv-icon-history\"></span>
\t\t\t\t<% } %>
\t\t\t</div>
\t\t\t<div class=\"uv-revision-right\">
\t\t\t\t<div>{{ \"Revision\"|trans }} #<%= id %>
\t\t\t\t\t<% if(isCurrent){ %>
\t\t\t\t\t\t<span>({{\"Published\"|trans}})</span>
\t\t\t\t\t<% } %>
\t\t\t\t</div>
\t\t\t\t<div><%- name %> {{ \"updated the article\"|trans }} <span class=\"timeago\" data-timestamp=\"<%= dateAdded.timestamp %>\"> {{ \"on\"|trans }} <%= dateAdded.format %></span></div>
\t\t\t\t<div class=\"uv-action-buttons\">
\t\t\t\t\t<a href=\"#\" type=\"button\" class=\"uv-btn-small history-preview\" data-id=\"<%= id %>\">
\t\t\t\t\t\t{{\"Preview\"|trans}}
\t\t\t\t\t</a>
\t\t\t\t\t<a href=\"#\" type=\"button\" class=\"uv-btn-small <% if(hasContent && !isCurrent){ %>history-restore<% } %>\"  <% if(isCurrent || !hasContent){ %>disabled=\"disabled\" <% } %>>
\t\t\t\t\t\t<% if(isCurrent){ %>
\t\t\t\t\t\t\t{{\"Restored\"|trans}}
\t\t\t\t\t\t<% }else{ %>
\t\t\t\t\t\t\t{{\"Restore\"|trans}}
\t\t\t\t\t\t<% } %>
\t\t\t\t\t</a>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
    </script>

\t<script id=\"article_preview_html\" type=\"text/template\">
\t\t<div class=\"uv-pop-up-overlay\" id=\"preview-modal\" style=\"display:block;\">
\t\t\t<div class=\"uv-pop-up-box uv-pop-up-wide\">
\t\t\t\t<span class=\"uv-pop-up-close\"></span>
\t\t\t\t<div class=\"uv-html-preview\" style=\"margin-bottom: 30px;\">
\t\t\t\t</div>
\t\t\t\t<div class=\"uv-pop-up-actions\">
\t\t\t\t\t<a href=\"#\" class=\"uv-btn cancel\">{{ 'Close'|trans }}</a>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
    </script>

\t<script id=\"article_history_view_html\" type=\"text/template\">
\t\t<div class=\"uv-pop-up-overlay\" id=\"preview-modal\" style=\"display:block;\">
\t\t\t<div class=\"uv-pop-up-box uv-pop-up-wide\">
\t\t\t\t<span class=\"uv-pop-up-close\"></span>
\t\t\t\t<div class=\"uv-html-preview\">
\t\t\t\t</div>
\t\t\t\t<div class=\"uv-pop-up-actions\">
\t\t\t\t\t<a href=\"#\" class=\"uv-btn uv-btn-error restore\">{{ 'Restore'|trans }}</a>
\t\t\t\t\t<a href=\"#\" class=\"uv-btn cancel\">{{ 'Cancel'|trans }}</a>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
    </script>

\t<script type=\"text/javascript\">
\t\tvar path_history = \"{{ path('helpdesk_member_knowledgebase_revision_article', {'id': article.id }) }}\"
\t\tvar path_related = \"{{ path('helpdesk_member_knowledgebase_related_article_xhr', {'id': article.id }) }}\"

\t\t\$.fn.serializeFormObject = function () {
\t\t\tvar o = {};
\t\t\tvar outputCopy = o;
\t\t\tvar a = this.serializeArray();
\t\t\tvar regex = /(\\w+)+/g;
\t\t\t\$.each(a, function (index, item) {
\t\t\t\tvar keys = item.name.match(regex);
\t\t\t\tkeys.forEach(function (key, localIndex) {
\t\t\t\t\tif (!outputCopy.hasOwnProperty(key)) {
\t\t\t\t\t\toutputCopy[key] = {};
\t\t\t\t\t}
\t\t\t\t\tif(localIndex == keys.length - 1) {
\t\t\t\t\t\toutputCopy[key] = isNaN(item.value)|| item.value == '' || item.value == null  ? item.value : +item.value;
\t\t\t\t\t}
\t\t\t\t\toutputCopy = outputCopy[key];
\t\t\t\t});
\t\t\t\toutputCopy = o;
\t\t\t});
\t\t\treturn o;
\t\t};

\t\t\$(function () {
\t\t\tvar globalMessageResponse = \"\";

\t\t\tvar ArticleForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn-action.update-btn' : \"saveArticle\",
\t\t\t\t\t'blur input': 'formChanged',

                    'click .uv-dropdown-list li': 'addEntity',
                    'click .uv-filtered-tags .uv-btn-small': 'removeEntity',
                    'click .uv-filtered-tags .uv-btn-tag': 'removeEntity',
\t\t\t\t\t'click .delete-article' : 'confirmRemove'
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.articleId = \"{{app.request.attributes.get('id')}}\";
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t},
                addEntity: function(e) {
                    let currentElement = Backbone.\$(e.currentTarget);
                    if(id = currentElement.attr(\"data-id\")) {
                    \tvar coreParent = Backbone.\$(e.currentTarget).parents('.uv-element-block');
                    \tvar parent = coreParent.find(\".uv-field-block\");
                        parent.find(\"li:not(.uv-no-results)\").show();

                        if(parent.hasClass('related')) {
\t\t\t\t\t\t\tlet parentTab = parent.parents('#article-related');

\t\t\t\t\t\t\tif(!parentTab.find(\".uv-list-view a[data-article-id='\" + id + \"']\").length) {
\t\t\t\t\t\t\t\tvar data = {};
\t\t\t\t\t\t\t\tdata['ids'] = [this.articleId];
\t\t\t\t\t\t\t\tdata['actionType'] = 'relatedUpdate'
\t\t\t\t\t\t\t\tdata['entityId'] = id;
\t\t\t\t\t\t\t\tdata['action'] = 'add';
\t\t\t\t\t\t\t\tthis.articleEntityUpdate(data);
\t\t\t\t\t\t\t}
\t\t\t\t\t\t}else{
\t\t\t\t\t\t\tvar inputElement = Backbone.\$('#tag-filter-input');
\t\t\t\t\t\t\tinputElement.removeClass('uv-field-error');
\t\t\t\t\t\t\tinputElement.parents('.uv-element-block').find('.uv-field-message').remove();

\t\t\t\t\t\t\tinputElement.val('');

\t\t\t\t\t\t\tif(!coreParent.find(\".uv-filtered-tags a[data-id='\" + id + \"']\").length) {
\t\t\t\t\t\t\t\tlet html = '';
\t\t\t\t\t\t\t\tif(parent[0].id == 'tagUpdate'){
\t\t\t\t\t\t\t\t\thtml = `
\t\t\t\t\t\t\t\t\t\t<a class=\"uv-btn-tag\" href=\"#\" data-id=\"\${id}\">
\t\t\t\t\t\t\t\t\t\t\t<span class=\"uv-tag\"><span class=\"uv-icon-remove-dark-before\"></span>\${currentElement.text()}</span>
\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t`;
\t\t\t\t\t\t\t\t}else{
\t\t\t\t\t\t\t\t\thtml = \"<a class='uv-btn-small default' href='#' data-id='\" + id + \"'>\"+currentElement.text()+\"<span class='uv-icon-remove'></span></a>\";
\t\t\t\t\t\t\t\t}

\t\t\t\t\t\t\t\tcoreParent.find('.uv-filtered-tags').append(html)
\t\t\t\t\t\t\t\tvar data = {};
\t\t\t\t\t\t\t\tdata['ids'] = [this.articleId];
\t\t\t\t\t\t\t\tdata['actionType'] = parent[0].id;
\t\t\t\t\t\t\t\tdata['entityId'] = id;
\t\t\t\t\t\t\t\tdata['action'] = 'add';
\t\t\t\t\t\t\t\tthis.articleEntityUpdate(data);
\t\t\t\t\t\t\t}else {
\t\t\t\t\t\t\t\tinputElement.addClass('uv-field-error');
\t\t\t\t\t\t\t\tinputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>{{ 'Tag with same name already exist'|trans }}</span>\");
\t\t\t\t\t\t\t}
\t\t\t\t\t\t}
                    }
                },
                removeEntity: function(e) {
                    var parent = Backbone.\$(e.currentTarget).parents('.uv-element-block').find(\".uv-field-block\")
                    Backbone.\$(e.currentTarget).remove();

\t\t\t\t\tvar data = {};
\t\t\t\t\tdata['ids'] = [this.articleId];
\t\t\t\t\tdata['actionType'] = parent[0].id;
\t\t\t\t\tdata['entityId'] = \$(e.currentTarget).attr(\"data-id\");
\t\t\t\t\tdata['action'] = 'remove';
\t\t\t\t\tthis.articleEntityUpdate(data);
                },
\t\t\t\tarticleEntityUpdate : function(data) {
                    var self = this;
                    app.appView.showLoader();
                    \$.ajax({
                        url : \"{{ path('helpdesk_member_knowledgebase_update_article_xhr') }}\",
                        type : 'POST',
                        data : {data : data},
                        dataType : 'json',
                        success : function(response) {
                            app.appView.hideLoader();

\t\t\t\t\t\t\tif (data['actionType'] == 'relatedUpdate') {
\t\t\t\t\t\t\t\tarticleRelatedCollection.syncData();
\t\t\t\t\t\t\t}

\t\t\t\t\t\t\tif(response.alertClass == \"success\") {
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t\t} else{
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t\t\tself.addErrors(response.errors);
\t\t\t\t\t\t\t}
                        },
                        error: function (xhr) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        }
                    });
                },
\t\t\t\tformChanged: function(e) {
\t\t\t    \tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t    },
\t\t\t\tsaveArticle: function (e) {
\t\t\t\t\te.preventDefault();
\t\t\t\t\t\$(\".uv-tabs li\").removeClass('uv-tab-error')
                    currentElement = Backbone.\$(e.currentTarget);
                    this.model.clear();
\t\t\t\t\tlet formData = this.\$el.find('form#article-form').serializeFormObject();
\t\t\t        this.model.set(formData);
                    self = this;
\t\t\t\t\tvar contentNotHasError = this.validateForm(e);
\t\t\t        if(this.model.isValid(true) && contentNotHasError) {
\t\t\t\t\t\tformData['ids'] = [this.articleId];
\t\t\t\t\t\tformData['actionType'] = 'articleUpdate';
\t\t\t\t\t\tformData['content'] = \$('textarea#article_content').val();
\t\t\t\t\t\t{% for localeCode, localeName in uvdesk_service.getLocales() %}
\t\t\t\t\t\t\tvar localeType = '{{ localeCode }}';
\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\tthis.articleEntityUpdate(formData);
\t\t\t        } else {
                        \$('.uv-field-message').each(function(e) {
                            \$(\".uv-tabs li[for='\" + \$(this).parents('.uv-tab-view').attr('id') + \"']:not(.uv-tab-active)\").addClass('uv-tab-error')
                        });
                    }
\t\t\t\t},
                validateForm : function(e) {
                    var element = Backbone.\$(e.currentTarget);
                    formType = 'content';
                    form = \$('#article-form');
                    form.find('.uv-field-message').remove()
                    var html = \$('.uv-field').text();
                    if(app.appView.htmlText(html).trim().length != 0) {
\t\t\t\t\t\treturn true;
                    } else {
                        form.find('.uv-element-block-textarea').append(\"<span class='uv-field-message'>{{ 'This field is mandatory'|trans }}</span>\");
                    }
                },
                addErrors: function(jsonContext) {
\t\t    \t\tfor (var field in jsonContext) {
\t\t    \t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
                },
                confirmRemove: function(e) {
                    e.preventDefault();
                    this.currentEvent = e;

                    app.appView.openConfirmModal(this)
                },
                removeItem: function(e) {
                    var data = {};

                    data['actionType'] = \"delete\";

                    data['ids'] = [\"{{article.id}}\"];
\t\t\t\t\tthis.articleEntityUpdate(data);

\t\t\t\t\tsetTimeout(function(){
                    \twindow.location = '{{ app.request.headers.get('referer') ? app.request.headers.get('referer') : path('helpdesk_member_knowledgebase_article_collection')}}';
\t\t\t\t\t}, 1000);
                },
\t\t\t});

\t\t\tvar ArticleFullView = Backbone.View.extend({
\t\t\t\tel: \$('body'),
\t\t\t\tpreviewTemplate : _.template(\$(\"#article_preview_html\").html()),
\t\t\t\tevents: {
\t\t\t\t\t'click #preview-link': 'previewArticle',
\t\t\t\t\t'click #preview-article': 'renderArticlePreview',
\t\t\t\t\t'click #article-locale li': 'closeDropdown',
\t\t\t\t},
\t\t\t\tpreviewArticle: function(e) {
\t\t\t\t\tvar target = \$(e.target).closest('.uv-button-preview');
\t\t\t\t\tvar isDisabled = target.attr('disabled') ? true : false;
\t\t\t\t\tvar lang = \$('#article-locale').attr('data-value');
\t\t\t\t\tif(lang && !isDisabled) {
\t\t\t\t\t\te.preventDefault();
\t\t\t\t\t\tvar langSpecificUrl = target.attr('href').replace('{{ app.request.locale }}', lang);
\t\t\t\t\t\twindow.open(langSpecificUrl);
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\trenderArticlePreview: function(e){
\t\t\t\t\te.preventDefault();
\t\t\t\t\tvar article_content = \$('#article_content').val();
\t\t\t\t\t//tinyMCE.get('content').focus();
\t\t\t\t\tconsole.log(article_content);
\t\t\t\t\tarticle_content

\t\t\t\t\t\$('body').append(this.previewTemplate());
\t\t\t\t\t\$('body').find('#preview-modal .uv-html-preview').html('<h1 style=\"margin-bottom: 30px;\">' + articlemodel.attributes.name + '</h1>' + article_content);
\t\t\t\t\t
\t\t\t\t\t//\$('body').find('#preview-modal .uv-html-preview').html('<h1 style=\"margin-bottom: 30px;\">' + articlemodel.attributes.name + '</h1>' + tinyMCE.activeEditor.getContent());
\t\t\t\t},
\t\t\t});

            var ArticleModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'name': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: 'This field is mandatory'
\t\t\t\t\t},{
\t\t\t\t\t\tmaxLength:200,
\t\t\t\t\t\tmsg: 'This field contain maximum 200 charecters only'
\t\t\t\t\t}, {
\t\t\t\t\t\tpattern: '^((?![\$%<]).)*\$',
\t\t\t\t\t\tmsg: 'This field must have valid characters only'
\t\t\t\t\t}],
\t\t\t\t\t'metaTitle':[{
\t\t\t\t\t\tmaxLength:200,
\t\t\t\t\t\tmsg: 'This field contain mata title maximum 200 charecters only'
\t\t\t\t\t}],
\t\t\t\t\t'keywords':[{
\t\t\t\t\t\tmaxLength:200,
\t\t\t\t\t\tmsg: 'This field contain keywords maximum 200 charecters only'
\t\t\t\t\t}],
\t\t\t\t\t'slug': function(val, attr, computed) {
\t\t\t\t\t\tvar elSlug = \$(\"[name=\" + attr + \"]\");
\t\t\t\t\t\tvar elSlugValue = '';
\t\t\t\t\t\telSlug.val(elSlugValue = app.appView.convertToSlug(val))
\t\t\t\t\t
\t\t\t\t\t\tif(elSlugValue.trim() == ''){
\t\t\t\t\t\t\treturn '{{ \"This field is mandatory\"|trans }}';
\t\t\t\t\t\t}
\t\t\t\t\t\t
\t\t\t\t\t\tif(elSlugValue.length > 100) {
\t\t\t\t\t\t\treturn \"This field slug contains maximum 100 charecters only.\";
\t\t\t\t\t\t}
\t\t\t\t\t}
\t\t\t\t},
                urlRoot : \"{{ path('helpdesk_member_knowledgebase_update_article_xhr') }}\"
\t\t\t});

\t\t\tvar articlemodel = new ArticleModel({
                id : \"{{ article.id }}\",
                name : \"{{ article.name|replace({\"\\n\":' ', \"\\r\":' '}) }}\",
                slug : \"{{ article.slug }}\",
\t\t\t\tstatus: \"{{ article.status }}\",
\t\t\t\tstared: \"{{ article.stared }}\",
\t\t\t})

\t\t\tarticleForm = new ArticleForm({
                el: '.uv-paper',
\t\t\t\t//el : \$(\".uv-aside.uv-category\"),
\t\t\t\tmodel : articlemodel
\t\t\t});

\t\t\tvar articleFullView = new ArticleFullView();

            var ArticleHistoryModel = Backbone.Model.extend({
                urlRoot : path_history
\t\t\t});

\t\t\tvar ArticleHistoryCollection = AppCollection.extend({
\t\t\t\tmodel : ArticleHistoryModel,
\t\t\t\turl : path_history,
\t\t\t\tfilterParameters : {
\t\t\t\t\t\"isActive\" : \"\",
\t\t\t\t\t\"search\" : \"\"
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.syncData();
\t\t\t\t},
\t\t\t\tparseRecords: function (resp, options) {
\t\t\t\t\treturn resp;
\t\t\t\t},
\t\t\t\tsyncData : function() {
\t\t\t\t\tapp.appView.showLoader();
\t\t\t\t\tthis.fetch({
\t\t\t\t\t\tdata : this.getValidParameters(),
\t\t\t\t\t\treset: true,
\t\t\t\t\t\tsuccess: function(model, response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tvar articleHistoryListView = new ArticleHistoryList();

\t\t\t\t\t\t\tif(globalMessageResponse)
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(globalMessageResponse);
\t\t\t\t\t\t\tglobalMessageResponse = null;
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t}
\t\t\t});

\t\t\tvar ArticleHistoryItem = Backbone.View.extend({
\t\t\t\ttagName : \"div\",
\t\t\t\ttemplate : _.template(\$(\"#article_history_list_item_tmp\").html()),
\t\t\t\tpreviewTemplate : _.template(\$(\"#article_history_view_html\").html()),
\t\t\t\tevents: {
\t\t\t\t\t'click .history-preview' : \"preview\",
\t\t\t\t\t'click .history-restore' : \"restore\",
\t\t\t\t},
\t\t\t\trender : function() {
\t\t\t\t\tvar tinymceContent = `{{ article.content|raw }}`;
\t\t\t\t\tthis.\$el.html(this.template(\$.extend(this.model.toJSON(), {
\t\t\t\t\t\tisCurrent: (this.model.attributes.content.trim() == tinymceContent ? true : false),
\t\t\t\t\t\thasContent: (this.model.attributes.content.trim().length ? true : false)
\t\t\t\t\t}) ));
\t\t\t\t\treturn this;
\t\t\t\t},
\t\t\t\tunrender : function(response) {
\t\t\t\t\tif(response.alertMessage != undefined) {
\t\t\t\t\t\tarticleHistoryCollection.syncData();
\t\t\t\t\t\tapp.appView.renderResponseAlert(response)
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tpreview: function(e){
\t\t\t\t\te.preventDefault();
\t\t\t\t\t\$('body').append(this.previewTemplate());

\t\t\t\t\tif(this.model.attributes.content.trim().length){
\t\t\t\t\t\t\$('body').find('#preview-modal .uv-html-preview').html(this.model.attributes.content);
\t\t\t\t\t}else{
\t\t\t\t\t\t\$('body').find('#preview-modal .uv-html-preview').html(
\t\t\t\t\t\t\t`
\t\t\t\t\t\t\t\t<h2>{{'Oops'|trans}}</h2>
\t\t\t\t\t\t\t\t<p>{{'Sorry, there are nothing to display.'|trans}}</p>
\t\t\t\t\t\t\t`
\t\t\t\t\t\t);
\t\t\t\t\t\t\$('body').find('#preview-modal .restore').attr('disabled', 'disabled');
\t\t\t\t\t\t\$('body').find('#preview-modal .uv-btn.uv-btn-error').removeClass('restore');
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\trestore: function(e){
\t\t\t\t\te.preventDefault();
\t\t\t\t\tformData = {};
\t\t\t\t\tformData['ids'] = ['{{article.id}}'];
\t\t\t\t\tformData['actionType'] = 'contentUpdate';
\t\t\t\t\tformData['content'] = this.model.attributes.content;
\t\t\t\t\ttinyMCE.get('content').setContent(this.model.attributes.content)
\t\t\t\t\tarticleForm.articleEntityUpdate(formData);
\t\t\t\t\tarticleHistoryCollection.syncData();
\t\t\t\t}
\t\t\t});

\t\t\tvar ArticleHistoryList = Backbone.View.extend({
\t\t\t\tel : \$(\"#article-history .uv-list-view\"),
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.render();
\t\t\t\t},
\t\t\t\trender : function () {
\t\t\t\t\tthis.\$el.find(\"div\").remove();
\t\t\t\t\tif(articleHistoryCollection.length) {
\t\t\t\t\t\t_.each(articleHistoryCollection.models, function (item) {
\t\t\t\t\t\t\tthis.renderArticle(item);
\t\t\t\t\t\t}, this);
\t\t\t\t\t\tapp.appView.relativeTime()
\t\t\t\t\t} else {
\t\t\t\t\t\tthis.\$el.append(\"<div class='uv-text-center'>{% trans %}No Record Found{% endtrans %}</div>\")
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\trenderArticle : function (item) {
\t\t\t\t\tvar articleHistoryItem = new ArticleHistoryItem({
\t\t\t\t\t\tmodel: item
\t\t\t\t\t});
\t\t\t\t\tthis.\$el.append(articleHistoryItem.render().el);
\t\t\t\t}
\t\t\t});

\t\t\tarticleHistoryCollection = new ArticleHistoryCollection();

            var ArticleRelatedModel = Backbone.Model.extend({
                urlRoot : path_related
\t\t\t});

\t\t\tvar ArticleRelatedCollection = AppCollection.extend({
\t\t\t\tmodel : ArticleRelatedModel,
\t\t\t\turl : path_related,
\t\t\t\tfilterParameters : {
\t\t\t\t\t\"isActive\" : \"\",
\t\t\t\t\t\"search\" : \"\"
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.syncData();
\t\t\t\t},
\t\t\t\tparseRecords: function (resp, options) {
\t\t\t\t\treturn resp;
\t\t\t\t},
\t\t\t\tsyncData : function() {
\t\t\t\t\tapp.appView.showLoader();
\t\t\t\t\tthis.fetch({
\t\t\t\t\t\tdata : this.getValidParameters(),
\t\t\t\t\t\treset: true,
\t\t\t\t\t\tsuccess: function(model, response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tvar articleRelatedListView = new ArticleRelatedList();

\t\t\t\t\t\t\tif(globalMessageResponse)
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(globalMessageResponse);
\t\t\t\t\t\t\tglobalMessageResponse = null;
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t}
\t\t\t});

\t\t\tvar ArticleRelatedItem = Backbone.View.extend({
\t\t\t\ttagName : \"div\",
\t\t\t\ttemplate : _.template(\$(\"#article_related_list_item_tmp\").html()),
\t\t\t\tevents: {
\t\t\t\t\t'click .remove' : \"remove\",
\t\t\t\t},
\t\t\t\trender : function() {
\t\t\t\t\tthis.\$el.html(this.template(this.model.toJSON()));
\t\t\t\t\treturn this;
\t\t\t\t},
\t\t\t\tremove: function(e){
\t\t\t\t\te.preventDefault();
\t\t\t\t\tlet formData = {};
\t\t\t\t\tformData['ids'] = [\"{{article.id}}\"];
\t\t\t\t\tformData['actionType'] = 'relatedUpdate';
\t\t\t\t\tformData['action'] = 'remove';
\t\t\t\t\tformData['entityId'] = this.model.id;
\t\t\t\t\tarticleForm.articleEntityUpdate(formData);

\t\t\t\t\t\$(e.target).parent().parent().remove();
\t\t\t\t}
\t\t\t});

\t\t\tvar ArticleRelatedList = Backbone.View.extend({
\t\t\t\tel : \$(\"#article-related .uv-list-view\"),
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.render();
\t\t\t\t},
\t\t\t\trender : function () {
\t\t\t\t\tthis.\$el.find(\"div\").remove();
\t\t\t\t\tif(articleRelatedCollection.length) {
\t\t\t\t\t\t_.each(articleRelatedCollection.models, function (item) {
\t\t\t\t\t\t\tthis.renderArticle(item);
\t\t\t\t\t\t}, this);
\t\t\t\t\t\tapp.appView.relativeTime()
\t\t\t\t\t} else {
\t\t\t\t\t\tthis.\$el.append(\"<div>{% trans %}No Record Found{% endtrans %}</div>\")
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\trenderArticle : function (item) {
\t\t\t\t\tvar articleRelatedItem = new ArticleRelatedItem({
\t\t\t\t\t\tmodel: item
\t\t\t\t\t});
\t\t\t\t\tthis.\$el.append(articleRelatedItem.render().el);
\t\t\t\t}
\t\t\t});

\t\t\tarticleRelatedCollection = new ArticleRelatedCollection();

\t\t\tvar TagList = Backbone.View.extend({
                el : \$(\"#tagUpdate\"),
                events : {
                    'keypress .uv-field' : 'addTag',
                },
                addTag : function(e) {
\t\t\t\t\tvar inputElement = Backbone.\$(e.currentTarget);
\t\t\t\t\tinputElement.removeClass('uv-field-error');
\t\t\t\t\tinputElement.parents('.uv-element-block').find('.uv-field-message').remove()
\t\t\t\t\tvar text = inputElement.val().trim();

\t\t\t\t\tif (e.which === 13 && text) {
\t\t\t\t\t\tif ((text.match(/^((?![!@#\$%^&*()<_+]).)*\$/))) {
\t\t\t\t\t\t\t\tif(text.length <= 35) {
\t\t\t\t\t\t\t\tlet existed = false;
\t\t\t\t\t\t\t\t\$('.uv-filtered-tags .uv-tag').each(function(key, el){
\t\t\t\t\t\t\t\t\tif(\$(el).text().toLowerCase() == text.toLowerCase())
\t\t\t\t\t\t\t\t\t\texisted = true;
\t\t\t\t\t\t\t\t})
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\tif(!existed) {
\t\t\t\t\t\t\t\t\tlet data = {};
\t\t\t\t\t\t\t\t\tapp.appView.showLoader();

\t\t\t\t\t\t\t\t\tdata['ids'] = [\"{{article.id}}\"];
\t\t\t\t\t\t\t\t\tdata['actionType'] = 'tagUpdate';
\t\t\t\t\t\t\t\t\tdata['entityId'] = \$(e.currentTarget).attr(\"data-id\");
\t\t\t\t\t\t\t\t\tdata['action'] = 'create';
\t\t\t\t\t\t\t\t\tdata['name'] = text;

\t\t\t\t\t\t\t\t\t\$.ajax({
\t\t\t\t\t\t\t\t\t\turl : \"{{ path('helpdesk_member_knowledgebase_update_article_xhr') }}\",
\t\t\t\t\t\t\t\t\t\ttype : 'POST',
\t\t\t\t\t\t\t\t\t\tdata : {data : data},
\t\t\t\t\t\t\t\t\t\tdataType : 'json',
\t\t\t\t\t\t\t\t\t\tsuccess: function (response) {
\t\t\t\t\t\t\t\t\t\t\tif(response.alertClass == \"success\") {
\t\t\t\t\t\t\t\t\t\t\t\tlet html = `
\t\t\t\t\t\t\t\t\t\t\t\t\t<a class=\"uv-btn-tag\" href=\"#\" data-id=\"\${response.tagId}\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"uv-tag\"><span class=\"uv-icon-remove-dark-before\"></span>\${response.tagName}</span>
\t\t\t\t\t\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t\t\t\t\t`;
\t\t\t\t\t\t\t\t\t\t\t\t\$('.uv-filtered-tags.tag').append(html);
\t\t\t\t\t\t\t\t\t\t\t}
\t\t\t\t\t\t\t\t\t\t\tinputElement.val('');
\t\t\t\t\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t\t\t\t\t},
\t\t\t\t\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t\t\t\t\t\tvar response = warningResponse;
\t\t\t\t\t\t\t\t\t\t\tif(xhr.responseJSON)
\t\t\t\t\t\t\t\t\t\t\t\tresponse = xhr.responseJSON;

\t\t\t\t\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t\t\t\t\t}
\t\t\t\t\t\t\t\t\t});
\t\t\t\t\t\t\t\t} else {
\t\t\t\t\t\t\t\t\tinputElement.addClass('uv-field-error');
\t\t\t\t\t\t\t\t\tinputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>{{ 'Tag with same name already exist'|trans }}</span>\");
\t\t\t\t\t\t\t\t}
\t\t\t\t\t\t\t} else {
\t\t\t\t\t\t\t\tinputElement.addClass('uv-field-error');
\t\t\t\t\t\t\t\tinputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>{{ 'Text length should be less than 35 charactors'|trans }}</span>\");
\t\t\t\t\t\t\t}
\t\t\t\t\t\t} else {
\t\t\t\t\t\t\tinputElement.addClass('uv-field-error');
\t\t\t\t\t\t\tinputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>{{ 'Only character are allowed' }}</span>\");
\t\t\t\t\t\t}
\t\t\t\t\t}
                },
            });

\t\t\tnew TagList({});

            var BodyView = Backbone.View.extend({
                el: 'body',
                events : {
\t\t\t\t\t'click #preview-modal .uv-pop-up-close' : \"removeModal\",
\t\t\t\t\t'click #preview-modal .uv-btn.cancel' : \"removeModal\",
\t\t\t\t\t'click #preview-modal .uv-btn.restore' : \"restore\",
\t\t\t\t},
\t\t\t\tremoveModal: function(e){
\t\t\t\t\te.preventDefault();
\t\t\t\t\tsetTimeout(function() {
\t\t\t\t\t\t\$(e.target).parents('#preview-modal').remove();
\t\t\t\t\t}, 500);
\t\t\t\t},
\t\t\t\trestore: function(e){
\t\t\t\t\te.preventDefault();

\t\t\t\t\tthis.removeModal(e);

\t\t\t\t\tformData = {};
\t\t\t\t\tformData['ids'] = ['{{article.id}}'];
\t\t\t\t\tformData['actionType'] = 'contentUpdate';
\t\t\t\t\tformData['content'] = \$('#preview-modal .uv-html-preview').html();
\t\t\t\t\ttinyMCE.get('content').setContent(formData['content'])
\t\t\t\t\tarticleForm.articleEntityUpdate(formData);
\t\t\t\t\tarticleHistoryCollection.syncData();
\t\t\t\t},
\t\t\t\taddRelatedArticle: function(){
\t\t\t\t\tarticleRelatedCollection.syncData();
\t\t\t\t}
\t\t\t});
\t\t\tvar bodyView = new BodyView({});

            var PageView = Backbone.View.extend({
                el: '.uv-paper',
                events : {
                    'click .uv-aside-ticket-actions .uv-aside-select .uv-dropdown-list:not(.uv-no-patch) li': 'editArticleProperty',
\t\t\t\t\t'input .uv-field-block input' : 'searchFilterOption',
                },
                editArticleProperty: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    var uvSelect = currentElement.parents('.uv-aside-select');
                    var field = currentElement.parent().attr('data-action');
                    var value = currentElement.attr('data-index');
\t\t\t\t\tif(field == 'status'){
\t\t\t\t\t\tif(value == '1'){
\t\t\t\t\t\t\t\$('.uv-btn-action.uv-button-preview').removeAttr('disabled');
\t\t\t\t\t\t}else{
\t\t\t\t\t\t\t\$('.uv-btn-action.uv-button-preview').attr('disabled', 'disabled');
\t\t\t\t\t\t}
\t\t\t\t\t}
                    if(uvSelect.find('.uv-aside-select-value').attr('data-id') != value) {
                        var name = currentElement.text().trim();
                        app.appView.showLoader();
\t\t\t\t\t\tself = this;
                        this.model.save({ editType: field, value: value, id: self.model.id }, {
                            patch: true,
                            success: function (model, response, options) {
                                uvSelect.find('.uv-aside-select-value').attr('data-id', value).text(name)
                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(response);
                            },
                            error: function (model, xhr, options) {
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;
                                var response = warningResponse;
                                if(xhr.responseJSON)
                                    response = xhr.responseJSON;

                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(response);
                            }
                        });
                    }
                },
                searchFilterOption: function(e) {
                    self = this;
                    currentElement = Backbone.\$(e.currentTarget);
                    dropdown = currentElement.siblings('.uv-dropdown-list');
                    var filterType =  currentElement.attr('data-filter-type');
                    if(jQuery.inArray(filterType, ['tag', 'related']) !== -1) {
                        self.searchFilterXhr(currentElement);
                    }
                },
\t\t\t\tloaderTemplate : _.template(\$(\"#loader-tmp\").html()),
                searchFilterXhr: _.debounce(function(currentElement) {
                    var parent = currentElement.parent();
                    if(\$('.uv-dropdown-other.uv-dropdown-btn-active').parent().attr('id') != parent.attr('id'))
                        return;

                    parent.find(\"li:not(.uv-no-results, .uv-filter-info, .press-enter-to-add)\").remove();
                    parent.find(\".uv-filter-info\").show()
                    if(currentElement.val().length > 1) {
                        parent.append(this.loaderTemplate())
                        parent.find('.uv-filter-info').text(\"{% trans %}Searching{% endtrans %} ...\")
                        if(self.xhrReq)
                            self.xhrReq.abort();

\t\t\t\t\t\tlet filterType = currentElement.attr('data-filter-type');
\t\t\t\t\t\tlet path = (filterType == 'tag' ? \"{{ path('search_ticket_filter_options_xhr') }}\" : \"{{ path('helpdesk_member_knowledgebase_article_collection_xhr') }}\");
                        self.xhrReq = \$.ajax({
                            url : path,
                            type : 'GET',
                            data: {\"type\" : currentElement.attr('data-filter-type'), \"query\" : currentElement.val()},
                            dataType : 'json',
                            success : function(response) {
                                self.xhrReq = 0;
                                parent.find('.uv-loader').remove()
\t\t\t\t\t\t\t\tif(parent.find('.uv-dropdown-list').length) {
\t\t\t\t\t\t\t\t\tparent.find('.uv-dropdown-list').show();
\t\t\t\t\t\t\t\t}
                                parent.find('.uv-filter-info').text(\"{{ 'Type atleast 2 letters'|trans }}\").hide();

\t\t\t\t\t\t\t\tif(filterType == 'tag'){
\t\t\t\t\t\t\t\t\tif(response.length == 0) {
\t\t\t\t\t\t\t\t\t\tparent.find('.press-enter-to-add').show()
\t\t\t\t\t\t\t\t\t}else{
\t\t\t\t\t\t\t\t\t\tparent.find('.press-enter-to-add').hide()
\t\t\t\t\t\t\t\t\t\tparent.find('.uv-no-results').hide();
\t\t\t\t\t\t\t\t\t\t_.each(response, function(item) {
\t\t\t\t\t\t\t\t\t\t\tparent.find('.uv-dropdown-list ul').append(\"<li data-id='\" + item.id + \"'>\" + item.name + \"</li>\")
\t\t\t\t\t\t\t\t\t\t});
\t\t\t\t\t\t\t\t\t}
\t\t\t\t\t\t\t\t}else{
\t\t\t\t\t\t\t\t\tif(response.results.length == 0) {
\t\t\t\t\t\t\t\t\t\tparent.find('.press-enter-to-add').hide()
\t\t\t\t\t\t\t\t\t\tparent.find('.uv-no-results').show()
\t\t\t\t\t\t\t\t\t}
\t\t\t\t\t\t\t\t\t_.each(response.results, function(item) {
\t\t\t\t\t\t\t\t\t\tparent.find('.press-enter-to-add').hide()
\t\t\t\t\t\t\t\t\t\tparent.find('.uv-no-results').hide();
\t\t\t\t\t\t\t\t\t\tif(item.id != {{article.id}})
\t\t\t\t\t\t\t\t\t\t\tparent.find('.uv-dropdown-list ul').append(\"<li data-id='\" + item.id + \"'>\" + item.name + \"</li>\")
\t\t\t\t\t\t\t\t\t});
\t\t\t\t\t\t\t\t}
                            },
                            error: function (xhr) {
                                self.xhrReq = 0;
                                parent.find('.uv-loader').remove()
                                parent.find('.uv-no-results').hide();
                                parent.find('.uv-filter-info').text(\"{{ 'Type atleast 2 letters'|trans }}\").show();
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;
                            }
                        });
                    } else {
\t\t\t\t\t\tparent.find('.uv-no-results').hide();
\t\t\t\t\t}
                },1000),
            });

\t\t\tvar pageView = new PageView({
\t\t\t\tmodel : articlemodel
\t\t\t});
\t\t});
\t</script>
\t{{ include(\"@UVDeskSupportCenter/Templates/tinyMCE.html.twig\") }}
    <script>
\t\t{# var toolbarOptions = sfTinyMce.options.toolbar;
        initializeArticleTinymce = function() {
\t\t\tsfTinyMce.init({
\t\t\t\tselector: 'textarea[name*=\"content\"]',
\t\t\t\ttoolbar: toolbarOptions + ' | insert | styleselect | alignleft aligncenter alignright alignjustify | outdent indent | code',
\t\t\t});
\t\t}; #}
\t\t
        
    </script>
{% endblock %}", "@UVDeskSupportCenter/Staff/Articles/articleForm.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Staff/Articles/articleForm.html.twig");
    }
}
