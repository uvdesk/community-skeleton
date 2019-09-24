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

/* @UVDeskCoreFramework/Templates/sidebar.html.twig */
class __TwigTemplate_be7b4ca8106376a2fca551e1e9ba14802ef3aa3a17b80be892527f31d73be49f extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Templates/sidebar.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Templates/sidebar.html.twig"));

        // line 1
        echo "<style>
    .uv-sidebar:not(.uv-sidebar-active) .uv-language .lang-wrapper {
        width: 300px;
        text-align: center;
        transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .uv-sidebar ul.uv-menubar.uv-language{
        position: fixed;
        bottom: 0px;
    }
    
    .uv-sidebar.uv-sidebar-active ul.uv-menubar.uv-language li a{
        width: 58px;
    }
    
    .uv-sidebar ul.uv-menubar.uv-language li a{
        max-width: 100%;
    }
    
    .uv-sidebar ul.uv-menubar.uv-language li a:hover, .uv-sidebar ul.uv-menubar.uv-language li .uv-item-active{
        color: #9E9E9E !important;
        border-left: 3px solid transparent;
    }
    
    .uv-sidebar ul.uv-menubar.uv-language a.uv-cursor{
        padding: 25px 27px;
    }
    
    .uv-sidebar ul.uv-menubar.uv-language .uv-profile.uv-dropdown-other{
        margin: -25px -27px;
        padding: 17px 18px;
    }

    ";
        // line 44
        echo "
    @media only screen and (max-width: 900px) {
        .uv-sidebar ul.uv-menubar.uv-language li a {
            width: 58px;
        }
    }
</style>

";
        // line 52
        if ((null == twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 52, $this->source); })()), "request", [], "any", false, false, false, 52), "cookies", [], "any", false, false, false, 52), "get", [0 => "uv-sidebar-status"], "method", false, false, false, 52))) {
            // line 53
            echo "\t<script type=\"text/javascript\">
\t\tdocument.addEventListener(\"DOMContentLoaded\", function(e) {
\t\t\twindow.dispatchEvent(new Event('resize'));
\t\t    var uvView = document.querySelector(\".uv-view\");
\t\t\tif(uvView && uvView.offsetWidth <= 1340) {
\t\t\t\tdocument.cookie = \"uv-sidebar-status=1; expires=Wed, 01 Jan 2020 00:00:00 GMT;path=/\";
\t\t\t}
\t\t});
\t</script>
";
        }
        // line 63
        echo "
<div class=\"uv-sidebar ";
        // line 64
        if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 64, $this->source); })()), "request", [], "any", false, false, false, 64), "cookies", [], "any", false, false, false, 64), "get", [0 => "uv-sidebar-status"], "method", false, false, false, 64)) {
            echo "uv-sidebar-active";
        }
        echo "\">
\t<div style=\"overflow: hidden;\">
\t\t<div class=\"uv-soft-top\">
\t\t\t<a href=\"";
        // line 67
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_dashboard");
        echo "\" class=\"uv-logo\">
\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"123px\" height=\"48px\">
\t\t\t\t\t<path fill-rule=\"evenodd\"  fill=\"rgb(124, 112, 244)\"
\t\t\t\t\t\td=\"M122.389,29.602 L120.229,29.602 L116.821,23.985 L114.637,26.529 L114.637,29.602 L112.693,29.602 L112.693,12.512 L114.637,12.512 L114.637,24.081 L114.709,24.081 L119.677,17.937 L121.861,17.937 L117.949,22.617 L122.389,29.602 ZM106.405,22.881 C108.085,23.505 109.957,24.201 109.957,26.409 C109.957,28.305 108.445,29.890 105.685,29.890 C104.029,29.890 102.445,29.194 101.341,28.281 L102.325,26.961 C103.333,27.777 104.365,28.353 105.757,28.353 C107.293,28.353 108.061,27.537 108.061,26.529 C108.061,25.329 106.669,24.801 105.397,24.321 C103.741,23.721 101.917,22.929 101.917,20.961 C101.917,19.089 103.405,17.649 105.925,17.649 C107.389,17.649 108.661,18.249 109.549,18.969 L108.613,20.217 C107.821,19.617 106.981,19.185 105.949,19.185 C104.485,19.185 103.813,19.977 103.813,20.865 C103.813,21.945 105.085,22.377 106.405,22.881 ZM91.813,24.201 C91.957,26.721 93.469,28.305 95.701,28.305 C96.806,28.305 97.742,27.945 98.606,27.393 L99.302,28.689 C98.294,29.338 97.046,29.890 95.461,29.890 C92.341,29.890 89.869,27.609 89.869,23.793 C89.869,19.977 92.437,17.649 95.101,17.649 C98.078,17.649 99.758,19.785 99.758,23.121 C99.758,23.529 99.734,23.913 99.686,24.201 L91.813,24.201 ZM95.149,19.209 C93.517,19.209 92.029,20.553 91.789,22.905 L98.030,22.905 C98.030,20.529 96.974,19.209 95.149,19.209 ZM84.998,28.233 L84.926,28.233 C84.014,29.122 82.766,29.890 81.398,29.890 C78.469,29.890 76.573,27.681 76.573,23.793 C76.573,20.001 78.973,17.649 81.638,17.649 C82.982,17.649 83.870,18.153 84.902,18.993 L84.806,17.000 L84.806,12.512 L86.798,12.512 L86.798,29.602 L85.166,29.602 L84.998,28.233 ZM84.806,20.529 C83.822,19.641 82.934,19.305 81.974,19.305 C80.101,19.305 78.613,21.105 78.613,23.769 C78.613,26.553 79.789,28.233 81.830,28.233 C82.910,28.233 83.846,27.705 84.806,26.625 L84.806,20.529 ZM68.822,29.602 L64.621,17.937 L66.661,17.937 L68.870,24.561 C69.206,25.713 69.590,26.889 69.950,27.993 L70.046,27.993 C70.382,26.889 70.766,25.713 71.102,24.561 L73.310,17.937 L75.254,17.937 L71.126,29.602 L68.822,29.602 ZM60.566,27.777 L60.494,27.777 C59.414,29.050 58.262,29.890 56.654,29.890 C54.182,29.890 53.078,28.305 53.078,25.329 L53.078,17.937 L55.070,17.937 L55.070,25.065 C55.070,27.249 55.718,28.185 57.254,28.185 C58.454,28.185 59.294,27.585 60.398,26.217 L60.398,17.937 L62.366,17.937 L62.366,29.602 L60.734,29.602 L60.566,27.777 ZM27.000,45.000 C26.973,44.292 27.011,42.899 27.000,43.000 C43.768,41.329 42.000,26.000 42.000,26.000 L45.000,26.000 C45.563,40.575 33.324,44.708 27.000,45.000 ZM42.000,24.500 C42.000,23.672 42.672,23.000 43.500,23.000 C44.328,23.000 45.000,23.672 45.000,24.500 L45.000,25.000 L42.000,25.000 L42.000,24.500 ZM39.000,31.000 L38.000,31.000 L38.000,18.000 L39.000,18.000 C39.945,18.000 41.000,19.066 41.000,20.000 L41.000,29.000 C41.000,29.934 39.945,31.000 39.000,31.000 ZM10.492,33.000 C8.555,33.000 6.986,31.433 6.986,29.501 C6.986,27.569 8.555,26.002 10.492,26.002 C12.428,26.002 13.998,27.569 13.998,29.501 C13.998,31.433 12.428,33.000 10.492,33.000 ZM37.000,19.000 L33.000,22.000 C28.171,24.696 23.059,25.515 17.000,23.000 C14.589,21.999 13.107,20.137 12.000,19.000 C10.074,21.163 6.902,23.525 3.000,24.000 L3.386,29.280 C3.386,33.462 5.179,37.850 8.000,41.000 C9.633,42.824 10.936,44.167 13.000,45.000 L12.000,48.000 C9.232,47.008 7.143,45.393 5.000,43.000 C1.629,39.236 -0.000,34.011 -0.000,29.000 L-0.000,18.000 C-0.000,8.047 7.935,-0.000 18.000,-0.000 C27.872,-0.000 36.692,8.308 37.000,18.000 C37.036,19.142 37.000,19.000 37.000,19.000 ZM27.504,26.002 C29.440,26.002 31.010,27.569 31.010,29.501 C31.010,31.433 29.440,33.000 27.504,33.000 C25.567,33.000 23.997,31.433 23.997,29.501 C23.997,27.569 25.567,26.002 27.504,26.002 ZM23.999,41.989 C25.097,41.989 25.987,42.889 25.987,44.000 C25.987,45.111 25.097,46.011 23.999,46.011 C22.902,46.011 22.012,45.111 22.012,44.000 C22.012,42.889 22.902,41.989 23.999,41.989 Z\"/>
\t\t\t\t</svg>
\t\t\t</a>

\t\t\t<span class=\"uv-hamburger\">
\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"20px\" height=\"14px\">
                    <path fill-rule=\"evenodd\"  fill=\"rgb(158, 158, 158)\" d=\"M19.000,2.000 L6.000,2.000 C5.448,2.000 5.000,1.552 5.000,1.000 C5.000,0.448 5.448,-0.000 6.000,-0.000 L19.000,-0.000 C19.552,-0.000 20.000,0.448 20.000,1.000 C20.000,1.552 19.552,2.000 19.000,2.000 ZM20.000,7.000 C20.000,7.552 19.552,8.000 19.000,8.000 L1.000,8.000 C0.448,8.000 0.000,7.552 0.000,7.000 C0.000,6.448 0.448,6.000 1.000,6.000 L19.000,6.000 C19.552,6.000 20.000,6.448 20.000,7.000 ZM3.000,12.000 L15.000,12.000 C15.552,12.000 16.000,12.448 16.000,13.000 C16.000,13.552 15.552,14.000 15.000,14.000 L3.000,14.000 C2.448,14.000 2.000,13.552 2.000,13.000 C2.000,12.448 2.448,12.000 3.000,12.000 Z\"/>
\t\t\t\t</svg>
\t\t\t</span>
\t\t</div>
\t</div>

\t<ul class=\"uv-menubar\">
\t\t";
        // line 84
        echo "        ";
        $context["route"] = twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 84, $this->source); })()), "request", [], "any", false, false, false, 84), "attributes", [], "any", false, false, false, 84), "get", [0 => "_route"], "method", false, false, false, 84);
        // line 85
        echo "        
\t\t";
        // line 86
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 86, $this->source); })()), "getRegisteredComponent", [0 => "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\Dashboard"], "method", false, false, false, 86), "getNavigationTemplate", [], "method", false, false, false, 86), "render", [], "method", false, false, false, 86);
        echo "
\t</ul>
</div>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework/Templates/sidebar.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  139 => 86,  136 => 85,  133 => 84,  114 => 67,  106 => 64,  103 => 63,  91 => 53,  89 => 52,  79 => 44,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<style>
    .uv-sidebar:not(.uv-sidebar-active) .uv-language .lang-wrapper {
        width: 300px;
        text-align: center;
        transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .uv-sidebar ul.uv-menubar.uv-language{
        position: fixed;
        bottom: 0px;
    }
    
    .uv-sidebar.uv-sidebar-active ul.uv-menubar.uv-language li a{
        width: 58px;
    }
    
    .uv-sidebar ul.uv-menubar.uv-language li a{
        max-width: 100%;
    }
    
    .uv-sidebar ul.uv-menubar.uv-language li a:hover, .uv-sidebar ul.uv-menubar.uv-language li .uv-item-active{
        color: #9E9E9E !important;
        border-left: 3px solid transparent;
    }
    
    .uv-sidebar ul.uv-menubar.uv-language a.uv-cursor{
        padding: 25px 27px;
    }
    
    .uv-sidebar ul.uv-menubar.uv-language .uv-profile.uv-dropdown-other{
        margin: -25px -27px;
        padding: 17px 18px;
    }

    {# .uv-logo-image {
\t\theight: 50px;
\t\twidth: 50px;\t
\t}

\t.hamburger-click-area{
\t\twidth: 30px;
\t\theight: 30px;
\t} #}

    @media only screen and (max-width: 900px) {
        .uv-sidebar ul.uv-menubar.uv-language li a {
            width: 58px;
        }
    }
</style>

{% if null == app.request.cookies.get('uv-sidebar-status') %}
\t<script type=\"text/javascript\">
\t\tdocument.addEventListener(\"DOMContentLoaded\", function(e) {
\t\t\twindow.dispatchEvent(new Event('resize'));
\t\t    var uvView = document.querySelector(\".uv-view\");
\t\t\tif(uvView && uvView.offsetWidth <= 1340) {
\t\t\t\tdocument.cookie = \"uv-sidebar-status=1; expires=Wed, 01 Jan 2020 00:00:00 GMT;path=/\";
\t\t\t}
\t\t});
\t</script>
{% endif %}

<div class=\"uv-sidebar {% if app.request.cookies.get('uv-sidebar-status') %}uv-sidebar-active{% endif %}\">
\t<div style=\"overflow: hidden;\">
\t\t<div class=\"uv-soft-top\">
\t\t\t<a href=\"{{ path('helpdesk_member_dashboard') }}\" class=\"uv-logo\">
\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"123px\" height=\"48px\">
\t\t\t\t\t<path fill-rule=\"evenodd\"  fill=\"rgb(124, 112, 244)\"
\t\t\t\t\t\td=\"M122.389,29.602 L120.229,29.602 L116.821,23.985 L114.637,26.529 L114.637,29.602 L112.693,29.602 L112.693,12.512 L114.637,12.512 L114.637,24.081 L114.709,24.081 L119.677,17.937 L121.861,17.937 L117.949,22.617 L122.389,29.602 ZM106.405,22.881 C108.085,23.505 109.957,24.201 109.957,26.409 C109.957,28.305 108.445,29.890 105.685,29.890 C104.029,29.890 102.445,29.194 101.341,28.281 L102.325,26.961 C103.333,27.777 104.365,28.353 105.757,28.353 C107.293,28.353 108.061,27.537 108.061,26.529 C108.061,25.329 106.669,24.801 105.397,24.321 C103.741,23.721 101.917,22.929 101.917,20.961 C101.917,19.089 103.405,17.649 105.925,17.649 C107.389,17.649 108.661,18.249 109.549,18.969 L108.613,20.217 C107.821,19.617 106.981,19.185 105.949,19.185 C104.485,19.185 103.813,19.977 103.813,20.865 C103.813,21.945 105.085,22.377 106.405,22.881 ZM91.813,24.201 C91.957,26.721 93.469,28.305 95.701,28.305 C96.806,28.305 97.742,27.945 98.606,27.393 L99.302,28.689 C98.294,29.338 97.046,29.890 95.461,29.890 C92.341,29.890 89.869,27.609 89.869,23.793 C89.869,19.977 92.437,17.649 95.101,17.649 C98.078,17.649 99.758,19.785 99.758,23.121 C99.758,23.529 99.734,23.913 99.686,24.201 L91.813,24.201 ZM95.149,19.209 C93.517,19.209 92.029,20.553 91.789,22.905 L98.030,22.905 C98.030,20.529 96.974,19.209 95.149,19.209 ZM84.998,28.233 L84.926,28.233 C84.014,29.122 82.766,29.890 81.398,29.890 C78.469,29.890 76.573,27.681 76.573,23.793 C76.573,20.001 78.973,17.649 81.638,17.649 C82.982,17.649 83.870,18.153 84.902,18.993 L84.806,17.000 L84.806,12.512 L86.798,12.512 L86.798,29.602 L85.166,29.602 L84.998,28.233 ZM84.806,20.529 C83.822,19.641 82.934,19.305 81.974,19.305 C80.101,19.305 78.613,21.105 78.613,23.769 C78.613,26.553 79.789,28.233 81.830,28.233 C82.910,28.233 83.846,27.705 84.806,26.625 L84.806,20.529 ZM68.822,29.602 L64.621,17.937 L66.661,17.937 L68.870,24.561 C69.206,25.713 69.590,26.889 69.950,27.993 L70.046,27.993 C70.382,26.889 70.766,25.713 71.102,24.561 L73.310,17.937 L75.254,17.937 L71.126,29.602 L68.822,29.602 ZM60.566,27.777 L60.494,27.777 C59.414,29.050 58.262,29.890 56.654,29.890 C54.182,29.890 53.078,28.305 53.078,25.329 L53.078,17.937 L55.070,17.937 L55.070,25.065 C55.070,27.249 55.718,28.185 57.254,28.185 C58.454,28.185 59.294,27.585 60.398,26.217 L60.398,17.937 L62.366,17.937 L62.366,29.602 L60.734,29.602 L60.566,27.777 ZM27.000,45.000 C26.973,44.292 27.011,42.899 27.000,43.000 C43.768,41.329 42.000,26.000 42.000,26.000 L45.000,26.000 C45.563,40.575 33.324,44.708 27.000,45.000 ZM42.000,24.500 C42.000,23.672 42.672,23.000 43.500,23.000 C44.328,23.000 45.000,23.672 45.000,24.500 L45.000,25.000 L42.000,25.000 L42.000,24.500 ZM39.000,31.000 L38.000,31.000 L38.000,18.000 L39.000,18.000 C39.945,18.000 41.000,19.066 41.000,20.000 L41.000,29.000 C41.000,29.934 39.945,31.000 39.000,31.000 ZM10.492,33.000 C8.555,33.000 6.986,31.433 6.986,29.501 C6.986,27.569 8.555,26.002 10.492,26.002 C12.428,26.002 13.998,27.569 13.998,29.501 C13.998,31.433 12.428,33.000 10.492,33.000 ZM37.000,19.000 L33.000,22.000 C28.171,24.696 23.059,25.515 17.000,23.000 C14.589,21.999 13.107,20.137 12.000,19.000 C10.074,21.163 6.902,23.525 3.000,24.000 L3.386,29.280 C3.386,33.462 5.179,37.850 8.000,41.000 C9.633,42.824 10.936,44.167 13.000,45.000 L12.000,48.000 C9.232,47.008 7.143,45.393 5.000,43.000 C1.629,39.236 -0.000,34.011 -0.000,29.000 L-0.000,18.000 C-0.000,8.047 7.935,-0.000 18.000,-0.000 C27.872,-0.000 36.692,8.308 37.000,18.000 C37.036,19.142 37.000,19.000 37.000,19.000 ZM27.504,26.002 C29.440,26.002 31.010,27.569 31.010,29.501 C31.010,31.433 29.440,33.000 27.504,33.000 C25.567,33.000 23.997,31.433 23.997,29.501 C23.997,27.569 25.567,26.002 27.504,26.002 ZM23.999,41.989 C25.097,41.989 25.987,42.889 25.987,44.000 C25.987,45.111 25.097,46.011 23.999,46.011 C22.902,46.011 22.012,45.111 22.012,44.000 C22.012,42.889 22.902,41.989 23.999,41.989 Z\"/>
\t\t\t\t</svg>
\t\t\t</a>

\t\t\t<span class=\"uv-hamburger\">
\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"20px\" height=\"14px\">
                    <path fill-rule=\"evenodd\"  fill=\"rgb(158, 158, 158)\" d=\"M19.000,2.000 L6.000,2.000 C5.448,2.000 5.000,1.552 5.000,1.000 C5.000,0.448 5.448,-0.000 6.000,-0.000 L19.000,-0.000 C19.552,-0.000 20.000,0.448 20.000,1.000 C20.000,1.552 19.552,2.000 19.000,2.000 ZM20.000,7.000 C20.000,7.552 19.552,8.000 19.000,8.000 L1.000,8.000 C0.448,8.000 0.000,7.552 0.000,7.000 C0.000,6.448 0.448,6.000 1.000,6.000 L19.000,6.000 C19.552,6.000 20.000,6.448 20.000,7.000 ZM3.000,12.000 L15.000,12.000 C15.552,12.000 16.000,12.448 16.000,13.000 C16.000,13.552 15.552,14.000 15.000,14.000 L3.000,14.000 C2.448,14.000 2.000,13.552 2.000,13.000 C2.000,12.448 2.448,12.000 3.000,12.000 Z\"/>
\t\t\t\t</svg>
\t\t\t</span>
\t\t</div>
\t</div>

\t<ul class=\"uv-menubar\">
\t\t{# Sidebar Navigation #}
        {% set route = app.request.attributes.get('_route') %}
        
\t\t{{ uvdesk_extensibles.getRegisteredComponent('Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\Dashboard').getNavigationTemplate().render()|raw }}
\t</ul>
</div>", "@UVDeskCoreFramework/Templates/sidebar.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/Templates/sidebar.html.twig");
    }
}
