<?php
/**
 * Taskup blog Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
$theme_version 		= wp_get_theme();

if(!empty($theme_version->get( 'TextDomain' )) && ( $theme_version->get( 'TextDomain' ) === 'taskup' || $theme_version->get( 'TextDomain' ) === 'taskup-child' )){
	
	Redux::setSection( $opt_name, array(
			'title'            => esc_html__( 'Blog settings', 'taskbot' ),
			'id'               => 'blog_settings',
			'subsection'       => false,
			'icon'			   => 'el el-align-center',
			'fields'           => array(
				array(
					'id'       => 'blog_listing_view',
					'type'     => 'select',
					'title'    => esc_html__( 'Blog listing view', 'taskbot' ),
					'desc'     => esc_html__( 'Select view for blog main page', 'taskbot' ),
					'options'   => array(
						'v1' => esc_html__('View 1', 'taskbot'),
						'v2' => esc_html__('View 2', 'taskbot'),
						'v3' => esc_html__('View 3', 'taskbot'),
					),
					'default'  => 'v1',
				),
				array(
					'id'       => 'side-layout',
					'type'     => 'image_select',
					'title'    => __('Select Layout', 'taskbot'), 
					'subtitle' => __('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'taskbot'),
					'options'  => array(
						'none'      => array(
							'alt'   => '1 Column', 
							'img'   => ReduxFramework::$_url.'assets/img/1col.png'
						),
						'left'      => array(
							'alt'   => '2 Column Left', 
							'img'   => ReduxFramework::$_url.'assets/img/2cl.png'
						),
						'right'      => array(
							'alt'   => '2 Column Right', 
							'img'  => ReduxFramework::$_url.'assets/img/2cr.png'
						),
					),
					'default' => 'left'
				),		
				array (
					'id'       	=> 'layout_sidebar',
					'type'     	=> 'select',
					'title'    	=> __('Select sidebar', 'taskbot'), 
					'subtitle' 	=> __('Select sidebar for blog page template', 'taskbot'),
					'data'  	=> 'sidebars',
					'required' 	=> array('side-layout','!=','none')
				),	
				array(
					'id'      => 'blog_settings_divider_1',
					'type'    => 'info',
					'title'   => esc_html__( 'Blog detail settings', 'taskbot' ),
					'style'   => 'info',
				),
				array(
					'id'       => 'author_details',
					'type'     => 'switch',
					'title'    => esc_html__( 'Author box', 'taskbot' ),
					'default'  => false,
					'desc'     => esc_html__( 'Enable author box on the blog detail page', 'taskbot' ),
				),	
				array(
					'id'       => 'related_article',
					'type'     => 'switch',
					'title'    => esc_html__( 'Related article', 'taskbot' ),
					'default'  => false,
					'desc'     => esc_html__( 'Enable related article on the blog detail page', 'taskbot' ),
				),
			)
		)
	);
}