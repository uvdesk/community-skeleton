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

/* @UVDeskSupportCenter/Staff/Folders/updateFolder.html.twig */
class __TwigTemplate_b43efbb4239b302f60128242284c0cb342fee1210d227f73e4e0347f6bad8e05 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Staff/Folders/updateFolder.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Staff/Folders/updateFolder.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskSupportCenter/Staff/Folders/updateFolder.html.twig", 1);
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

        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit Folder"), "html", null, true);
        
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
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\SupportCenterBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Knowledgebase";
        // line 10
        echo "
\t\t";
        // line 11
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 11, $this->source); })()), "getRegisteredComponent", [0 => (isset($context["asideTemplate"]) || array_key_exists("asideTemplate", $context) ? $context["asideTemplate"] : (function () { throw new RuntimeError('Variable "asideTemplate" does not exist.', 11, $this->source); })())], "method", false, false, false, 11), "renderSidebar", [0 => (isset($context["asideSidebarReference"]) || array_key_exists("asideSidebarReference", $context) ? $context["asideSidebarReference"] : (function () { throw new RuntimeError('Variable "asideSidebarReference" does not exist.', 11, $this->source); })())], "method", false, false, false, 11);
        echo "
\t\t
\t\t<div class=\"uv-view ";
        // line 13
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 13, $this->source); })()), "request", [], "any", false, false, false, 13), "cookies", [], "any", false, false, false, 13) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 13, $this->source); })()), "request", [], "any", false, false, false, 13), "cookies", [], "any", false, false, false, 13), "get", [0 => "uv-asideView"], "method", false, false, false, 13))) {
            echo "uv-aside-view";
        }
        echo "\">
\t\t\t<h1>";
        // line 14
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit Folder"), "html", null, true);
        echo "</h1>
\t\t\t
\t\t\t<form method=\"post\" action=\"\" id=\"entity-form\" enctype=\"multipart/form-data\">
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 18
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Name"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<input type=\"text\" name=\"name\" class=\"uv-field\" value=\"";
        // line 20
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["folder"]) || array_key_exists("folder", $context) ? $context["folder"] : (function () { throw new RuntimeError('Variable "folder" does not exist.', 20, $this->source); })()), "name", [], "any", false, false, false, 20), "html", null, true);
        echo "\" />
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 22
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Folder Name is shown upfront at Knowledge Base"), "html", null, true);
        echo "</span>
\t\t\t\t</div>

\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 26
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Description"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<textarea name=\"description\" class=\"uv-field\">";
        // line 28
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["folder"]) || array_key_exists("folder", $context) ? $context["folder"] : (function () { throw new RuntimeError('Variable "folder" does not exist.', 28, $this->source); })()), "description", [], "any", false, false, false, 28), "html", null, true);
        echo "</textarea>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 30
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("A small text about the folder helps user to navigate more easily"), "html", null, true);
        echo "</span>
\t\t\t\t</div>

\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 34
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
        echo "</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<select class=\"uv-select\" name=\"visibility\">
\t\t\t\t\t\t\t<option value=\"public\" ";
        // line 37
        echo (((twig_get_attribute($this->env, $this->source, (isset($context["folder"]) || array_key_exists("folder", $context) ? $context["folder"] : (function () { throw new RuntimeError('Variable "folder" does not exist.', 37, $this->source); })()), "visibility", [], "any", false, false, false, 37) && (twig_get_attribute($this->env, $this->source, (isset($context["folder"]) || array_key_exists("folder", $context) ? $context["folder"] : (function () { throw new RuntimeError('Variable "folder" does not exist.', 37, $this->source); })()), "visibility", [], "any", false, false, false, 37) == "public"))) ? ("selected") : (""));
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Publish"), "html", null, true);
        echo "</option>
\t\t\t\t\t\t\t<option value=\"private\" ";
        // line 38
        echo (((twig_get_attribute($this->env, $this->source, (isset($context["folder"]) || array_key_exists("folder", $context) ? $context["folder"] : (function () { throw new RuntimeError('Variable "folder" does not exist.', 38, $this->source); })()), "visibility", [], "any", false, false, false, 38) && (twig_get_attribute($this->env, $this->source, (isset($context["folder"]) || array_key_exists("folder", $context) ? $context["folder"] : (function () { throw new RuntimeError('Variable "folder" does not exist.', 38, $this->source); })()), "visibility", [], "any", false, false, false, 38) == "private"))) ? ("selected") : (""));
        echo ">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Draft"), "html", null, true);
        echo "</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 41
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Choose appropriate status"), "html", null, true);
        echo "</span>
\t\t\t\t</div>

\t\t\t\t<div class=\"uv-element-block uv-no-error-success-icon\">
\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 45
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Folder Image"), "html", null, true);
        echo "</label>
\t\t\t\t\t<!-- Profile image -->
\t\t\t\t\t<div class=\"uv-image-upload-wrapper\" style=\"padding: 10px 0px 10px 0px; border:none;\">
\t\t\t\t\t\t";
        // line 48
        $context["isHaveImage"] = ((((isset($context["folder"]) || array_key_exists("folder", $context) ? $context["folder"] : (function () { throw new RuntimeError('Variable "folder" does not exist.', 48, $this->source); })()) && twig_get_attribute($this->env, $this->source, (isset($context["folder"]) || array_key_exists("folder", $context) ? $context["folder"] : (function () { throw new RuntimeError('Variable "folder" does not exist.', 48, $this->source); })()), "solutionImage", [], "any", false, false, false, 48))) ? (1) : (0));
        // line 49
        echo "\t\t\t\t\t\t<div class=\"uv-image-upload-brick ";
        if ((isset($context["isHaveImage"]) || array_key_exists("isHaveImage", $context) ? $context["isHaveImage"] : (function () { throw new RuntimeError('Variable "isHaveImage" does not exist.', 49, $this->source); })())) {
            echo "uv-on-drop-shadow";
        }
        echo "\" ";
        if ((isset($context["isHaveImage"]) || array_key_exists("isHaveImage", $context) ? $context["isHaveImage"] : (function () { throw new RuntimeError('Variable "isHaveImage" does not exist.', 49, $this->source); })())) {
            echo "style=\"border-color: transparent;\"";
        }
        echo ">
\t\t\t\t\t\t\t<input type=\"file\" name=\"solutionImage\" id=\"uv-upload-profile\" accept=\"image/*\">
\t\t\t\t\t\t\t<div class=\"uv-image-upload-placeholder\">
\t\t\t\t\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"48px\" height=\"32px\">
\t\t\t\t\t\t\t\t<path fill-rule=\"evenodd\" d=\"M28.026,26.003 L19.964,26.003 L19.964,17.962 L13.964,17.962 L23.995,8.050 L34.025,17.962 L28.026,17.962 L28.026,26.003 ZM33.557,3.421 C30.806,1.146 27.619,0.008 23.995,0.008 C21.182,0.008 18.588,0.756 16.214,2.252 C13.838,3.749 11.996,5.712 10.683,8.143 C7.683,8.456 5.152,9.749 3.090,12.024 C1.027,14.300 -0.004,16.965 -0.004,20.019 C-0.004,23.324 1.168,26.144 3.512,28.481 C5.855,30.819 8.682,31.988 11.996,31.988 L37.963,31.988 C40.712,31.988 43.072,31.006 45.040,29.042 C47.009,27.079 47.993,24.726 47.993,21.983 C47.993,19.364 47.087,17.106 45.275,15.203 C43.461,13.302 41.275,12.258 38.713,12.071 C38.024,8.580 36.306,5.698 33.557,3.421 Z\"></path>
\t\t\t\t\t\t\t\t</svg>\t
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<img id=\"dynamic-image-upload\" ";
        // line 56
        if ((isset($context["isHaveImage"]) || array_key_exists("isHaveImage", $context) ? $context["isHaveImage"] : (function () { throw new RuntimeError('Variable "isHaveImage" does not exist.', 56, $this->source); })())) {
            echo "src=\"";
            echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 56, $this->source); })()), "request", [], "any", false, false, false, 56), "scheme", [], "any", false, false, false, 56) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 56, $this->source); })()), "request", [], "any", false, false, false, 56), "httpHost", [], "any", false, false, false, 56)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")), "html", null, true);
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["folder"]) || array_key_exists("folder", $context) ? $context["folder"] : (function () { throw new RuntimeError('Variable "folder" does not exist.', 56, $this->source); })()), "solutionImage", [], "any", false, false, false, 56), "html", null, true);
            echo "\"";
        }
        echo ">
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 59
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("An image is worth a thousands words and makes folder more accessible"), "html", null, true);
        echo "</span>
\t\t\t\t</div> 

\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"";
        // line 62
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"submit\">
\t\t\t</form>
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 68
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 69
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
\t
\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar EntityModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'name': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"";
        // line 77
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
\t\t\t\t\t}, {
\t\t\t\t\t\tpattern: '^((?![\$%<]).)*\$',
\t\t\t\t\t\tmsg: \"";
        // line 80
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field must have valid characters only"), "html", null, true);
        echo "\"
\t\t\t\t\t},
\t\t\t\t\t{
\t\t\t\t\t\tmaxLength:40,
\t\t\t\t\t\tmsg:\"";
        // line 84
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field contain maximum 40 charectures."), "html", null, true);
        echo "\"
\t\t\t\t\t}],
\t\t\t\t\t'description': {
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg:\"";
        // line 88
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
\t\t\t\t\t}
\t\t\t\t}
\t\t\t});

\t\t\tvar EntityForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn': \"saveEntity\",
\t\t\t\t\t'blur input, textarea': 'formChanegd',
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t\tvar jsonContext = JSON.parse('";
        // line 100
        echo (isset($context["errors"]) || array_key_exists("errors", $context) ? $context["errors"] : (function () { throw new RuntimeError('Variable "errors" does not exist.', 100, $this->source); })());
        echo "');
\t\t    \t\tfor (var field in jsonContext) {
\t\t    \t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t\t\tif(e.target.name != 'solutionImage'){
\t\t\t    \t\tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \t\tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t\t\t}
\t\t\t    },
\t\t\t\tsaveEntity : function (e) {
\t\t\t\t\te.preventDefault();
\t\t\t        this.model.set(this.\$el.serializeObject());
\t\t\t        if(this.model.isValid(true)) {
\t\t\t\t\t\tthis.\$el.find('.uv-btn').attr('disabled', 'disabled');
\t\t\t            this.\$el.submit();
\t\t\t        }
\t\t\t\t},
\t\t\t});

\t\t\tgroupForm = new EntityForm({
\t\t\t\tel : \$(\"#entity-form\"),
\t\t\t\tmodel : new EntityModel()
\t\t\t});\t
\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Staff/Folders/updateFolder.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  294 => 100,  279 => 88,  272 => 84,  265 => 80,  259 => 77,  247 => 69,  237 => 68,  222 => 62,  216 => 59,  205 => 56,  188 => 49,  186 => 48,  180 => 45,  173 => 41,  165 => 38,  159 => 37,  153 => 34,  146 => 30,  141 => 28,  136 => 26,  129 => 22,  124 => 20,  119 => 18,  112 => 14,  106 => 13,  101 => 11,  98 => 10,  95 => 9,  92 => 8,  89 => 6,  79 => 5,  60 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %}{{ 'Edit Folder'|trans }}{% endblock %}

{% block pageContent %}
\t<div class=\"uv-inner-section\">
        {# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\SupportCenterBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Knowledgebase' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}
\t\t
\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
\t\t\t<h1>{{ 'Edit Folder'|trans }}</h1>
\t\t\t
\t\t\t<form method=\"post\" action=\"\" id=\"entity-form\" enctype=\"multipart/form-data\">
\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Name'|trans }}</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<input type=\"text\" name=\"name\" class=\"uv-field\" value=\"{{ folder.name }}\" />
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">{{ 'Folder Name is shown upfront at Knowledge Base'|trans }}</span>
\t\t\t\t</div>

\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Description'|trans }}</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<textarea name=\"description\" class=\"uv-field\">{{ folder.description }}</textarea>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">{{ 'A small text about the folder helps user to navigate more easily'|trans }}</span>
\t\t\t\t</div>

\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Status'|trans }}</label>
\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t<select class=\"uv-select\" name=\"visibility\">
\t\t\t\t\t\t\t<option value=\"public\" {{ (folder.visibility and folder.visibility == 'public') ? 'selected' : '' }}>{{ 'Publish'|trans }}</option>
\t\t\t\t\t\t\t<option value=\"private\" {{ (folder.visibility and folder.visibility == 'private') ? 'selected' : '' }}>{{ 'Draft'|trans }}</option>
\t\t\t\t\t\t</select>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">{{ 'Choose appropriate status'|trans }}</span>
\t\t\t\t</div>

\t\t\t\t<div class=\"uv-element-block uv-no-error-success-icon\">
\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Folder Image'|trans }}</label>
\t\t\t\t\t<!-- Profile image -->
\t\t\t\t\t<div class=\"uv-image-upload-wrapper\" style=\"padding: 10px 0px 10px 0px; border:none;\">
\t\t\t\t\t\t{% set isHaveImage =  folder  and folder.solutionImage ? 1 : 0 %}
\t\t\t\t\t\t<div class=\"uv-image-upload-brick {% if isHaveImage %}uv-on-drop-shadow{% endif %}\" {% if isHaveImage %}style=\"border-color: transparent;\"{% endif %}>
\t\t\t\t\t\t\t<input type=\"file\" name=\"solutionImage\" id=\"uv-upload-profile\" accept=\"image/*\">
\t\t\t\t\t\t\t<div class=\"uv-image-upload-placeholder\">
\t\t\t\t\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"48px\" height=\"32px\">
\t\t\t\t\t\t\t\t<path fill-rule=\"evenodd\" d=\"M28.026,26.003 L19.964,26.003 L19.964,17.962 L13.964,17.962 L23.995,8.050 L34.025,17.962 L28.026,17.962 L28.026,26.003 ZM33.557,3.421 C30.806,1.146 27.619,0.008 23.995,0.008 C21.182,0.008 18.588,0.756 16.214,2.252 C13.838,3.749 11.996,5.712 10.683,8.143 C7.683,8.456 5.152,9.749 3.090,12.024 C1.027,14.300 -0.004,16.965 -0.004,20.019 C-0.004,23.324 1.168,26.144 3.512,28.481 C5.855,30.819 8.682,31.988 11.996,31.988 L37.963,31.988 C40.712,31.988 43.072,31.006 45.040,29.042 C47.009,27.079 47.993,24.726 47.993,21.983 C47.993,19.364 47.087,17.106 45.275,15.203 C43.461,13.302 41.275,12.258 38.713,12.071 C38.024,8.580 36.306,5.698 33.557,3.421 Z\"></path>
\t\t\t\t\t\t\t\t</svg>\t
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<img id=\"dynamic-image-upload\" {% if isHaveImage %}src=\"{{ app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') }}{{ folder.solutionImage }}\"{% endif %}>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<span class=\"uv-field-info\">{{ 'An image is worth a thousands words and makes folder more accessible'|trans }}</span>
\t\t\t\t</div> 

\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"{{ 'Save Changes'|trans }}\" type=\"submit\">
\t\t\t</form>
\t\t</div>
\t</div>
{% endblock %}

{% block footer %}
\t{{ parent() }}
\t
\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar EntityModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'name': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"{{'This field is mandatory'|trans}}\"
\t\t\t\t\t}, {
\t\t\t\t\t\tpattern: '^((?![\$%<]).)*\$',
\t\t\t\t\t\tmsg: \"{{'This field must have valid characters only'|trans}}\"
\t\t\t\t\t},
\t\t\t\t\t{
\t\t\t\t\t\tmaxLength:40,
\t\t\t\t\t\tmsg:\"{{'This field contain maximum 40 charectures.'|trans}}\"
\t\t\t\t\t}],
\t\t\t\t\t'description': {
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg:\"{{'This field is mandatory'|trans}}\"
\t\t\t\t\t}
\t\t\t\t}
\t\t\t});

\t\t\tvar EntityForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn': \"saveEntity\",
\t\t\t\t\t'blur input, textarea': 'formChanegd',
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t\tvar jsonContext = JSON.parse('{{ errors|raw }}');
\t\t    \t\tfor (var field in jsonContext) {
\t\t    \t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t\t\tif(e.target.name != 'solutionImage'){
\t\t\t    \t\tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \t\tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t\t\t}
\t\t\t    },
\t\t\t\tsaveEntity : function (e) {
\t\t\t\t\te.preventDefault();
\t\t\t        this.model.set(this.\$el.serializeObject());
\t\t\t        if(this.model.isValid(true)) {
\t\t\t\t\t\tthis.\$el.find('.uv-btn').attr('disabled', 'disabled');
\t\t\t            this.\$el.submit();
\t\t\t        }
\t\t\t\t},
\t\t\t});

\t\t\tgroupForm = new EntityForm({
\t\t\t\tel : \$(\"#entity-form\"),
\t\t\t\tmodel : new EntityModel()
\t\t\t});\t
\t\t});
\t</script>
{% endblock %}", "@UVDeskSupportCenter/Staff/Folders/updateFolder.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Staff/Folders/updateFolder.html.twig");
    }
}
