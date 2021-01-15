<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 26/01/2018
 * Time: 20:42
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'TZ_Theme_Controller' ) ) :

	abstract class TZ_Theme_Controller
	{
		/** Singleton *************************************************************/

		protected function __construct()
		{
		}

		private static $instance;
		final public static function instance() {
			if ( !isset(self::$instance) && !(self::$instance instanceof Ellie_Controller) ) {
				self::$instance = new static();
				self::$instance->init();
			}
			return self::$instance;
		}

		/**
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden
			_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'ellie'), TZ_THEME_VERSION);
		}

		/**
		 * Disable unserializing of the class
		 *
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden
			_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'ellie'), TZ_THEME_VERSION);
		}

		function init(){

			add_filter( 'body_class', [$this, 'body_classes'] );
			add_action( 'wp_enqueue_scripts', [$this, 'load_scripts'] );
			add_action( 'template_redirect', [$this, 'register_layout_hooks'] );
			add_action( 'template_redirect', [$this, 'set_layout_dependencies'] );
			add_action( 'widgets_init', [$this, 'register_conditional_sidebars'] );

			$this->add_image_sizes();

			$this->register_conditional_menus();

		}

		function register_shop_sidebar(){
			register_sidebar( array(
				'name'          => esc_html__( 'Shop Sidebar', 'ellie' ),
				'id'            => 'sidebar-shop', // Do not modify ids
				'description'   => esc_html__( 'Add widgets for shop page here.', 'ellie' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) );
        }

        function register_product_sidebar(){
	        register_sidebar( array(
		        'name'          => esc_html__( 'Product Sidebar', 'ellie' ),
		        'id'            => 'sidebar-product', // Do not modify ids
		        'description'   => esc_html__( 'Add widgets for products page here.', 'ellie' ),
		        'before_widget' => '<section id="%1$s" class="widget %2$s">',
		        'after_widget'  => '</section>',
		        'before_title'  => '<h2 class="widget-title">',
		        'after_title'   => '</h2>',
	        ) );
        }

        function register_footer_sidebar(){
	        register_sidebar( array(
		        'name'          => esc_html__( 'Footer Sidebar', 'ellie' ),
		        'id'            => 'sidebar-footer', // Do not modify ids
		        'description'   => esc_html__( 'Add widgets for footer here.', 'ellie' ),
		        'before_widget' => '<section id="%1$s" class="widget %2$s">',
		        'after_widget'  => '</section>',
		        'before_title'  => '<h2 class="widget-title">',
		        'after_title'   => '</h2>',
	        ) );
        }

        function register_logo_sidebar(){
	        register_sidebar( array(
		        'name'          => esc_html__( 'Logo Widget Area', 'ellie' ),
		        'id'            => 'sidebar-logo', // Do not modify ids
		        'description'   => esc_html__( 'Add widgets aside the logo here.', 'ellie' ),
		        'before_widget' => '<section id="%1$s" class="header-widget %2$s">',
		        'after_widget'  => '</section>',
		        'before_title'  => '',
		        'after_title'   => '',
	        ) );
        }

        function register_pre_header_sidebar(){
	        register_sidebar( array(
		        'name'          => esc_html__( 'Widget Area Before Header', 'ellie' ),
		        'id'            => 'sidebar-header-pre', // Do not modify ids
		        'description'   => esc_html__( 'Add widgets before header widget area here.', 'ellie' ),
		        'before_widget' => '<section id="%1$s" class="pre-header-widget %2$s">',
		        'after_widget'  => '</section>',
		        'before_title'  => '<h2 class="widget-title">',
		        'after_title'   => '</h2>',
	        ) );
        }

        function register_post_header_sidebar(){
	        register_sidebar( array(
		        'name'          => esc_html__( 'Widget Area After Header', 'ellie' ),
		        'id'            => 'sidebar-header-post', // Do not modify ids
		        'description'   => esc_html__( 'Add widgets after header widget area here.', 'ellie' ),
		        'before_widget' => '<section id="%1$s" class="post-header-widget %2$s">',
		        'after_widget'  => '</section>',
		        'before_title'  => '<h2 class="widget-title">',
		        'after_title'   => '</h2>',
	        ) );
        }

		function register_conditional_sidebars(){
         // WooCommerce Sidebars Start
		    if ( class_exists( 'WooCommerce' ) ) {
			    $this->register_shop_sidebar();
			    $this->register_product_sidebar();
            } // If WooCommerce installed
		// WooCommerce Sidebars End

        // Footer Sidebar Start
			if ( get_theme_mod( 'footer_sidebar', false) ) {
		        $this->register_footer_sidebar();
		    }
		// Footer Sidebar End

		// Header Sidebars Start
			if ( get_theme_mod( 'logo_widget_area', false ) ) {
				$this->register_logo_sidebar();
			}

			if ( get_theme_mod( 'pre_header_widget_area', false ) ) {
                $this->register_pre_header_sidebar();
			}

			if ( get_theme_mod( 'post_header_widget_area', false ) ) {
				$this->register_post_header_sidebar();
			}

		// Header Sidebars End

        }

        function add_image_sizes(){

        }

        function register_conditional_menus(){

        }

		function load_scripts(){
			$this->load_global_scripts();
			if ( TZ_Theme_Helper::is_blog() ) $this->load_blog_scripts();
			if ( TZ_Theme_Helper::is_shop() ) $this->load_shop_scripts();
			if ( TZ_Theme_Helper::is_product() ) $this->load_product_scripts();
		}

		function load_global_scripts(){

        }

        function load_blog_scripts(){

	        if ( ( 'grid' == get_theme_mod( 'blog_posts_layout', 'grid' ) )
		        && ( 'masonry' == get_theme_mod( 'blog_grid_layout', 'masonry' ) )
	        ){
	            wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array(), TZ_THEME_VERSION, true );
		        wp_enqueue_script( 'isotope-packery', get_template_directory_uri() . '/js/packery-mode.pkgd.min.js', array(), TZ_THEME_VERSION, true );
		        wp_enqueue_script( TZ_THEME_PREFIX.'-isotope-controller', get_template_directory_uri() . '/js/isotope-controller.js', array('imagesloaded'), TZ_THEME_VERSION, true );
		        wp_localize_script( TZ_THEME_PREFIX.'-isotope-controller', TZ_THEME_PREFIX.'_isotope_options', array(
			        'wrapper_id' => TZ_THEME_PREFIX.'-grid-wrapper',
			        'item_selector' => '.'.TZ_THEME_PREFIX.'-grid-post-wrapper',
		        ));
	        }

	        //PRO
	        /*if ( 'grid' == get_theme_mod( 'blog_posts_layout', 'list' ) ) {
			    wp_enqueue_script( TZ_THEME_PREFIX.'-inview', get_template_directory_uri() . '/js/inview-controller.js', array(), THEME_VERSION, true );
			    wp_localize_script( TZ_THEME_PREFIX.'-inview', TZ_THEME_PREFIX.'_inview_options', array(
				    'item_selector' => '.post',
				    'item_container' => '.site-main',
			    ));
            }*/

        }

        function load_shop_scripts(){

        }

		function load_product_scripts(){

		}

		function get_page_sidebar_tag(){

			if ( TZ_Theme_Helper::is_shop() && is_active_sidebar('sidebar-shop') ) {
				if ( get_theme_mod('shop_page_layout', 'left') == 'no' ) return '';
				return 'sidebar-shop';
			} elseif ( TZ_Theme_Helper::is_product() && is_active_sidebar('sidebar-product') ) {
				if ( get_theme_mod('product_page_layout', 'no') == 'no' ) return '';
				return 'sidebar-product';
			} elseif ( TZ_Theme_Helper::is_page() ) {
				if ( get_theme_mod('static_page_layout', 'right') == 'no' ) return '';
				if (is_active_sidebar('sidebar-page')) return 'sidebar-page';
				else return 'sidebar-blog';
			} elseif ( TZ_Theme_Helper::is_cart() && is_active_sidebar('sidebar-shop') ) {
				if ( get_theme_mod('cart_page_layout', 'no') == 'no' ) return '';
				else return 'sidebar-shop';
			} elseif ( TZ_Theme_Helper::is_checkout() && is_active_sidebar('sidebar-shop') ) {
				if ( get_theme_mod('checkout_page_layout', 'no') == 'no' ) return '';
				else return 'sidebar-shop';
			} elseif ( TZ_Theme_Helper::is_blog() && is_active_sidebar('sidebar-blog') ) {
				if ( get_theme_mod('blog_page_layout', 'right') == 'no' ) return '';
				return 'sidebar-blog';
			} elseif ( TZ_Theme_Helper::is_post() && is_active_sidebar('sidebar-blog') ) {
				if ( get_theme_mod('post_page_layout', 'right') == 'no' ) return '';
				return 'sidebar-blog';
			} else {
				return 'sidebar-blog';
            }

		}

		function body_classes( $classes ){
			$classes[] = $this->get_header_layout();
			$classes[] = $this->get_page_layout();
			if ( TZ_Theme_Helper::is_blog() ) $classes[] = $this->get_blog_view();
			if ( TZ_Theme_Helper::is_post() ) $classes[] = $this->get_post_view();
			if ( TZ_Theme_Helper::is_shop() ) $classes[] = $this->get_shop_view();
			if ( TZ_Theme_Helper::is_product() ) $classes[] = $this->get_product_view();
			return $classes;
		}

		function get_blog_view(){
			$blog_view = get_theme_mod( 'blog_posts_layout', 'grid' );
			$blog_classes[] = TZ_THEME_PREFIX.'-blog-view-'.$blog_view;
			if ( $blog_view == 'grid' ) {
			    if ( 'masonry' == get_theme_mod( 'blog_grid_layout', 'masonry' ) ){
				    $blog_classes[] = TZ_THEME_PREFIX.'-blog-grid-type-masonry';
                }
				$blog_cols = get_theme_mod( 'posts_per_row', '2' );
				$blog_classes[] = TZ_THEME_PREFIX.'-blog-grid-cols-'.$blog_cols;
			}
			return implode(' ', $blog_classes);
		}

		function get_post_view(){
            return '';
        }

        function get_shop_view(){
		    return '';
        }

        function get_product_view(){
		    return '';
        }

		function get_header_layout(){
		    $classes[] = TZ_THEME_PREFIX . '-menu-align-' . ( get_theme_mod('menu_alignment', 'center') );
            $classes[] = TZ_THEME_PREFIX . '-logo-position-' . ( get_theme_mod('logo_position', 'center') );
			$classes[] = ( get_theme_mod( 'menu_position', false ) ? TZ_THEME_PREFIX . '-header-menu-around' : TZ_THEME_PREFIX . '-header-menu-under' );
			$classes[] = ( ( get_theme_mod( 'logo_widget_area', false ) && is_active_sidebar( 'sidebar-logo' ) ) ? TZ_THEME_PREFIX . '-header-logo-widgets' : '' );
			$classes[] = ( ( get_theme_mod( 'pre_header_widget_area', false ) ) ? TZ_THEME_PREFIX . '-header-pre-widgets' : '' );
			$classes[] = ( ( get_theme_mod( 'post_header_widget_area', false ) ) ? TZ_THEME_PREFIX . '-header-post-widgets' : '' );
			return implode(' ', $classes);
        }

		function get_page_layout(){

		    // TODO: Refactor page types as an enum and use switch instead

			if ( TZ_Theme_Helper::is_shop() ) {
				$layout = get_theme_mod('shop_page_layout', 'left');
				return TZ_THEME_PREFIX.'-layout-'.$layout;
			} elseif ( TZ_Theme_Helper::is_product() ) {
				$layout = get_theme_mod('product_page_layout', 'no');
				return TZ_THEME_PREFIX.'-layout-'.$layout;
			} elseif ( TZ_Theme_Helper::is_blog() ) {
				$layout = get_theme_mod('blog_page_layout', 'right');
				if ( is_active_sidebar( 'sidebar-blog' ) || is_active_sidebar( 'sidebar-1' ) )
					return TZ_THEME_PREFIX.'-layout-'.$layout;
				else return TZ_THEME_PREFIX.'-layout-right';
			} elseif ( TZ_Theme_Helper::is_post() ) {
				$layout = get_theme_mod('post_page_layout', 'right');
				if ( is_active_sidebar( 'sidebar-blog' ) )
					return TZ_THEME_PREFIX.'-layout-'.$layout;
				else return 'layout-no';
			} elseif ( TZ_Theme_Helper::is_page() ) {
				$layout = get_theme_mod('static_page_layout', 'right');
				return TZ_THEME_PREFIX.'-layout-'.$layout;
			} elseif ( TZ_Theme_Helper::is_search() ) {
				$layout = get_theme_mod('search_page_layout', 'right');
				return TZ_THEME_PREFIX.'-layout-'.$layout;
			} elseif ( TZ_Theme_Helper::is_cart() ) {
				$layout = get_theme_mod('cart_page_layout', 'no');
				return TZ_THEME_PREFIX.'-layout-'.$layout;
			} elseif ( TZ_Theme_Helper::is_checkout() ) {
				$layout = get_theme_mod('checkout_page_layout', 'no');
				return TZ_THEME_PREFIX.'-layout-'.$layout;
			} else {
				return TZ_THEME_PREFIX.'-layout-default';
			}
		}



		function set_layout_dependencies(){

		    // Header Image Start
			if ( ( get_header_image() )  && ( is_front_page() || is_home() ) ) :
                add_action( TZ_THEME_PREFIX.'_between_header_content', [$this, 'header_image'] );
            endif;
			// Header Image End

			// Menu Positioning Start
		    add_filter( TZ_THEME_PREFIX.'_menu_to_split', [$this, 'menus_to_split'], 1, 1 );

		    if (
				( 'center' == get_theme_mod('logo_position', 'left') )
				&& ( true == get_theme_mod('menu_position', false) )
			){
				add_filter( 'wp_nav_menu_items', 'TZ_Theme_Helper::split_menu', 10, 2 );
			}

			add_filter( 'wp_nav_menu_args', [$this, 'modify_menus_args'] );
			// Menu Positioning End

        }

		function menus_to_split($menus){
			$menus[] = 'menu-main';
		    return $menus;
        }

        function modify_menus_args($args){

	        if ( in_array($args["theme_location"], apply_filters( TZ_THEME_PREFIX.'_menu_to_split', array() ) ) ) {
		        $args['container'] = false;
	        }
	        return $args;
        }

		function register_layout_hooks(){
			$this->global_layout_hooks();
		    if ( TZ_Theme_Helper::is_blog() ) $this->blog_layout_hooks();
			if ( TZ_Theme_Helper::is_shop() ) $this->shop_layout_hooks();
		}

		function blog_layout_hooks(){
			if ( ( 'grid' == get_theme_mod( 'blog_posts_layout', 'grid' )
				&& ( 'masonry' == get_theme_mod( 'blog_grid_layout', 'masonry' ) )
			)
			){
				add_action( TZ_THEME_PREFIX.'_before_post_loop', [$this, 'grid_container_start'], 1 );
				add_action( TZ_THEME_PREFIX.'_after_post_loop', [$this, 'grid_container_end'] );
				add_action( TZ_THEME_PREFIX.'_before_post', [$this, 'grid_post_container_start'], 1, 2 );
				add_action( TZ_THEME_PREFIX.'_after_post', [$this, 'grid_post_container_end'] );
			}
        }

        function shop_layout_hooks(){

        }

        function global_layout_hooks(){
	        if ( get_theme_mod( 'footer_sidebar', false) ) add_action( TZ_THEME_PREFIX.'_before_footer', [$this, 'get_footer_sidebar'] );
	        if ( get_theme_mod( 'logo_widget_area', false ) && ( 'center' !=  get_theme_mod('logo_position', 'left') ) && (  false == get_theme_mod('menu_position', false)  ) ) add_action( TZ_THEME_PREFIX.'_after_logo', [$this, 'get_logo_sidebar'] );
	        if ( get_theme_mod( 'pre_header_widget_area', false ) ) add_action( TZ_THEME_PREFIX.'_before_header_content', [$this, 'get_pre_header_sidebar'] );
	        if ( get_theme_mod( 'post_header_widget_area', false ) ) add_action( TZ_THEME_PREFIX.'_after_header_content', [$this, 'get_post_header_sidebar'] );
        }

		// Layout functions Start

        function get_pre_header_sidebar(){
			if ( ! is_active_sidebar( 'sidebar-header-pre' ) ) return;
			?>
            <aside id="<?php echo esc_attr( TZ_THEME_PREFIX.'-pre-header-sidebar' )?>" class="<?php echo esc_attr( TZ_THEME_PREFIX.'-pre-header-widget-area' )?>">
				<?php
				dynamic_sidebar('sidebar-header-pre');
				?>
            </aside>
			<?php
		}

		function get_post_header_sidebar(){
			if ( ! is_active_sidebar( 'sidebar-header-post' ) ) return;
			?>
            <aside id="<?php echo esc_attr( TZ_THEME_PREFIX.'-post-header-sidebar' )?>" class="<?php echo esc_attr( TZ_THEME_PREFIX.'-post-header-widget-area' )?>">
				<?php
				dynamic_sidebar('sidebar-header-post');
				?>

            </aside>
			<?php
		}

        function get_logo_sidebar(){
	        if ( ! is_active_sidebar( 'sidebar-logo' ) ) return;

	        ?>
            <aside id="<?php echo esc_attr( TZ_THEME_PREFIX.'-logo-sidebar' )?>" class="<?php echo esc_attr( TZ_THEME_PREFIX.'-logo-widget-area' )?>">
		        <?php
                add_filter('widget_title', '__return_false'); // Remove if you need widget titles in logo area
		        dynamic_sidebar('sidebar-logo');
		        remove_filter('widget_title', '__return_false'); // Remove if you need widget titles in logo area
		        ?>

            </aside>
	        <?php
        }

        function get_footer_sidebar(){
	        if ( ! is_active_sidebar( 'sidebar-footer' ) ) return;

	        ?>
            <aside id="<?php echo esc_attr( TZ_THEME_PREFIX.'-footer-sidebar' )?>" class="<?php echo esc_attr( TZ_THEME_PREFIX.'-footer-widget-area' )?>">
                <?php dynamic_sidebar( 'sidebar-footer' ); ?>
            </aside>
            <?php

        }

		function grid_container_start(){
			?>
			<div id="<?php echo esc_attr( TZ_THEME_PREFIX.'-grid-wrapper' )?>">
			<?php
		}

		function grid_container_end(){
			?>
			<div class="grid-sizer"></div>
			</div><!-- #ellie-grid-wrapper -->
			<?php
		}

		function grid_post_container_start($post_type, $is_sticky){
			?>
			<div class="<?php echo esc_attr( TZ_THEME_PREFIX.'-grid-post-wrapper' );?> <?php echo ( $post_type ) ? esc_attr( TZ_THEME_PREFIX.'-grid-type-'.$post_type ) : ''; ?> <?php echo (  $is_sticky ? esc_attr(TZ_THEME_PREFIX.'-grid-sticky') : '' ) ?>">
			<?php
		}

		function grid_post_container_end(){
			?>
			</div><!-- ellie-grid-post-wrapper -->
			<?php
		}

		// Layout functions End

        // Header Background Image
        function header_image(){
		    ?>
	        <?php if ( get_header_image() ) : ?>
		        <?php
		        $custom_header_sizes = apply_filters( TZ_THEME_PREFIX.'_custom_header_sizes', '(max-width: 709px) 85vw, (max-width: 909px) 81vw, (max-width: 1400px) 88vw, 1400px' );
		        ?>
                <div class="page-header-block">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <img src="<?php header_image(); ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id ) ); ?>" sizes="<?php echo esc_attr( $custom_header_sizes ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
                    </a>
                </div><!-- .header-image -->
	        <?php endif; // End header image check. ?>
            <?php
        }


	}

endif;
