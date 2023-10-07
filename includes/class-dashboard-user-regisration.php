<?php
/**
 *
 * Class 'Taskbot_Dashboard_Shortcodes_User_Registration' add user registration shortcode
 *
 * @package     Taskbot
 * @subpackage  Taskbot/includes
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
class Taskbot_Dashboard_Shortcodes_User_Registration
{

    private $shortcode_name = 'taskbot_registration';

    /**
     * Add user registration shortcode
     *
     * @since    1.0.0
     * @access   public
     */
    public function __construct()
    {
        add_action('wp_ajax_nopriv_taskbot_registeration', array($this, 'taskbot_registeration'));
        add_shortcode($this->shortcode_name, array($this, 'taskbot_user_registration_form'));
    }

    /**
     * User registration AJAX function
     *
     * @since    1.0.0
     * @access   public
     */
    public function taskbot_registeration()
    {
        global $taskbot_settings;
        if( function_exists('taskbot_is_demo_site') ) { 
            taskbot_is_demo_site();
        }

        $json           = array();
        $notifyData     = array();
        $notifyDetails	= array();

        $post_data          = !empty($_POST['data']) ? $_POST['data'] : '';

        parse_str($post_data, $output);

        $do_check         = check_ajax_referer('ajax_nonce', 'security', false);
        $json['message']  = esc_html__('Registration','taskbot');

        if ($do_check == false) {
            $json['type']          = 'error';
            $json['message_desc']  = esc_html__('Security checks failed', 'taskbot');
            wp_send_json($json);
        }
        taskbotRegistration($output);
    }

    /**
     * user registration form
     *
     * @since    1.0.0
     * @access   public
     */
    public function taskbot_user_registration_form($atts) {

        global $current_user, $taskbot_settings;
        $atts = shortcode_atts(
            array(
                'background' => '',
                'logo'      => '',
                'tagline'   => '',
            ),
            $atts
        );

        ob_start();
        $bg_banner  = $atts['background'];
        $logo       = $atts['logo'];
        $tagline    = $atts['tagline'];

        $login_page                 = !empty( $taskbot_settings['tpl_login'] ) ? get_permalink($taskbot_settings['tpl_login']) : '';
        $terms_conditions_page      = !empty($taskbot_settings['tpl_terms_conditions']) ? ($taskbot_settings['tpl_terms_conditions']) : '';
        $tpl_privacy                = !empty($taskbot_settings['tpl_privacy']) ? ($taskbot_settings['tpl_privacy']) : '';
        $hide_role                  = !empty($taskbot_settings['hide_role']) ? ($taskbot_settings['hide_role']) : '';
        $google_connect             = !empty($taskbot_settings['enable_social_connect']) ? $taskbot_settings['enable_social_connect'] : '';
        $user_name_option           = !empty($taskbot_settings['user_name_option']) ? $taskbot_settings['user_name_option'] : false;
        $defult_register_type       = !empty($taskbot_settings['defult_register_type']) ? $taskbot_settings['defult_register_type'] : 'buyers';
        $term_link                  = !empty($terms_conditions_page) ? '<a target="_blank" href="'.get_the_permalink($terms_conditions_page).'">'.get_the_title($terms_conditions_page).'</a>' : '';
        $privacy_link               = !empty($tpl_privacy) ? '<a target="_blank" href="'.get_the_permalink($tpl_privacy).'">'.get_the_title($tpl_privacy).'</a>' : '';
        $user_types                 = apply_filters('taskbot_get_user_types','');

        if(!empty($hide_role) && $hide_role !== 'both'){
            unset($user_types[$hide_role]);
        }

        if (!is_user_logged_in()) {

            //Register template
            taskbot_get_template('register.php',
                array(
                    'background_banner'   => $bg_banner,
                    'logo'                => $logo,
                    'tagline'             => $tagline,
                    'login_page'          => $login_page,
                    'term_link'           => $term_link,
                    'privacy_link'        => $privacy_link,
                    'terms_conditions_page' => $terms_conditions_page,
                    'user_name_option'      => $user_name_option,
                    'google_connect'        => $google_connect,
                    'user_types'            => $user_types,
                    'defult_register_type'  => $defult_register_type

                )
            );
        }
        
        return ob_get_clean();
    }

}

new Taskbot_Dashboard_Shortcodes_User_Registration();
