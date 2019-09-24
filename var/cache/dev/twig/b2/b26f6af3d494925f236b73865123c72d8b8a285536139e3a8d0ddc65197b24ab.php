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

/* @UVDeskCoreFramework/Email/emailSettings.html.twig */
class __TwigTemplate_9318a9c130010f5459e255370eadac84f0dd7717c38bfbfef05522de418e9dce extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Email/emailSettings.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Email/emailSettings.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskCoreFramework/Email/emailSettings.html.twig", 1);
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

        echo "Email Settings";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 5
    public function block_pageContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        // line 6
        echo "    <div class=\"uv-inner-section\">
        ";
        // line 8
        echo "\t\t";
        $context["asideTemplate"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\AsideTemplate";
        // line 9
        echo "\t\t";
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Settings";
        // line 10
        echo "
\t\t";
        // line 11
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 11, $this->source); })()), "getRegisteredComponent", [0 => (isset($context["asideTemplate"]) || array_key_exists("asideTemplate", $context) ? $context["asideTemplate"] : (function () { throw new RuntimeError('Variable "asideTemplate" does not exist.', 11, $this->source); })())], "method", false, false, false, 11), "renderSidebar", [0 => (isset($context["asideSidebarReference"]) || array_key_exists("asideSidebarReference", $context) ? $context["asideSidebarReference"] : (function () { throw new RuntimeError('Variable "asideSidebarReference" does not exist.', 11, $this->source); })())], "method", false, false, false, 11);
        echo "

        <div class=\"uv-view\">
            <div class=\"uv-action-bar\">
                <div class=\"uv-action-bar-col-lt\">
                    <h1>
                        ";
        // line 17
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email Settings"), "html", null, true);
        echo "
                    </h1>
                </div>
            </div>
            <div id=\"email-settings\">
\t\t\t</div>
\t\t</div>
    </div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 27
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 28
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "

    <script id=\"email-settings-form-tempplate\" type=\"text/template\">
        <form id=\"email-settings-form\">\t\t\t
            <!-- .fade-out-white -->
            <div style=\"width: 500px;max-width: 80%;\">
                <!-- .jelly-out -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">";
        // line 36
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email Id"), "html", null, true);
        echo "</label>
                    <div class=\"uv-field-block\">
                        <input class=\"uv-field\" type=\"text\" name=\"id\" value='<%= (typeof(id) !== \"undefined\") ? id : \"\" %>'>
                    </div>
                </div>
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">";
        // line 42
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Name"), "html", null, true);
        echo "</label>
                    <div class=\"uv-field-block\">
                        <input class=\"uv-field\" type=\"text\" name=\"name\" value='<%= (typeof(name) !== \"undefined\") ? name : \"\" %>'>
                    </div>
                </div>
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">";
        // line 48
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Swiftmailer id (Select from drop down)"), "html", null, true);
        echo "</label>
                    <div class=\"uv-field-block\">
                        <select name=\"mailer_id\" class=\"uv-select\" type=\"text\" value='<%= (typeof(mailer_id) !== \"undefined\") ? mailer_id : \"\" %>'>
                            <% if (typeof(mailer_id) == \"undefined\") { %>
                                <option>Select swiftmailer</option>
                            <% } %>

                            ";
        // line 55
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["swiftmailers"]) || array_key_exists("swiftmailers", $context) ? $context["swiftmailers"] : (function () { throw new RuntimeError('Variable "swiftmailers" does not exist.', 55, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["swiftmailer"]) {
            // line 56
            echo "                                <option <%= typeof(mailer_id) !== 'undefined' && mailer_id == \"";
            echo twig_escape_filter($this->env, $context["swiftmailer"], "html", null, true);
            echo "\" ? selected=\"selected\" : \"\" %>>";
            echo twig_escape_filter($this->env, $context["swiftmailer"], "html", null, true);
            echo "</option>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['swiftmailer'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 58
        echo "                        </select>
                    </div>
                </div>
                <div class=\"uv-pop-up-actions\">
                    <button type=\"submit\" class=\"uv-btn save-email-settings\">";
        // line 62
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Proceed"), "html", null, true);
        echo "</button>
                </div>
            </div>
        </form>
    </script>

    <script type=\"text/javascript\">
        var emailSettingsModel = Backbone.Model.extend({
            defaults: {
                'id': \"";
        // line 71
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["email_settings"]) || array_key_exists("email_settings", $context) ? $context["email_settings"] : (function () { throw new RuntimeError('Variable "email_settings" does not exist.', 71, $this->source); })()), "id", [], "any", false, false, false, 71), "html", null, true);
        echo "\",
                'name': \"";
        // line 72
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["email_settings"]) || array_key_exists("email_settings", $context) ? $context["email_settings"] : (function () { throw new RuntimeError('Variable "email_settings" does not exist.', 72, $this->source); })()), "name", [], "any", false, false, false, 72), "html", null, true);
        echo "\",
                'mailer_id': \"";
        // line 73
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["email_settings"]) || array_key_exists("email_settings", $context) ? $context["email_settings"] : (function () { throw new RuntimeError('Variable "email_settings" does not exist.', 73, $this->source); })()), "mailer_id", [], "any", false, false, false, 73), "html", null, true);
        echo "\",
            },
            validation: {
                'id': [
                    {
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: '";
        // line 79
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please enter a mailer id"), "html", null, true);
        echo "'
\t\t\t\t\t},
                    {
\t\t\t\t\t\tpattern: 'email',
\t\t\t\t\t\tmsg: '";
        // line 83
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please enter a valid e-mail id"), "html", null, true);
        echo "'
\t\t\t\t\t},
                ],
                'name': [
                    {
                        required: true,
\t\t\t\t\t\tmsg: '";
        // line 89
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please enter a mailer id"), "html", null, true);
        echo "'
                    },
                ],
                \"mailer_id\": function (id) {
\t\t\t\t\tif (id == \"Select swiftmailer\")
\t\t\t\t\t\treturn '";
        // line 94
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please select a swiftmailer id"), "html", null, true);
        echo "';
\t\t\t\t},
            }
        });

        var emailSettingsForm = Backbone.View.extend({
            el: '#email-settings',
            model: new emailSettingsModel(),
            email_settings_form_template: _.template(\$('#email-settings-form-tempplate').html()),
\t\t    events : {
\t\t    \t'click .save-email-settings' : 'saveEmailSettings',
\t\t    },
            initialize: function () {
                this.render();
            },
            render: function () {
                this.\$el.html(this.email_settings_form_template(this.model.toJSON()));
            },
            saveEmailSettings: function (event) {
                event.preventDefault();
                Backbone.Validation.bind(this);
                var data = this.\$el.find('#email-settings-form').serializeObject();

                this.model.set(data);
                if (this.model.isValid(true)) {
\t\t\t\t\tapp.appView.showLoader();
                    this.model.save({}, {
                        url: \"";
        // line 121
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_update_emails_settings_xhr");
        echo "\",
                        success: function (model, response, options) {
        \t\t\t\t\tapp.appView.hideLoader();
                            this.model.attributes = response.email_settings;
                            app.appView.renderResponseAlert(response);
                        }.bind(this),
                        error: function (model, response, options) {
        \t\t\t\t\tapp.appView.hideLoader();
                        }
                    });
                }
            }
        });

        new emailSettingsForm();
    </script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework/Email/emailSettings.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  283 => 121,  253 => 94,  245 => 89,  236 => 83,  229 => 79,  220 => 73,  216 => 72,  212 => 71,  200 => 62,  194 => 58,  183 => 56,  179 => 55,  169 => 48,  160 => 42,  151 => 36,  139 => 28,  129 => 27,  110 => 17,  101 => 11,  98 => 10,  95 => 9,  92 => 8,  89 => 6,  79 => 5,  60 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %}Email Settings{% endblock %}

{% block pageContent %}
    <div class=\"uv-inner-section\">
        {# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Settings' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}

        <div class=\"uv-view\">
            <div class=\"uv-action-bar\">
                <div class=\"uv-action-bar-col-lt\">
                    <h1>
                        {{ 'Email Settings'|trans }}
                    </h1>
                </div>
            </div>
            <div id=\"email-settings\">
\t\t\t</div>
\t\t</div>
    </div>
{% endblock %}

{% block footer %}
\t{{ parent() }}

    <script id=\"email-settings-form-tempplate\" type=\"text/template\">
        <form id=\"email-settings-form\">\t\t\t
            <!-- .fade-out-white -->
            <div style=\"width: 500px;max-width: 80%;\">
                <!-- .jelly-out -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">{{ 'Email Id'|trans }}</label>
                    <div class=\"uv-field-block\">
                        <input class=\"uv-field\" type=\"text\" name=\"id\" value='<%= (typeof(id) !== \"undefined\") ? id : \"\" %>'>
                    </div>
                </div>
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">{{ 'Name'|trans }}</label>
                    <div class=\"uv-field-block\">
                        <input class=\"uv-field\" type=\"text\" name=\"name\" value='<%= (typeof(name) !== \"undefined\") ? name : \"\" %>'>
                    </div>
                </div>
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">{{ 'Swiftmailer id (Select from drop down)'|trans }}</label>
                    <div class=\"uv-field-block\">
                        <select name=\"mailer_id\" class=\"uv-select\" type=\"text\" value='<%= (typeof(mailer_id) !== \"undefined\") ? mailer_id : \"\" %>'>
                            <% if (typeof(mailer_id) == \"undefined\") { %>
                                <option>Select swiftmailer</option>
                            <% } %>

                            {% for swiftmailer in swiftmailers %}
                                <option <%= typeof(mailer_id) !== 'undefined' && mailer_id == \"{{swiftmailer}}\" ? selected=\"selected\" : \"\" %>>{{ swiftmailer }}</option>
                            {% endfor %}
                        </select>
                    </div>
                </div>
                <div class=\"uv-pop-up-actions\">
                    <button type=\"submit\" class=\"uv-btn save-email-settings\">{{ 'Proceed'|trans }}</button>
                </div>
            </div>
        </form>
    </script>

    <script type=\"text/javascript\">
        var emailSettingsModel = Backbone.Model.extend({
            defaults: {
                'id': \"{{ email_settings.id }}\",
                'name': \"{{ email_settings.name }}\",
                'mailer_id': \"{{ email_settings.mailer_id }}\",
            },
            validation: {
                'id': [
                    {
\t\t\t\t\t\trequired: true,
\t\t\t\t\t\tmsg: '{{ \"Please enter a mailer id\"|trans }}'
\t\t\t\t\t},
                    {
\t\t\t\t\t\tpattern: 'email',
\t\t\t\t\t\tmsg: '{{ \"Please enter a valid e-mail id\"|trans }}'
\t\t\t\t\t},
                ],
                'name': [
                    {
                        required: true,
\t\t\t\t\t\tmsg: '{{ \"Please enter a mailer id\"|trans }}'
                    },
                ],
                \"mailer_id\": function (id) {
\t\t\t\t\tif (id == \"Select swiftmailer\")
\t\t\t\t\t\treturn '{{ \"Please select a swiftmailer id\"|trans }}';
\t\t\t\t},
            }
        });

        var emailSettingsForm = Backbone.View.extend({
            el: '#email-settings',
            model: new emailSettingsModel(),
            email_settings_form_template: _.template(\$('#email-settings-form-tempplate').html()),
\t\t    events : {
\t\t    \t'click .save-email-settings' : 'saveEmailSettings',
\t\t    },
            initialize: function () {
                this.render();
            },
            render: function () {
                this.\$el.html(this.email_settings_form_template(this.model.toJSON()));
            },
            saveEmailSettings: function (event) {
                event.preventDefault();
                Backbone.Validation.bind(this);
                var data = this.\$el.find('#email-settings-form').serializeObject();

                this.model.set(data);
                if (this.model.isValid(true)) {
\t\t\t\t\tapp.appView.showLoader();
                    this.model.save({}, {
                        url: \"{{ path('helpdesk_member_update_emails_settings_xhr') }}\",
                        success: function (model, response, options) {
        \t\t\t\t\tapp.appView.hideLoader();
                            this.model.attributes = response.email_settings;
                            app.appView.renderResponseAlert(response);
                        }.bind(this),
                        error: function (model, response, options) {
        \t\t\t\t\tapp.appView.hideLoader();
                        }
                    });
                }
            }
        });

        new emailSettingsForm();
    </script>
{% endblock %}
", "@UVDeskCoreFramework/Email/emailSettings.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/Email/emailSettings.html.twig");
    }
}
