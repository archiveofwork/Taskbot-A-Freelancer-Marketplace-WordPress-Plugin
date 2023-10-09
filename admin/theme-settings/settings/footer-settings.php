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
			'title'            => esc_html__( 'Footer settings', 'taskbot' ),
			'id'               => 'footer_settings',
			'subsection'       => false,
			'icon'			   => 'el el-align-center',
			'fields'           => array(
				array(
					'id'       => 'copyright',
					'type'     => 'textarea',
					'title'    => esc_html__( 'Copyright text', 'taskbot' ),
					'desc'     => esc_html__( '', 'taskbot' ),
					'default'  => 'Copyright © All rights reserved. 2022',
				),
				array(
					'id'       => 'footer_menu',
					'type'     => 'switch',
					'title'    => esc_html__( 'Footer menu', 'taskbot' ),
					'default'  => false,
					'desc'     => esc_html__( 'Enable footer menu, you must create a menu from Appearance > Menus and then assign menu location to show on the front-end.', 'taskbot' ),
				),	
			)
		)
	);
} else if(!empty($theme_version->get( 'TextDomain' )) && ( $theme_version->get( 'TextDomain' ) === 'taskup' || $theme_version->get( 'TextDomain' ) === 'taskup-child' )){
	Redux::setSection( $opt_name, array(
			'title'            => esc_html__( 'Footer settings', 'taskbot' ),
			'id'               => 'footer_settings',
			'subsection'       => false,
			'icon'			   => 'el el-align-center',
			'fields'           => array(
				array(
					'id'       => 'copyright',
					'type'     => 'textarea',
					'title'    => esc_html__( 'Copyright text', 'taskbot' ),
					'desc'     => esc_html__( '', 'taskbot' ),
					'default'  => 'Copyright © All rights reserved. 2022',
				),
                array(
                    'id'        => 'taskup_footer_shape_divider',
                    'type'      => 'switch',
                    'title'     => esc_html__('Footer Shape Divider', 'taskbot'),
                    'default'   => true,
                    'desc'      => esc_html__('Enable/disable footer top shape divider.', 'taskbot')
                ),
			)
		)
	);
}