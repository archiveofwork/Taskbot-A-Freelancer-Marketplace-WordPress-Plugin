<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 
 * Template to display package tab meta fields
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/products_data
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */

global $woocommerce, $post;
$taskbot_subtask_fields_values = get_post_meta($post->ID, 'taskbot_product_subtasks', TRUE);?>
<div class="options_group product-data-packages-feilds">
    <?php do_action('taskbot_packages_fields_before', $taskbot_product_tasks_fields);

    woocommerce_wp_select( array(
        'id'          => 'buyer_package_type',
        'value'       => get_post_meta( get_the_ID(), 'package_type', true ),
        'label'       => esc_html__('Package type', 'taskbot'),
        'options'     => array( 'days' => esc_html__('Day(s)', 'taskbot'), 'month' => esc_html__('Month(s)', 'taskbot'), 'year' => esc_html__('Year(s)', 'taskbot')),
    ) );
    woocommerce_wp_text_input( array(
        'id'            => 'buyer_package_duration',
        'value'         => get_post_meta( get_the_ID(), 'package_duration', true ),
        'label'         => esc_html__('Package duration', 'taskbot'),
        'description'   => '',
        'custom_attributes' => array(
            'step' 	=> 'any',
            'min'	=> '0'
        )     
    ) );
    woocommerce_wp_text_input( array(
        'id'            => 'number_projects_allowed',
        'value'         => get_post_meta( get_the_ID(), 'number_projects_allowed', true ),
        'label'         => esc_html__('Number of projects', 'taskbot'),
        'description'   => '',
        'custom_attributes' => array(
            'step' 	=> 'any',
            'min'	=> '0'
        )     
    ) );
    woocommerce_wp_text_input( array(
        'id'            => 'featured_projects_allowed',
        'value'         => get_post_meta( get_the_ID(), 'featured_projects_allowed', true ),
        'label'         => esc_html__('Number of featured projects', 'taskbot'),
        'description'   => '',
        'custom_attributes' => array(
            'step' 	=> 'any',
            'min'	=> '0'
        ) 
    ) );
    woocommerce_wp_text_input( array(
        'id'            => 'featured_projects_duration',
        'value'         => get_post_meta( get_the_ID(), 'featured_projects_duration', true ),
        'label'         => esc_html__('Featured projects duration', 'taskbot'),
        'description'   => 'Featured project duration in number of day(s).',
        'custom_attributes' => array(
            'step' 	=> 'any',
            'min'	=> '0'
        )     
    ) );
    
    do_action('taskbot_buyer_packages_fields_after', $taskbot_product_tasks_fields);?>
</div>