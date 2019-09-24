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

/* @UVDeskCoreFramework/Templates/header.html.twig */
class __TwigTemplate_663bf04cf4a10be4b6b65ab07270bff91a359680c397811a2a6bb50278af8cba extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Templates/header.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Templates/header.html.twig"));

        // line 1
        echo "<!-- Navbar -->
<style>
    .uv-navbar .uv-notification-list li {
        cursor: default;
        font-size: 15px !important;
    }
    .uv-navbar .uv-notification-list li * {
        display: inline-block !important;
    }
    .uv-navbar .uv-notification-list li a {
         color: #2750C4 !important;
    }
    .uv-navbar .uv-notification-list ul {
        max-height: 320px !important;
    }
    .uv-navbar .uv-notification-list .timeago {
        color: #9E9E9E;
        margin-top: 5px;
        font-size: 13px;
    }
    .uv-navbar .uv-dropdown-container.load-more {
        border-top: solid 1px #D3D3D3;
        text-align: center;
    }
    .uv-navbar .uv-dropdown-container.load-more a {
        color: #333;
        text-transform: capitalize;
        font-size: 15px;
        font-weight: 500;
    }
    .uv-navbar .uv-icon-load-more {
        margin-right: 5px;
    }
    .uv-plan-list-item .uv-text-light-color {
        color: #9E9E9E;
    }
    .uv-plan-list-item .uv-plan-badge {
        color: #FFFFFF;
        font-size: 12px;
        padding: 1px 5px;
        border-radius: 3px;
        margin-left: 5px;
        display: inline-block;
        text-transform: uppercase;
    }
    .uv-plan-list-item .uv-plan-badge-color-free {
        background: #4486ee;
    }
    .uv-plan-list-item .uv-plan-badge-color-pro {
        background: #f5d02a;
    }
    .uv-plan-list-item .uv-plan-badge-color-enterprise {
        background: #fd9a9a;
    }
    .uv-plan-list-item .uv-plan-badge-color-customized {
        background: #b77af5;
    }
    .uv-onboard-navigator {
        cursor: pointer;
    }
    .uv-margin-icon-srch {
        margin: 5px 0px 0px 5px;
    }

    .uv-mob-aside{
        position: fixed;
        z-index: 999;
        top: 105px;
        left: 288px;
        transition: 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .uv-sidebar.uv-sidebar-active ~ .uv-paper .uv-mob-aside{
        left: 320px;
    }
    .uv-mob-aside.uv-mob-aside-collapsed{
        left: 286px;
    }
    .uv-sidebar.uv-sidebar-active ~ .uv-paper .uv-mob-aside.uv-mob-aside-collapsed{
        left: 45px;
    }
    .uv-view.uv-aside-view{
        padding: 25px 0px 25px 25px;
    }
    .uv-inner-section .uv-view.uv-aside-view .uv-ticket-scroll-region.uv-aside-view-tv{
        left: 20px;
    }
    .uv-mob-aside .uv-icon-aside-menu,.uv-mob-aside .uv-icon-aside-menu:hover {
        background-position: 1px -497px;
    }
    .uv-mob-aside-collapsed .uv-icon-aside-menu, .uv-mob-aside-collapsed .uv-icon-aside-menu:hover {
        background-position: 5px -497px;
    }
    .uv-mob-aside:not(.uv-mob-aside-collapsed) .uv-icon-aside-menu,.uv-mob-aside:not(.uv-mob-aside-collapsed) .uv-icon-aside-menu:hover {
        -ms-transform: rotate(180deg);
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .uv-mob-aside:not(.uv-mob-aside-collapsed) .uv-icon-aside-menu:hover,.uv-rtl .uv-mob-aside.uv-mob-aside-collapsed .uv-icon-aside-menu:hover {
        box-shadow: 0px -8px 15px 3px rgba(0, 0, 0, 0.15), 0px -2px 3px 0px rgba(0, 0, 0, 0.2);
    }
    .uv-rtl .uv-mob-aside:not(.uv-mob-aside-collapsed) .uv-icon-aside-menu,.uv-rtl .uv-mob-aside:not(.uv-mob-aside-collapsed) .uv-icon-aside-menu:hover {
        -ms-transform: unset;
        -webkit-transform: unset;
        transform: unset;
    }
    .uv-rtl .uv-mob-aside.uv-mob-aside-collapsed .uv-icon-aside-menu,.uv-rtl .uv-mob-aside.uv-mob-aside-collapsed .uv-icon-aside-menu:hover {
        -ms-transform: rotate(180deg)!important;
        -webkit-transform: rotate(180deg)!important;
        transform: rotate(180deg)!important;
    }
    .uv-rtl .uv-sidebar.uv-sidebar-active ~ .uv-paper .uv-mob-aside{
        right: 320px;
        left: unset;
    }
    .uv-rtl .uv-mob-aside.uv-mob-aside-collapsed{
        right: 286px;
    }
    .uv-rtl .uv-sidebar.uv-sidebar-active ~ .uv-paper .uv-mob-aside.uv-mob-aside-collapsed{
        right: 45px;
    }
    .uv-rtl .uv-inner-section .uv-view.uv-aside-view .uv-ticket-scroll-region.uv-aside-view-tv{
        right: 20px;
    }
    .uv-rtl .uv-sidebar:not(.uv-sidebar-active) ~ .uv-paper .uv-mob-aside:not(.uv-mob-aside-collapsed) {
        right: 560px
    }
    .uv-rtl .uv-mob-aside{
        left: unset;
    }
    .uv-menubar.uv-language .uv-dropdown-list {
        z-index: 19999;
    }

    .user-name {
        font-weight: 800;
        margin-top: 2px;
        font-size: medium;
    }

    @media screen and (min-width: 901px) and (max-width: 1400px) {
        .uv-sidebar.uv-sidebar-active ~ .uv-paper .uv-mob-aside{
            left: 290px;
        }
        .uv-mob-aside.uv-mob-aside-collapsed{
            left: 40px;
        }
        .uv-rtl .uv-sidebar.uv-sidebar-active ~ .uv-paper .uv-mob-aside{
            right: 290px;
        }
        .uv-rtl  .uv-mob-aside.uv-mob-aside-collapsed{
            right: 52px;
        }
    }
    @media screen and (max-width: 1024px) {
        .uv-mob-aside{
            top: 48px;
            left: 80px!important;
        }
        .uv-mob-aside-collapsed .uv-icon-aside-menu, .uv-mob-aside-collapsed .uv-icon-aside-menu:hover {
            background-position: 1px -497px;
        }
        .uv-sidebar ul.uv-menubar li a {
            max-width: 60px !important;
        }
        .uv-sidebar .uv-soft-top .uv-company-logo {
            width: unset;
        }
        #google_translate_element .goog-te-gadget-simple {
            width: 26px;
            overflow: hidden;
            font-size: 0px;
            padding: 3px 2px 2px 2px;
        }
    }
    @media screen and (max-width: 400px) {
        #google_translate_element {
            display: none;
        }
    }
    .uv-rtl .uv-mob-aside{
        right: 320px;
    }
    .uv-pop-up-body .uv-mob-aside {
        display: none;
        transition: none;
    }
    .uv-rtl .uv-view.uv-aside-view{
        padding: 25px 25px 25px 0px;
    }
    .uv-rtl .uv-inner-section .uv-view.uv-aside-view .uv-ticket-scroll-region.uv-aside-view-tv{
        left: 0px;
        right: 20px;
    }
    .uv-filter-view .uv-filter-head .uv-filter-toggle span{
        background-position: -21px -245px;
    }
    .uv-view.uv-aside-view{
        padding: 25px 0px 25px 25px;
    }
    .uv-inner-section .uv-view.uv-aside-view .uv-ticket-scroll-region.uv-aside-view-tv{
        left: 20px;
    }
    .uv-rtl .uv-view.uv-aside-view{
        padding: 25px 25px 25px 0px;
    }
    .uv-rtl .uv-inner-section .uv-view.uv-aside-view .uv-ticket-scroll-region.uv-aside-view-tv{
        left: 0px;
        right: 20px;
    }
    .uv-filter-view .uv-filter-head .uv-filter-toggle span{
        background-position: -21px -245px;
    }


    .uv-inner-section .uv-view.uv-aside-view .uv-ticket-fixed-region{
        left: 20px;
    }

    .uv-rtl .uv-inner-section .uv-view.uv-aside-view .uv-ticket-fixed-region {
        left: 0px;
        right: 20px;
    }

    div.mce-edit-area {
        margin-right: 1px!important;
    }

    .uv-whats-newlist li img {
        width: 40px;
    }
    .uv-got-whats-new {
        background-color: #7C70F4;
        border-radius: 50%;
        padding: 4px;
        border: 2px solid white;
        position: absolute;
        top: -3px;
        right: -3px;
    }
    .uv-feature-title {
        vertical-align: top;
        font-size: 18px;
        margin: 5px 0 0 5px;
        word-wrap: break-word;
        display: inline-block;
    }
    .uv-feature-content {
        margin: 2px 0 0 0;
    }
    .uv-dropdown-list ul .uv-feature-link, .uv-dropdown-list ul .uv-feature-link:link, .uv-dropdown-list ul .uv-feature-link:active, .uv-dropdown-list ul .uv-feature-link:visited, .uv-dropdown-list ul .uv-feature-link:focus {
        color: #2750C4;
        font-size: 15px;
        margin-top: 10px;
    }
    .uv-dropdown-list ul.uv-search-list li.uv-whats-li {
        border-top: none;
        padding-top: 5px;
    }
    .uv-whats-newlist + .uv-notification-list {
        margin-left: 15px;
    }
    .uv-search-result-wrapper a:focus > .uv-search-result-row {
        background-color: #f0f0f0;
    }
    .uv-loader-view ~ .uv-notifications-wrapper {
        z-index: 9999;
    }
    .mce-notification-error {
        display: none;
    }
    ul.uv-flag-notice-list {
        color: #333333;
        border-top: solid 1px #D3D3D3;
        border-bottom: solid 1px #D3D3D3;
        padding: 15px 20px;
        background: #FAFAFA;
    }
    .uv-dropdown-list ul.uv-search-list.flags-active li:first-child {
        border-top: unset;
    }

    ";
        // line 287
        echo "
    .dropdown-divider {
        border-top: 1px solid #e1e4e8;
        display: block;
        height: 0;
        margin: 10px 0 10px -19px;
        width: 195px;
    }
</style>

<!-- Navigation -->
<div class=\"uv-navbar\">
    <!-- Banner -->
    <div class=\"uv-mob-aside ";
        // line 300
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 300, $this->source); })()), "request", [], "any", false, false, false, 300), "cookies", [], "any", false, false, false, 300) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 300, $this->source); })()), "request", [], "any", false, false, false, 300), "cookies", [], "any", false, false, false, 300), "get", [0 => "uv-asideView"], "method", false, false, false, 300))) {
            echo "uv-mob-aside-collapsed";
        }
        echo "\">
        <span class=\"uv-icon-aside-menu\"></span>
    </div>

    <!-- Search Box -->
    ";
        // line 305
        echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["uvdesk_extensibles"]) || array_key_exists("uvdesk_extensibles", $context) ? $context["uvdesk_extensibles"] : (function () { throw new RuntimeError('Variable "uvdesk_extensibles" does not exist.', 305, $this->source); })()), "getRegisteredComponent", [0 => "Webkul\\UVDesk\\CoreFrameworkBundle\\Dashboard\\SearchTemplate"], "method", false, false, false, 305), "render", [], "method", false, false, false, 305);
        echo "

    <div class=\"uv-actions\">
        <!-- Profile Navigations -->
        <span style=\"position: relative\" class=\"\">
            <div class=\"uv-profile uv-dropdown-other\">
                ";
        // line 311
        if ((((isset($context["currentUserDetails"]) || array_key_exists("currentUserDetails", $context)) && twig_get_attribute($this->env, $this->source, ($context["currentUserDetails"] ?? null), "thumbnail", [], "any", true, true, false, 311)) &&  !twig_test_empty(twig_get_attribute($this->env, $this->source, (isset($context["currentUserDetails"]) || array_key_exists("currentUserDetails", $context) ? $context["currentUserDetails"] : (function () { throw new RuntimeError('Variable "currentUserDetails" does not exist.', 311, $this->source); })()), "thumbnail", [], "any", false, false, false, 311)))) {
            // line 312
            echo "                    <img class='uv-avatar' src=\"";
            echo twig_escape_filter($this->env, (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 312, $this->source); })()), "request", [], "any", false, false, false, 312), "scheme", [], "any", false, false, false, 312) . "://") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 312, $this->source); })()), "request", [], "any", false, false, false, 312), "httpHost", [], "any", false, false, false, 312)) . $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("")), "html", null, true);
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["currentUserDetails"]) || array_key_exists("currentUserDetails", $context) ? $context["currentUserDetails"] : (function () { throw new RuntimeError('Variable "currentUserDetails" does not exist.', 312, $this->source); })()), "thumbnail", [], "any", false, false, false, 312), "html", null, true);
            echo "\"/>
                ";
        } else {
            // line 314
            echo "                    <img class='uv-avatar' src=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bundles/uvdeskcoreframework/images/uv-avatar-batman.png"), "html", null, true);
            echo "\"/>
                ";
        }
        // line 316
        echo "            </div>

            <div class=\"uv-dropdown-list uv-bottom-right uv-text-left\">
                <div class=\"uv-dropdown-container\">

                    <label>";
        // line 321
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Signed in as"), "html", null, true);
        echo "</label>
                        <p class=\"user-name\">";
        // line 322
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 322, $this->source); })()), "firstName", [], "any", false, false, false, 322), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["currentUser"]) || array_key_exists("currentUser", $context) ? $context["currentUser"] : (function () { throw new RuntimeError('Variable "currentUser" does not exist.', 322, $this->source); })()), "lastName", [], "any", false, false, false, 322), "html", null, true);
        echo "</p>
                    <div role=\"none\" class=\"dropdown-divider\"></div>

                    <ul>
                        <li><a href=\"";
        // line 326
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("edit_profile");
        echo "\" class='profiler'>";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Your Profile"), "html", null, true);
        echo "</a></li>
                    </ul>

                    <ul>
                        <li data-action=\"create\" class=\"uv-open-popup\" data-target=\"create-ticket-modal\">";
        // line 330
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Create Ticket"), "html", null, true);
        echo "</li>
\t\t\t\t\t\t";
        // line 331
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 331, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_MANAGE_AGENT"], "method", false, false, false, 331)) {
            // line 332
            echo "                            <li><a href=\"";
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_create_account");
            echo "\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Create Agent"), "html", null, true);
            echo "</a></li>
                        ";
        }
        // line 334
        echo "\t\t\t\t\t\t";
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 334, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_MANAGE_CUSTOMER"], "method", false, false, false, 334)) {
            // line 335
            echo "                            <li><a href=\"";
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_create_customer_account");
            echo "\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Create Customer"), "html", null, true);
            echo "</a></li>
                        ";
        }
        // line 337
        echo "
                        <div role=\"none\" class=\"dropdown-divider\"></div>
                        <li><a class=\"uv-text-danger\" href=\"";
        // line 339
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("helpdesk_member_handle_logout");
        echo "\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Sign Out"), "html", null, true);
        echo "</a></li>
                    </ul>
                </div>
            </div>
        </span>
    </div>
</div>

<script type=\"text/template\" id=\"notification_flags_temp\">
    <% if (typeof undeliveredMessages != 'undefined') { %>
        <li>
            <span class=\"uv-notification-message\">
                <%= undeliveredMessages %>
            </span>
        </li>
        <span class=\"timeago\">";
        // line 354
        echo $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Learn more about %deliveryStatus%.", ["%deliveryStatus%" => (("<a href=\"https://support.uvdesk.com/en/blog/uvdesk-ticket-delivery-status\" target=\"_blank\">" . $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("ticket delivery status")) . "</a>")]);
        echo "</span>
    <% } %>
</script>

<script type=\"text/javascript\">
    \$(function () {
        var FeatureSearch = Backbone.View.extend({
            el: \$('.uv-search-wrapper'),
            events: {
                'keyup .uv-search-bar': 'searchFeature',
                'click .uv-search-bar': 'openFeatureSearch',
            },
            searchFeature: function(e) {
                var currentElement = Backbone.\$(e.currentTarget);
                if(currentElement.val().trim() != '') {
                    var flag = 0;
                    \$('.uv-search-wrapper').find('.uv-search-result-row').each(function() {
                        if(!\$(this).hasClass('uv-no-results')) {
                            var text = \$(this).text().trim().toLowerCase();
                            var isTextContained = text.search(currentElement.val().trim().toLowerCase());
                            if(isTextContained < 0) {
                                \$(this).parent().hide();
                                \$(this).parent().attr('tabIndex', -1);
                            } else {
                                \$(this).parent().show();
                                \$(this).parent().removeAttr('tabIndex');
                                flag = 1;
                            }
                        }
                    });
                    if(flag == 0)
                        \$('.uv-search-wrapper').find(\".uv-no-results\").show();
                    else
                        \$('.uv-search-wrapper').find(\".uv-no-results\").hide();

                    this.\$el.find('.uv-search-result-wrapper').addClass('uv-search-result-active').addClass('uv-search-flap-up')
                } else {
                    this.\$el.find('.uv-search-result-wrapper').removeClass('uv-search-result-active').removeClass('uv-search-flap-up')
                }
            },
            openFeatureSearch: function(e) {
                var currentElement = Backbone.\$(e.currentTarget);
                if(currentElement.val().trim() != '') {
                    this.\$el.find('.uv-search-result-wrapper').addClass('uv-search-result-active').addClass('uv-search-flap-up')
                }
            }
        });

        var SidePanelUV = Backbone.View.extend({
            el: \$('.uv-paper'),
            events: {
                'click .uv-mob-aside span': 'toggleAsideBar'
            },
            initialize : function() {
                var ele = \$('.uv-paper');
                if(ele.css('padding-left') == '60px'){
                    \$('.uv-mob-aside').removeClass('uv-mob-aside-left');
                }else{
                    \$('.uv-mob-aside').addClass('uv-mob-aside-left');
                }

                var asideView = '";
        // line 415
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 415, $this->source); })()), "request", [], "any", false, false, false, 415), "cookies", [], "any", false, false, false, 415), "get", [0 => "uv-asideView"], "method", false, false, false, 415), "html", null, true);
        echo "';
                if(asideView == 'true')
                    this.toggleAsideBar();
            },
            toggleAsideBar: function(){
                var asideView = true;
                var ele = \$('.uv-inner-section .uv-aside');
                var eleSidePanel = \$('.uv-inner-section .uv-view');
                var eleTicketView = \$('.uv-inner-section .uv-view .uv-ticket-scroll-region');
                var mobAside = \$('.uv-mob-aside');
                if(ele.css('display') == 'none'){
                    asideView = false;
                    ele.css('display', 'block');
                    eleSidePanel.removeClass('uv-aside-view');
                    eleTicketView.removeClass('uv-aside-view-tv');
                    mobAside.removeClass('uv-mob-aside-collapsed')
                }else{
                    ele.css('display', 'none');
                    eleSidePanel.addClass('uv-aside-view');
                    eleTicketView.addClass('uv-aside-view-tv');
                    mobAside.addClass('uv-mob-aside-collapsed')
                }
                if(asideView) {
                    document.cookie = (\"uv-asideView=1; expires=Wed, 01 Jan 2020 00:00:00 GMT;path=/\");
                } else {
                    document.cookie = (\"uv-asideView=0; expires=Wed, 01 Jan 2020 00:00:00 GMT;path=/\");
                }
            }
        });

        var featureSearch =  new FeatureSearch();
        var sidePanelUV =  new SidePanelUV();
    });
</script>

";
        // line 451
        if (twig_get_attribute($this->env, $this->source, (isset($context["user_service"]) || array_key_exists("user_service", $context) ? $context["user_service"] : (function () { throw new RuntimeError('Variable "user_service" does not exist.', 451, $this->source); })()), "isAccessAuthorized", [0 => "ROLE_AGENT_CREATE_TICKET"], "method", false, false, false, 451)) {
            // line 452
            echo "    ";
            echo twig_get_attribute($this->env, $this->source, (isset($context["ticket_service"]) || array_key_exists("ticket_service", $context) ? $context["ticket_service"] : (function () { throw new RuntimeError('Variable "ticket_service" does not exist.', 452, $this->source); })()), "appendTwigSnippet", [0 => "createMemberTicket"], "method", false, false, false, 452);
            echo "
    ";
        }
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework/Templates/header.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  558 => 452,  556 => 451,  518 => 415,  454 => 354,  434 => 339,  430 => 337,  422 => 335,  419 => 334,  411 => 332,  409 => 331,  405 => 330,  396 => 326,  387 => 322,  383 => 321,  376 => 316,  370 => 314,  363 => 312,  361 => 311,  352 => 305,  342 => 300,  327 => 287,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!-- Navbar -->
<style>
    .uv-navbar .uv-notification-list li {
        cursor: default;
        font-size: 15px !important;
    }
    .uv-navbar .uv-notification-list li * {
        display: inline-block !important;
    }
    .uv-navbar .uv-notification-list li a {
         color: #2750C4 !important;
    }
    .uv-navbar .uv-notification-list ul {
        max-height: 320px !important;
    }
    .uv-navbar .uv-notification-list .timeago {
        color: #9E9E9E;
        margin-top: 5px;
        font-size: 13px;
    }
    .uv-navbar .uv-dropdown-container.load-more {
        border-top: solid 1px #D3D3D3;
        text-align: center;
    }
    .uv-navbar .uv-dropdown-container.load-more a {
        color: #333;
        text-transform: capitalize;
        font-size: 15px;
        font-weight: 500;
    }
    .uv-navbar .uv-icon-load-more {
        margin-right: 5px;
    }
    .uv-plan-list-item .uv-text-light-color {
        color: #9E9E9E;
    }
    .uv-plan-list-item .uv-plan-badge {
        color: #FFFFFF;
        font-size: 12px;
        padding: 1px 5px;
        border-radius: 3px;
        margin-left: 5px;
        display: inline-block;
        text-transform: uppercase;
    }
    .uv-plan-list-item .uv-plan-badge-color-free {
        background: #4486ee;
    }
    .uv-plan-list-item .uv-plan-badge-color-pro {
        background: #f5d02a;
    }
    .uv-plan-list-item .uv-plan-badge-color-enterprise {
        background: #fd9a9a;
    }
    .uv-plan-list-item .uv-plan-badge-color-customized {
        background: #b77af5;
    }
    .uv-onboard-navigator {
        cursor: pointer;
    }
    .uv-margin-icon-srch {
        margin: 5px 0px 0px 5px;
    }

    .uv-mob-aside{
        position: fixed;
        z-index: 999;
        top: 105px;
        left: 288px;
        transition: 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .uv-sidebar.uv-sidebar-active ~ .uv-paper .uv-mob-aside{
        left: 320px;
    }
    .uv-mob-aside.uv-mob-aside-collapsed{
        left: 286px;
    }
    .uv-sidebar.uv-sidebar-active ~ .uv-paper .uv-mob-aside.uv-mob-aside-collapsed{
        left: 45px;
    }
    .uv-view.uv-aside-view{
        padding: 25px 0px 25px 25px;
    }
    .uv-inner-section .uv-view.uv-aside-view .uv-ticket-scroll-region.uv-aside-view-tv{
        left: 20px;
    }
    .uv-mob-aside .uv-icon-aside-menu,.uv-mob-aside .uv-icon-aside-menu:hover {
        background-position: 1px -497px;
    }
    .uv-mob-aside-collapsed .uv-icon-aside-menu, .uv-mob-aside-collapsed .uv-icon-aside-menu:hover {
        background-position: 5px -497px;
    }
    .uv-mob-aside:not(.uv-mob-aside-collapsed) .uv-icon-aside-menu,.uv-mob-aside:not(.uv-mob-aside-collapsed) .uv-icon-aside-menu:hover {
        -ms-transform: rotate(180deg);
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .uv-mob-aside:not(.uv-mob-aside-collapsed) .uv-icon-aside-menu:hover,.uv-rtl .uv-mob-aside.uv-mob-aside-collapsed .uv-icon-aside-menu:hover {
        box-shadow: 0px -8px 15px 3px rgba(0, 0, 0, 0.15), 0px -2px 3px 0px rgba(0, 0, 0, 0.2);
    }
    .uv-rtl .uv-mob-aside:not(.uv-mob-aside-collapsed) .uv-icon-aside-menu,.uv-rtl .uv-mob-aside:not(.uv-mob-aside-collapsed) .uv-icon-aside-menu:hover {
        -ms-transform: unset;
        -webkit-transform: unset;
        transform: unset;
    }
    .uv-rtl .uv-mob-aside.uv-mob-aside-collapsed .uv-icon-aside-menu,.uv-rtl .uv-mob-aside.uv-mob-aside-collapsed .uv-icon-aside-menu:hover {
        -ms-transform: rotate(180deg)!important;
        -webkit-transform: rotate(180deg)!important;
        transform: rotate(180deg)!important;
    }
    .uv-rtl .uv-sidebar.uv-sidebar-active ~ .uv-paper .uv-mob-aside{
        right: 320px;
        left: unset;
    }
    .uv-rtl .uv-mob-aside.uv-mob-aside-collapsed{
        right: 286px;
    }
    .uv-rtl .uv-sidebar.uv-sidebar-active ~ .uv-paper .uv-mob-aside.uv-mob-aside-collapsed{
        right: 45px;
    }
    .uv-rtl .uv-inner-section .uv-view.uv-aside-view .uv-ticket-scroll-region.uv-aside-view-tv{
        right: 20px;
    }
    .uv-rtl .uv-sidebar:not(.uv-sidebar-active) ~ .uv-paper .uv-mob-aside:not(.uv-mob-aside-collapsed) {
        right: 560px
    }
    .uv-rtl .uv-mob-aside{
        left: unset;
    }
    .uv-menubar.uv-language .uv-dropdown-list {
        z-index: 19999;
    }

    .user-name {
        font-weight: 800;
        margin-top: 2px;
        font-size: medium;
    }

    @media screen and (min-width: 901px) and (max-width: 1400px) {
        .uv-sidebar.uv-sidebar-active ~ .uv-paper .uv-mob-aside{
            left: 290px;
        }
        .uv-mob-aside.uv-mob-aside-collapsed{
            left: 40px;
        }
        .uv-rtl .uv-sidebar.uv-sidebar-active ~ .uv-paper .uv-mob-aside{
            right: 290px;
        }
        .uv-rtl  .uv-mob-aside.uv-mob-aside-collapsed{
            right: 52px;
        }
    }
    @media screen and (max-width: 1024px) {
        .uv-mob-aside{
            top: 48px;
            left: 80px!important;
        }
        .uv-mob-aside-collapsed .uv-icon-aside-menu, .uv-mob-aside-collapsed .uv-icon-aside-menu:hover {
            background-position: 1px -497px;
        }
        .uv-sidebar ul.uv-menubar li a {
            max-width: 60px !important;
        }
        .uv-sidebar .uv-soft-top .uv-company-logo {
            width: unset;
        }
        #google_translate_element .goog-te-gadget-simple {
            width: 26px;
            overflow: hidden;
            font-size: 0px;
            padding: 3px 2px 2px 2px;
        }
    }
    @media screen and (max-width: 400px) {
        #google_translate_element {
            display: none;
        }
    }
    .uv-rtl .uv-mob-aside{
        right: 320px;
    }
    .uv-pop-up-body .uv-mob-aside {
        display: none;
        transition: none;
    }
    .uv-rtl .uv-view.uv-aside-view{
        padding: 25px 25px 25px 0px;
    }
    .uv-rtl .uv-inner-section .uv-view.uv-aside-view .uv-ticket-scroll-region.uv-aside-view-tv{
        left: 0px;
        right: 20px;
    }
    .uv-filter-view .uv-filter-head .uv-filter-toggle span{
        background-position: -21px -245px;
    }
    .uv-view.uv-aside-view{
        padding: 25px 0px 25px 25px;
    }
    .uv-inner-section .uv-view.uv-aside-view .uv-ticket-scroll-region.uv-aside-view-tv{
        left: 20px;
    }
    .uv-rtl .uv-view.uv-aside-view{
        padding: 25px 25px 25px 0px;
    }
    .uv-rtl .uv-inner-section .uv-view.uv-aside-view .uv-ticket-scroll-region.uv-aside-view-tv{
        left: 0px;
        right: 20px;
    }
    .uv-filter-view .uv-filter-head .uv-filter-toggle span{
        background-position: -21px -245px;
    }


    .uv-inner-section .uv-view.uv-aside-view .uv-ticket-fixed-region{
        left: 20px;
    }

    .uv-rtl .uv-inner-section .uv-view.uv-aside-view .uv-ticket-fixed-region {
        left: 0px;
        right: 20px;
    }

    div.mce-edit-area {
        margin-right: 1px!important;
    }

    .uv-whats-newlist li img {
        width: 40px;
    }
    .uv-got-whats-new {
        background-color: #7C70F4;
        border-radius: 50%;
        padding: 4px;
        border: 2px solid white;
        position: absolute;
        top: -3px;
        right: -3px;
    }
    .uv-feature-title {
        vertical-align: top;
        font-size: 18px;
        margin: 5px 0 0 5px;
        word-wrap: break-word;
        display: inline-block;
    }
    .uv-feature-content {
        margin: 2px 0 0 0;
    }
    .uv-dropdown-list ul .uv-feature-link, .uv-dropdown-list ul .uv-feature-link:link, .uv-dropdown-list ul .uv-feature-link:active, .uv-dropdown-list ul .uv-feature-link:visited, .uv-dropdown-list ul .uv-feature-link:focus {
        color: #2750C4;
        font-size: 15px;
        margin-top: 10px;
    }
    .uv-dropdown-list ul.uv-search-list li.uv-whats-li {
        border-top: none;
        padding-top: 5px;
    }
    .uv-whats-newlist + .uv-notification-list {
        margin-left: 15px;
    }
    .uv-search-result-wrapper a:focus > .uv-search-result-row {
        background-color: #f0f0f0;
    }
    .uv-loader-view ~ .uv-notifications-wrapper {
        z-index: 9999;
    }
    .mce-notification-error {
        display: none;
    }
    ul.uv-flag-notice-list {
        color: #333333;
        border-top: solid 1px #D3D3D3;
        border-bottom: solid 1px #D3D3D3;
        padding: 15px 20px;
        background: #FAFAFA;
    }
    .uv-dropdown-list ul.uv-search-list.flags-active li:first-child {
        border-top: unset;
    }

    {# .uv-main-logo {
        position: absolute;
        padding: 10px 0 0px 30px;
    } #}

    .dropdown-divider {
        border-top: 1px solid #e1e4e8;
        display: block;
        height: 0;
        margin: 10px 0 10px -19px;
        width: 195px;
    }
</style>

<!-- Navigation -->
<div class=\"uv-navbar\">
    <!-- Banner -->
    <div class=\"uv-mob-aside {% if app.request.cookies and app.request.cookies.get('uv-asideView') %}uv-mob-aside-collapsed{% endif %}\">
        <span class=\"uv-icon-aside-menu\"></span>
    </div>

    <!-- Search Box -->
    {{ uvdesk_extensibles.getRegisteredComponent('Webkul\\\\UVDesk\\\\CoreFrameworkBundle\\\\Dashboard\\\\SearchTemplate').render() | raw }}

    <div class=\"uv-actions\">
        <!-- Profile Navigations -->
        <span style=\"position: relative\" class=\"\">
            <div class=\"uv-profile uv-dropdown-other\">
                {% if currentUserDetails is defined and currentUserDetails.thumbnail is defined and currentUserDetails.thumbnail is not empty %}
                    <img class='uv-avatar' src=\"{{ app.request.scheme ~'://' ~ app.request.httpHost ~ asset('') }}{{ currentUserDetails.thumbnail }}\"/>
                {% else %}
                    <img class='uv-avatar' src=\"{{ asset('bundles/uvdeskcoreframework/images/uv-avatar-batman.png') }}\"/>
                {% endif %}
            </div>

            <div class=\"uv-dropdown-list uv-bottom-right uv-text-left\">
                <div class=\"uv-dropdown-container\">

                    <label>{{'Signed in as'|trans}}</label>
                        <p class=\"user-name\">{{ currentUser.firstName }} {{ currentUser.lastName }}</p>
                    <div role=\"none\" class=\"dropdown-divider\"></div>

                    <ul>
                        <li><a href=\"{{ path('edit_profile') }}\" class='profiler'>{{'Your Profile'|trans}}</a></li>
                    </ul>

                    <ul>
                        <li data-action=\"create\" class=\"uv-open-popup\" data-target=\"create-ticket-modal\">{{'Create Ticket'|trans}}</li>
\t\t\t\t\t\t{% if user_service.isAccessAuthorized('ROLE_AGENT_MANAGE_AGENT') %}
                            <li><a href=\"{{ path('helpdesk_member_create_account') }}\">{{'Create Agent'|trans}}</a></li>
                        {% endif %}
\t\t\t\t\t\t{% if user_service.isAccessAuthorized('ROLE_AGENT_MANAGE_CUSTOMER') %}
                            <li><a href=\"{{ path('helpdesk_member_create_customer_account') }}\">{{'Create Customer'|trans}}</a></li>
                        {% endif %}

                        <div role=\"none\" class=\"dropdown-divider\"></div>
                        <li><a class=\"uv-text-danger\" href=\"{{ path('helpdesk_member_handle_logout') }}\">{{\"Sign Out\"|trans}}</a></li>
                    </ul>
                </div>
            </div>
        </span>
    </div>
</div>

<script type=\"text/template\" id=\"notification_flags_temp\">
    <% if (typeof undeliveredMessages != 'undefined') { %>
        <li>
            <span class=\"uv-notification-message\">
                <%= undeliveredMessages %>
            </span>
        </li>
        <span class=\"timeago\">{{ 'Learn more about %deliveryStatus%.'|trans({'%deliveryStatus%': '<a href=\"https://support.uvdesk.com/en/blog/uvdesk-ticket-delivery-status\" target=\"_blank\">' ~ 'ticket delivery status'|trans ~ '</a>'})|raw }}</span>
    <% } %>
</script>

<script type=\"text/javascript\">
    \$(function () {
        var FeatureSearch = Backbone.View.extend({
            el: \$('.uv-search-wrapper'),
            events: {
                'keyup .uv-search-bar': 'searchFeature',
                'click .uv-search-bar': 'openFeatureSearch',
            },
            searchFeature: function(e) {
                var currentElement = Backbone.\$(e.currentTarget);
                if(currentElement.val().trim() != '') {
                    var flag = 0;
                    \$('.uv-search-wrapper').find('.uv-search-result-row').each(function() {
                        if(!\$(this).hasClass('uv-no-results')) {
                            var text = \$(this).text().trim().toLowerCase();
                            var isTextContained = text.search(currentElement.val().trim().toLowerCase());
                            if(isTextContained < 0) {
                                \$(this).parent().hide();
                                \$(this).parent().attr('tabIndex', -1);
                            } else {
                                \$(this).parent().show();
                                \$(this).parent().removeAttr('tabIndex');
                                flag = 1;
                            }
                        }
                    });
                    if(flag == 0)
                        \$('.uv-search-wrapper').find(\".uv-no-results\").show();
                    else
                        \$('.uv-search-wrapper').find(\".uv-no-results\").hide();

                    this.\$el.find('.uv-search-result-wrapper').addClass('uv-search-result-active').addClass('uv-search-flap-up')
                } else {
                    this.\$el.find('.uv-search-result-wrapper').removeClass('uv-search-result-active').removeClass('uv-search-flap-up')
                }
            },
            openFeatureSearch: function(e) {
                var currentElement = Backbone.\$(e.currentTarget);
                if(currentElement.val().trim() != '') {
                    this.\$el.find('.uv-search-result-wrapper').addClass('uv-search-result-active').addClass('uv-search-flap-up')
                }
            }
        });

        var SidePanelUV = Backbone.View.extend({
            el: \$('.uv-paper'),
            events: {
                'click .uv-mob-aside span': 'toggleAsideBar'
            },
            initialize : function() {
                var ele = \$('.uv-paper');
                if(ele.css('padding-left') == '60px'){
                    \$('.uv-mob-aside').removeClass('uv-mob-aside-left');
                }else{
                    \$('.uv-mob-aside').addClass('uv-mob-aside-left');
                }

                var asideView = '{{ app.request.cookies.get(\"uv-asideView\") }}';
                if(asideView == 'true')
                    this.toggleAsideBar();
            },
            toggleAsideBar: function(){
                var asideView = true;
                var ele = \$('.uv-inner-section .uv-aside');
                var eleSidePanel = \$('.uv-inner-section .uv-view');
                var eleTicketView = \$('.uv-inner-section .uv-view .uv-ticket-scroll-region');
                var mobAside = \$('.uv-mob-aside');
                if(ele.css('display') == 'none'){
                    asideView = false;
                    ele.css('display', 'block');
                    eleSidePanel.removeClass('uv-aside-view');
                    eleTicketView.removeClass('uv-aside-view-tv');
                    mobAside.removeClass('uv-mob-aside-collapsed')
                }else{
                    ele.css('display', 'none');
                    eleSidePanel.addClass('uv-aside-view');
                    eleTicketView.addClass('uv-aside-view-tv');
                    mobAside.addClass('uv-mob-aside-collapsed')
                }
                if(asideView) {
                    document.cookie = (\"uv-asideView=1; expires=Wed, 01 Jan 2020 00:00:00 GMT;path=/\");
                } else {
                    document.cookie = (\"uv-asideView=0; expires=Wed, 01 Jan 2020 00:00:00 GMT;path=/\");
                }
            }
        });

        var featureSearch =  new FeatureSearch();
        var sidePanelUV =  new SidePanelUV();
    });
</script>

{# Ticket Create Popup #}
{% if user_service.isAccessAuthorized('ROLE_AGENT_CREATE_TICKET') %}
    {{ ticket_service.appendTwigSnippet('createMemberTicket')|raw }}
    {# {% include('UVDeskCoreFrameworkBundle:Snippets:createMemberTicketSnippet.html.twig') only %} #}
{% endif %}
", "@UVDeskCoreFramework/Templates/header.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/Templates/header.html.twig");
    }
}
