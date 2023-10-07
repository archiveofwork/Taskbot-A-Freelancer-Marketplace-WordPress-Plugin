<?php
/**
 * Dispute listings
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public
 */
global  $post,$taskbot_settings;
$task_downloadable    =  !empty($taskbot_settings['task_downloadable']) ? $taskbot_settings['task_downloadable'] : '';
$post_id    = !empty($args['post_id']) ? intval($args['post_id']) : $post->ID;
$user_id	= !empty($post_id) ? taskbot_get_linked_profile_id( $post_id, 'post' ) : 0;
$user_id	= !empty($user_id) ? $user_id : 0;

$user_name  = !empty($post_id) ? taskbot_get_username($post_id) : '';
$is_verified= !empty($post_id) ? get_post_meta( $post_id, '_is_verified',true) : '';
$paged 		= ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$status		= !empty($post_status) ? $post_status : 'any';
$taskbot_args = array(
    'post_status'       => $status,
    'limit'    			=> get_option('posts_per_page'),
    'page'             	=> $paged,
    'author'            => $user_id,
    'orderby'           => 'ID',
    'order'             => 'DESC',
    'tax_query'         => array(
        array(
            'taxonomy' => 'product_type',
            'field'    => 'slug',
            'terms'    => 'tasks',
        ),
    ),
);
$taskbot_query = new WP_Query( apply_filters('taskbot_service_listings_args', $taskbot_args) );
?>
<div class="tb-tasklist">
	<?php if ( $taskbot_query->have_posts() ) :
		while ( $taskbot_query->have_posts() ) : $taskbot_query->the_post();
			global $post;
			$product 	= wc_get_product( $post->ID );
			?>
			<div class="tb-tasksitem">
				<div class="tb-tasksitem_head">
					<div class="tb-cards__title">
						<?php if( !empty($user_name) ){?>
							<a href="<?php echo get_the_permalink($post_id);?>">
								<?php echo esc_html($user_name);?>
								<?php if( !empty($is_verified) && $is_verified === 'yes'){?>
									<i class="icon-check-circle" <?php echo apply_filters('taskbot_tooltip_attributes', 'verified_user');?>></i>
								<?php } ?>
							</a>
						<?php } ?>
						<h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
						<ul class="tb-rateviews">
							<?php
								do_action('taskbot_service_rating_count', $product);
								do_action('taskbot_service_item_views', $product);
							?>
							<li><div class="tk-likev2"><?php do_action( 'taskbot_project_saved_item', $post->ID,'','_saved_tasks','list' );?></div></li>
						</ul>
					</div>
					<?php do_action('taskbot_service_item_starting_price', $product);?>
				</div>
				<div class="tb-tasksitem__footer">
					<ul class="tb-sales">
						<?php do_action( 'taskbot_service_sales', $product );?>
						<?php do_action( 'taskbot_service_delivery_time', $product );?>
						<?php 
							if( !empty($task_downloadable) ){
								do_action( 'taskbot_service_download', $product );
							}
						?>
					</ul>
					<div class="tb-tasksitem__btn">
						<a href="<?php the_permalink();?>" class="tb-btn tb-btnv2"><?php esc_html_e('View details','taskbot');?></a>
					</div>
				</div>
			</div>
		<?php endwhile;
		taskbot_paginate($taskbot_query,'tb-service-pagination');
	else:
      do_action( 'taskbot_empty_listing', esc_html__('No services found', 'taskbot'));
	endif;
	wp_reset_postdata();?>
</div>