<?php
/**
 *
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package     Taskbot
 * @subpackage  Taskbot/public
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
class Taskbot_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $taskbot    The ID of this plugin.
     */
    private $taskbot;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $taskbot       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $taskbot, $version ) {

        $this->taskbot = $taskbot;
        $this->version = $version;

        /**
         * The class responsible for ajax common functions
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/ajax-hooks.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/woo-hooks.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/hooks.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/class-dashboard-menu.php';
        add_action( 'elementor/widget/render_content', array($this, 'taskbot_before_render_elementor_enqueue'), 10, 2);

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        $protocol = is_ssl() ? 'https' : 'http';
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Taskbot_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Taskbot_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        if( !is_page_template( 'templates/admin-dashboard.php') ) {
			wp_register_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
            wp_register_style( 'fontawesome', plugin_dir_url( __FILE__ ) . 'css/fontawesome/all.min.css', array(), $this->version, 'all' );
            wp_register_style( 'feather-icons', plugin_dir_url( __FILE__ ) . 'css/feather-icons.css', array(), $this->version, 'all' );
            wp_register_style( 'owl.carousel', plugin_dir_url( __FILE__ ) . 'css/owl.carousel.min.css', array(), $this->version, 'all' );
            wp_register_style( 'jquery-general', plugin_dir_url( __FILE__ ) . 'css/jquery-general.css', array(), $this->version, 'all' );
            wp_register_style( 'venobox', plugin_dir_url( __FILE__ ) . 'css/venobox.min.css', array(), $this->version, 'all' );
            wp_register_style( 'datetimepicker', plugin_dir_url( __FILE__ ) . 'css/datetimepicker.css', array(), $this->version, 'all' );
            wp_register_style( 'mCustomScrollbar', plugin_dir_url( __FILE__ ) . 'css/jquery.mCustomScrollbar.min.css', array(), $this->version, 'all' );
            wp_register_style( 'tagify', plugin_dir_url( __FILE__ ) . 'css/tagify.css', array(), $this->version, 'all' );
            wp_register_style( 'jquery-confirm', plugin_dir_url( __FILE__ ) . 'css/jquery-confirm.min.css', array(), $this->version, 'all' );
            wp_register_style('splide', plugin_dir_url( __FILE__ ) . 'css/splide.min.css', array(), $this->version, 'all' );
            wp_register_style('swiper', plugin_dir_url( __FILE__ ) . 'css/swiper-bundle.min.css', array(), $this->version, 'all' );
            wp_register_style('croppie-style', plugin_dir_url( __FILE__ ) . 'css/croppie.min.css', array(), $this->version, 'all' );
            wp_register_style( 'taskbot-styles', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), $this->version, 'all' );
            wp_register_style( 'taskbot-rtl-styles', plugin_dir_url( __FILE__ ) . 'css/rtl.css', array(), $this->version, 'all' );


            //Default theme font famlies
            $font_families	= array();
            $font_families[] = 'Urbanist:400,500,600,700,900';
            $font_families[] = 'Playfair+Display:700';
            $font_families[] = 'Open+Sans:400,600,700';
            
            $query_args = array (
                'family' => implode('%7C' , $font_families) ,
                'subset' => 'latin,latin-ext' ,
            );

            $theme_fonts = add_query_arg($query_args , $protocol.'://fonts.googleapis.com/css');

		    wp_enqueue_style('taskbot-fonts-enqueue' , esc_url_raw($theme_fonts), array () , null);

            wp_enqueue_style( 'bootstrap' );
            wp_enqueue_style( 'fontawesome' );
            wp_enqueue_style( 'feather-icons' );
            wp_enqueue_style( 'jquery-general' );
            wp_enqueue_style( 'mCustomScrollbar' );
            wp_enqueue_style( 'jquery-confirm' );

        }
    }



    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        global $taskbot_settings,$taskbot_notification;
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Taskbot_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Taskbot_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        $pusher_notification	    = !empty($taskbot_notification['pusher_notification']) ? $taskbot_notification['pusher_notification'] : '';
        $task_listing_type          = !empty($taskbot_settings['task_listing_type']) ? $taskbot_settings['task_listing_type'] : 'v1';
        $view_type                  = !empty($taskbot_settings['registration_view_type']) ? $taskbot_settings['registration_view_type'] : 'pages';
        if( !is_page_template( 'templates/admin-dashboard.php') ) {
            wp_enqueue_script('jquery-ui-slider');
            wp_enqueue_script( 'underscore' ); 
            wp_register_script( 'jquery-validate', plugin_dir_url( __FILE__ ) . 'js/jquery.validate.min.js', array('jquery'), $this->version, true);
            wp_register_script( 'jquery.ui.touch-punch', plugin_dir_url( __FILE__ ) . 'js/vendor/jquery.ui.touch-punch.js', array( 'jquery' ), $this->version, true );
            wp_register_script( 'bootstrap', plugin_dir_url( __FILE__ ) . 'js/vendor/bootstrap.min.js', array( 'jquery' ), $this->version, true );
            wp_register_script( 'readmore', plugin_dir_url( __FILE__ ) . 'js/vendor/readmore.js', array( 'jquery' ), $this->version, true );
            wp_register_script( 'jquery-confirm', plugin_dir_url( __FILE__ ) . 'js/jquery-confirm.min.js', array(), $this->version, true );
            wp_register_script( 'swiper', plugin_dir_url( __FILE__ ) . 'js/vendor/swiper-bundle.min.js', array('jquery'), $this->version, true );
            wp_register_script( 'popper', plugin_dir_url( __FILE__ ) . 'js/vendor/popper-core.js', array( 'jquery' ), $this->version, true );
		    wp_register_script( 'tippy', plugin_dir_url( __FILE__ ) . 'js/vendor/tippy.js', array( 'jquery' ), $this->version, true );
            wp_register_script('owl.carousel', plugin_dir_url( __FILE__ ) . 'js/vendor/owl.carousel.min.js', array(), $this->version, true);
            wp_register_script('mCustomScrollbar', plugin_dir_url( __FILE__ ) . 'js/vendor/jquery.mCustomScrollbar.concat.min.js', array(), $this->version, true);
            wp_register_script('sortable', plugin_dir_url( __FILE__ ) . 'js/vendor/sortable.min.js', array(), $this->version, true);
            wp_register_script('tagify', plugin_dir_url( __FILE__ ) . 'js/vendor/tagify.min.js', array(), $this->version, true);           
            wp_register_script('jquery.downCount', plugin_dir_url( __FILE__ ) .  '/js/vendor/jquery.downCount.js', array(), $this->version, true);
            wp_register_script('venobox', plugin_dir_url( __FILE__ ) .  '/js/venobox.min.js', array(), $this->version, true);
            wp_register_script('datetimepicker', plugin_dir_url( __FILE__ ) .  '/js/datetimepicker.js', array(), $this->version, true);
            wp_register_script('splide', plugin_dir_url( __FILE__ ) .  'js/splide.min.js', array(), $this->version, true);
            wp_register_script( $this->taskbot, plugin_dir_url( __FILE__ ) . 'js/taskbot-public.js', array('wp-util'), $this->version, true );
            wp_register_script( $this->taskbot.'-dashboard', plugin_dir_url( __FILE__ ) . 'js/taskbot_dashboard.js', array('jquery', 'wp-util'), $this->version, true );
            wp_register_script('croppie-js', plugin_dir_url( __FILE__ ) . 'js/croppie.min.js', array('jquery', 'wp-util'), $this->version, true);
            wp_register_script( 'chart', plugin_dir_url( __FILE__ ) . 'js/vendor/chart.min.js', array(), $this->version, true );
            wp_register_script( 'utils-chart', plugin_dir_url( __FILE__ ) . 'js/utils.js', array(), $this->version, true );
            wp_register_script( 'linkify', plugin_dir_url( __FILE__ ) . 'js/vendor/linkify.min.js', array(), $this->version, true );
			wp_register_script( 'linkify-jquery', plugin_dir_url( __FILE__ ) . 'js/vendor/linkify-jquery.min.js', array(), $this->version, true );
            
            wp_register_script('google-signin-api-js', plugin_dir_url( __FILE__ ) . 'js/google-client.js', array('jquery'), $this->version, true);
            wp_register_script( 'google-signin-gconnect-js', plugin_dir_url( __FILE__ ) . 'js/gconnect.js', array('jquery'), $this->version, true );

            wp_register_script('pusher', plugin_dir_url( __FILE__ ) . 'js/pusher.min.js', array('jquery'),$this->version, true);
            wp_register_script('pusher-notify', plugin_dir_url( __FILE__ ) . 'js/pusher-notify.js', array( 'jquery' ), $this->version, true);

            wp_enqueue_script('bootstrap');
            wp_enqueue_script('jquery.ui.touch-punch');
            wp_enqueue_script('readmore');
            wp_enqueue_script('popper');
            wp_enqueue_script('tippy');
            wp_enqueue_script('jquery-confirm');
            wp_enqueue_script('mCustomScrollbar');           

            if( is_page_template( 'templates/dashboard.php') || is_page_template( 'templates/add-task.php') || is_page_template( 'templates/add-project.php') || is_page_template( 'templates/search-task.php') || is_page_template( 'templates/search-projects.php') ) {
                wp_enqueue_script('plupload');
                wp_enqueue_style( 'select2' );
                wp_enqueue_script('select2');
                wp_enqueue_script( 'linkify' );
                wp_enqueue_script( 'linkify-jquery' );

                if( is_page_template( 'templates/add-task.php')) {
                    wp_enqueue_script('jquery-validate');
                    wp_enqueue_script('sortable');
                    wp_enqueue_style( 'tagify' );
                    wp_enqueue_script('tagify');
                    wp_enqueue_style('venobox');
                    wp_enqueue_script('venobox');
                }

                if( is_page_template( 'templates/dashboard.php')){
                    wp_enqueue_script('jquery.downCount');
                    wp_enqueue_style( 'datetimepicker' );
                    wp_enqueue_script('datetimepicker');
                    wp_enqueue_style('croppie-style');
                    wp_enqueue_script('croppie-js');
                }
                
                wp_enqueue_script($this->taskbot.'-dashboard');
            }
            
            //If POP Enabled
            if(!is_user_logged_in() && !empty($view_type) && $view_type  === 'popup'){
                wp_enqueue_script('google-signin-api-js');
                wp_enqueue_script('google-signin-gconnect-js');
            }

            if( is_page_template( 'templates/submit-proposal.php') || is_page_template( 'templates/dashboard.php') ){
                wp_enqueue_script('sortable');
            }
            if(is_page_template( 'templates/search-task.php') || is_page_template( 'templates/search-freelancer.php')){
                wp_enqueue_style( 'select2' );
                wp_enqueue_script('select2');
            }

            if(is_page_template( 'templates/search-task.php')){   
                if( !empty($task_listing_type) && $task_listing_type === 'v1' ){          
                    wp_enqueue_style('owl.carousel');
                    wp_enqueue_script('owl.carousel');
                }
                wp_enqueue_style('venobox');
                wp_enqueue_script('venobox');
            }

            if(is_singular( 'product' )){
                wp_enqueue_style('splide');
                wp_enqueue_script('splide');
                wp_enqueue_style('venobox');
                wp_enqueue_script('venobox');
            }         

            if( !empty($pusher_notification) && current_user_can( 'subscriber' ) ){
                wp_enqueue_script('pusher');
                wp_enqueue_script('pusher-notify');
            }

            $upload_file_size	    = !empty($taskbot_settings['upload_file_size']) ? $taskbot_settings['upload_file_size'].'mb' : '50mb';
            $date_format	    = !empty($taskbot_settings['dateformat']) ? $taskbot_settings['dateformat'] : 'Y-m-d';
            $tpl_dashboard	    = !empty($taskbot_settings['tpl_dashboard']) ? $taskbot_settings['tpl_dashboard'] : '';
            $gclient_id         = '';
            if (!empty($taskbot_settings['enable_social_connect']) && $taskbot_settings['enable_social_connect'] == '1'){
                $gclient_id    = !empty($taskbot_settings['google_client_id']) ? $taskbot_settings['google_client_id'] : '';
            }

            $user_type          = '';
            $current_user_key   = '';
            $cluster            = !empty($taskbot_notification['pusher_app_cluster']) ? $taskbot_notification['pusher_app_cluster'] : '';
            $pusher_app_key     = !empty($taskbot_notification['pusher_app_key']) ? $taskbot_notification['pusher_app_key'] : '';
            $maxnumber_fields   =  !empty($taskbot_settings['maxnumber_fields']) ? $taskbot_settings['maxnumber_fields'] : 5;

            $tpl_dashboard      = !empty($tpl_dashboard) ? get_the_permalink( $tpl_dashboard ) : '';
            $user_id            = get_current_user_id();
            $wallet_amount      = 0;
            if( is_user_logged_in(  ) ){
                $user_type       = taskbot_get_user_type($user_id);
                if( current_user_can( 'administrator' ) ){
                    $current_user_key  = $user_id; 
                } else {
                    $current_user_key       = taskbot_get_linked_profile_id($user_id, '', $user_type);
                    $wallet_amount          = get_user_meta( $user_id, '_buyer_balance', true );
                    $wallet_amount          = !empty($wallet_amount) ? $wallet_amount : 0;
                }
            }
            $enable_state		    = !empty($taskbot_settings['enable_state']) ? $taskbot_settings['enable_state'] : false;
            $data = array(
                'ajax_nonce'    => wp_create_nonce('ajax_nonce'),
                'home_url'    	=> home_url( '/' ),
                'ajaxurl'       => admin_url( 'admin-ajax.php' ),
                'username'      => esc_html__('Username required.', 'taskbot'),
                'valid_email'   => esc_html__('Valid email required', 'taskbot'),
                'first_name'    => esc_html__('First Name is required', 'taskbot'),
                'last_name'     => esc_html__('Last Name is required', 'taskbot'),
                'payout_methods_title' => esc_html__('Payouts method', 'taskbot'),
                'user_password' => esc_html__('Password is required', 'taskbot'),
                'user_password_confirm_match'	=> esc_html__('Password and confirm password should be same', 'taskbot'),
                'user_agree_terms'              => esc_html__('You must agree our terms & conditions before signup.', 'taskbot'),
                'upload_size'                   => $upload_file_size,
                'pusher_key'                    => $pusher_app_key,
                'cluster'                       => $cluster,
                'view_type'                     => $view_type,
                'remove_paymentmethod'          => esc_html__('Uh-Oh!', 'taskbot'),
                'remove_paymentmethod_message'  => esc_html__('Are you sure, you want to remove this payment method?', 'taskbot'),
                'service_type'                  => esc_html__('Task type', 'taskbot'),
                'project_type'                  => esc_html__('Project type', 'taskbot'),
                'select_option'                 => esc_html__('Select an option', 'taskbot'),
                'file_size_error'               => esc_html__('File size is too big', 'taskbot'),
                'error_title'                   => esc_html__('Uh-Oh!', 'taskbot'),
                'file_size_error_title'         => esc_html__('Uh-Oh!', 'taskbot'),
                'deactivate_account'            => esc_html__('Uh-Oh!', 'taskbot'),
                'deactivate_account_message'    => esc_html__('Are you sure, you want to deactivate this account?', 'taskbot'),
                'edu_date_error_title'          => esc_html__('Education','taskbot'),
                'load_more'                     => esc_html__('Load more','taskbot'),
                'show_less'                     => esc_html__('Show Less','taskbot'),
                'edu_date_error'                => esc_html__('Please add a vaild dates','taskbot'),
                'upload_max_images'             => esc_html__('Please upload files up to ','taskbot'),
                'date_format'                   => $date_format,
                'tpl_dashboard'                 => $tpl_dashboard,
                'startweekday'                  => get_option( 'start_of_week' ),
                'remove_education'              => esc_html__('Remove education', 'taskbot'),
                'remove_education_message'		=> esc_html__('Are you sure, you want to remove this education?', 'taskbot'),
                'remove_faq'				    => esc_html__('Remove FAQ', 'taskbot'),
                'remove_faq_message'            => esc_html__('Are you sure, you want to remove this FAQ?', 'taskbot'),
                'remove_task'                   => esc_html__('Remove task', 'taskbot'),
                'remove_task_message'           => esc_html__('Are you sure, you want to delete this task permanently?', 'taskbot'),
                'remove_subtask'                => esc_html__('Remove subtask', 'taskbot'),
                'remove_subtask_message'        => esc_html__('Are you sure, you want to remove this subtask?', 'taskbot'),
                'active_account'    		    => esc_html__('Active account', 'taskbot'),
			    'active_account_message'        => esc_html__('Are you sure you want active your account?', 'taskbot'),
                'yes_btntext'    		        => esc_html__('Yes', 'taskbot'),
                'cancel_verification'    		=> esc_html__('Cancel Verfication', 'taskbot'),
                'btntext_cancelled'    		    => esc_html__('Cancel', 'taskbot'),
			    'cancel_verification_message'   => esc_html__('Are you sure you want cancel your identity verification?', 'taskbot'),
                'default_image_extensions'      => ! empty( $taskbot_settings['default_image_extensions'] ) 		? $taskbot_settings['default_image_extensions'] 		: '',
                'default_file_extensions'       => ! empty( $taskbot_settings['default_file_extensions'] ) 		? $taskbot_settings['default_file_extensions'] 		: '',
                'allow_tags'                    => !empty($taskbot_settings['allow_tags'])? false : true,
                'task_max_images'               => ! empty($taskbot_settings['task_max_images'] ) 	? $taskbot_settings['task_max_images'] 	: 3,
                'maxnumber_fields'              => $maxnumber_fields,
                'max_custom_fieds_error'        => sprintf(esc_html__('You are allowed to add only %s custom fields','taskbot'),$maxnumber_fields),
                'empty_custom_field'    		=> esc_html__("Please don't leave empty custom fields. Either remove this or add the field title", 'taskbot'),
                'gclient_id'                    => $gclient_id,
                'user_type'                     => $user_type,
                'login_required'                => esc_html__('You must login as buyer to send a message to this seller','taskbot'),
                'only_buyer_option'             => esc_html__('You need to login as a buyer to access this option', 'taskbot'),
                'post_author_option'            => esc_html__('You are not allowed to perform this action', 'taskbot'),
                'show_more'                     => esc_html__('Load more', 'taskbot'),
                'show_less'                     => esc_html__('Show Less', 'taskbot'),
                'price_min_max_error_title'     => esc_html__('Wrong price range', 'taskbot'),
                'price_min_max_error_desc'      => esc_html__('Minimum price should not be greater than maximum price', 'taskbot'),
                'select_category'               => esc_html__('Select category', 'taskbot'),
                'search_category'               => esc_html__('Search category', 'taskbot'),
                'select_sub_category'           => esc_html__('Select sub category', 'taskbot'),
                'search_sub_category'           => esc_html__('Search sub category', 'taskbot'),
                'choose_category'               => esc_html__('Choose category', 'taskbot'),
                'choose_sub_category'           => esc_html__('Choose sub category', 'taskbot'),
                'current_user_key'              => $current_user_key,
                'remove_project'                => esc_html__('Remove project', 'taskbot'),
                'remove_project_message'        => esc_html__('Are you sure, you want to remove this project?', 'taskbot'),
                'languages_option'              => esc_html__('Select languages from the list', 'taskbot'),
                'skills_option'                 => esc_html__('Select skills from the list', 'taskbot'),
                'seller_skills_option'          => esc_html__('Select seller skills from the list', 'taskbot'),
                'expertise_level_option'        => esc_html__('Select expertise level', 'taskbot'),
                'num_freelancer_option'        => esc_html__('Select no of freelancer', 'taskbot'),
                'select_project_type'           => esc_html__('Select project type', 'taskbot'),
                'select_location'               => esc_html__('Select location', 'taskbot'),
                'select_state'                  => esc_html__('Select State', 'taskbot'),
                'apply_now'                     => esc_html__('Apply now','taskbot'),
                'login_seller_required'         => esc_html__('You must login as seller to access this option','taskbot'),
                'login_required_apply'          => esc_html__('You must login as seller to apply on this project','taskbot'),
                'wallet_account'    		    => esc_html__('You can also use wallet', 'taskbot'),
			    'wallet_account_message'        => sprintf(esc_html__('You have %s in your wallet. would you like to use wallet in this transaction?', 'taskbot'), taskbot_price_format($wallet_amount,'return')),
                'btn_with_wallet'    		    => esc_html__('Continue with wallet', 'taskbot'),
                'btn_without_wallet'    		=> esc_html__('Continue without wallet', 'taskbot'),
                'featured_title'                => esc_html__('Project featured','taskbot'),
                'featured_details'              => esc_html__('Are you sure, you want to mark featured this project?','taskbot'),
                'unfeatured_details'            => esc_html__('Are you sure, you want to remove mark featured this project?','taskbot'),
                'milestone_title'    		    => esc_html__('Milestone', 'taskbot'),
			    'milestone_request_message'     => esc_html__('Are you sure, you want to remove mark as complete this milestone project?', 'taskbot'),
                'hiring_title'    		        => esc_html__('Hiring process', 'taskbot'),
			    'hiring_request_message'        => esc_html__('Are you sure, you want to hire this?', 'taskbot'),
                'yes'                           => esc_html__('Yes','taskbot'),
                'no'                            => esc_html__('No','taskbot'),
                'enable_state'                  => $enable_state,
                
            );
            wp_localize_script($this->taskbot, 'scripts_vars', $data );
            wp_enqueue_script( $this->taskbot);
            wp_enqueue_style( 'taskbot-styles' );
            if( is_rtl() ){ wp_enqueue_style( 'taskbot-rtl-styles' );}
            

            $custom_css = taskbot_add_dynamic_styles();   
            wp_add_inline_style('taskbot-styles', $custom_css);
        }
    }

    /**
     * Enqueue firles for elementor
     *
     * @package         Amentotech
     * @subpackage      taskbot/public
     * @since           1.0
     */
    public function taskbot_before_render_elementor_enqueue( $content, $widget ) {
        $widget_name  = $widget->get_name();
        do_action( 'taskbot_elementor_files', $widget_name,$widget );

        if( $widget_name === 'taskbot_element_popular_services'
            || $widget_name === 'taskbot_element_feedback'
            || $widget_name === 'taskbot_element_sellers'
            || $widget_name === 'taskbot_element_sort_faqs'
            || $widget_name === 'taskbot_element_popular_categories'
            || $widget_name === 'taskbot_element_services_slider'
        ){
            wp_enqueue_style('splide');
            wp_enqueue_script('splide');
            wp_enqueue_style('splide');
            wp_enqueue_script('splide');
        }

        if($widget_name === 'taskbot_element_services_slider'){
            wp_enqueue_style('venobox');
            wp_enqueue_script('venobox');
        }

        if($widget_name === 'taskbot_element_search_banner_v2' || $widget_name === 'taskbot_element_search' ){
            wp_enqueue_style('select2');
            wp_enqueue_script('select2');
        }

        if($widget_name === 'taskbot_element_index_operate'){
            wp_enqueue_style('venobox');
            wp_enqueue_script('venobox');
        }

        if($widget_name === 'taskbot_element_authentication' && !is_user_logged_in()){
            wp_enqueue_script('google-signin-api-js');
            wp_enqueue_script('google-signin-gconnect-js');
        }

        return $content;
    }
}

/**
 * @Remove user
 * @type delete
 */
if (!function_exists('taskbot_delete_wp_user')) {
	add_action('delete_user', 'taskbot_delete_wp_user');
	function taskbot_delete_wp_user($user_id)
	{        
        $seller_profile = get_user_meta($user_id, '_linked_profile', true);
        $buyer_profile  = get_user_meta($id, '_linked_profile_buyer', true);
		if (!empty($buyer_profile)) {
			wp_delete_post($buyer_profile, true);
		}
        if (!empty($seller_profile)) {
			wp_delete_post($seller_profile, true);
		}
	}
}