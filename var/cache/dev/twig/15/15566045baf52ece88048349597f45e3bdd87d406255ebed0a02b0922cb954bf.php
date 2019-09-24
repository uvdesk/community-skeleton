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

/* @UVDeskSupportCenter/Templates/pagination.html.twig */
class __TwigTemplate_35a464f70354c63ee6e9a58bcc1a25083486d415e61b79ef4d4c64a8cc4829ba extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Templates/pagination.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Templates/pagination.html.twig"));

        // line 1
        echo "<script id=\"pagination_tmp\" type=\"text/template\">
    <% if(pageCount > 1) { %>
        <div class=\"uv-pagination\">
            <% if(previous) { %>
                <a data-page=\"<%= previous %>\" href=\"<%= url.replace('replacePage', previous) %>\" id=\"previous\" class=\"uv-pagination-previous\">
                </a>
            <% } else { %>
                <a class=\"uv-pagination-previous\">
                </a>
            <% } %>

            <% if(startPage > 1) { %>
                <a data-page=\"1\" href=\"<%= url.replace('replacePage', 1) %>\">1</a>
                <% if(startPage == 3) { %>
                    <a data-page=\"2\" href=\"<%= url.replace('replacePage', 2) %>\">2</a>
                <% } else if(startPage != 2) { %>
                    <a class=\"uv-page-active\" style=\"text-decoration: none\">&hellip;</a>
                <% } %>
            <% } %>

            <% _.each(pagesInRange, function(page) { %>
                <% if(page != current) { %>
                    <a data-page=\"<%= page %>\" href=\"<%= url.replace('replacePage', page) %>\">
                        <%= page %>
                    </a>
                <% } else { %>
                    <a class=\"uv-page-active\"><%= page %></a>
                <% } %>
            <% }) %>

            <% if(pageCount > endPage) { %>
                <% if(pageCount > (endPage + 1) ) { %>
                    <% if(pageCount > (endPage + 2) ) { %>
                        <a class=\"uv-page-active\" style=\"text-decoration: none\">&hellip;</a>
                    <% } else { %>
                        <a data-page=\"<%= pageCount - 1 %>\" href=\"<%= url.replace('replacePage', pageCount - 1) %>\">
                            <%= pageCount - 1 %>
                        </a>
                    <% } %>
                <% } %>
                <a data-page=\"<%= pageCount %>\" href=\"<%= url.replace('replacePage', pageCount) %>\">
                    <%= pageCount %>
                </a>
            <% } %>

            <% if(next) { %>
                <a href=\"<%= url.replace('replacePage',next) %>\" data-page=\"<%= next %>\" id=\"next\" class=\"uv-pagination-next\">
                </a>
            <% } else { %>
                <a class=\"uv-pagination-next\">
                </a>
            <% } %>
        </div>
    <% } %>
</script>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Templates/pagination.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<script id=\"pagination_tmp\" type=\"text/template\">
    <% if(pageCount > 1) { %>
        <div class=\"uv-pagination\">
            <% if(previous) { %>
                <a data-page=\"<%= previous %>\" href=\"<%= url.replace('replacePage', previous) %>\" id=\"previous\" class=\"uv-pagination-previous\">
                </a>
            <% } else { %>
                <a class=\"uv-pagination-previous\">
                </a>
            <% } %>

            <% if(startPage > 1) { %>
                <a data-page=\"1\" href=\"<%= url.replace('replacePage', 1) %>\">1</a>
                <% if(startPage == 3) { %>
                    <a data-page=\"2\" href=\"<%= url.replace('replacePage', 2) %>\">2</a>
                <% } else if(startPage != 2) { %>
                    <a class=\"uv-page-active\" style=\"text-decoration: none\">&hellip;</a>
                <% } %>
            <% } %>

            <% _.each(pagesInRange, function(page) { %>
                <% if(page != current) { %>
                    <a data-page=\"<%= page %>\" href=\"<%= url.replace('replacePage', page) %>\">
                        <%= page %>
                    </a>
                <% } else { %>
                    <a class=\"uv-page-active\"><%= page %></a>
                <% } %>
            <% }) %>

            <% if(pageCount > endPage) { %>
                <% if(pageCount > (endPage + 1) ) { %>
                    <% if(pageCount > (endPage + 2) ) { %>
                        <a class=\"uv-page-active\" style=\"text-decoration: none\">&hellip;</a>
                    <% } else { %>
                        <a data-page=\"<%= pageCount - 1 %>\" href=\"<%= url.replace('replacePage', pageCount - 1) %>\">
                            <%= pageCount - 1 %>
                        </a>
                    <% } %>
                <% } %>
                <a data-page=\"<%= pageCount %>\" href=\"<%= url.replace('replacePage', pageCount) %>\">
                    <%= pageCount %>
                </a>
            <% } %>

            <% if(next) { %>
                <a href=\"<%= url.replace('replacePage',next) %>\" data-page=\"<%= next %>\" id=\"next\" class=\"uv-pagination-next\">
                </a>
            <% } else { %>
                <a class=\"uv-pagination-next\">
                </a>
            <% } %>
        </div>
    <% } %>
</script>
", "@UVDeskSupportCenter/Templates/pagination.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Templates/pagination.html.twig");
    }
}
