(function ($) {
    // Wait for all assets to load
    $(window).bind("load", function() {
        var UVDeskCommunitySystemRequirementsView = Backbone.View.extend({
            el: '#wizard-system-requirements',
            initialize: function() {
                console.log('initialize system req.');
            },
        });

        var InstallationWizard = Backbone.View.extend({
            el: '#wizard',
            router: {},
            reference_nodes: {
                header: undefined,
                content: undefined,
            },
            wizard_default_header_template: _.template($("#installationWizard-DefaultHeaderTemplate").html()),
            wizard_default_content_template: _.template($("#installationWizard-DefaultContentTemplate").html()),
            events: {
                'click #wizardInstallationCTA': 'startInstallationProcess',
            },
            procedureChecklist: [
                {
                    path: 'check-requirements',
                    view: UVDeskCommunitySystemRequirementsView,
                },
                {
                    path: 'configure-database',
                },
                {
                    path: 'configure-website',
                },
                {
                    path: 'setup-admin',
                },
                {
                    path: 'install',
                },
            ],
            initialize: function(params) {
                this.router = params.router;
                this.reference_nodes.header = this.$el.find('#wizardHeader');
                this.reference_nodes.content = this.$el.find('#wizardContent');

                this.renderWizard();
            },
            renderWizard: function() {
                let self = this;

                this.reference_nodes.header.html(self.wizard_default_header_template());
                this.reference_nodes.content.html(self.wizard_default_content_template());
            },
            startInstallationProcess: function() {
                console.log(this.procedureChecklist);

                this.router.navigate('check-requirements', {
                    trigger: true
                });
            },
        });
    
        Router = Backbone.Router.extend({
            wizard: undefined,
            routes: {
                ':installationStep': 'iterateInstallationProcedure',
            },
            initialize: function() {
                let self = this;

                // Initialize installation wizard
                this.wizard = new InstallationWizard({ router: self });
            },
            iterateInstallationProcedure: function(installationStep) {
                console.log('iterate step:', installationStep);
            },
        });
    
        var router = new Router();
        Backbone.history.start({ push_state: true });
    });
})(jQuery);