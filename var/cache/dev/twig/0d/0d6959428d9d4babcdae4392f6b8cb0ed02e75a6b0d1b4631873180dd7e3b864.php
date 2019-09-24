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

/* @UVDeskCoreFramework/Templates/attachment.html.twig */
class __TwigTemplate_54e3cb86130da1cc8e77a7c29693da68c8ab75edb0589042175425d7d3119ec5 extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Templates/attachment.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@UVDeskCoreFramework/Templates/attachment.html.twig"));

        // line 1
        echo "<style>
    input.attachment {
        display: none;
    }
</style>
<script type=\"text/javascript\">
    \$(function () {
        var FileView = Backbone.View.extend({
            fileCounter: 0,
            el: '.attachment-block',
            events : {
                'click .uv-file-label': 'createFileType',
                'change .attachment': 'selectFile',
                'click .uv-added-attachment span': 'removeFile'
            },
            createFileType: function(e) {
                currentElement = Backbone.\$(e.currentTarget)
                this.fileCounter += 1;
                currentElement.parents('.attachment-block').append('<div class=\"uv-added-attachment\" style=\"display: none\" id=\"file-' + this.fileCounter + '\"><div class=\"uv-attachment\"><input type=\"file\" name=\"attachments[]\" class=\"attachment\" multiple=\"multiple\"></div><span></span></div>')
                \$('#file-' + this.fileCounter).find('.attachment').trigger('click')
            },
            labelTemplate: _.template('<label class=\"file-name\"><%- fileName %></label><br>'),
            selectFile: function(e) {
                currentElement = Backbone.\$(e.currentTarget)
                var attachmentBlock = currentElement.parents(\".uv-added-attachment\");
                if(currentElement.length) {
                   files = currentElement[0].files; 
                   if(files.length) {
                        for (var i = 0; i < files.length; i++) {
                            var fileName = files[i].name;
                            attachmentBlock.append(this.labelTemplate({'fileName': fileName}));
                        }
                   }
                }

                attachmentBlock.show()
            },
            removeFile: function(e) {
                Backbone.\$(e.currentTarget).parents('.uv-added-attachment').remove()
            }
        });
        
        var fileView = new FileView();
    });
</script>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@UVDeskCoreFramework/Templates/attachment.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<style>
    input.attachment {
        display: none;
    }
</style>
<script type=\"text/javascript\">
    \$(function () {
        var FileView = Backbone.View.extend({
            fileCounter: 0,
            el: '.attachment-block',
            events : {
                'click .uv-file-label': 'createFileType',
                'change .attachment': 'selectFile',
                'click .uv-added-attachment span': 'removeFile'
            },
            createFileType: function(e) {
                currentElement = Backbone.\$(e.currentTarget)
                this.fileCounter += 1;
                currentElement.parents('.attachment-block').append('<div class=\"uv-added-attachment\" style=\"display: none\" id=\"file-' + this.fileCounter + '\"><div class=\"uv-attachment\"><input type=\"file\" name=\"attachments[]\" class=\"attachment\" multiple=\"multiple\"></div><span></span></div>')
                \$('#file-' + this.fileCounter).find('.attachment').trigger('click')
            },
            labelTemplate: _.template('<label class=\"file-name\"><%- fileName %></label><br>'),
            selectFile: function(e) {
                currentElement = Backbone.\$(e.currentTarget)
                var attachmentBlock = currentElement.parents(\".uv-added-attachment\");
                if(currentElement.length) {
                   files = currentElement[0].files; 
                   if(files.length) {
                        for (var i = 0; i < files.length; i++) {
                            var fileName = files[i].name;
                            attachmentBlock.append(this.labelTemplate({'fileName': fileName}));
                        }
                   }
                }

                attachmentBlock.show()
            },
            removeFile: function(e) {
                Backbone.\$(e.currentTarget).parents('.uv-added-attachment').remove()
            }
        });
        
        var fileView = new FileView();
    });
</script>", "@UVDeskCoreFramework/Templates/attachment.html.twig", "/home/users/anmol.rathi/www/html/opensourceLatest/vendor/uvdesk/core-framework/Resources/views/Templates/attachment.html.twig");
    }
}
