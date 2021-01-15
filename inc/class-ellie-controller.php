<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 15/02/2018
 * Time: 15:53
 */

class Ellie_Controller extends TZ_Theme_Controller{ // overload Theme Controllers Functionality here

    function load_global_scripts(){
        parent::load_global_scripts();

	    wp_enqueue_script( TZ_THEME_PREFIX.'-animate', get_template_directory_uri() . '/js/animate-controller.js', array(), TZ_THEME_VERSION, true );
	    wp_enqueue_script( TZ_THEME_PREFIX.'-subitems', get_template_directory_uri() . '/js/subitems-controller.js', array(), TZ_THEME_VERSION, true );

	    if ( ! wp_script_is( 'select2', 'registered' )) {
		    wp_register_script( 'select2', get_template_directory_uri() . '/js/select2.min.js', array('jquery'));
	    }

	    wp_enqueue_script('select2', array('jquery'), true);

	    wp_enqueue_script( TZ_THEME_PREFIX.'-fontawesome', get_template_directory_uri() . '/js/fontawesome-all.min.js', array(), '507', true);

	    if ( get_theme_mod('sticky_header', false) ) {
		    wp_enqueue_script( TZ_THEME_PREFIX.'-sticky-header', get_template_directory_uri() . '/js/sticky-controller.js', array(), TZ_THEME_VERSION, true );
        }
	    if ( is_active_sidebar( 'sidebar-header-pre' ) ) {
		    wp_enqueue_script( TZ_THEME_PREFIX.'-sidebar-toggler', get_template_directory_uri() . '/js/menu-toggler.js', array(), TZ_THEME_VERSION, true );
        }

	    if ( get_theme_mod('post_header_widget_area', true) && class_exists( 'WooCommerce' ) ) {
		    wp_enqueue_script( TZ_THEME_PREFIX.'-cart-toggler', get_template_directory_uri() . '/js/cart-toggler.js', array(), TZ_THEME_VERSION, true );
        }

	    wp_enqueue_script( TZ_THEME_PREFIX, get_template_directory_uri() . '/js/main.js', array('jquery'), TZ_THEME_VERSION, true );

    }

    function global_layout_hooks(){
		parent::global_layout_hooks();

		add_action( TZ_THEME_PREFIX.'_before_page', [$this, 'offcanvas_viewport_start'], 1 );
	    add_action( TZ_THEME_PREFIX.'_after_page', [$this, 'offcanvas_viewport_end'], 10 );

	    if ( get_theme_mod('sticky_header', false) ) {
			add_action( TZ_THEME_PREFIX.'_before_header', [$this, 'sticky_header_start'], 2 );
			add_action( TZ_THEME_PREFIX.'_after_header', [$this, 'sticky_header_end'], 99 );
		}

	    add_action( TZ_THEME_PREFIX.'_between_header_content', [$this, 'page_heading'], 1 );

		add_action( TZ_THEME_PREFIX.'_after_site_info', [$this, 'social_menu'] );
	    add_action( TZ_THEME_PREFIX.'_after_site_info', [$this, 'footer_menu'] );

	    add_action( TZ_THEME_PREFIX.'_after_post_loop', [$this, 'posts_navigation'], 99 );

	    add_filter( 'comment_form_default_fields', [$this, 'comments_form_fileds'] );

	    if ( class_exists( 'Elementor\Plugin' ) ) $this->elementor_layout_hooks();

	    if ( class_exists( 'WooCommerce' ) ) $this->woo_layout_hooks();

	    add_filter( 'post_gallery', [$this, 'gallery_controller'], 1002, 3 );

	}

	function load_product_scripts()
	{
		wp_enqueue_script(TZ_THEME_PREFIX . '-product', get_template_directory_uri() . '/js/single-product.js', array(), TZ_THEME_VERSION, true);
		wp_localize_script(TZ_THEME_PREFIX . '-product', 'options', [
			'label_write_review' => esc_html__('Add a review', 'ellie')
		]);
	}

    function elementor_layout_hooks(){
        if ( TZ_Theme_Helper::is_elementor() ) {
	        add_filter( TZ_THEME_PREFIX.'_show_page_title', '__return_false' );
	        add_filter( TZ_THEME_PREFIX.'_show_page_comments', '__return_false' );
        }
    }

    function gallery_controller( $html, $atts, $instance ){
	    wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array(), TZ_THEME_VERSION, true );
	    wp_enqueue_script( 'isotope-packery', get_template_directory_uri() . '/js/packery-mode.pkgd.min.js', array(), TZ_THEME_VERSION, true );
	    wp_enqueue_script( TZ_THEME_PREFIX.'-isotope-controller', get_template_directory_uri() . '/js/gallery-controller.js', array('imagesloaded'), TZ_THEME_VERSION, true );
	    wp_localize_script( TZ_THEME_PREFIX.'-isotope-controller', TZ_THEME_PREFIX.'_isotope_options', array(
		    'wrapper_id' => 'gallery-'.$instance,
		    'item_selector' => '.gallery-item',
	    ));
    }

	function woo_layout_hooks(){
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
        add_filter( 'woocommerce_breadcrumb_defaults', [$this, 'breadcrumb_filter'] );
        if (
                TZ_Theme_Helper::is_cart()
                || TZ_Theme_Helper::is_checkout()
                || TZ_Theme_Helper::is_account()
                || TZ_Theme_Helper::is_order_tracking()
        ) add_filter( TZ_THEME_PREFIX.'_show_page_title', '__return_false' );
    }

    function breadcrumb_filter($args){
        $args['delimiter'] = '&nbsp;&nbsp;/&nbsp;&nbsp;' ;
        return $args;
    }

	function offcanvas_viewport_start(){
        ?>
        <div id="site-viewport" class="site-viewport">
        <?php
    }

    function offcanvas_viewport_end(){
        ?>
        </div> <!-- .site-viewport -->
        <?php
    }

	function sticky_header_start(){
		?>
		<div class="sticky-header">
		<?php
	}

	function sticky_header_end(){
		?>
		</div><!--.sticky-header -->
		<?php
	}

	function get_pre_header_sidebar(){
		if ( ! is_active_sidebar( 'sidebar-header-pre' ) ) return;
		?>
            <aside id="<?php echo esc_attr( TZ_THEME_PREFIX.'-pre-header-sidebar' )?>" class="<?php echo esc_attr( TZ_THEME_PREFIX.'-pre-header-widget-area' )?>">
                <div id="menu-icon-wrapper" class="menu-icon-wrapper">
                    <div id="menu-icon-trigger" class="menu-icon-trigger">
                        <svg width="80px" height="80px">
                            <path id="pathA" d="M 30 44 L 70 44 C 90 40 90 75 60 85 A 40 40 0 0 1 20 20 L 80 80"></path>
                            <path id="pathB" d="M 30 50 L 70 50"></path>
                            <path id="pathC" d="M 70 56 L 30 56 C 10 60 10 20 40 15 A 40 38 0 1 1 20 80 L 80 20"></path>
                        </svg>
                    </div>
                </div>
                <div id="offcanvas-sidebar" class="offcanvas-sidebar">
                <?php
                dynamic_sidebar('sidebar-header-pre');
                ?>
                </div>
            </aside>

		<?php
	}

	function get_post_header_sidebar(){
		?>
        <aside id="<?php echo esc_attr( TZ_THEME_PREFIX.'-post-header-sidebar' )?>" class="<?php echo esc_attr( TZ_THEME_PREFIX.'-post-header-widget-area' )?>">
	        <?php
	        if ( function_exists( 'ellie_woocommerce_header_cart' ) ) {
		        ellie_woocommerce_header_cart();
	        }
	        ?>
        </aside>
		<?php
	}

	function register_pre_header_sidebar(){
		register_sidebar( array(
			'name'          => esc_html__( 'Off-canvas widget area', 'ellie' ),
			'id'            => 'sidebar-header-pre', // Do not modify ids
			'description'   => esc_html__( 'Add widgets to off-canvas widget area.', 'ellie' ),
			'before_widget' => '<section id="%1$s" class="widget pre-header-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}

	function register_post_header_sidebar(){ // removing default header sidebar

	}

	function register_conditional_menus(){
		register_nav_menus( array(
			'social-menu' => esc_html__( 'Social Icons', 'ellie' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'ellie' ),
		) );
    }

    function get_post_thumbnail_size(){

        $blog_view = get_theme_mod( 'blog_posts_layout', 'grid' );

	    if ( $blog_view == 'grid' ){
		    $blog_cols = get_theme_mod( 'posts_per_row', '3' );
		    return TZ_THEME_PREFIX.'-post-thumbnail-'.$blog_cols.'cols';
        } else {
		    return TZ_THEME_PREFIX.'-post-thumbnail-list';
        }

    }

    function add_image_sizes(){

	    set_post_thumbnail_size(1380, 9999);

	    add_image_size( TZ_THEME_PREFIX.'-single-post-thumbnail', 1420, 9999 );

	    add_image_size( TZ_THEME_PREFIX.'-post-thumbnail-4cols', 323, 9999 );

	    add_image_size( TZ_THEME_PREFIX.'-post-thumbnail-3cols', 440, 9999 );

	    add_image_size( TZ_THEME_PREFIX.'-post-thumbnail-2cols', 675, 9999 );

	    add_image_size( TZ_THEME_PREFIX.'-post-thumbnail-list', 1380, 9999 );

    }

	function social_menu(){
        if ( has_nav_menu( 'social-menu' ) ){
	        wp_nav_menu( array(
		        'theme_location' => 'social-menu',
		        'menu_id'        => 'social-menu',
		        'depth' => 1
	        ) );
        }
    }

	function footer_menu(){
		if ( has_nav_menu( 'footer-menu' ) ){
			wp_nav_menu( array(
				'theme_location' => 'footer-menu',
				'menu_id'        => 'footer-menu',
				'depth' => 1
			) );
		}
	}

	function posts_navigation(){

        if ( 'linked' == get_theme_mod('blog_pagination', 'paginated' ) ) {
		    the_posts_navigation();
        } else {
	        the_posts_pagination(array(
		        'prev_text' => '<i class="ellie-icon-angle-double-left"></i>',
		        'next_text' => '<i class="ellie-icon-angle-double-right"></i>',
	        ));
        }
    }

    function blog_page_heading(){
	    if ( is_home() && ! is_front_page() ) :
            $image = get_theme_mod( 'blog_page_banner', 0 );
	        $custom_image_class = ( $image ? TZ_THEME_PREFIX.'-custom-image' : '' );
		    ?>
            <header class="page-header-block <?php echo esc_attr( $custom_image_class ); ?> ">
	            <?php $this->page_banner( $image ); ?>
	            <?php do_action( TZ_THEME_PREFIX.'_page_header_breadcrumbs' )?>
                <h1 class="page-title"><?php single_post_title(); ?></h1>
            </header>

	    <?php
	    endif;
    }

    function search_page_heading(){
        ?>
        <header class="page-header-block">
	        <?php do_action( TZ_THEME_PREFIX.'_page_header_breadcrumbs' )?>
            <h1 class="page-title"><?php
			    /* translators: %s: search query. */
			    printf( esc_html__( 'Search Results for: %s', 'ellie' ), '<span>' . get_search_query() . '</span>' );
			    ?></h1>
        </header><!-- .page-header -->
        <?php
    }

    function archive_page_heading(){
        ?>
        <header class="page-header-block">
	        <?php do_action( TZ_THEME_PREFIX.'_page_header_breadcrumbs' )?>
		    <?php
		    the_archive_title( '<h1 class="page-title">', '</h1>' );
		    the_archive_description( '<div class="archive-description">', '</div>' );
		    ?>
        </header><!-- .page-header -->
        <?php
    }

    function post_page_heading(){

	    if ( get_theme_mod('post_layout', 'simple') == 'modern' ) :
        ?>
            <?php if ( have_posts() ) : the_post(); ?>
            <header class="page-header-block">
	            <?php do_action( TZ_THEME_PREFIX.'_page_header_breadcrumbs' ); ?>
	            <?php if ( 'post' === get_post_type() ) : ?>
                    <div class="entry-meta">
			            <?php
			            ellie_posted_on();
			            ellie_posted_by();
			            ?>
                    </div><!-- .entry-meta -->
	            <?php
	            endif; ?>
                <?php
	            if ( is_singular() ) :
		            the_title( '<h1 class="entry-title">', '</h1>' );
	            endif;
                ?>
	            <?php ellie_post_thumbnail(); ?>
            </header>
		    <?php rewind_posts(); ?>
            <?php endif; ?>
        <?php
        else:
        ?>
            <header class="page-header-block">
                <?php do_action( TZ_THEME_PREFIX.'_page_header_breadcrumbs' ); ?>
            </header><!-- .page-header -->
        <?php
        endif;
    }

    function shop_page_heading(){
	    $image = get_theme_mod( 'shop_page_banner', 0 );
	    $custom_image_class = ( $image ? TZ_THEME_PREFIX.'-custom-image' : '' );
        ?>
        <header class="page-header-block <?php echo esc_attr( $custom_image_class ); ?> ">
            <?php $this->page_banner( $image ); ?>
		    <?php woocommerce_breadcrumb(); ?>
            <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
        </header><!-- .page-header -->
        <?php
    }

    function page_banner( $image_id ){
        if ( $image_id ) : ?>
        <div class="<?php echo esc_attr( TZ_THEME_PREFIX.'-top-banner' )?>">
            <?php echo wp_get_attachment_image( $image_id, 'full' ); ?>
        </div>
        <?php endif;
    }

    function product_page_heading(  ){
	    $image = get_theme_mod( 'product_page_banner', 0 );
	    $custom_image_class = ( $image ? TZ_THEME_PREFIX.'-custom-image' : '' );
	    ?>
        <header class="page-header-block <?php echo esc_attr( $custom_image_class ); ?>">
		    <?php $this->page_banner( $image ); ?>
		    <?php woocommerce_breadcrumb(); ?>
        </header><!-- .page-header -->
	    <?php
    }

    function cart_page_heading(){
	    $image = get_theme_mod( 'cart_page_banner', 0 );
	    $custom_image_class = ( $image ? TZ_THEME_PREFIX.'-custom-image' : '' );
	    ?>
        <header class="page-header-block <?php echo esc_attr( $custom_image_class ); ?> ">
		    <?php $this->page_banner( $image ); ?>
		    <?php woocommerce_breadcrumb(); ?>
		    <?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
        </header><!-- .page-header -->
	    <?php
    }

	function checkout_page_heading(){
		$image = get_theme_mod( 'checkout_page_banner', 0 );
		$custom_image_class = ( $image ? TZ_THEME_PREFIX.'-custom-image' : '' );
		?>
        <header class="page-header-block <?php echo esc_attr( $custom_image_class ); ?> ">
			<?php $this->page_banner( $image ); ?>
			<?php woocommerce_breadcrumb(); ?>
			<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
        </header><!-- .page-header -->
		<?php
	}

	function account_page_heading(){
		$image = get_theme_mod( 'account_page_banner', 0 );
		$custom_image_class = ( $image ? TZ_THEME_PREFIX.'-custom-image' : '' );
		?>
        <header class="page-header-block <?php echo esc_attr( $custom_image_class ); ?> ">
			<?php $this->page_banner( $image ); ?>
			<?php woocommerce_breadcrumb(); ?>
			<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
        </header><!-- .page-header -->
		<?php
    }

	function order_tracking_page_heading(){
		$image = get_theme_mod( 'account_page_banner', 0 );
		$custom_image_class = ( $image ? TZ_THEME_PREFIX.'-custom-image' : '' );
		?>
        <header class="page-header-block <?php echo esc_attr( $custom_image_class ); ?> ">
			<?php $this->page_banner( $image ); ?>
			<?php woocommerce_breadcrumb(); ?>
			<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
        </header><!-- .page-header -->
		<?php
	}

    function get_post_view(){
	    $classes[] = parent::get_post_view();
        $classes[] = ( get_theme_mod('post_layout', 'simple') == 'modern' ? TZ_THEME_PREFIX.'-post-modern' : '' );
	    $classes[] = ( get_theme_mod('post_layout', 'simple') == 'modern' ? TZ_THEME_PREFIX.'-heading-inset' : '' );
        return implode(' ', $classes);
    }

	function page_heading(){
        if ( TZ_Theme_Helper::is_blog() && !TZ_Theme_Helper::is_archive() ) $this->blog_page_heading();
        elseif ( TZ_Theme_Helper::is_search() ) $this->search_page_heading();
        elseif ( TZ_Theme_Helper::is_archive() && !TZ_Theme_Helper::is_woocommerce() ) $this->archive_page_heading();
        elseif ( TZ_Theme_Helper::is_post() ) $this->post_page_heading();
        elseif ( TZ_Theme_Helper::is_shop() ) $this->shop_page_heading();
        elseif ( TZ_Theme_Helper::is_product() ) $this->product_page_heading();
        elseif ( TZ_Theme_Helper::is_cart() ) $this->cart_page_heading();
        elseif ( TZ_Theme_Helper::is_checkout() ) $this->checkout_page_heading();
        elseif ( TZ_Theme_Helper::is_account() ) $this->account_page_heading();
        elseif ( TZ_Theme_Helper::is_order_tracking() ) $this->order_tracking_page_heading();
    }

    function comments_form_fileds( $fields ){

	    $req = get_option( 'require_name_email' );
	    $star = $req ? ' *': '';

        $fields['author'] = str_replace('id="author" name="author"', 'id="author" name="author" placeholder="'.esc_attr__('Name', 'ellie').$star.'"', $fields['author']);
	    $fields['email']  = str_replace('id="email" name="email"', 'id="email" name="email" placeholder="'.esc_attr__('Email', 'ellie').$star.'"', $fields['email'] );
	    $fields['url']    = str_replace('id="url" name="url"', 'id="url" name="url" placeholder="'.esc_attr__('Website', 'ellie').'"', $fields['url']);

        return $fields;
    }

}