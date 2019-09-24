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

/* @UVDeskSupportCenter/Themes/masonryView.html.twig */
class __TwigTemplate_6b225fd06f3b8d35172b219ad14670001ee328e0f69fab295b48ad1fd60c722d extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Themes/masonryView.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Themes/masonryView.html.twig"));

        // line 1
        echo "<div class=\"uv-kb-section\">
\t<div class=\"uv-kb-section-head\">
\t\t<h1 class=\"uv-text-center\">";
        // line 3
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Browse via Folders"), "html", null, true);
        echo "</h1>
\t\t<p class=\"uv-text-center uv-fixed-width\">";
        // line 4
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Looking for something that is queried generally? Choose a relevant folder from below to explore possible solutions"), "html", null, true);
        echo "</p>
\t</div>
\t<div class=\"uv-kb-section-layout uv-kb-layout-grid\">
    \t";
        // line 7
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["solutions"]) || array_key_exists("solutions", $context) ? $context["solutions"] : (function () { throw new RuntimeError('Variable "solutions" does not exist.', 7, $this->source); })()), "results", [], "any", false, false, false, 7));
        foreach ($context['_seq'] as $context["_key"] => $context["folder"]) {
            // line 8
            echo "\t\t\t<!--Folder-->
\t\t\t<div class=\"uv-kb-folder\">
\t\t\t\t<p class=\"uv-folder-heading\">";
            // line 10
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["folder"], "name", [], "any", false, false, false, 10), "html", null, true);
            echo "</p>
\t\t\t\t<p class=\"uv-folder-description\">";
            // line 11
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["folder"], "description", [], "any", false, false, false, 11), "html", null, true);
            echo "</p>
\t\t\t\t<p><a href=\"";
            // line 12
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_folder", ["solution" => twig_get_attribute($this->env, $this->source, $context["folder"], "id", [], "any", false, false, false, 12)]), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["folder"], "categoriesCount", [], "any", false, false, false, 12), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Categories"), "html", null, true);
            echo "</a></p>
\t\t\t\t<p><a href=\"";
            // line 13
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_folder_article_collection", ["solution" => twig_get_attribute($this->env, $this->source, $context["folder"], "id", [], "any", false, false, false, 13)]), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["folder"], "articleCount", [], "any", false, false, false, 13), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Articles"), "html", null, true);
            echo "</a></p>
\t\t\t</div>
\t\t\t<!--//Folder-->
    \t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['folder'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "\t</div>
</div>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Themes/masonryView.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  95 => 17,  81 => 13,  73 => 12,  69 => 11,  65 => 10,  61 => 8,  57 => 7,  51 => 4,  47 => 3,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"uv-kb-section\">
\t<div class=\"uv-kb-section-head\">
\t\t<h1 class=\"uv-text-center\">{{ \"Browse via Folders\"|trans}}</h1>
\t\t<p class=\"uv-text-center uv-fixed-width\">{{ \"Looking for something that is queried generally? Choose a relevant folder from below to explore possible solutions\"|trans}}</p>
\t</div>
\t<div class=\"uv-kb-section-layout uv-kb-layout-grid\">
    \t{% for folder in solutions.results %}
\t\t\t<!--Folder-->
\t\t\t<div class=\"uv-kb-folder\">
\t\t\t\t<p class=\"uv-folder-heading\">{{folder.name}}</p>
\t\t\t\t<p class=\"uv-folder-description\">{{folder.description}}</p>
\t\t\t\t<p><a href=\"{{ path('helpdesk_knowledgebase_folder', {'solution': folder.id}) }}\">{{folder.categoriesCount}} {{\"Categories\"|trans}}</a></p>
\t\t\t\t<p><a href=\"{{ path('helpdesk_knowledgebase_folder_article_collection', {'solution': folder.id}) }}\">{{folder.articleCount}} {{\"Articles\"|trans}}</a></p>
\t\t\t</div>
\t\t\t<!--//Folder-->
    \t{% endfor %}
\t</div>
</div>", "@UVDeskSupportCenter/Themes/masonryView.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Themes/masonryView.html.twig");
    }
}
