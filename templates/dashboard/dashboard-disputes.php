<?php
/**
 * Dispute listings
 * 
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $current_user, $wp_roles, $userdata, $post, $taskbot_settings;

$reference 		 = !empty($_GET['ref'] ) ? esc_html($_GET['ref']) : '';
$mode 			 = !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity 	 = intval($current_user->ID);
$id 			 = !empty($args['id']) ? $args['id'] : '';
$user_type		 = apply_filters('taskbot_get_user_type', $user_identity );

$label		= esc_html__('Buyer name', 'taskbot');
$meta_key	= '_seller_id';

if($user_type == 'buyers'){
	$meta_key	= '_buyer_id';
	$label		= esc_html__('Seller name', 'taskbot');
}

if ( !class_exists('WooCommerce') ) {
	return;
}

$price_symbol		= taskbot_get_current_currency();
$currency_symbol	= !empty($price_symbol['symbol']) ? $price_symbol['symbol'] : '$';

$paged	= ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$search	= !empty($_GET['search']) ? esc_html($_GET['search']) : '';
$sortby	= !empty($_GET['sortby']) ? esc_html($_GET['sortby']) : '';

$dispute_status	= 'any';
if( !empty($sortby) ){
	if($sortby === 'disputed' ){
		$dispute_status	= array('disputed');
	} elseif($sortby === 'refund_requested' ){
		$dispute_status	= array('publish');
	} elseif($sortby === 'resolve' ){
		$dispute_status	= array('resolved','refunded');
	}
}

$taskbot_args = array(
    'post_type'         => 'disputes',
    'post_status'       => $dispute_status,
    'posts_per_page'    => get_option('posts_per_page'),
    'paged'             => $paged,
    'orderby'           => 'date',
    'order'             => 'DESC',
	'meta_query' => array(
        array(
            'key'     => $meta_key,
            'value'   => $user_identity,
            'compare' => '=',
        ),
    ),
);

if(!empty($search)){
	$taskbot_args['s'] = esc_html($search);
}

$taskbot_query = new WP_Query( apply_filters('taskbot_dispute_listings_args', $taskbot_args) );
?>
<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="tb-dhb-mainheading tb-dhb-mainheadingv2">
				<h2><?php esc_html_e('Disputes listings', 'taskbot');?></h2>
				<div class="tb-sortby">
					<form class="tb-themeform tb-displistform">
						<input type="hidden" name="ref" value="<?php echo esc_attr($reference);?>" >
						<input type="hidden" name="mode" value="<?php echo esc_attr($mode);?>" >
						<input type="hidden" name="identity" value="<?php echo intval($user_identity);?>" >
						<fieldset>
							<div class="tb-themeform__wrap">
								<div class="form-group wo-inputicon wo-inputheight">
									<i class="tb-icon-search" id="dispute-search-btn"></i>
									<input type="text" id="dispute-search" name="search" value="<?php echo esc_attr($search);?>" class="form-control" placeholder="<?php esc_attr_e('Search task here', 'taskbot');?>">
								</div>
								<div class="wo-inputicon">
									<div class="tb-actionselect">
										<span><?php esc_html_e('Sort by', 'taskbot');?>: </span>
										<div class="tb-select">
											<select id="tb-selection1" name="sortby" class="form-control tk-selectv dispute-search-date">
												<option selected hidden><?php esc_html_e('All disputes', 'taskbot'); ?></option>
												<option value="disputed" <?php if(!empty($sortby) && $sortby == 'disputed'){echo esc_attr('selected');}?>><?php esc_html_e('New disputes', 'taskbot');?></option>
												<option value="resolve" <?php if(!empty($sortby) && $sortby == 'resolve'){echo esc_attr('selected');}?>><?php esc_html_e('Resolved disputes', 'taskbot');?></option>
												<option value="refund_requested" <?php if(!empty($sortby) && $sortby == 'refund_requested'){echo esc_attr('selected');}?>><?php esc_html_e('Refund requested', 'taskbot');?></option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
			<?php if ( $taskbot_query->have_posts() ) :?>
				<table class="table tb-table">
					<thead>
					<tr>
						<th><span><?php esc_html_e('Ref #', 'taskbot');?> </span></th>
						<th><?php echo esc_html($label);?></th>
						<th><?php esc_html_e('Dated', 'taskbot');?></th>
						<th><?php esc_html_e('Amount', 'taskbot');?></th>
						<th><?php esc_html_e('Status', 'taskbot');?></th>
						<th><?php esc_html_e('Action', 'taskbot');?></th>
					</tr>
					</thead>
					<tbody>
					<?php 
						while ( $taskbot_query->have_posts() ) : $taskbot_query->the_post();
							$buyer_id			= get_post_meta($post->ID, $meta_key, true);
							$order_id			= get_post_meta($post->ID, '_dispute_order', true);
							$dispute_type		= get_post_meta($post->ID, '_dispute_type', true);
							$dispute_type		= !empty($dispute_type) ? $dispute_type : "";
							$linked_user_id		= 0;
							if($user_type == 'buyers'){
								$linked_user_id = get_post_meta($post->ID, '_seller_id', true);
							} else if($user_type == 'sellers'){
								$linked_user_id = get_post_meta($post->ID, '_buyer_id', true);
							}
							$linked_profile_id = taskbot_get_linked_profile_id($linked_user_id);							
							$dispute_detail_url	= Taskbot_Profile_Menu::taskbot_profile_menu_link('disputes', $user_identity, true, 'detail',$post->ID);
							if( get_post_type( $order_id ) === 'proposals' ){
								$dispute_detail_url	= Taskbot_Profile_Menu::taskbot_profile_menu_link('proposals', $user_identity, true, 'dispute',$post->ID);
							}			
						?>
					<tr>
						<td data-label="<?php esc_attr_e('Ref #','taskbot');?>">
							<span><?php echo intval($post->ID);?></span>
						</td>
						<td data-label="<?php echo esc_attr(taskbot_get_username($linked_profile_id))?>"><a href="<?php echo esc_url(get_the_permalink($linked_profile_id));?>"><?php echo esc_html(taskbot_get_username($linked_profile_id))?></a> </td>
						<td data-label="<?php esc_attr_e('Dated', 'taskbot');?>"><?php echo esc_html(get_the_date());?></td>
						<td data-label="<?php esc_attr_e('Amount', 'taskbot');?>">
							<span>
								<?php 
									if( !empty($dispute_type) && $dispute_type === 'proposals' ){
										$total_amount		= get_post_meta($post->ID, '_total_amount', true);
										$total_amount		= !empty($total_amount) ? $total_amount : 0;
										taskbot_price_format($total_amount);
									} else {
										taskbot_price_format( taskbot_order_price($order_id));
									}
								?>
							</span>
						</td>
						<td data-label="<?php esc_attr_e('Status','taskbot');?>">
							<div class="tb-bordertags">
								<span class="tb-tag-bordered tb-dispute-<?php echo esc_html(get_post_status($post->ID));?>"><?php echo esc_html(taskbot_dispute_status($post->ID));?></span>
							</div>
							
						</td>
						<td data-label="<?php esc_attr_e('options','taskbot');?>">
							<span class="tb-tag-bordered">
								<a href="<?php echo esc_url($dispute_detail_url);?>" class="tb-vieweye"><span class="tb-icon-eye"></span> <?php esc_html_e('View', 'taskbot');?></a>
							</span>
						</td>
					</tr>
					<?php endwhile;?>
					</tbody>
				</table>
				<?php taskbot_paginate($taskbot_query); ?>					
			<?php else:
                $image_url = !empty($taskbot_settings['empty_listing_image']['url']) ? $taskbot_settings['empty_listing_image']['url'] : TASKBOT_DIRECTORY_URI . 'public/images/empty.png';
                ?>
				<div class="tb-submitreview tb-submitreviewv3">
					<figure>
						<img src="<?php echo esc_url($image_url);?>" alt="<?php esc_attr_e('No disputes', 'taskbot');?>">
					</figure>
					<h4><?php esc_html_e( 'There are no disputes against any task.', 'taskbot'); ?></h4>
				</div>
			<?php endif;
			wp_reset_postdata();?>
		</div>
	</div>
</div>