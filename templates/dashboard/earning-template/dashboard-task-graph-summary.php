<?php
/**
 * The template part for displaying the dashboard Task graph summary for seller
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard/earning_template
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global $current_user;
$user_identity    = intval($current_user->ID);

if ( !class_exists('WooCommerce') ) {
	return;
}

$meta_array	= array(
    array(
      'key'         => 'seller_id',
      'value'   	=> $user_identity,
      'compare' 	=> '=',
      'type' 		=> 'NUMERIC'
    ),
    array(
      'key'		    => '_task_status',
      'value'   	=> 'completed',
      'compare' 	=> '=',
    ),
    array(
      'key'         => 'payment_type',
      'value'   	=> 'tasks',
      'compare' 	=> '=',
    )
);

$completed_tasks  = taskbot_tasks_earnings('shop_order',array('wc-completed'),$meta_array);
$graph_keys       = !empty($completed_tasks['key']) ? $completed_tasks['key'] : '';
$graph_values     = !empty($completed_tasks['values']) ? $completed_tasks['values'] : '';

wp_enqueue_script('chart');
wp_enqueue_script('utils-chart');

$currency_symbol  = get_woocommerce_currency_symbol();
?>
<div class="col-lg-8">
    <div class="tb-buyercontainer">
        <div class="tb-tabfilter">
            <div class="tb-tabfiltertitle">
                <h5><?php esc_html_e('Earning history', 'taskbot'); ?></h5>
            </div>
        </div>
        <div class="tb-tabfilteritem">
            <canvas id="canvaschart" class="tb-linechart"></canvas>
        </div>
    </div>
</div>
<?php
$script = "
window.addEventListener('load', (event) =>{
  var activity = document.getElementById('canvaschart');
  if (activity !== null) {
  activity.height = 100;
  var config = {
    type: 'line',
    data: {
      labels: [".do_shortcode( $graph_keys )."],
      datasets: [{
        pointBackgroundColor: window.chartColors.dark_blue,
        backgroundColor: 'rgba(0,117,214,0.03)',
        borderColor: window.chartColors.dark_blue,
        borderWidth: 1,
        fill: true,
        pointBorderColor: '#ffffff',
        pointHoverBackgroundColor: '#fad85a',
        data: [".do_shortcode( $graph_values )."],
      }]
    },
    options: {
      responsive: true,
      title:false,

      position: 'nearest',
      animation:{
        duration:1000,
        easing:'linear',
        delay: 1500,
      },
      interaction: {
        intersect: false,
        mode: 'point',
        },
      font: {
        family: 'Nunito'
      },
      plugins: {
        filler: {
        propagate: false,
        },
        tooltip: {
          yAlign: 'bottom',
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
          callbacks: {
            title: function(context){
              return '".esc_html__('Earning:','taskbot')."'
            },
            label: function(context){
              return '".html_entity_decode($currency_symbol)."' + context.dataset.data[context.dataIndex]
            }
          }
        },
        legend:{
          display:false,
        },
      },
      elements: {
        line: {
        tension: 0.000001
        },
      },
      scales: {
        y:{
          ticks: {
          fontSize: 12, fontFamily: '', fontColor: '#000', fontStyle: '500',
          beginAtZero: true,
          callback: function(value, index, values) {
          if(parseInt(value) >= 1000){
            return '".html_entity_decode($currency_symbol)."' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
          } else {
            return '".html_entity_decode($currency_symbol)."' + value;
              }
            }
          }
        },
        x:{
        ticks: {fontSize: 12, fontFamily: '', fontColor: '#000', fontStyle: '500'},
        grid:{
            display : false
          }
        }
      },
      },
    }
    var ctx = document.getElementById('canvaschart').getContext('2d');

    var myLine = new Chart(ctx, config);
  };
})";
wp_add_inline_script( 'utils-chart', $script, 'after' );
