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
global $current_user,$taskbot_settings;
$date_format	= get_option('date_format');
$order_id 		= get_user_meta($current_user->ID, 'package_order_id', true);
$order_id		= !empty($order_id) ? intval($order_id) : 0;

if(!empty($order_id) && class_exists('WooCommerce')){ ?>
	<div class="tk-package-plan">
		<?php 
			$order 			= wc_get_order($order_id);
			if(empty($order )){
				return;
			}

			$order_status	= $order->get_status();
			
			if ( !empty($order_status) && $order_status === 'completed' ) {
				$remaing_days			= 0;
				$current_time			= time();
				$package_id				= get_post_meta($order_id, 'package_id', true);
				$package_details  		= get_user_meta($current_user->ID, 'seller_package_details', true);
				$order_data    			= get_post_meta( $order_id, 'package_details',true );

				$package_details		= !empty($package_details) ? $package_details : array();
				$task_count       		= taskbot_get_user_tasks($current_user->ID, array('publish'));
				$featured_task       	= taskbot_get_user_tasks($current_user->ID, array('publish'),true);
				$package_create_date	= !empty($package_details['package_create_date']) ? $package_details['package_create_date'] : 0;
				$package_expriy_date	= !empty($package_details['package_expriy_date']) ? $package_details['package_expriy_date'] : 0;
				$package_create_date	= !empty($package_create_date) ? strtotime($package_create_date) : 0;
				$package_expriy_date	= !empty($package_expriy_date) ? strtotime($package_expriy_date) : 0;
				$number_tasks_allowed	= !empty($package_details['number_tasks_allowed']) ? $package_details['number_tasks_allowed'] : 0;
				$remaining_tasks		= !empty($number_tasks_allowed) && $number_tasks_allowed <= $task_count	? 0 : $number_tasks_allowed - $task_count;
				$featured_allowed		= !empty($package_details['featured_tasks_allowed']) ? $package_details['featured_tasks_allowed'] : 0;
				$number_project_credits		= !empty($package_details['number_project_credits']) ? $package_details['number_project_credits'] : 0;
				$allowed_project_credits	= !empty($order_data['number_project_credits']) ? $order_data['number_project_credits'] : 0;
				
				$remaining_featured		= empty($featured_allowed) || ( !empty($featured_allowed) && $featured_allowed < $featured_task)	? 0 : $featured_allowed - $featured_task;
				$package_id				= !empty($package_id) ? intval($package_id) : 0;
				$product_instant		= !empty($package_id)	? get_post( $package_id ) : '';
				$product_title			= !empty($product_instant) ? sanitize_text_field($product_instant->post_title) : '';
				$pkg_content			= !empty($product_instant) ? sanitize_text_field($product_instant->post_content) : '';
				$image_html				= !empty($package_id) ? get_the_post_thumbnail( $package_id, 'thumbnail' ) : '';
				   
				if($package_expriy_date >= $current_time ){
					$remaing_days	= $package_expriy_date-$current_time;
					$remaing_days	= round((($remaing_days/24)/60)/60); 
				}
 				?>
				<div class="tk-package-heading">
					<?php if( !empty($image_html) ){?>
						<figure><?php echo do_shortcode( $image_html );?></figure>
					<?php }?>
					<div class="tk-package-tags">
						<?php if( !empty($remaing_days)){?>
							<span class="tk-onging"><?php esc_html_e('Ongoing','taskbot');?></span>
						<?php } else { ?> 
							<span class="tk-onging tk-expire"><?php esc_html_e('Expired','taskbot');?></span>
						<?php } ?>
						<?php if( !empty($product_title) ){?>
							<h4><?php echo esc_html($product_title);?></h4>
						<?php } ?>
					</div>
				</div>
				<?php if( !empty($pkg_content) ){?>
					<div class="tk-description">
						<p><?php echo esc_html($pkg_content);?></p>
					</div>
				<?php } ?>
				<ul class="tk-package-list"> 
					<?php if( !empty($package_create_date) ){?>
						<li>
							<h6><?php esc_html_e('Purchased on','taskbot');?></h6>
							<span><?php echo date_i18n( $date_format, $package_create_date );?></span>
						</li>
					<?php } ?>
					<?php if( !empty($package_expriy_date) ){?>
						<li>
							<h6><?php esc_html_e('Expiry date','taskbot');?></h6>
							<span><?php echo date_i18n( $date_format, $package_expriy_date );?></span>
						</li>
					<?php } ?>
					<?php if( isset($remaing_days) ){?>
						<li>
							<h6><?php esc_html_e('Package duration','taskbot');?></h6>
							<span><?php echo wp_sprintf( esc_html__('%s days left', 'taskbot'), $remaing_days );?></span>
						</li>
					<?php } ?>
					<?php if( isset($remaining_tasks) ){?>
						<li>
							<h6><?php esc_html_e('No. of tasks to post','taskbot');?></h6>
							<h6><?php echo wp_sprintf( esc_html__('%s task left', 'taskbot'), $remaining_tasks );?><em>/<?php echo wp_sprintf( esc_html__('%s allowed', 'taskbot'), $number_tasks_allowed );?></em></h6>
						</li>
					<?php } ?>
					<?php if( isset($remaining_featured) ){?>
						<li>
							<h6><?php esc_html_e('Featured tasks','taskbot');?></h6>
							<h6><?php echo wp_sprintf( esc_html__('%s left', 'taskbot'), $remaining_featured );?><em>/<?php echo wp_sprintf( esc_html__('%s allowed', 'taskbot'), $featured_allowed );?></em></h6>
						</li>
					<?php } ?>

					<?php if( isset($number_project_credits) ){?>
						<li>
							<h6><?php esc_html_e('Credits','taskbot');?></h6>
							<h6><?php echo wp_sprintf( esc_html__('%s left', 'taskbot'), $number_project_credits );?><em>/<?php echo wp_sprintf( esc_html__('%s allowed', 'taskbot'), $allowed_project_credits );?></em></h6>
						</li>
					<?php } ?>
					<li>
						<h6><?php esc_html_e('Plan pricing','taskbot');?></h6>
						<span>
							<?php 
								if(!empty($package_details['task_plans_allowed']) && $package_details['task_plans_allowed'] == 'yes'){
									esc_html_e('Allowed','taskbot');
								} else {
									esc_html_e('Not allowed','taskbot');
								}
							?>
						</span>
					</li>
				</ul>
			<?php 
			}
		?>		
	</div>
<?php }?>