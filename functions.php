<?php
/**
 * ellie functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ellie
 */

if ( !defined( 'TZ_THEME_VERSION' ) ) define('TZ_THEME_VERSION', '1.0.38');
if ( !defined( 'TZ_THEME_PREFIX' ) ) define('TZ_THEME_PREFIX', 'ellie');
else wp_die( esc_html__('Theme prefix has been defined before Ellie', 'ellie' ), esc_html__('Theme Error', 'ellie') );

if ( ! defined( 'ELEMENTOR_PARTNER_ID' ) ) {
	define( 'ELEMENTOR_PARTNER_ID', 1641 );
}

add_filter( 'smartslider3_hoplink', function($source){
	return 'themeszone';
});

if ( ! function_exists( 'ellie_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ellie_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ellie, use a find and replace
		 * to change 'ellie' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ellie', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );


		register_nav_menus( array(
			'menu-main' => esc_html__( 'Primary', 'ellie' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ellie_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
			'header-text' => array( 'site-title', 'site-description' ),
		) );

		/**
		 * Add support for all post formats.
		 *
		 * @link https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'gallery',
			'link',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat'
		) );

        add_theme_support( 'editor-styles' );
        add_editor_style( 'style-editor.css' );

        add_theme_support( 'editor-color-palette', array(
            array(
                'name'  => esc_html__( 'Ellie Accent Color', 'ellie' ),
                'slug'  => 'ellie-accent-color',
                'color'	=> '#f5bdb6',
            ),
            array(
                'name'  => esc_html__( 'Ellie Accent Text Color', 'ellie' ),
                'slug'  => 'ellie-accent-text-color',
                'color' => '#f5bdb6',
            ),
            array(
                'name'  => esc_html__( 'Ellie Text Color', 'ellie' ),
                'slug'  => 'ellie-main-text-color',
                'color' => '#3d3d3d',
            ),
            array(
                'name'  => esc_html__( 'Ellie Secondary Deco Color', 'ellie' ),
                'slug'  => 'ellie-second-deco-color',
                'color' => '#ccc',
            ),
            array(
                'name'  => esc_html__( 'Ellie Hover Color', 'ellie' ),
                'slug'  => 'ellie-hover-color',
                'color' => '#7e7e7e',
            ),
        ) );

        add_theme_support( 'editor-font-sizes', array(
            array(
                'name'      => esc_html__( 'Extra Small', 'ellie' ),
                'shortName' => esc_html__( 'XS', 'ellie' ),
                'size'      => 11,
                'slug'      => 'xsmall'
            ),
            array(
                'name'      => esc_html__( 'Small', 'ellie' ),
                'shortName' => esc_html__( 'S', 'ellie' ),
                'size'      => 14,
                'slug'      => 'small'
            ),
            array(
                'name'      => esc_html__( 'Normal', 'ellie' ),
                'shortName' => esc_html__( 'M', 'ellie' ),
                'size'      => 15,
                'slug'      => 'normal'
            ),
            array(
                'name'      => esc_html__( 'Large', 'ellie' ),
                'shortName' => esc_html__( 'L', 'ellie' ),
                'size'      => 20,
                'slug'      => 'large'
            ),
            array(
                'name'      => esc_html__( 'Larger', 'ellie' ),
                'shortName' => esc_html__( 'XL', 'ellie' ),
                'size'      => 32,
                'slug'      => 'larger'
            ),
            array(
                'name'      => esc_html__( 'Largest', 'ellie' ),
                'shortName' => esc_html__( 'XXL', 'ellie' ),
                'size'      => 40,
                'slug'      => 'largest'
            )
        ) );
	}
endif;
add_action( 'after_setup_theme', 'ellie_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ellie_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ellie_content_width', 1380 );
}
add_action( 'after_setup_theme', 'ellie_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ellie_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'ellie' ),
		'id'            => 'sidebar-blog', // Do not modify ids
		'description'   => esc_html__( 'Add widgets here.', 'ellie' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Page Sidebar', 'ellie' ),
		'id'            => 'sidebar-page', // Do not modify ids
		'description'   => esc_html__( 'Add widgets here.', 'ellie' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ellie_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ellie_scripts() {
	wp_enqueue_style( 'ellie-style', get_stylesheet_uri() );

	wp_enqueue_script( 'ellie-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'ellie-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_style( 'ellie-custom-fonts', get_template_directory_uri().'/assets/css/fonts.css');

	wp_enqueue_style( 'ellie-icons',  get_template_directory_uri().'/assets/css/ellie-icons.css');

	wp_enqueue_script( 'ellie-main', get_template_directory_uri() . '/js/main.js', array(), TZ_THEME_VERSION, true );

	wp_localize_script( 'ellie-main', 'theme_vars', array('theme_prefix' => TZ_THEME_PREFIX, 'js_path' => get_template_directory_uri() . '/js/') );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ellie_scripts' );

function ellie_get_js_theme_vars(){

}

/**
 * Load Ellie Theme Helper
 */
require get_template_directory() . '/inc/lib/class-tz-theme-helper.php';

/**
 * Load Ellie Theme Controller
 */
require get_template_directory() . '/inc/lib/class-tz-theme-controller.php';
require get_template_directory() . '/inc/class-ellie-controller.php';
// Run controller
add_action( 'after_setup_theme', 'Ellie_Controller::instance' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom header tags for this theme.
 */
require get_template_directory() . '/inc/header-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Load required plugins prompt.
 */
require get_template_directory() . '/inc/required-plugins.php';

/**
 * Load demo data prompt.
 */
if ( class_exists( 'OCDI_Plugin' ) ) {
	require get_template_directory() . '/inc/demo-import.php';
}