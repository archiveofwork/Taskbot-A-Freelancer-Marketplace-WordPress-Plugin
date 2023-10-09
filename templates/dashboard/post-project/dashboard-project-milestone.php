<?php
    $proposal_id    = !empty($args['proposal_id']) ? intval($args['proposal_id']) : 0;
    $project_id     = !empty($args['project_id']) ? intval($args['project_id']) : 0;
    $seller_id      = !empty($args['seller_id']) ? intval($args['seller_id']) : 0;
    $proposal_status= !empty($args['proposal_status']) ? esc_attr($args['proposal_status']) : 0;
    $proposal_meta  = !empty($args['proposal_meta']) ? ($args['proposal_meta']) : array();
    $user_identity  = !empty($args['user_identity']) ? intval($args['user_identity']) : 0;

    $hired_balance      = !empty($args['hired_balance']) ? ($args['hired_balance']) : 0;
    $earned_balance     = !empty($args['earned_balance']) ? ($args['earned_balance']) : 0;
    $remaning_balance   = !empty($args['remaning_balance']) ? ($args['remaning_balance']) : 0;
    $mileastone_array   = !empty($args['mileastone_array']) ? ($args['mileastone_array']) : array();
    $completed_mil_array= !empty($args['completed_mil_array']) ? ($args['completed_mil_array']) : array();
    $user_balance       = get_user_meta( $user_identity, '_buyer_balance', true );
    $user_balance       = !empty($user_balance) ? $user_balance : 0;
    if( !empty($user_balance) ){
        $checkout_class         = 'tb_proposal_hiring';
    } else {
        $checkout_class     = 'tb_hire_proposal';
    }
?>
<div class="tk-counterinfo">
    <ul class="tk-counterinfo_list">
        <li>
            <strong class="tk-counterinfo_escrow"><i class="tb-icon-clock"></i></strong>
            <span><?php esc_html_e('Total escrow amount','taskbot');?></span>
            <h5><?php taskbot_price_format($hired_balance);?> </h5>
        </li>
        <li>
            <strong class="tk-counterinfo_earned"><i class="tb-icon-briefcase"></i></strong>
            <span><?php esc_html_e('Total amount spent','taskbot');?></span>
            <h5><?php taskbot_price_format($earned_balance);?></h5>
        </li>
        <li>
            <strong class="tk-counterinfo_remaining"><i class="tb-icon-dollar-sign"></i></strong>
            <span><?php esc_html_e('Remaining project budget','taskbot');?></span>
            <h5><?php taskbot_price_format($remaning_balance);?></h5>
        </li>
    </ul>
</div>
<?php if( !empty($mileastone_array) ){?>
    <div class="tk-projectsinfo">
        <div class="tk-projectsinfo_title">
            <h4><?php esc_html_e('Project roadmap','taskbot');?></h4>
        </div>
        <ul class="tk-projectsinfo_list">
            <?php 
                foreach($mileastone_array as $key => $value){
                    $status = !empty($value['status']) ? $value['status'] : '';
                    $price  = !empty($value['price']) ? $value['price'] : 0;
                    $title  = !empty($value['title']) ? $value['title'] : '';
                    $detail = !empty($value['detail']) ? $value['detail'] : '';
                    ?>
                    <li>
                        <div class="tk-statusview">
                            <div class="tk-statusview_head">
                                <div class="tk-statusview_title">
                                    <div class="tk-mile-title">
                                        <span><?php taskbot_price_format($price);?></span>
                                        <?php 
                                            if( isset($status) && $status != 'requested' ){
                                                do_action( 'taskbot_milestone_proposal_status_tag', $status );
                                            }
                                        ?>
                                    </div>
                                    <?php if( !empty($title) ){?>
                                        <h5><?php echo esc_html($title);?></h5>
                                    <?php } ?>
                                    <?php if( !empty($detail) ){?>
                                        <p><?php echo esc_html($detail);?></p>
                                    <?php } ?>
                                </div>
                                
                            </div>
                            <?php if( !empty($status) && $status === 'decline' && !empty($value['decline_reason'])){?>
                                <div class="tk-statusview_alert">
                                    <span><i class="tb-icon-info"></i><?php esc_html_e('The employer declined this milestone invoice. Read the comment below and try again','taskbot');?></span>
                                    <p><?php echo esc_html($value['decline_reason']);?></p>
                                </div>
                            <?php } ?>
                            <?php if( !empty($proposal_status) && $proposal_status === 'hired' ){?>
                                <?php if( !empty($status) && $status === 'requested' ){?>
                                    <div class="tk-statusview_btns">
                                        <span class="tk-btn_approve tb_update_milestone" data-status="completed" data-id="<?php echo intval($proposal_id);?>" data-key="<?php echo esc_attr($key);?>"><?php esc_html_e('Approve','taskbot');?></span>
                                        <span class="tk-btn_decline" data-bs-target="#tb_milestone_declinereason-<?php echo esc_attr($key);?>" data-bs-toggle="modal" ><?php esc_html_e('Decline','taskbot');?></span>
                                    </div>
                                    <div class="modal fade tk-declinereason" id="tb_milestone_declinereason-<?php echo esc_attr($key);?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="tk-popup_title">
                                                <h5><?php esc_html_e('Add decline reason below','taskbot');?></h5>
                                                <a href="javascrcript:void(0)" data-bs-dismiss="modal">
                                                    <i class="tb-icon-x"></i>
                                                </a>
                                            </div>
                                            <div class="modal-body tk-popup-content">
                                                <div class="tk-themeform">
                                                    <fieldset>
                                                        <div class="tk-themeform__wrap">
                                                            <div class="form-group">
                                                                <div class="tk-placeholderholder">
                                                                    <textarea id="milestone_declinereason-<?php echo esc_attr($key);?>" class="form-control tk-themeinput" placeholder="<?php esc_attr_e("Enter description","taskbot");?>"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="tk-popup-terms form-group">
                                                                <button type="button" data-id="<?php echo intval($proposal_id);?>" data-status="decline" data-key="<?php echo esc_attr($key);?>" class="tk-btn-solid-lg tb_decline_milestone"><?php esc_html_e('Submit question now','taskbot');?><i class="tb-icon-arrow-right"></i></button>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else if(empty($status)){ ?>
                                    <div class="tk-statusview_btns">
                                        <span class="tk-btn_decline <?php echo esc_attr($checkout_class);?>" data-key="<?php echo esc_attr($key);?>" data-id="<?php echo intval($proposal_id);?>"><?php esc_html_e('Escrow','taskbot');?></span>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
<?php if( !empty($completed_mil_array) ){?>
    <div class="tk-projectsinfo">
        <div class="tk-projectsinfo_title">
            <h4><?php esc_html_e('Completed milestones','taskbot');?></h4>
        </div>
        <ul class="tk-projectsinfo_list">
            <?php 
                foreach($completed_mil_array as $key => $value){
                    $status = !empty($value['status']) ? $value['status'] : '';
                    $price  = !empty($value['price']) ? $value['price'] : 0;
                    $title  = !empty($value['title']) ? $value['title'] : '';
                    $detail = !empty($value['detail']) ? $value['detail'] : '';
                    ?>
                    <li>
                        <div class="tk-statusview">
                            <div class="tk-statusview_head">
                                <div class="tk-statusview_title">
                                    <div class="tk-mile-title">
                                        <span><?php taskbot_price_format($price);?></span>
                                        <?php do_action( 'taskbot_milestone_proposal_status_tag', $status );?>
                                    </div>
                                    <?php if( !empty($title) ){?>
                                        <h5><?php echo esc_html($title);?></h5>
                                    <?php } ?>
                                    <?php if( !empty($detail) ){?>
                                        <p><?php echo esc_html($detail);?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </li>
            <?php } ?>
        </ul>
    </div>
<?php }