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

/* @Twig/Exception/logs.html.twig */
class __TwigTemplate_2816e6824c4945f8308783d509128990985c8dc0250010890f1e5098c8faa327 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Twig/Exception/logs.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Twig/Exception/logs.html.twig"));

        // line 1
        $context["channel_is_defined"] = twig_get_attribute($this->env, $this->source, twig_first($this->env, (isset($context["logs"]) || array_key_exists("logs", $context) ? $context["logs"] : (function () { throw new RuntimeError('Variable "logs" does not exist.', 1, $this->source); })())), "channel", [], "any", true, true, false, 1);
        // line 2
        echo "<table class=\"logs\" data-filter-level=\"Emergency,Alert,Critical,Error,Warning,Notice,Info,Debug\" data-filters>
    <thead>
        <tr>
            <th data-filter=\"level\">Level</th>
            ";
        // line 6
        if ((isset($context["channel_is_defined"]) || array_key_exists("channel_is_defined", $context) ? $context["channel_is_defined"] : (function () { throw new RuntimeError('Variable "channel_is_defined" does not exist.', 6, $this->source); })())) {
            echo "<th data-filter=\"channel\">Channel</th>";
        }
        // line 7
        echo "            <th class=\"full-width\">Message</th>
        </tr>
    </thead>

    <tbody>
    ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["logs"]) || array_key_exists("logs", $context) ? $context["logs"] : (function () { throw new RuntimeError('Variable "logs" does not exist.', 12, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["log"]) {
            // line 13
            echo "        ";
            if ((twig_get_attribute($this->env, $this->source, $context["log"], "priority", [], "any", false, false, false, 13) >= 400)) {
                // line 14
                echo "            ";
                $context["status"] = "error";
                // line 15
                echo "        ";
            } elseif ((twig_get_attribute($this->env, $this->source, $context["log"], "priority", [], "any", false, false, false, 15) >= 300)) {
                // line 16
                echo "            ";
                $context["status"] = "warning";
                // line 17
                echo "        ";
            } else {
                // line 18
                echo "            ";
                $context["severity"] = ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["log"], "context", [], "any", false, true, false, 18), "exception", [], "any", false, true, false, 18), "severity", [], "any", true, true, false, 18)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["log"], "context", [], "any", false, true, false, 18), "exception", [], "any", false, true, false, 18), "severity", [], "any", false, false, false, 18), false)) : (false));
                // line 19
                echo "            ";
                $context["status"] = (((((isset($context["severity"]) || array_key_exists("severity", $context) ? $context["severity"] : (function () { throw new RuntimeError('Variable "severity" does not exist.', 19, $this->source); })()) === constant("E_DEPRECATED")) || ((isset($context["severity"]) || array_key_exists("severity", $context) ? $context["severity"] : (function () { throw new RuntimeError('Variable "severity" does not exist.', 19, $this->source); })()) === constant("E_USER_DEPRECATED")))) ? ("warning") : ("normal"));
                // line 20
                echo "        ";
            }
            // line 21
            echo "        <tr class=\"status-";
            echo twig_escape_filter($this->env, (isset($context["status"]) || array_key_exists("status", $context) ? $context["status"] : (function () { throw new RuntimeError('Variable "status" does not exist.', 21, $this->source); })()), "html", null, true);
            echo "\" data-filter-level=\"";
            echo twig_escape_filter($this->env, twig_lower_filter($this->env, twig_get_attribute($this->env, $this->source, $context["log"], "priorityName", [], "any", false, false, false, 21)), "html", null, true);
            echo "\"";
            if ((isset($context["channel_is_defined"]) || array_key_exists("channel_is_defined", $context) ? $context["channel_is_defined"] : (function () { throw new RuntimeError('Variable "channel_is_defined" does not exist.', 21, $this->source); })())) {
                echo " data-filter-channel=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["log"], "channel", [], "any", false, false, false, 21), "html", null, true);
                echo "\"";
            }
            echo ">
            <td class=\"text-small\" nowrap>
                <span class=\"colored text-bold\">";
            // line 23
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["log"], "priorityName", [], "any", false, false, false, 23), "html", null, true);
            echo "</span>
                <span class=\"text-muted newline\">";
            // line 24
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["log"], "timestamp", [], "any", false, false, false, 24), "H:i:s"), "html", null, true);
            echo "</span>
            </td>
            ";
            // line 26
            if ((isset($context["channel_is_defined"]) || array_key_exists("channel_is_defined", $context) ? $context["channel_is_defined"] : (function () { throw new RuntimeError('Variable "channel_is_defined" does not exist.', 26, $this->source); })())) {
                // line 27
                echo "                <td class=\"text-small text-bold nowrap\">
                    ";
                // line 28
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["log"], "channel", [], "any", false, false, false, 28), "html", null, true);
                echo "
                </td>
            ";
            }
            // line 31
            echo "            <td>
                ";
            // line 32
            echo $this->extensions['Symfony\Bridge\Twig\Extension\CodeExtension']->formatLogMessage(twig_get_attribute($this->env, $this->source, $context["log"], "message", [], "any", false, false, false, 32), twig_get_attribute($this->env, $this->source, $context["log"], "context", [], "any", false, false, false, 32));
            echo "
                ";
            // line 33
            if ((((twig_get_attribute($this->env, $this->source, $context["log"], "context", [], "any", true, true, false, 33) &&  !(null === twig_get_attribute($this->env, $this->source, $context["log"], "context", [], "any", false, false, false, 33)))) ? (twig_get_attribute($this->env, $this->source, $context["log"], "context", [], "any", false, false, false, 33)) : (false))) {
                // line 34
                echo "                    <pre class=\"text-muted prewrap m-t-5\">";
                echo twig_escape_filter($this->env, json_encode(twig_get_attribute($this->env, $this->source, $context["log"], "context", [], "any", false, false, false, 34), ((twig_constant("JSON_PRETTY_PRINT") | twig_constant("JSON_UNESCAPED_UNICODE")) | twig_constant("JSON_UNESCAPED_SLASHES"))), "html", null, true);
                echo "</pre>
                ";
            }
            // line 36
            echo "            </td>
        </tr>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['log'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 39
        echo "    </tbody>
</table>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/logs.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  147 => 39,  139 => 36,  133 => 34,  131 => 33,  127 => 32,  124 => 31,  118 => 28,  115 => 27,  113 => 26,  108 => 24,  104 => 23,  90 => 21,  87 => 20,  84 => 19,  81 => 18,  78 => 17,  75 => 16,  72 => 15,  69 => 14,  66 => 13,  62 => 12,  55 => 7,  51 => 6,  45 => 2,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% set channel_is_defined = (logs|first).channel is defined %}
<table class=\"logs\" data-filter-level=\"Emergency,Alert,Critical,Error,Warning,Notice,Info,Debug\" data-filters>
    <thead>
        <tr>
            <th data-filter=\"level\">Level</th>
            {% if channel_is_defined %}<th data-filter=\"channel\">Channel</th>{% endif %}
            <th class=\"full-width\">Message</th>
        </tr>
    </thead>

    <tbody>
    {% for log in logs %}
        {% if log.priority >= 400 %}
            {% set status = 'error' %}
        {% elseif log.priority >= 300 %}
            {% set status = 'warning' %}
        {% else %}
            {% set severity = log.context.exception.severity|default(false) %}
            {% set status = severity is constant('E_DEPRECATED') or severity is constant('E_USER_DEPRECATED') ? 'warning' : 'normal' %}
        {% endif %}
        <tr class=\"status-{{ status }}\" data-filter-level=\"{{ log.priorityName|lower }}\"{% if channel_is_defined %} data-filter-channel=\"{{ log.channel }}\"{% endif %}>
            <td class=\"text-small\" nowrap>
                <span class=\"colored text-bold\">{{ log.priorityName }}</span>
                <span class=\"text-muted newline\">{{ log.timestamp|date('H:i:s') }}</span>
            </td>
            {% if channel_is_defined %}
                <td class=\"text-small text-bold nowrap\">
                    {{ log.channel }}
                </td>
            {% endif %}
            <td>
                {{ log.message|format_log_message(log.context) }}
                {% if log.context ?? false %}
                    <pre class=\"text-muted prewrap m-t-5\">{{ log.context|json_encode(constant('JSON_PRETTY_PRINT') b-or constant('JSON_UNESCAPED_UNICODE') b-or constant('JSON_UNESCAPED_SLASHES')) }}</pre>
                {% endif %}
            </td>
        </tr>
    {% endfor %}
    </tbody>
</table>
", "@Twig/Exception/logs.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/symfony/twig-bundle/Resources/views/Exception/logs.html.twig");
    }
}
