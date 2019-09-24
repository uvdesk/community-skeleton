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

/* @UVDeskMailbox/listConfigurations.html.twig */
class __TwigTemplate_d76abf31ab8152339ffeaebd295fd8a94c27c74ac7990eac3656de3c7ca51951 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'templateCSS' => [$this, 'block_templateCSS'],
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskMailbox/listConfigurations.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskMailbox/listConfigurations.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework/Templates/layout.html.twig", "@UVDeskMailbox/listConfigurations.html.twig", 1);
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

        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Mailbox Settings"), "html", null, true);
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 5
    public function block_templateCSS($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "templateCSS"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "templateCSS"));

        // line 6
        echo "    <style>
\t\t.uv-action-bar {
\t\t\tborder-bottom: 1px solid #d3d3d3;
\t\t\tpadding-bottom: 10px;
\t\t}

\t\t.mailer-id {
\t\t\tfont-weight: 600;
\t\t\tborder: 1px solid #333;
\t\t\tbackground: #cecece;
\t\t\tpadding: 2px 4px 2px;
\t\t\tborder-radius: 2px;
\t\t}

\t\t.uv-app-list-brick {
\t\t\twidth: 310px;
\t\t\tmax-width: 100%;
\t\t\tfont-size: 0;
\t\t\tmargin: 15px 20px 0px 0px;
\t\t\tdisplay: inline-block;
\t\t\tborder-radius: 3px;
\t\t\tborder: solid 1px #7C70F4;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-lt {
\t\t\tdisplay: inline-block;
\t\t\tvertical-align: middle;
\t\t\twidth: 35%;
\t\t\theight: 100%;
\t\t\ttext-align: center;
\t\t\tbackground-color: #7C70F4;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-lt span {
\t\t\tfont-size: 24px;
\t\t\tcolor: #FFFFFF;
\t\t\tpadding: 24px 0px;
\t\t\tdisplay: inline-block;
\t\t\tline-height: 40px;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-rt {
\t\t\twidth: 65%;
\t\t\tpadding: 10px 15px 9px 15px;
\t\t\tdisplay: inline-block;
\t\t\tvertical-align: middle;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-rt p {
\t\t\twidth: 100%;
\t\t\tmargin: 0px;
\t\t\tmargin-bottom: 3px;
\t\t\toverflow: hidden;
\t\t\twhite-space: nowrap;
\t\t\ttext-overflow: ellipsis;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-rt span.uv-app-list-flag-active {
\t\t\tfont-size: 15px;
\t\t\tcolor: #FFFFFF;
\t\t\tbackground-color: #2ED04C;
\t\t\tdisplay: inline-block;
\t\t\tpadding: 0px 7px 1px 7px;
\t\t\tmargin-bottom: 2px;
\t\t\tborder-radius: 3px;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-rt span.uv-app-list-flag-inactive {
\t\t\tfont-size: 15px;
\t\t\tcolor: #FFFFFF;
\t\t\tbackground-color: #FF5656;
\t\t\tdisplay: inline-block;
\t\t\tpadding: 0px 7px 1px 7px;
\t\t\tmargin-bottom: 2px;
\t\t\tborder-radius: 3px;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-rt a:link,
\t\t.uv-app-list-brick .uv-app-list-brick-rt a:focus,
\t\t.uv-app-list-brick .uv-app-list-brick-rt a:hover,
\t\t.uv-app-list-brick .uv-app-list-brick-rt a:active,
\t\t.uv-app-list-brick .uv-app-list-brick-rt a:visited {
\t\t\tfont-size: 15px;
\t\t\tcolor: #2750C4;
\t\t\tmargin-right: 10px;
\t\t\tdisplay: inline-block;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-rt a.uv-delete {
\t\t\tcolor: #FF5656;
\t\t}

\t\t";
        // line 104
        echo "
\t\t.mailbox-del-button {
\t\t    padding: 8px 10px;
    \t\tborder-radius: 3px;
\t\t\tcursor: pointer;
\t\t\t/* vertical-align: middle; */
\t\t\tfont-size: 15px;
\t\t\tdisplay: inline-block;
\t\t\tmargin: 5px 0px;
\t\t\tcolor: #e00d0d;
\t\t}
\t</style>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 118
    public function block_pageContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        // line 119
        echo "\t<div class=\"uv-inner-section\">
        ";
        // line 121
        echo "\t\t";
        $context["asideTemplate"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\AsideTemplate";
        // line 122
        echo "\t\t";
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Settings";
        // line 123
        echo "
\t\t";
        // line 124
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 124, $this->source); })()), "getRegisteredComponent", [0 => (isset($context["asideTemplate"]) || array_key_exists("asideTemplate", $context) ? $context["asideTemplate"] : (function () { throw new RuntimeError('Variable "asideTemplate" does not exist.', 124, $this->source); })())], "method", false, false, false, 124), "renderSidebar", [0 => (isset($context["asideSidebarReference"]) || array_key_exists("asideSidebarReference", $context) ? $context["asideSidebarReference"] : (function () { throw new RuntimeError('Variable "asideSidebarReference" does not exist.', 124, $this->source); })())], "method", false, false, false, 124);
        echo "

\t\t<div class=\"uv-view ";
        // line 126
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 126, $this->source); })()), "request", [], "any", false, false, false, 126), "cookies", [], "any", false, false, false, 126) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 126, $this->source); })()), "request", [], "any", false, false, false, 126), "cookies", [], "any", false, false, false, 126), "get", [0 => "uv-asideView"], "method", false, false, false, 126))) {
            echo "uv-aside-view";
        }
        echo "\">
\t\t\t<div class=\"uv-action-bar\">
                <div class=\"uv-action-bar-col-lt\" style=\"vertical-align: middle;\">
\t\t\t\t\t<h1>";
        // line 129
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Mailbox Settings"), "html", null, true);
        echo "</h1>
                </div>

\t\t\t\t<div class=\"uv-action-bar-col-rt\" style=\"vertical-align: middle;\">
\t\t\t\t\t<a href=\"";
        // line 133
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_mailbox_create_configuration");
        echo "\" type=\"button\" class=\"uv-btn-action\" style=\"margin: unset;\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("New Mailbox"), "html", null, true);
        echo "</a>
\t\t\t\t</div>
            </div>

            <div id=\"mailbox-collection\" class=\"mailbox-collection uv-app-list-channels\">
            </div>
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 143
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 144
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "
\t
\t<script type=\"text/template\" id=\"no_mailers_template\">
        <div class=\"uv-app-screen\">
            <div class=\"uv-app-splash\" style=\"text-align: center;\">
                <img class=\"uv-app-splash-image\" src=\"";
        // line 149
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdeskcoreframework/images/splash/mailbox.png"), "html", null, true);
        echo "\" alt=\"Tasks\">
                <h2 class=\"uv-margin-top-10\">";
        // line 150
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("No mailbox configurations found"), "html", null, true);
        echo "</h2>
            </div>
        </div>\t
\t</script>

\t<script id=\"swiftmailer_configuration_item_template\" type=\"text/template\">
\t\t<div class=\"uv-app-list-brick-rt\" title=\"<%- id %>\" style=\"width: 100%;\">
\t\t\t<p style=\"line-height: 1.4em; margin: unset; margin-bottom: 4px;\">
\t\t\t\t<span style=\"font-weight: 700; text-transform: uppercase;\"><%- id %></span>
\t\t\t</p>
\t\t\t
\t\t\t<p style=\"line-height: 1.4em; margin-bottom: 10px;\">
\t\t\t\t<%- name %> 
\t\t\t</p>
\t\t\t
\t\t\t<p style=\"line-height: 1.4em; margin-bottom: 10px;\">
\t\t\t\t<% if (isEnabled) { %>
\t\t\t\t\t<span class=\"uv-app-list-flag-active\">";
        // line 167
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Enabled"), "html", null, true);
        echo "</span>
\t\t\t\t<% } else { %>
\t\t\t\t\t<span class=\"uv-app-list-flag-inactive\">";
        // line 169
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Disabled"), "html", null, true);
        echo "</span>
\t\t\t\t<% } %>
\t\t\t</p>

\t\t\t<div class=\"uv-app-list-actions\">
\t\t\t\t<a href=\"";
        // line 174
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_mailbox_update_configuration", ["id" => ""]);
        echo "/<%- id %>\"  class=\"edit-mailbox\">
\t\t\t\t\t";
        // line 175
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit"), "html", null, true);
        echo "
\t\t\t\t</a>
\t\t\t\t<div class=\"mailbox-del-button delete-type\">
\t\t\t\t\t";
        // line 178
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Delete"), "html", null, true);
        echo "
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
    </script>

\t<script type=\"text/javascript\">
\t\tvar path = \"";
        // line 185
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_mailbox_update_configuration", ["id" => "replaceId"]);
        echo "\";

\t\t\$(function () {
\t\t\tvar globalMessageResponse = \"\";

\t\t\tvar ConfigurationModel = Backbone.Model.extend({
\t\t\t\tidAttribute : \"id\"
\t\t\t});

\t\t\tvar ConfigurationCollection = AppCollection.extend({
\t\t\t\tmodel: ConfigurationModel,
\t\t\t\turl: \"";
        // line 196
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_mailbox_load_configurations_xhr");
        echo "\",
\t\t\t\tfilterParameters : {
\t\t\t\t\t\"isActive\" : \"\",
\t\t\t\t\t\"search\" : \"\"
\t\t\t\t},
\t\t\t\tparseRecords: function (resp, options) {
\t\t\t\t\treturn resp.types;
\t\t\t\t},
\t\t\t\tinitialize: function() {
\t\t\t\t\tthis.syncData();
\t\t\t\t},
\t\t\t\tsyncData: function() {
\t\t\t\t\tapp.appView.showLoader();

\t\t\t\t\tthis.fetch({
\t\t\t\t\t\tdata: this.getValidParameters(),
\t\t\t\t\t\treset: true,
\t\t\t\t\t\tsuccess: function(model,response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tvar configurationListView = new ConfigurationList(response);

\t\t\t\t\t\t\tif (globalMessageResponse) {
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(globalMessageResponse);
\t\t\t\t\t\t\t}

\t\t\t\t\t\t\tglobalMessageResponse = null;
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t}
\t\t\t});

\t\t\tvar ConfigurationView = Backbone.View.extend({
\t\t\t\ttagName: \"div\",
\t\t\t\tclassName: \"uv-app-list-brick\",
\t\t\t\ttemplate: _.template(\$(\"#swiftmailer_configuration_item_template\").html()),
\t\t\t\tevents: {
\t\t\t\t\t'click .delete-type' : \"confirmRemove\"
\t\t\t\t},
\t\t\t\trender: function() {
\t\t\t\t\tthis.\$el.html(this.template(this.model));
\t\t\t\t\treturn this;
\t\t\t\t},
\t\t\t\tconfirmRemove: function(e) {
\t\t\t\t\te.preventDefault();
\t\t\t\t\tapp.appView.openConfirmModal(this)
\t\t\t\t},
\t\t\t\tremoveItem: function (e) {
\t\t\t\t\tapp.appView.showLoader();
\t\t\t\t\tself = this;
\t\t\t\t
\t\t\t\t\t\$.ajax({
\t\t\t\t\t\turl: \"";
        // line 251
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_mailbox_remove_configuration_xhr");
        echo "/\" + this.model.id,
\t\t\t\t\t\t\tsuccess: function (response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tglobalMessageResponse = response;
\t\t\t\t\t\t\tconfigurationCollection.syncData();
\t\t\t\t\t\t}, 
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif (url = xhr.getResponseHeader('Location')) {
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t\t}

\t\t\t\t\t\t\tvar response = warningResponse;
\t\t\t\t\t\t\t
\t\t\t\t\t\t\tif (xhr.responseJSON) {
\t\t\t\t\t\t\t\tresponse = xhr.responseJSON;
\t\t\t\t\t\t\t}

\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t}
\t\t\t});

\t\t\tvar ConfigurationList = Backbone.View.extend({
\t\t\t\tel: \$(\".mailbox-collection\"),
\t\t\t\ttemplate: _.template(\$(\"#no_mailers_template\").html()),
\t\t\t\tinitialize : function(listItems) {
\t\t\t\t\tthis.render(listItems);
\t\t\t\t},
\t\t\t\trender : function (items) {
\t\t\t\t\tthis.\$el.find(\"div\").remove();
\t\t\t\t\t
\t\t\t\t\tif (items.length > 0) {
\t\t\t\t\t\t_.each(items, function (item) {
\t\t\t\t\t\t\tthis.renderType(item);
\t\t\t\t\t\t}, this);
\t\t\t\t\t} else {
\t\t\t\t\t\tthis.\$el.html(this.template());
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\trenderType : function (item) {
\t\t\t\t\tvar configuration = new ConfigurationView({
\t\t\t\t\t\tmodel: item
\t\t\t\t\t});

\t\t\t\t\tthis.\$el.append(configuration.render().el);
\t\t\t\t}
\t\t\t});

\t\t\tvar configurationCollection = new ConfigurationCollection();
\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskMailbox/listConfigurations.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  417 => 251,  359 => 196,  345 => 185,  335 => 178,  329 => 175,  325 => 174,  317 => 169,  312 => 167,  292 => 150,  288 => 149,  279 => 144,  269 => 143,  248 => 133,  241 => 129,  233 => 126,  228 => 124,  225 => 123,  222 => 122,  219 => 121,  216 => 119,  206 => 118,  184 => 104,  90 => 6,  80 => 5,  61 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework/Templates/layout.html.twig\" %}

{% block title %}{{'Mailbox Settings'|trans}}{% endblock %}

{% block templateCSS %}
    <style>
\t\t.uv-action-bar {
\t\t\tborder-bottom: 1px solid #d3d3d3;
\t\t\tpadding-bottom: 10px;
\t\t}

\t\t.mailer-id {
\t\t\tfont-weight: 600;
\t\t\tborder: 1px solid #333;
\t\t\tbackground: #cecece;
\t\t\tpadding: 2px 4px 2px;
\t\t\tborder-radius: 2px;
\t\t}

\t\t.uv-app-list-brick {
\t\t\twidth: 310px;
\t\t\tmax-width: 100%;
\t\t\tfont-size: 0;
\t\t\tmargin: 15px 20px 0px 0px;
\t\t\tdisplay: inline-block;
\t\t\tborder-radius: 3px;
\t\t\tborder: solid 1px #7C70F4;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-lt {
\t\t\tdisplay: inline-block;
\t\t\tvertical-align: middle;
\t\t\twidth: 35%;
\t\t\theight: 100%;
\t\t\ttext-align: center;
\t\t\tbackground-color: #7C70F4;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-lt span {
\t\t\tfont-size: 24px;
\t\t\tcolor: #FFFFFF;
\t\t\tpadding: 24px 0px;
\t\t\tdisplay: inline-block;
\t\t\tline-height: 40px;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-rt {
\t\t\twidth: 65%;
\t\t\tpadding: 10px 15px 9px 15px;
\t\t\tdisplay: inline-block;
\t\t\tvertical-align: middle;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-rt p {
\t\t\twidth: 100%;
\t\t\tmargin: 0px;
\t\t\tmargin-bottom: 3px;
\t\t\toverflow: hidden;
\t\t\twhite-space: nowrap;
\t\t\ttext-overflow: ellipsis;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-rt span.uv-app-list-flag-active {
\t\t\tfont-size: 15px;
\t\t\tcolor: #FFFFFF;
\t\t\tbackground-color: #2ED04C;
\t\t\tdisplay: inline-block;
\t\t\tpadding: 0px 7px 1px 7px;
\t\t\tmargin-bottom: 2px;
\t\t\tborder-radius: 3px;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-rt span.uv-app-list-flag-inactive {
\t\t\tfont-size: 15px;
\t\t\tcolor: #FFFFFF;
\t\t\tbackground-color: #FF5656;
\t\t\tdisplay: inline-block;
\t\t\tpadding: 0px 7px 1px 7px;
\t\t\tmargin-bottom: 2px;
\t\t\tborder-radius: 3px;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-rt a:link,
\t\t.uv-app-list-brick .uv-app-list-brick-rt a:focus,
\t\t.uv-app-list-brick .uv-app-list-brick-rt a:hover,
\t\t.uv-app-list-brick .uv-app-list-brick-rt a:active,
\t\t.uv-app-list-brick .uv-app-list-brick-rt a:visited {
\t\t\tfont-size: 15px;
\t\t\tcolor: #2750C4;
\t\t\tmargin-right: 10px;
\t\t\tdisplay: inline-block;
\t\t}

\t\t.uv-app-list-brick .uv-app-list-brick-rt a.uv-delete {
\t\t\tcolor: #FF5656;
\t\t}

\t\t{# .uv-app-list-brick-template {
\t\t\twidth: 100%;
\t\t\tpadding: 10px 15px 9px 15px;
\t\t\tdisplay: inline-block;
\t\t\tvertical-align: middle;
\t\t} #}

\t\t.mailbox-del-button {
\t\t    padding: 8px 10px;
    \t\tborder-radius: 3px;
\t\t\tcursor: pointer;
\t\t\t/* vertical-align: middle; */
\t\t\tfont-size: 15px;
\t\t\tdisplay: inline-block;
\t\t\tmargin: 5px 0px;
\t\t\tcolor: #e00d0d;
\t\t}
\t</style>
{% endblock %}

{% block pageContent %}
\t<div class=\"uv-inner-section\">
        {# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Settings' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}

\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
\t\t\t<div class=\"uv-action-bar\">
                <div class=\"uv-action-bar-col-lt\" style=\"vertical-align: middle;\">
\t\t\t\t\t<h1>{{'Mailbox Settings'|trans}}</h1>
                </div>

\t\t\t\t<div class=\"uv-action-bar-col-rt\" style=\"vertical-align: middle;\">
\t\t\t\t\t<a href=\"{{ path('helpdesk_member_mailbox_create_configuration') }}\" type=\"button\" class=\"uv-btn-action\" style=\"margin: unset;\">{{'New Mailbox'|trans}}</a>
\t\t\t\t</div>
            </div>

            <div id=\"mailbox-collection\" class=\"mailbox-collection uv-app-list-channels\">
            </div>
\t\t</div>
\t</div>
{% endblock %}

{% block footer %}
\t{{ parent() }}
\t
\t<script type=\"text/template\" id=\"no_mailers_template\">
        <div class=\"uv-app-screen\">
            <div class=\"uv-app-splash\" style=\"text-align: center;\">
                <img class=\"uv-app-splash-image\" src=\"{{ asset('bundles/uvdeskcoreframework/images/splash/mailbox.png') }}\" alt=\"Tasks\">
                <h2 class=\"uv-margin-top-10\">{{ 'No mailbox configurations found'|trans }}</h2>
            </div>
        </div>\t
\t</script>

\t<script id=\"swiftmailer_configuration_item_template\" type=\"text/template\">
\t\t<div class=\"uv-app-list-brick-rt\" title=\"<%- id %>\" style=\"width: 100%;\">
\t\t\t<p style=\"line-height: 1.4em; margin: unset; margin-bottom: 4px;\">
\t\t\t\t<span style=\"font-weight: 700; text-transform: uppercase;\"><%- id %></span>
\t\t\t</p>
\t\t\t
\t\t\t<p style=\"line-height: 1.4em; margin-bottom: 10px;\">
\t\t\t\t<%- name %> 
\t\t\t</p>
\t\t\t
\t\t\t<p style=\"line-height: 1.4em; margin-bottom: 10px;\">
\t\t\t\t<% if (isEnabled) { %>
\t\t\t\t\t<span class=\"uv-app-list-flag-active\">{{'Enabled'|trans}}</span>
\t\t\t\t<% } else { %>
\t\t\t\t\t<span class=\"uv-app-list-flag-inactive\">{{'Disabled'|trans}}</span>
\t\t\t\t<% } %>
\t\t\t</p>

\t\t\t<div class=\"uv-app-list-actions\">
\t\t\t\t<a href=\"{{ path('helpdesk_member_mailbox_update_configuration', {'id': '' }) }}/<%- id %>\"  class=\"edit-mailbox\">
\t\t\t\t\t{{ \"Edit\"|trans }}
\t\t\t\t</a>
\t\t\t\t<div class=\"mailbox-del-button delete-type\">
\t\t\t\t\t{{ \"Delete\"|trans }}
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
    </script>

\t<script type=\"text/javascript\">
\t\tvar path = \"{{ path('helpdesk_member_mailbox_update_configuration', {'id': 'replaceId' }) }}\";

\t\t\$(function () {
\t\t\tvar globalMessageResponse = \"\";

\t\t\tvar ConfigurationModel = Backbone.Model.extend({
\t\t\t\tidAttribute : \"id\"
\t\t\t});

\t\t\tvar ConfigurationCollection = AppCollection.extend({
\t\t\t\tmodel: ConfigurationModel,
\t\t\t\turl: \"{{ path('helpdesk_member_mailbox_load_configurations_xhr') }}\",
\t\t\t\tfilterParameters : {
\t\t\t\t\t\"isActive\" : \"\",
\t\t\t\t\t\"search\" : \"\"
\t\t\t\t},
\t\t\t\tparseRecords: function (resp, options) {
\t\t\t\t\treturn resp.types;
\t\t\t\t},
\t\t\t\tinitialize: function() {
\t\t\t\t\tthis.syncData();
\t\t\t\t},
\t\t\t\tsyncData: function() {
\t\t\t\t\tapp.appView.showLoader();

\t\t\t\t\tthis.fetch({
\t\t\t\t\t\tdata: this.getValidParameters(),
\t\t\t\t\t\treset: true,
\t\t\t\t\t\tsuccess: function(model,response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tvar configurationListView = new ConfigurationList(response);

\t\t\t\t\t\t\tif (globalMessageResponse) {
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(globalMessageResponse);
\t\t\t\t\t\t\t}

\t\t\t\t\t\t\tglobalMessageResponse = null;
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t}
\t\t\t});

\t\t\tvar ConfigurationView = Backbone.View.extend({
\t\t\t\ttagName: \"div\",
\t\t\t\tclassName: \"uv-app-list-brick\",
\t\t\t\ttemplate: _.template(\$(\"#swiftmailer_configuration_item_template\").html()),
\t\t\t\tevents: {
\t\t\t\t\t'click .delete-type' : \"confirmRemove\"
\t\t\t\t},
\t\t\t\trender: function() {
\t\t\t\t\tthis.\$el.html(this.template(this.model));
\t\t\t\t\treturn this;
\t\t\t\t},
\t\t\t\tconfirmRemove: function(e) {
\t\t\t\t\te.preventDefault();
\t\t\t\t\tapp.appView.openConfirmModal(this)
\t\t\t\t},
\t\t\t\tremoveItem: function (e) {
\t\t\t\t\tapp.appView.showLoader();
\t\t\t\t\tself = this;
\t\t\t\t
\t\t\t\t\t\$.ajax({
\t\t\t\t\t\turl: \"{{ path('helpdesk_member_mailbox_remove_configuration_xhr') }}/\" + this.model.id,
\t\t\t\t\t\t\tsuccess: function (response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tglobalMessageResponse = response;
\t\t\t\t\t\t\tconfigurationCollection.syncData();
\t\t\t\t\t\t}, 
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif (url = xhr.getResponseHeader('Location')) {
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t\t}

\t\t\t\t\t\t\tvar response = warningResponse;
\t\t\t\t\t\t\t
\t\t\t\t\t\t\tif (xhr.responseJSON) {
\t\t\t\t\t\t\t\tresponse = xhr.responseJSON;
\t\t\t\t\t\t\t}

\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t}
\t\t\t});

\t\t\tvar ConfigurationList = Backbone.View.extend({
\t\t\t\tel: \$(\".mailbox-collection\"),
\t\t\t\ttemplate: _.template(\$(\"#no_mailers_template\").html()),
\t\t\t\tinitialize : function(listItems) {
\t\t\t\t\tthis.render(listItems);
\t\t\t\t},
\t\t\t\trender : function (items) {
\t\t\t\t\tthis.\$el.find(\"div\").remove();
\t\t\t\t\t
\t\t\t\t\tif (items.length > 0) {
\t\t\t\t\t\t_.each(items, function (item) {
\t\t\t\t\t\t\tthis.renderType(item);
\t\t\t\t\t\t}, this);
\t\t\t\t\t} else {
\t\t\t\t\t\tthis.\$el.html(this.template());
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\trenderType : function (item) {
\t\t\t\t\tvar configuration = new ConfigurationView({
\t\t\t\t\t\tmodel: item
\t\t\t\t\t});

\t\t\t\t\tthis.\$el.append(configuration.render().el);
\t\t\t\t}
\t\t\t});

\t\t\tvar configurationCollection = new ConfigurationCollection();
\t\t});
\t</script>
{% endblock %}", "@UVDeskMailbox/listConfigurations.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/mailbox-component/Resources/views/listConfigurations.html.twig");
    }
}
