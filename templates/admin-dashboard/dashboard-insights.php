<?php
/**
 * Dashboard insights
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/admin_dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user, $wp_roles, $userdata, $post;

$reference 		 = !empty($_GET['ref'] ) ? $_GET['ref'] : '';
$mode 			 = !empty($_GET['mode']) ? $_GET['mode'] : '';
$user_identity 	 = intval($current_user->ID);
$id 			 = !empty($args['id']) ? $args['id'] : '';
$user_type		 = apply_filters('taskbot_get_user_type', $user_identity );
wp_enqueue_script( 'chart' );
wp_enqueue_script( 'utils-chart');
taskbot_get_template_part('admin-dashboard/dashboard', 'tasks-insights');
