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

$taskbot_plan_icon_fields = array(
	array(
		'id'       => 'custom_field_option',
		'type'     => 'switch',
		'title'    => esc_html__( 'Enable/disable custom field for sellers', 'taskbot' ),
		'default'  => false,
		'desc'     => esc_html__( 'Enable/disable custom field for sellers to add while creating a task', 'taskbot' )
	),
	array(
		'id' 		=> 'maxnumber_fields',
		'type' 		=> 'slider',
		'title' 	=> esc_html__('Set number of custom fields', 'taskbot'),
		'desc' 		=> esc_html__('Set max number of fields that seller can add while creating a task', 'taskbot'),
		"default" 	=> 5,
		"min" 		=> 1,
		"step" 		=> 1,
		"max" 		=> 100,
		'display_value' => 'label',
		'required'  => array('custom_field_option', '=', true),
	),
	array(
		'id' 		=> 'task_max_images',
		'type' 		=> 'slider',
		'title' 	=> esc_html__('Set number gallery images', 'taskbot'),
		'desc' 		=> esc_html__('Set max number gallery image for the task', 'taskbot'),
		"default" 	=> 3,
		"min" 		=> 1,
		"step" 		=> 1,
		"max" 		=> 100,
		'display_value' => 'label',
	),
	array(
		'id'       => 'task_downloadable',
		'type'     => 'switch',
		'title'    => esc_html__( 'Enable/disable task for downloadable', 'taskbot' ),
		'default'  => true,
		'desc'     => esc_html__( 'Enable/disable sellser option to add downloadable task', 'taskbot' )
	),
	array(
		'id'       => 'allow_tags',
		'type'     => 'switch',
		'title'    => esc_html__( 'Allow tags', 'taskbot' ),
		'default'  => true,
		'desc'     => esc_html__( 'Allow tags while creating task', 'taskbot' )
	),
    array(
        'id'       => 'task_description_length_option',
        'type'     => 'switch',
        'title'    => esc_html__( 'Enable/disable task description length', 'taskbot' ),
        'default'  => false,
        'desc'     => esc_html__( 'Enable/disable to add minimum and maximum description length while creating a task', 'taskbot' )
    ),
    array(
        'id' => 'task_description_length',
        'type' => 'slider',
        'title' => __('Task description length', 'taskbot'),
        'desc' => __(' Define the minimum and maximum task description word length', 'taskbot'),
        'default' => array(
            1 => 50,
            2 => 500,
        ),
        'min' => 0,
        'step' => 5,
        'max' => 1000,
        'display_value' => 'select',
        'handles' => 2,
        'required'  => array('task_description_length_option', '=', true),
    ),
	array(
		'id'    	=> 'hide_product_cat',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Hide product category', 'taskbot' ),
		'data' 		=> 'terms',
		'args' 		=> array('taxonomies' => array( 'product_cat' ),'hide_empty' => false,),
		'multi'    	=> true,
		'desc'      => esc_html__('Select product for hiding on the search page', 'taskbot'),
	),
	array(
		'id'        => 'task_listing_type',
		'type'      => 'select',
		'title'     => esc_html__('Task listing type', 'taskbot'),
		'desc'      => esc_html__('Enable Task listing type?', 'taskbot'),
		'options'   => array(
			'v1'         => esc_html__('V1', 'taskbot'),
			'v2'         => esc_html__('V2', 'taskbot')
		),
		'default'   => 'v1',
	),

);

$taskbot_service_plans = Taskbot_Service_Plans::service_plans();
foreach($taskbot_service_plans as $plan_key => $plan_feilds){
  $taskbot_plan_icon_fields[] = array(
    'id'       => 'task_plan_icon_'.$plan_key,
    'type'     => 'media',
    'title'    => wp_sprintf( '%s %s', ucfirst($plan_key), esc_html__( ' plan icon', 'taskbot' ) ), 
    'default'  => array( 'url' => TASKBOT_DIRECTORY_URI.'/public/images/task-plan-icon.jpg' ),
  );
}

$taskbot_plan_icon_fields[] = array(
	'id'       => 'hide_deadline',
	'type'     => 'select',
	'title'    => esc_html__('Hide task dealine', 'taskbot'),
	'desc'     => esc_html__('You can hide the task deadline from ongoing order', 'taskbot'),
	'options'  => array(
		'yes' 	=> esc_html__('Yes', 'taskbot'),
		'no' 	=> esc_html__('No', 'taskbot')
	),
	'default'  => 'no',
);

$taskbot_plan_icon_fields[] = array(
	'id'       => 'service_status',
	'type'     => 'select',
	'title'    => esc_html__('Task default status', 'taskbot'),
	'desc'     => esc_html__('Please select default status of task', 'taskbot'),
	'options'  => array(
		'publish' 	=> esc_html__('Publish', 'taskbot'),
		'pending' 	=> esc_html__('Pending', 'taskbot')
	),
	'default'  => 'publish',
);

$taskbot_plan_icon_fields[] = array(
	'id'       => 'remove_price_plans',
	'type'     => 'select',
	'title'    => esc_html__('Show only one package', 'taskbot'),
	'desc'     => esc_html__('Show only one package while posting a service and hide other two packages', 'taskbot'),
	'options'  => array(
		'yes' 	=> esc_html__('Yes, Show only one', 'taskbot'),
		'no' 	=> esc_html__('No, Show 3 packages', 'taskbot')
	),
	'default'  => 'no',
);

$taskbot_plan_icon_fields[] = array(
	'id'    	=> 'resubmit_service_status',
	'type'  	=> 'select',
	'title' 	=> esc_html__( 'Does approved task edit approval require?', 'taskbot' ),
	'options'  => array(
		'yes' 	=> esc_html__('Yes! It should get approved by the admin every time', 'taskbot'),
		'no' 	=> esc_html__('No! Let it approve automatically', 'taskbot')
	),
	'required'  => array('service_status', '=', 'pending'),
	'default'  	=> 'no',
);


Redux::setSection( $opt_name, array(
	'title'            => esc_html__( 'Task settings ', 'taskbot' ),
	'id'               => 'task_settings',
	'desc'       	   => '',
	'subsection'       => true,
	'icon'			   => 'el el-braille',	
	'fields'           => $taskbot_plan_icon_fields
	)
);