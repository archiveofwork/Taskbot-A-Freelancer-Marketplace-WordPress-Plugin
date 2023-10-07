<?php
/**
 * Custom settings for URL
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings/Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/
if( !class_exists('TaskbotCustomSetting')){
    class TaskbotCustomSetting {

        function __construct() {	
        
            add_action( 'load-options-permalink.php', array($this,'taskbot_save_settings') ); 
            add_action( 'admin_init', array($this,'taskbot_setting_init') );
            add_action('init', array($this,'taskbot_set_custom_rewrite_rule'));
        }

        function taskbot_get_post_types(  ) {
            $list	= array(
                'sellers'	=> esc_html__('Sellers','taskbot'),
            );
            $list 	= apply_filters('taskbot_filter_get_post_types',$list);
            return $list;
        }
        
        function taskbot_set_custom_rewrite_rule() {
            global $wp_rewrite;
            $settings 				= $this->taskbot_get_post_types();
            $taskbot_rewrit_url     = get_option( 'taskbot_rewrit_url' );
            if( !empty( $settings ) ){
                foreach ( $settings as $post_type => $name ) {
                    $db_slug	= !empty($taskbot_rewrit_url[$post_type]) ? $taskbot_rewrit_url[$post_type] : '';
                    if(!empty( $post_type ) && !empty($db_slug) ){
                        $args = get_post_type_object($post_type);
                        if( !empty( $args ) ){
                            $args->rewrite["slug"] = $db_slug;
                            register_post_type($args->name, $args);
                        }
                    }
                }
            }
            $wp_rewrite->flush_rules();
        } 

        function taskbot_save_settings() {
            if( isset( $_POST['taskbot_rewrit_url'] ) ) {
                update_option( 'taskbot_rewrit_url', ( $_POST['taskbot_rewrit_url'] ) );
            }
        }

        function taskbot_settings_field_callback($arg=array()) {
            $taskbot_rewrit_url     = get_option( 'taskbot_rewrit_url' );	
            $name                   = !empty($arg['name']) ? $arg['name'] : '';
            $value                  = !empty($taskbot_rewrit_url[$name]) ? $taskbot_rewrit_url[$name] : '';
            echo do_shortcode('<input type="text" value="' . esc_attr( $value ) . '" name="taskbot_rewrit_url['.do_shortcode($name).']" id="tb-'.esc_attr($name).'" class="regular-text" />');
        }

        function taskbot_custom_setting_section_form(){}
        
        function taskbot_setting_init(){
            add_settings_section(
                'taskbot_custom_setting_section',
                esc_html__('Rewrite Taskbot post type URL(s)','taskbot'),
                array($this,'taskbot_custom_setting_section_form'),
                'permalink'
            );
            $post_types = $this->taskbot_get_post_types();
            if( !empty($post_types) ){
                foreach($post_types as $key => $value ){
                    add_settings_field(
                        $key, 
                        $value, 
                        array($this,'taskbot_settings_field_callback'), 
                        'permalink', 
                        'taskbot_custom_setting_section',
                        array(
                            'name'      => $key
                        )
                    );
                }
            }
            
        }
    }
    new TaskbotCustomSetting();
}