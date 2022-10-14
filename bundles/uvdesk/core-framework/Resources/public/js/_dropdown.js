$(function() {
    $(document).click(function(e) {
        var target = e.target;
        if(!$(target).parents('.uv-dropdown-open').length || $(target).is('li') || $(target).is('a')) {
            $('.uv-dropdown-list').hide();
            $('.uv-dropdown-btn').removeClass('uv-dropdown-btn-active');
            $('.uv-dropdown-other').removeClass('uv-dropdown-btn-active');
            $('.uv-dropdown-open').removeClass('uv-dropdown-open');
        }

        if(!$(target).parents('.uv-search-result-active').length && !$(target).is('.uv-search-bar')) {
            $('.uv-search-result-wrapper').removeClass('uv-search-result-active');
            $('.uv-search-result-wrapper').removeClass('uv-search-flap-up');
        }
    });

    $('body').delegate('.uv-dropdown-btn, .uv-dropdown-other', 'click', function(e) {
        toggleDropdown(e);
    });

    function toggleDropdown(e) {
        var currentElement = $(e.currentTarget);
        if(currentElement.hasClass('uv-dropdown-btn-active')) {
            $('.uv-dropdown-list').hide();
            $('.uv-dropdown-btn').removeClass('uv-dropdown-btn-active');
            $('.uv-dropdown-other').removeClass('uv-dropdown-btn-active');
            $('.uv-dropdown-open').removeClass('uv-dropdown-open');
        } else {
            $('.uv-dropdown-list').hide(); 
            $('.uv-dropdown-btn').removeClass('uv-dropdown-btn-active');
            $('.uv-dropdown-other').removeClass('uv-dropdown-btn-active');
            $('.uv-dropdown-open').removeClass('uv-dropdown-open');

            if(currentElement.attr('disabled') != "disabled") {
                currentElement.addClass('uv-dropdown-btn-active');
                currentElement.parent().find('.uv-dropdown-list').fadeIn(100);
                currentElement.parent().addClass('uv-dropdown-open');
                autoDropupDropdown();
            }
        }
    }

    $('.uv-search-field').on('input', function() {
        var currentElement = $(this);
        currentElement.parents(".uv-dropdown-list").find('li').each(function() {
            var text = $(this).text().trim().toLowerCase();
            var value = $(this).attr('data-id');
            if(value) {
                var isTextContained = text.search(currentElement.val().toLowerCase());
                var isValueContained = value.search(currentElement.val());
                if(isTextContained < 0 && isValueContained < 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                    flag = 1;
                }
            } else {
                var isTextContained = text.search(currentElement.val().toLowerCase());
                if(isTextContained < 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            }
        });
    });

    $('input.preloaded.uv-dropdown-other').on('input', function() {
        var currentElement = $(this);
        dropdown = currentElement.siblings('.uv-dropdown-list');
        var flag = 0;
        dropdown.find('li').each(function() {
            if(!$(this).hasClass('uv-no-results')) {
                var text = $(this).text().trim().toLowerCase();
                var value = $(this).attr('data-id');
                if(value) {
                    var isTextContained = text.search(currentElement.val().toLowerCase());
                    var isValueContained = value.search(currentElement.val());
                    if(isTextContained < 0 && isValueContained < 0) {
                        $(this).hide();
                    } else {
                        $(this).show();
                        flag = 1;
                    }
                }  else {
                    var isTextContained = text.search(currentElement.val().toLowerCase());
                    if(isTextContained < 0) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                }
            }
        });
        if(flag == 0)
            dropdown.find(".uv-no-results").show();
        else
            dropdown.find(".uv-no-results").hide();
    });

    function autoDropupDropdown() {
        dropdownButton = $(".uv-dropdown-open");
        if(!dropdownButton.find('.uv-dropdown-list').hasClass('uv-top-left') && !dropdownButton.find('.uv-dropdown-list').hasClass('uv-top-right') && dropdownButton.length) {
            dropdown = dropdownButton.find('.uv-dropdown-list');
            height = dropdown.height() + 50;
            var topOffset = dropdownButton.offset().top - 70;
            var bottomOffset = $(window).height() - topOffset - dropdownButton.height();
            
            if(bottomOffset > topOffset || height < bottomOffset) {
                dropdownButton.removeClass("bottom");
                if(dropdown.hasClass('uv-top-right')) {
                    dropdown.removeClass('uv-top-right')
                    dropdown.addClass('uv-bottom-right')
                } else if(dropdown.hasClass('uv-top-left')) {
                    dropdown.removeClass('uv-top-left')
                    dropdown.addClass('uv-bottom-left')
                }
            } else{
                if(dropdown.hasClass('uv-bottom-right')) {
                    dropdown.removeClass('uv-bottom-right')
                    dropdown.addClass('uv-top-right')
                } else if(dropdown.hasClass('uv-bottom-left')) {
                    dropdown.removeClass('uv-bottom-left')
                    dropdown.addClass('uv-top-left')
                }
            }
        }
    }

    $('div').scroll(function(){
        autoDropupDropdown()
    });

});