<?php
/**
 * Seller packages
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $taskbot_settings, $current_user;
$user_identity  = intval($current_user->ID);
$user_type		= apply_filters('taskbot_get_user_type', $user_identity );
$title			= !empty($taskbot_settings['pkg_page_title']) ? $taskbot_settings['pkg_page_title'] : '';
$sub_title		= !empty($taskbot_settings['pkg_page_sub_title']) ? $taskbot_settings['pkg_page_sub_title'] : '';
$details		= !empty($taskbot_settings['pkg_page_details']) ? $taskbot_settings['pkg_page_details'] : '';
?>
<div class="row">
	<div class="col-lg-9 col-xl-8">
		<div class="tb-sectioninfov2 tb-priceplantitle">
			<div class="tb-sectiontitle">
				<?php if( !empty($title) ){?>
					<h3><?php echo esc_html($title); ?></h3>
				<?php } ?>
				<?php if( !empty($sub_title) ){?>
					<h2><?php echo esc_html($sub_title) ?></h2>
				<?php } ?>
				<?php if( !empty($details) ){?>
					<div class="tb-description">
						<?php echo do_shortcode($details); ?>
					</div>
				<?php } ?>
			</div>

		</div>
	</div>
</div>
<?php
if($user_type == 'buyers'){
	taskbot_get_template_part('dashboard/buyer/user-package-detail');
} else {
	taskbot_get_template_part('dashboard/user-package-detail');
}

if($user_type == 'buyers'){
	$args = array(
	   'limit'     => -1, // All packages
	   'status'    => 'publish',
	   'type'      => 'buyer_packages',
	   'orderby'   => 'date',
	   'order'     => 'ASC',
   );
} else {
	$args = array(
	   'limit'     => -1, // All packages
	   'status'    => 'publish',
	   'type'      => 'packages',
	   'orderby'   => 'date',
	   'order'     => 'ASC',
   );
}
$taskbot_packages = wc_get_products( $args );

if(isset($taskbot_packages) && is_array($taskbot_packages) && count($taskbot_packages)>0){?>
	<div class="tb-pricing">
		<div class="row">
			<?php foreach($taskbot_packages as $package){ ?>
				<div class="col-md-6 col-lg-4">
					<?php do_action('taskbot_package_details', $package ); ?>
				</div>
			<?php } ?>
		</div>
	</div>
<?php }
