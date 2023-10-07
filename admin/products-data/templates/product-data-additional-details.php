<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * 
 * Template to display product data type additional fields
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/products_data
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */

global $woocommerce, $post;
echo do_shortcode('<div class="options_group">');
    echo do_shortcode('<div class="options_group product-data-additional-meta-feilds">');
    echo do_action('taskbot_additional_fields', get_the_ID());
echo do_shortcode('</div></div>');
