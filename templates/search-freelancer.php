<?php
/**
 *
 * Template Name: Search freelancers
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
$search_view = 'seller_search_view1';
if (isset($search_view) && $search_view === 'seller_search_view1') {
  include plugin_dir_path(__FILE__) . '/search-seller/search-seller.php';
}