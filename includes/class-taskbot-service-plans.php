<?php

/**
 *
 * Class 'Taskbot_Service_Plans' defines task plans
 * 
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package     Taskbot
 * @subpackage  Taskbot/includes
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

if (!class_exists('Taskbot_Service_Plans')){
    
    class Taskbot_Service_Plans{
  
        private static $instance = null;

        public function __construct(){
           
        }

        /**
         * Returns the *Singleton* instance of this class.
         *
         * @return
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         */
        public static function getInstance(){

            if (self::$instance==null){
                self::$instance = new Taskbot_Service_Plans();
            }
            return self::$instance;
        }

        /**
         * @ Default task plans
         * @return
        */
        public static function service_plans(){
            global $taskbot_settings;
		    $remove_price_plans		= !empty($taskbot_settings['remove_price_plans']) ? $taskbot_settings['remove_price_plans'] : 'no';

            $taskbot_service_plans = array(
                'basic' => array(
                    'title' => array(
                        'id'            => 'title',
                        'label'         => esc_html__('Package title', 'taskbot'),
                        'type'          =>'text',
                        'value'         => '',
                        'class'         => 'title',
                        'placeholder'   => esc_html__('Add title', 'taskbot'),
                        'title'         => esc_html__('Please enter title', 'taskbot'),
                        'required'      => true,
                    ),
                    'description'=> array(
                        'id'            => 'description',
                        'label'         => esc_html__('Description', 'taskbot'),
                        'type'          => 'textarea',
                        'default_value' => '',
                        'class'         =>'description',
                        'placeholder'   => esc_html__('Description', 'taskbot'),                        
                        'title'         => esc_html__('Please enter description', 'taskbot'),
                        'required'      => true,
                    ),
                    'price'=> array(
                        'id'            => 'price',
                        'label'         => esc_html__('Price', 'taskbot'),
                        'type'          => 'number',
                        'min'           => 0,
                        'max'           => 0,
                        'default_value' => '',
                        'class'         =>'price',
                        'placeholder'   => esc_html__('Price', 'taskbot'),
                        'title'         => esc_html__('Please enter price', 'taskbot'),
                        'required'      => true,
                        
                    ),
                    'delivery_time'=> array(
                        'id'            => 'delivery_time',
                        'label'         => esc_html__('Delivery time', 'taskbot'),
                        'type'          => 'terms_dropdwon',
                        'taxonomy'      => 'delivery_time',
                        'default_value' => '',
                        'class'         =>'delivery-time',
                        'placeholder'   => esc_html__('Delivery time', 'taskbot'),
                        'title'         => esc_html__('Please enter delivery time', 'taskbot'),
                        'required'      => true,
                    ), 
                    'featured_package'=> array(
                        'id'            => 'featured_package',
                        'label'         => esc_html__('Featured package', 'taskbot'),
                        'type'          => 'featured_package',
                        'default_value' => '',
                        'class'         =>'featured-package',
                        'placeholder'   => esc_html__('Featured package', 'taskbot'),
                        'title'         => esc_html__('Please select featured package', 'taskbot'),
                        'required'      => true,
                    ),                  
                ),            
                'premium' => array(
                    'title' => array(
                        'id'            => 'title',
                        'label'         => esc_html__('Package title', 'taskbot'),
                        'type'          => 'text',
                        'value'         => '',
                        'class'         => 'title',
                        'placeholder'   => esc_html__('Add title', 'taskbot'),
                        'title'         => esc_html__('Please enter title', 'taskbot'),
                        'required'      => true,
                    ),
                    'description'=> array(
                        'id'            => 'description',
                        'label'         => esc_html__('Description', 'taskbot'),
                        'type'          => 'textarea',
                        'default_value' => '',
                        'class'         =>'description',
                        'placeholder'   => esc_html__('Description', 'taskbot'),                        
                        'title'         => esc_html__('Please enter description', 'taskbot'),
                        'required'      => true,
                    ),
                    'price'=> array(
                        'id'            => 'price',
                        'label'         => esc_html__('Price', 'taskbot'),
                        'type'          => 'number',
                        'min'           => 0,
                        'max'           => 0,
                        'default_value' => '',
                        'class'         =>'price',
                        'placeholder'   => esc_html__('Price', 'taskbot'),
                        'title'         => esc_html__('Please enter price', 'taskbot'),
                        'required'      => true,
                    ),
                    'delivery_time'=> array(
                        'id'            => 'delivery_time',
                        'label'         => esc_html__('Delivery time', 'taskbot'),
                        'type'          => 'terms_dropdwon',
                        'taxonomy'      => 'delivery_time',
                        'default_value' => '',
                        'class'         =>'delivery-time',
                        'placeholder'   => esc_html__('Delivery time', 'taskbot'),
                        'title'         => esc_html__('Please enter delivery time', 'taskbot'),
                        'required'      => true,
                    ),      
                    'featured_package'=> array(
                        'id'            => 'featured_package',
                        'label'         => esc_html__('Featured package', 'taskbot'),
                        'type'          => 'featured_package',
                        'default_value' => '',
                        'class'         =>'featured-package',
                        'placeholder'   => esc_html__('Featured package', 'taskbot'),
                        'title'         => esc_html__('Please select featured package', 'taskbot'),
                        'required'      => true,
                    ),                
                ),
                'pro' => array(
                    'title' => array(
                        'id'            => 'title',   
                        'label'         => esc_html__('Package title', 'taskbot'),
                        'type'          => 'text',
                        'value'         => '',
                        'class'         => 'title',
                        'placeholder'   => esc_html__('Add title', 'taskbot'),
                        'title'         => esc_html__('Please enter title', 'taskbot'),
                        'required'      => true,
                    ),
                    'description'=> array(
                        'id'            => 'description',
                        'label'         => esc_html__('Description', 'taskbot'),
                        'type'          => 'textarea',
                        'default_value' => '',
                        'class'         => 'description',
                        'placeholder'   => esc_html__('Description', 'taskbot'),
                        'title'         => esc_html__('Please enter description', 'taskbot'),
                        'required'      => true,
                    ),
                    'price'=> array(
                        'id'            => 'price',
                        'label'         => esc_html__('Price', 'taskbot'),
                        'type'          => 'number',
                        'min'           => 0,
                        'max'           => 0,
                        'default_value' => '',
                        'class'         =>'price',
                        'placeholder'   => esc_html__('Price', 'taskbot'),
                        'title'         => esc_html__('Please enter price', 'taskbot'),
                        'required'      => true,
                    ),
                    'delivery_time'=> array(
                        'id'            => 'delivery_time',
                        'label'         => esc_html__('Delivery time', 'taskbot'),
                        'type'          => 'terms_dropdwon',
                        'taxonomy'      => 'delivery_time',
                        'default_value' => '',
                        'class'         =>'delivery-time',
                        'placeholder'   => esc_html__('Delivery time', 'taskbot'),
                        'title'         => esc_html__('Please delivery time', 'taskbot'),
                        'required'      => true,
                    ),
                    'featured_package'=> array(
                        'id'            => 'featured_package',
                        'label'         => esc_html__('Featured package', 'taskbot'),
                        'type'          => 'featured_package',
                        'default_value' => '',
                        'class'         =>'featured-package',
                        'placeholder'   => esc_html__('Featured package', 'taskbot'),
                        'title'         => esc_html__('Please select featured package', 'taskbot'),
                        'required'      => true,
                    ),   
                ),
            );
            
            if(!empty($remove_price_plans) && $remove_price_plans == 'yes'){
                unset( $taskbot_service_plans['premium'] );
                unset( $taskbot_service_plans['pro'] );
            }

            return apply_filters('taskbot_service_plans', $taskbot_service_plans);
        }
      
    }
}