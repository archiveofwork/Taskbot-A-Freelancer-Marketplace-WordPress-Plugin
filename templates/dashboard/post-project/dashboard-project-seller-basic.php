<?php
global  $taskbot_settings;
$buyer_dispute_issues      = !empty($taskbot_settings['buyer_project_dispute_issues']) ? $taskbot_settings['buyer_project_dispute_issues'] : array();
$tpl_terms_conditions   = !empty( $taskbot_settings['tpl_terms_conditions'] ) ? $taskbot_settings['tpl_terms_conditions'] : '';
$tpl_privacy            = !empty( $taskbot_settings['tpl_privacy'] ) ? $taskbot_settings['tpl_privacy'] : '';
$term_link              = !empty($tpl_terms_conditions) ? '<a target="_blank" href="'.get_the_permalink($tpl_terms_conditions).'">'.get_the_title($tpl_terms_conditions).'</a>' : '';
$privacy_link           = !empty($tpl_privacy) ? '<a target="_blank" href="'.get_the_permalink($tpl_privacy).'">'.get_the_title($tpl_privacy).'</a>' : '';

$proposal_id    = !empty($args['proposal_id']) ? intval($args['proposal_id']) : 0;
$project_id     = !empty($args['project_id']) ? intval($args['project_id']) : 0;
$project_title  = !empty($args['project_title']) ? esc_attr($args['project_title']) : 0;
$seller_id      = !empty($args['seller_id']) ? intval($args['seller_id']) : 0;
$proposal_status= !empty($args['proposal_status']) ? esc_attr($args['proposal_status']) :'';
$complete_option= !empty($args['complete_option']) ? esc_attr($args['complete_option']) :'';
$proposal_type  = get_post_meta( $proposal_id, 'proposal_type', true );
$profile_id     = taskbot_get_linked_profile_id($seller_id, '','sellers');
$user_name      = taskbot_get_username($profile_id);
$avatar         = apply_filters( 'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 50, 'height' => 50), $profile_id), array('width' => 50, 'height' => 50));
$proposal_price = isset($args['proposal_meta']['price']) ? $args['proposal_meta']['price'] : 0;
do_action('taskbot_project_completed_form',$args);
?>
<div class="tk-projectsstatus_head">
    <div class="tk-projectsstatus_info">
        <?php if( !empty($avatar) ){?>
            <figure class="tk-projectsstatus_img">
                <img src="<?php echo esc_url($avatar);?>" alt="<?php echo esc_attr($user_name);?>">
            </figure>
        <?php } ?>
        <div class="tk-projectsstatus_name">
            <?php do_action( 'taskbot_seller_proposal_status_tag', $proposal_id );?>
            <?php if( !empty($user_name) ){?>
                <h5><?php echo esc_html($user_name);?></h5>
            <?php } ?>
        </div>
    </div>
    <div class="tk-projectsstatus_budget">
        <strong>
            <span>
            <?php if( empty($proposal_type) || $proposal_type === 'fixed') {
                    taskbot_price_format($proposal_price);
                } else {
                    do_action( 'taskbot_proposal_listing_price', $proposal_id );
                }?>    
            </span>
            <?php do_action( 'taskbot_project_estimation_html', $project_id );?>
            <?php 
                if( empty($proposal_type) || $proposal_type === 'fixed') {
                    esc_html_e('Total project budget','taskbot');
                }
            ?>
        </strong>
        <?php if( !empty($proposal_status) && in_array($proposal_status,array('hired','cancelled')) ){?>
            <div class="tk-projectsstatus_option">
                <a href="javascript:void(0);"><i class="icon-more-horizontal"></i></a>
                <ul class="tk-contract-list">
                    <?php if( !empty($proposal_status) && $proposal_status === 'hired' ){?>
                        <?php if( !empty($complete_option) && $complete_option === 'yes' ){?>
                            <li>
                                <span class="tb_proposal_completed" data-proposal_id="<?php echo intval($proposal_id);?>" data-title="<?php echo esc_attr($project_title);?>"><?php esc_html_e('Complete contract','taskbot');?></span>
                            </li>
                        <?php } ?>
                    <?php } ?>
                    <?php if( !empty($proposal_status) && in_array($proposal_status,array('hired')) ){?>
                        <li>
                            <span id="taskrefundrequest"><?php esc_html_e('Create refund request','taskbot');?></span>
                        </li>
                        <?php } 
                        if( !empty($proposal_type) && $proposal_type !='fixed'){
                            do_action('taskbot_project_history_menu',$proposal_id,$proposal_type);
                        } ?>
                </ul>
            </div>
        <?php } ?>
    </div>
</div>
<script type="text/template" id="tmpl-load-task-refund-request">
    <div class="modal-dialog tb-modaldialog" role="document">
        <div class="modal-content">
            <div class="tb-popuptitle">
                <h4><?php esc_html_e('Create refund request', 'taskbot') ?></h4>
                <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
            </div>
            <div class="modal-body">
                <div class="tb-popupbodytitle">
                    <?php esc_html_e('Choose issue you want to highlight', 'taskbot') ?>
                </div>
                <form name="refund-request" id="project-refund-request">
                    <input type="hidden" name="proposal_id" value="<?php echo intval($proposal_id); ?>">
                    <div class="tb-disputelist">
                        <ul class="tb-radiolist">
                            <?php if (!empty($buyer_dispute_issues)) {
                                foreach ($buyer_dispute_issues as $key => $issue) { ?>
                                    <li>
                                        <div class="tb-radio">
                                            <input type="radio" id="f-option-<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($issue); ?>" name="dispute_issue">
                                            <label for="f-option-<?php echo esc_attr($key); ?>"><?php echo esc_html($issue); ?></label>
                                        </div>
                                    </li>
                                <?php }
                            } ?>
                        </ul>
                    </div>
                    <div class="tb-popupbodytitle">
                        <h5><?php esc_html_e('Add dispute details', 'taskbot'); ?></h5>
                    </div>
                    <textarea class="form-control" placeholder="<?php esc_attr_e('Enter dispute details', 'taskbot'); ?>" id="dispute-details" name="dispute-details"></textarea>
                    <div class="tb-popupbtnarea">
                        <div class="tb-checkterm">
                            <div class="tb-checkbox">
                                <input id="check3" type="checkbox" name="dispute_terms">
                                <label for="check3">
                                    <span>
                                        <?php echo sprintf(esc_html__('By clicking you agree with our %s and %s', 'taskbot'), $term_link, $privacy_link); ?>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <a href="javascript:void(0);" id="projectrefundrequest-submit" class="tb-btn"><?php esc_html_e('Submit', 'taskbot'); ?> <span class="rippleholder tb-jsripple"><em class="ripplecircle"></em></span></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</script>
<?php 
$scripts = '
jQuery(document).ready(function () {
    jQuery(".tk-projectsstatus_option > a").on("click",function() {
        jQuery(".tk-contract-list").slideToggle();
    });
});
';
wp_add_inline_script('taskbot', $scripts, 'after');