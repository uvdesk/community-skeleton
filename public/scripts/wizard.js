(function ($) {
    // Wait for all assets to load
    $(window).bind("load", function() {
        var UVDeskCommunityInstallSetupView = Backbone.View.extend({
            el: '#wizardContent',
            wizard: undefined,
            installation_setup_template: _.template($("#installationWizard-InstallSetupTemplate").html()),
            installation_process_template: _.template($("#installationWizard-InstallSetupTemplate-ProcessingItem").html()),
            installation_successfull_template: _.template($('#installationWizard-InstallationCompleteTemplate').html()),
            events: {
                'click #wizardCTA-CancelInstallation': 'abortInstallation',
                'click #wizardCTA-StartInstallation': 'installHelpdesk',
            },
            initialize: function(params) {
                this.wizard = params.wizard;
                this.wizard.reference_nodes.content.html(this.installation_setup_template());
            },
            installHelpdesk: function(params) {
                this.updateConfigurations();
            },
            updateConfigurations: function () {
                let self = this;

                // Generator to make ajax request one by one
                let generator = function* () {
                    self.$el.find('#wizard-finalizeInstall').html(self.installation_process_template({ currentStep: 'load-configurations' }));
                    self.$el.find('#wizard-finalizeInstall .installation-progress-loader').html(self.wizard.wizard_icons_loader_template());
                    yield $.post('/setup/xhr/load/configurations');
                    

                    self.$el.find('#wizard-finalizeInstall').html(self.installation_process_template({ currentStep: 'load-migrations' }));
                    self.$el.find('#wizard-finalizeInstall .installation-progress-loader').html(self.wizard.wizard_icons_loader_template());
                    yield $.post('/setup/xhr/load/migrations');
    

                    self.$el.find('#wizard-finalizeInstall').html(self.installation_process_template({ currentStep: 'populate-datasets' }));
                    self.$el.find('#wizard-finalizeInstall .installation-progress-loader').html(self.wizard.wizard_icons_loader_template());
                    yield $.post('/setup/xhr/load/entities');
                    

                    self.$el.find('#wizard-finalizeInstall').html(self.installation_process_template({ currentStep: 'create-super-user' }));
                    self.$el.find('#wizard-finalizeInstall .installation-progress-loader').html(self.wizard.wizard_icons_loader_template());
                    yield $.post('/setup/xhr/load/super-user');

                    self.$el.find('#wizard-finalizeInstall').html(self.installation_process_template({ currentStep: 'load-website-prefixes' }));
                    self.$el.find('#wizard-finalizeInstall .installation-progress-loader').html(self.wizard.wizard_icons_loader_template());
                    yield $.post('/setup/xhr/load/website-configure');
                    
                    self.redirectToWelcomePage();
                };

                let gen = generator();

                let handle = yielded => {
                    if (!yielded.done) {
                        yielded.value.then(() => {
                            handle(gen.next());
                        })
                    }
                }
                handle(gen.next());
            },
            redirectToWelcomePage: function () {
                this.$el.html(this.installation_successfull_template({member:this.wizard.prefix.member}));
            },
        });

        var UVDeskCommunityWebsiteConfigurationModel = Backbone.Model.extend({
            defaults: {
                member_panel_url: "member",
                customer_panel_url: "customer",
            },
            initialize: function (attributes) {
                this.view = attributes.view;
            },
            isProcedureCompleted: function (callback) {
                var self = this;
                this.set('urlCollection', {
                    'member-prefix': this.view.$el.find('input[name="memeberUrlPrefix"]').val(),
                    'customer-prefix': this.view.$el.find('input[name="customerUrlPrefix"]').val(),
                });

                var wizard = this.view.wizard;
                wizard.reference_nodes.content.find('#wizardCTA-IterateInstallation').prepend('<span class="processing-request">' + wizard.wizard_icons_loader_template() + '</span>');

                $.post('/setup/xhr/website-configure', this.get('urlCollection'), (response) => {
                    if (typeof response.status != 'undefined' && true === response.status) {
                        wizard.prefix.member = "/en/" + this.get('urlCollection')['member-prefix'] + "/login";
                        callback(wizard);
                    } else {
                        wizard.disableNextStep();
                    }
                }).fail(function(response) {
                    wizard.disableNextStep();
                }).always(function() {
                    wizard.reference_nodes.content.find('#wizardCTA-IterateInstallation .processing-request').remove();
                });
            }
        });

        var UVDeskCommunityWebsiteConfigurationView = Backbone.View.extend({
            el: '#wizardSetup',
            wizard: undefined,
            events: {
                "keyup .form-content input" : "validateForm",
            },
            model: UVDeskCommunityWebsiteConfigurationModel,
            wizard_website_configuration: _.template($("#installationWizard-WebsiteConfigurationTemplate").html()),
            initialize: function(params) {
                let self = this;
                
                this.wizard = params.wizard;
                
                // default enabled button
                this.wizard.enableNextStep();
                this.model = new UVDeskCommunityWebsiteConfigurationModel({ view: self });

                this.$el.html(this.wizard_website_configuration(this.model.attributes));
            },
            validateForm: _.debounce(function (event) {
                let errorFlag = false;
                event.preventDefault();
                this.$el.find('.form-content .wizard-form-notice').remove();

                let memberPrefix = this.$el.find('input[name="memeberUrlPrefix"]').val();
                let customerPrefix = this.$el.find('input[name="customerUrlPrefix"]').val();

                if (memberPrefix == null || memberPrefix =="") {
                    errorFlag = true;
                    this.$el.find('.form-content input[name="memeberUrlPrefix"]').after("<span class='wizard-form-notice'>This field is mandatory</span>")
                }

                if (customerPrefix == null || customerPrefix =="") {
                    errorFlag = true;
                    this.$el.find('.form-content input[name="customerUrlPrefix"]').after("<span class='wizard-form-notice'>This field is mandatory</span>")
                }

                if (customerPrefix == memberPrefix) {
                    errorFlag = true;
                    this.$el.find('.form-content input[name="customerUrlPrefix"]').after("<span class='wizard-form-notice'>Both prefixes can not be same.</span>")
                }
                
                if (!errorFlag) {
                    let prefixTestRegex = /^[a-z0-9A-Z]*$/;

                    if (!prefixTestRegex.test(memberPrefix)) {
                        errorFlag = true;
                        this.$el.find('.form-content input[name="memeberUrlPrefix"]').after("<span class='wizard-form-notice'>Only letters and numbers are allowed</span>")
                    }

                    if (!prefixTestRegex.test(customerPrefix)) {
                        errorFlag = true;
                        this.$el.find('.form-content input[name="customerUrlPrefix"]').after("<span class='wizard-form-notice'>Only letters and numbers are allowed</span>")
                    }
                }

                if (false == errorFlag) {
                    this.wizard.enableNextStep();
                } else {
                    this.wizard.disableNextStep();
                }
            }, 400),
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
            isProcedureCompleted: function (callback) {
                this.set('user', {
                    name: this.view.$el.find('input[name="name"]').val(),
                    email: this.view.$el.find('input[name="email"]').val(),
                    password: this.view.$el.find('input[name="password"]').val(),
                });

                let wizard = this.view.wizard;
                wizard.reference_nodes.content.find('#wizardCTA-IterateInstallation').prepend('<span class="processing-request">' + wizard.wizard_icons_loader_template() + '</span>');
                
                $.post('/setup/xhr/intermediary/super-user', this.get('user'), function (response) {
                    if (typeof response.status != 'undefined' && true === response.status) {
                        callback(wizard);
                    } else {
                        wizard.disableNextStep();
                    }
                }).fail(function(response) {
                    wizard.disableNextStep();
                }).always(function() {
                    wizard.reference_nodes.content.find('#wizardCTA-IterateInstallation .processing-request').remove();
                });
            },
        });

        var UVDeskCommunityAccountConfigurationView = Backbone.View.extend({
            el: '#wizardSetup',
            model: UVDeskCommunityAccountConfigurationModel,
            wizard: undefined,
            account_settings_template: _.template($("#installationWizard-AccountConfigurationTemplate").html()),
            events: {
                "keyup .form-content input" : "validateForm",
            },
            initialize: function(params) {
                let self = this;
                Backbone.Validation.bind(self);
                
                this.wizard = params.wizard;
                this.model = new UVDeskCommunityAccountConfigurationModel({ view: self });
                this.$el.html(this.account_settings_template(this.model.attributes));
            },
            validateForm: _.debounce(function(event) {
                let errorFlag = false;
                let emailRegEX = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

                let mandatoryFieldsCollection = ['name', 'email', 'password', 'confirm_password'];

                if (mandatoryFieldsCollection.indexOf(event.target.name) != -1) {
                    let selectedElement = this.$el.find(event.target).parent();
                    selectedElement.find('.wizard-form-notice') ? selectedElement.find('.wizard-form-notice').remove() : '';

                    enteredField = event.target.name;
                    enteredValue = event.target.value;
                    if (enteredValue == null || enteredValue == "") {
                        errorFlag = true;
                        selectedElement.find('.wizard-form-notice')
                        selectedElement.append("<span class='wizard-form-notice'>This field is mandatory</span>");
                    }

                    if (!errorFlag && enteredField == "email") {
                        if (!emailRegEX.test(enteredValue)) {
                            errorFlag = true;
                            selectedElement.append("<span class='wizard-form-notice'>Invalid Email</span>")
                        }
                    }

                    if (!errorFlag && enteredField == "password") {
                        if (enteredValue.length < 8) {
                            errorFlag = true;
                            selectedElement.append("<span class='wizard-form-notice'>The password is too short: it must at least 8 characters.</span>")
                        }
                    }

                    if (!errorFlag && enteredField == "confirm_password") {
                        if (enteredValue != this.$el.find('input[name="password"]').val()) {
                            errorFlag = true;
                            selectedElement.append("<span class='wizard-form-notice'>Password does not match.</span>")
                        }
                    }
                }
                
                if (false == errorFlag) {
                    this.wizard.enableNextStep();
                } else {
                    this.wizard.disableNextStep();
                }
            }, 400),
        });
    
        var UVDeskCommunityDatabaseConfigurationModel = Backbone.Model.extend({
            view: undefined,
            defaults: {
                verified: false,
                credentials: {
                    serverName: '127.0.0.1',
                    serverPort: '3306',
                    username: 'root',
                    password: null,
                    database: null,
                }
            },
            initialize: function (attributes) {
                this.view = attributes.view;
            },
            isProcedureCompleted: function (callback) {
                this.set('credentials', {
                    serverName: this.view.$el.find('input[name="serverName"]').val(),
                    port: this.view.$el.find('input[name="port"]').val(),
                    username: this.view.$el.find('input[name="username"]').val(),
                    password: this.view.$el.find('input[name="password"]').val(),
                    database: this.view.$el.find('input[name="database"]').val(),
                });

                var self = this;
                let wizard = this.view.wizard;
                wizard.reference_nodes.content.find('#wizardCTA-IterateInstallation').prepend('<span class="processing-request">' + wizard.wizard_icons_loader_template() + '</span>');

                $.post('/setup/xhr/verify-database-credentials', this.get('credentials'), function (response) {
                    if (typeof response.status != 'undefined' && true === response.status) {
                        callback(wizard);
                    } else {
                        self.view.$el.find('.form-content input[name="database"]').parent().append("<span class='wizard-form-notice'>Details are incorrect ! Connection not established.</span>");
                        wizard.disableNextStep();
                    }
                }).fail(function(response) {
                    wizard.disableNextStep();
                }).always(function() {
                    wizard.reference_nodes.content.find('#wizardCTA-IterateInstallation .processing-request').remove();
                });
            },
        });

        var UVDeskCommunityDatabaseConfigurationView = Backbone.View.extend({
            el: '#wizardSetup',
            model: undefined,
            wizard: undefined,
            database_configuration_template: _.template($("#installationWizard-DatabaseConfigurationTemplate").html()),
            events: {
                "keyup .form-content input" : "validateForm",
            },
            initialize: function(params) {
                let self = this;

                this.wizard = params.wizard;
                this.model = new UVDeskCommunityDatabaseConfigurationModel({ view: self });

                // Render Database Configuration View
                this.$el.html(this.database_configuration_template(this.model.attributes));
            },
            validateForm: _.debounce(function(event) {
                let errorFlag = false;
                let mandatoryFieldsCollection = ['serverName', 'username', 'password', 'database'];

                if (mandatoryFieldsCollection.indexOf(event.target.name) != -1) {
                    let selectedElement = this.$el.find(event.target).parent();
                    selectedElement.find('.wizard-form-notice') ? selectedElement.find('.wizard-form-notice').remove() : '';
                    if (event.target.value == null || event.target.value == "") {
                        errorFlag = true;
                        selectedElement.find('.wizard-form-notice')
                        selectedElement.append("<span class='wizard-form-notice'>This field is mandatory</span>");
                    }
                }

                if (false == errorFlag) {
                    this.wizard.enableNextStep();
                } else {
                    this.wizard.disableNextStep();
                }
            }, 400),
        });

        var UVDeskCommunitySystemRequirementsModel = Backbone.Model.extend({
            view: undefined,
            defaults: {
                fetch: false,
                verified: false,
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
                this.set('fetch', true);

                this.checkPHP();
                this.evaluatePHPExtensions();
            },
            isProcedureCompleted: function (callback) {
                if (this.get('verified')) {
                    callback(this.view.wizard);
                }
            },
            checkPHP: function() {
                let self = this;
                let postData = {
                    specification: 'php-version',
                };

                $.post('/setup/xhr/check-requirements', postData, function (response) {
                    self.set('php-version', response);
                }).fail(function(response) {
                    self.set('php-version', {
                        status: false,
                        message: 'An unexpected error occurred during the PHP version verification process.',
                    });
                }).always(function() {
                    self.view.renderPHPVersion();
                    self.evaluateOverallRequirements();
                });
            },
            evaluatePHPExtensions: function() {
                let self = this;
                let postData = {
                    specification: 'php-extensions',
                };

                $.post('/setup/xhr/check-requirements', postData, function (response) {
                    self.set('php-extensions', response);
                }).fail(function() {
                    self.set('php-extensions', {
                        status: false,
                        message: 'An unexpected error occurred while examining your system for missing extensions.',
                    });
                }).always(function() {
                    self.view.renderPHPExtensionsCriteria();
                    self.evaluateOverallRequirements();
                });;
            },
            evaluateOverallRequirements: function() {
                if (false == this.get('php-version').status) {
                    this.set('verified', false);
                } else if (false == this.get('php-extensions').status) {
                    this.set('verified', false);
                } else {
                    this.set('verified', true);
                }

                if (true === this.get('verified')) {
                    this.view.wizard.enableNextStep();
                } else {
                    this.view.wizard.disableNextStep();
                }
            },
        });

        var UVDeskCommunitySystemRequirementsView = Backbone.View.extend({
            el: '#wizardSetup',
            model: undefined,
            wizard: undefined,
            reference_nodes: {
                version: undefined,
                extension: undefined,
            },
            wizard_icons_loader_template: _.template($("#wizardIcons-LoaderTemplate").html()),
            wizard_icons_success_template: _.template($("#wizardIcons-SuccessTemplate").html()),
            wizard_icons_notice_template: _.template($("#wizardIcons-NoticeTemplate").html()),
            wizard_system_requirements_template: _.template($("#installationWizard-SystemRequirementsTemplate").html()),
            wizard_system_requirements_php_ver_template: _.template($("#installationWizard-SystemRequirementsTemplate-PHPVersion").html()),
            wizard_system_requirements_php_ext_template: _.template($("#installationWizard-SystemRequirementsTemplate-PHPExtensions").html()),
            initialize: function(params) {
                let self = this;

                this.wizard = params.wizard;
                this.model = new UVDeskCommunitySystemRequirementsModel({ view: self });

                // Render Initial Template
                this.$el.html(this.wizard_system_requirements_template());

                // Set reference nodes
                this.reference_nodes.version = this.$el.find('#systemCriteria-PHPVersion');
                this.reference_nodes.extension = this.$el.find('#systemCriteria-PHPExtensions');
                
                this.renderPHPVersion('verifying');
                this.renderPHPExtensionsCriteria('verifying');

                this.model.fetch();
            },
            renderPHPVersion: function(status) {
                this.reference_nodes.version.html(this.wizard_system_requirements_php_ver_template(this.model.get('php-version')));

                if (false == this.model.get('fetch')) {
                    this.reference_nodes.version.find('.wizard-svg-icon-criteria-checklist').html(this.wizard_icons_loader_template());
                    this.reference_nodes.version.find('label').html('Checking currently enabled PHP version');
                } else {
                    if (true === this.model.get('php-version').status) {
                        this.reference_nodes.version.find('.wizard-svg-icon-criteria-checklist').html(this.wizard_icons_success_template());
                        this.reference_nodes.version.find('label').html(this.model.get('php-version').message);
                    } else {
                        this.reference_nodes.version.find('.wizard-svg-icon-criteria-checklist').html(this.wizard_icons_notice_template());
                        this.reference_nodes.version.find('label').html(this.model.get('php-version').message);
                    }
                }
            },
            renderPHPExtensionsCriteria: function(status) {
                this.reference_nodes.extension.html(this.wizard_system_requirements_php_ext_template(this.model.get('php-extensions')));

                if (false == this.model.get('fetch')) {
                    this.reference_nodes.extension.find('.wizard-svg-icon-criteria-checklist').html(this.wizard_icons_loader_template());
                    this.reference_nodes.extension.find('label').html('Checking currently enabled PHP extensions');
                } else {
                    if (true === this.model.get('php-version').status) {
                        this.reference_nodes.extension.find('.wizard-svg-icon-criteria-checklist').html(this.wizard_icons_success_template());
                        this.reference_nodes.extension.find('label').html(this.model.get('php-extensions').message);
                    } else {
                        this.reference_nodes.extension.find('.wizard-svg-icon-criteria-checklist').html(this.wizard_icons_notice_template());
                        this.reference_nodes.extension.find('label').html(this.model.get('php-extensions').message);
                    }
                }
            }
        });

        var UVDeskCommunityInstallationWizardView = Backbone.View.extend({
            el: '#wizard',
            router: {},
            enabled: false,
            reference_nodes: {
                header: undefined,
                content: undefined,
            },
            prefix: {
                member: 'member'
            },
            activeSetupProcedure: undefined,
            wizard_icons_success_template: _.template($("#wizardIcons-SuccessTemplate").html()),
            wizard_icons_loader_template: _.template($("#wizardIcons-LoaderTemplate").html()),
            wizard_default_header_template: _.template($("#installationWizard-DefaultHeaderTemplate").html()),
            wizard_default_content_template: _.template($("#installationWizard-DefaultContentTemplate").html()),
            wizard_setup_component_template: _.template($("#installationWizard-SetupTemplate").html()),
            events: {
                'click #wizardCTA-StartInstallation': function() {
                    this.enabled = true;
                    this.reference_nodes.content.empty();
                    this.reference_nodes.content.html(this.wizard_setup_component_template());

                    this.router.navigate('check-requirements', { trigger: true });
                },
                'click #wizardCTA-IterateInstallation': function() {
                    if (typeof(this.activeSetupProcedure) != 'undefined') {
                        this.activeSetupProcedure.model.isProcedureCompleted(function (wizard) {
                            let activeInstanceIndex = undefined;

                            wizard.timeline.every(function (instance, index) {
                                if (false == instance.isActive) {
                                    return true;
                                }
                                
                                activeInstanceIndex = index;
                                return false;
                            });

                            if (typeof (activeInstanceIndex) != 'undefined') {
                                wizard.timeline[activeInstanceIndex].isActive = false;
                                wizard.timeline[activeInstanceIndex].isChecked = true;
                                
                                if (typeof (wizard.timeline[activeInstanceIndex + 1]) !== 'undefined') {
                                    wizard.router.navigate(wizard.timeline[activeInstanceIndex + 1].path, { trigger: true });
                                }
                            }
                        });
                    }
                },
                'click #wizardCTA-CancelInstallation': function() {
                    this.router.navigate('welcome', { trigger: true });
                },
            },
            timeline: [
                {
                    isActive: false,
                    isChecked: false,
                    path: 'check-requirements',
                    view: UVDeskCommunitySystemRequirementsView,
                },
                {
                    isActive: false,
                    isChecked: false,
                    path: 'configure-database',
                    view: UVDeskCommunityDatabaseConfigurationView,
                },
                {
                    isActive: false,
                    isChecked: false,
                    path: 'create-admin',
                    view: UVDeskCommunityAccountConfigurationView,
                },
                {
                    isActive: false,
                    isChecked: false,
                    path: 'website-prefixes',
                    view: UVDeskCommunityWebsiteConfigurationView,
                },
                {
                    isActive: false,
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
                    this.timeline[4].isChecked = false;

                    this.renderWizard();
                } else {
                    if (!this.enabled) {
                        this.router.navigate('welcome', { trigger: true });
                    } else {
                        let self = this;
    
                        this.timeline.every(function (installationStep, index) {
                            if (iteration == installationStep.path && typeof installationStep.view != 'undefined') {
                                self.timeline[index].isActive = true;
                                self.renderWizardInstallationStep(installationStep.view);

                                return false;
                            } else if (installationStep.isChecked) {
                                self.timeline[index].isActive = false;

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

                this.disableNextStep();
                this.reference_nodes.content.find('#wizardSetup').empty();
                this.activeSetupProcedure = new InstallationWizardTemplateView({ wizard: self });
            },
            enableNextStep: function() {
                this.$el.find('#wizardCTA-IterateInstallation').removeAttr('disabled');
            },
            disableNextStep: function() {
                this.$el.find('#wizardCTA-IterateInstallation').attr('disabled', 'disabled');
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
                this.wizard = new UVDeskCommunityInstallationWizardView({ router: self });
            },
            iterateInstallationProcedure: function(installationStep) {
                this.wizard.iterateInstallationSteps(installationStep);
            },
        });
    
        var router = new Router();
        Backbone.history.start({ push_state: true });
    });
})(jQuery);
