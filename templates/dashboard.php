<?php
/**
 * Template Name: Dashboard
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $current_user;
$user_identity  = intval($current_user->ID);
$user_type		= apply_filters('taskbot_get_user_type', $user_identity );
$url_identity   = !empty($_GET['identity']) ? intval($_GET['identity']) : '';
$reference 		= !empty($_GET['ref'] ) ? $_GET['ref'] : '';
$mode 			= !empty($_GET['mode']) ? $_GET['mode'] : '';
$redirect_url   = '';

if( !is_user_logged_in() ){
    $redirect_url   = taskbot_get_page_uri('login');
} else if( !empty($user_type) && !in_array($user_type,array('sellers','buyers') )){
  $redirect_url   = get_home_url();
} else if( !empty($user_type) && in_array($user_type,array('sellers','buyers') )){
    $redirect_url   = taskbot_get_page_access($user_identity,$user_type,$reference,$mode);
}

if( !empty($url_identity) && $user_identity != $url_identity ){
    $redirect_url   = taskbot_get_page_uri('dashboard');
}

if(empty($reference) && !empty($user_type) && $user_type === 'sellers'){
    $redirect_url = Taskbot_Profile_Menu::taskbot_profile_menu_link('earnings', $user_identity, true, 'insights');
}

if( !empty($redirect_url) ){
    wp_redirect( $redirect_url );
    exit;
}

get_header();

$post_id		= taskbot_get_linked_profile_id( $user_identity );

do_action('taskbot_start_before_wrapper');

$deactive_account	= get_post_meta( $post_id, '_deactive_account', true );
$deactive_account	= !empty($deactive_account) ? $deactive_account : 0;

$is_verified 	= get_user_meta($user_identity, '_is_verified', true);
$is_verified    = !empty($is_verified) ? $is_verified : '';
$app_task_base      = taskbot_application_access('task');
$app_project_base   = taskbot_application_access('project');
if( !empty($deactive_account) && $deactive_account == 1 ){ ?>
    <section class="overflow-hiddentb-main-section tb-deactived-account">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="tb-deactived-popup">
                        <div class="tb-alertpopup">
                            <span class="tb-redbgbf tb-red">
                                <i class="tb-icon-slash"></i>
                            </span>
                            <h3><?php esc_html_e('Account deactivated','taskbot');?></h3>
                            <p><?php esc_html_e("You can not perform any action without restoring your account.Click “Restore my account” and let's get started","taskbot");?></p>
                            <ul class="tb-btnareafull">
                                <li><span data-id="<?php echo intval($url_identity);?>" class="tb-pb tb-active-account tb-greenbtn"><?php esc_html_e('Remove anyway','taskbot');?></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } else { ?>
    <section class="overflow-hidden tb-main-section">
        <div class="container">
            <?php 
                if( empty($mode) || $mode != 'verification' ){
                    do_action( 'taskbot_verify_account_notice', $is_verified );
                }
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <?php
                        if( have_posts() ):
                            while ( have_posts() ) : the_post();
                                the_content();
                                wp_link_pages( array(
                                        'before'      => '<div class="tb-paginationvtwo"><nav class="tb-pagination"><ul>',
                                        'after'       => '</ul></nav></div>',
                                ) );
                            endwhile;

                            if ( !empty($reference) && $reference === 'cart' && $user_type === 'buyers') {
                                taskbot_get_template_part('dashboard/dashboard', 'cart-page');
                            } else if ( !empty($reference) && $reference === 'offers-cart' && $user_type === 'buyers') {
                                do_action( 'taskbot_offers_cart', $args );
                            } elseif (is_user_logged_in() && $url_identity === $user_identity ) {
                                if ( !empty($app_task_base) && !empty($reference) && !empty($mode) && $reference === 'task' && $mode === 'listing' && $user_type === 'sellers') {
                                    taskbot_get_template_part('dashboard/dashboard', 'services-listing');
                                } else if ( !empty($reference) && !empty($mode) && $reference === 'offers' && $mode === 'listing') {
                                    do_action( 'taskbot_offers_listing', $args );
                                } else if ( !empty($app_task_base) && !empty($reference) && $reference === 'tasks-orders') {
                                    if( !empty($mode) && $mode == 'detail' ){
                                        taskbot_get_template_part('dashboard/dashboard', $user_type.'-tasks-detail');
                                    } else {
                                        taskbot_get_template_part('dashboard/dashboard', $user_type.'-tasks-orders');
                                    }
                                } else if ( !empty($reference) && !empty($mode) && $reference === 'dashboard' && ( $mode === 'verification' || $mode === 'billing' || $mode === 'profile' || $mode === 'account' ) ) {
                                    taskbot_get_template_part('dashboard/dashboard', 'settings',array( 'id' => $url_identity ) );
                                }else if ( !empty($reference) && !empty($mode) && $reference === 'disputes' && $mode === 'listing') {
                                    taskbot_get_template_part('dashboard/dashboard', 'disputes');
                                }else if ( !empty($reference) && !empty($mode) && $reference === 'disputes' && $mode === 'detail') {
                                    taskbot_get_template_part('dashboard/dashboard', 'disputes-detail');
                                }else if ( !empty($reference) && !empty($mode) && $reference === 'saved' && $mode === 'listing') {
                                    taskbot_get_template_part('dashboard/dashboard', 'saved-items');
                                }else if ( !empty($reference) && !empty($mode) && $reference === 'notifications' && $mode === 'listing') {
                                    taskbot_get_template_part('dashboard/dashboard', 'notifications');
                                }else if ( !empty($reference) && !empty($mode) && $reference === 'projects' && !empty($app_project_base)) {
                                    if( !empty($user_type) && $user_type === 'buyers' ){
                                        if( !empty($mode) && $mode === 'listing' ){
                                            taskbot_get_template_part('dashboard/post-project/buyer/dashboard', 'buyer-projects');
                                        } else if( !empty($mode) && $mode === 'activity' ){
                                            taskbot_get_template_part('dashboard/post-project/buyer/dashboard', 'proposals-activity');
                                        } 
                                    } elseif( !empty($user_type) && $user_type === 'sellers' ){
                                        if( !empty($mode) && $mode === 'listing' ){
                                            taskbot_get_template_part('dashboard/post-project/seller/dashboard', 'seller-projects');
                                        }else if( !empty($mode) && $mode === 'activity'){
                                            taskbot_get_template_part('dashboard/post-project/seller/dashboard', 'proposals-activity');
                                        }
                                    }
                                }else if ( !empty($reference) && !empty($mode) && $reference === 'proposals' && !empty($app_project_base)) {
                                    if( !empty($user_type) && $user_type === 'buyers' ){
                                        if( !empty($mode) && $mode === 'listing'){
                                            taskbot_get_template_part('dashboard/post-project/buyer/dashboard', 'project-proposals');
                                        } else if( !empty($mode) && $mode === 'detail'){
                                            taskbot_get_template_part('dashboard/post-project/buyer/dashboard', 'proposals-detail');
                                        }else if( !empty($mode) && $mode === 'dispute'){
                                            taskbot_get_template_part('dashboard/post-project/dashboard', 'disputes-detail');
                                        }
                                    } else if( !empty($user_type) && $user_type === 'sellers' ){
                                        if( !empty($mode) && $mode === 'dispute'){
                                            taskbot_get_template_part('dashboard/post-project/dashboard', 'disputes-detail');
                                        }
                                    }
                                }else if ( !empty($reference) && $reference === 'inbox' || !empty($reference) && $reference === 'chat' ) {
                                    taskbot_get_template_part('dashboard/dashboard', 'inbox');
                                }else if ( !empty($reference) && $reference === 'earnings' && $user_type === 'sellers' ) {
                                    taskbot_get_template_part('dashboard/dashboard', 'earnings');
                                }else if ( !empty($reference) && $reference === 'invoices' ) {
                                    if (  !empty($mode) && $mode === 'detail'){
                                        $args               = array();
                                        $args['identity']   = !empty($_GET['identity']) ? intval($_GET['identity']) : "";
                                        $args['order_id']   = !empty($_GET['id']) ? intval($_GET['id']) : "";
                                        ?>
                                        <div class="tb-invoicehead">
                                            <span data-order_id="<?php echo intval($args['order_id']);?>" class="tb-download-pdf tb-btn"><i class="tb-icon-download"></i><?php esc_html_e('Export PDF','taskbot');?></span>
                                        </div>
                                        <?php
                                        if(!empty($user_type ) && $user_type === 'buyers' ) {
                                            taskbot_get_template_part('dashboard/dashboard', 'invoice-detail',$args);
                                        } elseif(!empty($user_type ) && $user_type === 'sellers' ) {
                                            taskbot_get_template_part('dashboard/dashboard', 'seller-invoice-detail',$args);
                                        }
                                    } else if( !empty($mode) && $mode === 'listing'){
                                        taskbot_get_template_part('dashboard/dashboard', 'invoices');
                                    } else if( !empty($mode) && $mode === 'hourly-detail'){
                                        $args               = array();
                                        $args['identity']   = !empty($_GET['identity']) ? intval($_GET['identity']) : "";
                                        $args['order_id']   = !empty($_GET['id']) ? intval($_GET['id']) : "";
                                        ?>
                                        <div class="tb-invoicehead">
                                            <span data-order_id="<?php echo intval($args['order_id']);?>" class="tb-download-pdf tb-btn"><i class="tb-icon-download"></i><?php esc_html_e('Export PDF','taskbot');?></span>
                                        </div>
                                        <?php
                                        if(!empty($user_type ) && $user_type === 'buyers' ) {
                                            do_action( 'taskbot_buyer_invoice_details', $args );
                                        } elseif(!empty($user_type ) && $user_type === 'sellers' ) {
                                            do_action( 'taskbot_seller_invoice_details', $args );
                                        } 
                                    }

                                }else if ( !empty($app_task_base) &&  !empty($reference) && $reference === 'orders' && $user_type === 'sellers') {
                                    taskbot_get_template_part('dashboard/dashboard', $user_type.'-tasks-orders');
                                }else {
                                    taskbot_get_template_part('dashboard/dashboard', 'insights');
                                }
                            } elseif (is_user_logged_in()) {
                                taskbot_get_template_part('dashboard/dashboard', 'insights');
                            }
                            do_action( 'taskbot_load_dashboard_templates');
                        endif;
                    ?>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="tb_completetask" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog tb-modaldialog" role="document">
            <div class="modal-content">
                <div class="tb-popuptitle">
                    <h4 id="tb_project_ratingtitle"><?php esc_html_e('Complete task','taskbot');?></h4>
                    <a href="javascript:void(0);" class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body tk-taskcomplete_popup" id="tb_taskcomplete_form"></div>
            </div>
        </div>
    </div>
    <?php do_action( 'taskbot_project_completed_model' );?>
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
                            <label class="tb-titleinput"><?php esc_attr_e('Feedback title','taskbot');?></label>
                            <input type="text" class="form-control" id="tb_rating_title-{{data.order_id}}" name="title" placeholder="<?php esc_attr_e('Add feedback title','taskbot');?>">
                        </div>
                        <div class="form-group">
                            <label class="tb-titleinput"><?php esc_attr_e('Task rating','taskbot');?></label>
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
                                <input type="hidden" id="tb_task_rating-{{data.order_id}}" name="rating" value="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="tb-titleinput"><?php esc_attr_e('Add feedback','taskbot');?></label>
                            <textarea class="form-control" id="tb_rating_details-{{data.order_id}}" name="details" placeholder="<?php esc_attr_e('Feedback','taskbot');?>"></textarea>
                        </div>
                        <div class="form-group tb-formbtn">
                            <ul class="tb-formbtnlist">
                                <li id="tb_without_feedback">
                                    <a href="javascript:void(0);" data-task_id="{{data.task_id}}" data-order_id="{{data.order_id}}" data-user_id="<?php echo intval($url_identity);?>" class="tb-btn tb-plainbtn tb_complete_task"><?php esc_html_e('Complete without feedback','taskbot');?></a>
                                </li>
                                <li><a href="javascript:void(0);" data-task_id="{{data.task_id}}" data-user_id="<?php echo intval($url_identity);?>" data-order_id="{{data.order_id}}" class="tb-btn tb-greenbg tb_rating_task"><?php esc_html_e('Submit','taskbot');?></a></li>
                            </ul>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </script>
    <script type="text/template" id="tmpl-load-completedproject_form">
        <div class="tb-completetask">
            <div class="tb-themeform">
                <fieldset>
                    <div class="tb-themeform__wrap">
                        <div class="form-group">
                            <label class="tb-titleinput"><?php esc_attr_e('Feedback title','taskbot');?></label>
                            <input type="text" class="form-control" id="tb_rating_title-{{data.order_id}}" name="title" placeholder="<?php esc_attr_e('Add feedback title','taskbot');?>">
                        </div>
                        <div class="form-group">
                            <label class="tb-titleinput"><?php esc_attr_e('Project rating','taskbot');?></label>
                            <div class="tb-my-ratingholder">
                                <ul id="tb_stars-{{data.proposal_id}}" class='tb-rating-stars tb_stars'>
                                    <li class='tb-star' data-value='1'  data-id="{{data.proposal_id}}">
                                        <i class='tb-icon-star fa-fw'></i>
                                    </li>
                                    <li class='tb-star' data-value='2'  data-id="{{data.proposal_id}}">
                                        <i class='tb-icon-star fa-fw'></i>
                                    </li>
                                    <li class='tb-star' data-value='3'  data-id="{{data.proposal_id}}">
                                        <i class='tb-icon-star fa-fw'></i>
                                    </li>
                                    <li class='tb-star' data-value='4'  data-id="{{data.proposal_id}}">
                                        <i class='tb-icon-star fa-fw'></i>
                                    </li>
                                    <li class='tb-star' data-value='5'  data-id="{{data.proposal_id}}">
                                        <i class='tb-icon-star fa-fw'></i>
                                    </li>
                                </ul>
                                <input type="hidden" id="tb_task_rating-{{data.proposal_id}}" name="rating" value="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="tb-titleinput"><?php esc_attr_e('Add feedback','taskbot');?></label>
                            <textarea class="form-control" id="tb_rating_details-{{data.proposal_id}}" name="details" placeholder="<?php esc_attr_e('Feedback','taskbot');?>"></textarea>
                        </div>
                        <div class="form-group tb-formbtn">
                            <ul class="tb-formbtnlist">
                                <li id="tb_without_feedback">
                                    <a href="javascript:void(0);" data-proposal_id="{{data.proposal_id}}" data-user_id="<?php echo intval($url_identity);?>" class="tb-btn tb-plainbtn tb_complete_project"><?php esc_html_e('Complete without review','taskbot');?></a>
                                </li>
                                <li><a href="javascript:void(0);" data-user_id="<?php echo intval($url_identity);?>" data-proposal_id="{{data.proposal_id}}" class="tk-btn-solid-lg tb-greenbg tb_rating_project"><?php esc_html_e('Complete contract','taskbot');?></a></li>
                            </ul>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </script>
    <script type="text/template" id="tmpl-load-project-rating">
        <div class="tb-completetask">
            <div class="tb-themeform">
                <fieldset>
                    <div class="tb-themeform__wrap">
                        <div class="form-group pt-0">
                            <div class="tb-my-ratingholder">
                                <ul id="tb_stars-{{data.proposal_id}}" class='tb-rating-stars tb_stars'>
                                    <li class='tb-star' data-value='1'  data-id="{{data.proposal_id}}">
                                        <i class='tb-icon-star fa-fw'></i>
                                    </li>
                                    <li class='tb-star' data-value='2'  data-id="{{data.proposal_id}}">
                                        <i class='tb-icon-star fa-fw'></i>
                                    </li>
                                    <li class='tb-star' data-value='3'  data-id="{{data.proposal_id}}">
                                        <i class='tb-icon-star fa-fw'></i>
                                    </li>
                                    <li class='tb-star' data-value='4'  data-id="{{data.proposal_id}}">
                                        <i class='tb-icon-star fa-fw'></i>
                                    </li>
                                    <li class='tb-star' data-value='5'  data-id="{{data.proposal_id}}">
                                        <i class='tb-icon-star fa-fw'></i>
                                    </li>
                                </ul>
                                <span><?php esc_html_e('1','taskbot');?></span>
                                <input type="hidden" id="tb_task_rating-{{data.proposal_id}}" name="rating" value="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="tb_rating_title-{{data.proposal_id}}" name="title" placeholder="<?php esc_attr_e('Add feedback title','taskbot');?>">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="tb_rating_details-{{data.proposal_id}}" name="details" placeholder="<?php esc_attr_e('Feedback','taskbot');?>"></textarea>
                        </div>
                        <div class="form-group tb-formbtn">
                            <ul class="tb-formbtnlist">
                                <li><a href="javascript:void(0);" data-user_id="<?php echo intval($url_identity);?>" data-proposal_id="{{data.proposal_id}}" class="tk-btn-solid-lg tb-greenbg tb_rating_project"><?php esc_html_e('Complete contract','taskbot');?></a></li>
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
                                <li><a href="javascript:void(0);" data-task_id="{{data.task_id}}" data-order_id="{{data.order_id}}" data-user_id="<?php echo intval($url_identity);?>"  class="tb-btn tb-greenbg tb_cancelled_task"><?php esc_html_e('Cancel task','taskbot');?></a></li>
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
<?php }
do_action('taskbot_dashboard_after_wrapper');
get_footer();
