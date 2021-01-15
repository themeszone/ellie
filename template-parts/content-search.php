<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ellie
 */

?>

<?php do_action( TZ_THEME_PREFIX.'_before_post', get_post_format(get_the_ID()), is_sticky(get_the_ID()) ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
            <div class="entry-meta">
				<?php
				ellie_posted_on();
				ellie_posted_by();
				?>
            </div><!-- .entry-meta -->
		<?php endif; ?>
    </header><!-- .entry-header -->

	<?php ellie_post_thumbnail(); ?>

    <div class="entry-summary">
		<?php the_excerpt(); ?>
    </div><!-- .entry-summary -->

    <footer class="entry-footer">
		<?php ellie_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
<?php do_action( TZ_THEME_PREFIX.'_after_post' ); ?>