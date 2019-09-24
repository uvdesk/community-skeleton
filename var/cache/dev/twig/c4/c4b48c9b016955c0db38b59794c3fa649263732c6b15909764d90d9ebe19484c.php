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

/* @UVDeskSupportCenter/Staff/Category/categoryForm.html.twig */
class __TwigTemplate_fc3d52f2ed6ff999a569efdbb505d5e6e73318cdd0aaec8f5a7fdd9d812023b5 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Staff/Category/categoryForm.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Staff/Category/categoryForm.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskSupportCenter/Staff/Category/categoryForm.html.twig", 1);
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
        echo "    ";
        if (twig_get_attribute($this->env, $this->source, (isset($context["category"]) || array_key_exists("category", $context) ? $context["category"] : (function () { throw new RuntimeError('Variable "category" does not exist.', 4, $this->source); })()), "id", [], "any", false, false, false, 4)) {
            // line 5
            echo "\t\t";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit Category"), "html", null, true);
            echo "
\t";
        } else {
            // line 7
            echo "\t\t";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Category"), "html", null, true);
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
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\SupportCenterBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Knowledgebase";
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
        if (twig_get_attribute($this->env, $this->source, (isset($context["category"]) || array_key_exists("category", $context) ? $context["category"] : (function () { throw new RuntimeError('Variable "category" does not exist.', 21, $this->source); })()), "id", [], "any", false, false, false, 21)) {
            // line 22
            echo "\t\t\t\t\t";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit Category"), "html", null, true);
            echo "
\t\t\t\t";
        } else {
            // line 24
            echo "\t\t\t\t\t";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Category"), "html", null, true);
            echo "
\t\t\t\t";
        }
        // line 26
        echo "\t\t\t</h1>

\t\t\t<!--Form-->
\t\t\t<form method=\"post\" action=\"\" id=\"entity-form\" enctype=\"multipart/form-data\">
\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 32
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Name"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<input type=\"text\" name=\"name\" class=\"uv-field\" value=\"";
        // line 34
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["category"]) || array_key_exists("category", $context) ? $context["category"] : (function () { throw new RuntimeError('Variable "category" does not exist.', 34, $this->source); })()), "name", [], "any", false, false, false, 34), "html", null, true);
        echo "\" />
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 36
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Category Name is shown upfront at Knowledge Base"), "html", null, true);
        echo "</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 42
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Description"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<textarea name=\"description\" class=\"uv-field\">";
        // line 44
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["category"]) || array_key_exists("category", $context) ? $context["category"] : (function () { throw new RuntimeError('Variable "category" does not exist.', 44, $this->source); })()), "description", [], "any", false, false, false, 44), "html", null, true);
        echo "</textarea>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 46
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("A small text about the category helps user to navigate more easily"), "html", null, true);
        echo "</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

                <!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 52
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Folders"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\" id=\"folder-filter\">
\t\t\t\t\t\t<input type=\"hidden\" name=\"tempSolutions\" class=\"uv-field\" value=\"\" />
                        <input class=\"uv-field uv-dropdown-other preloaded\" type=\"text\" id=\"folder-filter-input\">
                        <div class=\"uv-dropdown-list uv-bottom-left uv-width-70\">
                            <div class=\"uv-dropdown-container\">
                                <label>";
        // line 58
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Filter With"), "html", null, true);
        echo "</label>
                            </div>
                            <ul class=\"uv-agents-list\">
                                ";
        // line 61
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["solutions"]) || array_key_exists("solutions", $context) ? $context["solutions"] : (function () { throw new RuntimeError('Variable "solutions" does not exist.', 61, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["solution"]) {
            // line 62
            echo "                                    <li data-id=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["solution"], "id", [], "any", false, false, false, 62), "html", null, true);
            echo "\">
                                        ";
            // line 63
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["solution"], "name", [], "any", false, false, false, 63), "html", null, true);
            echo "
                                    </li>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['solution'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 66
        echo "                                <li class=\"uv-no-results\" style=\"display: none;\">
                                    ";
        // line 67
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("No result found"), "html", null, true);
        echo "
                                </li>
                            </ul>
                        </div>
                        <div class=\"uv-filtered-tags\">
                            ";
        // line 72
        if ((isset($context["categorySolutions"]) || array_key_exists("categorySolutions", $context) ? $context["categorySolutions"] : (function () { throw new RuntimeError('Variable "categorySolutions" does not exist.', 72, $this->source); })())) {
            // line 73
            echo "                                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["categorySolutions"]) || array_key_exists("categorySolutions", $context) ? $context["categorySolutions"] : (function () { throw new RuntimeError('Variable "categorySolutions" does not exist.', 73, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["solution"]) {
                // line 74
                echo "                                    <a class=\"uv-btn-small default\" href=\"#\" data-id=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["solution"], "id", [], "any", false, false, false, 74), "html", null, true);
                echo "\">
                                        ";
                // line 75
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["solution"], "name", [], "any", false, false, false, 75), "html", null, true);
                echo "
                                        <span class=\"uv-icon-remove\"></span>
                                    </a>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['solution'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 79
            echo "                            ";
        }
        // line 80
        echo "                        </div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 86
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Sort Order"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<input type=\"number\" name=\"sortOrder\" class=\"uv-field\" value=\"";
        // line 88
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["category"]) || array_key_exists("category", $context) ? $context["category"] : (function () { throw new RuntimeError('Variable "category" does not exist.', 88, $this->source); })()), "sortOrder", [], "any", false, false, false, 88), "html", null, true);
        echo "\" />
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 90
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Using Category Order, you can decide which category should display first"), "html", null, true);
        echo "</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 96
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Sorting"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<select class=\"uv-select\" name=\"sorting\">
\t\t\t\t\t\t\t<option value=\"ascending\" ";
        // line 99
        echo (((twig_get_attribute($this->env, $this->source, (isset($context["category"]) || array_key_exists("category", $context) ? $context["category"] : (function () { throw new RuntimeError('Variable "category" does not exist.', 99, $this->source); })()), "sorting", [], "any", false, false, false, 99) && (twig_get_attribute($this->env, $this->source, (isset($context["category"]) || array_key_exists("category", $context) ? $context["category"] : (function () { throw new RuntimeError('Variable "category" does not exist.', 99, $this->source); })()), "sorting", [], "any", false, false, false, 99) == "ascending"))) ? ("selected") : (""));
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Ascending Order (A-Z)"), "html", null, true);
        echo "</option>
\t\t\t\t\t\t\t<option value=\"descending\" ";
        // line 100
        echo (((twig_get_attribute($this->env, $this->source, (isset($context["category"]) || array_key_exists("category", $context) ? $context["category"] : (function () { throw new RuntimeError('Variable "category" does not exist.', 100, $this->source); })()), "sorting", [], "any", false, false, false, 100) && (twig_get_attribute($this->env, $this->source, (isset($context["category"]) || array_key_exists("category", $context) ? $context["category"] : (function () { throw new RuntimeError('Variable "category" does not exist.', 100, $this->source); })()), "sorting", [], "any", false, false, false, 100) == "descending"))) ? ("selected") : (""));
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Descending Order (Z-A)"), "html", null, true);
        echo "</option>
\t\t\t\t\t\t\t<option value=\"popularity\" ";
        // line 101
        echo (((twig_get_attribute($this->env, $this->source, (isset($context["category"]) || array_key_exists("category", $context) ? $context["category"] : (function () { throw new RuntimeError('Variable "category" does not exist.', 101, $this->source); })()), "sorting", [], "any", false, false, false, 101) && (twig_get_attribute($this->env, $this->source, (isset($context["category"]) || array_key_exists("category", $context) ? $context["category"] : (function () { throw new RuntimeError('Variable "category" does not exist.', 101, $this->source); })()), "sorting", [], "any", false, false, false, 101) == "popularity"))) ? ("selected") : (""));
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Based on Popularity"), "html", null, true);
        echo "</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 104
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Article of this category will display according to selected option"), "html", null, true);
        echo "</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 110
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<select class=\"uv-select\" name=\"status\">
\t\t\t\t\t\t\t<option value=\"1\"  ";
        // line 113
        echo ((twig_get_attribute($this->env, $this->source, (isset($context["category"]) || array_key_exists("category", $context) ? $context["category"] : (function () { throw new RuntimeError('Variable "category" does not exist.', 113, $this->source); })()), "status", [], "any", false, false, false, 113)) ? ("selected") : (""));
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Publish"), "html", null, true);
        echo "</option>
\t\t\t\t\t\t\t<option value=\"0\"  ";
        // line 114
        echo (( !twig_get_attribute($this->env, $this->source, (isset($context["category"]) || array_key_exists("category", $context) ? $context["category"] : (function () { throw new RuntimeError('Variable "category" does not exist.', 114, $this->source); })()), "status", [], "any", false, false, false, 114)) ? ("selected") : (""));
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Draft"), "html", null, true);
        echo "</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 117
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Choose appropriate status"), "html", null, true);
        echo "</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!--CTA-->
\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"";
        // line 122
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

    // line 129
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 130
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar EntityModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'name': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"";
        // line 137
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
\t\t\t\t\t}, {
\t\t\t\t\t\tpattern: '^((?![\$%<]).)*\$',
\t\t\t\t\t\tmsg: \"";
        // line 140
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field must have valid characters only"), "html", null, true);
        echo "\"
\t\t\t\t\t},{
\t\t\t\t\t\tmaxLength:50,
\t\t\t\t\t\tmsg:\"";
        // line 143
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field contain maximum 50 charectures."), "html", null, true);
        echo "\"
\t\t\t\t\t}],
                    'sortOrder': {
                        pattern: '^[0-9]*\$',
                        msg: \"";
        // line 147
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field must be a number"), "html", null, true);
        echo "\"
                    },
\t\t\t\t}
\t\t\t});

\t\t\tvar EntityForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn': \"saveEntity\",
\t\t\t\t\t'blur input, textarea': 'formChanegd',
                    'click .uv-dropdown-list li': 'addEntity',
                    'click .uv-filtered-tags .uv-btn-small': 'removeEntity'
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.setAddedIds('#folder-filter')

\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t\tvar jsonContext = JSON.parse('";
        // line 163
        echo (isset($context["errors"]) || array_key_exists("errors", $context) ? $context["errors"] : (function () { throw new RuntimeError('Variable "errors" does not exist.', 163, $this->source); })());
        echo "');
\t\t    \t\tfor (var field in jsonContext) {
\t\t    \t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t\t\tif(e.target.name != 'solutionImage'){
\t\t\t    \t\tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \t\tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t\t\t}
\t\t\t    },
\t\t\t\tsaveEntity : function (e) {
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
                        parent.find(\"li:not(.uv-no-results)\").show()
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

\t\t\tgroupForm = new EntityForm({
\t\t\t\tel : \$(\"#entity-form\"),
\t\t\t\tmodel : new EntityModel()
\t\t\t});
\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Staff/Category/categoryForm.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  422 => 163,  403 => 147,  396 => 143,  390 => 140,  384 => 137,  373 => 130,  363 => 129,  346 => 122,  338 => 117,  330 => 114,  324 => 113,  318 => 110,  309 => 104,  301 => 101,  295 => 100,  289 => 99,  283 => 96,  274 => 90,  269 => 88,  264 => 86,  256 => 80,  253 => 79,  243 => 75,  238 => 74,  233 => 73,  231 => 72,  223 => 67,  220 => 66,  211 => 63,  206 => 62,  202 => 61,  196 => 58,  187 => 52,  178 => 46,  173 => 44,  168 => 42,  159 => 36,  154 => 34,  149 => 32,  141 => 26,  135 => 24,  129 => 22,  127 => 21,  120 => 19,  115 => 17,  112 => 16,  109 => 15,  106 => 14,  103 => 12,  93 => 11,  79 => 7,  73 => 5,  70 => 4,  60 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %}
    {% if category.id %}
\t\t{{ 'Edit Category'|trans }}
\t{% else %}
\t\t{{ 'Add Category'|trans }}
\t{% endif %}
{% endblock %}

{% block pageContent %}
\t<div class=\"uv-inner-section\">
\t\t{# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\SupportCenterBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Knowledgebase' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}
\t\t
\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
\t\t\t<h1>
\t\t\t\t{% if category.id %}
\t\t\t\t\t{{ 'Edit Category'|trans }}
\t\t\t\t{% else %}
\t\t\t\t\t{{ 'Add Category'|trans }}
\t\t\t\t{% endif %}
\t\t\t</h1>

\t\t\t<!--Form-->
\t\t\t<form method=\"post\" action=\"\" id=\"entity-form\" enctype=\"multipart/form-data\">
\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Name'|trans }}</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<input type=\"text\" name=\"name\" class=\"uv-field\" value=\"{{ category.name }}\" />
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">{{ 'Category Name is shown upfront at Knowledge Base'|trans }}</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Description'|trans }}</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<textarea name=\"description\" class=\"uv-field\">{{ category.description }}</textarea>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">{{ 'A small text about the category helps user to navigate more easily'|trans }}</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

                <!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Folders'|trans }}</label>
\t\t\t\t\t<div class=\"uv-field-block\" id=\"folder-filter\">
\t\t\t\t\t\t<input type=\"hidden\" name=\"tempSolutions\" class=\"uv-field\" value=\"\" />
                        <input class=\"uv-field uv-dropdown-other preloaded\" type=\"text\" id=\"folder-filter-input\">
                        <div class=\"uv-dropdown-list uv-bottom-left uv-width-70\">
                            <div class=\"uv-dropdown-container\">
                                <label>{{ 'Filter With'|trans }}</label>
                            </div>
                            <ul class=\"uv-agents-list\">
                                {% for solution in solutions %}
                                    <li data-id=\"{{solution.id}}\">
                                        {{solution.name}}
                                    </li>
                                {% endfor %}
                                <li class=\"uv-no-results\" style=\"display: none;\">
                                    {{ 'No result found'|trans }}
                                </li>
                            </ul>
                        </div>
                        <div class=\"uv-filtered-tags\">
                            {% if categorySolutions %}
                                {% for solution in categorySolutions %}
                                    <a class=\"uv-btn-small default\" href=\"#\" data-id=\"{{ solution.id }}\">
                                        {{ solution.name }}
                                        <span class=\"uv-icon-remove\"></span>
                                    </a>
                                {% endfor %}
                            {% endif %}
                        </div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Sort Order'|trans }}</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<input type=\"number\" name=\"sortOrder\" class=\"uv-field\" value=\"{{ category.sortOrder }}\" />
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">{{ 'Using Category Order, you can decide which category should display first'|trans }}</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Sorting'|trans }}</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<select class=\"uv-select\" name=\"sorting\">
\t\t\t\t\t\t\t<option value=\"ascending\" {{ (category.sorting and category.sorting == 'ascending') ? 'selected' : '' }}>{{ 'Ascending Order (A-Z)'|trans }}</option>
\t\t\t\t\t\t\t<option value=\"descending\" {{ (category.sorting and category.sorting == 'descending') ? 'selected' : '' }}>{{ 'Descending Order (Z-A)'|trans }}</option>
\t\t\t\t\t\t\t<option value=\"popularity\" {{ (category.sorting and category.sorting == 'popularity') ? 'selected' : '' }}>{{ 'Based on Popularity'|trans }}</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">{{ 'Article of this category will display according to selected option'|trans }}</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Status'|trans }}</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<select class=\"uv-select\" name=\"status\">
\t\t\t\t\t\t\t<option value=\"1\"  {{ category.status ? 'selected' : '' }}>{{ 'Publish'|trans }}</option>
\t\t\t\t\t\t\t<option value=\"0\"  {{ not category.status ? 'selected' : '' }}>{{ 'Draft'|trans }}</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">{{ 'Choose appropriate status'|trans }}</span>
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
\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar EntityModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'name': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"{{ 'This field is mandatory'|trans }}\"
\t\t\t\t\t}, {
\t\t\t\t\t\tpattern: '^((?![\$%<]).)*\$',
\t\t\t\t\t\tmsg: \"{{ 'This field must have valid characters only'|trans }}\"
\t\t\t\t\t},{
\t\t\t\t\t\tmaxLength:50,
\t\t\t\t\t\tmsg:\"{{'This field contain maximum 50 charectures.'|trans}}\"
\t\t\t\t\t}],
                    'sortOrder': {
                        pattern: '^[0-9]*\$',
                        msg: \"{{ 'This field must be a number'|trans }}\"
                    },
\t\t\t\t}
\t\t\t});

\t\t\tvar EntityForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn': \"saveEntity\",
\t\t\t\t\t'blur input, textarea': 'formChanegd',
                    'click .uv-dropdown-list li': 'addEntity',
                    'click .uv-filtered-tags .uv-btn-small': 'removeEntity'
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.setAddedIds('#folder-filter')

\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t\tvar jsonContext = JSON.parse('{{ errors|raw }}');
\t\t    \t\tfor (var field in jsonContext) {
\t\t    \t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t\t\tif(e.target.name != 'solutionImage'){
\t\t\t    \t\tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \t\tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t\t\t}
\t\t\t    },
\t\t\t\tsaveEntity : function (e) {
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
                        parent.find(\"li:not(.uv-no-results)\").show()
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

\t\t\tgroupForm = new EntityForm({
\t\t\t\tel : \$(\"#entity-form\"),
\t\t\t\tmodel : new EntityModel()
\t\t\t});
\t\t});
\t</script>
{% endblock %}", "@UVDeskSupportCenter/Staff/Category/categoryForm.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Staff/Category/categoryForm.html.twig");
    }
}
