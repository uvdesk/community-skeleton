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

/* @UVDeskSupportCenter/Themes/articleView.html.twig */
class __TwigTemplate_f5f5440d037d93d1314c50a14e3622417d42f241035575b1bdcc3b34b9250954 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Themes/articleView.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Themes/articleView.html.twig"));

        // line 1
        echo "<div class=\"uv-kb-section\">
\t<div class=\"uv-kb-section-layout uv-kb-layout-article\">
\t\t<div class=\"uv-kb-folder\">
\t\t\t<h2>";
        // line 4
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Popular Articles"), "html", null, true);
        echo "</h2>
\t\t\t<p>";
        // line 5
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Here are some of the most popular articles, which helped number of users to get their queries and questions resolved."), "html", null, true);
        echo "</p>
\t\t\t<ul>
    \t\t\t";
        // line 7
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["popArticles"]) || array_key_exists("popArticles", $context) ? $context["popArticles"] : (function () { throw new RuntimeError('Variable "popArticles" does not exist.', 7, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["popArticle"]) {
            // line 8
            echo "\t\t\t\t\t<li><a href=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_read_article", ["article" => twig_get_attribute($this->env, $this->source, $context["popArticle"], "id", [], "any", false, false, false, 8)]), "html", null, true);
            echo "\"> ";
            if (twig_get_attribute($this->env, $this->source, $context["popArticle"], "stared", [], "any", false, false, false, 8)) {
                echo "<span class=\"uv-icon-star uv-pre\"></span>";
            }
            echo " ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["popArticle"], "name", [], "any", false, false, false, 8), "html", null, true);
            echo "</a></li>
    \t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['popArticle'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 10
        echo "\t\t\t</ul>
\t\t</div>
\t</div>
</div>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Themes/articleView.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  76 => 10,  61 => 8,  57 => 7,  52 => 5,  48 => 4,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"uv-kb-section\">
\t<div class=\"uv-kb-section-layout uv-kb-layout-article\">
\t\t<div class=\"uv-kb-folder\">
\t\t\t<h2>{{\"Popular Articles\"|trans}}</h2>
\t\t\t<p>{{\"Here are some of the most popular articles, which helped number of users to get their queries and questions resolved.\"|trans}}</p>
\t\t\t<ul>
    \t\t\t{% for popArticle in popArticles %}
\t\t\t\t\t<li><a href=\"{{path('helpdesk_knowledgebase_read_article', {'article': popArticle.id})}}\"> {% if popArticle.stared %}<span class=\"uv-icon-star uv-pre\"></span>{% endif %} {{ popArticle.name }}</a></li>
    \t\t\t{% endfor %}
\t\t\t</ul>
\t\t</div>
\t</div>
</div>", "@UVDeskSupportCenter/Themes/articleView.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Themes/articleView.html.twig");
    }
}
