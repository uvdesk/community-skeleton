var app = app || {};

$(function() {
    _.extend(Backbone.Validation.callbacks, {
        valid : function (view, attr, selector) {
            var $el = view.$('[name="' + attr + '"]');
            $el = $el.length ? $el : $('[name="'+ attr + '[]' + '"]');
            if(attr == 'user_form[groups][]' || attr == 'user_form[agentPrivilege][]' || attr == 'privilege_form[privileges][]') {
                $el.parents('.uv-scroll-block').parent().find('.uv-field-message').remove();
            } else if(attr == 'user_form[ticketView]' || attr == 'grant-type[]') {
                $el.closest('.uv-element-block').parent().find('.uv-field-message').remove();
            } else if(attr == 'g-recaptcha-response') {
                $el.parents('.g-recaptcha').find(".uv-field-message").remove();
            } else if(attr != 'user_form[profileImage]' && attr != 'customer_form[profileImage]') {
                $el.removeClass('uv-field-error');
                if(!$el.parent().hasClass('uv-radio') && !$el.parent().hasClass('uv-checkbox')) {
                    $el.parent().find('.uv-field-error-icon').remove()
                    $el.parent().find('.uv-field-success-icon').remove()
                    if($el.val()) {
                        $el.after('<span class="uv-field-success-icon"></span>');
                    }
                }
                $el.parents('.uv-element-block').find('.uv-field-message').remove();
            } else {
                $el.parents('.uv-image-upload-wrapper').find('.uv-field-message').remove();
            }
        },
        invalid : function (view, attr, error, selector) {
            var $el = view.$('[name="' + attr + '"]');
            $el = $el.length ? $el : $('[name="'+ attr + '[]' + '"]');
            if(attr == 'user_form[groups][]' || attr == 'user_form[agentPrivilege][]' || attr == 'privilege_form[privileges][]') {
                $el.parents('.uv-scroll-block').parent().find('.uv-field-message').remove();
                $el.parents('.uv-scroll-block').parent().append("<span class='uv-field-message'>" + error + "</span>")
            } else if(attr == 'user_form[ticketView]' || attr == 'grant-type[]') {
                $el.parents('label').parent().parent().find('.uv-field-message').remove();
                $el.parents('label').parent().parent().append("<span class='uv-field-message'>" + error + "</span>")
            } else if(attr == 'g-recaptcha-response') {
                $el.parents('.g-recaptcha').find('.uv-field-message').remove();
                $el.parents('.g-recaptcha').append("<span class='uv-field-message' style='font-size: 15px'>" + error + "</span>")
            } else if(attr != 'user_form[profileImage]' && attr != 'customer_form[profileImage]') {
                $el.addClass('uv-field-error');
                if(!$el.parent().hasClass('uv-radio') && !$el.parent().hasClass('uv-checkbox')) {
                    $el.parent().find('.uv-field-success-icon').remove()
                    $el.parent().find('.uv-field-error-icon').remove()
                    $el.after('<span class="uv-field-error-icon"></span>');
                }
                $el.parents('.uv-element-block').find('.uv-field-message').remove();
                $el.parents('.uv-element-block').append("<span class='uv-field-message'>" + error + "</span>");
            } else {
                $el.parents('.uv-image-upload-wrapper').append("<span class='uv-field-message'>" + error + "</span>");
            }
        }
    });

    $.fn.serializeObject = function () {
        "use strict";
        var a = {}, b = function (b, c) {
            var d = a[c.name];
            "undefined" != typeof d && d !== null ? $.isArray(d) ? d.push(c.value) : a[c.name] = [d, c.value] : a[c.name] = c.value
        };
        return $.each(this.serializeArray(), b), a
    };

    var oldBackboneSync = Backbone.sync;
    Backbone.sync = function( method, model, options ) {
        if ( method === 'delete' ) {
            if ( options.data ) {
                options.data = JSON.stringify(options.data);
            }
            options.contentType = 'application/json';
        }
        return oldBackboneSync.apply(this, [method, model, options]);
    }

    AppCollection = Backbone.PageableCollection.extend({
    	mode: "server",
     	state: {
     		pageSize: null,
        	currentPage: null,
        	totalRecords : null,
        	sortKey: null,
        	order : null,
        	query: {}
      	},
      	filterParameters : {
      		"search" : ""
      	},
      	queryParams: {
    	    currentPage: "page",
    	    sortKey: "sort",
    	    order: "direction",
    	    pageSize : "limit",
    	    directions: {
    	      "-1": "asc",
    	      "1": "desc"
    	    }
    	},
    	getValidParameters : function() {
    		var self = this;
    		var param = {};
    		$.each(this.filterParameters, function(key, value){
    		    if (key == 'page' || key == 'sort' || key == 'direction') {
    		        delete self.filterParameters[key];
    		    } else {
    		    	if (value != "" && value != null)
    		    		param[key] = value;
    		    }
    		});
    		return param;
    	}
    });

    app.Filter = Backbone.View.extend({
        el : $(".uv-action-bar"),
        events : {
            'click .filter-by-status li' : "filterByStatus",
            'keyup .uv-search-inline' : 'search',
        },
        sortCollection : function(sortField,order) {
            var context = {};
            context['queryString'] = app.appView.buildQuery($.param(this.collection.getValidParameters()));
            if(typeof sortField != 'undefined' && sortField != null) {
                context['page'] = this.collection.state.currentPage;
                context['sort'] = sortField;

                if(order == 'asc') {
                    context['direction'] = 'desc';
                    order = -1;
                } else {
                    context['direction'] = 'asc';
                    order = 1;
                }

                $(".sort .uv-dropdown-list ul").html(this.template(context));
                var selectedText = $(".sort a[data-field='"+sortField+"']").text();
                $(".sort .uv-dropdown-btn").text(this.sortText + selectedText);
                this.collection.setSorting(sortField, order, {full: true});
            } else {
                $(".sort .uv-dropdown-btn").text(this.defaultSortText);
                context['page'] = this.collection.state.currentPage;
                context['sort'] = this.defaultSortIndex;
                context['direction'] = 'asc';
                $(".sort .uv-dropdown-list ul").html(this.template(context));
            }
        },
        filterByStatus : function(e) {
			e.preventDefault()
            this.collection.reset();
            this.collection.state.currentPage = null;
            this.collection.setSorting(null, null, {full: false});
            this.collection.filterParameters.isActive  = Backbone.$(e.currentTarget).find('a').attr('data-id');
            var queryString = app.appView.buildQuery($.param(this.collection.getValidParameters()));
            router.navigate(queryString, {trigger: true});
        },
        search : _.debounce(function(e) {
            this.collection.reset();
            this.collection.state.currentPage = null;
            this.collection.filterParameters.search = Backbone.$(e.target).val();
            var queryString = app.appView.buildQuery($.param(this.collection.getValidParameters()));
            router.navigate(queryString,{trigger: true});
        }, 1000)
    });

    app.Paginater = Backbone.View.extend({
    	el : $(".navigation"),
    	template : _.template($("#pagination_tmp").html()),
        paginationData: {},
        render : function() {
        	if(typeof this.paginationData.next == 'undefined')
        		this.paginationData.next = 0;
        	if(typeof this.paginationData.previous == 'undefined')
        		this.paginationData.previous = 0;
        	this.paginationData.current = parseInt(this.paginationData.current);

        	$(".navigation").html(this.template(this.paginationData));
        },
    });

    app.AppView = Backbone.View.extend({
    	el: 'body',
        targetView: null,
        functionName: null,
        events : {
            'click .delete': 'actionConfirmed',
            'click .uv-open-popup': 'openModalEvent',
            'click .uv-pop-up-overlay .uv-btn.cancel, .uv-pop-up-overlay .uv-pop-up-close': 'closeModalEvent',
            'click .uv-pop-up-overlay .uv-btn.confirm': 'actionConfirmed',
            'click .uv-notification-close': 'closeNotificationPopUp',
            'change .uv-image-upload-brick input': 'uploadImage',
            'dragover .uv-image-upload-brick input': 'dragoverOnImage',
            'drop .uv-image-upload-brick input': 'dropOnImage',
            'mouseover [data-toggle="tooltip"]': 'openTooltip',
            'mouseout [data-toggle="tooltip"]': 'closeTooltip',
            'click #open-uvdesk-tour': 'openUVdeskTour'
        },
    	fullViewLoader: _.template($('#full-view-loader').html()) ,
        initialize: function() {
            setTimeout(function() {
                $(".uv-notification.page-load").fadeOut(500, function() {
                    $(this).remove();
                });
            }, 5000);
        },
        closeNotificationPopUp: function(e) {
            Backbone.$(e.currentTarget).parents('.uv-notification').remove();
        },
        openModalEvent: function(e) {
            e.preventDefault();

            var currentElement = Backbone.$(e.currentTarget);
            $("#" + currentElement.attr('data-target')).show();
            $('body').addClass('uv-pop-up-body')
        },
        closeModalEvent: function(e) {
            this.closeModal();
        },
        openModal: function(target) {
            $(".uv-pop-up-overlay#" + target).show();
            $('body').addClass('uv-pop-up-body');
        },
        closeModal: function() {
            $(".uv-pop-up-box").addClass('jelly-out')
            $(".uv-pop-up-overlay").addClass('fade-out-white');
            setTimeout(function() {
                $(".uv-pop-up-overlay").removeClass('fade-out-white').hide();
                $(".uv-pop-up-box").removeClass('jelly-out')
                $('body').removeClass('uv-pop-up-body');
            }, 250);
        },
        openConfirmModal: function(targetView, functionName) {
            this.openModal("confirm-modal")
            this.targetView = targetView;
            if(typeof(functionName) == "undefined") {
                functionName = 'removeItem';
            }
            this.functionName = functionName;
        },
        actionConfirmed: function() {
            this.targetView[this.functionName]()
            this.closeModal("confirm-modal")
        },
        defLoader: 1,
        removeDefLoader: function(e) {
            if(this.defLoader) {
            	$('.uv-loader-view').remove();            
            }
        },
    	showLoader : function() {
            if(!$('.uv-loader-view').length) {
                this.$el.prepend(this.fullViewLoader());
            } else {
                this.defLoader = 0;
            }
        },
        hideLoader : function() {
        	$('.uv-loader-view').remove();
        },
        renderResponseAlert : function(response) {
            var notification = new NotificationView();
            $(".uv-notifications-wrapper").prepend(notification.render(response).el);
            setTimeout(function() {
                notification.$el.fadeOut(500, function() {
                    $(this).remove();
                });
            }, 5000);
        },
        buildQuery: function(query) {
            query = query.replace(/&/g,'/');
            query = query.replace(/=/g,'/');
            if(query.indexOf("new/1") >= 0)
                query = query.replace('new/1','new')
            else if(query.indexOf("unassigned/1") >= 0)
                query = query.replace('unassigned/1','unassigned')
            else if(query.indexOf("notreplied/1") >= 0)
                query = query.replace('notreplied/1','notreplied')
            else if(query.indexOf("mine/1") >= 0)
                query = query.replace('mine/1','mine')
            else if(query.indexOf("starred/1") >= 0)
                query = query.replace('starred/1','starred')
            else if(query.indexOf("trashed/1") >= 0)
                query = query.replace('trashed/1','trashed')

            return query;
        },
        relativeTime: function() {
            return;
            $.each($(".timeago"), function() {
                var msPerMinute = 60;
                var msPerHour = msPerMinute * 60;
                var msPerDay = msPerHour * 24;
                var msPerMonth = msPerDay * 30;
                var msPerYear = msPerDay * 365;

                var elapsed = Math.round(new Date().getTime() / 1000) - parseInt($(this).attr('data-timestamp'));
                var relativeTimeStr = "";
                if (elapsed < msPerMinute) {
                    relativeTimeStr = Math.round(elapsed / 1000) + ' seconds ago';
                } else if (elapsed < msPerHour) {
                    relativeTimeStr = Math.round(elapsed / msPerMinute) + ' minutes ago';
                } else if (elapsed < msPerDay ) {
                    relativeTimeStr = Math.round(elapsed / msPerHour ) + ' hours ago';
                } else if (elapsed < msPerMonth) {
                    relativeTimeStr = Math.round(elapsed / msPerDay) + ' days ago';
                } else if (elapsed < msPerYear) {
                    relativeTimeStr = Math.round(elapsed / msPerMonth) + ' months ago';
                } else {
                    relativeTimeStr = + Math.round(elapsed / msPerYear ) + ' years ago';
                }

                $(this).text(relativeTimeStr)
            });

        },
        stripHTML: function(dirtyString) {
            var container = document.createElement('div');
            var text = document.createTextNode(dirtyString);
            container.appendChild(text);
            return container.innerHTML; // innerHTML will be a xss safe string
        },
        htmlText: function(dirtyString) {
            var container = document.createElement('div');
		  	var text = document.createTextNode(dirtyString);
		  	$(container).html(dirtyString);
		  	return $(container).text().trim();
        },
        convertToSlug: function(Text) {
            return Text
                .toLowerCase()
                .replace(/[^\w- ]+/g,'')
                .trim()
                .replace(/ +/g,'-');
        },
        checkSpecialChras: function(Text) {
            if(/^[a-zA-Z0-9-]*$/.test(Text) == false)
                return true;

            return false;
        },
        timeToString: function(sec_num) {
            var d = parseInt(sec_num / (3600 * 24));
	        var h = parseInt((sec_num / 3600) % 24);
	        var m = parseInt((sec_num / 60) % 60);
	        var s = parseInt(sec_num % 60);

            var dDisplay = d > 0 ? d + "d " : "";
            var hDisplay = h > 0 ? h + "h " : "";
            var mDisplay = m > 0 ? m + "m " : "";
            var sDisplay = s > 0 ? s + "s " : "";

            time = dDisplay + hDisplay + mDisplay;
            if(d < 1 && h < 1) {
                time += sDisplay;
            }

            return time;
		},
        getTextColorBasedBackground: function(hexCode) {
            hexCode = hexCode.replace('#', '');
            if(hexCode.length == 3)
                hexCode += hexCode;

            var chars = hexCode.split("");
            a2fCount = 0;
            _.each(chars, function (char, key) {
                if(jQuery.inArray(key, [0, 2, 4]) !== -1 && jQuery.inArray(char.toUpperCase(), ['A', 'B', 'C', 'D', 'E', 'F']) !== -1) {
                    a2fCount++;
                }
            });

            if(a2fCount >= 2) {
                return '#333333';
            } else {
                return '#FFFFFF';
            }

            // var c_r = parseInt(hexCode.substr(0, 2), 16);
            // var c_g = parseInt(hexCode.substr(2, 2), 16);
            // var c_b = parseInt(hexCode.substr(4, 2), 16);

            // temp = ((c_r * 299) + (c_g * 587) + (c_b * 114)) / 1000;
            // if(temp > 125) {
            //     return '#333333';
            // } else {
            //     return '#FFFFFF';
            // }
        },
		copyToClipboard: function(elem) {
            try {
                // create hidden text element, if it doesn't already exist
                var targetId = "_hiddenCopyText_";
                var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
                var origSelectionStart, origSelectionEnd;
                if (isInput) {
                    // can just use the original source element for the selection and copy
                    target = elem;
                    origSelectionStart = elem.selectionStart;
                    origSelectionEnd = elem.selectionEnd;
                } else {
                    // must use a temporary form element for the selection and copy
                    target = document.getElementById(targetId);
                    if (!target) {
                        var target = document.createElement("textarea");
                        target.style.position = "absolute";
                        target.style.left = "-9999px";
                        target.style.top = "0";
                        target.id = targetId;
                        document.body.appendChild(target);
                    }
                    target.textContent = elem.textContent;
                }
                // select the content
                var currentFocus = document.activeElement;
                target.focus();
                target.setSelectionRange(0, target.value.length);

                // copy the selection
                var succeed;
                try {
                    succeed = document.execCommand("copy");
                } catch(e) {
                    succeed = false;
                }
                // restore original focus
                if (currentFocus && typeof currentFocus.focus === "function") {
                    currentFocus.focus();
                }

                if (isInput) {
                    // restore prior selection
                    elem.setSelectionRange(origSelectionStart, origSelectionEnd);
                } else {
                    // clear temporary content
                    target.textContent = "";
                }
            } catch(e) {
                succeed = false;
            }
			return succeed;
		},
        uploadImage: function(e) {
            var currentElement = Backbone.$(e.currentTarget);
            var reader = new FileReader();
            uvGetImage = e.currentTarget.files[0];

            reader.readAsDataURL(uvGetImage);
            reader.onload = function() {
                var uvUploadBrick = currentElement.parents('.uv-image-upload-brick');
                var uploadedImage = uvUploadBrick.find("#dynamic-image-upload");

                uvUploadBrick.css('border', 'none')
                uploadedImage.css('backgroundColor', '#FFFFFF')
                uploadedImage.attr('src', reader.result)
                uvUploadBrick.addClass("uv-on-drop-shadow")
            }
        },
        dragoverOnImage: function(e) {
            Backbone.$(e.currentTarget).parents('.uv-image-upload-brick').addClass('uv-on-drag')
        },
        dropOnImage: function(e) {
            var uvUploadBrick = Backbone.$(e.currentTarget).parents('.uv-image-upload-brick');
            if(uvUploadBrick.hasClass("uv-on-drag")){
                uvUploadBrick.removeClass("uv-on-drag");
            }
            uvUploadBrick.addClass("uv-on-drop-shadow");
        },
        openTooltip: function(e) {
            var currentElement = Backbone.$(e.currentTarget)
            currentElement.attr('data-title', currentElement.attr('title'));
            currentElement.removeAttr('title');
            if(currentElement.parents('.uv-sidebar').length) {
                if(!currentElement.parents('.uv-sidebar').hasClass('uv-sidebar-active')) {
                    return;
                }
            }

            var placement = currentElement.attr('data-placement') ? currentElement.attr('data-placement') : 'top';
            $('body').append("<span class='uv-tooltip " + placement + "'>" + currentElement.attr('data-title') + "</span>")

            var elementWidth = currentElement.outerWidth()
            var elementHeight = currentElement.outerHeight()
            var tooltipWidth = $('.uv-tooltip').outerWidth()
            var tooltipHeight = $('.uv-tooltip').outerHeight()
            var topOffset = currentElement.offset().top;
            var leftOffset = currentElement.offset().left;
            var rightOffset = ($(window).width() - (leftOffset + currentElement.outerWidth()));

            if(placement == 'left') {
                if(elementHeight > tooltipHeight)
                    var top = topOffset + ((elementHeight / 2) - (tooltipHeight / 2));
                else
                    var top = topOffset - ((elementHeight / 2) - (elementWidth / 2));

                $('.uv-tooltip').css('top', top)
                $('.uv-tooltip').css('left', leftOffset - elementWidth - tooltipWidth - 10)
            } else if(placement == 'right') {
                if(elementHeight > tooltipHeight)
                    var top = topOffset + ((elementHeight / 2) - (tooltipHeight / 2));
                else
                    var top = topOffset - ((elementHeight / 2) - (elementWidth / 2));

                $('.uv-tooltip').css('top', top)
                $('.uv-tooltip').css('left', leftOffset + elementWidth + 10)
            } else if(placement == 'bottom') {
                minus = 0;
                temp = leftOffset + (elementWidth / 2) + (tooltipWidth / 2)
                if(temp > $(window).outerWidth()) {
                    minus = temp - $(window).outerWidth();
                }

                if(elementWidth > tooltipWidth)
                    var left = leftOffset + ((elementWidth / 2) - (tooltipWidth / 2));
                else
                    var left = leftOffset - ((tooltipWidth / 2) - (elementWidth / 2));

                $('.uv-tooltip').css('left', left - minus)
                $('.uv-tooltip').css('top', topOffset + elementHeight + 10)
            } else {
                minus = 0;
                temp = leftOffset + (elementWidth / 2) + (tooltipWidth / 2)
                if(temp > $(window).outerWidth()) {
                    minus = temp - $(window).outerWidth();
                }

                if(elementWidth > tooltipWidth)
                    var left = leftOffset + ((elementWidth / 2) - (tooltipWidth / 2));
                else
                    var left = leftOffset - ((tooltipWidth / 2) - (elementWidth / 2));

                $('.uv-tooltip').css('left', left - minus)
                $('.uv-tooltip').css('top', topOffset - tooltipHeight - 10)
            }
        },
        closeTooltip: function(e) {
            var currentElement = Backbone.$(e.currentTarget)            
            currentElement.attr('title', currentElement.attr('data-title'));
            currentElement.removeAttr('data-title');            
            $('.uv-tooltip').remove();
        },
        openUVdeskTour: function(e) {
            localStorage.removeItem("tourHide")
            this.openModal('uv-tour-pop-up')
        },
        sanitize: function(html) {
            return html
                .replace(/&/g, '&amp;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
        }
    });

    var NotificationView = Backbone.View.extend({
        tagName : "div",
    	template: _.template($('#notification-template').html()),
        events : {
            'click .uv-notification-close': 'closeNotificationPopUp',
        },
        render : function(response) {
            this.$el.html(this.template(response));
            return this;
        },
        closeNotificationPopUp: function(e) {
            this.$el.remove();
        }
    });

    Backbone.$('.delete-entity').on('click', function() {
        if(typeof(targetView) != 'undefined')
            targetView.removeItem();

        Backbone.$('#confirm-modal').modal('hide');
    });

    $('.uv-tabs li').on('click', function() {
        if(!$(this).hasClass('uv-tab-ellipsis') && !$(this).parents('li').hasClass('uv-tab-ellipsis')) {
            $(this).siblings('.uv-tabs li').removeClass('uv-tab-active');
            $(this).addClass('uv-tab-active');
            $(this).siblings('.uv-tab-view').removeClass('uv-tab-view-active')
            $('#' + $(this).attr('for')).addClass('uv-tab-view-active')
            $('#' + $(this).attr('for')).siblings('.uv-tab-view').removeClass('uv-tab-view-active')
        }
    });

    $('.uv-home-tabs li').on('click', function() {
        $('.uv-home-tabs li').removeClass('home-tab-active');
        $(this).addClass('home-tab-active');
        $('.uv-tab-view').removeClass('uv-tab-view-active')
        $('#' + $(this).attr('for')).addClass('uv-tab-view-active')
    });

    $('.filter-view-trigger').on('click', function() {
        if ($(this).parents('.uv-rtl').length > 0) {
            $('.uv-filter-view:not(.uv-files-view)').css('left', '-300px')
            $("#" + $(this).attr('data-target')).css('left', '0px')
        } else {
            $('.uv-filter-view:not(.uv-files-view)').css('right', '-300px')
            $("#" + $(this).attr('data-target')).css('right', '0px')
        }
    });

    $('.uv-filter-toggle').on('click', function() {
        if ($(this).parents('.uv-rtl').length > 0) {
            $(this).parents('.uv-filter-view').css('left', '-300px')
        } else {
            $(this).parents('.uv-filter-view').css('right', '-300px')
        }
    });

    app.appView = new app.AppView();
    app.appView.relativeTime()
    app.pager = new app.Paginater();

    setInterval(function() {
        app.appView.relativeTime()
    }, 60 * 1000);

    $('body').on('click', '[disabled="disabled"]', function(e){
        e.preventDefault();
    })

    var uvHamburger =  document.querySelector(".uv-hamburger");
	if (uvHamburger) {
	    var uvPaper =  document.querySelector(".uv-paper");
	    var uvSidebar =  document.querySelector(".uv-sidebar");
        var uvWrapper =  document.querySelector(".uv-wrapper");
        var uvSlideIn = () => {
            if (window.innerWidth <= 768) {
                uvSidebar.classList.add("slide-in");
            } else {
                uvSidebar.classList.remove("slide-in");
            }
	    }

	    window.onresize = () => {
            uvSlideIn();
	    }
	    uvSlideIn();
        
        var getCookie = name => {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");

            return parseInt(parts.pop().split(";").shift());
        }

        let sidebarCookieValue = getCookie('uv-sidebar');
        if (sidebarCookieValue) {
            uvSidebar.classList.remove('uv-sidebar-active');
            uvPaper.classList.add('uv-wrapper-padding');
            uvWrapper.classList.add('uv-wrapper-gap');
        } else {
            uvSidebar.classList.add('uv-sidebar-active');
            uvWrapper.classList.remove('uv-wrapper-gap');
            uvPaper.classList.remove('uv-wrapper-padding');
        }

	    uvHamburger.addEventListener("click", () => {
            uvWrapper.classList.toggle("uv-wrapper-gap");
            uvPaper.classList.toggle('uv-wrapper-padding');
            uvSidebar.classList.toggle("uv-sidebar-active");
            if (uvWrapper.classList.contains("uv-wrapper-gap"))
                document.cookie = "uv-sidebar=1; uv-wrapper-status=1;";
            else
                document.cookie = "uv-sidebar=0; uv-wrapper-status=0;"
        });

        $(window).resize(function() {
            var windowSize = $(window).width();
            if(windowSize && windowSize <= 1310) {
                uvSidebar.classList.add('uv-sidebar-active');
                var uvSideBar = document.querySelector(".uv-logo");
                var uvOpenHamburger = document.querySelector(".open-hamburger");
                if (uvOpenHamburger && !uvOpenHamburger.is(":hidden")) {
                    uvSideBar.style.display = 'block'; 
                }
            } else {
                uvSidebar.classList.add('uv-sidebar-active');
            }
        });

        var windowSize = $(window).width();
        if(windowSize && windowSize >= 1340) {
            var uvViewT =  document.querySelector(".uv-view");
    
            uvHamburger.addEventListener("click", () => {
                var uvSideBar = document.querySelector(".uv-logo");
                var uvSoftTop = document.querySelector(".uv-soft-top");
                var uvOpenHamburger = document.querySelector(".open-hamburger");
                if (uvOpenHamburger) {
                    if (uvViewT)
                        uvViewT.classList.add('open-uvt');
    
                    uvHamburger.classList.remove('open-hamburger');
                    uvHamburger.style.margin = '24px 20px'; 
                    uvSideBar.style.display = 'none';
                    uvSideBar.style.margin = '10px 7px'; 
                    uvSoftTop.style.display = 'block';
                    uvWrapper.style.left = '60px';
                } else {
                    if (uvViewT)
                        uvViewT.classList.add('open-uvt');
    
                    uvHamburger.classList.add('open-hamburger');
                    uvHamburger.style.margin = '24px 7px'; 
                    uvSideBar.style.display = 'block';
                    uvSideBar.style.margin = '10px 18px'; 
                    uvSoftTop.style.display = 'flex';
                    uvWrapper.style.left = '300px';
                }
            }); 
        }

        if(windowSize && windowSize >= 1310) {
            uvSidebar.classList.add('uv-sidebar-active');
            uvWrapper.classList.remove('uv-wrapper-gap');
            uvPaper.classList.remove('uv-wrapper-padding');
        } else {
            uvSidebar.classList.remove('uv-sidebar-active');
            uvPaper.classList.remove('uv-wrapper-padding');
            uvWrapper.classList.add('uv-wrapper-gap');

            var uvSideBar = document.querySelector(".uv-logo");
            var uvOpenHamburger = document.querySelector(".open-hamburger");
            if (uvOpenHamburger) {
                if (!uvOpenHamburger.is(":hidden")) {
                    uvSideBar.style.display = 'block';
                }
            } 
        }
	} 
});