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
				array (
					'id'       	=> 'layout_sidebar',
					'type'     	=> 'select',
					'title'    	=> __('Select sidebar', 'taskbot'), 
					'subtitle' 	=> __('Select sidebar for blog page template', 'taskbot'),
					'data'  	=> 'sidebars',
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