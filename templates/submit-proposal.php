<?php
/**
 * Template Name: Submit proposal
 *
 * @package     Taskbot
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0 http://localhost/www/taskbot/create-project/?step=1&page=projects
*/
get_header();
global $post, $current_user,$taskbot_settings;
$user_type			= apply_filters('taskbot_get_user_type', $current_user->ID );
$proposal_id		= !empty($_GET['id']) ? intval($_GET['id']) : 0;
$project_id        	= (isset($_GET['post_id'])) ? intval($_GET['post_id']) : '';
$post_url			= taskbot_get_page_uri('add_project_page');
$hide_fixed_milestone	= !empty($taskbot_settings['hide_fixed_milestone']) ? $taskbot_settings['hide_fixed_milestone'] : 'no';
$enable_milestone_feature     = !empty($taskbot_settings['enable_milestone_feature']) ? $taskbot_settings['enable_milestone_feature'] : 'yes';
$allow_project			= false;
$product				= array();
if( !empty($user_type) && $user_type == 'sellers'){
	$allow_project	= true;	
} else {
	$allow_project	= false;	
}

if( !empty($allow_project) ){
	$proposal_meta		= array();
	$proposal_status	= '';
	if( !empty($proposal_id) ){
		$project_id			= get_post_meta( $proposal_id, 'project_id',true );
		$project_id			= !empty($project_id) ? intval($project_id) : 0;
		$proposal_meta		= get_post_meta( $proposal_id, 'proposal_meta',true );
		$proposal_status	= get_post_status( $proposal_id );
		if(empty($project_id) || (!empty($proposal_status) && !in_array($proposal_status,array('draft','publish','pending') )) ){
			$allow_project	= false;
		}
	}
	
	$proposal_price	= isset($proposal_meta['price']) ? $proposal_meta['price'] : 0;
	$product		= wc_get_product( $project_id );
	$project_meta	= get_post_meta( $project_id, 'tb_project_meta',true);
	$project_type	= !empty($project_meta['project_type']) ? $project_meta['project_type'] : '';
	$commission		= !empty($taskbot_settings['admin_commision']) ? esc_html($taskbot_settings['admin_commision'].'%') : 0;
	$project_price	= taskbot_project_price($project_id);
	$price_options	= isset($proposal_price) ? taskbot_commission_fee($proposal_price,'return') : array();
	$milestone_image= taskbot_add_http_protcol(TASKBOT_DIRECTORY_URI . 'public/images/milestone.jpg');
	$fixed_image	= taskbot_add_http_protcol(TASKBOT_DIRECTORY_URI . 'public/images/fixed.png');
	$is_milestone	= !empty($project_meta['is_milestone']) ? $project_meta['is_milestone'] : '';
	$proposal_price	= isset($proposal_price) && $proposal_price > 0 ? $proposal_price : "";	
	
	$checked_fixed_type		= "";
	$checked_milestone_type	= "";
	$checked_fixed_class	= "";
	$checked_milestone_class= "";
	$milestone_content_class= "d-none";
	$all_milestone			= array();
	if( !empty($project_type) && $project_type === 'fixed' ){
		$checked_fixed_type		= "checked";
		$checked_milestone_type	= "";	
		$checked_fixed_class	= "active";
		$checked_milestone_class= "";
		$milestone_content_class= "d-none";
		$proposal_type	= !empty($proposal_meta['proposal_type']) ? $proposal_meta['proposal_type'] : '';
		if( !empty($proposal_type) && $proposal_type === 'fixed' ){
			$checked_fixed_type		= "checked";
			$checked_fixed_class	= "active";
		} else if( !empty($proposal_type) && $proposal_type === 'milestone' ){
			$checked_fixed_type		= "";
			$checked_fixed_class	= "";
			$checked_milestone_type	= "checked";
			$checked_milestone_class= "active";
			$milestone_content_class= "";	
			$all_milestone			= !empty($proposal_meta['milestone']) ? $proposal_meta['milestone'] : array();
		}
	}
}

if(!empty($hide_fixed_milestone) && $hide_fixed_milestone === 'yes'){
	$checked_milestone_type		= "checked";
	$checked_milestone_class	= "active";
	$milestone_content_class	= "";	
}

?>
<section class="tk-main-section">
	<div class="container">
		<div class="row gy-4">
			<?php if( !empty($allow_project) ){?>
				<div class="col-lg-7 col-xl-8">
					<div class="tk-projectbox">
						<div class="tk-project-box">
							<div class="tk-servicedetailtitle">
								<?php if( !empty($product) ){?>
									<h3><?php echo esc_html($product->get_name());?></h3>
								<?php } ?>
								<ul class="tk-blogviewdates">
									<?php do_action( 'taskbot_posted_date_html', $product );?>
									<?php do_action( 'taskbot_location_html', $product );?>
								</ul>
							</div>
						</div>
						<div class="tk-project-box">
							<form class="tk-themeform" id="tasbkot-submit-proposal">
								<fieldset>
									<div class="tk-themeform__wrap">
										<?php if( !empty($project_type) && $project_type === 'fixed' ){?>
										<div class="form-group tb-input-price">
											<label class="tk-label"><?php esc_html_e('Your budget working rate','taskbot');?></label>
											<div class="tk-placeholderholder">
												<input type="text" value="<?php echo esc_attr($proposal_price);?>" name="price" data-post_id="<?php echo intval($project_id);?>" class="form-control tb_proposal_price tk-themeinput" placeholder="<?php esc_attr_e('Enter your budget working rate','taskbot');?>">
											</div>
										</div>
										<div class="form-group">
											<ul class="tk-budgetlist">
												<li>
													<span><?php esc_html_e('Project total fixed budget','taskbot');?></span>
													<h6><?php echo do_shortcode($project_price);?></h6> 
												</li>
												<li>
													<span><?php esc_html_e('Your budget working rate','taskbot');?></span>
													<h6 id="tb_total_rate"><?php if( isset($proposal_price) ){taskbot_price_format($proposal_price);};?></h6>
												</li>
												<li>
													<span><?php echo sprintf( esc_html__('Admin commission fee (%s)','taskbot'),$commission);?></span>
													<h6 id="tb_service_fee"><?php if( isset($price_options['admin_shares']) ){taskbot_price_format($price_options['admin_shares']);}?></h6>
												</li>
											</ul>
										</div>
										<div class="form-group">
											<div class="tk-totalamout">
												<span><?php esc_html_e("Total amount you'll get","taskbot");?></span>
												<h5 id="tb_user_share"><?php if( isset($price_options['seller_shares']) ){taskbot_price_format($price_options['seller_shares']);}?></h5>
											</div>
										</div>
										<?php } else {
											do_action( 'taskbot_submit_proposal_form', $project_id,$proposal_id,$project_price,$price_options,$commission );
										} ?>
										
										<?php if( (!empty($is_milestone) && $is_milestone === 'yes') 
										&& (!empty($enable_milestone_feature) && $enable_milestone_feature == 'yes')){?>
											<div class="form-group tk-paid-version">
												<div class="tk-betaversion-wrap">
													<div class="tk-betaversion-info-two">
														<h5><?php esc_html_e("How do you want to be paid","taskbot");?></h5>
														<p><?php esc_html_e("Employer is open and happy to work with milestones in this project. Feel free to bid your customized milestones.","taskbot");?></p>
													</div>
													<ul class="tk-paid-option">
														<li>
															<div class="tk-projectpaid-list <?php echo esc_attr($checked_milestone_class);?>" data-class_id="tb-fixed-milestone">
																<input <?php echo esc_attr($checked_milestone_type);?> type="radio" id="tb-fixed-milestone" name="proposal_type" value="milestone">
																<lable class="tk-projectprice-option" for="tb-fixed-milestone">
																	<?php if( !empty($fixed_image) ){ ?>
																		<img src="<?php echo esc_attr($milestone_image);?>" alt="<?php esc_attr_e('milestone','taskbot');?>">
																	<?php } ?>
																	<h6><?php esc_html_e("Work with milestones","taskbot");?></h6>
																	<span><?php esc_html_e("Split your work and get paid partially on milestone completion.","taskbot");?></span>
																</lable>
															</div>
														</li>
														<?php if(!empty($hide_fixed_milestone) && $hide_fixed_milestone === 'no'){?>
														<li>
															<div class="tk-projectpaid-list <?php echo esc_attr($checked_fixed_class);?>" data-class_id="tb-fixed">
																<input <?php echo esc_attr($checked_fixed_type);?> type="radio" id="tb-fixed" name="proposal_type" value="fixed">
																<lable class="tk-projectprice-option" for="tb-fixed">
																	<?php if( !empty($fixed_image) ){ ?>
																		<img src="<?php echo esc_attr($fixed_image);?>" alt="<?php esc_attr_e('Fixed','taskbot');?>">
																	<?php } ?>
																	<h6><?php esc_html_e("Fixed price project","taskbot");?></h6>
																	<span><?php esc_html_e("Complete entire project and get full payment at the end.","taskbot");?></span>
																</lable>
															</div>
														</li>
														<?php }?>
													</ul>
													<div class="tk-add-price-slots <?php echo esc_attr($milestone_content_class);?>">
														<label class="tk-label"><?php esc_html_e("How many milestones you want to add?","taskbot");?>
															<a href="javascript:void(0)" class="tk-addicon" id="tb-add-milestone"><?php esc_html_e("Add milestone","taskbot");?> <i class="tb-icon-plus"></i></a>
														</label>
														<div id="tb-list-milestone">
															<?php if( !empty($all_milestone) ){
																	foreach($all_milestone as $key => $value){
																		$k_val	= !empty($key) ? $key : "";
																		$price	= isset($value['price']) ? $value['price'] : "";
																		$detail	= !empty($value['detail']) ? $value['detail'] : "";
																		$title	= !empty($value['title']) ? $value['title'] : "";
																		$status	= !empty($value['status']) ? $value['status'] : "";
																		?>
																		<div class="tk-milestones-prices" id="taskbot-milestone-<?php echo esc_attr($key);?>">
																			<div class="tk-grapinput">
																				<div class="tk-milestones-input">
																					<div class="tk-placeholderholder tk-addslots">
																						<input type="text" value="<?php echo esc_attr($price);?>" name="milestone[<?php echo esc_attr($key);?>][price]" class="form-control tk-themeinput" placeholder="<?php esc_attr_e('Enter price','taskbot');?>">
																					</div>
																					<div class="tk-placeholderholder">
																						<input type="text" value="<?php echo esc_attr($title);?>" name="milestone[<?php echo esc_attr($key);?>][title]" class="form-control tk-themeinput" placeholder="<?php esc_attr_e('Enter title','taskbot');?>">
																					</div>
																					<a href="javascript:;" data-id="<?php echo esc_attr($key);?>" class="tb-remove-milestone tk-removeicon"><i class="tb-icon-trash-2"></i></a>
																				</div>
																				<div class="tk-placeholderholder">
																					<textarea class="form-control tk-themeinput" name="milestone[<?php echo esc_attr($key);?>][detail]" placeholder="<?php esc_attr_e('Enter description', 'taskbot');?>"><?php echo do_shortcode($detail);?></textarea>
																				</div>
																			</div>
																			<input type="hidden" name="milestone[<?php echo esc_attr($key);?>][status]" value="<?php echo esc_attr($status);?>">
																		</div>
																<?php } ?>
															<?php } ?>
														</div>
													</div>
												</div>
											</div>
										<?php } ?>
										<div class="tk-comment-section">
											<div class="form-group">
												<label class="tk-label"><?php esc_html_e('Add special comments to employer','taskbot');?></label>
												<div class="tk-placeholderholder">
													<textarea class="form-control tk-themeinput" name="description" placeholder="<?php esc_attr_e('Enter your comments here','taskbot');?>"><?php if(!empty($proposal_meta['description']) ){echo do_shortcode( $proposal_meta['description'] );}?></textarea>
												</div>
											</div>
										</div>
									</div>
								</fieldset>
								<?php do_action( 'taskbot_after_proposal_form',$project_id,$proposal_id );?>
							</form>
						</div>
					</div>
					<div class="tk-proposal-btn">
						<a href="javascript:void(0)" class="tk-btn-solid-lg-lefticon tb_submit_task" data-type="publish" data-project_id="<?php echo intval($project_id);?>" data-proposal_id="<?php echo intval($proposal_id);?>"><?php esc_html_e('Submit bid now','taskbot');?></a>
						<?php if( empty($proposal_status)  || $proposal_status === 'draft'){?>
							<a href="javascript:void(0)" class="tk-btnline tb_submit_task" data-type="draft" data-project_id="<?php echo intval($project_id);?>" data-proposal_id="<?php echo intval($proposal_id);?>"><?php esc_html_e('Save as draft','taskbot');?></a>
						<?php } ?>
					</div>
				</div>
				<div class="col-lg-5 col-xl-4">
					<aside>
						<div class="tk-projectbox">
							<div class="tk-project-box tk-projectprice">
								<div class="tk-sidebar-title">
									<?php do_action( 'taskbot_project_type_tag', $product->get_id() );?>
									<?php do_action( 'taskbot_project_price_html', $product->get_id() );?>
								</div>
							</div>
							<div class="tk-project-box">
								<div class="tk-sidebar-title">
									<h5><?php esc_html_e('Project requirements','taskbot');?></h5>
								</div>
								<ul class="tk-project-requirement">
									<?php do_action( 'taskbot_total_hiring_freelancer_html', $product->get_id() );?>
									<?php do_action( 'taskbot_texnomies_html', $product->get_id(),'expertise_level',esc_html__('Expertise','taskbot'),'tb-icon-briefcase tk-darkred-icon' );?>
									<?php do_action( 'taskbot_texnomies_html', $product->get_id(),'languages',esc_html__('Languages','taskbot'),'tb-icon-book-open tk-yellow-icon' );?>
									<?php do_action( 'taskbot_texnomies_html', $product->get_id(),'duration',esc_html__('Project duration','taskbot'),'tb-icon-calendar tk-green-icon' );?>
									<?php do_action( 'taskbot_after_project_requirements', $product->get_id());?>
								</ul>
							</div>
						</div>
						<?php do_action( 'taskbot_project_seller_basic', $product->get_id() );?>
					</aside>
				</div>
			<?php } else { 
				do_action( 'taskbot_notification', esc_html__('Restricted access','taskbot'), esc_html__('Oops! you are not allowed to access this page','taskbot') );
			 } ?>
		</div>
	</div>
</section>
<?php if( (!empty($is_milestone) && $is_milestone === 'yes') && (!empty($enable_milestone_feature) && $enable_milestone_feature == 'yes')){?>
	<script type="text/template" id="tmpl-load-project-milestone">
		<div class="tk-milestones-prices" id="taskbot-milestone-{{data.id}}">
			<div class="tk-grapinput">
				<div class="tk-milestones-input">
					<div class="tk-placeholderholder tk-addslots">
						<input type="text" name="milestone[{{data.id}}][price]" class="form-control tk-themeinput" placeholder="<?php esc_attr_e('Enter price','taskbot');?>">
					</div>
					<div class="tk-placeholderholder">
						<input type="text" name="milestone[{{data.id}}][title]" class="form-control tk-themeinput" placeholder="<?php esc_attr_e('Enter title','taskbot');?>">
					</div>
					<a href="javascript:;" data-id="{{data.id}}" class="tb-remove-milestone tk-removeicon"><i class="tb-icon-trash-2"></i></a>
				</div>
				<div class="tk-placeholderholder">
					<textarea class="form-control tk-themeinput" name="milestone[{{data.id}}][detail]" placeholder="<?php esc_attr_e('Enter description', 'taskbot');?>"></textarea>
				</div>
			</div>
			<input type="hidden" name="milestone[{{data.id}}][status]" value="">
		</div>
	</script>
<?php } ?>
<?php
$scripts = " jQuery(document).ready(function () {
	jQuery('.tk-projectpaid-list').on('click',function(){
		let class_id	= jQuery(this).data('class_id');
		jQuery(this).prop( 'checked', false );

		if ( jQuery(this).hasClass('active') ) {
		  jQuery('#'+class_id).prop( 'checked', true );
		} else {
			jQuery('#'+class_id).prop( 'checked', true );
			jQuery('.tk-projectpaid-list').removeClass('active');
			jQuery(this).addClass('active');    
			jQuery('.tk-add-price-slots').toggleClass('d-none');
		}

		if(class_id === 'tb-fixed'){
			jQuery('.tk-add-price-slots').addClass('d-none');
		}else if(class_id === 'tb-fixed-milestone'){
			jQuery('.tk-add-price-slots').removeClass('d-none');
		}
	});

	removeMilestone();
	jQuery('#tb-add-milestone').on('click', function (e) {
		let counter 	            = taskbot_unique_increment(10);
		var load_milestone_temp 	= wp.template('load-project-milestone');
		var data 		            = {id: counter};
		load_milestone_temp	        = load_milestone_temp(data);
		jQuery('#tb-list-milestone').append(load_milestone_temp);
		removeMilestone();
	});

	function removeMilestone(){
		jQuery('.tb-remove-milestone').on('click', function (e) {
			jQuery(this).closest('.tk-milestones-prices').remove();
		});
	}
	var tk_sortable = document.getElementById('tb-list-milestone');
	if (tk_sortable !== null) {
		var tk_sortable = Sortable.create(tk_sortable, {
			animation: 350,
		});
	} 
});";
wp_add_inline_script('taskbot', $scripts, 'before');
get_footer();
