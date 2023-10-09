<?php
/**
 * Single task task details
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public
 */
global $current_user, $wp_roles, $userdata, $post;
extract($args);
$taskbot_featured               = $product->get_featured();
$taskbot_product_rating         = $product->get_average_rating();
$taskbot_product_rating_count   = $product->get_rating_count();
$product_id                     = $product->get_id();
$taskbot_service_views          = get_post_meta( $product_id, 'taskbot_service_views', TRUE );
$taskbot_service_views          = !empty($taskbot_service_views) ? intval($taskbot_service_views) : 0;
$user_type		                  = apply_filters('taskbot_get_user_type', $current_user->ID);
$linked_profile                 = taskbot_get_linked_profile_id($current_user->ID, '', $user_type);
?>
<ul class="tb-rateviews tb-rateviews3">
    <?php
		do_action('taskbot_service_rating_count_theme_v2', $product);
		do_action( 'taskbot_service_sales', $product,'v3' );
		do_action('taskbot_service_item_views', $product);
		do_action( 'taskbot_saved_item', $product_id, $linked_profile,'_saved_tasks', '' );
		do_action('taskbot_service_extra_items', $product);
    ?>
</ul>