<?php
/**
 * Default Images Settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings/Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/
Redux::setSection( $opt_name, array(
	'title'            => esc_html__( 'Default images', 'taskbot' ),
	'id'               => 'default_images_settings',
	'subsection'       => false,
	'icon'			   => 'el el-random',
	'fields'           => array(
			array(
				'id'       => 'defaul_buyers_profile',
				'type'     => 'media',
				'title'    => esc_html__('Buyer default profile image', 'taskbot'),
            ),
			array(
				'id'       => 'defaul_sellers_profile',
				'type'     => 'media',
				'title'    => esc_html__('Seller default profile image', 'taskbot'),
            ),
			array(
				'id'       => 'defaul_site_logo',
				'type'     => 'media',
				'title'    => esc_html__('Dashboard logo image', 'taskbot'),
            ),
			array(
				'id'       => 'empty_listing_image',
				'type'     => 'media',
				'title'    => esc_html__('Default listing empty image', 'taskbot'),
            )
		)
	)
);
