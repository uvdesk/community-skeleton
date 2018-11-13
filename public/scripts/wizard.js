(function ($) {
    // Wait for all assets to load
    $(window).bind("load", function() {
        console.log('Resources loaded');
    });

    // Main execution
    console.log('Hello World');

    var InstallationWizard = Backbone.View.extend({
        el: '#wizard-container',
        router: {},
        collection: {},
        initialize: function(params) {
            this.router = params.router;
            // this.collection.incomingSourcesStatistics = new VisitorsIncomingSourceStatisticsView({
            //     parentViewReference: this,
            //     elementReference: '.knowledgebase-insights.source-overview-metrics',
            // });
        },
        appendLoader: function(node_reference) {
            // this.$el.find(node_reference).append(this.loader_template());
        },
        removeLoader: function(node_reference) {
            // this.$el.find(node_reference + ' .uv-loader-view').remove();
        },
        updateReport: function() {
            // this.collection.incomingSourcesStatistics.reference_model.syncReports({filters: this.getValidParameters()});
        },
    });

    Router = Backbone.Router.extend({
        wizard: undefined,
        routes: {
            '': 'loadWizard',
            // 'start/:startDate(/end/:endDate)': 'getFilteredReport',
        },
        initialize: function() {
            var self = this;
            self.wizard = new InstallationWizard({router: self});
        },
        loadWizard: function() {
            console.log('Load Wizard');
            // this.fetch();
        },
        // getFilteredReport: function(startDate, endDate, agent, customer, priority, type, group, team, source) {
        //     this.resetFilter(startDate, endDate, agent, customer, priority, type, group, team, source);
        //     this.fetch();
        // },
        // resetFilter: function(startDate, endDate, agent, customer, priority, type, group, team, source) {
        //     // console.log('Reset insight filters');
        //     $('#insightsFilterRange').data('daterangepicker').setStartDate(startDate);
        //     $('#insightsFilterRange').data('daterangepicker').setEndDate(endDate);

        //     this.insights.filterParameters.start = startDate;
        //     this.insights.filterParameters.end = endDate;
        // },
        fetch: function() {
            // this.insights.updateReport();
        },
    });

    var router = new Router();
    Backbone.history.start({ push_state: true });
})(jQuery);