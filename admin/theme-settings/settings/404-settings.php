<?php
/**
 * Footer Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
$theme_version 		= wp_get_theme();
if(!empty($theme_version->get( 'TextDomain' )) && ( $theme_version->get( 'TextDomain' ) === 'taskup' || $theme_version->get( 'TextDomain' ) === 'taskup-child' )){
	Redux::setSection( $opt_name, array(
			'title'            => esc_html__( '404 page settings', 'taskbot' ),
			'id'               => 'page404_settings',
			'subsection'       => false,
			'icon'			   => 'el el-align-center',
			'fields'           => array(
				array(
					'id'        => 'title_404',
					'type'      => 'text',
					'title'     => esc_html__('404 page title', 'taskbot'),
				),
				array(
					'id'        => 'subtitle_404',
					'type'      => 'text',
					'title'     => esc_html__('404 page sub title', 'taskbot'),
				),
				array(
					'id'       => 'description_404',
					'type'     => 'textarea',
					'title'    => esc_html__('404 page description', 'taskbot' ),
					'default'  => '',
				),
				array(
					'id'		=> 'image_404',
					'type' 		=> 'media',
					'url'		=> true,
					'title' 	=> esc_html__('404 image', 'taskbot'),
					'desc' 		=> esc_html__('Upload site 404 page image, leave it empty to hide', 'taskbot'),
				),
			)
		)
	);
}