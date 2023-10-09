<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://codecanyon.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Taskbot
 *
 * @Taskbot
 * Plugin Name:       Taskbot - Freelance and Jobs Marketplace
 * Plugin URI:        https://codecanyon.net/user/amentotech/portfolio
 * Description:       Taskbot is a Freelancer Marketplace WordPress plugin to post task and projects. This system would allow the sellers and buyers to register and create their profiles in a few simple steps. Sellers can create the task and get online orders for the posted task.
 * Version:           6.0
 * Author:            Amentotech Private Limited
 * Author URI:        https://codecanyon.net/user/amentotech/portfolio/
 * Text Domain:       taskbot
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if( !function_exists( 'taskbot_load_last' ) ) {
	function taskbot_load_last() {
		$taskbot_file_path 		= preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
		$taskbot_plugin 		= plugin_basename(trim($taskbot_file_path));
		$taskbot_active_plugins = get_option('active_plugins');
		$taskbot_plugin_key 	= array_search($taskbot_plugin, $taskbot_active_plugins);
		array_splice($taskbot_active_plugins, $taskbot_plugin_key, 1);
		array_push($taskbot_active_plugins, $taskbot_plugin);
		update_option('active_plugins', $taskbot_active_plugins);
	}
	
	add_action("activated_plugin", "taskbot_load_last");
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TASKBOT_VERSION', '6.0' );
define( 'TASKBOT_DIRECTORY', plugin_dir_path( __FILE__ ));
define( 'TASKBOT_DIRECTORY_URI', plugin_dir_url( __FILE__ ));
define( 'TASKBOT_ACTIVE_THEME_DIRECTORY', get_stylesheet_directory());

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-taskbot-core-activator.php
 */
function taskbot_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-taskbot-core-activator.php';
	Taskbot_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-taskbot-core-deactivator.php
 */
function taskbot_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-taskbot-core-deactivator.php';
	Taskbot_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'taskbot_activate' );
register_deactivation_hook( __FILE__, 'taskbot_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'helpers/register.php';
require plugin_dir_path( __FILE__ ) . 'includes/cron.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-taskbot-core.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-tgm-plugin-activation.php';
require plugin_dir_path( __FILE__ ) . 'public/partials/funtions.php';
require plugin_dir_path( __FILE__ ) . 'public/public-function.php';
require plugin_dir_path( __FILE__ ) . 'public/partials/projects-function.php';
require plugin_dir_path( __FILE__ ) . 'public/partials/projects-hooks.php';
require plugin_dir_path( __FILE__ ) . 'public/partials/proposal-hooks.php';
require taskbot_load_template( 'public/partials/class-header');
require taskbot_load_template( 'public/partials/class-footer');
require taskbot_load_template( 'public/partials/template-loader');

/**
 * The class responsible for task plans
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-taskbot-service-plans.php';

require plugin_dir_path( __FILE__ ) . 'elementor/base.php';
require plugin_dir_path( __FILE__ ) . 'elementor/config.php';
require plugin_dir_path( __FILE__ ) . '/admin/taskbot-notification/init.php';

require plugin_dir_path( __FILE__ ) . '/admin/theme-settings/init.php'; //Theme Settings
require plugin_dir_path( __FILE__ ) . 'import-users/class-readcsv.php';
require plugin_dir_path( __FILE__ ) . 'includes/migration.php';
include taskbot_load_template( 'import-users/class-import-user' );
require plugin_dir_path( __FILE__ ) . 'widgets/class-footer-info.php';
require plugin_dir_path( __FILE__ ) . 'widgets/class-footer-app-info.php';
require plugin_dir_path( __FILE__ ) . 'widgets/class-footer-contact-info.php';
require plugin_dir_path( __FILE__ ) . 'widgets/class-nav-menu-widget.php';
require plugin_dir_path( __FILE__ ) . 'widgets/class-recent-posts.php';
require plugin_dir_path( __FILE__ ) . 'widgets/class-news-letters.php';

include taskbot_load_template( 'libraries/mailchimp/class-mailchimp' );
require plugin_dir_path( __FILE__ ) . 'libraries/mailchimp/class-mailchimp-oath.php';

/**
 * Get template from plugin or theme.
 *
 * @param string $file  Templat`e file name.
 * @param array  $param Params to add to template.
 *
 * @return string
 */
function taskbot_load_template( $file, $param = array() ) {
	extract( $param );

	if ( is_dir( TASKBOT_ACTIVE_THEME_DIRECTORY . '/extend/' ) ) {
		if ( file_exists( TASKBOT_ACTIVE_THEME_DIRECTORY . '/extend/' . $file . '.php' ) ) {
			$template_load = TASKBOT_ACTIVE_THEME_DIRECTORY . '/extend/' . $file . '.php';
		} else {
			$template_load = TASKBOT_DIRECTORY . '/' . $file . '.php';
		}
	} else {
			$template_load = TASKBOT_DIRECTORY . '/' . $file . '.php';
	}

	return $template_load;
}

/**
 * Add http from URL
 */
if (!function_exists('taskbot_add_http_protcol')) {

  function taskbot_add_http_protcol($url) {
	$url    = set_url_scheme($url);
	
	return $url;
  }
}

add_action( 'tgmpa_register', 'taskbot_register_required_plugins' );



/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function taskbot_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$dir = get_template_directory() . '/theme-config/plugins/';
	$protocol = is_ssl() ? 'https' : 'http';
	$app_api  = $protocol.'://amentotech.com/autoupdate/taskbot/';
	$unyson_core    = $protocol.'://amentotech.com/plugins/unyson.zip';

	//the download location for the plugin zip file (can be any internet host)
	$app_plugin = $app_api.'taskbot-api.zip';
	$plugins = array(
		array(
			'name'      => esc_html__('WooCommerce', 'taskbot'),
			'slug'      => 'woocommerce',
			'required'  => true,
		),
		array(
			'name'      => esc_html__('Advanced Custom Fields', 'taskbot'),
			'slug'      => 'advanced-custom-fields',
			'required'  => true,
		),
		array(
			'name'      => esc_html__('Elementor', 'taskbot'),
			'slug'      => 'elementor',
			'required'  => true,
		),
		array(
			'name'      => esc_html__('Redux', 'taskbot'),
			'slug'      => 'redux-framework',
			'required'  => true,
		),
		array(
			'name'      => esc_html__('Contact Form 7', 'taskbot'),
			'slug'      => 'contact-form-7',
			'required'  => false,
		),
		array(
			'name'      => esc_html__('Unyson ( One Click Demo Import )', 'taskbot'),
			'slug'      => 'unyson',
			'source' 	=> $unyson_core,
			'required'  => false,
		),
		array(
            'name' 			=> esc_html__('Taskbot Mobile APP REST API( Optional )', 'taskbot'),
            'slug' 			=> 'taskbot_api',
            'source' 		=> $app_plugin,
            'required' 		=> false,
        ),
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'taskbot',				// Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',						// Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins',	// Menu slug.
		'parent_slug'  => 'edit.php?post_type=sellers',			// Parent menu slug.
		'capability'   => 'manage_options',			// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,						// Show admin notices or not.
		'dismissable'  => true,						// If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',						// If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,					// Automatically activate plugins after installation or not.
		'message'      => '',						// Message to output right before the plugins table.		
		'strings'      => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'taskbot' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'taskbot' ),
			/* translators: %s: plugin name. */
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'taskbot' ),
			/* translators: %s: plugin name. */
			'updating'                        => esc_html__( 'Updating Plugin: %s', 'taskbot' ),
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'taskbot' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). */
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'taskbot'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). */
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'taskbot'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). */
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'taskbot'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). */
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'taskbot'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). */
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'taskbot'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). */
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'taskbot'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'taskbot'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'taskbot'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'taskbot'
			),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'taskbot' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'taskbot' ),
			'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'taskbot' ),
			/* translators: 1: plugin name. */
			'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.', 'taskbot' ),
			/* translators: 1: plugin name. */
			'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'taskbot' ),
			/* translators: 1: dashboard link. */
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s', 'taskbot' ),
			'dismiss'                         => esc_html__( 'Dismiss this notice', 'taskbot' ),
			'notice_cannot_install_activate'  => esc_html__( 'There are one or more required or recommended plugins to install, update or activate.', 'taskbot' ),
			'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'taskbot' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		
	);

	tgmpa( $plugins, $config );
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function taskbot_run() {
	$plugin = new Taskbot();
	$plugin->run();
}
add_action('plugins_loaded', 'taskbot_run');

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
add_action( 'init', 'taskbot_load_textdomain' );
function taskbot_load_textdomain() {
  load_plugin_textdomain( 'taskbot', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}
