<?php
/**
 * User dashboard header
 *
 * @link       https://codecanyon.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Taskbot
 * @subpackage Taskbot_/public
 */

?>
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php if ( ! current_theme_supports( 'title-tag' ) ) : ?>
		<title><?php echo wp_get_document_title(); ?></title>
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}

	$main_class	= '';
	if( is_page_template( 'templates/add-task.php') || is_page_template( 'templates/add-offer.php') ){
		$theme_version 		= wp_get_theme();
		if(!empty($theme_version->get( 'TextDomain' )) && ( $theme_version->get( 'TextDomain' ) === 'taskon' || $theme_version->get( 'TextDomain' ) === 'taskon-child' )){
			$main_class			= 'taskon-main-wrapper tk-lightest_bg';
		} else if(!empty($theme_version->get( 'TextDomain' )) && ( $theme_version->get( 'TextDomain' ) === 'taskup' || $theme_version->get( 'TextDomain' ) === 'taskup-child' )){
			$main_class			= 'taskup-main-wrapper tk-lightest_bg';
		}
	} ?>
	<div id="tb-wrapper" class="tb-wrapper at-haslayout">
		<?php do_action('taskbot_process_headers'); ?>
		<?php do_action('taskbot_do_process_titlebar');?>
		<main class="tb-main overflow-hidden <?php echo esc_attr($main_class);?>">

