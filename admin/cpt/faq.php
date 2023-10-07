<?php
/**
 * Class 'Taskbot_Admin_CPT_FAQ' defines the cusotm post type
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/cpt
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */
class Taskbot_CPT_FAQ {

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
    $this->register_taxonomy();
  }

  /**
   *Regirster FAQ post type
   */
  public function register_posttype() {


    $labels = array(
      'name'                  => esc_html__( 'FAQ', 'taskbot' ),
      'singular_name'         => esc_html__( 'FAQ', 'taskbot' ),
      'menu_name'             => esc_html__( 'FAQ', 'taskbot' ),
      'name_admin_bar'        => esc_html__( 'FAQ', 'taskbot' ),
      'archives'              => esc_html__( 'FAQ Archives', 'taskbot' ),
      'attributes'            => esc_html__( 'FAQ Attributes', 'taskbot' ),
      'parent_item_colon'     => esc_html__( 'Parent FAQ:', 'taskbot' ),
      'all_items'             => esc_html__( 'All FAQ', 'taskbot' ),
      'add_new_item'          => esc_html__( 'Add new FAQ', 'taskbot' ),
      'add_new'               => esc_html__( 'Add new FAQ', 'taskbot' ),
      'new_item'              => esc_html__( 'New FAQ', 'taskbot' ),
      'edit_item'             => esc_html__( 'Edit FAQ', 'taskbot' ),
      'update_item'           => esc_html__( 'Update FAQ', 'taskbot' ),
      'view_item'             => esc_html__( 'View FAQ', 'taskbot' ),
      'view_items'            => esc_html__( 'View FAQ', 'taskbot' ),
      'search_items'          => esc_html__( 'Search FAQ', 'taskbot' ),
      'not_found'             => esc_html__( 'Not found', 'taskbot' ),
      'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'taskbot' ),
      'featured_image'        => esc_html__( 'Featured Image', 'taskbot' ),
      'set_featured_image'    => esc_html__( 'Set featured image', 'taskbot' ),
      'remove_featured_image' => esc_html__( 'Remove featured image', 'taskbot' ),
      'use_featured_image'    => esc_html__( 'Use as featured image', 'taskbot' ),
      'insert_into_item'      => esc_html__( 'Insert into Profile', 'taskbot' ),
      'uploaded_to_this_item' => esc_html__( 'Uploaded to this Profile', 'taskbot' ),
      'items_list'            => esc_html__( 'FAQ list', 'taskbot' ),
      'items_list_navigation' => esc_html__( 'FAQ list navigation', 'taskbot' ),
      'filter_items_list'     => esc_html__( 'Filter FAQ list', 'taskbot' ),
    );

    $args = array(
      'label'                 => esc_html__( 'FAQ', 'taskbot' ),
      'description'           => esc_html__( 'All FAQs', 'taskbot' ),
      'labels'                => apply_filters('taskbot_faq_cpt_labels', $labels),
      'supports'              => array( 'title','editor'),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'menu_position'         => 5,
      'menu_icon'             => 'dashicons-editor-help',
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => true,
      'exclude_from_search'   => true,
      'publicly_queryable'    => true,
      'capability_type'       => 'page',
      'show_in_rest'          => true,
      'rest_base'             => 'FAQ',
      'rest_controller_class' => 'WP_REST_Posts_Controller',
    );

    register_post_type( apply_filters('taskbot_faq_post_type_name', 'faq'), $args );

  }

  /**
   *Regirster FAQ post type
   */
  public function register_taxonomy() {
    $cat_labels = array(
      'name' 					=> esc_html__('Categories', 'taskbot'),
      'singular_name' 		=> esc_html__('Category','taskbot'),
      'search_items'			=> esc_html__('Search Category', 'taskbot'),
      'all_items' 				=> esc_html__('All Category', 'taskbot'),
      'parent_item' 			=> esc_html__('Parent Category', 'taskbot'),
      'parent_item_colon' => esc_html__('Parent Category:', 'taskbot'),
      'edit_item' 				=> esc_html__('Edit Category', 'taskbot'),
      'update_item' 			=> esc_html__('Update Category', 'taskbot'),
      'add_new_item' 			=> esc_html__('Add New Category', 'taskbot'),
      'new_item_name' 		=> esc_html__('New Category Name', 'taskbot'),
      'menu_name' 				=> esc_html__('Categories', 'taskbot'),
    );

    $cat_args = array(
      'hierarchical'              => true,
      'labels'			              => apply_filters('taskbot_faq_taxonomy_labels', $cat_labels),
      'show_ui'                   => true,
      'show_admin_column'         => true,
      'query_var'                 => true,
      'rewrite'                   => array('slug' => 'faq_categories'),
      'show_in_rest'              => true,
      'rest_base'                 => 'faq_categories',
      'rest_controller_class'     => 'WP_REST_Terms_Controller'
      
    );

    register_taxonomy('faq_categories', array('faq'), $cat_args);
  }
}

new Taskbot_CPT_FAQ();