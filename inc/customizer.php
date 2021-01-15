<?php
/**
 * ellie Theme Customizer
 *
 * @package ellie
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ellie_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => TZ_THEME_PREFIX.'_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => TZ_THEME_PREFIX.'_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'ellie_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function ellie_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function ellie_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ellie_customize_preview_js() {
	wp_enqueue_script( TZ_THEME_PREFIX.'-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', TZ_THEME_PREFIX.'_customize_preview_js' );


/**
 * Customizer options based on Kirki Plugin.
 */

// Add Kirki Fallback class
require get_template_directory() . '/inc/lib/class-kirki-fallback.php';

if ( class_exists( 'Ellie_Kirki_Customizer' ) ) : // Ellie_Kirki_Customizer Options Start

	Ellie_Kirki_Customizer::add_config( TZ_THEME_PREFIX.'_theme', array(
		'option_type' => 'theme_mod',
		'capability'  => 'edit_theme_options',
	) );

	if ( ! function_exists('ellie_add_custom_fonts') ) {

		function ellie_add_custom_fonts( $fonts ){

			$fonts['Butler'] = array(
				'label' => 'Butler',
				'variants' => array('200', '300', '400','400italic', '500','500italic', '600','600italic', '700','700italic', '800','800italic', 'regular','italic'),
				'stack' => 'Butler, serif',
                'subsets' => array( 'latin-ext' ),
			);

			$fonts['Butler Stencil'] = array(
				'label' => 'Butler Stencil',
				'variants' => array('400'),
				'stack' => 'Butler Stencil, Butler, serif',
                'subsets' => array( 'latin-ext' ),
			);

			$fonts['HK Grotesk'] = array(
				'label' => 'HK Grotesk',
				'variants' => array('200','200italic', '300','300italic', '400','400italic', '500','500italic', '600','600italic', '700','700italic', '800','800italic', 'regular','italic'),
				'stack' => 'HK Grotesk, serif',
                'subsets' => array( 'latin-ext' ),
			);

			return $fonts;
		}

	}

	add_filter( 'kirki_fonts_standard_fonts', 'ellie_add_custom_fonts' );

// Available Section

// Typography Section
	Ellie_Kirki_Customizer::add_section( 'typography', array(
		'title'      => esc_attr__( 'Typography', 'ellie' ),
		'priority'   => 1,
		'capability' => 'edit_theme_options',
	) );

// Header Section
	Ellie_Kirki_Customizer::add_section( 'header', array(
		'title'      => esc_attr__( 'Header Layout', 'ellie' ),
		'priority'   => 2,
		'capability' => 'edit_theme_options',
	) );

// Layout Section
	Ellie_Kirki_Customizer::add_section( 'layout', array(
		'title'      => esc_attr__( 'Theme Layout', 'ellie' ),
		'priority'   => 3,
		'capability' => 'edit_theme_options',
	) );

// Footer Section
	Ellie_Kirki_Customizer::add_section( 'footer', array(
		'title'      => esc_attr__( 'Footer Layout', 'ellie' ),
		'priority'   => 4,
		'capability' => 'edit_theme_options',
	) );

// Blog Section
	Ellie_Kirki_Customizer::add_section( 'blog', array(
		'title'      => esc_attr__( 'Blog Options', 'ellie' ),
		'priority'   => 5,
		'capability' => 'edit_theme_options',
	) );

// Post Section
	Ellie_Kirki_Customizer::add_section( 'post', array(
		'title'      => esc_attr__( 'Post Options', 'ellie' ),
		'priority'   => 5,
		'capability' => 'edit_theme_options',
	) );

// Shop Section
	Ellie_Kirki_Customizer::add_section( 'shop', array(
		'title'      => esc_attr__( 'Shop Page Options', 'ellie' ),
		'priority'   => 5,
		'capability' => 'edit_theme_options',
	) );

// Product Section
	Ellie_Kirki_Customizer::add_section( 'product', array(
		'title'      => esc_attr__( 'Product Page Options', 'ellie' ),
		'priority'   => 5,
		'capability' => 'edit_theme_options',
	) );

// Typography Start
	// global typography start
	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'typography',
		'settings'    => 'global_font',
		'label'       => esc_attr__( 'Global Font', 'ellie' ),
		'description' => esc_attr__( 'Site wide font used everywhere if no other setting applied.', 'ellie' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'HK Grotesk',
			'variant'        => 'regular',
			'font-size'      => '17px',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'color'          => '#3d3d3d',
			'text-transform' => 'none',
			'text-align'     => 'left',
            'subsets' => array( 'latin-ext' ),
		),
		'priority'    => 1,
		'output'      => array(
			array(
				'element' => array(
					'body',

				),
			),
            array(
                'element'  => '.edit-post-visual-editor.editor-styles-wrapper',
                'context'  => array( 'editor' ),
            ),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'typography',
		'settings'    => 'headings_font',
		'label'       => esc_attr__( 'Headings Font', 'ellie' ),
		'description' => esc_attr__( 'Site wide headings font used everywhere if no other setting applied.', 'ellie' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'Butler',
			'color'          => '#000000',
            'subsets' => array( 'latin-ext' ),
		),
		'priority'    => 2,
		'output'      => array(
			array(
				'element' => array(
					'h1',
					'h2',
					'h3',
					'h4',
					'.widget_calendar th',
					'blockquote',
					'.single-post.ellie-post-modern .entry-content p:first-child:first-letter',
					'ul.products .product .onsale',
					'.shop_table_responsive .product-name a',
					'.ellie-testimonials .elementor-testimonial-content'
				),
			),
            array(
                'element'  => array(
                    '.edit-post-visual-editor.editor-styles-wrapper h1',
                    '.edit-post-visual-editor.editor-styles-wrapper h2',
                    '.edit-post-visual-editor.editor-styles-wrapper h3',
                    '.edit-post-visual-editor.editor-styles-wrapper h4',
                    '.editor-post-title__block',
                    '.editor-post-title__block .editor-post-title__input'
                ),
                'context'  => array( 'editor' ),
            ),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'color',
		'settings'    => 'accent_color',
		'label'       => __( 'Accent Color', 'ellie' ),
		'description' => esc_attr__( 'Accent Color (secondary site color).', 'ellie' ),
		'section'     => 'typography',
		'default'     => '#f5bdb6',
		'choices'     => array(
			'alpha' => true,
		),
		'output'   => array(
			array(
				'element'  => array(
					'.site-header-cart .cart-toggler .cart-contents',
					'.site-header-cart .product_list_widget li .remove',
					'.blog .post .entry-meta a',
					'.tagcloud a:hover',
					'.single-product .summary .product_meta .posted_in:before',
					'.single-product .summary .product_meta .sku_wrapper:before',
					'.single-product .summary .product_meta .tagged_as:before',
					'.site-footer .menu li a:hover',
					'.site-footer .site-info a:hover'

				),
				'property' => 'color',
			),

			array(
				'element'  => array(
					'.site-header-cart .product_list_widget li .remove:hover',
					'.site-header-cart .widget_shopping_cart_content .buttons a:hover',
					'ul.products .product .added_to_cart',
					'.widget_product_tag_cloud .tagcloud a:hover',
					'.single-product .product .summary .single_add_to_cart_button:hover',
					'ul.products .product .add_to_cart_button:hover',
					'ul.products .product .product_type_variable:hover',
					'.single-product .single-product-reviews .review-button-cont .button:hover',
					'#review_form #respond p.form-submit input:hover',
					'.heading-undersocre:after'

				),
				'property' => 'background-color',
			),

			array(
				'element'  => array(
					'.widget_product_tag_cloud .tagcloud a:hover'
				),
				'property' => 'border-color',
			),

		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'color',
		'settings'    => 'links_color',
		'label'       => __( 'Links color', 'ellie' ),
		'description' => esc_attr__( 'Color for links site-wide.', 'ellie' ),
		'section'     => 'typography',
		'default'     => '#000000',
		'choices'     => array(
			'alpha' => true,
		),
		'output'   => array(
			array(
				'element'  => 'a',
				'property' => 'color',
			),
		),
	) );
	// TODO: Add full typography controller for links in PRO

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'color',
		'settings'    => 'links_color_hover',
		'label'       => __( 'Hovered links color', 'ellie' ),
		'description' => esc_attr__( 'Hover color for links site-wide.', 'ellie' ),
		'section'     => 'typography',
		'default'     => '#7e7e7e',
		'choices'     => array(
			'alpha' => true,
		),
		'output'   => array(
			array(
				'element'  => 'a:hover',
				'property' => 'color',
			),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'color',
		'settings'    => 'links_color_visited',
		'label'       => __( 'Visited links color', 'ellie' ),
		'description' => esc_attr__( 'Visited links color site-wide.', 'ellie' ),
		'section'     => 'typography',
		'default'     => '#7e7e7e',
		'choices'     => array(
			'alpha' => true,
		),
		'output'   => array(
			array(
				'element'  => 'a:visited',
				'property' => 'color',
			),
		),
	) );


	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'typography',
		'settings'    => 'menu_font',
		'label'       => esc_attr__( 'Menu Font', 'ellie' ),
		'description' => esc_attr__( 'Typography for main menu.', 'ellie' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'HK Grotesk',
			'variant'        => '600',
			'font-size'      => '14px',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'color'          => '#000000',
			'text-transform' => 'uppercase',
			'text-align'     => 'left'
		),
		'priority'    => 4,
		'output'      => array(
			array(
				'element' => array(
					'.main-navigation .menu > li > a',
					'.main-navigation .menu  .nav-menu > li > a',

				),
			),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'typography',
		'settings'    => 'logo_font',
		'label'       => esc_attr__( 'Logo Font', 'ellie' ),
		'description' => esc_attr__( 'Logo font, color, and size.', 'ellie' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'Butler Stencil',
			'variant'        => 'regular',
			'font-size'      => '30px',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'color'          => '#000000',
			'text-transform' => 'none',
			'text-align'     => 'center'
		),
		'priority'    => 3,
		'output'      => array(
			array(
				'element' => array(
					'.site-title',
					'.hidden-logo'

				),
			),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'typography',
		'settings'    => 'footer_signature_font',
		'label'       => esc_attr__( 'Footer Signature Font', 'ellie' ),
		'description' => esc_attr__( 'Typography for footer signature.', 'ellie' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'HK Grotesk',
			'variant'        => 'regular',
			'font-size'      => '12px',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'color'          => '#000000',
			'text-transform' => 'uppercase',
			'text-align'     => 'center'
		),
		'priority'    => 20,
		'output'      => array(
			array(
				'element' => array(
					'.site-info',

				),
			),
		),
	) );
	// global typography end

	// blog typography start

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'typography',
		'settings'    => 'blog_widget_title',
		'label'       => esc_attr__( 'Blog Widget Titles', 'ellie' ),
		'description' => esc_attr__( 'Typography for Sidebar widget title', 'ellie' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'HK Grotesk',
			'variant'        => '700',
			'font-size'      => '14px',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'color'          => '#000000',
			'text-transform' => 'uppercase',
			'text-align'     => 'center'
		),
		'priority'    => 5,
		'output'      => array(
			array(
				'element' => array(
					'#secondary .widget-title',

				),
			),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'typography',
		'settings'    => 'archive_post_titles',
		'label'       => esc_attr__( 'Blog Post Titles', 'ellie' ),
		'description' => esc_attr__( 'Post titles typography on posts listings.', 'ellie' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'Butler',
			'variant'        => 'normal',
			'font-size'      => '1.5em',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'color'          => '#000000',
			'text-transform' => 'none',
			'text-align'     => 'left'
		),
		'priority'    => 5,
		'output'      => array(
			array(
				'element' => array(
					'.blog #content article.post .entry-title',

				),
			),
		),
	) );

	// blog typography end

	// off-canvas sidebar start
	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'typography',
		'settings'    => 'offcanvas_widget_title',
		'label'       => esc_attr__( 'Off-Canvas Sidebar Widget Titles', 'ellie' ),
		'description' => esc_attr__( 'Typography for footer signature.', 'ellie' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'Butler',
			'variant'        => 'regular',
			'font-size'      => '1.5em',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'color'          => '#000000',
			'text-transform' => 'none',
			'text-align'     => 'left'
		),
		'priority'    => 5,
		'output'      => array(
			array(
				'element' => array(
					'.offcanvas-sidebar .widget-title',

				),
			),
		),
	) );
	// TODO: Add more customizable features for offcanvas sidebar on PRO
	// off-canvas sidebar end

	// post typography start
	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'typography',
		'settings'    => 'post_title',
		'label'       => esc_attr__( 'Post Titles', 'ellie' ),
		'description' => esc_attr__( 'Post title on single post page.', 'ellie' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'Butler',
			'variant'        => '500',
			'font-size'      => '2em',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'color'          => '#000000',
			'text-transform' => 'none',
			'text-align'     => 'left'
		),
		'priority'    => 5,
		'output'      => array(
			array(
				'element' => array(
					'.single-post #content .entry-header .entry-title',
				),
			),
		),
	) );
	// post typography end

	// product listing typography start
	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'typography',
		'settings'    => 'product_listing_titles',
		'label'       => esc_attr__( 'Product Titles on product listing page', 'ellie' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'HK Grotesk',
			'variant'        => '500',
			'font-size'      => '1em',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'color'          => '#000000',
			'text-transform' => 'none',
			'text-align'     => 'left'
		),
		'priority'    => 5,
		'output'      => array(
			array(
				'element' => array(
					'.products > .product .woocommerce-loop-product__title',
				),
			),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'typography',
		'settings'    => 'product_listing_prices',
		'label'       => esc_attr__( 'Product price on product listing page', 'ellie' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'HK Grotesk',
			'variant'        => 'normal',
			'font-size'      => '0.882em',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'color'          => '#000000',
			'text-transform' => 'none',
			'text-align'     => 'left'
		),
		'priority'    => 5,
		'output'      => array(
			array(
				'element' => array(
					'ul.products .product .price',
					'.product_list_widget .amount'
				),
			),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'color',
		'settings'    => 'rating_color',
		'label'       => __( 'Ratings Color', 'ellie' ),
		'description' => esc_attr__( 'Star ratings color on listing page', 'ellie' ),
		'section'     => 'typography',
		'default'     => '#f5bdb6',
		'choices'     => array(
			'alpha' => true,
		),
		'output'   => array(
			array(
				'element'  => array(
					'.star-rating',
					'.comment-form-rating .stars a:before',
					'.comment-form-rating .stars:hover a:before',
					'.comment-form-rating .stars:visited a:before',
					'.comment-form-rating .stars:active a:before',
					'.comment-form-rating .stars.selected a.active:before'
				),
				'property' => 'color',
			),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'typography',
		'settings'    => 'product_listing_button',
		'label'       => esc_attr__( 'Add to cart button on product listing page', 'ellie' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'HK Grotesk',
			'variant'        => 'normal',
			'font-size'      => '1em',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'color'          => '#000000',
			'text-transform' => 'none',
			'text-align'     => 'left'
		),
		'priority'    => 5,
		'output'      => array(
			array(
				'element' => array(
					'.products > .product .add_to_cart_button',
				),
			),
		),
	) );
	// product listing typography end


// Typography End


// Header Layout Start
	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'radio-image',
		'settings'    => 'logo_position',
		'label'       => esc_html__( 'Logo Position', 'ellie' ),
		'description' => esc_attr__( 'Select how you want to position your logo, left, right or centered' , 'ellie' ),
		'section'     => 'header',
		'default'     => 'center',
		'priority'    => 1,
		'choices'     => array(
			'left'   => get_template_directory_uri() . '/assets/img/logo_l.jpg',
			'right'  => get_template_directory_uri() . '/assets/img/logo_r.jpg',
			'center' => get_template_directory_uri() . '/assets/img/logo_c.jpg',
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'switch',
		'settings'    => 'menu_position',
		'label'       => esc_html__( 'Main Menu Floating', 'ellie' ),
		'description' => esc_attr__( 'Make the main menu float around logo or display under the logo.', 'ellie' ),
		'section'     => 'header',
		/*'active_callback' => array(
			array(
				'setting' => 'logo_position',
				'operator' => '==',
				'value' =>  'center'
			),
		),*/
		'default'     => false,
		'priority'    => 2,
		'choices'     => array(
			'around'  => esc_attr__( 'Around', 'ellie' ),
			'under'   => esc_attr__( 'Under', 'ellie' ),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'radio-image',
		'settings'    => 'menu_alignment',
		'label'       => esc_html__( 'Menu Items Alignment', 'ellie' ),
		'description' => esc_attr__( 'Select how you want to align main menu items, left, right or centered' , 'ellie' ),
		'section'     => 'header',
		'default'     => 'center',
		'priority'    => 3,
		'choices'     => array(
			'left'   => get_template_directory_uri() . '/assets/img/text-l.svg',
			'right'  => get_template_directory_uri() . '/assets/img/text-r.svg',
			'center' => get_template_directory_uri() . '/assets/img/text-c.svg',
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'switch',
		'settings'    => 'logo_widget_area',
		'label'       => esc_html__( 'Logo Widget Area', 'ellie' ),
		'description' => esc_attr__( 'Enable or disable logo widget area.', 'ellie' ),
		'section'     => 'header',
		'default'     => false,
		'priority'    => 4,
		'active_callback' => array(
			array(
				'setting' => 'menu_position',
				'operator' => '==',
				'value' =>  false
			),
			array(
				'setting' => 'logo_position',
				'operator' => '!=',
				'value' =>  'center'
			),

		),
		'choices'     => array(
			'enabled'  => esc_attr__( 'Enabled', 'ellie' ),
			'disabled'   => esc_attr__( 'Disables', 'ellie' ),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'switch',
		'settings'    => 'pre_header_widget_area',
		'label'       => esc_html__( 'Off canvas widget area', 'ellie' ),
		'description' => esc_attr__( 'Enable or disable off-canvas widget area.', 'ellie' ),
		'section'     => 'header',
		'default'     => true,
		'priority'    => 5,
		'choices'     => array(
			'enabled'  => esc_attr__( 'Enabled', 'ellie' ),
			'disabled'   => esc_attr__( 'Disables', 'ellie' ),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'switch',
		'settings'    => 'post_header_widget_area',
		'label'       => esc_html__( 'Show Shopping Cart in Header', 'ellie' ),
		'description' => esc_attr__( 'Enable or disable Shopping-cart Widget in Header', 'ellie' ),
		'section'     => 'header',
		'default'     => true,
		'priority'    => 6,
		'choices'     => array(
			'enabled'  => esc_attr__( 'Enabled', 'ellie' ),
			'disabled'   => esc_attr__( 'Disables', 'ellie' ),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'switch',
		'settings'    => 'sticky_header',
		'label'       => esc_html__( 'Sticky Header', 'ellie' ),
		'description' => esc_attr__( 'Enable or disable sticky header', 'ellie' ),
		'section'     => 'header',
		'default'     => false,
		'priority'    => 7,
		'choices'     => array(
			'enabled'  => esc_attr__( 'Enabled', 'ellie' ),
			'disabled'   => esc_attr__( 'Disables', 'ellie' ),
		),
	) );

	// TODO: Add widths for header areas in PRO version

// Header Layout End

// Sidebar Layout Start
	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'radio-image',
		'settings'    => 'blog_page_layout',
		'label'       => esc_html__( 'Blog Page Sidebar Position', 'ellie' ),
		'description' => esc_attr__('Select how you want to position your sidebar, left, right or no sidebar on the blog page' , 'ellie' ),
		'section'     => 'layout',
		'default'     => 'right',
		'priority'    => 1,
		'choices'     => array(
			'left'   => get_template_directory_uri() . '/assets/img/two-col-left.png',
			'right'  => get_template_directory_uri() . '/assets/img/two-col-right.png',
			'no'     => get_template_directory_uri() . '/assets/img/one-col.png',
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'radio-image',
		'settings'    => 'post_page_layout',
		'label'       => esc_html__( 'Single Post Sidebar Position', 'ellie' ),
		'description' => esc_attr__('Select how you want to position your sidebar, left, right or no sidebar on the post page' , 'ellie' ),
		'section'     => 'layout',
		'default'     => 'right',
		'priority'    => 1,
		'choices'     => array(
			'left'   => get_template_directory_uri() . '/assets/img/two-col-left.png',
			'right'  => get_template_directory_uri() . '/assets/img/two-col-right.png',
			'no'     => get_template_directory_uri() . '/assets/img/one-col.png',
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'radio-image',
		'settings'    => 'search_page_layout',
		'label'       => esc_html__( 'Search Results Page Sidebar Position', 'ellie' ),
		'description' => esc_attr__('Select how you want to position your sidebar, left, right or no sidebar on the search page' , 'ellie'),
		'section'     => 'layout',
		'default'     => 'right',
		'priority'    => 1,
		'choices'     => array(
			'left'   => get_template_directory_uri() . '/assets/img/two-col-left.png',
			'right'  => get_template_directory_uri() . '/assets/img/two-col-right.png',
			'no'     => get_template_directory_uri() . '/assets/img/one-col.png',
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'radio-image',
		'settings'    => 'static_page_layout',
		'label'       => esc_html__( 'Static Page Sidebar Position', 'ellie' ),
		'description' => esc_attr__('Select how you want to position your sidebar, left, right or no sidebar on the static page' , 'ellie'),
		'section'     => 'layout',
		'default'     => 'right',
		'priority'    => 1,
		'choices'     => array(
			'left'   => get_template_directory_uri() . '/assets/img/two-col-left.png',
			'right'  => get_template_directory_uri() . '/assets/img/two-col-right.png',
			'no'     => get_template_directory_uri() . '/assets/img/one-col.png',
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'radio-image',
		'settings'    => 'shop_page_layout',
		'label'       => esc_html__( 'Shop Page Sidebar Position', 'ellie' ),
		'description' => esc_attr__('Select how you want to position your sidebar, left, right or no sidebar on the shop page', 'ellie'),
		'section'     => 'layout',
		'default'     => 'left',
		'priority'    => 1,
		'choices'     => array(
			'left'   => get_template_directory_uri() . '/assets/img/two-col-left.png',
			'right'  => get_template_directory_uri() . '/assets/img/two-col-right.png',
			'no'     => get_template_directory_uri() . '/assets/img/one-col.png',
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'radio-image',
		'settings'    => 'cart_page_layout',
		'label'       => esc_html__( 'Cart Page Sidebar Position', 'ellie' ),
		'description' => esc_attr__('Select how you want to position your sidebar, left, right or no sidebar on the cart page', 'ellie'),
		'section'     => 'layout',
		'default'     => 'no',
		'priority'    => 1,
		'choices'     => array(
			'left'   => get_template_directory_uri() . '/assets/img/two-col-left.png',
			'right'  => get_template_directory_uri() . '/assets/img/two-col-right.png',
			'no'     => get_template_directory_uri() . '/assets/img/one-col.png',
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'radio-image',
		'settings'    => 'checkout_page_layout',
		'label'       => esc_html__( 'Checkout Page Sidebar Position', 'ellie' ),
		'description' => esc_attr__('Select how you want to position your sidebar, left, right or no sidebar on the checkout page', 'ellie'),
		'section'     => 'layout',
		'default'     => 'no',
		'priority'    => 1,
		'choices'     => array(
			'left'   => get_template_directory_uri() . '/assets/img/two-col-left.png',
			'right'  => get_template_directory_uri() . '/assets/img/two-col-right.png',
			'no'     => get_template_directory_uri() . '/assets/img/one-col.png',
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'radio-image',
		'settings'    => 'product_page_layout',
		'label'       => esc_html__( 'Product Page Sidebar Position', 'ellie' ),
		'description' => esc_attr__('Select how you want to position your sidebar, left, right or no sidebar on the product page', 'ellie'),
		'section'     => 'layout',
		'default'     => 'no',
		'priority'    => 1,
		'choices'     => array(
			'left'   => get_template_directory_uri() . '/assets/img/two-col-left.png',
			'right'  => get_template_directory_uri() . '/assets/img/two-col-right.png',
			'no'     => get_template_directory_uri() . '/assets/img/one-col.png',
		),
	) );

	// TODO: Add sidebar width control in PRO version

// Sidebar Layout End

// Footer Layout Start
	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'switch',
		'settings'    => 'footer_sidebar',
		'label'       => esc_html__( 'Show / Hide Footer Sidebar Section', 'ellie' ),
		'description' => esc_attr__( 'Show or Hide Footer Sidebar Section (Once disabled widgets will be removed from the sidebar)', 'ellie' ),
		'section'     => 'footer',
		'default'     => true,
		'priority'    => 1,
		'choices'     => array(
			'on'  => esc_attr__( 'Show', 'ellie' ),
			'off' => esc_attr__( 'Hide', 'ellie' ),
		),
	) );

	/*Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'color',
		'settings'    => 'footer_sidebar_background_color',
		'label'       => __( 'Links color', 'ellie' ),
		'description' => esc_attr__( 'Color for links site-wide.', 'ellie' ),
		'section'     => 'footer',
		'default'     => '#f8f8f8',
		'choices'     => array(
			'alpha' => true,
		),
		'output'   => array(
			array(
				'element'  => TZ_THEME_PREFIX.'-footer-widget-area',
				'property' => 'background-color',
			),
		),
	) );*/

// Footer Layout End

// Blog Layout Start
	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'radio',
		'settings'    => 'blog_posts_layout',
		'label'       => __( 'Blog Posts View', 'ellie' ),
		'description' => esc_attr__('Select how you want your blog posts to be displayed, list or grid view.', 'ellie'),
		'section'     => 'blog',
		'default'     => 'grid',
		'priority'    => 1,
		'choices'     => array(
			'list'   => array(
				esc_attr__( 'List', 'ellie' ),
				esc_attr__( 'Blog posts will follow one another as a list of posts', 'ellie' ),
			),
			'grid' => array(
				esc_attr__( 'Grid', 'ellie' ),
				esc_attr__( 'Blog posts will be laid out in a grid manner', 'ellie' ),
			),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'number',
		'settings'    => 'posts_per_row',
		'label'       => esc_attr__( 'Set the number of posts per row', 'ellie' ),
		'description' => esc_attr__( 'Set the number of posts you want to show per row for posts grid view', 'ellie' ),
		'section'     => 'blog',
		'active_callback' => array(
			array(
				'setting' => 'blog_posts_layout',
				'operator' => '==',
				'value' =>  'grid',
			)
		),
		'default'     => 2,
		'priority'    => 2,
		'choices'     => array(
			'min'  => 2,
			'max'  => 4,
			'step' => 1,
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'radio',
		'settings'    => 'blog_grid_layout',
		'label'       => __( 'Blog Grid View', 'ellie' ),
		'description' => esc_attr__('Select how you want your blog posts to be displayed in grid view, masonry or fit a row.', 'ellie' ),
		'section'     => 'blog',
		'default'     => 'simple',
		'priority'    => 3,
		'active_callback' => array(
			array(
				'setting' => 'blog_posts_layout',
				'operator' => '==',
				'value' =>  'grid',
			)
		),
		'choices'     => array(
			'masonry'   => array(
				esc_attr__( 'Masonry', 'ellie' ),
				esc_attr__( 'Blog will be placed by shuffle script in masonry layout', 'ellie' ),
			),
			'simple' => array(
				esc_attr__( 'Simple', 'ellie' ),
				esc_attr__( 'Blog posts will be laid out in a grid manner fitting the row', 'ellie' ),
			),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'radio',
		'settings'    => 'blog_pagination',
		'label'       => __( 'Blog Navigation Style', 'ellie' ),
		'description' => esc_attr__('Select the type of navigation on blog page, paginated or newer/older posts links.', 'ellie' ),
		'section'     => 'blog',
		'default'     => 'paginated',
		'priority'    => 3,
		'choices'     => array(
			'paginated'   => array(
				esc_attr__( 'Paginated', 'ellie' ),
				esc_attr__( 'Linked page numbers.', 'ellie' ),
			),
			'linked' => array(
				esc_attr__( 'Linked', 'ellie' ),
				esc_attr__( 'Newer and Older posts links', 'ellie' ),
			),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'image',
		'settings'    => 'blog_page_banner',
		'label'       => esc_attr__( 'Blog Page Banner', 'ellie' ),
		'description' => esc_attr__( 'Set a banner that appears on blog page.', 'ellie' ),
		'section'     => 'blog',
		'default'     => '',
		'choices'     => array(
			'save_as' => 'id',
		),
	) );

// Blog Layout End

// Post Layout Start
	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'radio',
		'settings'    => 'post_layout',
		'label'       => __( 'Post View', 'ellie' ),
		'description' => esc_attr__('Select how you want your single post page to look like', 'ellie' ),
		'section'     => 'post',
		'default'     => 'simple',
		'priority'    => 1,
		'active_callback' => array(
			array(
				'setting' => 'post_page_layout',
				'operator' => '==',
				'value' =>  'no',
			)
		),
		'choices'     => array(
			'simple'   => array(
				esc_attr__( 'Simple', 'ellie' ),
				esc_attr__( 'Standard layout with featured image above', 'ellie' ),
			),
			'modern' => array(
				esc_attr__( 'Modern', 'ellie' ),
				esc_attr__( 'Featured Image is placed as a heading block, no sidebar', 'ellie' ),
			),
		),
	) );
// Post Layout End

// Shop Layout Start
	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'number',
		'settings'    => 'products_per_row',
		'label'       => esc_attr__( 'Set the number of products per row', 'ellie' ),
		'description' => esc_attr__( 'Set the number of products you want to show per row on a product listing page', 'ellie' ),
		'section'     => 'shop',
		'default'     => 3,
		'choices'     => array(
			'min'  => 2,
			'max'  => 5,
			'step' => 1,
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'number',
		'settings'    => 'products_per_page',
		'label'       => esc_attr__( 'Set the number of products per page', 'ellie' ),
		'description' => esc_attr__( 'Set the number of products you want to show per page on a product listing page', 'ellie' ),
		'section'     => 'shop',
		'default'     => 12
	) );


	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'image',
		'settings'    => 'shop_page_banner',
		'label'       => esc_attr__( 'Shop Page Banner', 'ellie' ),
		'description' => esc_attr__( 'Set a banner that appears on shop page.', 'ellie' ),
		'section'     => 'shop',
		'default'     => '',
		'choices'     => array(
			'save_as' => 'id',
		),
	) );

	// TODO: Add switcher for grid/list view on products page in PRO version

	// TODO: Add show/hide switcher for products sorter

	// TODO: Add show/hide swithcer for "Showing - Results" section

	// TODO: Add product listing style switcher for PRO version


// Shop Layout End

// Product Layout Start
	/*Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'number',
		'settings'    => 'products_thumbnail_columns',
		'label'       => esc_attr__( 'Set the number of thumbnail columns on a product page', 'ellie' ),
		'description' => esc_attr__( 'Set the number of thumbnail columns you want to show per row on a single product page', 'ellie' ),
		'section'     => 'product',
		'default'     => 3,
		'choices'     => array(
			'min'  => 2,
			'max'  => 4,
			'step' => 1,
		),
	) );*/

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'number',
		'settings'    => 'related_products_per_page',
		'label'       => esc_attr__( 'Set the number of related products on product page', 'ellie' ),
		'description' => esc_attr__( 'Set the number of related products you want to show on a single product page', 'ellie' ),
		'section'     => 'product',
		'default'     => 4,
		'choices'     => array(
			'min'  => 2,
			'max'  => 5,
			'step' => 1,
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'number',
		'settings'    => 'related_products_per_column',
		'label'       => esc_attr__( 'Set the number of related products per row', 'ellie' ),
		'description' => esc_attr__( 'Set the number of related products per row you want to show on a single product page', 'ellie' ),
		'section'     => 'product',
		'default'     => 4,
		'choices'     => array(
			'min'  => 2,
			'max'  => 5,
			'step' => 1,
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'image',
		'settings'    => 'product_page_banner',
		'label'       => esc_attr__( 'Product Page Banner', 'ellie' ),
		'description' => esc_attr__( 'Set a banner that appears on product page.', 'ellie' ),
		'section'     => 'product',
		'default'     => '',
		'choices'     => array(
			'save_as' => 'id',
		),
	) );

	// TODO: Add option to hide related products on PRO version

	// TODO: Add styles options to display single product in PRO version

	// TODO: Add prev next product switcher functionality in PRO version

	// TODO: Add switcher for Related/Cross-sell products tabbed view in PRO version

	// single product typography start
	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'typography',
		'settings'    => 'single_product_title',
		'label'       => esc_attr__( 'Single Product page title', 'ellie' ),
		'section'     => 'product',
		'default'     => array(
			'font-family'    => 'Butler',
			'variant'        => 'normal',
			'font-size'      => '2em',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'color'          => '#000000',
			'text-transform' => 'none',
			'text-align'     => 'left'
		),
		'priority'    => 5,
		'output'      => array(
			array(
				'element' => array(
					'.single-product .product .summary .product_title',
				),
			),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'color',
		'settings'    => 'single_rating_color',
		'label'       => __( 'Single product ratings color', 'ellie' ),
		'description' => esc_attr__( 'Star ratings color on products page', 'ellie' ),
		'section'     => 'product',
		'default'     => '#f5bdb6',
		'choices'     => array(
			'alpha' => true,
		),
		'output'   => array(
			array(
				'element'  => '.single-product .product .summary .star-rating',
				'property' => 'color',
			),
		),
	) );

	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'typography',
		'settings'    => 'single_product_price',
		'label'       => esc_attr__( 'Single Product Price', 'ellie' ),
		'section'     => 'product',
		'default'     => array(
			'font-family'    => 'HK Grotesk',
			'variant'        => 'normal',
			'font-size'      => '1.25em',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'color'          => '#000000',
			'text-transform' => 'none',
			'text-align'     => 'left'
		),
		'priority'    => 5,
		'output'      => array(
			array(
				'element' => array(
					'.single-product .product .summary .price',
				),
			),
		),
	) );


	Ellie_Kirki_Customizer::add_field( TZ_THEME_PREFIX.'_theme', array(
		'type'        => 'color',
		'settings'    => 'single_product_add_to_cart_button',
		'label'       => __( 'Single Product Add to Cart button', 'ellie' ),
		'description' => esc_attr__( 'Background color for add to cart button on single product page', 'ellie' ),
		'section'     => 'product',
		'default'     => '#000000',
		'output'   => array(
			array(
				'element'  => array(
					'.single-product .product .summary .single_add_to_cart_button',
					'.single-product .single-product-reviews .review-button-cont .button'
				),
				'property' => 'background-color',
			),
		),
	) );

	// single product typography end

// Product Layout End

endif; // Ellie_Kirki_Customizer Options End