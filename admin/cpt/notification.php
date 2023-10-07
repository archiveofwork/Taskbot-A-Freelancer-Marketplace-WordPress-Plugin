<?php
/**
 * Class 'Taskbot_CPT_Notification' defines the cusotm post type
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/cpt
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */
class Taskbot_CPT_Notification {

  /**
   * FAQ post type
   *
   * @since    1.0.0
   * @access   public
   */
  public function __construct() {
    add_action('init', array(&$this, 'init_post_type'));
  }

  /**
   * @Init post type
   */
  public function init_post_type() {
    $this->register_posttype();
  }

  /**
   *Regirster Notification post type
   */
  public function register_posttype() {


    $labels = array(
      'name'                  => esc_html__( 'Notification', 'taskbot' ),
      'singular_name'         => esc_html__( 'Notification', 'taskbot' ),
      'menu_name'             => esc_html__( 'Notification', 'taskbot' ),
      'name_admin_bar'        => esc_html__( 'Notification', 'taskbot' ),
      'archives'              => esc_html__( 'Notification Archives', 'taskbot' ),
      'attributes'            => esc_html__( 'Notification Attributes', 'taskbot' ),
      'parent_item_colon'     => esc_html__( 'Parent Notification:', 'taskbot' ),
      'all_items'             => esc_html__( 'All Notification', 'taskbot' ),
      'add_new_item'          => esc_html__( 'Add new Notification', 'taskbot' ),
      'add_new'               => esc_html__( 'Add new Notification', 'taskbot' ),
      'new_item'              => esc_html__( 'New Notification', 'taskbot' ),
      'edit_item'             => esc_html__( 'Edit Notification', 'taskbot' ),
      'update_item'           => esc_html__( 'Update Notification', 'taskbot' ),
      'view_item'             => esc_html__( 'View Notification', 'taskbot' ),
      'view_items'            => esc_html__( 'View Notification', 'taskbot' ),
      'search_items'          => esc_html__( 'Search Notification', 'taskbot' ),
      'not_found'             => esc_html__( 'Not found', 'taskbot' ),
      'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'taskbot' ),
      'items_list'            => esc_html__( 'Notification list', 'taskbot' ),
      'items_list_navigation' => esc_html__( 'Notification list navigation', 'taskbot' ),
      'filter_items_list'     => esc_html__( 'Filter Notification list', 'taskbot' ),
    );

    $args = array(
      'label'                 => esc_html__( 'Notification', 'taskbot' ),
      'description'           => esc_html__( 'All Notifications', 'taskbot' ),
      'labels'                => apply_filters('taskbot_notification_cpt_labels', $labels),
      'supports'              => array('title','editor','author'),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'menu_position'         => 6,
      'menu_icon'             => 'dashicons-bell',
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => true,
      'exclude_from_search'   => true,
      'publicly_queryable' 	  => false,
      'capability_type'       => 'page',
      'show_in_rest'          => true,
      'rest_base'             => 'notification',
      'show_in_menu' 			    => 'edit.php?post_type=sellers',
      'rest_controller_class' => 'WP_REST_Posts_Controller',
    );

    register_post_type( apply_filters('taskbot_notification_post_type_name', 'notification'), $args );

  }

}

new Taskbot_CPT_Notification();