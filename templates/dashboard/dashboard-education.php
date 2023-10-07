<?php
/**
 * User education
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user, $taskbot_settings, $userdata, $post;

$reference 		 = !empty($_GET['ref'] ) ? esc_html($_GET['ref']) : '';
$mode 			 = !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity 	 = intval($current_user->ID);
$id 			 = !empty($args['id']) ? intval($args['id']) : '';
$user_type		 = apply_filters('taskbot_get_user_type', $current_user->ID );
$profile_id      = taskbot_get_linked_profile_id($user_identity,'',$user_type);
$user_type		 = apply_filters('taskbot_get_user_type', $user_identity );
$date_format	 = get_option( 'date_format' );
$tb_post_meta   = get_post_meta( $profile_id,'tb_post_meta',true );
$tb_post_meta   = !empty($tb_post_meta) ? $tb_post_meta : array();

$educations     	= !empty($tb_post_meta['education']) ? $tb_post_meta['education'] : array();
$education_array	= array();
?>
<div class="tb-dhb-profile-settings tb-education-wrapper">
	<div class="tb-tabtasktitle">
		<h5><?php esc_html_e('Educational details','taskbot');?></h5>
		<div class="tb-profileform__title--rightarea">
			<a href="javascript:void(0);" data-type="add" class="tb_show_education"><?php esc_html_e('Add new','taskbot');?></a>
		</div>
	</div>
	<div class="tb-dhb-box-wrapper">
		<div class="tb-themeform tb-profileform">
			<fieldset>
				<div class="tb-profileform__holder">
					<?php if( !empty($educations) ){?>
						<ul class="tb-detail tb-educationdetail">
							<?php 
							foreach($educations as $key => $value ){
								$degree_title	= !empty($value['title']) ? $value['title'] : '';
								$institute		= !empty($value['institute']) ? $value['institute'] : '';
								$startdate 		= !empty( $value['start_date'] ) ? $value['start_date'] : '';
								$enddate 		= !empty( $value['end_date'] ) ? $value['end_date'] : '';
								$description 	= !empty( $value['description'] ) ? wp_kses_post( stripslashes( $value['description'] ) ) : '';
								$start_date 	= !empty( $startdate ) ? date_i18n($date_format, strtotime(apply_filters('taskbot_date_format_fix',$startdate ))) : '';
								$end_date 		= !empty( $enddate ) ? date_i18n($date_format, strtotime(apply_filters('taskbot_date_format_fix',$enddate ))) : '';
								
								if( empty( $end_date ) ){
									$end_date = '';
								} else {
									$end_date	= ' - '.$end_date;
								}

								if( !empty( $start_date ) ){
									$period = $start_date.$end_date;
								}

								if( !empty($period) ){
									$institute	= $institute.' - '.$period;
								}

								$education_array[$key]	= $value;
								?>
								<li>
									<div class="tb-detail__content">
										<div class="tb-detail__title">
											<?php if( !empty($institute) ){?>
												<span><?php echo esc_html($institute);?></span>
											<?php } ?>
											<?php if( !empty($degree_title) ){ ?>
												<h6><a href="javascript:void(0);"><?php echo esc_html($degree_title);?></a></h6>
											<?php } ?>
										</div>
										<div class="tb-detail__icon">
											<a href="javascript:void(0);" data-id="<?php echo intval($user_identity);?>" data-type="edit" data-key="<?php echo intval($key);?>" class="tb-edit tb_show_education"><i class="icon-edit-2"></i></a>
											<a href="javascript:void(0);" data-id="<?php echo intval($user_identity);?>" data-key="<?php echo intval($key);?>" class="tb-delete tb_remove_edu"><i class="icon-trash-2"></i></a>
										</div>
									</div>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
				</div>
			</fieldset>
		</div>
	</div>
</div>
<script>
	var profile_education = [];
	window.profile_education	= <?php echo json_encode($education_array); ?>
</script>
<script type="text/template" id="tmpl-load-education">
	<form class="tb-themeform tb-formlogin" id="tb_update_education">
		<fieldset>
			<div class="form-group">
				<label class="form-group-title"><?php esc_html_e('Add degree title :','taskbot');?></label>
				<input type="text" name="education[{{data.counter}}][title]" value="{{data.title}}" class="form-control" placeholder="<?php esc_attr_e('Add degree title','taskbot');?>" autocomplete="off">
			</div>
			<div class="form-group">
				<label class="form-group-title"><?php esc_html_e('Add institute name :','taskbot');?></label>
				<input type="text" name="education[{{data.counter}}][institute]" value="{{data.institute}}" class="form-control" placeholder="<?php esc_attr_e('Add institute name','taskbot');?>" autocomplete="off">
			</div>
			<div class="form-group">
				<label class="form-group-title"><?php esc_html_e('Choose date','taskbot');?></label>
				<div class="tb-themeform__wrap">
					<div class="form-group tb-combine-group">
						<div class="tb-calendar">
							<input id="edu_start_date" value="{{data.start_date}}" name="education[{{data.counter}}][start_date]" type="text" class="form-control dateinit-{{data.counter}}tb-start-pick" placeholder="<?php esc_attr_e('Date from','taskbot');?>">
						</div>
						<div class="tb-calendar">
							<input id="edu_end_date" value="{{data.end_date}}" name="education[{{data.counter}}][end_date]" type="text" class="form-control dateinit-{{data.counter}}tb-end-pick" placeholder="<?php esc_attr_e('Date to','taskbot');?>">
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="form-group-title"><?php esc_html_e('Add description:','taskbot');?></label>
				<textarea class="form-control"  name="education[{{data.counter}}][description]" placeholder="<?php esc_attr_e('Description','taskbot');?>">{{{data.description}}}</textarea>
			</div>
			<div class="form-group tb-form-btn">
				<div class="tb-savebtn">
					<em><?php esc_html_e('Click “Save & Update” to update your educational details','taskbot');?></em>
					<a href="javascript:void(0);" data-mode="{{data.mode}}" data-key="{{data.key}}" data-id="<?php echo intval($user_identity);?>" id="tb_add_education" class="tb-btn"><?php esc_html_e('Save & Update','taskbot');?></a>
				</div>
			</div>
		</fieldset>
	</form>
</script>
<div class="modal fade tk-educationpopup" id="tb_educationaldetail" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog tb-modaldialog" role="document">
		<div class="modal-content">
			<div class="tb-popuptitle">
				<h4><?php esc_html_e('Add/edit educational details','taskbot');?></h4>
				<a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
			</div>
			<div class="modal-body" id="tb_add_education_frm"></div>
		</div>
	</div>
</div>
<?php
$counter = 0;
