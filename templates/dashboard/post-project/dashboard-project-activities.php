<?php
global $taskbot_settings;

$proposal_id    = !empty($args['proposal_id']) ? intval($args['proposal_id']) : 0;
$project_id     = !empty($args['project_id']) ? intval($args['project_id']) : 0;
$seller_id      = !empty($args['seller_id']) ? intval($args['seller_id']) : 0;
$proposal_status= !empty($args['proposal_status']) ? esc_attr($args['proposal_status']) : 0;
$profile_id     = taskbot_get_linked_profile_id($seller_id, '','sellers');
$user_name      = taskbot_get_username($profile_id);
$avatar         = apply_filters( 'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 50, 'height' => 50), $profile_id), array('width' => 50, 'height' => 50));
$proposal_price = isset($args['proposal_meta']['price']) ? $args['proposal_meta']['price'] : 0;
$args   = array(
    'post_id'       => $proposal_id,
    'orderby'       => 'date',
    'order'         => 'DESC',
    'hierarchical'  => 'threaded',
    'type'          => 'activity_detail '
);
$comments = get_comments( $args );
?>

<div class=" tab-pane fade show active" id="project-activities" role="tabpanel" aria-labelledby="project-activities-tab">
    <?php if( !empty($comments) ){?>
        <div class="tk-proactivity">
            <ul class="tk-proactivity_list mCustomScrollbar">
                <?php
                    foreach ($comments as $key => $value) { 
                        do_action( 'taskbot_project_comments_history', $value );
                    }
                ?>
            </ul>
        </div>
    <?php } else { ?>
        <div class="tk-proactivity">
            <?php do_action( 'taskbot_empty_listing', esc_html__('No project activities found', 'taskbot')); ?>
        </div>
    <?php } ?>
    <?php if( !empty($proposal_status) && $proposal_status === 'hired' ){?>
        <form class="tk-themeform tk-uploadfile-doc tb-project-comment-form">
            <fieldset>
               
                <div class="form-group">
                    <label class="tk-label"><?php esc_html_e('Add detail','taskbot');?></label>
                    <textarea name="details" class="form-control tk-themeinput" name="detail" placeholder="<?php esc_attr_e('Enter your comments here','taskbot');?>"></textarea>
                </div>
                <div class="tk-freelanerinfo form-group">
                    <h6><?php esc_html_e('Upload documents / files','taskbot');?></h6>
                    <div class="tk-upload-resume" id="taskbot-upload-attachment">
                        <ul class="tk-upload-list" id="taskbot-fileprocessing"></ul>
                        <div class="tk-uploadphoto taskbot-dragdroparea" id="taskbot-droparea" >
                            <p><?php echo wp_sprintf( esc_html__( 'You can upload jpg,jpeg,gif,png,zip,rar,mp3 mp4 and pdf only. Make sure your file does not exceed %s mb.', 'taskbot'), $taskbot_settings['upload_file_size'] );?></p>
                            <span id="taskbot-attachment-btn-clicked">
                                <input id="taskbot-attachment-btn-clicked" type="file" name="file">
                                <?php esc_html_e('Click here to upload', 'taskbot');?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group tk-form-btn">
                    <span><?php esc_html_e('Click Send now button to send your uploaded file(s)','taskbot');?></span>
                    <span class="tk-btn-solid tb-submit-project-commetns" data-id="<?php echo intval($proposal_id);?>"><?php esc_html_e('Send now','taskbot');?></span>
                </div>
            </fieldset>
        </form>
    <?php } ?>
</div>
<script type="text/template" id="tmpl-load-chat-media-attachments">
    <li id="thumb-{{data.id}}" class="tk-uploading">
        <span>{{data.name}}</span>
        <input type="hidden" class="attachment_url" name="attachments[{{data.attachment_id}}]" value="{{data.url}}">
        <em class="tb-remove"><a href="javascript:void(0)" class="taskbot-remove-attachment tb-remove-attachment"><i class="tb-icon-trash-2"></i></a></em>
    </li>
</script>
