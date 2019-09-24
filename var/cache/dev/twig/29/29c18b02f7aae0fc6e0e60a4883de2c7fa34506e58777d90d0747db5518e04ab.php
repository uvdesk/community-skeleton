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

/* @UVDeskAutomation/Workflow/createWorkflow.html.twig */
class __TwigTemplate_8b5dc810414204118300ec7307676bccf9c8487aca01b98d7372add168cb1ec9 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'internalcss' => [$this, 'block_internalcss'],
            'pageContent' => [$this, 'block_pageContent'],
            'footer' => [$this, 'block_footer'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "@UVDeskCoreFramework/Templates/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskAutomation/Workflow/createWorkflow.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskAutomation/Workflow/createWorkflow.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework/Templates/layout.html.twig", "@UVDeskAutomation/Workflow/createWorkflow.html.twig", 1);
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
        echo "    ";
        if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 4, $this->source); })()), "request", [], "any", false, false, false, 4), "get", [0 => "id"], "method", false, false, false, 4)) {
            // line 5
            echo "        ";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit Workflow"), "html", null, true);
            echo "
    ";
        } else {
            // line 7
            echo "        ";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Workflow"), "html", null, true);
            echo "
    ";
        }
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 11
    public function block_internalcss($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "internalcss"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "internalcss"));

        // line 12
        echo "    @media(max-width: 767px) {
        #company-workflow > .steps {
            display: none;
        }
    }

    @media(max-width: 579px) {
        #company-workflow > h3 {
            margin-right: 80px;
        }

        #company-workflow > h3 > a {
            position: absolute;
            top: 0px;
            right: 10px;
        }
    }

    .has-error button.btn {
        border-color: #cc5965;
    }
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 35
    public function block_pageContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        // line 36
        echo "    <style>
        .workflow-conditions-body .workflow-condition:first-child .uv-workflow-hr-plank {
            display: none;
        }
        .grammarly-fix-message-container {
\t\t\toverflow: visible !important;
\t\t}
\t\t.grammarly-fix-message {
\t\t\tmax-width: 120%;
\t\t}
        .textarea-fix-action {
            max-width: 500px !important;
        }
    </style>
    <!-- Inner Section -->
    <div class=\"uv-inner-section\">
        ";
        // line 53
        echo "\t\t";
        $context["asideTemplate"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\AsideTemplate";
        // line 54
        echo "\t\t";
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Productivity";
        // line 55
        echo "
\t\t";
        // line 56
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 56, $this->source); })()), "getRegisteredComponent", [0 => (isset($context["asideTemplate"]) || array_key_exists("asideTemplate", $context) ? $context["asideTemplate"] : (function () { throw new RuntimeError('Variable "asideTemplate" does not exist.', 56, $this->source); })())], "method", false, false, false, 56), "renderSidebar", [0 => (isset($context["asideSidebarReference"]) || array_key_exists("asideSidebarReference", $context) ? $context["asideSidebarReference"] : (function () { throw new RuntimeError('Variable "asideSidebarReference" does not exist.', 56, $this->source); })())], "method", false, false, false, 56);
        echo "
        
        <!-- View -->
        <div class=\"uv-view ";
        // line 59
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 59, $this->source); })()), "request", [], "any", false, false, false, 59), "cookies", [], "any", false, false, false, 59) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 59, $this->source); })()), "request", [], "any", false, false, false, 59), "cookies", [], "any", false, false, false, 59), "get", [0 => "uv-asideView"], "method", false, false, false, 59))) {
            echo "uv-aside-view";
        }
        echo "\">
            <!-- Form -->
            ";
        // line 61
        if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 61, $this->source); })()), "request", [], "any", false, false, false, 61), "get", [0 => "id"], "method", false, false, false, 61))) {
            // line 62
            echo "                <h1>";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit Workflow"), "html", null, true);
            echo "</h1>
                <form class=\"workflow-form\" name=\"form-workflow\" method=\"POST\" action=\"";
            // line 63
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("workflows_editaction", ["id" => twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 63, $this->source); })()), "request", [], "any", false, false, false, 63), "get", [0 => "id"], "method", false, false, false, 63)]), "html", null, true);
            echo "\">
            ";
        } else {
            // line 65
            echo "                <h1>";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("New Workflow"), "html", null, true);
            echo "</h1>
                <form class=\"workflow-form\" name=\"form-workflow\" method=\"POST\" action=\"";
            // line 66
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("workflows_addaction");
            echo "\">
            ";
        }
        // line 68
        echo "                <!-- Workflow Description Section -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">";
        // line 70
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Name"), "html", null, true);
        echo "</label>
                    <div class=\"uv-field-block\">
                        <input name=\"name\" class=\"uv-field\" type=\"text\" value=\"";
        // line 72
        ((twig_get_attribute($this->env, $this->source, ($context["formData"] ?? null), "name", [], "any", true, true, false, 72)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["formData"]) || array_key_exists("formData", $context) ? $context["formData"] : (function () { throw new RuntimeError('Variable "formData" does not exist.', 72, $this->source); })()), "name", [], "any", false, false, false, 72), "html", null, true))) : (print ("")));
        echo "\">
                        <p class=\"uv-field-message\">";
        // line 73
        if (twig_get_attribute($this->env, $this->source, ($context["error"] ?? null), "name", [], "any", true, true, false, 73)) {
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 73, $this->source); })()), "name", [], "any", false, false, false, 73), "html", null, true);
        }
        echo "</p>
                    </div>
                </div>

                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">";
        // line 78
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Description"), "html", null, true);
        echo "</label>
                    <div class=\"uv-field-block grammarly-fix-message-container\">
                        <textarea name=\"description\" class=\"uv-field grammarly-fix-message\">";
        // line 80
        ((twig_get_attribute($this->env, $this->source, ($context["formData"] ?? null), "description", [], "any", true, true, false, 80)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["formData"]) || array_key_exists("formData", $context) ? $context["formData"] : (function () { throw new RuntimeError('Variable "formData" does not exist.', 80, $this->source); })()), "description", [], "any", false, false, false, 80), "html", null, true))) : (print ("")));
        echo "</textarea>
                        <p class=\"uv-field-message\">";
        // line 81
        if (twig_get_attribute($this->env, $this->source, ($context["error"] ?? null), "description", [], "any", true, true, false, 81)) {
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 81, $this->source); })()), "description", [], "any", false, false, false, 81), "html", null, true);
        }
        echo "</p>
                    </div>
                </div>

                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">";
        // line 86
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Workflow Status"), "html", null, true);
        echo "</label>
                    <div class=\"uv-element-block\">
                        <label>
                            <div class=\"uv-checkbox\">
                                <input name=\"status\" type=\"checkbox\" ";
        // line 90
        echo (((twig_get_attribute($this->env, $this->source, ($context["formData"] ?? null), "status", [], "any", true, true, false, 90) && (twig_get_attribute($this->env, $this->source, (isset($context["formData"]) || array_key_exists("formData", $context) ? $context["formData"] : (function () { throw new RuntimeError('Variable "formData" does not exist.', 90, $this->source); })()), "status", [], "any", false, false, false, 90) == "on"))) ? ("checked") : (""));
        echo ">
                                <span class=\"uv-checkbox-view\"></span>
                            </div>
                            <span class=\"uv-checkbox-label\">";
        // line 93
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Workflow is Active"), "html", null, true);
        echo "</span>
                        </label>
                    </div>
                </div>

                <div class=\"uv-hr\"></div>
                <!-- // Workflow Description Section -->


                <!-- Workflow Events Section -->
                <div id=\"events\" class=\"uv-field-workflow\">
                    <label class=\"uv-field-label\">";
        // line 104
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Events"), "html", null, true);
        echo "</label>
                    <span class=\"uv-field-info\">";
        // line 105
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("An event automatically triggers to check conditions and perform a respective pre-defined set of actions"), "html", null, true);
        echo "</span>

                    <div class=\"workflow-event-body\"></div>
                    <div class=\"uv-workflow-buttons\">
                        <a class=\"uv-btn-tag btn-add\" href=\"#\">
                            <span class=\"uv-icon-add-dark\"></span> ";
        // line 110
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add More"), "html", null, true);
        echo "
                        </a>
                    </div>
                </div>

                <div class=\"uv-hr\"></div>
                <!-- // Workflow Events Section -->

                <!-- Workflow Conditions Section -->
                <div id=\"conditions\" class=\"uv-field-workflow\" >
                    <label class=\"uv-field-label\">";
        // line 120
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Conditions"), "html", null, true);
        echo "</label>
                    <span class=\"uv-field-info\">";
        // line 121
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Conditions are set of rules which checks for specific scenarios and are triggered on specific occasions"), "html", null, true);
        echo "</span>

                    <div class=\"workflow-conditions-body\"></div>
                    <div class=\"uv-workflow-buttons\">
                        <a class=\"uv-btn-tag btn-or\" href=\"#\">
                            <span class=\"uv-icon-add-dark\"></span> ";
        // line 126
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("OR"), "html", null, true);
        echo "
                        </a>
                        <a class=\"uv-btn-tag btn-and\" href=\"#\">
                            <span class=\"uv-icon-add-dark\"></span> ";
        // line 129
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("AND"), "html", null, true);
        echo "
                        </a>
                    </div>
                </div>
                <!-- // Workflow Conditions Section -->
                <div class=\"uv-hr\"></div>
                


                <!-- Workflow Actions Section -->
                <div id=\"actions\" class=\"uv-element-block uv-field-workflow\">
                    <label class=\"uv-field-label\">";
        // line 140
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Actions"), "html", null, true);
        echo "</label>
                    <span class=\"uv-field-info\">";
        // line 141
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("An action not only reduces the workload but also makes it quite easier for ticket automation"), "html", null, true);
        echo "</span>

                    <div class=\"workflow-action-body\"></div>
                    <div class=\"uv-workflow-buttons\">
                        <a class=\"uv-btn-tag btn-add\" href=\"#\">
                            <span class=\"uv-icon-add-dark\"></span> ";
        // line 146
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add More"), "html", null, true);
        echo "
                        </a>
                    </div>
                </div>
                <!-- // Workflow Actions Section -->

                <!-- CTA -->
                ";
        // line 154
        echo "                <button type=\"submit\" name=\"submit\" class=\"uv-btn\" href=\"#\">";
        if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 154, $this->source); })()), "request", [], "any", false, false, false, 154), "get", [0 => "id"], "method", false, false, false, 154))) {
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Workflow"), "html", null, true);
        } else {
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Workflow"), "html", null, true);
        }
        echo "</button>
                <!-- // CTA -->
            </form>
            <!-- Form -->
        </div>
        <!-- // View -->
    </div>
    <!-- // Inner Section -->
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 164
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 165
        echo "    ";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "

    <script type=\"text/javascript\">
        _.extend(Backbone.Validation.patterns, {
          stringPattern: /[a-z0-9]/i,
        });

        _.extend(Backbone.Validation.callbacks, {
            valid : function (view, attr, selector) {
                \$('[name=\"'+attr+'\"]').closest('.uv-field-block').find('.uv-field-message').html('').fadeOut(0);
            },
            invalid : function (view, attr, error, selector) {
                \$('[name=\"'+attr+'\"]').closest('.uv-field-block').find('.uv-field-message').html(error).fadeIn(0);
            }
        });

        if(typeof(sB) == 'undefined'){
          var sB = {};
        }

        sB.WorkflowCollection = Backbone.Collection.extend({
            baseUrl: \"";
        // line 186
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("ajax_service_call");
        echo "\",
            fetchResult: function(dataMatch) {
            this.url = this.baseUrl;
            return this.fetch({ 'data' : {
                'service': 'email.service',
                'call': 'getEmailPlaceHolders',
                'options': { 'match': dataMatch },
            }});
        }});
        sB.workflowCollection = new sB.WorkflowCollection();

        sB.WorkflowModel = Backbone.Model.extend({
            validation: {
                name: {
                    required: true,
                    pattern: 'stringPattern',
                    msg: \"";
        // line 202
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please enter a valid name."), "html", null, true);
        echo "\"
                },
            },
            validateSelect: function(value, attr, computedState) {
                var currentSelectValue = \$('select[name=\"'+ attr + '\"]').find(':selected').length;
                if (!value) {
                    return \"";
        // line 208
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please select a value."), "html", null, true);
        echo "\";
                }
            },
            validateSelectMultiple: function(value, attr, computedState) {
                var currentSelectValue = \$('[name=\"'+ attr + '\"]').length;
                if (!value) {
                    return \"";
        // line 214
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please select a value."), "html", null, true);
        echo "\";
                }
            },
            validateSelectText: function(value, attr, computedState) {
                if (!value) {
                    return \"";
        // line 219
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Please add a value."), "html", null, true);
        echo "\";
                }
            }
        });

        sB.WorkflowView = Backbone.View.extend({
            el: '.uv-view',
            initialize: function() {
                this.model = new sB.WorkflowModel();
                Backbone.Validation.bind(this);
            },
            events: {
                'submit form[name=\"form-workflow\"]': 'processWorkflow',
            },
            processWorkflow: function(e) {
                var disabledCollection = this.\$el.find('form').find('[disabled]');
                if (\$(disabledCollection).length > 0) {
                    \$.each(\$(disabledCollection), function(index, nodeElement) {
                        \$(nodeElement).removeAttr('disabled');
                    });
                }

                this.model.set(this.\$el.find('form').serializeObject());

                var self = this;
                filterArray = ['name'];
                // Populate Filter Array - Events and Actions are required fields

                // Event
                this.\$('.wfEvents').each(function(key, value) {
                    filterArray.push(\$(value).attr('name'));
                    self.model.validation[\$(value).attr('name')] = 'validateSelect';
                });
                this.\$('.wfEventTriggers').each(function(key, value) {
                    filterArray.push(\$(value).attr('name'));
                    self.model.validation[\$(value).attr('name')] = 'validateSelect';
                });

                // Conditions
                if (\$(\"[name='events[0][event]']\").val() == 'ticket' || \$(\"[name='events[0][event]']\").val() == 'task') {
                    this.\$('.wfCondition').each(function(key, value) {
                        filterArray.push(\$(value).attr('name'));
                        self.model.validation[\$(value).attr('name')] = 'validateSelect';
                    });
                    this.\$('.wfConditionMatch').each(function(key, value) {
                        filterArray.push(\$(value).attr('name'));
                        self.model.validation[\$(value).attr('name')] = 'validateSelect';
                    });
                    this.\$('.wfConditionValue').each(function(key, value) {
                        if (\$(this).attr('name') == undefined) {
                            return;
                        }
                        filterArray.push(\$(value).attr('name'));
                        self.model.validation[\$(value).attr('name')] = 'validateSelectText';
                    });
                }

                // Actions
                this.\$('.wfAction').each(function(key, value) {
                    filterArray.push(\$(value).attr('name'));
                    self.model.validation[\$(value).attr('name')] = 'validateSelect';
                });
                this.\$('.wfActionMultiple').each(function(key, value) {
                    filterArray.push(\$(value).attr('name'));
                    self.model.validation[\$(value).attr('name')] = 'validateSelectMultiple';
                });
                this.\$('.wfActionValue').each(function(key, value) {
                    if (\$(this).attr('name') == undefined) {
                        return;
                    }

                    filterArray.push(\$(value).attr('name'));
                    self.model.validation[\$(value).attr('name')] = 'validateSelectText';
                });

                if (this.validateData(filterArray)) {
                    return true;
                } else {
                    e.preventDefault();
                    if (\$(disabledCollection).length > 0) {
                        \$.each(\$(disabledCollection), function(index, nodeElement) {
                            \$(nodeElement).attr('disabled', 'disabled');
                        });
                    }
                }
            },
            validateData: function(filterArray) {
                return this.model.isValid(filterArray);
            },
            updateActive: function(e){
                this.\$('div.step-info').each(function() {
                    \$(this).addClass('active');
                    if (\$(this).attr('data-href') == self.\$(e.target).attr('href'))
                        return false;
                });
            }
        });
        sB.workflowView = new sB.WorkflowView();

        \$.fn.serializeObject = function () {
            \"use strict\";
            var a = {}, b = function (b, c) {
                var d = a[c.name];
                \"undefined\" != typeof d && d !== null ? \$.isArray(d) ? d.push(c.value) : a[c.name] = [d, c.value] : a[c.name] = c.value
            };
            return \$.each(this.serializeArray(), b), a
        };
    </script>

    ";
        // line 328
        echo twig_include($this->env, $context, "@UVDeskAutomation//Workflow//events.html.twig");
        echo "
    ";
        // line 329
        echo twig_include($this->env, $context, "@UVDeskAutomation//Workflow//conditions.html.twig");
        echo "
    ";
        // line 330
        echo twig_include($this->env, $context, "@UVDeskAutomation//Workflow//actions.html.twig");
        echo "

";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskAutomation/Workflow/createWorkflow.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  579 => 330,  575 => 329,  571 => 328,  459 => 219,  451 => 214,  442 => 208,  433 => 202,  414 => 186,  389 => 165,  379 => 164,  355 => 154,  345 => 146,  337 => 141,  333 => 140,  319 => 129,  313 => 126,  305 => 121,  301 => 120,  288 => 110,  280 => 105,  276 => 104,  262 => 93,  256 => 90,  249 => 86,  239 => 81,  235 => 80,  230 => 78,  220 => 73,  216 => 72,  211 => 70,  207 => 68,  202 => 66,  197 => 65,  192 => 63,  187 => 62,  185 => 61,  178 => 59,  172 => 56,  169 => 55,  166 => 54,  163 => 53,  145 => 36,  135 => 35,  104 => 12,  94 => 11,  80 => 7,  74 => 5,  71 => 4,  61 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework/Templates/layout.html.twig\" %}

{% block title %}
    {% if app.request.get('id') %}
        {{ 'Edit Workflow' | trans }}
    {% else %}
        {{ 'Add Workflow' | trans }}
    {% endif %}
{% endblock %}

{% block internalcss %}
    @media(max-width: 767px) {
        #company-workflow > .steps {
            display: none;
        }
    }

    @media(max-width: 579px) {
        #company-workflow > h3 {
            margin-right: 80px;
        }

        #company-workflow > h3 > a {
            position: absolute;
            top: 0px;
            right: 10px;
        }
    }

    .has-error button.btn {
        border-color: #cc5965;
    }
{% endblock %}

{% block pageContent %}
    <style>
        .workflow-conditions-body .workflow-condition:first-child .uv-workflow-hr-plank {
            display: none;
        }
        .grammarly-fix-message-container {
\t\t\toverflow: visible !important;
\t\t}
\t\t.grammarly-fix-message {
\t\t\tmax-width: 120%;
\t\t}
        .textarea-fix-action {
            max-width: 500px !important;
        }
    </style>
    <!-- Inner Section -->
    <div class=\"uv-inner-section\">
        {# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Productivity' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}
        
        <!-- View -->
        <div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
            <!-- Form -->
            {% if app.request.get('id') is not empty %}
                <h1>{{ 'Edit Workflow'|trans }}</h1>
                <form class=\"workflow-form\" name=\"form-workflow\" method=\"POST\" action=\"{{ path('workflows_editaction', {'id': app.request.get('id')}) }}\">
            {% else %}
                <h1>{{ 'New Workflow'|trans }}</h1>
                <form class=\"workflow-form\" name=\"form-workflow\" method=\"POST\" action=\"{{ path('workflows_addaction') }}\">
            {% endif %}
                <!-- Workflow Description Section -->
                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">{{ 'Name'|trans }}</label>
                    <div class=\"uv-field-block\">
                        <input name=\"name\" class=\"uv-field\" type=\"text\" value=\"{{ formData.name is defined ? formData.name : '' }}\">
                        <p class=\"uv-field-message\">{% if error.name is defined %}{{ error.name }}{% endif %}</p>
                    </div>
                </div>

                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">{{ 'Description'|trans }}</label>
                    <div class=\"uv-field-block grammarly-fix-message-container\">
                        <textarea name=\"description\" class=\"uv-field grammarly-fix-message\">{{ formData.description is defined ? formData.description : '' }}</textarea>
                        <p class=\"uv-field-message\">{% if error.description is defined %}{{ error.description }}{% endif %}</p>
                    </div>
                </div>

                <div class=\"uv-element-block\">
                    <label class=\"uv-field-label\">{{ 'Workflow Status'|trans }}</label>
                    <div class=\"uv-element-block\">
                        <label>
                            <div class=\"uv-checkbox\">
                                <input name=\"status\" type=\"checkbox\" {{ formData.status is defined and formData.status == 'on' ? 'checked' : '' }}>
                                <span class=\"uv-checkbox-view\"></span>
                            </div>
                            <span class=\"uv-checkbox-label\">{{ 'Workflow is Active'|trans }}</span>
                        </label>
                    </div>
                </div>

                <div class=\"uv-hr\"></div>
                <!-- // Workflow Description Section -->


                <!-- Workflow Events Section -->
                <div id=\"events\" class=\"uv-field-workflow\">
                    <label class=\"uv-field-label\">{{ 'Events'|trans }}</label>
                    <span class=\"uv-field-info\">{{ \"An event automatically triggers to check conditions and perform a respective pre-defined set of actions\"|trans }}</span>

                    <div class=\"workflow-event-body\"></div>
                    <div class=\"uv-workflow-buttons\">
                        <a class=\"uv-btn-tag btn-add\" href=\"#\">
                            <span class=\"uv-icon-add-dark\"></span> {{'Add More'|trans}}
                        </a>
                    </div>
                </div>

                <div class=\"uv-hr\"></div>
                <!-- // Workflow Events Section -->

                <!-- Workflow Conditions Section -->
                <div id=\"conditions\" class=\"uv-field-workflow\" >
                    <label class=\"uv-field-label\">{{ 'Conditions'|trans }}</label>
                    <span class=\"uv-field-info\">{{ 'Conditions are set of rules which checks for specific scenarios and are triggered on specific occasions'|trans }}</span>

                    <div class=\"workflow-conditions-body\"></div>
                    <div class=\"uv-workflow-buttons\">
                        <a class=\"uv-btn-tag btn-or\" href=\"#\">
                            <span class=\"uv-icon-add-dark\"></span> {{ 'OR'|trans }}
                        </a>
                        <a class=\"uv-btn-tag btn-and\" href=\"#\">
                            <span class=\"uv-icon-add-dark\"></span> {{ 'AND'|trans }}
                        </a>
                    </div>
                </div>
                <!-- // Workflow Conditions Section -->
                <div class=\"uv-hr\"></div>
                


                <!-- Workflow Actions Section -->
                <div id=\"actions\" class=\"uv-element-block uv-field-workflow\">
                    <label class=\"uv-field-label\">{{ 'Actions'|trans }}</label>
                    <span class=\"uv-field-info\">{{ 'An action not only reduces the workload but also makes it quite easier for ticket automation'|trans }}</span>

                    <div class=\"workflow-action-body\"></div>
                    <div class=\"uv-workflow-buttons\">
                        <a class=\"uv-btn-tag btn-add\" href=\"#\">
                            <span class=\"uv-icon-add-dark\"></span> {{ 'Add More'|trans }}
                        </a>
                    </div>
                </div>
                <!-- // Workflow Actions Section -->

                <!-- CTA -->
                {# <input type=\"submit\" class=\"uv-btn\" href=\"#\" value=\"Save Workflow\"> #}
                <button type=\"submit\" name=\"submit\" class=\"uv-btn\" href=\"#\">{% if app.request.get('id') is not empty %}{{ 'Save Workflow'|trans }}{% else %}{{ 'Add Workflow'|trans }}{% endif %}</button>
                <!-- // CTA -->
            </form>
            <!-- Form -->
        </div>
        <!-- // View -->
    </div>
    <!-- // Inner Section -->
{% endblock %}

{% block footer %}
    {{ parent() }}

    <script type=\"text/javascript\">
        _.extend(Backbone.Validation.patterns, {
          stringPattern: /[a-z0-9]/i,
        });

        _.extend(Backbone.Validation.callbacks, {
            valid : function (view, attr, selector) {
                \$('[name=\"'+attr+'\"]').closest('.uv-field-block').find('.uv-field-message').html('').fadeOut(0);
            },
            invalid : function (view, attr, error, selector) {
                \$('[name=\"'+attr+'\"]').closest('.uv-field-block').find('.uv-field-message').html(error).fadeIn(0);
            }
        });

        if(typeof(sB) == 'undefined'){
          var sB = {};
        }

        sB.WorkflowCollection = Backbone.Collection.extend({
            baseUrl: \"{{ path('ajax_service_call') }}\",
            fetchResult: function(dataMatch) {
            this.url = this.baseUrl;
            return this.fetch({ 'data' : {
                'service': 'email.service',
                'call': 'getEmailPlaceHolders',
                'options': { 'match': dataMatch },
            }});
        }});
        sB.workflowCollection = new sB.WorkflowCollection();

        sB.WorkflowModel = Backbone.Model.extend({
            validation: {
                name: {
                    required: true,
                    pattern: 'stringPattern',
                    msg: \"{{ 'Please enter a valid name.'|trans }}\"
                },
            },
            validateSelect: function(value, attr, computedState) {
                var currentSelectValue = \$('select[name=\"'+ attr + '\"]').find(':selected').length;
                if (!value) {
                    return \"{{ 'Please select a value.'|trans }}\";
                }
            },
            validateSelectMultiple: function(value, attr, computedState) {
                var currentSelectValue = \$('[name=\"'+ attr + '\"]').length;
                if (!value) {
                    return \"{{ 'Please select a value.'|trans }}\";
                }
            },
            validateSelectText: function(value, attr, computedState) {
                if (!value) {
                    return \"{{ 'Please add a value.'|trans }}\";
                }
            }
        });

        sB.WorkflowView = Backbone.View.extend({
            el: '.uv-view',
            initialize: function() {
                this.model = new sB.WorkflowModel();
                Backbone.Validation.bind(this);
            },
            events: {
                'submit form[name=\"form-workflow\"]': 'processWorkflow',
            },
            processWorkflow: function(e) {
                var disabledCollection = this.\$el.find('form').find('[disabled]');
                if (\$(disabledCollection).length > 0) {
                    \$.each(\$(disabledCollection), function(index, nodeElement) {
                        \$(nodeElement).removeAttr('disabled');
                    });
                }

                this.model.set(this.\$el.find('form').serializeObject());

                var self = this;
                filterArray = ['name'];
                // Populate Filter Array - Events and Actions are required fields

                // Event
                this.\$('.wfEvents').each(function(key, value) {
                    filterArray.push(\$(value).attr('name'));
                    self.model.validation[\$(value).attr('name')] = 'validateSelect';
                });
                this.\$('.wfEventTriggers').each(function(key, value) {
                    filterArray.push(\$(value).attr('name'));
                    self.model.validation[\$(value).attr('name')] = 'validateSelect';
                });

                // Conditions
                if (\$(\"[name='events[0][event]']\").val() == 'ticket' || \$(\"[name='events[0][event]']\").val() == 'task') {
                    this.\$('.wfCondition').each(function(key, value) {
                        filterArray.push(\$(value).attr('name'));
                        self.model.validation[\$(value).attr('name')] = 'validateSelect';
                    });
                    this.\$('.wfConditionMatch').each(function(key, value) {
                        filterArray.push(\$(value).attr('name'));
                        self.model.validation[\$(value).attr('name')] = 'validateSelect';
                    });
                    this.\$('.wfConditionValue').each(function(key, value) {
                        if (\$(this).attr('name') == undefined) {
                            return;
                        }
                        filterArray.push(\$(value).attr('name'));
                        self.model.validation[\$(value).attr('name')] = 'validateSelectText';
                    });
                }

                // Actions
                this.\$('.wfAction').each(function(key, value) {
                    filterArray.push(\$(value).attr('name'));
                    self.model.validation[\$(value).attr('name')] = 'validateSelect';
                });
                this.\$('.wfActionMultiple').each(function(key, value) {
                    filterArray.push(\$(value).attr('name'));
                    self.model.validation[\$(value).attr('name')] = 'validateSelectMultiple';
                });
                this.\$('.wfActionValue').each(function(key, value) {
                    if (\$(this).attr('name') == undefined) {
                        return;
                    }

                    filterArray.push(\$(value).attr('name'));
                    self.model.validation[\$(value).attr('name')] = 'validateSelectText';
                });

                if (this.validateData(filterArray)) {
                    return true;
                } else {
                    e.preventDefault();
                    if (\$(disabledCollection).length > 0) {
                        \$.each(\$(disabledCollection), function(index, nodeElement) {
                            \$(nodeElement).attr('disabled', 'disabled');
                        });
                    }
                }
            },
            validateData: function(filterArray) {
                return this.model.isValid(filterArray);
            },
            updateActive: function(e){
                this.\$('div.step-info').each(function() {
                    \$(this).addClass('active');
                    if (\$(this).attr('data-href') == self.\$(e.target).attr('href'))
                        return false;
                });
            }
        });
        sB.workflowView = new sB.WorkflowView();

        \$.fn.serializeObject = function () {
            \"use strict\";
            var a = {}, b = function (b, c) {
                var d = a[c.name];
                \"undefined\" != typeof d && d !== null ? \$.isArray(d) ? d.push(c.value) : a[c.name] = [d, c.value] : a[c.name] = c.value
            };
            return \$.each(this.serializeArray(), b), a
        };
    </script>

    {{ include('@UVDeskAutomation//Workflow//events.html.twig') }}
    {{ include('@UVDeskAutomation//Workflow//conditions.html.twig') }}
    {{ include('@UVDeskAutomation//Workflow//actions.html.twig') }}

{% endblock %}
", "@UVDeskAutomation/Workflow/createWorkflow.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/automation-bundle/Resources/views/Workflow/createWorkflow.html.twig");
    }
}
