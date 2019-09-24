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

/* @UVDeskSupportCenter/Knowledgebase/ticket.html.twig */
class __TwigTemplate_717dfc4efeaf898973f4c21587d5e4c3dadf3a63fc9275360ee943342781c10b extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'ogtitle' => [$this, 'block_ogtitle'],
            'twtitle' => [$this, 'block_twtitle'],
            'metaDescription' => [$this, 'block_metaDescription'],
            'metaKeywords' => [$this, 'block_metaKeywords'],
            'body' => [$this, 'block_body'],
            'footer' => [$this, 'block_footer'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "@UVDeskSupportCenter/Templates/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Knowledgebase/ticket.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Knowledgebase/ticket.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskSupportCenter/Templates/layout.html.twig", "@UVDeskSupportCenter/Knowledgebase/ticket.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 2
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Create Ticket", [], "messages");
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 3
    public function block_ogtitle($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "ogtitle"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "ogtitle"));

        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Create Ticket", [], "messages");
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 4
    public function block_twtitle($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "twtitle"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "twtitle"));

        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Create Ticket", [], "messages");
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 5
    public function block_metaDescription($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "metaDescription"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "metaDescription"));

        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("create.ticket.metaDescription", [], "messages");
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 6
    public function block_metaKeywords($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "metaKeywords"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "metaKeywords"));

        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("create.ticket.metaKeywords", [], "messages");
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 8
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 9
        echo "\t<style>
\t\t.uv-field{
\t\t\tpadding: 5px 10px;
\t\t}
\t\t.grammarly-fix-message-container {
\t\t\toverflow: visible !important;
\t\t}
\t\t.grammarly-fix-message {
\t\t\tmax-width: 158%;
\t\t}
\t\t.uv-field-success-icon {
\t\t\tdisplay: none !important;
\t\t}
\t</style>

\t";
        // line 24
        $context["isTicketViewPage"] = ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "user", [], "any", false, true, false, 24), "id", [], "any", true, true, false, 24)) ? (true) : (false));
        // line 25
        echo "\t<div class=\"uv-paper-article uv-paper-form\">
\t\t<div class=\"uv-paper-section\">
\t\t\t<section>
\t\t\t\t<h1>";
        // line 28
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Create Ticket Request"), "html", null, true);
        echo "</h1>

\t\t\t\t<div class=\"uv-form\">
\t\t\t\t\t<form action=\"";
        // line 31
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_create_ticket");
        echo "\" method=\"post\" id=\"create-ticket-form\" enctype=\"multipart/form-data\">
\t\t\t\t\t\t";
        // line 32
        if ( !(isset($context["isTicketViewPage"]) || array_key_exists("isTicketViewPage", $context) ? $context["isTicketViewPage"] : (function () { throw new RuntimeError('Variable "isTicketViewPage" does not exist.', 32, $this->source); })())) {
            // line 33
            echo "\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
            // line 35
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Name"), "html", null, true);
            echo "</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t\t<input name=\"name\" class=\"uv-field create-ticket\" type=\"text\" value=\"";
            // line 37
            ((twig_get_attribute($this->env, $this->source, ($context["post"] ?? null), "name", [], "any", true, true, false, 37)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["post"]) || array_key_exists("post", $context) ? $context["post"] : (function () { throw new RuntimeError('Variable "post" does not exist.', 37, $this->source); })()), "name", [], "any", false, false, false, 37), "html", null, true))) : (print ("")));
            echo "\">
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<span class=\"uv-field-info\">";
            // line 39
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Enter your name"), "html", null, true);
            echo "</span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
            // line 45
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email"), "html", null, true);
            echo "</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t\t<input name=\"from\" class=\"uv-field create-ticket\" type=\"text\" value=\"";
            // line 47
            ((twig_get_attribute($this->env, $this->source, ($context["post"] ?? null), "from", [], "any", true, true, false, 47)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["post"]) || array_key_exists("post", $context) ? $context["post"] : (function () { throw new RuntimeError('Variable "post" does not exist.', 47, $this->source); })()), "from", [], "any", false, false, false, 47), "html", null, true))) : (print ("")));
            echo "\">
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<span class=\"uv-field-info\">";
            // line 49
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Enter your email"), "html", null, true);
            echo "</span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->
\t\t\t\t\t\t";
        }
        // line 53
        echo "\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 55
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Type"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<select name=\"type\" class=\"uv-select create-ticket\" id=\"type\">
\t\t\t\t\t\t\t\t\t<option value=\"\">";
        // line 58
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Select type"), "html", null, true);
        echo "</option>

\t\t\t\t\t\t\t\t\t";
        // line 60
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 60, $this->source); })()), "getTypes", [], "method", false, false, false, 60));
        foreach ($context['_seq'] as $context["_key"] => $context["type"]) {
            // line 61
            echo "\t\t\t\t\t\t\t\t\t\t<option value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["type"], "id", [], "any", false, false, false, 61), "html", null, true);
            echo "\" ";
            echo (((twig_get_attribute($this->env, $this->source, ($context["post"] ?? null), "type", [], "any", true, true, false, 61) && (twig_get_attribute($this->env, $this->source, (isset($context["post"]) || array_key_exists("post", $context) ? $context["post"] : (function () { throw new RuntimeError('Variable "post" does not exist.', 61, $this->source); })()), "type", [], "any", false, false, false, 61) == twig_get_attribute($this->env, $this->source, $context["type"], "id", [], "any", false, false, false, 61)))) ? ("selected") : (""));
            echo ">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["type"], "name", [], "any", false, false, false, 61), "html", null, true);
            echo "</option>
\t\t\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['type'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 63
        echo "\t\t\t\t\t\t\t\t</select>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 65
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Choose ticket type"), "html", null, true);
        echo "</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 71
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Subject"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<input name=\"subject\" class=\"uv-field create-ticket\" type=\"text\" value=\"";
        // line 73
        ((twig_get_attribute($this->env, $this->source, ($context["post"] ?? null), "subject", [], "any", true, true, false, 73)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["post"]) || array_key_exists("post", $context) ? $context["post"] : (function () { throw new RuntimeError('Variable "post" does not exist.', 73, $this->source); })()), "subject", [], "any", false, false, false, 73), "html", null, true))) : (print ("")));
        echo "\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 75
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Ticket subject"), "html", null, true);
        echo "</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 81
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Message"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block grammarly-fix-message-container\">
\t\t\t\t\t\t\t\t<textarea name=\"reply\" class=\"uv-field create-ticket grammarly-fix-message\" type=\"text\">";
        // line 83
        ((twig_get_attribute($this->env, $this->source, ($context["post"] ?? null), "reply", [], "any", true, true, false, 83)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["post"]) || array_key_exists("post", $context) ? $context["post"] : (function () { throw new RuntimeError('Variable "post" does not exist.', 83, $this->source); })()), "reply", [], "any", false, false, false, 83), "html", null, true))) : (print ("")));
        echo "</textarea>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 85
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Ticket query message"), "html", null, true);
        echo "</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block attachment-block uv-no-error-success-icon\" id=\"uv-attachment-option\">
\t\t\t\t\t\t\t<label>
\t\t\t\t\t\t\t\t<span class=\"uv-file-label\">";
        // line 92
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Attachment"), "html", null, true);
        echo "</span>
\t\t\t\t\t\t\t</label>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<button type=\"submit\" id=\"create-ticket-btn\" class=\"uv-btn\">";
        // line 98
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Create Ticket"), "html", null, true);
        echo "</button>
\t\t\t\t\t\t</div>
\t\t\t\t\t</form>
\t\t\t\t</div>
\t\t\t</section>
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 107
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 108
        echo "\t";
        $context["isTicketViewPage"] = ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "user", [], "any", false, true, false, 108), "id", [], "any", true, true, false, 108)) ? (true) : (false));
        // line 109
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
\t";
        // line 110
        echo twig_include($this->env, $context, "@UVDeskCoreFramework/Templates/attachment.html.twig");
        echo "

\t<script src='https://www.google.com/recaptcha/api.js'></script>

\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\t";
        // line 116
        if ((isset($context["removeMe"]) || array_key_exists("removeMe", $context))) {
            // line 117
            echo "\t\t\t\t\$.each(";
            echo json_encode((isset($context["removeMe"]) || array_key_exists("removeMe", $context) ? $context["removeMe"] : (function () { throw new RuntimeError('Variable "removeMe" does not exist.', 117, $this->source); })()));
            echo ", function(key, value){
\t\t\t\t\t\$('label[for=\"' + value + '\"]').parent().hide();
\t\t\t\t});
\t\t\t";
        }
        // line 121
        echo "
\t\t\tvar CreateTicketModel = Backbone.Model.extend({
\t\t\t\tidAttribute : \"id\",
\t\t\t\tdefaults : {
\t\t\t\t\tpath : \"\",
\t\t\t\t},
\t\t\t\tvalidation: {
\t\t\t\t\t";
        // line 128
        if ( !(isset($context["isTicketViewPage"]) || array_key_exists("isTicketViewPage", $context) ? $context["isTicketViewPage"] : (function () { throw new RuntimeError('Variable "isTicketViewPage" does not exist.', 128, $this->source); })())) {
            // line 129
            echo "\t\t\t\t\t\t'name' : {
\t\t\t\t\t\t\trequired : true,
\t\t\t\t\t\t\tmsg : '";
            // line 131
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
            echo "'
\t\t\t\t\t\t},
\t\t\t\t\t\t'from' :
\t\t\t\t\t\t[{
\t\t\t\t\t\t\trequired : true,
\t\t\t\t\t\t\tmsg : '";
            // line 136
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
            echo "'
\t\t\t\t\t\t},{
\t\t\t\t\t\t\tpattern : 'email',
\t\t\t\t\t\t\tmsg : '";
            // line 139
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email address is invalid"), "html", null, true);
            echo "'
\t\t\t\t\t\t}],
\t\t\t\t\t";
        }
        // line 142
        echo "\t\t\t\t\t'type' : {
\t\t\t\t\t\trequired : true,
\t\t\t\t\t\tmsg : '";
        // line 144
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
\t\t\t\t\t},
\t\t\t\t\t'subject' : {
\t\t\t\t\t\trequired : true,
\t\t\t\t\t\tmsg : '";
        // line 148
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
\t\t\t\t\t},
\t\t\t\t\t'reply' : {
\t\t\t\t\t\trequired : true,
\t\t\t\t\t\tmsg : '";
        // line 152
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
\t\t\t\t\t},
\t\t\t\t},
\t\t\t\turlRoot : \"";
        // line 155
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_create_ticket");
        echo "\"
\t\t\t});

\t\t\tvar CreateTicketForm = Backbone.View.extend({
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t\tvar jsonContext = JSON.parse('";
        // line 161
        echo (((isset($context["errors"]) || array_key_exists("errors", $context))) ? ((isset($context["errors"]) || array_key_exists("errors", $context) ? $context["errors"] : (function () { throw new RuntimeError('Variable "errors" does not exist.', 161, $this->source); })())) : ("{}"));
        echo "');
\t\t\t\t\tfor (var field in jsonContext) {
\t\t\t\t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tevents : {
\t\t\t\t\t'click #create-ticket-btn' : \"saveTicket\",
\t\t\t\t\t'change #type' : \"updateCustomFields\",
\t\t\t\t\t'blur input:not(input[type=file]), textarea, select, checkbox': 'formChanegd',
\t\t\t\t\t'change input[type=file]': 'formChanegd',
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t\t\tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t\t\tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t\t},
\t\t\t\tsaveTicket : function (e) {
\t\t\t\t\te.preventDefault();
\t\t\t\t\tvar currentElement = Backbone.\$(e.currentTarget);
\t\t\t\t\tvar data = currentElement.closest('form').serializeObject();
\t\t\t\t\tthis.model.set(data);

\t\t\t\t\tif(this.model.isValid(true)) {
\t\t\t\t\t\t\$('#create-ticket-form').submit();
\t\t\t\t\t\t\$('form').find('#create-ticket-btn').attr('disabled', 'disabled');
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tupdateCustomFields : function (e) {
\t\t\t\t\tvar dependentFields = e.currentTarget.value;
\t\t\t\t\tthis.\$('.dependent').hide();
\t\t\t\t\tthis.\$('.dependency' + dependentFields).show();
\t\t\t\t}
\t\t\t});

\t\t\tvar createticketForm = new CreateTicketForm({
\t\t\t\tel : \$(\"#create-ticket-form\"),
\t\t\t\tmodel : new CreateTicketModel()
\t\t\t});
\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Knowledgebase/ticket.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  461 => 161,  452 => 155,  446 => 152,  439 => 148,  432 => 144,  428 => 142,  422 => 139,  416 => 136,  408 => 131,  404 => 129,  402 => 128,  393 => 121,  385 => 117,  383 => 116,  374 => 110,  369 => 109,  366 => 108,  356 => 107,  338 => 98,  329 => 92,  319 => 85,  314 => 83,  309 => 81,  300 => 75,  295 => 73,  290 => 71,  281 => 65,  277 => 63,  264 => 61,  260 => 60,  255 => 58,  249 => 55,  245 => 53,  238 => 49,  233 => 47,  228 => 45,  219 => 39,  214 => 37,  209 => 35,  205 => 33,  203 => 32,  199 => 31,  193 => 28,  188 => 25,  186 => 24,  169 => 9,  159 => 8,  140 => 6,  121 => 5,  102 => 4,  83 => 3,  64 => 2,  41 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskSupportCenter/Templates/layout.html.twig\" %}
{% block title %}{% trans %}Create Ticket{% endtrans %}{% endblock %}
{% block ogtitle %}{% trans %}Create Ticket{% endtrans %}{% endblock %}
{% block twtitle %}{% trans %}Create Ticket{% endtrans %}{% endblock %}
{% block metaDescription %}{% trans %}create.ticket.metaDescription{% endtrans %}{% endblock %}
{% block metaKeywords %}{% trans %}create.ticket.metaKeywords{% endtrans %}{% endblock %}

{% block body %}
\t<style>
\t\t.uv-field{
\t\t\tpadding: 5px 10px;
\t\t}
\t\t.grammarly-fix-message-container {
\t\t\toverflow: visible !important;
\t\t}
\t\t.grammarly-fix-message {
\t\t\tmax-width: 158%;
\t\t}
\t\t.uv-field-success-icon {
\t\t\tdisplay: none !important;
\t\t}
\t</style>

\t{% set isTicketViewPage = (app.user.id is defined ? true : false) %}
\t<div class=\"uv-paper-article uv-paper-form\">
\t\t<div class=\"uv-paper-section\">
\t\t\t<section>
\t\t\t\t<h1>{{ 'Create Ticket Request'|trans }}</h1>

\t\t\t\t<div class=\"uv-form\">
\t\t\t\t\t<form action=\"{{ path('helpdesk_customer_create_ticket') }}\" method=\"post\" id=\"create-ticket-form\" enctype=\"multipart/form-data\">
\t\t\t\t\t\t{% if not isTicketViewPage %}
\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Name'|trans }}</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t\t<input name=\"name\" class=\"uv-field create-ticket\" type=\"text\" value=\"{{ post.name is defined ? post.name : '' }}\">
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<span class=\"uv-field-info\">{{ 'Enter your name'|trans }}</span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Email'|trans }}</label>
\t\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t\t<input name=\"from\" class=\"uv-field create-ticket\" type=\"text\" value=\"{{ post.from is defined ? post.from : '' }}\">
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<span class=\"uv-field-info\">{{ 'Enter your email'|trans }}</span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<!-- //Field -->
\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Type'|trans }}</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<select name=\"type\" class=\"uv-select create-ticket\" id=\"type\">
\t\t\t\t\t\t\t\t\t<option value=\"\">{{ 'Select type'|trans }}</option>

\t\t\t\t\t\t\t\t\t{% for type in ticket_service.getTypes() %}
\t\t\t\t\t\t\t\t\t\t<option value=\"{{ type.id }}\" {{ post.type is defined and post.type == type.id ? 'selected' : '' }}>{{ type.name }}</option>
\t\t\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t\t\t</select>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<span class=\"uv-field-info\">{{ 'Choose ticket type'|trans }}</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Subject'|trans }}</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<input name=\"subject\" class=\"uv-field create-ticket\" type=\"text\" value=\"{{ post.subject is defined ? post.subject : '' }}\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<span class=\"uv-field-info\">{{ 'Ticket subject'|trans }}</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Message'|trans }}</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block grammarly-fix-message-container\">
\t\t\t\t\t\t\t\t<textarea name=\"reply\" class=\"uv-field create-ticket grammarly-fix-message\" type=\"text\">{{ post.reply is defined ? post.reply : '' }}</textarea>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<span class=\"uv-field-info\">{{ 'Ticket query message'|trans }}</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block attachment-block uv-no-error-success-icon\" id=\"uv-attachment-option\">
\t\t\t\t\t\t\t<label>
\t\t\t\t\t\t\t\t<span class=\"uv-file-label\">{{ 'Add Attachment'|trans }}</span>
\t\t\t\t\t\t\t</label>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<button type=\"submit\" id=\"create-ticket-btn\" class=\"uv-btn\">{{ 'Create Ticket'|trans }}</button>
\t\t\t\t\t\t</div>
\t\t\t\t\t</form>
\t\t\t\t</div>
\t\t\t</section>
\t\t</div>
\t</div>
{% endblock %}

{% block footer %}
\t{% set isTicketViewPage = (app.user.id is defined ? true : false) %}
\t{{ parent() }}
\t{{ include('@UVDeskCoreFramework/Templates/attachment.html.twig') }}

\t<script src='https://www.google.com/recaptcha/api.js'></script>

\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\t{% if(removeMe is defined) %}
\t\t\t\t\$.each({{ removeMe | json_encode |raw }}, function(key, value){
\t\t\t\t\t\$('label[for=\"' + value + '\"]').parent().hide();
\t\t\t\t});
\t\t\t{% endif %}

\t\t\tvar CreateTicketModel = Backbone.Model.extend({
\t\t\t\tidAttribute : \"id\",
\t\t\t\tdefaults : {
\t\t\t\t\tpath : \"\",
\t\t\t\t},
\t\t\t\tvalidation: {
\t\t\t\t\t{% if not isTicketViewPage %}
\t\t\t\t\t\t'name' : {
\t\t\t\t\t\t\trequired : true,
\t\t\t\t\t\t\tmsg : '{{ \"This field is mandatory\"|trans }}'
\t\t\t\t\t\t},
\t\t\t\t\t\t'from' :
\t\t\t\t\t\t[{
\t\t\t\t\t\t\trequired : true,
\t\t\t\t\t\t\tmsg : '{{ \"This field is mandatory\"|trans }}'
\t\t\t\t\t\t},{
\t\t\t\t\t\t\tpattern : 'email',
\t\t\t\t\t\t\tmsg : '{{ \"Email address is invalid\"|trans }}'
\t\t\t\t\t\t}],
\t\t\t\t\t{% endif %}
\t\t\t\t\t'type' : {
\t\t\t\t\t\trequired : true,
\t\t\t\t\t\tmsg : '{{ \"This field is mandatory\"|trans }}'
\t\t\t\t\t},
\t\t\t\t\t'subject' : {
\t\t\t\t\t\trequired : true,
\t\t\t\t\t\tmsg : '{{ \"This field is mandatory\"|trans }}'
\t\t\t\t\t},
\t\t\t\t\t'reply' : {
\t\t\t\t\t\trequired : true,
\t\t\t\t\t\tmsg : '{{ \"This field is mandatory\"|trans }}'
\t\t\t\t\t},
\t\t\t\t},
\t\t\t\turlRoot : \"{{ path('helpdesk_customer_create_ticket') }}\"
\t\t\t});

\t\t\tvar CreateTicketForm = Backbone.View.extend({
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t\tvar jsonContext = JSON.parse('{{ errors is defined ? errors|raw : \"{}\"  }}');
\t\t\t\t\tfor (var field in jsonContext) {
\t\t\t\t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tevents : {
\t\t\t\t\t'click #create-ticket-btn' : \"saveTicket\",
\t\t\t\t\t'change #type' : \"updateCustomFields\",
\t\t\t\t\t'blur input:not(input[type=file]), textarea, select, checkbox': 'formChanegd',
\t\t\t\t\t'change input[type=file]': 'formChanegd',
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t\t\tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t\t\tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t\t},
\t\t\t\tsaveTicket : function (e) {
\t\t\t\t\te.preventDefault();
\t\t\t\t\tvar currentElement = Backbone.\$(e.currentTarget);
\t\t\t\t\tvar data = currentElement.closest('form').serializeObject();
\t\t\t\t\tthis.model.set(data);

\t\t\t\t\tif(this.model.isValid(true)) {
\t\t\t\t\t\t\$('#create-ticket-form').submit();
\t\t\t\t\t\t\$('form').find('#create-ticket-btn').attr('disabled', 'disabled');
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tupdateCustomFields : function (e) {
\t\t\t\t\tvar dependentFields = e.currentTarget.value;
\t\t\t\t\tthis.\$('.dependent').hide();
\t\t\t\t\tthis.\$('.dependency' + dependentFields).show();
\t\t\t\t}
\t\t\t});

\t\t\tvar createticketForm = new CreateTicketForm({
\t\t\t\tel : \$(\"#create-ticket-form\"),
\t\t\t\tmodel : new CreateTicketModel()
\t\t\t});
\t\t});
\t</script>
{% endblock %}", "@UVDeskSupportCenter/Knowledgebase/ticket.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Knowledgebase/ticket.html.twig");
    }
}
