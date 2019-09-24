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

/* @UVDeskSupportCenter/Themes/categoryView.html.twig */
class __TwigTemplate_4d08a9b138e85e42d60d6a2068ac49e48d3e99ea89c5319e4e7a084928b71738 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Themes/categoryView.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Themes/categoryView.html.twig"));

        // line 1
        echo "<div class=\"uv-kb-section\">
\t<div class=\"uv-kb-section-head\">
\t\t<h1 class=\"uv-text-center\">";
        // line 3
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Browse via Categories"), "html", null, true);
        echo "</h1>
\t\t<p class=\"uv-text-center uv-fixed-width\">";
        // line 4
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Looking for something specific? Choose a relevant category from below to explore possible solutions"), "html", null, true);
        echo "</p>
\t</div>
\t<div class=\"uv-kb-section-layout uv-kb-layout-category\">
\t\t";
        // line 7
        if ((twig_get_attribute($this->env, $this->source, ($context["solutions"] ?? null), "categories", [], "any", true, true, false, 7) &&  !twig_test_empty(twig_get_attribute($this->env, $this->source, (isset($context["solutions"]) || array_key_exists("solutions", $context) ? $context["solutions"] : (function () { throw new RuntimeError('Variable "solutions" does not exist.', 7, $this->source); })()), "categories", [], "any", false, false, false, 7)))) {
            // line 8
            echo "\t\t\t";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["solutions"]) || array_key_exists("solutions", $context) ? $context["solutions"] : (function () { throw new RuntimeError('Variable "solutions" does not exist.', 8, $this->source); })()), "categories", [], "any", false, false, false, 8));
            foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
                // line 9
                echo "\t\t\t\t";
                if ((twig_get_attribute($this->env, $this->source, $context["category"], "articles", [], "any", true, true, false, 9) &&  !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["category"], "articles", [], "any", false, false, false, 9)))) {
                    // line 10
                    echo "\t\t\t\t\t<div class=\"uv-kb-folder uv-kb-category\">
\t\t\t\t\t\t<p class=\"uv-category-heading\">";
                    // line 11
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 11), "html", null, true);
                    echo "</p>
\t\t\t\t\t\t<p class=\"uv-folder-description\">";
                    // line 12
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["category"], "description", [], "any", false, false, false, 12), "html", null, true);
                    echo "</p>

\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t";
                    // line 15
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["category"], "articles", [], "any", false, false, false, 15));
                    foreach ($context['_seq'] as $context["_key"] => $context["article"]) {
                        // line 16
                        echo "\t\t\t\t\t\t\t\t<li><a href=\"";
                        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_read_slug_article", ["slug" => twig_get_attribute($this->env, $this->source, $context["article"], "slug", [], "any", false, false, false, 16)]), "html", null, true);
                        echo "\">";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["article"], "name", [], "any", false, false, false, 16), "html", null, true);
                        echo "</a></li>
\t\t\t\t\t\t\t";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['article'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 18
                    echo "\t\t\t\t\t\t</ul>

\t\t\t\t\t\t<a href=\"";
                    // line 20
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_category", ["category" => twig_get_attribute($this->env, $this->source, $context["category"], "id", [], "any", false, false, false, 20)]), "html", null, true);
                    echo "\" class=\"uv-btn-small\">";
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("View all articles"), "html", null, true);
                    echo "</a>
\t\t\t\t\t</div>
\t\t\t\t";
                }
                // line 23
                echo "\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 24
            echo "
\t\t\t<div style=\"text-align: center; margin-top: 30px;\">
\t\t\t\t<a href=\"";
            // line 26
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_category_collection");
            echo "\" class=\"uv-btn\">View all Categories</a>
\t\t\t</div>
\t\t";
        } else {
            // line 29
            echo "\t\t\t<p>";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("No Categories Found!"), "html", null, true);
            echo "</p>
\t\t";
        }
        // line 31
        echo "\t</div>
</div>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Themes/categoryView.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  129 => 31,  123 => 29,  117 => 26,  113 => 24,  107 => 23,  99 => 20,  95 => 18,  84 => 16,  80 => 15,  74 => 12,  70 => 11,  67 => 10,  64 => 9,  59 => 8,  57 => 7,  51 => 4,  47 => 3,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"uv-kb-section\">
\t<div class=\"uv-kb-section-head\">
\t\t<h1 class=\"uv-text-center\">{{ \"Browse via Categories\"|trans}}</h1>
\t\t<p class=\"uv-text-center uv-fixed-width\">{{ \"Looking for something specific? Choose a relevant category from below to explore possible solutions\"|trans}}</p>
\t</div>
\t<div class=\"uv-kb-section-layout uv-kb-layout-category\">
\t\t{% if solutions.categories is defined and solutions.categories is not empty %}
\t\t\t{% for category in solutions.categories %}
\t\t\t\t{% if category.articles is defined and category.articles is not empty %}
\t\t\t\t\t<div class=\"uv-kb-folder uv-kb-category\">
\t\t\t\t\t\t<p class=\"uv-category-heading\">{{ category.name }}</p>
\t\t\t\t\t\t<p class=\"uv-folder-description\">{{ category.description }}</p>

\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t{% for article in category.articles %}
\t\t\t\t\t\t\t\t<li><a href=\"{{ path('helpdesk_knowledgebase_read_slug_article', {'slug': article.slug}) }}\">{{ article.name }}</a></li>
\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t</ul>

\t\t\t\t\t\t<a href=\"{{ path('helpdesk_knowledgebase_category', {'category': category.id}) }}\" class=\"uv-btn-small\">{{ \"View all articles\"|trans }}</a>
\t\t\t\t\t</div>
\t\t\t\t{% endif %}
\t\t\t{% endfor %}

\t\t\t<div style=\"text-align: center; margin-top: 30px;\">
\t\t\t\t<a href=\"{{ path('helpdesk_knowledgebase_category_collection') }}\" class=\"uv-btn\">View all Categories</a>
\t\t\t</div>
\t\t{% else %}
\t\t\t<p>{{ \"No Categories Found!\"|trans }}</p>
\t\t{% endif %}
\t</div>
</div>
", "@UVDeskSupportCenter/Themes/categoryView.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Themes/categoryView.html.twig");
    }
}
