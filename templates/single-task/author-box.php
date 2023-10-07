<?php
/**
 * Single task author details
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public
 */
global $post;
$post_author				= get_post_field( 'post_author', $post);
$taskbot_args               = array();
$taskbot_args['post_id']    = !empty($post_author) ? taskbot_get_linked_profile_id($post_author,'','sellers') :'';
taskbot_get_template( 'single-seller/profile-basic.php',$taskbot_args);
