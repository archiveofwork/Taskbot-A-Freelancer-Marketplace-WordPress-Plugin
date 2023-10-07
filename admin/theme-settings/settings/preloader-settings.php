<?php
/**
 * General Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
$theme_version 		= wp_get_theme();
if(!empty($theme_version->get( 'TextDomain' )) && ( $theme_version->get( 'TextDomain' ) === 'taskon' || $theme_version->get( 'TextDomain' ) === 'taskon-child' )){
	Redux::setSection( $opt_name, array(
		'title'            => esc_html__( 'Preloader settings', 'taskbot' ),
		'id'               => 'preloader_settings',
		'subsection'       => false,
		'icon'			   => 'el el-globe',
		'fields'           => array(
				array(
					'id'       => 'site_loader',
					'type'     => 'switch',
					'title'    => esc_html__( 'Preloader on/off', 'taskbot' ),
					'default'  => false,
					'desc'     => esc_html__( '', 'taskbot' ),
				),	
				array(
					'id'       => 'loader_type',
					'type'     => 'select',
					'title'    => esc_html__('Select Type', 'taskbot'), 
					'desc'     => esc_html__('Please select loader type.', 'taskbot'),
					'options'  => array(
						'default' 	=> esc_html__('Default', 'taskbot'), 
						'custom' 	=> esc_html__('Custom', 'taskbot'), 
					),
					'default'  => 'default',
					'required' => array( 'site_loader', '=', true ),
				),
				array(
					'id'       => 'loader_image',
					'type'     => 'media',
					'url'      => true,
					'title'    => esc_html__( 'Loader image?', 'taskbot' ),
					'compiler' => 'true',
					'desc'     => esc_html__( 'Uplaod loader image', 'taskbot' ),
					'required' => array( 'loader_type', '=', 'custom' )
				),	
				
				array(
					'id'       => 'loader_duration',
					'type'     => 'select',
					'title'    => esc_html__('Loader duration?', 'taskbot'), 
					'desc'     => esc_html__('Select site loader speed', 'taskbot'),
					'options'  => array(
						'250' 	=> esc_html__('1/4th Seconds', 'taskbot'), 
						'500' 	=> esc_html__('Half Second', 'taskbot'), 
						'1000' 	=> esc_html__('1 Second', 'taskbot'), 
						'2000' 	=> esc_html__('2 Seconds', 'taskbot'), 
					),
					'default'  => '250',
					'required' => array( 'site_loader', '=', true ),
				),
			)
		)
	);
} else if(!empty($theme_version->get( 'TextDomain' )) && ( $theme_version->get( 'TextDomain' ) === 'taskup' || $theme_version->get( 'TextDomain' ) === 'taskup-child' )){
	Redux::setSection( $opt_name, array(
		'title'            => esc_html__( 'Preloader settings', 'taskbot' ),
		'id'               => 'preloader_settings',
		'subsection'       => false,
		'icon'			   => 'el el-globe',
		'fields'           => array(
				array(
					'id'       => 'site_loader',
					'type'     => 'switch',
					'title'    => esc_html__( 'Preloader on/off', 'taskbot' ),
					'default'  => false,
					'desc'     => esc_html__( '', 'taskbot' ),
				),	
				array(
					'id'       => 'loader_type',
					'type'     => 'select',
					'title'    => esc_html__('Select Type', 'taskbot'), 
					'desc'     => esc_html__('Please select loader type.', 'taskbot'),
					'options'  => array(
						'default' 	=> esc_html__('Default', 'taskbot'), 
						'custom' 	=> esc_html__('Custom', 'taskbot'), 
					),
					'default'  => 'default',
					'required' => array( 'site_loader', '=', true ),
				),
				array(
					'id'       => 'loader_image',
					'type'     => 'media',
					'url'      => true,
					'title'    => esc_html__( 'Loader image?', 'taskbot' ),
					'compiler' => 'true',
					'desc'     => esc_html__( 'Uplaod loader image', 'taskbot' ),
					'required' => array( 'loader_type', '=', 'custom' )
				),	
				
				array(
					'id'       => 'loader_duration',
					'type'     => 'select',
					'title'    => esc_html__('Loader duration?', 'taskbot'), 
					'desc'     => esc_html__('Select site loader speed', 'taskbot'),
					'options'  => array(
						'250' 	=> esc_html__('1/4th Seconds', 'taskbot'), 
						'500' 	=> esc_html__('Half Second', 'taskbot'), 
						'1000' 	=> esc_html__('1 Second', 'taskbot'), 
						'2000' 	=> esc_html__('2 Seconds', 'taskbot'), 
					),
					'default'  => '250',
					'required' => array( 'site_loader', '=', true ),
				),
			)
		)
	);
}