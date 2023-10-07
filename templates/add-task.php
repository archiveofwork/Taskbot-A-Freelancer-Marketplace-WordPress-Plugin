<?php
/**
 * Template Name: Add new task
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $post, $thumbnail,$taskbot_settings,$current_user;
$package_option	        = !empty($taskbot_settings['package_option']) ? $taskbot_settings['package_option'] : '';
$user_type			= apply_filters('taskbot_get_user_type', $current_user->ID );
$post_id        	= (isset($_GET['post'])) ? intval($_GET['post']) : '';
$step           	= (isset($_GET['step'])) ? intval($_GET['step']) : '1';
$taskbot_args   	= array( 'post_id'=>$post_id, 'step' => $step );
$task_allowed    	= taskbot_task_create_allowed($current_user->ID);
$package_detail  	= taskbot_get_package($current_user->ID);
$task_plans_allowed	= 'yes';
$package_type    	=  !empty($package_detail['type']) ? $package_detail['type'] : '';

if( !empty($package_type) && $package_type == 'paid'){
	$task_plans_allowed    =  !empty($package_detail['package']['task_plans_allowed']) ? $package_detail['package']['task_plans_allowed'] : 'no';
	$number_tasks_allowed  =  !empty($package_detail['package']['number_tasks_allowed']) ? $package_detail['package']['number_tasks_allowed'] : 0;
}

if((!empty($post_id) && $user_type == 'sellers') ||  (!empty($user_type) && $user_type == 'sellers' && $task_allowed)){
	$task_allowed_	= true;
} else {
	$redirect_url  = !empty($taskbot_settings['tpl_dashboard']) ? get_the_permalink( $taskbot_settings['tpl_dashboard'] ) : '';
	if(!empty($package_option) && ( $package_option == 'buyer_free' || $package_option == 'paid' )){
		$redirect_url	= taskbot_get_page_uri('package_page');
	}
	
	wp_redirect( $redirect_url );
    exit;
}

get_header();
?>
<div class="tk-main-section">
	<div class="container">
		<div class="row tk-blogs-bottom">
			<div class="col-xl-12">
				<?php if((!empty($post_id) && $user_type == 'sellers') ||  (!empty($user_type) && $user_type == 'sellers' && $task_allowed)){
					 taskbot_get_template( 'dashboard/post-service/add-service.php', $taskbot_args);		 
				 } else {					
					 do_action('taskbot_user_not_authorized');
				 } 
				?>
			</div>
		</div>
	</div>
</div>
<?php
get_footer();
