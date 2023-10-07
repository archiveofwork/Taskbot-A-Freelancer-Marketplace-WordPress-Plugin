<?php
/**
 * The template part for displaying the dashboard Pending Income for seller
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
$icon           = 'icon-server';
$account_blance = taskbot_account_details($user_identity,array('wc-completed'),'hired');
$page_url       = Taskbot_Profile_Menu::taskbot_profile_menu_link('earnings', $user_identity, true);
?>
<div class="tb-earningcostvtwo">
    <div class="tb-earningcost__item">
        <i class="<?php echo esc_attr($icon); ?>"></i>
        <h4><?php esc_html_e('Pending income', 'taskbot'); ?></h4>
        <span><?php taskbot_price_format($account_blance);?></span>
        <a href="<?php echo esc_url($page_url);?>"><?php esc_html_e('Refresh', 'taskbot'); ?></a>
    </div>
</div>