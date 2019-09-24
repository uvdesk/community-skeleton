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

/* @UVDeskSupportCenter/Knowledgebase/ticketView.html.twig */
class __TwigTemplate_62fc1b0b7070ea1213b688c71c8a961d678eb24bad53d53a97ef5639d524310c extends \Twig\Template
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
            'tabHeader' => [$this, 'block_tabHeader'],
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Knowledgebase/ticketView.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Knowledgebase/ticketView.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskSupportCenter/Templates/layout.html.twig", "@UVDeskSupportCenter/Knowledgebase/ticketView.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        echo "#";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 3, $this->source); })()), "id", [], "any", false, false, false, 3), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 3, $this->source); })()), "subject", [], "any", false, false, false, 3), "html", null, true);
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 4
    public function block_ogtitle($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "ogtitle"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "ogtitle"));

        echo "#";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 4, $this->source); })()), "id", [], "any", false, false, false, 4), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 4, $this->source); })()), "subject", [], "any", false, false, false, 4), "html", null, true);
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 5
    public function block_twtitle($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "twtitle"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "twtitle"));

        echo "#";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 5, $this->source); })()), "id", [], "any", false, false, false, 5), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 5, $this->source); })()), "subject", [], "any", false, false, false, 5), "html", null, true);
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 7
    public function block_tabHeader($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "tabHeader"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "tabHeader"));

        // line 8
        echo "\t<div class=\"uv-nav-bar uv-nav-tab\">
\t\t<div class=\"uv-container\">
\t\t\t<div class=\"uv-nav-bar-lt\">
\t\t\t\t<ul class=\"uv-nav-tab-label\">
\t\t\t\t\t<li><a href=\"";
        // line 12
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_ticket_collection");
        echo "\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Ticket Requests"), "html", null, true);
        echo "</a></li>
\t\t\t\t\t";
        // line 13
        if (twig_get_attribute($this->env, $this->source, (isset($context["websiteConfiguration"]) || array_key_exists("websiteConfiguration", $context) ? $context["websiteConfiguration"] : (function () { throw new RuntimeError('Variable "websiteConfiguration" does not exist.', 13, $this->source); })()), "ticketCreateOption", [], "any", false, false, false, 13)) {
            // line 14
            echo "                        <li><a href=\"";
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_create_ticket");
            echo "\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("New Ticket Request"), "html", null, true);
            echo "</a></li>
                    ";
        }
        // line 16
        echo "\t\t\t\t</ul>
\t\t\t</div>
\t\t\t<div class=\"uv-nav-bar-rt\">
\t\t\t\t<form method=\"get\" action=\"";
        // line 19
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_front_article_search");
        echo "\">
\t\t\t\t\t<input name=\"s\" class=\"uv-nav-search\" type=\"text\" placeholder=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Search"), "html", null, true);
        echo "\">
\t\t\t\t</form>
\t\t\t</div>
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 27
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 28
        echo "    <style>
        .uv-btn-tag {
            margin-right: 5px;
        }
        .uv-group-field {
            width: 80%;
        }
        .uv-element-block .mce-tinymce {
            margin-top: 10px;
        }
        .uv-ticket-view .uv-ticket-accordion .uv-ticket-wrapper {
            display: block;
        }
        .message {
            font-size: 15px;
        }
        .message img {
            max-width: 100%;
        }
        .uv-dropdown.reply .uv-dropdown-btn-active {
            border: none;
        }
        .uv-dropdown.reply .uv-dropdown-list {
            width: 220px;
            bottom: 47px;
        }

\t\t.uv-rtl .uv-top-left {
\t\t\tleft: unset;
\t\t}

\t\t.uv-rtl .uv-dropdown-list {
\t\t\ttext-align: right;
\t\t}

        .uv-action-buttons {
            margin: 10px 0px;
        }

        .uv-action-buttons .uv-btn:first-child {
            margin-left: 0px;
        }

\t\t.uv-rtl .uv-action-buttons .uv-btn:first-child {
\t\t\tmargin-left: 5px;
\t\t\tmargin-right: 0px;
\t\t}

        .uv-action-buttons .uv-btn {
            margin: 5px;
        }

        form #customFieldCollection .uv-field-error-icon, form #customFieldCollection .uv-field-success-icon {
            display: none;
        }

        .custom-field-field-display .uv-field-block {
            width: 100%;
            color: #333333;
            word-wrap: break-word;
        }

        .custom-field-field-display .uv-field-block span {
            display: inline;
        }
        .uv-submit-left-side {
            margin: 0!important;
            padding-right: 5px;
            border-bottom-right-radius: 0;
            border-top-right-radius: 0;
        }
\t\t.uv-rtl .uv-submit-left-side {
\t\t\tpadding-right: 10px;
            border-bottom-right-radius: 3px;
            border-top-right-radius: 3px;
\t\t\tpadding-left: 5px;
\t\t\tborder-bottom-left-radius: 0;
            border-top-left-radius: 0;
\t\t}
        .uv-submit-right-side {
            margin: 0!important;
        }
        .no-left-padding {
            padding-left: 0;
            border-bottom-left-radius: 0;
            border-top-left-radius: 0;
        }
\t\t.uv-rtl .no-left-padding {
\t\t\tpadding-left: 10px;
            border-bottom-left-radius: 3px;
            border-top-left-radius: 3px;
\t\t\tpadding-right: 0;
\t\t\tborder-bottom-right-radius: 0;
\t\t\tborder-top-right-radius: 0;
\t\t}
        .uv-btn-error {
            background-color: #FF5656!important;
        }
        .uv-pull-rightside {
            float: right;
            font-size: 15px;
            cursor: pointer;
        }
\t\t.uv-rtl .uv-pull-rightside {
            float: left;
        }
        .uv-print-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            background-image: url('../../../../../bundles/webkuldefault/images/uvdesk-kb-sprite.svg');
            background-position: -176px -91px;
            vertical-align: middle;
        }
        @media print {
            .uv-navbar,.uv-ticket-action-bar, .uv-kudo, .uv-aside-back, .uv-footer, .uv-ticket-main.uv-ticket-reply, .uv-nav-bar,input, .uv-dropdown-list>.uv-dropdown-container,.uv-notifications-wrapper,.uv-pop-up-overlay,.uv-loader-view, .uv-loader,.uv-header,.uv-upload-actions,.uv-pull-rightside {
                display: none !important;
            }
        }
    </style>

    ";
        // line 149
        $context["ticketAgent"] = ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 149, $this->source); })()), "agent", [], "any", false, false, false, 149)) ? (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 149, $this->source); })()), "getAgentDetailById", [0 => twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 149, $this->source); })()), "agent", [], "any", false, false, false, 149), "id", [], "any", false, false, false, 149)], "method", false, false, false, 149)) : (null));
        // line 150
        echo "    ";
        $context["totalThreads"] = twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 150, $this->source); })()), "getTicketTotalThreads", [0 => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 150, $this->source); })()), "id", [], "any", false, false, false, 150)], "method", false, false, false, 150);
        // line 151
        echo "    ";
        $context["customer"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 151, $this->source); })()), "getCustomerPartialDetailById", [0 => twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 151, $this->source); })()), "customer", [], "any", false, false, false, 151), "id", [], "any", false, false, false, 151)], "method", false, false, false, 151);
        // line 152
        echo "    ";
        $context["createThread"] = twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 152, $this->source); })()), "getCreateReply", [0 => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 152, $this->source); })()), "id", [], "any", false, false, false, 152), 1 => "customer"], "method", false, false, false, 152);
        // line 153
        echo "    ";
        $context["currentUser"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 153, $this->source); })()), "getCustomerPartialDetailById", [0 => twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 153, $this->source); })()), "user", [], "any", false, false, false, 153), "id", [], "any", false, false, false, 153)], "method", false, false, false, 153);
        // line 154
        echo "
    <div class=\"uv-thread\">
        <div class=\"uv-thread-lt\">
            <aside>
                <h6>";
        // line 158
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Ticket Information"), "html", null, true);
        echo "</h6>
                <div class=\"uv-aside-brick\">
                    <h6>";
        // line 160
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Total Replies"), "html", null, true);
        echo "</h6>
                    <span class=\"uv-icon-replies\"></span>
                    <span>";
        // line 162
        echo twig_escape_filter($this->env, (isset($context["totalThreads"]) || array_key_exists("totalThreads", $context) ? $context["totalThreads"] : (function () { throw new RuntimeError('Variable "totalThreads" does not exist.', 162, $this->source); })()), "html", null, true);
        echo "</span>
                </div>
                <div class=\"uv-aside-brick\">
                    <h6>";
        // line 165
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Timestamp"), "html", null, true);
        echo "</h6>
                    <span class=\"uv-icon-timestamp\"></span>
                    <span>";
        // line 167
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 167, $this->source); })()), "createdAt", [], "any", false, false, false, 167), "m-d-y h:i A"), "html", null, true);
        echo "</span>
                </div>

                <div class=\"uv-hr\"></div>
                ";
        // line 171
        if ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 171, $this->source); })()), "customer", [], "any", false, false, false, 171) != twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 171, $this->source); })()), "user", [], "any", false, false, false, 171))) {
            // line 172
            echo "                    <div class=\"uv-aside-brick\">
                        <h6>";
            // line 173
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Customer"), "html", null, true);
            echo "</h6>
                        <span>";
            // line 174
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 174, $this->source); })()), "name", [], "any", false, false, false, 174), "html", null, true);
            echo "</span>
                    </div>
                ";
        }
        // line 177
        echo "                ";
        if ((isset($context["ticketAgent"]) || array_key_exists("ticketAgent", $context) ? $context["ticketAgent"] : (function () { throw new RuntimeError('Variable "ticketAgent" does not exist.', 177, $this->source); })())) {
            // line 178
            echo "                    <div class=\"uv-aside-brick\">
                        <h6>";
            // line 179
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent"), "html", null, true);
            echo "</h6>
                        <span>";
            // line 180
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticketAgent"]) || array_key_exists("ticketAgent", $context) ? $context["ticketAgent"] : (function () { throw new RuntimeError('Variable "ticketAgent" does not exist.', 180, $this->source); })()), "name", [], "any", false, false, false, 180), "html", null, true);
            echo "</span>
                    </div>
                ";
        }
        // line 183
        echo "                <div class=\"uv-aside-brick\">
                    <h6>";
        // line 184
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
        echo "</h6>
                    <span>";
        // line 185
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 185, $this->source); })()), "status", [], "any", false, false, false, 185), "code", [], "any", false, false, false, 185)), "html", null, true);
        echo "</span>
                </div>
                ";
        // line 187
        if (twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 187, $this->source); })()), "type", [], "any", false, false, false, 187)) {
            // line 188
            echo "                    <div class=\"uv-aside-brick\">
                        <h6>";
            // line 189
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Type"), "html", null, true);
            echo "</h6>
                        <span>";
            // line 190
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 190, $this->source); })()), "type", [], "any", false, false, false, 190), "code", [], "any", false, false, false, 190), "html", null, true);
            echo "</span>
                    </div>
                ";
        }
        // line 193
        echo "
                ";
        // line 194
        if ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 194, $this->source); })()), "customer", [], "any", false, false, false, 194) == twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 194, $this->source); })()), "user", [], "any", false, false, false, 194))) {
            // line 195
            echo "                    <div class=\"uv-hr\"></div>
                    <div class=\"uv-aside-brick collaborator-list-block\">
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">";
            // line 198
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Collaborators"), "html", null, true);
            echo "</label>
                            <div class=\"uv-field-block\">
                                <input class=\"uv-field\" type=\"text\" name=\"email\" type=\"text\" value=\"\" placeholder=\"";
            // line 200
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Type email to add"), "html", null, true);
            echo "\">
                            </div>
                        </div>
                        <div class=\"collaborator-list\" style=\"margin-top: 10px\">
                        </div>
                    </div>
                ";
        }
        // line 207
        echo "            </aside>
            ";
        // line 208
        if ((isset($context["customFieldCollection"]) || array_key_exists("customFieldCollection", $context))) {
            // line 209
            echo "                <aside id=\"uv-customfield-view\" class=\"uv-customfield-view\" style=\"margin-top: 20px;\">
                    <div style=\"position: relative;\">
                        <h6>";
            // line 211
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Custom Field"), "html", null, true);
            echo "</h6>
                        <span class=\"uv-customize cfield-manage-pta\" style=\"width: 15px; height: 15px; position: absolute; background-image: url('../../../../../bundles/webkuldefault/images/uvdesk-sprite.svg'); background-position: -44px -46px; top: 4px; cursor: pointer;\" title=\"";
            // line 212
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Manage Ticket Custom Fields"), "html", null, true);
            echo "\" data-toggle=\"tooltip\" data-placement=\"bottom\"></span>
                    </div>
                    <p style=\"padding-right: 20px; color: #6F6F6F; font-style: italic;\">";
            // line 214
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Manage Custom Fields to provide additional details with the ticket."), "html", null, true);
            echo "</p>

                    <div class=\"uv-hr\"></div>
                    <form name=\"customFieldForm\" enctype=\"multipart/form-data\">
                        <div id=\"customFieldCollection\">
                        </div>
                    </form>
                </aside>
            ";
        }
        // line 223
        echo "        </div>
        <div class=\"uv-thread-rt\">
            <section>
                <div class=\"uv-ticket-view\">
                    <div class=\"uv-ticket-head\">
                        <h1>
                            ";
        // line 229
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 229, $this->source); })()), "subject", [], "any", false, false, false, 229), "html", null, true);
        echo "
                            <span class=\"uv-pull-rightside uv-print-icon\" onclick=\"window.print()\"></span>
                        </h1>
                        <div class=\"uv-ticket-strip\">
                            <span>
                                <span class=\"uv-ticket-strip-label\">";
        // line 234
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Created"), "html", null, true);
        echo " -</span>
                                <span class=\"timeago\" data-timestamp=\"";
        // line 235
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 235, $this->source); })()), "createdAt", [], "any", false, false, false, 235), "m-d-y h:i:s A"), "html", null, true);
        echo "\" title=\"";
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 235, $this->source); })()), "createdAt", [], "any", false, false, false, 235), "m-d-y h:i:s A"), "html", null, true);
        echo "\">
                                    ";
        // line 236
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 236, $this->source); })()), "createdAt", [], "any", false, false, false, 236), "m-d-y h:i A"), "html", null, true);
        echo "
                                </span>
                            </span>
                            <span>
                                <span class=\"uv-ticket-strip-label\">";
        // line 240
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("By"), "html", null, true);
        echo " -</span>
                                ";
        // line 241
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["createThread"]) || array_key_exists("createThread", $context) ? $context["createThread"] : (function () { throw new RuntimeError('Variable "createThread" does not exist.', 241, $this->source); })()), "user", [], "any", false, false, false, 241), "name", [], "any", false, false, false, 241), "html", null, true);
        echo "
                            </span>
                            ";
        // line 243
        if ((isset($context["ticketAgent"]) || array_key_exists("ticketAgent", $context) ? $context["ticketAgent"] : (function () { throw new RuntimeError('Variable "ticketAgent" does not exist.', 243, $this->source); })())) {
            // line 244
            echo "                                <span>
                                    <span class=\"uv-ticket-strip-label\">";
            // line 245
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent"), "html", null, true);
            echo " -</span>
                                    ";
            // line 246
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticketAgent"]) || array_key_exists("ticketAgent", $context) ? $context["ticketAgent"] : (function () { throw new RuntimeError('Variable "ticketAgent" does not exist.', 246, $this->source); })()), "name", [], "any", false, false, false, 246), "html", null, true);
            echo "
                                </span>
                            ";
        }
        // line 249
        echo "                        </div>
                    </div>

                    <div class=\"uv-tab-view\">
                        <div class=\"uv-ticket-section\">
                            <div class=\"uv-ticket-main create\">
                                <div class=\"uv-ticket-strip\">
                                    <span>
                                        <span class=\"timeago uv-margin-0\" data-timestamp=\"ticket.createdAt\" title=\"";
        // line 257
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 257, $this->source); })()), "createdAt", [], "any", false, false, false, 257), "m-d-y h:i:s A"), "html", null, true);
        echo "\">
                                            ";
        // line 258
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 258, $this->source); })()), "createdAt", [], "any", false, false, false, 258), "m-d-y h:i A"), "html", null, true);
        echo "
                                        </span>
                                        - ";
        // line 260
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["createThread"]) || array_key_exists("createThread", $context) ? $context["createThread"] : (function () { throw new RuntimeError('Variable "createThread" does not exist.', 260, $this->source); })()), "user", [], "any", false, false, false, 260), "name", [], "any", false, false, false, 260), "html", null, true);
        echo "
                                        <span class=\"uv-ticket-strip-label\">
                                        ";
        // line 262
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("created Ticket"), "html", null, true);
        echo "
                                        ";
        // line 266
        echo "                                    </span>
                                </span>
                                </div>
                                <div class=\"uv-ticket-main-lt\">
                                    ";
        // line 270
        if (twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 270, $this->source); })()), "smallThumbnail", [], "any", false, false, false, 270)) {
            // line 271
            echo "                                        <img src=\"";
            echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 271, $this->source); })()), "request", [], "any", false, false, false, 271), "scheme", [], "any", false, false, false, 271) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 271, $this->source); })()), "request", [], "any", false, false, false, 271), "httpHost", [], "any", false, false, false, 271)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")), "html", null, true);
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 271, $this->source); })()), "smallThumbnail", [], "any", false, false, false, 271), "html", null, true);
            echo "\">
                                    ";
        } else {
            // line 273
            echo "                                        <img src=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((isset($context["default_customer_image_path"]) || array_key_exists("default_customer_image_path", $context) ? $context["default_customer_image_path"] : (function () { throw new RuntimeError('Variable "default_customer_image_path" does not exist.', 273, $this->source); })())), "html", null, true);
            echo "\">
                                    ";
        }
        // line 275
        echo "                                </div>
                                <div class=\"uv-ticket-main-rt\">
                                    <span class=\"uv-ticket-member-name\">
                                        ";
        // line 278
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["createThread"]) || array_key_exists("createThread", $context) ? $context["createThread"] : (function () { throw new RuntimeError('Variable "createThread" does not exist.', 278, $this->source); })()), "user", [], "any", false, false, false, 278), "name", [], "any", false, false, false, 278), "html", null, true);
        echo "
                                    </span>

                                    <!-- Message Block -->
                                    <div class=\"message\">
                                        <p>
                                            ";
        // line 284
        if ((strip_tags(twig_get_attribute($this->env, $this->source, (isset($context["createThread"]) || array_key_exists("createThread", $context) ? $context["createThread"] : (function () { throw new RuntimeError('Variable "createThread" does not exist.', 284, $this->source); })()), "reply", [], "any", false, false, false, 284)) == twig_get_attribute($this->env, $this->source, (isset($context["createThread"]) || array_key_exists("createThread", $context) ? $context["createThread"] : (function () { throw new RuntimeError('Variable "createThread" does not exist.', 284, $this->source); })()), "reply", [], "any", false, false, false, 284))) {
            // line 285
            echo "                                                ";
            echo nl2br(twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["createThread"]) || array_key_exists("createThread", $context) ? $context["createThread"] : (function () { throw new RuntimeError('Variable "createThread" does not exist.', 285, $this->source); })()), "reply", [], "any", false, false, false, 285), "html", null, true));
            echo "
                                            ";
        } else {
            // line 287
            echo "                                                ";
            echo twig_get_attribute($this->env, $this->source, (isset($context["createThread"]) || array_key_exists("createThread", $context) ? $context["createThread"] : (function () { throw new RuntimeError('Variable "createThread" does not exist.', 287, $this->source); })()), "reply", [], "any", false, false, false, 287);
            echo "
                                            ";
        }
        // line 289
        echo "                                        </p>
                                    </div>
                                    <!-- //Message Block -->

                                    <!-- Attachment Block -->
                                    ";
        // line 294
        if (twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["createThread"]) || array_key_exists("createThread", $context) ? $context["createThread"] : (function () { throw new RuntimeError('Variable "createThread" does not exist.', 294, $this->source); })()), "attachments", [], "any", false, false, false, 294))) {
            // line 295
            echo "                                        <div class=\"uv-ticket-uploads\">
                                            <h4>";
            // line 296
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Uploaded Files"), "html", null, true);
            echo "</h4>
                                            <div class=\"uv-ticket-uploads-strip uv-viewer-images\">
                                                ";
            // line 298
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["createThread"]) || array_key_exists("createThread", $context) ? $context["createThread"] : (function () { throw new RuntimeError('Variable "createThread" does not exist.', 298, $this->source); })()), "attachments", [], "any", false, false, false, 298));
            foreach ($context['_seq'] as $context["_key"] => $context["attachment"]) {
                // line 299
                echo "                                                    <a href=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["attachment"], "downloadURL", [], "any", false, false, false, 299), "html", null, true);
                echo "\" target = \"_blank\" class=\"uv-ticket-uploads-brick uv-no-pointer-events\" data-toggle=\"tooltip\" title=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["attachment"], "name", [], "any", false, false, false, 299), "html", null, true);
                echo "\">
                                                        <img src=\"";
                // line 300
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["attachment"], "iconURL", [], "any", false, false, false, 300), "html", null, true);
                echo "\"  class=\"uv-auto-pointer-events\"/>
                                                    </a>
                                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attachment'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 303
            echo "                                            </div>
                                            ";
            // line 304
            if ((twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["createThread"]) || array_key_exists("createThread", $context) ? $context["createThread"] : (function () { throw new RuntimeError('Variable "createThread" does not exist.', 304, $this->source); })()), "attachments", [], "any", false, false, false, 304)) > 1)) {
                // line 305
                echo "                                                <div class=\"uv-upload-actions\">
                                                    <!-- <a href=\"#\"><span class=\"uv-icon-open-in-files\"></span>Open in Files</a> -->
                                                    <a href=\"";
                // line 307
                echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_download_ticket_attachment_zip");
                echo "/";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["createThread"]) || array_key_exists("createThread", $context) ? $context["createThread"] : (function () { throw new RuntimeError('Variable "createThread" does not exist.', 307, $this->source); })()), "id", [], "any", false, false, false, 307), "html", null, true);
                echo "\" target=\"_blank\"><span class=\"uv-icon-attachment\"></span> ";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Download (as .zip)"), "html", null, true);
                echo "</a>
                                                </div>
                                            ";
            }
            // line 310
            echo "                                        </div>
                                    ";
        }
        // line 312
        echo "                                    <!-- //Attachment Block -->
                                </div>
                            </div>

                            <!-- uv-ticket-accordion-expanded uv-ticket-accordion-no-count-->
                            <div class=\"uv-ticket-accordion\">
                                <div class=\"uv-ticket-count-wrapper\">
                                    <span class=\"uv-ticket-count-stat\">";
        // line 319
        echo twig_escape_filter($this->env, (isset($context["totalThreads"]) || array_key_exists("totalThreads", $context) ? $context["totalThreads"] : (function () { throw new RuntimeError('Variable "totalThreads" does not exist.', 319, $this->source); })()), "html", null, true);
        echo "</span>
                                </div>
                                <div class=\"uv-ticket-wrapper thread-list\">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reply Form Block -->
                    <div class=\"uv-ticket-main uv-ticket-reply uv-no-error-success-icon\">
                        <div class=\"uv-ticket-main-lt\">
                            <span class=\"uv-icon-ellipsis\"></span>
                            ";
        // line 331
        if (twig_get_attribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 331, $this->source); })()), "smallThumbnail", [], "any", false, false, false, 331)) {
            // line 332
            echo "                                <img src=\"";
            echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 332, $this->source); })()), "request", [], "any", false, false, false, 332), "scheme", [], "any", false, false, false, 332) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 332, $this->source); })()), "request", [], "any", false, false, false, 332), "httpHost", [], "any", false, false, false, 332)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")), "html", null, true);
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 332, $this->source); })()), "smallThumbnail", [], "any", false, false, false, 332), "html", null, true);
            echo "\" />
                            ";
        } else {
            // line 334
            echo "                                <img src=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((isset($context["default_customer_image_path"]) || array_key_exists("default_customer_image_path", $context) ? $context["default_customer_image_path"] : (function () { throw new RuntimeError('Variable "default_customer_image_path" does not exist.', 334, $this->source); })())), "html", null, true);
            echo "\" />
                            ";
        }
        // line 336
        echo "                        </div>
                        <div class=\"uv-ticket-main-rt\">
                            <span class=\"uv-ticket-member-name\">";
        // line 338
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 338, $this->source); })()), "name", [], "any", false, false, false, 338), "html", null, true);
        echo "</span>

                            <!-- Reply Tab View -->
                            <div class=\"uv-tab-view uv-tab-view-active\" id=\"reply\">
                                <form enctype=\"multipart/form-data\" method=\"post\" action=\"";
        // line 342
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_add_ticket_thread", ["id" => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 342, $this->source); })()), "id", [], "any", false, false, false, 342)]), "html", null, true);
        echo "\" id=\"ticket-form\">
                                    <input name=\"threadType\" value=\"reply\" type=\"hidden\">
                                    <input class=\"reply-status\" name=\"status\" value=\"\" type=\"hidden\">
                                    <div class=\"uv-element-block collaborators\" style=\"display: none\">
                                        <label class=\"uv-field-label\">";
        // line 346
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Collaborators"), "html", null, true);
        echo "</label>
                                        <div class=\"uv-field-block\">
                                        </div>
                                    </div>

                                    <div class=\"uv-element-block cc-bcc\">
                                        <label>
                                            <div class=\"uv-checkbox\">
                                                <input type=\"checkbox\" class=\"cc-bcc-toggle\">
                                                <span class=\"uv-checkbox-view\"></span>
                                            </div>
                                            <span class=\"uv-checkbox-label\">";
        // line 357
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("CC/BCC"), "html", null, true);
        echo "</span>
                                        </label>
                                        <div class=\"uv-field-block\" style=\"display: none\">
                                            <div class=\"uv-group\">
                                                <input class=\"uv-group-field\" type=\"text\">
                                                <select class=\"uv-group-select cc-bcc-select\">
                                                    <option value=\"bcc\">";
        // line 363
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("BCC"), "html", null, true);
        echo "</option>
                                                    <option value=\"cc\">";
        // line 364
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("CC"), "html", null, true);
        echo "</option>
                                                </select>
                                            </div>
                                            <div class=\"cc-bcc-list\">
                                            </div>
                                        </div>
                                    </div>

                                    <div class=\"uv-element-block uv-element-block-textarea\">
                                        <label class=\"uv-field-label\">";
        // line 373
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Write a reply"), "html", null, true);
        echo "</label>
                                        <div class=\"uv-field-block\">
                                            <textarea class=\"uv-field\" name=\"message\" id=\"reply-area\">";
        // line 375
        echo "</textarea>
                                        </div>
                                    </div>

                                    <!-- Field -->
                                    <div class=\"uv-element-block attachment-block\">
                                        <label>
                                            <span class=\"uv-file-label\">";
        // line 382
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Attachment"), "html", null, true);
        echo "</span>
                                        </label>
                                    </div>
                                    <!-- //Field -->

                                    <div class=\"uv-action-buttons\">
                                        <div id=\"reply-btn\" class=\"uv-btn uv-submit-left-side\">";
        // line 388
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Reply"), "html", null, true);
        echo "</div>
                                        <div class=\"uv-dropdown reply uv-submit-right-side\">
                                            <div class=\"uv-btn uv-dropdown-other no-left-padding\">
                                                <span class=\"uv-icon-down-light\"></span>
                                            </div>
                                            <div class=\"uv-dropdown-list uv-top-left\">
                                                <div class=\"uv-dropdown-container\">
                                                    <label>";
        // line 395
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Reply"), "html", null, true);
        echo "</label>
                                                    <ul>
                                                        <li data-id=\"\">";
        // line 397
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Submit"), "html", null, true);
        echo "</li>
                                                        <li class=\"confirm-close-ticket\" data-id=\"closed\">";
        // line 398
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Submit And Closed"), "html", null, true);
        echo "</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- //Reply Tab View -->
                        </div>
                    </div>
                    <!-- Reply Form Block -->
                </div>
            </section>
        </div>
        </div>
    </div>

    <div class=\"uv-pop-up-overlay\" id=\"confirm-ticket-close-modal\" style=\"display: none;\">
        <div class=\"uv-pop-up-box uv-pop-up-slim\">
            <span class=\"uv-pop-up-close\"></span>
            <h2>";
        // line 419
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Confirm Close Ticket"), "html", null, true);
        echo "</h2>
            <p>";
        // line 420
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Are you sure? You want to reply and close ticket."), "html", null, true);
        echo "</p>

            <div class=\"uv-pop-up-actions\">
                <a href=\"#\" class=\"uv-btn uv-btn-error\" id=\"confirmed-close-ticket\" data-id=\"closed\">";
        // line 423
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Confirm"), "html", null, true);
        echo "</a>
                <a href=\"#\" class=\"uv-btn cancel\">";
        // line 424
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Cancel"), "html", null, true);
        echo "</a>
            </div>
        </div>
    </div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 430
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 431
        echo "    ";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
    ";
        // line 432
        echo twig_include($this->env, $context, "@UVDeskCoreFramework/Templates/attachment.html.twig");
        echo "

    <script id=\"thread_list_item_tmp\" type=\"text/template\">
        <div class=\"uv-ticket-strip\">
            <span>
                <span class=\"timeago uv-margin-0\" data-timestamp=\"<%= timestamp %>\" title=\"<%= formatedCreatedAt %>\">
                    <%= formatedCreatedAt %>
                </span>
                - <%- fullname %>
                <span class=\"uv-ticket-strip-label\">
                    ";
        // line 442
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("replied"), "html", null, true);
        echo "
                </span>
            </span>
            <% if(cc || bcc) { %>
                <div class=\"uv-ticket-strip\">
                    <% if(cc) { %>
                        <span><span class=\"uv-ticket-strip-label\">";
        // line 448
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("CC"), "html", null, true);
        echo " -</span> <%- cc %></span>
                    <% } if(bcc) { %>
                        <span><span class=\"uv-ticket-strip-label\">";
        // line 450
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("BCC"), "html", null, true);
        echo " -</span> <%- bcc %></span>
                    <% } %>
                </div>
            <% } %>
        </div>
        <div class=\"uv-ticket-main-lt\">
            <% if(user && smallThumbnail != null) { %>
                <img src=\"";
        // line 457
        echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 457, $this->source); })()), "request", [], "any", false, false, false, 457), "scheme", [], "any", false, false, false, 457) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 457, $this->source); })()), "request", [], "any", false, false, false, 457), "httpHost", [], "any", false, false, false, 457)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")), "html", null, true);
        echo "<%= smallThumbnail %>\" />
            <% } else { %>
                <img src=\"<% if(userType == 'agent') { %> ";
        // line 459
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((isset($context["default_agent_image_path"]) || array_key_exists("default_agent_image_path", $context) ? $context["default_agent_image_path"] : (function () { throw new RuntimeError('Variable "default_agent_image_path" does not exist.', 459, $this->source); })())), "html", null, true);
        echo " <% } else { %> ";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((isset($context["default_customer_image_path"]) || array_key_exists("default_customer_image_path", $context) ? $context["default_customer_image_path"] : (function () { throw new RuntimeError('Variable "default_customer_image_path" does not exist.', 459, $this->source); })())), "html", null, true);
        echo " <% } %>\" />
            <% } %>
        </div>
        <div class=\"uv-ticket-main-rt\">
            <span class=\"uv-ticket-member-name\">
                <%- fullname %>
            </span>
            <!-- Message Block -->
            <div class=\"message\">
                <%= reply %>
            </div>
            <!-- //Message Block -->

            <!-- Attachment Block -->
            <% if(attachments.length) { %>
                <div class=\"uv-ticket-uploads\">
                    <h4>";
        // line 475
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Uploaded Files"), "html", null, true);
        echo "</h4>
                    <div class=\"uv-ticket-uploads-strip uv-viewer-images\">
                        <% _.each(attachments, function(file) { %>
                            <a href=\"<%-file.downloadURL %>\" target =\"_blank\" class=\"uv-ticket-uploads-brick uv-no-pointer-events\" data-toggle=\"tooltip\" title=\"<%- file.name %>\">
                                <img src=\"<%-file.iconURL %>\" class=\"uv-auto-pointer-events\">
                            </a>
                        <% }) %>
                    </div>

                    <% if (attachments.length > 1) { %>
                        <div class=\"thread-attachments-zip pull-left\">
                            <div class=\"uv-upload-actions\">
                                ";
        // line 488
        echo "                                <a href=\"";
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_download_ticket_attachment_zip");
        echo "/<%= id %>\" target=\"_blank\"><span class=\"uv-icon-attachment\"></span> ";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Download (as .zip)"), "html", null, true);
        echo "</a>
                            </div>
                        </div>
                    <% } %>
                </div>
            <% } %>
            <!-- //Attachment Block -->
        </div>
    </script>

    <script type=\"text/javascript\">

        var ticketApp = {};
        \$(function () {
            
            var TicketModel = Backbone.Model.extend({
                idAttribute : \"id\",
                validation: {
                    'email': [{
                        required: true,
                        msg: '";
        // line 508
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
                    },{
                        pattern: 'email',
                        msg: '";
        // line 511
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please enter a valid email"), "html", null, true);
        echo "'
                    }],
                },
            });

            var TicketView = Backbone.View.extend({
                el: \$('.uv-body'),
                stopDraftSaveFlag: 0,
                events: {
                    'click .collaborator-list .uv-btn-tag': 'removeCcCollaborator',
                    'change .uv-element-block.cc-bcc .cc-bcc-toggle': 'showCcBccBlock',
                    'keypress .uv-element-block.cc-bcc .uv-group-field': 'addCcBccInput',
                    'click .cc-bcc-list .uv-btn-tag, .to-list .uv-btn-tag': 'removeEmail',
                    'click .uv-dropdown.reply .uv-dropdown-list li:not(.confirm-close-ticket)': 'validateForm',
                    'click #reply-btn': 'validateForm',
                    'click #confirmed-close-ticket': 'confirmedAction',
                    'click .confirm-close-ticket': 'confirmClose',
                },
                confirmClose: function(e) {
                    \$('#confirm-ticket-close-modal').show();
                },
                confirmedAction: function(e) {
                    \$('#confirm-ticket-close-modal').hide();
                    this.validateForm(e);
                },
                loaderTemplate : _.template(\$(\"#loader-tmp\").html()),
                addCCCollaborators: function() {
                    if(collaboratorCollection.length) {
                        var collaboratorContainer = \$('.uv-element-block.collaborators');
                        collaboratorContainer.find('.uv-field-block').html('');
                        collaboratorContainer.show()
                        _.each(collaboratorCollection.models, function (item) {
                            var json = item.attributes;
                            collaboratorContainer.find('.uv-field-block').append(\"<span><input type='hidden' name='cccol[]' value='\" + json.email + \"'/><a class='uv-btn-tag' href='#'><span class='uv-icon-remove-dark-before'></span>\" + json.name + \"</a></span>\")
                        }, this);
                    }
                },
                removeCcCollaborator: function(e) {
                    e.preventDefault()
                    if (Backbone.\$(e.currentTarget).parent()[0]) {
                        Backbone.\$(e.currentTarget).parent()[0].removeChild(e.currentTarget);
                        var collaboratorContainer = \$('.uv-element-block.collaborators');
                    }

                    if(!collaboratorContainer.find('.uv-btn-tag').length)
                        collaboratorContainer.hide()
                },
                showCcBccBlock: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    var currentTab = currentElement.parents('.uv-tab-view');
                    if(currentElement.is(':checked')) {
                        currentTab.find('.uv-element-block.cc-bcc').find('.uv-field-block').show()
                    } else {
                        currentTab.find('.uv-element-block.cc-bcc').find('.uv-field-block').hide()
                        currentTab.find('.uv-element-block .cc-bcc-list').html('')
                    }
                },
                addCcBccInput: function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    var currentTab = inputElement.parents('.uv-tab-view');
                    var email = inputElement.val().trim();
                    if (e.which === 13 && email) {
                        e.preventDefault()
                        type = currentTab.find('.cc-bcc-select option:selected').text()
                        if(!this.model.preValidate({name: 'email', email: email})) {
                            inputName = \$('.cc-bcc-select').val()
                            inputElement.val('').trigger('input')
                            inputElement.removeClass('uv-dropdown-btn-active')
                            inputElement.siblings('.uv-dropdown-list').hide()
                            if(!currentTab.find(\".cc-bcc-list input[value='\" + email + \"'].\" + inputName).length) {
                                currentTab.find('.cc-bcc-list').append(\"<span><input type='hidden' name='\" + inputName + \"[]' value='\" + email + \"' class='\" + inputName + \"'/><a class=uv-btn-tag uv-lowercase' href='#'><span class='uv-icon-remove-dark-before'></span>\" + email + \" : <span class='uv-uppercase'>\" + type + \"</span></a></span>\")
                            }
                        }
                    }
                },
                removeEmail: function(e) {
                    e.preventDefault()
                    Backbone.\$(e.currentTarget).parent().remove();
                },
                validateForm : function(e) {
                    e.preventDefault();
                    var element = Backbone.\$(e.currentTarget);
                    form = \$('#ticket-form');
                    form.find('.reply-status').val(element.attr('data-id'));
                    form.find('.uv-field-message').remove()

                    var html = tinyMCE.get(\"reply-area\").getContent();
                    if(app.appView.htmlText(html) != '' || -1 != html.indexOf('<img')) {
                        this.stopDraftSaveFlag = 1;

\t\t\t\t\t\tapp.appView.showLoader();
                        tinyMCE.activeEditor.uploadImages(function(response) {
                            app.appView.hideLoader();

\t\t\t\t\t\t\tform.submit();
\t                        \$('.uv-dropdown.reply').find('.uv-btn').attr('disabled', 'disabled');
\t                        \$('#reply-btn,#confirmed-close-ticket').attr('disabled', 'disabled');
                        });
                    } else {
                        form.find('.uv-element-block-textarea').append(\"<span class='uv-field-message'>";
        // line 610
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "</span>\");
                    }
                }
            });

            var ThreadModel = Backbone.Model.extend({
                idAttribute : \"id\",
                defaults : {
                    hasTask : 0,
                    task: null
                }
            });

            var ThreadCollection = AppCollection.extend({
                model : ThreadModel,
                mode: \"infinite\",
                url : \"";
        // line 626
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_thread_collection_xhr", ["id" => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 626, $this->source); })()), "id", [], "any", false, false, false, 626)]), "html", null, true);
        echo "\",
                parseRecords: function (resp, options) {
                    return resp.threads;
                },
                syncData : function() {
                    app.appView.showLoader()
                    this.fetch({
                        remove: false,
                        success: function(model, response) {
                            app.appView.hideLoader()
                            pagination.renderPagination(response.pagination);
                            threadCollection.state.currentPage = parseInt(response.pagination.current) + 1;
                        },
                        error: function (model, xhr, options) {
                            app.appView.hideLoader()
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                        }
                    });
                }
            });

            var ThreadItem = Backbone.View.extend({
                tagName : \"div\",
                className : \"uv-ticket-main\",
                template : _.template(\$(\"#thread_list_item_tmp\").html()),
                render : function () {
                    this.\$el.html(this.template(this.model.toJSON()));
                    this.\$el.addClass(\"thread-\" + this.model.id)

                    return this;
                }
            });

            var ThreadList = Backbone.View.extend({
                el : \$(\".thread-list\"),
                initialize : function() {
                    this.listenTo(threadCollection.fullCollection, \"add\", this.renderThread);
                },
                renderThread : function (item) {
                    var threadItem = new ThreadItem({
                        model: item
                    });
                    if(item.id < threadCollection.fullCollection.at(0).id)
                        this.\$el.prepend(threadItem.render().el);
                    else
                        this.\$el.append(threadItem.render().el);
                    threadItem.\$el.find('.helpdesk_blockquote').eq(0).before(\"<span class='uv-icon-ellipsis uv-ellipsis-mirror'></span>\").hide();
                    //emojifyRun();
                    this.\$el.find('img').removeAttr('crossorigin');
                    //viewerImages();
                    //convertForImages(this.\$el);
                    this.\$el.find('div.message a').attr('target', '_blank');
                    app.appView.relativeTime()
                }
            });

            var Pagination = Backbone.View.extend({
                el: \$('.uv-ticket-accordion'),
                events: {
                    'click .uv-ticket-count-stat': 'loadMore',
                },
                renderPagination: function(pagination) {
                    if(pagination.totalCount - pagination.lastItemNumber > 0 && pagination.lastItemNumber > 0) {
                        var remain = pagination.totalCount - pagination.lastItemNumber;
                        \$('.uv-ticket-count-stat').text(remain)
                        \$('.uv-ticket-accordion').removeClass('uv-ticket-accordion-expanded').removeClass('uv-ticket-accordion-no-count')
                    } else {
                        \$('.uv-ticket-accordion').addClass('uv-ticket-accordion-expanded').addClass('uv-ticket-accordion-no-count')
                    }
                },
                loadMore: function() {
                    threadCollection.syncData();
                }
            });

            //Collaborator Code starts here
            _.extend(Backbone.Model.prototype, Backbone.Validation.mixin);
            var CollaboratorModel = Backbone.Model.extend({
                idAttribute : \"id\",
                validation: {
                    'email': [{
                        required: true,
                        msg: '";
        // line 709
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "'
                    },{
                        pattern: 'email',
                        msg: '";
        // line 712
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please enter a valid email"), "html", null, true);
        echo "'
                    }]
                },
                defaults : {
                    ticketId : ";
        // line 716
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 716, $this->source); })()), "id", [], "any", false, false, false, 716), "html", null, true);
        echo ",
                    email: ''
                },
                parse: function (resp, options) {
                    return resp.collaborator;
                },
                urlRoot : \"";
        // line 722
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_update_ticket_collaborators_xhr");
        echo "\"
            });

            var CollaboratorCollection = Backbone.PageableCollection.extend({
                model : CollaboratorModel
            });

            var CollaboratorItem = Backbone.View.extend({
                tagName : \"a\",
                className: 'uv-btn-tag',
                template : _.template(\"<span class='uv-tag'><span class='uv-icon-remove-dark-before'></span><%- name %></span>\"),
                events : {
                    'click .uv-tag' : 'removeItem'
                },
                render : function () {
                    this.\$el.html(this.template(this.model.toJSON()));
                    return this;
                },
                unrender : function(response) {
                    if(response.alertMessage != undefined) {
                        collaboratorListView.render();
                        app.appView.renderResponseAlert(response);
                    }
                },
                removeItem: function() {
                    self = this;
                    app.appView.showLoader();
                    this.model.destroy({
                        data : { 'ticketId' : this.model.attributes.ticketId },
                        success : function (model, response, options) {
                            app.appView.hideLoader();
                            self.\$el.remove();
                            self.unrender(response);
                        },
                        error: function (model, xhr, options) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        }
                    });
                }
            });

            var CollaboratorList = Backbone.View.extend({
                el : \$(\".collaborator-list-block\"),
                events : {
                    'keypress .uv-field' : 'addCollaborator',
                    'focusout .uv-field' : 'removeErrorClass',
                },
                initialize : function() {
                    //Backbone.Validation.bind(this);
                },
                render : function() {
                    this.\$el.find(\".collaborator-list\").html('');
                    var self = this;
                    collaboratorOptionHtml = '';
                    if(collaboratorCollection.length) {
                        _.each(collaboratorCollection.models, function (item) {
                            this.renderCollaborator(item);
                        }, this);
                    }
                    ticketView.addCCCollaborators()
                },
                renderCollaborator : function (item) {
                    var collaborator = new CollaboratorItem({
                        model: item
                    });
                    this.\$el.find('.collaborator-list').append(collaborator.render().el);
                },
                removeErrorClass: function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    inputElement.removeClass('uv-field-error');
                    inputElement.parents('.uv-element-block').find('.uv-field-message').remove()
                },
                addCollaborator : function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    inputElement.removeClass('uv-field-error');
                    inputElement.parents('.uv-element-block').find('.uv-field-message').remove()
                    var text = inputElement.val().trim();

                    if (e.which === 13 && text) {
                        this.model = new CollaboratorModel();
                        self = this;
                        this.model.set({email: text})

                        if(this.model.isValid(true)) {
                            app.appView.showLoader();
                            this.model.save({},{
                                success : function (model, response, options) {
                                    inputElement.val('');
                                    if(response.alertClass == \"success\") {
                                        collaboratorCollection.add(model);
                                    }
                                    self.render();
                                    app.appView.hideLoader();
                                    app.appView.renderResponseAlert(response);
                                },
                                error: function (model, xhr, options) {
                                    if(url = xhr.getResponseHeader('Location'))
                                        window.location = url;
                                    var response = warningResponse;
                                    if(xhr.responseJSON)
                                        response = xhr.responseJSON;

                                    app.appView.hideLoader();
                                    app.appView.renderResponseAlert(response);
                                }
                            });
                        } else {
                            inputElement.addClass('uv-field-error');
                            if(text)
                                inputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>";
        // line 838
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email address is invalid"), "html", null, true);
        echo "</span>\");
                        }
                    }
                }
            });
            //Collaborator Code ends here

            ticketModel = new TicketModel({
                id : \"";
        // line 846
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 846, $this->source); })()), "id", [], "any", false, false, false, 846), "html", null, true);
        echo "\",
            });

            ticketApp.ticketView = ticketView = new TicketView({
                model: ticketModel
            });

            var threadCollection = new ThreadCollection();
\t\t    var threadList = new ThreadList();
            var pagination = new Pagination();
            threadCollection.syncData();

            ";
        // line 858
        if ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 858, $this->source); })()), "customer", [], "any", false, false, false, 858) == twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 858, $this->source); })()), "user", [], "any", false, false, false, 858))) {
            // line 859
            echo "                var collaboratorCollection = new CollaboratorCollection(\$.parseJSON('";
            echo json_encode(twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 859, $this->source); })()), "getTicketCollaborators", [0 => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 859, $this->source); })()), "id", [], "any", false, false, false, 859)], "method", false, false, false, 859));
            echo "'));
                var collaboratorListView = new CollaboratorList();
                collaboratorListView.render();
            ";
        }
        // line 863
        echo "        });
    </script>

    ";
        // line 866
        echo twig_include($this->env, $context, "@UVDeskCoreFramework/Templates/tinyMCE.html.twig");
        echo "

\t<script>
\t\tsfTinyMce.init({
            height: '250px',
\t\t\tselector : '.uv-ticket-reply textarea',
\t\t\timages_upload_url: \"";
        // line 872
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_customer_upload_thread_encoded_image", ["ticketId" => twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 872, $this->source); })()), "request", [], "any", false, false, false, 872), "get", [0 => "id"], "method", false, false, false, 872)]), "html", null, true);
        echo "\",
            setup: function(editor) {
            }
\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Knowledgebase/ticketView.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1388 => 872,  1379 => 866,  1374 => 863,  1366 => 859,  1364 => 858,  1349 => 846,  1338 => 838,  1219 => 722,  1210 => 716,  1203 => 712,  1197 => 709,  1111 => 626,  1092 => 610,  990 => 511,  984 => 508,  958 => 488,  943 => 475,  922 => 459,  917 => 457,  907 => 450,  902 => 448,  893 => 442,  880 => 432,  875 => 431,  865 => 430,  850 => 424,  846 => 423,  840 => 420,  836 => 419,  812 => 398,  808 => 397,  803 => 395,  793 => 388,  784 => 382,  775 => 375,  770 => 373,  758 => 364,  754 => 363,  745 => 357,  731 => 346,  724 => 342,  717 => 338,  713 => 336,  707 => 334,  700 => 332,  698 => 331,  683 => 319,  674 => 312,  670 => 310,  660 => 307,  656 => 305,  654 => 304,  651 => 303,  642 => 300,  635 => 299,  631 => 298,  626 => 296,  623 => 295,  621 => 294,  614 => 289,  608 => 287,  602 => 285,  600 => 284,  591 => 278,  586 => 275,  580 => 273,  573 => 271,  571 => 270,  565 => 266,  561 => 262,  556 => 260,  551 => 258,  547 => 257,  537 => 249,  531 => 246,  527 => 245,  524 => 244,  522 => 243,  517 => 241,  513 => 240,  506 => 236,  500 => 235,  496 => 234,  488 => 229,  480 => 223,  468 => 214,  463 => 212,  459 => 211,  455 => 209,  453 => 208,  450 => 207,  440 => 200,  435 => 198,  430 => 195,  428 => 194,  425 => 193,  419 => 190,  415 => 189,  412 => 188,  410 => 187,  405 => 185,  401 => 184,  398 => 183,  392 => 180,  388 => 179,  385 => 178,  382 => 177,  376 => 174,  372 => 173,  369 => 172,  367 => 171,  360 => 167,  355 => 165,  349 => 162,  344 => 160,  339 => 158,  333 => 154,  330 => 153,  327 => 152,  324 => 151,  321 => 150,  319 => 149,  196 => 28,  186 => 27,  170 => 20,  166 => 19,  161 => 16,  153 => 14,  151 => 13,  145 => 12,  139 => 8,  129 => 7,  107 => 5,  85 => 4,  63 => 3,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskSupportCenter/Templates/layout.html.twig\" %}

{% block title %}#{{ ticket.id }} {{ ticket.subject }}{% endblock %}
{% block ogtitle %}#{{ ticket.id }} {{ ticket.subject }}{% endblock %}
{% block twtitle %}#{{ ticket.id }} {{ ticket.subject }}{% endblock %}

{% block tabHeader %}
\t<div class=\"uv-nav-bar uv-nav-tab\">
\t\t<div class=\"uv-container\">
\t\t\t<div class=\"uv-nav-bar-lt\">
\t\t\t\t<ul class=\"uv-nav-tab-label\">
\t\t\t\t\t<li><a href=\"{{ path('helpdesk_customer_ticket_collection') }}\">{{ 'Ticket Requests'|trans }}</a></li>
\t\t\t\t\t{% if websiteConfiguration.ticketCreateOption %}
                        <li><a href=\"{{ path('helpdesk_customer_create_ticket') }}\">{{ 'New Ticket Request'|trans }}</a></li>
                    {% endif %}
\t\t\t\t</ul>
\t\t\t</div>
\t\t\t<div class=\"uv-nav-bar-rt\">
\t\t\t\t<form method=\"get\" action=\"{{path('helpdesk_customer_front_article_search')}}\">
\t\t\t\t\t<input name=\"s\" class=\"uv-nav-search\" type=\"text\" placeholder=\"{{ 'Search'|trans }}\">
\t\t\t\t</form>
\t\t\t</div>
\t\t</div>
\t</div>
{% endblock %}

{% block body %}
    <style>
        .uv-btn-tag {
            margin-right: 5px;
        }
        .uv-group-field {
            width: 80%;
        }
        .uv-element-block .mce-tinymce {
            margin-top: 10px;
        }
        .uv-ticket-view .uv-ticket-accordion .uv-ticket-wrapper {
            display: block;
        }
        .message {
            font-size: 15px;
        }
        .message img {
            max-width: 100%;
        }
        .uv-dropdown.reply .uv-dropdown-btn-active {
            border: none;
        }
        .uv-dropdown.reply .uv-dropdown-list {
            width: 220px;
            bottom: 47px;
        }

\t\t.uv-rtl .uv-top-left {
\t\t\tleft: unset;
\t\t}

\t\t.uv-rtl .uv-dropdown-list {
\t\t\ttext-align: right;
\t\t}

        .uv-action-buttons {
            margin: 10px 0px;
        }

        .uv-action-buttons .uv-btn:first-child {
            margin-left: 0px;
        }

\t\t.uv-rtl .uv-action-buttons .uv-btn:first-child {
\t\t\tmargin-left: 5px;
\t\t\tmargin-right: 0px;
\t\t}

        .uv-action-buttons .uv-btn {
            margin: 5px;
        }

        form #customFieldCollection .uv-field-error-icon, form #customFieldCollection .uv-field-success-icon {
            display: none;
        }

        .custom-field-field-display .uv-field-block {
            width: 100%;
            color: #333333;
            word-wrap: break-word;
        }

        .custom-field-field-display .uv-field-block span {
            display: inline;
        }
        .uv-submit-left-side {
            margin: 0!important;
            padding-right: 5px;
            border-bottom-right-radius: 0;
            border-top-right-radius: 0;
        }
\t\t.uv-rtl .uv-submit-left-side {
\t\t\tpadding-right: 10px;
            border-bottom-right-radius: 3px;
            border-top-right-radius: 3px;
\t\t\tpadding-left: 5px;
\t\t\tborder-bottom-left-radius: 0;
            border-top-left-radius: 0;
\t\t}
        .uv-submit-right-side {
            margin: 0!important;
        }
        .no-left-padding {
            padding-left: 0;
            border-bottom-left-radius: 0;
            border-top-left-radius: 0;
        }
\t\t.uv-rtl .no-left-padding {
\t\t\tpadding-left: 10px;
            border-bottom-left-radius: 3px;
            border-top-left-radius: 3px;
\t\t\tpadding-right: 0;
\t\t\tborder-bottom-right-radius: 0;
\t\t\tborder-top-right-radius: 0;
\t\t}
        .uv-btn-error {
            background-color: #FF5656!important;
        }
        .uv-pull-rightside {
            float: right;
            font-size: 15px;
            cursor: pointer;
        }
\t\t.uv-rtl .uv-pull-rightside {
            float: left;
        }
        .uv-print-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            background-image: url('../../../../../bundles/webkuldefault/images/uvdesk-kb-sprite.svg');
            background-position: -176px -91px;
            vertical-align: middle;
        }
        @media print {
            .uv-navbar,.uv-ticket-action-bar, .uv-kudo, .uv-aside-back, .uv-footer, .uv-ticket-main.uv-ticket-reply, .uv-nav-bar,input, .uv-dropdown-list>.uv-dropdown-container,.uv-notifications-wrapper,.uv-pop-up-overlay,.uv-loader-view, .uv-loader,.uv-header,.uv-upload-actions,.uv-pull-rightside {
                display: none !important;
            }
        }
    </style>

    {% set ticketAgent = ticket.agent ? user_service.getAgentDetailById(ticket.agent.id) : null %}
    {% set totalThreads = ticket_service.getTicketTotalThreads(ticket.id) %}
    {% set customer = user_service.getCustomerPartialDetailById(ticket.customer.id)  %}
    {% set createThread = ticket_service.getCreateReply(ticket.id, 'customer') %}
    {% set currentUser = user_service.getCustomerPartialDetailById(app.user.id)  %}

    <div class=\"uv-thread\">
        <div class=\"uv-thread-lt\">
            <aside>
                <h6>{{ 'Ticket Information'|trans }}</h6>
                <div class=\"uv-aside-brick\">
                    <h6>{{ 'Total Replies'|trans }}</h6>
                    <span class=\"uv-icon-replies\"></span>
                    <span>{{ totalThreads }}</span>
                </div>
                <div class=\"uv-aside-brick\">
                    <h6>{{ 'Timestamp'|trans }}</h6>
                    <span class=\"uv-icon-timestamp\"></span>
                    <span>{{ ticket.createdAt|date('m-d-y h:i A') }}</span>
                </div>

                <div class=\"uv-hr\"></div>
                {% if ticket.customer != app.user %}
                    <div class=\"uv-aside-brick\">
                        <h6>{{ 'Customer'|trans }}</h6>
                        <span>{{ customer.name }}</span>
                    </div>
                {% endif %}
                {% if ticketAgent %}
                    <div class=\"uv-aside-brick\">
                        <h6>{{ 'Agent'|trans }}</h6>
                        <span>{{ ticketAgent.name }}</span>
                    </div>
                {% endif %}
                <div class=\"uv-aside-brick\">
                    <h6>{{ 'Status'|trans }}</h6>
                    <span>{{ ticket.status.code|trans }}</span>
                </div>
                {% if ticket.type %}
                    <div class=\"uv-aside-brick\">
                        <h6>{{ 'Type'|trans }}</h6>
                        <span>{{ ticket.type.code }}</span>
                    </div>
                {% endif %}

                {% if ticket.customer == app.user %}
                    <div class=\"uv-hr\"></div>
                    <div class=\"uv-aside-brick collaborator-list-block\">
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">{{ 'Collaborators'|trans }}</label>
                            <div class=\"uv-field-block\">
                                <input class=\"uv-field\" type=\"text\" name=\"email\" type=\"text\" value=\"\" placeholder=\"{{ 'Type email to add'|trans }}\">
                            </div>
                        </div>
                        <div class=\"collaborator-list\" style=\"margin-top: 10px\">
                        </div>
                    </div>
                {% endif %}
            </aside>
            {% if customFieldCollection is defined %}
                <aside id=\"uv-customfield-view\" class=\"uv-customfield-view\" style=\"margin-top: 20px;\">
                    <div style=\"position: relative;\">
                        <h6>{{ 'Custom Field'|trans }}</h6>
                        <span class=\"uv-customize cfield-manage-pta\" style=\"width: 15px; height: 15px; position: absolute; background-image: url('../../../../../bundles/webkuldefault/images/uvdesk-sprite.svg'); background-position: -44px -46px; top: 4px; cursor: pointer;\" title=\"{{ 'Manage Ticket Custom Fields'|trans }}\" data-toggle=\"tooltip\" data-placement=\"bottom\"></span>
                    </div>
                    <p style=\"padding-right: 20px; color: #6F6F6F; font-style: italic;\">{{ 'Manage Custom Fields to provide additional details with the ticket.'|trans }}</p>

                    <div class=\"uv-hr\"></div>
                    <form name=\"customFieldForm\" enctype=\"multipart/form-data\">
                        <div id=\"customFieldCollection\">
                        </div>
                    </form>
                </aside>
            {% endif %}
        </div>
        <div class=\"uv-thread-rt\">
            <section>
                <div class=\"uv-ticket-view\">
                    <div class=\"uv-ticket-head\">
                        <h1>
                            {{ ticket.subject }}
                            <span class=\"uv-pull-rightside uv-print-icon\" onclick=\"window.print()\"></span>
                        </h1>
                        <div class=\"uv-ticket-strip\">
                            <span>
                                <span class=\"uv-ticket-strip-label\">{{ 'Created'|trans }} -</span>
                                <span class=\"timeago\" data-timestamp=\"{{ (ticket.createdAt|date('m-d-y h:i:s A')) }}\" title=\"{{ ticket.createdAt|date('m-d-y h:i:s A') }}\">
                                    {{ ticket.createdAt|date('m-d-y h:i A') }}
                                </span>
                            </span>
                            <span>
                                <span class=\"uv-ticket-strip-label\">{{ 'By'|trans }} -</span>
                                {{ createThread.user.name }}
                            </span>
                            {% if ticketAgent %}
                                <span>
                                    <span class=\"uv-ticket-strip-label\">{{ 'Agent'|trans }} -</span>
                                    {{ ticketAgent.name }}
                                </span>
                            {% endif %}
                        </div>
                    </div>

                    <div class=\"uv-tab-view\">
                        <div class=\"uv-ticket-section\">
                            <div class=\"uv-ticket-main create\">
                                <div class=\"uv-ticket-strip\">
                                    <span>
                                        <span class=\"timeago uv-margin-0\" data-timestamp=\"ticket.createdAt\" title=\"{{ ticket.createdAt|date('m-d-y h:i:s A') }}\">
                                            {{ ticket.createdAt|date('m-d-y h:i A') }}
                                        </span>
                                        - {{ createThread.user.name }}
                                        <span class=\"uv-ticket-strip-label\">
                                        {{ 'created Ticket'|trans }}
                                        {# {% if ticket.ipAddress %}
                                            ({{ 'IP'|trans }} -{{ ticket.ipAddress }})
                                        {% endif %} #}
                                    </span>
                                </span>
                                </div>
                                <div class=\"uv-ticket-main-lt\">
                                    {% if customer.smallThumbnail %}
                                        <img src=\"{{ app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') }}{{ customer.smallThumbnail }}\">
                                    {% else %}
                                        <img src=\"{{ asset(default_customer_image_path) }}\">
                                    {% endif %}
                                </div>
                                <div class=\"uv-ticket-main-rt\">
                                    <span class=\"uv-ticket-member-name\">
                                        {{ createThread.user.name }}
                                    </span>

                                    <!-- Message Block -->
                                    <div class=\"message\">
                                        <p>
                                            {% if createThread.reply|striptags == createThread.reply %}
                                                {{ createThread.reply|nl2br }}
                                            {% else %}
                                                {{ createThread.reply|raw }}
                                            {% endif %}
                                        </p>
                                    </div>
                                    <!-- //Message Block -->

                                    <!-- Attachment Block -->
                                    {% if createThread.attachments|length %}
                                        <div class=\"uv-ticket-uploads\">
                                            <h4>{{ 'Uploaded Files'|trans }}</h4>
                                            <div class=\"uv-ticket-uploads-strip uv-viewer-images\">
                                                {% for attachment in createThread.attachments %}
                                                    <a href=\"{{ attachment.downloadURL }}\" target = \"_blank\" class=\"uv-ticket-uploads-brick uv-no-pointer-events\" data-toggle=\"tooltip\" title=\"{{ attachment.name }}\">
                                                        <img src=\"{{ attachment.iconURL }}\"  class=\"uv-auto-pointer-events\"/>
                                                    </a>
                                                {% endfor %}
                                            </div>
                                            {% if createThread.attachments|length > 1 %}
                                                <div class=\"uv-upload-actions\">
                                                    <!-- <a href=\"#\"><span class=\"uv-icon-open-in-files\"></span>Open in Files</a> -->
                                                    <a href=\"{{ path('helpdesk_customer_download_ticket_attachment_zip') }}/{{createThread.id}}\" target=\"_blank\"><span class=\"uv-icon-attachment\"></span> {{ 'Download (as .zip)'|trans }}</a>
                                                </div>
                                            {% endif %}
                                        </div>
                                    {% endif %}
                                    <!-- //Attachment Block -->
                                </div>
                            </div>

                            <!-- uv-ticket-accordion-expanded uv-ticket-accordion-no-count-->
                            <div class=\"uv-ticket-accordion\">
                                <div class=\"uv-ticket-count-wrapper\">
                                    <span class=\"uv-ticket-count-stat\">{{ totalThreads }}</span>
                                </div>
                                <div class=\"uv-ticket-wrapper thread-list\">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reply Form Block -->
                    <div class=\"uv-ticket-main uv-ticket-reply uv-no-error-success-icon\">
                        <div class=\"uv-ticket-main-lt\">
                            <span class=\"uv-icon-ellipsis\"></span>
                            {% if currentUser.smallThumbnail %}
                                <img src=\"{{ app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') }}{{ currentUser.smallThumbnail }}\" />
                            {% else %}
                                <img src=\"{{ asset(default_customer_image_path) }}\" />
                            {% endif %}
                        </div>
                        <div class=\"uv-ticket-main-rt\">
                            <span class=\"uv-ticket-member-name\">{{ currentUser.name }}</span>

                            <!-- Reply Tab View -->
                            <div class=\"uv-tab-view uv-tab-view-active\" id=\"reply\">
                                <form enctype=\"multipart/form-data\" method=\"post\" action=\"{{ path('helpdesk_customer_add_ticket_thread', {'id': ticket.id }) }}\" id=\"ticket-form\">
                                    <input name=\"threadType\" value=\"reply\" type=\"hidden\">
                                    <input class=\"reply-status\" name=\"status\" value=\"\" type=\"hidden\">
                                    <div class=\"uv-element-block collaborators\" style=\"display: none\">
                                        <label class=\"uv-field-label\">{{ 'Collaborators'|trans }}</label>
                                        <div class=\"uv-field-block\">
                                        </div>
                                    </div>

                                    <div class=\"uv-element-block cc-bcc\">
                                        <label>
                                            <div class=\"uv-checkbox\">
                                                <input type=\"checkbox\" class=\"cc-bcc-toggle\">
                                                <span class=\"uv-checkbox-view\"></span>
                                            </div>
                                            <span class=\"uv-checkbox-label\">{{ 'CC/BCC'|trans }}</span>
                                        </label>
                                        <div class=\"uv-field-block\" style=\"display: none\">
                                            <div class=\"uv-group\">
                                                <input class=\"uv-group-field\" type=\"text\">
                                                <select class=\"uv-group-select cc-bcc-select\">
                                                    <option value=\"bcc\">{{ 'BCC'|trans }}</option>
                                                    <option value=\"cc\">{{ 'CC'|trans }}</option>
                                                </select>
                                            </div>
                                            <div class=\"cc-bcc-list\">
                                            </div>
                                        </div>
                                    </div>

                                    <div class=\"uv-element-block uv-element-block-textarea\">
                                        <label class=\"uv-field-label\">{{ 'Write a reply'|trans }}</label>
                                        <div class=\"uv-field-block\">
                                            <textarea class=\"uv-field\" name=\"message\" id=\"reply-area\">{# {{ ticket_service.getCustomerDraft(ticket.id, 'reply') }} #}</textarea>
                                        </div>
                                    </div>

                                    <!-- Field -->
                                    <div class=\"uv-element-block attachment-block\">
                                        <label>
                                            <span class=\"uv-file-label\">{{ 'Add Attachment'|trans }}</span>
                                        </label>
                                    </div>
                                    <!-- //Field -->

                                    <div class=\"uv-action-buttons\">
                                        <div id=\"reply-btn\" class=\"uv-btn uv-submit-left-side\">{{ 'Reply'|trans }}</div>
                                        <div class=\"uv-dropdown reply uv-submit-right-side\">
                                            <div class=\"uv-btn uv-dropdown-other no-left-padding\">
                                                <span class=\"uv-icon-down-light\"></span>
                                            </div>
                                            <div class=\"uv-dropdown-list uv-top-left\">
                                                <div class=\"uv-dropdown-container\">
                                                    <label>{{ 'Reply'|trans }}</label>
                                                    <ul>
                                                        <li data-id=\"\">{{ 'Submit'|trans }}</li>
                                                        <li class=\"confirm-close-ticket\" data-id=\"closed\">{{ 'Submit And Closed'|trans }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- //Reply Tab View -->
                        </div>
                    </div>
                    <!-- Reply Form Block -->
                </div>
            </section>
        </div>
        </div>
    </div>

    <div class=\"uv-pop-up-overlay\" id=\"confirm-ticket-close-modal\" style=\"display: none;\">
        <div class=\"uv-pop-up-box uv-pop-up-slim\">
            <span class=\"uv-pop-up-close\"></span>
            <h2>{{ 'Confirm Close Ticket'|trans }}</h2>
            <p>{{ 'Are you sure? You want to reply and close ticket.'|trans }}</p>

            <div class=\"uv-pop-up-actions\">
                <a href=\"#\" class=\"uv-btn uv-btn-error\" id=\"confirmed-close-ticket\" data-id=\"closed\">{{ 'Confirm'|trans }}</a>
                <a href=\"#\" class=\"uv-btn cancel\">{{ 'Cancel'|trans }}</a>
            </div>
        </div>
    </div>
{% endblock %}

{% block footer %}
    {{ parent() }}
    {{ include('@UVDeskCoreFramework/Templates/attachment.html.twig') }}

    <script id=\"thread_list_item_tmp\" type=\"text/template\">
        <div class=\"uv-ticket-strip\">
            <span>
                <span class=\"timeago uv-margin-0\" data-timestamp=\"<%= timestamp %>\" title=\"<%= formatedCreatedAt %>\">
                    <%= formatedCreatedAt %>
                </span>
                - <%- fullname %>
                <span class=\"uv-ticket-strip-label\">
                    {{ 'replied'|trans }}
                </span>
            </span>
            <% if(cc || bcc) { %>
                <div class=\"uv-ticket-strip\">
                    <% if(cc) { %>
                        <span><span class=\"uv-ticket-strip-label\">{{ 'CC'|trans }} -</span> <%- cc %></span>
                    <% } if(bcc) { %>
                        <span><span class=\"uv-ticket-strip-label\">{{ 'BCC'|trans }} -</span> <%- bcc %></span>
                    <% } %>
                </div>
            <% } %>
        </div>
        <div class=\"uv-ticket-main-lt\">
            <% if(user && smallThumbnail != null) { %>
                <img src=\"{{ app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') }}<%= smallThumbnail %>\" />
            <% } else { %>
                <img src=\"<% if(userType == 'agent') { %> {{ asset(default_agent_image_path) }} <% } else { %> {{ asset(default_customer_image_path) }} <% } %>\" />
            <% } %>
        </div>
        <div class=\"uv-ticket-main-rt\">
            <span class=\"uv-ticket-member-name\">
                <%- fullname %>
            </span>
            <!-- Message Block -->
            <div class=\"message\">
                <%= reply %>
            </div>
            <!-- //Message Block -->

            <!-- Attachment Block -->
            <% if(attachments.length) { %>
                <div class=\"uv-ticket-uploads\">
                    <h4>{{ 'Uploaded Files'|trans }}</h4>
                    <div class=\"uv-ticket-uploads-strip uv-viewer-images\">
                        <% _.each(attachments, function(file) { %>
                            <a href=\"<%-file.downloadURL %>\" target =\"_blank\" class=\"uv-ticket-uploads-brick uv-no-pointer-events\" data-toggle=\"tooltip\" title=\"<%- file.name %>\">
                                <img src=\"<%-file.iconURL %>\" class=\"uv-auto-pointer-events\">
                            </a>
                        <% }) %>
                    </div>

                    <% if (attachments.length > 1) { %>
                        <div class=\"thread-attachments-zip pull-left\">
                            <div class=\"uv-upload-actions\">
                                {#<a href=\"#\"><span class=\"uv-icon-open-in-files\"></span>Open in Files</a>#}
                                <a href=\"{{ path('helpdesk_customer_download_ticket_attachment_zip') }}/<%= id %>\" target=\"_blank\"><span class=\"uv-icon-attachment\"></span> {{ 'Download (as .zip)'|trans }}</a>
                            </div>
                        </div>
                    <% } %>
                </div>
            <% } %>
            <!-- //Attachment Block -->
        </div>
    </script>

    <script type=\"text/javascript\">

        var ticketApp = {};
        \$(function () {
            
            var TicketModel = Backbone.Model.extend({
                idAttribute : \"id\",
                validation: {
                    'email': [{
                        required: true,
                        msg: '{{ \"This field is mandatory\"|trans }}'
                    },{
                        pattern: 'email',
                        msg: '{{ \"Please enter a valid email\"|trans }}'
                    }],
                },
            });

            var TicketView = Backbone.View.extend({
                el: \$('.uv-body'),
                stopDraftSaveFlag: 0,
                events: {
                    'click .collaborator-list .uv-btn-tag': 'removeCcCollaborator',
                    'change .uv-element-block.cc-bcc .cc-bcc-toggle': 'showCcBccBlock',
                    'keypress .uv-element-block.cc-bcc .uv-group-field': 'addCcBccInput',
                    'click .cc-bcc-list .uv-btn-tag, .to-list .uv-btn-tag': 'removeEmail',
                    'click .uv-dropdown.reply .uv-dropdown-list li:not(.confirm-close-ticket)': 'validateForm',
                    'click #reply-btn': 'validateForm',
                    'click #confirmed-close-ticket': 'confirmedAction',
                    'click .confirm-close-ticket': 'confirmClose',
                },
                confirmClose: function(e) {
                    \$('#confirm-ticket-close-modal').show();
                },
                confirmedAction: function(e) {
                    \$('#confirm-ticket-close-modal').hide();
                    this.validateForm(e);
                },
                loaderTemplate : _.template(\$(\"#loader-tmp\").html()),
                addCCCollaborators: function() {
                    if(collaboratorCollection.length) {
                        var collaboratorContainer = \$('.uv-element-block.collaborators');
                        collaboratorContainer.find('.uv-field-block').html('');
                        collaboratorContainer.show()
                        _.each(collaboratorCollection.models, function (item) {
                            var json = item.attributes;
                            collaboratorContainer.find('.uv-field-block').append(\"<span><input type='hidden' name='cccol[]' value='\" + json.email + \"'/><a class='uv-btn-tag' href='#'><span class='uv-icon-remove-dark-before'></span>\" + json.name + \"</a></span>\")
                        }, this);
                    }
                },
                removeCcCollaborator: function(e) {
                    e.preventDefault()
                    if (Backbone.\$(e.currentTarget).parent()[0]) {
                        Backbone.\$(e.currentTarget).parent()[0].removeChild(e.currentTarget);
                        var collaboratorContainer = \$('.uv-element-block.collaborators');
                    }

                    if(!collaboratorContainer.find('.uv-btn-tag').length)
                        collaboratorContainer.hide()
                },
                showCcBccBlock: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    var currentTab = currentElement.parents('.uv-tab-view');
                    if(currentElement.is(':checked')) {
                        currentTab.find('.uv-element-block.cc-bcc').find('.uv-field-block').show()
                    } else {
                        currentTab.find('.uv-element-block.cc-bcc').find('.uv-field-block').hide()
                        currentTab.find('.uv-element-block .cc-bcc-list').html('')
                    }
                },
                addCcBccInput: function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    var currentTab = inputElement.parents('.uv-tab-view');
                    var email = inputElement.val().trim();
                    if (e.which === 13 && email) {
                        e.preventDefault()
                        type = currentTab.find('.cc-bcc-select option:selected').text()
                        if(!this.model.preValidate({name: 'email', email: email})) {
                            inputName = \$('.cc-bcc-select').val()
                            inputElement.val('').trigger('input')
                            inputElement.removeClass('uv-dropdown-btn-active')
                            inputElement.siblings('.uv-dropdown-list').hide()
                            if(!currentTab.find(\".cc-bcc-list input[value='\" + email + \"'].\" + inputName).length) {
                                currentTab.find('.cc-bcc-list').append(\"<span><input type='hidden' name='\" + inputName + \"[]' value='\" + email + \"' class='\" + inputName + \"'/><a class=uv-btn-tag uv-lowercase' href='#'><span class='uv-icon-remove-dark-before'></span>\" + email + \" : <span class='uv-uppercase'>\" + type + \"</span></a></span>\")
                            }
                        }
                    }
                },
                removeEmail: function(e) {
                    e.preventDefault()
                    Backbone.\$(e.currentTarget).parent().remove();
                },
                validateForm : function(e) {
                    e.preventDefault();
                    var element = Backbone.\$(e.currentTarget);
                    form = \$('#ticket-form');
                    form.find('.reply-status').val(element.attr('data-id'));
                    form.find('.uv-field-message').remove()

                    var html = tinyMCE.get(\"reply-area\").getContent();
                    if(app.appView.htmlText(html) != '' || -1 != html.indexOf('<img')) {
                        this.stopDraftSaveFlag = 1;

\t\t\t\t\t\tapp.appView.showLoader();
                        tinyMCE.activeEditor.uploadImages(function(response) {
                            app.appView.hideLoader();

\t\t\t\t\t\t\tform.submit();
\t                        \$('.uv-dropdown.reply').find('.uv-btn').attr('disabled', 'disabled');
\t                        \$('#reply-btn,#confirmed-close-ticket').attr('disabled', 'disabled');
                        });
                    } else {
                        form.find('.uv-element-block-textarea').append(\"<span class='uv-field-message'>{{ 'This field is mandatory'|trans }}</span>\");
                    }
                }
            });

            var ThreadModel = Backbone.Model.extend({
                idAttribute : \"id\",
                defaults : {
                    hasTask : 0,
                    task: null
                }
            });

            var ThreadCollection = AppCollection.extend({
                model : ThreadModel,
                mode: \"infinite\",
                url : \"{{ path('helpdesk_customer_thread_collection_xhr', {'id': ticket.id}) }}\",
                parseRecords: function (resp, options) {
                    return resp.threads;
                },
                syncData : function() {
                    app.appView.showLoader()
                    this.fetch({
                        remove: false,
                        success: function(model, response) {
                            app.appView.hideLoader()
                            pagination.renderPagination(response.pagination);
                            threadCollection.state.currentPage = parseInt(response.pagination.current) + 1;
                        },
                        error: function (model, xhr, options) {
                            app.appView.hideLoader()
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                        }
                    });
                }
            });

            var ThreadItem = Backbone.View.extend({
                tagName : \"div\",
                className : \"uv-ticket-main\",
                template : _.template(\$(\"#thread_list_item_tmp\").html()),
                render : function () {
                    this.\$el.html(this.template(this.model.toJSON()));
                    this.\$el.addClass(\"thread-\" + this.model.id)

                    return this;
                }
            });

            var ThreadList = Backbone.View.extend({
                el : \$(\".thread-list\"),
                initialize : function() {
                    this.listenTo(threadCollection.fullCollection, \"add\", this.renderThread);
                },
                renderThread : function (item) {
                    var threadItem = new ThreadItem({
                        model: item
                    });
                    if(item.id < threadCollection.fullCollection.at(0).id)
                        this.\$el.prepend(threadItem.render().el);
                    else
                        this.\$el.append(threadItem.render().el);
                    threadItem.\$el.find('.helpdesk_blockquote').eq(0).before(\"<span class='uv-icon-ellipsis uv-ellipsis-mirror'></span>\").hide();
                    //emojifyRun();
                    this.\$el.find('img').removeAttr('crossorigin');
                    //viewerImages();
                    //convertForImages(this.\$el);
                    this.\$el.find('div.message a').attr('target', '_blank');
                    app.appView.relativeTime()
                }
            });

            var Pagination = Backbone.View.extend({
                el: \$('.uv-ticket-accordion'),
                events: {
                    'click .uv-ticket-count-stat': 'loadMore',
                },
                renderPagination: function(pagination) {
                    if(pagination.totalCount - pagination.lastItemNumber > 0 && pagination.lastItemNumber > 0) {
                        var remain = pagination.totalCount - pagination.lastItemNumber;
                        \$('.uv-ticket-count-stat').text(remain)
                        \$('.uv-ticket-accordion').removeClass('uv-ticket-accordion-expanded').removeClass('uv-ticket-accordion-no-count')
                    } else {
                        \$('.uv-ticket-accordion').addClass('uv-ticket-accordion-expanded').addClass('uv-ticket-accordion-no-count')
                    }
                },
                loadMore: function() {
                    threadCollection.syncData();
                }
            });

            //Collaborator Code starts here
            _.extend(Backbone.Model.prototype, Backbone.Validation.mixin);
            var CollaboratorModel = Backbone.Model.extend({
                idAttribute : \"id\",
                validation: {
                    'email': [{
                        required: true,
                        msg: '{{ \"This field is mandatory\"|trans }}'
                    },{
                        pattern: 'email',
                        msg: '{{ \"Please enter a valid email\"|trans }}'
                    }]
                },
                defaults : {
                    ticketId : {{ ticket.id }},
                    email: ''
                },
                parse: function (resp, options) {
                    return resp.collaborator;
                },
                urlRoot : \"{{ path('helpdesk_customer_update_ticket_collaborators_xhr') }}\"
            });

            var CollaboratorCollection = Backbone.PageableCollection.extend({
                model : CollaboratorModel
            });

            var CollaboratorItem = Backbone.View.extend({
                tagName : \"a\",
                className: 'uv-btn-tag',
                template : _.template(\"<span class='uv-tag'><span class='uv-icon-remove-dark-before'></span><%- name %></span>\"),
                events : {
                    'click .uv-tag' : 'removeItem'
                },
                render : function () {
                    this.\$el.html(this.template(this.model.toJSON()));
                    return this;
                },
                unrender : function(response) {
                    if(response.alertMessage != undefined) {
                        collaboratorListView.render();
                        app.appView.renderResponseAlert(response);
                    }
                },
                removeItem: function() {
                    self = this;
                    app.appView.showLoader();
                    this.model.destroy({
                        data : { 'ticketId' : this.model.attributes.ticketId },
                        success : function (model, response, options) {
                            app.appView.hideLoader();
                            self.\$el.remove();
                            self.unrender(response);
                        },
                        error: function (model, xhr, options) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        }
                    });
                }
            });

            var CollaboratorList = Backbone.View.extend({
                el : \$(\".collaborator-list-block\"),
                events : {
                    'keypress .uv-field' : 'addCollaborator',
                    'focusout .uv-field' : 'removeErrorClass',
                },
                initialize : function() {
                    //Backbone.Validation.bind(this);
                },
                render : function() {
                    this.\$el.find(\".collaborator-list\").html('');
                    var self = this;
                    collaboratorOptionHtml = '';
                    if(collaboratorCollection.length) {
                        _.each(collaboratorCollection.models, function (item) {
                            this.renderCollaborator(item);
                        }, this);
                    }
                    ticketView.addCCCollaborators()
                },
                renderCollaborator : function (item) {
                    var collaborator = new CollaboratorItem({
                        model: item
                    });
                    this.\$el.find('.collaborator-list').append(collaborator.render().el);
                },
                removeErrorClass: function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    inputElement.removeClass('uv-field-error');
                    inputElement.parents('.uv-element-block').find('.uv-field-message').remove()
                },
                addCollaborator : function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    inputElement.removeClass('uv-field-error');
                    inputElement.parents('.uv-element-block').find('.uv-field-message').remove()
                    var text = inputElement.val().trim();

                    if (e.which === 13 && text) {
                        this.model = new CollaboratorModel();
                        self = this;
                        this.model.set({email: text})

                        if(this.model.isValid(true)) {
                            app.appView.showLoader();
                            this.model.save({},{
                                success : function (model, response, options) {
                                    inputElement.val('');
                                    if(response.alertClass == \"success\") {
                                        collaboratorCollection.add(model);
                                    }
                                    self.render();
                                    app.appView.hideLoader();
                                    app.appView.renderResponseAlert(response);
                                },
                                error: function (model, xhr, options) {
                                    if(url = xhr.getResponseHeader('Location'))
                                        window.location = url;
                                    var response = warningResponse;
                                    if(xhr.responseJSON)
                                        response = xhr.responseJSON;

                                    app.appView.hideLoader();
                                    app.appView.renderResponseAlert(response);
                                }
                            });
                        } else {
                            inputElement.addClass('uv-field-error');
                            if(text)
                                inputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>{{ 'Email address is invalid'|trans }}</span>\");
                        }
                    }
                }
            });
            //Collaborator Code ends here

            ticketModel = new TicketModel({
                id : \"{{ ticket.id }}\",
            });

            ticketApp.ticketView = ticketView = new TicketView({
                model: ticketModel
            });

            var threadCollection = new ThreadCollection();
\t\t    var threadList = new ThreadList();
            var pagination = new Pagination();
            threadCollection.syncData();

            {% if ticket.customer == app.user %}
                var collaboratorCollection = new CollaboratorCollection(\$.parseJSON('{{ ticket_service.getTicketCollaborators(ticket.id)|json_encode|raw }}'));
                var collaboratorListView = new CollaboratorList();
                collaboratorListView.render();
            {% endif %}
        });
    </script>

    {{ include(\"@UVDeskCoreFramework/Templates/tinyMCE.html.twig\") }}

\t<script>
\t\tsfTinyMce.init({
            height: '250px',
\t\t\tselector : '.uv-ticket-reply textarea',
\t\t\timages_upload_url: \"{{ path('helpdesk_customer_upload_thread_encoded_image', {ticketId: app.request.get('id')}) }}\",
            setup: function(editor) {
            }
\t\t});
\t</script>
{% endblock %}
", "@UVDeskSupportCenter/Knowledgebase/ticketView.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Knowledgebase/ticketView.html.twig");
    }
}
