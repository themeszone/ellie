<?php
/**
 * Required Plugins Installation File
 *
 * @link https://github.com/TGMPA/TGM-Plugin-Activation
 *
 * @package ellie
 */

require_once get_template_directory() . '/inc/lib/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'ellie_register_required_plugins' );

function ellie_register_required_plugins() {

	$plugins = array(

		// Plugins recommended with a theme.
		array(
			'name'               => 'One Click Demo Import', // The plugin name.
			'slug'               => 'one-click-demo-import', // The plugin slug (typically the folder name).
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
		),

		array(
			'name'               => 'Kirki', // The plugin name.
			'slug'               => 'kirki', // The plugin slug (typically the folder name).
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
		),

		array(
			'name'               => 'WooCommerce', // The plugin name.
			'slug'               => 'woocommerce', // The plugin slug (typically the folder name).
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
		),

		array(
			'name'               => 'Elementor',
			'slug'               => 'elementor',
			'required'           => false,
		),

		array(
			'name'               => 'Smart Slider 3',
			'slug'               => 'smart-slider-3',
			'required'           => false,
		),

		array(
			'name'               => 'Contact Form 7',
			'slug'               => 'contact-form-7',
			'required'           => false,
		),

		array(
			'name'               => 'MailChimp for WordPress',
			'slug'               => 'mailchimp-for-wp',
			'required'           => false,
		),

		array(
			'name'               => 'Instagram Feed',
			'slug'               => 'instagram-feed',
			'required'           => false,
		),

	);

	$config = array(
		'id'           => 'ellie',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',          // Message to output right before the plugins table.

	);

	tgmpa( $plugins, $config );
}
