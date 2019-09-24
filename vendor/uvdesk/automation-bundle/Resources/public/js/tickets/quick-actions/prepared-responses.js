$(function () {
    var PreparedResponsesComponent = Backbone.View.extend({
        el: $('.uv-wrapper'),
        events: {
            'click .uv-dropdown-container.prepared-responses a:not(.create-new)': 'confirmPreparedResponses',
        },
        confirmPreparedResponses: function(e) {
            console.log('confirm prepared response');
            e.preventDefault();

            currentElement = Backbone.$(e.currentTarget);
            this.targetPreparedResponseUrl = currentElement.attr('href');
            app.appView.openConfirmModal(this, 'applyPreparedResponses');
        },
        applyPreparedResponses: function() {
            window.location = this.targetPreparedResponseUrl;
        }
    });

    new PreparedResponsesComponent({
        model: uvdesk.ticket.model
    });

});