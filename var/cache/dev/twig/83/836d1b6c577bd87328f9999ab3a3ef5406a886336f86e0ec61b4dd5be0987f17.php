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

/* @UVDeskSupportCenter/Themes/cookiePolicy.html.twig */
class __TwigTemplate_b0a40f57c3af8bc4b4b78dbf71461a20edcb1304322cf9001c7a13e0e0640946 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Themes/cookiePolicy.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Themes/cookiePolicy.html.twig"));

        // line 1
        echo "<div class=\"uv-pop-up-overlay uv-no-error-success-icon\" id=\"cookie-dialog-modal\" style=\"display:none;\">
    <div class=\"uv-pop-up-box uv-pop-up-wide\">
        <span class=\"uv-pop-up-close\"></span>
        <h2 style=\"text-align: center; margin-bottom: 30px;\">";
        // line 4
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Cookie Usage Policy"), "html", null, true);
        echo "</h2>
        <div class=\"uv-element-block\" style=\"line-height: 1.8em;\">
            <p>";
        // line 6
        echo $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Some of our site pages utilize %cookies% and other tracking technologies. A %cookie% is a small text file that may be used, for example, to collect information about site activity. Some cookies and other technologies may serve to recall personal information previously indicated by a site user. You may block cookies, or delete existing cookies, by adjusting the appropriate setting on your browser. Please consult the %help% menu of your browser to learn how to do this. If you block or delete %cookies% you may find the usefulness of our site to be impaired.", ["%cookie%" => (("<em>" . $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("cookie")) . "</em>"), "%cookies%" => (("<em>" . $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("cookies")) . "</em>"), "%help%" => (("<b>" . $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("HELP")) . "</b>")]);
        echo "</p>
            <p>";
        // line 7
        echo $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("To know more about how our privacy policy works, please %websiteLink%.", ["%websiteLink%" => (("<a href=\"https://www.uvdesk.com/en/privacy-policy/\" target=\"_blank\">" . "visit our website") . "</a>")]);
        echo "</p>
        </div>
    </div>
</div>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Themes/cookiePolicy.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  57 => 7,  53 => 6,  48 => 4,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"uv-pop-up-overlay uv-no-error-success-icon\" id=\"cookie-dialog-modal\" style=\"display:none;\">
    <div class=\"uv-pop-up-box uv-pop-up-wide\">
        <span class=\"uv-pop-up-close\"></span>
        <h2 style=\"text-align: center; margin-bottom: 30px;\">{{ 'Cookie Usage Policy'|trans }}</h2>
        <div class=\"uv-element-block\" style=\"line-height: 1.8em;\">
            <p>{{ 'Some of our site pages utilize %cookies% and other tracking technologies. A %cookie% is a small text file that may be used, for example, to collect information about site activity. Some cookies and other technologies may serve to recall personal information previously indicated by a site user. You may block cookies, or delete existing cookies, by adjusting the appropriate setting on your browser. Please consult the %help% menu of your browser to learn how to do this. If you block or delete %cookies% you may find the usefulness of our site to be impaired.'|trans({'%cookie%': '<em>' ~ 'cookie'|trans ~ '</em>', '%cookies%': '<em>' ~ 'cookies'|trans ~ '</em>', '%help%': '<b>' ~ 'HELP'|trans ~ '</b>'})|raw }}</p>
            <p>{{ \"To know more about how our privacy policy works, please %websiteLink%.\"|trans({'%websiteLink%': '<a href=\"https://www.uvdesk.com/en/privacy-policy/\" target=\"_blank\">' ~ 'visit our website' ~ '</a>'})|raw }}</p>
        </div>
    </div>
</div>
", "@UVDeskSupportCenter/Themes/cookiePolicy.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Themes/cookiePolicy.html.twig");
    }
}
