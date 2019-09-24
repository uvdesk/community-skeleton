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

/* @UVDeskCoreFramework/Privileges/createSupportPrivelege.html.twig */
class __TwigTemplate_f9584db2649fc64a46f691a40d09e2a2bc429e817143ea1d120ffc8656946b19 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Privileges/createSupportPrivelege.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Privileges/createSupportPrivelege.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskCoreFramework/Privileges/createSupportPrivelege.html.twig", 1);
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

        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Privilege"), "html", null, true);
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 5
    public function block_pageContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        // line 6
        echo "\t<div class=\"uv-inner-section\">
        ";
        // line 8
        echo "\t\t";
        $context["asideTemplate"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\AsideTemplate";
        // line 9
        echo "\t\t";
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Users";
        // line 10
        echo "
\t\t";
        // line 11
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 11, $this->source); })()), "getRegisteredComponent", [0 => (isset($context["asideTemplate"]) || array_key_exists("asideTemplate", $context) ? $context["asideTemplate"] : (function () { throw new RuntimeError('Variable "asideTemplate" does not exist.', 11, $this->source); })())], "method", false, false, false, 11), "renderSidebar", [0 => (isset($context["asideSidebarReference"]) || array_key_exists("asideSidebarReference", $context) ? $context["asideSidebarReference"] : (function () { throw new RuntimeError('Variable "asideSidebarReference" does not exist.', 11, $this->source); })())], "method", false, false, false, 11);
        echo "

\t\t<div class=\"uv-view ";
        // line 13
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 13, $this->source); })()), "request", [], "any", false, false, false, 13), "cookies", [], "any", false, false, false, 13) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 13, $this->source); })()), "request", [], "any", false, false, false, 13), "cookies", [], "any", false, false, false, 13), "get", [0 => "uv-asideView"], "method", false, false, false, 13))) {
            echo "uv-aside-view";
        }
        echo "\">
\t\t\t<h1>";
        // line 14
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Privilege"), "html", null, true);
        echo "</h1>
\t\t\t
            ";
        // line 17
        echo "\t\t\t<form method=\"post\" action=\"\" id=\"privilege-form\">
                ";
        // line 19
        echo "\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 20
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Name"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<input type=\"text\" name=\"privilege_form[name]\" class=\"uv-field\" value=\"";
        // line 22
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["supportPrivilege"]) || array_key_exists("supportPrivilege", $context) ? $context["supportPrivilege"] : (function () { throw new RuntimeError('Variable "supportPrivilege" does not exist.', 22, $this->source); })()), "name", [], "any", false, false, false, 22), "html", null, true);
        echo "\" />
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 27
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Description"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<textarea name=\"privilege_form[description]\" class=\"uv-field\">";
        // line 29
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["supportPrivilege"]) || array_key_exists("supportPrivilege", $context) ? $context["supportPrivilege"] : (function () { throw new RuntimeError('Variable "supportPrivilege" does not exist.', 29, $this->source); })()), "description", [], "any", false, false, false, 29), "html", null, true);
        echo "</textarea>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t
                ";
        // line 34
        echo "\t\t\t\t<div class=\"uv-scroll-plank\">
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 36
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent Privileges"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t<span class=\"uv-field-info uv-margin-top-5\">";
        // line 37
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Choose set of privileges which will be available to the agent."), "html", null, true);
        echo "</span>
\t\t\t\t\t</div>
\t\t\t\t\t
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label>
\t\t\t\t\t\t\t<span class=\"uv-checkbox-label uv-bold\">";
        // line 42
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Tickets"), "html", null, true);
        echo "</span>
\t\t\t\t\t\t</label>
\t\t\t\t\t</div>

\t\t\t\t\t<div>
\t\t\t\t\t\t<div class=\"uv-scroll-block\" id=\"beauty-scroll\">
\t\t\t\t\t\t\t";
        // line 48
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["supportPrivilegeResources"]) || array_key_exists("supportPrivilegeResources", $context) ? $context["supportPrivilegeResources"] : (function () { throw new RuntimeError('Variable "supportPrivilegeResources" does not exist.', 48, $this->source); })()), "ticket", [], "any", false, false, false, 48));
        foreach ($context['_seq'] as $context["privelegeCode"] => $context["privelegeDescription"]) {
            // line 49
            echo "\t\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t\t<label>
\t\t\t\t\t\t\t\t\t\t<div class=\"uv-checkbox\">
\t\t\t\t\t\t\t\t\t\t\t<input name=\"privilege_form[privileges][]\" type=\"checkbox\" value=\"";
            // line 52
            echo twig_escape_filter($this->env, $context["privelegeCode"], "html", null, true);
            echo "\">
\t\t\t\t\t\t\t\t\t\t\t<span class=\"uv-checkbox-view\"></span>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<span class=\"uv-checkbox-label\">";
            // line 55
            echo twig_escape_filter($this->env, $context["privelegeDescription"], "html", null, true);
            echo "</span>
\t\t\t\t\t\t\t\t\t</label>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['privelegeCode'], $context['privelegeDescription'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 59
        echo "\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

                    ";
        // line 63
        echo "\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<a href=\"#\" class=\"select\">";
        // line 64
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Select All"), "html", null, true);
        echo "</a>
\t\t\t\t\t\t<a href=\"#\" class=\"deselect\">";
        // line 65
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Remove All"), "html", null, true);
        echo "</a>
\t\t\t\t\t</div>
\t\t\t\t</div>
                ";
        // line 69
        echo "\t\t\t\t<div class=\"uv-scroll-plank\">
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label>
\t\t\t\t\t\t\t<span class=\"uv-checkbox-label uv-bold\">";
        // line 72
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Advanced"), "html", null, true);
        echo "</span>
\t\t\t\t\t\t</label>
\t\t\t\t\t</div>

\t\t\t\t\t<div>
\t\t\t\t\t\t<div class=\"uv-scroll-block\" id=\"beauty-scroll\">
\t\t\t\t\t\t\t";
        // line 78
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["supportPrivilegeResources"]) || array_key_exists("supportPrivilegeResources", $context) ? $context["supportPrivilegeResources"] : (function () { throw new RuntimeError('Variable "supportPrivilegeResources" does not exist.', 78, $this->source); })()), "advanced", [], "any", false, false, false, 78));
        foreach ($context['_seq'] as $context["privelegeCode"] => $context["privelegeDescription"]) {
            // line 79
            echo "\t\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t\t<label>
\t\t\t\t\t\t\t\t\t\t<div class=\"uv-checkbox\">
\t\t\t\t\t\t\t\t\t\t\t<input name=\"privilege_form[privileges][]\" type=\"checkbox\" value=\"";
            // line 82
            echo twig_escape_filter($this->env, $context["privelegeCode"], "html", null, true);
            echo "\" ";
            if (((isset($context["supportPrivilege"]) || array_key_exists("supportPrivilege", $context) ? $context["supportPrivilege"] : (function () { throw new RuntimeError('Variable "supportPrivilege" does not exist.', 82, $this->source); })()) && twig_in_filter($context["privelegeCode"], twig_get_attribute($this->env, $this->source, (isset($context["supportPrivilege"]) || array_key_exists("supportPrivilege", $context) ? $context["supportPrivilege"] : (function () { throw new RuntimeError('Variable "supportPrivilege" does not exist.', 82, $this->source); })()), "privileges", [], "any", false, false, false, 82)))) {
                echo "checked";
            }
            echo ">
\t\t\t\t\t\t\t\t\t\t\t<span class=\"uv-checkbox-view\"></span>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<span class=\"uv-checkbox-label\">";
            // line 85
            echo twig_escape_filter($this->env, $context["privelegeDescription"], "html", null, true);
            echo "</span>
\t\t\t\t\t\t\t\t\t</label>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['privelegeCode'], $context['privelegeDescription'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 89
        echo "\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

                    ";
        // line 93
        echo "\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<a href=\"#\" class=\"select\">";
        // line 94
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Select All"), "html", null, true);
        echo "</a>
\t\t\t\t\t\t<a href=\"#\" class=\"deselect\">";
        // line 95
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Remove All"), "html", null, true);
        echo "</a>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<!-- CSRF token Field -->
                ";
        // line 101
        echo "                <!-- //CSRF token Field -->

\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"";
        // line 103
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"submit\">
\t\t\t</form>
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 109
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 110
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "

\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar SupportPrivilegeModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'privilege_form[name]': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"";
        // line 118
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
\t\t\t\t\t}, {
\t\t\t\t\t\tpattern: '^((?![!@#\$%^&*()<>]).)*\$',
\t\t\t\t\t\tmsg: \"";
        // line 121
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Privilege Name must have characters only"), "html", null, true);
        echo "\"
\t\t\t\t\t},{
\t\t\t\t\t\tmaxLength:50,
                        msg:\"";
        // line 124
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Maximum character length is 50"), "html", null, true);
        echo "\"
\t\t\t\t\t}],
\t\t\t\t\t'privilege_form[description]': {
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"";
        // line 128
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
\t\t\t\t\t},
\t\t\t\t\t'privilege_form[privileges][]': {
                        fn: function() {
                            return !\$(\"input[name='privilege_form[privileges][]']:checked\").length ? true : false;
                        },
                        msg: \"";
        // line 134
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
                    },
\t\t\t\t}
\t\t\t});

\t\t\tvar CreateSupportPrivilegeForm = Backbone.View.extend({
\t\t\t\tevents: {
\t\t\t\t\t'click .uv-btn' : \"savePrivilege\",
\t\t\t\t\t'blur input, textarea': 'formChanegd',
\t\t\t\t\t'click a.select': 'selectAll',
\t\t            'click a.deselect': 'deselectAll',
\t\t\t\t},
\t\t\t\tinitialize: function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t\tvar jsonContext = JSON.parse('";
        // line 148
        echo (isset($context["errors"]) || array_key_exists("errors", $context) ? $context["errors"] : (function () { throw new RuntimeError('Variable "errors" does not exist.', 148, $this->source); })());
        echo "');

\t\t    \t\tfor (var field in jsonContext) {
\t\t\t\t\t\tif (field == 'privileges') {
\t\t\t\t\t\t\tBackbone.Validation.callbacks.invalid(this, \"privilege_form[privileges][]\", jsonContext[field], 'input');
\t\t\t\t\t\t} else {
\t\t\t\t\t\t\tBackbone.Validation.callbacks.invalid(this, \"privilege_form[\" + field + \"]\", jsonContext[field], 'input');
\t\t\t\t\t\t}
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t    \tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t    },
\t\t\t\tsavePrivilege: function (e) {
\t\t\t\t\te.preventDefault();
\t\t\t        this.model.set(this.\$el.serializeObject());

\t\t\t        if (this.model.isValid(true)) {
\t\t\t\t\t\tthis.\$el.find('.uv-btn').attr('disabled', 'disabled');
\t\t\t            this.\$el.submit();
\t\t\t        }
\t\t\t\t},
                selectAll: function (e) {
                    e.preventDefault();
                    this.\$(e.currentTarget).parents('.uv-scroll-plank').find('input').prop('checked', true)
                },
                deselectAll: function (e) {
                    e.preventDefault();
                    this.\$(e.currentTarget).parents('.uv-scroll-plank').find('input').prop('checked', false);
\t\t        },
\t\t\t});

\t\t\tvar createSupportPrivilegeForm = new CreateSupportPrivilegeForm({
\t\t\t\tel: \$(\"#privilege-form\"),
\t\t\t\tmodel: new SupportPrivilegeModel()
\t\t\t});\t
\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework/Privileges/createSupportPrivelege.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  365 => 148,  348 => 134,  339 => 128,  332 => 124,  326 => 121,  320 => 118,  308 => 110,  298 => 109,  283 => 103,  279 => 101,  271 => 95,  267 => 94,  264 => 93,  259 => 89,  249 => 85,  239 => 82,  234 => 79,  230 => 78,  221 => 72,  216 => 69,  210 => 65,  206 => 64,  203 => 63,  198 => 59,  188 => 55,  182 => 52,  177 => 49,  173 => 48,  164 => 42,  156 => 37,  152 => 36,  148 => 34,  141 => 29,  136 => 27,  128 => 22,  123 => 20,  120 => 19,  117 => 17,  112 => 14,  106 => 13,  101 => 11,  98 => 10,  95 => 9,  92 => 8,  89 => 6,  79 => 5,  60 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %}{{'Add Privilege'|trans}}{% endblock %}

{% block pageContent %}
\t<div class=\"uv-inner-section\">
        {# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Users' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}

\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
\t\t\t<h1>{{'Add Privilege'|trans}}</h1>
\t\t\t
            {# Create Support Privilege Form #}
\t\t\t<form method=\"post\" action=\"\" id=\"privilege-form\">
                {# Basic Details #}
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{'Name'|trans}}</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<input type=\"text\" name=\"privilege_form[name]\" class=\"uv-field\" value=\"{{ supportPrivilege.name }}\" />
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{'Description'|trans}}</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<textarea name=\"privilege_form[description]\" class=\"uv-field\">{{ supportPrivilege.description }}</textarea>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t
                {# Agent Resources #}
\t\t\t\t<div class=\"uv-scroll-plank\">
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label class=\"uv-field-label\">{{\"Agent Privileges\"|trans}}</label>
\t\t\t\t\t\t<span class=\"uv-field-info uv-margin-top-5\">{{'Choose set of privileges which will be available to the agent.'|trans}}</span>
\t\t\t\t\t</div>
\t\t\t\t\t
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label>
\t\t\t\t\t\t\t<span class=\"uv-checkbox-label uv-bold\">{{'Tickets'|trans}}</span>
\t\t\t\t\t\t</label>
\t\t\t\t\t</div>

\t\t\t\t\t<div>
\t\t\t\t\t\t<div class=\"uv-scroll-block\" id=\"beauty-scroll\">
\t\t\t\t\t\t\t{% for privelegeCode, privelegeDescription in supportPrivilegeResources.ticket %}
\t\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t\t<label>
\t\t\t\t\t\t\t\t\t\t<div class=\"uv-checkbox\">
\t\t\t\t\t\t\t\t\t\t\t<input name=\"privilege_form[privileges][]\" type=\"checkbox\" value=\"{{ privelegeCode }}\">
\t\t\t\t\t\t\t\t\t\t\t<span class=\"uv-checkbox-view\"></span>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<span class=\"uv-checkbox-label\">{{ privelegeDescription }}</span>
\t\t\t\t\t\t\t\t\t</label>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

                    {# Mass Action #}
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<a href=\"#\" class=\"select\">{{'Select All'|trans}}</a>
\t\t\t\t\t\t<a href=\"#\" class=\"deselect\">{{'Remove All'|trans}}</a>
\t\t\t\t\t</div>
\t\t\t\t</div>
                {# Advanced Resources #}
\t\t\t\t<div class=\"uv-scroll-plank\">
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<label>
\t\t\t\t\t\t\t<span class=\"uv-checkbox-label uv-bold\">{{\"Advanced\"|trans}}</span>
\t\t\t\t\t\t</label>
\t\t\t\t\t</div>

\t\t\t\t\t<div>
\t\t\t\t\t\t<div class=\"uv-scroll-block\" id=\"beauty-scroll\">
\t\t\t\t\t\t\t{% for privelegeCode, privelegeDescription in supportPrivilegeResources.advanced %}
\t\t\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t\t\t<label>
\t\t\t\t\t\t\t\t\t\t<div class=\"uv-checkbox\">
\t\t\t\t\t\t\t\t\t\t\t<input name=\"privilege_form[privileges][]\" type=\"checkbox\" value=\"{{ privelegeCode }}\" {% if supportPrivilege and privelegeCode in supportPrivilege.privileges %}checked{% endif %}>
\t\t\t\t\t\t\t\t\t\t\t<span class=\"uv-checkbox-view\"></span>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<span class=\"uv-checkbox-label\">{{ privelegeDescription }}</span>
\t\t\t\t\t\t\t\t\t</label>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t{% endfor %}
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

                    {# Mass Action #}
\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t<a href=\"#\" class=\"select\">{{'Select All'|trans}}</a>
\t\t\t\t\t\t<a href=\"#\" class=\"deselect\">{{'Remove All'|trans}}</a>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<!-- CSRF token Field -->
                {# <input type=\"hidden\" name=\"privilege_form[_token]\" value=\"{{ default_service.generateCsrfToken('privilege_form') }}\"/> #}
                <!-- //CSRF token Field -->

\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"{{'Save Changes'|trans}}\" type=\"submit\">
\t\t\t</form>
\t\t</div>
\t</div>
{% endblock %}

{% block footer %}
\t{{ parent() }}

\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar SupportPrivilegeModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'privilege_form[name]': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"{{'This field is mandatory'|trans}}\"
\t\t\t\t\t}, {
\t\t\t\t\t\tpattern: '^((?![!@#\$%^&*()<>]).)*\$',
\t\t\t\t\t\tmsg: \"{{'Privilege Name must have characters only'|trans}}\"
\t\t\t\t\t},{
\t\t\t\t\t\tmaxLength:50,
                        msg:\"{{'Maximum character length is 50'|trans}}\"
\t\t\t\t\t}],
\t\t\t\t\t'privilege_form[description]': {
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"{{'This field is mandatory'|trans}}\"
\t\t\t\t\t},
\t\t\t\t\t'privilege_form[privileges][]': {
                        fn: function() {
                            return !\$(\"input[name='privilege_form[privileges][]']:checked\").length ? true : false;
                        },
                        msg: \"{{'This field is mandatory'|trans}}\"
                    },
\t\t\t\t}
\t\t\t});

\t\t\tvar CreateSupportPrivilegeForm = Backbone.View.extend({
\t\t\t\tevents: {
\t\t\t\t\t'click .uv-btn' : \"savePrivilege\",
\t\t\t\t\t'blur input, textarea': 'formChanegd',
\t\t\t\t\t'click a.select': 'selectAll',
\t\t            'click a.deselect': 'deselectAll',
\t\t\t\t},
\t\t\t\tinitialize: function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t\tvar jsonContext = JSON.parse('{{ errors|raw }}');

\t\t    \t\tfor (var field in jsonContext) {
\t\t\t\t\t\tif (field == 'privileges') {
\t\t\t\t\t\t\tBackbone.Validation.callbacks.invalid(this, \"privilege_form[privileges][]\", jsonContext[field], 'input');
\t\t\t\t\t\t} else {
\t\t\t\t\t\t\tBackbone.Validation.callbacks.invalid(this, \"privilege_form[\" + field + \"]\", jsonContext[field], 'input');
\t\t\t\t\t\t}
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t    \tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t    },
\t\t\t\tsavePrivilege: function (e) {
\t\t\t\t\te.preventDefault();
\t\t\t        this.model.set(this.\$el.serializeObject());

\t\t\t        if (this.model.isValid(true)) {
\t\t\t\t\t\tthis.\$el.find('.uv-btn').attr('disabled', 'disabled');
\t\t\t            this.\$el.submit();
\t\t\t        }
\t\t\t\t},
                selectAll: function (e) {
                    e.preventDefault();
                    this.\$(e.currentTarget).parents('.uv-scroll-plank').find('input').prop('checked', true)
                },
                deselectAll: function (e) {
                    e.preventDefault();
                    this.\$(e.currentTarget).parents('.uv-scroll-plank').find('input').prop('checked', false);
\t\t        },
\t\t\t});

\t\t\tvar createSupportPrivilegeForm = new CreateSupportPrivilegeForm({
\t\t\t\tel: \$(\"#privilege-form\"),
\t\t\t\tmodel: new SupportPrivilegeModel()
\t\t\t});\t
\t\t});
\t</script>
{% endblock %}", "@UVDeskCoreFramework/Privileges/createSupportPrivelege.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/Privileges/createSupportPrivelege.html.twig");
    }
}
