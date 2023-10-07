<?php
/**
 * Dashboard earnings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/admin_dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user;
$reference 		 = !empty($_GET['ref'] ) ? $_GET['ref'] : '';
$mode 			 = !empty($_GET['mode']) ? $_GET['mode'] : '';
$user_identity 	 = intval($current_user->ID);
$id 			 = !empty($args['id']) ? $args['id'] : '';
$status			 = !empty($_GET['status']) ? $_GET['status'] : 'any';
$paged			 = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$post_per_page	 = get_option('posts_per_page');
$taskbot_args	= array(
    'post_type'         => 'withdraw',
    'post_status'       => $status,
    'posts_per_page'	=> $post_per_page,
    'paged'             => $paged,
    'orderby'           => 'ID',
    'order'             => 'DESC'
);
$taskbot_query 	= new WP_Query( apply_filters('taskbot_earning_listings_args', $taskbot_args) );
$total_posts	= (int)$taskbot_query->found_posts;
$date_format	= get_option( 'date_format' );

$month	= !empty($_POST['months']) ? sprintf("%02d", $_POST['months']) : '';
$year	= !empty($_POST['years']) ? $_POST['years'] : '';
$years 	= array_combine(range(date("Y"), 1970), range(date("Y"), 1970));
$months	= array();

if( function_exists('taskbot_list_month') ) {
	$months	= taskbot_list_month();
}
?>
<div class="col-md-12">
	<div class="tb-dhb-mainheading">
		<h2><?php esc_html_e('Withdraw requests','taskbot');?></h2>
		<div class="tb-sortby tb-payout-sort">
			<form class="tb-themeform tb-displistform" id="tb-withdraw-form" method="post">
				<fieldset>
					<div class="tb-themeform__wrap">
						<div class="tb-actionselect">
							<span><?php esc_html_e('Show only:','taskbot');?></span>
							<div class="tb-select tb-dbholder border-0">
								<select name="months" id="bulk-action-selector-top">
									<option value=""><?php esc_html_e('Select month','taskbot');?></option>
									<?php if( !empty( $months ) ) {?>
										<?php foreach ( $months as $key	=> $val ) {
											$selected_m = '';

											if( !empty($month) && $month == $key ){
												$selected_m = 'selected';
											}
											?>
											<option value="<?php echo intval($key);?>" <?php echo esc_attr($selected_m);?>><?php echo esc_html($val);?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="tb-profileform__content">
							<div class="tb-select tb-dbholder border-0">
								<select name="years" id="bulk-action-selector-top">
									<option value=""><?php esc_html_e('Select year','taskbot');?></option>
									<?php if( !empty( $years ) ) {?>
										<?php foreach ( $years as $key	=> $val ) {
											$selected_y = '';

											if( !empty($year) && $year == $key ){
												$selected_y = 'selected';
											} ?>
											<option value="<?php echo intval($key);?>" <?php echo esc_attr($selected_y);?>><?php echo esc_html($val);?></option>
										<?php } ?>
									<?php } ?>

								</select>
							</div>
						</div>
						<div class="tb-downloadbtn">
							<a href="javascript:void(0);" class="tb-btn tb-doownload-withdraw"><?php esc_html_e('Download','taskbot');?><span class="rippleholder tb-jsripple"><em class="ripplecircle"></em></span></a>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
	<div class="tb-dbholder border-0 tb-payout">
		<table class="table tb-table tb-dbholder">
			<thead>
				<tr>
					<th>
						<div class="tb-checkbox">
							<span><?php esc_html_e('Ref #','taskbot');?></span>
						</div>
					</th>
					<th><?php esc_html_e('Seller name','taskbot');?></th>
					<th><?php esc_html_e('Payout method','taskbot');?></th>
					<th><?php esc_html_e('Payout amount','taskbot');?></th>
					<th><?php esc_html_e('Dated','taskbot');?></th>
					<th><?php esc_html_e('Status','taskbot');?></th>
				</tr>
			</thead>
			<tbody>
			<?php if ( $taskbot_query->have_posts() ) :?>
				<?php
					while ( $taskbot_query->have_posts() ) : $taskbot_query->the_post();
						global $post;
						$withdraw_key		= get_post_meta( $post->ID, '_unique_key', true );
						$withdraw_key		= !empty($withdraw_key) ? $withdraw_key : $post->ID;
						$withdraw_amount	= get_post_meta( $post->ID, '_withdraw_amount', true );
						$withdraw_amount	= !empty($withdraw_amount) ? $withdraw_amount : '';

						$payment_method	= get_post_meta( $post->ID, '_payment_method', true );
						$payment_method	= !empty($payment_method) ? $payment_method : '';
						$post_author	= get_post_field( 'post_author', $post );
						$post_author	= !empty($post_author) ? $post_author : '';
						$profile_id		= taskbot_get_linked_profile_id($post_author,'','sellers');
						$user_name		= taskbot_get_username($profile_id);
						$payrols		= taskbot_get_payouts_lists();
						$payment_method	= !empty($payrols[$payment_method]['label']) ? $payrols[$payment_method]['label'] : '';
						$post_status	= get_post_status( $post );?>
						<tr>
							<td data-label="<?php esc_attr_e('Ref #','taskbot');?>">
								<div class="tb-checkbox">
									<span> <?php echo esc_html($withdraw_key);?></span>
								</div>
							</td>
							<td data-label="<?php esc_attr_e('Seller name','taskbot');?>"><a href="<?php echo get_the_permalink( $profile_id );?>"><?php echo esc_html($user_name);?></a></td>
							<td data-label="<?php esc_attr_e('Payout method','taskbot');?>"><?php echo esc_html($payment_method);?></td>
							<td data-label="<?php esc_attr_e('Payout amount','taskbot');?>"><span><?php taskbot_price_format($withdraw_amount);?></span></td>
							<td data-label="<?php esc_attr_e('Dated','taskbot');?>"><?php echo esc_html(date_i18n( $date_format,  strtotime(get_the_date($post->ID))));?></td>
							<td data-label="<?php esc_attr_e('Status','taskbot');?>" class="tb-dispuitstatus">
								<div class="tb-dispueitems tb-dispueitemsv2">
									<?php do_action( 'taskbot_post_status', $post->ID );?>
								</div>
								<div class="tb-dispueitems tb-dispueitemsv2">
									<?php if( !empty($post_status) && $post_status === 'pending'){?>
										<div class="tb-bordertags">
											<a href="javascript:void(0);" data-status="publish" data-id="<?php echo intval($post->ID);?>" class="tb-update-earning bordr-green"><?php esc_html_e( 'Approve', 'taskbot' );?></a>
										</div>
										<?php
									} ?>
								</div>
							</td>
						</tr>
					<?php endwhile;
					wp_reset_postdata();
					endif;?>
			</tbody>
		</table>
		<?php if ( $taskbot_query->have_posts() && $total_posts >= $post_per_page ) :?>
			<div class="tb-tabfilteritem">
				<?php taskbot_paginate($taskbot_query); ?>
			</div>
		<?php endif;?>

		<?php if ( !$taskbot_query->have_posts() ) {
			do_action( 'taskbot_empty_listing', esc_html__('Oops!! record not found', 'taskbot') );
		} ?>
		<?php wp_reset_postdata();?>
	</div>
</div>