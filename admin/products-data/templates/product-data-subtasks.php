<?php
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $woocommerce, $post;
$taskbot_subtask_fields_values = get_post_meta($post->ID, 'taskbot_product_subtasks', TRUE);
$taskbot_subtask_fields = array(
    'subtasks' => array(
        'id'    => 'product_subtask',
        'label' => esc_html__('Select subtask', 'taskbot'),
        'type'  => 'post_dropdwon',
        'value' => '',
        'post_type' => 'product',
        'multiple' => true,        
        'class' => 'subtask-selection',
        'placeholder' => esc_html__('Select subtask', 'taskbot'),
    ),
);
$taskbot_product_tasks_fields = apply_filters('taskbot_product_tasks_fields', $taskbot_subtask_fields);
echo do_shortcode('<div class="options_group product-data-subtasks-feilds">');
    do_action('taskbot_subtasks_fields_before', $taskbot_product_tasks_fields);
    do_action('taskbot_render_subtasks_fields', $taskbot_product_tasks_fields, $taskbot_subtask_fields_values);
    
    echo do_shortcode('<div class="tb-pricingtitle form-field subtask-selection">');
        woocommerce_wp_text_input( array(
            'id'            => 'taskbot_video_url',
            'value'         => get_post_meta( get_the_ID(), '_product_video', true ),
            'label'         => esc_html__('Video URL', 'taskbot'),
            'description'   => '',
        ) );
        woocommerce_wp_hidden_input( array(
            'id'            => '_product_video_attachment_id',
            'value'         => get_post_meta( get_the_ID(), '_product_video_attachment_id', true ),
            
        ) );
    echo do_shortcode('</div>');
echo do_shortcode('</div>');
