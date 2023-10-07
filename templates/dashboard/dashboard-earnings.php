<?php
/**
 * User earnings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
global $current_user, $wp_roles, $woocommerce, $post;

$user_identity    = intval($current_user->ID);
$user_type        = apply_filters('taskbot_get_user_type', $user_identity);
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="tb-earninginvoices">
                <!-- Earning boxes -->
                <?php taskbot_get_template_part('dashboard/earning-template/dashboard', 'total-income'); ?>
                <?php taskbot_get_template_part('dashboard/earning-template/dashboard', 'income-withdrawn'); ?>
                <?php taskbot_get_template_part('dashboard/earning-template/dashboard', 'pending-income'); ?>
                <?php taskbot_get_template_part('dashboard/earning-template/dashboard', 'income-in-account'); ?>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="tb-earning">
        <div class="row">
            <!-- task graph summary -->
            <?php taskbot_get_template_part('dashboard/earning-template/dashboard', 'task-graph-summary'); ?>

            <!-- payouts method -->
            <?php taskbot_get_template_part('dashboard/earning-template/dashboard', 'payouts-method'); ?>
        </div>
    </div>
</div>
<!-- payouts history -->
<?php taskbot_get_template_part('dashboard/earning-template/dashboard', 'payouts-history'); ?>
