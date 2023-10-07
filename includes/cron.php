<?php
/**
 * CRON Management
 *

 * CRON init
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

if( !function_exists('taskbot_cron_activate') ) {
	register_activation_hook (__FILE__, 'taskbot_cron_activate');
	add_action('wp', 'taskbot_cron_activate');
	function taskbot_cron_activate() {	
		if ( ! wp_next_scheduled( 'taskbot_update_featured_listing' ) ) {
		  wp_schedule_event( time(), 'hourly', 'taskbot_update_featured_listing' );
		}
	}
}

/**
 * Update expiry
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists('taskbot_update_featured_listing') ) {
	add_action( 'taskbot_update_featured_listing', 'taskbot_update_featured_listing' );
	function taskbot_update_featured_listing() {
		global $current_user;

        if (!class_exists('WooCommerce')) {
            return 0;
        }

        $taskbot_args = array(
            'post_type'         => 'product',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,            
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                ),
				array(
                    'taxonomy' => 'product_type',
                    'field'    => 'slug',
                    'terms'    => 'tasks',
                ),
            ),
        );

		$current_date = current_time('timestamp');
		$meta_query_args	= array();
		$meta_query_args[] = array(
			'key'		=> '_featured_till',
			'value'   	=> $current_date,
			'compare' 	=> '<',
			'type' 		=> 'NUMERIC'
		);

		if (!empty($meta_query_args)) {
			$query_relation = array('relation' => 'AND',);
			$meta_query_args = array_merge($query_relation, $meta_query_args);
			$taskbot_args['meta_query'] = $meta_query_args;
		}

        $featured_task = get_posts($taskbot_args);
		foreach($featured_task as $key => $task){
			$product = wc_get_product( absint( $task->ID ) );
            if ( $product ) {
                $product->set_featured( ! $product->get_featured() );
                $product->save();
            }
		}
	}
}