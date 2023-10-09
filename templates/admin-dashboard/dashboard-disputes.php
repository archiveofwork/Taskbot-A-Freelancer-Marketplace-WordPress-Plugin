<?php
/**
 * Dispute listings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/admin_dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user, $wp_roles, $userdata, $post, $taskbot_settings;

$reference 		 = !empty($_GET['ref'] ) ? $_GET['ref'] : '';
$mode 			 = !empty($_GET['mode']) ? $_GET['mode'] : '';
$user_identity 	 = intval($current_user->ID);
$id 			 = !empty($args['id']) ? $args['id'] : '';
$user_type		 = apply_filters('taskbot_get_user_type', $user_identity );
$label			 = esc_html__('Buyer name', 'taskbot');
$meta_key		 = '_seller_id';

if($user_type == 'buyers'){
	$meta_key	= '_send_by';
	$label		= esc_html__('Seller name', 'taskbot');
}

if ( !class_exists('WooCommerce') ) {
	return;
}

$dispute_posts_count	= wp_count_posts('disputes');
$price_symbol			= taskbot_get_current_currency();
$currency_symbol		= !empty($price_symbol['symbol']) ? $price_symbol['symbol'] : '$';

$paged	= ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$search	= !empty($_GET['search']) ? esc_html($_GET['search']) : '';
$status	= !empty($_GET['status']) ? esc_html($_GET['status']) : array('disputed','resolved','refunded');

if($status	== 'new'){
	$status	= 'publish';
} elseif($status	== 'resolved'){
	$status	= 'refunded';
}

$posts_per_page	= get_option('posts_per_page');
$taskbot_args = array(
    'post_type'         => 'disputes',
    'post_status'       => $status,
    'posts_per_page'    => $posts_per_page,
    'paged'             => $paged,
    'orderby'           => 'date',
    'order'             => 'DESC',	
);

if(!empty($search)){
	$taskbot_args['s'] = esc_html($search);
}

if(!empty($days)){
	$taskbot_args['date_query'] = array(
        'after' => date('Y-m-d', strtotime("-$days days")) 
    );
}

$taskbot_query	= new WP_Query( apply_filters('taskbot_dispute_listings_args', $taskbot_args) );
$total_posts	= (int)$taskbot_query->found_posts;

$dispute_percentage	= taskbot_disppute_date_query_count('disputes');
$percentChange		= !empty($dispute_percentage['percentChange']) ? $dispute_percentage['percentChange'] : '0';
$change				= !empty($dispute_percentage['change']) ? $dispute_percentage['change'] : 'decrease';

$change_class		= 'tb-icon-chevron-left';
$changearrow_class	= 'tb-icon-arrow-down';

if($change == 'increase'){
	$change_class		= 'tb-icon-chevron-right';
	$changearrow_class	= 'tb-icon-arrow-up';
}
$search_status	= !empty($status) && !is_array($status) ? $status : '';
?>
<div class="col-md-4 tb-md-50 tb-disputes-col">
	<div class="tb-dbholder">
		<div class="tb-dbbox tb-dbboxtitle">
			<h5><?php esc_html_e('Dispute summary', 'taskbot');?></h5>
		</div>
		<div class="tb-dbbox tb-asideboxvtwo" id="dispute-summary1">
			<?php taskbot_get_template_part('admin-dashboard/dashboard', 'disputes-summary');?>
		</div>
	</div>
</div>
<div class="col-md-8 tb-md-50 tb-disputes-col">
	<div class="tb-dhb-mainheading">
		<h2><?php esc_html_e('Disputes listings', 'taskbot');?></h2>
		<div class="tb-sortby">
			<form class="tb-themeform tb-displistform">
				<input type="hidden" name="ref" value="<?php echo esc_attr($reference);?>" >
				<input type="hidden" name="mode" value="<?php echo esc_attr($mode);?>" >
				<input type="hidden" name="identity" value="<?php echo intval($user_identity);?>" >

				<fieldset>
					<div class="tb-themeform__wrap">
						<div class="form-group tb-inputicon tb-inputheight tb-dbholder">
							<i class="tb-icon-search"></i>
							<input type="text" class="form-control" name="search" onkeyup="tablecellsearch()" id="myInputTwo" autocomplete="off" placeholder="<?php esc_attr_e('Search dispute listing', 'taskbot');?>">
						</div>
						<?php echo esc_attr($search_status);?>
						<div class="tb-actionselect">
						<span><?php esc_html_e('Sort by', 'taskbot');?>: </span>
							<div class="tb-select tb-dbholder border-0">
								<select id="tb-selection1" class="form-control dispute-status-select" name="status">
									<option value=""><?php esc_html_e('All disputes', 'taskbot');?></option>
									<option value="refunded" <?php if(!empty($search_status) && $search_status == 'refunded'){echo esc_attr('selected');}?>><?php esc_html_e('Resolved disputes', 'taskbot');?></option>
									<option value="disputed" <?php if(!empty($search_status)  &&  $search_status == 'disputed'){echo esc_attr('selected');}?>><?php esc_html_e('New disputes', 'taskbot');?></option>
								</select>
							</div>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
	<?php if ( $taskbot_query->have_posts() ) :?>
		<div class="tb-disputetable tb-disputetablev2">
			<table class="table tb-table tb-dbholder">
				<thead>
					<tr>
						<th> <?php esc_html_e('Ref #', 'taskbot');?></th>
						<th><?php esc_html_e('Buyer Name', 'taskbot');?></th>
						<th><?php esc_html_e('Seller Name', 'taskbot');?></th>
						<th><?php esc_html_e('Dated', 'taskbot');?></th>
						<th><?php esc_html_e('Status', 'taskbot');?></th>
						<th><?php esc_html_e('Action', 'taskbot');?></th>
					</tr>
				</thead>
				<tbody>
				<?php while ( $taskbot_query->have_posts() ) : $taskbot_query->the_post();
					$meta_key	= '_seller_id';
					if($user_type == 'buyers'){
						$meta_key	= '_send_by';
						$label	= esc_html__('Seller name', 'taskbot');
					}
					
					$seller_id	= get_post_meta($post->ID, '_seller_id', true);
					$buyer_id	= get_post_meta($post->ID, '_buyer_id', true);
					$order_id	= get_post_meta($post->ID, '_dispute_order', true);
					$buyer_profile_id	= taskbot_get_linked_profile_id($buyer_id,'','buyers');
					$seller_profile_id	= taskbot_get_linked_profile_id($seller_id,'','sellers');
					$post_type		= get_post_type( $order_id );
					if( !empty($post_type) && $post_type === 'proposals' ){
						$dispute_url	= Taskbot_Profile_Menu::taskbot_profile_admin_menu_link('project', $user_identity, true, 'dispute');
					} else {
						$dispute_url	= Taskbot_Profile_Menu::taskbot_profile_admin_menu_link('disputes', $user_identity, true, 'detail');
					}
					
					$dispute_url	= add_query_arg('id', $post->ID, $dispute_url);					
					?>
					<tr>
						<td data-label="<?php esc_attr_e('Ref #','taskbot');?>">
							<?php echo intval($post->ID);?>
						</td>
						<td data-label="<?php esc_html_e('Buyer Name', 'taskbot');?>">
							<?php if( !empty($buyer_profile_id) ){?>
								<a href="<?php echo esc_url(get_edit_post_link($buyer_profile_id));?>"><?php echo esc_html(taskbot_get_username($buyer_profile_id))?></a> 
							<?php } ?>
						</td>
						<td data-label="<?php esc_html_e('Seller Name', 'taskbot');?>"><a href="<?php echo esc_url(get_the_permalink($seller_profile_id));?>"><?php echo esc_html(taskbot_get_username($seller_profile_id))?></a> </td>
						<td data-label="<?php esc_attr_e('Dated', 'taskbot');?>"><?php echo esc_html(get_the_date());?></td>
						<td data-label="<?php esc_attr_e('Status','taskbot');?>">
							<div class="tb-bordertags">
								<span class="tb-tag-bordered tb-dispute-<?php echo esc_html(get_post_status($post->ID));?>"><?php echo esc_html(taskbot_dispute_status($post->ID));?></span>
							</div>
							
						</td>
						<td data-label="<?php esc_attr_e('Action','taskbot');?>">
							<span class="tb-tag-bordered">
								<a href="<?php echo esc_url($dispute_url);?>" class="tb-vieweye"><span class="tb-icon-eye"></span> <?php esc_html_e('View', 'taskbot');?></a>
							</span>
						</td>				
					</tr>
				  <?php endwhile;?>					
				</tbody>
			</table>
			<?php if($total_posts > $posts_per_page){?>
				<div class="tb-tabfilteritem">
					<?php taskbot_paginate($taskbot_query); ?>				
				</div>
			<?php }?>
		</div>
	<?php else:
        $image_url = !empty($taskbot_settings['empty_listing_image']['url']) ? $taskbot_settings['empty_listing_image']['url'] : TASKBOT_DIRECTORY_URI . 'public/images/empty.png';
        ?>
		<div class="tb-submitreview tb-submitreviewv3">
			<figure>
				<img src="<?php echo esc_url($image_url);?>" alt="<?php esc_attr_e( 'There are no disputes against any task.', 'taskbot'); ?>">
			</figure>
			<h4><?php esc_html_e( 'There are no disputes against any task.', 'taskbot'); ?></h4>
		</div>
	<?php endif;?>
</div>
<?php
wp_reset_postdata();
