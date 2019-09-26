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

/* @UVDeskSupportCenter/Staff/Articles/articleListBySolution.html.twig */
class __TwigTemplate_e26fab54cda39ed1a7dea96e07e4daa4f0978f0f1fff8bf066970a3eb9061530 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Staff/Articles/articleListBySolution.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Staff/Articles/articleListBySolution.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskSupportCenter/Staff/Articles/articleListBySolution.html.twig", 1);
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

        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Articles"), "html", null, true);
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 5
    public function block_pageContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        // line 6
        echo "\t<style>
\t\t@media only screen and (max-width: 900px) {
\t\t\t.uv-table.uv-list-view table tbody td.uv-last-170{
\t\t\t\twidth: 100%;
\t\t\t}
\t\t}
\t</style>
\t<div class=\"uv-inner-section\">
        <div class=\"uv-aside uv-category\">
\t\t    <div class=\"uv-main-info-block\">
\t\t\t\t<div class=\"uv-aside-head\">
\t\t\t\t\t<div class=\"uv-aside-title\">
\t\t\t\t\t\t<h6>";
        // line 18
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("FOLDER"), "html", null, true);
        echo "</h6>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"uv-aside-back\">
\t\t\t\t\t\t<span onclick=\"window.location = '";
        // line 21
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_folders_collection");
        echo "'\"> ";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Back"), "html", null, true);
        echo "</span>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t";
        // line 24
        $context["defaultImage"] = $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdesksupportcenter/images/splash/knowledgebase-splash.png");
        // line 25
        echo "\t\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t\t<div class=\"uv-aside-customer-block\">
\t\t\t\t\t\t<div class=\"uv-aside-avatar\">
\t\t\t\t\t\t\t";
        // line 29
        echo "\t\t\t\t\t\t\t<img src=\"https://s3-ap-southeast-1.amazonaws.com/cdn.uvdesk.com/website/183/im%2Cas.png\">
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"uv-aside-customer-info\">
\t\t\t\t\t\t\t<span class=\"uv-customize\"></span>
\t\t\t\t\t\t\t<span class=\"uv-bold\">";
        // line 33
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["solution"]) || array_key_exists("solution", $context) ? $context["solution"] : (function () { throw new RuntimeError('Variable "solution" does not exist.', 33, $this->source); })()), "name", [], "any", false, false, false, 33), "html", null, true);
        echo "</span>
\t\t\t\t\t\t\t<span>";
        // line 34
        echo twig_escape_filter($this->env, (isset($context["solutionCategoryCount"]) || array_key_exists("solutionCategoryCount", $context) ? $context["solutionCategoryCount"] : (function () { throw new RuntimeError('Variable "solutionCategoryCount" does not exist.', 34, $this->source); })()), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Categories"), "html", null, true);
        echo "</span>
\t\t\t\t\t\t\t<span>";
        // line 35
        echo twig_escape_filter($this->env, (isset($context["solutionArticleCount"]) || array_key_exists("solutionArticleCount", $context) ? $context["solutionArticleCount"] : (function () { throw new RuntimeError('Variable "solutionArticleCount" does not exist.', 35, $this->source); })()), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Articles"), "html", null, true);
        echo "</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"uv-aside-ticket-block\">
\t\t\t\t\t\t<div class=\"uv-aside-ticket-brick\">
\t\t\t\t\t\t\t<span>";
        // line 40
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["solution"]) || array_key_exists("solution", $context) ? $context["solution"] : (function () { throw new RuntimeError('Variable "solution" does not exist.', 40, $this->source); })()), "description", [], "any", false, false, false, 40), "html", null, true);
        echo "</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!--//Ticket Info-->
\t\t\t\t</div>
            </div>

\t\t\t<!--Aside Customer Info Update Brick-->
\t\t\t<div class=\"uv-main-info-update-block\" style=\"display: none\">
\t\t\t\t<div class=\"uv-aside-head\">
\t\t\t\t\t<div class=\"uv-aside-title\">
\t\t\t\t\t\t<h6>";
        // line 51
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit Folder"), "html", null, true);
        echo "</h6>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"uv-aside-back\">
\t\t\t\t\t\t<span>";
        // line 54
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Back"), "html", null, true);
        echo "</span>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t\t<form method=\"post\">
\t\t\t\t\t\t<input class=\"uv-field\" name=\"id\" type=\"hidden\" value=\"";
        // line 60
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["solution"]) || array_key_exists("solution", $context) ? $context["solution"] : (function () { throw new RuntimeError('Variable "solution" does not exist.', 60, $this->source); })()), "id", [], "any", false, false, false, 60), "html", null, true);
        echo "\">
\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 63
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Name"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<input class=\"uv-field\" name=\"name\" type=\"text\" value=\"";
        // line 65
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["solution"]) || array_key_exists("solution", $context) ? $context["solution"] : (function () { throw new RuntimeError('Variable "solution" does not exist.', 65, $this->source); })()), "name", [], "any", false, false, false, 65), "html", null, true);
        echo "\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 72
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Description"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<textarea class=\"uv-field\" name=\"description\">";
        // line 74
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["solution"]) || array_key_exists("solution", $context) ? $context["solution"] : (function () { throw new RuntimeError('Variable "solution" does not exist.', 74, $this->source); })()), "description", [], "any", false, false, false, 74), "html", null, true);
        echo "</textarea>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-action-buttons\">
\t\t\t\t\t\t\t<a class=\"uv-btn update-btn\" href=\"#\">
\t\t\t\t\t\t\t\t";
        // line 82
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Update"), "html", null, true);
        echo "
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t<a class=\"uv-btn cancel-btn\" href=\"#\">
\t\t\t\t\t\t\t\t";
        // line 85
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Cancel"), "html", null, true);
        echo "
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- CSRF token Field -->
\t\t\t\t\t\t";
        // line 92
        echo "\t\t\t\t\t\t<!-- //CSRF token Field -->
\t\t\t\t\t</form>
\t\t\t\t</div>
\t\t\t</div>


\t\t\t<!--Aside Brick-->
\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t<!--Ticket Actions-->
\t\t\t\t<div class=\"uv-aside-ticket-actions\">

\t\t\t\t\t<div class=\"uv-aside-select\">
\t\t\t\t\t\t<label class=\"uv-aside-select-label\">";
        // line 104
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t<span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"";
        // line 106
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["solution"]) || array_key_exists("solution", $context) ? $context["solution"] : (function () { throw new RuntimeError('Variable "solution" does not exist.', 106, $this->source); })()), "visibility", [], "any", false, false, false, 106), "html", null, true);
        echo "\">
\t\t\t\t\t\t\t\t";
        // line 107
        echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, (isset($context["solution"]) || array_key_exists("solution", $context) ? $context["solution"] : (function () { throw new RuntimeError('Variable "solution" does not exist.', 107, $this->source); })()), "visibility", [], "any", false, false, false, 107) == "public")) ? ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Published")) : ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Draft"))), "html", null, true);
        echo "
\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>";
        // line 111
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t\t<ul class=\"status\" data-action=\"status\">
\t\t\t\t\t\t\t\t\t\t<li data-index=\"public\"><a href=\"#\">";
        // line 113
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Published"), "html", null, true);
        echo "</a></li>
\t\t\t\t\t\t\t\t\t\t<li data-index=\"private\"><a href=\"#\">";
        // line 114
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Draft"), "html", null, true);
        echo "</a></li>
\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>

\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t<a href=\"";
        // line 124
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_folder", ["solution" => twig_get_attribute($this->env, $this->source, (isset($context["solution"]) || array_key_exists("solution", $context) ? $context["solution"] : (function () { throw new RuntimeError('Variable "solution" does not exist.', 124, $this->source); })()), "id", [], "any", false, false, false, 124)]), "html", null, true);
        echo "\" target=\"_blank\"  type=\"button\" class=\"uv-btn-action\">
\t\t\t\t\t";
        // line 125
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preview"), "html", null, true);
        echo "
\t\t\t\t</a>
\t\t\t</div>
        </div>

\t\t<div class=\"uv-view ";
        // line 130
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 130, $this->source); })()), "request", [], "any", false, false, false, 130), "cookies", [], "any", false, false, false, 130) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 130, $this->source); })()), "request", [], "any", false, false, false, 130), "cookies", [], "any", false, false, false, 130), "get", [0 => "uv-asideView"], "method", false, false, false, 130))) {
            echo "uv-aside-view";
        }
        echo "\">
\t\t\t<h1>
\t\t\t\t";
        // line 132
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Articles"), "html", null, true);
        echo "
\t\t\t</h1>
\t\t\t<div class=\"uv-action-bar\">
                <!-- Select all checkbox -->
                <div class=\"uv-action-select-wrapper\">
                    <label class=\"uv-vertical-align uv-margin-left-27\">
                        <div class=\"uv-checkbox\">
                            <input type=\"checkbox\" class=\"select-all-checkbox\">
                            <span class=\"uv-checkbox-view\"></span>
                        </div>
                    </label>
                </div>
                <!-- //Select all checkbox -->

                <div class=\"uv-action-col-wrapper\">
\t\t\t\t\t<div class=\"uv-action-bar-col-lt\">
\t\t\t\t\t\t<!--Sort by-->
\t\t\t\t\t\t<div class=\"uv-dropdown sort\">
\t\t\t\t\t\t\t<div class=\"uv-dropdown-btn uv-vertical-align uv-margin-right-5\">
\t\t\t\t\t\t\t\t";
        // line 151
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Sort By:"), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Created At"), "html", null, true);
        echo "
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>";
        // line 155
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Sort By"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!--Sort by-->

\t\t\t\t\t\t<!--Filter By Status-->
\t\t\t\t\t\t<div class=\"uv-dropdown filter-by-status\">
\t\t\t\t\t\t\t<div class=\"uv-dropdown-btn uv-vertical-align uv-margin-right-5\">
\t\t\t\t\t\t\t\t";
        // line 166
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status:"), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("All"), "html", null, true);
        echo "
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>";
        // line 170
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t\t\t\t<li class=\"uv-drop-list-active\"><a href=\"#\">";
        // line 172
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("All"), "html", null, true);
        echo "</a></li>
\t\t\t\t\t\t\t\t\t\t<li><a href=\"#\" data-id=\"1\">";
        // line 173
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Active"), "html", null, true);
        echo "</a></li>
\t\t\t\t\t\t\t\t\t\t<li><a href=\"#\" data-id=\"0\">";
        // line 174
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Disabled"), "html", null, true);
        echo "</a></li>
\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!--//Filter By Status-->
\t\t\t\t\t</div>

\t\t\t\t\t<div class=\"uv-action-bar-col-lt\" style=\"display: none\">
\t\t\t\t\t\t<!-- Mass action -->
\t\t\t\t\t\t<div class=\"mass-action\">
\t\t\t\t\t\t\t<div class=\"property-block\">
\t\t\t\t\t\t\t\t<!-- //Mass status update -->
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown\">
\t\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-btn uv-vertical-align uv-margin-right-5\">";
        // line 188
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
        echo "</div>
\t\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t\t\t<label>";
        // line 191
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"status\" data-action=\"status\">
\t\t\t\t\t\t\t\t\t\t\t\t<li data-index=\"1\"><a href=\"#\">";
        // line 193
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Published"), "html", null, true);
        echo "</a></li>
\t\t\t\t\t\t\t\t\t\t\t\t<li data-index=\"0\"><a href=\"#\">";
        // line 194
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Draft"), "html", null, true);
        echo "</a></li>
\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<!-- //Mass status update -->

\t\t\t\t\t\t\t\t<!-- Mass trashed -->
\t\t\t\t\t\t\t\t<a class=\"uv-btn-stroke uv-margin-right-5\" id=\"mass-delete\" data-action=\"delete\" style=\"margin-left: 5px;\">
\t\t\t\t\t\t\t\t\t";
        // line 203
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Delete"), "html", null, true);
        echo "
\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t<!-- //Mass trashed -->
\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Mass action -->
\t\t\t\t\t</div>

\t\t\t\t\t<div class=\"uv-action-bar-col-rt\">
\t\t\t\t\t\t<input type=\"text\" class=\"uv-search-inline uv-vertical-align uv-margin-right-15\" placeholder=\"";
        // line 213
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Search"), "html", null, true);
        echo "\">
\t\t\t\t\t\t<!-- Add Button -->
\t\t\t\t\t\t<a href=\"";
        // line 215
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_create_article");
        echo "\" type=\"button\" class=\"uv-btn-action\">
\t\t\t\t\t\t\t<span class=\"uv-icon-add\"></span>
\t\t\t\t\t\t\t";
        // line 217
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("New Article"), "html", null, true);
        echo "
\t\t\t\t\t\t</a>
\t\t\t\t\t\t<!--// Add Button -->
\t\t\t\t\t</div>
\t\t\t\t</div>
            </div>
            <!--//Action Bar-->

            <div class=\"uv-table uv-list-view\">
                <table>
                    <thead>
                        <tr>
\t\t\t\t\t\t\t<th style=\"width: 1px;\"></th>
                            <th></th>
                            <th>";
        // line 231
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Id"), "html", null, true);
        echo "</th>
                            <th>";
        // line 232
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Article"), "html", null, true);
        echo "</th>
\t                        <th>";
        // line 233
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Viewed"), "html", null, true);
        echo "</th>
                            <th>";
        // line 234
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Created"), "html", null, true);
        echo "</th>
                            <th>";
        // line 235
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
        echo "</th>
                            <th class=\"uv-last\">";
        // line 236
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Action"), "html", null, true);
        echo "</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
\t\t\t\t<div class=\"navigation\"></div>
            </div>
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 248
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 249
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "

\t<!-- Sorting Template -->
\t<script id=\"article_list_sorting_tmp\" type=\"text/template\">
        <li class=\"<% if(sort == 'a.createdAt') { %>uv-drop-list-active<% } %>\">
            <a href=\"#<% if(queryString != '') { %><%- queryString %>/<% } %><% if(page) { %>page/<%- page %><% } else { %>page/1<% } %>/sort/a.createdAt/<% if(sort == 'a.createdAt') { %><% if(direction) { %>direction/<%- direction %><% } else { %>direction/desc<% } %><% } else { %>direction/asc<% } %>\" data-field=\"a.createdAt\">
\t\t\t\t";
        // line 255
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Created At", [], "messages");
        // line 256
        echo "\t\t\t\t<% if(sort == 'a.createdAt') { %>
\t\t\t\t\t<span class=\"uv-sorting <% if(direction == 'asc') { %> descend <% } else { %> ascend <% } %>\"></span>
\t\t\t\t<% } %>
\t\t\t</a>
        </li>

\t    <li class=\"<% if(sort == 'a.name') { %>uv-drop-list-active<% } %>\">
            <a href=\"#<% if(queryString != '') { %><%- queryString %>/<% } %><% if(page) { %>page/<%- page %><% } else { %>page/1<% } %>/sort/a.name/<% if(sort == 'a.name') { %><% if(direction) { %>direction/<%- direction %><% } else { %>direction/desc<% } %><% } else { %>direction/asc<% } %>\" data-field=\"a.name\">
\t\t\t\t";
        // line 264
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Name", [], "messages");
        // line 265
        echo "\t\t\t\t<% if(sort == 'a.name') { %>
\t\t\t\t\t<span class=\"uv-sorting <% if(direction == 'asc') { %> descend <% } else { %> ascend <% } %>\"></span>
\t\t\t\t<% } %>
\t\t\t</a>
        </li>

\t    <li class=\"<% if(sort == 'a.viewed') { %>uv-drop-list-active<% } %>\">
            <a href=\"#<% if(queryString != '') { %><%- queryString %>/<% } %><% if(page) { %>page/<%- page %><% } else { %>page/1<% } %>/sort/a.viewed/<% if(sort == 'a.viewed') { %><% if(direction) { %>direction/<%- direction %><% } else { %>direction/desc<% } %><% } else { %>direction/asc<% } %>\" data-field=\"a.viewed\">
\t\t\t\t";
        // line 273
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Viewed", [], "messages");
        // line 274
        echo "\t\t\t\t<% if(sort == 'a.viewed') { %>
\t\t\t\t\t<span class=\"uv-sorting <% if(direction == 'asc') { %> descend <% } else { %> ascend <% } %>\"></span>
\t\t\t\t<% } %>
\t\t\t</a>
        </li>
\t</script>
\t<!-- //Sorting Template -->

\t<!-- Article list item template -->
\t<script id=\"article_list_item_tmp\" type=\"text/template\">
\t\t<td>
            <label class=\"uv-vertical-align uv-margin-left-17\">
                <div class=\"uv-checkbox\">
                    <input type=\"checkbox\" class=\"mass-action-checkbox\" value=\"<%- id %>\"/>
                    <span class=\"uv-checkbox-view\"></span>
                </div>
            </label>
        </td>
\t\t<td data-value=\"";
        // line 292
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("popularity"), "html", null, true);
        echo "\" class=\"uv-text-center\">
\t\t\t<% if(viewed > 100){ %>
\t\t\t\t<span class=\"uv-icon-popular uv-icon-popular-active\"></span>
\t\t\t<% }else{ %>
\t\t\t\t<span class=\"uv-icon-popular\"></span>
\t\t\t<% } %>
\t\t</td>
\t\t<td data-value=\"";
        // line 299
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Id"), "html", null, true);
        echo "\">
\t\t\t<%- id %>
\t\t</td>
\t\t<td data-value=\"";
        // line 302
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Article"), "html", null, true);
        echo "\"><%- name %></td>
\t\t<td data-value=\"";
        // line 303
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Viewed"), "html", null, true);
        echo "\"><%- viewed ? viewed : 0 %></td>
\t\t<td data-value=\"";
        // line 304
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Created"), "html", null, true);
        echo "\"><%- dateAdded %></td>
\t\t<td data-value=\"";
        // line 305
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
        echo "\">
\t\t\t<% if(status) { %>
            \t<span class=\"uv-text-success\">";
        // line 307
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Published"), "html", null, true);
        echo "</span>
            <% } else { %>
            \t<span class=\"uv-text-danger\">";
        // line 309
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Draft"), "html", null, true);
        echo "</span>
        \t<% } %>
\t\t</td>
\t\t<td data-value=\"";
        // line 312
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Action"), "html", null, true);
        echo "\" class=\"uv-last-170\">
\t\t\t<a href=\"<%- path.replace('replaceId', id) %>\" class=\"uv-btn-stroke edit-article\">
\t\t\t\t";
        // line 314
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit"), "html", null, true);
        echo "
\t\t\t</a>
\t\t\t<a class=\"uv-btn-stroke preview-article\" href=\"<%- pathPreview.replace('replaceId', slug) %>\" target=\"_blank\" <%- status ? '' : 'disabled=\"disabled\"' %>>
\t\t\t\t";
        // line 317
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Preview"), "html", null, true);
        echo "
\t\t\t</a>
\t\t</td>
    </script>
\t<!-- //Article list item template -->

\t<script type=\"text/javascript\">
\t\tvar path = \"";
        // line 324
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_update_article", ["id" => "replaceId"]);
        echo "\";
\t\tvar pathPreview = \"";
        // line 325
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_read_slug_article", ["slug" => "replaceId"]);
        echo "\";

\t\t\$(function () {
\t\t\tvar globalMessageResponse = \"\";

\t\t\tvar ArticleModel = Backbone.Model.extend({
\t\t\t\tidAttribute : \"id\"
\t\t\t});

\t\t\tvar ArticleCollection = AppCollection.extend({
\t\t\t\tmodel : ArticleModel,
\t\t\t\turl : \"";
        // line 336
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_folder_articles_collection_xhr", ["solution" => twig_get_attribute($this->env, $this->source, (isset($context["solution"]) || array_key_exists("solution", $context) ? $context["solution"] : (function () { throw new RuntimeError('Variable "solution" does not exist.', 336, $this->source); })()), "id", [], "any", false, false, false, 336)]), "html", null, true);
        echo "\",
\t\t\t\tfilterParameters : {
\t\t\t\t\t\"isActive\" : \"\",
\t\t\t\t\t\"search\" : \"\"
\t\t\t\t},
\t\t\t\tparseRecords: function (resp, options) {
\t\t\t\t\treturn resp.results;
\t\t\t\t},
\t\t\t\tsyncData : function() {
\t\t\t\t\tapp.appView.showLoader();
\t\t\t\t\tthis.fetch({
\t\t\t\t\t\tdata : this.getValidParameters(),
\t\t\t\t\t\treset: true,
\t\t\t\t\t\tsuccess: function(model, response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tvar articleListView = new ArticleList();
\t\t\t\t\t\t\tapp.pager.paginationData = response.pagination_data;

\t\t\t\t\t\t\tvar url = app.pager.paginationData.url;
\t\t\t\t\t\t\tif(articleCollection.length == 0 && app.pager.paginationData.current != \"0\")
\t\t\t\t\t\t\t\trouter.navigate(url.replace('replacePage', app.pager.paginationData.last),{trigger: true});
\t\t\t\t\t\t\telse {
\t\t\t\t\t\t\t\tapp.pager.render();
\t\t\t\t\t\t\t}
\t\t\t\t\t\t\tif(globalMessageResponse)
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(globalMessageResponse);
\t\t\t\t\t\t\tglobalMessageResponse = null;
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t},
                batchOperation : function(data) {
\t\t\t\t\tif(!data.ids.length) return;
                    var self = this;
                    app.appView.showLoader();
                    \$.ajax({
                        url : \"";
        // line 375
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_update_article_xhr");
        echo "\",
                        type : 'POST',
                        data : {data : data},
                        dataType : 'json',
                        success : function(response) {
                            app.appView.hideLoader();
                            globalMessageResponse = response;
                            self.syncData();
                        },
                        error: function (xhr) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                            \$('.mass-action-checkbox').prop('checked', false);
                        }
                    });
                }
\t\t\t});

\t\t\tvar ArticleItem = Backbone.View.extend({
\t\t\t\ttagName : \"tr\",
\t\t\t\ttemplate : _.template(\$(\"#article_list_item_tmp\").html()),
\t\t\t\trender : function() {
\t\t\t\t\tthis.\$el.html(this.template(this.model.toJSON()));
\t\t\t\t\treturn this;
\t\t\t\t},
\t\t\t\tunrender : function(response) {
\t\t\t\t\tif(response.alertMessage != undefined) {
\t\t\t\t\t\tarticleCollection.syncData();
\t\t\t\t\t\tapp.appView.renderResponseAlert(response)
\t\t\t\t\t}
\t\t\t\t},
\t\t\t});

\t\t\tvar ArticleList = Backbone.View.extend({
\t\t\t\tel : \$(\".uv-list-view table tbody\"),
\t\t\t\tevents: {
                    'change .mass-action-checkbox' : 'showBulkOptions'
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.render();
\t\t\t\t},
                showBulkOptions : function() {
                    var count = 0;
                    this.\$el.find('.mass-action-checkbox').each(function() {
                        if(\$(this).is(':checked'))
                            count++;
                    });

                    if(count == \$('.mass-action-checkbox').length)
                        \$('.select-all-checkbox').prop('checked', true);
                    else
                        \$('.select-all-checkbox').prop('checked', false);

                    if(count) {
                        \$('.uv-action-bar-col-lt').eq(0).hide();
                        \$('.uv-action-bar-col-lt').eq(1).show();
                        \$('.uv-action-bar-col-rt').hide()
                    } else {
                        \$('.uv-action-bar-col-lt').eq(1).hide();
                        \$('.uv-action-bar-col-lt').eq(0).show();
                        \$('.uv-action-bar-col-rt').show()
                    }
                },
\t\t\t\trender : function () {
\t\t\t\t\tthis.\$el.find(\"tr\").remove();
\t\t\t\t\tif(articleCollection.length) {
\t\t\t\t\t\t_.each(articleCollection.models, function (item) {
\t\t\t\t\t\t\tthis.renderArticle(item);
\t\t\t\t\t\t}, this);
\t\t\t\t\t} else {
\t\t\t\t\t\tthis.\$el.append(\"<tr style='text-align: center;'><td colspan='8'>";
        // line 451
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("No Record Found", [], "messages");
        echo "</td></tr>\")
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\trenderArticle : function (item) {
\t\t\t\t\tvar articleItem = new ArticleItem({
\t\t\t\t\t\tmodel: item
\t\t\t\t\t});
\t\t\t\t\tthis.\$el.append(articleItem.render().el);
\t\t\t\t}
\t\t\t});

            var BulkActionView = Backbone.View.extend({
                el : \$(\".mass-action\"),
                currentEvent : null,
                events : {
                    'click ul li' : 'massAction',
                    'click #mass-delete' : 'confirmRemove'
                },
                massAction: function(e) {
                    e.preventDefault();
                    //if(!parseInt(Backbone.\$(e.currentTarget).attr('data-index'))) return;
                    var data = {};
                    data['actionType'] = Backbone.\$(e.currentTarget).parents('ul').attr('data-action') ? Backbone.\$(e.currentTarget).parents('ul').attr('data-action') : Backbone.\$(e.currentTarget).attr('data-action');
                    data['targetId'] = Backbone.\$(e.currentTarget).attr('data-index');
                    data['ids'] = this.getCheckedIds();
                    articleCollection.batchOperation(data);
                    this.hideBulkOptions();
                },
                removeItem: function(e) {
                    var data = {};

                    if(Backbone.\$(this.currentEvent.currentTarget).is(\"#mass-delete\"))
                        data['actionType'] = \"delete\";

                    data['ids'] = this.getCheckedIds();
                    articleCollection.batchOperation(data);
                    this.hideBulkOptions();
                },
                getCheckedIds() {
                    var ids = new Array();
                    \$('.mass-action-checkbox').each(function() {
                        if(\$(this).is(':checked')) {
                            ids.push(\$(this).val());
                        }
                    });

                    return ids;
                },
                confirmRemove: function(e) {
                    e.preventDefault();
                    this.currentEvent = e;

                    app.appView.openConfirmModal(this)
                },
                hideBulkOptions : function() {
\t\t\t\t\t\$('.uv-action-bar-col-lt').eq(1).hide();
\t\t\t\t\t\$('.uv-action-bar-col-lt').eq(0).show();
\t\t\t\t\t\$('.uv-action-bar-col-rt').show()

\t\t\t\t\t\$('.select-all-checkbox').prop('checked', false)
                }
            });

\t\t\tvar FolderForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn.update-btn' : \"saveFolder\",
\t\t\t\t\t'blur input': 'formChanegd',
                    'click .cancel-btn': 'backToInfo',
                    'click .uv-aside-back': 'backToInfo'
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t    \tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t    },
\t\t\t\tsaveFolder: function (e) {
\t\t\t\t\te.preventDefault();
                    currentElement = Backbone.\$(e.currentTarget);
                    this.model.clear();
\t\t\t        this.model.set(this.\$el.find('form').serializeObject());
                    self = this;
\t\t\t        if(this.model.isValid(true)) {
                        app.appView.showLoader();
\t\t\t\t\t\tcurrentElement.attr('disabled', 'disabled');
                        this.model.save({}, {
                            success: function (model, response, options) {
                                app.appView.hideLoader();
                                currentElement.removeAttr(\"disabled\");
                                if(response.alertClass == \"success\") {
                                    app.appView.renderResponseAlert(response);
                                    \$('.uv-aside-customer-info .uv-bold').text(self.model.attributes.name);
                                    \$('.uv-aside-ticket-brick span').text(self.model.attributes.description);
                                    self.backToInfo();
                                } else
                                    self.addErrors(JSON.parse(response.errors));
                            },
                            error: function (model, xhr, options) {
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;

                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(warningResponse);
                            }
                        });
\t\t\t        }
\t\t\t\t},
                addErrors: function(jsonContext) {
\t\t    \t\tfor (var field in jsonContext) {
\t\t    \t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
                },
                backToInfo: function(e) {
                    if(e) e.preventDefault();

                    \$('.uv-main-info-update-block').hide()
                    \$('.uv-main-info-block').show()
                },
\t\t\t});

            var FolderModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'name': {
                        required: true,
                        msg: '";
        // line 576
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
                    }
\t\t\t\t},
                urlRoot : \"";
        // line 579
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_update_folder_xhr");
        echo "\"
\t\t\t});

\t\t\tvar foldermodel = new FolderModel({
                id : \"";
        // line 583
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["solution"]) || array_key_exists("solution", $context) ? $context["solution"] : (function () { throw new RuntimeError('Variable "solution" does not exist.', 583, $this->source); })()), "id", [], "any", false, false, false, 583), "html", null, true);
        echo "\",
                name : \"";
        // line 584
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["solution"]) || array_key_exists("solution", $context) ? $context["solution"] : (function () { throw new RuntimeError('Variable "solution" does not exist.', 584, $this->source); })()), "name", [], "any", false, false, false, 584), "html", null, true);
        echo "\",
\t\t\t\tvisibility: \"";
        // line 585
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["solution"]) || array_key_exists("solution", $context) ? $context["solution"] : (function () { throw new RuntimeError('Variable "solution" does not exist.', 585, $this->source); })()), "visibility", [], "any", false, false, false, 585), "html", null, true);
        echo "\",
\t\t\t\tdescription: \"";
        // line 586
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["solution"]) || array_key_exists("solution", $context) ? $context["solution"] : (function () { throw new RuntimeError('Variable "solution" does not exist.', 586, $this->source); })()), "description", [], "any", false, false, false, 586), "html", null, true);
        echo "\",
\t\t\t})

\t\t\tFolderForm = new FolderForm({
\t\t\t\tel : \$(\".uv-main-info-update-block\"),
\t\t\t\tmodel : foldermodel
\t\t\t});

            var PageView = Backbone.View.extend({
                el: '.uv-paper',
                events : {
                    'change .select-all-checkbox' : 'selectAll',
                    'click .uv-aside-customer-info .uv-customize': 'showUpdateBlock',
                    'click .uv-aside-ticket-actions .uv-aside-select .uv-dropdown-list li': 'editSolutionProperty',
                },
                editSolutionProperty: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    var uvSelect = currentElement.parents('.uv-aside-select');
                    var field = currentElement.parent().attr('data-action');
                    var value = currentElement.attr('data-index');
                    if(uvSelect.find('.uv-aside-select-value').attr('data-id') != value) {
                        var name = currentElement.text().trim();
                        app.appView.showLoader();
                        this.model.save({editType: field, value: value, id: this.model.id}, {
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
                selectAll : function(e) {
                    if(Backbone.\$(e.currentTarget).is(':checked')) {
\t\t\t\t\t\tif(\$('.mass-action-checkbox').length){
\t\t\t\t\t\t\t\$('.mass-action-checkbox').prop('checked', true);

\t\t\t\t\t\t\t\$('.uv-action-bar-col-lt').eq(0).hide();
\t\t\t\t\t\t\t\$('.uv-action-bar-col-lt').eq(1).show();
\t\t\t\t\t\t\t\$('.uv-action-bar-col-rt').hide()
\t\t\t\t\t\t}else
\t\t\t\t\t\t\tBackbone.\$(e.currentTarget).prop('checked', false)
                    } else {
                        var count = 0;
                        \$('.mass-action-checkbox').each(function() {
                            if(\$(this).is(':checked'))
                                count++;
                        });
                        if(count == \$('.mass-action-checkbox').length) {
                            \$('.mass-action-checkbox').prop('checked', false);

\t\t\t\t\t\t\t\$('.uv-action-bar-col-lt').eq(1).hide();
\t\t\t\t\t\t\t\$('.uv-action-bar-col-lt').eq(0).show();
\t\t\t\t\t\t\t\$('.uv-action-bar-col-rt').show()
                        }
                    }
                },
                showUpdateBlock: function() {
                    \$('.uv-main-info-update-block').show()
                    \$('.uv-main-info-block').hide()
                },
            });

\t\t\tvar pageView = new PageView({
\t\t\t\tmodel : foldermodel
\t\t\t});
            var bulkAction = new BulkActionView();

\t\t\tvar Filter = app.Filter.extend({
\t\t\t\tdefaultSortIndex: 'a.createdAt',
\t\t\t\tsortText: \"";
        // line 667
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Sort By:", [], "messages");
        echo " \",
\t\t\t\tdefaultSortText: \"";
        // line 668
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Sort By:", [], "messages");
        echo " ";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Created At", [], "messages");
        echo "\",
\t\t\t\ttemplate : _.template(\$(\"#article_list_sorting_tmp\").html())
\t\t\t})

\t\t\tvar articleCollection = new ArticleCollection();

\t\t\tvar filter = new Filter({
\t\t\t\tcollection : articleCollection
\t\t\t});

\t\t\tRouter = Backbone.Router.extend({
\t\t\t\troutes: {
\t\t\t\t\t'page/:number(/sort/:sortField)(/direction/:order)' : 'paginate',
\t\t\t\t\t'isActive/:status(/search/:query)(/page/:number)(/sort/:sortField)(/direction/:order)' : 'filterArticleByStatus',
\t\t\t\t\t'search/:query(/page/:number)(/sort/:sortField)(/direction/:order)' : 'filterByQuery',
\t\t\t\t\t'' : 'initializeList'
\t\t\t\t},
\t\t\t\tinitializeList : function() {
\t\t\t\t\tthis.resetParams('', '');
\t\t\t\t\tarticleCollection.state.currentPage = null;
\t\t\t\t\tfilter.sortCollection();
\t\t\t\t\tarticleCollection.syncData();
\t\t\t\t},
\t\t\t\tpaginate : function(number,sortField,order) {
\t\t\t\t\tthis.resetParams('', '');
\t\t\t\t\tarticleCollection.state.currentPage = number;
\t\t\t\t\tfilter.sortCollection(sortField,order);
\t\t\t\t\tarticleCollection.syncData();
\t\t\t\t},
\t\t\t\tfilterArticleByStatus: function(status,query,number,sortField,order) {
\t\t\t\t\tthis.resetParams(status,query);
\t\t\t\t\tarticleCollection.state.currentPage = number;
\t\t\t\t\tfilter.sortCollection(sortField,order);
\t\t\t\t\tarticleCollection.syncData();
\t\t\t\t},
\t\t\t\tfilterByQuery : function(query,number,sortField,order) {
\t\t\t\t\tthis.resetParams('',query);
\t\t\t\t\tarticleCollection.state.currentPage = number;
\t\t\t\t\tfilter.sortCollection(sortField,order);
\t\t\t\t\tarticleCollection.syncData();
\t\t\t\t},
\t\t\t\tresetParams : function(status, query) {
\t\t\t\t\tif(query != null)
\t\t\t\t\t\tquery = query.replace(/\\+/g,' ');
\t\t\t\t\tarticleCollection.filterParameters.isActive = status;
\t\t\t\t\tvar statusText = status ? \$(\".filter-by-status a[data-id='\" + status + \"']\").text() : \"";
        // line 713
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("All", [], "messages");
        echo "\";
\t\t\t\t\t\$(\".filter-by-status .uv-dropdown-btn\").text(\"";
        // line 714
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Status:", [], "messages");
        echo " \" + statusText);
\t\t\t\t\tarticleCollection.filterParameters.search = query;
\t\t\t\t\t\$(\".uv-search-inline\").val(query);
\t\t\t\t}
\t\t\t});

\t\t\trouter = new Router();
\t\t\tBackbone.history.start({push_state:true});
\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Staff/Articles/articleListBySolution.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1059 => 714,  1055 => 713,  1005 => 668,  1001 => 667,  917 => 586,  913 => 585,  909 => 584,  905 => 583,  898 => 579,  892 => 576,  764 => 451,  685 => 375,  643 => 336,  629 => 325,  625 => 324,  615 => 317,  609 => 314,  604 => 312,  598 => 309,  593 => 307,  588 => 305,  584 => 304,  580 => 303,  576 => 302,  570 => 299,  560 => 292,  540 => 274,  538 => 273,  528 => 265,  526 => 264,  516 => 256,  514 => 255,  504 => 249,  494 => 248,  473 => 236,  469 => 235,  465 => 234,  461 => 233,  457 => 232,  453 => 231,  436 => 217,  431 => 215,  426 => 213,  413 => 203,  401 => 194,  397 => 193,  392 => 191,  386 => 188,  369 => 174,  365 => 173,  361 => 172,  356 => 170,  347 => 166,  333 => 155,  324 => 151,  302 => 132,  295 => 130,  287 => 125,  283 => 124,  270 => 114,  266 => 113,  261 => 111,  254 => 107,  250 => 106,  245 => 104,  231 => 92,  222 => 85,  216 => 82,  205 => 74,  200 => 72,  190 => 65,  185 => 63,  179 => 60,  170 => 54,  164 => 51,  150 => 40,  140 => 35,  134 => 34,  130 => 33,  124 => 29,  119 => 25,  117 => 24,  109 => 21,  103 => 18,  89 => 6,  79 => 5,  60 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %}{{'Articles'|trans}}{% endblock %}

{% block pageContent %}
\t<style>
\t\t@media only screen and (max-width: 900px) {
\t\t\t.uv-table.uv-list-view table tbody td.uv-last-170{
\t\t\t\twidth: 100%;
\t\t\t}
\t\t}
\t</style>
\t<div class=\"uv-inner-section\">
        <div class=\"uv-aside uv-category\">
\t\t    <div class=\"uv-main-info-block\">
\t\t\t\t<div class=\"uv-aside-head\">
\t\t\t\t\t<div class=\"uv-aside-title\">
\t\t\t\t\t\t<h6>{{ 'FOLDER'|trans }}</h6>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"uv-aside-back\">
\t\t\t\t\t\t<span onclick=\"window.location = '{{path('helpdesk_member_knowledgebase_folders_collection')}}'\"> {{ 'Back'|trans }}</span>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t{% set defaultImage = asset('bundles/uvdesksupportcenter/images/splash/knowledgebase-splash.png') %}
\t\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t\t<div class=\"uv-aside-customer-block\">
\t\t\t\t\t\t<div class=\"uv-aside-avatar\">
\t\t\t\t\t\t\t{# <img src=\"{{solution.solutionImage ? solution.solutionImage : defaultImage}}\"> #}
\t\t\t\t\t\t\t<img src=\"https://s3-ap-southeast-1.amazonaws.com/cdn.uvdesk.com/website/183/im%2Cas.png\">
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"uv-aside-customer-info\">
\t\t\t\t\t\t\t<span class=\"uv-customize\"></span>
\t\t\t\t\t\t\t<span class=\"uv-bold\">{{solution.name}}</span>
\t\t\t\t\t\t\t<span>{{solutionCategoryCount}} {{'Categories'|trans }}</span>
\t\t\t\t\t\t\t<span>{{solutionArticleCount}} {{'Articles'|trans }}</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"uv-aside-ticket-block\">
\t\t\t\t\t\t<div class=\"uv-aside-ticket-brick\">
\t\t\t\t\t\t\t<span>{{solution.description}}</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<!--//Ticket Info-->
\t\t\t\t</div>
            </div>

\t\t\t<!--Aside Customer Info Update Brick-->
\t\t\t<div class=\"uv-main-info-update-block\" style=\"display: none\">
\t\t\t\t<div class=\"uv-aside-head\">
\t\t\t\t\t<div class=\"uv-aside-title\">
\t\t\t\t\t\t<h6>{{ 'Edit Folder'|trans }}</h6>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"uv-aside-back\">
\t\t\t\t\t\t<span>{{ 'Back'|trans }}</span>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t\t<form method=\"post\">
\t\t\t\t\t\t<input class=\"uv-field\" name=\"id\" type=\"hidden\" value=\"{{ solution.id }}\">
\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Name'|trans }}</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<input class=\"uv-field\" name=\"name\" type=\"text\" value=\"{{ solution.name }}\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Description'|trans }}</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<textarea class=\"uv-field\" name=\"description\">{{ solution.description }}</textarea>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-action-buttons\">
\t\t\t\t\t\t\t<a class=\"uv-btn update-btn\" href=\"#\">
\t\t\t\t\t\t\t\t{{ 'Update'|trans }}
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t<a class=\"uv-btn cancel-btn\" href=\"#\">
\t\t\t\t\t\t\t\t{{ 'Cancel'|trans }}
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- CSRF token Field -->
\t\t\t\t\t\t{# <input type=\"hidden\" name=\"_token\" value=\"{{ default_service.generateCsrfToken('') }}\"/> #}
\t\t\t\t\t\t<!-- //CSRF token Field -->
\t\t\t\t\t</form>
\t\t\t\t</div>
\t\t\t</div>


\t\t\t<!--Aside Brick-->
\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t<!--Ticket Actions-->
\t\t\t\t<div class=\"uv-aside-ticket-actions\">

\t\t\t\t\t<div class=\"uv-aside-select\">
\t\t\t\t\t\t<label class=\"uv-aside-select-label\">{{ 'Status'|trans }}</label>
\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t<span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"{{ solution.visibility }}\">
\t\t\t\t\t\t\t\t{{ solution.visibility == 'public' ? 'Published'|trans : 'Draft'|trans  }}
\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>{{ 'Status'|trans }}</label>
\t\t\t\t\t\t\t\t\t<ul class=\"status\" data-action=\"status\">
\t\t\t\t\t\t\t\t\t\t<li data-index=\"public\"><a href=\"#\">{{ 'Published'|trans }}</a></li>
\t\t\t\t\t\t\t\t\t\t<li data-index=\"private\"><a href=\"#\">{{ 'Draft'|trans }}</a></li>
\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>

\t\t\t<div class=\"uv-aside-brick\">
\t\t\t\t<a href=\"{{path('helpdesk_knowledgebase_folder', {'solution': solution.id })}}\" target=\"_blank\"  type=\"button\" class=\"uv-btn-action\">
\t\t\t\t\t{{'preview'|trans}}
\t\t\t\t</a>
\t\t\t</div>
        </div>

\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
\t\t\t<h1>
\t\t\t\t{{ 'Articles'|trans }}
\t\t\t</h1>
\t\t\t<div class=\"uv-action-bar\">
                <!-- Select all checkbox -->
                <div class=\"uv-action-select-wrapper\">
                    <label class=\"uv-vertical-align uv-margin-left-27\">
                        <div class=\"uv-checkbox\">
                            <input type=\"checkbox\" class=\"select-all-checkbox\">
                            <span class=\"uv-checkbox-view\"></span>
                        </div>
                    </label>
                </div>
                <!-- //Select all checkbox -->

                <div class=\"uv-action-col-wrapper\">
\t\t\t\t\t<div class=\"uv-action-bar-col-lt\">
\t\t\t\t\t\t<!--Sort by-->
\t\t\t\t\t\t<div class=\"uv-dropdown sort\">
\t\t\t\t\t\t\t<div class=\"uv-dropdown-btn uv-vertical-align uv-margin-right-5\">
\t\t\t\t\t\t\t\t{{ 'Sort By:'|trans }} {{ 'Created At'|trans }}
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>{{ 'Sort By'|trans }}</label>
\t\t\t\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!--Sort by-->

\t\t\t\t\t\t<!--Filter By Status-->
\t\t\t\t\t\t<div class=\"uv-dropdown filter-by-status\">
\t\t\t\t\t\t\t<div class=\"uv-dropdown-btn uv-vertical-align uv-margin-right-5\">
\t\t\t\t\t\t\t\t{{ 'Status:'|trans }} {{ 'All'|trans }}
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t<label>{{ 'Status'|trans }}</label>
\t\t\t\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t\t\t\t<li class=\"uv-drop-list-active\"><a href=\"#\">{{ 'All'|trans }}</a></li>
\t\t\t\t\t\t\t\t\t\t<li><a href=\"#\" data-id=\"1\">{{ 'Active'|trans }}</a></li>
\t\t\t\t\t\t\t\t\t\t<li><a href=\"#\" data-id=\"0\">{{ 'Disabled'|trans }}</a></li>
\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!--//Filter By Status-->
\t\t\t\t\t</div>

\t\t\t\t\t<div class=\"uv-action-bar-col-lt\" style=\"display: none\">
\t\t\t\t\t\t<!-- Mass action -->
\t\t\t\t\t\t<div class=\"mass-action\">
\t\t\t\t\t\t\t<div class=\"property-block\">
\t\t\t\t\t\t\t\t<!-- //Mass status update -->
\t\t\t\t\t\t\t\t<div class=\"uv-dropdown\">
\t\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-btn uv-vertical-align uv-margin-right-5\">{{ 'Status'|trans }}</div>
\t\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t\t\t\t<label>{{ 'Status'|trans }}</label>
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"status\" data-action=\"status\">
\t\t\t\t\t\t\t\t\t\t\t\t<li data-index=\"1\"><a href=\"#\">{{ 'Published'|trans }}</a></li>
\t\t\t\t\t\t\t\t\t\t\t\t<li data-index=\"0\"><a href=\"#\">{{ 'Draft'|trans }}</a></li>
\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<!-- //Mass status update -->

\t\t\t\t\t\t\t\t<!-- Mass trashed -->
\t\t\t\t\t\t\t\t<a class=\"uv-btn-stroke uv-margin-right-5\" id=\"mass-delete\" data-action=\"delete\" style=\"margin-left: 5px;\">
\t\t\t\t\t\t\t\t\t{{ 'Delete'|trans }}
\t\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t\t\t<!-- //Mass trashed -->
\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Mass action -->
\t\t\t\t\t</div>

\t\t\t\t\t<div class=\"uv-action-bar-col-rt\">
\t\t\t\t\t\t<input type=\"text\" class=\"uv-search-inline uv-vertical-align uv-margin-right-15\" placeholder=\"{{ 'Search'|trans }}\">
\t\t\t\t\t\t<!-- Add Button -->
\t\t\t\t\t\t<a href=\"{{ path('helpdesk_member_knowledgebase_create_article') }}\" type=\"button\" class=\"uv-btn-action\">
\t\t\t\t\t\t\t<span class=\"uv-icon-add\"></span>
\t\t\t\t\t\t\t{{ \"New Article\"|trans }}
\t\t\t\t\t\t</a>
\t\t\t\t\t\t<!--// Add Button -->
\t\t\t\t\t</div>
\t\t\t\t</div>
            </div>
            <!--//Action Bar-->

            <div class=\"uv-table uv-list-view\">
                <table>
                    <thead>
                        <tr>
\t\t\t\t\t\t\t<th style=\"width: 1px;\"></th>
                            <th></th>
                            <th>{{ \"Id\"|trans }}</th>
                            <th>{{ \"Article\"|trans }}</th>
\t                        <th>{{ \"Viewed\"|trans }}</th>
                            <th>{{ \"Created\"|trans }}</th>
                            <th>{{ \"Status\"|trans }}</th>
                            <th class=\"uv-last\">{{ \"Action\"|trans }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
\t\t\t\t<div class=\"navigation\"></div>
            </div>
\t\t</div>
\t</div>
{% endblock %}

{% block footer %}
\t{{ parent() }}

\t<!-- Sorting Template -->
\t<script id=\"article_list_sorting_tmp\" type=\"text/template\">
        <li class=\"<% if(sort == 'a.createdAt') { %>uv-drop-list-active<% } %>\">
            <a href=\"#<% if(queryString != '') { %><%- queryString %>/<% } %><% if(page) { %>page/<%- page %><% } else { %>page/1<% } %>/sort/a.createdAt/<% if(sort == 'a.createdAt') { %><% if(direction) { %>direction/<%- direction %><% } else { %>direction/desc<% } %><% } else { %>direction/asc<% } %>\" data-field=\"a.createdAt\">
\t\t\t\t{% trans %}Created At{% endtrans %}
\t\t\t\t<% if(sort == 'a.createdAt') { %>
\t\t\t\t\t<span class=\"uv-sorting <% if(direction == 'asc') { %> descend <% } else { %> ascend <% } %>\"></span>
\t\t\t\t<% } %>
\t\t\t</a>
        </li>

\t    <li class=\"<% if(sort == 'a.name') { %>uv-drop-list-active<% } %>\">
            <a href=\"#<% if(queryString != '') { %><%- queryString %>/<% } %><% if(page) { %>page/<%- page %><% } else { %>page/1<% } %>/sort/a.name/<% if(sort == 'a.name') { %><% if(direction) { %>direction/<%- direction %><% } else { %>direction/desc<% } %><% } else { %>direction/asc<% } %>\" data-field=\"a.name\">
\t\t\t\t{% trans %}Name{% endtrans %}
\t\t\t\t<% if(sort == 'a.name') { %>
\t\t\t\t\t<span class=\"uv-sorting <% if(direction == 'asc') { %> descend <% } else { %> ascend <% } %>\"></span>
\t\t\t\t<% } %>
\t\t\t</a>
        </li>

\t    <li class=\"<% if(sort == 'a.viewed') { %>uv-drop-list-active<% } %>\">
            <a href=\"#<% if(queryString != '') { %><%- queryString %>/<% } %><% if(page) { %>page/<%- page %><% } else { %>page/1<% } %>/sort/a.viewed/<% if(sort == 'a.viewed') { %><% if(direction) { %>direction/<%- direction %><% } else { %>direction/desc<% } %><% } else { %>direction/asc<% } %>\" data-field=\"a.viewed\">
\t\t\t\t{% trans %}Viewed{% endtrans %}
\t\t\t\t<% if(sort == 'a.viewed') { %>
\t\t\t\t\t<span class=\"uv-sorting <% if(direction == 'asc') { %> descend <% } else { %> ascend <% } %>\"></span>
\t\t\t\t<% } %>
\t\t\t</a>
        </li>
\t</script>
\t<!-- //Sorting Template -->

\t<!-- Article list item template -->
\t<script id=\"article_list_item_tmp\" type=\"text/template\">
\t\t<td>
            <label class=\"uv-vertical-align uv-margin-left-17\">
                <div class=\"uv-checkbox\">
                    <input type=\"checkbox\" class=\"mass-action-checkbox\" value=\"<%- id %>\"/>
                    <span class=\"uv-checkbox-view\"></span>
                </div>
            </label>
        </td>
\t\t<td data-value=\"{{ 'popularity'|trans }}\" class=\"uv-text-center\">
\t\t\t<% if(viewed > 100){ %>
\t\t\t\t<span class=\"uv-icon-popular uv-icon-popular-active\"></span>
\t\t\t<% }else{ %>
\t\t\t\t<span class=\"uv-icon-popular\"></span>
\t\t\t<% } %>
\t\t</td>
\t\t<td data-value=\"{{ 'Id'|trans }}\">
\t\t\t<%- id %>
\t\t</td>
\t\t<td data-value=\"{{ 'Article'|trans }}\"><%- name %></td>
\t\t<td data-value=\"{{ 'Viewed'|trans }}\"><%- viewed ? viewed : 0 %></td>
\t\t<td data-value=\"{{ 'Created'|trans }}\"><%- dateAdded %></td>
\t\t<td data-value=\"{{ 'Status'|trans }}\">
\t\t\t<% if(status) { %>
            \t<span class=\"uv-text-success\">{{ 'Published'|trans }}</span>
            <% } else { %>
            \t<span class=\"uv-text-danger\">{{ 'Draft'|trans }}</span>
        \t<% } %>
\t\t</td>
\t\t<td data-value=\"{{ 'Action'|trans }}\" class=\"uv-last-170\">
\t\t\t<a href=\"<%- path.replace('replaceId', id) %>\" class=\"uv-btn-stroke edit-article\">
\t\t\t\t{{ \"Edit\"|trans }}
\t\t\t</a>
\t\t\t<a class=\"uv-btn-stroke preview-article\" href=\"<%- pathPreview.replace('replaceId', slug) %>\" target=\"_blank\" <%- status ? '' : 'disabled=\"disabled\"' %>>
\t\t\t\t{{ \"Preview\"|trans }}
\t\t\t</a>
\t\t</td>
    </script>
\t<!-- //Article list item template -->

\t<script type=\"text/javascript\">
\t\tvar path = \"{{ path('helpdesk_member_knowledgebase_update_article', {'id': 'replaceId' }) }}\";
\t\tvar pathPreview = \"{{ path('helpdesk_knowledgebase_read_slug_article', {'slug': 'replaceId' }) }}\";

\t\t\$(function () {
\t\t\tvar globalMessageResponse = \"\";

\t\t\tvar ArticleModel = Backbone.Model.extend({
\t\t\t\tidAttribute : \"id\"
\t\t\t});

\t\t\tvar ArticleCollection = AppCollection.extend({
\t\t\t\tmodel : ArticleModel,
\t\t\t\turl : \"{{ path('helpdesk_member_knowledgebase_folder_articles_collection_xhr', {solution: solution.id}) }}\",
\t\t\t\tfilterParameters : {
\t\t\t\t\t\"isActive\" : \"\",
\t\t\t\t\t\"search\" : \"\"
\t\t\t\t},
\t\t\t\tparseRecords: function (resp, options) {
\t\t\t\t\treturn resp.results;
\t\t\t\t},
\t\t\t\tsyncData : function() {
\t\t\t\t\tapp.appView.showLoader();
\t\t\t\t\tthis.fetch({
\t\t\t\t\t\tdata : this.getValidParameters(),
\t\t\t\t\t\treset: true,
\t\t\t\t\t\tsuccess: function(model, response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tvar articleListView = new ArticleList();
\t\t\t\t\t\t\tapp.pager.paginationData = response.pagination_data;

\t\t\t\t\t\t\tvar url = app.pager.paginationData.url;
\t\t\t\t\t\t\tif(articleCollection.length == 0 && app.pager.paginationData.current != \"0\")
\t\t\t\t\t\t\t\trouter.navigate(url.replace('replacePage', app.pager.paginationData.last),{trigger: true});
\t\t\t\t\t\t\telse {
\t\t\t\t\t\t\t\tapp.pager.render();
\t\t\t\t\t\t\t}
\t\t\t\t\t\t\tif(globalMessageResponse)
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(globalMessageResponse);
\t\t\t\t\t\t\tglobalMessageResponse = null;
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t},
                batchOperation : function(data) {
\t\t\t\t\tif(!data.ids.length) return;
                    var self = this;
                    app.appView.showLoader();
                    \$.ajax({
                        url : \"{{ path('helpdesk_member_knowledgebase_update_article_xhr') }}\",
                        type : 'POST',
                        data : {data : data},
                        dataType : 'json',
                        success : function(response) {
                            app.appView.hideLoader();
                            globalMessageResponse = response;
                            self.syncData();
                        },
                        error: function (xhr) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                            \$('.mass-action-checkbox').prop('checked', false);
                        }
                    });
                }
\t\t\t});

\t\t\tvar ArticleItem = Backbone.View.extend({
\t\t\t\ttagName : \"tr\",
\t\t\t\ttemplate : _.template(\$(\"#article_list_item_tmp\").html()),
\t\t\t\trender : function() {
\t\t\t\t\tthis.\$el.html(this.template(this.model.toJSON()));
\t\t\t\t\treturn this;
\t\t\t\t},
\t\t\t\tunrender : function(response) {
\t\t\t\t\tif(response.alertMessage != undefined) {
\t\t\t\t\t\tarticleCollection.syncData();
\t\t\t\t\t\tapp.appView.renderResponseAlert(response)
\t\t\t\t\t}
\t\t\t\t},
\t\t\t});

\t\t\tvar ArticleList = Backbone.View.extend({
\t\t\t\tel : \$(\".uv-list-view table tbody\"),
\t\t\t\tevents: {
                    'change .mass-action-checkbox' : 'showBulkOptions'
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.render();
\t\t\t\t},
                showBulkOptions : function() {
                    var count = 0;
                    this.\$el.find('.mass-action-checkbox').each(function() {
                        if(\$(this).is(':checked'))
                            count++;
                    });

                    if(count == \$('.mass-action-checkbox').length)
                        \$('.select-all-checkbox').prop('checked', true);
                    else
                        \$('.select-all-checkbox').prop('checked', false);

                    if(count) {
                        \$('.uv-action-bar-col-lt').eq(0).hide();
                        \$('.uv-action-bar-col-lt').eq(1).show();
                        \$('.uv-action-bar-col-rt').hide()
                    } else {
                        \$('.uv-action-bar-col-lt').eq(1).hide();
                        \$('.uv-action-bar-col-lt').eq(0).show();
                        \$('.uv-action-bar-col-rt').show()
                    }
                },
\t\t\t\trender : function () {
\t\t\t\t\tthis.\$el.find(\"tr\").remove();
\t\t\t\t\tif(articleCollection.length) {
\t\t\t\t\t\t_.each(articleCollection.models, function (item) {
\t\t\t\t\t\t\tthis.renderArticle(item);
\t\t\t\t\t\t}, this);
\t\t\t\t\t} else {
\t\t\t\t\t\tthis.\$el.append(\"<tr style='text-align: center;'><td colspan='8'>{% trans %}No Record Found{% endtrans %}</td></tr>\")
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\trenderArticle : function (item) {
\t\t\t\t\tvar articleItem = new ArticleItem({
\t\t\t\t\t\tmodel: item
\t\t\t\t\t});
\t\t\t\t\tthis.\$el.append(articleItem.render().el);
\t\t\t\t}
\t\t\t});

            var BulkActionView = Backbone.View.extend({
                el : \$(\".mass-action\"),
                currentEvent : null,
                events : {
                    'click ul li' : 'massAction',
                    'click #mass-delete' : 'confirmRemove'
                },
                massAction: function(e) {
                    e.preventDefault();
                    //if(!parseInt(Backbone.\$(e.currentTarget).attr('data-index'))) return;
                    var data = {};
                    data['actionType'] = Backbone.\$(e.currentTarget).parents('ul').attr('data-action') ? Backbone.\$(e.currentTarget).parents('ul').attr('data-action') : Backbone.\$(e.currentTarget).attr('data-action');
                    data['targetId'] = Backbone.\$(e.currentTarget).attr('data-index');
                    data['ids'] = this.getCheckedIds();
                    articleCollection.batchOperation(data);
                    this.hideBulkOptions();
                },
                removeItem: function(e) {
                    var data = {};

                    if(Backbone.\$(this.currentEvent.currentTarget).is(\"#mass-delete\"))
                        data['actionType'] = \"delete\";

                    data['ids'] = this.getCheckedIds();
                    articleCollection.batchOperation(data);
                    this.hideBulkOptions();
                },
                getCheckedIds() {
                    var ids = new Array();
                    \$('.mass-action-checkbox').each(function() {
                        if(\$(this).is(':checked')) {
                            ids.push(\$(this).val());
                        }
                    });

                    return ids;
                },
                confirmRemove: function(e) {
                    e.preventDefault();
                    this.currentEvent = e;

                    app.appView.openConfirmModal(this)
                },
                hideBulkOptions : function() {
\t\t\t\t\t\$('.uv-action-bar-col-lt').eq(1).hide();
\t\t\t\t\t\$('.uv-action-bar-col-lt').eq(0).show();
\t\t\t\t\t\$('.uv-action-bar-col-rt').show()

\t\t\t\t\t\$('.select-all-checkbox').prop('checked', false)
                }
            });

\t\t\tvar FolderForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn.update-btn' : \"saveFolder\",
\t\t\t\t\t'blur input': 'formChanegd',
                    'click .cancel-btn': 'backToInfo',
                    'click .uv-aside-back': 'backToInfo'
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t    \tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t    },
\t\t\t\tsaveFolder: function (e) {
\t\t\t\t\te.preventDefault();
                    currentElement = Backbone.\$(e.currentTarget);
                    this.model.clear();
\t\t\t        this.model.set(this.\$el.find('form').serializeObject());
                    self = this;
\t\t\t        if(this.model.isValid(true)) {
                        app.appView.showLoader();
\t\t\t\t\t\tcurrentElement.attr('disabled', 'disabled');
                        this.model.save({}, {
                            success: function (model, response, options) {
                                app.appView.hideLoader();
                                currentElement.removeAttr(\"disabled\");
                                if(response.alertClass == \"success\") {
                                    app.appView.renderResponseAlert(response);
                                    \$('.uv-aside-customer-info .uv-bold').text(self.model.attributes.name);
                                    \$('.uv-aside-ticket-brick span').text(self.model.attributes.description);
                                    self.backToInfo();
                                } else
                                    self.addErrors(JSON.parse(response.errors));
                            },
                            error: function (model, xhr, options) {
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;

                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(warningResponse);
                            }
                        });
\t\t\t        }
\t\t\t\t},
                addErrors: function(jsonContext) {
\t\t    \t\tfor (var field in jsonContext) {
\t\t    \t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
                },
                backToInfo: function(e) {
                    if(e) e.preventDefault();

                    \$('.uv-main-info-update-block').hide()
                    \$('.uv-main-info-block').show()
                },
\t\t\t});

            var FolderModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'name': {
                        required: true,
                        msg: '{{ \"This field is mandatory\"|trans }}'
                    }
\t\t\t\t},
                urlRoot : \"{{ path('helpdesk_member_knowledgebase_update_folder_xhr') }}\"
\t\t\t});

\t\t\tvar foldermodel = new FolderModel({
                id : \"{{ solution.id }}\",
                name : \"{{ solution.name }}\",
\t\t\t\tvisibility: \"{{ solution.visibility }}\",
\t\t\t\tdescription: \"{{ solution.description }}\",
\t\t\t})

\t\t\tFolderForm = new FolderForm({
\t\t\t\tel : \$(\".uv-main-info-update-block\"),
\t\t\t\tmodel : foldermodel
\t\t\t});

            var PageView = Backbone.View.extend({
                el: '.uv-paper',
                events : {
                    'change .select-all-checkbox' : 'selectAll',
                    'click .uv-aside-customer-info .uv-customize': 'showUpdateBlock',
                    'click .uv-aside-ticket-actions .uv-aside-select .uv-dropdown-list li': 'editSolutionProperty',
                },
                editSolutionProperty: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    var uvSelect = currentElement.parents('.uv-aside-select');
                    var field = currentElement.parent().attr('data-action');
                    var value = currentElement.attr('data-index');
                    if(uvSelect.find('.uv-aside-select-value').attr('data-id') != value) {
                        var name = currentElement.text().trim();
                        app.appView.showLoader();
                        this.model.save({editType: field, value: value, id: this.model.id}, {
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
                selectAll : function(e) {
                    if(Backbone.\$(e.currentTarget).is(':checked')) {
\t\t\t\t\t\tif(\$('.mass-action-checkbox').length){
\t\t\t\t\t\t\t\$('.mass-action-checkbox').prop('checked', true);

\t\t\t\t\t\t\t\$('.uv-action-bar-col-lt').eq(0).hide();
\t\t\t\t\t\t\t\$('.uv-action-bar-col-lt').eq(1).show();
\t\t\t\t\t\t\t\$('.uv-action-bar-col-rt').hide()
\t\t\t\t\t\t}else
\t\t\t\t\t\t\tBackbone.\$(e.currentTarget).prop('checked', false)
                    } else {
                        var count = 0;
                        \$('.mass-action-checkbox').each(function() {
                            if(\$(this).is(':checked'))
                                count++;
                        });
                        if(count == \$('.mass-action-checkbox').length) {
                            \$('.mass-action-checkbox').prop('checked', false);

\t\t\t\t\t\t\t\$('.uv-action-bar-col-lt').eq(1).hide();
\t\t\t\t\t\t\t\$('.uv-action-bar-col-lt').eq(0).show();
\t\t\t\t\t\t\t\$('.uv-action-bar-col-rt').show()
                        }
                    }
                },
                showUpdateBlock: function() {
                    \$('.uv-main-info-update-block').show()
                    \$('.uv-main-info-block').hide()
                },
            });

\t\t\tvar pageView = new PageView({
\t\t\t\tmodel : foldermodel
\t\t\t});
            var bulkAction = new BulkActionView();

\t\t\tvar Filter = app.Filter.extend({
\t\t\t\tdefaultSortIndex: 'a.createdAt',
\t\t\t\tsortText: \"{% trans %}Sort By:{% endtrans %} \",
\t\t\t\tdefaultSortText: \"{% trans %}Sort By:{% endtrans %} {% trans %}Created At{% endtrans %}\",
\t\t\t\ttemplate : _.template(\$(\"#article_list_sorting_tmp\").html())
\t\t\t})

\t\t\tvar articleCollection = new ArticleCollection();

\t\t\tvar filter = new Filter({
\t\t\t\tcollection : articleCollection
\t\t\t});

\t\t\tRouter = Backbone.Router.extend({
\t\t\t\troutes: {
\t\t\t\t\t'page/:number(/sort/:sortField)(/direction/:order)' : 'paginate',
\t\t\t\t\t'isActive/:status(/search/:query)(/page/:number)(/sort/:sortField)(/direction/:order)' : 'filterArticleByStatus',
\t\t\t\t\t'search/:query(/page/:number)(/sort/:sortField)(/direction/:order)' : 'filterByQuery',
\t\t\t\t\t'' : 'initializeList'
\t\t\t\t},
\t\t\t\tinitializeList : function() {
\t\t\t\t\tthis.resetParams('', '');
\t\t\t\t\tarticleCollection.state.currentPage = null;
\t\t\t\t\tfilter.sortCollection();
\t\t\t\t\tarticleCollection.syncData();
\t\t\t\t},
\t\t\t\tpaginate : function(number,sortField,order) {
\t\t\t\t\tthis.resetParams('', '');
\t\t\t\t\tarticleCollection.state.currentPage = number;
\t\t\t\t\tfilter.sortCollection(sortField,order);
\t\t\t\t\tarticleCollection.syncData();
\t\t\t\t},
\t\t\t\tfilterArticleByStatus: function(status,query,number,sortField,order) {
\t\t\t\t\tthis.resetParams(status,query);
\t\t\t\t\tarticleCollection.state.currentPage = number;
\t\t\t\t\tfilter.sortCollection(sortField,order);
\t\t\t\t\tarticleCollection.syncData();
\t\t\t\t},
\t\t\t\tfilterByQuery : function(query,number,sortField,order) {
\t\t\t\t\tthis.resetParams('',query);
\t\t\t\t\tarticleCollection.state.currentPage = number;
\t\t\t\t\tfilter.sortCollection(sortField,order);
\t\t\t\t\tarticleCollection.syncData();
\t\t\t\t},
\t\t\t\tresetParams : function(status, query) {
\t\t\t\t\tif(query != null)
\t\t\t\t\t\tquery = query.replace(/\\+/g,' ');
\t\t\t\t\tarticleCollection.filterParameters.isActive = status;
\t\t\t\t\tvar statusText = status ? \$(\".filter-by-status a[data-id='\" + status + \"']\").text() : \"{% trans %}All{% endtrans %}\";
\t\t\t\t\t\$(\".filter-by-status .uv-dropdown-btn\").text(\"{% trans %}Status:{% endtrans %} \" + statusText);
\t\t\t\t\tarticleCollection.filterParameters.search = query;
\t\t\t\t\t\$(\".uv-search-inline\").val(query);
\t\t\t\t}
\t\t\t});

\t\t\trouter = new Router();
\t\t\tBackbone.history.start({push_state:true});
\t\t});
\t</script>
{% endblock %}", "@UVDeskSupportCenter/Staff/Articles/articleListBySolution.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Staff/Articles/articleListBySolution.html.twig");
    }
}
