
var $isClickedNotify = false;
var loader_html	= '<div class="tb-preloader-section"><div class="tb-preloader-holder"><div class="tb-loader"></div></div></div>';
jQuery(document).ready(function($){
	'use strict';
    jQuery(window).on("click",function(){
        $("#rangecollapse").collapse({toggle: false});
    });

    // Loade More
    let classes = [
        '.tk-languagetermsfilter',
        '.tk-skillstermsfilter',
        '.tk-expertisetermsfilter',
    ];
    for ( let i = 0; i < classes.length; ++i) {
        if (classes[i].length <= 5) {
            jQuery(".tb-show_more").hide();
        } 
        else if (classes[i].length >= 5) {
            
            jQuery(".tk-languagetermsfilter li:nth-child(n+6)").hide();
            jQuery(".tk-skillstermsfilter li:nth-child(n+6)").hide();
            jQuery(".tk-expertisetermsfilter li:nth-child(n+6)").hide();
        }
    }
    

    //load more sub categories
    jQuery(document).on('click','.tb-show_more',function(e){
        let show_more   = jQuery(this).data('show_more');
        let show_less   = jQuery(this).data('show_less');
        jQuery(this).text($(this).text() == show_less ? show_more : show_less);
        jQuery(this).closest(".tk-aside-holder").find(".tk-languagetermsfilter li:nth-child(n+6)").slideToggle();
        jQuery(this).closest(".tk-aside-holder").find(".tk-skillstermsfilter li:nth-child(n+6)").slideToggle();
        jQuery(this).closest(".tk-aside-holder").find(".tk-expertisetermsfilter li:nth-child(n+6)").slideToggle();
    });

    jQuery(document).on('mouseenter','.tb-tooltip-data',function(e){
        let id  = jQuery(this).attr('id');
        tooltipInit('#'+id);
    }); 
    
    jQuery(document).on('mouseenter','[data-class="tb-tooltip-data"]',function(e){
        let id  = jQuery(this).attr('id');
        tooltipInit('#'+id);
    }); 
    

    // NOTIFICATION
	taskbot_notification_options();
    taskbot_tippy_options();
    // Author checkout page
    
    jQuery('.tb_btn_author').on('click', function (e) {
        StickyAlert(scripts_vars.error_title, scripts_vars.post_author_option, {classList: 'danger', autoclose: 2000});
    });
    if (jQuery(window).width() < 1200 && $isClickedNotify === false) {
        $isClickedNotify  = false;
        jQuery('.tb-notifyheader').addClass('tb-page-link');
    } else {
        jQuery('.tb-notifyheader').removeClass('tb-page-link')
    }
    // Responsive menu
    function collapseMenu(){
        jQuery('.tb-navbarnav:not(.tk-menu-navbarnav) li.menu-item-has-children > a').prepend('<span class="tk-dropdowarrow"><i class="icon-chevron-right"></i></span>');
        jQuery('.tb-navbarnav:not(.tk-menu-navbarnav) li.menu-item-has-children span.tk-dropdowarrow').on('click', function() {
            jQuery(this).parent().toggleClass('tk-menuopen');
            jQuery(this).parent().next().slideToggle(300);
        });
    }
    collapseMenu();

    // Submit proposal 
    jQuery('.tb_submit_task').on('click',function () {
        let _this           = jQuery(this);
        let status          = _this.data('type');
        let project_id      = _this.data('project_id');
        let proposal_id     = _this.data('proposal_id');
        var _serialize      = jQuery('#tasbkot-submit-proposal').serialize();
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action'    : 'taskbot_submit_proposal',
                'security'  : scripts_vars.ajax_nonce,
                'project_id': project_id,
                'proposal_id': proposal_id,
                'status'    : status,
                'data'      : _serialize,
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {
                    StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 1000});
                   window.location.replace(response.redirect);
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
        
    });

    //Newsletter form submit 
	jQuery(document).on('click', '.subscribe_me', function (event) {
        event.preventDefault();
        var _this = jQuery(this);
        jQuery('body').append(loader_html);
		
        jQuery.ajax({
            type: 'POST',
            url: scripts_vars.ajaxurl,
            data: 'security='+scripts_vars.ajax_nonce+'&'+_this.parents('form').serialize() + '&action=taskbot_subscribe_mailchimp',
            dataType: "json",
            success: function (response) {
            	jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {                	
                    StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 1000});
                } else {                	                
                	StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});               
                }
            }
        });
    });

    //Update mailchimp list
	jQuery(document).on('click', '.tb-latest-mailchimp-list', function(event) {
		event.preventDefault();
		var dataString = 'security='+scripts_vars.ajax_nonce+'&action=taskbot_mailchimp_array';
		
		var _this = jQuery(this);
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			dataType:"json",
			data: dataString,
			success: function(response) {
				jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
				window.location.reload();
			}
		});
	});
    
    //page redirect
    jQuery('.tb-page-link').on('click',function () {
        let page_url    = jQuery(this).data('url');
        window.location.href = page_url;
    });

    //page redirect
    jQuery('.tb-redirect-url').on('click',function () {
        StickyAlert(scripts_vars.apply_now, scripts_vars.login_required_apply, {classList: 'danger', autoclose: 5000});
    });

    //Delay in time while typing
    function TBdelayTime(callback, timer) {
        var delayTime = 0;

        return function() {
          var context   = this; 
          var args      = arguments;
          clearTimeout(delayTime);
          
          delayTime = setTimeout(function () {
            callback.apply(context, args);
          }, timer || 0);
        };
    }

    // price calculation
    jQuery('input.tb_proposal_price').on('keyup change',TBdelayTime(function(e){
        let _this       = jQuery(this);
        let post_id     = _this.data('post_id');
        let price       = _this.val();
        jQuery('.tb-input-price').addClass('tb-input-loader');
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action'		: 'taskbot_calculate_price',
                'security'		: scripts_vars.ajax_nonce,
                'post_id'	    : post_id,
                'price'		    : price,
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-input-price').removeClass('tb-input-loader');
                if (response.type === 'success') {
                    jQuery('#tb_total_rate').html(response.price);
                    jQuery('#tb_service_fee').html(response.admin_shares);
                    jQuery('#tb_user_share').html(response.user_shares);
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    },500));

    //toggle two classes on mobile menu
    jQuery('.tb_user_profile').on('click',function () {
        jQuery('.tb-user-menu').toggleClass('tb-opendbmenu');
    });
    //toggle div on mobile menu
    jQuery('.tk-filtericon').on('click',function () {
        jQuery('.tk-searchlist').slideToggle(300);
        jQuery('.tk-mt0').toggleClass('tk-mt');

    });
    //toggle two classes on mobile menu
    jQuery('.tb-login-user').on('click',function () {
        StickyAlert(scripts_vars.error_title, scripts_vars.login_required, {classList: 'danger', autoclose: 5000});
    });

    jQuery('.tb-login-seller').on('click',function () {
        StickyAlert(scripts_vars.error_title, scripts_vars.login_required_apply, {classList: 'danger', autoclose: 5000});
    });
    jQuery('.tb-authorization-required').on('click',function () {
        StickyAlert(scripts_vars.error_title, scripts_vars.post_author_option, {classList: 'danger', autoclose: 5000});
    });

    //Download files
    jQuery('.tb_download_files').on('click',function(e){
        let product_id			= jQuery(this).data('id');
        let order_id			= jQuery(this).data('order_id');
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action'		: 'taskbot_download_zip_file',
                'security'		: scripts_vars.ajax_nonce,
                'product_id'	: product_id,
                'order_id'		: order_id,
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();

                if (response.type === 'success') {
                    window.location = response.attachment;
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    });

     // Send message
     jQuery('.tb_sent_msg_task').on('click', function (e) {
        var reciver_id    = $(this).data('reciver_id');
        var _message    = $('#tb_message').val();
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_send_user_msg',
                'security': scripts_vars.ajax_nonce,
                'reciver_id': reciver_id,
                'message' : _message
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {
                    StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 2000});
                    window.setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 2000);
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    });

    // Send message on task detail
    jQuery('.tb_sentmsg_task').on('click', function (e) {
        var _post_id    = $(this).data('post_id');
        var _message    = $('#tb_message').val();
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_send_message',
                'security': scripts_vars.ajax_nonce,
                'post_id': _post_id,
                'message' : _message
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {
                    StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 2000});
                    window.setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 2000);
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    });

    jQuery('.tb_proposal_chat').on('click', function (e) {
        var _post_id    = $(this).data('reciver_id');
        jQuery('body').append(loader_html);

        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'wp_guppy_start_chat',
                'security': scripts_vars.ajax_nonce,
                'post_id': _post_id
            },
            dataType: "json",
            success: function (response) {
                if (response.type === 'success') {
                    window.setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 2000);
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    });

    // update switch user
	$(document).on('click', '.tb_switch_user', function (e) {
		$('body').append(loader_html);
		let _this		= $(this);
		let id			= _this.data('id');
		jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: {
				'action'	: 'taskbot_switch_user_settings',
				'security'	: scripts_vars.ajax_nonce,
				'id'		: id
			},
			dataType: "json",
			success: function (response) {
				jQuery('.tb-preloader-section').remove();
				if (response.type === 'success') {
					StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 5000});
					location.reload();
				} else {
					StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
				}
			}
		});
	});

    // Checkout page
    jQuery('.tb_btn_checkout').on('click', function (e) {
        var _type = $(this).data('type');
        var _url = $(this).data('url');
        if (scripts_vars.user_type == '' || scripts_vars.user_type == null || scripts_vars.user_type == undefined) {
            jQuery('body').append(loader_html);
            jQuery.ajax({
                type: "POST",
                url: scripts_vars.ajaxurl,
                data: {
                    'action': 'taskbot_redirect_page',
                    'security': scripts_vars.ajax_nonce,
                    'type': _type,
                    'page_url': _url,
                },
                dataType: "json",
                success: function (response) {
                    jQuery('.tb-preloader-section').remove();
                    if (response.type === 'success') {
                        StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 2000});
                        window.setTimeout(function () {
                            if(scripts_vars.view_type === 'popup' ){
                                jQuery('#tk-signup-model').modal('show');
                            } else {
                                window.location.href = response.redirect;
                            }
                        }, 2000);
                    } else {
                        StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                    }
                }
            });
        } else if (scripts_vars.user_type != 'buyers') {
            StickyAlert(scripts_vars.error_title, scripts_vars.only_buyer_option, {
                classList: 'danger',
                autoclose: 2000
            });
        } else {
            window.location.href = _url;
        }
    });

    // Post a tag without login
    jQuery('#tk_post_task').on('click', function (e) {
        var _type = $(this).data('type');
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_redirect_page',
                'security': scripts_vars.ajax_nonce,
                'type': _type,
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {
                    if(scripts_vars.view_type === 'popup' ){
                        jQuery('#tk-signup-model').modal('show');
                    } else {
                        window.location.href = response.redirect;
                    }
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    });

    // Get categories
    jQuery(document).on('change', '.tb-top-service-task-option', function (e) {
        let _this   = $(this);
        let id      = _this.val();
        jQuery('#task_search_tb_parent_category').append('<span class="form-loader"><i class="fas fa-spinner fa-spin"></i></span>');
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_task_search_get_terms',
                'security': scripts_vars.ajax_nonce,
                'id': id,
                'option' : 'title'
            },
            dataType: "json",
            success: function (response) {
                jQuery('#task_search_tb_parent_category span.form-loader').remove();
                if (response.type === 'success') {
                    jQuery('#task_search_tb_sub_category').html(response.categories);
                    jQuery('#task_search_tb_category_level3').html('');
                    if ( $.isFunction($.fn.select2) ) {
                        jQuery('#tb-top-service-task-option-level-2').select2({
                            placeholder: {
                                id: '', // the value of the option
                                text: scripts_vars.select_sub_category
                            },
                            allowClear: true
                        });

                        jQuery('#tb-top-service-task-option-level-2').on('select2:open', function (e) {
                            jQuery('input.select2-search__field').prop('placeholder', scripts_vars.search_sub_category);
                        });
                    }
                } else {
                    jQuery('#task_search_tb_sub_category').html();
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 50000});
                }
            }
        });
    });

    // Get categories
    jQuery(document).on('change', '.tb-top-service-task-search', function (e) {
        let _this   = $(this);
        let id      = _this.val();
        jQuery('#task_search_tb_parent_category').append('<span class="form-loader"><i class="fas fa-spinner fa-spin"></i></span>');
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_task_search_get_terms',
                'security': scripts_vars.ajax_nonce,
                'id': id
            },
            dataType: "json",
            success: function (response) {
                jQuery('#task_search_tb_parent_category span.form-loader').remove();
                if (response.type === 'success') {
                    jQuery('#task_search_tb_sub_category').html(response.categories);
                    jQuery('#task_search_tb_category_level3').html('');
                    if ( $.isFunction($.fn.select2) ) {
                        jQuery('#tb-top-service-task-search-level-2').select2({
                            placeholder: {
                                id: '', // the value of the option
                                text: scripts_vars.select_sub_category
                            },
                            allowClear: true
                        });

                        jQuery('#tb-top-service-task-search-level-2').on('select2:open', function (e) {
                            jQuery('input.select2-search__field').prop('placeholder', scripts_vars.search_sub_category);
                        });
                    }
                } else {
                    jQuery('#task_search_tb_sub_category').html();
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 50000});
                }
            }
        });
    });

    jQuery(document).on('click', '.tb_view_rating', function (e) {
        let rating_id		= jQuery(this).data('rating_id');

        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: 'POST',
            url: scripts_vars.ajaxurl,
            data: {
                'action'		: 'taskbot_tk_rating_view',
                'security'		: scripts_vars.ajax_nonce,
                'rating_id'		: rating_id,
            },
            dataType: 'json',
            success: function (response) {
                jQuery('.tb-preloader-section').remove();

                if (response.type === 'success') {
                    jQuery('#tb_tk_viewrating').html(response.html);
                    jQuery('#tb_excfreelancerpopup').modal('show');
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });

    });

    jQuery(document).on('click', '.tk-login-poup', function (e) {
        taskbotHideRegModel();
        jQuery('#tk-login-model').modal('show');
    });

    jQuery(document).on('click', '.tk-signup-poup-btn', function (e) {
        taskbotHideRegModel();
        jQuery('#tk-signup-model').modal('show');
    });
    
    jQuery(document).on('click', '.tk-pass-poup-btn', function (e) {
        taskbotHideRegModel();
        jQuery('#tk-pass-model').modal('show');
    });
    if(scripts_vars.enable_state){
        jQuery(document).on('change', '#tklocation #task_location', function (e) {
            let country_val= jQuery('#tklocation #task_location option:selected').val();
            if(country_val){
                jQuery.ajax({
                    type: "POST",
                    url: scripts_vars.ajaxurl,
                    data: {
                        'action': 'taskbot_get_states',
                        'security': scripts_vars.ajax_nonce,
                        'country_val': country_val
                    },
                    dataType: "json",
                    success: function (response) {
                        if(response.states > 0){
                            jQuery('.tb-state-parent').removeClass('d-sm-none');
                            jQuery('.tb-country-state').find('option').not(':first').remove()
                            jQuery('.tb-country-state').append(response.states_html);
                        } else {
                            jQuery('.tb-state-parent').addClass('d-sm-none');
                        }
                    }
                });
            }
        });
        jQuery(document).on('change', '#service-introduction-form #tb_country', function (e) {
            let country_val= jQuery('#service-introduction-form #tb_country option:selected').val();
            if(country_val){
                jQuery.ajax({
                    type: "POST",
                    url: scripts_vars.ajaxurl,
                    data: {
                        'action': 'taskbot_get_states',
                        'security': scripts_vars.ajax_nonce,
                        'country_val': country_val
                    },
                    dataType: "json",
                    success: function (response) {
                        if(response.states > 0){
                            jQuery('.tb-state-parent').removeClass('d-sm-none');
                            jQuery('.tb-country-state').find('option').not(':first').remove()
                            jQuery('.tb-country-state').append(response.states_html);
                        } else {
                            jQuery('.tb-state-parent').addClass('d-sm-none');
                        }
                    }
                });
            }
        });
        jQuery(document).on('change', 'select[name="country"]', function (e) {
            let country_val= jQuery('select[name="country"] option:selected').val();
            if(country_val){
                jQuery.ajax({
                    type: "POST",
                    url: scripts_vars.ajaxurl,
                    data: {
                        'action': 'taskbot_get_states',
                        'security': scripts_vars.ajax_nonce,
                        'country_val': country_val
                    },
                    dataType: "json",
                    success: function (response) {
                        if(response.states > 0){
                            jQuery('.tb-state-parent').removeClass('d-sm-none');
                            jQuery('.tb-country-state').find('option').not(':first').remove()
                            jQuery('.tb-country-state').append(response.states_html);
                        } else {
                            jQuery('.tb-state-parent').addClass('d-sm-none');
                        }
                    }
                });
            }
        });
        /* add state in dashboard billing information */
        jQuery(document).on('change', 'select[name="billing[billing_country]"]', function (e) {
            let country_val= jQuery('select[name="billing[billing_country]"] option:selected').val();
            if(country_val){
                jQuery('body').append(loader_html);
                jQuery.ajax({
                    type: "POST",
                    url: scripts_vars.ajaxurl,
                    data: {
                        'action': 'taskbot_get_states',
                        'security': scripts_vars.ajax_nonce,
                        'country_val': country_val
                    },
                    dataType: "json",
                    success: function (response) {
                        jQuery('.tb-preloader-section').remove();
                        if(response.states > 0){
                            jQuery('.tb-state-parent').removeClass('d-sm-none');
                            jQuery('.tb-country-state').find('option').not(':first').remove()
                            jQuery('.tb-country-state').append(response.states_html);
                        } else {
                            jQuery('.tb-state-parent').addClass('d-sm-none');
                        }
                    }
                });
            }
        });
    }
    // Get services
    jQuery(document).on('change', '#tb-top-service-task-option-level-2', function (e) {
        let _this = $(this);
        let id = _this.val();
        jQuery('#sub_category_container').append('<span class="form-loader"><i class="fas fa-spinner fa-spin"></i></span>');
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_task_search_get_terms_subcategories',
                'security': scripts_vars.ajax_nonce,
                'id': id,
                'option' : 'title'
            },
            dataType: "json",
            success: function (response) {
                if (response.type === 'success') {
                    jQuery('#sub_category_container span.form-loader').remove();
                    jQuery('#task_search_tb_category_level3').html(response.terms_html);
                    var tk_categoriesfilter = document.querySelector(".tk-categoriesfilter");
                    if (tk_categoriesfilter !== null) {
                        tk_categoriesfilter = {
                            collapsedHeight: 180,
                            moreLink: '<a href="javascript:void(0);" class="tb-readmorebtn">'+scripts_vars.show_more+'</a>',
                            lessLink: '<a href="javascript:void(0);" class="tb-readmorebtn">'+scripts_vars.show_less+'</a>',
                        };
                        $('.tk-categoriesfilter').readmore(tk_categoriesfilter);
                    }
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    });

    // Get services
    jQuery(document).on('change', '#tb-top-service-task-search-level-2', function (e) {
        let _this = $(this);
        let id = _this.val();
        jQuery('#sub_category_container').append('<span class="form-loader"><i class="fas fa-spinner fa-spin"></i></span>');
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_task_search_get_terms_subcategories',
                'security': scripts_vars.ajax_nonce,
                'id': id
            },
            dataType: "json",
            success: function (response) {
                if (response.type === 'success') {
                    jQuery('#sub_category_container span.form-loader').remove();
                    jQuery('#task_search_tb_category_level3').html(response.terms_html);
                    var tk_categoriesfilter = document.querySelector(".tk-categoriesfilter");
                    if (tk_categoriesfilter !== null) {
                        tk_categoriesfilter = {
                            collapsedHeight: 180,
                            moreLink: '<a href="javascript:void(0);" class="tb-readmorebtn">'+scripts_vars.show_more+'</a>',
                            lessLink: '<a href="javascript:void(0);" class="tb-readmorebtn">'+scripts_vars.show_less+'</a>',
                        };
                        $('.tk-categoriesfilter').readmore(tk_categoriesfilter);
                    }
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    });

    // Registration
    jQuery(document).on('click', '.tb-signup-now', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var _serialized = jQuery('#userregistration-from').serialize();
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_registeration',
                'security': scripts_vars.ajax_nonce,
                'data': '&' + _serialized,
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {
                    StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 5000});
                    window.location.replace(response.redirect);
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    });

    // Login Ajax
    jQuery(document).on('click', '.tb-signin-now', function (event) {
        event.preventDefault();
        var _this = jQuery(this);
        var _serialize = _this.parents('form.tb-formlogin').serialize();
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_signin',
                'security': scripts_vars.ajax_nonce,
                'data': _serialize,
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {
                    StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 5000});
                    window.location.replace(response.redirect);
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    });

    // Forgot password ajax
    jQuery(document).on('click', '.btn-forget-pass', function (event) {
        event.preventDefault();
        var _this = jQuery(this);
        var _serialize = _this.parents('form.tb-forgot-password-form').serialize();
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_forgot',
                'security': scripts_vars.ajax_nonce,
                'data': _serialize,
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {
                    StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 5000});
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    });

    // Reset password ajax
    jQuery(document).on('click', '.btn-reset-pass', function (event) {
        event.preventDefault();
        var _this = jQuery(this);
        jQuery('body').append(loader_html);
        var _serialize = _this.parents('form.tb-forgot-password-form').serialize();

        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_reset',
                'security': scripts_vars.ajax_nonce,
                'data': _serialize,
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {
                    StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 5000});
                    window.location.replace(response.redirect_url);
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    });

    // Show password
    jQuery(document).on('click', '.password-hide-show', function (event) {
        event.preventDefault();
        var pass_type = document.getElementById("user_password");
        if (pass_type.type === "password") {
            pass_type.type = "text";
        } else {
            pass_type.type = "password";
        }
    });

    // Re send email verification link
    jQuery(document).on('click', '.re-send-email', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        var dataString = 'security=' + scripts_vars.ajax_nonce + '&action=taskbot_resend_verification';
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {
                    StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 5000});
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    });

    // Contact and question page
    jQuery(document).on('submit', '#questions_form', function (e) {
        e.preventDefault();
        let _serialized = $(this).serialize();
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_contact_send_question',
                'security': scripts_vars.ajax_nonce,
                'data': _serialized,
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {
                    StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 5000});
                    window.location.reload();
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    });

    // Update billing information
    jQuery(document).on('click', '#tb_submit_fund', function (e) {
        let _this = $(this);
        let _url = document.location.href;
        let wallet_amount = jQuery('#tb_wallet_amount').val();
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_wallet_checkout',
                'security': scripts_vars.ajax_nonce,
                'wallet_amount': wallet_amount,
                'url': _url
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {
                    window.location.replace(response.checkout_url);
                } else {
                    if (response.button){
                        StickyAlertBtn(response.message, response.message_desc, {classList: 'danger', autoclose: 5000,button:response.button});
                    } else {
                        StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                    }
                }
            }
        });
    });
    
    // compare packages
    jQuery(document).on('click', '.tb-recommend', function (event) {
        event.preventDefault();
        var target = $('#taskbot-price-plans');
        if (target.length) {
            $('html,body').animate({
                scrollTop: target.offset().top
            }, 200);
            return false;
        }
    });

    // Task buy package
    jQuery('.tb-buy-package').on('click', function (e) {
        let package_id = jQuery(this).data('package_id');
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_package_checkout',
                'security': scripts_vars.ajax_nonce,
                'package_id': package_id,
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {
                    window.location.replace(response.checkout_url);
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    });
    
    // Task add cart button
    jQuery('#tb_btn_cart').on('click', function (e) {
        /* getting checked subtasks */
        var subtask_checked_values = [];
        jQuery("input.tb_subtask_check:checked").each(function () {
            subtask_checked_values.push($(this).val());
        });
        let wallet = jQuery('#tb_wallet_option:checked').val() ? 1 : 0;
        let _serialized = jQuery('#tb_cart_form').serialize();
        let id = jQuery(this).data('id');
        let dataString = _serialized + '&id=' + id + '&subtasks=' + subtask_checked_values;
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_service_checkout',
                'security': scripts_vars.ajax_nonce,
                'data': dataString,
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {
                    window.location.replace(response.checkout_url);
                } else {
                    if (response.button){
                        StickyAlertBtn(response.message, response.message_desc, {classList: 'danger', autoclose: 5000,button:response.button});
                    } else {
                        StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                    }
                }
            }
        });
    });

    // Task order status change
    jQuery('.tb_project_task').on("change", function () {
        let task_key = jQuery('.tb_project_task').find('option:selected').val();
        jQuery('.tb-product-package').addClass('d-none');
        jQuery('#tb-pkg-' + task_key).removeClass('d-none');
        taskbot_totlaprice();
    });

    // Subtask update price and toggle
    jQuery('.tb_subtask_check').on("change", function () {
        let _this = jQuery(this);
        let id = _this.data('id');

        if (_this.prop('checked') == true) {
            jQuery('#additionalservice-list-' + id).prop("checked", true);
            _this.closest('li').addClass('tk-services-checked');
        } else {
            jQuery('#additionalservice-list-' + id).prop("checked", false);
            _this.closest('li').removeClass('tk-services-checked');
        }

        taskbot_totlaprice();
        jQuery("#tb-fixsidebar").css("display", "block");
        jQuery(".tb-fixsidebar").toggleClass("tb-fixsidebarshow");
    });

    // Get child element text parrent text
    jQuery(document).on('click', '.tk-pakagelist li', function (e) {
        e.preventDefault();
        let _this = jQuery(this);
        let package_key = _this.data('package_key');
        let pkg_img = _this.data('img');
        jQuery("#tb_project_task_key").attr("data-task_key", package_key);
        jQuery("#tb_project_task_key").val(package_key);

        var title = jQuery(this).find('span').text();
        var price = jQuery(this).find('em').text();

        jQuery('.tk-pakagedetail .tk-pakageinfo h6').html(title);
        jQuery('.tk-pakagedetail .tk-pakageinfo h4').html(price);

        if (jQuery(this).hasClass('active')) {
            jQuery(this).removeClass('active');
        } else {
            jQuery('.tk-pakagelist li').removeClass('active');
            jQuery(this).addClass('active');
        }
        taskbot_totlaprice();
        jQuery('#tb_pkg_image').attr('src', pkg_img);
    });

    // Task hired click
    jQuery('.tb_hired_btn').on('click', function (e) {
        let _this = jQuery(this);
        let id = _this.data('id');
        jQuery('#tb-op-' + id).attr("selected", "selected");
        jQuery("#tb-fixsidebar").css("display", "block");
        jQuery(".tb-fixsidebar").toggleClass("tb-fixsidebarshow");
        taskbot_totlaprice();
    });

    // Subtask update price and toggle
    jQuery('.tb_subtasks').on("change", function () {
        let _this = jQuery(this);
        let id = _this.data('id');
        if (_this.prop('checked') == true) {
            jQuery('#additionalservice-' + id).prop("checked", true);
        } else {
            jQuery('#additionalservice-' + id).prop("checked", false);
        }
        taskbot_totlaprice();
        jQuery("#tb-fixsidebar").css("display", "block");
        jQuery(".tb-fixsidebar").toggleClass("tb-fixsidebarshow");
    });

    // Total Price
    function taskbot_totlaprice() {

        let task_id = jQuery('#tb_task_cart').data('task_id');
        let task_key = jQuery('#tb_project_task_key').val();
        let sub_tasks = [];
        let sub_tasks_html = '';
        var task_selected_html = '';
        var processing_fee_html = '';
        var boxes = jQuery('.tb_subtask_check:checked');
        jQuery('body').append(loader_html);

        boxes.each(function () {
            sub_tasks.push(jQuery(this).val());
            sub_tasks_html += '<li><span>' + jQuery(this).data('title') + '</span><em>(' + jQuery(this).data('price') + ')</em></li>';
        });

        var url = scripts_vars.tpl_dashboard;
        var params = {'key': task_key, 'ref': 'cart', 'id': task_id, 'sub_tasks': sub_tasks};
        var new_url = url + '?' + jQuery.param(params);
        history.pushState({}, null, new_url);

        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_get_tasks_total',
                'security': scripts_vars.ajax_nonce,
                'task_id': task_id,
                'task_key': task_key,
                'sub_tasks': sub_tasks
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();
                if (response.type === 'success') {
                    jQuery('#tk-pakagedetail').collapse('hide');
                    jQuery('#tb_package_price').html(response.task_price);
                    task_selected_html = '<li><span>' + response.task_title + '</span><em>(' + response.task_price + ')</em></li>';
                    
                    if(response.processing_fee_val > 0){
                        processing_fee_html = '<li><span>' + response.processing_fee_title + '</span><em>(' + response.processing_fee + ')</em></li>';
                    }

                    jQuery('#tb-planlist').html(task_selected_html + sub_tasks_html+processing_fee_html);
                    jQuery('#tb_task_total').html(response.totalPrice);
                    jQuery('.tk-mainlistvtwo').addClass('d-none');
                    jQuery('#tb-pkg-'+task_key).removeClass('d-none');

                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    }

    // Task budget
    jQuery('.tb-tasktotalbudget .close').on('click', function (e) {
        $("#overlay").css("display", "none");
        $(".tb-fixsidebar").toggleClass("tb-fixsidebarshow");
    });

    // Add to saved items
    jQuery(document).on('click', '.tb_saved_items', function (e) {
        let _this = $(this);
        let id = _this.data('id');
        let post_id = _this.data('post_id');
        let type = _this.data('type');
        let action = _this.data('action');
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_saved_items',
                'security': scripts_vars.ajax_nonce,
                'id': id,
                'post_id': post_id,
                'type': type,
                'option': action
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();

                if (response.type === 'success') {
                    StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 5000});
                    _this.addClass('bg-heart');
                    window.location.reload();
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                    _this.removeClass('bg-heart');
                }
            }
        });
    });
    
    // Add to saved items
    jQuery(document).on('click', '.tb_read_notification', function (e) {
        let _this       = jQuery(this);
        let post_id     = _this.data('post_id');
        
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: {
                'action': 'taskbot_update_notifications',
                'security': scripts_vars.ajax_nonce,
                'post_id': post_id
            },
            dataType: "json",
            success: function (response) {
                jQuery('.tb-preloader-section').remove();

                if (response.type === 'success') {
                    _this.remove();
                    jQuery('.tb_notify_'+post_id).removeClass('tk-noti-unread');
                    let count_number    = parseInt(jQuery('.tk-remaining-notification').html());
                    jQuery('.tk-remaining-notification').html(count_number-1);
                } 
            }
        });
    });
    //show hide tags
    jQuery('.tb-selected__showmore a').on('click', function(){
        jQuery(this).closest('ul').children().removeClass('d-none')
        jQuery(this).closest('li').addClass('d-none')
    });

    // Make drop-down select2
    if ( $.isFunction($.fn.select2) ) {

        jQuery('.tb-select select').select2();

        // Make dashboard country drop down select2
        jQuery('.tb-select-country select').select2();

        // Make category drop-down select2
        jQuery('#tb_order_type').select2({
            width:'200',
            minimumResultsForSearch: Infinity,

        });
        jQuery('#tb_order_type').on('select2:open', function (e) {
            jQuery('.select2-results__options').mCustomScrollbar('destroy');
            
            setTimeout(function () {
                jQuery('.select2-results__options').mCustomScrollbar();
            }, 0);
        });
        // Make drop-down select2
        jQuery('#tb_country', '#category', '#select_location').select2();

        // Make sub category drop-down select2 on search
        jQuery('#tb-top-service-task-search-level-2').select2({
            placeholder: {
                id: '', // the value of the option
                text: scripts_vars.select_sub_category
            },
            allowClear: true
        });

        // Add place holder in select search element
        jQuery('#tb-top-service-task-search-level-2').on('select2:open', function (e) {
            jQuery('input.select2-search__field').prop('placeholder', scripts_vars.search_sub_category);
        });

         // Make sub category drop-down select2 on search
         jQuery('#tb-top-service-task-option-level-2').select2({
            placeholder: {
                id: '', // the value of the option
                text: scripts_vars.select_sub_category
            },
            allowClear: true
        });

        // Add place holder in select search element
        jQuery('#tb-top-service-task-option-level-2').on('select2:open', function (e) {
            jQuery('input.select2-search__field').prop('placeholder', scripts_vars.search_sub_category);
        });

        // Make category drop-down select2 on search task
        jQuery('#task_category').select2({
            minimumResultsForSearch: Infinity,
            placeholder: {
                id: '-1', // the value of the option
                text: scripts_vars.select_category
            },
            allowClear: true
        });
        jQuery('#task_location').select2({
            placeholder: {
                id: '-1', // the value of the option
                text: scripts_vars.select_location
            },
            allowClear: true
        });

        jQuery('#tk-search-state').select2({
            placeholder: {
                id: '-1', // the value of the option
                text: scripts_vars.select_state
            },
            allowClear: true
        });
        // Make category drop-down select2 on add service
        jQuery('#tb-top-service').select2({
            placeholder: {
                id: '', // the value of the option
                text: scripts_vars.choose_category
            },
            allowClear: true
        });

        // Add place holder in select search element
        jQuery('#tb-top-service').on('select2:open', function (e) {
            jQuery('input.select2-search__field').prop('placeholder', scripts_vars.search_category);
        });

        // Make sub category drop-down select2 on add service
        jQuery('#tb-service-level2').select2({
            placeholder: {
                id: '', // the value of the option
                text: scripts_vars.choose_sub_category
            },
            allowClear: true
        });

        // Add place holder in select search element
        jQuery('#tb-service-level2').on('select2:open', function (e) {
            jQuery('input.select2-search__field').prop('placeholder', scripts_vars.search_sub_category);
        });

         // Make search sort drop-down select2
        $("#tb-sort").select2({
            width: '196' ,
            minimumResultsForSearch: Infinity,
            dropdownAutoWidth:true,
        });

        jQuery('.tb-select select[multiple]').select2({
            multiple: true,
            placeholder: scripts_vars.select_option
        });

        // Make invoice sort drop-down select2
        $("#tb-invoice-sort").select2({
            width: '196' ,
            minimumResultsForSearch: Infinity,
            dropdownAutoWidth:true,
        });

        // Make withdeaw sort drop-down select2
        $("#tb-withdraw-sort").select2({
            width: '196' ,
            minimumResultsForSearch: Infinity,
            dropdownAutoWidth:true,
        });

        //Select2 placeholder
        jQuery('.tb-select [data-placeholderinput], .tk-select [data-placeholderinput]').each(function (item) {
            var data_placeholder = jQuery('[data-placeholderinput]')[item]
            var tk_id = jQuery(data_placeholder).attr('id')
            var tk_placeholder = jQuery(data_placeholder).attr('data-placeholderinput')
            jQuery('#' + tk_id).on('select2:open', function (e) {
                jQuery('input.select2-search__field').prop('placeholder', tk_placeholder);
            });
        });

        //Select2 dropdown scrollbar
        jQuery('.tb-select select, .tk-select select').on('select2:open', function (e) {
            jQuery('.select2-results__options').mCustomScrollbar('destroy');
            
            setTimeout(function () {
                jQuery('.select2-results__options').mCustomScrollbar();
            }, 0);
        });
        //Select2 placeholder
        jQuery('.tb-select-country [data-placeholderinput]').each(function (item) {
            var data_placeholder = jQuery('[data-placeholderinput]')[item]
            var tk_id = jQuery(data_placeholder).attr('id')
            var tk_placeholder = jQuery(data_placeholder).attr('data-placeholderinput')
            jQuery('#' + tk_id).on('select2:open', function (e) {
                jQuery('input.select2-search__field').prop('placeholder', tk_placeholder);
            });
        });

        //Select2 dropdown scrollbar
        jQuery('.tb-select-country select,.tk-select select').on('select2:open', function (e) {
            jQuery('.select2-results__options').mCustomScrollbar('destroy');
            
            setTimeout(function () {
                jQuery('.select2-results__options').mCustomScrollbar();
            }, 0);
        });

        //Select2 dropdown scrollbar
        jQuery('#task_location','#tb_country', '#task_category', '#tb-sort','.tk-select select').on('select2:open', function (e) {
            jQuery('.select2-results__options').mCustomScrollbar('destroy');
            
            setTimeout(function () {
                jQuery('.select2-results__options').mCustomScrollbar();
            }, 0);
        });
        
    }

    // Input asteric
    jQuery('.tk-placeholder').on('click', function (e) {
        jQuery(this).siblings('.form-control').focus();
        e.stopPropagation();
    });
    
    jQuery('.tk-propsal-list-show').on("click", function(){
        jQuery('.tk-prouserslist').slideToggle(300);
        jQuery('.tk-prouserslist').mCustomScrollbar('destroy');
        setTimeout(function () {
            jQuery('.tk-prouserslist').mCustomScrollbar();
        }, 2000);
    })

    // Earning page payout methods
    jQuery(".tb-radioholder").on("click", function (e) {
        let key         = jQuery(this).attr('data-key');
        jQuery('.tb-li_payouts-'+key).addClass("tb-radio-checked");
        jQuery(this).closest(".tb-payoutmethodholder").addClass("tb-slide");
        jQuery(this).closest(".tb-radiobox").children(".tb-steppaypal").addClass("tb-slidecontent");
        e.stopPropagation();
    });

    //Dashboard paypal payout click
    jQuery(".tb-paypalcontent").on("click", function (e) {
        jQuery(this).closest(".tb-asideholder").children(".tb-payoutmethodwrap").children().removeClass("tb-banktitle");
        jQuery(this).closest(".tb-asideholder").children(".tb-payoutmethodwrap").children(".tb-paypaltitle").addClass("tb-banktitle");
        e.stopPropagation();
    });

    // Dashboard stripe payout
    jQuery("#tb-stripecontent").on("click", function (e) {
        jQuery(this).closest(".tb-asideholder").children(".tb-payoutmethodwrap").children().removeClass("tb-banktitle");
        jQuery(this).closest(".tb-asideholder").children(".tb-payoutmethodwrap").children(".tb-stripetilte").addClass("tb-banktitle");
        e.stopPropagation();
    });

    // Dashboard bank acount payout
    jQuery("#tb-bankcontent").on("click", function (e) {
        jQuery(this).closest(".tb-asideholder").children(".tb-payoutmethodwrap").children().removeClass("tb-banktitle");
        jQuery(this).closest(".tb-asideholder").children(".tb-payoutmethodwrap").children(".tb-banktransfertitle").addClass("tb-banktitle");
        e.stopPropagation();
    });

    // Dashboard button click
    jQuery(".tb-btnplain").on("click", function (e) {
        let selectedkey = jQuery(this).attr('data-selectedkey');
        if (selectedkey == '' || selectedkey == null || selectedkey == undefined) {
            let key = jQuery(this).attr('data-key');
            jQuery('#payrols-'+key).attr("checked", false);
            jQuery('.tb-li_payouts-'+key).removeClass("tb-radio-checked");
            
        }
        jQuery(this).closest(".tb-slide").removeClass("tb-slide");
        jQuery(this).closest(".tb-slidecontent").removeClass("tb-slidecontent");
        jQuery(this).closest(".tb-asideholder").children(".tb-payoutmethodwrap").children().removeClass("tb-banktitle");
        jQuery(this).closest(".tb-asideholder").children(".tb-payoutmethodwrap").children(".tb-bankpayouttitle").addClass("tb-banktitle");
        e.stopPropagation();
    });

    // Package title active class
    jQuery(".tb-sidebartabs__pkgtitle .nav-item").on("click", function (e) {
        jQuery(this).siblings('').removeClass('tb-sideactive');
        jQuery(this).addClass('tb-sideactive');
        e.stopPropagation();
    });

    // Display message
    jQuery('.tb-messagelist__name a').on('click', function (e) {
        jQuery(this).closest('.tb-message').addClass('tb-messageopen');
        e.stopPropagation();
    });

    // Display message
    jQuery('.tb-messageuserabove__back').on('click', function (e) {
        jQuery(this).closest('.tb-message').removeClass('tb-messageopen');
        e.stopPropagation();
    });

    // Prevent collapse range slider
    jQuery('.tb-rangevalue').on('click', function (e) {
        e.stopPropagation();
        jQuery('#tb-rangecollapse').collapse('show');
    });

    // Prevent collapse
    jQuery('#tb-rangecollapse, .tb-distance').on('click', function (e) {
        e.stopPropagation();
    });

    // Prevent collapse
    jQuery(document).on('click', 'body', function (e) {
        jQuery('#tb-rangecollapse').collapse('hide');
        e.stopPropagation();
    });

    // submit search on keyword field submit
    jQuery(document).on('click', '.tk-search-icon', function (e) {
        jQuery('#tb_sort_form').submit();
        e.stopPropagation();
    });

    // Task search range input validation
    jQuery(document).on('click','#taskbot_apply_filter',function(e){
        e.preventDefault();
        let min_price = jQuery('input#tb_amount_min').val();
        let max_price = jQuery('input#tb_amount_max').val();

        if (min_price && max_price){
            if (parseInt(min_price) > parseInt(max_price)){
                StickyAlert(scripts_vars.price_min_max_error_title, scripts_vars.price_min_max_error_desc, {classList: 'danger', autoclose: 5000});
                return false;
            }
        }

        jQuery('#tb_sort_form').submit();
    });

    jQuery('.tk-togglebtmmenu').on('click', function() {
        jQuery(this).next().slideToggle(500);
    });
});

// Alert the notification
function StickyAlert($title = '', $message = '', data) {
    var $icon = 'icon-check';
    var $class = 'dark';

    if (data.classList === 'success') {
        $icon = 'icon-check';
        $class = 'green';
    } else if (data.classList === 'danger') {
        $icon = 'icon-x';
        $class = 'red';
    }

    jQuery.confirm({
        icon: $icon,
        closeIcon: true,
        theme: 'modern',
        animation: 'scale',
        type: $class, //red, green, dark, orange
        title: $title,
        content: $message,
        autoClose: 'close|' + data.autoclose,
        buttons: {
            close: {btnClass: 'tb-sticky-alert'},
        }
    });

    window.setTimeout(function () {
        jQuery(".jconfirm-content").linkify();
    }, 500);
}

// Alert the notification
function StickyAlertBtn($title = '', $message = '', data) {
    var $icon = 'icon-check';
    var $class = 'dark';
    var btntext;
    btntext = data.button.btntext;
    if (data.classList === 'success') {
        $icon = 'icon-check';
        $class = 'green';
    } else if (data.classList === 'danger') {
        $icon = 'icon-x';
        $class = 'red';
    }
    
    jQuery.confirm({
        icon: $icon,
        closeIcon: true,
        theme: 'modern',
        animation: 'scale',
        type: $class, //red, green, dark, orange
        title: $title,
        content: $message,
        autoClose: 'close|' + data.autoclose,
        buttons: {
            close: {btnClass: 'tb-sticky-alert'},
            yes: {
                text: btntext,
                btnClass:data.button.buttonclass,
               action : function() {
                   if(data.button.redirect!=''){
                        window.location.href = data.button.redirect;
                   }
                }
            }
        }
    });

    window.setTimeout(function () {
        jQuery(".jconfirm-content").linkify();
    }, 500);
}
// Confirm before submit
function executeConfirmAjaxRequest(ajax, title = 'Confirm', message = '', loader) {
    $.confirm({
        title: title,
        content: message,
        class: 'blue',
        theme: 'modern',
        animation: 'scale',
        closeIcon: true, // hides the close icon.
        'buttons': {
            'Yes': {
                'btnClass': 'btn-dark tb-yesbtn',
                'text': scripts_vars.yes,
                'action': function () {
                    if (loader) {
                        jQuery('body').append(loader_html);
                    }
                    jQuery.ajax(ajax);
                }
            },
            'No': {
                'text': scripts_vars.no,
                'btnClass': 'btn-default tb-nobtn',
                'action': function () {
                    return true;
                }
            },
        }
    });
}

// Handled sort_by drop filtration in search task search filters form
function merge_search_field() {
    // get the selected option of sort by drop-down
    var selectedOption = jQuery('#tb-sort').find(":selected").val();

    // set selected value in hidden field
    jQuery('#tb_sort_by_filter').val(selectedOption)

    // submit search form
    jQuery('#tb_sort_form').submit();
}
function taskbot_notification_options(){
    jQuery('.tk-notidropdowns > a').on('click',function(e){
        e.stopPropagation();
        let _this               = jQuery(this).next();
        _this.slideToggle();

    });
    jQuery(window).click(function(e) {
        jQuery('.tk-notidropdowns > a').next().slideUp();
    });
}

function taskbot_tippy_options(){
    if(jQuery('.tb_tippy').length > 0){
       //
    }
}

function TaskbotShowMore($key='.tb-description-area'){
    tk_categoriesfilter = {
        collapsedHeight: 150,
        moreLink: '<div class="show-more"><a href="javascript:void(0);" class="tb-readmorebtn">'+scripts_vars.show_more+'</a></div>',
        lessLink: '<div class="show-more"><a href="javascript:void(0);" class="tb-readmorebtn">'+scripts_vars.show_less+'</a></div>',
    };
    jQuery($key).readmore(tk_categoriesfilter);
}

function tooltipTagsInit( selecter) {
    if (typeof tippy === 'function') {
        console.log('tippy', selecter);
        tippy( selecter, {
            allowHTML: true,
            arrow: true,
            theme: 'light',
            animation: 'scale',
            placement: 'top',
            content(reference) {
                const tippycontent = reference.getAttribute('tippy-content');
                if(tippycontent){
                    return template.innerHTML;
                }
                const id = reference.getAttribute('data-template');
                const template = document.getElementById(id);
                return template.innerHTML;
            }
        });
    }    
}


function tooltipInit( selecter) {
    if (typeof tippy === 'function') {
        tippy( selecter, {
            allowHTML: true,
            placement: 'top',
            arrow: true,
            theme: 'taskbot-tippy',
            animation: 'scale',
            interactive: true,
            content(reference) {
                const tippycontent = reference.getAttribute('tippy-content');
                if(tippycontent){
                    return tippycontent;
                }
            }
        });
    }    
}
//MOBILE MENU
function collapseMenu(){
    jQuery('.tb-navbar ul li.menu-item-has-children, .tb-navbar ul li.page_item_has_children, .tb-navdashboard ul li.menu-item-has-children, .tb-navbar ul li.menu-item-has-mega-menu').prepend('<span class="tb-dropdowarrow"><i class="icon-chevron-right"></i></span>');
    
    jQuery('.tb-navbar ul li.menu-item-has-children span,.tb-navbar ul li.page_item_has_children span').on('click', function(e) {
        jQuery(this).parent('li').toggleClass('tb-open');
        jQuery(this).next().next().slideToggle(300);
        e.stopPropagation();

    });
    
    jQuery('.tb-navbar ul li.menu-item-has-children > a, .tb-navbar ul li.page_item_has_children > a').on('click', function(e) {
        if ( location.href.indexOf("#") != -1 ) {
            jQuery(this).parent('li').toggleClass('tb-open');
            jQuery(this).next().slideToggle(300);
            e.stopPropagation();

        } else{
            //do nothing
        }
    });  
}
jQuery(".tk-bidbtn > .tk-invite-bidbtn,.tb-invite-sent").on("click", function(){
    jQuery(this).attr("disabled", "disabled");
    jQuery(this).text("Invitation sent");
})
function taskbotHideRegModel() {
    jQuery('#tk-login-model').modal('hide');
    jQuery('#tk-signup-model').modal('hide');
    jQuery('#tk-pass-model').modal('hide');
}

// range mater collapse
jQuery("#tk-range-wrapper").on("click",function() {
    jQuery("#rangecollapse").collapse("show");
  });

function taskbot_unique_increment(length) {
        let characters      = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        let randomString    = characters.length;
        let rad_num         = '';
        for ( var i = 0; i < length;  i++) {
            rad_num += characters.charAt(Math.floor(Math.random() * 
            randomString));
        }
        return rad_num;
}