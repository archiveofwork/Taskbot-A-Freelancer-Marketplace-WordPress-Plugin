<?php
/**
 * Task detail activity history
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public
 */
global  $current_user;

if ( !class_exists('WooCommerce') ) {
	return;
}

$order_id           = !empty($_GET['id']) ? intval($_GET['id']) : 0;
$current_user_type  = apply_filters('taskbot_get_user_type', $current_user->ID);
$post_type          = !empty($order_id) ? get_post_type($order_id) : '';
$disputes_order_id  = !empty($post_type) && $post_type === 'disputes' ? get_post_meta( $order_id, '_dispute_order',true ) : 0;
$disputes_order_type= !empty($disputes_order_id) ? get_post_type( $disputes_order_id ) : '';
if(!empty($post_type) && $post_type === 'disputes' && !empty($disputes_order_id) && !empty($current_user_type) && $current_user_type ==='administrator' ){
  $order_id   = $disputes_order_id;
}
$task_id            = get_post_meta( $order_id, 'task_product_id', true);
$task_id            = !empty($task_id) ? $task_id : 0;
$seller_id          = get_post_meta( $order_id, 'seller_id', true);
$seller_id          = !empty($seller_id) ? intval($seller_id) : 0;
$task_status        = get_post_meta( $order_id, '_task_status', true);
$task_status        = !empty($task_status) ? $task_status : '';
$gmt_time           = current_time( 'mysql', 1 );
$order_type         = $task_status;
$task_title         = get_the_title($task_id);

$args   = array(
    'post_id'       => $order_id,
    'orderby'       => 'date',
    'order'         => 'ASC',
    'hierarchical' => 'threaded',
);
$comments = get_comments( $args );
?>

<!-- comments -->
<?php if (isset($comments) && !empty($comments)){?>
    <div class="tb-additonolservices tb-taskhistory">
        <div class="tb-additonoltitle">
            <h5>
                <?php 
                    if( !empty($disputes_order_type) && $disputes_order_type === 'proposals' ){
                        esc_html_e('Project history','taskbot'); 
                    } else {
                        esc_html_e('Task history','taskbot'); 
                    }
                ?>
            </h5>
        </div>
        <div class="tb-additionolinfo">
            <div class="tb-blogcommentsholder tb-blogcommentsholdervone">
                <?php
                    foreach ($comments as $key => $value) {
                        do_action('taskbot_activity_chat_history',$value,'parent',$current_user->ID);

                        // check if comment's children
                        $comment_children = array();
                        $comment_children = $value->get_children();

                        if (!empty($comment_children)){
                            foreach ($comment_children as $comment_child){
                            do_action('taskbot_activity_chat_history',$comment_child,'child',$current_user->ID);
                            }
                        }
                    }
                ?>

                <?php if (!empty($task_status) && $task_status == 'completed'){ ?>
                    <div class="tb-addcomment ">
                        <div class="tb-description">
                            <div class="tb-statustag">
                                <span class="tb-approved"><i class="far fa-check-circle"></i><?php esc_html_e('Approved','taskbot'); ?></span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<!-- comments end -->

<!-- message area -->
<?php if (!empty($task_status) && $task_status == 'hired' && isset($current_user_type) && $current_user_type != 'administrator'){ ?>
    <div class="tb-additonolservices tb-addtaskfile" id="chat_box_section">
        <div class="tb-additonoltitle">
            <h5><?php esc_html_e('Add task documents / files','taskbot'); ?></h5>
        </div>
        <div class="tb-additionolinfo">
            <form class="tb-themeform tb-project-chat-form">
                <fieldset>
                    <?php if (isset($current_user_type) && $current_user_type == 'sellers') { ?>
                        <ul class="tb-resvsionbtn-holder">
                            <li class="form-group-half">
                                <div class="tb-radio">
                                    <input type="radio" id="x-option" name="message_type" value="revision" checked="">
                                    <label for="x-option">
                                        <span><?php esc_html_e('Send as a revision','taskbot'); ?></span>
                                    </label>
                                </div>
                            </li>
                            <li class="form-group-half">
                                <div class="tb-radio">
                                    <input type="radio" id="y-option" name="message_type" value="final">
                                    <label for="y-option">
                                        <span><?php esc_html_e('Send as a final attempt','taskbot'); ?></span>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    <?php } ?>
                    <div class="tb-profileform__holder">
                        <div class="tb-profileform__content">
                            <textarea name="activity_detail" class="form-control form-controltwo" placeholder="<?php esc_attr_e('Enter description','taskbot');?>"></textarea>
                        </div>
                        <div class="tb-taskuploadtitle">
                            <h6><?php esc_html_e('Upload task documents / files:', 'taskbot');?> <span>(<?php esc_html_e('Add up to 3', 'taskbot');?>)</span></h6>
                        </div>
                        <div class="tb-profileform__content">
                            <div class="tb-uploadarea" id="taskbot-upload-attachment">
                                <ul class="tb-uploadbar tb-bars taskbot-fileprocessing taskbot-infouploading" id="taskbot-fileprocessing"></ul>
                                <div class="tb-uploadbox taskbot-dragdroparea" id="taskbot-droparea" >
                                    <em>
                                        <?php echo wp_sprintf( '%1$s %2$s', esc_html__( 'You can upload jpg,jpeg,gif,png,zip,rar,mp3 mp4 and pdf only.', 'taskbot'), esc_html__( 'Make sure your file does not exceed 3mb.', 'taskbot') );?>
                                        <label for="file1">
                                            <span id="taskbot-attachment-btn-clicked">
                                                <input id="file1" type="file" name="file">
                                                <?php esc_html_e('Click here to upload', 'taskbot');?>
                                            </span>
                                        </label>
                                    </em>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tb-taskbtn">
                        <a href="javascript:void(0)"  class="tb-btn tb-submit-project-chat" data-id="<?php echo esc_attr( $order_id ); ?>"><?php esc_html_e('Submit', 'taskbot'); ?></a>
                    </div>
                </fieldset>
                <script type="text/template" id="tmpl-load-chat-media-attachments">
                    <li id="thumb-{{data.id}}" class="taskbot-list">
                        <div class="tb-filedesciption">
                            <span>{{data.name}}</span>
                            <input type="hidden" class="attachment_url" name="attachments[{{data.attachment_id}}]" value="{{data.url}}">
                            <em class="tb-remove"><a href="javascript:void(0)" class="taskbot-remove-attachment tb-remove-attachment"><?php esc_html_e('Remove', 'taskbot');?></a></em>
                        </div>
                        <div class="progress">
                            <div class="progress-bar uploadprogressbar" style="width:0%"></div>
                        </div>
                    </li>
                </script>
            </form>
        </div>
    </div>
<?php } ?>