<?php
/**
 * Menus list items
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard/menus
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/ 

global $current_user, $wp_roles, $userdata, $post;

$reference      = (isset($args['ref']) && $args['ref'] <> '') ? esc_html($args['ref']) : '';
$mode           = (isset($args['mode']) && $args['mode'] <> '') ? esc_html($args['mode']) : '';
$title          = (isset($args['title']) && $args['title'] <> '') ? esc_html($args['title']) : '';
$type          = (isset($args['type']) && $args['type'] <> '') ? esc_html($args['type']) : '';
$id             = (isset($args['id']) && $args['id'] <> '') ? intval($args['id']) : '';
$icon_class     = (isset($args['icon']) && $args['icon'] <> '') ? esc_html($args['icon']) : '';
$class          = (isset($args['class']) && $args['class'] <> '') ? esc_html($args['class']) : '';
$user_identity  = $current_user->ID;

$user_type		= apply_filters('taskbot_get_user_type', $user_identity);
$linked_profile	= taskbot_get_linked_profile_id($user_identity,'',$user_type);

$sub_meu            = false;
if(isset($args['submenu']) && is_array($args['submenu']) && count($args['submenu'])>0){
    $list_submenus              = !empty($args['submenu']) ? $args['submenu'] : array();
    $sortorder                  = array_column($list_submenus, 'sortorder');
    array_multisort($sortorder, SORT_ASC, $list_submenus);
    $sub_meu            = true;
    $class              .= ' menu-item-has-children';
}
if(empty($reference) && empty($mode)){
	$url	= '#';
} else {
    $url	= Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity, true, $mode);
    
    if( !empty($reference) && $reference === 'packages'){
        $url	= taskbot_get_page_uri('package_page');
    } else if( !empty($reference) && $reference === 'find-task'){
        $url	= taskbot_get_page_uri('service_search_page');
    }else if( !empty($reference) && $reference === 'create_project'){
        $url	= taskbot_get_page_uri('add_project_page');
    }
	
}

$messages_count = apply_filters('wpguppy_count_all_unread_messages', $user_identity );
?>
<li class="<?php echo esc_attr($class); ?>">
    <?php if( !empty($reference) && $reference === 'notifications'){
        $args['linked_profile']    = $linked_profile;
        taskbot_get_template_part('dashboard/dashboard', 'list-notification', $args);
    } else {?>
        <a href="<?php echo esc_url( $url ); ?>">
            <?php if(isset($icon_class) && !empty($icon_class)){?>
                    <i class="<?php echo esc_attr($icon_class);?>"></i>
                    <?php
                }
                if(!empty($title)){ echo esc_html($title);}
                if( !empty($reference) && $reference === 'inbox' && (in_array('wp-guppy/wp-guppy.php', apply_filters('active_plugins', get_option('active_plugins'))) || in_array('wpguppy-lite/wpguppy-lite.php', apply_filters('active_plugins', get_option('active_plugins')))) ){ ?>
                    <?php if(!empty($messages_count) ){?><em class="tk-remaining-notification"><?php echo esc_html($messages_count);?></em><?php } ?>
                    <span><?php esc_html_e('Messages','taskbot');?></span>
                <?php } 
            ?>
        </a>
        <?php if( !empty($sub_meu)){ ?>
            <ul class="sub-menu">
                <?php foreach($list_submenus as $key => $submenu_item){
                    $submenu_item['id']         = $key;
                    $submenu_item['reference']  = $reference;
                    taskbot_get_template_part('dashboard/menus/submenu', 'list-item', $submenu_item);
                } ?>
            </ul>
        <?php }?>
    <?php } ?>
</li>
