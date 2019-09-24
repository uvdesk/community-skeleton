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

/* @UVDeskAutomation/tickets/quick-actions/prepared-responses.html.twig */
class __TwigTemplate_c064f741c178751bec4e483fc8d9de82e363ad17d0150f523647416c1c97972c extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskAutomation/tickets/quick-actions/prepared-responses.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskAutomation/tickets/quick-actions/prepared-responses.html.twig"));

        // line 1
        echo "<div class=\"uv-dropdown\">
    <div class=\"uv-dropdown-btn\">";
        // line 2
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Prepared Responses"), "html", null, true);
        echo "</div>
    <div class=\"uv-dropdown-list uv-top-left\">
        <div class=\"uv-dropdown-container prepared-responses\">
            <label>";
        // line 5
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Prepared Responses"), "html", null, true);
        echo "</label>
            <ul>
                <li>
                    <a class=\"create-new\" href=\"";
        // line 8
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("prepare_response_action");
        echo "\" target=\"_blank\" style=\"color: #2750C4\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Create New"), "html", null, true);
        echo "</a>
                </li>
                
                ";
        // line 11
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 11, $this->source); })()), "getManualWorkflow", [], "method", false, false, false, 11));
        foreach ($context['_seq'] as $context["_key"] => $context["preparedResponse"]) {
            // line 12
            echo "                    <li>
                        <a href=\"";
            // line 13
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_ticket_prepared_response_xhr");
            echo "/";
            echo twig_escape_filter($this->env, (isset($context["ticketId"]) || array_key_exists("ticketId", $context) ? $context["ticketId"] : (function () { throw new RuntimeError('Variable "ticketId" does not exist.', 13, $this->source); })()), "html", null, true);
            echo "/";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["preparedResponse"], "id", [], "any", false, false, false, 13), "html", null, true);
            echo "\">
                            ";
            // line 14
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["preparedResponse"], "name", [], "any", false, false, false, 14), "html", null, true);
            echo "
                        </a>
                    </li>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['preparedResponse'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 18
        echo "            </ul>
        </div>
    </div>
</div>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskAutomation/tickets/quick-actions/prepared-responses.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 18,  81 => 14,  73 => 13,  70 => 12,  66 => 11,  58 => 8,  52 => 5,  46 => 2,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"uv-dropdown\">
    <div class=\"uv-dropdown-btn\">{{ 'Prepared Responses'|trans }}</div>
    <div class=\"uv-dropdown-list uv-top-left\">
        <div class=\"uv-dropdown-container prepared-responses\">
            <label>{{ 'Prepared Responses'|trans }}</label>
            <ul>
                <li>
                    <a class=\"create-new\" href=\"{{path('prepare_response_action')}}\" target=\"_blank\" style=\"color: #2750C4\">{{ 'Create New'|trans }}</a>
                </li>
                
                {% for preparedResponse in ticket_service.getManualWorkflow() %}
                    <li>
                        <a href=\"{{ path('helpdesk_member_ticket_prepared_response_xhr') }}/{{ ticketId }}/{{ preparedResponse.id }}\">
                            {{ preparedResponse.name }}
                        </a>
                    </li>
                {% endfor %}
            </ul>
        </div>
    </div>
</div>", "@UVDeskAutomation/tickets/quick-actions/prepared-responses.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/automation-bundle/Resources/views/tickets/quick-actions/prepared-responses.html.twig");
    }
}
