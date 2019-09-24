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

/* @UVDeskSupportCenter/Templates/breadcrumbs.html.twig */
class __TwigTemplate_3eafd1e7d6b156ac4b874763aca71d9c0cecc6e85efeffcae5c93246da8d5326 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Templates/breadcrumbs.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Templates/breadcrumbs.html.twig"));

        // line 1
        if ((isset($context["breadcrumbs"]) || array_key_exists("breadcrumbs", $context))) {
            // line 2
            echo "    <form method=\"get\" action=\"";
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_knowledgebase_search");
            echo "\">
        <div class=\"uv-nav-bar\">
            <div class=\"uv-container\">
                <div class=\"uv-nav-bar-lt\">
                    <ul>
                        ";
            // line 7
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["breadcrumbs"]) || array_key_exists("breadcrumbs", $context) ? $context["breadcrumbs"] : (function () { throw new RuntimeError('Variable "breadcrumbs" does not exist.', 7, $this->source); })()));
            foreach ($context['_seq'] as $context["key"] => $context["breadcrumb"]) {
                // line 8
                echo "                            ";
                if (($context["key"] == (twig_length_filter($this->env, (isset($context["breadcrumbs"]) || array_key_exists("breadcrumbs", $context) ? $context["breadcrumbs"] : (function () { throw new RuntimeError('Variable "breadcrumbs" does not exist.', 8, $this->source); })())) - 1))) {
                    // line 9
                    echo "                                ";
                    if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 9, $this->source); })()), "request", [], "any", false, false, false, 9), "headers", [], "any", false, false, false, 9), "get", [0 => "referer"], "method", false, false, false, 9) && twig_in_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 9, $this->source); })()), "request", [], "any", false, false, false, 9), "headers", [], "any", false, false, false, 9), "get", [0 => "host"], "method", false, false, false, 9), twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 9, $this->source); })()), "request", [], "any", false, false, false, 9), "headers", [], "any", false, false, false, 9), "get", [0 => "referer"], "method", false, false, false, 9)))) {
                        // line 10
                        echo "                                    <li><a href=\"";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 10, $this->source); })()), "request", [], "any", false, false, false, 10), "headers", [], "any", false, false, false, 10), "get", [0 => "referer"], "method", false, false, false, 10), "html", null, true);
                        echo "\">";
                        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Prev"), "html", null, true);
                        echo "</a></li>
                                ";
                    }
                    // line 12
                    echo "                            ";
                }
                // line 13
                echo "                            <li><a href=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "url", [], "any", false, false, false, 13), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "label", [], "any", false, false, false, 13), "html", null, true);
                echo "</a></li>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['breadcrumb'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 15
            echo "                    </ul>  
                </div>
                <div class=\"uv-nav-bar-rt\">
                    <input class=\"uv-nav-search\" name=\"s\" type=\"text\" placeholder=\"";
            // line 18
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Search KnowledgeBase"), "html", null, true);
            echo "\" value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 18, $this->source); })()), "request", [], "any", false, false, false, 18), "query", [], "any", false, false, false, 18), "get", [0 => "s"], "method", false, false, false, 18), "html", null, true);
            echo "\"> 
                </div>
            </div>
        </div>
    </form>
";
        }
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Templates/breadcrumbs.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 18,  86 => 15,  75 => 13,  72 => 12,  64 => 10,  61 => 9,  58 => 8,  54 => 7,  45 => 2,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% if breadcrumbs is defined %}
    <form method=\"get\" action=\"{{ path('helpdesk_knowledgebase_search') }}\">
        <div class=\"uv-nav-bar\">
            <div class=\"uv-container\">
                <div class=\"uv-nav-bar-lt\">
                    <ul>
                        {% for key, breadcrumb in breadcrumbs %}
                            {% if key == (breadcrumbs|length - 1) %}
                                {% if app.request.headers.get('referer') and app.request.headers.get('host') in app.request.headers.get('referer') %}
                                    <li><a href=\"{{ app.request.headers.get('referer') }}\">{{ \"Prev\"|trans }}</a></li>
                                {% endif %}
                            {% endif %}
                            <li><a href=\"{{ breadcrumb.url }}\">{{ breadcrumb.label }}</a></li>
                        {% endfor %}
                    </ul>  
                </div>
                <div class=\"uv-nav-bar-rt\">
                    <input class=\"uv-nav-search\" name=\"s\" type=\"text\" placeholder=\"{{ \"Search KnowledgeBase\"|trans }}\" value=\"{{ app.request.query.get('s') }}\"> 
                </div>
            </div>
        </div>
    </form>
{% endif %}", "@UVDeskSupportCenter/Templates/breadcrumbs.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Templates/breadcrumbs.html.twig");
    }
}
