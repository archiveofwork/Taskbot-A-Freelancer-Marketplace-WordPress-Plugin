<?php
/**
 * The apps download widgets functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Taskup
 * @subpackage Taskup/admin
 */

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

if (!class_exists('Taskup_Contact_Information')) {

    class Taskup_Contact_Information extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {

            parent::__construct(
                'taskup_contact_information' , // Base ID
                esc_html__('Contact information | Taskup' , 'taskbot') , // Name
                array (
                	'classname' 	=> 'tb-footercontact-info',
					'description' 	=> esc_html__('Taskup contact information' , 'taskbot') ,
				) // Args
            );
        }

        /**
         * Outputs the content of the widget
         *
         * @param array $args
         * @param array $instance
         */
        public function widget($args , $instance) {
            // outputs the content of the widget
			global $post;

            extract($instance);
            $title              = !empty($instance['title']) ? ($instance['title']) : '';
            $faccebook_link 	= !empty($instance['faccebook_link']) ? ($instance['faccebook_link']) : '';
            $twitter_link 	    = !empty($instance['twitter_link']) ? ($instance['twitter_link']) : '';
            $linkedin_link 	    = !empty($instance['linkedin_link']) ? ($instance['linkedin_link']) : '';
            $dribbble_link 	    = !empty($instance['dribbble_link']) ? ($instance['dribbble_link']) : '';
            $google_plus_link 	= !empty($instance['google_plus_link_link']) ? ($instance['google_plus_link']) : '';
            $phone_number       = !empty($instance['phone_number']) ? ($instance['phone_number']) : '';
            $phone_call_time    = !empty($instance['phone_call_time']) ? ($instance['phone_call_time']) : '';
            $email_address      = !empty($instance['email_address']) ? ($instance['email_address']) : '';
            $fax_number         = !empty($instance['fax_number']) ? ($instance['fax_number']) : '';
            $whatsapp_number    = !empty($instance['whatsapp_number']) ? ($instance['whatsapp_number']) : '';
            $whatsapp_call_time = !empty($instance['whatsapp_call_time']) ? ($instance['whatsapp_call_time']) : '';
            $before		        = ($args['before_widget']);
			$after	 	        = ($args['after_widget']);

            echo do_shortcode($before);?>
            <div class="tk-fwidget">
                <?php if( !empty($title) ){?>
                    <div class="tk-fwidget_title">
                        <h5><?php echo esc_html($title);?></h5>
                    </div>
                <?php } ?>
                <?php if( !empty($phone_number) || !empty($phone_call_time) || !empty($email_address) || !empty($fax_number) || !empty($whatsapp_number) || !empty($whatsapp_call_time) ){?>
                    <ul class="tk-fwidget_contact_list">
                        <?php if( !empty($phone_number) || !empty($phone_call_time) ){?>
                            <li>
                                <i class="tb-icon-phone-call"></i>
                                <?php if( !empty($phone_number) ){?>
                                    <a href="tel:<?php echo do_shortcode($phone_number);?>"><?php echo esc_html($phone_number);?></a>
                                <?php } ?>
                                <?php if( !empty($phone_call_time) ){?>
                                    <span><?php echo esc_html($phone_call_time);?></span>
                                <?php } ?>
                            </li>
                        <?php } ?>
                        <?php if( !empty($email_address) ){?>
                            <li>
                                <i class="tb-icon-mail"></i>
                                <?php if( !empty($email_address) ){?>
                                    <a href="mailto:<?php echo do_shortcode($email_address);?>"><?php echo esc_html($email_address);?></a>
                                <?php } ?>
                            </li>
                        <?php } ?>
                        <?php if( !empty($fax_number) ){?>
                            <li>
                                <i class="tb-icon-printer"></i>
                                <?php if( !empty($fax_number) ){?>
                                    <a href="fax:<?php echo do_shortcode($fax_number);?>"><?php echo esc_html($fax_number);?></a>
                                <?php } ?>
                            </li>
                        <?php } ?>
                        <?php if( !empty($whatsapp_number) || !empty($whatsapp_call_time) ){?>
                            <li>
                                <i class="fab fa-whatsapp"></i>
                                <?php if( !empty($whatsapp_number) ){?>
                                    <a href="tel:<?php echo do_shortcode($whatsapp_number);?>"><?php echo esc_html($whatsapp_number);?></a>
                                <?php } ?>
                                <?php if( !empty($whatsapp_call_time) ){?>
                                    <span><?php echo esc_html($whatsapp_call_time);?></span>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
                <?php if( !empty($faccebook_link) || !empty($twitter_link) || !empty($linkedin_link) || !empty($dribbble_link) || !empty($google_plus_link) ){?>
                    <ul class="tk-socialicons">
                        <?php if( !empty($faccebook_link) ){?>
                            <li>
                                <a href="<?php echo esc_url($faccebook_link);?>" class="wk-facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            </li>
                        <?php } ?>
                        <?php if( !empty($twitter_link) ){?>
                            <li>
                                <a href="<?php echo esc_url($twitter_link);?>" class="wk-twitter" target="_blank"><i class="fab fa-twitter"></i></a>
                            </li>
                        <?php } ?>
                        <?php if( !empty($linkedin_link) ){?>
                            <li>
                                <a href="<?php echo esc_url($linkedin_link);?>" class="wk-linkedin" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            </li>
                        <?php } ?>
                        <?php if( !empty($dribbble_link) ){?>
                            <li>
                                <a href="<?php echo esc_url($dribbble_link);?>" class="wk-dribbble" target="_blank"><i class="fab fa-dribbble"></i></a>
                            </li>
                        <?php } ?>
                        <?php if( !empty($google_plus_link) ){?>
                            <li>
                                <a href="<?php echo esc_url($google_plus_link);?>" class="wk-google" target="_blank"><i class="fab fa-google"></i></a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
			<?php
			echo do_shortcode( $after );
        }

        /**
         * Outputs the options form on admin
         *
         * @param array $instance The widget options
         */
        public function form($instance) {
            // outputs the options form on admin
            $title              = !empty($instance['title']) ? ($instance['title']) : '';
            $fax_number         = !empty($instance['fax_number']) ? ($instance['fax_number']) : '';           
            $twitter_link 	    = !empty($instance['twitter_link']) ? ($instance['twitter_link']) : '';
            $phone_number       = !empty($instance['phone_number']) ? ($instance['phone_number']) : '';
            $email_address      = !empty($instance['email_address']) ? ($instance['email_address']) : '';
            $linkedin_link 	    = !empty($instance['linkedin_link']) ? ($instance['linkedin_link']) : '';
            $dribbble_link 	    = !empty($instance['dribbble_link']) ? ($instance['dribbble_link']) : '';
            $faccebook_link 	= !empty($instance['faccebook_link']) ? ($instance['faccebook_link']) : '';
            $whatsapp_number    = !empty($instance['whatsapp_number']) ? ($instance['whatsapp_number']) : '';
             $phone_call_time   = !empty($instance['phone_call_time']) ? ($instance['phone_call_time']) : '';
            $google_plus_link   = !empty($instance['google_plus_link']) ? ($instance['google_plus_link']) : '';
            $whatsapp_call_time = !empty($instance['whatsapp_call_time']) ? ($instance['whatsapp_call_time']) : '';
            ?>
            
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('phone_number') ); ?>"><?php esc_html_e('Phone number','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('phone_number') ); ?>" type="text" value="<?php echo esc_attr($phone_number); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('phone_call_time') ); ?>"><?php esc_html_e('Phone call time content','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('phone_call_time') ); ?>" type="text" value="<?php echo esc_attr($phone_call_time); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('email_address') ); ?>"><?php esc_html_e('Email address','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('email_address') ); ?>" type="text" value="<?php echo esc_attr($email_address); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('fax_number') ); ?>"><?php esc_html_e('Fax number','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('fax_number') ); ?>" type="text" value="<?php echo esc_attr($fax_number); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('whatsapp_number') ); ?>"><?php esc_html_e('Whatsapp number','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('whatsapp_number') ); ?>" type="text" value="<?php echo esc_attr($whatsapp_number); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('whatsapp_call_time') ); ?>"><?php esc_html_e('Whatsapp call time content','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('whatsapp_call_time') ); ?>" type="text" value="<?php echo esc_attr($whatsapp_call_time); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('faccebook_link') ); ?>"><?php esc_html_e('Facebook link','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('faccebook_link') ); ?>" type="text" value="<?php echo esc_url($faccebook_link); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('twitter_link') ); ?>"><?php esc_html_e('Twitter link','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('twitter_link') ); ?>" type="text" value="<?php echo esc_url($twitter_link); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('linkedin_link') ); ?>"><?php esc_html_e('Linkedin link','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('linkedin_link') ); ?>" type="text" value="<?php echo esc_url($linkedin_link); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('google_plus_link') ); ?>"><?php esc_html_e('Google Plus link','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('google_plus_link') ); ?>" type="text" value="<?php echo esc_url($google_plus_link); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('dribbble_link') ); ?>"><?php esc_html_e('dribbble link','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('dribbble_link') ); ?>" type="text" value="<?php echo esc_url($dribbble_link); ?>">
            </p>
            <?php
        }

        /**
         * Processing widget options on save
         *
         * @param array $new_instance The new options
         * @param array $old_instance The previous options
         */
        public function update($new_instance , $old_instance) {
            // processes widget options to be saved
            $instance                           = $old_instance;
            $instance['faccebook_link']	        = !empty($new_instance['faccebook_link']) ? esc_url($new_instance['faccebook_link']) : '';
            $instance['twitter_link']	        = !empty($new_instance['twitter_link']) ? esc_url($new_instance['twitter_link']) : '';
            $instance['linkedin_link']	        = !empty($new_instance['linkedin_link']) ? esc_url($new_instance['linkedin_link']) : '';
            $instance['dribbble_link']	        = !empty($new_instance['dribbble_link']) ? esc_url($new_instance['dribbble_link']) : '';
            $instance['google_plus_link']	    = !empty($new_instance['google_plus_link']) ? esc_url($new_instance['google_plus_link']) : '';
            $instance['phone_number']           = !empty($new_instance['phone_number']) ? sanitize_text_field($new_instance['phone_number']) : '';
            $instance['phone_call_time']        = !empty($new_instance['phone_call_time']) ? sanitize_text_field($new_instance['phone_call_time']) : '';
            $instance['email_address']          = !empty($new_instance['email_address']) && sanitize_email($new_instance['email_address']) ? ($new_instance['email_address']) : '';
            $instance['fax_number']             = !empty($new_instance['fax_number']) ? sanitize_text_field($new_instance['fax_number']) : '';
            $instance['whatsapp_number']       = !empty($new_instance['whatsapp_number']) ? sanitize_text_field($new_instance['whatsapp_number']) : '';
            $instance['whatsapp_call_time']     = !empty($new_instance['whatsapp_call_time']) ? sanitize_text_field($new_instance['whatsapp_call_time']) : '';
            $instance['title']                  = !empty($new_instance['title']) ? ($new_instance['title']) : '';
            return $instance;
        }
    }
}

//register widget
function taskbot_register_contact_info_widgets() {
	register_widget( 'Taskup_Contact_Information' );
}
add_action( 'widgets_init', 'taskbot_register_contact_info_widgets' );
