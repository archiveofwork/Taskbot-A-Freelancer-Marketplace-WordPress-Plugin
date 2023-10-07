<?php
global  $taskbot_settings;
$seller_dispute_issues      = !empty($taskbot_settings['seller_project_dispute_issues']) ? $taskbot_settings['seller_project_dispute_issues'] : array();

$tpl_terms_conditions   = !empty( $taskbot_settings['tpl_terms_conditions'] ) ? $taskbot_settings['tpl_terms_conditions'] : '';
$tpl_privacy            = !empty( $taskbot_settings['tpl_privacy'] ) ? $taskbot_settings['tpl_privacy'] : '';
$term_link              = !empty($tpl_terms_conditions) ? '<a target="_blank" href="'.get_the_permalink($tpl_terms_conditions).'">'.get_the_title($tpl_terms_conditions).'</a>' : '';
$privacy_link           = !empty($tpl_privacy) ? '<a target="_blank" href="'.get_the_permalink($tpl_privacy).'">'.get_the_title($tpl_privacy).'</a>' : '';

$proposal_status= !empty($args['proposal_status']) ? esc_attr($args['proposal_status']) :'';
$proposal_id    = !empty($args['proposal_id']) ? intval($args['proposal_id']) : 0;
$project_id     = !empty($args['project_id']) ? intval($args['project_id']) : 0;
$buyer_id       = !empty($args['buyer_id']) ? intval($args['buyer_id']) : 0;
$proposal_meta  = !empty($args['proposal_meta']) ? ($args['proposal_meta']) :array();
$proposal_type  = get_post_meta( $proposal_id, 'proposal_type', true );
$profile_id     = taskbot_get_linked_profile_id($buyer_id, '','buyers');
$user_name      = taskbot_get_username($profile_id);
$avatar         = apply_filters( 'taskbot_avatar_fallback', taskbot_get_user_avatar(array('width' => 50, 'height' => 50), $profile_id), array('width' => 50, 'height' => 50));
$proposal_price = isset($args['proposal_meta']['price']) ? $args['proposal_meta']['price'] : 0;
$milestone_total= isset($args['milestone_total']) ? esc_attr($args['milestone_total']) : '';
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
            <?php if( empty($proposal_type) || $proposal_type === 'fixed') { esc_html_e('Total project budget','taskbot'); }?>
        </strong>
        <?php if( !empty($proposal_status) && in_array($proposal_status,array('hired')) ){?>
            <div class="tk-projectsstatus_option">
                <a href="javascript:void(0);"><i class="icon-more-horizontal"></i></a>
                <ul class="tk-contract-list">
                    <li>
                        <span id="taskrefundrequest"><?php esc_html_e('Raise a dispute','taskbot');?></span>
                    </li>
                    <?php if( !empty($milestone_total) && !empty($proposal_price) && !empty($proposal_meta['proposal_type']) && $proposal_meta['proposal_type'] === 'milestone' && $proposal_price > $milestone_total ){?>
                        <li>
                            <span id="tk-add_milestone"><?php esc_html_e('Ceate a milestone','taskbot');?></span>
                        </li>
                    <?php } ?>
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
                            <?php if (!empty($seller_dispute_issues)) {
                                foreach ($seller_dispute_issues as $key => $issue) { ?>
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
<?php if( !empty($milestone_total) && !empty($proposal_price) && $proposal_price > $milestone_total && !empty($proposal_meta['proposal_type']) && $proposal_meta['proposal_type'] === 'milestone' ){?>
	<div class="modal fade tk-workinghours-popup" id="tbaddmilestone" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
           <div class="tk-popup_title">
               <h5><?php esc_html_e('Add new milestone','taskbot');?></h5>
               <a href="javascrcript:void(0)" data-bs-dismiss="modal">
                   <i class="icon-x"></i>
               </a>
           </div>
            <div class="modal-body tk-popup-content">
                <form class="tk-themeform" id="tb_submit_milestone">
                    <fieldset>
                        <div class="tk-themeform__wrap">
                        	<label class="tk-label"><?php esc_html_e('How many milestones you want to add?','taskbot');?>
                                <a href="javascript:void(0)" class="tk-addicon" id="tb-add-milestone"><?php esc_html_e('Add milestone','taskbot');?><i class="icon-plus"></i></a>
                            </label>
                            <div id="tb-list-milestone" class="tk-dragslots">                                
                            </div>
                            <input type="hidden" type="text" value="<?php echo intval($proposal_id);?>" name="proposal_id">
                            <div class="form-group tk-btnarea">
                                <button class="tk-btn-solid-lg tk-success-tag" id="tb_add_milestonebtn"><?php esc_html_e('Add new milestone','taskbot');?></button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
          </div>
        </div>
    </div>
    <script type="text/template" id="tmpl-load-project-milestone">
        <div class="form-group" id="taskbot-milestone-{{data.id}}">
            <div class="tk-milestones-prices">
                <div class="tk-grapinput">
                    <div class="tk-milestones-input">
                        <div class="tk-placeholderholder tk-addslots">
                            <input type="text" name="milestone[{{data.id}}][price]" class="form-control tk-themeinput" placeholder="<?php esc_attr_e('Enter price','taskbot');?>">
                        </div>
                        <div class="tk-placeholderholder">
                            <input type="text" name="milestone[{{data.id}}][title]" class="form-control tk-themeinput" placeholder="<?php esc_attr_e('Enter title','taskbot');?>">
                        </div>
                        <a href="javascript:;" data-id="{{data.id}}" class="tb-remove-milestone tk-removeicon"><i class="icon-trash-2"></i></a>
                    </div>
                    <div class="tk-placeholderholder">
                        <textarea class="form-control tk-themeinput" name="milestone[{{data.id}}][detail]" placeholder="<?php esc_attr_e('Enter description', 'taskbot');?>"></textarea>
                    </div>
                </div>
                <input type="hidden" name="milestone[{{data.id}}][status]" value="">
            </div>
        </div>
	</script>
<?php } ?>
<?php 
$scripts = '
jQuery(document).ready(function () {
    jQuery(".tk-projectsstatus_option > a").on("click",function() {
        jQuery(".tk-contract-list").slideToggle();
    });
    removeMilestone();
    jQuery("#tb-add-milestone").on("click", function (e) {
		let counter 	            = taskbot_unique_increment(10);
		var load_milestone_temp 	= wp.template("load-project-milestone");
		var data 		            = {id: counter};
		load_milestone_temp	        = load_milestone_temp(data);
		jQuery("#tb-list-milestone").append(load_milestone_temp);
		removeMilestone();
	});
    function removeMilestone(){
		jQuery(".tb-remove-milestone").on("click", function (e) {
			jQuery(this).closest(".tk-milestones-prices").remove();
		});
	}
	var tk_sortable = document.getElementById("tb-list-milestone");
	if (tk_sortable !== null) {
		var tk_sortable = Sortable.create(tk_sortable, {
			animation: 350,
		});
	} 
});
';
wp_add_inline_script('taskbot', $scripts, 'after');