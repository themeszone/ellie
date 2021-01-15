<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 07/02/2018
 * Time: 15:11
 */

if ( ! function_exists( 'ellie_site_branding' ) ) :

	/**
	 * Displays Site Branding section in header
	 */

	function ellie_site_branding(){
		?>
		<div class="site-branding">
			<?php

			    the_custom_logo();

                if ( is_front_page() && is_home() ) : ?>
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php else : ?>
                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                <?php
                endif;
                $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) : ?>
                    <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                <?php
                endif;

            ?>
		</div><!-- .site-branding -->
		<?php
	}

endif;