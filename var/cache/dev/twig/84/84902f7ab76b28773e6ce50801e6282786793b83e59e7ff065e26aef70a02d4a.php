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

/* @UVDeskSupportCenter/Templates/tinyMCE.html.twig */
class __TwigTemplate_3cc300e4546b7363cd4ba6af67a9bd36aae6baf4cdf1a605745c2f363eac9b1f extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Templates/tinyMCE.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskSupportCenter/Templates/tinyMCE.html.twig"));

        // line 4
        echo "\t";
        // line 5
        echo "\t<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>

";
        // line 8
        echo "<script type=\"text/javascript\">
var sfTinyMce = {
\ttinymce : tinymce,
\toptions : {
\t\tbrowser_spellcheck : true,\t\t
\t\tselector: '.uv-view textarea',
\t\tbranding: false,
\t\trelative_urls : false,
\t\tremove_script_host : false,
\t\timage_title: true,
\t\tautoresize_max_height: 350,
\t\ttheme: 'modern',
\t\tmenubar: false,
\t\theight: 150,
\t\t\ttoolbar: 'undo redo | bold italic | forecolor | bullist | numlist | link imageupload | spellchecker',
\t\tspellchecker_languages: 'English=en',
\t\t\t
\t\tplugins: [
\t\t\t'spellchecker advlist autolink lists link charmap print preview hr anchor pagebreak',
\t\t\t'searchreplace wordcount visualblocks visualchars code fullscreen',
\t\t\t'media nonbreaking table directionality',
\t\t\t'emoticons template paste textcolor colorpicker textpattern codesample toc',
\t\t\t'autoresize image imagetools',
\t\t\t'mention',
\t\t],
\t\tinvalid_elements : 'script,style,iframe,input,textarea,form,onmouseover,onmouseout,onclick',
\t    // paste_as_text: true,
\t\tpaste_data_images: true,\t\t
\t\tmentions : {
\t\t\tsource: function(){
\t\t\t\treturn [];\t
\t\t\t},
\t\t},
\t},
\tinit : function (options){
\t\tif(typeof(options.setup) === 'function'){
\t\t\tlet optionsSetup = options.setup;
\t\t\tthis.options.setup = function(editor){
\t\t\t\tsfTinyMce.initImageUpload(editor);
\t\t\t\toptionsSetup(editor);
\t\t\t}

\t\t\tdelete options.setup;
\t\t}else{
\t\t\tthis.options.setup = function(editor){
\t\t\t\tsfTinyMce.initImageUpload(editor);
\t\t\t}

\t\t\tdelete options.setup;
\t\t}

\t\tthis.options = \$.extend({}, this.options, options)
\t\twindow.tinymce.dom.Event.domLoaded = true;
\t\ttinymce.init(this.options);
\t},
\thtml : function(selector, html){
\t\ttinymce.get(selector).setContent(html);
\t},
\tinitImageUpload : function(editor) {
\t\t// create input and insert in the DOM
\t\tvar inp = \$('<input id=\"tinymce-uploader\" type=\"file\" name=\"pic\" accept=\"image/*\" style=\"display:none\">');
\t\t\$(editor.getElement()).parent().append(inp);

\t\t// add the image upload button to the editor toolbar
\t\teditor.addButton('imageupload', {
\t\t\ttext: '',
\t\t\ticon: 'image',
\t\t\tonclick: function(e) { // when toolbar button is clicked, open file select modal
\t\t\t\tinp.trigger('click');
\t\t\t}
\t\t});

\t\t// when a file is selected, upload it to the server
\t\tinp.on(\"change\", function(e){
\t\t\tsfTinyMce.uploadFile(\$(this), editor);
\t\t});
\t},
\tuploadFile : function(input, editor) {
\t\tsendFile(input.get(0).files).done(function(json){
\t\t\t\t//remove loading image
\t\t\t\tif(json['error'] != ''){
\t\t\t\t\tvar response = {
\t\t\t\t\t\t'alertClass' : 'danger',
\t\t\t\t\t\t'alertMessage' : json['error'],
\t\t\t\t\t};
\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t}else if(json['fileNames']){
\t\t\t\t\t\$.each(json['fileNames'], function(key, path){
\t\t\t\t\t\teditor.insertContent('<img class=\"content-img\" src=\"' + path + '\"/>');
\t\t\t\t\t});
\t\t\t\t}
\t\t\t\tif(json.location != undefined)
\t\t\t\t\twindow.location = json.location; 
\t\t\t})
\t\t\t.fail(function(xhr) {
\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\twindow.location = url;

\t\t\t\tapp.appView.hideLoader();
\t\t\t\tapp.appView.renderResponseAlert(warningResponse);
\t\t\t})
\t\t;
\t},
}

function sendFile(files) {
    var data = new FormData();
\tvar nonEmptyFlag;
    \$.each(files, function(key, file){
\t\tvar patt = new RegExp(\"(image/)(?!tif)\");
\t\tif(file.type && patt.test(file.type)) {
\t\t\tdata.append(\"attachments[]\", file);
\t\t\tnonEmptyFlag = true;
\t\t}
    });
\tvar path = \"";
        // line 124
        echo ((twig_in_filter("/customer/", twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 124, $this->source); })()), "request", [], "any", false, false, false, 124), "requestUri", [], "any", false, false, false, 124))) ? ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("ajax_file_upload_customer")) : ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("ajax_file_upload")));
        echo "\";
\tif(nonEmptyFlag) {
\t\treturn \$.ajax({
\t\t\t\tdata: data,
\t\t\t\ttype: \"POST\",
\t\t\t\tenctype: 'multipart/form-data',
\t\t\t\turl: path,
\t\t\t\tprocessData: false,
\t\t\t\tcontentType: false,
\t\t\t\tcache: false,
\t\t\t});
\t} else {
\t\tapp.appView.renderResponseAlert({'alertClass': 'danger', 'alertMessage': '";
        // line 136
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("Warning! Select valid image file."), "html", null, true);
        echo "' });
\t}
}

function sendUrls(url) {
\tvar path = \"";
        // line 141
        echo ((twig_in_filter("/customer/", twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 141, $this->source); })()), "request", [], "any", false, false, false, 141), "requestUri", [], "any", false, false, false, 141))) ? ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("ajax_url_file_customer")) : ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("ajax_url_file")));
        echo "\";
    return \$.ajax({
\t\t        data: {'url': url},
\t\t        type: \"POST\",
\t\t        url: path,
\t\t        dataType: 'json'
\t\t    });
}

function removeFile(file) {
\tvar path = \"";
        // line 151
        echo ((twig_in_filter("/customer/", twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 151, $this->source); })()), "request", [], "any", false, false, false, 151), "requestUri", [], "any", false, false, false, 151))) ? ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("ajax_file_remove_customer")) : ($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("ajax_file_remove")));
        echo "\";
    return \$.ajax({
\t\t        data: {'path': file},
\t\t        type: \"POST\",
\t\t        url: path,
\t\t        dataType: 'json'
\t\t    });
}
";
        // line 206
        echo "</script>

";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskSupportCenter/Templates/tinyMCE.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  214 => 206,  203 => 151,  190 => 141,  182 => 136,  167 => 124,  49 => 8,  45 => 5,  43 => 4,);
    }

    public function getSourceContext()
    {
        return new Source("{# {% if '.webkul.com' == application_service.getConfigParameter('site.url') %}
\t<script src='{{ asset(\"bundles/webkuldefault/js/tinymce/tinymce.min.js\") }}'></script>
{% else %} #}
\t{# <script src='{{ asset(\"bundles/tinymce/tinymce.min.js\") }}'></script> #}
\t<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>

{# {% endif %} #}
<script type=\"text/javascript\">
var sfTinyMce = {
\ttinymce : tinymce,
\toptions : {
\t\tbrowser_spellcheck : true,\t\t
\t\tselector: '.uv-view textarea',
\t\tbranding: false,
\t\trelative_urls : false,
\t\tremove_script_host : false,
\t\timage_title: true,
\t\tautoresize_max_height: 350,
\t\ttheme: 'modern',
\t\tmenubar: false,
\t\theight: 150,
\t\t\ttoolbar: 'undo redo | bold italic | forecolor | bullist | numlist | link imageupload | spellchecker',
\t\tspellchecker_languages: 'English=en',
\t\t\t
\t\tplugins: [
\t\t\t'spellchecker advlist autolink lists link charmap print preview hr anchor pagebreak',
\t\t\t'searchreplace wordcount visualblocks visualchars code fullscreen',
\t\t\t'media nonbreaking table directionality',
\t\t\t'emoticons template paste textcolor colorpicker textpattern codesample toc',
\t\t\t'autoresize image imagetools',
\t\t\t'mention',
\t\t],
\t\tinvalid_elements : 'script,style,iframe,input,textarea,form,onmouseover,onmouseout,onclick',
\t    // paste_as_text: true,
\t\tpaste_data_images: true,\t\t
\t\tmentions : {
\t\t\tsource: function(){
\t\t\t\treturn [];\t
\t\t\t},
\t\t},
\t},
\tinit : function (options){
\t\tif(typeof(options.setup) === 'function'){
\t\t\tlet optionsSetup = options.setup;
\t\t\tthis.options.setup = function(editor){
\t\t\t\tsfTinyMce.initImageUpload(editor);
\t\t\t\toptionsSetup(editor);
\t\t\t}

\t\t\tdelete options.setup;
\t\t}else{
\t\t\tthis.options.setup = function(editor){
\t\t\t\tsfTinyMce.initImageUpload(editor);
\t\t\t}

\t\t\tdelete options.setup;
\t\t}

\t\tthis.options = \$.extend({}, this.options, options)
\t\twindow.tinymce.dom.Event.domLoaded = true;
\t\ttinymce.init(this.options);
\t},
\thtml : function(selector, html){
\t\ttinymce.get(selector).setContent(html);
\t},
\tinitImageUpload : function(editor) {
\t\t// create input and insert in the DOM
\t\tvar inp = \$('<input id=\"tinymce-uploader\" type=\"file\" name=\"pic\" accept=\"image/*\" style=\"display:none\">');
\t\t\$(editor.getElement()).parent().append(inp);

\t\t// add the image upload button to the editor toolbar
\t\teditor.addButton('imageupload', {
\t\t\ttext: '',
\t\t\ticon: 'image',
\t\t\tonclick: function(e) { // when toolbar button is clicked, open file select modal
\t\t\t\tinp.trigger('click');
\t\t\t}
\t\t});

\t\t// when a file is selected, upload it to the server
\t\tinp.on(\"change\", function(e){
\t\t\tsfTinyMce.uploadFile(\$(this), editor);
\t\t});
\t},
\tuploadFile : function(input, editor) {
\t\tsendFile(input.get(0).files).done(function(json){
\t\t\t\t//remove loading image
\t\t\t\tif(json['error'] != ''){
\t\t\t\t\tvar response = {
\t\t\t\t\t\t'alertClass' : 'danger',
\t\t\t\t\t\t'alertMessage' : json['error'],
\t\t\t\t\t};
\t\t\t\t\tapp.appView.hideLoader();
\t\t\t\t\tapp.appView.renderResponseAlert(response);
\t\t\t\t}else if(json['fileNames']){
\t\t\t\t\t\$.each(json['fileNames'], function(key, path){
\t\t\t\t\t\teditor.insertContent('<img class=\"content-img\" src=\"' + path + '\"/>');
\t\t\t\t\t});
\t\t\t\t}
\t\t\t\tif(json.location != undefined)
\t\t\t\t\twindow.location = json.location; 
\t\t\t})
\t\t\t.fail(function(xhr) {
\t\t\t\tif(url = xhr.getResponseHeader('Location'))
\t\t\t\t\twindow.location = url;

\t\t\t\tapp.appView.hideLoader();
\t\t\t\tapp.appView.renderResponseAlert(warningResponse);
\t\t\t})
\t\t;
\t},
}

function sendFile(files) {
    var data = new FormData();
\tvar nonEmptyFlag;
    \$.each(files, function(key, file){
\t\tvar patt = new RegExp(\"(image/)(?!tif)\");
\t\tif(file.type && patt.test(file.type)) {
\t\t\tdata.append(\"attachments[]\", file);
\t\t\tnonEmptyFlag = true;
\t\t}
    });
\tvar path = \"{{ '/customer/' in app.request.requestUri ? path('ajax_file_upload_customer') : path('ajax_file_upload') }}\";
\tif(nonEmptyFlag) {
\t\treturn \$.ajax({
\t\t\t\tdata: data,
\t\t\t\ttype: \"POST\",
\t\t\t\tenctype: 'multipart/form-data',
\t\t\t\turl: path,
\t\t\t\tprocessData: false,
\t\t\t\tcontentType: false,
\t\t\t\tcache: false,
\t\t\t});
\t} else {
\t\tapp.appView.renderResponseAlert({'alertClass': 'danger', 'alertMessage': '{{ \"Warning! Select valid image file.\"|trans }}' });
\t}
}

function sendUrls(url) {
\tvar path = \"{{ '/customer/' in app.request.requestUri ? path('ajax_url_file_customer') : path('ajax_url_file') }}\";
    return \$.ajax({
\t\t        data: {'url': url},
\t\t        type: \"POST\",
\t\t        url: path,
\t\t        dataType: 'json'
\t\t    });
}

function removeFile(file) {
\tvar path = \"{{ '/customer/' in app.request.requestUri ? path('ajax_file_remove_customer') : path('ajax_file_remove') }}\";
    return \$.ajax({
\t\t        data: {'path': file},
\t\t        type: \"POST\",
\t\t        url: path,
\t\t        dataType: 'json'
\t\t    });
}
{# addTranslateButton = function(editor) {
\teditor.addButton('translate', {
\t\ttype: 'listbox',
\t\ttitle : 'selectContentAndTranslate',
\t\ttext: '{{ \"Translate\"|trans }}',
\t\tonselect: function (e) {
\t\t\tthis.text('{{ \"Translate\"|trans }}');
\t\t\tif(editor.selection.getContent({format : 'html'})) {
\t\t\t\tajaxData = {
\t\t\t\t\t'lang': this.value(),
\t\t\t\t\t'content': editor.selection.getContent({format : 'html'}),
\t\t\t\t};
\t\t\t\ttinyMCE.activeEditor.setProgressState(true);
\t\t\t\t\$.ajax({
\t\t\t\t\turl: '{{ path(\"app_translate_action\") }}',
\t\t\t\t\tdata: ajaxData,
\t\t\t\t\tmethod: 'POST',
\t\t\t\t\tsuccess: function (response) {\t\t\t
\t\t\t\t\t\ttinyMCE.activeEditor.setProgressState(false);
\t\t\t\t\t\teditor.execCommand('mceInsertContent', true, response);\t\t\t\t\t\t\t
\t\t\t\t\t\t\$('.mce-toolbar-grp .uv-loader').remove()
\t\t\t\t\t},
\t\t\t\t\terror: function (model, xhr, options) {
\t\t\t\t\t\ttinyMCE.activeEditor.setProgressState(false);
\t\t\t\t\t\tapp.appView.renderResponseAlert(warningResponse);\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\tif('undefined' != typeof(url = xhr.getResponseHeader) && (url = xhr.getResponseHeader('Location')))
\t\t\t\t\t\t\twindow.location = url;
\t\t\t\t\t}\t\t\t\t\t\t
\t\t\t\t});
\t\t\t} else {
\t\t\t\teditor.notificationManager.close();
\t\t\t\teditor.notificationManager.open({
\t\t\t\t\ttext: '{{ \"Select text then select language to translate text.\"|trans }}',
\t\t\t\t\ttype: 'info',\t\t\t\t\t
\t\t\t\t\ttimeout: 3000,
\t\t\t\t\tcloseButton: true
\t\t\t\t});
\t\t\t}
\t\t},
\t\tvalues: [
\t\t\t{% for value, text in application_service.getTranslationSupportedLanguages() %}
\t\t\t\t{ text: '{{ text }}', value: '{{ value }}' },
\t\t\t{% endfor %}
\t\t\t{ text: '“Powered by Yandex.Translate”', value: '', disabled: true },
\t\t],
\t});
} #}
</script>

{#theme: 'inlite',
inline: true,
insert_toolbar: 'quickimage quicktable',
plugins: [
\t'advlist autolink lists link image charmap print preview hr anchor pagebreak',
\t'searchreplace wordcount visualblocks visualchars code fullscreen',
\t'insertdatetime media nonbreaking save table contextmenu directionality',
\t'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
],
toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image codesample',
image_advtab: true,
templates: [
\t{ title: 'Test template 1', content: 'Test 1' },
\t{ title: 'Test template 2', content: 'Test 2' }
],
content_css: [
\t'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
\t'//www.tinymce.com/css/codepen.min.css'
]#}", "@UVDeskSupportCenter/Templates/tinyMCE.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/support-center-bundle/Resources/views/Templates/tinyMCE.html.twig");
    }
}
