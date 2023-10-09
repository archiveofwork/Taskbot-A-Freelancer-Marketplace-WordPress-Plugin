<?php
/**
 * The template part for displaying the dashboard Income withdrawn for seller
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard/earning_template
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $current_user;
$user_identity = $current_user->ID;
$icon = 'tb-icon-briefcase';
$total_amount   = 0;

if( function_exists('taskbot_account_withdraw_details') ){
  $total_amount = taskbot_account_withdraw_details($user_identity);
}

$invoice_url  = Taskbot_Profile_Menu::taskbot_profile_menu_link('invoices', $user_identity, true, 'listing');
?>
<div class="tb-earningcostvtwo">
    <div class="tb-earningcost__item">
        <i class="<?php echo esc_html($icon); ?>"></i>
        <h4><?php esc_html_e('Income withdrawn', 'taskbot') ?></h4>
        <span><?php taskbot_price_format($total_amount);?></span>
        <a href="<?php echo esc_url($invoice_url);?>"><?php esc_html_e('Show all invoices', 'taskbot'); ?></a>
    </div>
</div>