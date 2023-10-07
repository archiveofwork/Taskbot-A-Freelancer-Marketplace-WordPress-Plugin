<?php
/**
 * Single task price plan tabs
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public
 */
global $current_user, $taskbot_settings;
$post_id		= $product->get_id();
$plans			= !empty($taskbot_plans_values) ? $taskbot_plans_values : array();
$plans_count	= !empty($plans) && is_array($plans) ? count($plans) : 0;
$post_author	= get_post_field( 'post_author', $post_id );
$checkout_class	= 'tb_btn_checkout';
if( !empty($current_user->ID) && $post_author == $current_user->ID ){
	$checkout_class	= 'tb_btn_author';
}

$fetured_plan	= get_post_meta( $post_id, '_featured_package', true );
$fetured_plan	= !empty($fetured_plan) ? $fetured_plan : '';
$tab_contents = '';
if( !empty($plans) ){
	$tab_contents	.='';
?>
<div class="tb-asideholder tb-sidebartabholder">
	<div class="tb-asidebox tb-sidebartabs">
		<?php if( !empty($plans_count) && $plans_count>1){ ?>
			<ul class="nav tb-sidebartabs__pkgtitle" id="tb_tasktaks" role="tablist">
		<?php } ?>

		<?php
		$counter	= 0;				
		foreach($plans as $key => $plan ){
			$counter ++;
			$title				= !empty($plan['title']) ? $plan['title'] : '';
			$description		= !empty($plan['description']) ? $plan['description'] : '';
			$price				= !empty($plan['price']) ? $plan['price'] : '';
			$delivery_time    	= !empty($plan['delivery_time']) ? $plan['delivery_time'] : 0;
			$days				= !empty($delivery_time) ? get_field('days', 'delivery_time_'.$delivery_time) : '';
			$delivery_time		= sprintf(_n( '%s Day', '%s Days', intval($days), 'taskbot' ), intval($days));
			$custom_fields		= taskbot_task_custom_fields($post_id,$key);
			$cart_url      		= Taskbot_Profile_Menu::taskbot_custom_profile_menu_link('cart',$post_id,$key);
			
			$duplicate_key		= array();
			if( !empty($title) && !empty($price) ){
				$class			= '';
				$class_li		= '';
				$class_content	= '';
				if( !empty($fetured_plan) && $fetured_plan == $key ){
					$class_li		= 'tb-sideactive';
					$class			= 'active';
					$class_content	= 'show';
				} else if(empty($fetured_plan)){
					if( !empty($counter) && $counter == 1 ){
						$class_li		= 'tb-sideactive';
						$class			= 'active';
						$class_content	= 'show';
					}
				}

				$taskbot_icon_key	= 'task_plan_icon_'.$key;
				$task_plan_icon_url	= !empty($taskbot_settings[$taskbot_icon_key]['url']) ? $taskbot_settings[$taskbot_icon_key]['url'] : '';

				$tab_contents	.='<div class="tab-pane fade '.esc_attr($class_content).' '.esc_attr($class).'" id="'.esc_attr($key).'" role="tabpanel">';
				$tab_contents	.='<div class="tb-sidebarpkg">';
				$tab_contents	.='<div class="tb-sectiontitle tb-sectiontitlev2">';

				if(!empty($task_plan_icon_url)){
					$tab_contents	.='<img src="'.esc_url($task_plan_icon_url).'" alt="'.esc_attr($title).'">';
				}

				$tab_contents	.='<div class="tb-packegeplan">';
				$tab_contents	.='<h5>'.esc_html($title).'</h5>';
				$tab_contents	.='<h3>'.taskbot_price_format($price,'return').'</h3>';
				$tab_contents	.='</div>';
				$tab_contents	.='<p>'.esc_html($description).'</p>';

				if( !empty($acf_fields) || !empty($custom_fields['contents'])){
					$counter_checked	= 0;
					$tab_contents	.='<div class="tb-sectiontitle__list--title"><h6>'.esc_html__('Features included','taskbot').'</h6><ul class="tb-sectiontitle__list tb-sectiontitle__listv2">';

					if( !empty($acf_fields) ){
						foreach($acf_fields as $acf_field ){
							if(!empty($duplicate_key[$acf_field['key']]) && !empty($duplicate_key) && in_array($acf_field['key'],$duplicate_key)){
								//do nothing
							}else{
								$plan_value	= !empty($acf_field['key']) && !empty($plan[$acf_field['key']]) ? $plan[$acf_field['key']] : '--';
								$counter_checked++;
								$tab_contents	.= taskbot_task_package_details($acf_field,$plan_value);
								$duplicate_key[$acf_field['key']]	= $acf_field['key'];
							}

							
						}
					} 
					
					$tab_contents	.= !empty($custom_fields['contents']) ? $custom_fields['contents'] : '';
					$tab_contents	.='</ul></div>';
				}

				$tab_contents	.='';
				$tab_contents	.='</div>';
				$tab_contents	.='<div class="tb-sidebarpkg__btn">';
				$tab_contents	.='<a href="javascript:void(0);" data-url="'.esc_url( $cart_url ).'" data-type="task_cart" class="tb-btn '.esc_attr($checkout_class).'">'.esc_html__('Hire me for a task','taskbot').'<i class="icon-arrow-right"></i></a>';
				$tab_contents	.='</div>';
				$tab_contents	.='</div>';
				$tab_contents	.='</div>';

				if( !empty($plans_count) && $plans_count>1){ ?>
					<li class="nav-item <?php echo esc_attr($class_li);?>" role="presentation">
						<a class="nav-link <?php echo esc_attr($class);?>" data-delivery_time="<?php echo esc_attr( $delivery_time);?>"  id="<?php echo esc_attr($key);?>-tab" data-bs-toggle="tab" href="#<?php echo esc_attr($key);?>" role="tab" aria-bs-controls="<?php echo esc_html($title);?>" aria-bs-selected="true"><?php echo esc_html($title);?></a>
					</li>
				<?php }?>
		<?php }}?>

		<?php if( !empty($plans_count) && $plans_count>1){ ?>
			</ul>
		<?php } ?>
		
		<div class="tab-content" id="tb_tasktakscontents">
			<?php echo do_shortcode($tab_contents);?>
			<?php if( !empty($plans_count) && $plans_count>1){ ?>
				<div class="tb-share-section">
					<span class="tb-recommend"><?php esc_html_e('Compare packages','taskbot');?><i class="icon-refresh-ccw"></i></span>
				</div>
			<?php } ?>
			<ul class="tb-pkgresponse">
				<?php do_action( 'taskbot_service_sales', $product,'v2' );?>
				<?php do_action( 'taskbot_service_ratings', $product);?>
				<?php do_action( 'taskbot_service_delivery_time', $product,'v2' );?>
			</ul>
		</div>
	</div>
</div>
<?php }
$scripts	= "
	jQuery(function () {
		jQuery('a[data-bs-toggle=".'tab'."]').on('shown.bs.tab', function (e) {
			var delivery_time = jQuery(e.target).attr('data-delivery_time'); 
			jQuery('.tb-change-timedays h6').html(delivery_time);
		});
		
	});";
	$theme_version 		= wp_get_theme();
	if(!empty($theme_version->get( 'TextDomain' )) && ( $theme_version->get( 'TextDomain' ) === 'taskon' || $theme_version->get( 'TextDomain' ) === 'taskon-child' )){
	    wp_add_inline_script('taskon-callbacks', $scripts, 'after');
    } else if(!empty($theme_version->get( 'TextDomain' )) && ( $theme_version->get( 'TextDomain' ) === 'taskup' || $theme_version->get( 'TextDomain' ) === 'taskup-child' )){
        wp_add_inline_script('taskup-callbacks', $scripts, 'after');
    }