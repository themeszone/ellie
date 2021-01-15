<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package ellie
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function ellie_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'ellie_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function ellie_woocommerce_scripts() {
	wp_enqueue_style( 'ellie-woocommerce-style', get_template_directory_uri() . '/woocommerce.css' );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'ellie-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'ellie_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function ellie_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'ellie_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function ellie_woocommerce_products_per_page() {
	return get_theme_mod('products_per_page', '12');
}
add_filter( 'loop_shop_per_page', 'ellie_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function ellie_woocommerce_thumbnail_columns() {
	return get_theme_mod('products_thumbnail_columns', '4');
}
add_filter( 'woocommerce_product_thumbnails_columns', 'ellie_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function ellie_woocommerce_loop_columns() {
	return get_theme_mod('products_per_row', '3');
}
add_filter( 'loop_shop_columns', 'ellie_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function ellie_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => get_theme_mod('related_products_per_page', '4'),
		'columns'        => get_theme_mod('related_products_per_column', '4')
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'ellie_woocommerce_related_products_args' );

if ( ! function_exists( 'ellie_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function ellie_woocommerce_product_columns_wrapper() {
		$columns = ellie_woocommerce_loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'ellie_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'ellie_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function ellie_woocommerce_product_columns_wrapper_close() {
		echo '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop', 'ellie_woocommerce_product_columns_wrapper_close', 40 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'ellie_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function ellie_woocommerce_wrapper_before() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'ellie_woocommerce_wrapper_before' );

if ( ! function_exists( 'ellie_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function ellie_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'ellie_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'ellie_woocommerce_header_cart' ) ) {
			ellie_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'ellie_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function ellie_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		ellie_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'ellie_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'ellie_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function ellie_woocommerce_cart_link() {
		?>
			<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'ellie' ); ?>">
				<?php /* translators: number of items in the mini cart. */ ?>
				<?php
                    $item_count_text = sprintf(
                        /* translators: number of items in the mini cart. */
                        _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'ellie' ),
                        WC()->cart->get_cart_contents_count()
                    );
                    ?>
                	<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>

            </a>
		<?php
	}
}

if ( ! function_exists( 'ellie_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function ellie_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<div id="site-header-cart" class="site-header-cart">
			<div class="cart-toggler <?php echo esc_attr( $class ); ?>">
				<?php ellie_woocommerce_cart_link(); ?>
			</div>
			<div class="site-header-cart-contents">
                <span id="cart-close" class="cart-close">×</span>
				<?php
					$instance = array(
						'title' => esc_html__('Shopping Cart','ellie'),
					);

					the_widget( 'WC_Widget_Cart', $instance );
				?>
			</div>
		</div>
		<?php
	}
}

// TODO: Add prev next product functionality on PRO version

// TODO: Add switcher functionality for grid/list view on products page in PRO version

// TODO: Add Tabbed swithcer for Related / Cross-sell products in PRO version

// Move title

add_filter( 'woocommerce_show_page_title', '__return_false' );

// Product layout start

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 ); // we are moving the link to the product title
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 9 );


add_action( 'woocommerce_before_shop_loop_item_title', 'ellie_product_thumbnail_wrapper_start', 0 );

if ( !function_exists( 'ellie_product_thumbnail_wrapper_start' ) ) :
    function ellie_product_thumbnail_wrapper_start(){
        ?>
        <div class="<?php echo esc_attr( TZ_THEME_PREFIX.'-thumb-wrapper' )?>">
        <?php
    }
endif;

add_action( 'woocommerce_before_shop_loop_item_title', 'ellie_product_thumbnail_wrapper_end', 13 );

if ( !function_exists( 'ellie_product_thumbnail_wrapper_end' ) ) :
	function ellie_product_thumbnail_wrapper_end(){
		?>
        </div><!--<?php echo esc_attr( TZ_THEME_PREFIX.'-thumb-wrapper' )?>-->
		<?php
	}
endif;

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 ); // Moving add to cart button into the thumb wrapper
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 12 );


add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 9 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 11 );

// Product layout end

// Pagination
add_filter( 'woocommerce_pagination_args', 'ellie_woo_pagination_args' );

if ( ! function_exists('ellie_woo_pagination_args' ) ) :

    function ellie_woo_pagination_args( $args ){

        $args['prev_text'] = '<i class="ellie-icon-angle-double-left"></i>';
		$args['next_text'] = '<i class="ellie-icon-angle-double-right"></i>';

        return $args;

    }

endif;

// Single Product Layout Start

add_action( 'woocommerce_after_single_product_summary', 'ellie_woo_tabs_wrapper_start', 9 );

if ( !function_exists( 'ellie_woo_tabs_wrapper_start' ) ) :
    function ellie_woo_tabs_wrapper_start(){
        ?>
        <div class="<?php echo esc_attr( TZ_THEME_PREFIX.'-tabs-wrapper' )?>" >
        <?php
    }
endif;

add_action( 'woocommerce_after_single_product_summary', 'ellie_woo_tabs_wrapper_end', 11 );

if ( !function_exists( 'ellie_woo_tabs_wrapper_end' ) ) :
     function ellie_woo_tabs_wrapper_end(){
     ?>
        </div><!--<?php echo esc_attr( TZ_THEME_PREFIX.'-tabs-wrapper' )?>-->
     <?php
     }
endif;

add_filter( 'woocommerce_product_tabs', 'ellie_get_tabs', 98 );

function ellie_get_tabs( $tabs ) {

	$reviews_tab = array();
	$num = 0;
	?>
    <div class="single-product-accordion">
        <div class="woocommerce-tabs wc-tabs-wrapper">
            <ul class="accordion css-accordion" role="tablist">
				<?php foreach ( $tabs as $key => $tab ) : ?>
					<?php if ( $key != 'reviews') : ?>
                        <li class="accordion-item">
                            <input class="accordion-item-input" type="radio" name="accordion" id="item-<?php echo esc_attr( $key ); ?>" <?php echo ( !$num ? 'checked' : '' ); ?> />
                            <label for="item-<?php echo esc_attr( $key ); ?>" class="accordion-item-hd"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?><span class="accordion-item-hd-cta"></span></label>
                            <div class="accordion-item-bd"><?php call_user_func( $tab['callback'], $key, $tab ); ?></div>
                        </li>
					<?php else : ?>
						<?php $reviews_tab = array($key => $tab); ?>
					<?php endif;?>
					<?php $num++; endforeach; ?>
            </ul>
        </div>
    </div>

	<?php if ( count($reviews_tab) ) : ?>
        <div class="single-product-reviews">
			<?php foreach( $reviews_tab as $key => $tab ) : ?>
				<?php call_user_func( $tab['callback'], $key, $tab ); ?>
			<?php endforeach ?>
        </div>
	<?php endif; ?>
	<?php
	return array();
}

add_filter('woocommerce_product_review_comment_form_args', 'ellie_review_form_filter');

if ( ! function_exists( 'ellie_review_form_filter' ) ){
	function ellie_review_form_filter($args){

		$args['fields']['email'] = str_replace('input id="email"', 'input id="email" placeholder="'.esc_html(__('Your E-Mail', 'ellie')).''.(strpos($args['fields']['email'], 'required') ? '*' : '').'" ', $args['fields']['email']);
		$args['fields']['author'] = str_replace('input id="author"', 'input id="author" placeholder="'.esc_html(__('Your Name', 'ellie')).''.(strpos($args['fields']['author'], 'required') ? '*' : '').'" ', $args['fields']['author']);
		$args['comment_field'] = str_replace('textarea id="comment"', 'textarea id="comment" placeholder="'.esc_html(__('Your Review', 'ellie')).'" ', $args['comment_field']);
		return $args;
	}
}

// Single Product Layout End