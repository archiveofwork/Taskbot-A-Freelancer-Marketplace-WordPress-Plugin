'use strict';
jQuery(document).ready(function($){
    var socketId = null;
    Pusher.logToConsole = true;
    let authorizer = (channel, options) => {
        return {
            authorize: function (socketId, callback) {
                jQuery.ajax({
                    url: scripts_vars.ajaxurl,
                    method: 'POST',
                    data: {
                        "channel_name": channel.name,
                        "socket_id": socketId,
                        action: 'taskbot_pusher_authorizer'
                    },
                    success: function (result) {
                        callback(false, JSON.parse(result));
                    }
                });
            }
        };
    };

    let pusher = new Pusher(scripts_vars.pusher_key, {
      cluster: scripts_vars.cluster,
      authorizer: authorizer,
    });
    
    var channel = pusher.subscribe('private-post-' + scripts_vars.current_user_key);
    channel.bind('notify_trigger_point', function(data) {
        if (data.pusher_type === 'notification') {
            jQuery('.tb-menu-notifications').html(data.message_html);
            taskbot_notification_options();
        }

        if (data.flash_message_html != '') {
            pusherStickyAlert(data.flash_message_html.message_html,{autoclose: 2000});
        }
    });

});
 function pusherStickyAlert( $message = '', data) {
     var $icon = 'icon-check';
     var $class = 'dark'; 
     jQuery.dialog({
         icon: $icon,
         closeIcon: true,
         theme: 'modern',
         animation: 'scale',
         type: $class, 
         title:'',
         content: $message,
         hide: { effect: "explode", duration: 2000 },
         buttons: {
            isHidden: true,
         }
     });
 }