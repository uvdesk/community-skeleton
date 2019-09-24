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

/* @UVDeskMailbox/manageConfigurations.html.twig */
class __TwigTemplate_856d738b4a22d6463cd37930d475b3131f1d4a03d636f4d6a5ed249f661b9093 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'pageContent' => [$this, 'block_pageContent'],
            'footer' => [$this, 'block_footer'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "@UVDeskCoreFramework//Templates//layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskMailbox/manageConfigurations.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskMailbox/manageConfigurations.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskMailbox/manageConfigurations.html.twig", 1);
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

        echo " 
\t";
        // line 4
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Mailbox Settings"), "html", null, true);
        echo "
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 7
    public function block_pageContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        // line 8
        echo "\t<style>
\t\t.section-heading {
\t\t\tfont-size: 16px;
\t\t\tmargin: 0px;
\t\t\tline-height: 1.4em;
\t\t}

\t\t.section-description {
\t\t\tcolor: #6F6F6F;
\t\t\tmargin-top: unset !important;
\t\t\tmargin-bottom: 20px;
\t\t\tline-height: 1.4em;
\t\t}

\t\t.uv-element-block .uv-field-message {
\t\t\tfont-style: normal;
\t\t\tmargin: 0px 0px 20px 0px;
\t\t}
\t</style>

\t<div class=\"uv-inner-section\">
\t\t";
        // line 30
        echo "\t\t";
        $context["asideTemplate"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\AsideTemplate";
        // line 31
        echo "\t\t";
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Settings";
        // line 32
        echo "
\t\t";
        // line 33
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 33, $this->source); })()), "getRegisteredComponent", [0 => (isset($context["asideTemplate"]) || array_key_exists("asideTemplate", $context) ? $context["asideTemplate"] : (function () { throw new RuntimeError('Variable "asideTemplate" does not exist.', 33, $this->source); })())], "method", false, false, false, 33), "renderSidebar", [0 => (isset($context["asideSidebarReference"]) || array_key_exists("asideSidebarReference", $context) ? $context["asideSidebarReference"] : (function () { throw new RuntimeError('Variable "asideSidebarReference" does not exist.', 33, $this->source); })())], "method", false, false, false, 33);
        echo "

\t\t<div class=\"uv-view ";
        // line 35
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 35, $this->source); })()), "request", [], "any", false, false, false, 35), "cookies", [], "any", false, false, false, 35) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 35, $this->source); })()), "request", [], "any", false, false, false, 35), "cookies", [], "any", false, false, false, 35), "get", [0 => "uv-asideView"], "method", false, false, false, 35))) {
            echo "uv-aside-view";
        }
        echo "\">
\t\t\t<h1>";
        // line 36
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("New Mailbox"), "html", null, true);
        echo "</h1>

            <div class=\"uv-hr\"></div>
\t\t\t
\t\t\t<form method=\"post\" action=\"\" id=\"mailbox-settings-view\">
\t\t\t\t";
        // line 42
        echo "\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 43
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("ID"), "html", null, true);
        echo ":</label>

\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t";
        // line 46
        if (((isset($context["mailbox"]) || array_key_exists("mailbox", $context)) &&  !twig_test_empty(twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 46, $this->source); })()), "id", [], "any", false, false, false, 46)))) {
            // line 47
            echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"id\" class=\"uv-field\" value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 47, $this->source); })()), "id", [], "any", false, false, false, 47), "html", null, true);
            echo "\" placeholder=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Mailbox ID - Leave blank to automatically create id"), "html", null, true);
            echo "\" />
\t\t\t\t\t\t";
        } else {
            // line 49
            echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"id\" class=\"uv-field\" value=\"\" placeholder=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Mailbox ID - Leave blank to automatically create id"), "html", null, true);
            echo "\" />
\t\t\t\t\t\t";
        }
        // line 51
        echo "\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t";
        // line 55
        echo "\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 56
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Name"), "html", null, true);
        echo ":</label>

\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t";
        // line 59
        if (((isset($context["mailbox"]) || array_key_exists("mailbox", $context)) &&  !twig_test_empty(twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 59, $this->source); })()), "name", [], "any", false, false, false, 59)))) {
            // line 60
            echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"name\" class=\"uv-field\" value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 60, $this->source); })()), "name", [], "any", false, false, false, 60), "html", null, true);
            echo "\" placeholder=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Mailbox Name"), "html", null, true);
            echo "\" />
\t\t\t\t\t\t";
        } else {
            // line 62
            echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"name\" class=\"uv-field\" value=\"\" placeholder=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Mailbox Name"), "html", null, true);
            echo "\" />
\t\t\t\t\t\t";
        }
        // line 64
        echo "\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t";
        // line 68
        echo "\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label>
\t\t\t\t\t\t<div class=\"uv-checkbox\">
\t\t\t\t\t\t\t";
        // line 71
        if ((twig_get_attribute($this->env, $this->source, ($context["mailbox"] ?? null), "isEnabled", [], "any", true, true, false, 71) && (twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 71, $this->source); })()), "isEnabled", [], "any", false, false, false, 71) == true))) {
            // line 72
            echo "\t\t\t\t\t\t\t\t<input name=\"isEnabled\" type=\"checkbox\" checked=\"\">
\t\t\t\t\t\t\t";
        } else {
            // line 74
            echo "\t\t\t\t\t\t\t\t<input name=\"isEnabled\" type=\"checkbox\">
\t\t\t\t\t\t\t";
        }
        // line 76
        echo "
\t\t\t\t\t\t\t<span class=\"uv-checkbox-view\"></span>
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<span class=\"uv-checkbox-label\">";
        // line 80
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Enable Mailbox"), "html", null, true);
        echo "</span>
\t\t\t\t\t</label>
\t\t\t\t</div>

\t\t\t\t<div class=\"uv-hr\"></div>

\t\t\t\t";
        // line 87
        echo "\t\t\t\t<h3 class=\"section-heading\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Incoming Mail (IMAP) Server"), "html", null, true);
        echo "</h3>
\t\t\t\t<p class=\"section-description\">";
        // line 88
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Configure your imap settings which will be used to fetch emails from your mailbox."), "html", null, true);
        echo "</p>

\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 91
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Transport"), "html", null, true);
        echo ":</label>

\t\t\t\t\t";
        // line 93
        if ((isset($context["mailbox"]) || array_key_exists("mailbox", $context))) {
            // line 94
            echo "\t\t\t\t\t\t<select name=\"imap[transport]\" id=\"cta-mailbox-imap-transport\" class=\"uv-select\">
\t\t\t\t\t\t\t<option value=\"custom\" ";
            // line 95
            if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 95, $this->source); })()), "imapConfiguration", [], "any", false, false, false, 95), "code", [], "any", false, false, false, 95) == "custom")) {
                echo "selected";
            }
            echo ">IMAP</option>
\t\t\t\t\t\t\t<option value=\"gmail\" ";
            // line 96
            if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 96, $this->source); })()), "imapConfiguration", [], "any", false, false, false, 96), "code", [], "any", false, false, false, 96) == "gmail")) {
                echo "selected";
            }
            echo ">Gmail</option>
\t\t\t\t\t\t\t<option value=\"yahoo\" ";
            // line 97
            if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 97, $this->source); })()), "imapConfiguration", [], "any", false, false, false, 97), "code", [], "any", false, false, false, 97) == "yahoo")) {
                echo "selected";
            }
            echo ">Yahoo Mail</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t";
        } else {
            // line 100
            echo "\t\t\t\t\t\t<select name=\"imap[transport]\" id=\"cta-mailbox-imap-transport\" class=\"uv-select\">
\t\t\t\t\t\t\t<option value=\"custom\" selected>";
            // line 101
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("IMAP"), "html", null, true);
            echo "</option>
\t\t\t\t\t\t\t<option value=\"gmail\">";
            // line 102
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Gmail"), "html", null, true);
            echo "</option>
\t\t\t\t\t\t\t<option value=\"yahoo\">";
            // line 103
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Yahoo"), "html", null, true);
            echo "</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t";
        }
        // line 106
        echo "\t\t\t\t</div>

\t\t\t\t<div class=\"imap-setting-references\"></div>

\t\t\t\t<div class=\"uv-hr\"></div>

\t\t\t\t";
        // line 113
        echo "\t\t\t\t<h3 class=\"section-heading\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Outgoing Mail (SMTP) Server"), "html", null, true);
        echo "</h3>
\t\t\t\t<p class=\"section-description\">";
        // line 114
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Select a valid Swift Mailer configuration which will be used to send emails through your mailbox."), "html", null, true);
        echo "</p>

\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 117
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Swift Mailer ID"), "html", null, true);
        echo ":</label>

\t\t\t\t\t";
        // line 119
        if (((isset($context["swiftmailerConfigurations"]) || array_key_exists("swiftmailerConfigurations", $context)) &&  !twig_test_empty((isset($context["swiftmailerConfigurations"]) || array_key_exists("swiftmailerConfigurations", $context) ? $context["swiftmailerConfigurations"] : (function () { throw new RuntimeError('Variable "swiftmailerConfigurations" does not exist.', 119, $this->source); })())))) {
            // line 120
            echo "\t\t\t\t\t\t<select name=\"swiftmailer_id\" class=\"uv-select\">
\t\t\t\t\t\t\t<option value=\"none\">";
            // line 121
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("None Selected"), "html", null, true);
            echo "</option>
\t\t\t\t\t\t\t";
            // line 122
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["swiftmailerConfigurations"]) || array_key_exists("swiftmailerConfigurations", $context) ? $context["swiftmailerConfigurations"] : (function () { throw new RuntimeError('Variable "swiftmailerConfigurations" does not exist.', 122, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["configuration"]) {
                // line 123
                echo "\t\t\t\t\t\t\t\t";
                if (((isset($context["mailbox"]) || array_key_exists("mailbox", $context)) && (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 123, $this->source); })()), "swiftmailerConfiguration", [], "any", false, false, false, 123), "id", [], "any", false, false, false, 123) == twig_get_attribute($this->env, $this->source, $context["configuration"], "id", [], "any", false, false, false, 123)))) {
                    // line 124
                    echo "\t\t\t\t\t\t\t\t\t<option value=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["configuration"], "id", [], "any", false, false, false, 124), "html", null, true);
                    echo "\" selected>";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["configuration"], "id", [], "any", false, false, false, 124), "html", null, true);
                    echo "</option>
\t\t\t\t\t\t\t\t";
                } else {
                    // line 126
                    echo "\t\t\t\t\t\t\t\t\t<option value=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["configuration"], "id", [], "any", false, false, false, 126), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["configuration"], "id", [], "any", false, false, false, 126), "html", null, true);
                    echo "</option>
\t\t\t\t\t\t\t\t";
                }
                // line 128
                echo "\t\t\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['configuration'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 129
            echo "\t\t\t\t\t\t</select>
\t\t\t\t\t";
        } else {
            // line 131
            echo "\t\t\t\t\t\t<select name=\"swiftmailer_id\" class=\"uv-select\">
\t\t\t\t\t\t\t<option value=\"none\">";
            // line 132
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("None Selected"), "html", null, true);
            echo "</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t";
        }
        // line 135
        echo "\t\t\t\t</div>

\t\t\t\t<div class=\"uv-hr\"></div>

\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"";
        // line 139
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Create Mailbox"), "html", null, true);
        echo "\" type=\"submit\">
\t\t\t</form>
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 145
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 146
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "

    <script id=\"imap_conf_template_predefined\" type=\"text/template\">
        <div class=\"uv-element-block\">
\t\t\t<label class=\"uv-field-label\">";
        // line 150
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Username"), "html", null, true);
        echo ":</label>
\t\t\t
\t\t\t<div class=\"uv-field-block\">
\t\t\t\t<% if (typeof(username) != 'undefined' && username != '') { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[username]\" value=\"<%- username %>\" placeholder=\"";
        // line 154
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email address"), "html", null, true);
        echo "\">
\t\t\t\t<% } else { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[username]\" value=\"\" placeholder=\"";
        // line 156
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email address"), "html", null, true);
        echo "\">
                <% } %>
\t\t\t</div>
\t\t</div>
\t\t
\t\t<div class=\"uv-element-block\">
\t\t\t<label class=\"uv-field-label\">";
        // line 162
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Password"), "html", null, true);
        echo ":</label>

\t\t\t<div class=\"uv-field-block\">
\t\t\t\t<input class=\"uv-field\" type=\"password\" name=\"imap[password]\" placeholder=\"";
        // line 165
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Associated Password"), "html", null, true);
        echo "\">
\t\t\t</div>
\t\t</div>
\t</script>

    <script id=\"imap_conf_template_custom\" type=\"text/template\">
        <div class=\"uv-element-block\">
\t\t\t<label class=\"uv-field-label\">";
        // line 172
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Host"), "html", null, true);
        echo ":</label>
\t\t\t
\t\t\t<div class=\"uv-field-block\">
\t\t\t\t<% if (typeof(host) != 'undefined' && host != '') { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[host]\" value=\"<%- host %>\" placeholder=\"<%- host %>\">
\t\t\t\t<% } else { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[host]\" value=\"\" placeholder=\"";
        // line 178
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("IMAP Host"), "html", null, true);
        echo "\">
                <% } %>
\t\t\t</div>
\t\t</div>

\t\t<div class=\"uv-element-block\">
\t\t\t<label class=\"uv-field-label\">";
        // line 184
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email"), "html", null, true);
        echo ":</label>
\t\t\t
\t\t\t<div class=\"uv-field-block\">
\t\t\t\t<% if (typeof(username) != 'undefined' && username != '') { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[username]\" value=\"<%- username %>\" placeholder=\"";
        // line 188
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email address"), "html", null, true);
        echo "\">
\t\t\t\t<% } else { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[username]\" value=\"\" placeholder=\"";
        // line 190
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email address"), "html", null, true);
        echo "\">
                <% } %>
\t\t\t</div>
\t\t</div>
\t\t
\t\t<div class=\"uv-element-block\">
\t\t\t<label class=\"uv-field-label\">";
        // line 196
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Password"), "html", null, true);
        echo ":</label>

\t\t\t<div class=\"uv-field-block\">
\t\t\t\t<input class=\"uv-field\" type=\"password\" name=\"imap[password]\" placeholder=\"";
        // line 199
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Associated Password"), "html", null, true);
        echo "\">
\t\t\t</div>
\t\t</div>
\t</script>

\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar MailboxConfigurationModel = Backbone.Model.extend({
                idAttribute: \"id\",
                validation: {
\t\t\t\t\tname: function(value) {
\t\t\t\t\t\tif (value == undefined || value == '') {
\t\t\t\t\t\t\treturn \"";
        // line 211
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please specify a valid name for your mailbox."), "html", null, true);
        echo "\";
\t\t\t\t\t\t}
                    },
\t\t\t\t\tswiftmailer_id: function(value) {
\t\t\t\t\t\tif (value == undefined || value == '' || value == 'none') {
\t\t\t\t\t\t\treturn \"";
        // line 216
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please select a valid swift-mailer configuration."), "html", null, true);
        echo "\";
\t\t\t\t\t\t}
                    },
\t\t\t\t\t\"imap[host]\": function(value) {
                        if ('custom' == this.get('transport') || 'imap' == this.get('transport')) {
                            if (value == undefined || value == '') {
                                return \"";
        // line 222
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please specify a valid host address."), "html", null, true);
        echo "\";
                            }
                        }
                    },
                    \"imap[username]\": [
                        {
                            required: true,
                            msg: \"";
        // line 229
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please specify a valid email address."), "html", null, true);
        echo "\"
                        },
                        {
                            pattern: /^([\\w-\\.]+)@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([\\w-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)\$/,
                            msg: \"";
        // line 233
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please specify a valid email address."), "html", null, true);
        echo "\"
                        }
                    ],
                    \"imap[password]\": function(value) {
                        if (value == undefined || value == '') {
                            return \"";
        // line 238
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please enter the associated account password."), "html", null, true);
        echo "\";
                        }
                    }
\t\t\t\t}
\t\t\t});

\t\t\tvar MailboxConfigurationView = Backbone.View.extend({
                imap_conf_template_custom: _.template(\$(\"#imap_conf_template_custom\").html()),
                imap_conf_template_predefined: _.template(\$(\"#imap_conf_template_predefined\").html()),
\t\t\t\tevents: {
                    'change #cta-mailbox-imap-transport': 'changeImapTransportType',
\t\t\t\t\t'click .uv-btn' : \"validateSubmission\",
\t\t\t\t},
\t\t\t\tinitialize: function() {
                    Backbone.Validation.bind(this);
                    this.renderTransportConfigurations();
\t\t\t\t},
                changeImapTransportType: function(e) {
                    if (true) {
                        this.model.set('transport', \$(e.target).val());
                    }

                    this.renderTransportConfigurations();
                },
                renderTransportConfigurations: function() {
                    switch (this.model.get('transport')) {
                        case 'custom':
                            \$('.imap-setting-references').html(this.imap_conf_template_custom(this.model.attributes));
                            break;
                        case 'gmail':
                            \$('.imap-setting-references').html(this.imap_conf_template_predefined(this.model.attributes));
                            break;
                        case 'yahoo':
                            \$('.imap-setting-references').html(this.imap_conf_template_predefined(this.model.attributes));
                            break;
                        default:
                            break;
                    }
                },
                validateSubmission: function(e) {
                    e.preventDefault();
                    this.model.set(this.\$el.serializeObject());

\t\t\t        if (this.model.isValid(true)) {
\t\t\t            this.\$el.submit();
\t\t\t        }
                }
\t\t\t});

            ";
        // line 287
        if ((isset($context["mailbox"]) || array_key_exists("mailbox", $context))) {
            // line 288
            echo "                new MailboxConfigurationView({
                    el: \$(\"#mailbox-settings-view\"),
                    model: new MailboxConfigurationModel({
\t\t\t\t\t\ttransport: \"";
            // line 291
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 291, $this->source); })()), "imapConfiguration", [], "any", false, false, false, 291), "code", [], "any", false, false, false, 291), "html", null, true);
            echo "\",
\t\t\t\t\t\thost: \"";
            // line 292
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 292, $this->source); })()), "imapConfiguration", [], "any", false, false, false, 292), "host", [], "any", false, false, false, 292), "html", null, true);
            echo "\",
\t\t\t\t\t\tusername: \"";
            // line 293
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 293, $this->source); })()), "imapConfiguration", [], "any", false, false, false, 293), "username", [], "any", false, false, false, 293), "html", null, true);
            echo "\",
\t\t\t\t\t})
                });
            ";
        } else {
            // line 297
            echo "                new MailboxConfigurationView({
                    el: \$(\"#mailbox-settings-view\"),
                    model: new MailboxConfigurationModel({ transport: 'custom' })
                });
            ";
        }
        // line 302
        echo "\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskMailbox/manageConfigurations.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  627 => 302,  620 => 297,  613 => 293,  609 => 292,  605 => 291,  600 => 288,  598 => 287,  546 => 238,  538 => 233,  531 => 229,  521 => 222,  512 => 216,  504 => 211,  489 => 199,  483 => 196,  474 => 190,  469 => 188,  462 => 184,  453 => 178,  444 => 172,  434 => 165,  428 => 162,  419 => 156,  414 => 154,  407 => 150,  399 => 146,  389 => 145,  374 => 139,  368 => 135,  362 => 132,  359 => 131,  355 => 129,  349 => 128,  341 => 126,  333 => 124,  330 => 123,  326 => 122,  322 => 121,  319 => 120,  317 => 119,  312 => 117,  306 => 114,  301 => 113,  293 => 106,  287 => 103,  283 => 102,  279 => 101,  276 => 100,  268 => 97,  262 => 96,  256 => 95,  253 => 94,  251 => 93,  246 => 91,  240 => 88,  235 => 87,  226 => 80,  220 => 76,  216 => 74,  212 => 72,  210 => 71,  205 => 68,  200 => 64,  194 => 62,  186 => 60,  184 => 59,  178 => 56,  175 => 55,  170 => 51,  164 => 49,  156 => 47,  154 => 46,  148 => 43,  145 => 42,  137 => 36,  131 => 35,  126 => 33,  123 => 32,  120 => 31,  117 => 30,  94 => 8,  84 => 7,  72 => 4,  60 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %} 
\t{{ 'Mailbox Settings'|trans }}
{% endblock %}

{% block pageContent %}
\t<style>
\t\t.section-heading {
\t\t\tfont-size: 16px;
\t\t\tmargin: 0px;
\t\t\tline-height: 1.4em;
\t\t}

\t\t.section-description {
\t\t\tcolor: #6F6F6F;
\t\t\tmargin-top: unset !important;
\t\t\tmargin-bottom: 20px;
\t\t\tline-height: 1.4em;
\t\t}

\t\t.uv-element-block .uv-field-message {
\t\t\tfont-style: normal;
\t\t\tmargin: 0px 0px 20px 0px;
\t\t}
\t</style>

\t<div class=\"uv-inner-section\">
\t\t{# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Settings' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}

\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
\t\t\t<h1>{{'New Mailbox'|trans}}</h1>

            <div class=\"uv-hr\"></div>
\t\t\t
\t\t\t<form method=\"post\" action=\"\" id=\"mailbox-settings-view\">
\t\t\t\t{# Mailer Id #}
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{'ID'|trans}}:</label>

\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t{% if mailbox is defined and mailbox.id is not empty %}
\t\t\t\t\t\t\t<input type=\"text\" name=\"id\" class=\"uv-field\" value=\"{{ mailbox.id }}\" placeholder=\"{{'Mailbox ID - Leave blank to automatically create id'|trans}}\" />
\t\t\t\t\t\t{% else %}
\t\t\t\t\t\t\t<input type=\"text\" name=\"id\" class=\"uv-field\" value=\"\" placeholder=\"{{'Mailbox ID - Leave blank to automatically create id'|trans}}\" />
\t\t\t\t\t\t{% endif %}
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t{# Mailer Name #}
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{'Name'|trans}}:</label>

\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t{% if mailbox is defined and mailbox.name is not empty %}
\t\t\t\t\t\t\t<input type=\"text\" name=\"name\" class=\"uv-field\" value=\"{{ mailbox.name }}\" placeholder=\"{{'Mailbox Name'|trans}}\" />
\t\t\t\t\t\t{% else %}
\t\t\t\t\t\t\t<input type=\"text\" name=\"name\" class=\"uv-field\" value=\"\" placeholder=\"{{'Mailbox Name'|trans}}\" />
\t\t\t\t\t\t{% endif %}
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t{# Status #}
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label>
\t\t\t\t\t\t<div class=\"uv-checkbox\">
\t\t\t\t\t\t\t{% if mailbox.isEnabled is defined and mailbox.isEnabled == true %}
\t\t\t\t\t\t\t\t<input name=\"isEnabled\" type=\"checkbox\" checked=\"\">
\t\t\t\t\t\t\t{% else %}
\t\t\t\t\t\t\t\t<input name=\"isEnabled\" type=\"checkbox\">
\t\t\t\t\t\t\t{% endif %}

\t\t\t\t\t\t\t<span class=\"uv-checkbox-view\"></span>
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<span class=\"uv-checkbox-label\">{{'Enable Mailbox'|trans}}</span>
\t\t\t\t\t</label>
\t\t\t\t</div>

\t\t\t\t<div class=\"uv-hr\"></div>

\t\t\t\t{# IMAP Settings #}
\t\t\t\t<h3 class=\"section-heading\">{{\"Incoming Mail (IMAP) Server\"|trans}}</h3>
\t\t\t\t<p class=\"section-description\">{{'Configure your imap settings which will be used to fetch emails from your mailbox.'|trans}}</p>

\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{'Transport'|trans}}:</label>

\t\t\t\t\t{% if mailbox is defined %}
\t\t\t\t\t\t<select name=\"imap[transport]\" id=\"cta-mailbox-imap-transport\" class=\"uv-select\">
\t\t\t\t\t\t\t<option value=\"custom\" {% if mailbox.imapConfiguration.code == 'custom' %}selected{% endif %}>IMAP</option>
\t\t\t\t\t\t\t<option value=\"gmail\" {% if mailbox.imapConfiguration.code == 'gmail' %}selected{% endif %}>Gmail</option>
\t\t\t\t\t\t\t<option value=\"yahoo\" {% if mailbox.imapConfiguration.code == 'yahoo' %}selected{% endif %}>Yahoo Mail</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t{% else %}
\t\t\t\t\t\t<select name=\"imap[transport]\" id=\"cta-mailbox-imap-transport\" class=\"uv-select\">
\t\t\t\t\t\t\t<option value=\"custom\" selected>{{'IMAP'|trans}}</option>
\t\t\t\t\t\t\t<option value=\"gmail\">{{'Gmail'|trans}}</option>
\t\t\t\t\t\t\t<option value=\"yahoo\">{{'Yahoo'|trans}}</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t{% endif %}
\t\t\t\t</div>

\t\t\t\t<div class=\"imap-setting-references\"></div>

\t\t\t\t<div class=\"uv-hr\"></div>

\t\t\t\t{# SwiftMailer Settings #}
\t\t\t\t<h3 class=\"section-heading\">{{'Outgoing Mail (SMTP) Server'|trans}}</h3>
\t\t\t\t<p class=\"section-description\">{{'Select a valid Swift Mailer configuration which will be used to send emails through your mailbox.'|trans}}</p>

\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{'Swift Mailer ID'|trans}}:</label>

\t\t\t\t\t{% if swiftmailerConfigurations is defined and swiftmailerConfigurations is not empty %}
\t\t\t\t\t\t<select name=\"swiftmailer_id\" class=\"uv-select\">
\t\t\t\t\t\t\t<option value=\"none\">{{\"None Selected\"|trans}}</option>
\t\t\t\t\t\t\t{% for configuration in swiftmailerConfigurations %}
\t\t\t\t\t\t\t\t{% if mailbox is defined and mailbox.swiftmailerConfiguration.id == configuration.id %}
\t\t\t\t\t\t\t\t\t<option value=\"{{ configuration.id }}\" selected>{{ configuration.id }}</option>
\t\t\t\t\t\t\t\t{% else %}
\t\t\t\t\t\t\t\t\t<option value=\"{{ configuration.id }}\">{{ configuration.id }}</option>
\t\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t</select>
\t\t\t\t\t{% else %}
\t\t\t\t\t\t<select name=\"swiftmailer_id\" class=\"uv-select\">
\t\t\t\t\t\t\t<option value=\"none\">{{\"None Selected\"|trans}}</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t{% endif %}
\t\t\t\t</div>

\t\t\t\t<div class=\"uv-hr\"></div>

\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"{{ 'Create Mailbox'|trans }}\" type=\"submit\">
\t\t\t</form>
\t\t</div>
\t</div>
{% endblock %}

{% block footer %}
\t{{ parent() }}

    <script id=\"imap_conf_template_predefined\" type=\"text/template\">
        <div class=\"uv-element-block\">
\t\t\t<label class=\"uv-field-label\">{{\"Username\"|trans}}:</label>
\t\t\t
\t\t\t<div class=\"uv-field-block\">
\t\t\t\t<% if (typeof(username) != 'undefined' && username != '') { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[username]\" value=\"<%- username %>\" placeholder=\"{{'Email address'|trans}}\">
\t\t\t\t<% } else { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[username]\" value=\"\" placeholder=\"{{'Email address'|trans}}\">
                <% } %>
\t\t\t</div>
\t\t</div>
\t\t
\t\t<div class=\"uv-element-block\">
\t\t\t<label class=\"uv-field-label\">{{'Password'|trans}}:</label>

\t\t\t<div class=\"uv-field-block\">
\t\t\t\t<input class=\"uv-field\" type=\"password\" name=\"imap[password]\" placeholder=\"{{'Associated Password'|trans}}\">
\t\t\t</div>
\t\t</div>
\t</script>

    <script id=\"imap_conf_template_custom\" type=\"text/template\">
        <div class=\"uv-element-block\">
\t\t\t<label class=\"uv-field-label\">{{'Host'|trans}}:</label>
\t\t\t
\t\t\t<div class=\"uv-field-block\">
\t\t\t\t<% if (typeof(host) != 'undefined' && host != '') { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[host]\" value=\"<%- host %>\" placeholder=\"<%- host %>\">
\t\t\t\t<% } else { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[host]\" value=\"\" placeholder=\"{{'IMAP Host'|trans}}\">
                <% } %>
\t\t\t</div>
\t\t</div>

\t\t<div class=\"uv-element-block\">
\t\t\t<label class=\"uv-field-label\">{{\"Email\"|trans}}:</label>
\t\t\t
\t\t\t<div class=\"uv-field-block\">
\t\t\t\t<% if (typeof(username) != 'undefined' && username != '') { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[username]\" value=\"<%- username %>\" placeholder=\"{{'Email address'|trans}}\">
\t\t\t\t<% } else { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[username]\" value=\"\" placeholder=\"{{'Email address'|trans}}\">
                <% } %>
\t\t\t</div>
\t\t</div>
\t\t
\t\t<div class=\"uv-element-block\">
\t\t\t<label class=\"uv-field-label\">{{'Password'|trans}}:</label>

\t\t\t<div class=\"uv-field-block\">
\t\t\t\t<input class=\"uv-field\" type=\"password\" name=\"imap[password]\" placeholder=\"{{'Associated Password'|trans}}\">
\t\t\t</div>
\t\t</div>
\t</script>

\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar MailboxConfigurationModel = Backbone.Model.extend({
                idAttribute: \"id\",
                validation: {
\t\t\t\t\tname: function(value) {
\t\t\t\t\t\tif (value == undefined || value == '') {
\t\t\t\t\t\t\treturn \"{{'Please specify a valid name for your mailbox.'|trans}}\";
\t\t\t\t\t\t}
                    },
\t\t\t\t\tswiftmailer_id: function(value) {
\t\t\t\t\t\tif (value == undefined || value == '' || value == 'none') {
\t\t\t\t\t\t\treturn \"{{'Please select a valid swift-mailer configuration.'|trans}}\";
\t\t\t\t\t\t}
                    },
\t\t\t\t\t\"imap[host]\": function(value) {
                        if ('custom' == this.get('transport') || 'imap' == this.get('transport')) {
                            if (value == undefined || value == '') {
                                return \"{{'Please specify a valid host address.'|trans}}\";
                            }
                        }
                    },
                    \"imap[username]\": [
                        {
                            required: true,
                            msg: \"{{'Please specify a valid email address.'|trans}}\"
                        },
                        {
                            pattern: /^([\\w-\\.]+)@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([\\w-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)\$/,
                            msg: \"{{'Please specify a valid email address.'|trans}}\"
                        }
                    ],
                    \"imap[password]\": function(value) {
                        if (value == undefined || value == '') {
                            return \"{{'Please enter the associated account password.'|trans}}\";
                        }
                    }
\t\t\t\t}
\t\t\t});

\t\t\tvar MailboxConfigurationView = Backbone.View.extend({
                imap_conf_template_custom: _.template(\$(\"#imap_conf_template_custom\").html()),
                imap_conf_template_predefined: _.template(\$(\"#imap_conf_template_predefined\").html()),
\t\t\t\tevents: {
                    'change #cta-mailbox-imap-transport': 'changeImapTransportType',
\t\t\t\t\t'click .uv-btn' : \"validateSubmission\",
\t\t\t\t},
\t\t\t\tinitialize: function() {
                    Backbone.Validation.bind(this);
                    this.renderTransportConfigurations();
\t\t\t\t},
                changeImapTransportType: function(e) {
                    if (true) {
                        this.model.set('transport', \$(e.target).val());
                    }

                    this.renderTransportConfigurations();
                },
                renderTransportConfigurations: function() {
                    switch (this.model.get('transport')) {
                        case 'custom':
                            \$('.imap-setting-references').html(this.imap_conf_template_custom(this.model.attributes));
                            break;
                        case 'gmail':
                            \$('.imap-setting-references').html(this.imap_conf_template_predefined(this.model.attributes));
                            break;
                        case 'yahoo':
                            \$('.imap-setting-references').html(this.imap_conf_template_predefined(this.model.attributes));
                            break;
                        default:
                            break;
                    }
                },
                validateSubmission: function(e) {
                    e.preventDefault();
                    this.model.set(this.\$el.serializeObject());

\t\t\t        if (this.model.isValid(true)) {
\t\t\t            this.\$el.submit();
\t\t\t        }
                }
\t\t\t});

            {% if mailbox is defined %}
                new MailboxConfigurationView({
                    el: \$(\"#mailbox-settings-view\"),
                    model: new MailboxConfigurationModel({
\t\t\t\t\t\ttransport: \"{{ mailbox.imapConfiguration.code }}\",
\t\t\t\t\t\thost: \"{{ mailbox.imapConfiguration.host }}\",
\t\t\t\t\t\tusername: \"{{ mailbox.imapConfiguration.username }}\",
\t\t\t\t\t})
                });
            {% else %}
                new MailboxConfigurationView({
                    el: \$(\"#mailbox-settings-view\"),
                    model: new MailboxConfigurationModel({ transport: 'custom' })
                });
            {% endif %}
\t\t});
\t</script>
{% endblock %}", "@UVDeskMailbox/manageConfigurations.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/mailbox-component/Resources/views/manageConfigurations.html.twig");
    }
}
