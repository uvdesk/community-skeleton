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

/* @UVDeskSupportCenter/Staff/Articles/articleAddForm.html.twig */
class __TwigTemplate_1a0c1305a145665e9f5a07e1889b6b6fa644d1f8fbb472099d9e02a5a1f2799a extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Staff/Articles/articleAddForm.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Staff/Articles/articleAddForm.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskSupportCenter/Staff/Articles/articleAddForm.html.twig", 1);
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
        echo "\t";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Article"), "html", null, true);
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
\t.uv-tab-error {
\t\tborder-bottom: 3px solid #FF5656 !important;
\t}
\t.mce-menu-item.mce-disabled .mce-text {
\t\tcolor: #333;
\t}
\t</style>
\t<div class=\"uv-inner-section uv-article\">
\t\t";
        // line 18
        echo "\t\t";
        $context["asideTemplate"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\AsideTemplate";
        // line 19
        echo "\t\t";
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\SupportCenterBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Knowledgebase";
        // line 20
        echo "
\t\t";
        // line 21
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 21, $this->source); })()), "getRegisteredComponent", [0 => (isset($context["asideTemplate"]) || array_key_exists("asideTemplate", $context) ? $context["asideTemplate"] : (function () { throw new RuntimeError('Variable "asideTemplate" does not exist.', 21, $this->source); })())], "method", false, false, false, 21), "renderSidebar", [0 => (isset($context["asideSidebarReference"]) || array_key_exists("asideSidebarReference", $context) ? $context["asideSidebarReference"] : (function () { throw new RuntimeError('Variable "asideSidebarReference" does not exist.', 21, $this->source); })())], "method", false, false, false, 21);
        echo "
\t\t
\t\t<div class=\"uv-view ";
        // line 23
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 23, $this->source); })()), "request", [], "any", false, false, false, 23), "cookies", [], "any", false, false, false, 23) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 23, $this->source); })()), "request", [], "any", false, false, false, 23), "cookies", [], "any", false, false, false, 23), "get", [0 => "uv-asideView"], "method", false, false, false, 23))) {
            echo "uv-aside-view";
        }
        echo "\">
\t\t\t<div class=\"uv-ticket-scroll-region uv-margin-0 ";
        // line 24
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 24, $this->source); })()), "request", [], "any", false, false, false, 24), "cookies", [], "any", false, false, false, 24) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 24, $this->source); })()), "request", [], "any", false, false, false, 24), "cookies", [], "any", false, false, false, 24), "get", [0 => "uv-asideView"], "method", false, false, false, 24))) {
            echo "uv-aside-view-tv";
        }
        echo "\">
\t\t\t\t<div class=\"uv-ticket-action-bar\">
\t\t\t\t\t<div class=\"uv-ticket-action-bar-lt\">
\t\t\t\t\t\t<!--Tabs-->
\t\t\t\t\t\t<div class=\"uv-tabs\">
\t\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t\t<li for=\"article-edit\" class=\"uv-tab-active\">";
        // line 30
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Article"), "html", null, true);
        echo "</li>
\t\t\t\t\t\t\t\t<li for=\"article-seo\" style=\"display:inline-block;\">";
        // line 31
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("SEO"), "html", null, true);
        echo "</li>
\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!--Tabs-->
\t\t\t\t\t</div>

\t\t\t\t\t<div class=\"uv-ticket-action-bar-rt\">
\t\t\t\t\t\t<div class=\"uv-action-buttons\">
\t\t\t\t\t\t\t<a href=\"#\" type=\"button\" class=\"uv-btn-action update-btn\">
\t\t\t\t\t\t\t\t";
        // line 40
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save"), "html", null, true);
        echo "
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<!-- Form -->
\t\t\t\t<form method=\"post\" action=\"\" id=\"article-form\" style=\"width: 97%;\">
\t\t\t\t\t<div class=\"uv-tab-view uv-tab-view-active\" id=\"article-edit\">
\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 51
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Title"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<input name=\"name\" class=\"uv-field\" type=\"text\" value=\"";
        // line 53
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 53, $this->source); })()), "name", [], "any", false, false, false, 53), "html", null, true);
        echo "\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block uv-element-block-textarea\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 60
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Content"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block uv-margin-top-5\">
\t\t\t\t\t\t\t\t<textarea name=\"content\" class=\"uv-field\">";
        // line 62
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 62, $this->source); })()), "content", [], "any", false, false, false, 62), "html", null, true);
        echo "</textarea>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->
\t\t\t\t\t</div>

\t\t\t\t\t<div class=\"uv-tab-view\" id=\"article-seo\">
\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 71
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Slug"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<input name=\"slug\" class=\"uv-field\" type=\"text\" value=\"";
        // line 73
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 73, $this->source); })()), "slug", [], "any", false, false, false, 73), "html", null, true);
        echo "\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 75
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Slug is the url identity of this article."), "html", null, true);
        echo "</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 81
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Meta Title"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<input name=\"metaTitle\" class=\"uv-field\" type=\"text\" value=\"";
        // line 83
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 83, $this->source); })()), "metaTitle", [], "any", false, false, false, 83), "html", null, true);
        echo "\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 85
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Title tags and meta descriptions are bits of HTML code in the header of a web page. They help search engines understand the content on a page. A page's title tag and meta description are usually shown whenever that page appears in search engine results"), "html", null, true);
        echo "</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 91
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Meta Keywords"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<input name=\"keywords\" class=\"uv-field\" type=\"text\" value=\"";
        // line 93
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 93, $this->source); })()), "keywords", [], "any", false, false, false, 93), "html", null, true);
        echo "\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<span class=\"uv-field-info\">";
        // line 95
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("comma \",\" separated"), "html", null, true);
        echo "</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">";
        // line 101
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Meta Description"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<textarea name=\"metaDescription\" class=\"uv-field\">";
        // line 103
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["article"]) || array_key_exists("article", $context) ? $context["article"] : (function () { throw new RuntimeError('Variable "article" does not exist.', 103, $this->source); })()), "metaDescription", [], "any", false, false, false, 103), "html", null, true);
        echo "</textarea>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->
\t\t\t\t\t</div>
\t\t\t\t</form>
\t\t\t</div>
\t\t</div>
\t</div>

\t<style>
\t\t.uv-inner-section.uv-article .uv-view .uv-ticket-action-bar{
\t\t\tmargin-top: 20px;
\t\t\tmargin-bottom: 25px;
\t\t}
\t</style>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 121
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 122
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "

\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar globalMessageResponse = \"\";

\t\t\tvar ArticleForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn-action.update-btn' : \"saveArticle\",
\t\t\t\t\t'blur input': 'formChanged',

\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.articleId = \"";
        // line 135
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 135, $this->source); })()), "request", [], "any", false, false, false, 135), "attributes", [], "any", false, false, false, 135), "get", [0 => "id"], "method", false, false, false, 135), "html", null, true);
        echo "\";
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t},
\t\t\t\tformChanged: function(e) {
\t\t\t    \tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t    },
\t\t\t\tsaveArticle: function (e) {
\t\t\t\t\te.preventDefault();
                    \$(\".uv-tabs li\").removeClass('uv-tab-error')
                    currentElement = Backbone.\$(e.currentTarget);
                    //this.model.clear();
\t\t\t\t\tlet formData = this.\$el.find('form#article-form').serializeObject();
\t\t\t        this.model.set(formData);
                    self = this;

\t\t\t\t\tvar contentNotHasError = this.validateForm(e);
                 
\t\t\t        if(this.model.isValid(true) && contentNotHasError) {
\t\t\t\t\t\tformData['ids'] = [this.articleId];
\t\t\t\t\t\tformData['actionType'] = 'articleSave';
\t\t\t\t\t\t//formData['content'] = tinyMCE.get('content').getContent();
\t\t\t\t\t
\t\t\t\t\t\t//formData['content'] = \$('.uv-field').val();
\t\t\t\t\t\tformData['content'] =\$('#content').val();
                   
\t\t\t\t\t\tthis.articleEntityUpdate(formData);
\t\t\t        } else {
\t\t\t\t\t\tconsole.log(\"fail\");

                        \$('.uv-field-message').each(function(e) {
                            \$(\".uv-tabs li[for='\" + \$(this).parents('.uv-tab-view').attr('id') + \"']:not(.uv-tab-active)\").addClass('uv-tab-error')
                        });
                    }
\t\t\t\t},
                validateForm : function(e) {
                    var element = Backbone.\$(e.currentTarget);
                    formType = 'content';
                    form = \$('#article-form');
                    form.find('.uv-field-message').remove()

                   // var html = tinyMCE.get(formType).getContent();
                    var html = \$('#content').val();

\t\t\t\t\tconsole.log(\"message value : \",html);

                    if(app.appView.htmlText(html).trim().length != 0) {
\t\t\t\t\t\treturn true;
                    } else {
                        form.find('.uv-element-block-textarea').append(\"<span class='uv-field-message'>";
        // line 184
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "</span>\");
                    }
                },
                addErrors: function(jsonContext) {
\t\t    \t\tfor (var field in jsonContext) {
\t\t    \t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
                },
\t\t\t\tarticleEntityUpdate : function(data) {
                    var self = this;
                    app.appView.showLoader();
                    \$.ajax({
                        url : \"";
        // line 196
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_update_article_xhr");
        echo "\",
                        type : 'POST',
                        data : {data : data},
                        dataType : 'json',
                        success : function(response) {
                            app.appView.hideLoader();

\t\t\t\t\t\t\tif(response.alertClass == \"success\") {
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t\t\tif(response.redirect)
\t\t\t\t\t\t\t\t\twindow.location = response.redirect;
\t\t\t\t\t\t\t} else{
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t\t\tself.addErrors(response.errors);
\t\t\t\t\t\t\t}
                        },
                        error: function (xhr) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        }
                    });
                },
\t\t\t});

            var ArticleModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'name': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"";
        // line 230
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
\t\t\t\t\t},{
\t\t\t\t\t\tmaxLength:200,
\t\t\t\t\t\tmsg: 'This field contain maximum 200 charecters only'
\t\t\t\t\t}, {
\t\t\t\t\t\tpattern: '^((?![\$%<]).)*\$',
\t\t\t\t\t\tmsg: 'This field must have valid characters only'
\t\t\t\t\t}],
\t\t\t\t\t'slug': function(val, attr, computed) {
\t\t\t\t\t\tvar elSlug = \$(\"[name=\" + attr + \"]\");
\t\t\t\t\t\tvar elSlugValue = '';
\t\t\t\t\t\telSlug.val(elSlugValue = app.appView.convertToSlug(val))
\t\t\t\t\t\t
\t\t\t\t\t\tif(elSlugValue.trim() == ''){
\t\t\t\t\t\t\treturn '";
        // line 244
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "';
\t\t\t\t\t\t}
\t\t\t\t\t\t
\t\t\t\t\t\tif(elSlugValue.length > 100) {
\t\t\t\t\t\t\tconsole.log(\"invalid lenth\");
\t\t\t\t\t\t\treturn \"This field slug contains maximum 100 charecters only.\";

\t\t\t\t\t\t}
\t\t\t\t\t}
\t\t\t\t},
                urlRoot : \"";
        // line 254
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_update_article_xhr");
        echo "\"
\t\t\t});

\t\t\tvar articlemodel = new ArticleModel({
                id : \"\",
                name : \"\",
\t\t\t})

\t\t\tarticleForm = new ArticleForm({
                el: '.uv-paper',
\t\t\t\tmodel : articlemodel
\t\t\t});

\t\t});
\t</script>

\t";
        // line 270
        echo twig_include($this->env, $context, "@UVDeskSupportCenter/Templates/tinyMCE.html.twig");
        echo "
\t
    <script>
\t\tvar toolbarOptions = sfTinyMce.options.toolbar;
        sfTinyMce.init({
\t\t\tselector: 'textarea[name*=\"content\"]',
\t\t\ttoolbar: toolbarOptions + ' | insert | styleselect | alignleft aligncenter alignright alignjustify | outdent indent | code | translate',
\t\t\tsetup: function (editor) {
                addTranslateButton(editor);
\t\t\t},
        });
    </script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Staff/Articles/articleAddForm.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  466 => 270,  447 => 254,  434 => 244,  417 => 230,  380 => 196,  365 => 184,  313 => 135,  296 => 122,  286 => 121,  259 => 103,  254 => 101,  245 => 95,  240 => 93,  235 => 91,  226 => 85,  221 => 83,  216 => 81,  207 => 75,  202 => 73,  197 => 71,  185 => 62,  180 => 60,  170 => 53,  165 => 51,  151 => 40,  139 => 31,  135 => 30,  124 => 24,  118 => 23,  113 => 21,  110 => 20,  107 => 19,  104 => 18,  93 => 8,  83 => 7,  70 => 4,  60 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %}
\t{{ 'Article'|trans }}
{% endblock %}

{% block pageContent %}
\t<style>
\t.uv-tab-error {
\t\tborder-bottom: 3px solid #FF5656 !important;
\t}
\t.mce-menu-item.mce-disabled .mce-text {
\t\tcolor: #333;
\t}
\t</style>
\t<div class=\"uv-inner-section uv-article\">
\t\t{# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\SupportCenterBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Knowledgebase' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}
\t\t
\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
\t\t\t<div class=\"uv-ticket-scroll-region uv-margin-0 {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view-tv{% endif %}\">
\t\t\t\t<div class=\"uv-ticket-action-bar\">
\t\t\t\t\t<div class=\"uv-ticket-action-bar-lt\">
\t\t\t\t\t\t<!--Tabs-->
\t\t\t\t\t\t<div class=\"uv-tabs\">
\t\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t\t<li for=\"article-edit\" class=\"uv-tab-active\">{{ 'Article'|trans }}</li>
\t\t\t\t\t\t\t\t<li for=\"article-seo\" style=\"display:inline-block;\">{{ 'SEO'|trans }}</li>
\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!--Tabs-->
\t\t\t\t\t</div>

\t\t\t\t\t<div class=\"uv-ticket-action-bar-rt\">
\t\t\t\t\t\t<div class=\"uv-action-buttons\">
\t\t\t\t\t\t\t<a href=\"#\" type=\"button\" class=\"uv-btn-action update-btn\">
\t\t\t\t\t\t\t\t{{'Save'|trans}}
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<!-- Form -->
\t\t\t\t<form method=\"post\" action=\"\" id=\"article-form\" style=\"width: 97%;\">
\t\t\t\t\t<div class=\"uv-tab-view uv-tab-view-active\" id=\"article-edit\">
\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Title'|trans }}</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<input name=\"name\" class=\"uv-field\" type=\"text\" value=\"{{ article.name }}\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block uv-element-block-textarea\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Content'|trans }}</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block uv-margin-top-5\">
\t\t\t\t\t\t\t\t<textarea name=\"content\" class=\"uv-field\">{{article.content}}</textarea>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->
\t\t\t\t\t</div>

\t\t\t\t\t<div class=\"uv-tab-view\" id=\"article-seo\">
\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Slug'|trans }}</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<input name=\"slug\" class=\"uv-field\" type=\"text\" value=\"{{ article.slug }}\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<span class=\"uv-field-info\">{{'Slug is the url identity of this article.'|trans}}</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Meta Title'|trans }}</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<input name=\"metaTitle\" class=\"uv-field\" type=\"text\" value=\"{{ article.metaTitle }}\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<span class=\"uv-field-info\">{{\"Title tags and meta descriptions are bits of HTML code in the header of a web page. They help search engines understand the content on a page. A page's title tag and meta description are usually shown whenever that page appears in search engine results\"|trans}}</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Meta Keywords'|trans }}</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<input name=\"keywords\" class=\"uv-field\" type=\"text\" value=\"{{ article.keywords }}\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<span class=\"uv-field-info\">{{'comma \",\" separated'|trans}}</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->

\t\t\t\t\t\t<!-- Field -->
\t\t\t\t\t\t<div class=\"uv-element-block\">
\t\t\t\t\t\t\t<label class=\"uv-field-label\">{{ 'Meta Description'|trans }}</label>
\t\t\t\t\t\t\t<div class=\"uv-field-block\">
\t\t\t\t\t\t\t\t<textarea name=\"metaDescription\" class=\"uv-field\">{{article.metaDescription}}</textarea>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<!-- //Field -->
\t\t\t\t\t</div>
\t\t\t\t</form>
\t\t\t</div>
\t\t</div>
\t</div>

\t<style>
\t\t.uv-inner-section.uv-article .uv-view .uv-ticket-action-bar{
\t\t\tmargin-top: 20px;
\t\t\tmargin-bottom: 25px;
\t\t}
\t</style>
{% endblock %}

{% block footer %}
\t{{ parent() }}

\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar globalMessageResponse = \"\";

\t\t\tvar ArticleForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn-action.update-btn' : \"saveArticle\",
\t\t\t\t\t'blur input': 'formChanged',

\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.articleId = \"{{app.request.attributes.get('id')}}\";
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t},
\t\t\t\tformChanged: function(e) {
\t\t\t    \tthis.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
\t\t\t    \tthis.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
\t\t\t    },
\t\t\t\tsaveArticle: function (e) {
\t\t\t\t\te.preventDefault();
                    \$(\".uv-tabs li\").removeClass('uv-tab-error')
                    currentElement = Backbone.\$(e.currentTarget);
                    //this.model.clear();
\t\t\t\t\tlet formData = this.\$el.find('form#article-form').serializeObject();
\t\t\t        this.model.set(formData);
                    self = this;

\t\t\t\t\tvar contentNotHasError = this.validateForm(e);
                 
\t\t\t        if(this.model.isValid(true) && contentNotHasError) {
\t\t\t\t\t\tformData['ids'] = [this.articleId];
\t\t\t\t\t\tformData['actionType'] = 'articleSave';
\t\t\t\t\t\t//formData['content'] = tinyMCE.get('content').getContent();
\t\t\t\t\t
\t\t\t\t\t\t//formData['content'] = \$('.uv-field').val();
\t\t\t\t\t\tformData['content'] =\$('#content').val();
                   
\t\t\t\t\t\tthis.articleEntityUpdate(formData);
\t\t\t        } else {
\t\t\t\t\t\tconsole.log(\"fail\");

                        \$('.uv-field-message').each(function(e) {
                            \$(\".uv-tabs li[for='\" + \$(this).parents('.uv-tab-view').attr('id') + \"']:not(.uv-tab-active)\").addClass('uv-tab-error')
                        });
                    }
\t\t\t\t},
                validateForm : function(e) {
                    var element = Backbone.\$(e.currentTarget);
                    formType = 'content';
                    form = \$('#article-form');
                    form.find('.uv-field-message').remove()

                   // var html = tinyMCE.get(formType).getContent();
                    var html = \$('#content').val();

\t\t\t\t\tconsole.log(\"message value : \",html);

                    if(app.appView.htmlText(html).trim().length != 0) {
\t\t\t\t\t\treturn true;
                    } else {
                        form.find('.uv-element-block-textarea').append(\"<span class='uv-field-message'>{{ 'This field is mandatory'|trans }}</span>\");
                    }
                },
                addErrors: function(jsonContext) {
\t\t    \t\tfor (var field in jsonContext) {
\t\t    \t\t\tBackbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
\t\t\t\t\t}
                },
\t\t\t\tarticleEntityUpdate : function(data) {
                    var self = this;
                    app.appView.showLoader();
                    \$.ajax({
                        url : \"{{ path('helpdesk_member_knowledgebase_update_article_xhr') }}\",
                        type : 'POST',
                        data : {data : data},
                        dataType : 'json',
                        success : function(response) {
                            app.appView.hideLoader();

\t\t\t\t\t\t\tif(response.alertClass == \"success\") {
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t\t\tif(response.redirect)
\t\t\t\t\t\t\t\t\twindow.location = response.redirect;
\t\t\t\t\t\t\t} else{
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t\t\tself.addErrors(response.errors);
\t\t\t\t\t\t\t}
                        },
                        error: function (xhr) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        }
                    });
                },
\t\t\t});

            var ArticleModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'name': [{
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: \"{{'This field is mandatory'|trans}}\"
\t\t\t\t\t},{
\t\t\t\t\t\tmaxLength:200,
\t\t\t\t\t\tmsg: 'This field contain maximum 200 charecters only'
\t\t\t\t\t}, {
\t\t\t\t\t\tpattern: '^((?![\$%<]).)*\$',
\t\t\t\t\t\tmsg: 'This field must have valid characters only'
\t\t\t\t\t}],
\t\t\t\t\t'slug': function(val, attr, computed) {
\t\t\t\t\t\tvar elSlug = \$(\"[name=\" + attr + \"]\");
\t\t\t\t\t\tvar elSlugValue = '';
\t\t\t\t\t\telSlug.val(elSlugValue = app.appView.convertToSlug(val))
\t\t\t\t\t\t
\t\t\t\t\t\tif(elSlugValue.trim() == ''){
\t\t\t\t\t\t\treturn '{{ \"This field is mandatory\"|trans }}';
\t\t\t\t\t\t}
\t\t\t\t\t\t
\t\t\t\t\t\tif(elSlugValue.length > 100) {
\t\t\t\t\t\t\tconsole.log(\"invalid lenth\");
\t\t\t\t\t\t\treturn \"This field slug contains maximum 100 charecters only.\";

\t\t\t\t\t\t}
\t\t\t\t\t}
\t\t\t\t},
                urlRoot : \"{{ path('helpdesk_member_knowledgebase_update_article_xhr') }}\"
\t\t\t});

\t\t\tvar articlemodel = new ArticleModel({
                id : \"\",
                name : \"\",
\t\t\t})

\t\t\tarticleForm = new ArticleForm({
                el: '.uv-paper',
\t\t\t\tmodel : articlemodel
\t\t\t});

\t\t});
\t</script>

\t{{ include('@UVDeskSupportCenter/Templates/tinyMCE.html.twig') }}
\t
    <script>
\t\tvar toolbarOptions = sfTinyMce.options.toolbar;
        sfTinyMce.init({
\t\t\tselector: 'textarea[name*=\"content\"]',
\t\t\ttoolbar: toolbarOptions + ' | insert | styleselect | alignleft aligncenter alignright alignjustify | outdent indent | code | translate',
\t\t\tsetup: function (editor) {
                addTranslateButton(editor);
\t\t\t},
        });
    </script>
{% endblock %}
", "@UVDeskSupportCenter/Staff/Articles/articleAddForm.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Staff/Articles/articleAddForm.html.twig");
    }
}
