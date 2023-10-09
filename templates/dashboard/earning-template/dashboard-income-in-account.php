<?php
/**
 * The template part for displaying the dashboard Income in Account for seller
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard/earning_template
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user,$taskbot_settings;
$user_id                    = !empty($_GET['identity']) ? intval($_GET['identity']) : 0;
$user_identity              = $current_user->ID;
$icon                       = 'tb-icon-shopping-cart';
$account_blance             = taskbot_account_details($user_identity,array('wc-completed'),'completed');
$withdrawn_amount           = taskbot_account_withdraw_details($user_identity,array('pending','publish'));
$available_withdraw_amount = $account_blance - $withdrawn_amount;
$payout_list                = taskbot_get_payouts_lists();
$package_details            = get_user_meta($user_identity, 'taskbot_payout_method', true);
$package_details            = !empty($package_details) ? $package_details : array();

$tpl_terms_conditions   = !empty( $taskbot_settings['tpl_terms_conditions'] ) ? $taskbot_settings['tpl_terms_conditions'] : '';
$tpl_privacy            = !empty( $taskbot_settings['tpl_privacy'] ) ? $taskbot_settings['tpl_privacy'] : '';
$term_link              = !empty($tpl_terms_conditions) ? '<a target="_blank" href="'.get_the_permalink($tpl_terms_conditions).'">'.get_the_title($tpl_terms_conditions).'</a>' : '';
$privacy_link           = !empty($tpl_privacy) ? '<a target="_blank" href="'.get_the_permalink($tpl_privacy).'">'.get_the_title($tpl_privacy).'</a>' : '';

?>
<div class="tb-earningcostvtwo">
    <div class="tb-earningcost__item">
        <i class="<?php echo esc_attr($icon); ?>"></i>
        <h4><?php esc_html_e('Available in account', 'taskbot') ?></h4>
        <span><?php taskbot_price_format($available_withdraw_amount);?></span>
        <?php if (!empty($package_details)){?>
            <a href="javascript:void(0);" data-bs-target="#withdraw-saved-payment" data-bs-toggle="modal"><?php esc_html_e('Withdraw now', 'taskbot'); ?></a>
        <?php } else { ?>
            <a href="javascript:void(0);" data-bs-target="#withdraw-non-saved-payment" data-bs-toggle="modal"><?php esc_html_e('Withdraw now', 'taskbot'); ?></a>
        <?php } ?>
    </div>
</div>
<?php if (!empty($payout_list) && is_array($payout_list)) {?>
    <div class="modal fade tb-withdrawmoney" tabindex="-1" role="dialog" id="withdraw-saved-payment">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="tb-modalcontent modal-content">
                <div class="tb-popuptitle">
                    <h4><?php esc_html_e('Withdraw money', 'taskbot'); ?></h4>
                    <a href="javascript:void(0);" class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <form class="tb-themeform tb-formlogin tb-withdrawform">
                        <fieldset>
                            <div class="form-group">
                                <label class="form-group-title"><?php esc_html_e('Enter amount','taskbot'); ?>:</label>
                                <div class="tb-limit">
                                <input type="number" placeholder="<?php esc_attr_e('Enter amount here', 'taskbot'); ?>*" name="withdraw[amount]" class="form-control">
                                <em><?php esc_html_e('Max Limit','taskbot'); ?>: <?php taskbot_price_format($available_withdraw_amount);?></em>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-group-title"><?php esc_html_e('Payout method','taskbot'); ?>:</label>
                                <ul class="tb-payoutmethod tb-payoutmethodpopup">
                                <?php foreach ($payout_list as $pay_key => $pay_val) {?>
                                    <?php if (array_key_exists($pay_key, $package_details)) { ?>
                                        <li class="tb-radiobox">
                                            <input type="radio" id="<?php echo esc_attr($pay_val['id']); ?>" name="withdraw[gateway]" value="<?php echo esc_attr( $pay_val['id'] ); ?>" checked>
                                            <div class="tb-radioholder tb-packages__days">
                                                <div class="tb-radio">
                                                    <label for="<?php echo esc_attr($pay_val['id']); ?>" class="tb-radiolist payoutlists">
                                                        <span class="tb-payoutmode">
                                                            <?php if(!empty($pay_val['img_url'])){?><img src="<?php echo esc_url($pay_val['img_url']); ?>" alt="<?php echo esc_attr($pay_val['title']); ?>"><?php }?>
                                                            <span><?php echo esc_html($pay_val['title']); ?></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </li>
                                    <?php }}?>
                                </ul>
                            </div>
                            <div class="form-group tb-popupbtnarea">
                                <div class="tb-checkterm">
                                    <div class="tb-checkbox">
                                        <input id="check3" type="checkbox" name="withdraw_consent">
                                        <label for="check3">
                                            <span>
                                                <?php echo sprintf(esc_html__('By clicking you agree with our %s and %s', 'taskbot'), $term_link, $privacy_link); ?>
                                            </span>
                                        </label>
                                    </div>                            
                                </div>
                                <button type="button" data-id="<?php echo intval($user_id);?>" class="tb-btn tb-withdraw-money"><?php esc_html_e('Withdraw now','taskbot'); ?></button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="withdraw-non-saved-payment">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="tb-modalcontent modal-content">
                <div class="tb-popuptitle">
                    <h4><?php esc_html_e('Withdraw money','taskbot'); ?></h4>
                    <a href="javascript:void(0);" class="close"><i class="tb-icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <h4><?php esc_html_e('Select any payment method before withdrawal request','taskbot'); ?></h4>
                </div>
            </div>
        </div>
    </div>
<?php }
