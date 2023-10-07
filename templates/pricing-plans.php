<?php
/**
 * Template Name: Pricing plans
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $post, $current_user;
$user_identity  = intval($current_user->ID);
$user_type		= apply_filters('taskbot_get_user_type', $user_identity );
get_header();
?>
<section class="tb-main-section">
	<div class="container">
		<div class="tb-pricingholder">			
			<?php 
				if(!empty($user_type) && in_array($user_type, array('buyers','sellers'))){
					do_action('taskbot_packages_listing');
				} else { 
					do_action( 'taskbot_notification', esc_html__('Restricted access','taskbot'), esc_html__('Oops! you are not allowed to access this page','taskbot') );
				}
				?>
		</div>
	</div>
</section>
<?php
get_footer();
