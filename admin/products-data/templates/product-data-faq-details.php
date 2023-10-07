<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 
 * Template to display faqs
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/products_data
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */

global $woocommerce, $post;
$taskbot_faq_meta = array_filter( (array) get_post_meta($post->ID, 'taskbot_service_faqs', true) );
?>
<div class="options_group">
	<?php do_action( 'taskbot_woocommerce_product_options_faqs_before' ); ?>
		<div class="form-field downloadable_files faq-data">
			<label><?php esc_html_e( 'FAQ\'s', 'taskbot' ); ?></label>
			<table class="widefat">
				<thead>
					<tr>
						<th class="sort">&nbsp;</th>
						<th><?php esc_html_e( 'Question', 'taskbot' ); ?> <?php echo wc_help_tip( esc_html__( 'This is the name of the videos shown to the customer.', 'taskbot' ) ); ?></th>
						<th colspan="2"><?php esc_html_e( 'Answer', 'taskbot' ); ?> <?php echo wc_help_tip( esc_html__( 'This is the URL or absolute path to the file which customers will get access to. URLs entered here should already be encoded.', 'taskbot' ) ); ?></th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>                
					<?php
					$video_files = array();                   
					if ( $taskbot_faq_meta ) {
						foreach ( $taskbot_faq_meta as $key => $taskbot_faq ) {
							include __DIR__ . '/html-product-faq.php';
						}
					}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="5">
							<a href="javascript:void(0);" class="button faq-insert " ><?php esc_html_e( 'Add FAQ', 'taskbot' ); ?></a>
						</th>
					</tr>
				</tfoot>
			</table>
		</div>
	<?php do_action( 'taskbot_woocommerce_product_options_faqs_after' );?>
</div>
<script type="text/template" id="tmpl-load-faq-tr">
	<tr>
		<td class="sort"></td>
		<td class="file_name">
			<input type="text" name="faq[{{data.key}}][question]" value="" class="form-control" placeholder="<?php esc_attr_e('Enter question here', 'taskbot');?>" autocomplete="off">
		</td>
		<td class="file_url">
			<textarea class="form-control" name="faq[{{data.key}}][answer]" placeholder="<?php esc_attr_e('Enter description', 'taskbot');?>"></textarea>
		</td>
		<td class="file_url_choose" width="1%"></td>
		<td width="1%">
			<a href="javascript:void(0);" class="delete">
				<?php esc_html_e( 'Delete', 'taskbot' ); ?>
			</a>
		</td>
	</tr>
</script>
