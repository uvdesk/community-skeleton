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

/* @UVDeskCoreFramework/Agents/createSupportAgent.html.twig */
class __TwigTemplate_4b33880de88f85ae6f9e484e72e283ca898f6edf026f029ebe47fd69dbcb49a2 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'templateCSS' => [$this, 'block_templateCSS'],
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Agents/createSupportAgent.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Agents/createSupportAgent.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskCoreFramework/Agents/createSupportAgent.html.twig", 1);
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

        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Create Agent"), "html", null, true);
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 5
    public function block_templateCSS($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "templateCSS"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "templateCSS"));

        // line 6
        echo "    <style>
        .uv-element-block .uv-element-block {
            margin: 6px 0;
        }
        
        .uv-tab-error {
            border-bottom: 3px solid #FF5656 !important;
        }
        
        .uv-paper .uv-view .uv-element-block .uv-error-message {
            color: #FF5656;
        }

        .uv-new-tab-link {
            width: 8px;
            height: 20px;
            display: inline-block;
            background-image: url(../../../bundles/uvdeskcoreframework/images/uvdesk-sprite.svg);
            background-position: 44px -158px;
            margin: 5px 0 0 10px;
            float: right;
            vertical-align: top;
        }

        .uv-xtra-info {
            font-weight: bold;
            margin-left: 6px;
            font-style: normal;
            cursor: help;
        }
    </style>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 39
    public function block_pageContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        // line 40
        echo "\t<div class=\"uv-inner-section\">
        ";
        // line 42
        echo "\t\t";
        $context["asideTemplate"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\AsideTemplate";
        // line 43
        echo "\t\t";
        $context["asideSidebarReference"] = "Webkul\\UVDesk\\CoreFrameworkBundle\\UIComponents\\Dashboard\\Panel\\Sidebars\\Users";
        // line 44
        echo "
\t\t";
        // line 45
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 45, $this->source); })()), "getRegisteredComponent", [0 => (isset($context["asideTemplate"]) || array_key_exists("asideTemplate", $context) ? $context["asideTemplate"] : (function () { throw new RuntimeError('Variable "asideTemplate" does not exist.', 45, $this->source); })())], "method", false, false, false, 45), "renderSidebar", [0 => (isset($context["asideSidebarReference"]) || array_key_exists("asideSidebarReference", $context) ? $context["asideSidebarReference"] : (function () { throw new RuntimeError('Variable "asideSidebarReference" does not exist.', 45, $this->source); })())], "method", false, false, false, 45);
        echo "
        
\t\t<div class=\"uv-view ";
        // line 47
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 47, $this->source); })()), "request", [], "any", false, false, false, 47), "cookies", [], "any", false, false, false, 47) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 47, $this->source); })()), "request", [], "any", false, false, false, 47), "cookies", [], "any", false, false, false, 47), "get", [0 => "uv-asideView"], "method", false, false, false, 47))) {
            echo "uv-aside-view";
        }
        echo "\">
            <h1>";
        // line 48
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Create Agent"), "html", null, true);
        echo "</h1>

            ";
        // line 51
        echo "\t\t\t<form method=\"post\" action=\"\" id=\"user-form\" enctype=\"multipart/form-data\">
                ";
        // line 53
        echo "                <div class=\"uv-tabs\">
                    <ul>
                        <li for=\"profile\" class=\"uv-tab-active\">";
        // line 55
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("General"), "html", null, true);
        echo "</li>
                        <li for=\"groups\">";
        // line 56
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Groups"), "html", null, true);
        echo "</li>
                        ";
        // line 57
        if (!twig_in_filter("ROLE_SUPER_ADMIN", twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 57, $this->source); })()), "roles", [], "any", false, false, false, 57))) {
            // line 58
            echo "                            <li for=\"permission\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Permission"), "html", null, true);
            echo "</li>
                        ";
        }
        // line 60
        echo "                    </ul>
                </div>

                ";
        // line 64
        echo "                <div class=\"uv-tab-view uv-tab-view-active\" id=\"profile\">
                    <div class=\"uv-image-upload-wrapper\">
\t\t\t\t\t    <div class=\"uv-image-upload-brick\">
                            <input type=\"file\" name=\"user_form[profileImage]\" id=\"uv-upload-profile\">
                            <div class=\"uv-image-upload-placeholder\">
                                <svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"48px\" height=\"32px\">
                                <path fill-rule=\"evenodd\" d=\"M28.026,26.003 L19.964,26.003 L19.964,17.962 L13.964,17.962 L23.995,8.050 L34.025,17.962 L28.026,17.962 L28.026,26.003 ZM33.557,3.421 C30.806,1.146 27.619,0.008 23.995,0.008 C21.182,0.008 18.588,0.756 16.214,2.252 C13.838,3.749 11.996,5.712 10.683,8.143 C7.683,8.456 5.152,9.749 3.090,12.024 C1.027,14.300 -0.004,16.965 -0.004,20.019 C-0.004,23.324 1.168,26.144 3.512,28.481 C5.855,30.819 8.682,31.988 11.996,31.988 L37.963,31.988 C40.712,31.988 43.072,31.006 45.040,29.042 C47.009,27.079 47.993,24.726 47.993,21.983 C47.993,19.364 47.087,17.106 45.275,15.203 C43.461,13.302 41.275,12.258 38.713,12.071 C38.024,8.580 36.306,5.698 33.557,3.421 Z\"></path>
                                </svg>
                            </div>
                            <img id=\"dynamic-image-upload\">

                        </div>
                        <div class=\"uv-image-info-brick\">
                            <span class=\"uv-field-info\">";
        // line 77
        echo $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Upload a Profile Image (100px x 100px)<br> in PNG or JPG Format");
        echo "</span>
                        </div>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 82
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("First Name"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[firstName]\" class=\"uv-field\" type=\"text\" value=\"\">
                        </div>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 89
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Last Name"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[lastName]\" class=\"uv-field\" type=\"text\" value=\"\">
                        </div>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 96
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[email]\" class=\"uv-field\" type=\"text\" value=\"\">
                        </div>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 103
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Designation"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[designation]\" class=\"uv-field\" type=\"text\" value=\"\">
                        </div>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 110
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Contact Number"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[contactNumber]\" class=\"uv-field\" type=\"text\" value=\"\">
                        </div>
                    </div>
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 116
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Signature"), "html", null, true);
        echo "</label>
                        <div class=\"uv-field-block\">
                            <textarea name=\"user_form[signature]\" class=\"uv-field\"></textarea>
                        </div>
                        <span class=\"uv-field-info\">";
        // line 120
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("User signature will be append in the bottom of ticket reply box"), "html", null, true);
        echo "</span>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 124
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Account Status"), "html", null, true);
        echo "</label>
                        <div class=\"uv-element-block\">
                            <label>
                                <div class=\"uv-checkbox\">
                                    <input type=\"checkbox\" name=\"user_form[isActive]\">
                                    <span class=\"uv-checkbox-view\"></span>
                                </div>
                                <span class=\"uv-checkbox-label\">";
        // line 131
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Account is Active"), "html", null, true);
        echo "</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                ";
        // line 138
        echo "                <div class=\"uv-tab-view\" id=\"groups\">
                    <div class=\"uv-scroll-plank\">
                        <!-- Checkbox Block -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">";
        // line 142
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Groups"), "html", null, true);
        echo "</label>
                            <span class=\"uv-field-info uv-margin-top-5\">";
        // line 143
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Assigning group(s) to user to view tickets regardless assignment."), "html", null, true);
        echo "</span>
                        </div>

                        <div>
                            <!--Block-->
                            <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                ";
        // line 149
        $context["groups"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 149, $this->source); })()), "getSupportGroups", [], "method", false, false, false, 149);
        // line 150
        echo "                                
                                ";
        // line 151
        if ((isset($context["groups"]) || array_key_exists("groups", $context) ? $context["groups"] : (function () { throw new RuntimeError('Variable "groups" does not exist.', 151, $this->source); })())) {
            // line 152
            echo "                                    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["groups"]) || array_key_exists("groups", $context) ? $context["groups"] : (function () { throw new RuntimeError('Variable "groups" does not exist.', 152, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["group"]) {
                // line 153
                echo "                                        <!-- / -->
                                        <div class=\"uv-element-block\">
                                            <label>
                                                <div class=\"uv-checkbox\">
                                                     <input name=\"user_form[groups][]\" type=\"checkbox\" value=\"";
                // line 157
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["group"], "id", [], "any", false, false, false, 157), "html", null, true);
                echo "\">
                                                    <span class=\"uv-checkbox-view\"></span>
                                                </div>
                                                <span class=\"uv-checkbox-label\">";
                // line 160
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["group"], "name", [], "any", false, false, false, 160), "html", null, true);
                echo "</span>
                                            </label>
                                        </div>
                                        <!-- /// -->
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['group'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 165
            echo "                                ";
        } else {
            // line 166
            echo "                                    <div class=\"uv-element-block\">
                                        <a class=\"uv-error-message\" href=\"";
            // line 167
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_support_group_collection");
            echo "\" target=\"_blank\">";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("No Group added, Please add Group(s) first !", [], "messages");
            echo "</a>
                                    </div>
                                ";
        }
        // line 170
        echo "                            </div>
                            <!--//Block-->

                        </div>
                        <div class=\"uv-element-block\">
                            <a href=\"#\" class=\"select\">";
        // line 175
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Select All"), "html", null, true);
        echo "</a>
                            <a href=\"#\" class=\"deselect\">";
        // line 176
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Remove All"), "html", null, true);
        echo "</a>
                        </div>
                    </div>

                    ";
        // line 180
        $context["userSubGroups"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 180, $this->source); })()), "getUserSubGroupIds", [0 => twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 180, $this->source); })()), "id", [], "any", false, false, false, 180)], "method", false, false, false, 180);
        // line 181
        echo "                    <div class=\"uv-scroll-plank\">
                        <!-- Checkbox Block -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">";
        // line 184
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Teams"), "html", null, true);
        echo "</label>
                            <span class=\"uv-field-info uv-margin-top-5\">";
        // line 185
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Assigning team(s) to user to view tickets regardless assignment."), "html", null, true);
        echo "</span>
                        </div>

                        <div>
                            <!--Block-->
                            <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                ";
        // line 191
        $context["teams"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 191, $this->source); })()), "getSupportTeams", [], "method", false, false, false, 191);
        // line 192
        echo "                                ";
        if ((isset($context["teams"]) || array_key_exists("teams", $context) ? $context["teams"] : (function () { throw new RuntimeError('Variable "teams" does not exist.', 192, $this->source); })())) {
            // line 193
            echo "                                    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["teams"]) || array_key_exists("teams", $context) ? $context["teams"] : (function () { throw new RuntimeError('Variable "teams" does not exist.', 193, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["team"]) {
                // line 194
                echo "                                        <!-- / -->
                                        <div class=\"uv-element-block\">
                                            <label>
                                                <div class=\"uv-checkbox\">
                                                    <input name=\"user_form[userSubGroup][]\" type=\"checkbox\" value=\"";
                // line 198
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "id", [], "any", false, false, false, 198), "html", null, true);
                echo "\">
                                                    <span class=\"uv-checkbox-view\"></span>
                                                </div>
                                                <span class=\"uv-checkbox-label\">";
                // line 201
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "name", [], "any", false, false, false, 201), "html", null, true);
                echo "</span>
                                            </label>
                                        </div>
                                        <!-- /// -->
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['team'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 206
            echo "                                ";
        } else {
            // line 207
            echo "                                    <div class=\"uv-element-block\">
                                        <a href=\"";
            // line 208
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_support_team_collection");
            echo "\" target=\"_blank\">";
            echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("No Team added !", [], "messages");
            echo "</a>
                                    </div>
                                ";
        }
        // line 211
        echo "
                            </div>
                            <!--//Block-->

                        </div>
                        <div class=\"uv-element-block\">
                            <a href=\"#\" class=\"select\">";
        // line 217
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Select All"), "html", null, true);
        echo "</a>
                            <a href=\"#\" class=\"deselect\">";
        // line 218
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Remove All"), "html", null, true);
        echo "</a>
                        </div>
                    </div>
                </div>
                <!--//Tab View-->

                <!--Tab View-->
                <div class=\"uv-tab-view\" id=\"permission\">
                    ";
        // line 226
        if (!twig_in_filter("ROLE_SUPER_ADMIN", twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 226, $this->source); })()), "roles", [], "any", false, false, false, 226))) {
            // line 227
            echo "                        <!-- Field -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">";
            // line 229
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Role"), "html", null, true);
            echo "</label>
                            <div class=\"uv-field-block\">
                                <select name=\"user_form[role]\" class=\"uv-select\" id=\"user_form_role\" ";
            // line 231
            if (((isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 231, $this->source); })()) && (twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 231, $this->source); })()), "id", [], "any", false, false, false, 231) == twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 231, $this->source); })()), "user", [], "any", false, false, false, 231), "id", [], "any", false, false, false, 231)))) {
                echo "disabled=\"disabled\"";
            }
            echo ">
                                    <option value=\"ROLE_ADMIN\" ";
            // line 232
            if (twig_in_filter("ROLE_ADMIN", twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 232, $this->source); })()), "roles", [], "any", false, false, false, 232))) {
                echo "selected";
            }
            echo ">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Administrator"), "html", null, true);
            echo "</option>
                                    <option value=\"ROLE_AGENT\" ";
            // line 233
            if (twig_in_filter("ROLE_AGENT", twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 233, $this->source); })()), "roles", [], "any", false, false, false, 233))) {
                echo "selected";
            }
            echo ">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent"), "html", null, true);
            echo "</option>
                                </select>
                            </div>
                            <span class=\"uv-field-info\">";
            // line 236
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Select agent role"), "html", null, true);
            echo "</span>
                        </div>
                        <!-- //Field -->

                        <!-- Role dependent fields -->
                        <div class=\"role-dependent-fields\">
                            <div class=\"uv-scroll-plank\">
                                <!-- Checkbox Block -->
                                <div class=\"uv-element-block\">
                                    <label class=\"uv-field-label\">";
            // line 245
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent Privileges"), "html", null, true);
            echo "</label>
                                    <span class=\"uv-field-info uv-margin-top-5\">";
            // line 246
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent Privilege represents overall permissions in System."), "html", null, true);
            echo "</span>
                                </div>

                                ";
            // line 249
            $context["privileges"] = twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 249, $this->source); })()), "getSupportPrivileges", [], "method", false, false, false, 249);
            // line 250
            echo "                                ";
            if ((isset($context["privileges"]) || array_key_exists("privileges", $context) ? $context["privileges"] : (function () { throw new RuntimeError('Variable "privileges" does not exist.', 250, $this->source); })())) {
                // line 251
                echo "                                    <div>
                                        <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                            ";
                // line 253
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable((isset($context["privileges"]) || array_key_exists("privileges", $context) ? $context["privileges"] : (function () { throw new RuntimeError('Variable "privileges" does not exist.', 253, $this->source); })()));
                foreach ($context['_seq'] as $context["_key"] => $context["privilege"]) {
                    // line 254
                    echo "                                                <div class=\"uv-element-block\">
                                                    <label>
                                                        <div class=\"uv-checkbox\">
                                                            <input name=\"user_form[agentPrivilege][]\" type=\"checkbox\" value=\"";
                    // line 257
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["privilege"], "id", [], "any", false, false, false, 257), "html", null, true);
                    echo "\">
                                                            <span class=\"uv-checkbox-view\"></span>
                                                        </div>
                                                        <span class=\"uv-checkbox-label\">";
                    // line 260
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["privilege"], "name", [], "any", false, false, false, 260), "html", null, true);
                    echo "</span>
                                                    </label>
                                                    <a class=\"uv-new-tab-link\" href=\"";
                    // line 262
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_update_privilege", ["supportPrivilegeId" => twig_get_attribute($this->env, $this->source, $context["privilege"], "id", [], "any", false, false, false, 262)]), "html", null, true);
                    echo "\" target=\"_blank\"></a> 
                                                </div>
                                            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['privilege'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 265
                echo "                                        </div>
                                    </div>

                                    <div class=\"uv-element-block\">
                                        <a href=\"#\" class=\"select\">";
                // line 269
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Select All"), "html", null, true);
                echo "</a>
                                        <a href=\"#\" class=\"deselect\">";
                // line 270
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Remove All"), "html", null, true);
                echo "</a>
                                    </div>
                                ";
            } else {
                // line 273
                echo "                                    <div>
                                        <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                            <div class=\"uv-element-block\">
                                                <input name=\"user_form[agentPrivilege][]\" type=\"hidden\" value=\"\">
                                            </div>
                                        </div>
                                    </div>
                                ";
            }
            // line 281
            echo "\t\t\t\t\t\t\t</div>

                            <div class=\"uv-element-block\">
                                <label class=\"uv-field-label\">";
            // line 284
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Ticket View"), "html", null, true);
            echo "</label>
                                <span class=\"uv-field-info\">";
            // line 285
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("User can view tickets based on selected scope."), "html", null, true);
            echo "
                                    <span class=\"uv-xtra-info\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"";
            // line 286
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("If individual access then user can View assigned Ticket(s) only, If Team access then user can view all Ticket(s) in team(s) he belongs to and so on"), "html", null, true);
            echo "\">[?]</span>
                                </span>
                                <div class=\"uv-element-block\" style=\"margin-top: 10px;\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"1\" type=\"radio\">
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">";
            // line 294
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Global Access"), "html", null, true);
            echo "</span>
                                    </label>
                                </div>
                                <div class=\"uv-element-block\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"2\" type=\"radio\">
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">";
            // line 303
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Group Access"), "html", null, true);
            echo "</span>
                                    </label>
                                </div>
                                <div class=\"uv-element-block\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"3\" type=\"radio\">
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">";
            // line 312
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Team Access"), "html", null, true);
            echo "</span>
                                    </label>
                                </div>
                                <div class=\"uv-element-block\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"4\" type=\"radio\">
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">";
            // line 321
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Individual Access"), "html", null, true);
            echo "</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    ";
        } else {
            // line 327
            echo "                        <input type=\"hidden\" name=\"user_form[role]\" value=\"ROLE_SUPER_ADMIN\">
                    ";
        }
        // line 329
        echo "                </div>

                <!-- CSRF token Field -->
                ";
        // line 333
        echo "
\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"";
        // line 334
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Save Changes"), "html", null, true);
        echo "\" type=\"submit\">
            </form>
\t\t</div>
\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 340
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 341
        echo "\t";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "

\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar UserModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'user_form[firstName]': [{
                        required: true,
                        msg: \"";
        // line 349
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
                    }, {
                        pattern: /^[A-Za-z][A-Za-z]*[\\sA-Za-z]*\$/,
                        msg: \"";
        // line 352
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field must have characters only"), "html", null, true);
        echo "\"
                    },{
                        maxLength:40,
                        msg:\"";
        // line 355
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Maximum character length is 40"), "html", null, true);
        echo "\"
                    }],
                    'user_form[lastName]': [{
                        required: true,
                        msg: \"";
        // line 359
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
                    }, {
                        pattern: /^[A-Za-z][A-Za-z]*[\\sA-Za-z]*\$/,
                        msg: \"";
        // line 362
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field must have characters only"), "html", null, true);
        echo "\"
                    },{
                        maxLength:40,
                        msg:\"";
        // line 365
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Maximum character length is 40"), "html", null, true);
        echo "\"
                    }],
                    'user_form[email]': [{
                        required: true,
                        msg: \"";
        // line 369
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
                    },{
                        pattern:  /^([\\w-\\.]+)@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([\\w-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)\$/,
                        msg: \"";
        // line 372
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This is not a valid email address"), "html", null, true);
        echo "\"
                    }],
                    'user_form[contactNumber]': function(value) {
                        if(value != undefined && value !== '') {
                            if(!value.match('^[0-9]*\$'))
                                return \"";
        // line 377
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\";
                        }
                    },
                    'user_form[password][first]' : function(value) {
                        if(value != undefined && value !== '') {
                            if(value.length < 8)
                                return \"";
        // line 383
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Password must contains 8 Characters"), "html", null, true);
        echo "\";
                        }
                    },
                    'user_form[password][second]': {
                        equalTo: 'user_form[password][first]',
                        msg: \"";
        // line 388
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("The passwords does not match"), "html", null, true);
        echo "\"
                    },
                    'user_form[isActive][]': {
                        fn: function(value) {
                            return false;
                        },
                    },
                    'user_form[groups][]': {
                        required: true,
                        msg: \"";
        // line 397
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
                    },
                    'user_form[agentPrivilege][]' : {
                        fn: function(value) {
                            if (\$(\"#user_form_role\").val() == 'ROLE_AGENT') {
                                if (!value)
                                    return true;
                            }

                            return false;
                        },
                        msg: \"";
        // line 408
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
                    },
                    'user_form[ticketView]': {
                        fn: function(value) {
                            if(\$(\"#user_form_role\").val() == 'ROLE_AGENT') {
                                if(!value)
                                    return true;
                            }

                            return false;
                        },
                        msg: \"";
        // line 419
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
                    },
\t\t\t\t}
\t\t\t});

\t\t\tvar UserForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn' : \"saveUser\",
\t\t\t\t\t'blur input, textarea': 'formChanegd',
                    'change #user_form_role': 'roleChanged',
                    'click a.select': 'selectAll',
\t\t            'click a.deselect': 'deselectAll',
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t\tvar jsonContext = JSON.parse('";
        // line 434
        echo (isset($context["errors"]) || array_key_exists("errors", $context) ? $context["errors"] : (function () { throw new RuntimeError('Variable "errors" does not exist.', 434, $this->source); })());
        echo "');
\t\t    \t\tfor (var field in jsonContext) {
                        if(field == 'first') {
                            Backbone.Validation.callbacks.invalid(this, \"user_form[password][\" + field + \"]\", jsonContext[field], 'input');
                        } else {
\t\t    \t\t\t    Backbone.Validation.callbacks.invalid(this, \"user_form[\" + field + \"]\", jsonContext[field], 'input');
                        }
\t\t\t\t\t}
                    ";
        // line 442
        if ( !twig_get_attribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 442, $this->source); })()), "id", [], "any", false, false, false, 442)) {
            // line 443
            echo "                        /* guess timezone and select that one */
                        var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone == 'Asia/Calcutta' ? 'Asia/Kolkata' : Intl.DateTimeFormat().resolvedOptions().timeZone;
                        if(timezone) {
                            var option = \$('select[name=\"user_form[timezone]\"]').find('option[value=\"'+ timezone +'\"]');
                            if(option.length) {
                                option.prop('selected', true);
                            }
                        }
                    ";
        }
        // line 452
        echo "\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t    \tvar fieldName = Backbone.\$(e.currentTarget).attr('name');
                    \$(\".uv-tabs li.uv-tab-active\").removeClass('uv-tab-error')
                    if(fieldName == 'user_form[password][second]') {
                        if(\$(\"input[name='user_form[password][first]']\").val().length) {
                            this.model.set(fieldName, Backbone.\$(e.currentTarget).val())
                            this.model.isValid([fieldName])
                        } else {
                            if(\$(\"input[name='user_form[password][second]']\").val().length) {
\t\t    \t\t\t        this.model.set(fieldName, Backbone.\$(e.currentTarget).val())
                                this.model.isValid([fieldName])
                            } else {
\t\t    \t\t\t        Backbone.Validation.callbacks.valid(this, fieldName, 'input');
                            }
                        }
                    } else {
                        this.model.set(fieldName, Backbone.\$(e.currentTarget).val())
                        this.model.isValid([fieldName])
                        if(fieldName == 'user_form[password][first]' && !\$(\"input[name='user_form[password][second]']\").val().length) {
\t\t    \t\t\t    Backbone.Validation.callbacks.valid(this, 'user_form[password][second]', 'input');
                        }
                    }
\t\t\t    },
\t\t\t\tsaveUser : function (e) {
\t\t\t\t\te.preventDefault();
                    \$(\".uv-tabs li\").removeClass('uv-tab-error')
                    this.model.unset('user_form[groups][]', { silent: true });
                    this.model.unset('user_form[agentPrivilege][]', { silent: true });
\t\t\t        this.model.set(this.\$el.serializeObject());
\t\t\t        if(this.model.isValid(true)) {
                        if(\$(\"#user_form_role\").val() == 'ROLE_ADMIN') {
                            \$('input[name=\"user_form[agentPrivilege][]\"]').remove();
                            this.model.unset('user_form[agentPrivilege][]', { silent: true });
                        }
\t\t\t\t\t\tthis.\$el.find('.uv-btn').attr('disabled', 'disabled');
\t\t\t            this.\$el.submit();
\t\t\t        } else {
                        console.log('invalid user, ', this.model);

                        \$('.uv-field-message').each(function(e) {
                            \$(\".uv-tabs li[for='\" + \$(this).parents('.uv-tab-view').attr('id') + \"']:not(.uv-tab-active)\").addClass('uv-tab-error')

                            if(\$(\".uv-tabs li[for='\" + \$(this).parents('.uv-tab-view').attr('id') + \"']:not(.uv-tab-active)\").length ) {
                                \$('.uv-view').animate({
                                    scrollTop: 0
                                }, 'slow');
                            }
                        });
                    }
\t\t\t\t},
                roleChanged: function(e) {
                    if(\$(e.target).val() == 'ROLE_AGENT') {
\t\t            \t\$('.role-dependent-fields').show();
\t\t            } else {
\t\t            \t\$('.role-dependent-fields').hide();
\t\t            }
                },
                selectAll: function (e) {
                    e.preventDefault();
                    this.\$(e.currentTarget).parents('.uv-scroll-plank')
                            .find('input')
                            .prop('checked', true)
                },
                deselectAll: function (e) {
                    e.preventDefault();
                    this.\$(e.currentTarget).parents('.uv-scroll-plank')
                            .find('input')
                            .prop('checked', false);
\t\t        },
\t\t\t});

\t\t\tnew UserForm({
\t\t\t\tel: \$(\"#user-form\"),
\t\t\t\tmodel: new UserModel()
\t\t\t});

            \$('#user_form_role').trigger('change');
\t\t});
\t</script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework/Agents/createSupportAgent.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  868 => 452,  857 => 443,  855 => 442,  844 => 434,  826 => 419,  812 => 408,  798 => 397,  786 => 388,  778 => 383,  769 => 377,  761 => 372,  755 => 369,  748 => 365,  742 => 362,  736 => 359,  729 => 355,  723 => 352,  717 => 349,  705 => 341,  695 => 340,  680 => 334,  677 => 333,  672 => 329,  668 => 327,  659 => 321,  647 => 312,  635 => 303,  623 => 294,  612 => 286,  608 => 285,  604 => 284,  599 => 281,  589 => 273,  583 => 270,  579 => 269,  573 => 265,  564 => 262,  559 => 260,  553 => 257,  548 => 254,  544 => 253,  540 => 251,  537 => 250,  535 => 249,  529 => 246,  525 => 245,  513 => 236,  503 => 233,  495 => 232,  489 => 231,  484 => 229,  480 => 227,  478 => 226,  467 => 218,  463 => 217,  455 => 211,  447 => 208,  444 => 207,  441 => 206,  430 => 201,  424 => 198,  418 => 194,  413 => 193,  410 => 192,  408 => 191,  399 => 185,  395 => 184,  390 => 181,  388 => 180,  381 => 176,  377 => 175,  370 => 170,  362 => 167,  359 => 166,  356 => 165,  345 => 160,  339 => 157,  333 => 153,  328 => 152,  326 => 151,  323 => 150,  321 => 149,  312 => 143,  308 => 142,  302 => 138,  293 => 131,  283 => 124,  276 => 120,  269 => 116,  260 => 110,  250 => 103,  240 => 96,  230 => 89,  220 => 82,  212 => 77,  197 => 64,  192 => 60,  186 => 58,  184 => 57,  180 => 56,  176 => 55,  172 => 53,  169 => 51,  164 => 48,  158 => 47,  153 => 45,  150 => 44,  147 => 43,  144 => 42,  141 => 40,  131 => 39,  90 => 6,  80 => 5,  61 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %}{{'Create Agent'|trans}}{% endblock %}

{% block templateCSS %}
    <style>
        .uv-element-block .uv-element-block {
            margin: 6px 0;
        }
        
        .uv-tab-error {
            border-bottom: 3px solid #FF5656 !important;
        }
        
        .uv-paper .uv-view .uv-element-block .uv-error-message {
            color: #FF5656;
        }

        .uv-new-tab-link {
            width: 8px;
            height: 20px;
            display: inline-block;
            background-image: url(../../../bundles/uvdeskcoreframework/images/uvdesk-sprite.svg);
            background-position: 44px -158px;
            margin: 5px 0 0 10px;
            float: right;
            vertical-align: top;
        }

        .uv-xtra-info {
            font-weight: bold;
            margin-left: 6px;
            font-style: normal;
            cursor: help;
        }
    </style>
{% endblock %}

{% block pageContent %}
\t<div class=\"uv-inner-section\">
        {# Append Panel Aside #}
\t\t{% set asideTemplate = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\AsideTemplate' %}
\t\t{% set asideSidebarReference = 'Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\UIComponents\\\\Dashboard\\\\Panel\\\\Sidebars\\\\Users' %}

\t\t{{ uvdesk_extensibles.getRegisteredComponent(asideTemplate).renderSidebar(asideSidebarReference) | raw }}
        
\t\t<div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\">
            <h1>{{\"Create Agent\"|trans}}</h1>

            {# Registeration Form #}
\t\t\t<form method=\"post\" action=\"\" id=\"user-form\" enctype=\"multipart/form-data\">
                {# Registeration Form Tabs #}
                <div class=\"uv-tabs\">
                    <ul>
                        <li for=\"profile\" class=\"uv-tab-active\">{{\"General\"|trans}}</li>
                        <li for=\"groups\">{{\"Groups\"|trans}}</li>
                        {% if \"ROLE_SUPER_ADMIN\" not in user.roles %}
                            <li for=\"permission\">{{\"Permission\"|trans}}</li>
                        {% endif %}
                    </ul>
                </div>

                {# Profile Tab #}
                <div class=\"uv-tab-view uv-tab-view-active\" id=\"profile\">
                    <div class=\"uv-image-upload-wrapper\">
\t\t\t\t\t    <div class=\"uv-image-upload-brick\">
                            <input type=\"file\" name=\"user_form[profileImage]\" id=\"uv-upload-profile\">
                            <div class=\"uv-image-upload-placeholder\">
                                <svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"48px\" height=\"32px\">
                                <path fill-rule=\"evenodd\" d=\"M28.026,26.003 L19.964,26.003 L19.964,17.962 L13.964,17.962 L23.995,8.050 L34.025,17.962 L28.026,17.962 L28.026,26.003 ZM33.557,3.421 C30.806,1.146 27.619,0.008 23.995,0.008 C21.182,0.008 18.588,0.756 16.214,2.252 C13.838,3.749 11.996,5.712 10.683,8.143 C7.683,8.456 5.152,9.749 3.090,12.024 C1.027,14.300 -0.004,16.965 -0.004,20.019 C-0.004,23.324 1.168,26.144 3.512,28.481 C5.855,30.819 8.682,31.988 11.996,31.988 L37.963,31.988 C40.712,31.988 43.072,31.006 45.040,29.042 C47.009,27.079 47.993,24.726 47.993,21.983 C47.993,19.364 47.087,17.106 45.275,15.203 C43.461,13.302 41.275,12.258 38.713,12.071 C38.024,8.580 36.306,5.698 33.557,3.421 Z\"></path>
                                </svg>
                            </div>
                            <img id=\"dynamic-image-upload\">

                        </div>
                        <div class=\"uv-image-info-brick\">
                            <span class=\"uv-field-info\">{{ 'Upload a Profile Image (100px x 100px)<br> in PNG or JPG Format'|trans|raw }}</span>
                        </div>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{\"First Name\"|trans}}</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[firstName]\" class=\"uv-field\" type=\"text\" value=\"\">
                        </div>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{\"Last Name\"|trans}}</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[lastName]\" class=\"uv-field\" type=\"text\" value=\"\">
                        </div>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Email'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[email]\" class=\"uv-field\" type=\"text\" value=\"\">
                        </div>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Designation'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[designation]\" class=\"uv-field\" type=\"text\" value=\"\">
                        </div>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Contact Number'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <input name=\"user_form[contactNumber]\" class=\"uv-field\" type=\"text\" value=\"\">
                        </div>
                    </div>
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Signature'|trans }}</label>
                        <div class=\"uv-field-block\">
                            <textarea name=\"user_form[signature]\" class=\"uv-field\"></textarea>
                        </div>
                        <span class=\"uv-field-info\">{{ 'User signature will be append in the bottom of ticket reply box'|trans }}</span>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{ 'Account Status'|trans }}</label>
                        <div class=\"uv-element-block\">
                            <label>
                                <div class=\"uv-checkbox\">
                                    <input type=\"checkbox\" name=\"user_form[isActive]\">
                                    <span class=\"uv-checkbox-view\"></span>
                                </div>
                                <span class=\"uv-checkbox-label\">{{ 'Account is Active'|trans }}</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                {# Group Tab #}
                <div class=\"uv-tab-view\" id=\"groups\">
                    <div class=\"uv-scroll-plank\">
                        <!-- Checkbox Block -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">{{'Groups'|trans}}</label>
                            <span class=\"uv-field-info uv-margin-top-5\">{{'Assigning group(s) to user to view tickets regardless assignment.'|trans}}</span>
                        </div>

                        <div>
                            <!--Block-->
                            <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                {% set groups = user_service.getSupportGroups() %}
                                
                                {% if groups %}
                                    {% for group in groups %}
                                        <!-- / -->
                                        <div class=\"uv-element-block\">
                                            <label>
                                                <div class=\"uv-checkbox\">
                                                     <input name=\"user_form[groups][]\" type=\"checkbox\" value=\"{{ group.id }}\">
                                                    <span class=\"uv-checkbox-view\"></span>
                                                </div>
                                                <span class=\"uv-checkbox-label\">{{ group.name }}</span>
                                            </label>
                                        </div>
                                        <!-- /// -->
                                    {% endfor %}
                                {% else %}
                                    <div class=\"uv-element-block\">
                                        <a class=\"uv-error-message\" href=\"{{path('helpdesk_member_support_group_collection')}}\" target=\"_blank\">{% trans %}No Group added, Please add Group(s) first !{% endtrans %}</a>
                                    </div>
                                {% endif %}
                            </div>
                            <!--//Block-->

                        </div>
                        <div class=\"uv-element-block\">
                            <a href=\"#\" class=\"select\">{{ 'Select All'|trans }}</a>
                            <a href=\"#\" class=\"deselect\">{{ 'Remove All'|trans }}</a>
                        </div>
                    </div>

                    {% set userSubGroups = user_service.getUserSubGroupIds(user.id) %}
                    <div class=\"uv-scroll-plank\">
                        <!-- Checkbox Block -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">{{ 'Teams'|trans }}</label>
                            <span class=\"uv-field-info uv-margin-top-5\">{{ 'Assigning team(s) to user to view tickets regardless assignment.'|trans }}</span>
                        </div>

                        <div>
                            <!--Block-->
                            <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                {% set teams = user_service.getSupportTeams() %}
                                {% if teams %}
                                    {% for team in teams %}
                                        <!-- / -->
                                        <div class=\"uv-element-block\">
                                            <label>
                                                <div class=\"uv-checkbox\">
                                                    <input name=\"user_form[userSubGroup][]\" type=\"checkbox\" value=\"{{ team.id }}\">
                                                    <span class=\"uv-checkbox-view\"></span>
                                                </div>
                                                <span class=\"uv-checkbox-label\">{{ team.name }}</span>
                                            </label>
                                        </div>
                                        <!-- /// -->
                                    {% endfor %}
                                {% else %}
                                    <div class=\"uv-element-block\">
                                        <a href=\"{{path('helpdesk_member_support_team_collection')}}\" target=\"_blank\">{% trans %}No Team added !{% endtrans %}</a>
                                    </div>
                                {% endif %}

                            </div>
                            <!--//Block-->

                        </div>
                        <div class=\"uv-element-block\">
                            <a href=\"#\" class=\"select\">{{ 'Select All'|trans }}</a>
                            <a href=\"#\" class=\"deselect\">{{ 'Remove All'|trans }}</a>
                        </div>
                    </div>
                </div>
                <!--//Tab View-->

                <!--Tab View-->
                <div class=\"uv-tab-view\" id=\"permission\">
                    {% if \"ROLE_SUPER_ADMIN\" not in user.roles %}
                        <!-- Field -->
                        <div class=\"uv-element-block\">
                            <label class=\"uv-field-label\">{{ 'Role'|trans }}</label>
                            <div class=\"uv-field-block\">
                                <select name=\"user_form[role]\" class=\"uv-select\" id=\"user_form_role\" {% if user and user.id == app.user.id %}disabled=\"disabled\"{% endif %}>
                                    <option value=\"ROLE_ADMIN\" {% if \"ROLE_ADMIN\" in user.roles %}selected{% endif %}>{{ 'Administrator'|trans }}</option>
                                    <option value=\"ROLE_AGENT\" {% if \"ROLE_AGENT\" in user.roles %}selected{% endif %}>{{ 'Agent'|trans }}</option>
                                </select>
                            </div>
                            <span class=\"uv-field-info\">{{ \"Select agent role\"|trans }}</span>
                        </div>
                        <!-- //Field -->

                        <!-- Role dependent fields -->
                        <div class=\"role-dependent-fields\">
                            <div class=\"uv-scroll-plank\">
                                <!-- Checkbox Block -->
                                <div class=\"uv-element-block\">
                                    <label class=\"uv-field-label\">{{ 'Agent Privileges'|trans }}</label>
                                    <span class=\"uv-field-info uv-margin-top-5\">{{ 'Agent Privilege represents overall permissions in System.'|trans }}</span>
                                </div>

                                {% set privileges = user_service.getSupportPrivileges() %}
                                {% if privileges %}
                                    <div>
                                        <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                            {% for privilege in privileges %}
                                                <div class=\"uv-element-block\">
                                                    <label>
                                                        <div class=\"uv-checkbox\">
                                                            <input name=\"user_form[agentPrivilege][]\" type=\"checkbox\" value=\"{{ privilege.id }}\">
                                                            <span class=\"uv-checkbox-view\"></span>
                                                        </div>
                                                        <span class=\"uv-checkbox-label\">{{ privilege.name }}</span>
                                                    </label>
                                                    <a class=\"uv-new-tab-link\" href=\"{{ path('helpdesk_member_update_privilege', {'supportPrivilegeId': privilege.id }) }}\" target=\"_blank\"></a> 
                                                </div>
                                            {% endfor %}
                                        </div>
                                    </div>

                                    <div class=\"uv-element-block\">
                                        <a href=\"#\" class=\"select\">{{ 'Select All'|trans }}</a>
                                        <a href=\"#\" class=\"deselect\">{{ 'Remove All'|trans }}</a>
                                    </div>
                                {% else %}
                                    <div>
                                        <div class=\"uv-scroll-block\" id=\"beauty-scroll\">
                                            <div class=\"uv-element-block\">
                                                <input name=\"user_form[agentPrivilege][]\" type=\"hidden\" value=\"\">
                                            </div>
                                        </div>
                                    </div>
                                {% endif %}
\t\t\t\t\t\t\t</div>

                            <div class=\"uv-element-block\">
                                <label class=\"uv-field-label\">{{ 'Ticket View'|trans }}</label>
                                <span class=\"uv-field-info\">{{ 'User can view tickets based on selected scope.'|trans }}
                                    <span class=\"uv-xtra-info\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"{{ 'If individual access then user can View assigned Ticket(s) only, If Team access then user can view all Ticket(s) in team(s) he belongs to and so on'|trans }}\">[?]</span>
                                </span>
                                <div class=\"uv-element-block\" style=\"margin-top: 10px;\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"1\" type=\"radio\">
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">{{ 'Global Access'|trans }}</span>
                                    </label>
                                </div>
                                <div class=\"uv-element-block\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"2\" type=\"radio\">
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">{{ 'Group Access'|trans }}</span>
                                    </label>
                                </div>
                                <div class=\"uv-element-block\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"3\" type=\"radio\">
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">{{ 'Team Access'|trans }}</span>
                                    </label>
                                </div>
                                <div class=\"uv-element-block\">
                                    <label>
                                        <div class=\"uv-radio\">
                                            <input name=\"user_form[ticketView]\" value=\"4\" type=\"radio\">
                                            <span class=\"uv-radio-view\"></span>
                                        </div>
                                        <span class=\"uv-radio-label\">{{ 'Individual Access'|trans }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    {% else %}
                        <input type=\"hidden\" name=\"user_form[role]\" value=\"ROLE_SUPER_ADMIN\">
                    {% endif %}
                </div>

                <!-- CSRF token Field -->
                {# <input type=\"hidden\" name=\"user_form[_token]\" value=\"{{ default_service.generateCsrfToken('user_form') }}\"/> #}

\t\t\t\t<input class=\"uv-btn\" href=\"#\" value=\"{{ 'Save Changes'|trans }}\" type=\"submit\">
            </form>
\t\t</div>
\t</div>
{% endblock %}

{% block footer %}
\t{{ parent() }}

\t<script type=\"text/javascript\">
\t\t\$(function () {
\t\t\tvar UserModel = Backbone.Model.extend({
\t\t\t\tvalidation: {
\t\t\t\t\t'user_form[firstName]': [{
                        required: true,
                        msg: \"{{'This field is mandatory'|trans}}\"
                    }, {
                        pattern: /^[A-Za-z][A-Za-z]*[\\sA-Za-z]*\$/,
                        msg: \"{{'This field must have characters only'|trans}}\"
                    },{
                        maxLength:40,
                        msg:\"{{'Maximum character length is 40'|trans}}\"
                    }],
                    'user_form[lastName]': [{
                        required: true,
                        msg: \"{{'This field is mandatory'|trans}}\"
                    }, {
                        pattern: /^[A-Za-z][A-Za-z]*[\\sA-Za-z]*\$/,
                        msg: \"{{'This field must have characters only'|trans}}\"
                    },{
                        maxLength:40,
                        msg:\"{{'Maximum character length is 40'|trans}}\"
                    }],
                    'user_form[email]': [{
                        required: true,
                        msg: \"{{'This field is mandatory'|trans}}\"
                    },{
                        pattern:  /^([\\w-\\.]+)@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([\\w-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)\$/,
                        msg: \"{{'This is not a valid email address'|trans}}\"
                    }],
                    'user_form[contactNumber]': function(value) {
                        if(value != undefined && value !== '') {
                            if(!value.match('^[0-9]*\$'))
                                return \"{{'This field is mandatory'|trans}}\";
                        }
                    },
                    'user_form[password][first]' : function(value) {
                        if(value != undefined && value !== '') {
                            if(value.length < 8)
                                return \"{{'Password must contains 8 Characters'|trans}}\";
                        }
                    },
                    'user_form[password][second]': {
                        equalTo: 'user_form[password][first]',
                        msg: \"{{'The passwords does not match'|trans}}\"
                    },
                    'user_form[isActive][]': {
                        fn: function(value) {
                            return false;
                        },
                    },
                    'user_form[groups][]': {
                        required: true,
                        msg: \"{{'This field is mandatory'|trans}}\"
                    },
                    'user_form[agentPrivilege][]' : {
                        fn: function(value) {
                            if (\$(\"#user_form_role\").val() == 'ROLE_AGENT') {
                                if (!value)
                                    return true;
                            }

                            return false;
                        },
                        msg: \"{{'This field is mandatory'|trans}}\"
                    },
                    'user_form[ticketView]': {
                        fn: function(value) {
                            if(\$(\"#user_form_role\").val() == 'ROLE_AGENT') {
                                if(!value)
                                    return true;
                            }

                            return false;
                        },
                        msg: \"{{'This field is mandatory'|trans}}\"
                    },
\t\t\t\t}
\t\t\t});

\t\t\tvar UserForm = Backbone.View.extend({
\t\t\t\tevents : {
\t\t\t\t\t'click .uv-btn' : \"saveUser\",
\t\t\t\t\t'blur input, textarea': 'formChanegd',
                    'change #user_form_role': 'roleChanged',
                    'click a.select': 'selectAll',
\t\t            'click a.deselect': 'deselectAll',
\t\t\t\t},
\t\t\t\tinitialize : function() {
\t\t\t\t\tBackbone.Validation.bind(this);
\t\t\t\t\tvar jsonContext = JSON.parse('{{ errors|raw }}');
\t\t    \t\tfor (var field in jsonContext) {
                        if(field == 'first') {
                            Backbone.Validation.callbacks.invalid(this, \"user_form[password][\" + field + \"]\", jsonContext[field], 'input');
                        } else {
\t\t    \t\t\t    Backbone.Validation.callbacks.invalid(this, \"user_form[\" + field + \"]\", jsonContext[field], 'input');
                        }
\t\t\t\t\t}
                    {% if not user.id %}
                        /* guess timezone and select that one */
                        var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone == 'Asia/Calcutta' ? 'Asia/Kolkata' : Intl.DateTimeFormat().resolvedOptions().timeZone;
                        if(timezone) {
                            var option = \$('select[name=\"user_form[timezone]\"]').find('option[value=\"'+ timezone +'\"]');
                            if(option.length) {
                                option.prop('selected', true);
                            }
                        }
                    {% endif %}
\t\t\t\t},
\t\t\t\tformChanegd: function(e) {
\t\t\t    \tvar fieldName = Backbone.\$(e.currentTarget).attr('name');
                    \$(\".uv-tabs li.uv-tab-active\").removeClass('uv-tab-error')
                    if(fieldName == 'user_form[password][second]') {
                        if(\$(\"input[name='user_form[password][first]']\").val().length) {
                            this.model.set(fieldName, Backbone.\$(e.currentTarget).val())
                            this.model.isValid([fieldName])
                        } else {
                            if(\$(\"input[name='user_form[password][second]']\").val().length) {
\t\t    \t\t\t        this.model.set(fieldName, Backbone.\$(e.currentTarget).val())
                                this.model.isValid([fieldName])
                            } else {
\t\t    \t\t\t        Backbone.Validation.callbacks.valid(this, fieldName, 'input');
                            }
                        }
                    } else {
                        this.model.set(fieldName, Backbone.\$(e.currentTarget).val())
                        this.model.isValid([fieldName])
                        if(fieldName == 'user_form[password][first]' && !\$(\"input[name='user_form[password][second]']\").val().length) {
\t\t    \t\t\t    Backbone.Validation.callbacks.valid(this, 'user_form[password][second]', 'input');
                        }
                    }
\t\t\t    },
\t\t\t\tsaveUser : function (e) {
\t\t\t\t\te.preventDefault();
                    \$(\".uv-tabs li\").removeClass('uv-tab-error')
                    this.model.unset('user_form[groups][]', { silent: true });
                    this.model.unset('user_form[agentPrivilege][]', { silent: true });
\t\t\t        this.model.set(this.\$el.serializeObject());
\t\t\t        if(this.model.isValid(true)) {
                        if(\$(\"#user_form_role\").val() == 'ROLE_ADMIN') {
                            \$('input[name=\"user_form[agentPrivilege][]\"]').remove();
                            this.model.unset('user_form[agentPrivilege][]', { silent: true });
                        }
\t\t\t\t\t\tthis.\$el.find('.uv-btn').attr('disabled', 'disabled');
\t\t\t            this.\$el.submit();
\t\t\t        } else {
                        console.log('invalid user, ', this.model);

                        \$('.uv-field-message').each(function(e) {
                            \$(\".uv-tabs li[for='\" + \$(this).parents('.uv-tab-view').attr('id') + \"']:not(.uv-tab-active)\").addClass('uv-tab-error')

                            if(\$(\".uv-tabs li[for='\" + \$(this).parents('.uv-tab-view').attr('id') + \"']:not(.uv-tab-active)\").length ) {
                                \$('.uv-view').animate({
                                    scrollTop: 0
                                }, 'slow');
                            }
                        });
                    }
\t\t\t\t},
                roleChanged: function(e) {
                    if(\$(e.target).val() == 'ROLE_AGENT') {
\t\t            \t\$('.role-dependent-fields').show();
\t\t            } else {
\t\t            \t\$('.role-dependent-fields').hide();
\t\t            }
                },
                selectAll: function (e) {
                    e.preventDefault();
                    this.\$(e.currentTarget).parents('.uv-scroll-plank')
                            .find('input')
                            .prop('checked', true)
                },
                deselectAll: function (e) {
                    e.preventDefault();
                    this.\$(e.currentTarget).parents('.uv-scroll-plank')
                            .find('input')
                            .prop('checked', false);
\t\t        },
\t\t\t});

\t\t\tnew UserForm({
\t\t\t\tel: \$(\"#user-form\"),
\t\t\t\tmodel: new UserModel()
\t\t\t});

            \$('#user_form_role').trigger('change');
\t\t});
\t</script>
{% endblock %}", "@UVDeskCoreFramework/Agents/createSupportAgent.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/Agents/createSupportAgent.html.twig");
    }
}
