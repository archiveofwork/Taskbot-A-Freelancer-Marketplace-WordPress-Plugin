<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Task settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings/Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/

$taskbot_sellers = array(
	array(
		'id'        => 'hide_english_level',
		'type'      => 'select',
		'title'     => esc_html__('Hide english level', 'taskbot'),
		'desc'      => esc_html__('Hide english level from seller settings and profile detail page', 'taskbot'),
		'options'   => array(
			'yes'         => esc_html__('Yes', 'taskbot'),
			'no'         => esc_html__('No', 'taskbot')
		),
		'default'   => 'no',
	),
	array(
		'id'        => 'hide_skills',
		'type'      => 'select',
		'title'     => esc_html__('Hide skills', 'taskbot'),
		'desc'      => esc_html__('Hide skills from seller settings and profile detail page', 'taskbot'),
		'options'   => array(
			'yes'         => esc_html__('Yes', 'taskbot'),
			'no'         => esc_html__('No', 'taskbot')
		),
		'default'   => 'no',
	),
	array(
		'id'        => 'hide_languages',
		'type'      => 'select',
		'title'     => esc_html__('Hide languages', 'taskbot'),
		'desc'      => esc_html__('Hide languages from seller settings and profile detail page', 'taskbot'),
		'options'   => array(
			'yes'         => esc_html__('Yes', 'taskbot'),
			'no'         => esc_html__('No', 'taskbot')
		),
		'default'   => 'no',
	),
);


Redux::setSection( $opt_name, array(
	'title'            => esc_html__( 'Seller settings ', 'taskbot' ),
	'id'               => 'seller_settings',
	'desc'       	   => '',
	'subsection'       => false,
	'icon'			   => 'el el-braille',	
	'fields'           => $taskbot_sellers
	)
);