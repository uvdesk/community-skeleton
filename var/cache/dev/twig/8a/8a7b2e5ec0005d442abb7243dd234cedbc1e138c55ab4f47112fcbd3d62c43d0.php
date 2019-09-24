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

/* @UVDeskSupportCenter/Templates/solutionLeftSidebar.html.twig */
class __TwigTemplate_f7d71a52b80844c0cbc161720d123281ae0eae31a0dabd378ce1995c175d63bf extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Templates/solutionLeftSidebar.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Templates/solutionLeftSidebar.html.twig"));

        // line 2
        echo "<div class=\"uv-aside\" ";
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 2, $this->source); })()), "request", [], "any", false, false, false, 2), "cookies", [], "any", false, false, false, 2) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 2, $this->source); })()), "request", [], "any", false, false, false, 2), "cookies", [], "any", false, false, false, 2), "get", [0 => "uv-asideView"], "method", false, false, false, 2))) {
            echo "style=\"display: none;\"";
        }
        echo ">
    ";
        // line 3
        $context["sidebarLinks"] = twig_get_attribute($this->env, $this->source, (isset($context["default_service"]) || array_key_exists("default_service", $context) ? $context["default_service"] : (function () { throw new RuntimeError('Variable "default_service" does not exist.', 3, $this->source); })()), "getLeftSidebarRoutes", [], "method", false, false, false, 3);
        // line 4
        echo "    ";
        if ((isset($context["sidebarLinks"]) || array_key_exists("sidebarLinks", $context) ? $context["sidebarLinks"] : (function () { throw new RuntimeError('Variable "sidebarLinks" does not exist.', 4, $this->source); })())) {
            // line 5
            echo "        <div class=\"uv-aside-head\">
            <div class=\"uv-aside-title\">
                <h6>";
            // line 7
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sidebarLinks"]) || array_key_exists("sidebarLinks", $context) ? $context["sidebarLinks"] : (function () { throw new RuntimeError('Variable "sidebarLinks" does not exist.', 7, $this->source); })()), "title", [], "any", false, false, false, 7), "html", null, true);
            echo "</h6>
            </div>
            <div class=\"uv-aside-back\">
                <span onclick=\"history.length > 1 ? history.go(-1) : window.location = '";
            // line 10
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("dashboard_action");
            echo "';\"> ";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Back"), "html", null, true);
            echo "</span>
            </div>
        </div>

        <div class=\"uv-aside-nav\">
            <ul>
                ";
            // line 16
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["sidebarLinks"]) || array_key_exists("sidebarLinks", $context) ? $context["sidebarLinks"] : (function () { throw new RuntimeError('Variable "sidebarLinks" does not exist.', 16, $this->source); })()), "items", [], "any", false, false, false, 16));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 17
                echo "                    <li>
                        <a class=\"";
                // line 18
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "class", [], "any", false, false, false, 18), "html", null, true);
                echo "\" ";
                ((twig_get_attribute($this->env, $this->source, $context["item"], "link", [], "any", false, false, false, 18)) ? (print (twig_escape_filter($this->env, ("href=" . twig_get_attribute($this->env, $this->source, $context["item"], "link", [], "any", false, false, false, 18)), "html", null, true))) : (print (false)));
                echo " ";
                if (twig_get_attribute($this->env, $this->source, $context["item"], "attr", [], "any", true, true, false, 18)) {
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "attr", [], "any", false, false, false, 18), "html", null, true);
                }
                echo ">";
                echo twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, false, 18);
                echo "</a>
                    </li>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 21
            echo "            </ul>
        </div>
    ";
        }
        // line 24
        echo "</div>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Templates/solutionLeftSidebar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 24,  100 => 21,  83 => 18,  80 => 17,  76 => 16,  65 => 10,  59 => 7,  55 => 5,  52 => 4,  50 => 3,  43 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("{# app/Resources/views/form/leftsiderbar.html.twig #}
<div class=\"uv-aside\" {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}style=\"display: none;\"{% endif %}>
    {% set sidebarLinks = default_service.getLeftSidebarRoutes() %}
    {% if sidebarLinks%}
        <div class=\"uv-aside-head\">
            <div class=\"uv-aside-title\">
                <h6>{{ sidebarLinks.title }}</h6>
            </div>
            <div class=\"uv-aside-back\">
                <span onclick=\"history.length > 1 ? history.go(-1) : window.location = '{{ path(\"dashboard_action\") }}';\"> {{ 'Back'|trans }}</span>
            </div>
        </div>

        <div class=\"uv-aside-nav\">
            <ul>
                {% for item in sidebarLinks.items %}
                    <li>
                        <a class=\"{{ item.class }}\" {{ item.link ? 'href='~item.link : false }} {% if item.attr is defined %}{{item.attr}}{% endif %}>{{ item.title|raw }}</a>
                    </li>
                {% endfor %}
            </ul>
        </div>
    {% endif %}
</div>", "@UVDeskSupportCenter/Templates/solutionLeftSidebar.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Templates/solutionLeftSidebar.html.twig");
    }
}
