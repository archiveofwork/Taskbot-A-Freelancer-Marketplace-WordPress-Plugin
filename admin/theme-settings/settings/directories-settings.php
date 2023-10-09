<?php
/**
 * Directories settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings/Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/
$theme_version 	= wp_get_theme();
$datefomate_list= apply_filters('taskbot_get_list_date_format', '');
$user_types     = apply_filters('taskbot_get_user_types','');
$seller_view    = array(
                        'list' => esc_html__('List','taskbot'),
                        'grid' => esc_html__('Grid','taskbot')
                      );


Redux::setSection( $opt_name, array(
        'title'             => esc_html__( 'Directory settings', 'taskbot' ),
        'id'                => 'directories-settings',
        'desc'       	      => '',
        'icon' 			        => 'el el-search',
        'subsection'        => false,
            'fields'           => array(
                  array(
                    'id'        => 'application_access',
                    'type'      => 'select',
                    'title'     => esc_html__('Application Access', 'taskbot'),
                    'desc'      => esc_html__('Either projects can enabled or task or you can also enable both', 'taskbot'),
                    'options'   => array(
                        'project_based'         => esc_html__('Project based application', 'taskbot'),
                        'task_based'            => esc_html__('Task based application', 'taskbot'),
                        'both'                  => esc_html__('Both Project and task based application', 'taskbot'),
                    ),
                    'default'   => 'both',
                ),
                array(
                  'id'        => 'seller_listing_type',
                  'type'      => 'select',
                  'title'     => esc_html__('Seller listing view', 'taskbot'),
                  'desc'      => esc_html__('Select seller listing view type', 'taskbot'),
                  'options'   => $seller_view,
                  'default'   => 'list',
                ),
                array(
                  'id'        => 'remove_cancel_order',
                  'type'      => 'select',
                  'title'     => esc_html__('Cancel order', 'taskbot'),
                  'desc'      => esc_html__('Remove cancel order options from the ongoing orders page', 'taskbot'),
                  'default'   => 'no',
                  'options'   => array(
                    'yes'  	=> esc_html__('Yes', 'taskbot'),
                    'no'  	=> esc_html__('No', 'taskbot'),
                  ),
                ),
                array(
                    'id'       => 'user_update_option',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'User action', 'taskbot' ),
                    'default'  => false,
                    'desc'     => esc_html__( 'Either user can submit any form without account approval or account verification is required. For example post a task by sellers', 'taskbot' )
                ),
                array(
                    'id'        => 'invoice_terms',
                    'type'      => 'editor',
                    'title'     => esc_html__('Invoice detail page note', 'taskbot'),
                    'default'   => '',
                    'desc'      => esc_html__('Add note for the invoice detail page. ', 'taskbot')
                ),
                
                array(
                    'id'        => 'invoice_billing_to',
                    'type'      => 'switch',
                    'title'     => esc_html__('Invoice billing to', 'taskbot'),
                    'default'   => false,
                    'desc'      => esc_html__('Enable or disable admin billing address on invoice page', 'taskbot'),
                ),
                array(
                    'id'        => 'invoice_billing_address',
                    'type'      => 'textarea',
                    'title'     => esc_html__('Add billing address', 'taskbot'),
                    'desc'      => esc_html__('Add billing address to show on invoice page', 'taskbot'),
                    'required'  => array('invoice_billing_to', '=', true),
                ),
                array(
                  'id'        => 'invoice_billing_wallet',
                  'type'      => 'textarea',
                  'title'     => esc_html__('Add billing address for wallet', 'taskbot'),
                  'desc'      => esc_html__('Add billing address for wallet payments to show on invoice page', 'taskbot')
                ),
                array(
                  'id'        => 'invoice_billing_package',
                  'type'      => 'textarea',
                  'title'     => esc_html__('Add billing address for package', 'taskbot'),
                  'desc'      => esc_html__('Add billing address for package to show on invoice page', 'taskbot')
                ),
                array(
                    'id'        => 'default_image_extensions',
                    'type'      => 'textarea',
                    'title'     => esc_html__('Image file extensions', 'taskbot'),
                    'default'   => 'jpg,jpeg,gif,png',
                    'subtitle'  => esc_html__('Add image file extension by comma seperated text', 'taskbot'),
                ),
                array(
                    'id'        => 'default_file_extensions',
                    'type'      => 'textarea',
                    'title'     => esc_html__('File extensions', 'taskbot'),
                    'default'   => 'pdf,doc,docx,xls,xlsx,ppt,pptx,csv,jpg,jpeg,gif,png,zip,rar,mp4,mp3,3gp,flv,ogg,wmv,avi,stl,obj,iges,js,php,html,txt',
                    'subtitle'  => esc_html__('Add file extension by comma seperated text', 'taskbot'),
                ),
                array(
                  'id'        => 'upload_file_size',
                  'type'      => 'slider',
                  "default" => 5,
                  "min" 		=> 1,
                  "step" 		=> 1,
                  "max" 		=> 500,
                  'title'     => esc_html__('Upload file size', 'taskbot'),
                  'desc'   => esc_html__('Add upload file size, this will be in MB, so write only integer value', 'taskbot'),
               ),
                array(
                    'id'        => 'dateformat',
                    'type'      => 'select',
                    'title'     => esc_html__('Date format', 'taskbot'),
                    'desc'      => esc_html__('Please select date format', 'taskbot'),
                    'options'   => $datefomate_list,
                    'default'   => 'Y-m-d',
                ),
                array(
                    'id'        => 'address_format',
                    'type'      => 'select',
                    'title'     => esc_html__('Profile address format', 'taskbot'),
                    'desc'      => esc_html__('Please select profile address format', 'taskbot'),
                    'options'   => array(
                        'city_country'        => esc_html__('City, Country', 'taskbot'),
                        'state_country'       => esc_html__('State, Country', 'taskbot'),
                        'city_state_country'  => esc_html__('City, State, Country', 'taskbot'),
                    ),
                    'default'   => 'state_country',
                ),
                array(
                    'id'        => 'activity_email',
                    'type'      => 'switch',
                    'title'     => esc_html__('Activity email', 'taskbot'),
                    'default'   => true,
                    'desc'      => esc_html__('Enable/disable activity email', 'taskbot')
                ),
                array(
                  'id'        => 'enable_state',
                  'type'      => 'switch',
                  'title'     => esc_html__('Enable states option', 'taskbot'),
                  'default'   => false,
                  'desc'      => esc_html__('Enable/disable country/states option', 'taskbot')
              ),
                array(
                    'id'        => 'shortname_option',
                    'type'      => 'switch',
                    'title'     => esc_html__('Short name', 'taskbot'),
                    'default'   => false,
                    'desc'      => esc_html__('Enable/disable shortname', 'taskbot')
                ),
                array(
                    'id'        => 'buyer_refund_req_title',
                    'type'      => 'text',
                    'title'     => esc_html__('Refund request title', 'taskbot'),
                    'default'   => esc_html__('Create refund request', 'taskbot'),
                ),
                array(
                    'id'        => 'buyer_refund_req_subheading',
                    'type'      => 'textarea',
                    'title'     => esc_html__('Refund request sub heading', 'taskbot'),
                    'default'   => '<h5>' . esc_html__('Choose issue you want to highlight', 'taskbot') . '</h5>',
                    'subtitle'  => esc_html__('You can add text with HTML tags ', 'taskbot'),
                ),
                array(
                  'id'        => 'buyer_dispute_issues',
                  'type'      => 'multi_text',
                  'title'     => esc_html__('Buyer dispute issues', 'taskbot'),
                  'default'   => array(
                    esc_html__('The seller is not responding', 'taskbot'),
                    esc_html__('The seller sent me an unfinished product', 'taskbot'),
                    esc_html__('Seller is abusive or using unprofessional language', 'taskbot'),
                    esc_html__('Seller not sure with his/her skills set', 'taskbot'),
                    esc_html__('Others', 'taskbot'),
                  ),
                  'desc'      => esc_html__('Add multiple dispute issues', 'taskbot')
                ),
                array(
                  'id'        => 'seller_dispute_issues',
                  'type'      => 'multi_text',
                  'title'     => esc_html__('Seller dispute issues', 'taskbot'),
                  'default'   => array(
                    esc_html__('The buyer is not responding', 'taskbot'),
                    esc_html__("I’m too busy to complete this job", 'taskbot'),
                    esc_html__('Due to personal reasons, I can not complete this job', 'taskbot'),
                    esc_html__('Buyer requesting unplanned additional work', 'taskbot'),
                    esc_html__('Others', 'taskbot'),
                  ),
                  'desc'      => esc_html__('Add multiple dispute issues', 'taskbot')
                ),
                array(
                  'id' 		  => 'buyer_dispute_option',
                  'type' 		=> 'slider',
                  'title' 	=> esc_html__('Set dispute option for buyer', 'taskbot'),
                  'desc' 		=> esc_html__('Set min number of days that buyer can add dispute', 'taskbot'),
                  "default" => 3,
                  "min" 		=> 1,
                  "step" 		=> 1,
                  "max" 		=> 50,
                  'display_value' => 'label',
                ),
                array(
                    'id'        => 'ads_content',
                    'type'      => 'editor',
                    'title'     => esc_html__('Ads content', 'taskbot'),
                    'subtitle'  => esc_html__('Add ads content', 'taskbot'),
                ),
                array(
                    'id'        => 'admin_dashboard_copyright',
                    'type'      => 'textarea',
                    'title'     => esc_html__('Admin dashboard footer text', 'taskbot'),
                    'desc'      => esc_html__('Add admin dashboard footer text', 'taskbot'),
                    'default'   => sprintf(esc_html__('Copyright  &copy;%s, All Right Reserved', 'taskbot'),date('Y'))
                ),
                array(
                    'id'        => 'min_search_price',
                    'type'      => 'text',
                    'title'     => esc_html__('Min search price', 'taskbot'),
                    'default'   => 1,
                ),

                array(
                    'id'        => 'max_search_price',
                    'type'      => 'text',
                    'title'     => esc_html__('Max search price', 'taskbot'),
                    'default'   => 5000,
                ),

              array(
                  'id'        => 'disable_range_slider',
                  'type'      => 'switch',
                  'title'     => esc_html__('Disable range slider', 'taskbot'),
                  'default'   => true,
                  'desc'      => esc_html__('Disable range slider for price filter', 'taskbot')
              ),
              array(
                'id'        => 'hide_search_item',
                'type'      => 'select',
                'title'     => esc_html__('Show search type', 'taskbot'),
                'desc'      => esc_html__('Select search types to show in the different search forms on the site', 'taskbot'),
                'multi'    	=> true,
                'default'   => array('sellers_search_page','service_search_page','project_search_page'),
                'options'   => array(
                  'sellers_search_page'  	=> esc_html__('Sellers', 'taskbot'),
                  'service_search_page'  	=> esc_html__('Services', 'taskbot'),
                  'project_search_page'  	=> esc_html__('Projects', 'taskbot'),
                ),
              ),
        )
	)
);


Redux::setSection( $opt_name, array(
	'title'            => esc_html__( 'Registration settings', 'taskbot' ),
	'id'               => 'registration_settings',
	'desc'       	   => '',
	'subsection'       => true,
	'icon'			   => 'el el-braille',	
	'fields'           =>  array(
        array(
          'id'        => 'defult_register_type',
          'type'      => 'select',
          'title'     => esc_html__('Defult user registration', 'taskbot'),
          'desc'      => esc_html__('Please select new user type for defult registration', 'taskbot'),
          'options'   => $user_types,
          'default'   => 'buyers',
        ),
        array(
          'id'        => 'hide_registration',
          'type'      => 'select',
          'title'     => esc_html__('Remove registration', 'taskbot'),
          'desc'      => esc_html__('You can disable registration from front-end', 'taskbot'),
          'default'   => 'no',
          'options'   => array(
            'no'  => esc_html__('No', 'taskbot'),
            'yes'   => esc_html__('Yes', 'taskbot'),
          ),
        ),
        array(
          'id'        => 'hide_role',
          'type'      => 'select',
          'title'     => esc_html__('Hide role', 'taskbot'),
          'desc'      => esc_html__('Hide one of the role from registration', 'taskbot'),
          'default'   => 'both',
          'options'   => array(
            'both'    => esc_html__('Show both', 'taskbot'),
            'sellers'  => esc_html__('Sellers', 'taskbot'),
            'buyers'   => esc_html__('Buyers', 'taskbot'),
          ),
        ),
        array(
          'id'        => 'registration_view_type',
          'type'      => 'select',
          'title'     => esc_html__('Login and registration type', 'taskbot'),
          'desc'      => esc_html__('Please select login/reigistration type', 'taskbot'),
          'options'   => array(
            'pages'         => esc_html__('Pages', 'taskbot'),
            'popup'         => esc_html__('Popup', 'taskbot'),
          ),
          'default'   => 'pages',
        ),
        array(
            'id'		  => 'popup_logo',
            'type' 		=> 'media',
            'url'		  => true,
            'title' 	=> esc_html__('Add logo for Popup', 'taskbot'),
            'desc' 		=> esc_html__('Upload site logo for popup.', 'taskbot'),
             'required'  => array('registration_view_type', '=', 'popup'),
        ),
        array(
          'id'        => 'email_user_registration',
          'type'      => 'select',
          'title'     => esc_html__('User verification', 'taskbot'),
          'desc'      => esc_html__('Please select new user verification type', 'taskbot'),
          'options'   => array(
            'verify_by_link'        => esc_html__('Verify by auto generated link', 'taskbot'),
            'verify_by_admin'       => esc_html__('Verify by admin', 'taskbot'),
          ),
          'default'   => 'verify_by_link',
        ),
        array(
          'id'        => 'user_name_option',
          'type'      => 'switch',
          'title'     => esc_html__('Enable/disable user name', 'taskbot'),
          'subtitle'  => esc_html__('Enable/disable user name on registration', 'taskbot'),
          'default'   => false,
        ),
        array(
          'id'        => 'identity_verification',
          'type'      => 'switch',
          'title'     => esc_html__('User identity verification', 'taskbot'),
          'default'   => false,
          'desc'      => esc_html__('Enable user identity verification, if enabled then users must have to upload identity documents to get verified', 'taskbot')
        ),

        array(
          'id'        => 'remove_account_reasons',
          'type'      => 'multi_text',
          'title'     => esc_html__('Deactivate account', 'taskbot'),
          'subtitle'  => 'Add deactivate account reasons',
          'default'   => array(
            esc_html__('Not interested anymore', 'taskbot')
          )
        ),
        array(
          'id'        => 'switch_user',
          'type'      => 'switch',
          'title'     => esc_html__('Switch user', 'taskbot'),
          'default'   => true,
          'desc'      => esc_html__('Enable/disable switch user', 'taskbot')
        ),
        array(
            'id'        => 'header_type_after_login',
            'type'      => 'select',
            'title'     => esc_html__('Header type after logged in', 'taskbot'),
            'desc'      => esc_html__('Please select header type for frontend pages when logged in.', 'taskbot'),
            'options'   => array(
                'theme-header'         => esc_html__('Theme Header', 'taskbot'),
                'taskbot-header'         => esc_html__('Taskbot Header', 'taskbot'),
            ),
            'default'   => 'theme-header',
        ),
        array(
          'id'        => 'login_redirect_buyer',
          'type'      => 'select',
          'title'     => esc_html__('Login/registration redirect for buyers', 'taskbot'),
          'desc'      => esc_html__('Select page to redirect the buyer after login/registration', 'taskbot'),
          'default'   => 'profile',
          'options'   => array(
            'home'        => esc_html__('Home page', 'taskbot'),
            'dashboard'   => esc_html__('Dashboard', 'taskbot'),
            'profile'     => esc_html__('Profile settings', 'taskbot'),
            'freelancer'     => esc_html__('Seller search page', 'taskbot'),
            'task'           => esc_html__('Task search page', 'taskbot'),
          ),
        ),
        array(
          'id'        => 'login_redirect_seller',
          'type'      => 'select',
          'title'     => esc_html__('Login/registration redirect for sellers', 'taskbot'),
          'desc'      => esc_html__('Select page to redirect the sellers after login/registration', 'taskbot'),
          'default'   => 'profile',
          'options'   => array(
            'home'        => esc_html__('Home page', 'taskbot'),
            'dashboard'   => esc_html__('Dashboard', 'taskbot'),
            'profile'     => esc_html__('Profile settings', 'taskbot'),
            'projects'    => esc_html__('Seller project page', 'taskbot'),
          ),
        ),
        array(
          'id'        => 'user_restriction',
          'type'      => 'switch',
          'title'     => esc_html__('After logged in restrict user', 'taskbot'),
          'default'   => false,
          'desc'      => esc_html__('Enable/disable user to access front pages after login', 'taskbot')
        ),
        array(
          'id'    	=> 'buyer_access_pages',
          'type'  	=> 'select',
          'title' 	=> esc_html__( 'Buyer restrict pages', 'taskbot' ),
          'data'  	=> 'pages',
          'multi'    => true,
          'desc'      => esc_html__('Select restrict pages for buyer after logged in', 'taskbot'),
          'required'  => array('user_restriction', '=', true),
        ),
        array(
          'id'    	=> 'seller_access_pages',
          'type'  	=> 'select',
          'title' 	=> esc_html__( 'Seller restrict pages', 'taskbot' ),
          'data'  	=> 'pages',
          'multi'    => true,
          'desc'      => esc_html__('Select restrict pages for seller after logged in', 'taskbot'),
          'required'  => array('user_restriction', '=', true),
        ),
      )
	)
);

$required_fields		= taskbotProjectValidations();
$recomended_freelancers	= taskbot_project_recomended_freelancers();
$project_plan_icon_fields = array(
	array(
		'id'        => 'fixed_projectmin_price',
		'type'      => 'text',
		'title'     => esc_html__('Fixed project min amount', 'taskbot'),
		'default'   => 5,
		'desc'      => esc_html__('Add minimum amount for fixed project', 'taskbot'),
	),
	array(
		'id'        => 'no_of_freelancers',
		'type'      => 'text',
		'title'     => esc_html__('Add maximum number of freelancers', 'taskbot'),
		'default'   => 5,
		'desc'      => esc_html__('Add Maximum number of freelancers that buyers add for project creation dropdown', 'taskbot'),
	),
	array(
		'id'       => 'project_status',
		'type'     => 'select',
		'title'    => esc_html__('Project default status', 'taskbot'),
		'desc'     => esc_html__('Please select the default status of the project', 'taskbot'),
		'options'  => array(
			'publish' 	=> esc_html__('Publish', 'taskbot'),
			'pending' 	=> esc_html__('Pending', 'taskbot')
		),
		'default'  => 'publish',
	),
    array(
        'id'    	=> 'project_edit_after_submit',
        'type'  	=> 'switch',
        'title' 	=> esc_html__( 'Edit submit project', 'taskbot' ),
        'desc' 	=> esc_html__( 'Enable/Disable to edit submitted project before approval.', 'taskbot' ),
        'required'  => array('project_status', '=', 'pending'),
        'default'  	=> true,
    ),
  array(
		'id'       => 'hide_fixed_milestone',
		'type'     => 'select',
		'title'    => esc_html__('Fixed project options', 'taskbot'),
		'desc'     => esc_html__('Hide fixed project options for seller if buyer has requested the miestone base project', 'taskbot'),
		'options'  => array(
			'yes' 	=> esc_html__('Yes, Hide it', 'taskbot'),
			'no' 	  => esc_html__('No, Show both options to sellers', 'taskbot')
		),
		'default'  => 'no',
	),
  array(
		'id'       => 'project_multilevel_cat',
		'type'     => 'select',
		'title'    => esc_html__('Enable sub-categories', 'taskbot'),
		'options'  => array(
			'enable' 	    => esc_html__('Enable', 'taskbot'),
			'disbale' 	  => esc_html__('Disable', 'taskbot')
		),
		'default'  => 'disbale',
	),
	array(
		'id'    	=> 'resubmit_project_status',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Does approved task edit approval require?', 'taskbot' ),
		'options'  => array(
			'yes' 	=> esc_html__('Yes! It should get approved by the admin every time', 'taskbot'),
			'no' 	=> esc_html__('No! Let it approve automatically', 'taskbot')
		),
		'required'  => array('project_status', '=', 'pending'),
		'default'  	=> 'no',
	),
	array(
		'id'       	=> 'project_recomended_freelancers',
		'type'  	=> 'select',
		'title'    	=> esc_html__('Project recommended freelancers option','taskbot'), 
		'desc'      => esc_html__('Select fields for project recommended freelancers','taskbot'), 
		'options'	=> $recomended_freelancers,
		'multi'    	=> true,
		'default'  	=> array(),
	),
	array(
		'id'        => 'buyer_project_dispute_issues',
		'type'      => 'multi_text',
		'title'     => esc_html__('Buyer dispute issues', 'taskbot'),
		'default'   => array(
		  esc_html__('The seller is not responding', 'taskbot'),
		  esc_html__('The seller sent me an unfinished product', 'taskbot'),
		  esc_html__('Seller is abusive or using unprofessional language', 'taskbot'),
		  esc_html__('Seller not sure with his/her skills set', 'taskbot'),
		  esc_html__('Others', 'taskbot'),
		),
		'desc'      => esc_html__('Add multiple dispute issues', 'taskbot')
	  ),
	  array(
		'id'        => 'seller_project_dispute_issues',
		'type'      => 'multi_text',
		'title'     => esc_html__('Seller dispute issues', 'taskbot'),
		'default'   => array(
		  esc_html__('The buyer is not responding', 'taskbot'),
		  esc_html__("I’m too busy to complete this job", 'taskbot'),
		  esc_html__('Due to personal reasons, I can not complete this job', 'taskbot'),
		  esc_html__('Buyer requesting unplanned additional work', 'taskbot'),
		  esc_html__('Others', 'taskbot'),
		),
		'desc'      => esc_html__('Add multiple dispute issues', 'taskbot')
	  ),
    array(
      'id'       => 'remove_languages',
      'type'     => 'select',
      'title'    => esc_html__('Remove languages', 'taskbot'),
      'desc'     => esc_html__('Remove languages from project posting', 'taskbot'),
      'options'  => array(
        'yes' 	=> esc_html__('Yes, Hide it', 'taskbot'),
        'no' 	  => esc_html__('No, show languages options', 'taskbot')
      ),
      'default'  => 'no',
    ),
);

if( !empty($required_fields) ){
	foreach($required_fields as $key => $fields){
		$default_key	= !empty($fields['default']) ? $fields['default'] : array();
		$project_title	= !empty($fields['title']) ? $fields['title'] : "";
		$project_des	= !empty($fields['details']) ? $fields['details'] : "";
		$fields			= !empty($fields['fields']) ? $fields['fields'] : array();
		$project_plan_icon_fields[] = array(
			'id'       	=> 'project_val_step'.$key,
			'type'  	=> 'select',
			'title'    	=> $project_title, 
			'desc'      => $project_des,
			'options'	=> $fields,
			'multi'    	=> true,
			'default'  	=> $default_key,
		  );
	}
}

$project_plan_icon_fields[] = array(
    'id'    	=> 'enable_milestone_feature',
		'type'  	=> 'select',
		'title' 	=> esc_html__( 'Does approved task edit approval require?', 'taskbot' ),
		'options'   => array(
			'yes' 	  => esc_html__('Yes, Display milestone management in the project', 'taskbot'),
			'no' 	    => esc_html__('No, Hide this', 'taskbot')
		),
		'default'  	=> 'yes',
);

$project_plan_icon_fields[] = array(
  'id'       => 'hide_related',
  'type'     => 'select',
  'title'    => esc_html__('Hide related projects', 'taskbot'),
  'desc'     => esc_html__('Hide related projects, default is No', 'taskbot'),
  'options'  => array(
    'no' 	      => esc_html__('No', 'taskbot'),
    'yes' 	    => esc_html__('Yes', 'taskbot')
  ),
  'default'  => 'no',
);

$project_plan_icon_fields[] = array(
  'id'       => 'allow_hour_times',
  'type'     => 'select',
  'title'    => esc_html__('Allow to add previous days hours', 'taskbot'),
  'desc'     => esc_html__('Allow the sellers to add the past/future days hours in the time card. This options will only work when the hourly extension is installed and activated', 'taskbot'),
  'options'  => array(
    'past' 	    => esc_html__('Allow only past hours', 'taskbot'),
    'both' 	    => esc_html__('Allow past and future hours', 'taskbot'),
    'no' 	      => esc_html__('Don\'t allow to add hours', 'taskbot'),
  ),
  'default'  => 'past',
);

Redux::setSection( $opt_name, array(
	'title'            => esc_html__( 'Project settings ', 'taskbot' ),
	'id'               => 'project_settings',
	'desc'       	   => '',
	'subsection'       => true,
	'icon'			   => 'el el-braille',	
	'fields'           => $project_plan_icon_fields
	)
);


$proposal_settings = array(
	array(
		'id'       => 'proposal_status',
		'type'     => 'select',
		'title'    => esc_html__('Proposal default status', 'taskbot'),
		'desc'     => esc_html__('Please select default status of task', 'taskbot'),
		'options'  => array(
			'publish' 	=> esc_html__('Auto approved', 'taskbot')
		),
		'default'  => 'publish',
	),
  array(
		'id'       => 'milestone_option',
		'type'     => 'select',
		'title'    => esc_html__('Milestone proposal amount', 'taskbot'),
		'options'  => array(
			'allow' 	  => esc_html__('Allow the seller to send less amount while submitting proposal', 'taskbot'),
      'restrict' 	=> esc_html__('Restrict the seller to create milestones within proposed price', 'taskbot')
		),
		'default'  => 'allow',
	),
  array(
    'id' 		  => 'credits_required',
    'type' 		=> 'slider',
    'title' 	=> esc_html__('Number of credit', 'taskbot'),
    'desc' 		=> esc_html__('Set number of credits to apply on the project', 'taskbot'),
    "default" => 5,
    "min" 		=> 1,
    "step" 		=> 1,
    "max" 		=> 50
  )
);
Redux::setSection( $opt_name, array(
	'title'            => esc_html__( 'Proposal settings ', 'taskbot' ),
	'id'               => 'proposal_settings',
	'desc'       	   => '',
	'subsection'       => true,
	'icon'			   => 'el el-braille',	
	'fields'           => $proposal_settings
	)
);