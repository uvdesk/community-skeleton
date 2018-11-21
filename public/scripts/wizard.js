(function ($) {
    // Wait for all assets to load
    $(window).bind("load", function() {
        var UVDeskCommunityInstallSetupView = Backbone.View.extend({
            el: '#wizardContent',
            wizard: undefined,
            installation_setup_template: _.template($("#installationWizard-InstallSetupTemplate").html()),
            events: {
                'click #wizardCTA-CancelInstallation': 'abortInstallation',
                'click #wizardCTA-IterateInstallation': 'processAccountConfiguration',
            },
            initialize: function(params) {
                this.wizard = params.wizard;
                this.wizard.reference_nodes.content.html(this.installation_setup_template());
            },
            abort: function() {
                this.wizard.router.navigate('welcome', { trigger: true });
            },
        });

        var UVDeskCommunityAccountConfigurationModel = Backbone.Model.extend({
            view: undefined,
            defaults: {
                user: {
                    name: null,
                    email: null,
                    password: null,
                    confirmPassword: null,
                }
            },
          
            initialize: function (attributes) {
                this.view = attributes.view;
            },
            verifyAccountDetails: function() {
                let self = this;
                
                return true;
            },
        });

        var UVDeskCommunityAccountConfigurationView = Backbone.View.extend({
            el: '#wizardContent',
            model: UVDeskCommunityAccountConfigurationModel,
            wizard: undefined,
            account_settings_template: _.template($("#installationWizard-AccountConfigurationTemplate").html()),
            events: {
                'click #wizardCTA-CancelInstallation': 'abort',
                'click #wizardCTA-IterateAdminAccount': 'processAccountConfiguration',
                'submit form[name="wizardForm-ConfigureAccount"]': 'processAccountConfiguration',
            },
            initialize: function(params) {
                let self = this;
              
                Backbone.Validation.bind(self);
                this.wizard = params.wizard;
                this.model = new UVDeskCommunityAccountConfigurationModel({ view: self });               
                this.wizard.reference_nodes.content.html(this.account_settings_template(this.model.attributes));
            },
            abort: function() {
                this.wizard.router.navigate('welcome', { trigger: true });
            },
            navigateToInstallation: function(e) {
                e.preventDefault();
            
            
                var form_data = {
                    name: this.$el.find('input[name="name"]').val(),
                    username: this.$el.find('input[name="username"]').val(),
                    password: this.$el.find('input[name="password"]').val(),
                    confirm_password: this.$el.find('input[name="confirm_password"]').val(),
                };
                // console.log(this.model.toJSON());
                if(this.isAccountConfigurationVerified(form_data)){
                    this.wizard.router.navigate('install', { trigger: true });
                }
              
            },
            validateEmail:function(email){
                var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                if (filter.test(email)) {
                    return true;
                }
                else {
                    return false;
                }
            },
            isAccountConfigurationVerified:function(data){
             
                $('.error_message').html('');
                if(data.name== null || data.name=="") {
                   
                    this.$el.find('input[name="name"]').after("<span class='error_message'>This field is mendatory</span>")
                    return false;
                }
                if(data.username== null || data.username==""){

                    this.$el.find('input[name="username"]').after("<span class='error_message'>This field is mendatory</span>")
                    return false;
                }
                if(!this.validateEmail(data.username)) {
                    this.$el.find('input[name="username"]').after("<span class='error_message'>Invalid Email</span>")
                    return false;
                }
                if(data.password== null || data.password==""){
                    this.$el.find('input[name="password"]').after("<span class='error_message'>This field is mendatory</span>")
                    return false;
                }
                if(data.confirm_password== null || data.confirm_password==""){
                    this.$el.find('input[name="confirm_password"]').after("<span class='error_message'>This field is mendatory</span>")
                    return false;
                }
                if(data.confirm_password != data.password){

                    this.$el.find('input[name="confirm_password"]').after("<span class='error_message'>This Password does not matched </span>")
                    return false;
                }
                
                return true;

            },
            disableNextStep: function() {
                this.$el.find('#wizardCTA-IterateInstallation').attr('disabled', 'disabled');
            },
            processAccountConfiguration: function(e) {
              
                e.preventDefault();
                if (this.model.verifyAccountDetails()) {
                    this.wizard.timeline[2].isChecked = true;
                    this.navigateToInstallation(e);
                }

                return false;
            },
        });
    
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
                    hostname: this.view.$el.find('input[name="hostname"]').val(),
                    username: this.view.$el.find('input[name="username"]').val(),
                    password: this.view.$el.find('input[name="password"]').val(),
                    database: this.view.$el.find('input[name="database"]').val(),
                });

                $.post('/setup/xhr/verify-database-credentials', self.get('credentials'), function (response) {
                    if (typeof response.status != 'undefined' && true === response.status) {
                        self.view.wizard.timeline[1].isChecked = true;
                        self.view.navigateToAccountConfiguration();
                    }
                }).fail(function(response) {
                    console.log('fail:', response);
                });
            },
        });

        var UVDeskCommunityDatabaseConfigurationView = Backbone.View.extend({
            el: '#wizardContent',
            model: undefined,
            wizard: undefined,
            database_configuration_template: _.template($("#installationWizard-DatabaseConfigurationTemplate").html()),
            events: {
                'click #wizardCTA-CancelInstallation': 'abort',
                'click #wizardCTA-IterateInstallation': 'processDatabaseConfiguration',
                'submit form[name="wizardForm-ConfigureDatabase"]': 'processDatabaseConfiguration',
            },
            initialize: function(params) {
                let self = this;

                this.wizard = params.wizard;
                this.model = new UVDeskCommunityDatabaseConfigurationModel({ view: self });

                // Render Initial Template
                this.wizard.reference_nodes.content.html(this.database_configuration_template(this.model.attributes));
            },
            abort: function() {
                this.wizard.router.navigate('welcome', { trigger: true });
            },
            navigateToAccountConfiguration: function() {
                this.wizard.router.navigate('create-admin', { trigger: true });
            },
            disableNextStep: function() {
                this.$el.find('#wizardCTA-IterateInstallation').attr('disabled', 'disabled');
            },
            processDatabaseConfiguration: function(e) {
                e.preventDefault();
                this.model.verifyDatabaseCredentials();

                return false;
            },
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
                let postData = {
                    specification: 'php-version',
                };

                $.post('/setup/xhr/check-requirements', postData, function (response) {
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
                let postData = {
                    specification: 'php-extensions',
                };

                $.post('/setup/xhr/check-requirements', postData, function (response) {
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
                        this.wizard.timeline[0].isChecked = true;
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
            enabled: false,
            reference_nodes: {
                header: undefined,
                content: undefined,
            },
            wizard_default_header_template: _.template($("#installationWizard-DefaultHeaderTemplate").html()),
            wizard_default_content_template: _.template($("#installationWizard-DefaultContentTemplate").html()),
            events: {
                'click #wizardCTA-StartInstallation': function() {
                    this.enabled = true;
                    this.router.navigate('check-requirements', { trigger: true });
                },
            },
            timeline: [
                {
                    isChecked: false,
                    path: 'check-requirements',
                    view: UVDeskCommunitySystemRequirementsView,
                },
                {
                    isChecked: false,
                    path: 'configure-database',
                    view: UVDeskCommunityDatabaseConfigurationView,
                },
                {
                    isChecked: false,
                    path: 'create-admin',
                    view: UVDeskCommunityAccountConfigurationView,
                },
                {
                    isChecked: false,
                    path: 'install',
                    view: UVDeskCommunityInstallSetupView,
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
                    this.enabled = false;

                    this.timeline[0].isChecked = false;
                    this.timeline[1].isChecked = false;
                    this.timeline[2].isChecked = false;
                    this.timeline[3].isChecked = false;

                    this.renderWizard();
                } else {
                    if (!this.enabled) {
                        this.router.navigate('welcome', { trigger: true });
                    } else {
                        let self = this;
                        // console.log("installationStep in router : ",installationStep);
    
                        this.timeline.every(function (installationStep) {
                            if (iteration == installationStep.path && typeof installationStep.view != 'undefined') {
                                self.renderWizardInstallationStep(installationStep.view);

                                return false;
                            } else if (installationStep.isChecked) {
                                return true;
                            }

                            self.router.navigate('welcome', { trigger: true });

                            return false;
                        });
                    }
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