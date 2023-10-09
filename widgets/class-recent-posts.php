<?php
/**
 * Recent posts widget 
 *
 * @since      1.0.0
 *
 * @package    Taskup
 * @subpackage Taskup/widgets
 */

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

if (!class_exists('Taskup_Recent_Posts')) {

    class Taskup_Recent_Posts extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {

            parent::__construct(
                'taskup_recent_posts' , // Base ID
                esc_html__('Recent post | Taskup' , 'taskbot') , // Name
                array (
                	'classname' 	=> '',
					'description' 	=> esc_html__('Blog posts' , 'taskbot') ,
				) // Args
            );
        }

        /**
         * Outputs the content of the widget
         *
         * @param array $args
         * @param array $instance
        */
        public function widget( $args, $instance) {
            extract($instance);
            $title          = !empty($instance['title']) ? ($instance['title']) : '';
            $link           = !empty($instance['link']) ? ($instance['link']) : '';
            $no_posts       = !empty($instance['no_posts']) ? ($instance['no_posts']) : 5;
            $before		    = ($args['before_widget']);
			$after	 	    = ($args['after_widget']);
            echo do_shortcode($before);
            
            $args   = array(
                'numberposts'   => $no_posts,
            );

            $recent_posts   = wp_get_recent_posts($args);
            ?>
            <div class="tu-recentposts" id="project_skill_search">
                <?php if(!empty($title)){?>
                    <h5><?php echo esc_html($title)?></h5>
                <?php } ?>
                <ul class="tu-recentposts_list">
                    <?php 
                    foreach( $recent_posts as $recent ) {
                        $post_ID            = $recent['ID'];
                        $post_thumbnail_id  = get_post_thumbnail_id( $post_ID );
                        $thumbnail_url      = wp_get_attachment_image_url( $post_thumbnail_id, 'taskbot_post_thumbnail' );
                        $post_title         = get_the_title($post_ID);
                        $post_date_month    = date_i18n('M', strtotime(get_the_date()));
                        $post_date_date     = date_i18n('d', strtotime(get_the_date()));
                        ?>
                        <li>  
                            <div class="tu-recentposts_info">
                                <?php if(!empty($thumbnail_url)){?>
                                    <figure>
                                        <a href="<?php echo esc_url( get_permalink($post_ID)); ?>">
                                            <img src="<?php echo esc_url($thumbnail_url);?>" alt="<?php echo esc_attr($post_title);?>">
                                        </a>
                                        <span class="date-and-month"><?php echo esc_attr($post_date_month)?><em><?php echo esc_attr($post_date_date)?></em></span>
                                    </figure>
                                <?php } ?>
                                <?php if(!empty($post_title) ){?>
                                    <div class="tu-recentposts_title">
                                        <?php if(!empty($post_title)){?>
                                            <a href="<?php echo esc_url( get_permalink($post_ID)); ?>"><h6><?php echo esc_html($post_title)?></h6></a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php echo get_the_term_list($post_ID, 'category', '<ul class="tk-taglinks tk-taglinksm"><li>', '</li><li>', '</li></ul>'); ?>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php if(!empty($link)){
                    echo '<div class="show-more"> <a href="'.$link.'" class="tb-readmorebtn" ">'.esc_attr__('Show more', 'taskbot').'</a></div>';
                }?>
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
            $title      = !empty($instance['title']) ? ($instance['title']) : esc_html__('Recent posts', 'taskbot');
            $link       = !empty($instance['link']) ? ($instance['link']) : '';
            $no_posts   = !empty($instance['no_posts']) ? ($instance['no_posts']) : '5';
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('link') ); ?>"><?php esc_html_e('Link','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('link') ); ?>" type="text" value="<?php echo esc_attr($link); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('no_posts') ); ?>"><?php esc_html_e('No of posts','taskbot'); ?></label>
                <input class="widefat"  name="<?php echo esc_attr( $this->get_field_name('no_posts') ); ?>" type="text" value="<?php echo intval($no_posts); ?>">
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
            $instance               = $old_instance;
            $instance['title']	    = (!empty($new_instance['title']) ) ? sanitize_text_field($new_instance['title']) : '';
            $instance['link']	    = (!empty($new_instance['link']) ) ? sanitize_text_field($new_instance['link']) : '';
            $instance['no_posts']	= (!empty($new_instance['no_posts']) ) ? sanitize_text_field($new_instance['no_posts']) : '';
            return $instance;
        }
    }
}

//register widget
function taskup_recent_post_widgets() {
	register_widget( 'Taskup_Recent_Posts' );
}
add_action( 'widgets_init', 'taskup_recent_post_widgets' );
