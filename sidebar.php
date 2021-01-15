<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ellie
 */

if ( ! is_active_sidebar( Ellie_Controller::instance()->get_page_sidebar_tag() ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( Ellie_Controller::instance()->get_page_sidebar_tag() ); ?>
</aside><!-- #secondary -->
