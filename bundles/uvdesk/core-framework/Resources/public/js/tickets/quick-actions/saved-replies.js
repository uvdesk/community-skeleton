$(function () {
    var SavedRepliesComponent = Backbone.View.extend({
        el: $('.uv-wrapper'),
        events: {
            'click .uv-dropdown.saved-reply .uv-dropdown-list li': 'getSavedReplyContent',
        },
        getSavedReplyContent : function(e) {
            var id = Backbone.$(e.currentTarget).attr('data-id');

            if (id) {
                app.appView.showLoader();

                $.ajax({
                    url: "../saved-reply-apply/" + id,
                    type: 'GET',
                    data: {
                        id: id,
                        ticketId: this.model.id
                    },
                    dataType: 'json',
                    success: function(response) {
                        app.appView.hideLoader();
                        activeTab = $('.uv-ticket-reply .uv-tab-view.uv-tab-view-active').attr('id');
                        tinyMCE.get(activeTab + "-area").execCommand('mceInsertContent', false, response.message);

                        $('.uv-ticket-scroll-region').animate({
                            scrollTop: $('#default').outerHeight()
                        }, 'slow');
                    },
                    error: function (xhr) {
                        if (url = xhr.getResponseHeader('Location')) {
                            window.location = url;
                        }
                    }
                });
            }
        },
    });

    new SavedRepliesComponent({
        model: uvdesk.ticket.model
    });
});