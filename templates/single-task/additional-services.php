<?php
/**
 * Single sub task
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public
 */
$max_services   = 6;
$total_services = !empty($taskbot_subtask) && is_array($taskbot_subtask) ? count($taskbot_subtask) : 0;
if(!empty($taskbot_subtask)){?>
<div class="tb-singleservice-tile">
    <div class="tk-addiservicesinfo">
        <div class="tk-addiservicesinfo_title">
            <h4><?php esc_html_e('Additional services', 'taskbot');?></h4>
        </div>
        <ul class="tb-additionalservices">
            <?php 
                $counter    = 0;
                foreach($taskbot_subtask as $taskbot_subtask_id){
                    $counter++;
                    $price      = get_post_meta( $taskbot_subtask_id, '_regular_price', true);
                    $li_class   = !empty($counter) && $counter > $max_services ? 'd-none' : 'tk-add-services';
                ?>
                <li class="<?php echo esc_attr($li_class);?>">
                    <div class="tb-additionalservices__content">
                        <div class="tb-additionalservices-title">
                            <h6><?php echo esc_html(get_the_title($taskbot_subtask_id));?></h6>
                            <?php echo apply_filters( 'the_content', get_the_content(null, false, $taskbot_subtask_id));?>                        
                        </div>
                        <div class="tb-additionalservice-price">
                            <h5><?php taskbot_price_format($price);?></h5>
                        </div>
                    </div>
                </li>
            <?php }?>
            <?php if( !empty($total_services) && $total_services > $max_services ){ ?>
                <li class="tk-ad-load-more">
                    <div class="tb-selected__showmore">
                        <a href="javascript:void(0);"><?php esc_html_e('Load more','taskbot');?></a>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php }