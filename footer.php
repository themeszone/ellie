<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ellie
 */

?>
    <?php do_action( TZ_THEME_PREFIX.'_after_site_content' ); ?>
	</div><!-- #content -->
    <?php do_action( TZ_THEME_PREFIX.'_before_footer' ); ?>
	<footer id="colophon" class="site-footer">
		<?php do_action( TZ_THEME_PREFIX.'_before_site_info' ); ?>
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'ellie' ) ); ?>"><?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'ellie' ), 'WordPress' );
			?></a>
			<span class="sep"> | </span>
			<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'ellie' ), '<b>ELLIE</b>', '<a href="https://themes.zone">Themes Zone</a>' );
			?>
		</div><!-- .site-info -->
		<?php do_action( TZ_THEME_PREFIX.'_after_site_info' ); ?>
	</footer><!-- #colophon -->
    <?php do_action( TZ_THEME_PREFIX.'_after_footer' ); ?>
</div><!-- #page -->
<?php do_action( TZ_THEME_PREFIX.'_after_page' );?>

<?php wp_footer(); ?>

</body>
</html>
