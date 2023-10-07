var loader_html	= '<div class="tb-preloader-section"><div class="tb-preloader-holder"><div class="tb-loader"></div></div></div>';
jQuery(document).ready(function($){
	'use strict';
    //convert bytes to KB< MB,GB,TB
	function bytesToSize(bytes) {
		var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
		if (bytes == 0) return '0 Byte';
		var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
		return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
	};

    function removeParam(key, sourceURL) {
		var rtn = sourceURL.split("?")[0],
			param,
			params_arr = [],
			queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
		if (queryString !== "") {
			params_arr = queryString.split("&");
			for (var i = params_arr.length - 1; i >= 0; i -= 1) {
				param = params_arr[i].split("=")[0];
				if (param === key) {
					params_arr.splice(i, 1);
				}
			}
			if (params_arr.length) rtn = rtn + "?" + params_arr.join("&");
		}
		return rtn;
	}

    $(function() {

		//dispute comment reply
        $(document).on('click', '.taskbot-comment-reply', function (e) {
            let comment_id = jQuery(this).data('comment_id');
            jQuery('#parent_comment_id').val(comment_id);
            document.getElementById("dispute_comment").scrollIntoView();
            e.preventDefault();
        });

		//dispute listings status sorting
        $(document).on('change', '.dispute-status-select', function (e) {
			let status = $(this).val();
            var url = window.location.href;
            var url = removeParam("status", url);
            if (url.indexOf('?') > -1){
                url += '&status='+status
            }else{
                url += '?status='+status
            }
            window.location.href = url;
			e.preventDefault();
		});

		//taskbot withdraw submit
		jQuery(document).on('click', '.tb-doownload-withdraw', function(e){
			jQuery('#tb-withdraw-form').submit();
		});

		

		//taskbot update earnings
		jQuery(document).on('click', '.tb-update-earning', function(e){
			let status 	= jQuery(this).data('status');
			let id 		= jQuery(this).data('id');
			jQuery('body').append(loader_html);
			jQuery.ajax({
				type: "POST",
				url: scripts_vars.ajaxurl,
				data: {
					'action'		: 'taskbot_update_earning',
					'id'			: id,
					'status'		: status,
					'security'		: scripts_vars.ajax_nonce,
				},
				dataType: "json",
				success: function (response) {
				   jQuery('.tb-preloader-section').remove();

				    if (response.type === 'success') {
                        StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 2000});
						window.setTimeout(function() {
							window.location.reload();
						}, 2000);
					} else {
						StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
					}
				}
			});
		 });

		 /*
		  * rejected task
		  * */
		$(document).on('click', '.tb_rejected_task_model', function (e) {
			let _this	= $(this);
			let id		= _this.data('id');
			$('#tb-reject-task').modal('show'); //show model for reject feedback
			$('#tb_submit_reject_task').attr( 'data-tb_task_id',id); //set attribute value by task id
		});

		 /*
		  * rejected task
		  * */
		 $(document).on('click', '.tb_rejected_project_model', function (e) {
			let _this	= $(this);
			let id		= _this.data('id');
			$('#tb-reject-project').modal('show'); //show model for reject feedback
			$('#tb_submit_reject_project').attr( 'data-tb_project_id',id); //set attribute value by project id
		});

		$(document).on('click', '.tb_rejected_project', function (e) {
			let _this		= $(this);
			let id			= _this.data('tb_project_id');
			let feedback	= $('#tb_reject_project_reason').val();
			jQuery('body').append(loader_html);
			jQuery.ajax({
				type: "POST",
				url: scripts_vars.ajaxurl,
				data: {
					'action'	  	: 'taskbot_rejected_project',
					'security'  	: scripts_vars.ajax_nonce,
					'id'		    : id,
					'feedback'  	: feedback
				},
				dataType: "json",
				success: function (response) {
					jQuery('.tb-preloader-section').remove();
					if (response.type === 'success') {
						StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 2000});
						window.setTimeout(function() {
						window.location.reload();
						}, 2000);
					} else {
						StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
					}
				}
			});
		});

		$(document).on('click', '.tb_rejected_task', function (e) {
			let _this		= $(this);
			let id			= _this.data('tb_task_id');
			let feedback	= $('#tb_reject_task_reason').val();
			jQuery('body').append(loader_html);
			jQuery.ajax({
				type: "POST",
				url: scripts_vars.ajaxurl,
				data: {
					'action'	  : 'taskbot_rejected_task',
					'security'  : scripts_vars.ajax_nonce,
					'id'		    : id,
					'feedback'  : feedback
				},
				dataType: "json",
				success: function (response) {
					jQuery('.tb-preloader-section').remove();
					if (response.type === 'success') {
						StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 2000});
						window.setTimeout(function() {
						window.location.reload();
						}, 2000);
					} else {
						StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
					}
				}
			});
		});

		// $(document).on('click', '.tb_rejected_project', function (e) {
		// 	let _this		= $(this);
		// 	let id			= _this.data('tb_task_id');
		// 	let feedback	= $('#tb_reject_task_reason').val();
		// 	jQuery('body').append(loader_html);
		// 	jQuery.ajax({
		// 		type: "POST",
		// 		url: scripts_vars.ajaxurl,
		// 		data: {
		// 			'action'	  	: 'taskbot_rejected_project',
		// 			'security'  	: scripts_vars.ajax_nonce,
		// 			'id'		    : id,
		// 			'feedback'  	: feedback
		// 		},
		// 		dataType: "json",
		// 		success: function (response) {
		// 			jQuery('.tb-preloader-section').remove();
		// 			if (response.type === 'success') {
		// 				StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 2000});
		// 				window.setTimeout(function() {
		// 				window.location.reload();
		// 				}, 2000);
		// 			} else {
		// 				StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
		// 			}
		// 		}
		// 	});
		// });

		// approved task
		$(document).on('click', '.tb_publish_project', function (e) {
			let _this			= $(this);
			let id 				= _this.data('id');
			executeConfirmAjaxRequest({
					type: "POST",
					url: scripts_vars.ajaxurl,
					data: {
						'action'	: 'taskbot_publish_project',
						'security'	: scripts_vars.ajax_nonce,
						'id'		: id
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
				},
				scripts_vars.publish_project,
				scripts_vars.publish_project_msg,
				loader_html
			)
		});

		 // approved task
		 $(document).on('click', '.tb_publish_task', function (e) {
			let _this			= $(this);
			let id 				= _this.data('id');
			executeConfirmAjaxRequest({
					type: "POST",
					url: scripts_vars.ajaxurl,
					data: {
						'action'	: 'taskbot_publish_task',
						'security'	: scripts_vars.ajax_nonce,
						'id'		: id
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
				},
				scripts_vars.publish_task,
				scripts_vars.publish_task_msg,
				loader_html
			)
		});

		// remove task
		$(document).on('click', '.tb_remove_task', function (e) {
			let _this			= $(this);
			let id 				= _this.data('id');
			executeConfirmAjaxRequest(
				{
					type: "POST",
					url: scripts_vars.ajaxurl,
					data: {
						'action'	: 'taskbot_remove_task',
						'security'	: scripts_vars.ajax_nonce,
						'id'		: id
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
				},
				scripts_vars.remove_task,
				scripts_vars.remove_task_message,
				loader_html
			)
		});

		//dispute summary load
        jQuery(document).on('click', '#dispute-summary-reload', function(e){
			jQuery('body').append(loader_html);
			jQuery.ajax({
				type: "POST",
				url: scripts_vars.ajaxurl,
				data: {
					'action'		: 'taskbot_dispute_summary',
					'security'		: scripts_vars.ajax_nonce,
				},
				dataType: "json",
				success: function (response) {
				   jQuery('.tb-preloader-section').remove();

				    if (response.type === 'success') {
                        jQuery('#dispute-summary1').html(response.html);
					}
				}
			});
		 });
		 //Task dispute reply
		$(document).on('click', '#project-dispute-reply-btn', function (e) {
			e.preventDefault();
			var _this 			= jQuery(this);
			var _serialized   	= jQuery('#project-dispute-reply-form').serialize();
			jQuery('body').append(loader_html);
			jQuery.ajax({
				type: "POST",
				url: scripts_vars.ajaxurl,
				data: {
					'action'	: 'taskbot_submit_project_dispute_reply',
					'security'	: scripts_vars.ajax_nonce,
					'data'		: _serialized,
				},
				dataType: "json",
				success: function (response) {
				   jQuery('.tb-preloader-section').remove();

				   if (response.type === 'success') {
						jQuery('#dispute_comment').val('');
						StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 2000});
						window.setTimeout(function() {
							window.location.reload();
						}, 2000);
					} else {
						StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
					}
				}
			});
		});
		 //dispute reply
         $(document).on('click', '#dispute-reply-btn', function (e) {
			e.preventDefault();
			var _this 			= jQuery(this);
			var _serialized   	= jQuery('#dispute-reply-form').serialize();

			jQuery('body').append(loader_html);

			jQuery.ajax({
				type: "POST",
				url: scripts_vars.ajaxurl,
				data: {
					'action'	: 'taskbot_submit_dispute_reply',
					'security'	: scripts_vars.ajax_nonce,
					'data'		: _serialized,
				},
				dataType: "json",
				success: function (response) {
				   jQuery('.tb-preloader-section').remove();
				   if (response.type === 'success') {
						jQuery('#dispute_comment').val('');
						StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 2000});
						window.setTimeout(function() {
							window.location.reload();
						}, 2000);

					} else {
						StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
					}
				}
			});
		});

		var particle = document.getElementById('particles-js')
		if (particle !== null) {
			particlesJS("particles-js",{
				"particles": {
					"number": {
						"value": 100,
						"density": {
							"out_mode": "out",
							"enable": true,
							"value_area": 800
						}
					},
					"color": {
						"value": ["#ffffff"]
					},
					"line_linked": {
						"enable": false,
					},
					"size": {
						"value": 30,
						"random": true,
					},
					"bubble": {
						"distance": 40,
						"size": 10,
						"duration": 2,
						"opacity": 9,
						"speed": 99
					},
					"opacity": {
						"value": 0.1,
						"random": true,
						"anim": {
							"enable": true,
							"speed": 0.1,
							"size_min": 1,
							"sync": true
						}
					},
				}
			})
		}		

		//Resolve Project Dispute Ajax
		jQuery(document).on('click', '.project-resolve-dispute-btn', function(e) {
			e.preventDefault();
			var _this = jQuery(this);
			jQuery('body').append(loader_html);
			var dispute_id			= _this.data('dispute-id');
			var _serialized 		= jQuery('#admin-dispute-resolve-form').serialize();
			var user_id				= jQuery("input[name='user_id']:checked").val();
			var dataString 			= 'security='+scripts_vars.ajax_nonce+'&'+_serialized+ '&user_id='+user_id+'&dispute_id='+dispute_id+'&action=taskbot_resolve_project_dispute';

			jQuery.ajax({
				type: "POST",
				url: scripts_vars.ajaxurl,
				dataType:"json",
				data: dataString,
				success: function(response) {
					jQuery('.tb-preloader-section').remove();
					if (response.type === 'success') {
						$("#admin-dispute-resolve-form").trigger("reset");
						StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 2000});
						window.setTimeout(function() {
							window.location.reload();
						}, 2000);
					} else {
						StickyAlert(response.message, response.message_desc, {classList: 'important', autoclose: 2000});
					}
				}
			});
		});

		//Resolve Dispute Ajax
		jQuery(document).on('click', '.resolve-dispute-btn', function(e) {
			e.preventDefault();
			var _this = jQuery(this);
			jQuery('body').append(loader_html);
			var dispute_id			= _this.data('dispute-id');
			var _serialized = jQuery('#admin-dispute-resolve-form').serialize();
			var user_id				= jQuery("input[name='user_id']:checked").val();
			var dataString 	= 'security='+scripts_vars.ajax_nonce+'&'+_serialized+ '&user_id='+user_id+'&dispute_id='+dispute_id+'&action=taskbot_resolve_dispute';

			jQuery.ajax({
				type: "POST",
				url: scripts_vars.ajaxurl,
				dataType:"json",
				data: dataString,
				success: function(response) {
					jQuery('.tb-preloader-section').remove();
					if (response.type === 'success') {
						$("#admin-dispute-resolve-form").trigger("reset");
						StickyAlert(response.message, response.message_desc, {classList: 'success', autoclose: 2000});
						window.setTimeout(function() {
							window.location.reload();
						}, 2000);
					} else {
						StickyAlert(response.message, response.message_desc, {classList: 'important', autoclose: 2000});
					}
				}
			});
		});

		// download attachments
		jQuery(document).on('click', '.tb-download-attachment', function(e){
			e.preventDefault();
			var _this = jQuery(this);
			var _comments_id = _this.data('id');

			if( _comments_id == '' || _comments_id == 'undefined' || _comments_id == null ){
				StickyAlert(scripts_vars.message_error, scripts_vars.message_error, {classList: 'important', autoclose: 2000});
				return false;
			}

			//Send request
			var dataString 	  = 'security='+scripts_vars.ajax_nonce+'&comments_id='+_comments_id+'&action=taskbot_download_chat_attachments';
			jQuery('body').append(loader_html);
			jQuery.ajax({
			type: "POST",
			url: scripts_vars.ajaxurl,
			data: dataString,
			dataType: "json",
			success: function (response) {
				jQuery('body').find('.tb-preloader-section').remove();
				if (response.type === 'success') {
					window.location = response.attachment;
				} else {
					StickyAlert(response.message, response.message_desc, {classList: 'important', autoclose: 2000});
				}
			}
			});
		});

		// Admin dispute resolve form submit
		taskbot_upload_multiple_doc('taskbot-attachment-btn-clicked', 'taskbot-upload-attachment', 'taskbot-droparea', 'file_name', 'taskbot-fileprocessing', 'load-chat-media-attachments', true, 'jpg,jpeg,gif,png', 1);
		// multiple upload
		function taskbot_upload_multiple_doc(btnID, containerID, dropareaID, type, previewID, templateID, _type, filetype = "pdf,doc,docx,xls,xlsx,ppt,pptx,csv,jpg,jpeg,gif,png,zip,rar,mp4,mp3,3gp,flv,ogg,wmv,avi,stl,obj,iges,js,php,html,txt", max_file_count=0) {


			if (typeof plupload === 'object') {
				var sys_upload_nonce = scripts_vars.sys_upload_nonce;
				var ProjectUploaderArguments = {
					browse_button: btnID, // this can be an id of a DOM element or the DOM element itself
					file_data_name: type,
					container: containerID,
					drop_element: dropareaID,
					multipart_params: {
						"type": type,
					},
					multi_selection: _type,
					url: scripts_vars.ajaxurl + "?action=taskbot_temp_file_uploader&ajax_nonce=" + scripts_vars.ajax_nonce,
					filters: {
						mime_types: [
							{ title: 'file', extensions: filetype }
						],
						max_file_size: scripts_vars.upload_size,
						max_file_count: max_file_count,

						prevent_duplicates: false
					}
				};
				var ProjectUploader = new plupload.Uploader(ProjectUploaderArguments);
				ProjectUploader.init();
				//bind
				ProjectUploader.bind('FilesAdded', function (up, files) {
					var _Thumb = "";
					if (max_file_count > 1 ) {
						let prevous_files = jQuery('#'+previewID+' li').length;
						let file_count  = max_file_count - prevous_files;

						if (file_count > 1 && files.length > file_count) {
							up.files.splice(5, up.files.length - 5);
							let extra_params = {};
							extra_params['note_desc'] = '';
							jQuery('#'+containerID).plupload('notify', 'info', scripts_vars.upload_max_images);
							return false;
						}
						if (files.length >= file_count) {
							jQuery('#'+dropareaID).hide('slow');
						}
					}
					let counter = 0;
					plupload.each(files, function (file) {


						let prevous_files = jQuery('#'+previewID+' li').length;
						let file_count  = max_file_count - prevous_files;

						if (max_file_count < 1 ||  counter < file_count) {
							var load_thumb = wp.template(templateID);
							var _size = bytesToSize(file.size);
							var data = { id: file.id, size: _size, name: file.name, percentage: file.percent };

							load_thumb = load_thumb(data);
							_Thumb += load_thumb;
						}
						if (max_file_count > 1){
							counter++;
						}
					});
					if (_type == false) {
						jQuery('#' + previewID).html(_Thumb);
					} else {
						jQuery('#' + previewID).append(_Thumb);
					}
					jQuery('#' + previewID).removeClass('taskbot-empty-uploader');
					jQuery('#' + previewID).addClass('taskbot-infouploading');
					up.refresh();
					ProjectUploader.start();
				});

				//FilesRemoved
				ProjectUploader.bind('FilesRemoved', function(up, files) {

					if (max_file_count > 1 ) {

						let prevous_files = jQuery('#'+previewID+' li').length;
						if (up.files.length >= max_file_count) {
							jQuery('#'+dropareaID).show('slow');
						}
					}
				});

				//bind
				ProjectUploader.bind('UploadProgress', function (up, file) {
					var _html = ' <span class="progress-bar uploadprogressbar" style="width:' + file.percent + '%"></span>';
					jQuery('#thumb-' + file.id + ' .progress .uploadprogressbar').replaceWith(_html);
				});

				//Error
				ProjectUploader.bind('Error', function (up, err) {
					var errorMessage = err.message
					if (err.code == '-600') {
						errorMessage = scripts_vars.file_size_error
					}
					let extra_params = {};
					extra_params['note_desc'] = errorMessage;
				});

				//display data
				ProjectUploader.bind('FileUploaded', function (up, file, ajax_response) {
					var response = jQuery.parseJSON(ajax_response.response);

					if (response.type === 'success') {
						var successIcon = '<a href="javascript:void(0);"><i class="icon-check-circle"></i></a>';
						jQuery('#thumb-' + file.id + ' .taskbot-filedesciption .taskbot-filedesciption__icon').append(successIcon);
						jQuery('#thumb-' + file.id).removeClass('taskbot-uploading');
						jQuery('#thumb-' + file.id).addClass('taskbot-file-uploaded');
						jQuery('#thumb-' + file.id + ' .attachment_url').val(response.thumbnail);
						jQuery('#thumb-' + file.id).find('.taskbot-filedesciption__details a').attr("href", response.thumbnail);
					} else {
						jQuery('#thumb-' + file.id).remove();
						StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
					}
				});

				//Delete Award Image
				jQuery(document).on('click', '.tb-remove-attachment', function (e) {
					e.preventDefault();
					var _this = jQuery(this);
					var listParent = _this.parents('li').parent('ul');
					_this.parents('li').remove();
					
					if (listParent.find('li').length < max_file_count) {
						jQuery('#'+dropareaID).show('slow');
					} else if(listParent.find('li').length == 0) {
						listParent.addClass('tb-empty-uploader')
					}
				});
			}
		}


    });

	//Confirm before submit
	function executeConfirmAjaxRequest(ajax, title='Confirm', message='',loader) {
		$.confirm({
			title: title,
			content: message,
			class: 'blue',
			theme		: 'modern',
			animation	: 'scale',
			closeIcon: true, // hides the close icon.
			'buttons': {
				'Yes': {
					'btnClass': 'btn-dark tb-yesbtn',
					'text': scripts_vars.yes,
					'action': function () {
						if(loader){jQuery('body').append(loader_html);}
						jQuery.ajax(ajax);
					}
				},
				'No': {
					'btnClass': 'btn-default tb-nobtn',
					'text': scripts_vars.no,
					'action': function () {
						return true;
					}
				},
			}
		});
	}

	//Alert the notification
	function StickyAlert($title='',$message='',data){
		var $icon	= 'icon-check';
		var $class	= 'dark';

		if(data.classList === 'success'){
			$icon	= 'icon-check';
			$class	= 'green';
		}else if(data.classList === 'danger'){
			$icon	= 'icon-x';
			$class	= 'red';
		}

		jQuery.confirm({
			icon		: $icon,
			closeIcon	: true,
			theme		: 'modern',
			animation	: 'scale',
			type		: $class, //red, green, dark, orange
			title		: $title,
			content		: $message,
			autoClose	: 'close|'+ data.autoclose,
			buttons: {
				close: {btnClass: 'tb-sticky-alert'}
			}
		});
	}


	jQuery(document).on('change', '#tb_admin_order_type', function (e) {
		jQuery('#tb-search-task-form').submit();
	});

	jQuery('#tb-btnmenutogglev2').on('click', function(){
		jQuery(this).closest('#tb-sidebarwrapper').toggleClass('tb-opensidebar')
	});

	// Left Sidebar Animation
	if($(window).width() >= 767){
		jQuery('.tb-btnmenutoggle a').on('click', function($) {
			var _this = jQuery(this);
			_this.parents('body').addClass('et-animationbar');
			setTimeout(function(){
				_this.parents('body').toggleClass("et-offsidebar");
				SDom[0].pJS.particles.move.enable = ture;
			},270)

			setTimeout(function(){
				_this.parents('body').removeClass('et-animationbar');
				pJSDom[0].pJS.particles.move.enable = true;
				pJSDom[0].pJS.fn.particlesRefresh();
			},600)

		});
	}

});

function tablecellsearch() {
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("myInputTwo");
	filter = input.value.toUpperCase();
	table = document.querySelectorAll(".table");
	tr = document.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[1];
		if (td) {
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
}
