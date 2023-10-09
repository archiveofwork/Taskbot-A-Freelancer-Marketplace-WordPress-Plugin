<?php
/**
 * Template Name: Administrator Dashboard
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
if( ! current_user_can('administrator') ){
    $redirect_url   = get_home_url();
    wp_redirect( $redirect_url );
    exit;
}

global $current_user, $taskbot_settings;
$url_identity 	= !empty($_GET['identity']) ? intval($_GET['identity']) : '';
$reference 		= !empty($_GET['ref'] ) ? $_GET['ref'] : '';
$mode 			= !empty($_GET['mode']) ? $_GET['mode'] : '';

if(isset($_POST['months']) || isset($_POST['years']) && $reference == 'earnings' && $mode == 'manage'){
	$month	    = !empty($_POST['months']) ? sprintf("%02d", $_POST['months']) : '';
	$year	    = !empty($_POST['years']) ? $_POST['years'] : '';
	$file_name	= !empty($month) ? $month.'-'.$year : 'earnings';
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename="'.$file_name.'.csv"');

	ob_end_clean();

	$output_handle 		= fopen('php://output', 'w');
	$payout_methods		= taskbot_get_payouts_lists();
	$filename           = "website_data_" . date('Ymd') . ".xls";
	$withdraw_titles	= array(
        esc_html__('User name','taskbot'),
        esc_html__('Account title','taskbot'),
        esc_html__('Price','taskbot'),
        esc_html__('Status','taskbot'),
        esc_html__('Month','taskbot'),
        esc_html__('Year','taskbot'),
        esc_html__('Details','taskbot'),
	);

	$staus		= array('pending','publish','rejected');
	$args_array = array(
		'post_status'		=> $staus,
		'post_type'			=> 'withdraw',
		'posts_per_page' 	=> -1,
	);


	if( !empty($year) ){
		$args_array['meta_query'][] = array('key' 		=> '_year',
											'value' 	=> intval($year),
											'compare' 	=> '=',
										);
	}

	if( !empty($month) ){
		$args_array['meta_query'][] = array(
											'key' 		=> '_month',
											'value' 	=> $month,
											'compare' 	=> '=',
										);
	}

	$post_data		= get_posts($args_array);
	$csv_fields     = array();

	foreach($withdraw_titles as $title){
		$csv_fields[] = $title;
	}

	fputcsv($output_handle, $csv_fields);

	if( !empty($post_data) ){
		foreach($post_data as $row){
			$post_author	= !empty($row->post_author) ? $row->post_author : 0;
			$seller_name	= !empty($post_author) ? taskbot_get_username($post_author) : '';

			$account_name			= get_post_meta( $row->ID, '_payment_method' ,true);
			$account_name			= !empty($account_name) ? $account_name : '';

			$account_name_val	= !empty($account_name) && !empty($payout_methods[$account_name]['label']) ? $payout_methods[$account_name]['label'] : '';
			$account_details	= get_post_meta( $row->ID, '_account_details',true );
			$account_details	= !empty($account_details) ? maybe_unserialize( $account_details ) : array();

			$account_detail		= '';
			$payout_details	= array();

			if( !empty($payout_methods[$account_name]['fields'])) {
				foreach( $payout_methods[$account_name]['fields'] as $key => $field ){

					if(isset($account_details[$key])){
						$account_detail			.= $field['title'].':';
						$account_detail			.= ' ';
						$account_detail			.= !empty($account_details[$key]) ? $account_details[$key]."\r	" : '';
					}

				}
			}

			$price			= get_post_meta( $row->ID, '_withdraw_amount' ,true);
			$price			= !empty($price) ? $price : 0;
			$year			= get_post_meta( $row->ID, '_year' ,true);
			$year			= !empty($year) ? $year : 0;
			$month			= get_post_meta( $row->ID, '_month' ,true);
			$month			= !empty($month) ? $month : 0;
			$status			= get_post_status( $row->ID );
			$status			= !empty($status) ? ucfirst($status) : '';
			$row_data       = array();
			$row_data['seller_name']	= $seller_name;
			$row_data['account']		= $account_name_val;
			$row_data['price']			= html_entity_decode(taskbot_price_format($price,'return'));
			$row_data['status']			= $status;
			$row_data['month']			= $month;
			$row_data['year']			= $year;
			$row_data['details']		= $account_detail;
			$OutputRecord = $row_data;
			fputcsv($output_handle, $OutputRecord);
		}
	}

	fclose( $output_handle );
	exit;
}

$user_identity 	= intval($current_user->ID);
$user_type		= apply_filters('taskbot_get_user_type', $user_identity );
$redirect_url   = '';

if( !is_user_logged_in() ){
    $redirect_url   = get_home_url();
} else if( !empty($user_type) && $user_type != 'administrator' ){
    $redirect_url  = !empty($taskbot_settings['tpl_dashboard']) ? get_the_permalink( $taskbot_settings['tpl_dashboard'] ) : '';
}

if( !empty($redirect_url) ){
    wp_redirect( $redirect_url );
    exit;
}

get_header();
$post_id		= taskbot_get_linked_profile_id( $user_identity );
$user_name      = !empty($current_user->user_login) ? $current_user->user_login : '';
do_action('taskbot_start_before_wrapper');

$avatar_url = get_avatar_url($current_user->ID,array('size',40));

?>

<div class="tb-mainwrapper">
    <div class="tb-sidebarwrapperholder">
        <aside id="tb-sidebarwrapper" class="tb-sidebarwrapper">
            <div id="tb-btnmenutogglev2" class="tb-btnmenutogglev2">
                <a href="javascript:void(0);"><i class="tb-icon-sliders"></i></a>
            </div>
            <div id="tb-btnmenutoggle" class="tb-btnmenutoggle">
                <a href="javascript:void(0);"><i class="tb-icon-sliders"></i></a>
            </div>
            <div class="tb-adminhead">
                <?php if( !empty($avatar_url) ){?>
                    <strong class="tb-adminhead__img">
                        <a href="javascript:void(0);">
                            <img src="<?php echo esc_url($avatar_url);?>" alt="<?php echo esc_attr($user_name);?>">
                        </a>
                    </strong>
                <?php } ?>
                <?php if( !empty($user_name) ){?>
                    <div class="tb-adminhead__title">
                        <h4><?php esc_html_e('Administrator','taskbot');?></h4>
                        <span><?php echo esc_html($user_name);?></span>
                    </div>
                <?php } ?>
            </div>
            <nav id="tb-navdashboard" class="tb-navdashboard">
                <ul><?php taskbot_get_template_part('dashboard/menus/admin/menu', 'list-items');?></ul>
            </nav>
        </aside>
    </div>
    <div class="tb-subwrapper">
        <div class="theme-container">
            <div class="tb-main">
                <div class="row">
                <?php if( have_posts() ):
                    while ( have_posts() ) : the_post();
                        the_content();
                        wp_link_pages( array(
                                'before'      => '<div class="tb-paginationvtwo"><nav class="tb-pagination"><ul>',
                                'after'       => '</ul></nav></div>',
                        ) );
                    endwhile;
					
                    if (is_user_logged_in() ) {
                        if ( !empty($reference) && !empty($mode) && $reference === 'task' && $mode === 'listing' && $user_type === 'sellers') {
                            taskbot_get_template_part('dashboard/dashboard', 'services-listing');

                        }else if ( !empty($reference) && $reference === 'inbox' ) {
                            taskbot_get_template_part('admin-dashboard/dashboard', 'inbox');
                        }else if ( !empty($reference) && !empty($mode) && $reference === 'disputes' && $mode === 'listing') {
                            taskbot_get_template_part('admin-dashboard/dashboard', 'disputes');
                        }else if ( !empty($reference) && !empty($mode) && $reference === 'disputes' && $mode === 'detail') {
                            taskbot_get_template_part('admin-dashboard/dashboard', 'disputes-detail');

                        }else if ( !empty($reference) && !empty($mode) && $reference === 'project' && $mode === 'dispute') {
                            taskbot_get_template_part('admin-dashboard/dashboard', 'project-disputes-detail');

                        }else if ( !empty($reference) && !empty($mode) && $reference === 'saved' && $mode === 'listing') {
                            taskbot_get_template_part('admin-dashboard/dashboard', 'saved-items');
                        }else if ( !empty($reference) && !empty($mode) && $reference === 'notifications' && $mode === 'listing') {
                            taskbot_get_template_part('admin-dashboard/dashboard', 'notifications');
                        }else if ( !empty($reference) && $reference === 'inbox' ) {
                            taskbot_get_template_part('admin-dashboard/dashboard', 'inbox');
                        }else if ( !empty($reference) && $reference === 'earnings') {
                            taskbot_get_template_part('admin-dashboard/dashboard', 'earnings');
                        } else if ( !empty($reference) && $reference === 'task') {
                            taskbot_get_template_part('admin-dashboard/dashboard', 'task');
                        }  else if ( !empty($reference) && $reference === 'projects') {
                            taskbot_get_template_part('admin-dashboard/dashboard', 'projects');
                        }  else {
                            taskbot_get_template_part('admin-dashboard/dashboard', 'insights');
                        }
                    }

                endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tb_completetask" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog tb-modaldialog" role="document">
        <div class="modal-content">
            <div class="tb-popuptitle">
                <h4 id="tb_ratingtitle"><?php esc_html_e('Complete Task','taskbot');?></h4>
                <a href="javascript:void(0);" class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></a>
            </div>
            <div class="modal-body" id="tb_taskcomplete_form"></div>
        </div>
    </div>
</div>
<div class="modal fade tb-excfreelancerpopup" id="tb_excfreelancerpopup" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog tb-modaldialog" role="document">
		<div class="modal-content" id="tb_tk_viewrating">
		</div>
	</div>
</div>
<script type="text/template" id="tmpl-load-completedtask_form">
    <div class="tb-completetask">
        <div class="tb-themeform">
            <fieldset>
                <div class="tb-themeform__wrap">
                    <div class="form-group">
                        <div class="tb-my-ratingholder">
                            <ul id="tb_stars-{{data.order_id}}" class='tb-rating-stars tb_stars'>
                                <li class='tb-star' data-value='1'  data-id="{{data.order_id}}">
                                    <i class='tb-icon-star fa-fw'></i>
                                </li>
                                <li class='tb-star' data-value='2'  data-id="{{data.order_id}}">
                                    <i class='tb-icon-star fa-fw'></i>
                                </li>
                                <li class='tb-star' data-value='3'  data-id="{{data.order_id}}">
                                    <i class='tb-icon-star fa-fw'></i>
                                </li>
                                <li class='tb-star' data-value='4'  data-id="{{data.order_id}}">
                                    <i class='tb-icon-star fa-fw'></i>
                                </li>
                                <li class='tb-star' data-value='5'  data-id="{{data.order_id}}">
                                    <i class='tb-icon-star fa-fw'></i>
                                </li>
                            </ul>
                            <span><?php esc_html_e('1','taskbot');?></span>
                            <input type="hidden" id="tb_task_rating-{{data.order_id}}" name="rating" value="1">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="tb_rating_title-{{data.order_id}}" name="title" placeholder="<?php esc_attr_e('Add feedback title','taskbot');?>">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="tb_rating_details-{{data.order_id}}" name="details" placeholder="<?php esc_attr_e('Feedback','taskbot');?>"></textarea>
                    </div>
                    <div class="form-group tb-formbtn">
                        <ul class="tb-formbtnlist">
                            <li id="tb_without_feedback"><a href="javascript:void(0);" data-task_id="{{data.task_id}}" data-order_id="{{data.order_id}}" class="tb-btn tb-plainbtn tb_complete_task"><?php esc_html_e('Complete without feedback','taskbot');?></a></li>
                            <li><a href="javascript:void(0);" data-task_id="{{data.task_id}}" data-order_id="{{data.order_id}}" class="tb-btn tb-greenbg tb_rating_task"><?php esc_html_e('Complete now','taskbot');?></a></li>
                        </ul>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</script>
<script type="text/template" id="tmpl-load-cancelledtask_form">
    <div class="tb-completetask">
        <div class="tb-themeform">
            <fieldset>
                <div class="tb-themeform__wrap">
                    <div class="form-group">
                        <textarea class="form-control" id="tb_details-{{data.order_id}}" name="details" placeholder="<?php esc_attr_e('Add cancellation reason','taskbot');?>"></textarea>
                    </div>
                    <div class="form-group tb-formbtn">
                        <ul class="tb-formbtnlist">
                            <li><a href="javascript:void(0);" data-task_id="{{data.task_id}}" data-order_id="{{data.order_id}}" class="tb-btn tb-greenbg tb_cancelled_task"><?php esc_html_e('Cancel task','taskbot');?></a></li>
                        </ul>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</script>
<script type="text/template" id="tmpl-load-rating_form">
    <div class="tb-completetask">
        <div class="tb-themeform">
            <fieldset>
                <div class="tb-themeform__wrap">
                    <div class="form-group pt-0">
                        <div class="tb-my-ratingholder">
                            <ul id="tb_stars-{{data.order_id}}" class='tb-rating-stars tb_stars'>
                                <li class='tb-star' data-value='1'  data-id="{{data.order_id}}">
                                    <i class='tb-icon-star fa-fw'></i>
                                </li>
                                <li class='tb-star' data-value='2'  data-id="{{data.order_id}}">
                                    <i class='tb-icon-star fa-fw'></i>
                                </li>
                                <li class='tb-star' data-value='3'  data-id="{{data.order_id}}">
                                    <i class='tb-icon-star fa-fw'></i>
                                </li>
                                <li class='tb-star' data-value='4'  data-id="{{data.order_id}}">
                                    <i class='tb-icon-star fa-fw'></i>
                                </li>
                                <li class='tb-star' data-value='5'  data-id="{{data.order_id}}">
                                    <i class='tb-icon-star fa-fw'></i>
                                </li>
                            </ul>
                            <span><?php esc_html_e('1','taskbot');?></span>
                            <input type="hidden" id="tb_task_rating-{{data.order_id}}" name="rating" value="1">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="tb_rating_title-{{data.order_id}}" name="title" placeholder="<?php esc_attr_e('Add feedback title','taskbot');?>">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="tb_rating_details-{{data.order_id}}" name="details" placeholder="<?php esc_attr_e('Feedback','taskbot');?>"></textarea>
                    </div>
                    <div class="form-group tb-formbtn">
                        <ul class="tb-formbtnlist">
                            <li><a href="javascript:void(0);" data-task_id="{{data.task_id}}" data-order_id="{{data.order_id}}" class="tb-btn tb-greenbg tb_taskrating_task"><?php esc_html_e('Complete now','taskbot');?></a></li>
                        </ul>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</script>

<?php
do_action('taskbot_admin_dashboard_after_wrapper');
get_footer('admin');
