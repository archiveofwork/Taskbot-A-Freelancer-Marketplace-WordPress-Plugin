<?php
/**
 * Header Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
$theme_version 		= wp_get_theme();
if(!empty($theme_version->get( 'TextDomain' )) && ( $theme_version->get( 'TextDomain' ) === 'taskon' || $theme_version->get( 'TextDomain' ) === 'taskon-child' )){
	Redux::setSection( $opt_name, array(
			'title'            => esc_html__( 'Header settings', 'taskbot' ),
			'id'               => 'header_settings',
			'icon'			   => 'el el-align-justify',
			'subsection'       => false,
			'fields'           => array(
				array(
					'id'		=> 'main_logo',
					'type' 		=> 'media',
					'url'		=> true,
					'title' 	=> esc_html__('Logo', 'taskbot'),
					'desc' 		=> esc_html__('Upload site header logo.', 'taskbot'),
				),
				array(
					'id'		=> 'transparent_logo',
					'type' 		=> 'media',
					'url'		=> true,
					'title' 	=> esc_html__('Transparent logo', 'taskbot'),
					'desc' 		=> esc_html__('Upload site header transparent logo.', 'taskbot'),
				),
				array(
					'id' 		=> 'logo_wide',
					'type' 		=> 'slider',
					'title' 	=> esc_html__('Set logo width', 'taskbot'),
					'desc' 		=> esc_html__('Leave it empty to hide.', 'taskbot'),
					"default" 	=> 143,
					"min" 		=> 0,
					"step" 		=> 1,
					"max" 		=> 500,
					'display_value' => 'label',
				),
				array(
					'id'    	=> 'tb_dark_header',
					'type'  	=> 'select',
					'title' 	=> esc_html__( 'Dark header', 'taskbot' ),
					'data'  	=> 'pages',
					'multi'    => true,
					'desc'      => esc_html__('Select dark pages header.', 'taskbot'),
				),
				array(
					'id'    	=> 'tb_transparent_header',
					'type'  	=> 'select',
					'title' 	=> esc_html__( 'Transparent header', 'taskbot' ),
					'data'  	=> 'pages',
					'multi'    => true,
					'desc'      => esc_html__('Select transparent pages header.', 'taskbot'),
				),
				array(
					'id'       => 'header_search',
					'type'     => 'switch',
					'title'    => esc_html__( 'Header search form on/off', 'taskbot' ),
					'default'  => false,
					'desc'     => esc_html__( '', 'taskbot' ),
				),	
				array(
					'id'		=> 'form_pages',
					'type'  	=> 'select',
					'title' 	=> esc_html__( 'Select pages to show form', 'taskbot' ),
					'data'  	=> 'pages',
					'multi'    	=> true,
					'required' 	=> array( 'header_search', '=', true ),
				),
				array(
					'id'       => 'search_result',
					'type'     => 'select',
					'title'    => esc_html__('Select defult search type', 'taskbot'), 
					'options'  => array(
						'sellers_search_page'		=> esc_html__('Sellers','taskbot'),
						'service_search_page'		=> esc_html__('Services','taskbot'),
						'project_search_page'		=> esc_html__('Projects','taskbot'),
					),
					'default'  => 'service_search_page',
					'required' => array( 'header_search', '=', true ),
				),
			)
		)
	);
}else if(!empty($theme_version->get( 'TextDomain' )) && ( $theme_version->get( 'TextDomain' ) === 'taskup' || $theme_version->get( 'TextDomain' ) === 'taskup-child' )){
	Redux::setSection( $opt_name, array(
		'title'            => esc_html__( 'Header settings', 'taskbot' ),
		'id'               => 'header_settings',
		'icon'			   => 'el el-align-justify',
		'subsection'       => false,
		'fields'           => array(
			array(
				'id'		=> 'main_logo',
				'type' 		=> 'media',
				'url'		=> true,
				'title' 	=> esc_html__('Logo', 'taskbot'),
				'desc' 		=> esc_html__('Upload site header logo.', 'taskbot'),
			),
			array(
				'id'		=> 'transparent_logo',
				'type' 		=> 'media',
				'url'		=> true,
				'title' 	=> esc_html__('Transparent logo', 'taskbot'),
				'desc' 		=> esc_html__('Upload site header transparent logo.', 'taskbot'),
			),
			array(
				'id' 		=> 'logo_wide',
				'type' 		=> 'slider',
				'title' 	=> esc_html__('Set logo width', 'taskbot'),
				'desc' 		=> esc_html__('Leave it empty to hide.', 'taskbot'),
				"default" 	=> 143,
				"min" 		=> 0,
				"step" 		=> 1,
				"max" 		=> 500,
				'display_value' => 'label',
			),
			array(
				'id'    	=> 'tb_transparent_header',
				'type'  	=> 'select',
				'title' 	=> esc_html__( 'Transparent header', 'taskbot' ),
				'data'  	=> 'pages',
				'multi'    => true,
				'desc'      => esc_html__('Select transparent pages header.', 'taskbot'),
			),
			array(
				'id'       => 'search_result',
				'type'     => 'select',
				'title'    => esc_html__('Select defult search type', 'taskbot'), 
				'options'  => array(
					'sellers_search_page'		=> esc_html__('Sellers','taskbot'),
					'service_search_page'		=> esc_html__('Services','taskbot'),
					'project_search_page'		=> esc_html__('Projects','taskbot'),
				),
				'default'  => 'service_search_page',
			),
		)
	));
}