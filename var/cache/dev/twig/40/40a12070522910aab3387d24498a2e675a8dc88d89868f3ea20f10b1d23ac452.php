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

/* @UVDeskSupportCenter/Staff/Folders/listFolders.html.twig */
class __TwigTemplate_1df45e471df0cd617d9455218e750debd2c4e2028570aa27fe4b2a733abd3337 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Staff/Folders/listFolders.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Staff/Folders/listFolders.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskSupportCenter/Staff/Folders/listFolders.html.twig", 1);
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
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Folders"), "html", null, true);
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
\t\t.uv-folders input[type='radio'] {
\t\t\tdisplay: none;
\t\t}
\t\t.uv-inner-section .folder-list .uv-app-list-brick .uv-app-list-brick-lt{
    \t\t//background: none;
\t\t}
\t\t.uv-inner-section .folder-list .uv-app-list-brick .uv-app-list-brick-lt img{
    \t\theight: 90px;
\t\t\twidth: 100%;
\t\t}
\t\t.uv-inner-section .folder-list .uv-app-list-brick .uv-app-list-brick-lt.uv-without-img{
    \t\tbackground-image: linear-gradient(to right, #7c70f4 0%, #ba81f1 100%);
\t\t}
\t\t.uv-folders .uv-aside-brick div {
\t\t\tmargin-top: 15px;
\t\t}
\t\t.uv-folders p {
\t\t\tmargin: 3px 0px 3px 0px;
\t\t}
\t\t.uv-app-list-brick-lt.uv-without-img div {
\t\t\twidth: 90px;
\t\t\theight: 90px;
\t\t\tbackground-image: url(../../../bundles/webkuldefault/images/uvdesk-kb-sprite.svg);
\t\t\tbackground-position: 0px 0px;
\t\t\tdisplay: inline-block;
\t\t\tvertical-align: middle;
\t\t\toverflow: hidden;
\t\t}
\t\t.uv-app-list-brick-lt.uv-without-img div{
\t\t\tbackground-position: -90px 0px;
\t\t}
\t\tdiv.uv-manage-gap{

\t\t}
\t\t.uv-app-list-brick-rt{
    \t\tword-break: break-word;
\t\t}
\t</style>

\t<div class=\"uv-inner-section\">
\t\t";
        // line 50
        echo "\t\t";
        $context["asideTemplate"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\AsideTemplate";
        // line 51
        echo "\t\t";
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\SupportCenterBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Knowledgebase";
        // line 52
        echo "
\t\t";
        // line 53
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 53, $this->source); })()), "getRegisteredComponent", [0 => (isset($context["asideTemplate"]) || array_key_exists("asideTemplate", $context) ? $context["asideTemplate"] : (function () { throw new RuntimeError('Variable "asideTemplate" does not exist.', 53, $this->source); })())], "method", false, false, false, 53), "renderSidebar", [0 => (isset($context["asideSidebarReference"]) || array_key_exists("asideSidebarReference", $context) ? $context["asideSidebarReference"] : (function () { throw new RuntimeError('Variable "asideSidebarReference" does not exist.', 53, $this->source); })())], "method", false, false, false, 53);
        echo "

\t\t<div class=\"uv-view ";
        // line 55
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 55, $this->source); })()), "request", [], "any", false, false, false, 55), "cookies", [], "any", false, false, false, 55) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 55, $this->source); })()), "request", [], "any", false, false, false, 55), "cookies", [], "any", false, false, false, 55), "get", [0 => "uv-asideView"], "method", false, false, false, 55))) {
            echo "uv-aside-view";
        }
        echo "\">
\t\t\t<h1>
\t\t\t\t";
        // line 57
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Folders"), "html", null, true);
        echo "
\t\t\t</h1>
\t\t\t<div class=\"uv-action-bar\">
                <div class=\"uv-action-bar-col-lt\">
                    <!--Sort by-->
                    <div class=\"uv-dropdown sort\">
                        <div class=\"uv-dropdown-btn uv-vertical-align uv-margin-right-5\">
                            ";
        // line 64
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Sort By:"), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Created At"), "html", null, true);
        echo "
                        </div>
                        <div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t<label>";
        // line 68
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Sort By"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t</div>
                        </div>
                    </div>
                    <!--Sort by-->

                    <!--Filter By Status-->
                    <div class=\"uv-dropdown filter-by-status\">
                        <div class=\"uv-dropdown-btn uv-vertical-align uv-margin-right-5\">
                            ";
        // line 79
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status:"), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("All"), "html", null, true);
        echo "
                        </div>
                        <div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t<label>";
        // line 83
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
        echo "</label>
\t\t\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t\t\t<li class=\"uv-drop-list-active\"><a href=\"#\">";
        // line 85
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("All"), "html", null, true);
        echo "</a></li>
\t\t\t\t\t\t\t\t\t<li><a href=\"#\" data-id=\"1\">";
        // line 86
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Published"), "html", null, true);
        echo "</a></li>
\t\t\t\t\t\t\t\t\t<li><a href=\"#\" data-id=\"0\">";
        // line 87
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Draft"), "html", null, true);
        echo "</a></li>
\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t</div>
                        </div>
                    </div>
                    <!--//Filter By Status-->
                </div>
\t\t\t\t<div class=\"uv-action-bar-col-rt\">
\t\t\t\t\t<input type=\"text\" class=\"uv-search-inline uv-vertical-align uv-margin-right-15\" placeholder=\"";
        // line 95
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Search"), "html", null, true);
        echo "\">
\t\t\t\t\t<!-- Add Button -->
\t\t\t\t\t
\t\t\t\t\t<a href=\"";
        // line 98
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_create_folder");
        echo "\" type=\"button\" class=\"uv-btn-action\" id=\"uv-add-folder\">
\t\t\t\t\t\t<span class=\"uv-icon-add\"></span>
\t\t\t\t\t\t";
        // line 100
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("New Folder"), "html", null, true);
        echo "
\t\t\t\t\t</a>
\t\t\t\t\t<!--// Add Button -->
\t\t\t\t</div>
            </div>
     
            <div class=\"uv-table uv-list-view\">
\t\t\t\t<div class=\"uv-app-screen\">
                    <div class=\"folder-list uv-app-list-channels\">
\t\t\t\t\t</div>
                </div>
\t\t\t\t<div class=\"navigation\"></div>
            </div>
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 117
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 118
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "

\t<!-- Sorting Template -->
\t<script id=\"entity_list_sorting_tmp\" type=\"text/template\">
        <li class=\"<% if(sort == 'a.dateAdded') { %>uv-drop-list-active<% } %>\">
            <a href=\"#<% if(queryString != '') { %><%- queryString %>/<% } %><% if(page) { %>page/<%- page %><% } else { %>page/1<% } %>/sort/a.dateAdded/<% if(sort == 'a.dateAdded') { %><% if(direction) { %>direction/<%- direction %><% } else { %>direction/desc<% } %><% } else { %>direction/asc<% } %>\" data-field=\"a.dateAdded\">
\t\t\t\t";
        // line 124
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Created At", [], "messages");
        // line 125
        echo "\t\t\t\t<% if(sort == 'a.dateAdded') { %>
\t\t\t\t\t<span class=\"uv-sorting <% if(direction == 'asc') { %> descend <% } else { %> ascend <% } %>\"></span>
\t\t\t\t<% } %>
\t\t\t</a>
        </li>

\t    <li class=\"<% if(sort == 'a.name') { %>uv-drop-list-active<% } %>\">
            <a href=\"#<% if(queryString != '') { %><%- queryString %>/<% } %><% if(page) { %>page/<%- page %><% } else { %>page/1<% } %>/sort/a.name/<% if(sort == 'a.name') { %><% if(direction) { %>direction/<%- direction %><% } else { %>direction/desc<% } %><% } else { %>direction/asc<% } %>\" data-field=\"a.name\">
\t\t\t\t";
        // line 133
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Name", [], "messages");
        // line 134
        echo "\t\t\t\t<% if(sort == 'a.name') { %>
\t\t\t\t\t<span class=\"uv-sorting <% if(direction == 'asc') { %> descend <% } else { %> ascend <% } %>\"></span>
\t\t\t\t<% } %>
\t\t\t</a>
        </li>
\t</script>
\t<!-- //Sorting Template -->

\t<!-- Folder list item template -->
\t<script id=\"entity_list_item_tmp\" type=\"text/template\">
\t\t<a href=\"<%- path.replace('replaceId', id) %>\">
\t\t\t<% if(solutionImage) { %>
\t\t\t\t<div class=\"uv-app-list-brick-lt\">
\t\t\t\t\t<img src=\"";
        // line 147
        echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 147, $this->source); })()), "request", [], "any", false, false, false, 147), "scheme", [], "any", false, false, false, 147) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 147, $this->source); })()), "request", [], "any", false, false, false, 147), "httpHost", [], "any", false, false, false, 147)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")), "html", null, true);
        echo "<%= solutionImage %>\"/>\t\t\t\t\t
\t\t\t\t</div>
\t\t\t<% }else{ %>
\t\t\t\t<div class=\"uv-app-list-brick-lt uv-without-img\"><div></div></div>
\t\t\t<% } %>
\t\t</a>
        <div class=\"uv-app-list-brick-rt\">
            <p><a href=\"<%- path.replace('replaceId', id) %>\" data-target=\"uv-task-view\" <% if(name.length > 20){ %> data-toggle=\"tooltip\" data-placement=\"top\" title=\"<%- app.appView.sanitize(name) %>\" <% } %> ><%- name %></a></p>
\t\t    <p>
\t\t\t<% if(parseInt(categoriesCount)){ %><a href=\"<%- pathCategory.replace('replaceId', id) %>\">
\t\t\t<%- categoriesCount %> ";
        // line 157
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Categories"), "html", null, true);
        echo "</a> <% }else{ %> <a href=\"<%- pathCategory.replace('replaceId', id) %>\">
\t\t\t<%- categoriesCount %> ";
        // line 158
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Categories"), "html", null, true);
        echo "</a><% } %> </p>
\t\t    <p>
\t\t\t\t<% if(parseInt(articleCount)){ %><a href=\"<%- pathArticle.replace('replaceId', id) %>\"><%- articleCount %> ";
        // line 160
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Articles"), "html", null, true);
        echo "</a> <% }else{ %>
\t\t\t\t<span class=\"uv-text-danger uv-cursor delete-folder uv-pull-right\" data-id=\"<%- id %>\">";
        // line 161
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("delete"), "html", null, true);
        echo "</span>
\t\t\t\t<a href=\"<%- pathArticle.replace('replaceId', id) %>\"><%- articleCount %> ";
        // line 162
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Articles"), "html", null, true);
        echo "</a><% } %>
\t\t\t</p>
        </div>
    </script>
\t<!-- //Folder list item template -->

\t<script id=\"no_result_tmp\" type=\"text/template\">
        <div class=\"uv-app-screen\">
\t\t\t<div class=\"uv-app-splash\" style=\"text-align: center;\">
\t\t\t\t<img class=\"uv-app-splash-image\" src=\"";
        // line 171
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdesksupportcenter/images/splash/knowledgebase-splash.png"), "html", null, true);
        echo "\" alt=\"Folders\">
\t\t\t\t<% if(!window.location.hash) { %>
\t\t\t\t\t<h2 class=\"uv-margin-top-10\">";
        // line 173
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Create Knowledgebase Folder"), "html", null, true);
        echo "</h2>
\t\t\t\t\t<p>";
        // line 174
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("You didn't add any folder to your Knowledgebase yet, Create your first Folder and start adding Categories/Articles to make your customers help themselves."), "html", null, true);
        echo "</p>
\t\t\t\t<% } else { %>
\t\t\t\t\t<p>
\t\t\t\t\t\t";
        // line 177
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("You didn't have any folder for current filter(s)."), "html", null, true);
        echo "
\t\t\t\t\t\t<a href=\"#\">";
        // line 178
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Clear Filters"), "html", null, true);
        echo "</a>
\t\t\t\t\t</p>
\t\t\t\t<% } %>
\t\t\t</div>
\t\t</div>
    </script>

\t<script type=\"text/javascript\">
\t\tvar path = \"";
        // line 186
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_update_folder", ["folderId" => "replaceId"]);
        echo "\";
\t\tvar pathCategory = \"";
        // line 187
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_folder_categories_collection", ["solution" => "replaceId"]);
        echo "\";
\t\tvar pathArticle = \"";
        // line 188
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_folder_articles_collection", ["solution" => "replaceId"]);
        echo "\";
\t\tvar pathLayout = \"";
        // line 189
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_update_theme_xhr");
        echo "\";
\t\t\$(function () {
\t\t\tvar globalMessageResponse = \"\";

\t\t\tvar FolderModel = Backbone.Model.extend({
\t\t\t\tidAttribute : \"id\"
\t\t\t});

\t\t\tvar FolderCollection = AppCollection.extend({
\t\t\t\tmodel : FolderModel,
\t\t\t\turl : \"";
        // line 199
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_folders_collection_xhr");
        echo "\",
\t\t\t\tfilterParameters : {
\t\t\t\t\t\"isActive\" : \"\",
\t\t\t\t\t\"search\" : \"\"
\t\t\t\t},
\t\t\t\tparseRecords: function (resp, options) {
\t\t\t\t\treturn resp.results;
\t\t\t\t},
\t\t\t\tsyncData : function() {
\t\t\t\t\tapp.appView.showLoader();
\t\t\t\t\tthis.fetch({
\t\t\t\t\t\tdata : this.getValidParameters(),
\t\t\t\t\t\treset: true,
\t\t\t\t\t\tsuccess: function(model, response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tvar folderListView = new FolderList();
\t\t\t\t\t\t\tapp.pager.paginationData = response.pagination_data;

\t\t\t\t\t\t\tvar url = app.pager.paginationData.url;
\t\t\t\t\t\t\tif(folderCollection.length == 0 && app.pager.paginationData.current != \"0\")
\t\t\t\t\t\t\t\trouter.navigate(url.replace('replacePage', app.pager.paginationData.last),{trigger: true});
\t\t\t\t\t\t\telse {
\t\t\t\t\t\t\t\tapp.pager.render();
\t\t\t\t\t\t\t}
\t\t\t\t\t\t\tif(globalMessageResponse)
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(globalMessageResponse);
\t\t\t\t\t\t\tglobalMessageResponse = null;
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t}
\t\t\t});

\t\t\tvar FolderItem = Backbone.View.extend({
\t\t\t\ttagName : \"div\",
\t\t\t\tclassName : \"uv-app-list-brick\",
\t\t\t\ttemplate : _.template(\$(\"#entity_list_item_tmp\").html()),
\t\t\t\tevents : {
\t\t\t\t\t'click .delete-folder' : \"confirmRemove\",
\t\t\t\t},
\t\t\t\trender : function() {
\t\t\t\t\tconsole.log(this.model.toJSON());
\t\t\t\t\tthis.\$el.html(this.template(this.model.toJSON()));
\t\t\t\t\treturn this;
\t\t\t\t},
\t\t\t\tunrender : function(response) {
\t\t\t\t\tif(response.alertMessage != undefined) {
\t\t\t\t\t\tfolderCollection.syncData();
\t\t\t\t\t\tapp.appView.renderResponseAlert(response)
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tconfirmRemove: function(e) {
\t\t\t\t\te.preventDefault();
\t\t\t\t\tapp.appView.openConfirmModal(this)
\t\t\t\t},
\t\t\t\tremoveItem : function (e) {
\t\t\t\t\tapp.appView.showLoader();
\t\t\t\t\tself = this;
\t\t\t\t\tthis.model.destroy({
\t\t\t\t\t\turl : \"";
        // line 261
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_knowledgebase_update_folder_xhr");
        echo "/\"+this.model.get('id'),
\t\t\t\t\t\tmethod:\"delete\",
\t\t\t\t\t\tsuccess : function (model, response, options) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t\tfolderCollection.syncData();
\t\t\t\t\t\t\tif(typeof(response.allowedToAdd) != 'undefined' && response.allowedToAdd) {
\t\t\t\t\t\t\t\t\$('#upgrade-plan-message').hide();
\t\t\t\t\t\t\t\t\$('#uv-add-folder').show();
\t\t\t\t\t\t\t}
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t\tvar response = warningResponse;
\t\t\t\t\t\t\tif(xhr.responseJSON)
\t\t\t\t\t\t\t\tresponse = xhr.responseJSON;
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t}
\t\t\t});

\t\t\tvar FolderList = Backbone.View.extend({
\t\t\t\tel : \$(\".uv-list-view div.folder-list\"),
\t\t\t\tnoResultTemplate : _.template(\$(\"#no_result_tmp\").html()),
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.render();
\t\t\t\t},
\t\t\t\trender : function () {
\t\t\t\t\tthis.\$el.html('');
\t\t\t\t\tthis.\$el.find(\".uv-app-list-brick\").remove();
\t\t\t\t\tvar isEmptyFlag = 0;
\t\t\t\t\tif(folderCollection.length) {
\t\t\t\t\t\tisEmptyFlag++;
\t\t\t\t\t\t_.each(folderCollection.models, function (item) {
\t\t\t\t\t\t\tthis.renderFolder(item);
\t\t\t\t\t\t}, this);
\t\t\t\t\t}

                    if(!isEmptyFlag) {
                        this.\$el.append(this.noResultTemplate())
                    }
\t\t\t\t},
\t\t\t\trenderFolder : function (item) {
\t\t\t\t\tvar folderItem = new FolderItem({
\t\t\t\t\t\tmodel: item
\t\t\t\t\t});
\t\t\t\t\tthis.\$el.append(folderItem.render().el);
\t\t\t\t}
\t\t\t});

\t\t\tvar Filter = app.Filter.extend({
\t\t\t\tdefaultSortIndex: 'a.dateAdded',
\t\t\t\tsortText: \"";
        // line 316
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Sort By:", [], "messages");
        echo " \",
\t\t\t\tdefaultSortText: \"";
        // line 317
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Sort By:", [], "messages");
        echo " ";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Created At", [], "messages");
        echo "\",
\t\t\t\ttemplate : _.template(\$(\"#entity_list_sorting_tmp\").html())
\t\t\t})

\t\t\tvar folderCollection = new FolderCollection();

\t\t\tvar filter = new Filter({
\t\t\t\tcollection : folderCollection
\t\t\t});

\t\t\tvar PageView = Backbone.View.extend({
                el: '.uv-folders',
                events : {
\t\t\t\t\t\"change input[type='radio']\": 'layoutChanged'
                },
                layoutChanged: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    \$('.uv-layout-icon').removeClass('uv-layout-icon-active');

                    \$(\"label[for='\" + currentElement.attr('id') + \"']\").addClass('uv-layout-icon-active');

\t\t\t\t\tapp.appView.showLoader();

\t\t\t\t\t\$.ajax({
\t\t\t\t\t\turl : pathLayout,
\t\t\t\t\t\ttype : 'POST',
\t\t\t\t\t\tdata: {\"layout\" : Backbone.\$(e.currentTarget).val(), \"actionType\": 'layoutUpdate'},
\t\t\t\t\t\tdataType : 'json',
\t\t\t\t\t\tsuccess: function (response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t\tvar response = warningResponse;
\t\t\t\t\t\t\tif(xhr.responseJSON)
\t\t\t\t\t\t\t\tresponse = xhr.responseJSON;
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
                        }
\t\t\t\t\t});
                },
            });

\t\t\tvar pageView = new PageView();

\t\t\tRouter = Backbone.Router.extend({
\t\t\t\troutes: {
\t\t\t\t\t'page/:number(/sort/:sortField)(/direction/:order)' : 'paginate',
\t\t\t\t\t'isActive/:status(/search/:query)(/page/:number)(/sort/:sortField)(/direction/:order)' : 'filterFolderByStatus',
\t\t\t\t\t'search/:query(/page/:number)(/sort/:sortField)(/direction/:order)' : 'filterByQuery',
\t\t\t\t\t'' : 'initializeList'
\t\t\t\t},
\t\t\t\tinitializeList : function() {
\t\t\t\t\tthis.resetParams('', '');
\t\t\t\t\tfolderCollection.state.currentPage = null;
\t\t\t\t\tfilter.sortCollection();
\t\t\t\t\tfolderCollection.syncData();
\t\t\t\t},
\t\t\t\tpaginate : function(number,sortField,order) {
\t\t\t\t\tthis.resetParams('', '');
\t\t\t\t\tfolderCollection.state.currentPage = number;
\t\t\t\t\tfilter.sortCollection(sortField,order);
\t\t\t\t\tfolderCollection.syncData();
\t\t\t\t},
\t\t\t\tfilterFolderByStatus: function(status,query,number,sortField,order) {
\t\t\t\t\tthis.resetParams(status,query);
\t\t\t\t\tfolderCollection.state.currentPage = number;
\t\t\t\t\tfilter.sortCollection(sortField,order);
\t\t\t\t\tfolderCollection.syncData();
\t\t\t\t},
\t\t\t\tfilterByQuery : function(query,number,sortField,order) {
\t\t\t\t\tthis.resetParams('',query);
\t\t\t\t\tfolderCollection.state.currentPage = number;
\t\t\t\t\tfilter.sortCollection(sortField,order);
\t\t\t\t\tfolderCollection.syncData();
\t\t\t\t},
\t\t\t\tresetParams : function(status, query) {
\t\t\t\t\tif(query != null)
\t\t\t\t\t\tquery = query.replace(/\\+/g,' ');
\t\t\t\t\tfolderCollection.filterParameters.isActive = status;
\t\t\t\t\tvar statusText = status ? \$(\".filter-by-status a[data-id='\" + status + \"']\").text() : \"";
        // line 399
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("All", [], "messages");
        echo "\";
\t\t\t\t\t\$(\".filter-by-status .uv-dropdown-btn\").text(\"";
        // line 400
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Status:", [], "messages");
        echo " \" + statusText);
\t\t\t\t\tfolderCollection.filterParameters.search = query;
\t\t\t\t\t\$(\".uv-search-inline\").val(query);
\t\t\t\t}
\t\t\t});

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
        return "@UVDeskSupportCenter/Staff/Folders/listFolders.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  624 => 400,  620 => 399,  533 => 317,  529 => 316,  471 => 261,  406 => 199,  393 => 189,  389 => 188,  385 => 187,  381 => 186,  370 => 178,  366 => 177,  360 => 174,  356 => 173,  351 => 171,  339 => 162,  335 => 161,  331 => 160,  326 => 158,  322 => 157,  309 => 147,  294 => 134,  292 => 133,  282 => 125,  280 => 124,  270 => 118,  260 => 117,  234 => 100,  229 => 98,  223 => 95,  212 => 87,  208 => 86,  204 => 85,  199 => 83,  190 => 79,  176 => 68,  167 => 64,  157 => 57,  150 => 55,  145 => 53,  142 => 52,  139 => 51,  136 => 50,  93 => 8,  83 => 7,  70 => 4,  60 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %}
\t{{ 'Folders'|trans }}
{% endblock %}

{% block pageContent %}
\t<style>
\t\t.uv-folders input[type='radio'] {
\t\t\tdisplay: none;
\t\t}
\t\t.uv-inner-section .folder-list .uv-app-list-brick .uv-app-list-brick-lt{
    \t\t//background: none;
\t\t}
\t\t.uv-inner-section .folder-list .uv-app-list-brick .uv-app-list-brick-lt img{
    \t\theight: 90px;
\t\t\twidth: 100%;
\t\t}
\t\t.uv-inner-section .folder-list .uv-app-list-brick .uv-app-list-brick-lt.uv-without-img{
    \t\tbackground-image: linear-gradient(to right, #7c70f4 0%, #ba81f1 100%);
\t\t}
\t\t.uv-folders .uv-aside-brick div {
\t\t\tmargin-top: 15px;
\t\t}
\t\t.uv-folders p {
\t\t\tmargin: 3px 0px 3px 0px;
\t\t}
\t\t.uv-app-list-brick-lt.uv-without-img div {
\t\t\twidth: 90px;
\t\t\theight: 90px;
\t\t\tbackground-image: url(../../../bundles/webkuldefault/images/uvdesk-kb-sprite.svg);
\t\t\tbackground-position: 0px 0px;
\t\t\tdisplay: inline-block;
\t\t\tvertical-align: middle;
\t\t\toverflow: hidden;
\t\t}
\t\t.uv-app-list-brick-lt.uv-without-img div{
\t\t\tbackground-position: -90px 0px;
\t\t}
\t\tdiv.uv-manage-gap{

\t\t}
\t\t.uv-app-list-brick-rt{
    \t\tword-break: break-word;
\t\t}
\t</style>

\t<div class=\"uv-inner-section\">
\t\t{# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\SupportCenterBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Knowledgebase' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}

\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
\t\t\t<h1>
\t\t\t\t{{ 'Folders'|trans }}
\t\t\t</h1>
\t\t\t<div class=\"uv-action-bar\">
                <div class=\"uv-action-bar-col-lt\">
                    <!--Sort by-->
                    <div class=\"uv-dropdown sort\">
                        <div class=\"uv-dropdown-btn uv-vertical-align uv-margin-right-5\">
                            {{ 'Sort By:'|trans }} {{ 'Created At'|trans }}
                        </div>
                        <div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t<label>{{ 'Sort By'|trans }}</label>
\t\t\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t</div>
                        </div>
                    </div>
                    <!--Sort by-->

                    <!--Filter By Status-->
                    <div class=\"uv-dropdown filter-by-status\">
                        <div class=\"uv-dropdown-btn uv-vertical-align uv-margin-right-5\">
                            {{ 'Status:'|trans }} {{ 'All'|trans }}
                        </div>
                        <div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t\t\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t\t\t\t\t<label>{{ 'Status'|trans }}</label>
\t\t\t\t\t\t\t\t<ul>
\t\t\t\t\t\t\t\t\t<li class=\"uv-drop-list-active\"><a href=\"#\">{{ 'All'|trans }}</a></li>
\t\t\t\t\t\t\t\t\t<li><a href=\"#\" data-id=\"1\">{{ 'Published'|trans }}</a></li>
\t\t\t\t\t\t\t\t\t<li><a href=\"#\" data-id=\"0\">{{ 'Draft'|trans }}</a></li>
\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t</div>
                        </div>
                    </div>
                    <!--//Filter By Status-->
                </div>
\t\t\t\t<div class=\"uv-action-bar-col-rt\">
\t\t\t\t\t<input type=\"text\" class=\"uv-search-inline uv-vertical-align uv-margin-right-15\" placeholder=\"{{ 'Search'|trans }}\">
\t\t\t\t\t<!-- Add Button -->
\t\t\t\t\t
\t\t\t\t\t<a href=\"{{ path('helpdesk_member_knowledgebase_create_folder') }}\" type=\"button\" class=\"uv-btn-action\" id=\"uv-add-folder\">
\t\t\t\t\t\t<span class=\"uv-icon-add\"></span>
\t\t\t\t\t\t{{ \"New Folder\"|trans }}
\t\t\t\t\t</a>
\t\t\t\t\t<!--// Add Button -->
\t\t\t\t</div>
            </div>
     
            <div class=\"uv-table uv-list-view\">
\t\t\t\t<div class=\"uv-app-screen\">
                    <div class=\"folder-list uv-app-list-channels\">
\t\t\t\t\t</div>
                </div>
\t\t\t\t<div class=\"navigation\"></div>
            </div>
\t\t</div>
\t</div>
{% endblock %}

{% block footer %}
\t{{ parent() }}

\t<!-- Sorting Template -->
\t<script id=\"entity_list_sorting_tmp\" type=\"text/template\">
        <li class=\"<% if(sort == 'a.dateAdded') { %>uv-drop-list-active<% } %>\">
            <a href=\"#<% if(queryString != '') { %><%- queryString %>/<% } %><% if(page) { %>page/<%- page %><% } else { %>page/1<% } %>/sort/a.dateAdded/<% if(sort == 'a.dateAdded') { %><% if(direction) { %>direction/<%- direction %><% } else { %>direction/desc<% } %><% } else { %>direction/asc<% } %>\" data-field=\"a.dateAdded\">
\t\t\t\t{% trans %}Created At{% endtrans %}
\t\t\t\t<% if(sort == 'a.dateAdded') { %>
\t\t\t\t\t<span class=\"uv-sorting <% if(direction == 'asc') { %> descend <% } else { %> ascend <% } %>\"></span>
\t\t\t\t<% } %>
\t\t\t</a>
        </li>

\t    <li class=\"<% if(sort == 'a.name') { %>uv-drop-list-active<% } %>\">
            <a href=\"#<% if(queryString != '') { %><%- queryString %>/<% } %><% if(page) { %>page/<%- page %><% } else { %>page/1<% } %>/sort/a.name/<% if(sort == 'a.name') { %><% if(direction) { %>direction/<%- direction %><% } else { %>direction/desc<% } %><% } else { %>direction/asc<% } %>\" data-field=\"a.name\">
\t\t\t\t{% trans %}Name{% endtrans %}
\t\t\t\t<% if(sort == 'a.name') { %>
\t\t\t\t\t<span class=\"uv-sorting <% if(direction == 'asc') { %> descend <% } else { %> ascend <% } %>\"></span>
\t\t\t\t<% } %>
\t\t\t</a>
        </li>
\t</script>
\t<!-- //Sorting Template -->

\t<!-- Folder list item template -->
\t<script id=\"entity_list_item_tmp\" type=\"text/template\">
\t\t<a href=\"<%- path.replace('replaceId', id) %>\">
\t\t\t<% if(solutionImage) { %>
\t\t\t\t<div class=\"uv-app-list-brick-lt\">
\t\t\t\t\t<img src=\"{{ app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') }}<%= solutionImage %>\"/>\t\t\t\t\t
\t\t\t\t</div>
\t\t\t<% }else{ %>
\t\t\t\t<div class=\"uv-app-list-brick-lt uv-without-img\"><div></div></div>
\t\t\t<% } %>
\t\t</a>
        <div class=\"uv-app-list-brick-rt\">
            <p><a href=\"<%- path.replace('replaceId', id) %>\" data-target=\"uv-task-view\" <% if(name.length > 20){ %> data-toggle=\"tooltip\" data-placement=\"top\" title=\"<%- app.appView.sanitize(name) %>\" <% } %> ><%- name %></a></p>
\t\t    <p>
\t\t\t<% if(parseInt(categoriesCount)){ %><a href=\"<%- pathCategory.replace('replaceId', id) %>\">
\t\t\t<%- categoriesCount %> {{ 'Categories'|trans }}</a> <% }else{ %> <a href=\"<%- pathCategory.replace('replaceId', id) %>\">
\t\t\t<%- categoriesCount %> {{ 'Categories'|trans }}</a><% } %> </p>
\t\t    <p>
\t\t\t\t<% if(parseInt(articleCount)){ %><a href=\"<%- pathArticle.replace('replaceId', id) %>\"><%- articleCount %> {{ 'Articles'|trans }}</a> <% }else{ %>
\t\t\t\t<span class=\"uv-text-danger uv-cursor delete-folder uv-pull-right\" data-id=\"<%- id %>\">{{ 'delete'|trans }}</span>
\t\t\t\t<a href=\"<%- pathArticle.replace('replaceId', id) %>\"><%- articleCount %> {{ 'Articles'|trans }}</a><% } %>
\t\t\t</p>
        </div>
    </script>
\t<!-- //Folder list item template -->

\t<script id=\"no_result_tmp\" type=\"text/template\">
        <div class=\"uv-app-screen\">
\t\t\t<div class=\"uv-app-splash\" style=\"text-align: center;\">
\t\t\t\t<img class=\"uv-app-splash-image\" src=\"{{ asset('bundles/uvdesksupportcenter/images/splash/knowledgebase-splash.png') }}\" alt=\"Folders\">
\t\t\t\t<% if(!window.location.hash) { %>
\t\t\t\t\t<h2 class=\"uv-margin-top-10\">{{\"Create Knowledgebase Folder\"|trans}}</h2>
\t\t\t\t\t<p>{{\"You didn't add any folder to your Knowledgebase yet, Create your first Folder and start adding Categories/Articles to make your customers help themselves.\"|trans}}</p>
\t\t\t\t<% } else { %>
\t\t\t\t\t<p>
\t\t\t\t\t\t{{ \"You didn't have any folder for current filter(s).\"|trans }}
\t\t\t\t\t\t<a href=\"#\">{{ 'Clear Filters'|trans }}</a>
\t\t\t\t\t</p>
\t\t\t\t<% } %>
\t\t\t</div>
\t\t</div>
    </script>

\t<script type=\"text/javascript\">
\t\tvar path = \"{{ path('helpdesk_member_knowledgebase_update_folder', {'folderId': 'replaceId' }) }}\";
\t\tvar pathCategory = \"{{ path('helpdesk_member_knowledgebase_folder_categories_collection', {'solution': 'replaceId' }) }}\";
\t\tvar pathArticle = \"{{ path('helpdesk_member_knowledgebase_folder_articles_collection', {'solution': 'replaceId' }) }}\";
\t\tvar pathLayout = \"{{ path('helpdesk_member_knowledgebase_update_theme_xhr') }}\";
\t\t\$(function () {
\t\t\tvar globalMessageResponse = \"\";

\t\t\tvar FolderModel = Backbone.Model.extend({
\t\t\t\tidAttribute : \"id\"
\t\t\t});

\t\t\tvar FolderCollection = AppCollection.extend({
\t\t\t\tmodel : FolderModel,
\t\t\t\turl : \"{{ path('helpdesk_member_knowledgebase_folders_collection_xhr') }}\",
\t\t\t\tfilterParameters : {
\t\t\t\t\t\"isActive\" : \"\",
\t\t\t\t\t\"search\" : \"\"
\t\t\t\t},
\t\t\t\tparseRecords: function (resp, options) {
\t\t\t\t\treturn resp.results;
\t\t\t\t},
\t\t\t\tsyncData : function() {
\t\t\t\t\tapp.appView.showLoader();
\t\t\t\t\tthis.fetch({
\t\t\t\t\t\tdata : this.getValidParameters(),
\t\t\t\t\t\treset: true,
\t\t\t\t\t\tsuccess: function(model, response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tvar folderListView = new FolderList();
\t\t\t\t\t\t\tapp.pager.paginationData = response.pagination_data;

\t\t\t\t\t\t\tvar url = app.pager.paginationData.url;
\t\t\t\t\t\t\tif(folderCollection.length == 0 && app.pager.paginationData.current != \"0\")
\t\t\t\t\t\t\t\trouter.navigate(url.replace('replacePage', app.pager.paginationData.last),{trigger: true});
\t\t\t\t\t\t\telse {
\t\t\t\t\t\t\t\tapp.pager.render();
\t\t\t\t\t\t\t}
\t\t\t\t\t\t\tif(globalMessageResponse)
\t\t\t\t\t\t\t\tapp.appView.renderResponseAlert(globalMessageResponse);
\t\t\t\t\t\t\tglobalMessageResponse = null;
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t}
\t\t\t});

\t\t\tvar FolderItem = Backbone.View.extend({
\t\t\t\ttagName : \"div\",
\t\t\t\tclassName : \"uv-app-list-brick\",
\t\t\t\ttemplate : _.template(\$(\"#entity_list_item_tmp\").html()),
\t\t\t\tevents : {
\t\t\t\t\t'click .delete-folder' : \"confirmRemove\",
\t\t\t\t},
\t\t\t\trender : function() {
\t\t\t\t\tconsole.log(this.model.toJSON());
\t\t\t\t\tthis.\$el.html(this.template(this.model.toJSON()));
\t\t\t\t\treturn this;
\t\t\t\t},
\t\t\t\tunrender : function(response) {
\t\t\t\t\tif(response.alertMessage != undefined) {
\t\t\t\t\t\tfolderCollection.syncData();
\t\t\t\t\t\tapp.appView.renderResponseAlert(response)
\t\t\t\t\t}
\t\t\t\t},
\t\t\t\tconfirmRemove: function(e) {
\t\t\t\t\te.preventDefault();
\t\t\t\t\tapp.appView.openConfirmModal(this)
\t\t\t\t},
\t\t\t\tremoveItem : function (e) {
\t\t\t\t\tapp.appView.showLoader();
\t\t\t\t\tself = this;
\t\t\t\t\tthis.model.destroy({
\t\t\t\t\t\turl : \"{{ path('helpdesk_member_knowledgebase_update_folder_xhr') }}/\"+this.model.get('id'),
\t\t\t\t\t\tmethod:\"delete\",
\t\t\t\t\t\tsuccess : function (model, response, options) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t\tfolderCollection.syncData();
\t\t\t\t\t\t\tif(typeof(response.allowedToAdd) != 'undefined' && response.allowedToAdd) {
\t\t\t\t\t\t\t\t\$('#upgrade-plan-message').hide();
\t\t\t\t\t\t\t\t\$('#uv-add-folder').show();
\t\t\t\t\t\t\t}
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t\tvar response = warningResponse;
\t\t\t\t\t\t\tif(xhr.responseJSON)
\t\t\t\t\t\t\t\tresponse = xhr.responseJSON;
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t}
\t\t\t\t\t});
\t\t\t\t}
\t\t\t});

\t\t\tvar FolderList = Backbone.View.extend({
\t\t\t\tel : \$(\".uv-list-view div.folder-list\"),
\t\t\t\tnoResultTemplate : _.template(\$(\"#no_result_tmp\").html()),
\t\t\t\tinitialize : function() {
\t\t\t\t\tthis.render();
\t\t\t\t},
\t\t\t\trender : function () {
\t\t\t\t\tthis.\$el.html('');
\t\t\t\t\tthis.\$el.find(\".uv-app-list-brick\").remove();
\t\t\t\t\tvar isEmptyFlag = 0;
\t\t\t\t\tif(folderCollection.length) {
\t\t\t\t\t\tisEmptyFlag++;
\t\t\t\t\t\t_.each(folderCollection.models, function (item) {
\t\t\t\t\t\t\tthis.renderFolder(item);
\t\t\t\t\t\t}, this);
\t\t\t\t\t}

                    if(!isEmptyFlag) {
                        this.\$el.append(this.noResultTemplate())
                    }
\t\t\t\t},
\t\t\t\trenderFolder : function (item) {
\t\t\t\t\tvar folderItem = new FolderItem({
\t\t\t\t\t\tmodel: item
\t\t\t\t\t});
\t\t\t\t\tthis.\$el.append(folderItem.render().el);
\t\t\t\t}
\t\t\t});

\t\t\tvar Filter = app.Filter.extend({
\t\t\t\tdefaultSortIndex: 'a.dateAdded',
\t\t\t\tsortText: \"{% trans %}Sort By:{% endtrans %} \",
\t\t\t\tdefaultSortText: \"{% trans %}Sort By:{% endtrans %} {% trans %}Created At{% endtrans %}\",
\t\t\t\ttemplate : _.template(\$(\"#entity_list_sorting_tmp\").html())
\t\t\t})

\t\t\tvar folderCollection = new FolderCollection();

\t\t\tvar filter = new Filter({
\t\t\t\tcollection : folderCollection
\t\t\t});

\t\t\tvar PageView = Backbone.View.extend({
                el: '.uv-folders',
                events : {
\t\t\t\t\t\"change input[type='radio']\": 'layoutChanged'
                },
                layoutChanged: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    \$('.uv-layout-icon').removeClass('uv-layout-icon-active');

                    \$(\"label[for='\" + currentElement.attr('id') + \"']\").addClass('uv-layout-icon-active');

\t\t\t\t\tapp.appView.showLoader();

\t\t\t\t\t\$.ajax({
\t\t\t\t\t\turl : pathLayout,
\t\t\t\t\t\ttype : 'POST',
\t\t\t\t\t\tdata: {\"layout\" : Backbone.\$(e.currentTarget).val(), \"actionType\": 'layoutUpdate'},
\t\t\t\t\t\tdataType : 'json',
\t\t\t\t\t\tsuccess: function (response) {
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t\t\t},
\t\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t\t\tvar response = warningResponse;
\t\t\t\t\t\t\tif(xhr.responseJSON)
\t\t\t\t\t\t\t\tresponse = xhr.responseJSON;
\t\t\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\t\t\tapp.appView.renderResponseAlert(response);
                        }
\t\t\t\t\t});
                },
            });

\t\t\tvar pageView = new PageView();

\t\t\tRouter = Backbone.Router.extend({
\t\t\t\troutes: {
\t\t\t\t\t'page/:number(/sort/:sortField)(/direction/:order)' : 'paginate',
\t\t\t\t\t'isActive/:status(/search/:query)(/page/:number)(/sort/:sortField)(/direction/:order)' : 'filterFolderByStatus',
\t\t\t\t\t'search/:query(/page/:number)(/sort/:sortField)(/direction/:order)' : 'filterByQuery',
\t\t\t\t\t'' : 'initializeList'
\t\t\t\t},
\t\t\t\tinitializeList : function() {
\t\t\t\t\tthis.resetParams('', '');
\t\t\t\t\tfolderCollection.state.currentPage = null;
\t\t\t\t\tfilter.sortCollection();
\t\t\t\t\tfolderCollection.syncData();
\t\t\t\t},
\t\t\t\tpaginate : function(number,sortField,order) {
\t\t\t\t\tthis.resetParams('', '');
\t\t\t\t\tfolderCollection.state.currentPage = number;
\t\t\t\t\tfilter.sortCollection(sortField,order);
\t\t\t\t\tfolderCollection.syncData();
\t\t\t\t},
\t\t\t\tfilterFolderByStatus: function(status,query,number,sortField,order) {
\t\t\t\t\tthis.resetParams(status,query);
\t\t\t\t\tfolderCollection.state.currentPage = number;
\t\t\t\t\tfilter.sortCollection(sortField,order);
\t\t\t\t\tfolderCollection.syncData();
\t\t\t\t},
\t\t\t\tfilterByQuery : function(query,number,sortField,order) {
\t\t\t\t\tthis.resetParams('',query);
\t\t\t\t\tfolderCollection.state.currentPage = number;
\t\t\t\t\tfilter.sortCollection(sortField,order);
\t\t\t\t\tfolderCollection.syncData();
\t\t\t\t},
\t\t\t\tresetParams : function(status, query) {
\t\t\t\t\tif(query != null)
\t\t\t\t\t\tquery = query.replace(/\\+/g,' ');
\t\t\t\t\tfolderCollection.filterParameters.isActive = status;
\t\t\t\t\tvar statusText = status ? \$(\".filter-by-status a[data-id='\" + status + \"']\").text() : \"{% trans %}All{% endtrans %}\";
\t\t\t\t\t\$(\".filter-by-status .uv-dropdown-btn\").text(\"{% trans %}Status:{% endtrans %} \" + statusText);
\t\t\t\t\tfolderCollection.filterParameters.search = query;
\t\t\t\t\t\$(\".uv-search-inline\").val(query);
\t\t\t\t}
\t\t\t});

\t\t\trouter = new Router();
\t\t\tBackbone.history.start({push_state:true});
\t\t});
\t</script>
{% endblock %}
", "@UVDeskSupportCenter/Staff/Folders/listFolders.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Staff/Folders/listFolders.html.twig");
    }
}
