<?php
/**
 * Directories settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings/Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/
$theme_version 	  = wp_get_theme();
$listing_view     = array('left' => esc_html__('Left','taskbot'));
if(!empty($theme_version->get( 'TextDomain' )) && ( $theme_version->get( 'TextDomain' ) === 'taskup' || $theme_version->get( 'TextDomain' ) === 'taskup-child' )){
  $listing_view['top']  = esc_html__('Top','taskbot');
}
Redux::setSection( $opt_name, array(
        'title'             => esc_html__( 'Search settings', 'taskbot' ),
        'id'                => 'search-settings',
        'desc'       	      => '',
        'icon' 			        => 'el el-search',
        'subsection'        => false,
            'fields'           => array(
                array(
                  'id'        => 'seller_listing_type',
                  'type'      => 'select',
                  'title'     => esc_html__('Seller filter position', 'taskbot'),
                  'desc'      => esc_html__('Select Seller filter position', 'taskbot'),
                  'options'   => $listing_view,
                  'default'   => 'left',
                ),
				array(
					'id'        => 'projects_listing_view',
					'type'      => 'select',
					'title'     => esc_html__('Projects filter position', 'taskbot'),
					'desc'      => esc_html__('Select projects filter position', 'taskbot'),
					'options'   => $listing_view,
					'default'   => 'left',
				),
				array(
					'id'        => 'task_listing_view',
					'type'      => 'select',
					'title'     => esc_html__('Task filter position', 'taskbot'),
					'desc'      => esc_html__('Select task filter position', 'taskbot'),
					'options'   => $listing_view,
					'default'   => 'left',
				),
              
        )
	)
);
Redux::setSection( $opt_name, array(
    'title'             	=> esc_html__( 'Task search settings', 'taskbot' ),
    'id'                	=> 'task_search_settings',
    'desc'       	      	=> '',
    'subsection'        	=> true,
    'icon'			        => 'el el-search',	
    'fields'            	=>  array(
								
								array(
									'id'        => 'hide_task_filter_location',
									'type'      => 'switch',
									'title'     => esc_html__('Show location in task search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the task search location filter in the task search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_task_filter_price',
									'type'      => 'switch',
									'title'     => esc_html__('Show price in task search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the price filter in the task search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_task_filter_categories',
									'type'      => 'switch',
									'title'     => esc_html__('Show categories in task search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the categories filter in the task search page', 'taskbot'),
									'default'   => true,
								),
			)
	));

Redux::setSection( $opt_name, array(
	'title'             	=> esc_html__( 'Project search settings', 'taskbot' ),
	'id'                	=> 'project_search_settings',
	'desc'       	      	=> '',
	'subsection'        	=> true,
	'icon'			        => 'el el-search',	
	'fields'            	=>  array(
								
								array(
									'id'        => 'hide_project_filter_type',
									'type'      => 'switch',
									'title'     => esc_html__('Show project type in project search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the project type filter in the project search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_project_filter_location',
									'type'      => 'switch',
									'title'     => esc_html__('Show location in project search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the project search location filter in the project search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_project_filter_skills',
									'type'      => 'switch',
									'title'     => esc_html__('Show project skills in project search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the project skills filter in the project search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_project_filter_level',
									'type'      => 'switch',
									'title'     => esc_html__('Show project expertise level in project search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the project expertise level filter in the project search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_project_filter_language',
									'type'      => 'switch',
									'title'     => esc_html__('Show project languages in project search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the project languages filter in the project search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_project_filter_price',
									'type'      => 'switch',
									'title'     => esc_html__('Show price in project search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the price filter in the project search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_project_filter_categories',
									'type'      => 'switch',
									'title'     => esc_html__('Show categories in project search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the categories filter in the project search page', 'taskbot'),
									'default'   => true,
								),
			)
	));

Redux::setSection( $opt_name, array(
	'title'             	=> esc_html__( 'Seller search settings', 'taskbot' ),
	'id'                	=> 'seller_search_settings',
	'desc'       	      	=> '',
	'subsection'        	=> true,
	'icon'			        => 'el el-search',	
	'fields'            	=>  array(
								
								array(
									'id'        => 'hide_seller_filter_type',
									'type'      => 'switch',
									'title'     => esc_html__('Show seller type in seller search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the seller type filter in the seller search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_seller_filter_location',
									'type'      => 'switch',
									'title'     => esc_html__('Show location in seller search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the seller search location filter in the seller search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_seller_filter_skills',
									'type'      => 'switch',
									'title'     => esc_html__('Show seller skills in seller search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the seller skills filter in the seller search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_seller_filter_level',
									'type'      => 'switch',
									'title'     => esc_html__('Show seller english level in seller search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the seller english level filter in the seller search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_seller_filter_language',
									'type'      => 'switch',
									'title'     => esc_html__('Show seller languages in seller search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the seller languages filter in the seller search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_seller_filter_price',
									'type'      => 'switch',
									'title'     => esc_html__('Show hourly rate in seller search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the hourly rate filter in the seller search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_seller_without_avatar',
									'type'      => 'select',
									'title'     => esc_html__('Hide sellers', 'taskbot'),
									'desc'      => esc_html__('Hide sellers without profile picture', 'taskbot'),
									'options'   => array(
										'yes'	=> esc_html__('Yes, hide profiles', 'taskbot'),
										'no'	=> esc_html__('No', 'taskbot'),
									),
									'default'   => 'no',
								),
			)
	));