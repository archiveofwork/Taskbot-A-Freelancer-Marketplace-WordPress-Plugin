<?php

/**
 * Dashboard saved items
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
 */
global $current_user, $wp_roles, $userdata, $post;

$reference			= !empty($_GET['ref']) ? esc_html($_GET['ref']) : '';
$mode 			    = !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$type 			    = !empty($_GET['type']) ? esc_html($_GET['type']) : 'sellers';
$user_identity		= intval($current_user->ID);
$id					= !empty($args['id']) ? intval($args['id']) : '';
$user_type		  	= apply_filters('taskbot_get_user_type', $current_user->ID);
$linked_profile 	= taskbot_get_linked_profile_id($user_identity, '', $user_type);
$user_type		  	= apply_filters('taskbot_get_user_type', $user_identity);
$paged 			    = (get_query_var('paged')) ? get_query_var('paged') : 1;
$show_posts     	= get_option('posts_per_page') ? get_option('posts_per_page') : 10;
if( !empty($type) && $type === 'product' ){
	$saved_tasks		= get_post_meta($linked_profile, '_saved_tasks', true);
	$saved_items		= !empty($saved_tasks) ? $saved_tasks : array();
} elseif( !empty($type) && $type === 'sellers' ){
	$saved_sellers		= get_post_meta($linked_profile, '_saved_sellers', true);
	$saved_items		= !empty($saved_sellers) ? $saved_sellers : array();
}elseif( !empty($type) && $type === 'projects' ){
	$saved_sellers		= get_post_meta($linked_profile, '_saved_projects', true);
	$saved_items		= !empty($saved_sellers) ? $saved_sellers : array();
}

$app_task_base      = taskbot_application_access('task');
$app_project_base   = taskbot_application_access('project');
$page_url 			= Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity, true, $mode);
?>
<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="tb-dhb-mainheading">
				<h2><?php esc_html_e('Saved items', 'taskbot'); ?></h2>
				<div class="tb-sortby">
					<div class="tb-actionselect tb-actionselect2">
						<span><?php esc_html_e('Show only:','taskbot');?></span>
						<div class="tb-select">
							<select id="tb_order_type" name="type" class="form-control tk-selectv">
								<option value="sellers" data-url="<?php echo esc_url($page_url);?>&type=sellers" <?php if( !empty($type) && $type === 'sellers'){ echo do_shortcode('selected');}?>><?php esc_html_e('Sellers','taskbot');?></option>
								<?php if( !empty($app_task_base) ){?>
									<option value="product" data-url="<?php echo esc_url($page_url);?>&type=product" <?php if( !empty($type) && $type === 'product'){ echo do_shortcode('selected');}?>><?php esc_html_e('Task','taskbot');?></option>
								<?php } ?>
								<?php if( !empty($app_project_base) ){?>
									<option value="product" data-url="<?php echo esc_url($page_url);?>&type=projects" <?php if( !empty($type) && $type === 'projects'){ echo do_shortcode('selected');}?>><?php esc_html_e('Projects','taskbot');?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<?php if (!empty($saved_items)) {
				$paged 			= (get_query_var('paged')) ? get_query_var('paged') : 1;
				$taskbot_args 	= array(
					'post_type'         => array($type),
					'post_status'       => 'any',
					'posts_per_page'    => $show_posts,
					'paged'             => $paged,
					'orderby'           => 'date',
					'order'             => 'DESC',
					'post__in' 			=> $saved_items,
				);

				if( !empty($type) && $type === 'projects' ){
					$taskbot_args['post_type']	= array('product');
				}
				$taskbot_query = new WP_Query(apply_filters('taskbot_service_listings_args', $taskbot_args));
				
				if ($taskbot_query->have_posts()) { ?>
					<?php if( !empty($type) && $type === 'product' ){?>
						<ul class="tb-savelisting">
							<?php do_action('taskbot_service_listing_before'); ?>
							<?php
							while ($taskbot_query->have_posts()) {
								$taskbot_query->the_post();
								$product = wc_get_product($post->ID);
								?>
								<li id="post-<?php the_ID(); ?>" <?php post_class('tb-tabbitem'); ?>>
									<?php if (!empty($product)) {
										do_action('taskbot_service_item_before', $product);
									}
									?>
									<div class="tb-tabbitem__list tb-tabbitem__listtwo">
										<div class="tb-deatlswithimg">
											<figure>
												
												<?php if (!empty($product)) {
													echo woocommerce_get_product_thumbnail('woocommerce_thumbnail');
													do_action('taskbot_service_featured_item', $product);
												} else {
													$avatar = apply_filters(
														'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 100, 'height' => 100), $post->ID), array('width' => 100, 'height' => 100)
													);?>
													<img src="<?php echo esc_url( $avatar );?>" alt="<?php esc_attr_e('User profile', 'taskbot'); ?>">
													<?php
												}
												?>
											</figure>
											<div class="tb-icondetails">
												<?php echo do_action('taskbot_task_categories', $post->ID, 'product_cat');?>
												<h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
												<ul class="tb-rateviews tb-rateviews2">
													<?php if (!empty($product)) {
														do_action('taskbot_service_rating_count', $product);
														do_action('taskbot_service_item_views', $product);
														do_action('taskbot_service_item_reviews', $product);
													} else {
														do_action('taskbot_get_freelancer_rating_cuont', $post->ID);
														do_action('taskbot_get_freelancer_views', $post->ID);
													}
													?>
												</ul>
											</div>
										</div>
										<div class="tb-itemlinks">
											<?php
												if (!empty($product)) {
													do_action('taskbot_service_item_starting_price', $product);
												}
												?>
											<ul class="tb-tabicon">
												<li><a href="<?php echo get_the_permalink($post->ID); ?>"><span class="tb-icon-external-link bg-gray"></span></a></li>
												<?php if (!empty($product)) {?>
														<li><?php do_action('taskbot_saved_item', $post->ID, $linked_profile, '_saved_tasks','list');?></li>
													<?php } else {
														do_action('taskbot_save_freelancer_html', $current_user->ID, $post->ID, '_saved_sellers', '', 'sellers');
													}
												?>
											</ul>
										</div>
									</div>
									<?php
										if (!empty($product)) {
											do_action('taskbot_service_item_after', $product);
										}
									?>
								</li>
							<?php
							}

							do_action('taskbot_service_listing_after');
							?>
						</ul>
					<?php } else if( !empty($type) && $type === 'projects' ){?>
						<ul class="tk-saved-item tb_saveprojectlisting">
							<?php do_action('taskbot_project_listing_before'); ?>
							<?php
							while ($taskbot_query->have_posts()) {
								$taskbot_query->the_post();
								global $post;
								$product            = wc_get_product();
                                $product_author_id  = get_post_field ('post_author', $product->get_id());
                                $linked_profile_id  = taskbot_get_linked_profile_id($product_author_id, '','buyers');
                                $user_name          = taskbot_get_username($linked_profile_id);
                                $is_verified    	= !empty($linked_profile_id) ? get_post_meta( $linked_profile_id, '_is_verified',true) : '';
                                $project_price      = taskbot_project_price($product->get_id());
                                $project_meta       = get_post_meta( $product->get_id(), 'tb_project_meta',true );
                                $project_meta       = !empty($project_meta) ? $project_meta : array();
                                $project_type       = !empty($project_meta['project_type']) ? $project_meta['project_type'] : '';
                                $post_status		= get_post_status( $product->get_id() );
								?>
								<li id="post-<?php the_ID(); ?>" <?php post_class('tb-tabbitem'); ?>>
									<?php if (!empty($product)) {
										do_action('taskbot_sproject_item_before', $product);
									}
									?>
									<div class="tk-project-wrapper">
                                    	<?php do_action( 'taskbot_featured_item', $product,'featured_project' );?>
										<div class="tk-project-box">
											<div class="tk-price-holder">
												<div class="tk-project_head">
													<div class="tk-verified-info">
														<strong>
															<?php echo esc_html($user_name);?>
															<?php do_action( 'taskbot_verification_tag_html', $linked_profile_id ); ?>
														</strong>
														<?php if( !empty($product->get_name()) ){?>
															<h5><a href="<?php echo esc_url(get_the_permalink( $product->get_id() ));?>"><?php echo esc_html($product->get_name());?></a></h5>
														<?php } ?>
													</div>
													<ul class="tk-template-view"> 
														<?php do_action( 'taskbot_posted_date_html', $product );?>
														<?php do_action( 'taskbot_location_html', $product );?>
														<?php do_action( 'taskbot_texnomies_html_v2', $product->get_id(),'expertise_level','tb-icon-briefcase' );?>
														<?php do_action( 'taskbot_hiring_freelancer_html', $product );?>
														<li><div class="tk-likev2"><?php do_action( 'taskbot_project_saved_item', $product->get_id(), '','_saved_projects', 'list' );?></div></li>
													</ul>
												</div>
												<?php if( isset($project_price) ){?>
													<div class="tk-price">
														<?php if( !empty($project_type) ){?>
															<?php do_action( 'taskbot_project_type_text', $project_type );?>
														<?php } ?>
														<h4><?php echo do_shortcode($project_price);?></h4>
														<div class="tk-project-option">
															<span class="tk-btn-solid-lg-lefticon"><a href="<?php echo get_the_permalink($product->get_id());?>"><?php esc_html_e('View detail','taskbot');?></a></span>
														</div>
													</div>
												<?php } ?>
											</div>
											<?php do_action( 'taskbot_term_tags', $product->get_id(),'skills','',7,'project' );?>
										</div>
									</div>
									<?php
										if (!empty($product)) {
											do_action('taskbot_project_item_after', $product);
										}
									?>
								</li>
							<?php
							}

							do_action('taskbot_project_listing_after');
							?>
						</ul>
					<?php }   else if( !empty($type) && $type === 'sellers' ){?>
						<div class="tb-freelancersearch">
							<?php while ($taskbot_query->have_posts()) {
								$taskbot_query->the_post();
								$seller_id        = get_the_ID();
								$seller_name      = taskbot_get_username($seller_id);
								$tb_post_meta     = get_post_meta($seller_id, 'tb_post_meta', true);
								$seller_tagline   = !empty($tb_post_meta['tagline']) ? $tb_post_meta['tagline'] : '';
								$app_task_base      		    = taskbot_application_access('task');
								$skills_base                    = 'project';
								if( !empty($app_task_base) ){
									$skills_base    = 'service';
								}
								?>
								<div class="tb-bestservice">
									<div class="tb-bestservice__content tb-bestservicedetail">
										<div class="tb-bestservicedetail__user">
											<div class="tk-price-holder">
												<div class="tb-asideprostatus">
													<?php do_action('taskbot_profile_image', $seller_id,'',array('width' => 300, 'height' => 300));?>
													<div class="tb-bestservicedetail__title">
														<?php if( !empty($seller_name) ){?>
															<h6>
																<a href="<?php echo esc_url( get_permalink()); ?>"><?php echo esc_html($seller_name); ?></a>
																<?php do_action( 'taskbot_verification_tag_html', $seller_id ); ?>
															</h6>
														<?php } ?>
														<?php if( !empty($seller_tagline) ){?>
															<h5><?php echo esc_html($seller_tagline); ?></h5>
														<?php } ?>
														<ul class="tb-rateviews">
															<?php do_action('taskbot_get_freelancer_rating_cuont', $seller_id); ?>
															<?php do_action('taskbot_get_freelancer_views', $seller_id); ?>
															<?php do_action('taskbot_save_freelancer_html', $current_user->ID, $seller_id, '_saved_sellers', '', 'sellers'); ?>
														</ul>
													</div>
												</div>
												<?php do_action('taskbot_user_hourly_starting_rate', $seller_id); ?>
											</div>
											<div class="tk-tags-holder">
												<?php the_excerpt(); ?>
												<?php do_action( 'taskbot_term_tags', $taskbot_query->ID,'skills','',15,$skills_base );?>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
					<?php
					taskbot_paginate($taskbot_query);
				} else {
					do_action('taskbot_empty_records_html', 'tb-empty-saved-items', esc_html__('No saved item found.', 'taskbot'));
				}
			} else {
				do_action('taskbot_empty_records_html', 'tb-empty-saved-items', esc_html__('No saved item found.', 'taskbot'));
			}
			wp_reset_postdata();
			?>
		</div>
	</div>
</div>
<?php
$script = "
jQuery(document).on('ready', function(){
    jQuery(document).on('change', '#tb_order_type', function (e) {
        let _this 	= $(this);
		let page_url = _this.find(':selected').data('url');
		window.location.replace(page_url);
    });
});
";
wp_add_inline_script( 'taskbot', $script, 'after' );