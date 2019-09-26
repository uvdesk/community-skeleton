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

/* @UVDeskExtensionFramework/dashboard.html.twig */
class __TwigTemplate_6817f04e579c17a92a05408c722b38969d38827e978a21e496ed33c074b0cc1f extends \Twig\Template
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
        return "@UVDeskCoreFramework//Templates//layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskExtensionFramework/dashboard.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskExtensionFramework/dashboard.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskExtensionFramework/dashboard.html.twig", 1);
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

        echo "Apps Dashboard";
        
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
\t\t.uv-mob-aside {
\t\t\tdisplay: none;
\t\t}

        .uv-app-banner {
\t\t\twidth: 120px;
\t\t\theight: 120px;
\t\t\tpadding: 30px;
\t\t\tborder-radius: 50%;
\t\t\tmargin: 0 auto 20px;
\t\t\tbackground-position: center;
\t\t\tbackground-size: cover;
        }
    </style>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 23
    public function block_pageContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        // line 24
        echo "\t<div class=\"uv-inner-section\">
\t\t<div class=\"uv-view\" style=\"padding-left: 20px;\">
\t\t\t<h1 id=\"app-current-title\">";
        // line 26
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Installed Applications"), "html", null, true);
        echo "</h1>

\t\t\t<div class=\"uv-hr\"></div>

\t\t\t";
        // line 31
        echo "\t\t\t<div class=\"uv-view-plank\" id=\"application-list\"></div>

\t\t\t";
        // line 34
        echo "\t\t\t<div class=\"navigation\"></div>
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 39
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 40
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "

\t<script id=\"application_list_sorting_tmp\" type=\"text/template\">
        <li class=\"<% if(sort == 'a.name') { %>uv-drop-list-active<% } %>\">
            <a href=\"#<% if(queryString != '') { %><%= queryString %>/<% } %><% if(page) { %>page/<%= page %><% } else { %>page/1<% } %>/sort/a.name/<% if(sort == 'a.name') { %><% if(direction) { %>direction/<%= direction %><% } else { %>direction/desc<% } %><% } else { %>direction/asc<% } %>\" data-field=\"a.name\">
                Name
                <% if(sort == 'a.name') { %>
\t\t\t\t\t<span class=\"uv-sorting <% if(direction == 'asc') { %> descend <% } else { %> ascend <% } %>\"></span>
\t\t\t\t<% } %>
            </a>
        </li>
\t</script>

\t<script id=\"application_list_item_tmp\" type=\"text/template\">
\t\t<% pathToApplication = \"";
        // line 54
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("uvdesk_extensions_standalone_application_dashboard", ["vendor" => "rep_v", "package" => "rep_e", "qualifiedName" => "rep_q"]), "html", null, true);
        echo "\" %>
\t\t<% pathToApplication = pathToApplication.replace('rep_v', reference.vendor).replace('rep_e', reference.package).replace('rep_q', qname) %>

\t\t<a href=\"<%= pathToApplication %>\">
\t\t\t<div class=\"uv-app-banner\" style=\"background-image: url('<%= icon %>')\"></div>
\t\t\t<h4 style=\"color: #464646; line-height: 1.4em; text-align: center; font-weight: normal;\"><%= name %></h4>
\t\t</a>
    </script>

\t<script type=\"text/template\" id=\"no-result-temp\">
        <div class=\"uv-app-screen\">
            <div class=\"uv-app-splash\" style=\"text-align: center;\">
                <h2 class=\"uv-margin-top-10\">";
        // line 66
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Nothing Interesting here"), "html", null, true);
        echo "</h2>
            </div>
        </div>
\t</script>

\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar globalMessageResponse = \"\";

\t\t\tvar ApplicationModel = Backbone.Model.extend({
\t\t\t\tidAttribute : \"id\",
\t\t\t});

\t\t\tvar ApplicationCollection = AppCollection.extend({
\t\t\t\tmodel : ApplicationModel,
\t\t\t\turl : \"";
        // line 81
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("uvdesk_extensions_applications_dashboard_xhr");
        echo "\",
\t\t\t\tfilterParameters : {
\t\t\t\t\t\"category\" : \"\",
\t\t\t\t\t\"type\" : \"\",
\t\t\t\t\t\"installed\": \"\",
\t\t\t\t},
\t\t\t\tparseRecords: function (resp, options) {
\t\t\t\t\treturn resp;
\t\t\t\t},
\t\t\t\tsyncData : function() {
\t\t\t\t\tapp.appView.showLoader();
\t\t\t\t\tself = this;
\t\t\t\t\tthis.fetch({
\t\t\t\t\t\tdata : self.getValidParameters(),
\t\t\t\t\t\treset: true,
\t\t\t\t\t\tsuccess: function(model, response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tvar appListView = new ApplicationList();

\t\t\t\t\t\t\tif (globalMessageResponse) {
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(globalMessageResponse);
\t\t\t\t\t\t\t}

\t\t\t\t\t\t\tglobalMessageResponse = null;
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif (url = xhr.getResponseHeader('Location')) {
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t\t}
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t}
\t\t\t});

\t\t\tvar ApplicationItem = Backbone.View.extend({
\t\t\t\ttagName : \"div\",
\t\t\t\tclassName: 'uv-app-wrapper',
\t\t\t\ttemplate : _.template(\$(\"#application_list_item_tmp\").html()),
\t\t\t\trender : function() {
\t\t\t\t\tthis.\$el.html(this.template(this.model.toJSON()));
\t\t\t\t\treturn this;
\t\t\t\t}
\t\t\t});

\t\t\tvar ApplicationList = Backbone.View.extend({
\t\t\t\tel : \$(\"#application-list\"),
\t\t\t\tinitialize : function() {
\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\tthis.render();
\t\t\t\t},
\t\t\t\trender : function () {
\t\t\t\t\tthis.\$el.html('');
\t\t\t\t\tif(applicationCollection.length) {
\t\t\t\t\t\t_.each(applicationCollection.models, function (item) {
\t\t\t\t\t\t\tthis.renderType(item);
\t\t\t\t\t\t}, this);
\t\t\t\t\t} else {
\t\t\t\t\t\tthis.\$el.append(_.template(\$('#no-result-temp').html()))
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\trenderType : function (item) {
\t\t\t\t\tvar applicationItem = new ApplicationItem({
\t\t\t\t\t\tmodel: item
\t\t\t\t\t});
\t\t\t\t\tthis.\$el.append(applicationItem.render().el);
\t\t\t\t},
\t\t\t});

            var Filter = app.Filter.extend({
\t\t\t\tdefaultSortIndex: 'createdAt',
\t\t\t\tsortText: \"";
        // line 151
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Sort By:"), "html", null, true);
        echo " \",
\t\t\t\tdefaultSortText: \"";
        // line 152
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Sort By:"), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Date Released"), "html", null, true);
        echo "\",
\t\t\t\ttemplate : _.template(\$(\"#application_list_sorting_tmp\").html()),
                events : {
                    'keyup .uv-search-inline' : 'search',
                    'change .asset-visibility input[type=\"checkbox\"]': 'filterAssetsVisibility'
                },
                search : _.debounce(function(e) {
                    this.collection.reset();
                    this.collection.state.currentPage = null;
                    this.collection.filterParameters.search = Backbone.\$(e.target).val();
                    var queryString = this.buildQuery(\$.param(this.collection.getValidParameters()));
                    router.navigate(queryString,{trigger: true});
                }, 1000),
\t\t\t\tsortCollection : function(sortField,order) {
\t\t\t\t\tvar context = {};
\t\t\t\t\tcontext['queryString'] = this.buildQuery(\$.param(this.collection.getValidParameters()));
\t\t\t\t\tif(typeof sortField != 'undefined' && sortField != null) {
\t\t\t\t\t\tcontext['page'] = this.collection.state.currentPage;
\t\t\t\t\t\tcontext['sort'] = sortField;

\t\t\t\t\t\tif(order == 'asc') {
\t\t\t\t\t\t\tcontext['direction'] = 'desc';
\t\t\t\t\t\t\torder = -1;
\t\t\t\t\t\t} else {
\t\t\t\t\t\t\tcontext['direction'] = 'asc';
\t\t\t\t\t\t\torder = 1;
\t\t\t\t\t\t}

\t\t\t\t\t\t\$(\".sort .uv-dropdown-list ul\").html(this.template(context));
\t\t\t\t\t\tvar selectedText = \$(\".sort a[data-field='\"+sortField+\"']\").text();
\t\t\t\t\t\t\$(\".sort .uv-dropdown-btn\").text(this.sortText + selectedText);
\t\t\t\t\t\tthis.collection.setSorting(sortField, order, {full: true});
\t\t\t\t\t} else {
\t\t\t\t\t\t\$(\".sort .uv-dropdown-btn\").text(this.defaultSortText);
\t\t\t\t\t\tcontext['page'] = this.collection.state.currentPage;
\t\t\t\t\t\tcontext['sort'] = this.defaultSortIndex;
\t\t\t\t\t\tcontext['direction'] = 'asc';
\t\t\t\t\t\t\$(\".sort .uv-dropdown-list ul\").html(this.template(context));
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tbuildQuery: function(query) {
\t\t\t\t\tquery = query.replace(/&/g, '/');
\t\t\t\t\tquery = query.replace(/=/g, '/');
\t\t\t\t\tif (query.indexOf(\"type/free\") >= 0)
\t\t\t\t\t\tquery = query.replace('type/free', 'free')
\t\t\t\t\telse if (query.indexOf(\"type/premium\") >= 0)
\t\t\t\t\t\tquery = query.replace('type/premium', 'premium')
\t\t\t\t\telse if (query.indexOf(\"installed/1\") >= 0)
\t\t\t\t\t\tquery = query.replace('installed/1', 'installed')
\t\t\t\t\telse if (query.indexOf(\"category/\") >= 0)
\t\t\t\t\t\tquery = query.replace('category/', '');
\t\t\t\t\treturn query;
\t\t\t\t},
\t\t\t})

\t\t\tRouter = Backbone.Router.extend({
\t\t\t\troutes: {
\t\t\t\t\t'page/:number(/sort/:sortField)(/direction/:order)': 'paginate',
                    'search/:query(/page/:number)(/sort/:sortField)(/direction/:order)' : 'filterByQuery',
\t\t\t\t\t'free(/search/:query)(/page/:number)(/sort/:sortField)(/direction/:order)': 'filterFreeApps',
\t\t\t\t\t'premium(/search/:query)(/page/:number)(/sort/:sortField)(/direction/:order)': 'filterPremiumApps',
\t\t\t\t\t'installed(/search/:query)(/page/:number)(/sort/:sortField)(/direction/:order)': 'filterInstalledApps',
\t\t\t\t\t':category(/search/:query)(/:pricing)(/page/:number)(/sort/:sortField)(/direction/:order)' : 'filterByCategory',
\t\t\t\t\t'': 'initializeList',
\t\t\t\t},
\t\t\t\tpaginate : function(number, sortField, order) {
\t\t\t\t\tthis.resetParams('', '',  '', '', number, sortField, order, '";
        // line 218
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("All"), "html", null, true);
        echo "');
\t\t\t\t},
\t\t\t\tfilterByQuery: function(query, number, sortField, order) {
\t\t\t\t\tthis.resetParams(query, '', '', '', number, sortField, order, '";
        // line 221
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("All"), "html", null, true);
        echo "');
\t\t\t\t},
\t\t\t\tfilterByCategory: function(category, query, pricing, number, sortField, order) {
\t\t\t\t\tif('free' != pricing && 'premium' != pricing) {
\t\t\t\t\t\tpricing = '';
\t\t\t\t\t}
\t\t\t\t\tthis.resetParams(query, category, pricing, '', number, sortField, order, category);
\t\t\t\t},
\t\t\t\tfilterFreeApps: function(query, number, sortField, order) {
\t\t\t\t\tthis.resetParams(query, '', 'free', '', number, sortField, order, '";
        // line 230
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Free"), "html", null, true);
        echo "');

\t\t\t\t},
\t\t\t\tfilterPremiumApps: function(query, number, sortField, order) {
\t\t\t\t\tthis.resetParams(query, '', 'premium', '', number, sortField, order, '";
        // line 234
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Premium"), "html", null, true);
        echo "');
\t\t\t\t},
\t\t\t\tfilterInstalledApps: function(query, number, sortField, order) {
\t\t\t\t\tthis.resetParams(query, '', '', true, number, sortField, order, '";
        // line 237
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Installed"), "html", null, true);
        echo "');
\t\t\t\t},
\t\t\t\tinitializeList : function() {
\t\t\t\t\tthis.resetParams('', '','', '', null, null, null, 'All');
\t\t\t\t},
\t\t\t\tresetParams : function(query, category, pricing, installedFlag, number, sortField, order, titleText) {
\t\t\t\t\tapplicationCollection.filterParameters.category = category;
\t\t\t\t\tapplicationCollection.filterParameters.type = pricing;
\t\t\t\t\tapplicationCollection.filterParameters.installed = installedFlag ? 1 : null;
\t\t\t\t\tapplicationCollection.state.currentPage = number;

                    if(query != null) {
                        query = query.replace(/\\+/g,' ');
\t\t\t\t\t}
                    applicationCollection.filterParameters.search = query;
                    \$(\".uv-search-inline\").val(query);

\t\t\t\t\tfilter.sortCollection(sortField, order);
\t\t\t\t\tapplicationCollection.syncData();
\t\t\t\t},
\t\t\t});

\t\t\tvar applicationCollection = new ApplicationCollection();

\t\t\tvar filter = new Filter({
                collection : applicationCollection
            });

\t\t\trouter = new Router();
\t\t\tBackbone.history.start({push_state:true});
\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskExtensionFramework/dashboard.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  393 => 237,  387 => 234,  380 => 230,  368 => 221,  362 => 218,  291 => 152,  287 => 151,  214 => 81,  196 => 66,  181 => 54,  163 => 40,  153 => 39,  140 => 34,  136 => 31,  129 => 26,  125 => 24,  115 => 23,  90 => 6,  80 => 5,  61 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %}Apps Dashboard{% endblock %}

{% block templateCSS %}
    <style>
\t\t.uv-mob-aside {
\t\t\tdisplay: none;
\t\t}

        .uv-app-banner {
\t\t\twidth: 120px;
\t\t\theight: 120px;
\t\t\tpadding: 30px;
\t\t\tborder-radius: 50%;
\t\t\tmargin: 0 auto 20px;
\t\t\tbackground-position: center;
\t\t\tbackground-size: cover;
        }
    </style>
{% endblock %}

{% block pageContent %}
\t<div class=\"uv-inner-section\">
\t\t<div class=\"uv-view\" style=\"padding-left: 20px;\">
\t\t\t<h1 id=\"app-current-title\">{{'Installed Applications'|trans}}</h1>

\t\t\t<div class=\"uv-hr\"></div>

\t\t\t{# App Listing #}
\t\t\t<div class=\"uv-view-plank\" id=\"application-list\"></div>

\t\t\t{# Navigate Listing #}
\t\t\t<div class=\"navigation\"></div>
\t\t</div>
\t</div>
{% endblock %}

{% block footer %}
\t{{ parent() }}

\t<script id=\"application_list_sorting_tmp\" type=\"text/template\">
        <li class=\"<% if(sort == 'a.name') { %>uv-drop-list-active<% } %>\">
            <a href=\"#<% if(queryString != '') { %><%= queryString %>/<% } %><% if(page) { %>page/<%= page %><% } else { %>page/1<% } %>/sort/a.name/<% if(sort == 'a.name') { %><% if(direction) { %>direction/<%= direction %><% } else { %>direction/desc<% } %><% } else { %>direction/asc<% } %>\" data-field=\"a.name\">
                Name
                <% if(sort == 'a.name') { %>
\t\t\t\t\t<span class=\"uv-sorting <% if(direction == 'asc') { %> descend <% } else { %> ascend <% } %>\"></span>
\t\t\t\t<% } %>
            </a>
        </li>
\t</script>

\t<script id=\"application_list_item_tmp\" type=\"text/template\">
\t\t<% pathToApplication = \"{{ path('uvdesk_extensions_standalone_application_dashboard', {'vendor': 'rep_v', 'package': 'rep_e', 'qualifiedName': 'rep_q'}) }}\" %>
\t\t<% pathToApplication = pathToApplication.replace('rep_v', reference.vendor).replace('rep_e', reference.package).replace('rep_q', qname) %>

\t\t<a href=\"<%= pathToApplication %>\">
\t\t\t<div class=\"uv-app-banner\" style=\"background-image: url('<%= icon %>')\"></div>
\t\t\t<h4 style=\"color: #464646; line-height: 1.4em; text-align: center; font-weight: normal;\"><%= name %></h4>
\t\t</a>
    </script>

\t<script type=\"text/template\" id=\"no-result-temp\">
        <div class=\"uv-app-screen\">
            <div class=\"uv-app-splash\" style=\"text-align: center;\">
                <h2 class=\"uv-margin-top-10\">{{'Nothing Interesting here'|trans}}</h2>
            </div>
        </div>
\t</script>

\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar globalMessageResponse = \"\";

\t\t\tvar ApplicationModel = Backbone.Model.extend({
\t\t\t\tidAttribute : \"id\",
\t\t\t});

\t\t\tvar ApplicationCollection = AppCollection.extend({
\t\t\t\tmodel : ApplicationModel,
\t\t\t\turl : \"{{ path('uvdesk_extensions_applications_dashboard_xhr') }}\",
\t\t\t\tfilterParameters : {
\t\t\t\t\t\"category\" : \"\",
\t\t\t\t\t\"type\" : \"\",
\t\t\t\t\t\"installed\": \"\",
\t\t\t\t},
\t\t\t\tparseRecords: function (resp, options) {
\t\t\t\t\treturn resp;
\t\t\t\t},
\t\t\t\tsyncData : function() {
\t\t\t\t\tapp.appView.showLoader();
\t\t\t\t\tself = this;
\t\t\t\t\tthis.fetch({
\t\t\t\t\t\tdata : self.getValidParameters(),
\t\t\t\t\t\treset: true,
\t\t\t\t\t\tsuccess: function(model, response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tvar appListView = new ApplicationList();

\t\t\t\t\t\t\tif (globalMessageResponse) {
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(globalMessageResponse);
\t\t\t\t\t\t\t}

\t\t\t\t\t\t\tglobalMessageResponse = null;
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif (url = xhr.getResponseHeader('Location')) {
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t\t}
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t}
\t\t\t});

\t\t\tvar ApplicationItem = Backbone.View.extend({
\t\t\t\ttagName : \"div\",
\t\t\t\tclassName: 'uv-app-wrapper',
\t\t\t\ttemplate : _.template(\$(\"#application_list_item_tmp\").html()),
\t\t\t\trender : function() {
\t\t\t\t\tthis.\$el.html(this.template(this.model.toJSON()));
\t\t\t\t\treturn this;
\t\t\t\t}
\t\t\t});

\t\t\tvar ApplicationList = Backbone.View.extend({
\t\t\t\tel : \$(\"#application-list\"),
\t\t\t\tinitialize : function() {
\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\tthis.render();
\t\t\t\t},
\t\t\t\trender : function () {
\t\t\t\t\tthis.\$el.html('');
\t\t\t\t\tif(applicationCollection.length) {
\t\t\t\t\t\t_.each(applicationCollection.models, function (item) {
\t\t\t\t\t\t\tthis.renderType(item);
\t\t\t\t\t\t}, this);
\t\t\t\t\t} else {
\t\t\t\t\t\tthis.\$el.append(_.template(\$('#no-result-temp').html()))
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\trenderType : function (item) {
\t\t\t\t\tvar applicationItem = new ApplicationItem({
\t\t\t\t\t\tmodel: item
\t\t\t\t\t});
\t\t\t\t\tthis.\$el.append(applicationItem.render().el);
\t\t\t\t},
\t\t\t});

            var Filter = app.Filter.extend({
\t\t\t\tdefaultSortIndex: 'createdAt',
\t\t\t\tsortText: \"{{ 'Sort By:'|trans }} \",
\t\t\t\tdefaultSortText: \"{{ 'Sort By:'|trans }} {{ 'Date Released'|trans }}\",
\t\t\t\ttemplate : _.template(\$(\"#application_list_sorting_tmp\").html()),
                events : {
                    'keyup .uv-search-inline' : 'search',
                    'change .asset-visibility input[type=\"checkbox\"]': 'filterAssetsVisibility'
                },
                search : _.debounce(function(e) {
                    this.collection.reset();
                    this.collection.state.currentPage = null;
                    this.collection.filterParameters.search = Backbone.\$(e.target).val();
                    var queryString = this.buildQuery(\$.param(this.collection.getValidParameters()));
                    router.navigate(queryString,{trigger: true});
                }, 1000),
\t\t\t\tsortCollection : function(sortField,order) {
\t\t\t\t\tvar context = {};
\t\t\t\t\tcontext['queryString'] = this.buildQuery(\$.param(this.collection.getValidParameters()));
\t\t\t\t\tif(typeof sortField != 'undefined' && sortField != null) {
\t\t\t\t\t\tcontext['page'] = this.collection.state.currentPage;
\t\t\t\t\t\tcontext['sort'] = sortField;

\t\t\t\t\t\tif(order == 'asc') {
\t\t\t\t\t\t\tcontext['direction'] = 'desc';
\t\t\t\t\t\t\torder = -1;
\t\t\t\t\t\t} else {
\t\t\t\t\t\t\tcontext['direction'] = 'asc';
\t\t\t\t\t\t\torder = 1;
\t\t\t\t\t\t}

\t\t\t\t\t\t\$(\".sort .uv-dropdown-list ul\").html(this.template(context));
\t\t\t\t\t\tvar selectedText = \$(\".sort a[data-field='\"+sortField+\"']\").text();
\t\t\t\t\t\t\$(\".sort .uv-dropdown-btn\").text(this.sortText + selectedText);
\t\t\t\t\t\tthis.collection.setSorting(sortField, order, {full: true});
\t\t\t\t\t} else {
\t\t\t\t\t\t\$(\".sort .uv-dropdown-btn\").text(this.defaultSortText);
\t\t\t\t\t\tcontext['page'] = this.collection.state.currentPage;
\t\t\t\t\t\tcontext['sort'] = this.defaultSortIndex;
\t\t\t\t\t\tcontext['direction'] = 'asc';
\t\t\t\t\t\t\$(\".sort .uv-dropdown-list ul\").html(this.template(context));
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tbuildQuery: function(query) {
\t\t\t\t\tquery = query.replace(/&/g, '/');
\t\t\t\t\tquery = query.replace(/=/g, '/');
\t\t\t\t\tif (query.indexOf(\"type/free\") >= 0)
\t\t\t\t\t\tquery = query.replace('type/free', 'free')
\t\t\t\t\telse if (query.indexOf(\"type/premium\") >= 0)
\t\t\t\t\t\tquery = query.replace('type/premium', 'premium')
\t\t\t\t\telse if (query.indexOf(\"installed/1\") >= 0)
\t\t\t\t\t\tquery = query.replace('installed/1', 'installed')
\t\t\t\t\telse if (query.indexOf(\"category/\") >= 0)
\t\t\t\t\t\tquery = query.replace('category/', '');
\t\t\t\t\treturn query;
\t\t\t\t},
\t\t\t})

\t\t\tRouter = Backbone.Router.extend({
\t\t\t\troutes: {
\t\t\t\t\t'page/:number(/sort/:sortField)(/direction/:order)': 'paginate',
                    'search/:query(/page/:number)(/sort/:sortField)(/direction/:order)' : 'filterByQuery',
\t\t\t\t\t'free(/search/:query)(/page/:number)(/sort/:sortField)(/direction/:order)': 'filterFreeApps',
\t\t\t\t\t'premium(/search/:query)(/page/:number)(/sort/:sortField)(/direction/:order)': 'filterPremiumApps',
\t\t\t\t\t'installed(/search/:query)(/page/:number)(/sort/:sortField)(/direction/:order)': 'filterInstalledApps',
\t\t\t\t\t':category(/search/:query)(/:pricing)(/page/:number)(/sort/:sortField)(/direction/:order)' : 'filterByCategory',
\t\t\t\t\t'': 'initializeList',
\t\t\t\t},
\t\t\t\tpaginate : function(number, sortField, order) {
\t\t\t\t\tthis.resetParams('', '',  '', '', number, sortField, order, '{{ \"All\"|trans }}');
\t\t\t\t},
\t\t\t\tfilterByQuery: function(query, number, sortField, order) {
\t\t\t\t\tthis.resetParams(query, '', '', '', number, sortField, order, '{{ \"All\"|trans }}');
\t\t\t\t},
\t\t\t\tfilterByCategory: function(category, query, pricing, number, sortField, order) {
\t\t\t\t\tif('free' != pricing && 'premium' != pricing) {
\t\t\t\t\t\tpricing = '';
\t\t\t\t\t}
\t\t\t\t\tthis.resetParams(query, category, pricing, '', number, sortField, order, category);
\t\t\t\t},
\t\t\t\tfilterFreeApps: function(query, number, sortField, order) {
\t\t\t\t\tthis.resetParams(query, '', 'free', '', number, sortField, order, '{{ \"Free\"|trans }}');

\t\t\t\t},
\t\t\t\tfilterPremiumApps: function(query, number, sortField, order) {
\t\t\t\t\tthis.resetParams(query, '', 'premium', '', number, sortField, order, '{{ \"Premium\"|trans }}');
\t\t\t\t},
\t\t\t\tfilterInstalledApps: function(query, number, sortField, order) {
\t\t\t\t\tthis.resetParams(query, '', '', true, number, sortField, order, '{{ \"Installed\"|trans }}');
\t\t\t\t},
\t\t\t\tinitializeList : function() {
\t\t\t\t\tthis.resetParams('', '','', '', null, null, null, 'All');
\t\t\t\t},
\t\t\t\tresetParams : function(query, category, pricing, installedFlag, number, sortField, order, titleText) {
\t\t\t\t\tapplicationCollection.filterParameters.category = category;
\t\t\t\t\tapplicationCollection.filterParameters.type = pricing;
\t\t\t\t\tapplicationCollection.filterParameters.installed = installedFlag ? 1 : null;
\t\t\t\t\tapplicationCollection.state.currentPage = number;

                    if(query != null) {
                        query = query.replace(/\\+/g,' ');
\t\t\t\t\t}
                    applicationCollection.filterParameters.search = query;
                    \$(\".uv-search-inline\").val(query);

\t\t\t\t\tfilter.sortCollection(sortField, order);
\t\t\t\t\tapplicationCollection.syncData();
\t\t\t\t},
\t\t\t});

\t\t\tvar applicationCollection = new ApplicationCollection();

\t\t\tvar filter = new Filter({
                collection : applicationCollection
            });

\t\t\trouter = new Router();
\t\t\tBackbone.history.start({push_state:true});
\t\t});
\t</script>
{% endblock %}
", "@UVDeskExtensionFramework/dashboard.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/extension-framework/Resources/views/dashboard.html.twig");
    }
}
