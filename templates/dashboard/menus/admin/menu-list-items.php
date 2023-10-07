<?php
/**
 * Menus list items
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard/menus/admin
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/ 

global $current_user;

$taskbot_menu_list 	= Taskbot_Profile_Menu::taskbot_get_admin_menu();
$sortorder          = array_column($taskbot_menu_list, 'sortorder');
array_multisort($sortorder, SORT_ASC, $taskbot_menu_list);
$user_identity      = $current_user->ID;
$current_tab        = !empty($_GET['ref']) ? esc_html($_GET['ref']) : '';
foreach( $taskbot_menu_list as $key => $val ){
    $reference 		 = (isset($val['ref']) && $val['ref'] <> '') ? esc_html($val['ref']) : '';
    $mode 			 = (isset($val['mode']) && $val['mode'] <> '') ? esc_html($val['mode']) : '';
    $title 			 = (isset($val['title']) && $val['title'] <> '') ? esc_html($val['title']) : '';
    $id 			 = (isset($val['id']) && $val['id'] <> '') ? $val['id'] : '';
    $icon_class 	 = (isset($val['icon']) && $val['icon'] <> '') ? $val['icon'] : '';
    $class 			 = (isset($val['class']) && $val['class'] <> '') ? $val['class'] : '';
    $active_class    = !empty($reference) && $reference === $current_tab ? 'active' : '';

    if(empty($reference) && empty($mode)){
        $url	= '#';
    } else {
        $url	= Taskbot_Profile_Menu::taskbot_admin_profile_menu_link($reference, $user_identity, true, $mode);
    }
    
    if( !empty($reference) && $reference === 'logout' ){
        $url	= esc_url(wp_logout_url(home_url('/')));
    }
    
    $messages_count = apply_filters('wpguppy_count_all_unread_messages', $user_identity );
    ?>
    <li class="<?php echo esc_attr($class); ?> <?php echo esc_attr($active_class); ?>">
        <a href="<?php echo esc_attr( $url ); ?>">
            <?php if(isset($icon_class) && !empty($icon_class)){?>
                    <i class="<?php echo esc_attr($icon_class);?>"></i>
            <?php } ?>
            <span class="tb-navdashboard__title">
                <?php echo esc_html($title); ?>
                <?php  if( !empty($key) && $key === 'inbox' && (in_array('wp-guppy/wp-guppy.php', apply_filters('active_plugins', get_option('active_plugins'))) || in_array('wpguppy-lite/wpguppy-lite.php', apply_filters('active_plugins', get_option('active_plugins')))) ){ ?>
                    <?php if(!empty($messages_count) ){?><em class="tk-remaining-notification"><?php echo esc_html($messages_count);?></em><?php } ?>
                <?php } ?>
            </sapn>
            
        </a>
    </li>
<?php }
