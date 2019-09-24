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

/* @UVDeskSupportCenter/Templates/sidepanel.html.twig */
class __TwigTemplate_1d6d57bca9bab79c627f538b9f9423bea7932bce2fb5c195f137ea87f10def18 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Templates/sidepanel.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Templates/sidepanel.html.twig"));

        // line 1
        echo "<div class=\"uv-paper-aside\">
    ";
        // line 2
        if (((isset($context["popArticles"]) || array_key_exists("popArticles", $context)) && (isset($context["popArticles"]) || array_key_exists("popArticles", $context) ? $context["popArticles"] : (function () { throw new RuntimeError('Variable "popArticles" does not exist.', 2, $this->source); })()))) {
            // line 3
            echo "        <aside>
            <h3>";
            // line 4
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Popular Articles"), "html", null, true);
            echo "</h3>
            <ul>
                ";
            // line 6
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["popArticles"]) || array_key_exists("popArticles", $context) ? $context["popArticles"] : (function () { throw new RuntimeError('Variable "popArticles" does not exist.', 6, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["popArticle"]) {
                // line 7
                echo "                    <li><a href=\"";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_read_slug_article", ["slug" => twig_get_attribute($this->env, $this->source, $context["popArticle"], "slug", [], "any", false, false, false, 7)]), "html", null, true);
                echo "\"> ";
                if (twig_get_attribute($this->env, $this->source, $context["popArticle"], "stared", [], "any", false, false, false, 7)) {
                    echo "<span class=\"uv-icon-star uv-pre\"></span>";
                }
                echo " ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["popArticle"], "name", [], "any", false, false, false, 7), "html", null, true);
                echo "</a></li>
                    ";
                // line 9
                echo "                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['popArticle'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 10
            echo "            </ul>
        </aside>
    ";
        }
        // line 13
        echo "    
    ";
        // line 14
        if (((isset($context["relatedArticles"]) || array_key_exists("relatedArticles", $context)) && (isset($context["relatedArticles"]) || array_key_exists("relatedArticles", $context) ? $context["relatedArticles"] : (function () { throw new RuntimeError('Variable "relatedArticles" does not exist.', 14, $this->source); })()))) {
            // line 15
            echo "        <aside class=\"uv-margin-top-30\">
            <h3>";
            // line 16
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Related Articles"), "html", null, true);
            echo "</h3>
            <ul>
                ";
            // line 18
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["relatedArticles"]) || array_key_exists("relatedArticles", $context) ? $context["relatedArticles"] : (function () { throw new RuntimeError('Variable "relatedArticles" does not exist.', 18, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["relatedArticle"]) {
                // line 19
                echo "                    <li><a href=\"";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_read_slug_article", ["slug" => twig_get_attribute($this->env, $this->source, $context["relatedArticle"], "slug", [], "any", false, false, false, 19)]), "html", null, true);
                echo "\"> ";
                if (twig_get_attribute($this->env, $this->source, $context["relatedArticle"], "stared", [], "any", false, false, false, 19)) {
                    echo "<span class=\"uv-icon-star uv-pre\"></span>";
                }
                echo " ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["relatedArticle"], "name", [], "any", false, false, false, 19), "html", null, true);
                echo "</a></li>
                    ";
                // line 21
                echo "                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['relatedArticle'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 22
            echo "            </ul>
        </aside>
    ";
        }
        // line 25
        echo "

    ";
        // line 27
        if (((isset($context["articleTags"]) || array_key_exists("articleTags", $context)) && (isset($context["articleTags"]) || array_key_exists("articleTags", $context) ? $context["articleTags"] : (function () { throw new RuntimeError('Variable "articleTags" does not exist.', 27, $this->source); })()))) {
            // line 28
            echo "        <aside class=\"uv-margin-top-30\">
            <h3>";
            // line 29
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Tags"), "html", null, true);
            echo "</h3>
            <div class=\"uv-tags\">
                ";
            // line 31
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["articleTags"]) || array_key_exists("articleTags", $context) ? $context["articleTags"] : (function () { throw new RuntimeError('Variable "articleTags" does not exist.', 31, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
                // line 32
                echo "                    <span><a href=\"";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_tag", ["tag" => twig_get_attribute($this->env, $this->source, $context["tag"], "id", [], "any", false, false, false, 32), "name" => twig_get_attribute($this->env, $this->source, $context["tag"], "name", [], "any", false, false, false, 32)]), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["tag"], "name", [], "any", false, false, false, 32), "html", null, true);
                echo "</a></span>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tag'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 34
            echo "            </div>
        </aside>
    ";
        }
        // line 37
        echo "</div>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Templates/sidepanel.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  155 => 37,  150 => 34,  139 => 32,  135 => 31,  130 => 29,  127 => 28,  125 => 27,  121 => 25,  116 => 22,  110 => 21,  99 => 19,  95 => 18,  90 => 16,  87 => 15,  85 => 14,  82 => 13,  77 => 10,  71 => 9,  60 => 7,  56 => 6,  51 => 4,  48 => 3,  46 => 2,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"uv-paper-aside\">
    {% if popArticles is defined and popArticles %}
        <aside>
            <h3>{{'Popular Articles'|trans}}</h3>
            <ul>
                {% for popArticle in popArticles %}
                    <li><a href=\"{{path('helpdesk_knowledgebase_read_slug_article', {'slug': popArticle.slug})}}\"> {% if popArticle.stared %}<span class=\"uv-icon-star uv-pre\"></span>{% endif %} {{ popArticle.name }}</a></li>
                    {#<li><a href=\"{{path('helpdesk_knowledgebase_read_article', {'article': popArticle.id})}}\"> {% if popArticle.stared %}<span class=\"uv-icon-star uv-pre\"></span>{% endif %} {{popArticle.name}}</a></li>#}
                {% endfor %}
            </ul>
        </aside>
    {% endif %}
    
    {% if relatedArticles is defined and relatedArticles %}
        <aside class=\"uv-margin-top-30\">
            <h3>{{'Related Articles'|trans}}</h3>
            <ul>
                {% for relatedArticle in relatedArticles %}
                    <li><a href=\"{{path('helpdesk_knowledgebase_read_slug_article', {'slug': relatedArticle.slug})}}\"> {% if relatedArticle.stared %}<span class=\"uv-icon-star uv-pre\"></span>{% endif %} {{ relatedArticle.name }}</a></li>
                    {#<li><a href=\"{{path('helpdesk_knowledgebase_read_article', {'article': relatedArticle.articleId})}}\"> {% if relatedArticle.stared %}<span class=\"uv-icon-star uv-pre\"></span>{% endif %} {{relatedArticle.name}}</a></li>#}
                {% endfor %}
            </ul>
        </aside>
    {% endif %}


    {% if articleTags is defined and articleTags %}
        <aside class=\"uv-margin-top-30\">
            <h3>{{'Tags'|trans}}</h3>
            <div class=\"uv-tags\">
                {% for tag in articleTags %}
                    <span><a href=\"{{path('helpdesk_knowledgebase_tag', {'tag': tag.id, 'name': tag.name})}}\">{{tag.name}}</a></span>
                {% endfor %}
            </div>
        </aside>
    {% endif %}
</div>", "@UVDeskSupportCenter/Templates/sidepanel.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Templates/sidepanel.html.twig");
    }
}
