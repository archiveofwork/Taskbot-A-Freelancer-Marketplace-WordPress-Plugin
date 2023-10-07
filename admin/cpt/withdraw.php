<?php

/**
 * 
 * Class 'Taskbot_Admin_CPT_Seller' defines the cusotm post type
 * 
 * @package     Taskbot
 * @subpackage  Taskbot/admin/cpt
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */

if (!class_exists('Taskbot_Withdraw')) {

    class Taskbot_Withdraw {

        /**
         * @access  public
         * @Init Hooks in Constructor
         */
        public function __construct() {
            add_action('init', array(&$this, 'init_post_type'));
            add_filter('manage_withdraw_posts_columns', array(&$this, 'withdraw_columns_add'));
            add_action('manage_withdraw_posts_custom_column', array(&$this, 'withdraw_columns'),10, 2);
            add_filter('post_row_actions',array(&$this, 'Taskbot_Withdraw_action_row'), 10, 2);
            add_action('init', array(&$this, 'withdraw_custom_post_status'));
            add_action('admin_footer-post.php', array(&$this, 'withdraw_append_post_status_list'));
        }

        /**
         * @Remove row actions
         * @return {post}
         */
        public function Taskbot_Withdraw_action_row($actions, $post){
            if ($post->post_type === "withdraw"){
				unset($actions['edit']);
				unset($actions['inline hide-if-no-js']);
            }
            return $actions;
        }


        /**
         * @Prepare Columns
         * @return {post}
         */
        public function withdraw_columns_add($columns) {
            $columns['price'] 				= esc_html__('Price','taskbot');
            $columns['account_type'] 		= esc_html__('Account type','taskbot');
            $columns['acount_details'] 		= esc_html__('Account details','taskbot');
            $columns['status'] 				= esc_html__('Status','taskbot');

            return $columns;
        }

        /**
         * @Get Columns
         * @return {}
         */
        public function withdraw_columns($case) {
            global $post;
            $price	          = get_post_meta( $post->ID, '_withdraw_amount', true );
            $price	          = !empty($price) ? $price : '';
            $account_type	  = get_post_meta( $post->ID, '_payment_method', true );
            $account_type	  = !empty($account_type) ? $account_type : '';
            $status			  = get_post_status( $post->ID );
            $status_data	  = !empty($status) ? esc_html($status) : esc_html__('Processed','taskbot');
            $account_details  = get_post_meta($post->ID, '_account_details',true);
			
            switch ($case) {
            case 'price':
                taskbot_price_format($price);
            break;
            case 'acount_details':
                $payrols	= taskbot_get_payouts_lists();
                ?>
                <div class="order-edit-wrap">
                    <div class="cus-modal" id="cus-order-modal-<?php echo esc_attr( $post->ID );?>">
                        <div class="cus-modal-dialog">
                            <div class="cus-modal-content">
                                <div class="cus-modal-body">
                                    <div class="cus-form cus-form-change-settings">
                                        <div class="edit-type-wrap">
                                            <?php
                                            $db_saved	= maybe_unserialize( $account_details );
                                            foreach ($payrols[$account_type]['fields'] as $key => $field) {

                                                if(!empty($field['show_this']) && $field['show_this'] == true){
                                                    $current_val	= !empty($db_saved[$key]) ? $db_saved[$key] : 0;
                                                    ?>
                                                    <div class="cus-options-data">
                                                        <label><span><?php echo esc_html($field['title']);?></span></label>
                                                        <div class="step-value">
                                                            <span><?php echo esc_html($current_val);?></span>
                                                        </div>
                                                    </div>
                                                <?php }
                                            }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            break;
            case 'account_type':
                echo esc_html( $account_type );
            break;
            case 'status':
                ?>
                <div class="order-edit-wrap">
                    <div class="view-order-detail">
                        <?php echo esc_html( $status_data );?>
                    </div>
                </div>
                <?php
            break;
            }
        }

        /**
         * @Init Post Type
         * @return {post}
         */
        public function init_post_type() {
            $this->prepare_post_type();
        }

        /**
         * @Prepare Post Type Category
         * @return post type
         */
        public function prepare_post_type() {
            $labels = array(
                'name'              => esc_html__('Withdraw', 'taskbot'),
                'all_items'         => esc_html__('Withdraw', 'taskbot'),
                'singular_name'     => esc_html__('Withdraw', 'taskbot'),
                'add_new'           => esc_html__('Add withdraw', 'taskbot'),
                'add_new_item'      => esc_html__('Add new withdraw', 'taskbot'),
                'edit'              => esc_html__('Edit', 'taskbot'),
                'edit_item'         => esc_html__('Edit withdraw', 'taskbot'),
                'new_item'          => esc_html__('New withdraw', 'taskbot'),
                'view'              => esc_html__('View withdraw', 'taskbot'),
                'view_item'         => esc_html__('View withdraw', 'taskbot'),
                'search_items'      => esc_html__('Search withdraw', 'taskbot'),
                'not_found'         => esc_html__('No withdraw found', 'taskbot'),
                'not_found_in_trash'    => esc_html__('No withdraw found in trash', 'taskbot'),
                'parent'                => esc_html__('Parent withdraw', 'taskbot'),
            );
			
            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__('This is where you can add new withdraw', 'taskbot'),
                'public'                => false,
                'supports'              => array('title','author'),
                'show_ui'               => true,
                'capability_type'       => 'post',
                'map_meta_cap' 		    => true,
                'menu_position' 	    => 10,
                'publicly_queryable'    => false,
                'query_var'             => false,
                'menu_icon'             => 'dashicons-money-alt',
                'rewrite'               => array('slug' => 'withdraw', 'with_front' => true),
                'capabilities'          => array('create_posts'   => false,),
            );
            register_post_type('withdraw', $args);
        }

        /**
         * Add 'rejected' post status.
         */
        public function withdraw_custom_post_status(){
            register_post_status( 'rejected',
                array(
                    'label'                     => esc_html__('Rejected', 'taskbot'),
                    'public'                    => false,
                    'exclude_from_search'       => true,
                    'show_in_admin_all_list'    => true,
                    'show_in_admin_status_list' => true,
                    'label_count'               => _n_noop( 'Rejected <span class="count">(%s)</span>', 'Rejected <span class="count">(%s)</span>', 'taskbot'),
                )
            );
        }

        public function withdraw_append_post_status_list(){
            global $post;
            $complete = '';
            $label = '';

            if($post->post_type == 'withdraw'){
                $status = $post->post_status;

                if($post->post_status == 'rejected'){
                    $complete = ' selected=\"selected\"';
                    $label = '<span id=\"post-status-display\"> '.esc_html__('Rejected', 'taskbot').'</span>';
                }

                $complete   = '';
                echo do_shortcode('<script>
                    jQuery(document).ready(function($){
                        jQuery("select#post_status").append("<option value=\"rejected\" '.esc_js($complete).'> '.esc_html__('Rejected', 'taskbot').'</option>");
                        jQuery(".misc-pub-section label").append("'.esc_js($label).'");
                        jQuery("#post-status-display").append("'.esc_js($label).'");
                        $("select#post_status option[value='.esc_js($status).']").attr("selected", true);
                    });
                    </script>');
            }
        }

    }

	new Taskbot_Withdraw();
}