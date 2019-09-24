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

/* @UVDeskCoreFramework/Snippets/createMemberTicket.html.twig */
class __TwigTemplate_f0133d0263c7158cb565c2fffd512a2ee31cdeb80c3c845ce4d99f80d052e641 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Snippets/createMemberTicket.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Snippets/createMemberTicket.html.twig"));

        // line 1
        $context["isTicketViewPage"] = ("helpdesk_member_ticket" == twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 1, $this->source); })()), "request", [], "any", false, false, false, 1), "attributes", [], "any", false, false, false, 1), "get", [0 => "_route"], "method", false, false, false, 1));
        // line 2
        echo "
<div class=\"uv-pop-up-overlay uv-no-error-success-icon\" id=\"create-ticket-modal\">
    <div class=\"uv-pop-up-box uv-pop-up-wide\">
        <span class=\"uv-pop-up-close\"></span>
        <h2>Create Ticket</h2>
        <form action=\"";
        // line 7
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_create_ticket");
        echo "\" method=\"post\" id=\"create-ticket-form\" enctype=\"multipart/form-data\">
            ";
        // line 9
        echo "            ";
        if ( !(isset($context["isTicketViewPage"]) || array_key_exists("isTicketViewPage", $context) ? $context["isTicketViewPage"] : (function () { throw new RuntimeError('Variable "isTicketViewPage" does not exist.', 9, $this->source); })())) {
            // line 10
            echo "                ";
            // line 11
            echo "                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">Name</label>
                    <div class=\"uv-field-block\">
                        <input name=\"name\" class=\"uv-field create-ticket\" type=\"text\" value=\"\">
                    </div>
                    <span class=\"uv-field-info\">Customer full name</span>
                </div>

                ";
            // line 20
            echo "                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">Email</label>
                    <div class=\"uv-field-block\">
                        <input name=\"from\" class=\"uv-field create-ticket\" type=\"text\" value=\"\">
                    </div>
                    <span class=\"uv-field-info\">Customer email address</span>
                </div>
            ";
        } else {
            // line 28
            echo "                ";
            // line 29
            echo "                <span class=\"uv-field-info\">Ticket will be created with current ticket's customer</span>
            ";
        }
        // line 31
        echo "
            ";
        // line 33
        echo "            <div class=\"uv-element-block\">
                <label class=\"uv-field-label\">Type</label>
                <div class=\"uv-field-block\">
                    <select name=\"type\" class=\"uv-select create-ticket\" id=\"type\">
                        <option value=\"\">Select type</option>

                        ";
        // line 39
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["ticketTypeCollection"]) || array_key_exists("ticketTypeCollection", $context) ? $context["ticketTypeCollection"] : (function () { throw new RuntimeError('Variable "ticketTypeCollection" does not exist.', 39, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["type"]) {
            // line 40
            echo "                            <option value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["type"], "id", [], "any", false, false, false, 40), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["type"], "description", [], "any", false, false, false, 40), "html", null, true);
            echo "</option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['type'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 42
        echo "                    </select>
                </div>
                
                <span class=\"uv-field-info\">Choose ticket type</span>
            </div>

            ";
        // line 49
        echo "            <div class=\"uv-element-block\">
                <label class=\"uv-field-label\">Subject</label>
                <div class=\"uv-field-block\">
                    <input name=\"subject\" class=\"uv-field create-ticket\" type=\"text\" value=\"\">
                </div>

                <span class=\"uv-field-info\">Ticket subject</span>
            </div>

            ";
        // line 59
        echo "            <div class=\"uv-element-block\">
                <label class=\"uv-field-label\">Message</label>
                <div class=\"uv-field-block\">
                    <textarea name=\"reply\" class=\"uv-field create-ticket\" type=\"text\"></textarea>
                </div>
                
                <span class=\"uv-field-info\">Query message</span>
            </div>

            ";
        // line 69
        echo "            <div class=\"uv-element-block attachment-block uv-no-error-success-icon\" id=\"uv-attachment-option\">
                <label>
                    <span class=\"uv-file-label\">Add Attachment</span>
                </label>
            </div>

            <div class=\"uv-element-block\">
                <button type=\"submit\" id=\"create-ticket-btn\" class=\"uv-btn\">Create Ticket</button>
            </div>
        </form>
    </div>
</div>

";
        // line 82
        if ( !twig_in_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 82, $this->source); })()), "request", [], "any", false, false, false, 82), "attributes", [], "any", false, false, false, 82), "get", [0 => "_route"], "method", false, false, false, 82), [0 => "helpdesk_member_ticket"])) {
            // line 83
            echo "    ";
            echo twig_include($this->env, $context, "@UVDeskCoreFramework\\Templates\\attachment.html.twig");
            echo "
";
        }
        // line 85
        echo "
<script type=\"text/javascript\">
    \$(function () {
        ";
        // line 88
        if ((isset($context["removeMe"]) || array_key_exists("removeMe", $context))) {
            // line 89
            echo "            \$.each(";
            echo json_encode((isset($context["removeMe"]) || array_key_exists("removeMe", $context) ? $context["removeMe"] : (function () { throw new RuntimeError('Variable "removeMe" does not exist.', 89, $this->source); })()));
            echo ", function(key, value){
                \$('label[for=\"' + value + '\"]').parent().hide();
            });
        ";
        }
        // line 93
        echo "
        \$('.uv-header-date').datetimepicker({
            format: 'YYYY-MM-DD',
        });
        \$('.uv-header-time').datetimepicker({
            format: 'LT',
        });
        \$('.uv-header-datetime').datetimepicker({
            format: 'YYYY-MM-DD H:m:s'
        });

        var CreateTicketModel = Backbone.Model.extend({
            idAttribute : \"id\",
            defaults : {
                path : \"\",
            },
            validation: {
                ";
        // line 110
        if ( !(isset($context["isTicketViewPage"]) || array_key_exists("isTicketViewPage", $context) ? $context["isTicketViewPage"] : (function () { throw new RuntimeError('Variable "isTicketViewPage" does not exist.', 110, $this->source); })())) {
            // line 111
            echo "                    'name' : {
                        required : true,
                        msg : 'This field is mandatory'
                    },
                    'from' : 
                    [{
                        required : true,
                        msg : 'This field is mandatory'
                    },{
                        pattern : /^([\\w-\\.]+)@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([\\w-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)\$/,
                        msg : 'Email address is invalid'
                    }],
                ";
        }
        // line 124
        echo "                'type' : {
                    required : true,
                    msg : 'This field is mandatory'
                },
                'subject' : {
                    required : true,
                    msg : 'This field is mandatory'
                },
                'reply' : {
                    required : true,
                    msg : 'This field is mandatory'
                },
            },
            urlRoot : \"";
        // line 137
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_create_ticket");
        echo "\"
        });

        var CreateTicketForm = Backbone.View.extend({
            el : \$(\"#create-ticket-modal #create-ticket-form\"),
            model: new CreateTicketModel(),
            initialize : function() {
                Backbone.Validation.bind(this);
                var jsonContext = JSON.parse('";
        // line 145
        echo (((isset($context["errors"]) || array_key_exists("errors", $context))) ? ((isset($context["errors"]) || array_key_exists("errors", $context) ? $context["errors"] : (function () { throw new RuntimeError('Variable "errors" does not exist.', 145, $this->source); })())) : ("{}"));
        echo "');
                for (var field in jsonContext) {
                    Backbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
                }
            },
            events : {
                'click #create-ticket-btn': \"saveTicket\",
                'blur input.create-ticket:not(input[type=file]), textarea.create-ticket, select.create-ticket, checkbox.create-ticket': 'formChanegd',
                'change input[type=file].create-ticket': 'formChanegd',
            },
            formChanegd: function(e) {
                this.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
                this.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
            },
            saveTicket: function (e) {
                e.preventDefault();
                var currentElement = Backbone.\$(e.currentTarget);
                var data = currentElement.closest('form').serializeObject();
                this.model = new CreateTicketModel();
                this.model.set(data);
                Backbone.Validation.bind(this);

                if(this.model.isValid(true)) {
                    \$('#create-ticket-form').submit();
                    \$('form').find('#create-ticket-btn').attr('disabled', 'disabled');
                }
            }
        });

        new CreateTicketForm();
    });\t
</script>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework/Snippets/createMemberTicket.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  243 => 145,  232 => 137,  217 => 124,  202 => 111,  200 => 110,  181 => 93,  173 => 89,  171 => 88,  166 => 85,  160 => 83,  158 => 82,  143 => 69,  132 => 59,  121 => 49,  113 => 42,  102 => 40,  98 => 39,  90 => 33,  87 => 31,  83 => 29,  81 => 28,  71 => 20,  61 => 11,  59 => 10,  56 => 9,  52 => 7,  45 => 2,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% set isTicketViewPage = ('helpdesk_member_ticket' == app.request.attributes.get('_route')) %}

<div class=\"uv-pop-up-overlay uv-no-error-success-icon\" id=\"create-ticket-modal\">
    <div class=\"uv-pop-up-box uv-pop-up-wide\">
        <span class=\"uv-pop-up-close\"></span>
        <h2>Create Ticket</h2>
        <form action=\"{{ path('helpdesk_member_create_ticket') }}\" method=\"post\" id=\"create-ticket-form\" enctype=\"multipart/form-data\">
            {# Customer Details #}
            {% if not isTicketViewPage %}
                {# Name #}
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">Name</label>
                    <div class=\"uv-field-block\">
                        <input name=\"name\" class=\"uv-field create-ticket\" type=\"text\" value=\"\">
                    </div>
                    <span class=\"uv-field-info\">Customer full name</span>
                </div>

                {# Email #}
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">Email</label>
                    <div class=\"uv-field-block\">
                        <input name=\"from\" class=\"uv-field create-ticket\" type=\"text\" value=\"\">
                    </div>
                    <span class=\"uv-field-info\">Customer email address</span>
                </div>
            {% else %}
                {# Retrieve customer details from the current ticket being visited #}
                <span class=\"uv-field-info\">Ticket will be created with current ticket's customer</span>
            {% endif %}

            {# Ticket Type #}
            <div class=\"uv-element-block\">
                <label class=\"uv-field-label\">Type</label>
                <div class=\"uv-field-block\">
                    <select name=\"type\" class=\"uv-select create-ticket\" id=\"type\">
                        <option value=\"\">Select type</option>

                        {% for type in ticketTypeCollection %}
                            <option value=\"{{ type.id }}\">{{ type.description }}</option>
                        {% endfor %}
                    </select>
                </div>
                
                <span class=\"uv-field-info\">Choose ticket type</span>
            </div>

            {# Ticket Subject #}
            <div class=\"uv-element-block\">
                <label class=\"uv-field-label\">Subject</label>
                <div class=\"uv-field-block\">
                    <input name=\"subject\" class=\"uv-field create-ticket\" type=\"text\" value=\"\">
                </div>

                <span class=\"uv-field-info\">Ticket subject</span>
            </div>

            {# Ticket Message #}
            <div class=\"uv-element-block\">
                <label class=\"uv-field-label\">Message</label>
                <div class=\"uv-field-block\">
                    <textarea name=\"reply\" class=\"uv-field create-ticket\" type=\"text\"></textarea>
                </div>
                
                <span class=\"uv-field-info\">Query message</span>
            </div>

            {# Ticket Attachment #}
            <div class=\"uv-element-block attachment-block uv-no-error-success-icon\" id=\"uv-attachment-option\">
                <label>
                    <span class=\"uv-file-label\">Add Attachment</span>
                </label>
            </div>

            <div class=\"uv-element-block\">
                <button type=\"submit\" id=\"create-ticket-btn\" class=\"uv-btn\">Create Ticket</button>
            </div>
        </form>
    </div>
</div>

{% if not(app.request.attributes.get('_route') in ['helpdesk_member_ticket']) %}
    {{ include('@UVDeskCoreFramework\\\\Templates\\\\attachment.html.twig') }}
{% endif %}

<script type=\"text/javascript\">
    \$(function () {
        {% if(removeMe is defined) %}
            \$.each({{ removeMe | json_encode |raw }}, function(key, value){
                \$('label[for=\"' + value + '\"]').parent().hide();
            });
        {% endif %}

        \$('.uv-header-date').datetimepicker({
            format: 'YYYY-MM-DD',
        });
        \$('.uv-header-time').datetimepicker({
            format: 'LT',
        });
        \$('.uv-header-datetime').datetimepicker({
            format: 'YYYY-MM-DD H:m:s'
        });

        var CreateTicketModel = Backbone.Model.extend({
            idAttribute : \"id\",
            defaults : {
                path : \"\",
            },
            validation: {
                {% if not isTicketViewPage %}
                    'name' : {
                        required : true,
                        msg : 'This field is mandatory'
                    },
                    'from' : 
                    [{
                        required : true,
                        msg : 'This field is mandatory'
                    },{
                        pattern : /^([\\w-\\.]+)@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([\\w-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)\$/,
                        msg : 'Email address is invalid'
                    }],
                {% endif %}
                'type' : {
                    required : true,
                    msg : 'This field is mandatory'
                },
                'subject' : {
                    required : true,
                    msg : 'This field is mandatory'
                },
                'reply' : {
                    required : true,
                    msg : 'This field is mandatory'
                },
            },
            urlRoot : \"{{ path('helpdesk_member_create_ticket') }}\"
        });

        var CreateTicketForm = Backbone.View.extend({
            el : \$(\"#create-ticket-modal #create-ticket-form\"),
            model: new CreateTicketModel(),
            initialize : function() {
                Backbone.Validation.bind(this);
                var jsonContext = JSON.parse('{{ errors is defined ? errors|raw : \"{}\"  }}');
                for (var field in jsonContext) {
                    Backbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
                }
            },
            events : {
                'click #create-ticket-btn': \"saveTicket\",
                'blur input.create-ticket:not(input[type=file]), textarea.create-ticket, select.create-ticket, checkbox.create-ticket': 'formChanegd',
                'change input[type=file].create-ticket': 'formChanegd',
            },
            formChanegd: function(e) {
                this.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
                this.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
            },
            saveTicket: function (e) {
                e.preventDefault();
                var currentElement = Backbone.\$(e.currentTarget);
                var data = currentElement.closest('form').serializeObject();
                this.model = new CreateTicketModel();
                this.model.set(data);
                Backbone.Validation.bind(this);

                if(this.model.isValid(true)) {
                    \$('#create-ticket-form').submit();
                    \$('form').find('#create-ticket-btn').attr('disabled', 'disabled');
                }
            }
        });

        new CreateTicketForm();
    });\t
</script>", "@UVDeskCoreFramework/Snippets/createMemberTicket.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/Snippets/createMemberTicket.html.twig");
    }
}
