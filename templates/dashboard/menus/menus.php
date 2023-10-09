<?php
/**
 * Menus listing
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard/menus
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/ 

global $taskbot_settings;
$taskbot_menu_list 	        = Taskbot_Profile_Menu::taskbot_get_dashboard_menu();
$taskbot_profile_menu_list 	= Taskbot_Profile_Menu::taskbot_get_dashboard_profile_menu();
$sortorder                  = array_column($taskbot_profile_menu_list, 'sortorder');
array_multisort($sortorder, SORT_ASC, $taskbot_profile_menu_list);

$list_sortorder                  = array_column($taskbot_menu_list, 'sortorder');
array_multisort($list_sortorder, SORT_ASC, $taskbot_menu_list);

?>
<nav class="tb-navbar navbar-expand-xl">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#tenavbar" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation','taskbot');?>">
        <i class="tb-icon-menu"></i>
    </button>
    <div id="tenavbar" class="collapse navbar-collapse">
        <ul class="navbar-nav tb-navbarnav">
            <?php if( !empty( $taskbot_menu_list ) ){
                foreach($taskbot_menu_list as $key => $menu_item){ 
                    if( !empty( $menu_item['type'] ) && ( $menu_item['type'] == $taskbot_user_role || $menu_item['type'] == 'none' ) ){
                        $menu_item['id'] = $key;                       
                        taskbot_get_template_part('dashboard/menus/menu', 'list-items', $menu_item);
                    }
                }
            }?>
        </ul>
    </div>
</nav>
<div class="tb-headerwrap__right">
    <div class="tb-userlogin sub-menu-holder">
        <a href="javascript:void(0);" id="profile-avatar-menue-icon">
            <?php Taskbot_Profile_Menu::taskbot_get_avatar();?>
        </a>
        <ul class="sub-menu">
            <?php if( !empty( $taskbot_profile_menu_list ) ){
                foreach($taskbot_profile_menu_list as $key => $menu_item){
                    if( !empty( $menu_item['type'] ) && ( $menu_item['type'] == $taskbot_user_role || $menu_item['type'] == 'none' ) ){
                        $menu_item['id'] = $key;
                        taskbot_get_template_part('dashboard/menus/menu', 'avatar-items', $menu_item);
                    }
                }
			} ?>
        </ul>
    </div>
</div>