<?php
/**
 * Menus avatar dropdown items
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard/menus
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/ 

global $current_user, $wp_roles, $userdata, $post;

$reference 		 = (isset($args['ref']) && $args['ref'] <> '') ? esc_html($args['ref']) : '';
$mode 			 = (isset($args['mode']) && $args['mode'] <> '') ? esc_html($args['mode']) : '';
$title 			 = (isset($args['title']) && $args['title'] <> '') ? esc_html($args['title']) : '';
$id 			 = (isset($args['id']) && $args['id'] <> '') ? esc_attr($args['id']) : '';
$icon_class 	 = (isset($args['icon']) && $args['icon'] <> '') ? esc_html($args['icon']) : '';
$class 			 = (isset($args['class']) && $args['class'] <> '') ? esc_html($args['class']) : '';
$data_attr 			 = (isset($args['data-attr']) && $args['data-attr'] <> '') ? $args['data-attr']: array();
$user_identity 	 = $current_user->ID;

if(isset($args['submenu']) && is_array($args['submenu']) && count($args['submenu'])>0){
    $class .= ' tb-menudropdown';
}

if(empty($reference) && empty($mode)){
	$url	= '#';
} else {
	$url	= Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity, true, $mode);
}

$target 		    = '_self';
$data_attr_list     = '';

if(!empty($data_attr)){
    foreach($data_attr as $key => $data_id){
        $data_attr_list  .= $key.'='. $data_id;
    }
}

if(!empty($reference) && $reference == 'logout'){
	$url	= esc_url(wp_logout_url(home_url('/')));
} else if( !empty($reference) && $reference === 'packages'){
    $url	= taskbot_get_page_uri('package_page');
} else if( !empty($reference) && $reference === 'profile'){
    $user_type		    = apply_filters('taskbot_get_user_type', $current_user->ID );
    $linked_profile	    = taskbot_get_linked_profile_id($current_user->ID,'',$user_type);
    $url	            = get_the_permalink($linked_profile);
    $target 		    = '_blank';
} else if( !empty($reference) && $reference === 'create_project'){
    $url	= taskbot_get_page_uri('add_project_page');
}

if( !empty($id) && $id === 'wallet' ){
    $user_balance   = get_user_meta( $user_identity, '_buyer_balance',true );
    $user_balance   = !empty($user_balance) ? $user_balance : 0;
    ?>
    <li class="<?php echo esc_attr($class); ?>" <?php echo esc_attr($data_attr_list); ?>>
        <?php if(isset($icon_class) && !empty($icon_class)){?>
            <i class="<?php echo esc_attr($icon_class);?>"></i>
        <?php } ?>
        <span><?php echo esc_html($title)?> <strong><?php taskbot_price_format($user_balance);?></strong></span>
        <a href="javascript:void(0);" data-bs-target="#tbcreditwallet" data-bs-toggle="modal"><em class="icon-credit-card"></em></a>
    </li>
<?php } else if( !empty($id) && $id === 'balance' ){
    $account_blance             = taskbot_account_details($user_identity,array('wc-completed'),'completed');
    $withdrawn_amount           = taskbot_account_withdraw_details($user_identity,array('pending','publish'));
    $available_withdraw_amount  = $account_blance - $withdrawn_amount;
    $available_withdraw_amount  = !empty($available_withdraw_amount) && $available_withdraw_amount > 0 ? $available_withdraw_amount : 0; 
    ?>
    <li class="<?php echo esc_attr($class); ?>" <?php echo esc_attr($data_attr_list); ?>>
        <?php if(isset($icon_class) && !empty($icon_class)){?>
            <i class="<?php echo esc_attr($icon_class);?>"></i>
        <?php } ?>
        <span><?php echo esc_html($title)?> <strong><?php taskbot_price_format($available_withdraw_amount);?></strong></span>
        <a href="<?php Taskbot_Profile_Menu::taskbot_profile_menu_link($reference, $user_identity)?>"><em class="icon-credit-card"></em></a>
    </li>
<?php } else { ?>
    <li class="<?php echo esc_attr($class); ?>" <?php echo ($data_attr_list); ?>>
        <a href="<?php echo esc_attr( $url ); ?>" target="<?php echo esc_attr( $target ); ?>">
            <?php if(isset($icon_class) && !empty($icon_class)){?><i class="<?php echo esc_attr($icon_class);?>"></i><?php } echo esc_html($title);?>
        </a>
        <?php if(isset($args['submenu']) && is_array($args['submenu']) && count($args['submenu'])>0){ ?>
            <ul class="sub-menu">
                <?php foreach($args['submenu'] as $key => $submenu_item){
                    $submenu_item['id'] = $key;
                    $submenu_item['reference'] = $reference;
                    taskbot_get_template_part('dashboard/menus/submenu', 'list-item', $submenu_item);
                }?>
            </ul>
        <?php }?>
    </li>
<?php }
