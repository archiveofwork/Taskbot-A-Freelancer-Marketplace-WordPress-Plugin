<?php
// die if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 
 * Template to display product data type subtaks tabs fields
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/products_data
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */

global $woocommerce, $post;
$taskbot_subtask_details_fields_values = get_post_meta($post->ID, 'taskbot_product_subtasks', TRUE);
$taskbot_subtask_details_fields = array(
  'title' => array(
      'id'          => 'title',
      'label'       => esc_html__('Add title', 'taskbot'),
      'type'        => 'text',
      'value'       =>'',
      'class'       => 'title',
      'placeholder' => esc_html__('Add title', 'taskbot'),
  ),
  'description'     => array(
      'id'          => 'description',
      'label'       => esc_html__('Description', 'taskbot'),
      'type'        => 'textarea',
      'default_value'   => '',
      'class'           => 'description',
      'placeholder'     => esc_html__('Description', 'taskbot'),
  ),
  'price'   => array(
      'id'      => 'price',
      'label'   => esc_html__('Price', 'taskbot'),
      'type'    => 'text',
      'default_value'   => '',
      'class'           => 'price',
      'placeholder'     => esc_html__('Price', 'taskbot'),
  ),
);

$taskbot_subtask_details_fields = apply_filters('taskbot_product_subtasks_details_fields', $taskbot_subtask_details_fields);
do_action('taskbot_subtasks_details_fields_before', $taskbot_subtask_details_fields);
do_action('taskbot_render_subtasks_details_fields', $taskbot_subtask_details_fields, $taskbot_subtask_details_fields_values);
do_action('taskbot_subtasks_details_fields_after', $taskbot_subtask_details_fields);
