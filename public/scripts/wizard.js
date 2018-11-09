(function ($) {
    // Wait for all assets to load
    $(window).bind("load", function() {
        console.log('Resources loaded');
    });

    // Main execution
    console.log('Hello World');
})(jQuery);