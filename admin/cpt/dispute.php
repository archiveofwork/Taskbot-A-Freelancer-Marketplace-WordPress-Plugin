<?php

/**
 * Class 'Taskbot_Dispute' defines the cusotm post type
 * 
 * @package     Taskbot
 * @subpackage  Taskbot/admin/cpt
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */

if (!class_exists('Taskbot_Dispute')) {

    class Taskbot_Dispute {

        /**
         * @access  public
         * @Init Hooks in Constructor
         */
        public function __construct() {
            add_action('init', array(&$this, 'init_directory_type'));
            add_action('add_meta_boxes', array(&$this, 'taskbot_dispute_detail'), 10, 2);
        }

        /**
         * @Init Post Type
         * @return {post}
         */
        public function init_directory_type() {
            $this->prepare_post_type();
        }

        /**
         * @Prepare Post Type Category
         * @return post type
         */
        public function prepare_post_type() {            
            $labels = array(
                'name'				=> esc_html__('Disputes', 'taskbot'),
                'all_items' 		=> esc_html__('Disputes', 'taskbot'),
                'singular_name' 	=> esc_html__('Disputes', 'taskbot'),
                'add_new' 			=> esc_html__('Add dispute', 'taskbot'),
                'add_new_item' 		=> esc_html__('Add new dispute', 'taskbot'),
                'edit' 				=> esc_html__('Edit', 'taskbot'),
                'edit_item' 		=> esc_html__('Edit dispute', 'taskbot'),
                'new_item' 			=> esc_html__('New dispute', 'taskbot'),
                'view' 				=> esc_html__('View dispute', 'taskbot'),
                'view_item' 		=> esc_html__('View dispute', 'taskbot'),
                'search_items' 		=> esc_html__('Search dispute', 'taskbot'),
                'not_found' 		=> esc_html__('No dispute found', 'taskbot'),
                'not_found_in_trash'=> esc_html__('No dispute found in trash', 'taskbot'),
                'parent' 			=> esc_html__('Parent dispute', 'taskbot'),
            );
			
            $args = array(
                'labels' 				=> $labels,
                'description' 			=> esc_html__('This is where you can add new Dispute ', 'taskbot'),
                'public' 				=> false,
                'supports' 				=> array('title','editor', 'comments'),
                'show_ui' 				=> true,
                'capability_type' 		=> 'post',
                'map_meta_cap' 			=> true,
                'publicly_queryable' 	=> false,
                'exclude_from_search' 	=> true,
                'hierarchical' 			=> false,
				'show_in_menu' 			=> true,
                'menu_position' 		=> 10,
                'rewrite' 				=> array('slug' => 'dispute', 'with_front' => true),
                'show_in_menu' 			=> 'edit.php?post_type=sellers',
                'query_var' 			=> false,
                'has_archive' 			=> false,
				'capabilities' 			=> array('create_posts' => false)
            );
			
            register_post_type('disputes', $args);     
        }

        /**
		 * @Linked Profile metabox
		 * @return {post}
		 */
		public function taskbot_dispute_detail($post_type, $post) {
            $user_id        = get_post_meta($post->ID, '_send_by', true);
            $linked_profile = taskbot_get_linked_profile_id( $user_id );
            
            if(empty($linked_profile)) {return;}

            add_meta_box(
                'linked_profile', esc_html__('Linked details', 'taskbot'), array(&$this, 'taskbot_dispute_detail_meta'), 'disputes', 'side', 'high'
            );

        }
        
        /**
		 * @Linked Profile metabox
		 * @return {post}
		 */
		public function taskbot_dispute_detail_meta($post) {
            $_dispute_key           = get_post_meta($post->ID, '_dispute_key', true);
            $task_id                = get_post_meta($post->ID, '_task_id', true);
            $disputed_order_id      = get_post_meta($post->ID, '_dispute_order', true);
            $seller_id              = get_post_meta($post->ID, '_seller_id', true);
            $post_type              = get_post_type($disputed_order_id);
            $post_status            = get_post_status( $post->ID );
            $title                      = esc_html__('View task order', 'taskbot');
            $buyer_id                   = get_post_field('post_author', $post->ID);
            $linked_employer_profile	= taskbot_get_linked_profile_id($seller_id);
            $linked_freelancer_profile	= taskbot_get_linked_profile_id($buyer_id);
            $proj_serv_id               = !empty($service_order_id) ? $service_order_id : '';
            ?>
			<ul class="review-info">
                <li> <?php echo esc_html($_dispute_key);?></li>
                <li>
                    <span class="push-right">
                        <a target="_blank" href="<?php echo esc_url(get_edit_post_link( $disputed_order_id ));?>"><?php echo esc_html($title); ?></a>
                    </span>
                </li>
                <li>
                    <span class="push-right">
                        <a target="_blank" href="<?php echo esc_url(get_edit_post_link($linked_freelancer_profile));?>"><?php esc_html_e('View buyer profile', 'taskbot'); ?></a>
                    </span>
                </li>
                <li>
                    <span class="push-right">
                        <a target="_blank" href="<?php echo esc_url(get_the_permalink( $linked_employer_profile ));?>"><?php esc_html_e('View seller profile', 'taskbot'); ?></a>
                    </span>
                </li>
                
			</ul>
            
			<?php
        }
    
    }

    new Taskbot_Dispute();
}