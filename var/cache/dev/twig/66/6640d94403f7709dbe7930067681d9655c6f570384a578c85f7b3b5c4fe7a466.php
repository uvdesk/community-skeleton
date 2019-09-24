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

/* @WebProfiler/Collector/time.css.twig */
class __TwigTemplate_b77a2237cd048eee25938825ad30c5dc795609ff5cb0398cf4aa95dd99889a57 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/time.css.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/time.css.twig"));

        // line 1
        echo "/* Variables */

.sf-profiler-timeline {
    --color-default: #777;
    --color-section: #999;
    --color-event-listener: #00B8F5;
    --color-template: #66CC00;
    --color-doctrine: #FF6633;
    --color-messenger-middleware: #BDB81E;
    --color-controller-argument-value-resolver: #8c5de6;
}

/* Legend */

.sf-profiler-timeline .legends .timeline-category {
    border: none;
    background: none;
    border-left: 1em solid transparent;
    line-height: 1em;
    margin: 0 1em 0 0;
    padding: 0 0.5em;
    display: none;
    opacity: 0.5;
}

.sf-profiler-timeline .legends .timeline-category.active {
    opacity: 1;
}

.sf-profiler-timeline .legends .timeline-category.present {
    display: inline-block;
}

.sf-profiler-timeline .legends .";
        // line 34
        echo twig_get_attribute($this->env, $this->source, (isset($context["classnames"]) || array_key_exists("classnames", $context) ? $context["classnames"] : (function () { throw new RuntimeError('Variable "classnames" does not exist.', 34, $this->source); })()), "default", [], "any", false, false, false, 34);
        echo " { border-color: var(--color-default); }
.sf-profiler-timeline .legends .";
        // line 35
        echo twig_get_attribute($this->env, $this->source, (isset($context["classnames"]) || array_key_exists("classnames", $context) ? $context["classnames"] : (function () { throw new RuntimeError('Variable "classnames" does not exist.', 35, $this->source); })()), "section", [], "any", false, false, false, 35);
        echo " { border-color: var(--color-section); }
.sf-profiler-timeline .legends .";
        // line 36
        echo twig_get_attribute($this->env, $this->source, (isset($context["classnames"]) || array_key_exists("classnames", $context) ? $context["classnames"] : (function () { throw new RuntimeError('Variable "classnames" does not exist.', 36, $this->source); })()), "event_listener", [], "any", false, false, false, 36);
        echo " { border-color: var(--color-event-listener); }
.sf-profiler-timeline .legends .";
        // line 37
        echo twig_get_attribute($this->env, $this->source, (isset($context["classnames"]) || array_key_exists("classnames", $context) ? $context["classnames"] : (function () { throw new RuntimeError('Variable "classnames" does not exist.', 37, $this->source); })()), "template", [], "any", false, false, false, 37);
        echo " { border-color: var(--color-template); }
.sf-profiler-timeline .legends .";
        // line 38
        echo twig_get_attribute($this->env, $this->source, (isset($context["classnames"]) || array_key_exists("classnames", $context) ? $context["classnames"] : (function () { throw new RuntimeError('Variable "classnames" does not exist.', 38, $this->source); })()), "doctrine", [], "any", false, false, false, 38);
        echo " { border-color: var(--color-doctrine); }
.sf-profiler-timeline .legends .";
        // line 39
        echo twig_get_attribute($this->env, $this->source, (isset($context["classnames"]) || array_key_exists("classnames", $context) ? $context["classnames"] : (function () { throw new RuntimeError('Variable "classnames" does not exist.', 39, $this->source); })()), "messenger.middleware", [], "array", false, false, false, 39);
        echo " { border-color: var(--color-messenger-middleware); }
.sf-profiler-timeline .legends .";
        // line 40
        echo twig_get_attribute($this->env, $this->source, (isset($context["classnames"]) || array_key_exists("classnames", $context) ? $context["classnames"] : (function () { throw new RuntimeError('Variable "classnames" does not exist.', 40, $this->source); })()), "controller.argument_value_resolver", [], "array", false, false, false, 40);
        echo " { border-color: var(--color-controller-argument-value-resolver); }

.timeline-graph {
    margin: 1em 0;
    width: 100%;
    background-color: var(--table-background);
    border: 1px solid var(--table-border);
}

/* Typography */

.timeline-graph .timeline-label {
    font-family: var(--font-sans-serif);
    font-size: 12px;
    line-height: 12px;
    font-weight: normal;
    fill: var(--color-text);
}

.timeline-graph .timeline-label .timeline-sublabel {
    margin-left: 1em;
    fill: var(--color-muted);
}

.timeline-graph .timeline-subrequest,
.timeline-graph .timeline-border {
    fill: none;
    stroke: var(--table-border);
    stroke-width: 1px;
}

.timeline-graph .timeline-subrequest {
    fill: url(#subrequest);
    fill-opacity: 0.5;
}

.timeline-subrequest-pattern {
    fill: var(--table-border);
}

/* Timeline periods */

.timeline-graph .timeline-period {
    stroke-width: 0;
}
.timeline-graph .";
        // line 85
        echo twig_get_attribute($this->env, $this->source, (isset($context["classnames"]) || array_key_exists("classnames", $context) ? $context["classnames"] : (function () { throw new RuntimeError('Variable "classnames" does not exist.', 85, $this->source); })()), "default", [], "any", false, false, false, 85);
        echo " .timeline-period {
    fill: var(--color-default);
}
.timeline-graph .";
        // line 88
        echo twig_get_attribute($this->env, $this->source, (isset($context["classnames"]) || array_key_exists("classnames", $context) ? $context["classnames"] : (function () { throw new RuntimeError('Variable "classnames" does not exist.', 88, $this->source); })()), "section", [], "any", false, false, false, 88);
        echo " .timeline-period {
    fill: var(--color-section);
}
.timeline-graph .";
        // line 91
        echo twig_get_attribute($this->env, $this->source, (isset($context["classnames"]) || array_key_exists("classnames", $context) ? $context["classnames"] : (function () { throw new RuntimeError('Variable "classnames" does not exist.', 91, $this->source); })()), "event_listener", [], "any", false, false, false, 91);
        echo " .timeline-period {
    fill: var(--color-event-listener);
}
.timeline-graph .";
        // line 94
        echo twig_get_attribute($this->env, $this->source, (isset($context["classnames"]) || array_key_exists("classnames", $context) ? $context["classnames"] : (function () { throw new RuntimeError('Variable "classnames" does not exist.', 94, $this->source); })()), "template", [], "any", false, false, false, 94);
        echo " .timeline-period {
    fill: var(--color-template);
}
.timeline-graph .";
        // line 97
        echo twig_get_attribute($this->env, $this->source, (isset($context["classnames"]) || array_key_exists("classnames", $context) ? $context["classnames"] : (function () { throw new RuntimeError('Variable "classnames" does not exist.', 97, $this->source); })()), "doctrine", [], "any", false, false, false, 97);
        echo " .timeline-period {
    fill: var(--color-doctrine);
}
.timeline-graph .";
        // line 100
        echo twig_get_attribute($this->env, $this->source, (isset($context["classnames"]) || array_key_exists("classnames", $context) ? $context["classnames"] : (function () { throw new RuntimeError('Variable "classnames" does not exist.', 100, $this->source); })()), "messenger.middleware", [], "array", false, false, false, 100);
        echo " .timeline-period {
    fill: var(--color-messenger-middleware);
}
.timeline-graph .";
        // line 103
        echo twig_get_attribute($this->env, $this->source, (isset($context["classnames"]) || array_key_exists("classnames", $context) ? $context["classnames"] : (function () { throw new RuntimeError('Variable "classnames" does not exist.', 103, $this->source); })()), "controller.argument_value_resolver", [], "array", false, false, false, 103);
        echo " .timeline-period {
    fill: var(--color-controller-argument-value-resolver);
}
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/time.css.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  186 => 103,  180 => 100,  174 => 97,  168 => 94,  162 => 91,  156 => 88,  150 => 85,  102 => 40,  98 => 39,  94 => 38,  90 => 37,  86 => 36,  82 => 35,  78 => 34,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("/* Variables */

.sf-profiler-timeline {
    --color-default: #777;
    --color-section: #999;
    --color-event-listener: #00B8F5;
    --color-template: #66CC00;
    --color-doctrine: #FF6633;
    --color-messenger-middleware: #BDB81E;
    --color-controller-argument-value-resolver: #8c5de6;
}

/* Legend */

.sf-profiler-timeline .legends .timeline-category {
    border: none;
    background: none;
    border-left: 1em solid transparent;
    line-height: 1em;
    margin: 0 1em 0 0;
    padding: 0 0.5em;
    display: none;
    opacity: 0.5;
}

.sf-profiler-timeline .legends .timeline-category.active {
    opacity: 1;
}

.sf-profiler-timeline .legends .timeline-category.present {
    display: inline-block;
}

.sf-profiler-timeline .legends .{{ classnames.default|raw }} { border-color: var(--color-default); }
.sf-profiler-timeline .legends .{{ classnames.section|raw }} { border-color: var(--color-section); }
.sf-profiler-timeline .legends .{{ classnames.event_listener|raw }} { border-color: var(--color-event-listener); }
.sf-profiler-timeline .legends .{{ classnames.template|raw }} { border-color: var(--color-template); }
.sf-profiler-timeline .legends .{{ classnames.doctrine|raw }} { border-color: var(--color-doctrine); }
.sf-profiler-timeline .legends .{{ classnames['messenger.middleware']|raw }} { border-color: var(--color-messenger-middleware); }
.sf-profiler-timeline .legends .{{ classnames['controller.argument_value_resolver']|raw }} { border-color: var(--color-controller-argument-value-resolver); }

.timeline-graph {
    margin: 1em 0;
    width: 100%;
    background-color: var(--table-background);
    border: 1px solid var(--table-border);
}

/* Typography */

.timeline-graph .timeline-label {
    font-family: var(--font-sans-serif);
    font-size: 12px;
    line-height: 12px;
    font-weight: normal;
    fill: var(--color-text);
}

.timeline-graph .timeline-label .timeline-sublabel {
    margin-left: 1em;
    fill: var(--color-muted);
}

.timeline-graph .timeline-subrequest,
.timeline-graph .timeline-border {
    fill: none;
    stroke: var(--table-border);
    stroke-width: 1px;
}

.timeline-graph .timeline-subrequest {
    fill: url(#subrequest);
    fill-opacity: 0.5;
}

.timeline-subrequest-pattern {
    fill: var(--table-border);
}

/* Timeline periods */

.timeline-graph .timeline-period {
    stroke-width: 0;
}
.timeline-graph .{{ classnames.default|raw }} .timeline-period {
    fill: var(--color-default);
}
.timeline-graph .{{ classnames.section|raw }} .timeline-period {
    fill: var(--color-section);
}
.timeline-graph .{{ classnames.event_listener|raw }} .timeline-period {
    fill: var(--color-event-listener);
}
.timeline-graph .{{ classnames.template|raw }} .timeline-period {
    fill: var(--color-template);
}
.timeline-graph .{{ classnames.doctrine|raw }} .timeline-period {
    fill: var(--color-doctrine);
}
.timeline-graph .{{ classnames['messenger.middleware']|raw }} .timeline-period {
    fill: var(--color-messenger-middleware);
}
.timeline-graph .{{ classnames['controller.argument_value_resolver']|raw }} .timeline-period {
    fill: var(--color-controller-argument-value-resolver);
}
", "@WebProfiler/Collector/time.css.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/symfony/web-profiler-bundle/Resources/views/Collector/time.css.twig");
    }
}
