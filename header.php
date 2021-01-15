<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ellie
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( TZ_THEME_PREFIX.'_before_page' ); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ellie' ); ?></a>
<?php do_action( TZ_THEME_PREFIX.'_before_header' ); ?>
    <header id="masthead" class="site-header">
        <?php do_action( TZ_THEME_PREFIX.'_before_header_content' ); ?>
	    <?php if ( false == get_theme_mod('menu_position', false) ) : ?>
		    <?php ellie_site_branding(); ?>
		    <?php do_action( TZ_THEME_PREFIX.'_after_logo' ); ?>
		    <?php do_action( TZ_THEME_PREFIX.'_after_header_content' ); ?>
	    <?php endif; ?>
		<nav id="site-navigation" class="main-navigation">
            <?php if ( true == get_theme_mod('menu_position', false) ) : ?>
            <?php ellie_site_branding(); ?>
			<?php do_action( TZ_THEME_PREFIX.'_after_logo' ); ?>
            <?php endif; ?>
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'ellie' ); ?></button>
			<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-main',
					'menu_id'        => 'primary-menu',
				) );
			?>
		</nav><!-- #site-navigation -->
    <?php if ( true == get_theme_mod('menu_position', false) ) : ?>
        <?php do_action( TZ_THEME_PREFIX.'_after_header_content' ); ?>
    <?php endif; ?>
	</header><!-- #masthead -->
<?php do_action( TZ_THEME_PREFIX.'_after_header' ); ?>
<?php do_action( TZ_THEME_PREFIX.'_between_header_content' ); ?>
	<div id="content" class="site-content">
        <?php do_action( TZ_THEME_PREFIX.'_before_site_content' ); ?>