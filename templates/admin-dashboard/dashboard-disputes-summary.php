<?php
/**
 * Dispute listings summary
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/admin_dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

$dispute_posts_count	= wp_count_posts('disputes');
$count_disputes			= taskbot_get_post_count_by_meta('disputes',array('disputed','resolved','refunded'));
$count_resolved			= taskbot_get_post_count_by_meta('disputes',array('resolved','refunded'));
$count_disputed			= taskbot_get_post_count_by_meta('disputes',array('disputed'));
$posts_count			= $dispute_posts_count;
$posts_count 			=  (array) $posts_count;
unset($posts_count['trash']);

$total_posts		= array_sum($posts_count);
$dispute_percentage	= taskbot_disppute_date_query_count('disputes');
$percentChange		= !empty($dispute_percentage['percentChange']) ? $dispute_percentage['percentChange'] : '0';
$change				= !empty($dispute_percentage['change']) ? $dispute_percentage['change'] : 'decrease';
$change_class		= 'icon-chevron-left';
$changearrow_class	= 'icon-arrow-down';

if ($change == 'increase') {
	$change_class		= 'icon-chevron-right';
	$changearrow_class	= 'icon-arrow-up';
}
?>
<div class="tb-admindispute">
	<h2> <?php echo sprintf(_n('%s Dispute', '%s Disputes', $count_disputes, 'taskbot'), $count_disputes); ?> <span></span></h2>
	<h6><?php esc_html_e('Total disputes in queue till now', 'taskbot'); ?></h6>
</div>
<?php do_action('taskbot_dispute_report_display');?>
<ul class="tb-totaldistupes">
	<li>
		<div class="tb-disputesicons">
			<figure>
				<img src="<?php echo esc_url(TASKBOT_DIRECTORY_URI . 'admin-dashboard/images/disputes/img-02.png'); ?>" alt="">
			</figure>
			<div class="tb-disputecount">
				<h5><?php echo intval($count_disputed); ?></h5>
				<h6><?php esc_html_e('New disputes', 'taskbot'); ?></h6>
			</div>
		</div>
	</li>
	<li>
		<div class="tb-disputesicons">
			<figure>
				<img src="<?php echo esc_url(TASKBOT_DIRECTORY_URI . 'admin-dashboard/images/disputes/img-03.png'); ?>" alt="<?php echo esc_attr('img-dispute') ?>">
			</figure>
			<div class="tb-disputecount">
				<h5><?php echo intval($count_resolved); ?></h5>
				<h6><?php esc_html_e('Total resolved disputes', 'taskbot'); ?></h6>
			</div>
		</div>
	</li>
</ul>