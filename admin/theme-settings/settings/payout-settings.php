<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Api Settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings/Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/

Redux::setSection( $opt_name, array(
	'title'            => esc_html__( 'Payment settings ', 'taskbot' ),
	'id'               => 'payout_settings',
	'desc'       	   => '',
	'subsection'       => false,
	'icon'			   => 'el el-braille',	
	'fields'           => array(
			array(
				'id'      => 'seller_commision',
				'type'    => 'info',
				'title'   => esc_html__( 'Commission from sellers', 'taskbot' ),
				'style'   => 'info',
			),	
			array(
				'id' 		=> 'admin_commision',
				'type' 		=> 'slider',
				'title' 	=> esc_html__('Admin commission from sellers', 'taskbot'),
				'desc' 		=> esc_html__('Set task/project commission/fee in percentage ( % ), set it to 0 to make commission free website', 'taskbot'),
				"default" 	=> 0,
				"min" 		=> 0,
				"step" 		=> 1,
				"max" 		=> 100,
				'display_value' => 'label',
			),
			array(
				'id'      => 'buyer_commision',
				'type'    => 'info',
				'title'   => esc_html__( 'Commission from buyers', 'taskbot' ),
				'style'   => 'info',
			),
			array(
				'id' 		=> 'admin_commision_buyers',
				'type' 		=> 'slider',
				'title' 	=> esc_html__('Admin commission from buyers', 'taskbot'),
				'desc' 		=> esc_html__('Set task/project hiring commission/fee in percentage ( % ), set it to 0 to make commission free website', 'taskbot'),
				"default" 	=> 0,
				"min" 		=> 0,
				"step" 		=> 1,
				"max" 		=> 100,
				'display_value' => 'label',
			),
			array(
				'id'       => 'commission_text',
				'type'     => 'text',
				'title'    => esc_html__('Add text', 'taskbot'), 
				'desc'     => esc_html__('Add commission text, default is: Processing fee', 'taskbot'),
				'default'  => esc_html__('Processing fee', 'taskbot'),
			),	
			array(
				'id'      => 'general_payment_settings',
				'type'    => 'info',
				'title'   => esc_html__( 'General settings', 'taskbot' ),
				'style'   => 'info',
			),
			array(
				'id'       => 'min_amount',
				'type'     => 'text',
				'title'    => esc_html__('Add minimum amount', 'taskbot'), 
				'desc'     => esc_html__('Add minimum amount which can be withdraw.', 'taskbot'),
				'default'  => '',
			),
			
			array(
                'id'        => 'min_wallet_amount',
                'type'      => 'text',
                'title'     => esc_html__('Buyer min wallet amount', 'taskbot'),
                'default'   => 1,
                'desc'      => esc_html__('Add minimum amount to add wallet', 'taskbot'),
            ),
			

			array(
				'id'       => 'payout_item_hide',
				'type'     => 'select',
				'multi'    => true,
				'title'    => esc_html__('Select payout method to hide.', 'taskbot'), 
				'options'  => array(
					'paypal'		=> esc_html__('PayPal','taskbot'),
					'bank'			=> esc_html__('Bank transfer','taskbot'),
					'payoneer'		=> esc_html__('Payoneer','taskbot'),
				),
			),
		)
	)
);


Redux::setSection( $opt_name, array(
	'title'			=> esc_html__( 'Packages', 'taskbot' ),
	'id'			=> 'package_setings',
	'icon'			=> 'el el-braille',
	'subsection'	=> true,
	'fields'		=>  array(
		array(
			'id'       => 'package_option',
			'type'     => 'select',
			'title'    => esc_html__('Packages?', 'taskbot'),
			'desc'     => esc_html__('You can enable or disable packages for the both type of users', 'taskbot'),
			'options'  => array(
				'both' 			=> esc_html__('Free listing for both type of users', 'taskbot'),
				'paid' 			=> esc_html__('Paid listing for both', 'taskbot'),
				'buyer_free' 	=> esc_html__('Paid listing for sellers', 'taskbot'),
				'seller_free' 	=> esc_html__('Paid listing for buyers', 'taskbot')
			),
			'default'  => 'both'
		),
		array(
			'id'       => 'pkg_page_title',
			'type'     => 'text',
			'title'    => esc_html__('Add price plan title', 'taskbot'), 
			'desc'     => esc_html__('Add price plan title', 'taskbot'),
			'default'  => 'We Genuinely Offer',
		),
		array(
			'id'       => 'pkg_page_sub_title',
			'type'     => 'text',
			'title'    => esc_html__('Add price plan sub title', 'taskbot'), 
			'desc'     => esc_html__('Add price plan sub title', 'taskbot'),
			'default'  => 'Affordable price plans',
		),
		array(
			'id'       => 'pkg_page_details',
			'type'     => 'editor',
			'title'    => esc_html__('Add price plan description', 'taskbot'), 
			'desc'     => esc_html__('Add price plan description', 'taskbot'),
			'default'  => '',
		),
	)
));