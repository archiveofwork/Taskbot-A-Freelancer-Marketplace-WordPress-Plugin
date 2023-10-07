<?php
/**
 * Dashboard insights
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/admin_dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user, $wp_roles, $userdata, $post;
$reference 		 = !empty($_GET['ref'] ) ? esc_html($_GET['ref']) : '';
$mode 			 = !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity 	 = intval($current_user->ID);
$id 			 = !empty($args['id']) ? intval($args['id']) : '';
$user_type		 = apply_filters('taskbot_get_user_type', $user_identity );

$total_tasks_arg	= array(
	array(
		'key'    		=> 'payment_type',
		'value'     	=> 'tasks',
		'compare'   	=> '=',
	  )
);

$total_tasks_count	= taskbot_get_post_count_by_meta('shop_order', array('wc-pending', 'wc-on-hold', 'wc-processing', 'wc-completed','wc-cancelled'), $total_tasks_arg);

$tasks_arg  = array(
	array(
	  'key'    		=> 'payment_type',
	  'value'     	=> 'tasks',
	  'compare'   	=> '=',
	)
);

$tasks_percentage	= taskbot_disppute_date_query_count('shop_order', array('wc-pending', 'wc-on-hold', 'wc-processing', 'wc-completed'),$tasks_arg);
$percentChange		= !empty($tasks_percentage['percentChange']) ? $tasks_percentage['percentChange'] : '0';
$change				= !empty($tasks_percentage['change']) ? $tasks_percentage['change'] : 'decrease';
$current_month		= !empty($tasks_percentage['current_month']) ? $tasks_percentage['current_month'] : 0;
$previous_month		= !empty($tasks_percentage['previous_month']) ? $tasks_percentage['previous_month'] : 0;

$total_posted			= !empty($total_tasks_count) ? $total_tasks_count	- ($previous_month+$current_month) :0;
$total_posted_array		= $total_posted.','.$previous_month.','.$current_month.','.$total_tasks_count;
$posted_string			= '"'.esc_html__('Start','taskbot').'","'.esc_html__('Last Month','taskbot').'","'.esc_html__('This month','taskbot').'","';
$total_posted_string	= $posted_string.esc_html__('Total posted tasks','taskbot').'"';
$change_class			= 'icon-chevron-left';
$changearrow_class		= 'icon-arrow-down';
$green_calss			= '';

if ($change == 'increase') {
	$green_calss		= 'fr-goodresult';
	$change_class		= 'icon-chevron-right';
	$changearrow_class	= 'icon-arrow-up';
}

$ongoing_arg  = array(
	array(
		'key'    		=> 'payment_type',
		'value'     	=> 'tasks',
		'compare'   	=> '=',
	),
	array(
		'key'    		=> '_task_status',
		'value'     	=> 'hired',
		'compare'   	=> '=',
	  )
);

$ongoing_tasks_count	= taskbot_get_post_count_by_meta('shop_order', array('wc-pending', 'wc-on-hold', 'wc-processing', 'wc-completed'), $ongoing_arg);
$ongoing_tasks_arg  = array(
	array(
	  'key'    		=> 'payment_type',
	  'value'     	=> 'tasks',
	  'compare'   	=> '=',
	),
	array(
		'key'    		=> '_task_status',
		'value'     	=> 'hired',
		'compare'   	=> '=',
	  )
  );
$ongoing_tasks_percentage	= taskbot_disppute_date_query_count('shop_order', array('wc-pending', 'wc-on-hold', 'wc-processing', 'wc-completed'),$ongoing_tasks_arg);
$ongoningpercentChange		= !empty($ongoing_tasks_percentage['percentChange']) ? $ongoing_tasks_percentage['percentChange'] : '0';
$ongoningchange				= !empty($ongoing_tasks_percentage['change']) ? $ongoing_tasks_percentage['change'] : 'decrease';
$ongoningcurrent_month		= !empty($ongoing_tasks_percentage['current_month']) ? $ongoing_tasks_percentage['current_month'] : 0;
$ongoningprevious_month		= !empty($ongoing_tasks_percentage['previous_month']) ? $ongoing_tasks_percentage['previous_month'] : 0;

$totalongoning_posted			= !empty($ongoing_tasks_count) ? $ongoing_tasks_count	- ($ongoningprevious_month+$ongoningcurrent_month) :0;
$ongoningtotal_posted_array		= $totalongoning_posted.','.$ongoningprevious_month.','.$ongoningcurrent_month.','.$ongoing_tasks_count;
$ongoningtotal_posted_string	= $posted_string.esc_html__('Total Ongoing tasks','taskbot').'"';

$ongoningchange_class		= 'icon-chevron-left';
$ongoningchangearrow_class	= 'icon-arrow-down';
$ongoninggreen_calss		= '';

if ($ongoningchange == 'increase') {
	$ongoninggreen_calss		= 'fr-goodresult';
	$ongoningchange_class		= 'icon-chevron-right';
	$ongoningchangearrow_class	= 'icon-arrow-up';
}

$cancelled_arg  = array(
	array(
		'key'    		=> 'payment_type',
		'value'     	=> 'tasks',
		'compare'   	=> '=',
	),
	array(
		'key'    		=> '_task_status',
		'value'     	=> 'cancelled',
		'compare'   	=> '=',
	  )
);
$cancelled_tasks_count    = taskbot_get_post_count_by_meta('shop_order', array('wc-pending', 'wc-on-hold', 'wc-processing', 'wc-completed','wc-cancelled'), $cancelled_arg);
$cancelled_tasks_arg  = array(
	array(
	  'key'    		=> 'payment_type',
	  'value'     	=> 'tasks',
	  'compare'   	=> '=',
	),
	array(
		'key'    		=> '_task_status',
		'value'     	=> 'cancelled',
		'compare'   	=> '=',
	  )
  );

$cancelled_tasks_percentage	= taskbot_disppute_date_query_count('shop_order', array('wc-pending', 'wc-on-hold', 'wc-processing', 'wc-completed','wc-cancelled'),$cancelled_tasks_arg);
$cancelledpercentChange		= !empty($cancelled_tasks_percentage['percentChange']) ? $cancelled_tasks_percentage['percentChange'] : '0';
$cancelledchange			= !empty($cancelled_tasks_percentage['change']) ? $cancelled_tasks_percentage['change'] : 'decrease';
$cancelledcurrent_month		= !empty($cancelled_tasks_percentage['current_month']) ? $cancelled_tasks_percentage['current_month'] : 0;
$cancelledprevious_month	= !empty($cancelled_tasks_percentage['previous_month']) ? $cancelled_tasks_percentage['previous_month'] : 0;

$totalcancelled_posted				= !empty($cancelled_tasks_count) ? $cancelled_tasks_count	- ($cancelledprevious_month+$cancelledcurrent_month) :0;
$cancelledtotal_posted_array		= $totalcancelled_posted.','.$cancelledprevious_month.','.$cancelledcurrent_month.','.$cancelled_tasks_count;
$cancelledtotal_posted_string		= $posted_string.esc_html__('Total ongoing tasks','taskbot').'"';
$cancelledchange_class		= 'icon-chevron-left';
$cancelledchangearrow_class	= 'icon-arrow-down';
$cancelledgreen_calss		= '';

if ($cancelledchange == 'increase') {
	$cancelledgreen_calss		= 'fr-goodresult';
	$cancelledchange_class		= 'icon-chevron-right';
	$cancelledchangearrow_class	= 'icon-arrow-up';
}
?>
<div class="col-xl-4 tb-chartboxholder">
	<div class="tb-dbholder">
		<div class="tb-dbbox">
			<span class="tb-bar"></span>
			<div class="tb-chartbox">
				<div class="tb-chartsingle">
					<div class="chart-area"></div>
				</div>
				<div class="tb-chartbox__text">
					<h3 class="tb-chartbox__title"><?php echo intval($total_tasks_count);?></h3>
					<h6><?php esc_html_e('Total orders','taskbot');?></h6>
					<span><?php echo sprintf(esc_html__('%s this month','taskbot'),$current_month);?> </span>
					<em class="<?php echo esc_attr($green_calss);?>"><i class="<?php echo esc_attr($changearrow_class); ?>"></i> <?php echo esc_html($percentChange); ?>% <i class="<?php echo esc_attr($change_class); ?> tb-charticon"></i> <?php esc_html_e('last month','taskbot');?></em>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-xl-4 tb-chartboxholder">
	<div class="tb-dbholder">
		<div class="tb-dbbox">
			<span class="tb-bar"></span>
			<div class="tb-chartbox">
				<div class="tb-chartsingle">
					<div class="chart-area-ongoing"></div>
				</div>
				<div class="tb-chartbox__text">
					<h3 class="tb-chartbox__title"><?php echo intval($ongoing_tasks_count);?></h3>
					<h6><?php esc_html_e('Total ongoing tasks','taskbot');?></h6>
					<span><?php echo sprintf(esc_html__('%s this month','taskbot'),$ongoningcurrent_month);?> </span>
					<em class="<?php echo esc_attr($ongoninggreen_calss);?>"><i class="<?php echo esc_attr($ongoningchangearrow_class); ?>"></i> <?php echo esc_html($ongoningpercentChange); ?>% <i class="<?php echo esc_attr($ongoningchange_class); ?> tb-charticon"></i> <?php esc_html_e('last month','taskbot');?></em>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-xl-4 tb-chartboxholder">
	<div class="tb-dbholder">
		<div class="tb-dbbox">
			<span class="tb-bar"></span>
			<div class="tb-chartbox">
				<div class="tb-chartsingle">
					<div class="chart-area-cancelled"></div>
				</div>
				<div class="tb-chartbox__text">
					<h3 class="tb-chartbox__title"><?php echo intval($cancelled_tasks_count);?></h3>
					<h6><?php esc_html_e('Total cancelled tasks','taskbot');?></h6>
					<span><?php echo sprintf(esc_html__('%s this month','taskbot'),$cancelledcurrent_month);?> </span>
					<em class="<?php echo esc_attr($cancelledgreen_calss);?>"><i class="<?php echo esc_attr($cancelledchangearrow_class); ?>"></i> <?php echo esc_html($cancelledpercentChange); ?>% <i class="<?php echo esc_attr($cancelledchange_class); ?> tb-charticon"></i> <?php esc_html_e('last month','taskbot');?></em>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
"use strict";
jQuery(document).ready(function(){
	window.addEventListener('load', (event) =>{
		function createChartConfig(items, data) {
			return {
				type: 'line',
				data: {
					labels: items.labels,
					datasets: [{
						steppedLine:false,
						data: data,
						borderColor: items.color,
						fill: false,
						cubicInterpolationMode: 'monotone',
					}]
				},
				options: {
					responsive: true,
					animation:{
						duration:2500,
						easing:'linear',
					},
					title: {
						display: false,
					},
					plugins:{
						legend: {display: false},
						tooltip: {
							displayColors:false,
							padding:{
								x:15,
								top:15,
								bottom:9,
							},
							borderColor:'#eee',
							borderWidth:1,
							titleColor: '#353648',
							bodyColor: '#353648',
							bodySpacing: 6,
							titleMarginBottom: 9,
							backgroundColor:'rgba(255, 255, 255)',
						},
					},
					scales: {
						y: {
							ticks: {display: false}
						},
						x: {
							display: false,
						}
					}
				}
			};
		}
		var charData = [{
			labels: [<?php echo do_shortcode($total_posted_string);?>],
			container:document.querySelector('.chart-area'),
			steppedLine: false,
			color: window.chartColors.blue,
			data:[<?php echo do_shortcode($total_posted_array);?>],
		},{
			labels: [<?php echo do_shortcode($ongoningtotal_posted_string);?>],
			container:document.querySelector('.chart-area-ongoing'),
			steppedLine: false,
			color: window.chartColors.blue,
			data:[<?php echo do_shortcode($ongoningtotal_posted_array);?>]
		},{
			labels: [<?php echo do_shortcode($cancelledtotal_posted_string);?>],
			container:document.querySelector('.chart-area-cancelled'),
			steppedLine: false,
			color: window.chartColors.blue,
			data:[<?php echo do_shortcode($cancelledtotal_posted_array);?>]
		}];
		charData.forEach(function(items) {
			var div = document.createElement('div');
			div.classList.add('chart-container');
			var canvas = document.createElement('canvas');
			div.appendChild(canvas);
			items.container.appendChild(div);
			var ctx = canvas.getContext('2d');
			var config = createChartConfig(items, items.data);
			new Chart(ctx, config);
		});	
	})
})
</script>