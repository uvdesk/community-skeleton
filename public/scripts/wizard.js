(function ($) {
    const ERRORS = {
        error404: {
            title: 'Unable to locate the path on the server.',
            description: 'Try putting index.php after your helpdesk installation\'s site url or If you are using apache, make sure that mod_rewrite module is enabled and AllowOverride directive for document root is set to All/FileInfo in your server\'s configuration file.',
        },
        error500: {
            title: 'Something\'s bad happened with the server.',
            description: ' Try again by clicking the back button or launch the wizard again by refershing the webpage or clicking the cancel button.'
        },
    };

    // Wait for all assets to load
    $(window).bind("load", function() {
        var UVDeskCommunityInstallSetupView = Backbone.View.extend({
            el: '#installation-wizard-steps-overview-details',
            wizard: undefined,
            wizard_icons_notice_template: _.template($("#wizardIcons-NoticeTemplate").html()),
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
                // execute next commands after arrival of network request's response
                (async () => {
                    this.$el.find('#wizard-finalizeInstall').html(this.installation_process_template({ currentStep: 'load-configurations' }));
                    this.$el.find('#wizard-finalizeInstall .installation-progress-loader').html(this.wizard.wizard_icons_loader_template());
                    await $.post('./wizard/xhr/load/configurations').fail(response => {
                        if (response.status == 500) {
                            this.$el.find('.wizard-svg-icon-failed-criteria-checklist').html(this.wizard_icons_notice_template());
                            this.$el.find('#error-message-bar').html('</span> Issue can be resolved by simply <a href="https://www.uvdesk.com/en/blog/open-source-helpdesk-installation-on-ubuntu-uvdesk/" target="_blank"><p> enabling your <b>.env</b> file read/write permission</a> refresh the browser and try again.</p>');
                        }
                    });
                    
                    this.$el.find('#wizard-finalizeInstall').html(this.installation_process_template({ currentStep: 'load-migrations' }));
                    this.$el.find('#wizard-finalizeInstall .installation-progress-loader').html(this.wizard.wizard_icons_loader_template());
                    this.next(1);
                    await $.post('./wizard/xhr/load/migrations').fail(response => {
                        if (response.status == 500) {
                            this.$el.find('.wizard-svg-icon-failed-criteria-checklist').html(this.wizard_icons_notice_template());
                            this.$el.find('#error-message-bar').html('Something went wrong ! Please try again');
                        }
                    });
    
                    this.$el.find('#wizard-finalizeInstall').html(this.installation_process_template({ currentStep: 'populate-datasets' }));
                    this.$el.find('#wizard-finalizeInstall .installation-progress-loader').html(this.wizard.wizard_icons_loader_template());
                    this.next(2);
                    await $.post('./wizard/xhr/load/entities').fail(response => {
                        if (response.status == 500) {
                            this.$el.find('.wizard-svg-icon-failed-criteria-checklist').html(this.wizard_icons_notice_template());
                            this.$el.find('#error-message-bar').html('Something went wrong ! Please try again');
                        }
                    });
                    
                    this.$el.find('#wizard-finalizeInstall').html(this.installation_process_template({ currentStep: 'create-super-user' }));
                    this.$el.find('#wizard-finalizeInstall .installation-progress-loader').html(this.wizard.wizard_icons_loader_template());
                    this.next(3);
                    await $.post('./wizard/xhr/load/super-user').fail(response => {
                        if (response.status == 500) {
                            this.$el.find('.wizard-svg-icon-failed-criteria-checklist').html(this.wizard_icons_notice_template());
                            this.$el.find('#error-message-bar').html('Something went wrong ! Please try again');
                        }
                    });

                    this.$el.find('#wizard-finalizeInstall').html(this.installation_process_template({ currentStep: 'load-website-prefixes' }));
                    this.$el.find('#wizard-finalizeInstall .installation-progress-loader').html(this.wizard.wizard_icons_loader_template());
                    this.next(4);
                    let websiteRoutes = await $.post('./wizard/xhr/load/website-configure').fail(response => {
                        if (response.status == 500) {
                            this.$el.find('.wizard-svg-icon-failed-criteria-checklist').html(this.wizard_icons_notice_template());
                            this.$el.find('#error-message-bar').html('Something went wrong ! Please try again');
                        }
                    });
                    this.wizard.prefix.member = websiteRoutes.memberLogin;
                    this.wizard.prefix.knowledgebase = websiteRoutes.knowledgebase;

                    $('.install').removeClass('active-node');
                    $('.install').addClass('check');

                    this.redirectToWelcomePage();
                })();
            },
            redirectToWelcomePage: function () {
                this.$el.find('.installation-wizard-steps-overview-details-container').html(this.installation_successfull_template({prefixCollecton:this.wizard.prefix}));
            },
            next: function($i) {
                for (let index = 0; index < $i; index++) {
                    var $next = $('.progress ul li.current').removeClass('current').addClass('complete').next('li');
                    if ($next.length) {
                        $next.removeClass('complete').addClass('current');
                    }
                }
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
            getDefaultAttributes: function () {
                // function to fetch current saved prefixes and will update values of defaults
                return new Promise ((resolve, reject) => {
                    $.get('./wizard/xhr/website-configure', (response) => {
                        if (typeof response.status != 'undefined' && true === response.status) {
                            this.defaults['member_panel_url'] = response.memberPrefix;
                            this.defaults['customer_panel_url'] = response.knowledgebasePrefix;
                            resolve();
                        } else {
                            wizard.disableNextStep();
                        }
                    }).fail(function(error) {
                        reject(error);
                        wizard.disableNextStep();
                    });
                });
            },
            isProcedureCompleted: function (callback) {
                this.set('urlCollection', {
                    'member-prefix': this.view.$el.find('input[name="memeberUrlPrefix"]').val(),
                    'customer-prefix': this.view.$el.find('input[name="customerUrlPrefix"]').val(),
                });

                var wizard = this.view.wizard;
                wizard.reference_nodes.content.find('#wizardCTA-IterateInstallation').prepend('<span class="processing-request">' + wizard.wizard_icons_loader_template() + '</span>');

                $.post('./wizard/xhr/website-configure', this.get('urlCollection'), (response) => {
                    if (typeof response.status != 'undefined' && true === response.status) {
                        callback(this.view);
                    } else {
                        wizard.disableNextStep();
                    }
                }).fail(function() {
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
                "keyup #wizard-configureWebsite .form-content input" : "validateForm",
            },
            model: UVDeskCommunityWebsiteConfigurationModel,
            wizard_website_configuration: _.template($("#installationWizard-WebsiteConfigurationTemplate").html()),
            initialize: function(params) {
                this.wizard = params.wizard;
                
                // default enabled button
                this.wizard.enableNextStep();
                if (params.existingModel instanceof UVDeskCommunityWebsiteConfigurationModel) {
                    this.model = params.existingModel;
                    this.model.view = this;
                } else {
                    this.model = new UVDeskCommunityWebsiteConfigurationModel({ view: this });
                }

                // function getDefaultAttributes will fetch current prefixes
                this.model.getDefaultAttributes().then(() => {
                    this.$el.html(this.wizard_website_configuration(this.model.defaults));
                });
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

                    if (event.keyCode == 13) {
                        let button = document.getElementById('wizardCTA-IterateInstallation');
                        button ? button.click() : '';
                    }
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
                
                $.post('./wizard/xhr/intermediary/super-user', this.get('user'), function (response) {
                    if (typeof response.status != 'undefined' && true === response.status) {
                        callback(this.view);
                    } else {
                        wizard.disableNextStep();
                    }
                }.bind(this)).fail(function(response) {
                    wizard.disableNextStep();
                }).always(function() {
                    wizard.reference_nodes.content.find('#wizardCTA-IterateInstallation .processing-request').remove();
                });
            },
        });

        var UVDeskCommunityAccountConfigurationView = Backbone.View.extend({
            el: '#wizardSetup',
            model: undefined,
            wizard: undefined,
            account_settings_template: _.template($("#installationWizard-AccountConfigurationTemplate").html()),
            events: {
                "keyup #wizard-configureAccount .form-content input" : "validateForm",
            },
            initialize: function(params) {
                this.wizard = params.wizard;
                if (params.existingModel instanceof UVDeskCommunityAccountConfigurationModel) {
                    this.model = params.existingModel;
                    this.model.view = this;
                } else {
                    this.model = new UVDeskCommunityAccountConfigurationModel({ view: this });
                }
                            
                Backbone.Validation.bind(this);
                this.$el.html(this.account_settings_template(this.model.attributes));
            },
            validateForm: _.debounce(function(event) {
                let errorFlag = false;
                let nameRegex = /^[A-Za-z][A-Za-z]*[\sA-Za-z]*$/;
                let emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
                let passwordRegix = /^(?=(.*[a-zA-Z].*){2,})(?=.*\d.*)(?=.*\W.*)[a-zA-Z0-9\S]{8,}$/;

                let user = {
                    name: this.$el.find('input[name="name"]').val(),
                    email: this.$el.find('input[name="email"]').val(),
                    password: this.$el.find('input[name="password"]').val(),
                    confirmPassword: this.$el.find('input[name="confirm_password"]').val(),
                };

                let selectedElement = this.$el.find(event.target).parent();
                this.$el.find('.wizard-form-notice') ? this.$el.find('.wizard-form-notice').remove() : '';

                enteredField = event.target.name;
                enteredValue = event.target.value;
                if (enteredValue == null || enteredValue == "") {
                    errorFlag = true;
                    selectedElement.find('.wizard-form-notice')
                    selectedElement.append("<span class='wizard-form-notice'>This field is mandatory</span>");
                }

                if (!errorFlag && user.name) {
                    if (!nameRegex.test(user.name)) {
                        errorFlag = true;
                        this.$el.find('input[name="name"]').parent().append("<span class='wizard-form-notice'>Invalid Name</span>")
                    }
                }

                if (!errorFlag && user.email !== "") {
                    if (!emailRegex.test(user.email)) {
                        errorFlag = true;
                        this.$el.find('input[name="email"]').parent().append("<span class='wizard-form-notice'>Invalid Email</span>")
                    }
                }

                if (user.password.length > 0 && (!passwordRegix.test(user.password))) {
                        errorFlag = true;
                        this.$el.find('input[name="password"]').parent().append("<span class='wizard-form-notice'>Password must contain minimum 8 character length, at least two letters (not case sensitive), one number, one special character(space is not allowed).</span>")
                }

                if (user.confirmPassword.length > 0 && user.confirmPassword != user.password) {
                    errorFlag = true;
                    this.$el.find('input[name="confirm_password"]').parent().append("<span class='wizard-form-notice'>Password does not match.</span>")
                }

                if (!errorFlag && (user.name == null || user.name =="") || (user.email == null || user.email =="") || (user.password == null || user.password =="") ||  (user.confirmPassword == null || user.confirmPassword ==""))
                    errorFlag = true;


                if (!errorFlag) {
                    this.wizard.enableNextStep();

                    if (event.keyCode == 13) {
                        let button = document.getElementById('wizardCTA-IterateInstallation');
                        button ? button.click() : '';
                    }
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
                    serverVersion: null,
                    serverPort: '3306',
                    username: 'root',
                    password: null,
                    database: null,
                    createDatabase: 1,
                }
            },
            initialize: function (attributes) {
                this.view = attributes.view;
            },
            isProcedureCompleted: function (callback) {
                this.set('credentials', {
                    serverName: this.view.$el.find('input[name="serverName"]').val(),
                    serverVersion: this.view.$el.find('input[name="serverVersion"]').val(),
                    serverPort: this.view.$el.find('input[name="serverPort"]').val(),
                    username: this.view.$el.find('input[name="username"]').val(),
                    password: this.view.$el.find('input[name="password"]').val(),
                    database: this.view.$el.find('input[name="database"]').val(),
                    createDatabase: this.view.$el.find('input[name="createDatabase"]').prop("checked") ? 1 : 0,
                });

                let wizard = this.view.wizard;
                wizard.reference_nodes.content.find('#wizardCTA-IterateInstallation').prepend('<span class="processing-request">' + wizard.wizard_icons_loader_template() + '</span>');

                $.post('./wizard/xhr/verify-database-credentials', this.get('credentials'), function (response) {
                    if (typeof response.status != 'undefined' && true === response.status) {
                        callback(this.view);
                    } else {
                        if (document.getElementById("wizard-error-id")) {
                            var element = document.getElementById("wizard-error-id");
                            element.parentNode.removeChild(element); 
                        }

                        this.view.$el.find('.form-content input[name="createDatabase"]').parents('.form-content').append("<span id='wizard-error-id' class='wizard-form-notice'>Details are incorrect ! Connection not established.</span>");
                        wizard.disableNextStep();
                    }
                }.bind(this)).fail(function(response) {
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
                "keyup #wizard-configureDatabase .form-content input" : "validateForm",
                "change #wizard-configureDatabase .form-content input[type='checkbox']" : "validateForm",
            },
            initialize: function(params) {
                if (params.existingModel instanceof UVDeskCommunityDatabaseConfigurationModel) {
                    this.model = params.existingModel;
                    this.model.view = this;
                } else {
                    this.model = new UVDeskCommunityDatabaseConfigurationModel({ view: this });
                }

                this.wizard = params.wizard;

                // Render Database Configuration View
                this.$el.html(this.database_configuration_template(this.model.attributes));
            },
            validateForm: _.debounce(function(event) {
                let errorFlag = false;
                let mandatoryFieldsCollection = ['serverName', 'username', 'password', 'database'];
                let selectedElement = this.$el.find(event.target).parent();
                selectedElement.find('.wizard-form-notice') ? selectedElement.find('.wizard-form-notice').remove() : '';

                if (mandatoryFieldsCollection.indexOf(event.target.name) != -1) {
                    if (event.target.value == null || event.target.value == "") {
                        errorFlag = true;
                        selectedElement.find('.wizard-form-notice')
                        selectedElement.append("<span class='wizard-form-notice'>This field is mandatory</span>");
                    }
                }

                let credentials = {
                    hostname: this.$el.find('input[name="serverName"]').val(),
                    serverVersion: this.$el.find('input[name="serverVersion"]').val(),
                    serverPort: this.$el.find('input[name="serverPort"]').val(),
                    username: this.$el.find('input[name="username"]').val(),
                    password: this.$el.find('input[name="password"]').val(),
                    database: this.$el.find('input[name="database"]').val(),
                };


                if (!errorFlag && (credentials.hostname == null || credentials.hostname == "" || (credentials.username == null || credentials.username == "") || (credentials.password == null || credentials.password == "") || (credentials.database == null || credentials.database == "")))
                    errorFlag = true;

                if (false == errorFlag) {
                    this.wizard.enableNextStep();
                    
                    if (document.getElementById("wizard-error-id")) {
                        var element = document.getElementById("wizard-error-id");
                        element.parentNode.removeChild(element);
                    }                    
                    if (event.keyCode == 13) {
                        let button = document.getElementById('wizardCTA-IterateInstallation');
                        button ? button.click() : '';
                    }
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
                    extensions: [],
                },
                'php-maximum-execution': {
                    status: undefined,
                },
                'php-envfile-permission': {
                    status: undefined,
                },
                'php-configfiles-permission': {
                    configfiles: [],
                }
            },
            initialize: function (attributes) {
                this.view = attributes.view;
            },
            fetch: function() {
                this.set('fetch', true);

                this.checkPHP();
                this.evaluatePHPExtensions();
                this.maximumExecution();
                this.checkEnvFilePermission();
                this.checkConfigFilesPermission();
            },
            isProcedureCompleted: function (callback) {
                if (this.get('verified')) {
                    callback(this.view);
                }
            },
            checkPHP: function() {
                let postData = {
                    specification: 'php-version',
                };
                
                $.post('./wizard/xhr/check-requirements', postData, response => {
                    this.set('php-version', response);
                }).fail((jqXHR, textStatus, errorThrown) => {
                    
                    this.set('php-version', {
                        status: false,
                        message: ERRORS.hasOwnProperty('error' + jqXHR.status) ? ERRORS['error' + jqXHR.status].title : 'An unexpected error occurred during the PHP version verification process',
                        description: ERRORS.hasOwnProperty('error' + jqXHR.status) ? ERRORS['error' + jqXHR.status].description : 'Not details Available',
                    });
                }).always(() => {
                    this.view.renderPHPVersion();
                    this.evaluateOverallRequirements();
                });
            },
            evaluatePHPExtensions: function() {
                let postData = {
                    specification: 'php-extensions',
                };

                $.post('./wizard/xhr/check-requirements', postData, response => {
                    this.set('php-extensions', response);
                }).fail((jqXHR, textStatus, errorThrown) => {
                    
                    this.set('php-extensions', {
                        status: false,
                        message: ERRORS.hasOwnProperty('error' + jqXHR.status) ? ERRORS['error' + jqXHR.status].title : 'An unexpected error occurred during the PHP extension evaluation process',
                        description: ERRORS.hasOwnProperty('error' + jqXHR.status) ? ERRORS['error' + jqXHR.status].description : 'Not details Available',
                    });
                }).always(() => {
                    this.view.renderPHPExtensionsCriteria();
                    this.evaluateOverallRequirements();
                });
            },
            maximumExecution: function() {
                let postData = {
                    specification: 'php-maximum-execution',
                };

                $.post('./wizard/xhr/check-requirements', postData, response => {
                    this.set('php-maximum-execution', response);
                }).fail((jqXHR, textStatus, errorThrown) => {
                    this.set('php-maximum-execution', {
                        status: false,
                        message: ERRORS.hasOwnProperty('error' + jqXHR.status) ? ERRORS['error' + jqXHR.status].title : 'An unexpected error occurred during the Maximum execution time verification process',
                        description: ERRORS.hasOwnProperty('error' + jqXHR.status) ? ERRORS['error' + jqXHR.status].description : 'Maximum Execution Time  </span><p>Need to resolve this issue can be done by reading this blog link:<a href="https: //www.simplified.guide/php/increase-max-execution-time" target="_blank">How to resolve PHP mailparse extension</a></p>',
                    });
                }).always(() => {
                    this.view.renderPHPmaximumexecution();
                    this.evaluateOverallRequirements();
                });
            },
            checkEnvFilePermission: function() {
                let postData = {
                    specification: 'php-envfile-permission',
                };

                $.post('./wizard/xhr/check-requirements', postData, response => {
                    this.set('php-envfile-permission', response);
                }).fail((jqXHR, textStatus, errorThrown) => {

                    this.set('php-envfile-permission', {
                        status: false,
                        message: ERRORS.hasOwnProperty('error' + jqXHR.status) ? ERRORS['error' + jqXHR.status].title : 'An unexpected error occurred during the PHP version verification process',
                        description: ERRORS.hasOwnProperty('error' + jqXHR.status) ? ERRORS['error' + jqXHR.status].description : 'Not details Available',
                    });
                }).always(() => {
                    this.view.renderEnvFilePermission();
                    this.evaluateOverallRequirements();
                });
            },
            checkConfigFilesPermission: function() {
                let postData = {
                    specification: 'php-configfiles-permission',
                };

                $.post('./wizard/xhr/check-requirements', postData, response => {
                    this.set('php-configfiles-permission', response);
                }).fail((jqXHR, textStatus, errorThrown) => {

                    this.set('php-configfiles-permission', {
                        status: false,
                        message: ERRORS.hasOwnProperty('error' + jqXHR.status) ? ERRORS['error' + jqXHR.status].title : 'An unexpected error occurred during the PHP version verification process',
                        description: ERRORS.hasOwnProperty('error' + jqXHR.status) ? ERRORS['error' + jqXHR.status].description : 'Not details Available',
                    });
                }).always(() => {
                    this.view.renderConfigFilesPermission();
                    this.evaluateOverallRequirements();
                });
            },
            evaluateOverallRequirements: function() {
                if (false == this.get('php-version').status) {
                    this.set('verified', false);
                }  else if (false == this.get('php-maximum-execution').status) {
                    this.set('verified', false);
                } else if (false == this.get('php-envfile-permission').status) {
                    this.set('verified', false);
                } else if (this.get('php-configfiles-permission').hasOwnProperty('configfiles')) {
                    let configfiles = this.get('php-configfiles-permission').configfiles;

                    let isconfigfilesError;
                    configfiles.forEach(configfiles => {
                        let currentconfigfileName = Object.keys(configfiles)[0];
                        if (!configfiles[currentconfigfileName]) {
                            isconfigfilesError = true;
                            this.set('verified', false);
                        }
                    });

                    if (!isconfigfilesError) {
                        this.set('verified', true);
                    }
                } else if (this.get('php-extensions').hasOwnProperty('extensions')) {
                    let extensions = this.get('php-extensions').extensions;

                    let isExtensionError;
                    extensions.forEach(extension => {
                        let currentExtensionName = Object.keys(extension)[0];
                        if (!extension[currentExtensionName]) {
                            isExtensionError = true;
                            this.set('verified', false);
                        }
                    });

                    if (!isExtensionError) {
                        this.set('verified', true);
                    }
                } else {
                    this.set('verified', false);
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
            events: {
                "click .PHPExtensions-toggle-details, .PHPVersion-toggle-details, .PHPPermissionEnvfile-toggle-details, .PHPExeTime-toggle-details, .PHPPermissionConfigfiles-toggle-details": function (e) {
                    // show and hide extension details
                    const currentElement = Backbone.$(e.currentTarget)
                    currentElement.parents('[class*="info-container"]').siblings('.systemCriteria-Details').toggle();
                    
                    if (currentElement.html() == "Show details") {
                        currentElement.html("Hide details");
                    } else {
                        currentElement.html("Show details");
                    }
                }
            },
            reference_nodes: {
                version: undefined,
                extension: undefined,
                execution: undefined,
                permission: undefined,
                Configfiles: undefined,
            },
            wizard_icons_loader_template: _.template($("#wizardIcons-LoaderTemplate").html()),
            wizard_icons_success_template: _.template($("#wizardIcons-SuccessTemplate").html()),
            wizard_icons_notice_template: _.template($("#wizardIcons-NoticeTemplate").html()),
            wizard_system_requirements_template: _.template($("#installationWizard-SystemRequirementsTemplate").html()),
            wizard_system_requirements_php_ver_template: _.template($("#installationWizard-SystemRequirementsTemplate-PHPVersion").html()),
            wizard_system_requirements_php_ext_template: _.template($("#installationWizard-SystemRequirementsTemplate-PHPExtensions").html()),
            wizard_system_requirements_php_exe_template: _.template($("#installationWizard-SystemRequirementsTemplate-PHPExecution").html()),
            wizard_system_requirements_php_env_template: _.template($("#installationWizard-SystemRequirementsTemplate-PHPPermission").html()),
            wizard_system_requirements_php_config_template: _.template($("#installationWizard-SystemRequirementsTemplate-PHPPermissionConfigfiles").html()),
            initialize: function(params) {
                this.wizard = params.wizard;
                this.model = new UVDeskCommunitySystemRequirementsModel({ view: this });

                // Render Initial Template
                this.$el.html(this.wizard_system_requirements_template());

                // Set reference nodes
                this.reference_nodes.version = this.$el.find('#systemCriteria-PHPVersion');
                this.reference_nodes.extension = this.$el.find('#systemCriteria-PHPExtensions');

                this.reference_nodes.execution = this.$el.find('#systemCriteria-PHPExecution');
                this.reference_nodes.permission = this.$el.find('#systemCriteria-PHPPermission');
                
                this.reference_nodes.Configfiles = this.$el.find('#systemCriteria-PHPPermissionConfigfiles');

                this.renderPHPVersion('verifying');
                this.renderPHPExtensionsCriteria('verifying');

                this.renderPHPmaximumexecution('verifying');
                this.renderEnvFilePermission('verifying');
                this.renderConfigFilesPermission('verifying');

                this.model.fetch();
            },
            renderPHPVersion: function(status) {
                this.reference_nodes.version.html(this.wizard_system_requirements_php_ver_template(this.model.get('php-version')));
                this.reference_nodes.version.find('.PHPVersion-toggle-details').hide();
                
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
                        if (this.model.get('php-version').hasOwnProperty('description')) {
                            this.reference_nodes.version.find('.PHPVersion-toggle-details').show();                        
                        } 
                        this.reference_nodes.version.find('.systemCriteria-Details').addClass('systemCriteria-Info-Message');
                        this.reference_nodes.version.find('#systemCriteria-PHPVersion-Details').html(this.model.get('php-version').description);
                    }
                }
            },
            renderPHPExtensionsCriteria: function(status) {
                this.reference_nodes.extension.html(this.wizard_system_requirements_php_ext_template(this.model.get('php-extensions')));
                
                if (false == this.model.get('fetch')) {
                    this.reference_nodes.extension.find('.wizard-svg-icon-criteria-checklist').html(this.wizard_icons_loader_template());
                    this.reference_nodes.extension.find('label').html('Checking currently enabled PHP extensions');
                } else if(this.model.get('php-extensions').hasOwnProperty('extensions')) {
                    var activeExtensionCount = 0;
                    var extensionCount = this.model.get('php-extensions').extensions.length;
                    // count the active extensions and set each extension with it's status in the extension list
                    this.model.get('php-extensions').extensions.forEach(extension => {
                        let currentExtensionName = Object.keys(extension)[0];
                        let currentExtensionTemplateInfo = this.reference_nodes.extension.find('#' + currentExtensionName + '-info');
                        if (extension[currentExtensionName]) {
                            activeExtensionCount++;
                            var currentExtensionIconStatus = this.wizard_icons_success_template();
                            var currentExtensionTextStatus = "<span class='extension_name'>" + currentExtensionName + "</span> extension is currently active.";
                        } else {
                            var currentExtensionIconStatus = this.wizard_icons_notice_template();
                            if (currentExtensionName == 'imap'){
                                var currentExtensionTextStatus = "<span class='extension_name'> PHP " + currentExtensionName + " extension </span><p>Need to resolve this issue can be done by reading this blog link:<a href='https://www.php.net/manual/en/imap.setup.php' target='_blank'>How to resolve PHP imap extension</a></p>";
                            }
                            else if(currentExtensionName == 'mailparse'){
                                var currentExtensionTextStatus = "<span class='extension_name'> PHP " + currentExtensionName + " extension </span><p>Need to resolve this issue can be done by reading this blog link:<a href='https://www.php.net/manual/en/book.mailparse.php' target='_blank'>How to resolve PHP mailparse extension</a></p>";
                            }
                            else{
                                var currentExtensionTextStatus = "<span class='extension_name'>" + currentExtensionName + "extension is currently inactive</span>";
                            }
                        }

                        currentExtensionTemplateInfo.find('.wizard-svg-icon-criteria-checklist').html(currentExtensionIconStatus);
                        currentExtensionTemplateInfo.find('label').html(currentExtensionTextStatus);
                    });

                    // set overall response with the count of active extensions
                    let extension_info = this.$el.find('#systemCriteria-PHPExtensions');
                    if (activeExtensionCount < extensionCount) {
                        var overallExtensionStatus = this.wizard_icons_notice_template();
                    } else {
                        var overallExtensionStatus = this.wizard_icons_success_template();
                    }

                    extension_info.find('.wizard-svg-icon-extension-criteria-checklist').html(overallExtensionStatus);
                    extension_info.find('.extension-criteria-label').html("You meet " + activeExtensionCount + " out of " + extensionCount + " PHP extensions requirements.");
                } else {
                    this.reference_nodes.extension.find('.wizard-svg-icon-extension-criteria-checklist').html(this.wizard_icons_notice_template());
                    this.reference_nodes.extension.find('.extension-criteria-label').html(this.model.get('php-extensions').message);
                    this.reference_nodes.extension.find('#systemCriteria-PHPExtensions-Details').html(this.model.get('php-extensions').description);
                    this.reference_nodes.extension.find('#systemCriteria-PHPExtensions-Details').addClass('systemCriteria-Info-Message');
                }
            },
            renderPHPmaximumexecution: function(status) {
                this.reference_nodes.execution.html(this.wizard_system_requirements_php_exe_template(this.model.get('php-maximum-execution')));
                this.reference_nodes.execution.find('.PHPExeTime-toggle-details').hide();
                if (false == this.model.get('fetch')) {
                    this.reference_nodes.execution.find('.wizard-svg-icon-execution-criteria-checklist').html(this.wizard_icons_loader_template());
                    this.reference_nodes.execution.find('label').html('Checking maximum execution time');
                } else {
                    if (true === this.model.get('php-maximum-execution').status) {
                        this.reference_nodes.execution.find('.wizard-svg-icon-execution-criteria-checklist').html(this.wizard_icons_success_template());
                        this.reference_nodes.execution.find('label').html(this.model.get('php-maximum-execution').message);
                    } else {
                        this.reference_nodes.execution.find('.wizard-svg-icon-execution-criteria-checklist').html(this.wizard_icons_notice_template());
                        this.reference_nodes.execution.find('label').html(this.model.get('php-maximum-execution').message);
                        if (this.model.get('php-maximum-execution').hasOwnProperty('description')) {
                            this.reference_nodes.execution.find('.PHPExeTime-toggle-details').show();
                        }
                        this.reference_nodes.execution.find('.systemCriteria-Details').addClass('systemCriteria-Info-Message');
                        this.reference_nodes.execution.find('#systemCriteria-PHPExecution-Details').html(this.model.get('php-maximum-execution').description);
                    }
                }
            },
            renderEnvFilePermission: function(status) {
                this.reference_nodes.permission.html(this.wizard_system_requirements_php_env_template(this.model.get('php-envfile-permission')));
                this.reference_nodes.permission.find('.PHPPermissionEnvfile-toggle-details').hide();

                if (false == this.model.get('fetch')) {
                    this.reference_nodes.permission.find('.wizard-svg-icon-permissionEnvfile-criteria-checklist').html(this.wizard_icons_loader_template());
                    this.reference_nodes.permission.find('label').html('Checking currently enabled .env file');
                } else {
                    if (true === this.model.get('php-envfile-permission').status) {
                        this.reference_nodes.permission.find('.wizard-svg-icon-permissionEnvfile-criteria-checklist').html(this.wizard_icons_success_template());
                        this.reference_nodes.permission.find('label').html(this.model.get('php-envfile-permission').message);
                    } else {
                        this.reference_nodes.permission.find('.wizard-svg-icon-permissionEnvfile-criteria-checklist').html(this.wizard_icons_notice_template());
                        this.reference_nodes.permission.find('label').html(this.model.get('php-envfile-permission').message);
                        if (this.model.get('php-envfile-permission').hasOwnProperty('description')) {
                            this.reference_nodes.permission.find('.PHPPermissionEnvfile-toggle-details').show();
                        }
                        this.reference_nodes.permission.find('.systemCriteria-Details').addClass('systemCriteria-Info-Message');
                        this.reference_nodes.permission.find('#systemCriteria-PHPPermission-Details').html(this.model.get('php-envfile-permission').description);
                    }
                }
            },
            renderConfigFilesPermission: function(status) {
                this.reference_nodes.Configfiles.html(this.wizard_system_requirements_php_config_template(this.model.get('php-configfiles-permission')));
                this.reference_nodes.Configfiles.find('.PHPPermissionConfigfiles-error-message').hide();
                if (false == this.model.get('fetch')) {
                    this.reference_nodes.Configfiles.find('.wizard-svg-icon-permissionConfigfiles-criteria-checklist').html(this.wizard_icons_loader_template());
                    this.reference_nodes.Configfiles.find('label').html('Checking currently enabled Config-files');
                } else if (this.model.get('php-configfiles-permission').hasOwnProperty('configfiles')) {
                    var activeconfigfileCount = 0;
                    var configfileCount = this.model.get('php-configfiles-permission').configfiles.length;
                    // count the active extensions and set each extension with it's status in the extension list
                    this.model.get('php-configfiles-permission').configfiles.forEach(configfile => {
                        let currentconfigfileName = Object.keys(configfile)[0];
                        let currentconfigfileTemplateInfo = this.reference_nodes.Configfiles.find('#' + currentconfigfileName + '-info');
                        if (configfile[currentconfigfileName]) {
                            activeconfigfileCount++;
                            var currentconfigfileIconStatus = this.wizard_icons_success_template();
                            var currentconfigfileTextStatus = "<span class='configfiles_name'>" + currentconfigfileName + ".yaml </span> read/write file permission is enabled.";
                        } else {
                            var currentconfigfileIconStatus = this.wizard_icons_notice_template();
                            if (currentconfigfileName == 'uvdesk') {
                                var currentconfigfileTextStatus = "<span class='configfiles_name'> " + currentconfigfileName + ".yaml  read/write file permission is disabled </span>";
                            } else if (currentconfigfileName == 'swiftmailer') {
                                var currentconfigfileTextStatus = "<span class='configfiles_name'> " + currentconfigfileName + ".yaml  read/write file permission is disabled </span>";
                            } else {
                                var currentconfigfileTextStatus = "<span class='configfiles_name'>" + currentconfigfileName + ".yaml  read/write file permission is disabled </span>";
                            }
                            this.reference_nodes.Configfiles.find('.PHPPermissionConfigfiles-error-message').show();
                            this.reference_nodes.Configfiles.find('.PHPPermissionConfigfiles-error-message').html(this.model.get('php-configfiles-permission').description)
                        }

                        currentconfigfileTemplateInfo.find('.wizard-svg-icon-criteria-checklist').html(currentconfigfileIconStatus);
                        currentconfigfileTemplateInfo.find('label').html(currentconfigfileTextStatus);
                    });
                    // set overall response with the count of active extensions
                   let configfile_info = this.$el.find('#systemCriteria-PHPPermissionConfigfiles');
                   if (activeconfigfileCount < configfileCount) {
                       var overallconfigfileStatus = this.wizard_icons_notice_template();
                   } else {
                       var overallconfigfileStatus = this.wizard_icons_success_template();
                   }

                   configfile_info.find('.wizard-svg-icon-permissionConfigfiles-criteria-checklist').html(overallconfigfileStatus);
                   configfile_info.find('.permissionConfigfiles-criteria-label').html("You meet " + activeconfigfileCount + " out of " + configfileCount + " config files permission.");
               } else {
                   this.reference_nodes.configfiles.find('.wizard-svg-icon-permissionConfigfiles-criteria-checklist').html(this.wizard_icons_notice_template());
                   this.reference_nodes.configfiles.find('.permissionConfigfiles-criteria-label').html(this.model.get('php-configfiles-permission').message);
                   this.reference_nodes.configfiles.find('#systemCriteria-PHPPermissionConfigfiles-Details').html(this.model.get('php-configfiles-permission').description);
                   this.reference_nodes.configfiles.find('#systemCriteria-PHPPermissionConfigfiles-Details').addClass('systemCriteria-Info-Message');
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
                member: '/en/member/login',
                knowledgebase: '/en'
            },
            activeSetupProcedure: undefined,
            wizard_icons_success_template: _.template($("#wizardIcons-SuccessTemplate").html()),
            wizard_icons_loader_template: _.template($("#wizardIcons-LoaderTemplate").html()),
            wizard_default_header_template: _.template($("#installationWizard-DefaultHeaderTemplate").html()),
            wizard_default_content_template: _.template($("#installationWizard-DefaultContentTemplate").html()),
            wizard_setup_component_template: _.template($("#installationWizard-SetupTemplate").html()),
            events: {
                'click #wizardCTA-StartInstallation': function() {
                    $('.active-node').addClass('check');
                    $('.active-node').removeClass('active-node');
                    this.$el.find('.check-requirements').addClass('active-node');
                    
                    this.enabled = true;
                    this.reference_nodes.content.empty();
                    this.reference_nodes.content.html(this.wizard_setup_component_template());

                    this.router.navigate('check-requirements', { trigger: true });
                },
                'click #wizardCTA-IterateInstallation': function() {
                    if (typeof(this.activeSetupProcedure) != 'undefined') {
                        this.$el.find('.check-requirements').removeClass('active-node');
                        this.$el.find('.check-requirements').addClass('check');
                       
                        this.timeline.filter((values, index) => {
                            if (values.isActive && this.timeline[index + 1]) {
                                var cls = this.timeline[index + 1].path;
                                this.$el.find('.'+cls).addClass('active-node');
                            }
                            if (values.isChecked && this.timeline[index + 1]){
                                var cls = this.timeline[index + 1].path;
                                this.$el.find('.'+cls).removeClass('active-node');
                                this.$el.find('.'+cls).addClass('check');
                            }
                        });

                        this.activeSetupProcedure.model.isProcedureCompleted(function ({wizard, model}) {
                            let activeInstanceIndex = undefined;

                            wizard.timeline.every(function (instance, index) {
                                if (instance.isActive) {
                                    instance.model = model;
                                }

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
                        }.bind(this));
                    }
                },
                'click #wizardCTA-CancelInstallation': function() {
                    this.router.navigate('welcome', { trigger: true });
                },
                'click #wizardCTA-IterateBackward': function()  {
                    this.timeline.filter((values, index) => {
                        if (values.isActive && this.timeline[index - 1]) {
                            if (this.timeline[index].path == 'configure-database') {
                                this.timeline[index].isActive = false;
                                this.enabled = true;
                                this.reference_nodes.content.empty();
                                this.reference_nodes.content.html(this.wizard_setup_component_template());
                                this.router.navigate('check-requirements', { trigger: true }); 
                            } else {
                                this.timeline[index].isActive = false;
                                this.router.navigate(this.timeline[index - 1].path, { trigger: true });
                            }
                        } else if (values.isActive && !this.timeline[index - 1]) {
                            this.router.navigate('welcome', { trigger: true });
                        }
                    });
                }
            },
            timeline: [
                {
                    isActive: false,
                    isChecked: false,
                    path: 'check-requirements',
                    view: UVDeskCommunitySystemRequirementsView,
                    model: UVDeskCommunitySystemRequirementsModel
                },
                {
                    isActive: false,
                    isChecked: false,
                    path: 'configure-database',
                    view: UVDeskCommunityDatabaseConfigurationView,
                    model: UVDeskCommunityDatabaseConfigurationModel
                },
                {
                    isActive: false,
                    isChecked: false,
                    path: 'create-admin',
                    view: UVDeskCommunityAccountConfigurationView,
                    model: UVDeskCommunityAccountConfigurationModel
                },
                {
                    isActive: false,
                    isChecked: false,
                    path: 'website-prefixes',
                    view: UVDeskCommunityWebsiteConfigurationView,
                    model: UVDeskCommunityWebsiteConfigurationModel
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
                this.reference_nodes.header = this.$el.find('#installation-wizard-steps-overview');
                this.reference_nodes.content = this.$el.find('.installation-wizard-steps-overview-details-container');

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
                        this.timeline.every(function (installationStep, index) {
                            if (iteration == installationStep.path && typeof installationStep.view != 'undefined') {
                                this.timeline[index].isActive = true;
                                this.renderWizardInstallationStep(installationStep);

                                return false;
                            } else if (installationStep.isChecked) {
                                this.timeline[index].isActive = false;

                                return true;
                            }

                            this.router.navigate('welcome', { trigger: true });
                            return false;
                        }.bind(this));
                    }
                }
            },
            renderWizard: function() {
                this.reference_nodes.header.html(this.wizard_default_header_template());
                this.reference_nodes.content.html(this.wizard_default_content_template());
            },
            renderWizardInstallationStep: function({view: InstallationWizardTemplateView, model: InstallationWizardTemplateModel}) {
                this.disableNextStep();
                this.reference_nodes.content.find('#wizardSetup').empty();
                this.activeSetupProcedure = new InstallationWizardTemplateView({ wizard: this, existingModel: InstallationWizardTemplateModel});
            },
            enableNextStep: function() {
                this.$el.find('#wizardCTA-IterateInstallation').removeAttr('disabled');
            },
            disableNextStep: function() {
                this.$el.find('#wizardCTA-IterateInstallation').attr('disabled', 'disabled');
            },
        });

        var Router = Backbone.Router.extend({
            wizard: undefined,
            routes: {
                ':installationStep': 'iterateInstallationProcedure',
            },
            initialize: function() {
                // Initialize installation wizard
                this.wizard = new UVDeskCommunityInstallationWizardView({ router: this });
            },
            iterateInstallationProcedure: function(installationStep) {
                this.wizard.iterateInstallationSteps(installationStep);
            },
        });
    
        new Router();
        Backbone.history.start({ push_state: true });
    });
}) (jQuery);
