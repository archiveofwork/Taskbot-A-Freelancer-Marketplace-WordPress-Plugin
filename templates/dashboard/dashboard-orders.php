<?php
/**
 * Seller orders listing
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $current_user, $wp_roles, $userdata, $post;

$reference		= !empty($_GET['ref'] ) ? esc_html($_GET['ref']) : '';
$mode			= !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity	= intval($current_user->ID);
$id				= !empty($args['id']) ? $args['id'] : '';
$user_type		= apply_filters('taskbot_get_user_type', $user_identity );
?>
<div class="container tb-dhb-orders-listing">
	<div class="row">
		<div class="col-lg-12">
			<!-- top filters section -->
			<div class="tb-dhb-mainheading">
				<h2><?php esc_html_e('All available tasks','taskbot');?></h2>
				<div class="tb-sortby">
					<div class="tb-actionselect tb-actionselect2">
						<span><?php esc_html_e('Sort by:','taskbot');?></span>
						<div class="tb-select">
						<select id="tb-selection1" class="form-control tk-selectv">
							<option selected hidden disabled> <?php esc_html_e('Deadline','taskbot');?></option>
							<option> <?php esc_html_e('30 Days','taskbot');?></option>
						</select>
						</div>
					</div>
				</div>
			</div>
			<!-- top filters section end -->
			<div class="tb-dhbtabs tb-tasktabs">
				<div class="nav nav-tabs tb-navtabs " id="myTab" role="tablist">
					<a class="nav-link <?php echo esc_attr( $mode == '' or $mode == 'all' ? 'active' : '' );?>" href="<?php echo esc_url(Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity, true, 'all'));?>"><?php esc_html_e('All orders','taskbot');?></a>
					<a class="nav-link <?php echo esc_attr( $mode == 'new' ? 'active' : '' );?>" href="<?php echo esc_url(Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity, true, 'new'));?>"><?php esc_html_e('New orders','taskbot');?></a>
					<a class="nav-link <?php echo esc_attr( $mode == 'ongoing' ? 'active' : '' );?>" href="<?php echo esc_url(Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity, true, 'ongoing'));?>"><?php esc_html_e('Ongoing orders','taskbot');?></a>
					<a class="nav-link <?php echo esc_attr( $mode == 'completed' ? 'active' : '' );?>" href="<?php echo esc_url(Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity, true, 'completed'));?>"><?php esc_html_e('Completed orders','taskbot');?></a>
					<a class="nav-link <?php echo esc_attr( $mode == 'cancelled' ? 'active' : '' );?>" href="<?php echo esc_url(Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity, true, 'cancelled'));?>"><?php esc_html_e('Cancelled orders','taskbot');?></a>
					<a class="nav-link <?php echo esc_attr( $mode == 'declined' ? 'active' : '' );?>" href="<?php echo esc_url(Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity, true, 'declined'));?>"><?php esc_html_e('Declined orders','taskbot');?></a>
				</div>
				<div class="tab-content tab-taskcontent" id="pills-tabContent">
					<?php
						if(!empty($mode) && $mode === 'new') {
							taskbot_get_template_part('dashboard/dashboard', 'new-orders', array());
						}elseif(!empty($mode) && $mode === 'ongoing') {
							taskbot_get_template_part('dashboard/dashboard', 'ongoing-orders', array());
						}elseif(!empty($mode) && $mode === 'completed') {
							taskbot_get_template_part('dashboard/dashboard', 'completed-orders', array());
						}elseif(!empty($mode) && $mode === 'cancelled') {
							taskbot_get_template_part('dashboard/dashboard', 'cancelled-orders', array());
						}elseif(!empty($mode) && $mode === 'declined') {
							taskbot_get_template_part('dashboard/dashboard', 'declined-orders', array());
						}else{
							taskbot_get_template_part('dashboard/dashboard', 'all-orders', array());
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
