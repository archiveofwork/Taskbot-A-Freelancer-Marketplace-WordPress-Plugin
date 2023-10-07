<?php
/**
 * Dashboard insights
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $current_user, $wp_roles, $userdata, $post;

$reference 		 = !empty($_GET['ref'] ) ? esc_html($_GET['ref']) : '';
$mode 			 = !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity 	 = intval($current_user->ID);
$id 			 = !empty($args['id']) ? $args['id'] : '';
$user_type		 = apply_filters('taskbot_get_user_type', $user_identity );
if ( !empty($user_type) && $user_type === 'sellers') {
	taskbot_get_template_part('dashboard/dashboard', 'seller-insights');
} else {
	taskbot_get_template_part('dashboard/dashboard', 'buyer-insights');
}
