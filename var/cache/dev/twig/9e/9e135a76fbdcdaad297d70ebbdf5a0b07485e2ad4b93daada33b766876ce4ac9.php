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

/* @UVDeskAutomation/Workflow/actions.html.twig */
class __TwigTemplate_d789480c5519b256b17c55279ebeb5103de4f9c9d0d12a7138a5f8c45209ca9d extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskAutomation/Workflow/actions.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskAutomation/Workflow/actions.html.twig"));

        // line 1
        echo "<script type=\"text/template\" id=\"action-add\">
\t<select class=\"uv-select uv-select-grouped select-action wfAction\" name=\"actions[<%- keyNo %>][type]\" style=\"width: 200px;\">
\t\t<option value=\"\">";
        // line 3
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Select an Action"), "html", null, true);
        echo "</option>
\t\t<% for(var key in actions){ %>
\t\t\t<option value=\"<%- key %>\" <%- typeof(type) != 'undefined' && type == key ? 'selected' : ''%>><%- actions[key] %></option>
\t\t<% } %>
\t</select>
\t<span class=\"apply-action\" style=\"display: inline-block; vertical-align: middle;\">
\t\t<a class=\"uv-btn-tag remove-action-tr\" href=\"#\"><span class=\"uv-icon-remove-dark-box\"></a>
\t</span>
\t<p class=\"uv-field-message\" style=\"display: none;\"></p>
</script>

<script type=\"text/template\" id=\"action-value-text\">
\t<textarea name=\"actions[<%- keyNo %>][value]\" id=\"textarea-note\" class=\"uv-field wfActionValue textarea-fix-action\" style=\"width: 200px;\"><%- (typeof(value) != 'undefined' && typeof(value) != 'object') ? value : ''%></textarea>
</script>

<script type=\"text/template\" id=\"action-value-select\">
\t<select name=\"actions[<%- keyNo %>][value]\" class=\"uv-select uv-select-grouped action-value wfAction\" style=\"width: 200px;\"><option>";
        // line 19
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Loading..."), "html", null, true);
        echo "</option></select>
</script>

<script type=\"text/template\" id=\"action-value-multi-select\">
\t<div class=\"uv-dropdown asset-visibility action-value-for wfActionMultiple\" name=\"actions[<%- keyNo %>][value][for][]\">
\t\t<div class=\"uv-dropdown-btn uv-vertical-align uv-margin-right-5\" style=\"width: 200px;\">";
        // line 24
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Select Option"), "html", null, true);
        echo "</div>
\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t<ul></ul>
\t\t\t</div>
\t\t</div>
\t</div>
\t<select name=\"actions[<%- keyNo %>][value][value]\" class=\"uv-select uv-select-grouped action-value wfAction\" style=\"width: 200px;\"><option>";
        // line 31
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Loading..."), "html", null, true);
        echo "</option></select>
</script>

<script type=\"text/template\" id=\"action-value-select-multiple\">
\t<select name=\"actions[<%- keyNo %>][value][]\" class=\"uv-select uv-select-grouped action-value wfAction\" multiple=\"true\" style=\"width: 200px;\"><option>";
        // line 35
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Loading..."), "html", null, true);
        echo "</option></select>
</script>

<script type=\"text/template\" id=\"action-value-select-option\">
\t<option value=\"<%= id %>\" <%- (typeof(value) != 'undefined' && (typeof(value) === 'object' && value.indexOf(id.toString()) > -1)) ? 'selected' : (typeof(value) != 'undefined' && value == id ? 'selected' : '')%>><%= name %></option>
</script>

<script type=\"text/template\" id=\"action-value-select-for-option\">
\t<li class=\"uv-dropdown-checkbox\">
        <label>
            <div class=\"uv-checkbox\">
                <input type=\"checkbox\" id=\"actions[<%- keyNo %>][value][for][<%- id.toString() %>]\" name=\"actions[<%- keyNo %>][value][for][]\" value=\"<%= id %>\" <%- (typeof(value) != 'undefined' && (typeof(value) === 'object' && value.indexOf(id.toString()) > -1)) ? 'checked' : (typeof(value) != 'undefined' && value == id ? 'checked' : '')%> >
                <span class=\"uv-checkbox-view uv-checkbox-dwn\"></span>
            </div>
        </label>
        <label for=\"actions[<%- keyNo %>][value][for][<%- id.toString() %>]\" style=\"display: inline;\"><%= name %></label>
    </li>
</script>

<script type=\"text/javascript\">
\t\$('body').on('focusout', '#textarea-note', function(){
\t\tselection = this;
\t\toldContent = selection.value;
\t\tcursorPosition = \$(this).prop(\"selectionStart\");
\t\tforEditor = false;
\t\tforSubject = true;
\t});

\tvar sB = sB || {};

\tsB.actionRow = 0;
\tsB.JsonActions = JSON.parse(\"";
        // line 66
        echo twig_escape_filter($this->env, twig_escape_filter($this->env, json_encode(twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_automations"]) || array_key_exists("uvdesk_automations", $context) ? $context["uvdesk_automations"] : (function () { throw new RuntimeError('Variable "uvdesk_automations" does not exist.', 66, $this->source); })()), "getWorkflowActions", [0 => ((((isset($context["forcedActions"]) || array_key_exists("forcedActions", $context)) && (isset($context["forcedActions"]) || array_key_exists("forcedActions", $context) ? $context["forcedActions"] : (function () { throw new RuntimeError('Variable "forcedActions" does not exist.', 66, $this->source); })()))) ? (true) : (false))], "method", false, false, false, 66)), "js"), "html", null, true);
        echo "\");

\tsB.ActionCollection = Backbone.Collection.extend({
\t    baseUrl: \"";
        // line 69
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_workflow_action_options_xhr");
        echo "\",
\t\tfetchResult: function(dataMatch, currentEvent) {
\t\t\tthis.url = this.baseUrl+'/'+dataMatch + (currentEvent ? ('/' + currentEvent) : '');
\t\t\tthis.reset();
\t\t\treturn this.fetch();
\t\t},
\t});

\tsB.ActionSelectView = Backbone.View.extend({
\t\ttagName: 'div',
\t\tclassName: 'uv-field-block workflow-action',
\t\tactionTemplate: _.template(\$('#action-add').html()),
\t\tvalueTextTemplate: _.template(\$('#action-value-text').html()),
\t\tvalueSelectTemplate: _.template(\$('#action-value-select').html()),
\t\tvalueMultiSelectTemplate: _.template(\$('#action-value-multi-select').html()),
\t\tvalueSelectMultipleTemplate: _.template(\$('#action-value-select-multiple').html()),
\t\tvalueSelectOptionTemplate: _.template(\$('#action-value-select-option').html()),
\t\tvalueSelectForOptionTemplate: _.template(\$('#action-value-select-for-option').html()),
\t\tevents: {
\t\t\t'change .select-action': 'selectOption',
\t\t\t'click .remove-action-tr': 'removeTr'
\t\t},
\t\tinitialize: function() {
\t\t\tthis.keyNo = sB.actionRow;
\t\t\tsB.actionRow++;\t
\t\t},
\t\trender: function() {
\t\t\tthis.\$el.html(this.actionTemplate(_.extend(this.model, {'keyNo': this.keyNo, 'actions' : sB.JsonActions[(typeof(sB.PrevEvent) != 'undefined' && sB.PrevEvent) ? sB.PrevEvent : 'ticket']})));
\t\t\treturn this;
\t\t},
\t\tremoveTr: function(e) {
\t \t\tif (\$('.uv-field-block.workflow-action').length > 1) {
\t\t\t\tthis.remove();
\t\t \t\tsB.actionselectView.clearFirstTrSpan();
\t\t\t} else {
\t\t\t\t\$(this.el).find('.uv-field-message').html(\"";
        // line 104
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is required"), "html", null, true);
        echo "\").fadeIn(0);
\t\t\t}
\t\t},
\t\tselectOption: function(e) {
\t\t\tif (this.disable) {
\t\t\t\treturn;
\t\t\t}

\t\t\tvar value = this.value = e.target.value;
\t\t\tif (typeof(sB.actionselectView) != 'undefined') {
\t\t\t\tsB.actionselectView.removeduplicate(e);
\t\t\t}

\t\t\tthis.selectOpt = this.\$el.find('.wfAction');
\t\t\tthis.siblingValue = this.\$el.find('.apply-action');
\t\t\t// if(value == 'delete_ticket' || value == 'mark_spam')
\t\t\tthis.siblingValue.find('select, textarea, div').remove();

\t\t\tif (value == 'uvdesk.agent.add_note' || value == 'reply') {
\t\t\t\tthis.siblingValue.prepend(this.valueTextTemplate(_.extend(this.model, {'keyNo': this.keyNo})));
\t\t\t} else if (value != 'uvdesk.ticket.delete' && value != 'uvdesk.ticket.mark_spam' && value) {
\t\t\t\tthis.selectOpt.prop('disabled', true);
\t\t\t\tthis.disable = true;
\t\t\t\tif (value == 'cc' || value == 'bcc') {
\t\t\t\t\tthis.siblingValue.prepend(this.valueSelectMultipleTemplate(_.extend(this.model, {'keyNo': this.keyNo})));
\t\t\t\t} else if(this.value == 'uvdesk.ticket.mail_group' || this.value == 'uvdesk.ticket.mail_team' || this.value == \"uvdesk.ticket.mail_agent\") {
\t\t\t\t\tthis.siblingValue.prepend(this.valueMultiSelectTemplate(_.extend(this.model, {'keyNo': this.keyNo})));
\t\t\t\t} else {
\t\t\t\t\tthis.siblingValue.prepend(this.valueSelectTemplate(_.extend(this.model, {'keyNo': this.keyNo})));
\t\t\t\t}

\t\t\t\tvar self = this;
\t\t\t\tsB.actionCollection.fetchResult(value, this.getCurrentEvent())
\t\t\t\t\t.done(function() {
\t\t\t\t\t\t\$(self.el).find('.action-value').find('option').remove();
\t\t\t\t\t\tself.addAll();
\t\t        \t})
\t\t        \t.fail(function(xhr) {
\t\t                if(url = xhr.getResponseHeader('Location'))
\t\t                    window.location = url;
\t\t            });
\t\t\t}
\t\t},
\t\tgetCurrentEvent: function() {
\t\t\treturn (\$('.wfEvents').eq(0).val() ? \$('.wfEvents').eq(0).val() : 'ticket');
\t\t},
\t\taddAll: function() {
\t\t\tif(this.value == 'uvdesk.ticket.mail_group' || this.value == 'uvdesk.ticket.mail_team' || this.value == \"uvdesk.ticket.mail_agent\")
\t\t\t\t_.each(sB.actionCollection.models, this.addOneMore, this);
\t\t\telse
\t\t\t\t_.each(sB.actionCollection.models, this.addOne, this);
\t\t\tthis.disable = false;
\t\t\tthis.selectOpt.prop('disabled', false);
\t\t},
\t\taddOne: function(newModel) {
\t\t\tif(typeof(this.model.value) == 'object')
\t\t\t\tthis.model.value = undefined;
\t\t\tvar sendThisModel = _.extend(this.model, newModel.attributes);
\t\t\tif(typeof(newModel.attributes.id) != 'undefined')
\t\t\t\tthis.siblingValue.find('.action-value').append(this.valueSelectOptionTemplate(sendThisModel));
\t\t},
\t\taddOneMore: function(models) {
\t\t\t_.each(models.attributes.partResults, function(newModel){
\t\t\t\tthis.siblingValue.find('.action-value-for').find('.uv-dropdown-container ul').append(this.valueSelectForOptionTemplate(_.extend({ 'value' : (typeof(this.model.value) != 'undefined' ? this.model.value.for : ''), 'keyNo': this.keyNo}, newModel)));
\t\t\t}, this);
\t\t\t_.each(models.attributes.templates, function(newModel){
\t\t\t\tthis.siblingValue.find('.action-value').append(this.valueSelectOptionTemplate(_.extend({ 'value' : (typeof(this.model.value) != 'undefined' ? this.model.value.value : '')}, newModel)));
\t\t\t}, this);
\t\t}
\t});

\tsB.ActionSelectViews = Backbone.View.extend({
\t\tel: '.uv-view',
\t\ttarget: \$('#actions .workflow-action-body'),
\t\tinitialize: function() {
\t\t\t";
        // line 179
        if (((isset($context["formData"]) || array_key_exists("formData", $context) ? $context["formData"] : (function () { throw new RuntimeError('Variable "formData" does not exist.', 179, $this->source); })()) && twig_get_attribute($this->env, $this->source, (isset($context["formData"]) || array_key_exists("formData", $context) ? $context["formData"] : (function () { throw new RuntimeError('Variable "formData" does not exist.', 179, $this->source); })()), "actions", [], "any", false, false, false, 179))) {
            // line 180
            echo "\t\t\t\tthis.createActions(\$.parseJSON(\"";
            echo twig_escape_filter($this->env, twig_escape_filter($this->env, json_encode(twig_get_attribute($this->env, $this->source, (isset($context["formData"]) || array_key_exists("formData", $context) ? $context["formData"] : (function () { throw new RuntimeError('Variable "formData" does not exist.', 180, $this->source); })()), "actions", [], "any", false, false, false, 180)), "js"), "html", null, true);
            echo "\"));
\t\t\t";
        } else {
            // line 182
            echo "\t\t\t\tthis.addSelect({});
\t\t\t";
        }
        // line 184
        echo "\t        this.listenTo(sB.actionCollection, 'add', this.addOne);
\t\t\t";
        // line 185
        if (((isset($context["forcedActions"]) || array_key_exists("forcedActions", $context)) && (isset($context["forcedActions"]) || array_key_exists("forcedActions", $context) ? $context["forcedActions"] : (function () { throw new RuntimeError('Variable "forcedActions" does not exist.', 185, $this->source); })()))) {
            // line 186
            echo "\t\t\t\tdIteration = 0;
\t\t\t\tdisableFieldFun = function() {
\t\t\t\t\tsetTimeout(function(e) {
\t\t\t\t\t\t\$('#actions input,#actions select,#actions textarea').attr('disabled', 'disabled');
\t\t\t\t\t\t\$('#actions .remove-action-tr').remove(); dIteration++;
\t\t\t\t\t\tif(dIteration<5)
\t\t\t\t\t\t\tdisableFieldFun();
\t\t\t\t\t}, 500);
\t\t\t\t};
\t\t\t\t
\t\t\t\tdisableFieldFun();
\t\t\t";
        }
        // line 198
        echo "\t\t},
\t\tevents: {
\t\t\t'click #actions .btn-add': 'addSelect',
\t\t},
\t\tclearHtml: function() {
\t        this.target.html('');
\t\t\tthis.addSelect({});
\t\t},
\t\tcreateActions: function(actionPreviouslyAdded) {
\t\t\t_.each(actionPreviouslyAdded, this.addSelect, this);
\t\t},
\t\taddSelect: function(newModel) {
\t\t\tvar view = new sB.ActionSelectView({model: newModel});
\t        this.target.append(viewEl = view.render().el);
\t        this.\$(viewEl).find('.wfAction').trigger('change');
\t \t\tthis.clearFirstTrSpan();
\t\t},
\t\tremoveduplicate: function(e) {
\t\t\t//remove already exits elements - select
\t\t    \$('.select-action').each(function() {
\t\t\t\tif(this.value == e.target.value)
\t\t\t\t\t\$(this).not(e.target).parents('tr').remove();
\t\t    });
\t \t\tthis.clearFirstTrSpan();
\t\t},
\t\tclearFirstTrSpan: function() {
\t \t\tthis.target.find('tr').eq(0).find('span.border-override').remove();
\t\t},
\t});

\tsB.actionCollection = new sB.ActionCollection();
\tsB.actionselectView = new sB.ActionSelectViews();
</script>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskAutomation/Workflow/actions.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  278 => 198,  264 => 186,  262 => 185,  259 => 184,  255 => 182,  249 => 180,  247 => 179,  169 => 104,  131 => 69,  125 => 66,  91 => 35,  84 => 31,  74 => 24,  66 => 19,  47 => 3,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<script type=\"text/template\" id=\"action-add\">
\t<select class=\"uv-select uv-select-grouped select-action wfAction\" name=\"actions[<%- keyNo %>][type]\" style=\"width: 200px;\">
\t\t<option value=\"\">{{ 'Select an Action'|trans }}</option>
\t\t<% for(var key in actions){ %>
\t\t\t<option value=\"<%- key %>\" <%- typeof(type) != 'undefined' && type == key ? 'selected' : ''%>><%- actions[key] %></option>
\t\t<% } %>
\t</select>
\t<span class=\"apply-action\" style=\"display: inline-block; vertical-align: middle;\">
\t\t<a class=\"uv-btn-tag remove-action-tr\" href=\"#\"><span class=\"uv-icon-remove-dark-box\"></a>
\t</span>
\t<p class=\"uv-field-message\" style=\"display: none;\"></p>
</script>

<script type=\"text/template\" id=\"action-value-text\">
\t<textarea name=\"actions[<%- keyNo %>][value]\" id=\"textarea-note\" class=\"uv-field wfActionValue textarea-fix-action\" style=\"width: 200px;\"><%- (typeof(value) != 'undefined' && typeof(value) != 'object') ? value : ''%></textarea>
</script>

<script type=\"text/template\" id=\"action-value-select\">
\t<select name=\"actions[<%- keyNo %>][value]\" class=\"uv-select uv-select-grouped action-value wfAction\" style=\"width: 200px;\"><option>{{ 'Loading...'|trans }}</option></select>
</script>

<script type=\"text/template\" id=\"action-value-multi-select\">
\t<div class=\"uv-dropdown asset-visibility action-value-for wfActionMultiple\" name=\"actions[<%- keyNo %>][value][for][]\">
\t\t<div class=\"uv-dropdown-btn uv-vertical-align uv-margin-right-5\" style=\"width: 200px;\">{{ 'Select Option'|trans }}</div>
\t\t<div class=\"uv-dropdown-list uv-bottom-left\">
\t\t\t<div class=\"uv-dropdown-container\">
\t\t\t\t<ul></ul>
\t\t\t</div>
\t\t</div>
\t</div>
\t<select name=\"actions[<%- keyNo %>][value][value]\" class=\"uv-select uv-select-grouped action-value wfAction\" style=\"width: 200px;\"><option>{{ 'Loading...'|trans }}</option></select>
</script>

<script type=\"text/template\" id=\"action-value-select-multiple\">
\t<select name=\"actions[<%- keyNo %>][value][]\" class=\"uv-select uv-select-grouped action-value wfAction\" multiple=\"true\" style=\"width: 200px;\"><option>{{ 'Loading...'|trans }}</option></select>
</script>

<script type=\"text/template\" id=\"action-value-select-option\">
\t<option value=\"<%= id %>\" <%- (typeof(value) != 'undefined' && (typeof(value) === 'object' && value.indexOf(id.toString()) > -1)) ? 'selected' : (typeof(value) != 'undefined' && value == id ? 'selected' : '')%>><%= name %></option>
</script>

<script type=\"text/template\" id=\"action-value-select-for-option\">
\t<li class=\"uv-dropdown-checkbox\">
        <label>
            <div class=\"uv-checkbox\">
                <input type=\"checkbox\" id=\"actions[<%- keyNo %>][value][for][<%- id.toString() %>]\" name=\"actions[<%- keyNo %>][value][for][]\" value=\"<%= id %>\" <%- (typeof(value) != 'undefined' && (typeof(value) === 'object' && value.indexOf(id.toString()) > -1)) ? 'checked' : (typeof(value) != 'undefined' && value == id ? 'checked' : '')%> >
                <span class=\"uv-checkbox-view uv-checkbox-dwn\"></span>
            </div>
        </label>
        <label for=\"actions[<%- keyNo %>][value][for][<%- id.toString() %>]\" style=\"display: inline;\"><%= name %></label>
    </li>
</script>

<script type=\"text/javascript\">
\t\$('body').on('focusout', '#textarea-note', function(){
\t\tselection = this;
\t\toldContent = selection.value;
\t\tcursorPosition = \$(this).prop(\"selectionStart\");
\t\tforEditor = false;
\t\tforSubject = true;
\t});

\tvar sB = sB || {};

\tsB.actionRow = 0;
\tsB.JsonActions = JSON.parse(\"{{ uvdesk_automations.getWorkflowActions(forcedActions is defined and forcedActions ? true : false) | json_encode | e('js') }}\");

\tsB.ActionCollection = Backbone.Collection.extend({
\t    baseUrl: \"{{ path('helpdesk_member_workflow_action_options_xhr') }}\",
\t\tfetchResult: function(dataMatch, currentEvent) {
\t\t\tthis.url = this.baseUrl+'/'+dataMatch + (currentEvent ? ('/' + currentEvent) : '');
\t\t\tthis.reset();
\t\t\treturn this.fetch();
\t\t},
\t});

\tsB.ActionSelectView = Backbone.View.extend({
\t\ttagName: 'div',
\t\tclassName: 'uv-field-block workflow-action',
\t\tactionTemplate: _.template(\$('#action-add').html()),
\t\tvalueTextTemplate: _.template(\$('#action-value-text').html()),
\t\tvalueSelectTemplate: _.template(\$('#action-value-select').html()),
\t\tvalueMultiSelectTemplate: _.template(\$('#action-value-multi-select').html()),
\t\tvalueSelectMultipleTemplate: _.template(\$('#action-value-select-multiple').html()),
\t\tvalueSelectOptionTemplate: _.template(\$('#action-value-select-option').html()),
\t\tvalueSelectForOptionTemplate: _.template(\$('#action-value-select-for-option').html()),
\t\tevents: {
\t\t\t'change .select-action': 'selectOption',
\t\t\t'click .remove-action-tr': 'removeTr'
\t\t},
\t\tinitialize: function() {
\t\t\tthis.keyNo = sB.actionRow;
\t\t\tsB.actionRow++;\t
\t\t},
\t\trender: function() {
\t\t\tthis.\$el.html(this.actionTemplate(_.extend(this.model, {'keyNo': this.keyNo, 'actions' : sB.JsonActions[(typeof(sB.PrevEvent) != 'undefined' && sB.PrevEvent) ? sB.PrevEvent : 'ticket']})));
\t\t\treturn this;
\t\t},
\t\tremoveTr: function(e) {
\t \t\tif (\$('.uv-field-block.workflow-action').length > 1) {
\t\t\t\tthis.remove();
\t\t \t\tsB.actionselectView.clearFirstTrSpan();
\t\t\t} else {
\t\t\t\t\$(this.el).find('.uv-field-message').html(\"{{ 'This field is required'|trans }}\").fadeIn(0);
\t\t\t}
\t\t},
\t\tselectOption: function(e) {
\t\t\tif (this.disable) {
\t\t\t\treturn;
\t\t\t}

\t\t\tvar value = this.value = e.target.value;
\t\t\tif (typeof(sB.actionselectView) != 'undefined') {
\t\t\t\tsB.actionselectView.removeduplicate(e);
\t\t\t}

\t\t\tthis.selectOpt = this.\$el.find('.wfAction');
\t\t\tthis.siblingValue = this.\$el.find('.apply-action');
\t\t\t// if(value == 'delete_ticket' || value == 'mark_spam')
\t\t\tthis.siblingValue.find('select, textarea, div').remove();

\t\t\tif (value == 'uvdesk.agent.add_note' || value == 'reply') {
\t\t\t\tthis.siblingValue.prepend(this.valueTextTemplate(_.extend(this.model, {'keyNo': this.keyNo})));
\t\t\t} else if (value != 'uvdesk.ticket.delete' && value != 'uvdesk.ticket.mark_spam' && value) {
\t\t\t\tthis.selectOpt.prop('disabled', true);
\t\t\t\tthis.disable = true;
\t\t\t\tif (value == 'cc' || value == 'bcc') {
\t\t\t\t\tthis.siblingValue.prepend(this.valueSelectMultipleTemplate(_.extend(this.model, {'keyNo': this.keyNo})));
\t\t\t\t} else if(this.value == 'uvdesk.ticket.mail_group' || this.value == 'uvdesk.ticket.mail_team' || this.value == \"uvdesk.ticket.mail_agent\") {
\t\t\t\t\tthis.siblingValue.prepend(this.valueMultiSelectTemplate(_.extend(this.model, {'keyNo': this.keyNo})));
\t\t\t\t} else {
\t\t\t\t\tthis.siblingValue.prepend(this.valueSelectTemplate(_.extend(this.model, {'keyNo': this.keyNo})));
\t\t\t\t}

\t\t\t\tvar self = this;
\t\t\t\tsB.actionCollection.fetchResult(value, this.getCurrentEvent())
\t\t\t\t\t.done(function() {
\t\t\t\t\t\t\$(self.el).find('.action-value').find('option').remove();
\t\t\t\t\t\tself.addAll();
\t\t        \t})
\t\t        \t.fail(function(xhr) {
\t\t                if(url = xhr.getResponseHeader('Location'))
\t\t                    window.location = url;
\t\t            });
\t\t\t}
\t\t},
\t\tgetCurrentEvent: function() {
\t\t\treturn (\$('.wfEvents').eq(0).val() ? \$('.wfEvents').eq(0).val() : 'ticket');
\t\t},
\t\taddAll: function() {
\t\t\tif(this.value == 'uvdesk.ticket.mail_group' || this.value == 'uvdesk.ticket.mail_team' || this.value == \"uvdesk.ticket.mail_agent\")
\t\t\t\t_.each(sB.actionCollection.models, this.addOneMore, this);
\t\t\telse
\t\t\t\t_.each(sB.actionCollection.models, this.addOne, this);
\t\t\tthis.disable = false;
\t\t\tthis.selectOpt.prop('disabled', false);
\t\t},
\t\taddOne: function(newModel) {
\t\t\tif(typeof(this.model.value) == 'object')
\t\t\t\tthis.model.value = undefined;
\t\t\tvar sendThisModel = _.extend(this.model, newModel.attributes);
\t\t\tif(typeof(newModel.attributes.id) != 'undefined')
\t\t\t\tthis.siblingValue.find('.action-value').append(this.valueSelectOptionTemplate(sendThisModel));
\t\t},
\t\taddOneMore: function(models) {
\t\t\t_.each(models.attributes.partResults, function(newModel){
\t\t\t\tthis.siblingValue.find('.action-value-for').find('.uv-dropdown-container ul').append(this.valueSelectForOptionTemplate(_.extend({ 'value' : (typeof(this.model.value) != 'undefined' ? this.model.value.for : ''), 'keyNo': this.keyNo}, newModel)));
\t\t\t}, this);
\t\t\t_.each(models.attributes.templates, function(newModel){
\t\t\t\tthis.siblingValue.find('.action-value').append(this.valueSelectOptionTemplate(_.extend({ 'value' : (typeof(this.model.value) != 'undefined' ? this.model.value.value : '')}, newModel)));
\t\t\t}, this);
\t\t}
\t});

\tsB.ActionSelectViews = Backbone.View.extend({
\t\tel: '.uv-view',
\t\ttarget: \$('#actions .workflow-action-body'),
\t\tinitialize: function() {
\t\t\t{% if formData and formData.actions %}
\t\t\t\tthis.createActions(\$.parseJSON(\"{{ formData.actions | json_encode | e('js') }}\"));
\t\t\t{% else %}
\t\t\t\tthis.addSelect({});
\t\t\t{% endif %}
\t        this.listenTo(sB.actionCollection, 'add', this.addOne);
\t\t\t{% if forcedActions is defined and forcedActions %}
\t\t\t\tdIteration = 0;
\t\t\t\tdisableFieldFun = function() {
\t\t\t\t\tsetTimeout(function(e) {
\t\t\t\t\t\t\$('#actions input,#actions select,#actions textarea').attr('disabled', 'disabled');
\t\t\t\t\t\t\$('#actions .remove-action-tr').remove(); dIteration++;
\t\t\t\t\t\tif(dIteration<5)
\t\t\t\t\t\t\tdisableFieldFun();
\t\t\t\t\t}, 500);
\t\t\t\t};
\t\t\t\t
\t\t\t\tdisableFieldFun();
\t\t\t{% endif %}
\t\t},
\t\tevents: {
\t\t\t'click #actions .btn-add': 'addSelect',
\t\t},
\t\tclearHtml: function() {
\t        this.target.html('');
\t\t\tthis.addSelect({});
\t\t},
\t\tcreateActions: function(actionPreviouslyAdded) {
\t\t\t_.each(actionPreviouslyAdded, this.addSelect, this);
\t\t},
\t\taddSelect: function(newModel) {
\t\t\tvar view = new sB.ActionSelectView({model: newModel});
\t        this.target.append(viewEl = view.render().el);
\t        this.\$(viewEl).find('.wfAction').trigger('change');
\t \t\tthis.clearFirstTrSpan();
\t\t},
\t\tremoveduplicate: function(e) {
\t\t\t//remove already exits elements - select
\t\t    \$('.select-action').each(function() {
\t\t\t\tif(this.value == e.target.value)
\t\t\t\t\t\$(this).not(e.target).parents('tr').remove();
\t\t    });
\t \t\tthis.clearFirstTrSpan();
\t\t},
\t\tclearFirstTrSpan: function() {
\t \t\tthis.target.find('tr').eq(0).find('span.border-override').remove();
\t\t},
\t});

\tsB.actionCollection = new sB.ActionCollection();
\tsB.actionselectView = new sB.ActionSelectViews();
</script>
", "@UVDeskAutomation/Workflow/actions.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/automation-bundle/Resources/views/Workflow/actions.html.twig");
    }
}
