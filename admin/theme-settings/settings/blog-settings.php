<?php
/**
 * Footer Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
$theme_version 		= wp_get_theme();

if(!empty($theme_version->get( 'TextDomain' )) && ( $theme_version->get( 'TextDomain' ) === 'taskon' || $theme_version->get( 'TextDomain' ) === 'taskon-child' )){
	Redux::setSection( $opt_name, array(
			'title'            => esc_html__( 'Blog settings', 'taskbot' ),
			'id'               => 'blog_settings',
			'subsection'       => false,
			'icon'			   => 'el el-align-center',
			'fields'           => array(
				array(
					'id'       => 'author_details',
					'type'     => 'switch',
					'title'    => esc_html__( 'Author box', 'taskbot' ),
					'default'  => false,
					'desc'     => esc_html__( 'Enable author box on the blog detail page', 'taskbot' ),
				),	
			)
		)
	);
}