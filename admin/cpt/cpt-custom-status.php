<?php

/**
 * 
 * Class 'Taskbot_CPT_Custom_Status' defines the post custom status
 * 
 * @package     Taskbot
 * @subpackage  Taskbot/admin/cpt
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */

if (!class_exists('Taskbot_CPT_Custom_Status')) {

    class Taskbot_CPT_Custom_Status {

        /**
         * @access  public
         * @Init Hooks in Constructor
         */
        public function __construct() {            
            add_action('init', array(&$this, 'dispute_custom_post_status'));
            add_action('admin_footer-post.php', array(&$this, 'dispute_append_post_status_list'));
        }

        /**
         * 
         * Registering custom post status
         * @access  public
        */
        public function dispute_custom_post_status(){
            register_post_status('declined', array(
                'label'                     => esc_html__('Declined', 'taskbot'),
                'public'                    => false,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop( 'Declined <span class="count">(%s)</span>', 'Declined <span class="count">(%s)</span>', 'taskbot'),
            ) );
			register_post_status('hired', array(
                'label'                     => esc_html__('Ongoing', 'taskbot'),
                'public'                    => false,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop( 'Ongoing <span class="count">(%s)</span>', 'Ongoing <span class="count">(%s)</span>', 'taskbot'),
            ) );
            register_post_status('refunded', array(
                'label'                     => esc_html__('Refunded', 'taskbot'),
                'public'                    => false,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop('Refunded <span class="count">(%s)</span>', 'Refunded <span class="count">(%s)</span>', 'taskbot'),
            ) );
			
            register_post_status('processing', array(
                'label'                     => esc_html__('Processing', 'taskbot'),
                'public'                    => false,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop('Processing <span class="count">(%s)</span>', 'Processing <span class="count">(%s)</span>', 'taskbot'),
            ) );
			
            register_post_status('disputed', array(
                'label'                     => esc_html__('Disputed', 'taskbot'),
                'public'                    => false,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop('Disputed <span class="count">(%s)</span>', 'Disputed <span class="count">(%s)</span>', 'taskbot'),
            ) );
			
            register_post_status('resolved', array(
                'label'                     => esc_html__('Resolved', 'taskbot'),
                'public'                    => false,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop('Resolved <span class="count">(%s)</span>', 'Resolved <span class="count">(%s)</span>', 'taskbot'),
            ) );
			
            register_post_status('cancelled', array(
                'label'                     => esc_html__('Cancelled', 'taskbot'),
                'public'                    => false,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop('Cancelled <span class="count">(%s)</span>', 'Cancelled <span class="count">(%s)</span>', 'taskbot'),
            ) );
			
            register_post_status('rejected', array(
                'label'                     => esc_html__('Rejected', 'taskbot'),
                'public'                    => false,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop('Rejected <span class="count">(%s)</span>', 'Rejected <span class="count">(%s)</span>', 'taskbot'),
            ) );
            register_post_status('completed', array(
                'label'                     => _x('Completed', 'Title for post type', 'taskbot' ),
                'public'                    => false,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop('Completed <span class="count">(%s)</span>', 'Completed <span class="count">(%s)</span>', 'taskbot'),
            ) );
        }

        /**
         * 
         * Append custom post status
         * @access  public
        */
        public function dispute_append_post_status_list(){
            global $post;
            $complete = '';
            $label = '';
           
            if($post->post_type == 'disputes'){
                $status = $post->post_status;
                
                if($post->post_status == 'declined'){
                    $complete = ' selected=\"selected\"';
                    $label = '<span id=\"post-status-display\"> '.esc_html__('Declined', 'taskbot').'</span>';
                } elseif($post->post_status == 'refunded'){
                    $complete = ' selected=\"selected\"';
                    $label = '<span id=\"post-status-display\"> '.esc_html__('Refunded', 'taskbot').'</span>';
                } elseif($post->post_status == 'processing'){
                    $complete = ' selected=\"selected\"';
                    $label = '<span id=\"post-status-display\"> '.esc_html__('Processing', 'taskbot').'</span>';
                } elseif($post->post_status == 'disputed'){
                    $complete = ' selected=\"selected\"';
                    $label = '<span id=\"post-status-display\"> '.esc_html__('Disputed', 'taskbot').'</span>';
                } elseif($post->post_status == 'resolved'){
                    $complete = ' selected=\"selected\"';
                    $label = '<span id=\"post-status-display\"> '.esc_html__('Resolved', 'taskbot').'</span>';
                } elseif($post->post_status == 'cancelled'){
                    $complete = ' selected=\"selected\"';
                    $label = '<span id=\"post-status-display\"> '.esc_html__('Cancelled', 'taskbot').'</span>';
                }elseif($post->post_status == 'hired'){
                    $complete = ' selected=\"selected\"';
                    $label = '<span id=\"post-status-display\"> '.esc_html__('Ongoing', 'taskbot').'</span>';
                }
                $label_title    = wp_strip_all_tags($label);
                $complete       = '';               
                echo do_shortcode('<script>
                jQuery(document).ready(function($){
                    jQuery("select#post_status").append("<option value=\"declined\" '.esc_js($complete).'> '.esc_html__('Declined', 'taskbot').'</option>");
                    jQuery("select#post_status").append("<option value=\"refunded\" '.esc_js($complete).'> '.esc_html__('Refunded', 'taskbot').'</option>");
                    jQuery("select#post_status").append("<option value=\"processing\" '.esc_js($complete).'> '.esc_html__('Processing', 'taskbot').'</option>");
                    jQuery("select#post_status").append("<option value=\"disputed\" '.esc_js($complete).'> '.esc_html__('Disputed', 'taskbot').'</option>");
                    jQuery("select#post_status").append("<option value=\"resolved\" '.esc_js($complete).'> '.esc_html__('Resolved', 'taskbot').'</option>");
                    jQuery("select#post_status").append("<option value=\"cancelled\" '.esc_js($complete).'> '.esc_html__('Cancelled', 'taskbot').'</option>");
                    jQuery("select#post_status").append("<option value=\"hired\" '.esc_js($complete).'> '.esc_html__('Ongoing', 'taskbot').'</option>");
                    jQuery(".misc-pub-section label").append("'.esc_js($label).'");
                    jQuery("#post-status-display").append("'.esc_js($label_title).'");   
                    $("select#post_status option[value='.esc_js($status).']").attr("selected", true);
                });
                </script>');

            } else if($post->post_type == 'proposals'){
                $status = $post->post_status;
                
                if($post->post_status == 'completed'){
                    $complete = ' selected=\"selected\"';
                    $label = '<span id=\"post-status-display\"> '._x('Completed', 'Title for post status', 'taskbot' ).'</span>';
                }elseif($post->post_status == 'cancelled'){
                    $complete = ' selected=\"selected\"';
                    $label = '<span id=\"post-status-display\"> '.esc_html__('Cancelled', 'taskbot').'</span>';
                }elseif($post->post_status == 'rejected'){
                    $complete = ' selected=\"selected\"';
                    $label = '<span id=\"post-status-display\"> '.esc_html__('Rejected', 'taskbot').'</span>';
                }elseif($post->post_status == 'hired'){
                    $complete = ' selected=\"selected\"';
                    $label = '<span id=\"post-status-display\"> '.esc_html__('Ongoing', 'taskbot').'</span>';
                }
                $label_title    = wp_strip_all_tags($label);
                $complete       = '';               
                echo do_shortcode('<script>
                jQuery(document).ready(function($){
                    jQuery("select#post_status").append("<option value=\"completed\" '.esc_js($complete).'> '._x('Completed', 'Title for post status', 'taskbot' ).'</option>");
                    jQuery("select#post_status").append("<option value=\"rejected\" '.esc_js($complete).'> '.esc_html__('Rejected', 'taskbot').'</option>");
                    
                    jQuery("select#post_status").append("<option value=\"cancelled\" '.esc_js($complete).'> '.esc_html__('Cancelled', 'taskbot').'</option>");
                    jQuery("select#post_status").append("<option value=\"hired\" '.esc_js($complete).'> '.esc_html__('Ongoing', 'taskbot').'</option>");
                    jQuery(".misc-pub-section label").append("'.esc_js($label).'");
                    jQuery("#post-status-display").append("'.esc_js($label_title).'");   
                    $("select#post_status option[value='.esc_js($status).']").attr("selected", true);
                });
                </script>');

            } elseif($post->post_type == 'product'){
                $status = $post->post_status;
                
                if($post->post_status == ''){
                    $complete 	= ' selected=\"selected\"';
                    $label 		= '<span id=\"post-status-display\"> '.esc_html__('Rejected', 'taskbot').'</span>';
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

    new Taskbot_CPT_Custom_Status();
}