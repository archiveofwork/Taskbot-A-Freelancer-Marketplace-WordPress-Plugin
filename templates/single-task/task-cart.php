<?php
/**
 * Single task author details
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public
 */
$plans			= !empty($taskbot_plans_values) ? $taskbot_plans_values : array();
$total_price	= 0;
$select_options	= '';

if( !empty($plans) ){
	$counter	= 0;
	foreach($plans as $key => $plan ){
		$title			= !empty($plan['title']) ? $plan['title'] : '';
		$price			= !empty($plan['price']) ? $plan['price'] : '';
		$selected		= '';
		
		if( empty($counter) ){
			$total_price	= $price;
			$selected		= 'selected';
		}

		if( !empty($title)){
			$select_options .= '<option id="tb-op-'.esc_attr($key).'" '.esc_attr($selected).' value="'.esc_attr($key).'" data-price="'.esc_attr($price).'">'.esc_html($title).'</option>';
		}

		$counter++;
	}
}
?>
<div class="tb-fixsidebar" id="tb-fixsidebar" style="display:none;">
	<div class="tb-messageuser">
		<div class="tb-tasktotalbudget">
			<div class="tb-tasktotal">
				<h5><?php esc_html_e('Add task details','taskbot');?></h5>
			</div>
			<a href="javascript:void(0);" class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></a>
		</div>
	</div>
	<div class="tb-addformtask">
		<div class="tb-packages__plan">
			<h6><em data-tippy-content="<?php esc_attr_e('Attachments','taskbot');?>" class="tippy tb-icon-info"></em> <?php esc_html_e('Total task budget','taskbot');?></h6>
			<h4 id="tb_total_price"><?php taskbot_price_format($total_price);?></h4>
		</div>
		<form class="tb-themeform tb-sidebarform" id="tb_cart_form">
			<fieldset>
				<div class="form-group-wrap">
					<div class="form-group form-vertical">
						<label class="tb-titleinput"><?php esc_html_e('Selected service:','taskbot');?></label>
						<input type="text" class="form-control disable" placeholder="<?php echo esc_attr($product->get_title());?>">
					</div>
					<div class="form-group form-vertical">
						<label class="tb-titleinput"><?php esc_html_e('Choose package plan:','taskbot');?></label>
						<div class="tb-select">
							<select class="form-control tb_project_task" id="tb_task_cart" data-task_id="<?php echo intval($task_id);?>" name="product_task">
								<?php echo do_shortcode( $select_options );?>
							</select>
						</div>
					</div>
					<?php if(!empty($taskbot_subtask)){?>
						<div class="form-group form-vertical">
							<label class="tb-titleinput"><?php esc_html_e('Choose addtional service:','taskbot');?></label>
							<ul class="tb-additionalchecklist mCustomScrollbar">
							<?php 
								foreach($taskbot_subtask as $key => $taskbot_subtask_id){
									$subtask_price 	= wc_get_product( $taskbot_subtask_id );
									$subtask_price	= !empty($subtask_price) ? $subtask_price->get_regular_price() : ''; ?>
									<li>
										<div class="tb-additionalservices__content">
											<div class="tb-checkbox">
												<input name="subtasks[]" class="tb_subtask_check" data-id="<?php echo intval($taskbot_subtask_id);?>" id="additionalservice-<?php echo intval($taskbot_subtask_id);?>" type="checkbox" data-price="<?php echo esc_attr($task_id);?>" value="<?php echo intval($taskbot_subtask_id);?>">
												<label for="additionalservice-<?php echo intval($taskbot_subtask_id);?>">
													<span><?php echo get_the_title($taskbot_subtask_id);?></span>
													<?php if( !empty($subtask_price) ){?>
														<em> ( +<?php taskbot_price_format($subtask_price);?> )</em>
													<?php } ?>
											</label>
											</div>
											<p><?php echo apply_filters( 'the_content', get_the_content(null, false, $taskbot_subtask_id));?></p>
										</div>
									</li>
								<?php  }?>
							</ul>    
						</div>
					<?php } ?>
					<div class="form-group m-0">
						<div class="tb-popupbtnarea">
							<a href="javascript:void(0);" data-id="<?php echo intval($task_id);?>" class="tb-btn" id="tb_btn_cart"><?php esc_html_e('Hire now','taskbot');?><span class="rippleholder tb-jsripple"><em class="ripplecircle"></em></span></a>
						</div>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>