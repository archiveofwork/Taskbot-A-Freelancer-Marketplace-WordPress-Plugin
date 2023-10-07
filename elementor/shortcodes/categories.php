<?php
/**
 * Shortcode
 *
 *
 * @package    Taskbot
 * @subpackage Taskbot/admin
 * @author     Amentotech <theamentotech@gmail.com>
 */

    namespace Elementor;

    if (!defined('ABSPATH')) {
    exit;
    }

    if (!class_exists('TaskbotCategories')) {
        class TaskbotCategories extends Widget_Base
        {

        /**
         *
         * @since    1.0.0
         * @access   static
         * @var      base
         */
        public function get_name(){
            return 'taskbot_element_categories';
        }

        /**
        *
        * @since    1.0.0
        * @access   static
        * @var      title
        */
        public function get_title(){
            return esc_html__('Product categories', 'taskbot');
        }

        /**
        *
        * @since    1.0.0
        * @access   public
        * @var      icon
        */
        public function get_icon(){
            return 'eicon-theme-builder';
        }

        /**
        *
        * @since    1.0.0
        * @access   public
        * @var      category of shortcode
        */
        public function get_categories(){
            return ['taskbot-elements'];
        }

        /**
        * Register category controls.
        * @since    1.0.0
        * @access   protected
        */
        protected function register_controls(){
            //Content
            $this->start_controls_section(
                'content_section',
                [
                    'label' => esc_html__('Content', 'taskbot'),
                    'tab'   => Controls_Manager::TAB_CONTENT,
                ]
            );
            $this->add_control(
                'layout_type',
                [
                    'type'      => Controls_Manager::SELECT2,
                    'label'     => esc_html__('layout type', 'taskbot'),
                    'desc'      => esc_html__('Select layout type', 'taskbot'),
                    'default'   => 'v1',
                    'options'   => [
                        'v1'   => esc_html__('V1', 'taskbot'),
                        'v2'  => esc_html__('V2', 'taskbot'),
                    ],
                ]
            );
            $this->end_controls_section();
        }

        /**
        * Render shortcode
        *
        * @since 1.0.0
        * @access protected
        */
        protected function render(){
            global $taskbot_settings;
            $settings       = $this->get_settings_for_display();
            $layout_type    = !empty($settings['layout_type']) ? $settings['layout_type'] : '';
           
            $flag 		    = rand(9999, 999999);
            $parent_cat     = !empty($_GET['parent_cat']) ? $_GET['parent_cat'] : "";
            $hide_cat       = !empty($taskbot_settings['hide_product_cat']) ? $taskbot_settings['hide_product_cat'] : array();
            $taskbot_args   = array(
                'hide_empty'    => false,
                'parent'        => 0
            );
            if( !empty($hide_cat) ){
                $taskbot_args['exclude']    = $hide_cat;
            }
            $categories         = get_terms('product_cat',$taskbot_args);
            $parent_name        = "";
            $task_search_url    = taskbot_get_page_uri('service_search_page');
            ?>
            <div class="container">
                <div class="row">
                    <?php if( !empty($layout_type) && $layout_type === 'v1' && !empty($categories)){?>
                        <div class="col-12 col-sm-4 col-md-3">
                            <aside>
                                <div class="tk-categoriestab">
                                    <h5><?php esc_html_e('Categories','taskbot');?></h5>
                                    <ul>
                                        <?php $counter  = 0;
                                            foreach($categories as $category){
                                                $counter++;
                                                $active_class  = '';
                                                if($counter == 1 && empty($parent_cat) ){
                                                $parent_cat      = $category->term_id;
                                                $parent_name     =  $category->name;
                                                $active_class    = 'class="tb-active"';
                                                } else if(!empty($parent_cat) && $parent_cat == $category->term_id ){
                                                    $parent_name     =  $category->name;
                                                    $active_class    = 'class="tb-active"';
                                                }  
                                                
                                            ?>
                                            <li <?php echo do_shortcode($active_class);?>><a href="?parent_cat=<?php echo esc_attr($category->term_id);?>"><?php echo esc_html($category->name);?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </aside>
                        </div>
                        <?php
                            $children       = get_terms( 'product_cat', array( 'parent' => $parent_cat, 'hide_empty' => false ) );
                            $child_items    = !empty($children) && is_array($children) ? count($children) : 0;
                        ?>
                        <div class="col-12 col-sm-8 col-md-9">
                            <div class="tk-category">
                                <div class="tk-category_title">
                                    <h5><?php esc_html_e('Start from the best category','taskbot');?></h5>
                                    <h3><?php echo sprintf(esc_html__('%s Items in "%s"','taskbot'),$child_items,$parent_name);?></h3>
                                </div>
                                <?php if( !empty($children) ){?>
                                    <div class="tk-category_list">
                                        <ul>
                                            <?php 
                                            $parent_cat = get_term($parent_cat,'product_cat');
                                            if(!empty($parent_cat)) {
                                                $task_search_url = !empty($parent_cat->slug) ? add_query_arg('category', esc_attr($parent_cat->slug), $task_search_url) : '#';
                                            }
                                            foreach($children as $child ){
                                                $image          = "";
                                                $thumbnail_id   = get_term_meta( $child->term_id, 'thumbnail_id', true );
                                                $image          = wp_get_attachment_image_url( $thumbnail_id,'taskbot_task_shortcode_thumbnail' ); 
                                                $task_cat_search_url    = '#';
                                                if(!empty($task_search_url)) {
                                                   $task_cat_search_url = !empty($child->slug) ? add_query_arg('sub_category', esc_attr($child->slug), $task_search_url) : '#';
                                                }
                                                ?>
                                                <li class="tk-category_item">
                                                    <?php if( !empty($image) ){?>
                                                        <figure class="tk-category_img">
                                                            <img src="<?php echo esc_url($image);?>" alt="<?php echo esc_attr($child->name);?>">
                                                        </figure>
                                                    <?php } ?>
                                                    <div class="tk-category_info">
                                                        <h5><a href="<?php echo esc_url($task_cat_search_url);?>"><?php echo esc_html($child->name);?></a></h5>
                                                        <span><?php echo sprintf(esc_html__('%s listings','taskbot'),$child->count);?></span>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } else if(!empty($layout_type) && $layout_type === 'v2' && !empty($categories)){?>
                        <div class="col-12">
                            <div class="tk-category tk-subcategory">
                                <div class="tk-category_title">
                                    <h3><?php esc_html_e('Explore categories','taskbot');?></h3>
                                </div>
                                <div class="tk-category_list">
                                    <ul>
                                        <?php
                                         foreach($categories as $category){
                                            $image         = "";
                                            $thumbnail_id   = get_term_meta( $category->term_id, 'thumbnail_id', true );
                                            $image          = wp_get_attachment_image_url( $thumbnail_id,'taskbot_task_shortcode_thumbnail' ); 
                                            $task_cat_search_url    = '#';
                                            if(!empty($task_search_url)) {
                                                $task_cat_search_url = !empty($category->slug) ? add_query_arg('category', esc_attr($category->slug), $task_search_url) : '#';
                                            }
                                            $children       = get_terms( 'product_cat', array( 'parent' => $category->term_id, 'hide_empty' => false ) );

                                        ?>
                                            <li class="tk-category_item">
                                                <?php if( !empty($image) ){?>
                                                    <figure class="tk-category_img">
                                                        <img src="<?php echo esc_url($image);?>" alt="<?php echo esc_attr($category->name);?>">
                                                    </figure>
                                                <?php } ?>
                                                <div class="tk-category_info">
                                                    <h6><a href="<?php echo esc_url($task_cat_search_url);?>"><?php echo esc_html($category->name);?></a></h6>
                                                    <?php
                                                        foreach($children as $child ){
                                                            $task_cat_child_url    = '';
                                                            if(!empty($task_cat_search_url)) {
                                                                $task_cat_child_url = !empty($child->slug) ? add_query_arg('sub_category', esc_attr($child->slug), $task_cat_search_url) : '#';
                                                            }
                                                        ?>
                                                        <a href="<?php echo esc_url($task_cat_child_url);?>"><?php echo esc_html($child->name);?></a>
                                                    <?php } ?>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <?php
            }
        }

        Plugin::instance()->widgets_manager->register(new TaskbotCategories);
    }
