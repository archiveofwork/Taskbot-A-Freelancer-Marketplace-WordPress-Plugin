<?php
/**
 * The apps download widgets functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot/admin
 */

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

if (!class_exists('Taskbot_Apps')) {

    class Taskbot_Apps extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {

            parent::__construct(
                'taskbot_apps' , // Base ID
                esc_html__('Get Mobile App | Taskbot' , 'taskbot') , // Name
                array (
                	'classname' 	=> 'tb-footerapp',
					'description' 	=> esc_html__('Taskbot apps' , 'taskbot') ,
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

			$footer_logo 		= (!empty($instance['footer_logo']) ) ? ($instance['footer_logo']) : '';
            $footer_content 	= !empty($instance['footer_content']) ? ($instance['footer_content']) : '';
            $mac_img 		    = (!empty($instance['mac_img']) ) ? ($instance['mac_img']) : '';
            $mac_url 		    = (!empty($instance['mac_url']) ) ? ($instance['mac_url']) : '';
            $google_img 		= (!empty($instance['google_img']) ) ? ($instance['google_img']) : '';
            $google_url 		= (!empty($instance['google_url']) ) ? ($instance['google_url']) : '';

            $faccebook_link 	= !empty($instance['faccebook_link']) ? ($instance['faccebook_link']) : '';
            $twitter_link 	    = !empty($instance['twitter_link']) ? ($instance['twitter_link']) : '';
            $linkedin_link 	    = !empty($instance['linkedin_link']) ? ($instance['linkedin_link']) : '';
            $instagram_link 	= !empty($instance['instagram_link']) ? ($instance['instagram_link']) : '';
            $pinterest_link 	= !empty($instance['pinterest_link']) ? ($instance['pinterest_link']) : '';
            $tiktok_link 	    = !empty($instance['tiktok_link']) ? ($instance['tiktok_link']) : '';
            $youtube_link 	    = !empty($instance['youtube_link']) ? ($instance['youtube_link']) : '';

            $faccebook_label 	= !empty($instance['faccebook_label']) ? ($instance['faccebook_label']) : '';
            $twitter_label 	    = !empty($instance['twitter_label']) ? ($instance['twitter_label']) : '';
            $linkedin_label 	= !empty($instance['linkedin_label']) ? ($instance['linkedin_label']) : '';
            $instagram_label 	= !empty($instance['instagram_label']) ? ($instance['instagram_label']) : '';
            $pinterest_label 	= !empty($instance['pinterest_label']) ? ($instance['pinterest_label']) : '';
            $tiktok_label 	    = !empty($instance['tiktok_label']) ? ($instance['tiktok_label']) : '';
            $youtube_label 	    = !empty($instance['youtube_label']) ? ($instance['youtube_label']) : '';

            $before		= ($args['before_widget']);
			$after	 	= ($args['after_widget']);

            echo do_shortcode($before);?>
            <div class="tk-footeritem">
                
                <?php if( !empty($footer_logo) ){?>
                    <figure>
                        <img class="tk-footer-logo" src="<?php echo esc_url($footer_logo);?>" alt="<?php echo esc_attr(get_bloginfo('name'));?>">
                    </figure>
                <?php } ?>

                <?php if( !empty($footer_content) ){?>
                    <div class="tk-main-description">
                        <p><?php echo esc_html($footer_content);?></p>
                    </div>
                <?php } ?>

                <?php if( !empty($faccebook_link) || !empty($twitter_link) || !empty($linkedin_link) || !empty($instagram_link) || !empty($pinterest_link) || !empty($tiktok_link) || !empty($youtube_link) ){?>
                    <ul class="tk-socialink">
                        <?php if( !empty($faccebook_link) ){?>
                            <li><a href="<?php echo esc_url( $faccebook_link );?>"> <i class="fab fa-facebook-f"></i> <?php echo esc_html( $faccebook_label );?></a> </li>
                        <?php } ?>
                        
                        <?php if( !empty($twitter_link) ){?>
                            <li><a href="<?php echo esc_url( $twitter_link );?>"> <i class="fab fa-twitter"></i> <?php echo esc_html( $twitter_label );?></a> </li>
                        <?php } ?>
                        <?php if( !empty($linkedin_link) ){?>
                            <li><a href="<?php echo esc_url( $linkedin_link );?>"> <i class="fab fa-linkedin-in"></i> <?php echo esc_html( $linkedin_label );?></a> </li>
                        <?php } ?>
                        <?php if( !empty($instagram_link) ){?>
                            <li><a href="<?php echo esc_url( $instagram_link );?>"> <i class="fab fa-instagram"></i> <?php echo esc_html( $instagram_label );?></a> </li>
                        <?php } ?>

                        <?php if( !empty($pinterest_link) ){?>
                            <li><a href="<?php echo esc_url( $pinterest_link );?>"> <i class="fab fa-pinterest"></i> <?php echo esc_html( $pinterest_label );?></a> </li>
                        <?php } ?>

                        <?php if( !empty($tiktok_link) ){?>
                            <li class="tk-tiktok-icon"><a href="<?php echo esc_url( $tiktok_link );?>"><img width="16" height="16" alt="<?php esc_html_e('Tiktok','taskbot');?>"  src="<?php echo esc_url(TASKBOT_DIRECTORY_URI.'/public/images/tiktok.svg');?>"><?php echo esc_html( $tiktok_label );?></a> </li>
                        <?php } ?>
                        <?php if( !empty($youtube_link) ){?>
                            <li><a href="<?php echo esc_url( $youtube_link );?>"> <i class="fab fa-youtube"></i> <?php echo esc_html( $youtube_label );?></a> </li>
                        <?php } ?>
                    </ul>
                <?php } ?>

                <?php if( !empty($mac_img) || !empty($google_img) ){?>
                    <ul class="tk-storeicons">
                        
                        <?php if( !empty($mac_img) ){?>
                            <li> <a href="<?php echo esc_url($mac_url);?>"><img src="<?php echo esc_url($mac_img);?>" alt="<?php esc_attr_e('App store','taskbot');?>"></a> </li>
                        <?php } ?>

                        <?php if( !empty($google_img) ){?>
                            <li> <a href="<?php echo esc_url($google_url);?>"><img src="<?php echo esc_url($google_img);?>" alt="<?php esc_attr_e('Play store','taskbot');?>"></a> </li>
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
            $footer_logo 		= (!empty($instance['footer_logo']) ) ? ($instance['footer_logo']) : '';
            $footer_content 	= !empty($instance['footer_content']) ? ($instance['footer_content']) : '';
            
            $faccebook_label 	= !empty($instance['faccebook_label']) ? ($instance['faccebook_label']) : '';
            $twitter_label 	    = !empty($instance['twitter_label']) ? ($instance['twitter_label']) : '';
            $linkedin_label 	= !empty($instance['linkedin_label']) ? ($instance['linkedin_label']) : '';

            $instagram_label 	= !empty($instance['instagram_label']) ? ($instance['instagram_label']) : '';
            $pinterest_label 	= !empty($instance['pinterest_label']) ? ($instance['pinterest_label']) : '';
            $tiktok_label 	    = !empty($instance['tiktok_label']) ? ($instance['tiktok_label']) : '';
            $youtube_label 	    = !empty($instance['youtube_label']) ? ($instance['youtube_label']) : '';

            $faccebook_link 	= !empty($instance['faccebook_link']) ? ($instance['faccebook_link']) : '';
            $twitter_link 	    = !empty($instance['twitter_link']) ? ($instance['twitter_link']) : '';
            $linkedin_link 	    = !empty($instance['linkedin_link']) ? ($instance['linkedin_link']) : '';

            $instagram_link 	= !empty($instance['instagram_link']) ? ($instance['instagram_link']) : '';
            $pinterest_link 	= !empty($instance['pinterest_link']) ? ($instance['pinterest_link']) : '';
            $tiktok_link 	    = !empty($instance['tiktok_link']) ? ($instance['tiktok_link']) : '';
            $youtube_link 	    = !empty($instance['youtube_link']) ? ($instance['youtube_link']) : '';

            $mac_img 		    = (!empty($instance['mac_img']) ) ? ($instance['mac_img']) : '';
            $mac_url 		    = (!empty($instance['mac_url']) ) ? ($instance['mac_url']) : '';
            $google_img 		= (!empty($instance['google_img']) ) ? ($instance['google_img']) : '';
            $google_url 		= (!empty($instance['google_url']) ) ? ($instance['google_url']) : '';

            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('footer_logo') ); ?>"><?php esc_html_e('Upload footer logo','taskbot'); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('footer_logo') ); ?>" name="<?php echo esc_attr( $this->get_field_name('footer_logo') ); ?>" type="text" value="<?php echo esc_url($footer_logo); ?>">
                <span id="upload" class="button upload_button_wgt"><?php esc_html_e( 'Footer logo', 'taskbot' ); ?><?php esc_html_e( 'Upload', 'taskbot' ); ?></span>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('footer_content') ); ?>"><?php esc_html_e('Footer content','taskbot'); ?></label>
                <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id('footer_content') ); ?>" name="<?php echo esc_attr( $this->get_field_name('footer_content') ); ?>"><?php echo esc_html($footer_content); ?></textarea>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('faccebook_label') ); ?>"><?php esc_html_e('Facebook label','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('faccebook_label') ); ?>" type="text" value="<?php echo esc_url($faccebook_label); ?>">
           </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('faccebook_link') ); ?>"><?php esc_html_e('Facebook link','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('faccebook_link') ); ?>" type="text" value="<?php echo esc_url($faccebook_link); ?>">
           </p>
           <p>
                <label for="<?php echo esc_attr( $this->get_field_id('twitter_label') ); ?>"><?php esc_html_e('Twitter label','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('twitter_label') ); ?>" type="text" value="<?php echo esc_url($twitter_label); ?>">
           </p>
           <p>
                <label for="<?php echo esc_attr( $this->get_field_id('twitter_link') ); ?>"><?php esc_html_e('Twitter link','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('twitter_link') ); ?>" type="text" value="<?php echo esc_url($twitter_link); ?>">
           </p>
           <p>
                <label for="<?php echo esc_attr( $this->get_field_id('linkedin_label') ); ?>"><?php esc_html_e('Linkedin label','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('linkedin_label') ); ?>" type="text" value="<?php echo esc_url($linkedin_label); ?>">
           </p>
           <p>
                <label for="<?php echo esc_attr( $this->get_field_id('linkedin_link') ); ?>"><?php esc_html_e('Linkedin link','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('linkedin_link') ); ?>" type="text" value="<?php echo esc_url($linkedin_link); ?>">
           </p>

           <p>
                <label for="<?php echo esc_attr( $this->get_field_id('pinterest_label') ); ?>"><?php esc_html_e('Pinterest label','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('pinterest_label') ); ?>" type="text" value="<?php echo esc_attr($pinterest_label); ?>">
           </p>
           <p>
                <label for="<?php echo esc_attr( $this->get_field_id('pinterest_link') ); ?>"><?php esc_html_e('Pinterest link','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('pinterest_link') ); ?>" type="text" value="<?php echo esc_url($pinterest_link); ?>">
           </p>

           <p>
                <label for="<?php echo esc_attr( $this->get_field_id('instagram_label') ); ?>"><?php esc_html_e('Instagram label','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('instagram_label') ); ?>" type="text" value="<?php echo esc_attr($instagram_label); ?>">
           </p>
           <p>
                <label for="<?php echo esc_attr( $this->get_field_id('instagram_link') ); ?>"><?php esc_html_e('Instagram link','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('instagram_link') ); ?>" type="text" value="<?php echo esc_url($instagram_link); ?>">
           </p>


           <p>
                <label for="<?php echo esc_attr( $this->get_field_id('youtube_label') ); ?>"><?php esc_html_e('Youtube label','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('youtube_label') ); ?>" type="text" value="<?php echo esc_attr($youtube_label); ?>">
           </p>
           <p>
                <label for="<?php echo esc_attr( $this->get_field_id('youtube_link') ); ?>"><?php esc_html_e('Youtube link','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('youtube_link') ); ?>" type="text" value="<?php echo esc_url($youtube_link); ?>">
           </p>

           <p>
                <label for="<?php echo esc_attr( $this->get_field_id('tiktok_label') ); ?>"><?php esc_html_e('Tiktok label','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('tiktok_label') ); ?>" type="text" value="<?php echo esc_attr($tiktok_label); ?>">
           </p>
           <p>
                <label for="<?php echo esc_attr( $this->get_field_id('tiktok_link') ); ?>"><?php esc_html_e('Tiktok link','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('tiktok_link') ); ?>" type="text" value="<?php echo esc_url($tiktok_link); ?>">
           </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('google_img') ); ?>"><?php esc_html_e('Google play image URL','taskbot'); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('google_img') ); ?>" name="<?php echo esc_attr( $this->get_field_name('google_img') ); ?>" type="text" value="<?php echo esc_url($google_img); ?>">
                <span id="upload" class="button upload_button_wgt"><?php esc_html_e( 'Logo', 'taskbot' ); ?><?php esc_html_e( 'Upload', 'taskbot' ); ?></span>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('google_url') ); ?>"><?php esc_html_e('Google App URL','taskbot'); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('google_url') ); ?>" name="<?php echo esc_attr( $this->get_field_name('google_url') ); ?>" type="text" value="<?php echo esc_attr($google_url); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('mac_img') ); ?>"><?php esc_html_e('App stor image URL','taskbot'); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('mac_img') ); ?>" name="<?php echo esc_attr( $this->get_field_name('mac_img') ); ?>" type="text" value="<?php echo esc_url($mac_img); ?>">
                <span id="upload" class="button upload_button_wgt"><?php esc_html_e( 'Logo', 'taskbot' ); ?><?php esc_html_e( 'Upload', 'taskbot' ); ?></span>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('mac_url') ); ?>"><?php esc_html_e('App URL','taskbot'); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('mac_url') ); ?>" name="<?php echo esc_attr( $this->get_field_name('mac_url') ); ?>" type="text" value="<?php echo esc_attr($mac_url); ?>">
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
            $instance                   = $old_instance;
            $instance['footer_logo']	= (!empty($new_instance['footer_logo']) ) ? esc_url($new_instance['footer_logo']) : '';
            $instance['mac_img']	    = (!empty($new_instance['mac_img']) ) ? esc_url($new_instance['mac_img']) : '';
            $instance['mac_url']	    = (!empty($new_instance['mac_url']) ) ? esc_url($new_instance['mac_url']) : '';
            $instance['google_img']	    = (!empty($new_instance['google_img']) ) ? esc_url($new_instance['google_img']) : '';
            $instance['google_url']	    = (!empty($new_instance['google_url']) ) ? esc_url($new_instance['google_url']) : '';

            $instance['footer_content']	= (!empty($new_instance['footer_content']) ) ? sanitize_textarea_field($new_instance['footer_content']) : '';

            $instance['faccebook_link']	= (!empty($new_instance['faccebook_link']) ) ? sanitize_text_field($new_instance['faccebook_link']) : '';
            $instance['twitter_link']	= (!empty($new_instance['twitter_link']) ) ? sanitize_text_field($new_instance['twitter_link']) : '';
            $instance['linkedin_link']	= (!empty($new_instance['linkedin_link']) ) ? sanitize_text_field($new_instance['linkedin_link']) : '';
            $instance['instagram_link']	= (!empty($new_instance['instagram_link']) ) ? sanitize_text_field($new_instance['instagram_link']) : '';
            $instance['pinterest_link']	= (!empty($new_instance['pinterest_link']) ) ? sanitize_text_field($new_instance['pinterest_link']) : '';
            $instance['tiktok_link']	= (!empty($new_instance['tiktok_link']) ) ? sanitize_text_field($new_instance['tiktok_link']) : '';
            $instance['youtube_link']	= (!empty($new_instance['youtube_link']) ) ? sanitize_text_field($new_instance['youtube_link']) : '';

            $instance['faccebook_label']	= (!empty($new_instance['faccebook_label']) ) ? sanitize_textarea_field($new_instance['faccebook_label']) : '';
            $instance['twitter_label']	    = (!empty($new_instance['twitter_label']) ) ? sanitize_textarea_field($new_instance['twitter_label']) : '';
            $instance['linkedin_label']	    = (!empty($new_instance['linkedin_label']) ) ? sanitize_textarea_field($new_instance['linkedin_label']) : '';
            $instance['instagram_label']	= (!empty($new_instance['instagram_label']) ) ? sanitize_textarea_field($new_instance['instagram_label']) : '';
            $instance['pinterest_label']	= (!empty($new_instance['pinterest_label']) ) ? sanitize_textarea_field($new_instance['pinterest_label']) : '';
            $instance['tiktok_label']	    = (!empty($new_instance['tiktok_label']) ) ? sanitize_textarea_field($new_instance['tiktok_label']) : '';
            $instance['youtube_label']	    = (!empty($new_instance['youtube_label']) ) ? sanitize_textarea_field($new_instance['youtube_label']) : '';

            return $instance;
        }

    }

}

//register widget
function taskbot_register_Apps_widgets() {
	register_widget( 'Taskbot_Apps' );
}
add_action( 'widgets_init', 'taskbot_register_Apps_widgets' );
