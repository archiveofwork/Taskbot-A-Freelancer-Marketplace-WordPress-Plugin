<?php
/**
 * Single task task faq's
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public
 */

$product_id = $product->get_id();
$faqs_data = get_post_meta($product_id, 'taskbot_service_faqs', true);

if (is_array($faqs_data) && !empty($faqs_data)) {?>
    <div class="tb-singleservice-tile tk-detailsfaq">
        <div class="tb-sectiontitle tb-sectiontitlev2">
            <h4><?php esc_html_e('Fequently asked questions', 'taskbot'); ?></h4>
        </div>
        <div id="tb-accordion" class="tb-faq">        
            <?php if (is_array($faqs_data) && !empty($faqs_data)) {
                $count = 0;
                foreach ($faqs_data as $val) {
                    $count++;
                    $faq_expand = 'faq' . $count;
                    $expanded   = ($count == 1) ? esc_html__('true', 'taskbot') : 'false';
                    $tab_option = ($count == 1) ? esc_html__('show', 'taskbot') : '';
                    ?>
                    <div class="tb-faq__content">
                        <div class="tb-faq__title" role="list" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr($faq_expand); ?>" aria-expanded="<?php echo esc_attr($expanded); ?>">
                            <h6 class="tb-select"><?php echo esc_html($val['question']); ?></h6>
                        </div>
                        <div id="<?php echo esc_attr($faq_expand); ?>" class="collapse <?php echo esc_attr($tab_option);?>" data-bs-parent="#tb-accordion">
                            <div class="tb-sectiontitle tb-sectiontitlev2">
                                <p><?php echo esc_html($val['answer']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
    </div>
<?php }
