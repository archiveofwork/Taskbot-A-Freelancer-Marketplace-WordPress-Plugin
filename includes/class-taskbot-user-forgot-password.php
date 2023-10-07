<?php
/**
 *
 * Class 'Taskbot_User_Forgot_Password' add user forgot password shortcode
 *
 * @package     Taskbot
 * @subpackage  Taskbot/includes
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
class Taskbot_User_Forgot_Password {

  private $shortcode_name = 'taskbot_forgot';

	/**
	 * Add user registration shortcode
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct() {
        add_action( 'wp_ajax_taskbot_forgot', array($this, 'taskbot_forgot') );
        add_action('wp_ajax_nopriv_taskbot_forgot',  array($this, 'taskbot_forgot') );
        add_action('wp_ajax_taskbot_reset',  array($this, 'taskbot_reset') );
        add_action('wp_ajax_nopriv_taskbot_reset',  array($this, 'taskbot_reset') );
        add_shortcode(  $this->shortcode_name, array($this, 'taskbot_forgot_form') );
    }

  /**
	 * Get Lost Password AJAX function
	 *
	 * @since    1.0.0
	 * @access   public
	 */
    public function taskbot_forgot(){

        global $taskbot_settings;
		    $json       = array();
		    $post_data  = !empty($_POST['data']) ?  $_POST['data'] : '';
		    parse_str($post_data,$output);

            $user_email = !empty($output['fotgot']['email']) ? sanitize_email($output['fotgot']['email']) : '';

            taskbotForgetPassword($user_email);
    }

    /**
     * Reset Password AJAX function
     *
     * @since    1.0.0
     * @access   public
     */
    public function taskbot_reset(){

        global $taskbot_settings;

        $json       = array();
        $post_data  = !empty($_POST['data']) ?  $_POST['data'] : '';
        parse_str($post_data,$output);
        $password           = (!empty($output['fotgot']['password'])    ? sanitize_text_field($output['fotgot']['password'])     : '');
        $confirm_password   = (!empty($output['fotgot']['re_password']) ? sanitize_text_field($output['fotgot']['re_password'])  : '');

        if ( empty($password) || empty($confirm_password) ) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Oops!', 'taskbot');
            $json['message_desc'] = esc_html__('Password should not be empty', 'taskbot');
            wp_send_json( $json );
        }

        //Match password
        if ($password != $confirm_password) {
            $json['type']     = 'error';
            $json['message'] = esc_html__('Oops!', 'taskbot');
            $json['message_desc']  = esc_html__('Password does not match.', 'taskbot');
            wp_send_json($json);
        }

        do_action( 'taskbot_strong_password_validation', $password );

        if (!empty($output['key']) && ( isset($output['reset_action']) && $output['reset_action'] == "reset_pwd" ) &&  (!empty($output['login']) ) ) {

            $reset_key  = sanitize_text_field($output['key']);
            $user_email = sanitize_text_field($output['login']);
            $user_data = get_user_by('email', $user_email);

            if (!empty($reset_key) && !empty($user_data)) {
                $user_identity 	= intval($user_data->ID);
                $user_type		= apply_filters('taskbot_get_user_type', $user_identity );
                $redirect_url   = '';

                if( !empty($user_type) && $user_type != 'administrator' ){
                    $redirect_url  = !empty($taskbot_settings['tpl_login']) ? get_the_permalink( $taskbot_settings['tpl_login'] ) : wp_login_url();
                }
                $notifyDetails                  = array();
                $notifyData                     = array();
                $user_type		                = apply_filters('taskbot_get_user_type', $user_data->ID);
                $linked_profile                 = taskbot_get_linked_profile_id($user_data->ID, '', $user_type);
                $notifyData['user_type']		= $user_type;
                $notifyData['receiver_id']		= $user_data->ID;
                $notifyData['type']				= 'reset_password';
                $notifyData['post_data']		= $notifyDetails;
                $notifyData['linked_profile']	= $linked_profile;
                do_action('taskbot_notification_message', $notifyData );

                wp_set_password($password, $user_data->ID);
                $json['redirect_url'] = $redirect_url;
                $json['type'] = "success";
                $json['message'] = esc_html__('Woohoo!', 'taskbot');
                $json['message_desc'] = esc_html__("Congratulation! your password has been changed.", 'taskbot');
                wp_send_json( $json );

            } else {
                $json['type'] = "error";
                $json['message'] = esc_html__('Oops!', 'taskbot');
                $json['message_desc'] = esc_html__("Oops! Invalid request", 'taskbot');
                wp_send_json( $json );
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Oops!', 'taskbot');
            $json['message_desc'] = esc_html__('Some error occur, please try again later', 'taskbot');
            wp_send_json( $json );
        }
  	}

    /**
	 * Forgot password form
	 *
	 * @since    1.0.0
	 * @access   public
	 */
    public function taskbot_forgot_form($atts){
        global $current_user, $taskbot_settings;
        $atts = shortcode_atts(
            array(
                'background'          => '',
                'logo'                => '',
                'reset_key'           => '',
                'reset_action'        => '',
                'user_email'          => '',
                'tagline'             => '',
                'reset_pass_tagline'  => '',
            ),$atts
        );
        ob_start();

        $bg_banner          = esc_url($atts['background']);
        $logo               = esc_url($atts['logo']);
        $reset_key          = '';
        $reset_action       = '';
        $user_email         = '';
        $google_connect     = !empty($taskbot_settings['enable_social_connect']) ? $taskbot_settings['enable_social_connect'] : '';
        $login_page         = !empty( $taskbot_settings['tpl_login'] ) ? get_permalink($taskbot_settings['tpl_login']) : '';
        $registration_page  = !empty( $taskbot_settings['tpl_registration'] ) ? get_permalink($taskbot_settings['tpl_registration']) : '';
        $classes	        = '';

        if(empty($registration_page)){
            $classes	= 'tb-popupcontainervtwo';
        }

        if(!is_user_logged_in()){

            if ( isset($_GET['action']) && $_GET['action'] == 'reset_pwd' ) {
                $tagline        = !empty($atts['reset_pass_tagline']) ? ($atts['reset_pass_tagline']) : '';
                $reset_key      = !empty($_GET['key'])    ? esc_html($_GET['key'])    : '';
                $reset_action   = !empty($_GET['action']) ? esc_html($_GET['action']) : '';
                $user_email     = !empty($_GET['login'])  ? esc_html($_GET['login'])  : '';
            } else {
                $tagline       = !empty($atts['tagline']) ? ($atts['tagline'])  : '';
            }

            // Forgot/Reset password template
            taskbot_get_template( 'forgot.php',
                array( 
                    'google_connect'        => $google_connect,
                    'background_banner'		=> $bg_banner,
                    'logo'                  => $logo,
                    'tagline'               => $tagline,
                    'reset_key'             => $reset_key,
                    'reset_action'          => $reset_action,
                    'user_email'            => $user_email,
                    'login_page'            => $login_page,
                    'registration_page'		=> $registration_page,
                    'classes'				=> $classes
                )
            );
        }

        return ob_get_clean();
    }
}
new Taskbot_User_Forgot_Password();
