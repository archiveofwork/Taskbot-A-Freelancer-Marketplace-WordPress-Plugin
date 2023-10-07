<?php
/**
 * Theme Settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/

if ( ! class_exists( 'Redux' ) ) { return;}
require_once(TASKBOT_DIRECTORY . '/libraries/scssphp/scss.inc.php');
$opt_name 	= "taskbot_settings";
$opt_name   = apply_filters( 'taskbot_settings_option_name', $opt_name );

$args = array(
    'opt_name'    		=> $opt_name,
    'display_name' 		=> esc_html__('Taskbot settings','taskbot') ,
    'display_version' 	=> TASKBOT_VERSION,
    'menu_type' 		=> 'menu',
    'allow_sub_menu' 	=> true,
    'menu_title' 		=> esc_html__('Taskbot settings', 'taskbot'),
	'page_title'        => esc_html__('Taskbot settings', 'taskbot') ,
    'google_api_key' 	=> '',
    'google_update_weekly' => false,
    'async_typography' 	   => true,
    'admin_bar' 		=> true,
    'admin_bar_icon' 	=> 'dashicons-admin-settings',
    'admin_bar_priority'=> 50,
    'global_variable' 	=> $opt_name,
    'dev_mode' 			=> false,
    'update_notice' 	=> false,
    'customizer' 		=> false,
    'page_priority' 	=> null,
    'page_parent' 		=> 'themes.php',
    'page_permissions'  => 'manage_options',
    'menu_icon' 		=> 'dashicons-admin-settings',
    'last_tab' 			=> '',
    'page_icon' 		=> 'icon-themes',
    'page_slug' 		=> 'taskbot_settings',
    'save_defaults' 	=> true,
    'default_show' 		=> false,
    'default_mark' 		=> '',
    'show_import_export' => true
);
 
Redux::setArgs ($opt_name, $args);

$scan = glob(TASKBOT_DIRECTORY."/admin/theme-settings/settings/*");
foreach ( $scan as $path ) {
    $file = pathinfo($path);
				
    if( !empty( $file['filename'] ) ){
        @include_once taskbot_load_template( '/admin/theme-settings/settings/'.$file['filename'] );
    } 

}

do_action( 'taskbot_settings_files');

if( !function_exists('taskbot_after_change_option') ){
    add_action ('redux/options/taskbot_settings/saved', 'taskbot_after_change_option');
    function taskbot_after_change_option($value){
        $primary_color      =  !empty($value['tb_primary_color']) ? $value['tb_primary_color'] : '#FCCF14';
        $secondary_color    =  !empty($value['tb_secondary_color']) ? $value['tb_secondary_color'] : '#0A0F26';
        $tertiary_color     =  !empty($value['tb_tertiary_color']) ? $value['tb_tertiary_color'] : '#1C1C1C';
        $link_color         =  !empty($value['tb_link_color']) ? $value['tb_link_color'] : '#1DA1F2';
        $button_color       =  !empty($value['tb_button_color']) ? $value['tb_button_color'] : '#1C1C1C';
        
        $compiler       = new ScssPhp\ScssPhp\Compiler();
        $source_scss    = TASKBOT_DIRECTORY . '/public/scss/style.scss';
        $scssContents   = file_get_contents($source_scss);
        $import_path    = TASKBOT_DIRECTORY . '/public/scss';
        $compiler->addImportPath($import_path);

        $target_css = TASKBOT_DIRECTORY . '/public/css/style.css';
        $variables  = array(
                        '$button-color'         => $button_color,
                        '$theme-color'          => $primary_color,
                        '$dark'                 => $secondary_color,
                        '$heading-font-color'   => $tertiary_color,
                        '$anchor-color'         => $link_color
                    );
        $compiler->setVariables($variables);
        
        $css = $compiler->compile($scssContents);
        if (!empty($css) && is_string($css)) {
            file_put_contents($target_css, $css);
        }
    }
}



//Redux design wrapper start
if( !function_exists('system_redux_style_start') ){
    add_action ('redux/'.$opt_name.'/panel/before', 'system_redux_style_start');
    function system_redux_style_start($value){
        echo '<div class="amt-redux-design">';
    }
}

//Redux design wrapper end
if( !function_exists('system_redux_style_end') ){
    add_action ('redux/'.$opt_name.'/panel/after', 'system_redux_style_end');
    function system_redux_style_end($value){
        echo '</div>';
    }
}