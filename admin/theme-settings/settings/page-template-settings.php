<?php
/**
 * Template Settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings/Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/
$add_page_template	= array(
	array(
		'id'    	=> 'tpl_admin_dashboard',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Administrator dashboard page', 'taskbot' ),
		'data'  	=> 'pages',
		'desc'      => esc_html__('Select page for the administrator dashboard page', 'taskbot'),
	),
	array(
		'id'    	=> 'tpl_dashboard',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'User dashboard page', 'taskbot' ),
		'data'  	=> 'pages',
		'desc'      => esc_html__('Select page for the dashboard page', 'taskbot'),
	),
	array(
		'id'    	=> 'tpl_terms_conditions',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Terms & conditions', 'taskbot' ),
		'data'  	=> 'pages',
		'desc'      => esc_html__('Select page for the terms & conditions', 'taskbot'),
	),
	array(
		'id'    	=> 'tpl_privacy',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Privacy policy', 'taskbot' ),
		'data'  	=> 'pages',
		'desc'      => esc_html__('Select page for the privacy', 'taskbot'),
	),
	array(
		'id'    	=> 'tpl_login',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Login page', 'taskbot' ),
		'data'  	=> 'pages',
		'desc'      => esc_html__('Select login page', 'taskbot'),
		'required'  => array('registration_view_type', '=', 'pages'),
	),
	array(
		'id'    	=> 'tpl_registration',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Registration page', 'taskbot' ),
		'data'  	=> 'pages',
		'desc'      => esc_html__('Select registration page', 'taskbot'),
		'required'  => array('registration_view_type', '=', 'pages'),
	),
	  array(
		'id'    	=> 'tpl_forgot_password',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Forgot Password page', 'taskbot' ),
		'data'  	=> 'pages',
		'desc'      => esc_html__('Select forgot password page', 'taskbot'),
		'required'  => array('registration_view_type', '=', 'pages'),
	),
	  array(
		'id'    	=> 'tpl_service_search_page',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Search task', 'taskbot' ),
		'data'  	=> 'pages',
		'desc'      => esc_html__('Select task search page', 'taskbot'),
	),
	array(
		'id'    	=> 'tpl_project_search_page',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Search project', 'taskbot' ),
		'data'  	=> 'pages',
		'desc'      => esc_html__('Select project search page', 'taskbot'),
	),
	array(
		'id'    	=> 'tpl_sellers_search_page',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Search sellers', 'taskbot' ),
		'data'  	=> 'pages',
		'desc'      => esc_html__('Select sellers search page', 'taskbot'),
	),
	array(
		'id'    	=> 'tpl_add_project_page',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Add/edit project', 'taskbot' ),
		'data'  	=> 'pages',
		'desc'      => esc_html__('Select add/edit project page template', 'taskbot'),
	),
	array(
		'id'    	=> 'tpl_submit_proposal_page',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Add/edit proposal', 'taskbot' ),
		'data'  	=> 'pages',
		'desc'      => esc_html__('Select add/edit proposal page template', 'taskbot'),
	),
	array(
		'id'    	=> 'tpl_add_service_page',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Add/edit task', 'taskbot' ),
		'data'  	=> 'pages',
		'desc'      => esc_html__('Select add/edit task page template', 'taskbot'),
	),
	array(
		'id'    	=> 'tpl_package_page',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Select packages page', 'taskbot' ),
		'data'  	=> 'pages',
		'desc'      => esc_html__('Select packages page template', 'taskbot'),
		
	),
);
$add_page_template	= apply_filters( 'taskbot_list_page_template', $add_page_template );
Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Template settings', 'taskbot' ),
        'id'               => 'template_settings',
        'desc'       	   => '',
		'icon' 			   => 'el el-search',
		'subsection'       => false,
        'fields'           => $add_page_template
	)
);
