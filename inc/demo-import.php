<?php

if ( ! function_exists('ellie_ocdi_import_files' ) ) {
	function ellie_ocdi_import_files()
	{
		return array(
			array(
				'import_file_name' => 'Demo Import',
				'categories' => array('Category 1', 'Category 2'),
				'import_file_url' => get_template_directory_uri() . '/dummy-data/ellie_lite_content.xml',
				'import_widget_file_url' => get_template_directory_uri() . '/dummy-data/ellie_lite_widgets.wie',
				'import_customizer_file_url' => get_template_directory_uri() . '/dummy-data/ellie_options.dat',
				'import_preview_image_url' => get_template_directory_uri() . '/screenshot.png',
				'import_notice' => esc_html__('After you import this demo, you will have to setup the slider separately.', 'ellie'),
				'preview_url' => 'http://ellie.themes.zone',
			),
		);
	}
}

add_filter( 'pt-ocdi/import_files', 'ellie_ocdi_import_files' );

/* Disable thumbs regeneration for faster installation */
add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

if ( ! function_exists( 'ellie_after_import_setup' ) ) {

	function ellie_after_import_setup(){

		// Assign menus to their locations.
		$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
		$footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );
		set_theme_mod( 'nav_menu_locations', array(
				'menu-main' => $main_menu->term_id,
				'footer-menu' => $footer_menu->term_id,
			)
		);

		// Assign front page and posts page (blog page).
		$front_page_id = get_page_by_title( 'Home Page' );
		$blog_page_id  = get_page_by_title( 'Blog' );
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
		update_option( 'page_for_posts', $blog_page_id->ID );

		// Elementor Options
		update_option('elementor_container_width', '1380');
		update_option('elementor_disable_color_schemes', 'yes');
		update_option('elementor_disable_typography_schemes', 'yes');

	}

}

add_action( 'pt-ocdi/after_import', 'ellie_after_import_setup' );