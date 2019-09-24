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

/* @UVDeskSupportCenter/Knowledgebase/popularArticle.html.twig */
class __TwigTemplate_2700f197b60b5974660ee549084ba2054c3fc0e69c51bf991c051b6f771c3f84 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Knowledgebase/popularArticle.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Knowledgebase/popularArticle.html.twig"));

        // line 1
        $context["popArticles"] = "";
        // line 2
        if ((isset($context["popArticles"]) || array_key_exists("popArticles", $context) ? $context["popArticles"] : (function () { throw new RuntimeError('Variable "popArticles" does not exist.', 2, $this->source); })())) {
            // line 3
            echo "    <div class=\"uv-paper-aside\">
        <aside>
            <h3>";
            // line 5
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Popular Articles"), "html", null, true);
            echo "</h3>
            <ul>
                ";
            // line 7
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["popArticles"]) || array_key_exists("popArticles", $context) ? $context["popArticles"] : (function () { throw new RuntimeError('Variable "popArticles" does not exist.', 7, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["popArticle"]) {
                // line 8
                echo "                    <li><a href=\"";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_read_slug_article", ["slug" => twig_get_attribute($this->env, $this->source, $context["popArticle"], "slug", [], "any", false, false, false, 8)]), "html", null, true);
                echo "\"> ";
                if (twig_get_attribute($this->env, $this->source, $context["popArticle"], "stared", [], "any", false, false, false, 8)) {
                    echo "<span class=\"uv-icon-star uv-pre\"></span>";
                }
                echo " ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["popArticle"], "name", [], "any", false, false, false, 8), "html", null, true);
                echo "</a></li>
                    ";
                // line 10
                echo "                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['popArticle'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 11
            echo "            </ul>
        </aside>
    </div>
";
        }
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Knowledgebase/popularArticle.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  77 => 11,  71 => 10,  60 => 8,  56 => 7,  51 => 5,  47 => 3,  45 => 2,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% set popArticles = \"\"%}
{% if popArticles %}
    <div class=\"uv-paper-aside\">
        <aside>
            <h3>{{'Popular Articles'|trans}}</h3>
            <ul>
                {% for popArticle in popArticles %}
                    <li><a href=\"{{path('helpdesk_knowledgebase_read_slug_article', {'slug': popArticle.slug})}}\"> {% if popArticle.stared %}<span class=\"uv-icon-star uv-pre\"></span>{% endif %} {{ popArticle.name }}</a></li>
                    {#<li><a href=\"{{path('helpdesk_knowledgebase_read_article', {'article': popArticle.id})}}\"> {% if popArticle.stared %}<span class=\"uv-icon-star uv-pre\"></span>{% endif %} {{popArticle.name}}</a></li>#}
                {% endfor %}
            </ul>
        </aside>
    </div>
{% endif %}", "@UVDeskSupportCenter/Knowledgebase/popularArticle.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Knowledgebase/popularArticle.html.twig");
    }
}
