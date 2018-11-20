(function ($) {
    // Wait for all assets to load
    $(window).bind("load", function() {
        var UVDeskCommunityDatabaseConfigurationModel = Backbone.Model.extend({
            view: undefined,
            defaults: {
                verified: false,
                credentials: {
                    hostname: 'localhost',
                    username: 'root',
                    password: null,
                    database: null,
                }
            },
            initialize: function (attributes) {
                this.view = attributes.view;
            },
            verifyDatabaseCredentials: function() {
                let self = this;

                this.set('credentials', {
                    hostname: this.view.$el.find('input[name="db_host"]').val(),
                    username: this.view.$el.find('input[name="db_username"]').val(),
                    password: this.view.$el.find('input[name="db_password"]').val(),
                    database: this.view.$el.find('input[name="db_name"]').val(),
                });

                $.post('/setup/xhr/verify-database-credentials', self.get('credentials'), function (response) {
                    console.log('success:', response);
                    // self.set('php-version', response);
                    // self.view.renderPHPVersion();
                }).fail(function(response) {
                    console.log('fail:', response);
                    // self.set('php-version', { status: false });
                    // self.view.renderPHPVersion();
                }).always(function() {
                    console.log('always:', response);
                    // self.validateSystemRequirements();
                });
            },
        });

        UVDeskCommunityDatabaseConfigurationView = Backbone.View.extend({
            el: '#wizardContent',
            model: undefined,
            wizard: undefined,
            reference_nodes: {
            },
            wizard_database_configuration_template: _.template($("#installationWizard-DatabaseConfigurationTemplate").html()),
            events: {
                'click #wizardCTA-CancelInstallation': function() {
                    this.wizard.router.navigate('welcome', { trigger: true });
                },
                'click #wizardCTA-IterateInstallation': function() {
                    this.enableVerificationLoader();
                    this.model.verifyDatabaseCredentials();
                    // if (this.model.validateDatabaseCredentials()) {
                    //     this.wizard.router.navigate('setup-admin', { trigger: true });
                    // }
                },
            },
            initialize: function(params) {
                let self = this;

                this.wizard = params.wizard;
                this.model = new UVDeskCommunityDatabaseConfigurationModel({ view: self });

                // Render Initial Template
                this.wizard.reference_nodes.content.html(this.wizard_database_configuration_template(this.model));
            },
            enableNextStep: function() {
                this.$el.find('#wizardCTA-IterateInstallation').removeAttr('disabled');
            },
            disableNextStep: function() {
                this.$el.find('#wizardCTA-IterateInstallation').attr('disabled', 'disabled');
            },
            enableVerificationLoader: function () {
                console.log('Verifying details');
            }
        });

        var UVDeskCommunitySystemRequirementsModel = Backbone.Model.extend({
            view: undefined,
            defaults: {
                'verified': false,
                'php-version': {
                    status: undefined,
                },
                'php-extensions': {
                    status: undefined,
                },
            },
            initialize: function (attributes) {
                this.view = attributes.view;
            },
            fetch: function() {
                this.checkPHP();
                this.evaluatePHPExtensions();
            },
            validateSystemRequirements: function() {
                if (false == this.get('php-version').status) {
                    this.set('verified', false);
                } else if (false == this.get('php-extensions').status) {
                    this.set('verified', false);
                } else {
                    this.set('verified', true);
                }

                if (true === this.get('verified')) {
                    this.view.enableNextStep();

                    return true;
                }

                return false;
            },
            checkPHP: function() {
                let self = this;

                $.post('/setup/xhr/check-requirements/php-version', function (response) {
                    self.set('php-version', response);
                    self.view.renderPHPVersion();
                }).fail(function(response) {
                    self.set('php-version', { status: false });
                    self.view.renderPHPVersion();
                }).always(function() {
                    self.validateSystemRequirements();
                });
            },
            evaluatePHPExtensions: function() {
                let self = this;

                $.post('/setup/xhr/check-requirements/php-extensions', function (response) {
                    self.set('php-extensions', response);
                    self.view.renderPHPExtensionsCriteria();
                }).fail(function() {
                    self.set('php-extensions', { status: false });
                    self.view.renderPHPExtensionsCriteria();
                }).always(function() {
                    self.validateSystemRequirements();
                });;
            },
        });

        var UVDeskCommunitySystemRequirementsView = Backbone.View.extend({
            el: '#wizardContent',
            model: undefined,
            wizard: undefined,
            reference_nodes: {
                version: undefined,
                extension: undefined,
            },
            wizard_system_requirements_template: _.template($("#installationWizard-SystemRequirementsTemplate").html()),
            wizard_system_requirements_php_ver_template: _.template($("#installationWizard-SystemRequirementsTemplate-PHPVersion").html()),
            wizard_system_requirements_php_ext_template: _.template($("#installationWizard-SystemRequirementsTemplate-PHPExtensions").html()),
            events: {
                'click #wizardCTA-CancelInstallation': function() {
                    this.wizard.router.navigate('welcome', { trigger: true });
                },
                'click #wizardCTA-IterateInstallation': function() {
                    if (this.model.validateSystemRequirements()) {
                        this.wizard.router.navigate('configure-database', { trigger: true });
                    }
                },
            },
            initialize: function(params) {
                let self = this;

                this.wizard = params.wizard;
                this.model = new UVDeskCommunitySystemRequirementsModel({ view: self });

                // Render Initial Template
                this.wizard.reference_nodes.content.html(this.wizard_system_requirements_template());

                // Set reference nodes
                this.reference_nodes.version = this.$el.find('#systemCriteria-PHPVersion');
                this.reference_nodes.extension = this.$el.find('#systemCriteria-PHPExtensions');
                
                this.renderPHPVersion();
                this.renderPHPExtensionsCriteria();

                this.model.fetch();
            },
            enableNextStep: function() {
                this.$el.find('#wizardCTA-IterateInstallation').removeAttr('disabled');
            },
            disableNextStep: function() {
                this.$el.find('#wizardCTA-IterateInstallation').attr('disabled', 'disabled');
            },
            renderPHPVersion: function() {
                this.reference_nodes.version.html(this.wizard_system_requirements_php_ver_template(this.model.get('php-version')));
            },
            renderPHPExtensionsCriteria: function() {
                this.reference_nodes.extension.html(this.wizard_system_requirements_php_ext_template(this.model.get('php-extensions')));
            }
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
                'click #wizardCTA-StartInstallation': function() {
                    this.router.navigate('check-requirements', { trigger: true });
                },
            },
            timeline: [
                {
                    path: 'check-requirements',
                    view: UVDeskCommunitySystemRequirementsView,
                },
                {
                    path: 'configure-database',
                    view: UVDeskCommunityDatabaseConfigurationView,
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
            iterateInstallationSteps: function(iteration) {
                if ('welcome' === iteration) {
                    this.renderWizard();
                } else {
                    let self = this;
    
                    this.timeline.forEach(function (procedure) {
                        if (iteration == procedure.path && typeof procedure.view != 'undefined') {
                            self.renderWizardInstallationStep(procedure.view);
                        }
                    });
                }
            },
            renderWizard: function() {
                let self = this;

                this.reference_nodes.header.html(self.wizard_default_header_template());
                this.reference_nodes.content.html(self.wizard_default_content_template());
            },
            renderWizardInstallationStep: function(InstallationWizardTemplateView) {
                let self = this;

                this.reference_nodes.content.empty();
                new InstallationWizardTemplateView({ wizard: self });
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
                this.wizard.iterateInstallationSteps(installationStep);
            },
        });
    
        var router = new Router();
        Backbone.history.start({ push_state: true });
    });
})(jQuery);