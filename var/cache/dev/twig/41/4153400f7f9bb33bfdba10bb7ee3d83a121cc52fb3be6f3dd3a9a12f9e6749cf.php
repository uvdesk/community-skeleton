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

/* @UVDeskCoreFramework//ticket.html.twig */
class __TwigTemplate_a12fa74eb02bf930cbefed87542b5a59f0e5dfcc3818caa34f4a57ce42310ddf extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework//ticket.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework//ticket.html.twig"));

        $this->parent = $this->loadTemplate("@UVDeskCoreFramework//Templates//layout.html.twig", "@UVDeskCoreFramework//ticket.html.twig", 1);
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

        echo twig_escape_filter($this->env, ((("#" . twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 3, $this->source); })()), "id", [], "any", false, false, false, 3)) . " ") . twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 3, $this->source); })()), "subject", [], "any", false, false, false, 3)), "html", null, true);
        
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
        .uv-aside-ticket-labels.label-list-block .uv-btn-label {
            cursor: pointer;
        }
        .uv-main-info-update-block .uv-element-block {
            margin: 10px 0px !important;
        }
        .uv-tab-ellipsis {
            position: relative;
        }
        .uv-inner-section .uv-view .uv-ticket-section .uv-ticket-accordion .uv-ticket-wrapper {
            display: block;
        }
        .uv-element-block.cc-bcc .uv-dropdown-container {
            padding: 10px 20px 10px 20px;
        }
        .uv-action-buttons .uv-dropdown-list ul li {
            padding: 5px 0px !important;
        }
        .uv-action-buttons{
            margin-bottom: 40px !important;
        }
        .uv-ticket-reply .uv-element-block-textarea, .thread-edit-container .uv-element-block-textarea {
            width: 100% !important;
            max-width: 100% !important;
        }
        .thread-edit-container .uv-field-message {
            color: #FF5656 !important;
        }
        .uv-element-block .mce-tinymce {
            margin-top: 10px;
        }
        .uv-ticket-reply .uv-element-block-textarea .uv-field-message, .thread-edit-container .uv-element-block-textarea .uv-field-message {
            margin-top: 15px;
        }
        .thread-edit-container {
            margin-top: 10px;
        }
        .uv-ticket-viewer-bar{
            transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            height: 0px;
        }
        .uv-ticket-viewer-bar.active{
            height: 50px;
            margin-bottom: 10px;
            border-bottom: 1px dotted #f97278;
        }
        .uv-ticket-viewer-single {
            display: inline-block;
            margin-right: 5px;
        }
        .uv-ticket-viewer-single img {
            width: 40px;
            border-radius: 3px;
            display: inline-block;
            vertical-align: middle;
        }
        .uv-ticket-viewer-single.uv-first {
            width: 40px;
            height: 40px;
            background-image: linear-gradient(to right, #f97278 0%, #f181bf 100%);
            text-align: center;
            vertical-align: top;
            line-height: 30px;
            border-radius: 20px;
        }
        .uv-ticket-viewer-close {
            position: absolute;
            top: 0px;
            width: 40px;
            height: 40px;
            background: #f1f1f1;
            text-align: center;
            line-height: 35px;
            border-radius: 2px;
            opacity: .6;
            text-indent: 6px;
        }
        .uv-ticket-viewer-list {
            display: inline;
        }
        span.viewer-firstletter.img-thumbnail {
            width: 40px;
            height: 40px;
            display: block;
            text-align: center;
            font-size: 20px;
            font-style: italic;
            border: 1px dotted;
            border-radius: 4px;
            line-height: 35px;
        }
        .uv-ticket-viewer-close {
            display:none;
        }
        .uv-ticket-viewer-single:hover .uv-ticket-viewer-close {
            display: block;
        }
        .uv-hide{
            display: none;
        }
        .uv-info{
            background: #7C70F4;
        }
        .uv-ticket-viewer-list .uv-icon-eye-light{
            animation: jelly 0.8s infinite alternate ease-in-out;
        }
        .uv-aside-brick .uv-loader {
            position: absolute;
            transform: scale(0.5);
            top: 22px;
            right: 45px;
        }
        .uv-app-glyph-customfields {
            width: 20px;
            height: 20px;
            background-position: center center;
            background-repeat: no-repeat;
            cursor: pointer;
            display: inline-block;
            vertical-align: middle;
            margin: 5px 0px 5px 10px;
            background-image: url(\"";
        // line 130
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdeskcoreframework/images/app-glyph-custom.svg"), "html", null, true);
        echo "\");
        }
        .uv-no-threads {
            padding: 80px 20px;
            text-align: center;
        }
        .uv-ticket-strip-label {
            position: relative;
        }
        input.input-copy-thread-link {
            position: absolute;
            bottom: 10px;
            width: 400px;
        }
        .uv-ticket-action-bar-fixed{
            position: fixed;
            width: 100%;
            background: #fff;
            z-index: 999;
        }
        .uv-ticket-action-bar-fixed .uv-ticket-action-bar-rt{
            position: fixed;
            right: 0px;
            margin-top: 10px;
        }
        .uv-ticket-action-bar-fixed + .uv-ticket-viewer-bar{
            margin-top: 70px;
        }
        .uv-ticket-main {
            word-wrap: break-word;
        }
        @media only screen and (max-width: 900px) {
            .uv-ticket-action-bar-fixed{
                position: relative;
            }
            .uv-ticket-action-bar-fixed + .uv-ticket-viewer-bar{
                margin-top: 0px;
            }
            .uv-ticket-action-bar-fixed .uv-ticket-action-bar-rt{
                position: relative;
            }
        }
        .uv-icon-pin {
            width: 18px;
            height: 18px;
            display: inline-block;
            vertical-align: middle;
            background-image: url(\"";
        // line 177
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdeskcoreframework/images/uvdesk-sprite.svg"), "html", null, true);
        echo "\");
            background-position: 0px -396px;
            transition: transform .15s;
            transform: scale(1);
        }
        .uv-icon-pinned {
            background-position: -19px -396px;
        }
        .uv-header-fix{
            display: inline-block;
            margin: 0px 10px 0px 5px;
        }
        .uv-header-fix + .uv-tabs{
            display: inline-block;
        }
        .uv-ticket-section span.uv-mail-status {
            width: 16px;
            height: 16px;
            background: url('../../../../../bundles/webkuldefault/images/mail-status.png');
            cursor: help;
        }
        .uv-ticket-section .uv-mail-status.uv-mail-processed {
            background-position: 0 0;
        }
        .uv-ticket-section .uv-mail-status.uv-mail-open,.uv-ticket-section .uv-mail-status.uv-mail-delivered,.uv-ticket-section .uv-mail-status.uv-mail-click {
            background-position: -38px 0;
        }
        .uv-ticket-section .uv-mail-status.uv-mail-spam,.uv-ticket-section .uv-mail-status.uv-mail-deferred,.uv-ticket-section .uv-mail-spamreport {
            background-position: -55px 0;
        }
        .uv-ticket-section .uv-mail-status.uv-mail-bounce,.uv-ticket-section .uv-mail-status.uv-mail-dropped {
            background-position: -73px 0;
        }
        @media only screen and (max-width: 1480px) {
            .uv-inner-section .uv-view .uv-ticket-action-bar-fixed.uv-ticket-action-bar .uv-ticket-action-bar-rt{
                width: auto;
            }
        }
        @media only screen and (max-width: 1300px) {
            .uv-header-fix{
                margin: 0px 10px 0px 10px;
            }
        }

        @media only screen and (max-width: 900px) {
            .uv-ticket-action-bar-fixed{
                position: relative;
            }
            .uv-ticket-action-bar-fixed + .uv-ticket-viewer-bar{
                margin-top: 0px;
            }
            .uv-ticket-action-bar-fixed .uv-ticket-action-bar-rt{
                position: relative;
            }
            .uv-inner-section .uv-view .uv-ticket-action-bar.uv-ticket-action-bar-fixed .uv-ticket-action-bar-lt{
                width: 70%;
            }
            .uv-inner-section .uv-view .uv-ticket-action-bar.uv-ticket-action-bar-fixed .uv-ticket-action-bar-rt {
                width: 21%;
                padding-right: 33px;
            }
            .uv-header-fix{
                display: none;
            }
        }
        
        .uv-inner-section .uv-view .uv-ticket-scroll-region {
            margin-bottom: 0px;
        }
        
        .uv-inner-section .uv-view .uv-ticket-action-bar.uv-ticket-action-bar-fixed .uv-ticket-action-bar-rt {
            width: 21%;
            padding-right: 33px;
        }
        @media print {
            .uv-navbar,.uv-ticket-action-bar, .uv-sidebar, .uv-aside>.uv-aside-brick, .uv-aside-back, .uv-ticket-fixed-region, .uv-ticket-main.uv-ticket-reply, .uv-upload-actions, .uv-filter-view, .uv-dropdown-list>.uv-dropdown-container,.uv-notifications-wrapper,.uv-pop-up-overlay,.uv-loader-view, .uv-loader, .uv-navbar,.uv-ticket-count-wrapper {
                display: none !important;
            }
            .uv-ticket-scroll-region {
                overflow: visible;
                margin-bottom: 0 !important;
            }
            .uv-paper {
                padding-left: 0px !important; /* uv-view */
            }
            .uv-wrapper {
                left: 0 !important;
                margin: 0 !important;
            }
            .uv-inner-section .uv-view .uv-ticket-scroll-region  .uv-ticket-main-rt {
                width: 80%;
            }
            .uv-paper,.uv-view ,.uv-ticket-scroll-region, .uv-wrapper  {
                position: initial !important;
            }
        }

        .uv-ticket-action-bar-rt .app-glyph {
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
            cursor: pointer;
            height: 20px;
            width: 20px;
        }

        .uv-ticket-action-bar-rt .app-glyph:last-child {
            margin-right: 0px;
        }
    </style>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 289
    public function block_pageContent($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageContent"));

        // line 290
        echo "    <div class=\"uv-inner-section\">
        ";
        // line 292
        echo "        <div class=\"uv-aside\" ";
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 292, $this->source); })()), "request", [], "any", false, false, false, 292), "cookies", [], "any", false, false, false, 292) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 292, $this->source); })()), "request", [], "any", false, false, false, 292), "cookies", [], "any", false, false, false, 292), "get", [0 => "uv-asideView"], "method", false, false, false, 292))) {
            echo "style=\"display: none;\"";
        }
        echo " >
            <div class=\"uv-main-info-block\">
                <div class=\"uv-aside-head\">
                    <div class=\"uv-aside-title\">
                        <h6>";
        // line 296
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Ticket"), "html", null, true);
        echo " #";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 296, $this->source); })()), "id", [], "any", false, false, false, 296), "html", null, true);
        echo "</h6>
                    </div>
                    <div class=\"uv-aside-back\">
                        <span onclick=\"history.length > 1 ? history.go(-1) : window.location = '";
        // line 299
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_ticket_collection");
        echo "';\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Back"), "html", null, true);
        echo "</span>
                    </div>
                </div>
        
                ";
        // line 304
        echo "                <div class=\"uv-aside-brick\">
                    ";
        // line 306
        echo "                    <div class=\"uv-aside-customer-block\">
                        <h3>";
        // line 307
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Customer Information"), "html", null, true);
        echo "</h3>
                        <div class=\"uv-aside-avatar\">
                            ";
        // line 309
        if (twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 309, $this->source); })()), "thumbnail", [], "any", false, false, false, 309)) {
            // line 310
            echo "                                <img src=\"";
            echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 310, $this->source); })()), "request", [], "any", false, false, false, 310), "scheme", [], "any", false, false, false, 310) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 310, $this->source); })()), "request", [], "any", false, false, false, 310), "httpHost", [], "any", false, false, false, 310)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")), "html", null, true);
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 310, $this->source); })()), "thumbnail", [], "any", false, false, false, 310), "html", null, true);
            echo "\">
                            ";
        } else {
            // line 312
            echo "                                <img src=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((isset($context["default_customer_image_path"]) || array_key_exists("default_customer_image_path", $context) ? $context["default_customer_image_path"] : (function () { throw new RuntimeError('Variable "default_customer_image_path" does not exist.', 312, $this->source); })())), "html", null, true);
            echo "\">
                            ";
        }
        // line 314
        echo "                        </div>

                        <div class=\"uv-aside-customer-info\">
                            <span>";
        // line 317
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 317, $this->source); })()), "name", [], "any", false, false, false, 317), "html", null, true);
        echo "</span>
                            <span>";
        // line 318
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 318, $this->source); })()), "email", [], "any", false, false, false, 318), "html", null, true);
        echo "</span>
                            ";
        // line 319
        if (twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 319, $this->source); })()), "contactNumber", [], "any", false, false, false, 319)) {
            // line 320
            echo "                                <span>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 320, $this->source); })()), "contactNumber", [], "any", false, false, false, 320), "html", null, true);
            echo "</span>
                            ";
        }
        // line 322
        echo "
                            ";
        // line 323
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 323, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_MANAGE_CUSTOMER"], "method", false, false, false, 323)) {
            // line 324
            echo "                                <span class=\"uv-customize\" data-toggle=\"tooltip\" title=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit Customer Information"), "html", null, true);
            echo "\"></span>
                            ";
        }
        // line 326
        echo "                        </div>
                    </div>

                    ";
        // line 330
        echo "                    <div class=\"uv-aside-ticket-block\">
                        <div class=\"uv-aside-ticket-brick\">
                            <h3>";
        // line 332
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Total Replies"), "html", null, true);
        echo "</h3>
                            <span class=\"uv-icon-replies\"></span> <span>";
        // line 333
        echo twig_escape_filter($this->env, (isset($context["totalReplies"]) || array_key_exists("totalReplies", $context) ? $context["totalReplies"] : (function () { throw new RuntimeError('Variable "totalReplies" does not exist.', 333, $this->source); })()), "html", null, true);
        echo "</span>
                        </div>

                        <div class=\"uv-aside-ticket-brick\">
                            <h3>";
        // line 337
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("TimeStamp"), "html", null, true);
        echo "</h3>
                            <span class=\"uv-icon-timestamp\"></span> <span>";
        // line 338
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 338, $this->source); })()), "timeZoneConverter", [0 => twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 338, $this->source); })()), "createdAt", [], "any", false, false, false, 338)], "method", false, false, false, 338), "html", null, true);
        echo "</span>
                        </div>

                        <div class=\"uv-aside-ticket-brick\">
                            <h3>";
        // line 342
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Channel"), "html", null, true);
        echo "</h3>
                            ";
        // line 343
        if ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 343, $this->source); })()), "source", [], "any", false, false, false, 343) == "email")) {
            // line 344
            echo "                                <span class=\"uv-icon-channel uv-channel-email\"></span> <span>";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email"), "html", null, true);
            echo "</span>
                            ";
        } else {
            // line 346
            echo "                                <span class=\"uv-icon-channel uv-channel-web\"></span> <span>";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Website"), "html", null, true);
            echo "</span>
                            ";
        }
        // line 348
        echo "                        </div>
                    </div>
                </div>
            </div>

            ";
        // line 354
        echo "            ";
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 354, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_MANAGE_CUSTOMER"], "method", false, false, false, 354)) {
            // line 355
            echo "                <div class=\"uv-main-info-update-block uv-no-error-success-icon\" style=\"display: none\">
                    <div class=\"uv-aside-head\">
                        <div class=\"uv-aside-title\"><h6>";
            // line 357
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit Customer"), "html", null, true);
            echo "</h6></div>
                        <div class=\"uv-aside-back\"><span>";
            // line 358
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Back"), "html", null, true);
            echo "</span></div>
                    </div>

                    <div class=\"uv-aside-brick\">
                        <form method=\"post\">
                            <input class=\"uv-field\" name=\"id\" type=\"hidden\" value=\"";
            // line 363
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 363, $this->source); })()), "id", [], "any", false, false, false, 363), "html", null, true);
            echo "\">

                            <div class=\"uv-element-block\">
                                <label class=\"uv-field-label\">";
            // line 366
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Name"), "html", null, true);
            echo "</label>
                                <div class=\"uv-field-block\">
                                    <input class=\"uv-field\" name=\"name\" type=\"text\" value=\"";
            // line 368
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 368, $this->source); })()), "name", [], "any", false, false, false, 368), "html", null, true);
            echo "\">
                                </div>
                            </div>

                            <div class=\"uv-element-block\">
                                <label class=\"uv-field-label\">";
            // line 373
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email"), "html", null, true);
            echo "</label>
                                <div class=\"uv-field-block\">
                                    <input class=\"uv-field\" name=\"email\" type=\"text\" value=\"";
            // line 375
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 375, $this->source); })()), "email", [], "any", false, false, false, 375), "html", null, true);
            echo "\">
                                </div>
                            </div>

                            <div class=\"uv-element-block\">
                                <label class=\"uv-field-label\">";
            // line 380
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Contact Number"), "html", null, true);
            echo "</label>
                                <div class=\"uv-field-block\">
                                    <input class=\"uv-field\" name=\"contactNumber\" type=\"text\" value=\"";
            // line 382
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 382, $this->source); })()), "contactNumber", [], "any", false, false, false, 382), "html", null, true);
            echo "\">
                                </div>
                            </div>

                            <div class=\"uv-action-buttons\">
                                <a class=\"uv-btn update-btn\" href=\"#\">";
            // line 387
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Update"), "html", null, true);
            echo "</a>
                                <a class=\"uv-btn cancel-btn\" href=\"#\">";
            // line 388
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Cancel"), "html", null, true);
            echo "</a>
                            </div>

                            <input type=\"hidden\" name=\"_token\" value=\"";
            // line 391
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["csrf_token_generator"]) || array_key_exists("csrf_token_generator", $context) ? $context["csrf_token_generator"] : (function () { throw new RuntimeError('Variable "csrf_token_generator" does not exist.', 391, $this->source); })()), "refreshToken", [0 => ""], "method", false, false, false, 391), "html", null, true);
            echo "\"/>
                        </form>
                    </div>
                </div>
            ";
        }
        // line 396
        echo "
            ";
        // line 398
        echo "            <div class=\"uv-aside-brick\">
                <div class=\"uv-aside-ticket-actions\">
                    ";
        // line 401
        echo "                    <div class=\"uv-aside-select\">
                        <label class=\"uv-aside-select-label\">";
        // line 402
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent"), "html", null, true);
        echo "</label>
                        <div>
                            ";
        // line 404
        $context["agentName"] = (((isset($context["ticketAgent"]) || array_key_exists("ticketAgent", $context) ? $context["ticketAgent"] : (function () { throw new RuntimeError('Variable "ticketAgent" does not exist.', 404, $this->source); })())) ? (twig_get_attribute($this->env, $this->source, (isset($context["ticketAgent"]) || array_key_exists("ticketAgent", $context) ? $context["ticketAgent"] : (function () { throw new RuntimeError('Variable "ticketAgent" does not exist.', 404, $this->source); })()), "name", [], "any", false, false, false, 404)) : ("Not Assigned"));
        // line 405
        echo "                            ";
        if (((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 405, $this->source); })()), "isTrashed", [], "any", false, false, false, 405) == false) && twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 405, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_ASSIGN_TICKET"], "method", false, false, false, 405))) {
            // line 406
            echo "                                <span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"";
            (((isset($context["ticketAgent"]) || array_key_exists("ticketAgent", $context) ? $context["ticketAgent"] : (function () { throw new RuntimeError('Variable "ticketAgent" does not exist.', 406, $this->source); })())) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticketAgent"]) || array_key_exists("ticketAgent", $context) ? $context["ticketAgent"] : (function () { throw new RuntimeError('Variable "ticketAgent" does not exist.', 406, $this->source); })()), "id", [], "any", false, false, false, 406), "html", null, true))) : (print ("")));
            echo "\">";
            echo twig_escape_filter($this->env, (isset($context["agentName"]) || array_key_exists("agentName", $context) ? $context["agentName"] : (function () { throw new RuntimeError('Variable "agentName" does not exist.', 406, $this->source); })()), "html", null, true);
            echo "</span>
                                <div class=\"uv-dropdown-list uv-bottom-left\">
                                    <div class=\"uv-dropdown-container\">
                                        <label>";
            // line 409
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent"), "html", null, true);
            echo "</label>
                                        <div class=\"uv-search-sm\">
                                            <input type=\"text\" class=\"uv-search-field\" placeholder=\"";
            // line 411
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Search"), "html", null, true);
            echo "\">
                                        </div>
                                    </div>

                                    <ul class=\"uv-agents-list agent\" data-action=\"agent\">
                                        ";
            // line 416
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 416, $this->source); })()), "getAgentPartialDataCollection", [], "method", false, false, false, 416));
            foreach ($context['_seq'] as $context["_key"] => $context["agent"]) {
                // line 417
                echo "                                            <li data-index=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["agent"], "id", [], "any", false, false, false, 417), "html", null, true);
                echo "\">
                                                <img src=\"";
                // line 418
                echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, $context["agent"], "smallThumbnail", [], "any", false, false, false, 418) != null)) ? (((((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 418, $this->source); })()), "request", [], "any", false, false, false, 418), "scheme", [], "any", false, false, false, 418) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 418, $this->source); })()), "request", [], "any", false, false, false, 418), "httpHost", [], "any", false, false, false, 418)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")) . twig_get_attribute($this->env, $this->source, $context["agent"], "smallThumbnail", [], "any", false, false, false, 418))) : ($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((isset($context["default_agent_image_path"]) || array_key_exists("default_agent_image_path", $context) ? $context["default_agent_image_path"] : (function () { throw new RuntimeError('Variable "default_agent_image_path" does not exist.', 418, $this->source); })())))), "html", null, true);
                echo "\"/> ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["agent"], "name", [], "any", false, false, false, 418), "html", null, true);
                echo "
                                            </li>
                                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['agent'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 421
            echo "                                    </ul>
                                </div>
                            ";
        } else {
            // line 424
            echo "                                <span class=\"uv-aside-select-value\">";
            echo twig_escape_filter($this->env, (isset($context["agentName"]) || array_key_exists("agentName", $context) ? $context["agentName"] : (function () { throw new RuntimeError('Variable "agentName" does not exist.', 424, $this->source); })()), "html", null, true);
            echo "</span>
                            ";
        }
        // line 426
        echo "                        </div>
                    </div>

                    ";
        // line 430
        echo "                    <div class=\"uv-aside-select\">
                        <label class=\"uv-aside-select-label\">";
        // line 431
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Priority"), "html", null, true);
        echo "</label>
                        <div>
                            <span class=\"uv-list-ticket-priority\" style=\"background: ";
        // line 433
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 433, $this->source); })()), "priority", [], "any", false, false, false, 433), "colorCode", [], "any", false, false, false, 433), "html", null, true);
        echo "\"></span>
                            ";
        // line 434
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 434, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_UPDATE_TICKET_PRIORITY"], "method", false, false, false, 434)) {
            // line 435
            echo "                                <span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 435, $this->source); })()), "priority", [], "any", false, false, false, 435), "id", [], "any", false, false, false, 435), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 435, $this->source); })()), "priority", [], "any", false, false, false, 435), "description", [], "any", false, false, false, 435), "html", null, true);
            echo "</span>
                                <div class=\"uv-dropdown-list uv-bottom-left\">
                                    <div class=\"uv-dropdown-container\">
                                        <label>";
            // line 438
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Priority"), "html", null, true);
            echo "</label>
                                        <ul class=\"priority\" data-action=\"priority\">
                                            ";
            // line 440
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["ticketPriorityCollection"]) || array_key_exists("ticketPriorityCollection", $context) ? $context["ticketPriorityCollection"] : (function () { throw new RuntimeError('Variable "ticketPriorityCollection" does not exist.', 440, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["priority"]) {
                // line 441
                echo "                                                <li data-index=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["priority"], "id", [], "any", false, false, false, 441), "html", null, true);
                echo "\" data-color=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["priority"], "colorCode", [], "any", false, false, false, 441), "html", null, true);
                echo "\"><a href=\"#\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["priority"], "description", [], "any", false, false, false, 441), "html", null, true);
                echo "</a></li>
                                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['priority'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 443
            echo "                                        </ul>
                                    </div>
                                </div>
                            ";
        } else {
            // line 447
            echo "                                <span class=\"uv-aside-select-value\">
                                    ";
            // line 448
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 448, $this->source); })()), "priority", [], "any", false, false, false, 448), "description", [], "any", false, false, false, 448), "html", null, true);
            echo "
                                </span>
                            ";
        }
        // line 451
        echo "                        </div>
                    </div>

                    ";
        // line 455
        echo "                    <div class=\"uv-aside-select\">
                        <label class=\"uv-aside-select-label\">";
        // line 456
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
        echo "</label>
                        <div>
                            ";
        // line 458
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 458, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_UPDATE_TICKET_STATUS"], "method", false, false, false, 458)) {
            // line 459
            echo "                                <span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 459, $this->source); })()), "status", [], "any", false, false, false, 459), "id", [], "any", false, false, false, 459), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 459, $this->source); })()), "status", [], "any", false, false, false, 459), "description", [], "any", false, false, false, 459), "html", null, true);
            echo "</span>
                                <div class=\"uv-dropdown-list uv-bottom-left\">
                                    <div class=\"uv-dropdown-container\">
                                        <label>";
            // line 462
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
            echo "</label>
                                        <ul class=\"status\" data-action=\"status\">
                                            ";
            // line 464
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["ticketStatusCollection"]) || array_key_exists("ticketStatusCollection", $context) ? $context["ticketStatusCollection"] : (function () { throw new RuntimeError('Variable "ticketStatusCollection" does not exist.', 464, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["status"]) {
                // line 465
                echo "                                                <li data-index=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["status"], "id", [], "any", false, false, false, 465), "html", null, true);
                echo "\"><a href=\"#\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["status"], "description", [], "any", false, false, false, 465), "html", null, true);
                echo "</a></li>
                                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['status'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 467
            echo "                                        </ul>
                                    </div>
                                </div>
                            ";
        } else {
            // line 471
            echo "                                <span class=\"uv-aside-select-value\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 471, $this->source); })()), "status", [], "any", false, false, false, 471), "description", [], "any", false, false, false, 471), "html", null, true);
            echo "</span>
                            ";
        }
        // line 473
        echo "                        </div>
                    </div>

                    ";
        // line 477
        echo "                    <div class=\"uv-aside-select\">
                        <label class=\"uv-aside-select-label\">";
        // line 478
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Type"), "html", null, true);
        echo "</label>
                        <div>
                            ";
        // line 480
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 480, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_UPDATE_TICKET_TYPE"], "method", false, false, false, 480)) {
            // line 481
            echo "                                <span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"";
            ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 481, $this->source); })()), "type", [], "any", false, false, false, 481)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 481, $this->source); })()), "type", [], "any", false, false, false, 481), "id", [], "any", false, false, false, 481), "html", null, true))) : (print ("-- --")));
            echo "\">";
            ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 481, $this->source); })()), "type", [], "any", false, false, false, 481)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 481, $this->source); })()), "type", [], "any", false, false, false, 481), "description", [], "any", false, false, false, 481), "html", null, true))) : (print ("{{'Not Assigned'|trans}}")));
            echo "</span>
                                <div class=\"uv-dropdown-list uv-bottom-left\">
                                    <div class=\"uv-dropdown-container\">
                                        <label>";
            // line 484
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Type"), "html", null, true);
            echo "</label>
                                        <div class=\"uv-search-sm\">
                                            <input type=\"text\" class=\"uv-search-field\" placeholder=\"";
            // line 486
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Search"), "html", null, true);
            echo "\">
                                        </div>
                                    </div>

                                    <ul class=\"uv-search-list type\" data-action=\"type\">
                                        ";
            // line 491
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["ticketTypeCollection"]) || array_key_exists("ticketTypeCollection", $context) ? $context["ticketTypeCollection"] : (function () { throw new RuntimeError('Variable "ticketTypeCollection" does not exist.', 491, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["type"]) {
                // line 492
                echo "                                            <li data-index=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["type"], "id", [], "any", false, false, false, 492), "html", null, true);
                echo "\"><a href=\"#\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["type"], "description", [], "any", false, false, false, 492), "html", null, true);
                echo "</a></li>
                                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['type'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 494
            echo "                                    </ul>
                                </div>
                            ";
        } else {
            // line 497
            echo "                                <span class=\"uv-aside-select-value\">
                                    ";
            // line 498
            ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 498, $this->source); })()), "type", [], "any", false, false, false, 498)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 498, $this->source); })()), "type", [], "any", false, false, false, 498), "description", [], "any", false, false, false, 498), "html", null, true))) : (print ("Not Assigned")));
            echo "
                                </span>
                            ";
        }
        // line 501
        echo "                        </div>
                    </div>

                    ";
        // line 505
        echo "                    <div class=\"uv-aside-select\">
                        <label class=\"uv-aside-select-label\">";
        // line 506
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Group"), "html", null, true);
        echo "</label>
                        <div>
                            ";
        // line 508
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 508, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_ASSIGN_TICKET_GROUP"], "method", false, false, false, 508)) {
            // line 509
            echo "                                <span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"";
            ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 509, $this->source); })()), "supportGroup", [], "any", false, false, false, 509)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 509, $this->source); })()), "supportGroup", [], "any", false, false, false, 509), "id", [], "any", false, false, false, 509), "html", null, true))) : (print ("-- --")));
            echo "\">
                                    ";
            // line 510
            ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 510, $this->source); })()), "supportGroup", [], "any", false, false, false, 510)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 510, $this->source); })()), "supportGroup", [], "any", false, false, false, 510), "name", [], "any", false, false, false, 510), "html", null, true))) : (print ("Not Assigned")));
            echo "
                                </span>
                                <div class=\"uv-dropdown-list uv-bottom-left\">
                                    <div class=\"uv-dropdown-container\">
                                        <label>";
            // line 514
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Group"), "html", null, true);
            echo "</label>
                                        <div class=\"uv-search-sm\">
                                            <input type=\"text\" class=\"uv-search-field\" placeholder=\"";
            // line 516
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Search"), "html", null, true);
            echo "\">
                                        </div>
                                    </div>
                                    <ul class=\"uv-search-list group\" data-action=\"group\">
                                        <li data-index=\"\"><a href=\"#\">";
            // line 520
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Not Assigned"), "html", null, true);
            echo "</a></li>

                                        ";
            // line 522
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["supportGroupCollection"]) || array_key_exists("supportGroupCollection", $context) ? $context["supportGroupCollection"] : (function () { throw new RuntimeError('Variable "supportGroupCollection" does not exist.', 522, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["group"]) {
                // line 523
                echo "                                            <li data-index=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["group"], "id", [], "any", false, false, false, 523), "html", null, true);
                echo "\"><a href=\"#\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["group"], "name", [], "any", false, false, false, 523), "html", null, true);
                echo "</a></li>
                                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['group'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 525
            echo "                                    </ul>
                                </div>
                            ";
        } else {
            // line 528
            echo "                                <span class=\"uv-aside-select-value\">
                                    ";
            // line 529
            ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 529, $this->source); })()), "supportGroup", [], "any", false, false, false, 529)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 529, $this->source); })()), "supportGroup", [], "any", false, false, false, 529), "name", [], "any", false, false, false, 529), "html", null, true))) : (print ("Not Assigned")));
            echo "
                                </span>
                            ";
        }
        // line 532
        echo "                        </div>
                    </div>

                    ";
        // line 536
        echo "                    <div class=\"uv-aside-select\">
                        <label class=\"uv-aside-select-label\">";
        // line 537
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Team"), "html", null, true);
        echo "</label>
                        <div>
                            ";
        // line 539
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 539, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_ASSIGN_TICKET_GROUP"], "method", false, false, false, 539)) {
            // line 540
            echo "                                <span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"";
            ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 540, $this->source); })()), "supportTeam", [], "any", false, false, false, 540)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 540, $this->source); })()), "supportTeam", [], "any", false, false, false, 540), "id", [], "any", false, false, false, 540), "html", null, true))) : (print ("-- --")));
            echo "\">
                                    ";
            // line 541
            ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 541, $this->source); })()), "supportTeam", [], "any", false, false, false, 541)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 541, $this->source); })()), "supportTeam", [], "any", false, false, false, 541), "name", [], "any", false, false, false, 541), "html", null, true))) : (print ("Not Assigned")));
            echo "
                                </span>
                                <div class=\"uv-dropdown-list uv-bottom-left\">
                                    <div class=\"uv-dropdown-container\">
                                        <label>";
            // line 545
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Team"), "html", null, true);
            echo "</label>
                                        <div class=\"uv-search-sm\">
                                            <input type=\"text\" class=\"uv-search-field\" placeholder=\"Search\">
                                        </div>
                                    </div>
                                    <ul class=\"uv-search-list team\" data-action=\"team\">
                                        <li data-index=\"\"><a href=\"#\">";
            // line 551
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Not Assigned"), "html", null, true);
            echo "</a></li>
                                        ";
            // line 552
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["supportTeamCollection"]) || array_key_exists("supportTeamCollection", $context) ? $context["supportTeamCollection"] : (function () { throw new RuntimeError('Variable "supportTeamCollection" does not exist.', 552, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["team"]) {
                // line 553
                echo "                                            <li data-index=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "id", [], "any", false, false, false, 553), "html", null, true);
                echo "\"><a href=\"#\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "name", [], "any", false, false, false, 553), "html", null, true);
                echo "</a></li>
                                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['team'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 555
            echo "                                    </ul>
                                </div>
                            ";
        } else {
            // line 558
            echo "                                <span class=\"uv-aside-select-value\">
                                    ";
            // line 559
            echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 559, $this->source); })()), "supportTeam", [], "any", false, false, false, 559)) ? (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 559, $this->source); })()), "supportTeam", [], "any", false, false, false, 559), "name", [], "any", false, false, false, 559)) : ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Not Assigned"))), "html", null, true);
            echo "
                                </span>
                            ";
        }
        // line 562
        echo "                        </div>
                    </div>
                </div>
            </div>

            ";
        // line 568
        echo "            <div class=\"uv-aside-brick\">
                <div class=\"uv-aside-ticket-labels label-list-block\">
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 571
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Labels"), "html", null, true);
        echo "</label>

                        <div class=\"uv-field-block\">
                            <input class=\"uv-field uv-dropdown-other\" type=\"text\" data-type=\"label\">
                            <div class=\"uv-dropdown-list uv-top-left\">
                                <div class=\"uv-dropdown-container\">
                                    <label>";
        // line 577
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Filter With"), "html", null, true);
        echo "</label>
                                    <ul class=\"\">
                                        <span class=\"uv-filter-info\">";
        // line 579
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Type atleast 2 letters"), "html", null, true);
        echo "</span>
                                        <span class=\"uv-no-results\" style=\"display: none;\">";
        // line 580
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("No result found"), "html", null, true);
        echo "</span>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"label-list\"></div>
                </div>
            </div>

            ";
        // line 592
        echo "            <div class=\"uv-aside-brick collaborator-list-block\">
                <div class=\"uv-aside-ticket-labels\">
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 595
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Collaborators"), "html", null, true);
        echo "</label>

                        ";
        // line 597
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 597, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_ADD_COLLABORATOR_TO_TICKET"], "method", false, false, false, 597)) {
            // line 598
            echo "                            <div class=\"uv-field-block\">
                                <input class=\"uv-field\" type=\"text\" name=\"email\" type=\"text\" value=\"\" placeholder=\"";
            // line 599
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Type email to add"), "html", null, true);
            echo "\">
                            </div>
                        ";
        }
        // line 602
        echo "                    </div>
                    <div class=\"collaborator-list\" style=\"margin-top: 10px\"></div>
                </div>
            </div>

            ";
        // line 608
        echo "            <div class=\"uv-aside-brick tag-list-block\">
                <div class=\"uv-aside-ticket-labels\">
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
        // line 611
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Tags"), "html", null, true);
        echo "</label>

                        ";
        // line 613
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 613, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_ADD_TAG"], "method", false, false, false, 613)) {
            // line 614
            echo "                            <div class=\"uv-field-block\">
                                <input class=\"uv-field uv-dropdown-other\" name=\"tag-name\" type=\"text\" data-type=\"tag\" value=\"\">
                                <div class=\"uv-dropdown-list uv-bottom-left\">
                                    <div class=\"uv-dropdown-container\">
                                        <label>";
            // line 618
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Filter With"), "html", null, true);
            echo "</label>
                                        <ul class=\"\">
                                            <span class=\"uv-filter-info\">";
            // line 620
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Type atleast 2 letters"), "html", null, true);
            echo "</span>
                                            <span class=\"uv-no-results\" style=\"display: none;\">";
            // line 621
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("No result found"), "html", null, true);
            echo "</span>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        ";
        }
        // line 627
        echo "                    </div>

                    <div class=\"tag-list\" style=\"margin-top: 10px\"></div>
                </div>
            </div>
        </div>

        <div class=\"uv-view ";
        // line 634
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 634, $this->source); })()), "request", [], "any", false, false, false, 634), "cookies", [], "any", false, false, false, 634) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 634, $this->source); })()), "request", [], "any", false, false, false, 634), "cookies", [], "any", false, false, false, 634), "get", [0 => "uv-asideView"], "method", false, false, false, 634))) {
            echo "uv-aside-view";
        }
        echo "\" >
            <div class=\"uv-ticket-scroll-region ";
        // line 635
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 635, $this->source); })()), "request", [], "any", false, false, false, 635), "cookies", [], "any", false, false, false, 635) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 635, $this->source); })()), "request", [], "any", false, false, false, 635), "cookies", [], "any", false, false, false, 635), "get", [0 => "uv-asideView"], "method", false, false, false, 635))) {
            echo "uv-aside-view-tv";
        }
        echo "\" >
                ";
        // line 637
        echo "                <div class=\"uv-ticket-action-bar\">
                    <div class=\"uv-ticket-action-bar-lt\">
                        <div class=\"uv-header-fix\"><a href=\"#\" class=\"uv-icon-pin\"></a></div>

                        ";
        // line 642
        echo "                        <div class=\"uv-tabs\">
                            <ul>
                                ";
        // line 645
        echo "                                <li for=\"default\" data-type=\"all\" class=\"uv-tab-active\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("All Threads"), "html", null, true);
        echo "</li>
                                <li for=\"default\" data-type=\"reply\">";
        // line 646
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Replies"), "html", null, true);
        echo "</li>
                                <li for=\"default\" data-type=\"forward\">";
        // line 647
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Forwards"), "html", null, true);
        echo "</li>
                                <li for=\"default\" data-type=\"note\">";
        // line 648
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Notes"), "html", null, true);
        echo "</li>
                                <li for=\"default\" data-type=\"pinned\">";
        // line 649
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Pinned"), "html", null, true);
        echo "</li>

                                ";
        // line 652
        echo "                                ";
        if ((twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 652, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_EDIT_TICKET"], "method", false, false, false, 652) || twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 652, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_DELETE_TICKET"], "method", false, false, false, 652))) {
            // line 653
            echo "                                    <li class=\"uv-tab-ellipsis uv-ticket-action\">
                                        <span class=\"uv-icon-ellipsis uv-dropdown-other\"></span>

                                        <div class=\"uv-dropdown-list uv-bottom-right\">
                                            <div class=\"uv-dropdown-container\">
                                                <ul class=\"priority\" data-action=\"priority\">
                                                    ";
            // line 659
            if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 659, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_EDIT_TICKET"], "method", false, false, false, 659)) {
                // line 660
                echo "                                                        <li data-action=\"edit\" class=\"uv-open-popup\" data-target=\"edit-ticket-modal\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit Ticket"), "html", null, true);
                echo "</li>
                                                    ";
            }
            // line 662
            echo "
                                                    <li data-action=\"print\">";
            // line 663
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Print Ticket"), "html", null, true);
            echo "</li>

                                                    ";
            // line 665
            if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 665, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_UPDATE_TICKET_STATUS"], "method", false, false, false, 665)) {
                // line 666
                echo "                                                        <li data-action=\"spam\" data-index=\"6\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Mark as Spam"), "html", null, true);
                echo "</li>
                                                        <li data-action=\"closed\" data-index=\"5\">";
                // line 667
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Mark as Closed"), "html", null, true);
                echo "</li>
                                                    ";
            }
            // line 669
            echo "
                                                    ";
            // line 670
            if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 670, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_DELETE_TICKET"], "method", false, false, false, 670)) {
                // line 671
                echo "                                                        <li data-action=\"delete\" class=\"uv-text-danger\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Delete Ticket"), "html", null, true);
                echo "</li>
                                                    ";
            }
            // line 673
            echo "                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                ";
        }
        // line 678
        echo "                            </ul>
                        </div>
                    </div>

                    <div class=\"uv-ticket-action-bar-rt\">
                        ";
        // line 683
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 683, $this->source); })()), "getRegisteredComponent", [0 => "Webkul\\UVDesk\\CoreFrameworkBundle\\Tickets\\WidgetCollection"], "method", false, false, false, 683), "embedSideFilterIcons", [], "method", false, false, false, 683);
        echo "
                    </div>
                </div>

                ";
        // line 688
        echo "                <div class=\"uv-ticket-viewer-bar\">
                    <div class=\"uv-ticket-viewer-list\">
                        <div class=\"uv-ticket-viewer-single uv-first\" title=\"";
        // line 690
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Currently active agents on ticket"), "html", null, true);
        echo "...\">
                            <span class=\"uv-icon-eye-light\"></span>
                        </div>
                    </div>
                </div>

                ";
        // line 697
        echo "                <div class=\"uv-ticket-head\">
                    <div class=\"uv-ticket-head-lt\">
                        <span class=\"uv-star-large ";
        // line 699
        echo ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 699, $this->source); })()), "isStarred", [], "any", false, false, false, 699)) ? ("uv-star-active") : (""));
        echo " uv-star uv-margin-right-5\"></span>
                    </div>

                    <div class=\"uv-ticket-head-rt\">
                        <h1>";
        // line 703
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 703, $this->source); })()), "subject", [], "any", false, false, false, 703), "html", null, true);
        echo "</h1>
                    </div>
                </div>

                <div class=\"uv-ticket-strip\">
                    <span>
                        <span class=\"uv-ticket-strip-label\">";
        // line 709
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Created"), "html", null, true);
        echo " - </span>
                        <span class=\"timeago uv-margin-0\" data-timestamp=\"";
        // line 710
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 710, $this->source); })()), "createdAt", [], "any", false, false, false, 710), "getTimestamp", [], "method", false, false, false, 710), "html", null, true);
        echo "\" title=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 710, $this->source); })()), "createdAt", [], "any", false, false, false, 710), "format", [0 => "d-m-Y h:ia"], "method", false, false, false, 710), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 710, $this->source); })()), "timeZoneConverter", [0 => twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 710, $this->source); })()), "createdAt", [], "any", false, false, false, 710)], "method", false, false, false, 710), "html", null, true);
        echo "</span>
                    </span>

                    <span>
                        <span class=\"uv-ticket-strip-label\">";
        // line 714
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("By"), "html", null, true);
        echo " - </span> ";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 714, $this->source); })()), "user", [], "any", false, false, false, 714), "name", [], "any", false, false, false, 714), "html", null, true);
        echo "
                        ";
        // line 715
        if ((isset($context["totalCustomerTickets"]) || array_key_exists("totalCustomerTickets", $context) ? $context["totalCustomerTickets"] : (function () { throw new RuntimeError('Variable "totalCustomerTickets" does not exist.', 715, $this->source); })())) {
            // line 716
            echo "                            (<a id=\"more-tickets-btn\" href=\"";
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_ticket_collection");
            echo "#customer/";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 716, $this->source); })()), "id", [], "any", false, false, false, 716), "html", null, true);
            echo "\" target=\"_blank\">";
            echo twig_escape_filter($this->env, (((isset($context["totalCustomerTickets"]) || array_key_exists("totalCustomerTickets", $context) ? $context["totalCustomerTickets"] : (function () { throw new RuntimeError('Variable "totalCustomerTickets" does not exist.', 716, $this->source); })()) - 1) . " more tickets"), "html", null, true);
            echo "</a>)
                        ";
        }
        // line 718
        echo "                    </span>

                    <span class=\"agent-info\" style=\"";
        // line 720
        echo (((isset($context["ticketAgent"]) || array_key_exists("ticketAgent", $context) ? $context["ticketAgent"] : (function () { throw new RuntimeError('Variable "ticketAgent" does not exist.', 720, $this->source); })())) ? ("") : ("display: none"));
        echo "\">
                        <span class=\"uv-ticket-strip-label\">";
        // line 721
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent"), "html", null, true);
        echo " - </span>
                        <span class=\"name\">";
        // line 722
        (((isset($context["ticketAgent"]) || array_key_exists("ticketAgent", $context) ? $context["ticketAgent"] : (function () { throw new RuntimeError('Variable "ticketAgent" does not exist.', 722, $this->source); })())) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticketAgent"]) || array_key_exists("ticketAgent", $context) ? $context["ticketAgent"] : (function () { throw new RuntimeError('Variable "ticketAgent" does not exist.', 722, $this->source); })()), "name", [], "any", false, false, false, 722), "html", null, true))) : (print ("")));
        echo "</span>
                    </span>
                </div>

                ";
        // line 727
        echo "                <div class=\"uv-tab-view uv-tab-view-active\" id=\"default\">
                    <div class=\"uv-ticket-section\">
                        <div class=\"uv-ticket-main create\">
                            <div class=\"uv-ticket-strip\">
                                <span>
                                    <span class=\"timeago uv-margin-0\" data-timestamp=\"";
        // line 732
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 732, $this->source); })()), "createdAt", [], "any", false, false, false, 732), "getTimestamp", [], "method", false, false, false, 732), "html", null, true);
        echo "\" title=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 732, $this->source); })()), "createdAt", [], "any", false, false, false, 732), "format", [0 => "d-m-Y h:ia"], "method", false, false, false, 732), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 732, $this->source); })()), "timeZoneConverter", [0 => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 732, $this->source); })()), "createdAt", [], "any", false, false, false, 732)], "method", false, false, false, 732), "html", null, true);
        echo "</span>
                                    - ";
        // line 733
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 733, $this->source); })()), "user", [], "any", false, false, false, 733), "name", [], "any", false, false, false, 733), "html", null, true);
        echo " <span class=\"uv-ticket-strip-label\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("created Ticket"), "html", null, true);
        echo "</span>
                                </span>
                            </div>

                            <div class=\"uv-ticket-main-lt\">
                                <img src=\"";
        // line 738
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 738, $this->source); })()), "thumbnail", [], "any", false, false, false, 738)) ? (((((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 738, $this->source); })()), "request", [], "any", false, false, false, 738), "scheme", [], "any", false, false, false, 738) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 738, $this->source); })()), "request", [], "any", false, false, false, 738), "httpHost", [], "any", false, false, false, 738)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")) . twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 738, $this->source); })()), "thumbnail", [], "any", false, false, false, 738))) : ($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((isset($context["default_customer_image_path"]) || array_key_exists("default_customer_image_path", $context) ? $context["default_customer_image_path"] : (function () { throw new RuntimeError('Variable "default_customer_image_path" does not exist.', 738, $this->source); })())))), "html", null, true);
        echo "\">
                            </div>

                            <div class=\"uv-ticket-main-rt\">
                                ";
        // line 742
        if ((twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 742, $this->source); })()), "createdBy", [], "any", false, false, false, 742) == "customer")) {
            // line 743
            echo "                                    <a href=\"";
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_manage_customer_account");
            echo "/";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 743, $this->source); })()), "user", [], "any", false, false, false, 743), "id", [], "any", false, false, false, 743), "html", null, true);
            echo "\" class=\"uv-ticket-member-name\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 743, $this->source); })()), "user", [], "any", false, false, false, 743), "name", [], "any", false, false, false, 743), "html", null, true);
            echo "</a>
                                ";
        } else {
            // line 745
            echo "                                    ";
            if (twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 745, $this->source); })()), "user", [], "any", false, false, false, 745)) {
                // line 746
                echo "                                        <a href=\"";
                echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_account");
                echo "/";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 746, $this->source); })()), "user", [], "any", false, false, false, 746), "id", [], "any", false, false, false, 746), "html", null, true);
                echo "\" class=\"uv-ticket-member-name\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 746, $this->source); })()), "user", [], "any", false, false, false, 746), "name", [], "any", false, false, false, 746), "html", null, true);
                echo "</a>
                                    ";
            } else {
                // line 748
                echo "                                        <a class=\"uv-ticket-member-name\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 748, $this->source); })()), "user", [], "any", false, false, false, 748), "name", [], "any", false, false, false, 748), "html", null, true);
                echo "</a>
                                    ";
            }
            // line 750
            echo "                                ";
        }
        // line 751
        echo "
                                ";
        // line 753
        echo "                                <div class=\"message\">
                                    <p>
                                        ";
        // line 755
        if ((strip_tags(twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 755, $this->source); })()), "message", [], "any", false, false, false, 755)) == twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 755, $this->source); })()), "message", [], "any", false, false, false, 755))) {
            // line 756
            echo "                                            ";
            echo nl2br(twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 756, $this->source); })()), "message", [], "any", false, false, false, 756), "html", null, true));
            echo "
                                        ";
        } else {
            // line 758
            echo "                                            ";
            echo twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 758, $this->source); })()), "message", [], "any", false, false, false, 758);
            echo "
                                        ";
        }
        // line 760
        echo "                                    </p>
                                </div>

                                ";
        // line 764
        echo "                                ";
        if (twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 764, $this->source); })()), "attachments", [], "any", false, false, false, 764))) {
            // line 765
            echo "                                    <div class=\"uv-ticket-uploads\">
                                        <h4>";
            // line 766
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Uploaded Files"), "html", null, true);
            echo "</h4>
                                        <div class=\"uv-ticket-uploads-strip\">
                                            ";
            // line 768
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 768, $this->source); })()), "attachments", [], "any", false, false, false, 768));
            foreach ($context['_seq'] as $context["_key"] => $context["attachment"]) {
                // line 769
                echo "                                                <a href=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["attachment"], "downloadURL", [], "any", false, false, false, 769), "html", null, true);
                echo "\" target = \"_blank\" class=\"uv-ticket-uploads-brick uv-no-pointer-events\" data-toggle=\"tooltip\" title=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["attachment"], "name", [], "any", false, false, false, 769), "html", null, true);
                echo "\">
                                                    <img src=\"";
                // line 770
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["attachment"], "iconURL", [], "any", false, false, false, 770), "html", null, true);
                echo "\"  class=\"uv-auto-pointer-events\"/>
                                                </a>
                                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attachment'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 773
            echo "                                        </div>

                                        ";
            // line 775
            if ((twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 775, $this->source); })()), "attachments", [], "any", false, false, false, 775)) > 1)) {
                // line 776
                echo "                                            <div class=\"uv-upload-actions\">
                                                <a href=\"#\" class=\"uv-open-in-files\" data-thread=\"";
                // line 777
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 777, $this->source); })()), "id", [], "any", false, false, false, 777), "html", null, true);
                echo "\" style=\"display: none\"><span class=\"uv-icon-open-in-files\"></span>";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Open in Files"), "html", null, true);
                echo "</a>
                                                ";
                // line 778
                if (twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 778, $this->source); })()), "attachments", [], "any", false, false, false, 778))) {
                    // line 779
                    echo "                                                    <a href=\"";
                    echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_ticket_download_attachment_zip");
                    echo "/";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 779, $this->source); })()), "id", [], "any", false, false, false, 779), "html", null, true);
                    echo "\" target=\"_blank\"><span class=\"uv-icon-attachment\"></span>";
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(" Download (as .zip)"), "html", null, true);
                    echo "</a>
                                                ";
                }
                // line 781
                echo "                                            </div>
                                        ";
            }
            // line 783
            echo "                                    </div>
                                ";
        }
        // line 785
        echo "                            </div>
                        </div>

                        <div class=\"uv-ticket-accordion\">
                            <div class=\"uv-ticket-count-wrapper\">
                                <span class=\"uv-ticket-count-stat\">";
        // line 790
        echo twig_escape_filter($this->env, (isset($context["totalReplies"]) || array_key_exists("totalReplies", $context) ? $context["totalReplies"] : (function () { throw new RuntimeError('Variable "totalReplies" does not exist.', 790, $this->source); })()), "html", null, true);
        echo "</span>
                            </div>

                            <div class=\"uv-ticket-wrapper thread-list\"></div>
                        </div>
                    </div>
                </div>

                ";
        // line 799
        echo "                <div class=\"uv-ticket-main uv-ticket-reply uv-no-error-success-icon\">
                    <div class=\"uv-ticket-main-lt\">
                        <span class=\"uv-icon-ellipsis\"></span>
                        <img src=\"";
        // line 802
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["currentUserDetails"]) || array_key_exists("currentUserDetails", $context) ? $context["currentUserDetails"] : (function () { throw new RuntimeError('Variable "currentUserDetails" does not exist.', 802, $this->source); })()), "thumbnail", [], "any", false, false, false, 802)) ? (((((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 802, $this->source); })()), "request", [], "any", false, false, false, 802), "scheme", [], "any", false, false, false, 802) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 802, $this->source); })()), "request", [], "any", false, false, false, 802), "httpHost", [], "any", false, false, false, 802)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")) . twig_get_attribute($this->env, $this->source, (isset($context["currentUserDetails"]) || array_key_exists("currentUserDetails", $context) ? $context["currentUserDetails"] : (function () { throw new RuntimeError('Variable "currentUserDetails" does not exist.', 802, $this->source); })()), "thumbnail", [], "any", false, false, false, 802))) : ($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((isset($context["default_agent_image_path"]) || array_key_exists("default_agent_image_path", $context) ? $context["default_agent_image_path"] : (function () { throw new RuntimeError('Variable "default_agent_image_path" does not exist.', 802, $this->source); })())))), "html", null, true);
        echo "\" />
                    </div>

                    <div class=\"uv-ticket-main-rt\">
                        <span class=\"uv-ticket-member-name\">";
        // line 806
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["currentUserDetails"]) || array_key_exists("currentUserDetails", $context) ? $context["currentUserDetails"] : (function () { throw new RuntimeError('Variable "currentUserDetails" does not exist.', 806, $this->source); })()), "name", [], "any", false, false, false, 806), "html", null, true);
        echo "</span>
                        <div class=\"uv-tabs\">
                            <ul>
                                <li for=\"reply\" class=\"uv-tab-active\">";
        // line 809
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Reply"), "html", null, true);
        echo "</li>
                                <li for=\"forward\">";
        // line 810
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Forward"), "html", null, true);
        echo "</li>
                                ";
        // line 811
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 811, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_ADD_NOTE"], "method", false, false, false, 811)) {
            // line 812
            echo "                                    <li for='note'>";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Note"), "html", null, true);
            echo "</li>
                                ";
        }
        // line 814
        echo "                            </ul>
                        </div>

                        ";
        // line 818
        echo "                        <div class=\"uv-tab-view uv-tab-view-active\" id=\"reply\">
                            <form enctype=\"multipart/form-data\" method=\"post\" action=\"";
        // line 819
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_add_ticket_thread", ["ticketId" => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 819, $this->source); })()), "id", [], "any", false, false, false, 819)]), "html", null, true);
        echo "\">
                                <input name=\"threadType\" value=\"reply\" type=\"hidden\">
                                <input name=\"status\" value=\"\" type=\"hidden\" ";
        // line 821
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 821, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_UPDATE_TICKET_STATUS"], "method", false, false, false, 821)) {
            echo "class=\"reply-status\"";
        }
        echo ">
                                <div class=\"uv-element-block collaborators\" style=\"display: none\">
                                    <label class=\"uv-field-label\">";
        // line 823
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Collaborators"), "html", null, true);
        echo "</label>
                                    <div class=\"uv-field-block\"></div>
                                </div>

                                <div class=\"uv-element-block cc-bcc\">
                                    <label>
                                        <div class=\"uv-checkbox\">
                                            <input type=\"checkbox\" class=\"cc-bcc-toggle\">
                                            <span class=\"uv-checkbox-view\"></span>
                                        </div>
                                        <span class=\"uv-checkbox-label\">";
        // line 833
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("CC/BCC"), "html", null, true);
        echo "</span>
                                    </label>

                                    <div class=\"uv-field-block\" style=\"display: none\">
                                        <div class=\"uv-group\">
                                            <input class=\"uv-group-field uv-dropdown-other preloaded uv-manual-enter\" type=\"text\">
                                            <div class=\"uv-dropdown-list uv-bottom-left\">
                                                <div class=\"uv-dropdown-container\">
                                                    <label>";
        // line 841
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent"), "html", null, true);
        echo "</label>
                                                </div>

                                                <ul class=\"uv-agents-list\">
                                                    ";
        // line 845
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 845, $this->source); })()), "getAgentPartialDataCollection", [], "any", false, false, false, 845));
        foreach ($context['_seq'] as $context["_key"] => $context["agent"]) {
            // line 846
            echo "                                                        <li data-id=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["agent"], "email", [], "any", false, false, false, 846), "html", null, true);
            echo "\">
                                                            <img src=\"";
            // line 847
            echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, $context["agent"], "smallThumbnail", [], "any", false, false, false, 847)) ? (((((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 847, $this->source); })()), "request", [], "any", false, false, false, 847), "scheme", [], "any", false, false, false, 847) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 847, $this->source); })()), "request", [], "any", false, false, false, 847), "httpHost", [], "any", false, false, false, 847)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")) . twig_get_attribute($this->env, $this->source, $context["agent"], "smallThumbnail", [], "any", false, false, false, 847))) : ($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((isset($context["default_agent_image_path"]) || array_key_exists("default_agent_image_path", $context) ? $context["default_agent_image_path"] : (function () { throw new RuntimeError('Variable "default_agent_image_path" does not exist.', 847, $this->source); })())))), "html", null, true);
            echo "\"/> ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["agent"], "name", [], "any", false, false, false, 847), "html", null, true);
            echo "
                                                        </li>
                                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['agent'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 850
        echo "
                                                    <li class=\"uv-no-results\" style=\"display: none;\">";
        // line 851
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("No result found"), "html", null, true);
        echo "</li>
                                                </ul>
                                            </div>
                                            <select class=\"uv-group-select cc-bcc-select\">
                                                <option value=\"bcc\">";
        // line 855
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("BCC"), "html", null, true);
        echo "</option>
                                                <option value=\"cc\">";
        // line 856
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("CC"), "html", null, true);
        echo "</option>
                                            </select>
                                        </div>

                                        <div class=\"cc-bcc-list\"></div>
                                    </div>
                                </div>

                                <div class=\"uv-element-block uv-element-block-textarea\">
                                    <label class=\"uv-field-label\">";
        // line 865
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Write a reply"), "html", null, true);
        echo "</label>
                                    <div class=\"uv-field-block\">
                                        <textarea class=\"uv-field\" name=\"reply\" id=\"reply-area\">";
        // line 867
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 867, $this->source); })()), "getAgentDraftReply", [], "method", false, false, false, 867), "html", null, true);
        echo "</textarea>
                                    </div>
                                </div>

                                <div class=\"uv-element-block attachment-block\">
                                    <label>
                                        <span class=\"uv-file-label\">";
        // line 873
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Attachment"), "html", null, true);
        echo "</span>
                                    </label>
                                </div>

                                <div class=\"uv-action-buttons\">
                                    <div class=\"uv-dropdown next-view\">
                                        <input type=\"hidden\" name=\"nextView\" value=\"stay\"/>
                                        <div class=\"uv-dropdown-btn\" style=\"padding: 9px 27px 9px 10px;\">";
        // line 880
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Stay on ticket"), "html", null, true);
        echo "</div>
                                        <div class=\"uv-dropdown-list uv-top-left\" style=\"opacity: 1;\">
                                            <div class=\"uv-dropdown-container\">
                                                <label>";
        // line 883
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("After Reply"), "html", null, true);
        echo "</label>
                                                <ul>
                                                    <li data-value=\"stay\">";
        // line 885
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Stay on ticket"), "html", null, true);
        echo "</li>
                                                    <li data-value=\"redirect\">";
        // line 886
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Redirect to list"), "html", null, true);
        echo "</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=\"uv-dropdown reply\">
                                        <div class=\"uv-btn uv-dropdown-other\">";
        // line 893
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Reply"), "html", null, true);
        echo " <span class=\"uv-icon-down-light\"></span></div>
                                        <div class=\"uv-dropdown-list uv-top-left\">
                                            <div class=\"uv-dropdown-container\">
                                                <label>";
        // line 896
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Reply"), "html", null, true);
        echo "</label>
                                                <ul>
                                                    <li data-id=\"\">";
        // line 898
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Submit"), "html", null, true);
        echo "</li>
                                                    ";
        // line 899
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 899, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_UPDATE_TICKET_STATUS"], "method", false, false, false, 899)) {
            // line 900
            echo "                                                        <li data-id=\"open\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Submit And Open"), "html", null, true);
            echo "</li>
                                                        <li data-id=\"pending\">";
            // line 901
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Submit And Pending"), "html", null, true);
            echo "</li>
                                                        <li data-id=\"answered\">";
            // line 902
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Submit And Answered"), "html", null, true);
            echo "</li>
                                                        <li data-id=\"resolved\">";
            // line 903
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Submit And Resolved"), "html", null, true);
            echo "</li>
                                                        <li data-id=\"closed\">";
            // line 904
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Submit And Closed"), "html", null, true);
            echo "</li>
                                                    ";
        }
        // line 906
        echo "                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        ";
        // line 915
        echo "                        <div class=\"uv-tab-view\" id=\"forward\">
                            <form enctype=\"multipart/form-data\" method=\"post\" action=\"";
        // line 916
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_add_ticket_thread", ["ticketId" => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 916, $this->source); })()), "id", [], "any", false, false, false, 916)]), "html", null, true);
        echo "\">
                                <input name=\"threadType\" value=\"forward\" type=\"hidden\">
                                <input name=\"status\" value=\"\" type=\"hidden\" ";
        // line 918
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 918, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_UPDATE_TICKET_STATUS"], "method", false, false, false, 918)) {
            echo "class=\"reply-status\"";
        }
        echo ">

                                <div class=\"uv-element-block\">
                                    <label class=\"uv-field-label\">";
        // line 921
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Subject"), "html", null, true);
        echo "</label>
                                    <div class=\"uv-field-block\">
                                        <input class=\"uv-field\" type=\"text\" name=\"subject\">
                                    </div>
                                </div>

                                <div class=\"uv-element-block to\">
                                    <label class=\"uv-field-label\">";
        // line 928
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("To"), "html", null, true);
        echo "</label>
                                    <div class=\"uv-field-block\">
                                        <input class=\"uv-field uv-dropdown-other preloaded uv-to-message uv-manual-enter\" type=\"text\">
                                        
                                        <div class=\"uv-dropdown-list uv-bottom-left\">
                                            <div class=\"uv-dropdown-container\">
                                                <label>";
        // line 934
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent"), "html", null, true);
        echo "</label>
                                            </div>

                                            <ul class=\"uv-agents-list\">
                                                ";
        // line 938
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 938, $this->source); })()), "getAgentPartialDataCollection", [], "any", false, false, false, 938));
        foreach ($context['_seq'] as $context["_key"] => $context["agent"]) {
            // line 939
            echo "                                                    <li data-id=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["agent"], "email", [], "any", false, false, false, 939), "html", null, true);
            echo "\">
                                                        <img src=\"";
            // line 940
            echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, $context["agent"], "smallThumbnail", [], "any", false, false, false, 940)) ? (((((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 940, $this->source); })()), "request", [], "any", false, false, false, 940), "scheme", [], "any", false, false, false, 940) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 940, $this->source); })()), "request", [], "any", false, false, false, 940), "httpHost", [], "any", false, false, false, 940)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")) . twig_get_attribute($this->env, $this->source, $context["agent"], "smallThumbnail", [], "any", false, false, false, 940))) : ($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((isset($context["default_agent_image_path"]) || array_key_exists("default_agent_image_path", $context) ? $context["default_agent_image_path"] : (function () { throw new RuntimeError('Variable "default_agent_image_path" does not exist.', 940, $this->source); })())))), "html", null, true);
            echo "\"/> ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["agent"], "name", [], "any", false, false, false, 940), "html", null, true);
            echo "
                                                    </li>
                                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['agent'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 943
        echo "
                                                <li class=\"uv-no-results\" style=\"display: none;\">";
        // line 944
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("No result found"), "html", null, true);
        echo "</li>
                                            </ul>
                                        </div>

                                        <div class=\"to-list\"></div>
                                    </div>
                                </div>

                                <div class=\"uv-element-block cc-bcc\">
                                    <label>
                                        <div class=\"uv-checkbox\">
                                            <input type=\"checkbox\" class=\"cc-bcc-toggle\">
                                            <span class=\"uv-checkbox-view\"></span>
                                        </div>
                                        <span class=\"uv-checkbox-label\">";
        // line 958
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("CC/BCC"), "html", null, true);
        echo "</span>
                                    </label>
                                    <div class=\"uv-field-block\" style=\"display: none\">
                                        <div class=\"uv-group\">
                                            <input class=\"uv-group-field uv-dropdown-other preloaded uv-manual-enter\" type=\"text\">
                                            <div class=\"uv-dropdown-list uv-bottom-left\">
                                                <div class=\"uv-dropdown-container\"><label>";
        // line 964
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent"), "html", null, true);
        echo "</label></div>

                                                <ul class=\"uv-agents-list\">
                                                    ";
        // line 967
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 967, $this->source); })()), "getAgentPartialDataCollection", [], "any", false, false, false, 967));
        foreach ($context['_seq'] as $context["_key"] => $context["agent"]) {
            // line 968
            echo "                                                        <li data-id=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["agent"], "email", [], "any", false, false, false, 968), "html", null, true);
            echo "\">
                                                            <img src=\"";
            // line 969
            echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, $context["agent"], "smallThumbnail", [], "any", false, false, false, 969)) ? (((((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 969, $this->source); })()), "request", [], "any", false, false, false, 969), "scheme", [], "any", false, false, false, 969) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 969, $this->source); })()), "request", [], "any", false, false, false, 969), "httpHost", [], "any", false, false, false, 969)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")) . twig_get_attribute($this->env, $this->source, $context["agent"], "smallThumbnail", [], "any", false, false, false, 969))) : ($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((isset($context["default_agent_image_path"]) || array_key_exists("default_agent_image_path", $context) ? $context["default_agent_image_path"] : (function () { throw new RuntimeError('Variable "default_agent_image_path" does not exist.', 969, $this->source); })())))), "html", null, true);
            echo "\"/> ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["agent"], "name", [], "any", false, false, false, 969), "html", null, true);
            echo "
                                                        </li>
                                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['agent'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 972
        echo "
                                                    <li class=\"uv-no-results\" style=\"display: none;\">";
        // line 973
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("No result found"), "html", null, true);
        echo "</li>
                                                </ul>
                                            </div>
                                            <select class=\"uv-group-select cc-bcc-select\">
                                                <option value=\"bcc\">";
        // line 977
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("BCC"), "html", null, true);
        echo "</option>
                                                <option value=\"cc\">";
        // line 978
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("CC"), "html", null, true);
        echo "</option>
                                            </select>
                                        </div>

                                        <div class=\"cc-bcc-list\"></div>
                                    </div>
                                </div>

                                <div class=\"uv-element-block uv-element-block-textarea\">
                                    <label class=\"uv-field-label\">";
        // line 987
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Write a reply"), "html", null, true);
        echo "</label>
                                    <div class=\"uv-field-block\">
                                        <textarea class=\"uv-field\" name=\"reply\" id=\"forward-area\">";
        // line 989
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 989, $this->source); })()), "getAgentDraftReply", [], "method", false, false, false, 989), "html", null, true);
        echo "</textarea>
                                    </div>
                                </div>

                                <div class=\"uv-element-block attachment-block\">
                                    <label><span class=\"uv-file-label\">";
        // line 994
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Attachment"), "html", null, true);
        echo "</span></label>
                                </div>

                                <div class=\"uv-action-buttons\">
                                    <div class=\"uv-dropdown next-view\">
                                        <input type=\"hidden\" name=\"nextView\" value=\"stay\"/>
                                        <div class=\"uv-dropdown-btn\" style=\"padding: 9px 27px 9px 10px;\">";
        // line 1000
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Stay on ticket"), "html", null, true);
        echo "</div>
                                        <div class=\"uv-dropdown-list uv-top-left\" style=\"opacity: 1;\">
                                            <div class=\"uv-dropdown-container\">
                                                <label>";
        // line 1003
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("After Reply"), "html", null, true);
        echo "</label>
                                                <ul>
                                                    <li data-value=\"stay\">";
        // line 1005
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Stay on ticket"), "html", null, true);
        echo "</li>
                                                    <li data-value=\"redirect\">";
        // line 1006
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Redirect to list"), "html", null, true);
        echo "</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=\"uv-btn forward\">";
        // line 1012
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Forward"), "html", null, true);
        echo "</div>
                                </div>
                            </form>
                        </div>

                        ";
        // line 1018
        echo "                        ";
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 1018, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_ADD_NOTE"], "method", false, false, false, 1018)) {
            // line 1019
            echo "                            <div class=\"uv-tab-view\" id=\"note\">
                                <form enctype=\"multipart/form-data\" method=\"post\" action=\"";
            // line 1020
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_add_ticket_thread", ["ticketId" => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 1020, $this->source); })()), "id", [], "any", false, false, false, 1020)]), "html", null, true);
            echo "\">
                                    <input name=\"threadType\" value=\"note\" type=\"hidden\">
                                    <input name=\"status\" value=\"\" type=\"hidden\" ";
            // line 1022
            if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 1022, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_UPDATE_TICKET_STATUS"], "method", false, false, false, 1022)) {
                echo "class=\"reply-status\"";
            }
            echo ">

                                    <div class=\"uv-element-block uv-element-block-textarea\">
                                        <label class=\"uv-field-label\">";
            // line 1025
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Write a reply"), "html", null, true);
            echo "</label>
                                        <div class=\"uv-field-block\">
                                            <textarea class=\"uv-field\" name=\"reply\" id=\"note-area\">";
            // line 1027
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 1027, $this->source); })()), "getAgentDraftReply", [], "method", false, false, false, 1027), "html", null, true);
            echo "</textarea>
                                        </div>
                                    </div>

                                    <div class=\"uv-element-block attachment-block\">
                                        <label><span class=\"uv-file-label\">";
            // line 1032
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Attachment"), "html", null, true);
            echo "</span></label>
                                    </div>

                                    <div class=\"uv-action-buttons\">
                                        <div class=\"uv-dropdown next-view\">
                                            <input type=\"hidden\" name=\"nextView\" value=\"stay\"/>
                                            <div class=\"uv-dropdown-btn\" style=\"padding: 9px 27px 9px 10px;\">";
            // line 1038
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Stay on ticket"), "html", null, true);
            echo "</div>
                                            <div class=\"uv-dropdown-list uv-top-left\" style=\"opacity: 1;\">
                                                <div class=\"uv-dropdown-container\">
                                                    <label>";
            // line 1041
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("After Reply"), "html", null, true);
            echo "</label>
                                                    <ul>
                                                        <li data-value=\"stay\">";
            // line 1043
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Stay on ticket"), "html", null, true);
            echo "</li>
                                                        <li data-value=\"redirect\">";
            // line 1044
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Redirect to list"), "html", null, true);
            echo "</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class=\"uv-dropdown reply\">
                                            <div class=\"uv-btn uv-dropdown-other\">";
            // line 1051
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Reply"), "html", null, true);
            echo " <span class=\"uv-icon-down-light\"></span></div>

                                            <div class=\"uv-dropdown-list uv-top-left\">
                                                <div class=\"uv-dropdown-container\">
                                                    <label>";
            // line 1055
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Add Note"), "html", null, true);
            echo "</label>
                                                    <ul>
                                                        <li data-id=\"\">";
            // line 1057
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Submit"), "html", null, true);
            echo "</li>
                                                        ";
            // line 1058
            if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 1058, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_UPDATE_TICKET_STATUS"], "method", false, false, false, 1058)) {
                // line 1059
                echo "                                                            <li data-id=\"open\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Submit And Open"), "html", null, true);
                echo "</li>
                                                            <li data-id=\"pending\">";
                // line 1060
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Submit And Pending"), "html", null, true);
                echo "</li>
                                                            <li data-id=\"answered\">";
                // line 1061
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Submit And Answered"), "html", null, true);
                echo "</li>
                                                            <li data-id=\"resolved\">";
                // line 1062
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Submit And Resolved"), "html", null, true);
                echo "</li>
                                                            <li data-id=\"closed\">";
                // line 1063
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Submit And Closed"), "html", null, true);
                echo "</li>
                                                        ";
            }
            // line 1065
            echo "                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        ";
        }
        // line 1073
        echo "                    </div>
                </div>
            </div>

            <!-- Bottom Action Block -->
            <div class=\"uv-ticket-fixed-region\">
                <div class=\"uv-ticket-fixed-region-lt\">
                    ";
        // line 1080
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 1080, $this->source); })()), "getRegisteredComponent", [0 => "Webkul\\UVDesk\\CoreFrameworkBundle\\Tickets\\QuickActionButtonCollection"], "method", false, false, false, 1080), "injectTemplates", [], "method", false, false, false, 1080);
        echo "

                    ";
        // line 1102
        echo "
                    ";
        // line 1126
        echo "                </div>

                <div class=\"uv-ticket-fixed-region-rt\"></div>
            </div>
            <!-- //Bottom Action Block -->
        </div>
    </div>

    ";
        // line 1135
        echo "    ";
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 1135, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_EDIT_TICKET"], "method", false, false, false, 1135)) {
            // line 1136
            echo "        <div class=\"uv-pop-up-overlay uv-no-error-success-icon\" id=\"edit-ticket-modal\">
            <div class=\"uv-pop-up-box uv-pop-up-wide\">
                <span class=\"uv-pop-up-close\"></span>
                <h2>Edit Ticket</h2>

                ";
            // line 1142
            echo "                <form method=\"post\" action=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_update_ticket_details_xhr", ["ticketId" => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 1142, $this->source); })()), "id", [], "any", false, false, false, 1142)]), "html", null, true);
            echo "\" id=\"edit-ticket-form\">
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">Subject</label>
                        <div class=\"uv-field-block\">
                            <input type=\"text\" name=\"subject\" class=\"uv-field\" value=\"";
            // line 1146
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 1146, $this->source); })()), "subject", [], "any", false, false, false, 1146), "html", null, true);
            echo "\" />
                        </div>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">";
            // line 1151
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Reply"), "html", null, true);
            echo "</label>
                        <div class=\"uv-field-block\">
                            <textarea name=\"reply\" id=\"uv-edit-create-thread\" class=\"uv-field\">";
            // line 1153
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["initialThread"]) || array_key_exists("initialThread", $context) ? $context["initialThread"] : (function () { throw new RuntimeError('Variable "initialThread" does not exist.', 1153, $this->source); })()), "message", [], "any", false, false, false, 1153), "html", null, true);
            echo "</textarea>
                        </div>
                    </div>

                    <div class=\"uv-pop-up-actions\">
                        <input class=\"uv-btn update\" href=\"#\" value=\"Update\" type=\"submit\">
                        <input class=\"uv-btn cancel\" href=\"#\" value=\"Discard\" type=\"button\">
                    </div>
                </form>
            </div>
        </div>
    ";
        }
        // line 1165
        echo "
    ";
        // line 1166
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 1166, $this->source); })()), "getRegisteredComponent", [0 => "Webkul\\UVDesk\\CoreFrameworkBundle\\Tickets\\WidgetCollection"], "method", false, false, false, 1166), "embedSideFilterContent", [], "method", false, false, false, 1166);
        echo "
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 1169
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "footer"));

        // line 1170
        echo "    ";
        $this->displayParentBlock("footer", $context, $blocks);
        echo "

    ";
        // line 1172
        echo twig_include($this->env, $context, "@UVDeskCoreFramework\\Templates\\attachment.html.twig");
        echo "
    ";
        // line 1173
        echo twig_include($this->env, $context, "@UVDeskCoreFramework/Templates/tinyMCE.html.twig");
        echo "

    <script id=\"thread_list_empty_tmp\" type=\"text/template\">
        <div class=\"uv-no-threads\">";
        // line 1176
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Nothing interesting here"), "html", null, true);
        echo "...</div>
    </script>

    <script id=\"thread_list_item_tmp\" type=\"text/template\">
        <div class=\"uv-ticket-strip\">
            <span>
                <% if(typeof(mailStatus) != 'undefined' && mailStatus) { %>
                    <a href=\"https://support.uvdesk.com/en/blog/uvdesk-ticket-delivery-status\" target=\"_blank\">
                        <span class=\"uv-mail-status uv-mail-<%- mailStatus.split(',')[0] %>\" <% if(mailStatus !== 'pending') { %>data-toggle=\"tooltip\" data-placement=\"right\" title=\"";
        // line 1184
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Mail status:"), "html", null, true);
        echo " <%- mailStatus.split(',')[0] %> <% if(mailStatus.split(',').length > 1) { print('Reason:' + mailStatus.split(',')[1] ); } %> \"<% } %> ></span>
                    </a>
                <% } %>
                <span class=\"timeago uv-margin-0\" data-timestamp=\"<%- timestamp %>\" title=\"<%- formatedCreatedAt %>\">
                    <%- formatedCreatedAt %>
                </span>
                - <%- fullname %>
                <span class=\"uv-ticket-strip-label\">
                <% if(threadType == 'reply') { %>
                    ";
        // line 1193
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("replied"), "html", null, true);
        echo "
                <% } else if(threadType == 'note') { %>
                    ";
        // line 1195
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("added note"), "html", null, true);
        echo "
                <% } else if(threadType == 'forward') { %>
                    ";
        // line 1197
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("forwarded"), "html", null, true);
        echo "
                <% } %>
                - <a href=\"#thread/<%- id %>\" id=\"thread<%- id %>\" class=\"copy-thread-link\">#<%- id %></a>
                </span>
            </span>

            <% if((replyTo && threadType ==  'forward') || cc || bcc) { %>
                <div class=\"uv-ticket-strip\">
                    <% if(replyTo && threadType ==  'forward') { %>
                    <span><span class=\"uv-ticket-strip-label\">";
        // line 1206
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("TO"), "html", null, true);
        echo " -</span> <%- replyTo %></span>
                    <% } if(cc) { %>
                        <span><span class=\"uv-ticket-strip-label\">";
        // line 1208
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("CC"), "html", null, true);
        echo " -</span> <%- cc %></span>
                    <% } if(bcc) { %>
                        <span><span class=\"uv-ticket-strip-label\">";
        // line 1210
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("BCC"), "html", null, true);
        echo " -</span> <%- bcc %></span>
                    <% } %>
                </div>
            <% } %>
        </div>

        <div class=\"uv-ticket-strip uv-margin-top-5\" <% if(!bookmark && !isLocked) { %>style=\"display: none\"<% } %> >
            <span <% if(!bookmark) { %>style=\"display: none\"<% } %> >
                <span class=\"uv-icon-pinned\"></span>
                ";
        // line 1219
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Pinned"), "html", null, true);
        echo "
            </span>
            <span <% if(!isLocked) { %>style=\"display: none\"<% } %> >
                <span class=\"uv-icon-locked\"></span>
                ";
        // line 1223
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Locked"), "html", null, true);
        echo "
            </span>
        </div>
        <div class=\"uv-ticket-main-lt\">
            <span class=\"uv-thread-action\">
                <span class=\"uv-icon-ellipsis uv-dropdown-other\"></span>
                <div class=\"uv-dropdown-list uv-bottom-left\">
                    <div class=\"uv-dropdown-container\">
                        <ul>
                            ";
        // line 1232
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 1232, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_EDIT_THREAD_NOTE"], "method", false, false, false, 1232)) {
            // line 1233
            echo "                                <% if(userType != 'system') { %>
                                    <li data-action=\"edit\">";
            // line 1234
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Edit Thread"), "html", null, true);
            echo "</li>
                                <% } %>
                            ";
        }
        // line 1237
        echo "                            ";
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 1237, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_DELETE_THREAD_NOTE"], "method", false, false, false, 1237)) {
            // line 1238
            echo "                                <li data-action=\"delete\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Delete Thread"), "html", null, true);
            echo "</li>
                            ";
        }
        // line 1240
        echo "                            <li data-action=\"forward\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Forward"), "html", null, true);
        echo "</li>
                            <% if(bookmark) { %>
                                <li data-action=\"pin\" data-id=\"1\">";
        // line 1242
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Unpin Thread"), "html", null, true);
        echo "</li>
                            <% } else { %>
                                <li data-action=\"pin\" data-id=\"0\">";
        // line 1244
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Pin Thread"), "html", null, true);
        echo "</li>
                            <% } %>
                            <% if(threadType != 'note') { %>
                                ";
        // line 1247
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 1247, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_MANAGE_LOCK_AND_UNLOCK_THREAD"], "method", false, false, false, 1247)) {
            // line 1248
            echo "                                    <% if(isLocked) { %>
                                        <li data-action=\"lock\" data-id=\"1\">";
            // line 1249
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Unlock Thread"), "html", null, true);
            echo "</li>
                                    <% } else { %>
                                        <li data-action=\"lock\" data-id=\"0\">";
            // line 1251
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Lock Thread"), "html", null, true);
            echo "</li>
                                    <% } %>
                                ";
        }
        // line 1254
        echo "                            <% } %>
                            <li style=\"display: none;\" data-action=\"translate\">";
        // line 1255
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Translate Thread"), "html", null, true);
        echo "</li>
                        </ul>
                    </div>
                </div>
            </span>
            <span class=\"p-relative\">
                <div class=\"uv-dropdown-list uv-bottom-left uv-translate-list\" style=\"display: none\">
                    <div class=\"uv-dropdown-container\">
                        <ul class=\"uv-lang-list language\" data-action=\"language\">
                            <label>";
        // line 1264
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Language"), "html", null, true);
        echo "</label>
                            ";
        // line 1265
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_service"]) || array_key_exists("uvdesk_service", $context) ? $context["uvdesk_service"] : (function () { throw new RuntimeError('Variable "uvdesk_service" does not exist.', 1265, $this->source); })()), "getLocales", [], "method", false, false, false, 1265));
        foreach ($context['_seq'] as $context["localeCode"] => $context["localeName"]) {
            // line 1266
            echo "                                <li data-value=\"";
            echo twig_escape_filter($this->env, $context["localeCode"], "html", null, true);
            echo "\">
                                    <img class=\"locale-image\" src='";
            // line 1267
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((("bundles/uvdeskcoreframework/images/country-flags/" . twig_replace_filter(twig_lower_filter($this->env, $context["localeCode"]), [" " => "-"])) . ".png")), "html", null, true);
            echo "' alt=\"";
            echo twig_escape_filter($this->env, $context["localeCode"], "html", null, true);
            echo "\" width=\"24px\">
                                    <span>";
            // line 1268
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans($context["localeName"]), "html", null, true);
            echo "</span>
                                </li>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['localeCode'], $context['localeName'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 1271
        echo "                        </ul>
                    </div>
                </div>
            </span>
            <% if(userType != 'system') { %>
                <% if(user && user.smallThumbnail != null) { %>
                    <img src=\"";
        // line 1277
        echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 1277, $this->source); })()), "request", [], "any", false, false, false, 1277), "scheme", [], "any", false, false, false, 1277) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 1277, $this->source); })()), "request", [], "any", false, false, false, 1277), "httpHost", [], "any", false, false, false, 1277)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")), "html", null, true);
        echo "<%- user.smallThumbnail %>\" />
                <% } else { %>
                    <img src=\"<% if(userType == 'agent') { %> ";
        // line 1279
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((isset($context["default_agent_image_path"]) || array_key_exists("default_agent_image_path", $context) ? $context["default_agent_image_path"] : (function () { throw new RuntimeError('Variable "default_agent_image_path" does not exist.', 1279, $this->source); })())), "html", null, true);
        echo " <% } else { %> ";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((isset($context["default_customer_image_path"]) || array_key_exists("default_customer_image_path", $context) ? $context["default_customer_image_path"] : (function () { throw new RuntimeError('Variable "default_customer_image_path" does not exist.', 1279, $this->source); })())), "html", null, true);
        echo " <% } %>\" />
                <% } %>
            <% } else { %>
                <img src=\"";
        // line 1282
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl((isset($context["default_helpdesk_image_path"]) || array_key_exists("default_helpdesk_image_path", $context) ? $context["default_helpdesk_image_path"] : (function () { throw new RuntimeError('Variable "default_helpdesk_image_path" does not exist.', 1282, $this->source); })())), "html", null, true);
        echo "\" />
            <% } %>
        </div>
        <div class=\"uv-ticket-main-rt\">
            <% if(userType == 'customer') { %>
                <a <% if(user) { %>href=\"";
        // line 1287
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_manage_customer_account");
        echo "/<%- user.id %>\"<% } %> class=\"uv-ticket-member-name\">
                    <%- fullname %>
                </a>
            <% } else if(userType == 'agent') { %>
                <a <% if(user) { %>href=\"";
        // line 1291
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_account");
        echo "/<%- user.id %>\"<% } %> class=\"uv-ticket-member-name\">
                    <%- fullname %>
                </a>
            <% } else { %>
                <span class=\"uv-ticket-member-name\">
                    ";
        // line 1296
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("System"), "html", null, true);
        echo "
                </span>
            <% } %>

            <!-- Message Block -->
            <div class=\"message\">
                <%= reply %>
            </div>

            <!-- Attachment Block -->
            <% if(attachments.length) { %>
                <div class=\"uv-ticket-uploads\">
                    <h4>";
        // line 1308
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Uploaded Files"), "html", null, true);
        echo "</h4>
                    <div class=\"uv-ticket-uploads-strip\">
                        <% _.each(attachments, function(file) { %>
                            <a href=\"<%-file.downloadURL %>\" target =\"_blank\" class=\"uv-ticket-uploads-brick uv-no-pointer-events\" data-toggle=\"tooltip\" title=\"<%- file.name %>\">
                                <img src=\"<%-file.iconURL %>\" class=\"uv-auto-pointer-events\">
                            </a>
                        <% }) %>
                    </div>

                    <% if (attachments.length > 1) { %>
                        <div class=\"thread-attachments-zip pull-left\">
                            <div class=\"uv-upload-actions\">
                                <a href=\"#\" class=\"uv-open-in-files\" data-thread=\"<%- id %>\" style=\"display: none\"><span class=\"uv-icon-open-in-files\"></span>";
        // line 1320
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Open in Files"), "html", null, true);
        echo "</a>
                                <% if(attachments.length > 0) { %>
                                    <a href=\"";
        // line 1322
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_ticket_download_attachment_zip");
        echo "/<%- id %>\" target=\"_blank\"><span class=\"uv-icon-attachment\"></span> ";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Download (as .zip)"), "html", null, true);
        echo "</a>
                                <% } %>
                            </div>
                        </div>
                    <% } %>

                </div>
            <% } %>
        </div>
    </script>

    <script id=\"edit_thread_tmp\" type=\"text/template\">
        <div class=\"thread-edit-container\">
            <div class=\"uv-element-block uv-element-block-textarea\">
                <div class=\"uv-field-block\">
                    <textarea id=\"uv-edit-thread\">
                    </textarea>
                </div>
            </div>
            <div class=\"uv-action-buttons\">
                <a class=\"uv-btn cancel-edit\" type=\"button\">";
        // line 1342
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Cancel"), "html", null, true);
        echo "</a>
                <a class=\"uv-btn saveThread\" type=\"button\" style=\"margin-right: 10px;\">";
        // line 1343
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Update"), "html", null, true);
        echo "</a>
            </div>
        </div>
    </script>

    <script id=\"ticket_quick_navigation_tmp\" type=\"text/template\">
        <% if(prev) { %>
            <a class=\"uv-btn-stroke\" href=\"";
        // line 1350
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_ticket");
        echo "/<%- prev %>\">
                <span class=\"uv-icon-previous\"></span>
                ";
        // line 1352
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Previous Ticket"), "html", null, true);
        echo "
            </a>
        <% } else { %>
            <a class=\"uv-btn-stroke\" disabled=\"disabled\">
                <span class=\"uv-icon-previous\"></span>
                ";
        // line 1357
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Previous Ticket"), "html", null, true);
        echo "
            </a>
        <% } %>

        <% if(next) { %>
            <a class=\"uv-btn-stroke\" href=\"";
        // line 1362
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_ticket");
        echo "/<%- next %>\">
                ";
        // line 1363
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Next Ticket"), "html", null, true);
        echo "
                <span class=\"uv-icon-next\"></span>
            </a>
        <% } else { %>
            <a class=\"uv-btn-stroke\" disabled=\"disabled\">
                ";
        // line 1368
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Next Ticket"), "html", null, true);
        echo "
                <span class=\"uv-icon-next\"></span>
            </a>
        <% } %>
    </script>

    <script type=\"text/javascript\">
        uvdesk = {
            ticket: {}
        };

        var ticketApp = {};

        viewerImages = function() {
            if (typeof(\$().viewer == 'function')) {
                \$('.uv-ticket-uploads .uv-ticket-uploads-strip').viewer({
                    'url': 'data-url',
                    'downloadBase': \"";
        // line 1385
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_ticket_download_attachment");
        echo "\",
                    'download': 'data-download',
                });
            }
        };

        \$(function () {
            var threadIds = [];
            viewerImages();
            
            _.extend(Backbone.Model.prototype, Backbone.Validation.mixin);

            // Ticket Model
            var TicketModel = Backbone.Model.extend({
                idAttribute : \"id\",
                urlRoot : \"";
        // line 1400
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_update_ticket_attributes_xhr");
        echo "\",
                validation: {
                    'email': [{
                        required: true,
                        msg: '";
        // line 1404
        echo "This field is mandatory";
        echo "'
                    },{
                        pattern: /^([\\w-\\.]+)@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([\\w-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)\$/,
                        msg: '";
        // line 1407
        echo "Please enter a valid email";
        echo "'
                    }],
                    'subject' : {
                        required : true,
                        msg : '";
        // line 1411
        echo "This field is mandatory";
        echo "'
                    },
                    'reply' : {
                        fn: function(value) {
                            if(!tinyMCE.get(\"uv-edit-create-thread\"))
                                return false;
                            var html = tinyMCE.get(\"uv-edit-create-thread\").getContent();
                            if(app.appView.stripHTML(html) != '') {
                                return false;
                            }
                            return true;
                        },
                        msg : '";
        // line 1423
        echo "This field is mandatory";
        echo "'
                    }
                },
            });

            // Thread Model
            var ThreadModel = Backbone.Model.extend({
                idAttribute : \"id\",
                defaults : {
                    hasTask : 0,
                    task: null
                }
            });

            // Customer Model
            var CustomerModel = Backbone.Model.extend({
                validation: {
                    'name': [{
                        required: true,
                        msg: '";
        // line 1442
        echo "This field is mandatory";
        echo "'
                    }, {
                        pattern: /^((?![!@#\$%^&*()<_+]).)*\$/,
                        msg: '";
        // line 1445
        echo "This field must have characters only";
        echo "'
                    }],
                    'email': [{
                        required: true,
                        msg: '";
        // line 1449
        echo "This field is mandatory";
        echo "'
                    },{
                        pattern: /^([\\w-\\.]+)@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([\\w-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)\$/,
                        msg: 'Email address is invalid'
                    }],
                    'contactNumber': function(value) {
                        if(value != undefined && value !== '') {
                            if (!value.match('^\\\\s*(?:\\\\+?(\\\\d{1,3}))?[-. (]*(\\\\d{3})[-. )]*(\\\\d{3})[-. ]*(\\\\d{4})(?: *x(\\\\d+))?\\\\s*\$'))
                                return 'Contact number is invalid';
                        }
                    }
                },
                urlRoot : \"";
        // line 1461
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_manage_customer_account");
        echo "\"
            });

            // Ticket Collaborator Model
            var CollaboratorModel = Backbone.Model.extend({
                idAttribute : \"id\",
                validation: {
                    'email': [{
                        required: true,
                        msg: \"";
        // line 1470
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "\"
                    },{
                        pattern: /^([\\w-\\.]+)@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([\\w-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)\$/,
                        msg: 'Please enter a valid email'
                    }]
                },
                defaults : {
                    ticketId : ";
        // line 1477
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 1477, $this->source); })()), "id", [], "any", false, false, false, 1477), "html", null, true);
        echo ",
                    email: ''
                },
                parse: function (resp, options) {
                    return resp.collaborator;
                },
                urlRoot : \"";
        // line 1483
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_ticket_manage_collaborators_xhr");
        echo "\"
            });

            // Ticket Tag Model
            var TagModel = Backbone.Model.extend({
                idAttribute : \"id\",
                defaults : {
                    ticketId : ";
        // line 1490
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 1490, $this->source); })()), "id", [], "any", false, false, false, 1490), "html", null, true);
        echo "
                },
                parse: function (resp, options) {
                    return resp.tag;
                },
                urlRoot : \"";
        // line 1495
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_ticket_create_tag_xhr");
        echo "\"
            });

            // Ticket Label Model
            var LabelModel = Backbone.Model.extend({
                idAttribute : \"id\",
                defaults : {
                    ticketId : ";
        // line 1502
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 1502, $this->source); })()), "id", [], "any", false, false, false, 1502), "html", null, true);
        echo "
                },
                parse: function (resp, options) {
                    return resp.label;
                },
                urlRoot : \"";
        // line 1507
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_ticket_add_label_xhr");
        echo "\"
            });

            // Ticket Thread Collection
            var ThreadCollection = AppCollection.extend({
                model : ThreadModel,
                mode: \"infinite\",
                url : \"";
        // line 1514
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_thread_collection_xhr", ["ticketId" => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 1514, $this->source); })()), "id", [], "any", false, false, false, 1514)]), "html", null, true);
        echo "\",
                firstScrollCheck: false,
                threadRequestedId: false,
                template : \$(\"#thread_list_empty_tmp\").html(),
                parseRecords: function (resp, options) {
                    return resp.threads;
                },
                syncData : function() {
                    type = \$(\".uv-ticket-action-bar-lt .uv-tabs .uv-tab-active\").attr('data-type')
                    var self = this;
                    var data = {
                            threadType: type
                        };

                    if(this.threadRequestedId)
                        data.threadRequestedId = this.threadRequestedId;

                    app.appView.showLoader()
                    this.fetch({
                        data : data,
                        remove: false,
                        success: function(model, response) {
                            app.appView.hideLoader();
                            self.threadRequestedId = false;
                            pagination.renderPagination(response.pagination);
                            threadCollection.state.currentPage = parseInt(response.pagination.current) + 1;
                            if(response.pagination.totalCount <= 0){
                                this.\$('.uv-ticket-wrapper.thread-list').html(self.template);
                            }
                        },
                        error: function (model, xhr, options) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                        }
                    }).done(function(){
                        viewerImages();
                        if(!self.firstScrollCheck){
                            self.firstScrollCheck = true;
                            var fragment = Backbone.history.fragment.trim();
                            if(fragment == '') {
                                router.scrollPage('#reply');
                            } else
                                router.scrollPage('#' + fragment.replace('thread/', 'thread'));
                        }
                    });
                }
            });

            // Ticket Collaborator Collection
            var CollaboratorCollection = Backbone.PageableCollection.extend({
                model : CollaboratorModel
            });

            // Ticket Tag Collection
            var TagCollection = Backbone.PageableCollection.extend({
                model : TagModel,
                isTagExist : function(name) {
                    var flag = 1;
                    _.each(tagCollection.models, function (item) {
                        if(item.get('name').toUpperCase() == name.toUpperCase())
                            flag = 0;
                    }, this);

                    return flag;
                }
            });

            // Ticket Label Collection
            var LabelCollection = Backbone.PageableCollection.extend({
                model : TagModel,
                isLabelExist : function(name) {
                    var flag = 1;
                    _.each(labelCollection.models, function (item) {
                        if(item.get('name').toUpperCase() == name.toUpperCase())
                            flag = 0;
                    }, this);
                    return flag;
                }
            });

            // Customer Form View
            var CustomerForm = Backbone.View.extend({
                events : {
                    'click .uv-btn.update-btn' : \"saveCustomer\",
                    'blur input': 'formChanegd',
                    'click .cancel-btn': 'backToInfo',
                    'click .uv-aside-back': 'backToInfo'
                },
                initialize : function() {
                    Backbone.Validation.bind(this);
                },
                formChanegd: function(e) {
                    this.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
                    this.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
                },
                saveCustomer: function (e) {
                    e.preventDefault();
                    currentElement = Backbone.\$(e.currentTarget);
                    this.model.clear();
                    this.model.set(this.\$el.find('form').serializeObject());
                    self = this;
                    if(this.model.isValid(true)) {
                        app.appView.showLoader();
                        currentElement.attr('disabled', 'disabled');
                        this.model.save({}, {
                            success: function (model, response, options) {
                                app.appView.hideLoader();
                                currentElement.removeAttr(\"disabled\");
                                if(response.alertClass == \"success\") {
                                    app.appView.renderResponseAlert(response);
                                    \$('.uv-aside-customer-info').html(\"<span>\" + self.model.attributes.name + \"</span><span>\" + self.model.attributes.email + \"</span><span>\" + self.model.attributes.contactNumber + \"</span><span class='uv-customize'></span>\")
                                    self.backToInfo();
                                } else if(response.errors) {
                                    self.addErrors(JSON.parse(response.errors));
                                } else if(response.alertMessage) {
                                    app.appView.renderResponseAlert(response);
                                }
                            },
                            error: function (model, xhr, options) {
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;

                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(warningResponse);
                            }
                        });
                    }
                },
                addErrors: function(jsonContext) {
                    for (var field in jsonContext) {
                        Backbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
                    }
                },
                backToInfo: function(e) {
                    if(e)
                        e.preventDefault()

                    \$('.uv-main-info-update-block').hide()
                    \$('.uv-main-info-block').show()
                },
            });

            // Ticket View
            var TicketView = Backbone.View.extend({
                el: \$('.uv-wrapper'),
                stopDraftSaveFlag: 0,
                events: {
                    'click .uv-ticket-action .uv-dropdown-list li[data-action=\"spam\"], .uv-ticket-action .uv-dropdown-list li[data-action=\"closed\"]': 'masrkSpamAndClosed',
                    'click .uv-aside-ticket-actions .uv-aside-select .uv-dropdown-list li': 'editTicketProperty',
                    'click .uv-aside-customer-info .uv-customize': 'showCustomerUpdateBlock',
                    'click .uv-ticket-head .uv-star-large': 'updateStar',
                    'click .uv-ticket-action-bar .uv-tabs li': 'filterThread',
                    'click .uv-ticket-action .uv-dropdown-list li[data-action=\"delete\"]': 'confirmRemove',
                    'click .uv-ticket-action .uv-dropdown-list li[data-action=\"lock\"]': 'lockAndUnlockThread',
                    'click .uv-element-block.collaborators .uv-btn-tag': 'removeCcCollaborator',
                    'keypress .uv-element-block.to .uv-dropdown-other': 'addToInput',
                    'click .uv-element-block.to .uv-dropdown-list li': 'addTo',
                    'click .to-list .uv-btn-tag': 'removeTo',
                    'change .uv-element-block.cc-bcc .cc-bcc-toggle': 'showCcBccBlock',
                    'keypress .uv-element-block.cc-bcc .uv-group-field.uv-dropdown-other': 'addCcBccInput',
                    'click .uv-element-block.cc-bcc .uv-dropdown-list li': 'addCcBcc',
                    'click .cc-bcc-list .uv-btn-tag, .to-list .uv-btn-tag': 'removeEmail',
                    'click .next-view .uv-dropdown-list li': 'setNextView',
                    'click .uv-dropdown.reply .uv-dropdown-list li, .uv-btn.forward': 'validateForm',
                    'click #edit-ticket-modal .uv-btn.update': 'updateTicket',
                    'click .message .uv-icon-ellipsis': 'showReplyQuote',
                    'input .uv-aside-brick .uv-field.uv-dropdown-other': 'searchFilterXhr',
                    'click .uv-dropdown-container.prepared-responses a:not(.create-new)': 'confirmPreparedResponses',

                    'click .uv-header-fix': 'fixheader',
                    'click .uv-ticket-action .uv-dropdown-list li[data-action=\"print\"]': 'printTicket',
                    'blur .uv-manual-enter': 'enterManualAdd',
                },
                ticketNavigationTemplate : _.template(\$(\"#ticket_quick_navigation_tmp\").html()),
                loaderTemplate : _.template(\$(\"#loader-tmp\").html()),
                targetPreparedResponseUrl: '',
                initialize: function() {
                    Backbone.Validation.bind(this);
                    InitTinyMce('#uv-edit-create-thread');
                    \$('.uv-ticket-fixed-region .uv-ticket-fixed-region-rt').html(this.ticketNavigationTemplate(ticketNavigation))
                    var threadTab = localStorage.getItem(\"threadTab\");
                    if(threadTab){
                        \$('.uv-ticket-action-bar-lt .uv-tabs li').removeClass('uv-tab-active');
                        \$('.uv-ticket-action-bar-lt .uv-tabs [data-type=\"' + threadTab + '\"]').addClass('uv-tab-active');
                    }
                    nextView = localStorage.getItem(\"nextView\");
                    if(nextView) {
                        \$(\".next-view input\").val(nextView)
                        \$(\".next-view .uv-dropdown-btn\").text(\$(\"#reply .next-view .uv-dropdown-list li[data-value='\" + nextView + \"']\").text())
                    }
                    if(!localStorage.getItem('ticketTour')) {
                        \$('.uv-ticket-tour').show()
                    }
                    this.fixheaderInit();
                },
                printTicket: function(e) {
                    window.print();
                },
                enterManualAdd: function(e) {
                    var target = \$(e.target);
                    if(target.val()) {
                        var e = \$.Event(\"keypress\");
                        e.which = 13; //choose the one you want
                        target.trigger(e);
                    }
                },
                fixheader: function(e){
                    e.preventDefault();
                    var header = localStorage.getItem(\"fixHeader\");
                    header = !(header == 'true');
                    localStorage.setItem(\"fixHeader\", header);
                    this.fixheaderInit();
                },
                fixheaderInit: function(){
                    var header = localStorage.getItem(\"fixHeader\");
                    if(header == 'true'){
                        \$('a.uv-icon-pin').addClass('uv-icon-pinned');
                        \$('.uv-ticket-action-bar').addClass('uv-ticket-action-bar-fixed');
                    }else{
                        \$('a.uv-icon-pin').removeClass('uv-icon-pinned');
                        \$('.uv-ticket-action-bar').removeClass('uv-ticket-action-bar-fixed');
                    }
                },
                masrkSpamAndClosed: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    var value = currentElement.attr('data-index');
                    \$(\".uv-aside-select .uv-dropdown-list ul.status li[data-index='\" + value + \"']\").trigger('click')
                },
                editTicketProperty: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    var uvSelect = currentElement.parents('.uv-aside-select');
                    var field = currentElement.parent().attr('data-action');
                    var value = currentElement.attr('data-index');
                    if(uvSelect.find('.uv-aside-select-value').attr('data-id') != value) {
                        var name = currentElement.text().trim();
                        app.appView.showLoader();
                        this.model.save({attribute: field, value: value, id: this.model.id}, {
                            patch: true,
                            success: function (model, response, options) {
                                uvSelect.find('.uv-aside-select-value').attr('data-id', value).text(name)
                                if(field == 'priority') {
                                    uvSelect.find('.uv-list-ticket-priority').attr('style', 'background:' + currentElement.attr('data-color'));
                                } else if(field == 'agent') {
                                    \$('.uv-ticket-strip .agent-info').show()
                                    \$('.uv-ticket-strip .agent-info .name').text(name)
                                }
                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(response);
                            },
                            error: function (model, xhr, options) {
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;
                                var response = warningResponse;
                                if(xhr.responseJSON)
                                    response = xhr.responseJSON;

                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(response);
                            }
                        });
                    }
                },
                showCustomerUpdateBlock: function() {
                    \$('.uv-main-info-update-block').show()
                    \$('.uv-main-info-block').hide()
                },
                updateStar: function(e) {
                    e.preventDefault();
                    var currentElement = Backbone.\$(e.currentTarget);
                    currentElement.toggleClass('uv-star-active')
                    this.model.save({id: this.model.id}, {
                        patch: true,
                        url : \"";
        // line 1786
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_bookmark_ticket_xhr");
        echo "\",
                        success: function (model, response, options) {
                        },
                        error: function (model, xhr, options) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                        }
                    });
                },
                filterThread: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    if(type = currentElement.attr('data-type')) {
                        localStorage.setItem(\"threadTab\", type);
                        if(type != 'all')
                            \$('.uv-ticket-main.create').hide()
                        else
                            \$('.uv-ticket-main.create').show()
                        \$('.uv-ticket-wrapper.thread-list').html('')
                        models = []
                        threadCollection.each(function(model) {
                            models.push(model)
                        })
                        total = threadCollection.models.length;
                        count = 0;
                        if(total) {
                            _.each(models, function (model) {
                                threadCollection.remove(model)
                                count++;
                                if(total == count) {
                                    threadCollection.reset()
                                    threadCollection.state.currentPage = 1;
                                    threadCollection.syncData()
                                }
                            });
                        } else {
                            threadCollection.reset()
                            threadCollection.state.currentPage = 1;
                            threadCollection.syncData()
                        }
                    }
                },
                confirmRemove: function(e) {
                    app.appView.openConfirmModal(this);
                },
                removeItem : function() {
                    if(this.model.attributes.isTrashed)
                        window.location.href = \"";
        // line 1832
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_delete_ticket", ["ticketId" => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 1832, $this->source); })()), "id", [], "any", false, false, false, 1832)]), "html", null, true);
        echo "\";
                    else
                        window.location.href = \"";
        // line 1834
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_trash_ticket", ["ticketId" => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 1834, $this->source); })()), "id", [], "any", false, false, false, 1834)]), "html", null, true);
        echo "\";
                },
                addCCCollaborators: function() {
                    if(collaboratorCollection.length) {
                        var collaboratorContainer = \$('.uv-element-block.collaborators');
                        collaboratorContainer.find('.uv-field-block').html('');
                        collaboratorContainer.show()
                        _.each(collaboratorCollection.models, function (item) {
                            var json = item.attributes;
                            collaboratorContainer.find('.uv-field-block').append(\"<span><input type='hidden' name='cccol[]' value='\" + json.email + \"'/><a class='uv-btn-tag' href='#'><span class='uv-icon-remove-dark-before'></span>\" + json.name + \"</a></span>\")
                        }, this);
                    }
                },
                removeCcCollaborator: function(e) {
                    e.preventDefault()
                    Backbone.\$(e.currentTarget).parent().remove();
                    var collaboratorContainer = \$('.uv-element-block.collaborators');
                    if(!collaboratorContainer.find('.uv-btn-tag').length)
                        collaboratorContainer.hide()
                },
                addToInput: function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    var currentTab = inputElement.parents('.uv-tab-view');
                    var email = inputElement.val().trim();
                    if (e.which === 13 && email) {
                        e.preventDefault()
                        if(!this.model.preValidate({name: 'email', email: email})) {
                            inputElement.val('').trigger('input')
                            inputElement.removeClass('uv-dropdown-btn-active')
                            inputElement.siblings('.uv-dropdown-list').hide()
                            if(!currentTab.find(\".to-list input[value='\" + email + \"'].to\").length) {
                                currentTab.find('.to-list').append(\"<span><input type='hidden' name='to[]' value='\" + email + \"' class='to'/><a class='uv-btn-tag' href='#'><span class='uv-icon-remove-dark-before'></span>\" + email + \"</span></a></span>\")
                            }
                        }
                    }
                },
                addTo: function(e) {
                    var currentTab = Backbone.\$(e.currentTarget).parents('.uv-tab-view');
                    var email =  Backbone.\$(e.currentTarget).attr('data-id');
                    if(!currentTab.find(\".to-list input[value='\" + email + \"'].to\").length) {
                        currentTab.find('.to-list').append(\"<span><input type='hidden' name='to[]' value='\" + email + \"' class='to'/><a class='uv-btn-tag' href='#'><span class='uv-icon-remove-dark-before'></span>\" + email + \"</span></a></span>\")
                    }
                },
                showCcBccBlock: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    var currentTab = currentElement.parents('.uv-tab-view');
                    if(currentElement.is(':checked')) {
                        currentTab.find('.uv-element-block.cc-bcc').find('.uv-field-block').show()
                    } else {
                        currentTab.find('.uv-element-block.cc-bcc').find('.uv-field-block').hide()
                        currentTab.find('.uv-element-block .cc-bcc-list').html('')
                    }
                },
                addCcBccInput: function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    var currentTab = inputElement.parents('.uv-tab-view');
                    var email = inputElement.val().trim();
                    if (e.which === 13 && email) {
                        e.preventDefault()
                        type = currentTab.find('.cc-bcc-select option:selected').text()
                        if(!this.model.preValidate({name: 'email', email: email})) {
                            inputName = \$('.cc-bcc-select').val()
                            inputElement.val('').trigger('input')
                            inputElement.removeClass('uv-dropdown-btn-active')
                            inputElement.siblings('.uv-dropdown-list').hide()
                            if(!currentTab.find(\".cc-bcc-list input[value='\" + email + \"'].\" + inputName).length) {
                                currentTab.find('.cc-bcc-list').append(\"<span><input type='hidden' name='\" + inputName + \"[]' value='\" + email + \"' class='\" + inputName + \"'/><a class=uv-btn-tag uv-lowercase' href='#'><span class='uv-icon-remove-dark-before'></span>\" + email + \" : <span class='uv-uppercase'>\" + type + \"</span></a></span>\")
                            }
                        }
                    }
                },
                addCcBcc: function(e) {
                    var currentTab = Backbone.\$(e.currentTarget).parents('.uv-tab-view');
                    var email =  Backbone.\$(e.currentTarget).attr('data-id');
                    type = currentTab.find('.cc-bcc-select option:selected').text()
                    inputName = currentTab.find('.cc-bcc-select').val()
                    if(!currentTab.find(\".cc-bcc-list input[value='\" + email + \"'].\" + inputName).length) {
                        currentTab.find('.uv-element-block.cc-bcc .uv-group-field.uv-dropdown-other').val('').trigger('input')
                        currentTab.find('.cc-bcc-list').append(\"<span><input type='hidden' name='\" + inputName + \"[]' value='\" + email + \"' class='\" + inputName + \"'/><a class=uv-btn-tag uv-lowercase' href='#'><span class='uv-icon-remove-dark-before'></span>\" + email + \" : <span class='uv-uppercase'>\" + type + \"</span></a></span>\")
                    }
                },
                removeEmail: function(e) {
                    e.preventDefault()
                    Backbone.\$(e.currentTarget).parent().remove();
                },
                setNextView: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    var nextView = currentElement.attr('data-value');
                    localStorage.setItem(\"nextView\", nextView);
                    \$(\".next-view input\").val(nextView)
                    \$(\".next-view .uv-dropdown-btn\").text(currentElement.text())
                },
                validateForm : function(e) {
                    e.preventDefault();
                    var element = Backbone.\$(e.currentTarget);
                    formType = element.parents('.uv-tab-view.uv-tab-view-active').attr('id');
                    form = element.parents('form');
                    form.find('.reply-status').val(element.attr('data-id'));
                    form.find('.uv-field-message').remove()

                    var html = tinyMCE.get(formType + \"-area\").getContent();
                    if(app.appView.htmlText(html) != '' || -1 != html.indexOf('<img')) {
                        if(formType == 'forward') {
                            if(!form.find(\".to-list input.to\").length) {
                                \$('.uv-element-block.to').append(\"<span class='uv-field-message'>";
        // line 1938
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "</span>\")
                            } else {
                                this.stopDraftSaveFlag = 1;

                                app.appView.showLoader();
                                tinyMCE.activeEditor.uploadImages(function(response) {
                                    app.appView.hideLoader();

                                    form.submit();
                                    \$('.uv-btn.forward').attr('disabled', 'disabled');
                                });
                            }
                        } else {
                            this.stopDraftSaveFlag = 1;
                            if(localStorage) {
                                localStorage.setItem(\"threadTab\", \"all\");
                            }

                            app.appView.showLoader();
                            tinyMCE.activeEditor.uploadImages(function(response) {
                                app.appView.hideLoader();

                                form.submit();
                                \$('.uv-dropdown.reply').find('.uv-btn').attr('disabled', 'disabled');
                            });
                        }
                    } else {
                        form.find('.uv-element-block-textarea').append(\"<span class='uv-field-message'>";
        // line 1965
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "</span>\");
                        if(formType == 'forward') {
                            if(!form.find(\".to-list input.to\").length) {
                                \$('.uv-element-block.to').append(\"<span class='uv-field-message'>";
        // line 1968
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "</span>\")
                            }
                        }
                    }
                },
                updateTicket: function(e) {
                    e.preventDefault();
                    this.model.set(\$('#edit-ticket-modal form').serializeObject());
                    if(this.model.isValid(['subject', 'reply'])) {
                        \$('#edit-ticket-modal form').find('.uv-btn').attr('disabled', 'disabled');
                        \$('#edit-ticket-modal form').submit();
                    }
                },
                showReplyQuote: function(e) {
                    Backbone.\$(e.currentTarget).next().toggle();
                },
                searchFilterXhr: _.debounce(function(e) {
                    currentElement = Backbone.\$(e.currentTarget);
                    var parent = currentElement.parent();
                    if(\$('.uv-dropdown-other.uv-dropdown-btn-active').parent().attr('id') != parent.attr('id'))
                        return;
                    parent.find(\"li:not(.uv-no-results, .uv-filter-info)\").remove();
                    parent.find(\".uv-filter-info\").show()
                    if(currentElement.val().length > 1) {
                        parent.append(this.loaderTemplate())
                        parent.find('.uv-filter-info').text(\"";
        // line 1993
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Searching", [], "messages");
        echo " ...\")
                        if(self.xhrReq)
                            self.xhrReq.abort();

                        self.xhrReq = \$.ajax({
                            url : \"";
        // line 1998
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_ticket_search_filter_options");
        echo "\",
                            type : 'GET',
                            data: {\"type\" : currentElement.attr('data-type'), \"query\": currentElement.val()},
                            dataType : 'json',
                            success : function(response) {
                                self.xhrReq = 0;
                                parent.find('.uv-loader').remove()
                                parent.find('.uv-filter-info').text(\"";
        // line 2005
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Type atleast 2 letters"), "html", null, true);
        echo "\").hide();
                                if(response.length == 0) {
                                    parent.find('.uv-no-results').show();
                                    parent.find('.uv-no-results').disabled = true;
                                } else {
                                    parent.find('.uv-no-results').hide();
                                    _.each(response, function(item) {
                                        parent.find('.uv-dropdown-list ul').append(\"<li data-id='\" + item.id + \"'>\" + item.name + \"</li>\")
                                    });
                                }
                            },
                            error: function (xhr) {
                                self.xhrReq = 0;
                                parent.find('.uv-loader').remove()
                                parent.find('.uv-no-results').hide();
                                parent.find('.uv-filter-info').text(\"";
        // line 2020
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Type atleast 2 letters"), "html", null, true);
        echo "\").show();

                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;
                            }
                        });
                    } else {
                        parent.find('.uv-no-results').hide();
                    }
                },1000)
            });

            // Ticket Thread View
            var ThreadItem = Backbone.View.extend({
                tagName : \"div\",
                className : \"uv-ticket-main\",
                template : _.template(\$(\"#thread_list_item_tmp\").html()),
                editThreadTemplate : _.template(\$(\"#edit_thread_tmp\").html()),
                events : {
                    'click .uv-thread-action .uv-dropdown-list li[data-action=\"delete\"]': 'confirmRemove',
                    'click .uv-thread-action .uv-dropdown-list li[data-action=\"lock\"]': 'lockAndUnlockThread',
                    'click .uv-thread-action .uv-dropdown-list li[data-action=\"pin\"]': 'pinThread',
                    'click .uv-thread-action .uv-dropdown-list li[data-action=\"mark\"]': 'markForTask',
                    'click .uv-thread-action .uv-dropdown-list li[data-action=\"forward\"]' : 'forwardThread',
                    'click .uv-thread-action .uv-dropdown-list li[data-action=\"edit\"]' : 'editThread',
                    'click .uv-btn.cancel-edit' : 'cancelEdit',
                    'click .uv-btn.saveThread' : 'updateThread',
                    'click .copy-thread-link' : 'copyThreadLink',
                    'blur .input-copy-thread-link': 'removeCopyThreadLink'
                },
                render : function () {
                    this.\$el.html(this.template(this.model.toJSON()));

                    this.\$el.addClass(\"thread-\" + this.model.id)
                    if(this.model.attributes.threadType == 'note')
                        this.\$el.addClass('uv-ticket-note')
                    return this;
                },
                unrender : function(response) {
                    if(response.alertMessage != undefined) {
                        var self = this;
                        ";
        // line 2062
        echo "                        threadCollection.models = threadCollection.models.filter(thread => {
                            if(thread.id == self.model.id) {
                                return false;
                            }

                            return true;
                        });
                        this.remove();
                        threadCollection.syncData();
                        app.appView.renderResponseAlert(response);
                    }
                },
                confirmRemove: function(e) {
                    app.appView.openConfirmModal(this);
                },
                removeItem : function() {
                    self = this;
                    var index = threadIds.indexOf(this.model.id);
                    if (index > -1)
                        threadIds.splice(index, 1);
                    app.appView.showLoader();
                    this.model.destroy({
                        url : \"";
        // line 2084
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_thread_xhr");
        echo "/\" + this.model.id,
                        data : { 'ticketId' : ticketModel.attributes.id },
                        success : function (model, response, options) {
                            app.appView.hideLoader();
                            self.unrender(response);
                        },
                        error: function (model, xhr, options) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        }
                    });
                },
                lockAndUnlockThread :function(e) {
                    self = this;
                    currentElement = Backbone.\$(e.currentTarget);
                    var isLocked = 0;
                    if(this.model.get('isLocked')) {
                        this.model.set('isLocked', 0);
                        currentElement.attr('data-id', isLocked).text(\"";
        // line 2108
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Lock Thread"), "html", null, true);
        echo "\");
                    } else {
                        isLocked = 1;
                        this.model.set('isLocked', 1);
                        currentElement.attr('data-id', isLocked).text(\"";
        // line 2112
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Unlock Thread"), "html", null, true);
        echo "\");
                    }
                    app.appView.showLoader();
                    this.model.save({
                            isLocked: isLocked,
                            id: this.model.id,
                            ticketId: ticketModel.attributes.id,
                            updateType: 'lock'
                        }, {
                        patch: true,
                        url : \"";
        // line 2122
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_thread_xhr");
        echo "/\" + this.model.id,
                        success : function (model, response, options) {
                            self.toggleThreadPropertyIcon()
                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        },
                        error: function (model, xhr, options) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        }
                    });
                },
                pinThread :function(e) {
                    self = this;
                    currentElement = Backbone.\$(e.currentTarget);
                    var bookmark = 0;
                    if(this.model.get('bookmark')) {
                        this.model.set('bookmark', 0);
                        currentElement.attr('data-id', bookmark).text(\"";
        // line 2146
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Pin Thread"), "html", null, true);
        echo "\");
                    } else {
                        bookmark = 1;
                        this.model.set('bookmark', 1);
                        currentElement.attr('data-id', bookmark).text(\"";
        // line 2150
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Unpin Thread"), "html", null, true);
        echo "\");
                    }
                    app.appView.showLoader();
                    this.model.save({
                            bookmark: bookmark,
                            id: this.model.id,
                            ticketId: ticketModel.attributes.id,
                            updateType: 'bookmark'
                        }, {
                        patch: true,
                        url : \"";
        // line 2160
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_thread_xhr");
        echo "/\" + this.model.id,
                        success : function (model, response, options) {
                            self.toggleThreadPropertyIcon()
                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        },
                        error: function (model, xhr, options) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        }
                    });
                },
                forwardThread : function(e) {
                    var element = Backbone.\$(e.currentTarget);
                    tinymce.get('forward-area').setContent(this.model.attributes.reply);
                    \$('#forward-area').parent().find('img').removeAttr('crossorigin');
                    \$(\".uv-tabs li[for='forward']\").trigger('click');

                    \$('.uv-ticket-scroll-region').animate({
                        scrollTop: \$('#default').outerHeight()
                    }, 'slow');
                },
                cancelEdit : function(e) {
                    this.initEditThread();
                    tinymce.get('uv-edit-thread').destroy()
                },
                editThread : function(e) {
                    \$('.thread-edit-container .cancel-edit').trigger('click');
                    this.initEditThread();
                    this.\$el.find('.message').hide().after(this.editThreadTemplate());
                    this.\$el.find('.uv-ticket-uploads').hide()

                    InitTinyMce('#uv-edit-thread');
                    tinymce.get('uv-edit-thread').setContent(this.model.attributes.reply);
                    this.\$el.find('img').removeAttr('crossorigin');
                },
                initEditThread: function() {
                    \$('.thread-edit-container').remove();
                    messageElement = this.\$el.find('.message');
                    messageElement.show();
                    this.\$el.find('.uv-ticket-uploads').show()
                },
                updateThread : function(e) {
                    e.preventDefault();
                    var currentElement = Backbone.\$(e.currentTarget);
                    parent = currentElement.parents('.thread-edit-container')
                    parent.find('.uv-field-message').remove()

                    var html = tinyMCE.get(\"uv-edit-thread\").getContent();
                    if(app.appView.stripHTML(html) != '') {
                        var self = this;
                        currentElement.attr(\"disabled\", \"disabled\");
                        this.model.set('reply', html);
                        app.appView.showLoader()
                        this.model.save({}, {
                            url : \"";
        // line 2221
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_thread_update_xhr");
        echo "/\" + this.model.id,
                            success : function (model, response, options) {
                                app.appView.hideLoader()
                                messageElement = self.\$el.find('.message');
                                if(response.alertClass == 'success') {
                                    messageElement.html(self.model.attributes.reply).show();
                                    messageElement.find('.uv-icon-ellipsis').remove();
                                    messageElement.find('.helpdesk_blockquote').eq(0).before(\"<span class='uv-icon-ellipsis uv-ellipsis-mirror'></span>\").hide();
                                }

                                self.initEditThread();
                                tinymce.get('uv-edit-thread').destroy()
                                app.appView.renderResponseAlert(response);
                            },
                            error: function (model, xhr, options) {
                                self.initEditThread();
                                tinymce.get('uv-edit-thread').destroy()
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;
                                var response = warningResponse;
                                if(xhr.responseJSON)
                                    response = xhr.responseJSON;
                                app.appView.hideLoader()
                                app.appView.renderResponseAlert(response);
                            }
                        });
                    } else {
                        this.\$el.find('.uv-element-block-textarea').append(\"<span class='uv-field-message'>";
        // line 2248
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("This field is mandatory"), "html", null, true);
        echo "</span>\");
                    }
                },
                toggleCreateTaskBar : function() {
                    if(threadIds.length) {
                        \$(\"#uv-task-view\").css('right', '0px');
                        \$(\"#uv-task-view .uv-create-task\").show()
                        \$(\"#uv-task-view .uv-task-list\").hide()
                    } else {
                        \$(\"#uv-task-view\").css('right', '-300px');
                        \$(\"#uv-task-view .uv-create-task\").hide()
                        \$(\"#uv-task-view .uv-task-list\").show()
                    }
                },
                copyThreadLink: function(e){
                    _.delay(function(){
                        \$(e.currentTarget).before('<input type=\"text\" class=\"input-copy-thread-link uv-field\" value=\"' + window.location.href + '\"/>');
                        \$(e.currentTarget).prev().focus().select();
                    }, 100);
                },
                removeCopyThreadLink: function(e){
                    \$(e.currentTarget).remove();
                },
                toggleThreadPropertyIcon: function(e) {
                    if(jQuery.inArray(this.model.id, threadIds) !== -1 || this.model.get('bookmark') || this.model.get('isLocked')) {
                        this.\$el.find('.uv-icon-pinned').parents('.uv-ticket-strip').show()
                    } else {
                        this.\$el.find('.uv-icon-pinned').parents('.uv-ticket-strip').hide()
                    }

                    if(jQuery.inArray(this.model.id, threadIds) !== -1)
                        this.\$el.find('.uv-icon-marked-task').parent().show()
                    else
                        this.\$el.find('.uv-icon-marked-task').parent().hide()

                    if(this.model.get('bookmark'))
                        this.\$el.find('.uv-icon-pinned').parent().show()
                    else
                        this.\$el.find('.uv-icon-pinned').parent().hide()

                    if(this.model.get('isLocked'))
                        this.\$el.find('.uv-icon-locked').parent().show()
                    else
                        this.\$el.find('.uv-icon-locked').parent().hide()
                }
            });

            // Ticket Thread List
            var ThreadList = Backbone.View.extend({
                el : \$(\".thread-list\"),
                initialize : function() {
                    this.listenTo(threadCollection.fullCollection, \"add\", this.renderThread);
                },
                renderThread : function (item) {
                    var threadItem = new ThreadItem({
                        model: item
                    });
                    if(item.id < threadCollection.fullCollection.at(0).id)
                        this.\$el.prepend(threadItem.render().el);
                    else
                        this.\$el.append(threadItem.render().el);
                    threadItem.\$el.find('.helpdesk_blockquote').eq(0).before(\"<span class='uv-icon-ellipsis uv-ellipsis-mirror'></span>\").hide();
                    //emojifyRun();
                    this.\$el.find('img').removeAttr('crossorigin');
                    this.\$el.find('div.message a').attr('target', '_blank');
                    app.appView.relativeTime();
                }
            });

            // Ticket Pagination View
            var Pagination = Backbone.View.extend({
                el: \$('.uv-ticket-accordion'),
                events: {
                    'click .uv-ticket-count-stat': 'loadMore',
                },
                renderPagination: function(pagination) {
                    if(pagination.totalCount - pagination.lastItemNumber > 0 && pagination.lastItemNumber > 0) {
                        var remain = pagination.totalCount - pagination.lastItemNumber;
                        \$('.uv-ticket-count-stat').text(remain)
                        \$('.uv-ticket-accordion').removeClass('uv-ticket-accordion-expanded').removeClass('uv-ticket-accordion-no-count')
                    } else {
                        \$('.uv-ticket-accordion').addClass('uv-ticket-accordion-expanded').addClass('uv-ticket-accordion-no-count')
                    }
                },
                loadMore: function() {
                    threadCollection.syncData();
                }
            });

            // Ticket collaborator Item View
            var CollaboratorItem = Backbone.View.extend({
                tagName : \"a\",
                className: 'uv-btn-tag',
                template : _.template(\"<span class='uv-tag'>";
        // line 2341
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 2341, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_DELETE_COLLABORATOR_FROM_TICKET"], "method", false, false, false, 2341)) {
            echo "<span class='uv-icon-remove-dark-before'></span>";
        }
        echo "<%- name %></span>\"),
                events : {
                    'click .uv-tag' : 'confirmRemove'
                },
                render : function () {
                    this.\$el.html(this.template(this.model.toJSON()));
                    return this;
                },
                unrender : function(response) {
                    if(response.alertMessage != undefined) {
                        app.appView.renderResponseAlert(response);
                    }
                },
                removeItem: function() {
                    ";
        // line 2355
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 2355, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_ADD_COLLABORATOR_TO_TICKET"], "method", false, false, false, 2355)) {
            // line 2356
            echo "                        self = this;
                        app.appView.showLoader();
                        this.model.destroy({
                            data : { 'ticketId' : this.model.attributes.ticketId },
                            success : function (model, response, options) {
                                app.appView.hideLoader();
                                self.\$el.remove();
                                self.unrender(response);
                            },
                            error: function (model, xhr, options) {
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;
                                var response = warningResponse;
                                if(xhr.responseJSON)
                                    response = xhr.responseJSON;

                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(response);
                            }
                        });
                    ";
        }
        // line 2377
        echo "                },
                confirmRemove: function(e) {
                    e.preventDefault();
                    ";
        // line 2380
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 2380, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_ADD_COLLABORATOR_TO_TICKET"], "method", false, false, false, 2380)) {
            // line 2381
            echo "                        app.appView.openConfirmModal(this)
                    ";
        }
        // line 2383
        echo "                }
            });

            // Ticket Collaborator View
            var CollaboratorList = Backbone.View.extend({
                el : \$(\".collaborator-list-block\"),
                events : {
                    'keypress .uv-field' : 'addCollaborator',
                    'focusout .uv-field' : 'removeErrorClass'
                },
                initialize : function() {
                    //Backbone.Validation.bind(this);
                },
                render : function() {
                    this.\$el.find(\".collaborator-list\").html('');
                    var self = this;
                    collaboratorOptionHtml = '';
                    
                    if(collaboratorCollection.length) {
                        _.each(collaboratorCollection.models, function (item) {
                            this.renderCollaborator(item);
                        }, this);
                    }
                    ticketView.addCCCollaborators()
                },
                renderCollaborator : function (item) {
                    var collaborator = new CollaboratorItem({
                        model: item
                    });
                    this.\$el.find('.collaborator-list').append(collaborator.render().el);
                },
                removeErrorClass: function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    inputElement.removeClass('uv-field-error');
                    inputElement.parents('.uv-element-block').find('.uv-field-message').remove()
                },
                addCollaborator : function(e) {
                    ";
        // line 2420
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 2420, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_ADD_COLLABORATOR_TO_TICKET"], "method", false, false, false, 2420)) {
            // line 2421
            echo "                        var inputElement = Backbone.\$(e.currentTarget);
                        inputElement.removeClass('uv-field-error');
                        inputElement.parents('.uv-element-block').find('.uv-field-message').remove()
                        var text = inputElement.val().trim();
                       
                        if (e.which === 13 && text) {
                            this.model = new CollaboratorModel();
                            self = this;
                            this.model.set({email: text})

                            if(this.model.isValid(true)) {
                                app.appView.showLoader();
                                this.model.save({},{
                                    success : function (model, response, options) {
                                        inputElement.val('');
                                        if(response.alertClass == \"success\") {
                                            collaboratorCollection.add(model);
                                        }
                                        self.render();
                                        app.appView.hideLoader();
                                        app.appView.renderResponseAlert(response);
                                    },
                                    error: function (model, xhr, options) {
                                        if(url = xhr.getResponseHeader('Location'))
                                            window.location = url;
                                        var response = warningResponse;
                                        if(xhr.responseJSON)
                                            response = xhr.responseJSON;

                                        app.appView.hideLoader();
                                        app.appView.renderResponseAlert(response);
                                    }
                                });
                            } else {
                                inputElement.addClass('uv-field-error');
                                if(text)
                                    inputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>";
            // line 2457
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Email address is invalid"), "html", null, true);
            echo "</span>\");
                            }
                        }
                    ";
        }
        // line 2461
        echo "                }
            });

       
            // Ticket Tag Item View
            var TagItem = Backbone.View.extend({
                tagName : \"a\",
                className : \"uv-btn-tag\",
                template : _.template(\"<span class='uv-tag'>";
        // line 2469
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 2469, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_DELETE_TAG"], "method", false, false, false, 2469)) {
            echo "<span class='uv-icon-remove-dark-before'></span>";
        }
        echo "<%- name %></span>\"),
                events : {
                    'click .uv-tag' : \"confirmRemove\"
                },
                render : function () {
                    this.\$el.html(this.template(this.model.toJSON()));
                    return this;
                },
                unrender : function(response) {
                    if(response.alertMessage != undefined) {
                        tagListView.render();
                        app.appView.renderResponseAlert(response);
                    }
                },
                removeItem : function () {
                    ";
        // line 2484
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 2484, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_DELETE_TAG"], "method", false, false, false, 2484)) {
            // line 2485
            echo "                        self = this;
                        app.appView.showLoader();
                        this.model.destroy({
                            data : { 'ticketId' : ticketModel.id } ,
                            success : function (model, response, options) {
                                app.appView.hideLoader();
                                self.\$el.remove();
                                self.unrender(response);
                            },
                            error: function (model, xhr, options) {
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;
                                var response = warningResponse;
                                if(xhr.responseJSON)
                                    response = xhr.responseJSON;

                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(response);
                            }
                        });
                    ";
        }
        // line 2506
        echo "                },
                confirmRemove: function(e) {
                    e.preventDefault();
                    ";
        // line 2509
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 2509, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_DELETE_TAG"], "method", false, false, false, 2509)) {
            // line 2510
            echo "                        app.appView.openConfirmModal(this)
                    ";
        }
        // line 2512
        echo "                }
            });

            // Ticket Tag View
            var TagList = Backbone.View.extend({
                el : \$(\".tag-list-block\"),
                events : {
                    'keypress .uv-field' : 'addTag',
                    'focusout .uv-field' : 'removeErrorClass',
                    'click .uv-dropdown-list li': 'addTag'
                },
                render : function() {
                    var self = this;
                    this.\$el.find(\".tag-list\").html('');
                    if(tagCollection.length) {
                        _.each(tagCollection.models, function (item) {
                            this.renderTag(item);
                        }, this);
                    }
                },
                renderTag : function (item) {
                    var tag = new TagItem({
                        model: item
                    });
                    this.\$el.find('.tag-list').append(tag.render().el);
                },
                addTag : function(e) {
                    ";
        // line 2539
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 2539, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_ADD_TAG"], "method", false, false, false, 2539)) {
            // line 2540
            echo "                        var currentElement = Backbone.\$(e.currentTarget);
                        if(currentElement.is('li')) {
                            var inputElement = currentElement.parents('.uv-field-block').find('.uv-dropdown-other');
                            var text = currentElement.text().trim();
                        } else {
                            var inputElement = currentElement;
                            var text = inputElement.val().trim();
                        }
                        inputElement.removeClass('uv-field-error');
                        inputElement.parents('.uv-element-block').find('.uv-field-message').remove()
                        
                        if (currentElement.is('li') || (e.which === 13 && text)) {
                            if(text.length <= 20) {
                                if(tagCollection.isTagExist(text)) {
                                    var self = this;
                                    inputElement.val('');
                                    this.model = new TagModel();
                                    this.model.set({name:text});
                                    self = this;

                                    app.appView.showLoader();
                                    this.model.save({}, {
                                        success: function (model, response, options) {
                                            inputElement.parent().find(\"li:not(.uv-no-results)\").remove()
                                            inputElement.parent().find(\".uv-no-results\").show()
                                            if(!currentElement.is('li')) {
                                                inputElement.trigger('click')
                                            }
                                            if(response.alertClass == \"success\") {
                                                tagCollection.add(model);
                                                self.render();
                                            }

                                            app.appView.hideLoader();
                                            app.appView.renderResponseAlert(response);
                                        },
                                        error: function (model, xhr, options) {
                                            if(url = xhr.getResponseHeader('Location'))
                                                window.location = url;
                                            var response = warningResponse;
                                            if(xhr.responseJSON)
                                                response = xhr.responseJSON;

                                            app.appView.hideLoader();
                                            app.appView.renderResponseAlert(response);
                                        }
                                    });
                                } else {
                                    inputElement.addClass('uv-field-error');
                                    inputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>";
            // line 2589
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Tag with same name already exist"), "html", null, true);
            echo "</span>\");
                                }
                            } else {
                                inputElement.addClass('uv-field-error');
                                inputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>";
            // line 2593
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Text length should be less than 20 charactors"), "html", null, true);
            echo "</span>\");
                            }
                        }
                    ";
        }
        // line 2597
        echo "                },
                removeErrorClass: function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    inputElement.removeClass('uv-field-error');
                    inputElement.parents('.uv-element-block').find('.uv-field-message').remove()
                },
            });

            // Ticket Label Item View
            var LabelItem = Backbone.View.extend({
                tagName : \"a\",
                className : \"uv-btn-label\",
                template : _.template(\"<span class='uv-tag'><span class='uv-icon-remove-before'></span><%- name %></span>\"),
                events : {
                    'click .uv-tag' : \"confirmRemove\"
                },
                render : function () {
                    this.\$el.html(this.template(this.model.toJSON()));
                    return this;
                },
                unrender : function(response) {
                    if(response.alertMessage != undefined) {
                        labelListView.render();
                        app.appView.renderResponseAlert(response);
                    }
                },
                removeItem : function () {
                    self = this;
                    app.appView.showLoader();

                    this.model.destroy({
                        url : \"";
        // line 2628
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_update_ticket_attributes_xhr");
        echo "\",
                        data : { attribute :'label', 'ticketId': ticketModel.id, 'labelId': this.model.get('id') },
                        success : function (model, response, options) {
                            app.appView.hideLoader();
                            self.\$el.remove();
                            self.unrender(response);
                        },
                        error: function (model, xhr, options) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        }
                    });
                },
                confirmRemove: function(e) {
                    e.preventDefault();
                    app.appView.openConfirmModal(this)
                }
            });

            // Ticket Label View
            var LabelList = Backbone.View.extend({
                el : \$(\".label-list-block\"),
                events : {
                    'keypress .uv-field' : 'addLabel',
                    'focusout .uv-field' : 'removeErrorClass',
                    'click .uv-dropdown-list li': 'addLabel'
                },
                render : function() {
                    var self = this;
                    this.\$el.find(\".label-list\").html('');
                    if(labelCollection.length) {
                        _.each(labelCollection.models, function (item) {
                            this.renderLabel(item);
                        }, this);
                    }
                },
                renderLabel : function (item) {
                    var label = new LabelItem({
                        model: item
                    });
                    lavelItem = label.render().el;
                    \$(lavelItem).attr('style', 'background:' + item.attributes.color)
                    this.\$el.find('.label-list').append(lavelItem);
                },
                addLabel : function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    if(currentElement.is('li')) {
                        var inputElement = currentElement.parents('.uv-field-block').find('.uv-dropdown-other');
                        var text = currentElement.text().trim();
                    } else {
                        var inputElement = currentElement;
                        var text = inputElement.val().trim();
                    }
                    inputElement.removeClass('uv-field-error');
                    inputElement.parents('.uv-element-block').find('.uv-field-message').remove()

                    if (currentElement.is('li') || (e.which === 13 && text)) {
                        if(text.length <= 20) {
                            if(labelCollection.isLabelExist(text)) {
                                var self = this;
                                inputElement.val('');
                                this.model = new LabelModel();
                                this.model.set({name:text});
                                self = this;

                                app.appView.showLoader();
                                this.model.save({}, {
                                    success: function (model, response, options) {
                                        inputElement.parent().find(\"li:not(.uv-no-results)\").remove()
                                        inputElement.parent().find(\".uv-no-results\").show()
                                        if(!currentElement.is('li')) {
                                            inputElement.trigger('click')
                                        }
                                        if(response.alertClass == \"success\") {
                                            labelCollection.add(model);
                                            self.render();
                                        }

                                        app.appView.hideLoader();
                                        app.appView.renderResponseAlert(response);
                                    },
                                    error: function (model, xhr, options) {
                                        if(url = xhr.getResponseHeader('Location'))
                                            window.location = url;
                                        var response = warningResponse;
                                        if(xhr.responseJSON)
                                            response = xhr.responseJSON;

                                        app.appView.hideLoader();
                                        app.appView.renderResponseAlert(response);
                                    }
                                });
                            } else {
                                inputElement.addClass('uv-field-error');
                                inputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>";
        // line 2728
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Label with same name already exist"), "html", null, true);
        echo "</span>\");
                            }
                        } else {
                            inputElement.addClass('uv-field-error');
                            inputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>";
        // line 2732
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Text length should be less than 20 charactors"), "html", null, true);
        echo "</span>\");
                        }
                    }
                },
                removeErrorClass: function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    inputElement.removeClass('uv-field-error');
                    inputElement.parents('.uv-element-block').find('.uv-field-message').remove()
                },
            });
            
            // Ticket Router
            var Router = Backbone.Router.extend({
                routes: {
                    'thread/:thread' : 'threadRequestedId'
                },
                threadRequestedId: function(thread){
                    threadCollection.threadRequestedId = thread;
                },
                scrollPage : function(divId) {
                    if(\$(divId).length){
                        \$('li a[href=\"'+divId+'\"]').trigger('click');
                        \$('.uv-ticket-scroll-region').animate({
                            scrollTop: \$(divId).offset().top
                        }, 'slow');
                    } else if(divId == '#') { //scroll to last thread added
                        if(threadCollection.fullCollection.length)
                            this.scrollPage('#thread' + threadCollection.fullCollection.at(0).id);
                    }
                }
            });

            var customerForm = new CustomerForm({
                el : \$(\".uv-main-info-update-block\"),
                model : new CustomerModel()
            });

            var ticketNavigation = \$.parseJSON('";
        // line 2769
        echo json_encode((isset($context["ticketNavigationIteration"]) || array_key_exists("ticketNavigationIteration", $context) ? $context["ticketNavigationIteration"] : (function () { throw new RuntimeError('Variable "ticketNavigationIteration" does not exist.', 2769, $this->source); })()));
        echo "');

            var ticketModel = new TicketModel({
                id : \"";
        // line 2772
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2772, $this->source); })()), "id", [], "any", false, false, false, 2772), "html", null, true);
        echo "\",
                status : \"";
        // line 2773
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2773, $this->source); })()), "status", [], "any", false, false, false, 2773), "id", [], "any", false, false, false, 2773), "html", null, true);
        echo "\",
                priority : \"";
        // line 2774
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2774, $this->source); })()), "priority", [], "any", false, false, false, 2774), "id", [], "any", false, false, false, 2774), "html", null, true);
        echo "\",
                group : \"";
        // line 2775
        ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2775, $this->source); })()), "supportGroup", [], "any", false, false, false, 2775)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2775, $this->source); })()), "supportGroup", [], "any", false, false, false, 2775), "id", [], "any", false, false, false, 2775), "html", null, true))) : (print ("")));
        echo "\",
                subGroup : \"";
        // line 2776
        ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2776, $this->source); })()), "supportTeam", [], "any", false, false, false, 2776)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2776, $this->source); })()), "supportTeam", [], "any", false, false, false, 2776), "id", [], "any", false, false, false, 2776), "html", null, true))) : (print ("")));
        echo "\",
                agent : \"\",
                profileImage : \"\",
                isTrashed : \"";
        // line 2779
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2779, $this->source); })()), "isTrashed", [], "any", false, false, false, 2779), "html", null, true);
        echo "\"
            });

            ticketApp.ticketView = ticketView = new TicketView({
                model: ticketModel
            });

            uvdesk.ticket.model = ticketModel;
            
            threadCollection = new ThreadCollection();
            var threadList = new ThreadList();
            var pagination = new Pagination();

            var collaboratorCollection = new CollaboratorCollection(\$.parseJSON('";
        // line 2792
        echo json_encode(twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 2792, $this->source); })()), "getTicketCollaborators", [0 => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2792, $this->source); })()), "id", [], "any", false, false, false, 2792)], "method", false, false, false, 2792));
        echo "'));
            var collaboratorList = new CollaboratorList();
            collaboratorList.render();

            var tagCollection = new TagCollection(\$.parseJSON('";
        // line 2796
        echo json_encode(twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 2796, $this->source); })()), "getTicketTagsById", [0 => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2796, $this->source); })()), "id", [], "any", false, false, false, 2796)], "method", false, false, false, 2796));
        echo "'));
            var tagListView = new TagList();
            tagListView.render();

            var labelCollection = new LabelCollection(\$.parseJSON('";
        // line 2800
        echo json_encode(twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 2800, $this->source); })()), "getTicketLabels", [0 => twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2800, $this->source); })()), "id", [], "any", false, false, false, 2800)], "method", false, false, false, 2800));
        echo "'));
            var labelListView = new LabelList();
            labelListView.render();

            var router = new Router();
            Backbone.history.start({push_state:true});

            threadCollection.syncData();
        });
    </script>

    <script>
        var sfTinyMceNew = \$.extend({}, sfTinyMce);
        var toolbarOptions = sfTinyMce.options.toolbar;

\t\tsfTinyMce.init({
\t\t\tselector : '.uv-ticket-reply textarea',
\t\t\ttoolbar: toolbarOptions + ' | translate',
            mentions : getMentions(),
            images_upload_url: \"";
        // line 2819
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_thread_encoded_image_uploader", ["ticketId" => twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 2819, $this->source); })()), "request", [], "any", false, false, false, 2819), "get", [0 => "ticketId"], "method", false, false, false, 2819)]), "html", null, true);
        echo "\",
            setup: function(editor) {
                editor.on('keydown', function(e) { /** for pageup, pagedown keys **/
                    if(e.keyCode == 34 || e.keyCode == 33){
                        e.preventDefault();
                    }
                });
                addTranslateButton(editor);
            }
\t\t});

        function InitTinyMce(selector) {
            let sfTinyMceNew2 = \$.extend({}, sfTinyMceNew);
            sfTinyMceNew2.init({
                selector : selector,
                mentions : getMentions(),
                setup: function(editor) {
                    addTranslateButton(editor);
                }
            });
        }

        function getMentions(){
\t\t\treturn {
\t\t\t\tdelimiter: ['#'],
                items: 15,
\t\t\t\tsource: function(){
                    return [
                        {
                            name : \"";
        // line 2848
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Ticket Id"), "html", null, true);
        echo "\",
                            value : \"";
        // line 2849
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2849, $this->source); })()), "id", [], "any", false, false, false, 2849), "html", null, true);
        echo "\",
                        },
                        {
                            name : \"";
        // line 2852
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Subject"), "html", null, true);
        echo "\",
                            value : \"";
        // line 2853
        echo twig_escape_filter($this->env, twig_replace_filter(twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2853, $this->source); })()), "subject", [], "any", false, false, false, 2853), ["
" => " ", "" => " "]), "html", null, true);
        echo "\",
                        },
                        {
                            name : \"";
        // line 2856
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Status"), "html", null, true);
        echo "\",
                            value : \"";
        // line 2857
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2857, $this->source); })()), "status", [], "any", false, false, false, 2857), "description", [], "any", false, false, false, 2857), "html", null, true);
        echo "\",
                        },
                        {
                            name : \"";
        // line 2860
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Priority"), "html", null, true);
        echo "\",
                            value : \"";
        // line 2861
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2861, $this->source); })()), "priority", [], "any", false, false, false, 2861), "description", [], "any", false, false, false, 2861), "html", null, true);
        echo "\",
                        },
                        {
                            name : \"";
        // line 2864
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Type"), "html", null, true);
        echo "\",
                            value : \"";
        // line 2865
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2865, $this->source); })()), "type", [], "any", false, false, false, 2865)) ? (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2865, $this->source); })()), "type", [], "any", false, false, false, 2865), "description", [], "any", false, false, false, 2865)) : ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Not Assigned"))), "html", null, true);
        echo "\",
                        },
                        {
                            name : \"";
        // line 2868
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Group"), "html", null, true);
        echo "\",
                            value : \"";
        // line 2869
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2869, $this->source); })()), "supportGroup", [], "any", false, false, false, 2869)) ? (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2869, $this->source); })()), "supportGroup", [], "any", false, false, false, 2869), "description", [], "any", false, false, false, 2869)) : ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Not Assigned"))), "html", null, true);
        echo "\",
                        },
                        {
                            name : \"";
        // line 2872
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Team"), "html", null, true);
        echo "\",
                            value : \"";
        // line 2873
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2873, $this->source); })()), "supportTeam", [], "any", false, false, false, 2873)) ? (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["ticket"]) || array_key_exists("ticket", $context) ? $context["ticket"] : (function () { throw new RuntimeError('Variable "ticket" does not exist.', 2873, $this->source); })()), "supportTeam", [], "any", false, false, false, 2873), "description", [], "any", false, false, false, 2873)) : ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Not Assigned"))), "html", null, true);
        echo "\",
                        },
                        {
                            name : \"";
        // line 2876
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Customer Name"), "html", null, true);
        echo "\",
                            value : \"";
        // line 2877
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 2877, $this->source); })()), "name", [], "any", false, false, false, 2877), "html", null, true);
        echo "\",
                        },
                        {
                            name : \"";
        // line 2880
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Customer Email"), "html", null, true);
        echo "\",
                            value : \"";
        // line 2881
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["customer"]) || array_key_exists("customer", $context) ? $context["customer"] : (function () { throw new RuntimeError('Variable "customer" does not exist.', 2881, $this->source); })()), "email", [], "any", false, false, false, 2881), "html", null, true);
        echo "\",
                        },
                        {
                            name : \"";
        // line 2884
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent Name"), "html", null, true);
        echo "\",
                            value : \"";
        // line 2885
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, ($context["ticketAgent"] ?? null), "name", [], "any", true, true, false, 2885)) ? (twig_get_attribute($this->env, $this->source, (isset($context["ticketAgent"]) || array_key_exists("ticketAgent", $context) ? $context["ticketAgent"] : (function () { throw new RuntimeError('Variable "ticketAgent" does not exist.', 2885, $this->source); })()), "name", [], "any", false, false, false, 2885)) : ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Not Assigned"))), "html", null, true);
        echo "\",
                        },
                        {
                            name : \"";
        // line 2888
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Agent Email"), "html", null, true);
        echo "\",
                            value : \"";
        // line 2889
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, ($context["ticketAgent"] ?? null), "email", [], "any", true, true, false, 2889)) ? (twig_get_attribute($this->env, $this->source, (isset($context["ticketAgent"]) || array_key_exists("ticketAgent", $context) ? $context["ticketAgent"] : (function () { throw new RuntimeError('Variable "ticketAgent" does not exist.', 2889, $this->source); })()), "email", [], "any", false, false, false, 2889)) : ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Not Assigned"))), "html", null, true);
        echo "\",
                        }
                    ];
\t\t\t\t},
\t\t\t\tinsert: function(item) {
\t\t\t\t\treturn '<span>' + item.value + '</span>';
\t\t\t\t}
\t\t\t};
        }
    </script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework//ticket.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  4298 => 2889,  4294 => 2888,  4288 => 2885,  4284 => 2884,  4278 => 2881,  4274 => 2880,  4268 => 2877,  4264 => 2876,  4258 => 2873,  4254 => 2872,  4248 => 2869,  4244 => 2868,  4238 => 2865,  4234 => 2864,  4228 => 2861,  4224 => 2860,  4218 => 2857,  4214 => 2856,  4207 => 2853,  4203 => 2852,  4197 => 2849,  4193 => 2848,  4161 => 2819,  4139 => 2800,  4132 => 2796,  4125 => 2792,  4109 => 2779,  4103 => 2776,  4099 => 2775,  4095 => 2774,  4091 => 2773,  4087 => 2772,  4081 => 2769,  4041 => 2732,  4034 => 2728,  3931 => 2628,  3898 => 2597,  3891 => 2593,  3884 => 2589,  3833 => 2540,  3831 => 2539,  3802 => 2512,  3798 => 2510,  3796 => 2509,  3791 => 2506,  3768 => 2485,  3766 => 2484,  3746 => 2469,  3736 => 2461,  3729 => 2457,  3691 => 2421,  3689 => 2420,  3650 => 2383,  3646 => 2381,  3644 => 2380,  3639 => 2377,  3616 => 2356,  3614 => 2355,  3595 => 2341,  3499 => 2248,  3469 => 2221,  3405 => 2160,  3392 => 2150,  3385 => 2146,  3358 => 2122,  3345 => 2112,  3338 => 2108,  3311 => 2084,  3287 => 2062,  3243 => 2020,  3225 => 2005,  3215 => 1998,  3207 => 1993,  3179 => 1968,  3173 => 1965,  3143 => 1938,  3036 => 1834,  3031 => 1832,  2982 => 1786,  2707 => 1514,  2697 => 1507,  2689 => 1502,  2679 => 1495,  2671 => 1490,  2661 => 1483,  2652 => 1477,  2642 => 1470,  2630 => 1461,  2615 => 1449,  2608 => 1445,  2602 => 1442,  2580 => 1423,  2565 => 1411,  2558 => 1407,  2552 => 1404,  2545 => 1400,  2527 => 1385,  2507 => 1368,  2499 => 1363,  2495 => 1362,  2487 => 1357,  2479 => 1352,  2474 => 1350,  2464 => 1343,  2460 => 1342,  2435 => 1322,  2430 => 1320,  2415 => 1308,  2400 => 1296,  2392 => 1291,  2385 => 1287,  2377 => 1282,  2369 => 1279,  2364 => 1277,  2356 => 1271,  2347 => 1268,  2341 => 1267,  2336 => 1266,  2332 => 1265,  2328 => 1264,  2316 => 1255,  2313 => 1254,  2307 => 1251,  2302 => 1249,  2299 => 1248,  2297 => 1247,  2291 => 1244,  2286 => 1242,  2280 => 1240,  2274 => 1238,  2271 => 1237,  2265 => 1234,  2262 => 1233,  2260 => 1232,  2248 => 1223,  2241 => 1219,  2229 => 1210,  2224 => 1208,  2219 => 1206,  2207 => 1197,  2202 => 1195,  2197 => 1193,  2185 => 1184,  2174 => 1176,  2168 => 1173,  2164 => 1172,  2158 => 1170,  2148 => 1169,  2136 => 1166,  2133 => 1165,  2118 => 1153,  2113 => 1151,  2105 => 1146,  2097 => 1142,  2090 => 1136,  2087 => 1135,  2077 => 1126,  2074 => 1102,  2069 => 1080,  2060 => 1073,  2050 => 1065,  2045 => 1063,  2041 => 1062,  2037 => 1061,  2033 => 1060,  2028 => 1059,  2026 => 1058,  2022 => 1057,  2017 => 1055,  2010 => 1051,  2000 => 1044,  1996 => 1043,  1991 => 1041,  1985 => 1038,  1976 => 1032,  1968 => 1027,  1963 => 1025,  1955 => 1022,  1950 => 1020,  1947 => 1019,  1944 => 1018,  1936 => 1012,  1927 => 1006,  1923 => 1005,  1918 => 1003,  1912 => 1000,  1903 => 994,  1895 => 989,  1890 => 987,  1878 => 978,  1874 => 977,  1867 => 973,  1864 => 972,  1853 => 969,  1848 => 968,  1844 => 967,  1838 => 964,  1829 => 958,  1812 => 944,  1809 => 943,  1798 => 940,  1793 => 939,  1789 => 938,  1782 => 934,  1773 => 928,  1763 => 921,  1755 => 918,  1750 => 916,  1747 => 915,  1737 => 906,  1732 => 904,  1728 => 903,  1724 => 902,  1720 => 901,  1715 => 900,  1713 => 899,  1709 => 898,  1704 => 896,  1698 => 893,  1688 => 886,  1684 => 885,  1679 => 883,  1673 => 880,  1663 => 873,  1654 => 867,  1649 => 865,  1637 => 856,  1633 => 855,  1626 => 851,  1623 => 850,  1612 => 847,  1607 => 846,  1603 => 845,  1596 => 841,  1585 => 833,  1572 => 823,  1565 => 821,  1560 => 819,  1557 => 818,  1552 => 814,  1546 => 812,  1544 => 811,  1540 => 810,  1536 => 809,  1530 => 806,  1523 => 802,  1518 => 799,  1507 => 790,  1500 => 785,  1496 => 783,  1492 => 781,  1482 => 779,  1480 => 778,  1474 => 777,  1471 => 776,  1469 => 775,  1465 => 773,  1456 => 770,  1449 => 769,  1445 => 768,  1440 => 766,  1437 => 765,  1434 => 764,  1429 => 760,  1423 => 758,  1417 => 756,  1415 => 755,  1411 => 753,  1408 => 751,  1405 => 750,  1399 => 748,  1389 => 746,  1386 => 745,  1376 => 743,  1374 => 742,  1367 => 738,  1357 => 733,  1349 => 732,  1342 => 727,  1335 => 722,  1331 => 721,  1327 => 720,  1323 => 718,  1313 => 716,  1311 => 715,  1305 => 714,  1294 => 710,  1290 => 709,  1281 => 703,  1274 => 699,  1270 => 697,  1261 => 690,  1257 => 688,  1250 => 683,  1243 => 678,  1236 => 673,  1230 => 671,  1228 => 670,  1225 => 669,  1220 => 667,  1215 => 666,  1213 => 665,  1208 => 663,  1205 => 662,  1199 => 660,  1197 => 659,  1189 => 653,  1186 => 652,  1181 => 649,  1177 => 648,  1173 => 647,  1169 => 646,  1164 => 645,  1160 => 642,  1154 => 637,  1148 => 635,  1142 => 634,  1133 => 627,  1124 => 621,  1120 => 620,  1115 => 618,  1109 => 614,  1107 => 613,  1102 => 611,  1097 => 608,  1090 => 602,  1084 => 599,  1081 => 598,  1079 => 597,  1074 => 595,  1069 => 592,  1055 => 580,  1051 => 579,  1046 => 577,  1037 => 571,  1032 => 568,  1025 => 562,  1019 => 559,  1016 => 558,  1011 => 555,  1000 => 553,  996 => 552,  992 => 551,  983 => 545,  976 => 541,  971 => 540,  969 => 539,  964 => 537,  961 => 536,  956 => 532,  950 => 529,  947 => 528,  942 => 525,  931 => 523,  927 => 522,  922 => 520,  915 => 516,  910 => 514,  903 => 510,  898 => 509,  896 => 508,  891 => 506,  888 => 505,  883 => 501,  877 => 498,  874 => 497,  869 => 494,  858 => 492,  854 => 491,  846 => 486,  841 => 484,  832 => 481,  830 => 480,  825 => 478,  822 => 477,  817 => 473,  811 => 471,  805 => 467,  794 => 465,  790 => 464,  785 => 462,  776 => 459,  774 => 458,  769 => 456,  766 => 455,  761 => 451,  755 => 448,  752 => 447,  746 => 443,  733 => 441,  729 => 440,  724 => 438,  715 => 435,  713 => 434,  709 => 433,  704 => 431,  701 => 430,  696 => 426,  690 => 424,  685 => 421,  674 => 418,  669 => 417,  665 => 416,  657 => 411,  652 => 409,  643 => 406,  640 => 405,  638 => 404,  633 => 402,  630 => 401,  626 => 398,  623 => 396,  615 => 391,  609 => 388,  605 => 387,  597 => 382,  592 => 380,  584 => 375,  579 => 373,  571 => 368,  566 => 366,  560 => 363,  552 => 358,  548 => 357,  544 => 355,  541 => 354,  534 => 348,  528 => 346,  522 => 344,  520 => 343,  516 => 342,  509 => 338,  505 => 337,  498 => 333,  494 => 332,  490 => 330,  485 => 326,  479 => 324,  477 => 323,  474 => 322,  468 => 320,  466 => 319,  462 => 318,  458 => 317,  453 => 314,  447 => 312,  440 => 310,  438 => 309,  433 => 307,  430 => 306,  427 => 304,  418 => 299,  410 => 296,  400 => 292,  397 => 290,  387 => 289,  266 => 177,  216 => 130,  90 => 6,  80 => 5,  61 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends \"@UVDeskCoreFramework//Templates//layout.html.twig\" %}

{% block title %}{{ '#' ~ ticket.id ~ ' ' ~ ticket.subject }}{% endblock %}

{% block templateCSS %}
    <style>
        .uv-aside-ticket-labels.label-list-block .uv-btn-label {
            cursor: pointer;
        }
        .uv-main-info-update-block .uv-element-block {
            margin: 10px 0px !important;
        }
        .uv-tab-ellipsis {
            position: relative;
        }
        .uv-inner-section .uv-view .uv-ticket-section .uv-ticket-accordion .uv-ticket-wrapper {
            display: block;
        }
        .uv-element-block.cc-bcc .uv-dropdown-container {
            padding: 10px 20px 10px 20px;
        }
        .uv-action-buttons .uv-dropdown-list ul li {
            padding: 5px 0px !important;
        }
        .uv-action-buttons{
            margin-bottom: 40px !important;
        }
        .uv-ticket-reply .uv-element-block-textarea, .thread-edit-container .uv-element-block-textarea {
            width: 100% !important;
            max-width: 100% !important;
        }
        .thread-edit-container .uv-field-message {
            color: #FF5656 !important;
        }
        .uv-element-block .mce-tinymce {
            margin-top: 10px;
        }
        .uv-ticket-reply .uv-element-block-textarea .uv-field-message, .thread-edit-container .uv-element-block-textarea .uv-field-message {
            margin-top: 15px;
        }
        .thread-edit-container {
            margin-top: 10px;
        }
        .uv-ticket-viewer-bar{
            transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            height: 0px;
        }
        .uv-ticket-viewer-bar.active{
            height: 50px;
            margin-bottom: 10px;
            border-bottom: 1px dotted #f97278;
        }
        .uv-ticket-viewer-single {
            display: inline-block;
            margin-right: 5px;
        }
        .uv-ticket-viewer-single img {
            width: 40px;
            border-radius: 3px;
            display: inline-block;
            vertical-align: middle;
        }
        .uv-ticket-viewer-single.uv-first {
            width: 40px;
            height: 40px;
            background-image: linear-gradient(to right, #f97278 0%, #f181bf 100%);
            text-align: center;
            vertical-align: top;
            line-height: 30px;
            border-radius: 20px;
        }
        .uv-ticket-viewer-close {
            position: absolute;
            top: 0px;
            width: 40px;
            height: 40px;
            background: #f1f1f1;
            text-align: center;
            line-height: 35px;
            border-radius: 2px;
            opacity: .6;
            text-indent: 6px;
        }
        .uv-ticket-viewer-list {
            display: inline;
        }
        span.viewer-firstletter.img-thumbnail {
            width: 40px;
            height: 40px;
            display: block;
            text-align: center;
            font-size: 20px;
            font-style: italic;
            border: 1px dotted;
            border-radius: 4px;
            line-height: 35px;
        }
        .uv-ticket-viewer-close {
            display:none;
        }
        .uv-ticket-viewer-single:hover .uv-ticket-viewer-close {
            display: block;
        }
        .uv-hide{
            display: none;
        }
        .uv-info{
            background: #7C70F4;
        }
        .uv-ticket-viewer-list .uv-icon-eye-light{
            animation: jelly 0.8s infinite alternate ease-in-out;
        }
        .uv-aside-brick .uv-loader {
            position: absolute;
            transform: scale(0.5);
            top: 22px;
            right: 45px;
        }
        .uv-app-glyph-customfields {
            width: 20px;
            height: 20px;
            background-position: center center;
            background-repeat: no-repeat;
            cursor: pointer;
            display: inline-block;
            vertical-align: middle;
            margin: 5px 0px 5px 10px;
            background-image: url(\"{{ asset('bundles/uvdeskcoreframework/images/app-glyph-custom.svg') }}\");
        }
        .uv-no-threads {
            padding: 80px 20px;
            text-align: center;
        }
        .uv-ticket-strip-label {
            position: relative;
        }
        input.input-copy-thread-link {
            position: absolute;
            bottom: 10px;
            width: 400px;
        }
        .uv-ticket-action-bar-fixed{
            position: fixed;
            width: 100%;
            background: #fff;
            z-index: 999;
        }
        .uv-ticket-action-bar-fixed .uv-ticket-action-bar-rt{
            position: fixed;
            right: 0px;
            margin-top: 10px;
        }
        .uv-ticket-action-bar-fixed + .uv-ticket-viewer-bar{
            margin-top: 70px;
        }
        .uv-ticket-main {
            word-wrap: break-word;
        }
        @media only screen and (max-width: 900px) {
            .uv-ticket-action-bar-fixed{
                position: relative;
            }
            .uv-ticket-action-bar-fixed + .uv-ticket-viewer-bar{
                margin-top: 0px;
            }
            .uv-ticket-action-bar-fixed .uv-ticket-action-bar-rt{
                position: relative;
            }
        }
        .uv-icon-pin {
            width: 18px;
            height: 18px;
            display: inline-block;
            vertical-align: middle;
            background-image: url(\"{{ asset('bundles/uvdeskcoreframework/images/uvdesk-sprite.svg') }}\");
            background-position: 0px -396px;
            transition: transform .15s;
            transform: scale(1);
        }
        .uv-icon-pinned {
            background-position: -19px -396px;
        }
        .uv-header-fix{
            display: inline-block;
            margin: 0px 10px 0px 5px;
        }
        .uv-header-fix + .uv-tabs{
            display: inline-block;
        }
        .uv-ticket-section span.uv-mail-status {
            width: 16px;
            height: 16px;
            background: url('../../../../../bundles/webkuldefault/images/mail-status.png');
            cursor: help;
        }
        .uv-ticket-section .uv-mail-status.uv-mail-processed {
            background-position: 0 0;
        }
        .uv-ticket-section .uv-mail-status.uv-mail-open,.uv-ticket-section .uv-mail-status.uv-mail-delivered,.uv-ticket-section .uv-mail-status.uv-mail-click {
            background-position: -38px 0;
        }
        .uv-ticket-section .uv-mail-status.uv-mail-spam,.uv-ticket-section .uv-mail-status.uv-mail-deferred,.uv-ticket-section .uv-mail-spamreport {
            background-position: -55px 0;
        }
        .uv-ticket-section .uv-mail-status.uv-mail-bounce,.uv-ticket-section .uv-mail-status.uv-mail-dropped {
            background-position: -73px 0;
        }
        @media only screen and (max-width: 1480px) {
            .uv-inner-section .uv-view .uv-ticket-action-bar-fixed.uv-ticket-action-bar .uv-ticket-action-bar-rt{
                width: auto;
            }
        }
        @media only screen and (max-width: 1300px) {
            .uv-header-fix{
                margin: 0px 10px 0px 10px;
            }
        }

        @media only screen and (max-width: 900px) {
            .uv-ticket-action-bar-fixed{
                position: relative;
            }
            .uv-ticket-action-bar-fixed + .uv-ticket-viewer-bar{
                margin-top: 0px;
            }
            .uv-ticket-action-bar-fixed .uv-ticket-action-bar-rt{
                position: relative;
            }
            .uv-inner-section .uv-view .uv-ticket-action-bar.uv-ticket-action-bar-fixed .uv-ticket-action-bar-lt{
                width: 70%;
            }
            .uv-inner-section .uv-view .uv-ticket-action-bar.uv-ticket-action-bar-fixed .uv-ticket-action-bar-rt {
                width: 21%;
                padding-right: 33px;
            }
            .uv-header-fix{
                display: none;
            }
        }
        
        .uv-inner-section .uv-view .uv-ticket-scroll-region {
            margin-bottom: 0px;
        }
        
        .uv-inner-section .uv-view .uv-ticket-action-bar.uv-ticket-action-bar-fixed .uv-ticket-action-bar-rt {
            width: 21%;
            padding-right: 33px;
        }
        @media print {
            .uv-navbar,.uv-ticket-action-bar, .uv-sidebar, .uv-aside>.uv-aside-brick, .uv-aside-back, .uv-ticket-fixed-region, .uv-ticket-main.uv-ticket-reply, .uv-upload-actions, .uv-filter-view, .uv-dropdown-list>.uv-dropdown-container,.uv-notifications-wrapper,.uv-pop-up-overlay,.uv-loader-view, .uv-loader, .uv-navbar,.uv-ticket-count-wrapper {
                display: none !important;
            }
            .uv-ticket-scroll-region {
                overflow: visible;
                margin-bottom: 0 !important;
            }
            .uv-paper {
                padding-left: 0px !important; /* uv-view */
            }
            .uv-wrapper {
                left: 0 !important;
                margin: 0 !important;
            }
            .uv-inner-section .uv-view .uv-ticket-scroll-region  .uv-ticket-main-rt {
                width: 80%;
            }
            .uv-paper,.uv-view ,.uv-ticket-scroll-region, .uv-wrapper  {
                position: initial !important;
            }
        }

        .uv-ticket-action-bar-rt .app-glyph {
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
            cursor: pointer;
            height: 20px;
            width: 20px;
        }

        .uv-ticket-action-bar-rt .app-glyph:last-child {
            margin-right: 0px;
        }
    </style>
{% endblock %}

{% block pageContent %}
    <div class=\"uv-inner-section\">
        {# Ticket Sidebar #}
        <div class=\"uv-aside\" {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}style=\"display: none;\"{% endif %} >
            <div class=\"uv-main-info-block\">
                <div class=\"uv-aside-head\">
                    <div class=\"uv-aside-title\">
                        <h6>{{'Ticket'|trans}} #{{ ticket.id }}</h6>
                    </div>
                    <div class=\"uv-aside-back\">
                        <span onclick=\"history.length > 1 ? history.go(-1) : window.location = '{{ path(\"helpdesk_member_ticket_collection\") }}';\">{{'Back'|trans}}</span>
                    </div>
                </div>
        
                {# Ticket Information #}
                <div class=\"uv-aside-brick\">
                    {# Customer Details #}
                    <div class=\"uv-aside-customer-block\">
                        <h3>{{'Customer Information'|trans}}</h3>
                        <div class=\"uv-aside-avatar\">
                            {% if customer.thumbnail %}
                                <img src=\"{{ app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') }}{{ customer.thumbnail }}\">
                            {% else %}
                                <img src=\"{{ asset(default_customer_image_path) }}\">
                            {% endif %}
                        </div>

                        <div class=\"uv-aside-customer-info\">
                            <span>{{ customer.name }}</span>
                            <span>{{ customer.email }}</span>
                            {% if customer.contactNumber %}
                                <span>{{ customer.contactNumber }}</span>
                            {% endif %}

                            {% if user_service.isAccessAuthorized('ROLE_AGENT_MANAGE_CUSTOMER') %}
                                <span class=\"uv-customize\" data-toggle=\"tooltip\" title=\"{{'Edit Customer Information'|trans}}\"></span>
                            {% endif %}
                        </div>
                    </div>

                    {# Ticket Details #}
                    <div class=\"uv-aside-ticket-block\">
                        <div class=\"uv-aside-ticket-brick\">
                            <h3>{{'Total Replies'|trans}}</h3>
                            <span class=\"uv-icon-replies\"></span> <span>{{ totalReplies }}</span>
                        </div>

                        <div class=\"uv-aside-ticket-brick\">
                            <h3>{{'TimeStamp'|trans}}</h3>
                            <span class=\"uv-icon-timestamp\"></span> <span>{{ ticket_service.timeZoneConverter(initialThread.createdAt) }}</span>
                        </div>

                        <div class=\"uv-aside-ticket-brick\">
                            <h3>{{'Channel'|trans}}</h3>
                            {% if ticket.source == 'email' %}
                                <span class=\"uv-icon-channel uv-channel-email\"></span> <span>{{'Email'|trans}}</span>
                            {% else %}
                                <span class=\"uv-icon-channel uv-channel-web\"></span> <span>{{'Website'|trans}}</span>
                            {% endif %}
                        </div>
                    </div>
                </div>
            </div>

            {# Edit Customer Info #}
            {% if user_service.isAccessAuthorized('ROLE_AGENT_MANAGE_CUSTOMER') %}
                <div class=\"uv-main-info-update-block uv-no-error-success-icon\" style=\"display: none\">
                    <div class=\"uv-aside-head\">
                        <div class=\"uv-aside-title\"><h6>{{'Edit Customer'|trans}}</h6></div>
                        <div class=\"uv-aside-back\"><span>{{'Back'|trans}}</span></div>
                    </div>

                    <div class=\"uv-aside-brick\">
                        <form method=\"post\">
                            <input class=\"uv-field\" name=\"id\" type=\"hidden\" value=\"{{ customer.id }}\">

                            <div class=\"uv-element-block\">
                                <label class=\"uv-field-label\">{{'Name'|trans}}</label>
                                <div class=\"uv-field-block\">
                                    <input class=\"uv-field\" name=\"name\" type=\"text\" value=\"{{ customer.name }}\">
                                </div>
                            </div>

                            <div class=\"uv-element-block\">
                                <label class=\"uv-field-label\">{{'Email'|trans}}</label>
                                <div class=\"uv-field-block\">
                                    <input class=\"uv-field\" name=\"email\" type=\"text\" value=\"{{ customer.email }}\">
                                </div>
                            </div>

                            <div class=\"uv-element-block\">
                                <label class=\"uv-field-label\">{{'Contact Number'|trans}}</label>
                                <div class=\"uv-field-block\">
                                    <input class=\"uv-field\" name=\"contactNumber\" type=\"text\" value=\"{{ customer.contactNumber }}\">
                                </div>
                            </div>

                            <div class=\"uv-action-buttons\">
                                <a class=\"uv-btn update-btn\" href=\"#\">{{'Update'|trans}}</a>
                                <a class=\"uv-btn cancel-btn\" href=\"#\">{{'Cancel'|trans}}</a>
                            </div>

                            <input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token_generator.refreshToken('') }}\"/>
                        </form>
                    </div>
                </div>
            {% endif %}

            {# Edit Ticket #}
            <div class=\"uv-aside-brick\">
                <div class=\"uv-aside-ticket-actions\">
                    {# Update Ticket Agent #}
                    <div class=\"uv-aside-select\">
                        <label class=\"uv-aside-select-label\">{{'Agent'|trans}}</label>
                        <div>
                            {% set agentName = ticketAgent ? ticketAgent.name : 'Not Assigned' %}
                            {% if ticket.isTrashed == false and user_service.isAccessAuthorized('ROLE_AGENT_ASSIGN_TICKET') %}
                                <span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"{{ ticketAgent ? ticketAgent.id : '' }}\">{{ agentName }}</span>
                                <div class=\"uv-dropdown-list uv-bottom-left\">
                                    <div class=\"uv-dropdown-container\">
                                        <label>{{'Agent'|trans}}</label>
                                        <div class=\"uv-search-sm\">
                                            <input type=\"text\" class=\"uv-search-field\" placeholder=\"{{'Search'|trans}}\">
                                        </div>
                                    </div>

                                    <ul class=\"uv-agents-list agent\" data-action=\"agent\">
                                        {% for agent in user_service.getAgentPartialDataCollection() %}
                                            <li data-index=\"{{ agent.id }}\">
                                                <img src=\"{{ agent.smallThumbnail != null ? app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') ~ agent.smallThumbnail : asset(default_agent_image_path) }}\"/> {{ agent.name }}
                                            </li>
                                        {% endfor %}
                                    </ul>
                                </div>
                            {% else %}
                                <span class=\"uv-aside-select-value\">{{ agentName }}</span>
                            {% endif %}
                        </div>
                    </div>

                    {# Update Ticket Priority #}
                    <div class=\"uv-aside-select\">
                        <label class=\"uv-aside-select-label\">{{'Priority'|trans}}</label>
                        <div>
                            <span class=\"uv-list-ticket-priority\" style=\"background: {{ ticket.priority.colorCode }}\"></span>
                            {% if user_service.isAccessAuthorized('ROLE_AGENT_UPDATE_TICKET_PRIORITY') %}
                                <span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"{{ ticket.priority.id }}\">{{ ticket.priority.description }}</span>
                                <div class=\"uv-dropdown-list uv-bottom-left\">
                                    <div class=\"uv-dropdown-container\">
                                        <label>{{'Priority'|trans}}</label>
                                        <ul class=\"priority\" data-action=\"priority\">
                                            {% for priority in ticketPriorityCollection %}
                                                <li data-index=\"{{ priority.id }}\" data-color=\"{{ priority.colorCode }}\"><a href=\"#\">{{ priority.description }}</a></li>
                                            {% endfor %}
                                        </ul>
                                    </div>
                                </div>
                            {% else %}
                                <span class=\"uv-aside-select-value\">
                                    {{ ticket.priority.description }}
                                </span>
                            {% endif %}
                        </div>
                    </div>

                    {# Update Ticket Status #}
                    <div class=\"uv-aside-select\">
                        <label class=\"uv-aside-select-label\">{{'Status'|trans}}</label>
                        <div>
                            {% if user_service.isAccessAuthorized('ROLE_AGENT_UPDATE_TICKET_STATUS') %}
                                <span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"{{ ticket.status.id }}\">{{ ticket.status.description }}</span>
                                <div class=\"uv-dropdown-list uv-bottom-left\">
                                    <div class=\"uv-dropdown-container\">
                                        <label>{{'Status'|trans}}</label>
                                        <ul class=\"status\" data-action=\"status\">
                                            {% for status in ticketStatusCollection %}
                                                <li data-index=\"{{ status.id }}\"><a href=\"#\">{{ status.description }}</a></li>
                                            {% endfor %}
                                        </ul>
                                    </div>
                                </div>
                            {% else %}
                                <span class=\"uv-aside-select-value\">{{ ticket.status.description }}</span>
                            {% endif %}
                        </div>
                    </div>

                    {# Update Ticket Type #}
                    <div class=\"uv-aside-select\">
                        <label class=\"uv-aside-select-label\">{{'Type'|trans}}</label>
                        <div>
                            {% if user_service.isAccessAuthorized('ROLE_AGENT_UPDATE_TICKET_TYPE') %}
                                <span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"{{ ticket.type ? ticket.type.id : '-- --' }}\">{{ ticket.type ? ticket.type.description : \"{{'Not Assigned'|trans}}\" }}</span>
                                <div class=\"uv-dropdown-list uv-bottom-left\">
                                    <div class=\"uv-dropdown-container\">
                                        <label>{{'Type'|trans}}</label>
                                        <div class=\"uv-search-sm\">
                                            <input type=\"text\" class=\"uv-search-field\" placeholder=\"{{'Search'|trans}}\">
                                        </div>
                                    </div>

                                    <ul class=\"uv-search-list type\" data-action=\"type\">
                                        {% for type in ticketTypeCollection %}
                                            <li data-index=\"{{ type.id }}\"><a href=\"#\">{{ type.description }}</a></li>
                                        {% endfor %}
                                    </ul>
                                </div>
                            {% else %}
                                <span class=\"uv-aside-select-value\">
                                    {{ ticket.type ? ticket.type.description : 'Not Assigned' }}
                                </span>
                            {% endif %}
                        </div>
                    </div>

                    {# Update Ticket Support Group #}
                    <div class=\"uv-aside-select\">
                        <label class=\"uv-aside-select-label\">{{'Group'|trans}}</label>
                        <div>
                            {% if user_service.isAccessAuthorized('ROLE_AGENT_ASSIGN_TICKET_GROUP') %}
                                <span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"{{ ticket.supportGroup ? ticket.supportGroup.id : '-- --' }}\">
                                    {{ ticket.supportGroup ? ticket.supportGroup.name : 'Not Assigned' }}
                                </span>
                                <div class=\"uv-dropdown-list uv-bottom-left\">
                                    <div class=\"uv-dropdown-container\">
                                        <label>{{'Group'|trans}}</label>
                                        <div class=\"uv-search-sm\">
                                            <input type=\"text\" class=\"uv-search-field\" placeholder=\"{{'Search'|trans}}\">
                                        </div>
                                    </div>
                                    <ul class=\"uv-search-list group\" data-action=\"group\">
                                        <li data-index=\"\"><a href=\"#\">{{'Not Assigned'|trans}}</a></li>

                                        {% for group in supportGroupCollection %}
                                            <li data-index=\"{{ group.id }}\"><a href=\"#\">{{ group.name }}</a></li>
                                        {% endfor %}
                                    </ul>
                                </div>
                            {% else %}
                                <span class=\"uv-aside-select-value\">
                                    {{ ticket.supportGroup ? ticket.supportGroup.name : 'Not Assigned' }}
                                </span>
                            {% endif %}
                        </div>
                    </div>

                    {# Update Ticket Support Team #}
                    <div class=\"uv-aside-select\">
                        <label class=\"uv-aside-select-label\">{{'Team'|trans}}</label>
                        <div>
                            {% if user_service.isAccessAuthorized('ROLE_AGENT_ASSIGN_TICKET_GROUP') %}
                                <span class=\"uv-aside-select-value uv-dropdown-other uv-aside-drop-icon\" data-id=\"{{ ticket.supportTeam ? ticket.supportTeam.id : '-- --' }}\">
                                    {{ ticket.supportTeam ? ticket.supportTeam.name : 'Not Assigned' }}
                                </span>
                                <div class=\"uv-dropdown-list uv-bottom-left\">
                                    <div class=\"uv-dropdown-container\">
                                        <label>{{ 'Team'|trans }}</label>
                                        <div class=\"uv-search-sm\">
                                            <input type=\"text\" class=\"uv-search-field\" placeholder=\"Search\">
                                        </div>
                                    </div>
                                    <ul class=\"uv-search-list team\" data-action=\"team\">
                                        <li data-index=\"\"><a href=\"#\">{{ 'Not Assigned'|trans }}</a></li>
                                        {% for team in supportTeamCollection %}
                                            <li data-index=\"{{ team.id }}\"><a href=\"#\">{{ team.name }}</a></li>
                                        {% endfor %}
                                    </ul>
                                </div>
                            {% else %}
                                <span class=\"uv-aside-select-value\">
                                    {{ ticket.supportTeam ? ticket.supportTeam.name : 'Not Assigned'|trans }}
                                </span>
                            {% endif %}
                        </div>
                    </div>
                </div>
            </div>

            {# Ticket Labels #}
            <div class=\"uv-aside-brick\">
                <div class=\"uv-aside-ticket-labels label-list-block\">
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{'Labels'|trans}}</label>

                        <div class=\"uv-field-block\">
                            <input class=\"uv-field uv-dropdown-other\" type=\"text\" data-type=\"label\">
                            <div class=\"uv-dropdown-list uv-top-left\">
                                <div class=\"uv-dropdown-container\">
                                    <label>{{'Filter With'|trans}}</label>
                                    <ul class=\"\">
                                        <span class=\"uv-filter-info\">{{'Type atleast 2 letters'|trans}}</span>
                                        <span class=\"uv-no-results\" style=\"display: none;\">{{'No result found'|trans}}</span>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"label-list\"></div>
                </div>
            </div>

            {# Ticket Collaborators #}
            <div class=\"uv-aside-brick collaborator-list-block\">
                <div class=\"uv-aside-ticket-labels\">
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{'Collaborators'|trans}}</label>

                        {% if user_service.isAccessAuthorized('ROLE_AGENT_ADD_COLLABORATOR_TO_TICKET') %}
                            <div class=\"uv-field-block\">
                                <input class=\"uv-field\" type=\"text\" name=\"email\" type=\"text\" value=\"\" placeholder=\"{{'Type email to add'|trans}}\">
                            </div>
                        {% endif %}
                    </div>
                    <div class=\"collaborator-list\" style=\"margin-top: 10px\"></div>
                </div>
            </div>

            {# Ticket Tags #}
            <div class=\"uv-aside-brick tag-list-block\">
                <div class=\"uv-aside-ticket-labels\">
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{'Tags'|trans}}</label>

                        {% if user_service.isAccessAuthorized('ROLE_AGENT_ADD_TAG') %}
                            <div class=\"uv-field-block\">
                                <input class=\"uv-field uv-dropdown-other\" name=\"tag-name\" type=\"text\" data-type=\"tag\" value=\"\">
                                <div class=\"uv-dropdown-list uv-bottom-left\">
                                    <div class=\"uv-dropdown-container\">
                                        <label>{{'Filter With'|trans}}</label>
                                        <ul class=\"\">
                                            <span class=\"uv-filter-info\">{{'Type atleast 2 letters'|trans}}</span>
                                            <span class=\"uv-no-results\" style=\"display: none;\">{{'No result found'|trans}}</span>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        {% endif %}
                    </div>

                    <div class=\"tag-list\" style=\"margin-top: 10px\"></div>
                </div>
            </div>
        </div>

        <div class=\"uv-view {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view{% endif %}\" >
            <div class=\"uv-ticket-scroll-region {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-aside-view-tv{% endif %}\" >
                {# Ticket Header CTA #}
                <div class=\"uv-ticket-action-bar\">
                    <div class=\"uv-ticket-action-bar-lt\">
                        <div class=\"uv-header-fix\"><a href=\"#\" class=\"uv-icon-pin\"></a></div>

                        {# Thread Actions #}
                        <div class=\"uv-tabs\">
                            <ul>
                                {# Filter Threads #}
                                <li for=\"default\" data-type=\"all\" class=\"uv-tab-active\">{{'All Threads'|trans}}</li>
                                <li for=\"default\" data-type=\"reply\">{{'Replies'|trans}}</li>
                                <li for=\"default\" data-type=\"forward\">{{'Forwards'|trans}}</li>
                                <li for=\"default\" data-type=\"note\">{{'Notes'|trans}}</li>
                                <li for=\"default\" data-type=\"pinned\">{{'Pinned'|trans}}</li>

                                {# Update Threads #}
                                {% if user_service.isAccessAuthorized('ROLE_AGENT_EDIT_TICKET') or user_service.isAccessAuthorized('ROLE_AGENT_DELETE_TICKET') %}
                                    <li class=\"uv-tab-ellipsis uv-ticket-action\">
                                        <span class=\"uv-icon-ellipsis uv-dropdown-other\"></span>

                                        <div class=\"uv-dropdown-list uv-bottom-right\">
                                            <div class=\"uv-dropdown-container\">
                                                <ul class=\"priority\" data-action=\"priority\">
                                                    {% if user_service.isAccessAuthorized('ROLE_AGENT_EDIT_TICKET') %}
                                                        <li data-action=\"edit\" class=\"uv-open-popup\" data-target=\"edit-ticket-modal\">{{'Edit Ticket'|trans}}</li>
                                                    {% endif %}

                                                    <li data-action=\"print\">{{'Print Ticket'|trans}}</li>

                                                    {% if user_service.isAccessAuthorized('ROLE_AGENT_UPDATE_TICKET_STATUS') %}
                                                        <li data-action=\"spam\" data-index=\"6\">{{'Mark as Spam'|trans}}</li>
                                                        <li data-action=\"closed\" data-index=\"5\">{{'Mark as Closed'|trans}}</li>
                                                    {% endif %}

                                                    {% if user_service.isAccessAuthorized('ROLE_AGENT_DELETE_TICKET') %}
                                                        <li data-action=\"delete\" class=\"uv-text-danger\">{{'Delete Ticket'|trans}}</li>
                                                    {% endif %}
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                {% endif %}
                            </ul>
                        </div>
                    </div>

                    <div class=\"uv-ticket-action-bar-rt\">
                        {{ uvdesk_extensibles.getRegisteredComponent(\"Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Tickets\\\\WidgetCollection\").embedSideFilterIcons()|raw }}
                    </div>
                </div>

                {# Ticket Active Users #}
                <div class=\"uv-ticket-viewer-bar\">
                    <div class=\"uv-ticket-viewer-list\">
                        <div class=\"uv-ticket-viewer-single uv-first\" title=\"{{'Currently active agents on ticket'|trans}}...\">
                            <span class=\"uv-icon-eye-light\"></span>
                        </div>
                    </div>
                </div>

                {# Ticket Header #}
                <div class=\"uv-ticket-head\">
                    <div class=\"uv-ticket-head-lt\">
                        <span class=\"uv-star-large {{ ticket.isStarred ? 'uv-star-active' : '' }} uv-star uv-margin-right-5\"></span>
                    </div>

                    <div class=\"uv-ticket-head-rt\">
                        <h1>{{ ticket.subject }}</h1>
                    </div>
                </div>

                <div class=\"uv-ticket-strip\">
                    <span>
                        <span class=\"uv-ticket-strip-label\">{{'Created'|trans}} - </span>
                        <span class=\"timeago uv-margin-0\" data-timestamp=\"{{ ticket.createdAt.getTimestamp() }}\" title=\"{{ ticket.createdAt.format('d-m-Y h:ia') }}\">{{ ticket_service.timeZoneConverter(initialThread.createdAt) }}</span>
                    </span>

                    <span>
                        <span class=\"uv-ticket-strip-label\">{{'By'|trans}} - </span> {{ initialThread.user.name }}
                        {% if totalCustomerTickets %}
                            (<a id=\"more-tickets-btn\" href=\"{{ path('helpdesk_member_ticket_collection') }}#customer/{{customer.id}}\" target=\"_blank\">{{ (totalCustomerTickets - 1) ~ (' more tickets') }}</a>)
                        {% endif %}
                    </span>

                    <span class=\"agent-info\" style=\"{{ ticketAgent ? '' : 'display: none' }}\">
                        <span class=\"uv-ticket-strip-label\">{{'Agent'|trans}} - </span>
                        <span class=\"name\">{{ ticketAgent ? ticketAgent.name : '' }}</span>
                    </span>
                </div>

                {# Thread Tab View #}
                <div class=\"uv-tab-view uv-tab-view-active\" id=\"default\">
                    <div class=\"uv-ticket-section\">
                        <div class=\"uv-ticket-main create\">
                            <div class=\"uv-ticket-strip\">
                                <span>
                                    <span class=\"timeago uv-margin-0\" data-timestamp=\"{{ ticket.createdAt.getTimestamp() }}\" title=\"{{ ticket.createdAt.format('d-m-Y h:ia') }}\">{{ ticket_service.timeZoneConverter(ticket.createdAt) }}</span>
                                    - {{ initialThread.user.name }} <span class=\"uv-ticket-strip-label\">{{'created Ticket'|trans}}</span>
                                </span>
                            </div>

                            <div class=\"uv-ticket-main-lt\">
                                <img src=\"{{ customer.thumbnail ? app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') ~ (customer.thumbnail) : asset(default_customer_image_path) }}\">
                            </div>

                            <div class=\"uv-ticket-main-rt\">
                                {% if initialThread.createdBy == 'customer' %}
                                    <a href=\"{{ path('helpdesk_member_manage_customer_account') }}/{{ initialThread.user.id}}\" class=\"uv-ticket-member-name\">{{ initialThread.user.name }}</a>
                                {% else %}
                                    {% if initialThread.user %}
                                        <a href=\"{{ path('helpdesk_member_account') }}/{{ initialThread.user.id}}\" class=\"uv-ticket-member-name\">{{ initialThread.user.name }}</a>
                                    {% else %}
                                        <a class=\"uv-ticket-member-name\">{{ initialThread.user.name }}</a>
                                    {% endif %}
                                {% endif %}

                                {# Ticket Message #}
                                <div class=\"message\">
                                    <p>
                                        {% if initialThread.message|striptags == initialThread.message %}
                                            {{ initialThread.message|nl2br }}
                                        {% else %}
                                            {{ initialThread.message|raw }}
                                        {% endif %}
                                    </p>
                                </div>

                                {# Ticket Attachments #}
                                {% if initialThread.attachments|length %}
                                    <div class=\"uv-ticket-uploads\">
                                        <h4>{{'Uploaded Files'|trans}}</h4>
                                        <div class=\"uv-ticket-uploads-strip\">
                                            {% for attachment in initialThread.attachments %}
                                                <a href=\"{{ attachment.downloadURL }}\" target = \"_blank\" class=\"uv-ticket-uploads-brick uv-no-pointer-events\" data-toggle=\"tooltip\" title=\"{{ attachment.name }}\">
                                                    <img src=\"{{ attachment.iconURL }}\"  class=\"uv-auto-pointer-events\"/>
                                                </a>
                                            {% endfor %}
                                        </div>

                                        {% if initialThread.attachments|length > 1 %}
                                            <div class=\"uv-upload-actions\">
                                                <a href=\"#\" class=\"uv-open-in-files\" data-thread=\"{{ initialThread.id }}\" style=\"display: none\"><span class=\"uv-icon-open-in-files\"></span>{{'Open in Files'|trans}}</a>
                                                {% if initialThread.attachments|length %}
                                                    <a href=\"{{ path('helpdesk_member_ticket_download_attachment_zip') }}/{{ initialThread.id }}\" target=\"_blank\"><span class=\"uv-icon-attachment\"></span>{{' Download (as .zip)'|trans}}</a>
                                                {% endif %}
                                            </div>
                                        {% endif %}
                                    </div>
                                {% endif %}
                            </div>
                        </div>

                        <div class=\"uv-ticket-accordion\">
                            <div class=\"uv-ticket-count-wrapper\">
                                <span class=\"uv-ticket-count-stat\">{{ totalReplies }}</span>
                            </div>

                            <div class=\"uv-ticket-wrapper thread-list\"></div>
                        </div>
                    </div>
                </div>

                {# Reply Ticket View #}
                <div class=\"uv-ticket-main uv-ticket-reply uv-no-error-success-icon\">
                    <div class=\"uv-ticket-main-lt\">
                        <span class=\"uv-icon-ellipsis\"></span>
                        <img src=\"{{ currentUserDetails.thumbnail ? app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') ~ currentUserDetails.thumbnail : asset(default_agent_image_path) }}\" />
                    </div>

                    <div class=\"uv-ticket-main-rt\">
                        <span class=\"uv-ticket-member-name\">{{ currentUserDetails.name }}</span>
                        <div class=\"uv-tabs\">
                            <ul>
                                <li for=\"reply\" class=\"uv-tab-active\">{{'Reply'|trans}}</li>
                                <li for=\"forward\">{{'Forward'|trans}}</li>
                                {% if user_service.isAccessAuthorized('ROLE_AGENT_ADD_NOTE') %}
                                    <li for='note'>{{'Note'|trans}}</li>
                                {% endif %}
                            </ul>
                        </div>

                        {# Ticket Thread | Add Reply #}
                        <div class=\"uv-tab-view uv-tab-view-active\" id=\"reply\">
                            <form enctype=\"multipart/form-data\" method=\"post\" action=\"{{ path('helpdesk_member_add_ticket_thread', {'ticketId': ticket.id }) }}\">
                                <input name=\"threadType\" value=\"reply\" type=\"hidden\">
                                <input name=\"status\" value=\"\" type=\"hidden\" {% if user_service.isAccessAuthorized('ROLE_AGENT_UPDATE_TICKET_STATUS') %}class=\"reply-status\"{% endif %}>
                                <div class=\"uv-element-block collaborators\" style=\"display: none\">
                                    <label class=\"uv-field-label\">{{'Collaborators'|trans}}</label>
                                    <div class=\"uv-field-block\"></div>
                                </div>

                                <div class=\"uv-element-block cc-bcc\">
                                    <label>
                                        <div class=\"uv-checkbox\">
                                            <input type=\"checkbox\" class=\"cc-bcc-toggle\">
                                            <span class=\"uv-checkbox-view\"></span>
                                        </div>
                                        <span class=\"uv-checkbox-label\">{{'CC/BCC'|trans}}</span>
                                    </label>

                                    <div class=\"uv-field-block\" style=\"display: none\">
                                        <div class=\"uv-group\">
                                            <input class=\"uv-group-field uv-dropdown-other preloaded uv-manual-enter\" type=\"text\">
                                            <div class=\"uv-dropdown-list uv-bottom-left\">
                                                <div class=\"uv-dropdown-container\">
                                                    <label>{{'Agent'|trans}}</label>
                                                </div>

                                                <ul class=\"uv-agents-list\">
                                                    {% for agent in user_service.getAgentPartialDataCollection %}
                                                        <li data-id=\"{{ agent.email }}\">
                                                            <img src=\"{{ agent.smallThumbnail ? app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') ~ agent.smallThumbnail : asset(default_agent_image_path) }}\"/> {{agent.name}}
                                                        </li>
                                                    {% endfor %}

                                                    <li class=\"uv-no-results\" style=\"display: none;\">{{'No result found'|trans}}</li>
                                                </ul>
                                            </div>
                                            <select class=\"uv-group-select cc-bcc-select\">
                                                <option value=\"bcc\">{{'BCC'|trans}}</option>
                                                <option value=\"cc\">{{'CC'|trans}}</option>
                                            </select>
                                        </div>

                                        <div class=\"cc-bcc-list\"></div>
                                    </div>
                                </div>

                                <div class=\"uv-element-block uv-element-block-textarea\">
                                    <label class=\"uv-field-label\">{{'Write a reply'|trans}}</label>
                                    <div class=\"uv-field-block\">
                                        <textarea class=\"uv-field\" name=\"reply\" id=\"reply-area\">{{ ticket_service.getAgentDraftReply() }}</textarea>
                                    </div>
                                </div>

                                <div class=\"uv-element-block attachment-block\">
                                    <label>
                                        <span class=\"uv-file-label\">{{'Add Attachment'|trans}}</span>
                                    </label>
                                </div>

                                <div class=\"uv-action-buttons\">
                                    <div class=\"uv-dropdown next-view\">
                                        <input type=\"hidden\" name=\"nextView\" value=\"stay\"/>
                                        <div class=\"uv-dropdown-btn\" style=\"padding: 9px 27px 9px 10px;\">{{'Stay on ticket'|trans}}</div>
                                        <div class=\"uv-dropdown-list uv-top-left\" style=\"opacity: 1;\">
                                            <div class=\"uv-dropdown-container\">
                                                <label>{{'After Reply'|trans}}</label>
                                                <ul>
                                                    <li data-value=\"stay\">{{'Stay on ticket'|trans}}</li>
                                                    <li data-value=\"redirect\">{{'Redirect to list'|trans}}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=\"uv-dropdown reply\">
                                        <div class=\"uv-btn uv-dropdown-other\">{{'Reply'|trans}} <span class=\"uv-icon-down-light\"></span></div>
                                        <div class=\"uv-dropdown-list uv-top-left\">
                                            <div class=\"uv-dropdown-container\">
                                                <label>{{'Reply'|trans}}</label>
                                                <ul>
                                                    <li data-id=\"\">{{'Submit'|trans}}</li>
                                                    {% if user_service.isAccessAuthorized('ROLE_AGENT_UPDATE_TICKET_STATUS') %}
                                                        <li data-id=\"open\">{{'Submit And Open'|trans}}</li>
                                                        <li data-id=\"pending\">{{'Submit And Pending'|trans}}</li>
                                                        <li data-id=\"answered\">{{'Submit And Answered'|trans}}</li>
                                                        <li data-id=\"resolved\">{{'Submit And Resolved'|trans}}</li>
                                                        <li data-id=\"closed\">{{'Submit And Closed'|trans}}</li>
                                                    {% endif %}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {# Ticket Thread | Forward Thread #}
                        <div class=\"uv-tab-view\" id=\"forward\">
                            <form enctype=\"multipart/form-data\" method=\"post\" action=\"{{ path('helpdesk_member_add_ticket_thread', {'ticketId': ticket.id }) }}\">
                                <input name=\"threadType\" value=\"forward\" type=\"hidden\">
                                <input name=\"status\" value=\"\" type=\"hidden\" {% if user_service.isAccessAuthorized('ROLE_AGENT_UPDATE_TICKET_STATUS') %}class=\"reply-status\"{% endif %}>

                                <div class=\"uv-element-block\">
                                    <label class=\"uv-field-label\">{{'Subject'|trans}}</label>
                                    <div class=\"uv-field-block\">
                                        <input class=\"uv-field\" type=\"text\" name=\"subject\">
                                    </div>
                                </div>

                                <div class=\"uv-element-block to\">
                                    <label class=\"uv-field-label\">{{'To'|trans}}</label>
                                    <div class=\"uv-field-block\">
                                        <input class=\"uv-field uv-dropdown-other preloaded uv-to-message uv-manual-enter\" type=\"text\">
                                        
                                        <div class=\"uv-dropdown-list uv-bottom-left\">
                                            <div class=\"uv-dropdown-container\">
                                                <label>{{'Agent'|trans}}</label>
                                            </div>

                                            <ul class=\"uv-agents-list\">
                                                {% for agent in user_service.getAgentPartialDataCollection %}
                                                    <li data-id=\"{{ agent.email }}\">
                                                        <img src=\"{{ agent.smallThumbnail ? app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') ~ agent.smallThumbnail : asset(default_agent_image_path) }}\"/> {{agent.name}}
                                                    </li>
                                                {% endfor %}

                                                <li class=\"uv-no-results\" style=\"display: none;\">{{'No result found'|trans}}</li>
                                            </ul>
                                        </div>

                                        <div class=\"to-list\"></div>
                                    </div>
                                </div>

                                <div class=\"uv-element-block cc-bcc\">
                                    <label>
                                        <div class=\"uv-checkbox\">
                                            <input type=\"checkbox\" class=\"cc-bcc-toggle\">
                                            <span class=\"uv-checkbox-view\"></span>
                                        </div>
                                        <span class=\"uv-checkbox-label\">{{'CC/BCC'|trans}}</span>
                                    </label>
                                    <div class=\"uv-field-block\" style=\"display: none\">
                                        <div class=\"uv-group\">
                                            <input class=\"uv-group-field uv-dropdown-other preloaded uv-manual-enter\" type=\"text\">
                                            <div class=\"uv-dropdown-list uv-bottom-left\">
                                                <div class=\"uv-dropdown-container\"><label>{{'Agent'|trans}}</label></div>

                                                <ul class=\"uv-agents-list\">
                                                    {% for agent in user_service.getAgentPartialDataCollection %}
                                                        <li data-id=\"{{ agent.email }}\">
                                                            <img src=\"{{ agent.smallThumbnail ? app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') ~ agent.smallThumbnail : asset(default_agent_image_path) }}\"/> {{agent.name}}
                                                        </li>
                                                    {% endfor %}

                                                    <li class=\"uv-no-results\" style=\"display: none;\">{{'No result found'|trans}}</li>
                                                </ul>
                                            </div>
                                            <select class=\"uv-group-select cc-bcc-select\">
                                                <option value=\"bcc\">{{'BCC'|trans}}</option>
                                                <option value=\"cc\">{{'CC'|trans}}</option>
                                            </select>
                                        </div>

                                        <div class=\"cc-bcc-list\"></div>
                                    </div>
                                </div>

                                <div class=\"uv-element-block uv-element-block-textarea\">
                                    <label class=\"uv-field-label\">{{'Write a reply'|trans}}</label>
                                    <div class=\"uv-field-block\">
                                        <textarea class=\"uv-field\" name=\"reply\" id=\"forward-area\">{{ ticket_service.getAgentDraftReply() }}</textarea>
                                    </div>
                                </div>

                                <div class=\"uv-element-block attachment-block\">
                                    <label><span class=\"uv-file-label\">{{'Add Attachment'|trans}}</span></label>
                                </div>

                                <div class=\"uv-action-buttons\">
                                    <div class=\"uv-dropdown next-view\">
                                        <input type=\"hidden\" name=\"nextView\" value=\"stay\"/>
                                        <div class=\"uv-dropdown-btn\" style=\"padding: 9px 27px 9px 10px;\">{{'Stay on ticket'|trans}}</div>
                                        <div class=\"uv-dropdown-list uv-top-left\" style=\"opacity: 1;\">
                                            <div class=\"uv-dropdown-container\">
                                                <label>{{'After Reply'|trans}}</label>
                                                <ul>
                                                    <li data-value=\"stay\">{{'Stay on ticket'|trans}}</li>
                                                    <li data-value=\"redirect\">{{'Redirect to list'|trans}}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=\"uv-btn forward\">{{'Forward'|trans}}</div>
                                </div>
                            </form>
                        </div>

                        {# Ticket Thread | Add Note #}
                        {% if user_service.isAccessAuthorized('ROLE_AGENT_ADD_NOTE') %}
                            <div class=\"uv-tab-view\" id=\"note\">
                                <form enctype=\"multipart/form-data\" method=\"post\" action=\"{{ path('helpdesk_member_add_ticket_thread', {'ticketId': ticket.id }) }}\">
                                    <input name=\"threadType\" value=\"note\" type=\"hidden\">
                                    <input name=\"status\" value=\"\" type=\"hidden\" {% if user_service.isAccessAuthorized('ROLE_AGENT_UPDATE_TICKET_STATUS') %}class=\"reply-status\"{% endif %}>

                                    <div class=\"uv-element-block uv-element-block-textarea\">
                                        <label class=\"uv-field-label\">{{'Write a reply'|trans}}</label>
                                        <div class=\"uv-field-block\">
                                            <textarea class=\"uv-field\" name=\"reply\" id=\"note-area\">{{ ticket_service.getAgentDraftReply() }}</textarea>
                                        </div>
                                    </div>

                                    <div class=\"uv-element-block attachment-block\">
                                        <label><span class=\"uv-file-label\">{{'Add Attachment'|trans}}</span></label>
                                    </div>

                                    <div class=\"uv-action-buttons\">
                                        <div class=\"uv-dropdown next-view\">
                                            <input type=\"hidden\" name=\"nextView\" value=\"stay\"/>
                                            <div class=\"uv-dropdown-btn\" style=\"padding: 9px 27px 9px 10px;\">{{'Stay on ticket'|trans}}</div>
                                            <div class=\"uv-dropdown-list uv-top-left\" style=\"opacity: 1;\">
                                                <div class=\"uv-dropdown-container\">
                                                    <label>{{'After Reply'|trans}}</label>
                                                    <ul>
                                                        <li data-value=\"stay\">{{'Stay on ticket'|trans}}</li>
                                                        <li data-value=\"redirect\">{{'Redirect to list'|trans}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class=\"uv-dropdown reply\">
                                            <div class=\"uv-btn uv-dropdown-other\">{{'Reply'|trans}} <span class=\"uv-icon-down-light\"></span></div>

                                            <div class=\"uv-dropdown-list uv-top-left\">
                                                <div class=\"uv-dropdown-container\">
                                                    <label>{{'Add Note'|trans}}</label>
                                                    <ul>
                                                        <li data-id=\"\">{{'Submit'|trans}}</li>
                                                        {% if user_service.isAccessAuthorized('ROLE_AGENT_UPDATE_TICKET_STATUS') %}
                                                            <li data-id=\"open\">{{'Submit And Open'|trans}}</li>
                                                            <li data-id=\"pending\">{{'Submit And Pending'|trans}}</li>
                                                            <li data-id=\"answered\">{{'Submit And Answered'|trans}}</li>
                                                            <li data-id=\"resolved\">{{'Submit And Resolved'|trans}}</li>
                                                            <li data-id=\"closed\">{{'Submit And Closed'|trans}}</li>
                                                        {% endif %}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        {% endif %}
                    </div>
                </div>
            </div>

            <!-- Bottom Action Block -->
            <div class=\"uv-ticket-fixed-region\">
                <div class=\"uv-ticket-fixed-region-lt\">
                    {{ uvdesk_extensibles.getRegisteredComponent(\"Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Tickets\\\\QuickActionButtonCollection\").injectTemplates()|raw }}

                    {# <!-- Saved Replied-->
                    <div class=\"uv-dropdown saved-reply\">
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
                    <!-- //Saved Replied--> #}

                    {# <!--Code-->
                    <div class=\"uv-dropdown\">
                        <div class=\"uv-dropdown-btn\">{{ 'Prepared Responses'|trans }}</div>
                        <div class=\"uv-dropdown-list uv-top-left\">
                        <div class=\"uv-dropdown-container prepared-responses\">
                            <label>{{ 'Prepared Responses'|trans }}</label>
                            <ul>
                                <li>
                                    <a class=\"create-new\" href=\"{{path('prepare_response_action')}}\" target=\"_blank\" style=\"color: #2750C4\">{{ 'Create New'|trans }}</a>
                                </li>
                                {% set preparedResponses = ticket_service.getManualWorkflow() %}
                                {% for workflow in preparedResponses %}
                                    <li>
                                        <a href=\"{{ path('helpdesk_member_ticket_prepared_response_xhr') }}/{{ ticket.id }}/{{ workflow.id }}\">
                                            {{ workflow.name }}
                                        </a>
                                    </li>
                                {% endfor %}
                            </ul>
                        </div>
                        </div>
                    </div>
                    <!--//Code--> #}
                </div>

                <div class=\"uv-ticket-fixed-region-rt\"></div>
            </div>
            <!-- //Bottom Action Block -->
        </div>
    </div>

    {# Edit Ticket #}
    {% if user_service.isAccessAuthorized('ROLE_AGENT_EDIT_TICKET') %}
        <div class=\"uv-pop-up-overlay uv-no-error-success-icon\" id=\"edit-ticket-modal\">
            <div class=\"uv-pop-up-box uv-pop-up-wide\">
                <span class=\"uv-pop-up-close\"></span>
                <h2>Edit Ticket</h2>

                {# Edit Ticket Form #}
                <form method=\"post\" action=\"{{ path('helpdesk_member_update_ticket_details_xhr', {'ticketId': ticket.id}) }}\" id=\"edit-ticket-form\">
                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">Subject</label>
                        <div class=\"uv-field-block\">
                            <input type=\"text\" name=\"subject\" class=\"uv-field\" value=\"{{ ticket.subject }}\" />
                        </div>
                    </div>

                    <div class=\"uv-element-block\">
                        <label class=\"uv-field-label\">{{'Reply'|trans}}</label>
                        <div class=\"uv-field-block\">
                            <textarea name=\"reply\" id=\"uv-edit-create-thread\" class=\"uv-field\">{{ initialThread.message }}</textarea>
                        </div>
                    </div>

                    <div class=\"uv-pop-up-actions\">
                        <input class=\"uv-btn update\" href=\"#\" value=\"Update\" type=\"submit\">
                        <input class=\"uv-btn cancel\" href=\"#\" value=\"Discard\" type=\"button\">
                    </div>
                </form>
            </div>
        </div>
    {% endif %}

    {{ uvdesk_extensibles.getRegisteredComponent(\"Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Tickets\\\\WidgetCollection\").embedSideFilterContent()|raw }}
{% endblock %}

{% block footer %}
    {{ parent() }}

    {{ include('@UVDeskCoreFramework\\\\Templates\\\\attachment.html.twig') }}
    {{ include(\"@UVDeskCoreFramework/Templates/tinyMCE.html.twig\") }}

    <script id=\"thread_list_empty_tmp\" type=\"text/template\">
        <div class=\"uv-no-threads\">{{'Nothing interesting here'|trans}}...</div>
    </script>

    <script id=\"thread_list_item_tmp\" type=\"text/template\">
        <div class=\"uv-ticket-strip\">
            <span>
                <% if(typeof(mailStatus) != 'undefined' && mailStatus) { %>
                    <a href=\"https://support.uvdesk.com/en/blog/uvdesk-ticket-delivery-status\" target=\"_blank\">
                        <span class=\"uv-mail-status uv-mail-<%- mailStatus.split(',')[0] %>\" <% if(mailStatus !== 'pending') { %>data-toggle=\"tooltip\" data-placement=\"right\" title=\"{{ 'Mail status:'|trans }} <%- mailStatus.split(',')[0] %> <% if(mailStatus.split(',').length > 1) { print('Reason:' + mailStatus.split(',')[1] ); } %> \"<% } %> ></span>
                    </a>
                <% } %>
                <span class=\"timeago uv-margin-0\" data-timestamp=\"<%- timestamp %>\" title=\"<%- formatedCreatedAt %>\">
                    <%- formatedCreatedAt %>
                </span>
                - <%- fullname %>
                <span class=\"uv-ticket-strip-label\">
                <% if(threadType == 'reply') { %>
                    {{ 'replied'|trans }}
                <% } else if(threadType == 'note') { %>
                    {{ 'added note'|trans }}
                <% } else if(threadType == 'forward') { %>
                    {{ 'forwarded'|trans }}
                <% } %>
                - <a href=\"#thread/<%- id %>\" id=\"thread<%- id %>\" class=\"copy-thread-link\">#<%- id %></a>
                </span>
            </span>

            <% if((replyTo && threadType ==  'forward') || cc || bcc) { %>
                <div class=\"uv-ticket-strip\">
                    <% if(replyTo && threadType ==  'forward') { %>
                    <span><span class=\"uv-ticket-strip-label\">{{ 'TO'|trans }} -</span> <%- replyTo %></span>
                    <% } if(cc) { %>
                        <span><span class=\"uv-ticket-strip-label\">{{ 'CC'|trans }} -</span> <%- cc %></span>
                    <% } if(bcc) { %>
                        <span><span class=\"uv-ticket-strip-label\">{{ 'BCC'|trans }} -</span> <%- bcc %></span>
                    <% } %>
                </div>
            <% } %>
        </div>

        <div class=\"uv-ticket-strip uv-margin-top-5\" <% if(!bookmark && !isLocked) { %>style=\"display: none\"<% } %> >
            <span <% if(!bookmark) { %>style=\"display: none\"<% } %> >
                <span class=\"uv-icon-pinned\"></span>
                {{ 'Pinned'|trans }}
            </span>
            <span <% if(!isLocked) { %>style=\"display: none\"<% } %> >
                <span class=\"uv-icon-locked\"></span>
                {{ 'Locked'|trans }}
            </span>
        </div>
        <div class=\"uv-ticket-main-lt\">
            <span class=\"uv-thread-action\">
                <span class=\"uv-icon-ellipsis uv-dropdown-other\"></span>
                <div class=\"uv-dropdown-list uv-bottom-left\">
                    <div class=\"uv-dropdown-container\">
                        <ul>
                            {% if user_service.isAccessAuthorized('ROLE_AGENT_EDIT_THREAD_NOTE') %}
                                <% if(userType != 'system') { %>
                                    <li data-action=\"edit\">{{ 'Edit Thread'|trans }}</li>
                                <% } %>
                            {% endif %}
                            {% if user_service.isAccessAuthorized('ROLE_AGENT_DELETE_THREAD_NOTE') %}
                                <li data-action=\"delete\">{{ 'Delete Thread'|trans }}</li>
                            {% endif %}
                            <li data-action=\"forward\">{{ 'Forward'|trans }}</li>
                            <% if(bookmark) { %>
                                <li data-action=\"pin\" data-id=\"1\">{{ 'Unpin Thread'|trans }}</li>
                            <% } else { %>
                                <li data-action=\"pin\" data-id=\"0\">{{ 'Pin Thread'|trans }}</li>
                            <% } %>
                            <% if(threadType != 'note') { %>
                                {% if user_service.isAccessAuthorized('ROLE_AGENT_MANAGE_LOCK_AND_UNLOCK_THREAD') %}
                                    <% if(isLocked) { %>
                                        <li data-action=\"lock\" data-id=\"1\">{{ 'Unlock Thread'|trans }}</li>
                                    <% } else { %>
                                        <li data-action=\"lock\" data-id=\"0\">{{ 'Lock Thread'|trans }}</li>
                                    <% } %>
                                {% endif %}
                            <% } %>
                            <li style=\"display: none;\" data-action=\"translate\">{{ 'Translate Thread'|trans }}</li>
                        </ul>
                    </div>
                </div>
            </span>
            <span class=\"p-relative\">
                <div class=\"uv-dropdown-list uv-bottom-left uv-translate-list\" style=\"display: none\">
                    <div class=\"uv-dropdown-container\">
                        <ul class=\"uv-lang-list language\" data-action=\"language\">
                            <label>{{ 'Language'|trans }}</label>
                            {% for localeCode, localeName in uvdesk_service.getLocales() %}
                                <li data-value=\"{{ localeCode }}\">
                                    <img class=\"locale-image\" src='{{ asset(\"bundles/uvdeskcoreframework/images/country-flags/\" ~ localeCode|lower|replace({\" \": \"-\"}) ~ \".png\") }}' alt=\"{{ localeCode }}\" width=\"24px\">
                                    <span>{{ localeName|trans }}</span>
                                </li>
                            {% endfor %}
                        </ul>
                    </div>
                </div>
            </span>
            <% if(userType != 'system') { %>
                <% if(user && user.smallThumbnail != null) { %>
                    <img src=\"{{ app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') }}<%- user.smallThumbnail %>\" />
                <% } else { %>
                    <img src=\"<% if(userType == 'agent') { %> {{ asset(default_agent_image_path) }} <% } else { %> {{ asset(default_customer_image_path) }} <% } %>\" />
                <% } %>
            <% } else { %>
                <img src=\"{{ asset(default_helpdesk_image_path) }}\" />
            <% } %>
        </div>
        <div class=\"uv-ticket-main-rt\">
            <% if(userType == 'customer') { %>
                <a <% if(user) { %>href=\"{{ path('helpdesk_member_manage_customer_account') }}/<%- user.id %>\"<% } %> class=\"uv-ticket-member-name\">
                    <%- fullname %>
                </a>
            <% } else if(userType == 'agent') { %>
                <a <% if(user) { %>href=\"{{ path('helpdesk_member_account') }}/<%- user.id %>\"<% } %> class=\"uv-ticket-member-name\">
                    <%- fullname %>
                </a>
            <% } else { %>
                <span class=\"uv-ticket-member-name\">
                    {{ 'System'|trans }}
                </span>
            <% } %>

            <!-- Message Block -->
            <div class=\"message\">
                <%= reply %>
            </div>

            <!-- Attachment Block -->
            <% if(attachments.length) { %>
                <div class=\"uv-ticket-uploads\">
                    <h4>{{ 'Uploaded Files'|trans }}</h4>
                    <div class=\"uv-ticket-uploads-strip\">
                        <% _.each(attachments, function(file) { %>
                            <a href=\"<%-file.downloadURL %>\" target =\"_blank\" class=\"uv-ticket-uploads-brick uv-no-pointer-events\" data-toggle=\"tooltip\" title=\"<%- file.name %>\">
                                <img src=\"<%-file.iconURL %>\" class=\"uv-auto-pointer-events\">
                            </a>
                        <% }) %>
                    </div>

                    <% if (attachments.length > 1) { %>
                        <div class=\"thread-attachments-zip pull-left\">
                            <div class=\"uv-upload-actions\">
                                <a href=\"#\" class=\"uv-open-in-files\" data-thread=\"<%- id %>\" style=\"display: none\"><span class=\"uv-icon-open-in-files\"></span>{{ 'Open in Files'|trans }}</a>
                                <% if(attachments.length > 0) { %>
                                    <a href=\"{{ path('helpdesk_member_ticket_download_attachment_zip') }}/<%- id %>\" target=\"_blank\"><span class=\"uv-icon-attachment\"></span> {{ 'Download (as .zip)'|trans }}</a>
                                <% } %>
                            </div>
                        </div>
                    <% } %>

                </div>
            <% } %>
        </div>
    </script>

    <script id=\"edit_thread_tmp\" type=\"text/template\">
        <div class=\"thread-edit-container\">
            <div class=\"uv-element-block uv-element-block-textarea\">
                <div class=\"uv-field-block\">
                    <textarea id=\"uv-edit-thread\">
                    </textarea>
                </div>
            </div>
            <div class=\"uv-action-buttons\">
                <a class=\"uv-btn cancel-edit\" type=\"button\">{{ 'Cancel'|trans }}</a>
                <a class=\"uv-btn saveThread\" type=\"button\" style=\"margin-right: 10px;\">{{ 'Update'|trans }}</a>
            </div>
        </div>
    </script>

    <script id=\"ticket_quick_navigation_tmp\" type=\"text/template\">
        <% if(prev) { %>
            <a class=\"uv-btn-stroke\" href=\"{{ path('helpdesk_member_ticket') }}/<%- prev %>\">
                <span class=\"uv-icon-previous\"></span>
                {{ 'Previous Ticket'|trans }}
            </a>
        <% } else { %>
            <a class=\"uv-btn-stroke\" disabled=\"disabled\">
                <span class=\"uv-icon-previous\"></span>
                {{ 'Previous Ticket'|trans }}
            </a>
        <% } %>

        <% if(next) { %>
            <a class=\"uv-btn-stroke\" href=\"{{ path('helpdesk_member_ticket') }}/<%- next %>\">
                {{ 'Next Ticket'|trans }}
                <span class=\"uv-icon-next\"></span>
            </a>
        <% } else { %>
            <a class=\"uv-btn-stroke\" disabled=\"disabled\">
                {{ 'Next Ticket'|trans }}
                <span class=\"uv-icon-next\"></span>
            </a>
        <% } %>
    </script>

    <script type=\"text/javascript\">
        uvdesk = {
            ticket: {}
        };

        var ticketApp = {};

        viewerImages = function() {
            if (typeof(\$().viewer == 'function')) {
                \$('.uv-ticket-uploads .uv-ticket-uploads-strip').viewer({
                    'url': 'data-url',
                    'downloadBase': \"{{ path('helpdesk_member_ticket_download_attachment') }}\",
                    'download': 'data-download',
                });
            }
        };

        \$(function () {
            var threadIds = [];
            viewerImages();
            
            _.extend(Backbone.Model.prototype, Backbone.Validation.mixin);

            // Ticket Model
            var TicketModel = Backbone.Model.extend({
                idAttribute : \"id\",
                urlRoot : \"{{ path('helpdesk_member_update_ticket_attributes_xhr') }}\",
                validation: {
                    'email': [{
                        required: true,
                        msg: '{{ \"This field is mandatory\" }}'
                    },{
                        pattern: /^([\\w-\\.]+)@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([\\w-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)\$/,
                        msg: '{{ \"Please enter a valid email\" }}'
                    }],
                    'subject' : {
                        required : true,
                        msg : '{{ \"This field is mandatory\" }}'
                    },
                    'reply' : {
                        fn: function(value) {
                            if(!tinyMCE.get(\"uv-edit-create-thread\"))
                                return false;
                            var html = tinyMCE.get(\"uv-edit-create-thread\").getContent();
                            if(app.appView.stripHTML(html) != '') {
                                return false;
                            }
                            return true;
                        },
                        msg : '{{ \"This field is mandatory\" }}'
                    }
                },
            });

            // Thread Model
            var ThreadModel = Backbone.Model.extend({
                idAttribute : \"id\",
                defaults : {
                    hasTask : 0,
                    task: null
                }
            });

            // Customer Model
            var CustomerModel = Backbone.Model.extend({
                validation: {
                    'name': [{
                        required: true,
                        msg: '{{ \"This field is mandatory\" }}'
                    }, {
                        pattern: /^((?![!@#\$%^&*()<_+]).)*\$/,
                        msg: '{{ \"This field must have characters only\"}}'
                    }],
                    'email': [{
                        required: true,
                        msg: '{{ \"This field is mandatory\" }}'
                    },{
                        pattern: /^([\\w-\\.]+)@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([\\w-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)\$/,
                        msg: 'Email address is invalid'
                    }],
                    'contactNumber': function(value) {
                        if(value != undefined && value !== '') {
                            if (!value.match('^\\\\s*(?:\\\\+?(\\\\d{1,3}))?[-. (]*(\\\\d{3})[-. )]*(\\\\d{3})[-. ]*(\\\\d{4})(?: *x(\\\\d+))?\\\\s*\$'))
                                return 'Contact number is invalid';
                        }
                    }
                },
                urlRoot : \"{{ path('helpdesk_member_manage_customer_account') }}\"
            });

            // Ticket Collaborator Model
            var CollaboratorModel = Backbone.Model.extend({
                idAttribute : \"id\",
                validation: {
                    'email': [{
                        required: true,
                        msg: \"{{'This field is mandatory'|trans}}\"
                    },{
                        pattern: /^([\\w-\\.]+)@((\\[[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.)|(([\\w-]+\\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)\$/,
                        msg: 'Please enter a valid email'
                    }]
                },
                defaults : {
                    ticketId : {{ ticket.id }},
                    email: ''
                },
                parse: function (resp, options) {
                    return resp.collaborator;
                },
                urlRoot : \"{{ path('helpdesk_member_ticket_manage_collaborators_xhr') }}\"
            });

            // Ticket Tag Model
            var TagModel = Backbone.Model.extend({
                idAttribute : \"id\",
                defaults : {
                    ticketId : {{ ticket.id }}
                },
                parse: function (resp, options) {
                    return resp.tag;
                },
                urlRoot : \"{{ path('helpdesk_member_ticket_create_tag_xhr') }}\"
            });

            // Ticket Label Model
            var LabelModel = Backbone.Model.extend({
                idAttribute : \"id\",
                defaults : {
                    ticketId : {{ ticket.id }}
                },
                parse: function (resp, options) {
                    return resp.label;
                },
                urlRoot : \"{{ path('helpdesk_member_ticket_add_label_xhr') }}\"
            });

            // Ticket Thread Collection
            var ThreadCollection = AppCollection.extend({
                model : ThreadModel,
                mode: \"infinite\",
                url : \"{{ path('helpdesk_member_thread_collection_xhr', {'ticketId': ticket.id}) }}\",
                firstScrollCheck: false,
                threadRequestedId: false,
                template : \$(\"#thread_list_empty_tmp\").html(),
                parseRecords: function (resp, options) {
                    return resp.threads;
                },
                syncData : function() {
                    type = \$(\".uv-ticket-action-bar-lt .uv-tabs .uv-tab-active\").attr('data-type')
                    var self = this;
                    var data = {
                            threadType: type
                        };

                    if(this.threadRequestedId)
                        data.threadRequestedId = this.threadRequestedId;

                    app.appView.showLoader()
                    this.fetch({
                        data : data,
                        remove: false,
                        success: function(model, response) {
                            app.appView.hideLoader();
                            self.threadRequestedId = false;
                            pagination.renderPagination(response.pagination);
                            threadCollection.state.currentPage = parseInt(response.pagination.current) + 1;
                            if(response.pagination.totalCount <= 0){
                                this.\$('.uv-ticket-wrapper.thread-list').html(self.template);
                            }
                        },
                        error: function (model, xhr, options) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                        }
                    }).done(function(){
                        viewerImages();
                        if(!self.firstScrollCheck){
                            self.firstScrollCheck = true;
                            var fragment = Backbone.history.fragment.trim();
                            if(fragment == '') {
                                router.scrollPage('#reply');
                            } else
                                router.scrollPage('#' + fragment.replace('thread/', 'thread'));
                        }
                    });
                }
            });

            // Ticket Collaborator Collection
            var CollaboratorCollection = Backbone.PageableCollection.extend({
                model : CollaboratorModel
            });

            // Ticket Tag Collection
            var TagCollection = Backbone.PageableCollection.extend({
                model : TagModel,
                isTagExist : function(name) {
                    var flag = 1;
                    _.each(tagCollection.models, function (item) {
                        if(item.get('name').toUpperCase() == name.toUpperCase())
                            flag = 0;
                    }, this);

                    return flag;
                }
            });

            // Ticket Label Collection
            var LabelCollection = Backbone.PageableCollection.extend({
                model : TagModel,
                isLabelExist : function(name) {
                    var flag = 1;
                    _.each(labelCollection.models, function (item) {
                        if(item.get('name').toUpperCase() == name.toUpperCase())
                            flag = 0;
                    }, this);
                    return flag;
                }
            });

            // Customer Form View
            var CustomerForm = Backbone.View.extend({
                events : {
                    'click .uv-btn.update-btn' : \"saveCustomer\",
                    'blur input': 'formChanegd',
                    'click .cancel-btn': 'backToInfo',
                    'click .uv-aside-back': 'backToInfo'
                },
                initialize : function() {
                    Backbone.Validation.bind(this);
                },
                formChanegd: function(e) {
                    this.model.set(Backbone.\$(e.currentTarget).attr('name'), Backbone.\$(e.currentTarget).val())
                    this.model.isValid([Backbone.\$(e.currentTarget).attr('name')])
                },
                saveCustomer: function (e) {
                    e.preventDefault();
                    currentElement = Backbone.\$(e.currentTarget);
                    this.model.clear();
                    this.model.set(this.\$el.find('form').serializeObject());
                    self = this;
                    if(this.model.isValid(true)) {
                        app.appView.showLoader();
                        currentElement.attr('disabled', 'disabled');
                        this.model.save({}, {
                            success: function (model, response, options) {
                                app.appView.hideLoader();
                                currentElement.removeAttr(\"disabled\");
                                if(response.alertClass == \"success\") {
                                    app.appView.renderResponseAlert(response);
                                    \$('.uv-aside-customer-info').html(\"<span>\" + self.model.attributes.name + \"</span><span>\" + self.model.attributes.email + \"</span><span>\" + self.model.attributes.contactNumber + \"</span><span class='uv-customize'></span>\")
                                    self.backToInfo();
                                } else if(response.errors) {
                                    self.addErrors(JSON.parse(response.errors));
                                } else if(response.alertMessage) {
                                    app.appView.renderResponseAlert(response);
                                }
                            },
                            error: function (model, xhr, options) {
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;

                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(warningResponse);
                            }
                        });
                    }
                },
                addErrors: function(jsonContext) {
                    for (var field in jsonContext) {
                        Backbone.Validation.callbacks.invalid(this, field, jsonContext[field], 'input');
                    }
                },
                backToInfo: function(e) {
                    if(e)
                        e.preventDefault()

                    \$('.uv-main-info-update-block').hide()
                    \$('.uv-main-info-block').show()
                },
            });

            // Ticket View
            var TicketView = Backbone.View.extend({
                el: \$('.uv-wrapper'),
                stopDraftSaveFlag: 0,
                events: {
                    'click .uv-ticket-action .uv-dropdown-list li[data-action=\"spam\"], .uv-ticket-action .uv-dropdown-list li[data-action=\"closed\"]': 'masrkSpamAndClosed',
                    'click .uv-aside-ticket-actions .uv-aside-select .uv-dropdown-list li': 'editTicketProperty',
                    'click .uv-aside-customer-info .uv-customize': 'showCustomerUpdateBlock',
                    'click .uv-ticket-head .uv-star-large': 'updateStar',
                    'click .uv-ticket-action-bar .uv-tabs li': 'filterThread',
                    'click .uv-ticket-action .uv-dropdown-list li[data-action=\"delete\"]': 'confirmRemove',
                    'click .uv-ticket-action .uv-dropdown-list li[data-action=\"lock\"]': 'lockAndUnlockThread',
                    'click .uv-element-block.collaborators .uv-btn-tag': 'removeCcCollaborator',
                    'keypress .uv-element-block.to .uv-dropdown-other': 'addToInput',
                    'click .uv-element-block.to .uv-dropdown-list li': 'addTo',
                    'click .to-list .uv-btn-tag': 'removeTo',
                    'change .uv-element-block.cc-bcc .cc-bcc-toggle': 'showCcBccBlock',
                    'keypress .uv-element-block.cc-bcc .uv-group-field.uv-dropdown-other': 'addCcBccInput',
                    'click .uv-element-block.cc-bcc .uv-dropdown-list li': 'addCcBcc',
                    'click .cc-bcc-list .uv-btn-tag, .to-list .uv-btn-tag': 'removeEmail',
                    'click .next-view .uv-dropdown-list li': 'setNextView',
                    'click .uv-dropdown.reply .uv-dropdown-list li, .uv-btn.forward': 'validateForm',
                    'click #edit-ticket-modal .uv-btn.update': 'updateTicket',
                    'click .message .uv-icon-ellipsis': 'showReplyQuote',
                    'input .uv-aside-brick .uv-field.uv-dropdown-other': 'searchFilterXhr',
                    'click .uv-dropdown-container.prepared-responses a:not(.create-new)': 'confirmPreparedResponses',

                    'click .uv-header-fix': 'fixheader',
                    'click .uv-ticket-action .uv-dropdown-list li[data-action=\"print\"]': 'printTicket',
                    'blur .uv-manual-enter': 'enterManualAdd',
                },
                ticketNavigationTemplate : _.template(\$(\"#ticket_quick_navigation_tmp\").html()),
                loaderTemplate : _.template(\$(\"#loader-tmp\").html()),
                targetPreparedResponseUrl: '',
                initialize: function() {
                    Backbone.Validation.bind(this);
                    InitTinyMce('#uv-edit-create-thread');
                    \$('.uv-ticket-fixed-region .uv-ticket-fixed-region-rt').html(this.ticketNavigationTemplate(ticketNavigation))
                    var threadTab = localStorage.getItem(\"threadTab\");
                    if(threadTab){
                        \$('.uv-ticket-action-bar-lt .uv-tabs li').removeClass('uv-tab-active');
                        \$('.uv-ticket-action-bar-lt .uv-tabs [data-type=\"' + threadTab + '\"]').addClass('uv-tab-active');
                    }
                    nextView = localStorage.getItem(\"nextView\");
                    if(nextView) {
                        \$(\".next-view input\").val(nextView)
                        \$(\".next-view .uv-dropdown-btn\").text(\$(\"#reply .next-view .uv-dropdown-list li[data-value='\" + nextView + \"']\").text())
                    }
                    if(!localStorage.getItem('ticketTour')) {
                        \$('.uv-ticket-tour').show()
                    }
                    this.fixheaderInit();
                },
                printTicket: function(e) {
                    window.print();
                },
                enterManualAdd: function(e) {
                    var target = \$(e.target);
                    if(target.val()) {
                        var e = \$.Event(\"keypress\");
                        e.which = 13; //choose the one you want
                        target.trigger(e);
                    }
                },
                fixheader: function(e){
                    e.preventDefault();
                    var header = localStorage.getItem(\"fixHeader\");
                    header = !(header == 'true');
                    localStorage.setItem(\"fixHeader\", header);
                    this.fixheaderInit();
                },
                fixheaderInit: function(){
                    var header = localStorage.getItem(\"fixHeader\");
                    if(header == 'true'){
                        \$('a.uv-icon-pin').addClass('uv-icon-pinned');
                        \$('.uv-ticket-action-bar').addClass('uv-ticket-action-bar-fixed');
                    }else{
                        \$('a.uv-icon-pin').removeClass('uv-icon-pinned');
                        \$('.uv-ticket-action-bar').removeClass('uv-ticket-action-bar-fixed');
                    }
                },
                masrkSpamAndClosed: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    var value = currentElement.attr('data-index');
                    \$(\".uv-aside-select .uv-dropdown-list ul.status li[data-index='\" + value + \"']\").trigger('click')
                },
                editTicketProperty: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    var uvSelect = currentElement.parents('.uv-aside-select');
                    var field = currentElement.parent().attr('data-action');
                    var value = currentElement.attr('data-index');
                    if(uvSelect.find('.uv-aside-select-value').attr('data-id') != value) {
                        var name = currentElement.text().trim();
                        app.appView.showLoader();
                        this.model.save({attribute: field, value: value, id: this.model.id}, {
                            patch: true,
                            success: function (model, response, options) {
                                uvSelect.find('.uv-aside-select-value').attr('data-id', value).text(name)
                                if(field == 'priority') {
                                    uvSelect.find('.uv-list-ticket-priority').attr('style', 'background:' + currentElement.attr('data-color'));
                                } else if(field == 'agent') {
                                    \$('.uv-ticket-strip .agent-info').show()
                                    \$('.uv-ticket-strip .agent-info .name').text(name)
                                }
                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(response);
                            },
                            error: function (model, xhr, options) {
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;
                                var response = warningResponse;
                                if(xhr.responseJSON)
                                    response = xhr.responseJSON;

                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(response);
                            }
                        });
                    }
                },
                showCustomerUpdateBlock: function() {
                    \$('.uv-main-info-update-block').show()
                    \$('.uv-main-info-block').hide()
                },
                updateStar: function(e) {
                    e.preventDefault();
                    var currentElement = Backbone.\$(e.currentTarget);
                    currentElement.toggleClass('uv-star-active')
                    this.model.save({id: this.model.id}, {
                        patch: true,
                        url : \"{{ path('helpdesk_member_bookmark_ticket_xhr') }}\",
                        success: function (model, response, options) {
                        },
                        error: function (model, xhr, options) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                        }
                    });
                },
                filterThread: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    if(type = currentElement.attr('data-type')) {
                        localStorage.setItem(\"threadTab\", type);
                        if(type != 'all')
                            \$('.uv-ticket-main.create').hide()
                        else
                            \$('.uv-ticket-main.create').show()
                        \$('.uv-ticket-wrapper.thread-list').html('')
                        models = []
                        threadCollection.each(function(model) {
                            models.push(model)
                        })
                        total = threadCollection.models.length;
                        count = 0;
                        if(total) {
                            _.each(models, function (model) {
                                threadCollection.remove(model)
                                count++;
                                if(total == count) {
                                    threadCollection.reset()
                                    threadCollection.state.currentPage = 1;
                                    threadCollection.syncData()
                                }
                            });
                        } else {
                            threadCollection.reset()
                            threadCollection.state.currentPage = 1;
                            threadCollection.syncData()
                        }
                    }
                },
                confirmRemove: function(e) {
                    app.appView.openConfirmModal(this);
                },
                removeItem : function() {
                    if(this.model.attributes.isTrashed)
                        window.location.href = \"{{ path('helpdesk_member_delete_ticket', {'ticketId': ticket.id}) }}\";
                    else
                        window.location.href = \"{{ path('helpdesk_member_trash_ticket', {'ticketId': ticket.id}) }}\";
                },
                addCCCollaborators: function() {
                    if(collaboratorCollection.length) {
                        var collaboratorContainer = \$('.uv-element-block.collaborators');
                        collaboratorContainer.find('.uv-field-block').html('');
                        collaboratorContainer.show()
                        _.each(collaboratorCollection.models, function (item) {
                            var json = item.attributes;
                            collaboratorContainer.find('.uv-field-block').append(\"<span><input type='hidden' name='cccol[]' value='\" + json.email + \"'/><a class='uv-btn-tag' href='#'><span class='uv-icon-remove-dark-before'></span>\" + json.name + \"</a></span>\")
                        }, this);
                    }
                },
                removeCcCollaborator: function(e) {
                    e.preventDefault()
                    Backbone.\$(e.currentTarget).parent().remove();
                    var collaboratorContainer = \$('.uv-element-block.collaborators');
                    if(!collaboratorContainer.find('.uv-btn-tag').length)
                        collaboratorContainer.hide()
                },
                addToInput: function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    var currentTab = inputElement.parents('.uv-tab-view');
                    var email = inputElement.val().trim();
                    if (e.which === 13 && email) {
                        e.preventDefault()
                        if(!this.model.preValidate({name: 'email', email: email})) {
                            inputElement.val('').trigger('input')
                            inputElement.removeClass('uv-dropdown-btn-active')
                            inputElement.siblings('.uv-dropdown-list').hide()
                            if(!currentTab.find(\".to-list input[value='\" + email + \"'].to\").length) {
                                currentTab.find('.to-list').append(\"<span><input type='hidden' name='to[]' value='\" + email + \"' class='to'/><a class='uv-btn-tag' href='#'><span class='uv-icon-remove-dark-before'></span>\" + email + \"</span></a></span>\")
                            }
                        }
                    }
                },
                addTo: function(e) {
                    var currentTab = Backbone.\$(e.currentTarget).parents('.uv-tab-view');
                    var email =  Backbone.\$(e.currentTarget).attr('data-id');
                    if(!currentTab.find(\".to-list input[value='\" + email + \"'].to\").length) {
                        currentTab.find('.to-list').append(\"<span><input type='hidden' name='to[]' value='\" + email + \"' class='to'/><a class='uv-btn-tag' href='#'><span class='uv-icon-remove-dark-before'></span>\" + email + \"</span></a></span>\")
                    }
                },
                showCcBccBlock: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    var currentTab = currentElement.parents('.uv-tab-view');
                    if(currentElement.is(':checked')) {
                        currentTab.find('.uv-element-block.cc-bcc').find('.uv-field-block').show()
                    } else {
                        currentTab.find('.uv-element-block.cc-bcc').find('.uv-field-block').hide()
                        currentTab.find('.uv-element-block .cc-bcc-list').html('')
                    }
                },
                addCcBccInput: function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    var currentTab = inputElement.parents('.uv-tab-view');
                    var email = inputElement.val().trim();
                    if (e.which === 13 && email) {
                        e.preventDefault()
                        type = currentTab.find('.cc-bcc-select option:selected').text()
                        if(!this.model.preValidate({name: 'email', email: email})) {
                            inputName = \$('.cc-bcc-select').val()
                            inputElement.val('').trigger('input')
                            inputElement.removeClass('uv-dropdown-btn-active')
                            inputElement.siblings('.uv-dropdown-list').hide()
                            if(!currentTab.find(\".cc-bcc-list input[value='\" + email + \"'].\" + inputName).length) {
                                currentTab.find('.cc-bcc-list').append(\"<span><input type='hidden' name='\" + inputName + \"[]' value='\" + email + \"' class='\" + inputName + \"'/><a class=uv-btn-tag uv-lowercase' href='#'><span class='uv-icon-remove-dark-before'></span>\" + email + \" : <span class='uv-uppercase'>\" + type + \"</span></a></span>\")
                            }
                        }
                    }
                },
                addCcBcc: function(e) {
                    var currentTab = Backbone.\$(e.currentTarget).parents('.uv-tab-view');
                    var email =  Backbone.\$(e.currentTarget).attr('data-id');
                    type = currentTab.find('.cc-bcc-select option:selected').text()
                    inputName = currentTab.find('.cc-bcc-select').val()
                    if(!currentTab.find(\".cc-bcc-list input[value='\" + email + \"'].\" + inputName).length) {
                        currentTab.find('.uv-element-block.cc-bcc .uv-group-field.uv-dropdown-other').val('').trigger('input')
                        currentTab.find('.cc-bcc-list').append(\"<span><input type='hidden' name='\" + inputName + \"[]' value='\" + email + \"' class='\" + inputName + \"'/><a class=uv-btn-tag uv-lowercase' href='#'><span class='uv-icon-remove-dark-before'></span>\" + email + \" : <span class='uv-uppercase'>\" + type + \"</span></a></span>\")
                    }
                },
                removeEmail: function(e) {
                    e.preventDefault()
                    Backbone.\$(e.currentTarget).parent().remove();
                },
                setNextView: function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    var nextView = currentElement.attr('data-value');
                    localStorage.setItem(\"nextView\", nextView);
                    \$(\".next-view input\").val(nextView)
                    \$(\".next-view .uv-dropdown-btn\").text(currentElement.text())
                },
                validateForm : function(e) {
                    e.preventDefault();
                    var element = Backbone.\$(e.currentTarget);
                    formType = element.parents('.uv-tab-view.uv-tab-view-active').attr('id');
                    form = element.parents('form');
                    form.find('.reply-status').val(element.attr('data-id'));
                    form.find('.uv-field-message').remove()

                    var html = tinyMCE.get(formType + \"-area\").getContent();
                    if(app.appView.htmlText(html) != '' || -1 != html.indexOf('<img')) {
                        if(formType == 'forward') {
                            if(!form.find(\".to-list input.to\").length) {
                                \$('.uv-element-block.to').append(\"<span class='uv-field-message'>{{ 'This field is mandatory'|trans }}</span>\")
                            } else {
                                this.stopDraftSaveFlag = 1;

                                app.appView.showLoader();
                                tinyMCE.activeEditor.uploadImages(function(response) {
                                    app.appView.hideLoader();

                                    form.submit();
                                    \$('.uv-btn.forward').attr('disabled', 'disabled');
                                });
                            }
                        } else {
                            this.stopDraftSaveFlag = 1;
                            if(localStorage) {
                                localStorage.setItem(\"threadTab\", \"all\");
                            }

                            app.appView.showLoader();
                            tinyMCE.activeEditor.uploadImages(function(response) {
                                app.appView.hideLoader();

                                form.submit();
                                \$('.uv-dropdown.reply').find('.uv-btn').attr('disabled', 'disabled');
                            });
                        }
                    } else {
                        form.find('.uv-element-block-textarea').append(\"<span class='uv-field-message'>{{ 'This field is mandatory'|trans }}</span>\");
                        if(formType == 'forward') {
                            if(!form.find(\".to-list input.to\").length) {
                                \$('.uv-element-block.to').append(\"<span class='uv-field-message'>{{ 'This field is mandatory'|trans }}</span>\")
                            }
                        }
                    }
                },
                updateTicket: function(e) {
                    e.preventDefault();
                    this.model.set(\$('#edit-ticket-modal form').serializeObject());
                    if(this.model.isValid(['subject', 'reply'])) {
                        \$('#edit-ticket-modal form').find('.uv-btn').attr('disabled', 'disabled');
                        \$('#edit-ticket-modal form').submit();
                    }
                },
                showReplyQuote: function(e) {
                    Backbone.\$(e.currentTarget).next().toggle();
                },
                searchFilterXhr: _.debounce(function(e) {
                    currentElement = Backbone.\$(e.currentTarget);
                    var parent = currentElement.parent();
                    if(\$('.uv-dropdown-other.uv-dropdown-btn-active').parent().attr('id') != parent.attr('id'))
                        return;
                    parent.find(\"li:not(.uv-no-results, .uv-filter-info)\").remove();
                    parent.find(\".uv-filter-info\").show()
                    if(currentElement.val().length > 1) {
                        parent.append(this.loaderTemplate())
                        parent.find('.uv-filter-info').text(\"{% trans %}Searching{% endtrans %} ...\")
                        if(self.xhrReq)
                            self.xhrReq.abort();

                        self.xhrReq = \$.ajax({
                            url : \"{{ path('helpdesk_member_ticket_search_filter_options') }}\",
                            type : 'GET',
                            data: {\"type\" : currentElement.attr('data-type'), \"query\": currentElement.val()},
                            dataType : 'json',
                            success : function(response) {
                                self.xhrReq = 0;
                                parent.find('.uv-loader').remove()
                                parent.find('.uv-filter-info').text(\"{{ 'Type atleast 2 letters'|trans }}\").hide();
                                if(response.length == 0) {
                                    parent.find('.uv-no-results').show();
                                    parent.find('.uv-no-results').disabled = true;
                                } else {
                                    parent.find('.uv-no-results').hide();
                                    _.each(response, function(item) {
                                        parent.find('.uv-dropdown-list ul').append(\"<li data-id='\" + item.id + \"'>\" + item.name + \"</li>\")
                                    });
                                }
                            },
                            error: function (xhr) {
                                self.xhrReq = 0;
                                parent.find('.uv-loader').remove()
                                parent.find('.uv-no-results').hide();
                                parent.find('.uv-filter-info').text(\"{{ 'Type atleast 2 letters'|trans }}\").show();

                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;
                            }
                        });
                    } else {
                        parent.find('.uv-no-results').hide();
                    }
                },1000)
            });

            // Ticket Thread View
            var ThreadItem = Backbone.View.extend({
                tagName : \"div\",
                className : \"uv-ticket-main\",
                template : _.template(\$(\"#thread_list_item_tmp\").html()),
                editThreadTemplate : _.template(\$(\"#edit_thread_tmp\").html()),
                events : {
                    'click .uv-thread-action .uv-dropdown-list li[data-action=\"delete\"]': 'confirmRemove',
                    'click .uv-thread-action .uv-dropdown-list li[data-action=\"lock\"]': 'lockAndUnlockThread',
                    'click .uv-thread-action .uv-dropdown-list li[data-action=\"pin\"]': 'pinThread',
                    'click .uv-thread-action .uv-dropdown-list li[data-action=\"mark\"]': 'markForTask',
                    'click .uv-thread-action .uv-dropdown-list li[data-action=\"forward\"]' : 'forwardThread',
                    'click .uv-thread-action .uv-dropdown-list li[data-action=\"edit\"]' : 'editThread',
                    'click .uv-btn.cancel-edit' : 'cancelEdit',
                    'click .uv-btn.saveThread' : 'updateThread',
                    'click .copy-thread-link' : 'copyThreadLink',
                    'blur .input-copy-thread-link': 'removeCopyThreadLink'
                },
                render : function () {
                    this.\$el.html(this.template(this.model.toJSON()));

                    this.\$el.addClass(\"thread-\" + this.model.id)
                    if(this.model.attributes.threadType == 'note')
                        this.\$el.addClass('uv-ticket-note')
                    return this;
                },
                unrender : function(response) {
                    if(response.alertMessage != undefined) {
                        var self = this;
                        {# threadCollection.models.remove(this.model); #}
                        threadCollection.models = threadCollection.models.filter(thread => {
                            if(thread.id == self.model.id) {
                                return false;
                            }

                            return true;
                        });
                        this.remove();
                        threadCollection.syncData();
                        app.appView.renderResponseAlert(response);
                    }
                },
                confirmRemove: function(e) {
                    app.appView.openConfirmModal(this);
                },
                removeItem : function() {
                    self = this;
                    var index = threadIds.indexOf(this.model.id);
                    if (index > -1)
                        threadIds.splice(index, 1);
                    app.appView.showLoader();
                    this.model.destroy({
                        url : \"{{ path('helpdesk_member_thread_xhr') }}/\" + this.model.id,
                        data : { 'ticketId' : ticketModel.attributes.id },
                        success : function (model, response, options) {
                            app.appView.hideLoader();
                            self.unrender(response);
                        },
                        error: function (model, xhr, options) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        }
                    });
                },
                lockAndUnlockThread :function(e) {
                    self = this;
                    currentElement = Backbone.\$(e.currentTarget);
                    var isLocked = 0;
                    if(this.model.get('isLocked')) {
                        this.model.set('isLocked', 0);
                        currentElement.attr('data-id', isLocked).text(\"{{ 'Lock Thread'|trans }}\");
                    } else {
                        isLocked = 1;
                        this.model.set('isLocked', 1);
                        currentElement.attr('data-id', isLocked).text(\"{{ 'Unlock Thread'|trans }}\");
                    }
                    app.appView.showLoader();
                    this.model.save({
                            isLocked: isLocked,
                            id: this.model.id,
                            ticketId: ticketModel.attributes.id,
                            updateType: 'lock'
                        }, {
                        patch: true,
                        url : \"{{ path('helpdesk_member_thread_xhr') }}/\" + this.model.id,
                        success : function (model, response, options) {
                            self.toggleThreadPropertyIcon()
                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        },
                        error: function (model, xhr, options) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        }
                    });
                },
                pinThread :function(e) {
                    self = this;
                    currentElement = Backbone.\$(e.currentTarget);
                    var bookmark = 0;
                    if(this.model.get('bookmark')) {
                        this.model.set('bookmark', 0);
                        currentElement.attr('data-id', bookmark).text(\"{{ 'Pin Thread'|trans }}\");
                    } else {
                        bookmark = 1;
                        this.model.set('bookmark', 1);
                        currentElement.attr('data-id', bookmark).text(\"{{ 'Unpin Thread'|trans }}\");
                    }
                    app.appView.showLoader();
                    this.model.save({
                            bookmark: bookmark,
                            id: this.model.id,
                            ticketId: ticketModel.attributes.id,
                            updateType: 'bookmark'
                        }, {
                        patch: true,
                        url : \"{{ path('helpdesk_member_thread_xhr') }}/\" + this.model.id,
                        success : function (model, response, options) {
                            self.toggleThreadPropertyIcon()
                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        },
                        error: function (model, xhr, options) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        }
                    });
                },
                forwardThread : function(e) {
                    var element = Backbone.\$(e.currentTarget);
                    tinymce.get('forward-area').setContent(this.model.attributes.reply);
                    \$('#forward-area').parent().find('img').removeAttr('crossorigin');
                    \$(\".uv-tabs li[for='forward']\").trigger('click');

                    \$('.uv-ticket-scroll-region').animate({
                        scrollTop: \$('#default').outerHeight()
                    }, 'slow');
                },
                cancelEdit : function(e) {
                    this.initEditThread();
                    tinymce.get('uv-edit-thread').destroy()
                },
                editThread : function(e) {
                    \$('.thread-edit-container .cancel-edit').trigger('click');
                    this.initEditThread();
                    this.\$el.find('.message').hide().after(this.editThreadTemplate());
                    this.\$el.find('.uv-ticket-uploads').hide()

                    InitTinyMce('#uv-edit-thread');
                    tinymce.get('uv-edit-thread').setContent(this.model.attributes.reply);
                    this.\$el.find('img').removeAttr('crossorigin');
                },
                initEditThread: function() {
                    \$('.thread-edit-container').remove();
                    messageElement = this.\$el.find('.message');
                    messageElement.show();
                    this.\$el.find('.uv-ticket-uploads').show()
                },
                updateThread : function(e) {
                    e.preventDefault();
                    var currentElement = Backbone.\$(e.currentTarget);
                    parent = currentElement.parents('.thread-edit-container')
                    parent.find('.uv-field-message').remove()

                    var html = tinyMCE.get(\"uv-edit-thread\").getContent();
                    if(app.appView.stripHTML(html) != '') {
                        var self = this;
                        currentElement.attr(\"disabled\", \"disabled\");
                        this.model.set('reply', html);
                        app.appView.showLoader()
                        this.model.save({}, {
                            url : \"{{ path('helpdesk_member_thread_update_xhr') }}/\" + this.model.id,
                            success : function (model, response, options) {
                                app.appView.hideLoader()
                                messageElement = self.\$el.find('.message');
                                if(response.alertClass == 'success') {
                                    messageElement.html(self.model.attributes.reply).show();
                                    messageElement.find('.uv-icon-ellipsis').remove();
                                    messageElement.find('.helpdesk_blockquote').eq(0).before(\"<span class='uv-icon-ellipsis uv-ellipsis-mirror'></span>\").hide();
                                }

                                self.initEditThread();
                                tinymce.get('uv-edit-thread').destroy()
                                app.appView.renderResponseAlert(response);
                            },
                            error: function (model, xhr, options) {
                                self.initEditThread();
                                tinymce.get('uv-edit-thread').destroy()
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;
                                var response = warningResponse;
                                if(xhr.responseJSON)
                                    response = xhr.responseJSON;
                                app.appView.hideLoader()
                                app.appView.renderResponseAlert(response);
                            }
                        });
                    } else {
                        this.\$el.find('.uv-element-block-textarea').append(\"<span class='uv-field-message'>{{ 'This field is mandatory'|trans }}</span>\");
                    }
                },
                toggleCreateTaskBar : function() {
                    if(threadIds.length) {
                        \$(\"#uv-task-view\").css('right', '0px');
                        \$(\"#uv-task-view .uv-create-task\").show()
                        \$(\"#uv-task-view .uv-task-list\").hide()
                    } else {
                        \$(\"#uv-task-view\").css('right', '-300px');
                        \$(\"#uv-task-view .uv-create-task\").hide()
                        \$(\"#uv-task-view .uv-task-list\").show()
                    }
                },
                copyThreadLink: function(e){
                    _.delay(function(){
                        \$(e.currentTarget).before('<input type=\"text\" class=\"input-copy-thread-link uv-field\" value=\"' + window.location.href + '\"/>');
                        \$(e.currentTarget).prev().focus().select();
                    }, 100);
                },
                removeCopyThreadLink: function(e){
                    \$(e.currentTarget).remove();
                },
                toggleThreadPropertyIcon: function(e) {
                    if(jQuery.inArray(this.model.id, threadIds) !== -1 || this.model.get('bookmark') || this.model.get('isLocked')) {
                        this.\$el.find('.uv-icon-pinned').parents('.uv-ticket-strip').show()
                    } else {
                        this.\$el.find('.uv-icon-pinned').parents('.uv-ticket-strip').hide()
                    }

                    if(jQuery.inArray(this.model.id, threadIds) !== -1)
                        this.\$el.find('.uv-icon-marked-task').parent().show()
                    else
                        this.\$el.find('.uv-icon-marked-task').parent().hide()

                    if(this.model.get('bookmark'))
                        this.\$el.find('.uv-icon-pinned').parent().show()
                    else
                        this.\$el.find('.uv-icon-pinned').parent().hide()

                    if(this.model.get('isLocked'))
                        this.\$el.find('.uv-icon-locked').parent().show()
                    else
                        this.\$el.find('.uv-icon-locked').parent().hide()
                }
            });

            // Ticket Thread List
            var ThreadList = Backbone.View.extend({
                el : \$(\".thread-list\"),
                initialize : function() {
                    this.listenTo(threadCollection.fullCollection, \"add\", this.renderThread);
                },
                renderThread : function (item) {
                    var threadItem = new ThreadItem({
                        model: item
                    });
                    if(item.id < threadCollection.fullCollection.at(0).id)
                        this.\$el.prepend(threadItem.render().el);
                    else
                        this.\$el.append(threadItem.render().el);
                    threadItem.\$el.find('.helpdesk_blockquote').eq(0).before(\"<span class='uv-icon-ellipsis uv-ellipsis-mirror'></span>\").hide();
                    //emojifyRun();
                    this.\$el.find('img').removeAttr('crossorigin');
                    this.\$el.find('div.message a').attr('target', '_blank');
                    app.appView.relativeTime();
                }
            });

            // Ticket Pagination View
            var Pagination = Backbone.View.extend({
                el: \$('.uv-ticket-accordion'),
                events: {
                    'click .uv-ticket-count-stat': 'loadMore',
                },
                renderPagination: function(pagination) {
                    if(pagination.totalCount - pagination.lastItemNumber > 0 && pagination.lastItemNumber > 0) {
                        var remain = pagination.totalCount - pagination.lastItemNumber;
                        \$('.uv-ticket-count-stat').text(remain)
                        \$('.uv-ticket-accordion').removeClass('uv-ticket-accordion-expanded').removeClass('uv-ticket-accordion-no-count')
                    } else {
                        \$('.uv-ticket-accordion').addClass('uv-ticket-accordion-expanded').addClass('uv-ticket-accordion-no-count')
                    }
                },
                loadMore: function() {
                    threadCollection.syncData();
                }
            });

            // Ticket collaborator Item View
            var CollaboratorItem = Backbone.View.extend({
                tagName : \"a\",
                className: 'uv-btn-tag',
                template : _.template(\"<span class='uv-tag'>{% if user_service.isAccessAuthorized('ROLE_AGENT_DELETE_COLLABORATOR_FROM_TICKET') %}<span class='uv-icon-remove-dark-before'></span>{% endif %}<%- name %></span>\"),
                events : {
                    'click .uv-tag' : 'confirmRemove'
                },
                render : function () {
                    this.\$el.html(this.template(this.model.toJSON()));
                    return this;
                },
                unrender : function(response) {
                    if(response.alertMessage != undefined) {
                        app.appView.renderResponseAlert(response);
                    }
                },
                removeItem: function() {
                    {% if user_service.isAccessAuthorized('ROLE_AGENT_ADD_COLLABORATOR_TO_TICKET') %}
                        self = this;
                        app.appView.showLoader();
                        this.model.destroy({
                            data : { 'ticketId' : this.model.attributes.ticketId },
                            success : function (model, response, options) {
                                app.appView.hideLoader();
                                self.\$el.remove();
                                self.unrender(response);
                            },
                            error: function (model, xhr, options) {
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;
                                var response = warningResponse;
                                if(xhr.responseJSON)
                                    response = xhr.responseJSON;

                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(response);
                            }
                        });
                    {% endif %}
                },
                confirmRemove: function(e) {
                    e.preventDefault();
                    {% if user_service.isAccessAuthorized('ROLE_AGENT_ADD_COLLABORATOR_TO_TICKET') %}
                        app.appView.openConfirmModal(this)
                    {% endif %}
                }
            });

            // Ticket Collaborator View
            var CollaboratorList = Backbone.View.extend({
                el : \$(\".collaborator-list-block\"),
                events : {
                    'keypress .uv-field' : 'addCollaborator',
                    'focusout .uv-field' : 'removeErrorClass'
                },
                initialize : function() {
                    //Backbone.Validation.bind(this);
                },
                render : function() {
                    this.\$el.find(\".collaborator-list\").html('');
                    var self = this;
                    collaboratorOptionHtml = '';
                    
                    if(collaboratorCollection.length) {
                        _.each(collaboratorCollection.models, function (item) {
                            this.renderCollaborator(item);
                        }, this);
                    }
                    ticketView.addCCCollaborators()
                },
                renderCollaborator : function (item) {
                    var collaborator = new CollaboratorItem({
                        model: item
                    });
                    this.\$el.find('.collaborator-list').append(collaborator.render().el);
                },
                removeErrorClass: function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    inputElement.removeClass('uv-field-error');
                    inputElement.parents('.uv-element-block').find('.uv-field-message').remove()
                },
                addCollaborator : function(e) {
                    {% if user_service.isAccessAuthorized('ROLE_AGENT_ADD_COLLABORATOR_TO_TICKET') %}
                        var inputElement = Backbone.\$(e.currentTarget);
                        inputElement.removeClass('uv-field-error');
                        inputElement.parents('.uv-element-block').find('.uv-field-message').remove()
                        var text = inputElement.val().trim();
                       
                        if (e.which === 13 && text) {
                            this.model = new CollaboratorModel();
                            self = this;
                            this.model.set({email: text})

                            if(this.model.isValid(true)) {
                                app.appView.showLoader();
                                this.model.save({},{
                                    success : function (model, response, options) {
                                        inputElement.val('');
                                        if(response.alertClass == \"success\") {
                                            collaboratorCollection.add(model);
                                        }
                                        self.render();
                                        app.appView.hideLoader();
                                        app.appView.renderResponseAlert(response);
                                    },
                                    error: function (model, xhr, options) {
                                        if(url = xhr.getResponseHeader('Location'))
                                            window.location = url;
                                        var response = warningResponse;
                                        if(xhr.responseJSON)
                                            response = xhr.responseJSON;

                                        app.appView.hideLoader();
                                        app.appView.renderResponseAlert(response);
                                    }
                                });
                            } else {
                                inputElement.addClass('uv-field-error');
                                if(text)
                                    inputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>{{ 'Email address is invalid'|trans }}</span>\");
                            }
                        }
                    {% endif %}
                }
            });

       
            // Ticket Tag Item View
            var TagItem = Backbone.View.extend({
                tagName : \"a\",
                className : \"uv-btn-tag\",
                template : _.template(\"<span class='uv-tag'>{% if user_service.isAccessAuthorized('ROLE_AGENT_DELETE_TAG') %}<span class='uv-icon-remove-dark-before'></span>{% endif %}<%- name %></span>\"),
                events : {
                    'click .uv-tag' : \"confirmRemove\"
                },
                render : function () {
                    this.\$el.html(this.template(this.model.toJSON()));
                    return this;
                },
                unrender : function(response) {
                    if(response.alertMessage != undefined) {
                        tagListView.render();
                        app.appView.renderResponseAlert(response);
                    }
                },
                removeItem : function () {
                    {% if user_service.isAccessAuthorized('ROLE_AGENT_DELETE_TAG') %}
                        self = this;
                        app.appView.showLoader();
                        this.model.destroy({
                            data : { 'ticketId' : ticketModel.id } ,
                            success : function (model, response, options) {
                                app.appView.hideLoader();
                                self.\$el.remove();
                                self.unrender(response);
                            },
                            error: function (model, xhr, options) {
                                if(url = xhr.getResponseHeader('Location'))
                                    window.location = url;
                                var response = warningResponse;
                                if(xhr.responseJSON)
                                    response = xhr.responseJSON;

                                app.appView.hideLoader();
                                app.appView.renderResponseAlert(response);
                            }
                        });
                    {% endif %}
                },
                confirmRemove: function(e) {
                    e.preventDefault();
                    {% if user_service.isAccessAuthorized('ROLE_AGENT_DELETE_TAG') %}
                        app.appView.openConfirmModal(this)
                    {% endif %}
                }
            });

            // Ticket Tag View
            var TagList = Backbone.View.extend({
                el : \$(\".tag-list-block\"),
                events : {
                    'keypress .uv-field' : 'addTag',
                    'focusout .uv-field' : 'removeErrorClass',
                    'click .uv-dropdown-list li': 'addTag'
                },
                render : function() {
                    var self = this;
                    this.\$el.find(\".tag-list\").html('');
                    if(tagCollection.length) {
                        _.each(tagCollection.models, function (item) {
                            this.renderTag(item);
                        }, this);
                    }
                },
                renderTag : function (item) {
                    var tag = new TagItem({
                        model: item
                    });
                    this.\$el.find('.tag-list').append(tag.render().el);
                },
                addTag : function(e) {
                    {% if user_service.isAccessAuthorized('ROLE_AGENT_ADD_TAG') %}
                        var currentElement = Backbone.\$(e.currentTarget);
                        if(currentElement.is('li')) {
                            var inputElement = currentElement.parents('.uv-field-block').find('.uv-dropdown-other');
                            var text = currentElement.text().trim();
                        } else {
                            var inputElement = currentElement;
                            var text = inputElement.val().trim();
                        }
                        inputElement.removeClass('uv-field-error');
                        inputElement.parents('.uv-element-block').find('.uv-field-message').remove()
                        
                        if (currentElement.is('li') || (e.which === 13 && text)) {
                            if(text.length <= 20) {
                                if(tagCollection.isTagExist(text)) {
                                    var self = this;
                                    inputElement.val('');
                                    this.model = new TagModel();
                                    this.model.set({name:text});
                                    self = this;

                                    app.appView.showLoader();
                                    this.model.save({}, {
                                        success: function (model, response, options) {
                                            inputElement.parent().find(\"li:not(.uv-no-results)\").remove()
                                            inputElement.parent().find(\".uv-no-results\").show()
                                            if(!currentElement.is('li')) {
                                                inputElement.trigger('click')
                                            }
                                            if(response.alertClass == \"success\") {
                                                tagCollection.add(model);
                                                self.render();
                                            }

                                            app.appView.hideLoader();
                                            app.appView.renderResponseAlert(response);
                                        },
                                        error: function (model, xhr, options) {
                                            if(url = xhr.getResponseHeader('Location'))
                                                window.location = url;
                                            var response = warningResponse;
                                            if(xhr.responseJSON)
                                                response = xhr.responseJSON;

                                            app.appView.hideLoader();
                                            app.appView.renderResponseAlert(response);
                                        }
                                    });
                                } else {
                                    inputElement.addClass('uv-field-error');
                                    inputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>{{ 'Tag with same name already exist'|trans }}</span>\");
                                }
                            } else {
                                inputElement.addClass('uv-field-error');
                                inputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>{{ 'Text length should be less than 20 charactors'|trans }}</span>\");
                            }
                        }
                    {% endif %}
                },
                removeErrorClass: function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    inputElement.removeClass('uv-field-error');
                    inputElement.parents('.uv-element-block').find('.uv-field-message').remove()
                },
            });

            // Ticket Label Item View
            var LabelItem = Backbone.View.extend({
                tagName : \"a\",
                className : \"uv-btn-label\",
                template : _.template(\"<span class='uv-tag'><span class='uv-icon-remove-before'></span><%- name %></span>\"),
                events : {
                    'click .uv-tag' : \"confirmRemove\"
                },
                render : function () {
                    this.\$el.html(this.template(this.model.toJSON()));
                    return this;
                },
                unrender : function(response) {
                    if(response.alertMessage != undefined) {
                        labelListView.render();
                        app.appView.renderResponseAlert(response);
                    }
                },
                removeItem : function () {
                    self = this;
                    app.appView.showLoader();

                    this.model.destroy({
                        url : \"{{ path('helpdesk_member_update_ticket_attributes_xhr') }}\",
                        data : { attribute :'label', 'ticketId': ticketModel.id, 'labelId': this.model.get('id') },
                        success : function (model, response, options) {
                            app.appView.hideLoader();
                            self.\$el.remove();
                            self.unrender(response);
                        },
                        error: function (model, xhr, options) {
                            if(url = xhr.getResponseHeader('Location'))
                                window.location = url;
                            var response = warningResponse;
                            if(xhr.responseJSON)
                                response = xhr.responseJSON;

                            app.appView.hideLoader();
                            app.appView.renderResponseAlert(response);
                        }
                    });
                },
                confirmRemove: function(e) {
                    e.preventDefault();
                    app.appView.openConfirmModal(this)
                }
            });

            // Ticket Label View
            var LabelList = Backbone.View.extend({
                el : \$(\".label-list-block\"),
                events : {
                    'keypress .uv-field' : 'addLabel',
                    'focusout .uv-field' : 'removeErrorClass',
                    'click .uv-dropdown-list li': 'addLabel'
                },
                render : function() {
                    var self = this;
                    this.\$el.find(\".label-list\").html('');
                    if(labelCollection.length) {
                        _.each(labelCollection.models, function (item) {
                            this.renderLabel(item);
                        }, this);
                    }
                },
                renderLabel : function (item) {
                    var label = new LabelItem({
                        model: item
                    });
                    lavelItem = label.render().el;
                    \$(lavelItem).attr('style', 'background:' + item.attributes.color)
                    this.\$el.find('.label-list').append(lavelItem);
                },
                addLabel : function(e) {
                    var currentElement = Backbone.\$(e.currentTarget);
                    if(currentElement.is('li')) {
                        var inputElement = currentElement.parents('.uv-field-block').find('.uv-dropdown-other');
                        var text = currentElement.text().trim();
                    } else {
                        var inputElement = currentElement;
                        var text = inputElement.val().trim();
                    }
                    inputElement.removeClass('uv-field-error');
                    inputElement.parents('.uv-element-block').find('.uv-field-message').remove()

                    if (currentElement.is('li') || (e.which === 13 && text)) {
                        if(text.length <= 20) {
                            if(labelCollection.isLabelExist(text)) {
                                var self = this;
                                inputElement.val('');
                                this.model = new LabelModel();
                                this.model.set({name:text});
                                self = this;

                                app.appView.showLoader();
                                this.model.save({}, {
                                    success: function (model, response, options) {
                                        inputElement.parent().find(\"li:not(.uv-no-results)\").remove()
                                        inputElement.parent().find(\".uv-no-results\").show()
                                        if(!currentElement.is('li')) {
                                            inputElement.trigger('click')
                                        }
                                        if(response.alertClass == \"success\") {
                                            labelCollection.add(model);
                                            self.render();
                                        }

                                        app.appView.hideLoader();
                                        app.appView.renderResponseAlert(response);
                                    },
                                    error: function (model, xhr, options) {
                                        if(url = xhr.getResponseHeader('Location'))
                                            window.location = url;
                                        var response = warningResponse;
                                        if(xhr.responseJSON)
                                            response = xhr.responseJSON;

                                        app.appView.hideLoader();
                                        app.appView.renderResponseAlert(response);
                                    }
                                });
                            } else {
                                inputElement.addClass('uv-field-error');
                                inputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>{{ 'Label with same name already exist'|trans }}</span>\");
                            }
                        } else {
                            inputElement.addClass('uv-field-error');
                            inputElement.parents('.uv-element-block').append(\"<span class='uv-field-message'>{{ 'Text length should be less than 20 charactors'|trans }}</span>\");
                        }
                    }
                },
                removeErrorClass: function(e) {
                    var inputElement = Backbone.\$(e.currentTarget);
                    inputElement.removeClass('uv-field-error');
                    inputElement.parents('.uv-element-block').find('.uv-field-message').remove()
                },
            });
            
            // Ticket Router
            var Router = Backbone.Router.extend({
                routes: {
                    'thread/:thread' : 'threadRequestedId'
                },
                threadRequestedId: function(thread){
                    threadCollection.threadRequestedId = thread;
                },
                scrollPage : function(divId) {
                    if(\$(divId).length){
                        \$('li a[href=\"'+divId+'\"]').trigger('click');
                        \$('.uv-ticket-scroll-region').animate({
                            scrollTop: \$(divId).offset().top
                        }, 'slow');
                    } else if(divId == '#') { //scroll to last thread added
                        if(threadCollection.fullCollection.length)
                            this.scrollPage('#thread' + threadCollection.fullCollection.at(0).id);
                    }
                }
            });

            var customerForm = new CustomerForm({
                el : \$(\".uv-main-info-update-block\"),
                model : new CustomerModel()
            });

            var ticketNavigation = \$.parseJSON('{{ ticketNavigationIteration|json_encode|raw }}');

            var ticketModel = new TicketModel({
                id : \"{{ ticket.id }}\",
                status : \"{{ ticket.status.id }}\",
                priority : \"{{ ticket.priority.id }}\",
                group : \"{{ ticket.supportGroup ? ticket.supportGroup.id : '' }}\",
                subGroup : \"{{ ticket.supportTeam ? ticket.supportTeam.id : '' }}\",
                agent : \"\",
                profileImage : \"\",
                isTrashed : \"{{ ticket.isTrashed }}\"
            });

            ticketApp.ticketView = ticketView = new TicketView({
                model: ticketModel
            });

            uvdesk.ticket.model = ticketModel;
            
            threadCollection = new ThreadCollection();
            var threadList = new ThreadList();
            var pagination = new Pagination();

            var collaboratorCollection = new CollaboratorCollection(\$.parseJSON('{{ ticket_service.getTicketCollaborators(ticket.id)|json_encode|raw }}'));
            var collaboratorList = new CollaboratorList();
            collaboratorList.render();

            var tagCollection = new TagCollection(\$.parseJSON('{{ ticket_service.getTicketTagsById(ticket.id)|json_encode|raw }}'));
            var tagListView = new TagList();
            tagListView.render();

            var labelCollection = new LabelCollection(\$.parseJSON('{{ ticket_service.getTicketLabels(ticket.id)|json_encode|raw }}'));
            var labelListView = new LabelList();
            labelListView.render();

            var router = new Router();
            Backbone.history.start({push_state:true});

            threadCollection.syncData();
        });
    </script>

    <script>
        var sfTinyMceNew = \$.extend({}, sfTinyMce);
        var toolbarOptions = sfTinyMce.options.toolbar;

\t\tsfTinyMce.init({
\t\t\tselector : '.uv-ticket-reply textarea',
\t\t\ttoolbar: toolbarOptions + ' | translate',
            mentions : getMentions(),
            images_upload_url: \"{{ path('helpdesk_member_thread_encoded_image_uploader', {ticketId: app.request.get('ticketId')}) }}\",
            setup: function(editor) {
                editor.on('keydown', function(e) { /** for pageup, pagedown keys **/
                    if(e.keyCode == 34 || e.keyCode == 33){
                        e.preventDefault();
                    }
                });
                addTranslateButton(editor);
            }
\t\t});

        function InitTinyMce(selector) {
            let sfTinyMceNew2 = \$.extend({}, sfTinyMceNew);
            sfTinyMceNew2.init({
                selector : selector,
                mentions : getMentions(),
                setup: function(editor) {
                    addTranslateButton(editor);
                }
            });
        }

        function getMentions(){
\t\t\treturn {
\t\t\t\tdelimiter: ['#'],
                items: 15,
\t\t\t\tsource: function(){
                    return [
                        {
                            name : \"{{ 'Ticket Id'|trans }}\",
                            value : \"{{ ticket.id }}\",
                        },
                        {
                            name : \"{{ 'Subject'|trans }}\",
                            value : \"{{ ticket.subject|replace({\"\\n\":' ', \"\\r\":' '}) }}\",
                        },
                        {
                            name : \"{{ 'Status'|trans }}\",
                            value : \"{{ ticket.status.description }}\",
                        },
                        {
                            name : \"{{ 'Priority'|trans }}\",
                            value : \"{{ ticket.priority.description }}\",
                        },
                        {
                            name : \"{{ 'Type'|trans }}\",
                            value : \"{{ ticket.type ? ticket.type.description : 'Not Assigned'|trans }}\",
                        },
                        {
                            name : \"{{ 'Group'|trans }}\",
                            value : \"{{ ticket.supportGroup ? ticket.supportGroup.description : 'Not Assigned'|trans }}\",
                        },
                        {
                            name : \"{{ 'Team'|trans }}\",
                            value : \"{{ ticket.supportTeam ? ticket.supportTeam.description : 'Not Assigned'|trans }}\",
                        },
                        {
                            name : \"{{ 'Customer Name'|trans }}\",
                            value : \"{{ customer.name }}\",
                        },
                        {
                            name : \"{{ 'Customer Email'|trans }}\",
                            value : \"{{ customer.email }}\",
                        },
                        {
                            name : \"{{ 'Agent Name'|trans }}\",
                            value : \"{{ ticketAgent.name is defined ? ticketAgent.name : 'Not Assigned'|trans }}\",
                        },
                        {
                            name : \"{{ 'Agent Email'|trans }}\",
                            value : \"{{ ticketAgent.email is defined ? ticketAgent.email : 'Not Assigned'|trans }}\",
                        }
                    ];
\t\t\t\t},
\t\t\t\tinsert: function(item) {
\t\t\t\t\treturn '<span>' + item.value + '</span>';
\t\t\t\t}
\t\t\t};
        }
    </script>
{% endblock %}
", "@UVDeskCoreFramework//ticket.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/ticket.html.twig");
    }
}
