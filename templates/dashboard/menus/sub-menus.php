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

global $taskbot_settings,$current_user;
$user_identity 	 = intval($current_user->ID);
$taskbot_menu_list 	        = Taskbot_Profile_Menu::taskbot_get_dashboard_sub_menu();
$taskbot_profile_menu_list 	= Taskbot_Profile_Menu::taskbot_get_dashboard_profile_menu();
$sortorder                  = array_column($taskbot_profile_menu_list, 'sortorder');
array_multisort($sortorder, SORT_ASC, $taskbot_profile_menu_list);

$list_sortorder                  = array_column($taskbot_menu_list, 'sortorder');
array_multisort($list_sortorder, SORT_ASC, $taskbot_menu_list);
$user_type		 = apply_filters('taskbot_get_user_type', $current_user->ID );
$create_task    = $user_type === 'buyers' ? taskbot_get_page_uri('add_project_page') : taskbot_get_page_uri('add_service_page');
$create_task_btn_text    = $user_type === 'buyers' ? __('Create a project','taskbot') : __('Create a gig','taskbot');
$taskbot_user_role = apply_filters('taskbot_get_user_type', $user_identity);
?>
<div class="tk-headerbottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tk-seller-tabs">
                    <nav class="tb-navbar tb-navbarbtm navbar-expand-xl">
                        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNavvtwo" aria-expanded="false">
                            <i class="tb-icon-menu"></i>
                        </button>
                        <div class="navbar-collapse collapse" id="navbarNavvtwo" style="">
                            <ul class="navbar-nav tb-navbarnav" id="myTab" role="tablist">
                                <?php if( !empty( $taskbot_menu_list ) ){
                                        foreach($taskbot_menu_list as $key => $menu_item){ 
                                            if( !empty( $menu_item['type'] ) && ( $menu_item['type'] == $taskbot_user_role || $menu_item['type'] == 'none' ) ){
                                                $menu_item['id'] = $key;                       
                                                taskbot_get_template_part('dashboard/menus/menu', 'list-items', $menu_item);
                                            }
                                        }
                                    }
                                ?>
                            </ul>
                        </div>
                    </nav>
                    <div class="tk-bootstraps-tabs-button">
                        <a href="<?php echo esc_url($create_task);?>" class="tk-tabs-button">
                            <?php echo esc_html($create_task_btn_text);?>
                            <i class="tb-icon-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>