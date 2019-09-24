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

/* @UVDeskCoreFramework/templateForm.html.twig */
class __TwigTemplate_3d8b1ffe225059041611217c0ef83ede342c467c8885d3b0e7ed2a80e1f5006c extends \Twig\Template
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
        return "@UVDeskCoreFramework/Templates/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/templateForm.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/templateForm.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework/Templates/layout.html.twig", "@UVDeskCoreFramework/templateForm.html.twig", 1);
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

        // line 4
        echo "    ";
        if (twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 4, $this->source); })()), "id", [], "any", false, false, false, 4)) {
            // line 5
            echo "\t\t";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit Email Template"), "html", null, true);
            echo "
\t";
        } else {
            // line 7
            echo "\t\t";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Email Template"), "html", null, true);
            echo "
\t";
        }
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 11
    public function block_pageContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        // line 12
        echo "\t<div class=\"uv-inner-section\">
\t\t";
        // line 14
        echo "\t\t";
        $context["asideTemplate"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\AsideTemplate";
        // line 15
        echo "\t\t";
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Settings";
        // line 16
        echo "
\t\t";
        // line 17
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 17, $this->source); })()), "getRegisteredComponent", [0 => (isset($context["asideTemplate"]) || array_key_exists("asideTemplate", $context) ? $context["asideTemplate"] : (function () { throw new RuntimeError('Variable "asideTemplate" does not exist.', 17, $this->source); })())], "method", false, false, false, 17), "renderSidebar", [0 => (isset($context["asideSidebarReference"]) || array_key_exists("asideSidebarReference", $context) ? $context["asideSidebarReference"] : (function () { throw new RuntimeError('Variable "asideSidebarReference" does not exist.', 17, $this->source); })())], "method", false, false, false, 17);
        echo "
\t\t
\t\t<div class=\"uv-view ";
        // line 19
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 19, $this->source); })()), "request", [], "any", false, false, false, 19), "cookies", [], "any", false, false, false, 19) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 19, $this->source); })()), "request", [], "any", false, false, false, 19), "cookies", [], "any", false, false, false, 19), "get", [0 => "uv-asideView"], "method", false, false, false, 19))) {
            echo "uv-aside-view";
        }
        echo "\">
\t\t\t<h1>
\t\t\t\t";
        // line 21
        if (twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 21, $this->source); })()), "id", [], "any", false, false, false, 21)) {
            // line 22
            echo "                    ";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit Email Template"), "html", null, true);
            echo "
                ";
        } else {
            // line 24
            echo "                    ";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Email Template"), "html", null, true);
            echo "
                ";
        }
        // line 26
        echo "\t\t\t</h1>

\t\t\t<!--Form-->
\t\t\t<form method=\"post\" action=\"\" id=\"template-form\">
\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 32
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Name"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<input type=\"text\" name=\"name\" class=\"uv-field\" value=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 34, $this->source); })()), "name", [], "any", false, false, false, 34)), "html", null, true);
        echo "\" />
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 36
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email template name"), "html", null, true);
        echo "</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 42
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Subject"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<div class=\"uv-group uv-no-error-success-icon\">
\t\t\t\t\t\t\t<input type=\"text\" id=\"subject-field\" name=\"subject\" class=\"uv-field uv-group-field\" value=\"";
        // line 45
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 45, $this->source); })()), "subject", [], "any", false, false, false, 45), "html", null, true);
        echo "\" />
\t\t\t\t\t\t\t<select id=\"subject-placeholders\" class=\"uv-group-select\" title=\"placeholders\" data-toggle=\"tooltip\" data-placement=\"top\">
\t\t\t\t\t\t\t\t<option value=\"\" selected>";
        // line 47
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Placeholders"), "html", null, true);
        echo "</option>
\t\t\t\t\t\t\t\t";
        // line 48
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["email_service"]) || array_key_exists("email_service", $context) ? $context["email_service"] : (function () { throw new RuntimeError('Variable "email_service" does not exist.', 48, $this->source); })()), "getEmailPlaceHolders", [0 => "template"], "method", false, false, false, 48));
        foreach ($context['_seq'] as $context["basekey"] => $context["placeholders"]) {
            // line 49
            echo "\t\t\t\t\t\t\t\t\t";
            if (twig_test_iterable($context["placeholders"])) {
                // line 50
                echo "\t\t\t\t\t\t\t\t\t\t";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($context["placeholders"]);
                foreach ($context['_seq'] as $context["fieldKey"] => $context["fieldPlaceholder"]) {
                    // line 51
                    echo "\t\t\t\t\t\t\t\t\t\t\t<option value='";
                    echo twig_escape_filter($this->env, (((("{%" . $context["basekey"]) . ".") . $context["fieldKey"]) . "%}"), "html", null, true);
                    echo "' data-group='";
                    echo twig_escape_filter($this->env, $context["basekey"], "html", null, true);
                    echo "' class=\"mce-pitem mce-";
                    echo twig_escape_filter($this->env, $context["basekey"], "html", null, true);
                    echo "\" ";
                    if (((($context["basekey"] != "global") && twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 51, $this->source); })()), "templateType", [], "any", false, false, false, 51)) && ($context["basekey"] != twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 51, $this->source); })()), "templateType", [], "any", false, false, false, 51)))) {
                        echo " style=\"display: none;\"";
                    }
                    echo ">";
                    echo twig_get_attribute($this->env, $this->source, $context["fieldPlaceholder"], "title", [], "any", false, false, false, 51);
                    echo "</option>
\t\t\t\t\t\t\t\t\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['fieldKey'], $context['fieldPlaceholder'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 53
                echo "\t\t\t\t\t\t\t\t\t";
            }
            // line 54
            echo "\t\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['basekey'], $context['placeholders'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 55
        echo "\t\t\t\t\t\t\t</select>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 58
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email template subject"), "html", null, true);
        echo "</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 64
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Template For"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<select name=\"templateFor\" class=\"uv-select\" id=\"relatedTo\">
\t\t\t\t\t\t\t<option value=\"\">";
        // line 67
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Nothing Selected"), "html", null, true);
        echo "</option>
\t\t\t\t\t\t\t<option value=\"ticket\" ";
        // line 68
        if (("ticket" == twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 68, $this->source); })()), "templateType", [], "any", false, false, false, 68))) {
            echo "selected";
        }
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Ticket"), "html", null, true);
        echo "</option>
\t\t\t\t\t\t\t<option value=\"user\" ";
        // line 69
        if (("user" == twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 69, $this->source); })()), "templateType", [], "any", false, false, false, 69))) {
            echo "selected";
        }
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("User"), "html", null, true);
        echo "</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 72
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("email template will be used for work related with selected option"), "html", null, true);
        echo "</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-margin-right-15\">
\t\t\t\t\t<label class=\"uv-field-label\" style=\"margin-bottom: 5px\">";
        // line 78
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Body"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\">
                        <textarea id=\"message\" name=\"message\" class=\"uv-field\">
\t\t\t\t\t\t\t";
        // line 81
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 81, $this->source); })()), "message", [], "any", false, false, false, 81), "html", null, true);
        echo "
\t\t\t\t\t\t</textarea>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 84
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email template body"), "html", null, true);
        echo "</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!--CTA-->
\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"";
        // line 89
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"submit\">
\t\t\t\t<!--//CTA-->
\t\t\t</form>
\t\t\t<!--//Form-->
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 96
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 97
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
\t";
        // line 98
        echo twig_include($this->env, $context, "@UVDeskCoreFramework/Templates/tinyMCE.html.twig");
        echo "
\t
\t<script type=\"text/javascript\">
\t\tvar toolbarOptions = sfTinyMce.options.toolbar;

        sfTinyMce.init({
\t\t\ttoolbar: toolbarOptions + ' | placeholders | code',
\t\t\tsetup: function (editor) {
\t\t\t\teditor.addButton('placeholders', {
\t\t\t\t\ttype: 'listbox',
\t\t\t\t\ttext: '";
        // line 108
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Placeholders"), "html", null, true);
        echo "',
\t\t\t\t\tonselect: function (e) {
\t\t\t\t\t\teditor.insertContent(this.value());
\t\t\t\t\t\tthis.text('";
        // line 111
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Placeholders"), "html", null, true);
        echo "');
\t\t\t\t\t},
\t\t\t\t\tvalues: [
\t\t\t\t\t";
        // line 114
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["email_service"]) || array_key_exists("email_service", $context) ? $context["email_service"] : (function () { throw new RuntimeError('Variable "email_service" does not exist.', 114, $this->source); })()), "getEmailPlaceHolders", [0 => "template"], "method", false, false, false, 114));
        foreach ($context['_seq'] as $context["basekey"] => $context["placeholders"]) {
            // line 115
            echo "\t\t\t\t\t\t\t";
            if (twig_test_iterable($context["placeholders"])) {
                // line 116
                echo "\t\t\t\t\t\t\t\t";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($context["placeholders"]);
                foreach ($context['_seq'] as $context["fieldKey"] => $context["fieldPlaceholder"]) {
                    // line 117
                    echo "\t\t\t\t\t\t\t\t\t{ text: \"";
                    echo twig_get_attribute($this->env, $this->source, $context["fieldPlaceholder"], "title", [], "any", false, false, false, 117);
                    echo "\", value: '";
                    echo twig_escape_filter($this->env, (((("{%" . $context["basekey"]) . ".") . $context["fieldKey"]) . "%}"), "html", null, true);
                    echo "', group: '";
                    echo twig_escape_filter($this->env, $context["basekey"], "html", null, true);
                    echo "'
\t\t\t\t\t\t\t\t\t";
                    // line 118
                    if (("global" != $context["basekey"])) {
                        // line 119
                        echo "\t\t\t\t\t\t\t\t\t\t, classes: 'pitem ";
                        echo twig_escape_filter($this->env, $context["basekey"], "html", null, true);
                        echo "' ";
                        if ((twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 119, $this->source); })()), "templateType", [], "any", false, false, false, 119) && ($context["basekey"] != twig_get_attribute($this->env, $this->source, (isset($context["template"]) || array_key_exists("template", $context) ? $context["template"] : (function () { throw new RuntimeError('Variable "template" does not exist.', 119, $this->source); })()), "templateType", [], "any", false, false, false, 119)))) {
                            echo ", hidden: true";
                        }
                        // line 120
                        echo "\t\t\t\t\t\t\t\t\t";
                    }
                    echo " },
\t\t\t\t\t\t\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['fieldKey'], $context['fieldPlaceholder'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 122
                echo "\t\t\t\t\t\t\t";
            }
            // line 123
            echo "\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['basekey'], $context['placeholders'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 124
        echo "\t\t\t\t\t],
\t\t\t\t});
\t\t\t},
        });

\t\t\$('#relatedTo').on('change', function(e) {
\t\t\tval = \$(e.target).val();
\t\t\tswitch(val) {
\t\t\t\tcase 'task':
\t\t\t\t\t\$('.mce-pitem').hide();
\t\t\t\t\t\$('.mce-task').show();
\t\t\t\t\tbreak;
\t\t\t\tcase 'user':
\t\t\t\t\t\$('.mce-pitem').hide();
\t\t\t\t\t\$('.mce-user').show();
\t\t\t\t\tbreak;
\t\t\t\tcase 'ticket':
\t\t\t\t\t\$('.mce-pitem').hide();
\t\t\t\t\t\$('.mce-ticket').show();
\t\t\t\t\tbreak;
\t\t\t\tdefault:
\t\t\t\t\t\$('.mce-pitem').show();
\t\t\t}
\t\t});
\t\tvar oldContent, selection, cursorPosition;
\t\t\$('body').on('focusout', '#subject-field', function() {
\t\t\tselection = this;
\t\t\toldContent = selection.value;
\t\t\tcursorPosition = \$(this).prop(\"selectionStart\");
\t\t\tforEditor = false;
\t\t\tforSubject = true;
\t\t});
\t\t\$('#subject-placeholders').on('change', function(e) {
\t\t\ttoInsert = \$(e.target).val();
\t\t\t\$('#subject-placeholders option[selected]').removeAttr('selected');
\t\t\tif(toInsert && cursorPosition >=0 && forSubject){
\t\t\t\tvar newContent = oldContent.substring(0, cursorPosition) + toInsert + oldContent.substring(cursorPosition);
\t\t\t\tselection.value = newContent;
\t\t\t\tcursorPosition = cursorPosition + toInsert.length;
\t\t\t\toldContent = newContent;
\t\t\t} else if(toInsert) {
\t\t\t\t\$('#subject-field').val(\$('#subject-field').val() + toInsert);
\t\t\t}
\t\t});

\t\t\$(function () {
\t\t\tvar TemplateModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'name': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"";
        // line 174
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
\t\t\t\t\t},
\t\t\t\t\t{
\t\t\t\t\t\tmaxLength: 100,
\t\t\t\t\t\tmsg: \"";
        // line 178
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field contain 100 characters only"), "html", null, true);
        echo "\"
\t\t\t\t\t},{
\t\t\t\t\t\tpattern:\"^[ a-zA-Z_0-9 ']*\$\",
\t\t\t\t\t\tmsg:\"";
        // line 181
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field contain characters only"), "html", null, true);
        echo "\"
\t\t\t\t\t}],
\t\t\t\t\t'subject': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"";
        // line 185
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
\t\t\t\t\t},{
\t\t\t\t\t\tmaxLength:100,
\t\t\t\t\t\tmsg: \"";
        // line 188
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field contain 100 characters only"), "html", null, true);
        echo "\"
\t\t\t\t\t}]
\t\t\t\t}
\t\t\t});

\t\t\tvar TemplateForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn' : \"saveTemplate\",
\t\t\t\t\t'blur input': 'formChanegd'
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t    \t\tfor (var field in jsonContext) {
\t\t    \t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t    \tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t    },
\t\t\t\tsaveTemplate : function (e) {
\t\t\t\t\te.preventDefault();
\t\t\t        this.model.set(this.\$el.serializeObject());
\t\t\t        if(this.model.isValid(true)) {
\t\t\t\t\t\tthis.\$el.find('.uv-btn').attr('disabled', 'disabled');
\t\t\t            this.\$el.submit();
\t\t\t        }
\t\t\t\t}
\t\t\t});

\t\t\ttemplateForm = new TemplateForm({
\t\t\t\tel : \$(\"#template-form\"),
\t\t\t\tmodel : new TemplateModel()
\t\t\t});
\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework/templateForm.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  477 => 188,  471 => 185,  464 => 181,  458 => 178,  451 => 174,  399 => 124,  393 => 123,  390 => 122,  381 => 120,  374 => 119,  372 => 118,  363 => 117,  358 => 116,  355 => 115,  351 => 114,  345 => 111,  339 => 108,  326 => 98,  321 => 97,  311 => 96,  294 => 89,  286 => 84,  280 => 81,  274 => 78,  265 => 72,  255 => 69,  247 => 68,  243 => 67,  237 => 64,  228 => 58,  223 => 55,  217 => 54,  214 => 53,  195 => 51,  190 => 50,  187 => 49,  183 => 48,  179 => 47,  174 => 45,  168 => 42,  159 => 36,  154 => 34,  149 => 32,  141 => 26,  135 => 24,  129 => 22,  127 => 21,  120 => 19,  115 => 17,  112 => 16,  109 => 15,  106 => 14,  103 => 12,  93 => 11,  79 => 7,  73 => 5,  70 => 4,  60 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework/Templates/layout.html.twig\" %}

{% block title %}
    {% if template.id %}
\t\t{{ 'Edit Email Template'|trans }}
\t{% else %}
\t\t{{ 'Add Email Template'|trans }}
\t{% endif %}
{% endblock %}

{% block pageContent %}
\t<div class=\"uv-inner-section\">
\t\t{# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Settings' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}
\t\t
\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
\t\t\t<h1>
\t\t\t\t{% if template.id %}
                    {{ 'Edit Email Template'|trans }}
                {% else %}
                    {{ 'Add Email Template'|trans }}
                {% endif %}
\t\t\t</h1>

\t\t\t<!--Form-->
\t\t\t<form method=\"post\" action=\"\" id=\"template-form\">
\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Name'|trans }}</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<input type=\"text\" name=\"name\" class=\"uv-field\" value=\"{{ template.name | trans }}\" />
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">{{ \"Email template name\"|trans }}</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Subject'|trans }}</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<div class=\"uv-group uv-no-error-success-icon\">
\t\t\t\t\t\t\t<input type=\"text\" id=\"subject-field\" name=\"subject\" class=\"uv-field uv-group-field\" value=\"{{ template.subject }}\" />
\t\t\t\t\t\t\t<select id=\"subject-placeholders\" class=\"uv-group-select\" title=\"placeholders\" data-toggle=\"tooltip\" data-placement=\"top\">
\t\t\t\t\t\t\t\t<option value=\"\" selected>{{'Placeholders'|trans}}</option>
\t\t\t\t\t\t\t\t{% for basekey, placeholders in email_service.getEmailPlaceHolders('template') %}
\t\t\t\t\t\t\t\t\t{% if placeholders is iterable %}
\t\t\t\t\t\t\t\t\t\t{% for fieldKey, fieldPlaceholder in placeholders %}
\t\t\t\t\t\t\t\t\t\t\t<option value='{{ \"{%\" ~ basekey ~ \".\" ~ fieldKey ~ \"%}\"}}' data-group='{{ basekey }}' class=\"mce-pitem mce-{{ basekey }}\" {% if basekey != 'global' and template.templateType and (basekey != template.templateType) %} style=\"display: none;\"{% endif %}>{{ fieldPlaceholder.title|raw }}</option>
\t\t\t\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t\t</select>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">{{ 'Email template subject'|trans }}</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Template For'|trans }}</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<select name=\"templateFor\" class=\"uv-select\" id=\"relatedTo\">
\t\t\t\t\t\t\t<option value=\"\">{{ 'Nothing Selected'|trans }}</option>
\t\t\t\t\t\t\t<option value=\"ticket\" {% if 'ticket' == template.templateType %}selected{% endif %}>{{ 'Ticket'|trans }}</option>
\t\t\t\t\t\t\t<option value=\"user\" {% if 'user' == template.templateType %}selected{% endif %}>{{ 'User'|trans }}</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">{{ \"email template will be used for work related with selected option\"|trans }}</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!-- Field -->
\t\t\t\t<div class=\"uv-margin-right-15\">
\t\t\t\t\t<label class=\"uv-field-label\" style=\"margin-bottom: 5px\">{{ 'Body'|trans }}</label>
\t\t\t\t\t<div class=\"uv-field-block\">
                        <textarea id=\"message\" name=\"message\" class=\"uv-field\">
\t\t\t\t\t\t\t{{ template.message }}
\t\t\t\t\t\t</textarea>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">{{ 'Email template body'|trans }}</span>
\t\t\t\t</div>
\t\t\t\t<!-- //Field -->

\t\t\t\t<!--CTA-->
\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"{{ 'Save Changes'|trans }}\" type=\"submit\">
\t\t\t\t<!--//CTA-->
\t\t\t</form>
\t\t\t<!--//Form-->
\t\t</div>
\t</div>
{% endblock %}
{% block footer %}
\t{{ parent() }}
\t{{ include('@UVDeskCoreFramework/Templates/tinyMCE.html.twig') }}
\t
\t<script type=\"text/javascript\">
\t\tvar toolbarOptions = sfTinyMce.options.toolbar;

        sfTinyMce.init({
\t\t\ttoolbar: toolbarOptions + ' | placeholders | code',
\t\t\tsetup: function (editor) {
\t\t\t\teditor.addButton('placeholders', {
\t\t\t\t\ttype: 'listbox',
\t\t\t\t\ttext: '{{ \"Placeholders\"|trans }}',
\t\t\t\t\tonselect: function (e) {
\t\t\t\t\t\teditor.insertContent(this.value());
\t\t\t\t\t\tthis.text('{{ \"Placeholders\"|trans }}');
\t\t\t\t\t},
\t\t\t\t\tvalues: [
\t\t\t\t\t{% for basekey, placeholders in email_service.getEmailPlaceHolders('template') %}
\t\t\t\t\t\t\t{% if placeholders is iterable %}
\t\t\t\t\t\t\t\t{% for fieldKey, fieldPlaceholder in placeholders %}
\t\t\t\t\t\t\t\t\t{ text: \"{{ fieldPlaceholder.title|raw }}\", value: '{{ \"{%\" ~ basekey ~ \".\" ~ fieldKey ~ \"%}\"}}', group: '{{ basekey }}'
\t\t\t\t\t\t\t\t\t{% if 'global' != basekey  %}
\t\t\t\t\t\t\t\t\t\t, classes: 'pitem {{ basekey }}' {% if template.templateType and (basekey != template.templateType) %}, hidden: true{% endif %}
\t\t\t\t\t\t\t\t\t{% endif %} },
\t\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t\t{% endif %}
\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t],
\t\t\t\t});
\t\t\t},
        });

\t\t\$('#relatedTo').on('change', function(e) {
\t\t\tval = \$(e.target).val();
\t\t\tswitch(val) {
\t\t\t\tcase 'task':
\t\t\t\t\t\$('.mce-pitem').hide();
\t\t\t\t\t\$('.mce-task').show();
\t\t\t\t\tbreak;
\t\t\t\tcase 'user':
\t\t\t\t\t\$('.mce-pitem').hide();
\t\t\t\t\t\$('.mce-user').show();
\t\t\t\t\tbreak;
\t\t\t\tcase 'ticket':
\t\t\t\t\t\$('.mce-pitem').hide();
\t\t\t\t\t\$('.mce-ticket').show();
\t\t\t\t\tbreak;
\t\t\t\tdefault:
\t\t\t\t\t\$('.mce-pitem').show();
\t\t\t}
\t\t});
\t\tvar oldContent, selection, cursorPosition;
\t\t\$('body').on('focusout', '#subject-field', function() {
\t\t\tselection = this;
\t\t\toldContent = selection.value;
\t\t\tcursorPosition = \$(this).prop(\"selectionStart\");
\t\t\tforEditor = false;
\t\t\tforSubject = true;
\t\t});
\t\t\$('#subject-placeholders').on('change', function(e) {
\t\t\ttoInsert = \$(e.target).val();
\t\t\t\$('#subject-placeholders option[selected]').removeAttr('selected');
\t\t\tif(toInsert && cursorPosition >=0 && forSubject){
\t\t\t\tvar newContent = oldContent.substring(0, cursorPosition) + toInsert + oldContent.substring(cursorPosition);
\t\t\t\tselection.value = newContent;
\t\t\t\tcursorPosition = cursorPosition + toInsert.length;
\t\t\t\toldContent = newContent;
\t\t\t} else if(toInsert) {
\t\t\t\t\$('#subject-field').val(\$('#subject-field').val() + toInsert);
\t\t\t}
\t\t});

\t\t\$(function () {
\t\t\tvar TemplateModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'name': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"{{'This field is mandatory'|trans}}\"
\t\t\t\t\t},
\t\t\t\t\t{
\t\t\t\t\t\tmaxLength: 100,
\t\t\t\t\t\tmsg: \"{{'This field contain 100 characters only'|trans}}\"
\t\t\t\t\t},{
\t\t\t\t\t\tpattern:\"^[ a-zA-Z_0-9 ']*\$\",
\t\t\t\t\t\tmsg:\"{{'This field contain characters only'|trans}}\"
\t\t\t\t\t}],
\t\t\t\t\t'subject': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"{{'This field is mandatory'|trans}}\"
\t\t\t\t\t},{
\t\t\t\t\t\tmaxLength:100,
\t\t\t\t\t\tmsg: \"{{'This field contain 100 characters only'|trans}}\"
\t\t\t\t\t}]
\t\t\t\t}
\t\t\t});

\t\t\tvar TemplateForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn' : \"saveTemplate\",
\t\t\t\t\t'blur input': 'formChanegd'
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t    \t\tfor (var field in jsonContext) {
\t\t    \t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t    \tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t    },
\t\t\t\tsaveTemplate : function (e) {
\t\t\t\t\te.preventDefault();
\t\t\t        this.model.set(this.\$el.serializeObject());
\t\t\t        if(this.model.isValid(true)) {
\t\t\t\t\t\tthis.\$el.find('.uv-btn').attr('disabled', 'disabled');
\t\t\t            this.\$el.submit();
\t\t\t        }
\t\t\t\t}
\t\t\t});

\t\t\ttemplateForm = new TemplateForm({
\t\t\t\tel : \$(\"#template-form\"),
\t\t\t\tmodel : new TemplateModel()
\t\t\t});
\t\t});
\t</script>
{% endblock %}", "@UVDeskCoreFramework/templateForm.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/templateForm.html.twig");
    }
}
