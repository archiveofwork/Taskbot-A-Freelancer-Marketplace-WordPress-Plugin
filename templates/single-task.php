<?php

/**
 *
 * The template used for displaying task detail
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $post, $thumbnail,$current_user;
do_action('taskbot_post_views', $post->ID,'taskbot_service_views');
get_header();
while (have_posts()) : the_post();
	$product 				= wc_get_product( $post->ID );
	$taskbot_plans_values 	= get_post_meta($post->ID, 'taskbot_product_plans', TRUE);
	$taskbot_plans_values	= !empty($taskbot_plans_values) ? $taskbot_plans_values : array();
	$plans_count			= !empty($taskbot_plans_values) && is_array($taskbot_plans_values) ? count($taskbot_plans_values) : 0;
	$product_cat 			= wp_get_post_terms( $post->ID, 'product_cat', array( 'fields' => 'ids' ) );
	$taskbot_subtask 		= get_post_meta($product->get_id(), 'taskbot_product_subtasks', TRUE);
	$post_status			= get_post_status( $post->ID );
	$post_author			= get_post_field( 'post_author', $post->ID );
	$post_id    			= !empty($post_author) ? taskbot_get_linked_profile_id($post_author,'','sellers') :'';
	$allow_user				= true;

	$user_name      = taskbot_get_username($post_id);

	if(!empty($post_status) && in_array($post_status,array('draft','rejected','pending'))){
		if( !is_user_logged_in( ) ){
			$allow_user			= false;
		} else {
			if( is_user_logged_in() && (current_user_can('administrator') || $current_user->ID == $post_author) ){
				$allow_user		= true;
			} else {
				$allow_user		= false;
			}
		}
	}	
	
	$plan_array	= array(
		'product_tabs' 			=> array('plan'),
		'product_plans_category'=> $product_cat
	);

	$acf_fields		= taskbot_acf_groups($plan_array);
	$taskbot_attr	= array(
		'task_id'   	=> $product->get_id(),
		'product'   	=> $product,
		'post_id'   	=> $post_id,
		'plan_array'	=> $plan_array,
		'acf_fields'	=> $acf_fields,
		'product'		=> $product,
		'taskbot_subtask'		=> $taskbot_subtask,
		'taskbot_plans_values'	=> $taskbot_plans_values,
	);
	?>
	<section class="tb-main-section overflow-hidden tb-main-bg">
		<div class="container">
			<?php
				if( empty($allow_user) ){
					do_action( 'taskbot_notification', esc_html__('Restricted access','taskbot'), esc_html__('Oops! you are not allowed to access this page','taskbot') );
				} else {?>
				<div class="row gy-4">
					<div class="col-lg-12">
                        <div class="tk-serviesbann">
                            <div class="tk-serviesbann__content">
                                <div class="tk-contentleft">
									<?php do_action( 'taskbot_featured_item', $product,'featured_task' );?>
                                    <h3><?php the_title();?></h3>
                                    <div class="tk-contenthasfig">
										<?php taskbot_get_template( 'single-task/task-details.php',$taskbot_attr); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-lg-7 col-xl-8">
						<div class="tk-servicewrap">
							<?php taskbot_get_template( 'single-task/gallery.php',$taskbot_attr); ?>
							<div class="tb-singleservice-tile">
								<div class="tk-text-wrapper">
									<?php
										echo wpautop(get_the_content());
										wp_link_pages( array(
											'before'	=> '<div class="tb-paginationvtwo"><nav class="tb-pagination"><ul>',
											'after'		=> '</ul></nav></div>',
										) );
									?>
								</div>
							</div>
							<div class="tb-servicedetailcontent">
								<?php
									taskbot_get_template('single-task/additional-services.php',$taskbot_attr);
									taskbot_get_template('single-task/task-tags.php',$taskbot_attr);
									taskbot_get_template('single-task/task-faqs.php',$taskbot_attr);
									taskbot_get_template('single-task/task-reviews.php',$taskbot_attr);
								?>
							</div>
						</div>
					</div>
					<div class="col-lg-5 col-xl-4">
						<aside class="tb-tabasidebar" id="taskbot-price-plans">
							<?php
								taskbot_get_template( 'single-task/price-plan-tabs.php',$taskbot_attr);
								taskbot_get_template( 'single-task/task-cart.php',$taskbot_attr);
								taskbot_get_template( 'single-task/author-box.php',$taskbot_attr);
								do_action('taskbot_product_ads_content');
							?>
						</aside>
					</div>
				</div>
			<?php } ?>
		</div>
	</section>
<?php
endwhile;

get_footer();