<?php
require_once(TASKBOT_DIRECTORY . "libraries/pusher/vendor/autoload.php");
if (!class_exists('PusherAuth')) {
    /**
     * Segment User Marketing
     *
     * @package Taskbot
     */
    class PusherAuth
    {
        /**
         * private variable
         *
         * @var [void]
         */
        private static $_instance = null;

        /**
         * protected variable
         *
         * @var [void]
         */
        protected static $_pusher = null;

        /**
         * protected variable
         *
         * @var [void]
         */
        protected static $_authkey = null;

        /**
         * Call this method to get singleton
         *
         * @return PusherAuth Instance
         */
        public static function instance()
        {
            if (self::$_instance === null) {
                self::$_instance = new PusherAuth();
            }
            return self::$_instance;
        }

        /**
         * PRIVATE CONSTRUCTOR
         */
        public function __construct()
        {
            add_action("wp_ajax_taskbot_pusher_authorizer", array(__CLASS__, "taskbot_pusher_authorizer"));
            add_action("wp_ajax_taskbot_pusher_authorizer", array(__CLASS__, "taskbot_pusher_authorizer"));
            add_action("taskbot_pusher_notification", array(__CLASS__, "taskbot_pusher_notification"));
        }

         /**
         * Init Pusher Instance
         */
        public static function taskbot_pusher_notification($params)
        {
            $post_id    = !empty($params['post_id']) ? $params['post_id'] : 0;
            self::initPusher()->trigger('private-post-'.$post_id, 'notify_trigger_point', $params);
        }

        /**
         * Init Pusher Instance
         */
        private static function initPusher()
        {
            global $taskbot_notification;
            $cluster            = !empty($taskbot_notification['pusher_app_cluster']) ? $taskbot_notification['pusher_app_cluster'] : '';
            $pusher_app_key     = !empty($taskbot_notification['pusher_app_key']) ? $taskbot_notification['pusher_app_key'] : '';
            $pusher_app_secret  = !empty($taskbot_notification['pusher_app_secret']) ? $taskbot_notification['pusher_app_secret'] : '';
            $pusher_app_id      = !empty($taskbot_notification['pusher_app_id']) ? $taskbot_notification['pusher_app_id'] : '';
            $options = array(
                'useTLS'    => true,
                'cluster'   => $cluster
            );

            if (self::$_pusher === null) {
                self::$_pusher = new Pusher\Pusher(
                    $pusher_app_key,
                    $pusher_app_secret,
                    $pusher_app_id,
                    $options
                );
            }

            return self::$_pusher;
        }

        public static function taskbot_pusher_authorizer()
        {
            if (is_user_logged_in()) {
                if (self::$_authkey === null) {
                    $socket_id = $_POST['socket_id'];
                    $channel_name = $_POST['channel_name'];

                    if (!empty($socket_id) && !empty($channel_name)) {
                        self::$_authkey = self::initPusher()->socket_auth($channel_name, $socket_id);
                        wp_send_json(self::$_authkey);
                    }
                }
            } else {
                header("HTTP/1.1 403 Unauthorized");
                exit;
            }
        }

    }

    PusherAuth::instance();
}