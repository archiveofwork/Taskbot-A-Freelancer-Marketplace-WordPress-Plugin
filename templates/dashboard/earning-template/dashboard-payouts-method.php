<?php
/**
 * The template part for displaying the dashboard Payouts methods for seller
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard/earning_template
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user, $taskbot_settings;
$user_identity      = intval($current_user->ID);
$payout_list        = taskbot_get_payouts_lists();
$contents_payout    = get_user_meta($user_identity, 'taskbot_payout_method', true);
$contents_payout    = !empty($contents_payout) ? $contents_payout : array();

$tpl_terms_conditions   = !empty( $taskbot_settings['tpl_terms_conditions'] ) ? $taskbot_settings['tpl_terms_conditions'] : '';
$tpl_privacy            = !empty( $taskbot_settings['tpl_privacy'] ) ? $taskbot_settings['tpl_privacy'] : '';
$term_link              = !empty($tpl_terms_conditions) ? '<a target="_blank" href="'.get_the_permalink($tpl_terms_conditions).'">'.get_the_title($tpl_terms_conditions).'</a>' : '';
$privacy_link           = !empty($tpl_privacy) ? '<a target="_blank" href="'.get_the_permalink($tpl_privacy).'">'.get_the_title($tpl_privacy).'</a>' : '';

?>
<div class="col-lg-4">
    <div class="tb-asideholder tb-asideholdertwo">
        <div class="tb-asidebox tb-payoutmethodwrap" id="tb_bankpayouttitle_heading">
            <h5 class="tb-banktitle tb-bankpayouttitle"><?php esc_html_e('Payouts method', 'taskbot'); ?></h5>
        </div>
        <div class="tb-asidebox">
            <div class="tb-payoutmethodholder">
                <div class="tb-themeform">
                    <ul class="tb-payoutmethod">
                        <?php
                        if (is_array($payout_list) && !empty($payout_list)) {
                            $selected_payout_count = 0;
                            foreach ($payout_list as $pay_key => $pay_val) {
                                $selected_payout_key    = !empty($contents_payout[$pay_key]) ? $pay_key : "";
                                $selected_li_class      = !empty($selected_payout_key) ? "tb-radio-checked" : "";
                                if (!empty($pay_val['status']) && $pay_val['status'] === 'enable') { ?>
                                <form class="tb-payout-user-form-<?php echo esc_attr($pay_key); ?>">
                                    <li class="tb-radiobox tb-li_payouts-<?php echo esc_attr($pay_key.' '.$selected_li_class); ?> ">
                                        <input type="radio" id="payrols-<?php echo esc_attr($pay_val['id']); ?>" name="payout_settings[<?php echo esc_attr($pay_key);?>]" <?php checked($selected_payout_key, $pay_val['id']); ?> value="<?php echo esc_attr($pay_val['id']); ?>">
                                        <div class="tb-radioholder tb-packages__days" data-key="<?php echo esc_attr($pay_val['id']); ?>">
                                            <div class="tb-radio">
                                                <label for="payrols-<?php echo esc_attr($pay_val['id']); ?>" class="tb-radiolist payoutlists">
                                                    <span class="tb-payoutmode">
                                                    <?php if(!empty($pay_val['img_url'])){?><img src="<?php echo esc_url($pay_val['img_url']); ?>" alt="<?php echo esc_attr($pay_val['title']); ?>"><?php }?>
                                                        <span> <?php echo esc_html($pay_val['title']); ?></span>
                                                    </span>
                                                </label>
                                            </div>
                                            <a class="tb-paypalcontent" data-payout_methods_title="<?php echo esc_attr($pay_val['title']); ?>" href="javascript:void(0)"><i class="tb-icon-chevron-right"></i></a>
                                        </div>
                                        <div id="tb-paypal1" class="tb-steppaypal">
                                            <fieldset>
                                                <div class="tb-themeform__wrap">
                                                    <?php if (is_array($pay_val['fields']) && !empty($pay_val['fields'])) {
                                                        foreach ($pay_val['fields'] as $key => $field) {
                                                            $db_value = !empty($contents_payout[$selected_payout_key][$key]) ? $contents_payout[$selected_payout_key][$key] : "";
                                                            ?>
                                                            <div class="form-group wo-inputicon wo-inputheight">
                                                                <input type="<?php echo esc_attr($field['type']); ?>" class="form-control" name="payout_settings[<?php echo esc_attr($pay_key);?>][<?php echo esc_attr($key); ?>]" placeholder="<?php echo esc_attr($field['placeholder']); ?>" id="<?php echo esc_attr($key); ?>-payrols" value="<?php echo esc_attr($db_value); ?>">
                                                            </div>
                                                            <?php
                                                        }
                                                    }

                                                    if (!empty($pay_val['desc'])) { ?>
                                                        <div class="tb-paymetdesc">
                                                            <p> <em><?php echo do_shortcode($pay_val['desc']); ?></em> </p>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="tb-paybtn">
                                                        <a href="javascript:void(0);" class="tb-btn tb-payrols-settings" data-key="<?php echo esc_attr($pay_key); ?>" data-id="<?php echo get_current_user_id(); ?>"><?php esc_html_e('Submit', 'taskbot'); ?>
                                                        <span class="rippleholder tb-jsripple"><em class="ripplecircle"></em></span></a>
                                                        <a href="javascript:void(0);" class="tb-btn tb-btnplain btnplain_cancel_methods" data-selectedkey="<?php echo esc_attr($selected_payout_key); ?>" data-key="<?php echo esc_attr($pay_key); ?>"><?php esc_html_e('Cancel', 'taskbot'); ?></a>
                                                        <?php if( !empty($selected_payout_key) ){?>
                                                            <a href="javascript:void(0);" data-key="<?php echo esc_attr($selected_payout_key);?>" class="tb-remove-payouts tb_remove_payout"><?php esc_html_e('Remove', 'taskbot'); ?></a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </li>
                                </form>
                                <?php }
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="tb-paymetdesc">
                    <p>
                        <em><?php echo sprintf(esc_html__('Choose any payment method to receive your earned amount direct to your desired account. Leaving this empty or unchecked will cause delay or no payments. For further info read our details %s and %s', 'taskbot'), $term_link, $privacy_link); ?></em>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>