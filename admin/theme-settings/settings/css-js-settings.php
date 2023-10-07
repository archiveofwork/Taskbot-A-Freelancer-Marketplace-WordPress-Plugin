<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Custom Scripts Settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings/Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/

Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'CSS/JS scripts', 'taskbot' ),
		'id'         => 'custom_code',
		'desc'       => '',
		'icon' 		 => 'el el-css',
		'subsection'       => false,
		'fields'     => array(
			array(
				'id'       => 'custom_css',
				'type'     => 'ace_editor',
				'title'    => esc_html__('Custom CSS', 'taskbot'),
				'subtitle' => esc_html__('Paste your CSS code here', 'taskbot'),
				'mode'     => 'css',
				'theme'    => 'monokai',
				'desc'     => '',
				'default'  => ""
			),
			array(
				'id'       => 'custom_js',
				'type'     => 'ace_editor',
				'title'    => esc_html__('Custom JS', 'taskbot'),
				'subtitle' => esc_html__('Paste your JS code here', 'taskbot'),
				'mode'     => 'css',
				'theme'    => 'monokai',
				'desc'     => '',
				'default'  => ""
			),
		)
	)
);
