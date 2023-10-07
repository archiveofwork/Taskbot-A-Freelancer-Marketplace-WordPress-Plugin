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
Redux::setSection( $opt_name,
  array(
    'title'       => esc_html__( 'Api settings', 'taskbot' ),
    'id'          => 'api-settings',
    'subsection'  => false,
    'desc'       	=> '',
    'icon'       	=> 'el el-key',
    'fields'      => array(
      array(
        'id'    =>'divider_1',
        'type'  => 'info',
        'title' => esc_html__('Google API Key', 'taskbot'),
        'style' => 'info',
      ),
      array(
        'id'        => 'enable_zipcode',
        'type'      => 'switch',
        'title'     => esc_html__('Zipcode settings', 'taskbot'),
        'desc'      => esc_html__('You can enable the zipcode settings and it will verify zipcode from Google Geocoding API and then user will be able to submit the task or profile settings etc. To disable, please make it off', 'taskbot'),
        'default'   => true,
      ),
      array(
        'id'       => 'google_map',
        'type'     => 'text',
        'title'    => esc_html__( 'Google Map Key', 'taskbot' ),
        'desc' 	   => wp_kses( __( 'Enter google map key here. It will be used for google maps. Get and Api key From <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank"> Get API KEY </a>', 'taskbot' ), array(
          'a' => array(
            'href' => array(),
            'class' => array(),
            'title' => array()
            ),
          'br' => array(),
          'em' => array(),
          'strong' => array(),
        ) ),
        'default'  => '',
        'required'  => array('enable_zipcode', '=', true),
      ),
      array(
        'id'        => 'enable_social_connect',
        'type'      => 'switch',
        'title'     => esc_html__('Google connect?', 'taskbot'),
        'subtitle'  => esc_html__('When enable user will able to login and register by using google account', 'taskbot'),
        'default'   => true,
      ),
      array(
        'id'    => 'google_client_id',
        'type'  => 'text',
        'title' => esc_html__( 'Client ID', 'taskbot' ),
        'required'  => array('enable_social_connect', '=', true),
      ),
      array(
        'id'    => 'google_client_secret',
        'type'  => 'text',
        'title' => esc_html__( 'Client secret', 'taskbot' ),
        'required'  => array('enable_social_connect', '=', true),
      ),
    )
  )
);