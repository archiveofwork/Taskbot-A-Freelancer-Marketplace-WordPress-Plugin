<?php
/**
 *  Add additional fields
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/post_services
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $post;

if ( !class_exists('WooCommerce') ) {
	return;
}

if( class_exists('ACF') ) :
    $groups = acf_get_field_groups(array('product_tabs' => 'additional'));
    echo do_shortcode('<div class="form-group taskbot-additional-fields">');
    do_action('taskbot_additional_fields_before', $groups);
    foreach($groups as $group){
        foreach( $group['location'] as $group_locations ) {
            foreach( $group_locations as $rule ) {

                if( $rule['param'] == 'product_tabs' && $rule['operator'] == '==' && $rule['value'] == 'additional' ) {
                    do_action('taskbot_additional_group_fields_before', $group);
                    echo acf_render_fields( $post_id, acf_get_fields( $group ) );
                    do_action('taskbot_additional_group_fields_after', $group);
                    break 2;
                }
                
            }
        }
    }

    do_action('taskbot_additional_fields_after', $groups);
    echo do_shortcode('</div>');
endif;