<?php
/**
 *
 * The template used for displaying cart detail
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
 */

global $current_user;
$order_id               = !empty($_GET['id']) ? intval($_GET['id']) : 0;
/* taskbot plan Values */
$order_details          = get_post_meta($order_id, 'order_details', TRUE);
$acf_fields             = !empty($order_details['fields']) ? $order_details['fields'] : array();
$plan_key               = !empty($order_details['key']) ? $order_details['key'] : '';
$tb_custom_fields       = !empty($order_details['tb_custom_fields']) ? $order_details['tb_custom_fields'] : array();
if( !empty($tb_custom_fields) || !empty($acf_fields) ){
?>
<div class="tk-servicedetail">
    <div class="tk-box">
        <h4><?php esc_html_e('Features included', 'taskbot'); ?>:</h4>
        <ul class="tk-mainlist tk-mainlistvtwo">
            <?php
            foreach ($acf_fields as $acf_key => $acf_field) {
                $plan_value = !empty($acf_field['selected_val']) ? $acf_field['selected_val'] : '';
                
                if (!empty($acf_field['label'])) {
                    if (!empty($acf_field['type']) && in_array($acf_field['type'], array('text', 'textarea', 'number'))) {
                        echo do_shortcode('<li><span>' . esc_html($acf_field['label']) . '</span><em> (' . esc_html($plan_value) . ')</em></li>');
                    } else if (!empty($acf_field['type']) && $acf_field['type'] === 'url' && !empty($plan_value)) {
                        echo do_shortcode('<li><span>' . esc_html($acf_field['label']) . '</span><em><a href="' . esc_url($plan_value) . '" target="_blank"> (' . esc_html($plan_value) . ')</a></em></li>');
                    } else if (!empty($acf_field['type']) && $acf_field['type'] === 'email' && !empty($plan_value)) {
                        echo do_shortcode('<li><span>' . esc_html($acf_field['label']) . '</span><em><a href="mailto:' . esc_attr($plan_value) . '" target="_blank"> (' . esc_html($plan_value) . ')</a></em></li>');
                    } else if (!empty($acf_field['type']) && in_array($acf_field['type'], array('checkbox'))) {
                        $class = !empty($plan_value) && $plan_value === 'yes' ? 'tb-available' : 'tb-unavailable';
                        echo do_shortcode('<li class="' . esc_attr($class) . '"><span>' . esc_html($acf_field['label']) . '</span></li>');
                    }
                }
            }
            ?>
            <?php 
                if( !empty($tb_custom_fields)){
                    foreach($tb_custom_fields as $field_value){
                        if( !empty($field_value['title']) ){?>
                        <li>
                            <span><?php echo esc_html($field_value['title']); ?></span>
                            <em>(<?php echo esc_html($field_value[$plan_key]); ?>)</em>
                        </li>
            <?php   }
                }
            } 
            ?>
        </ul>
    </div>
</div>
<?php }
