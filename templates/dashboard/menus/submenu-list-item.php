<?php
/**
 * Menus sub menu items
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard/menus
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user, $wp_roles, $userdata, $post,$taskbot_settings;
$reference 		 = (isset($args['ref']) && $args['ref'] <> '') ? $args['ref'] : '';
$mode 			 = (isset($args['mode']) && $args['mode'] <> '') ? $args['mode'] : '';
$title 			 = (isset($args['title']) && $args['title'] <> '') ? $args['title'] : '';
$id 			 = (isset($args['id']) && $args['id'] <> '') ? $args['id'] : '';
$icon_class 	 = (isset($args['icon']) && $args['icon'] <> '') ? $args['icon'] : '';
$class 			 = (isset($args['class']) && $args['class'] <> '') ? $args['class'] : '';
$user_identity 	 = $current_user->ID;

if(empty($reference) && empty($mode)){
	$url	= '#';
} else if( !empty($reference) && $reference === 'create_project'){
    $url	= taskbot_get_page_uri('add_project_page');
} else{
	$url	= Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity, true, $mode);
	if( !empty($reference) && $reference === 'create-task'){
		$url = !empty($taskbot_settings['tpl_add_service_page']) ? get_permalink($taskbot_settings['tpl_add_service_page']) : '';
    } else if( !empty($reference) && $reference === 'find-project'){
		$url 			= !empty($taskbot_settings['tpl_project_search_page']) ? get_permalink($taskbot_settings['tpl_project_search_page']) : '';
    }
}?>
<li class="<?php echo esc_attr($class); ?>">
	<a href="<?php echo esc_attr( $url ); ?>">
        <?php if(isset($icon_class) && !empty($icon_class)){?>
				<i class="<?php echo esc_attr($icon_class);?>"></i>
		<?php
			}
			if( !empty($title) ){
        		echo esc_html($title);
			}
        ?>
	</a>
</li>