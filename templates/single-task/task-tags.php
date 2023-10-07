<?php
/**
 * Single task task tags
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public
 */
global $product;
do_action( 'taskbot_term_tags', $product->get_id(),'product_tag',esc_html__('Tags','taskbot') );
