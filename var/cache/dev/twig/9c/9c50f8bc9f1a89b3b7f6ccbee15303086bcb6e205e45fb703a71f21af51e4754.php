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

/* @UVDeskMailbox//manageConfigurations.html.twig */
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskMailbox//manageConfigurations.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskMailbox//manageConfigurations.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskMailbox//manageConfigurations.html.twig", 1);
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
\t\t\t";
        // line 36
        if (((isset($context["mailbox"]) || array_key_exists("mailbox", $context)) &&  !twig_test_empty(twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 36, $this->source); })()), "id", [], "any", false, false, false, 36)))) {
            // line 37
            echo "\t\t\t\t<h1>";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Update Mailbox"), "html", null, true);
            echo "</h1>
\t\t\t";
        } else {
            // line 39
            echo "\t\t\t\t<h1>";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("New Mailbox"), "html", null, true);
            echo "</h1>
\t\t\t";
        }
        // line 41
        echo "
            <div class=\"uv-hr\"></div>
\t\t\t
\t\t\t<form method=\"post\" action=\"\" id=\"mailbox-settings-view\">
\t\t\t\t";
        // line 46
        echo "\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 47
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("ID"), "html", null, true);
        echo ":</label>

\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t";
        // line 50
        if (((isset($context["mailbox"]) || array_key_exists("mailbox", $context)) &&  !twig_test_empty(twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 50, $this->source); })()), "id", [], "any", false, false, false, 50)))) {
            // line 51
            echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"id\" class=\"uv-field\" value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 51, $this->source); })()), "id", [], "any", false, false, false, 51), "html", null, true);
            echo "\" placeholder=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Mailbox ID - Leave blank to automatically create id"), "html", null, true);
            echo "\" />
\t\t\t\t\t\t";
        } else {
            // line 53
            echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"id\" class=\"uv-field\" value=\"\" placeholder=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Mailbox ID - Leave blank to automatically create id"), "html", null, true);
            echo "\" />
\t\t\t\t\t\t";
        }
        // line 55
        echo "\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t";
        // line 59
        echo "\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 60
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Name"), "html", null, true);
        echo ":</label>

\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t";
        // line 63
        if (((isset($context["mailbox"]) || array_key_exists("mailbox", $context)) &&  !twig_test_empty(twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 63, $this->source); })()), "name", [], "any", false, false, false, 63)))) {
            // line 64
            echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"name\" class=\"uv-field\" value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 64, $this->source); })()), "name", [], "any", false, false, false, 64), "html", null, true);
            echo "\" placeholder=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Mailbox Name"), "html", null, true);
            echo "\" />
\t\t\t\t\t\t";
        } else {
            // line 66
            echo "\t\t\t\t\t\t\t<input type=\"text\" name=\"name\" class=\"uv-field\" value=\"\" placeholder=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Mailbox Name"), "html", null, true);
            echo "\" />
\t\t\t\t\t\t";
        }
        // line 68
        echo "\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t";
        // line 72
        echo "\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label>
\t\t\t\t\t\t<div class=\"uv-checkbox\">
\t\t\t\t\t\t\t";
        // line 75
        if ((twig_get_attribute($this->env, $this->source, ($context["mailbox"] ?? null), "isEnabled", [], "any", true, true, false, 75) && (twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 75, $this->source); })()), "isEnabled", [], "any", false, false, false, 75) == true))) {
            // line 76
            echo "\t\t\t\t\t\t\t\t<input name=\"isEnabled\" type=\"checkbox\" checked=\"\">
\t\t\t\t\t\t\t";
        } else {
            // line 78
            echo "\t\t\t\t\t\t\t\t<input name=\"isEnabled\" type=\"checkbox\">
\t\t\t\t\t\t\t";
        }
        // line 80
        echo "
\t\t\t\t\t\t\t<span class=\"uv-checkbox-view\"></span>
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<span class=\"uv-checkbox-label\">";
        // line 84
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Enable Mailbox"), "html", null, true);
        echo "</span>
\t\t\t\t\t</label>
\t\t\t\t</div>

\t\t\t\t<div class=\"uv-hr\"></div>

\t\t\t\t";
        // line 91
        echo "\t\t\t\t<h3 class=\"section-heading\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Incoming Mail (IMAP) Server"), "html", null, true);
        echo "</h3>
\t\t\t\t<p class=\"section-description\">";
        // line 92
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Configure your imap settings which will be used to fetch emails from your mailbox."), "html", null, true);
        echo "</p>

\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 95
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Transport"), "html", null, true);
        echo ":</label>

\t\t\t\t\t";
        // line 97
        if ((isset($context["mailbox"]) || array_key_exists("mailbox", $context))) {
            // line 98
            echo "\t\t\t\t\t\t<select name=\"imap[transport]\" id=\"cta-mailbox-imap-transport\" class=\"uv-select\">
\t\t\t\t\t\t\t<option value=\"custom\" ";
            // line 99
            if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 99, $this->source); })()), "imapConfiguration", [], "any", false, false, false, 99), "code", [], "any", false, false, false, 99) == "custom")) {
                echo "selected";
            }
            echo ">IMAP</option>
\t\t\t\t\t\t\t<option value=\"gmail\" ";
            // line 100
            if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 100, $this->source); })()), "imapConfiguration", [], "any", false, false, false, 100), "code", [], "any", false, false, false, 100) == "gmail")) {
                echo "selected";
            }
            echo ">Gmail</option>
\t\t\t\t\t\t\t<option value=\"yahoo\" ";
            // line 101
            if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 101, $this->source); })()), "imapConfiguration", [], "any", false, false, false, 101), "code", [], "any", false, false, false, 101) == "yahoo")) {
                echo "selected";
            }
            echo ">Yahoo Mail</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t";
        } else {
            // line 104
            echo "\t\t\t\t\t\t<select name=\"imap[transport]\" id=\"cta-mailbox-imap-transport\" class=\"uv-select\">
\t\t\t\t\t\t\t<option value=\"custom\" selected>";
            // line 105
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("IMAP"), "html", null, true);
            echo "</option>
\t\t\t\t\t\t\t<option value=\"gmail\">";
            // line 106
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Gmail"), "html", null, true);
            echo "</option>
\t\t\t\t\t\t\t<option value=\"yahoo\">";
            // line 107
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Yahoo"), "html", null, true);
            echo "</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t";
        }
        // line 110
        echo "\t\t\t\t</div>

\t\t\t\t<div class=\"imap-setting-references\"></div>

\t\t\t\t<div class=\"uv-hr\"></div>

\t\t\t\t";
        // line 117
        echo "\t\t\t\t<h3 class=\"section-heading\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Outgoing Mail (SMTP) Server"), "html", null, true);
        echo "</h3>
\t\t\t\t<p class=\"section-description\">";
        // line 118
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Select a valid Swift Mailer configuration which will be used to send emails through your mailbox."), "html", null, true);
        echo "</p>

\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 121
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Swift Mailer ID"), "html", null, true);
        echo ":</label>

\t\t\t\t\t";
        // line 123
        if (((isset($context["swiftmailerConfigurations"]) || array_key_exists("swiftmailerConfigurations", $context)) &&  !twig_test_empty((isset($context["swiftmailerConfigurations"]) || array_key_exists("swiftmailerConfigurations", $context) ? $context["swiftmailerConfigurations"] : (function () { throw new RuntimeError('Variable "swiftmailerConfigurations" does not exist.', 123, $this->source); })())))) {
            // line 124
            echo "\t\t\t\t\t\t<select name=\"swiftmailer_id\" class=\"uv-select\">
\t\t\t\t\t\t\t<option value=\"none\">";
            // line 125
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("None Selected"), "html", null, true);
            echo "</option>
\t\t\t\t\t\t\t";
            // line 126
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["swiftmailerConfigurations"]) || array_key_exists("swiftmailerConfigurations", $context) ? $context["swiftmailerConfigurations"] : (function () { throw new RuntimeError('Variable "swiftmailerConfigurations" does not exist.', 126, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["configuration"]) {
                // line 127
                echo "\t\t\t\t\t\t\t\t";
                if (((isset($context["mailbox"]) || array_key_exists("mailbox", $context)) && (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 127, $this->source); })()), "swiftmailerConfiguration", [], "any", false, false, false, 127), "id", [], "any", false, false, false, 127) == twig_get_attribute($this->env, $this->source, $context["configuration"], "id", [], "any", false, false, false, 127)))) {
                    // line 128
                    echo "\t\t\t\t\t\t\t\t\t<option value=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["configuration"], "id", [], "any", false, false, false, 128), "html", null, true);
                    echo "\" selected>";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["configuration"], "id", [], "any", false, false, false, 128), "html", null, true);
                    echo "</option>
\t\t\t\t\t\t\t\t";
                } else {
                    // line 130
                    echo "\t\t\t\t\t\t\t\t\t<option value=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["configuration"], "id", [], "any", false, false, false, 130), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["configuration"], "id", [], "any", false, false, false, 130), "html", null, true);
                    echo "</option>
\t\t\t\t\t\t\t\t";
                }
                // line 132
                echo "\t\t\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['configuration'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 133
            echo "\t\t\t\t\t\t</select>
\t\t\t\t\t";
        } else {
            // line 135
            echo "\t\t\t\t\t\t<select name=\"swiftmailer_id\" class=\"uv-select\">
\t\t\t\t\t\t\t<option value=\"none\">";
            // line 136
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("None Selected"), "html", null, true);
            echo "</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t";
        }
        // line 139
        echo "\t\t\t\t</div>

\t\t\t\t<div class=\"uv-hr\"></div>

\t\t\t\t";
        // line 144
        echo "\t\t\t\t";
        if (((isset($context["mailbox"]) || array_key_exists("mailbox", $context)) &&  !twig_test_empty(twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 144, $this->source); })()), "id", [], "any", false, false, false, 144)))) {
            // line 145
            echo "\t\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Update Mailbox"), "html", null, true);
            echo "\" type=\"submit\">
\t\t\t\t";
        } else {
            // line 147
            echo "\t\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Create Mailbox"), "html", null, true);
            echo "\" type=\"submit\">
\t\t\t\t";
        }
        // line 149
        echo "\t\t\t\t
\t\t\t</form>
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 155
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 156
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "

    <script id=\"imap_conf_template_predefined\" type=\"text/template\">
        <div class=\"uv-element-block\">
\t\t\t<label class=\"uv-field-label\">";
        // line 160
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Username"), "html", null, true);
        echo ":</label>
\t\t\t
\t\t\t<div class=\"uv-field-block\">
\t\t\t\t<% if (typeof(username) != 'undefined' && username != '') { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[username]\" value=\"<%- username %>\" placeholder=\"";
        // line 164
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email address"), "html", null, true);
        echo "\">
\t\t\t\t<% } else { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[username]\" value=\"\" placeholder=\"";
        // line 166
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email address"), "html", null, true);
        echo "\">
                <% } %>
\t\t\t</div>
\t\t</div>
\t\t
\t\t<div class=\"uv-element-block\">
\t\t\t<label class=\"uv-field-label\">";
        // line 172
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Password"), "html", null, true);
        echo ":</label>

\t\t\t<div class=\"uv-field-block\">
\t\t\t\t<input class=\"uv-field\" type=\"password\" name=\"imap[password]\" placeholder=\"";
        // line 175
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Associated Password"), "html", null, true);
        echo "\">
\t\t\t</div>
\t\t</div>
\t</script>

    <script id=\"imap_conf_template_custom\" type=\"text/template\">
        <div class=\"uv-element-block\">
\t\t\t<label class=\"uv-field-label\">";
        // line 182
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Host"), "html", null, true);
        echo ":</label>
\t\t\t
\t\t\t<div class=\"uv-field-block\">
\t\t\t\t<% if (typeof(host) != 'undefined' && host != '') { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[host]\" value=\"<%- host %>\" placeholder=\"<%- host %>\">
\t\t\t\t<% } else { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[host]\" value=\"\" placeholder=\"";
        // line 188
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("IMAP Host"), "html", null, true);
        echo "\">
                <% } %>
\t\t\t</div>
\t\t</div>

\t\t<div class=\"uv-element-block\">
\t\t\t<label class=\"uv-field-label\">";
        // line 194
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email"), "html", null, true);
        echo ":</label>
\t\t\t
\t\t\t<div class=\"uv-field-block\">
\t\t\t\t<% if (typeof(username) != 'undefined' && username != '') { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[username]\" value=\"<%- username %>\" placeholder=\"";
        // line 198
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email address"), "html", null, true);
        echo "\">
\t\t\t\t<% } else { %>
\t\t\t\t\t<input class=\"uv-field\" type=\"text\" name=\"imap[username]\" value=\"\" placeholder=\"";
        // line 200
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email address"), "html", null, true);
        echo "\">
                <% } %>
\t\t\t</div>
\t\t</div>
\t\t
\t\t<div class=\"uv-element-block\">
\t\t\t<label class=\"uv-field-label\">";
        // line 206
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Password"), "html", null, true);
        echo ":</label>

\t\t\t<div class=\"uv-field-block\">
\t\t\t\t<input class=\"uv-field\" type=\"password\" name=\"imap[password]\" placeholder=\"";
        // line 209
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
        // line 221
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please specify a valid name for your mailbox."), "html", null, true);
        echo "\";
\t\t\t\t\t\t}
                    },
\t\t\t\t\tswiftmailer_id: function(value) {
\t\t\t\t\t\tif (value == undefined || value == '' || value == 'none') {
\t\t\t\t\t\t\treturn \"";
        // line 226
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please select a valid swift-mailer configuration."), "html", null, true);
        echo "\";
\t\t\t\t\t\t}
                    },
\t\t\t\t\t\"imap[host]\": function(value) {
                        if ('custom' == this.get('transport') || 'imap' == this.get('transport')) {
                            if (value == undefined || value == '') {
                                return \"";
        // line 232
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please specify a valid host address."), "html", null, true);
        echo "\";
                            }
                        }
                    },
                    \"imap[username]\": [
                        {
                            required: true,
                            msg: \"";
        // line 239
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please specify a valid email address."), "html", null, true);
        echo "\"
                        },
                        {
                            pattern: /^([\\w-\\.]+)@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([\\w-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)\$/,
                            msg: \"";
        // line 243
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please specify a valid email address."), "html", null, true);
        echo "\"
                        }
                    ],
                    \"imap[password]\": function(value) {
                        if (value == undefined || value == '') {
                            return \"";
        // line 248
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
        // line 297
        if ((isset($context["mailbox"]) || array_key_exists("mailbox", $context))) {
            // line 298
            echo "                new MailboxConfigurationView({
                    el: \$(\"#mailbox-settings-view\"),
                    model: new MailboxConfigurationModel({
\t\t\t\t\t\ttransport: \"";
            // line 301
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 301, $this->source); })()), "imapConfiguration", [], "any", false, false, false, 301), "code", [], "any", false, false, false, 301), "html", null, true);
            echo "\",
\t\t\t\t\t\thost: \"";
            // line 302
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 302, $this->source); })()), "imapConfiguration", [], "any", false, false, false, 302), "host", [], "any", false, false, false, 302), "html", null, true);
            echo "\",
\t\t\t\t\t\tusername: \"";
            // line 303
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["mailbox"]) || array_key_exists("mailbox", $context) ? $context["mailbox"] : (function () { throw new RuntimeError('Variable "mailbox" does not exist.', 303, $this->source); })()), "imapConfiguration", [], "any", false, false, false, 303), "username", [], "any", false, false, false, 303), "html", null, true);
            echo "\",
\t\t\t\t\t})
                });
            ";
        } else {
            // line 307
            echo "                new MailboxConfigurationView({
                    el: \$(\"#mailbox-settings-view\"),
                    model: new MailboxConfigurationModel({ transport: 'custom' })
                });
            ";
        }
        // line 312
        echo "\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskMailbox//manageConfigurations.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  653 => 312,  646 => 307,  639 => 303,  635 => 302,  631 => 301,  626 => 298,  624 => 297,  572 => 248,  564 => 243,  557 => 239,  547 => 232,  538 => 226,  530 => 221,  515 => 209,  509 => 206,  500 => 200,  495 => 198,  488 => 194,  479 => 188,  470 => 182,  460 => 175,  454 => 172,  445 => 166,  440 => 164,  433 => 160,  425 => 156,  415 => 155,  401 => 149,  395 => 147,  389 => 145,  386 => 144,  380 => 139,  374 => 136,  371 => 135,  367 => 133,  361 => 132,  353 => 130,  345 => 128,  342 => 127,  338 => 126,  334 => 125,  331 => 124,  329 => 123,  324 => 121,  318 => 118,  313 => 117,  305 => 110,  299 => 107,  295 => 106,  291 => 105,  288 => 104,  280 => 101,  274 => 100,  268 => 99,  265 => 98,  263 => 97,  258 => 95,  252 => 92,  247 => 91,  238 => 84,  232 => 80,  228 => 78,  224 => 76,  222 => 75,  217 => 72,  212 => 68,  206 => 66,  198 => 64,  196 => 63,  190 => 60,  187 => 59,  182 => 55,  176 => 53,  168 => 51,  166 => 50,  160 => 47,  157 => 46,  151 => 41,  145 => 39,  139 => 37,  137 => 36,  131 => 35,  126 => 33,  123 => 32,  120 => 31,  117 => 30,  94 => 8,  84 => 7,  72 => 4,  60 => 3,  37 => 1,);
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
\t\t\t{% if mailbox is defined and mailbox.id is not empty %}
\t\t\t\t<h1>{{'Update Mailbox'|trans}}</h1>
\t\t\t{% else %}
\t\t\t\t<h1>{{'New Mailbox'|trans}}</h1>
\t\t\t{% endif %}

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

\t\t\t\t{# <input class=\"uv-btn\" href=\"#\" value=\"{{ 'Create Mailbox'|trans }}\" type=\"submit\"> #}
\t\t\t\t{% if mailbox is defined and mailbox.id is not empty %}
\t\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"{{ 'Update Mailbox'|trans }}\" type=\"submit\">
\t\t\t\t{% else %}
\t\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"{{ 'Create Mailbox'|trans }}\" type=\"submit\">
\t\t\t\t{% endif %}
\t\t\t\t
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
{% endblock %}", "@UVDeskMailbox//manageConfigurations.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/mailbox-component/Resources/views/manageConfigurations.html.twig");
    }
}
