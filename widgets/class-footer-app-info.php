<?php
/**
 * About us Footer widget 
 *
 * @since      1.0.0
 *
 * @package    Taskup
 * @subpackage Taskup/admin
 */

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

if (!class_exists('Taskup_Apps')) {

    class Taskup_Apps extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {

            parent::__construct(
                'taskup_apps' , // Base ID
                esc_html__('Mobile app section | Taskup' , 'taskbot') , // Name
                array (
                	'classname' 	=> 'tu-footerapp',
					'description' 	=> esc_html__('Taskup info' , 'taskbot') ,
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

			$footer_logo 		    = (!empty($instance['footer_logo']) ) ? ($instance['footer_logo']) : '';
            $footer_content 	    = !empty($instance['footer_content']) ? ($instance['footer_content']) : '';
            $mobile_app_title       = (!empty($instance['mobile_app_title']) ) ? sanitize_text_field($instance['mobile_app_title']) : '';
            $appstore_logo	        = (!empty($instance['appstore_logo']) ) ? esc_url($instance['appstore_logo']) : '';
            $appstore_url           = (!empty($instance['appstore_url']) ) ? esc_url($instance['appstore_url']) : '';
            $palystore_logo	        = (!empty($instance['palystore_logo']) ) ? esc_url($instance['palystore_logo']) : '';
            $palystore_url	        = (!empty($instance['palystore_url']) ) ? esc_url($instance['palystore_url']) : '';

            $before		            = ($args['before_widget']);
			$after	 	            = ($args['after_widget']);

            echo do_shortcode($before);?>
            <div class="tk-footer-two_info">
                <?php if(!empty($footer_logo)){?>
                    <strong><a href="<?php echo esc_url(get_home_url());?>"><img src="<?php echo esc_url($footer_logo)?>" alt="<?php echo esc_attr(get_bloginfo('name'));?>"></a></strong>
                <?php } ?>
                <?php if( !empty($footer_content) ){?>
                    <div class="tk-description">
                        <p><?php echo esc_html($footer_content);?></p>
                    </div>
                <?php } ?>
                <?php if( !empty($appstore_logo) || !empty($palystore_logo) || !empty($mobile_app_title) ){?>
                    <div class="tk-footer-mobile-app">
                        <?php if( !empty($mobile_app_title) ){?>
                            <div class="tk-title">
                                <h3><?php echo esc_html($mobile_app_title);?></h3>
                            </div>
                        <?php } ?>
                        <?php if(!empty($appstore_logo) || !empty($palystore_logo) ){?>
                            <ul class="tk-socailapp">
                                <li>
                                    <a href="<?php echo esc_url($appstore_url);?>"><img src="<?php echo esc_url($appstore_logo)?>" alt="<?php esc_attr_e('App store app','taskbot');?>"></a>
                                </li>
                                <li>
                                    <a href="<?php echo esc_url($palystore_url);?>"><img src="<?php echo esc_url($palystore_logo)?>" alt="<?php esc_attr_e('Play store app','taskbot');?>"></a>
                                </li>
                            </ul>
                        <?php } ?>
                    </div>
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
            $footer_logo 		    = (!empty($instance['footer_logo']) ) ? ($instance['footer_logo']) : '';
            $footer_content 	    = !empty($instance['footer_content']) ? ($instance['footer_content']) : '';
            $appstore_logo 		    = (!empty($instance['appstore_logo']) ) ? ($instance['appstore_logo']) : '';
            $mobile_app_title 		= (!empty($instance['mobile_app_title']) ) ? ($instance['mobile_app_title']) : '';
            $appstore_url 		    = (!empty($instance['appstore_url']) ) ? ($instance['appstore_url']) : '';
            $palystore_logo 		= (!empty($instance['palystore_logo']) ) ? ($instance['palystore_logo']) : '';
            $palystore_url 		    = (!empty($instance['palystore_url']) ) ? ($instance['palystore_url']) : '';
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('footer_logo') ); ?>"><?php esc_html_e('Upload footer logo','taskbot'); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('footer_logo') );?>" name="<?php echo esc_attr( $this->get_field_name('footer_logo') );?>" type="text" value="<?php echo esc_url($footer_logo);?>">
                <span id="upload" class="button upload_button_wgt"><?php esc_html_e( 'Footer logo', 'taskbot' ); ?><?php esc_html_e( 'Upload', 'taskbot' ); ?></span>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('footer_content') ); ?>"><?php esc_html_e('Footer content','taskbot'); ?></label>
                <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id('footer_content') ); ?>" name="<?php echo esc_attr( $this->get_field_name('footer_content') ); ?>"><?php echo esc_html($footer_content); ?></textarea>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('mobile_app_title') ); ?>"><?php esc_html_e('Add mobile app section title','taskbot'); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('mobile_app_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('mobile_app_title') ); ?>" type="text" value="<?php echo esc_html($mobile_app_title); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('appstore_logo') ); ?>"><?php esc_html_e('Upload App store logo','taskbot'); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('appstore_logo') );?>" name="<?php echo esc_attr( $this->get_field_name('appstore_logo') );?>" type="text" value="<?php echo esc_url($appstore_logo);?>">
                <span id="upload" class="button upload_button_wgt"><?php esc_html_e( 'App store logo', 'taskbot' ); ?><?php esc_html_e( 'Upload', 'taskbot' ); ?></span>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('appstore_url') ); ?>"><?php esc_html_e('Add App store app URL','taskbot'); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('appstore_url') ); ?>" name="<?php echo esc_attr( $this->get_field_name('appstore_url') ); ?>" type="text" value="<?php echo esc_html($appstore_url); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('palystore_logo') ); ?>"><?php esc_html_e('Upload play store logo','taskbot'); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('palystore_logo') );?>" name="<?php echo esc_attr( $this->get_field_name('palystore_logo') );?>" type="text" value="<?php echo esc_url($palystore_logo);?>">
                <span id="upload" class="button upload_button_wgt"><?php esc_html_e( 'Play store logo', 'taskbot' ); ?><?php esc_html_e( 'Upload', 'taskbot' ); ?></span>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('palystore_url') ); ?>"><?php esc_html_e('Add Play store app URL','taskbot'); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('palystore_url') ); ?>" name="<?php echo esc_attr( $this->get_field_name('palystore_url') ); ?>" type="text" value="<?php echo esc_html($palystore_url); ?>">
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
            $instance['mobile_app_title']	    = (!empty($new_instance['mobile_app_title']) ) ? sanitize_text_field($new_instance['mobile_app_title']) : '';
            $instance['footer_logo']	        = (!empty($new_instance['footer_logo']) ) ? esc_url($new_instance['footer_logo']) : '';
            $instance['footer_content']	        = (!empty($new_instance['footer_content']) ) ? sanitize_textarea_field($new_instance['footer_content']) : '';
            $instance['appstore_logo']	        = (!empty($new_instance['appstore_logo']) ) ? esc_url($new_instance['appstore_logo']) : '';
            $instance['appstore_url']	        = (!empty($new_instance['appstore_url']) ) ? esc_url($new_instance['appstore_url']) : '';
            $instance['palystore_logo']	        = (!empty($new_instance['palystore_logo']) ) ? esc_url($new_instance['palystore_logo']) : '';
            $instance['palystore_url']	        = (!empty($new_instance['palystore_url']) ) ? esc_url($new_instance['palystore_url']) : '';
            return $instance;
        }
    }
}

//register widget
if( !function_exists('taskup_register_apps_widgets') ){
    function taskup_register_apps_widgets() {
        register_widget( 'Taskup_Apps' );
    }
    add_action( 'widgets_init', 'taskup_register_apps_widgets' );
}