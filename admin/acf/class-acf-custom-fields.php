<?php
/**
 * 
 * ACF custom input radio for dashboard menu
 * ACF custom image field for FAQ categories
 * ACF custom input field for Delivery time
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/acf
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */
if ( function_exists( 'acf_add_local_field_group' ) ):
	/*
	 * Dashboard menu feild
	 */
	acf_add_local_field_group( array(
		'key' => 'group_taskbot6193725c1ce90',
		'title' => esc_html__( 'Dashboard menu', 'taskbot' ),
		'fields' => array(
			array(
				'key' => 'field_taskbot619372a56a031',
				'label' => esc_html__( 'Show login user details', 'taskbot' ),
				'name' => 'login_user_details',
				'type' => 'radio',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'no' => esc_html__( 'No', 'taskbot' ),
					'yes' => esc_html__( 'Yes', 'taskbot' ),
				),
				'allow_null' => 0,
				'other_choice' => 0,
				'default_value' => 'no',
				'layout' => 'vertical',
				'return_format' => 'value',
				'save_other_choice' => 0,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'nav_menu',
					'operator' => '==',
					'value' => 'all',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
	) );

/*
 * FAQ category image
 */
acf_add_local_field_group( array(
	'key' => 'group_taskbot61973a33d70e2',
	'title' => esc_html__( 'FAQ category fields', 'taskbot' ),
	'fields' => array(
		array(
			'key' => 'field_taskbot61973a5389853',
			'label' => esc_html__( 'Faq Category Image', 'taskbot' ),
			'name' => 'faq_category_image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'faq_categories',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );

/*
 * Delivery time taxonomy field
 */
acf_add_local_field_group( array(
	'key' => 'group_taskbot6178f863a4dd7',
	'title' => esc_html__( 'Delivery time', 'taskbot' ),
	'fields' => array(
		array(
			'key' => 'field_taskbot6178f8829fdfd',
			'label' => esc_html__( 'Days', 'taskbot' ),
			'name' => 'days',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 1,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'delivery_time',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
) );
endif;