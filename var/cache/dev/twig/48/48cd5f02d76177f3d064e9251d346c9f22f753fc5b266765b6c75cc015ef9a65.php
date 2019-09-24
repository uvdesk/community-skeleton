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

/* @UVDeskCoreFramework/tickets/quick-actions/saved-replies.html.twig */
class __TwigTemplate_75326343e2a3c65bb8f727663b26059868e2d5a85aa446c2d2110ff6fe4aec04 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/tickets/quick-actions/saved-replies.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/tickets/quick-actions/saved-replies.html.twig"));

        // line 1
        echo "<div class=\"uv-dropdown saved-reply\">
    <div class=\"uv-dropdown-btn\">";
        // line 2
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Saved Replies"), "html", null, true);
        echo "</div>
    <div class=\"uv-dropdown-list uv-top-left\">
        <div class=\"uv-dropdown-container\">
            <label>";
        // line 5
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Saved Replies"), "html", null, true);
        echo "</label>
            <ul>
                <li data-id=\"\">
                    <a href=\"";
        // line 8
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_saved_replies");
        echo "\" target=\"_blank\" style=\"color: #2750C4\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Create New"), "html", null, true);
        echo "</a>
                </li>
                
                ";
        // line 11
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 11, $this->source); })()), "getSavedReplies", [], "method", false, false, false, 11));
        foreach ($context['_seq'] as $context["_key"] => $context["savedReply"]) {
            // line 12
            echo "                    <li data-id=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["savedReply"], "id", [], "any", false, false, false, 12), "html", null, true);
            echo "\">
                        ";
            // line 13
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["savedReply"], "name", [], "any", false, false, false, 13), "html", null, true);
            echo "
                    </li>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['savedReply'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        echo "            </ul>
        </div>
    </div>
</div>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework/tickets/quick-actions/saved-replies.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  84 => 16,  75 => 13,  70 => 12,  66 => 11,  58 => 8,  52 => 5,  46 => 2,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"uv-dropdown saved-reply\">
    <div class=\"uv-dropdown-btn\">{{ 'Saved Replies'|trans }}</div>
    <div class=\"uv-dropdown-list uv-top-left\">
        <div class=\"uv-dropdown-container\">
            <label>{{ 'Saved Replies'|trans }}</label>
            <ul>
                <li data-id=\"\">
                    <a href=\"{{ path('helpdesk_member_saved_replies') }}\" target=\"_blank\" style=\"color: #2750C4\">{{ 'Create New'|trans }}</a>
                </li>
                
                {% for savedReply in ticket_service.getSavedReplies() %}
                    <li data-id=\"{{ savedReply.id }}\">
                        {{ savedReply.name }}
                    </li>
                {% endfor %}
            </ul>
        </div>
    </div>
</div>
", "@UVDeskCoreFramework/tickets/quick-actions/saved-replies.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/tickets/quick-actions/saved-replies.html.twig");
    }
}
