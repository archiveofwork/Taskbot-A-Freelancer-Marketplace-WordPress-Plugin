<?php
// die if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 
 * Display FAQ list item
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/products_data
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */
?>
<tr>
	<td class="sort"></td>
	<td class="file_name">
		<input type="text" name="faq[<?php echo esc_attr($key);?>][question]" value="<?php echo esc_attr($taskbot_faq['question']);?>" class="form-control" placeholder="<?php esc_attr_e('Enter question here', 'taskbot');?>" autocomplete="off">
	</td>
	<td class="file_url">
		<textarea class="form-control" name="faq[<?php echo esc_attr($key);?>][answer]" placeholder="<?php esc_attr_e('Enter description', 'taskbot');?>"><?php echo esc_html($taskbot_faq['answer']);?></textarea>
	</td>
	<td class="file_url_choose" width="1%"></td>
	<td width="1%"><a href="javascript:void(0);" class="delete"><?php esc_html_e( 'Delete', 'taskbot' ); ?></a></td>
</tr>
