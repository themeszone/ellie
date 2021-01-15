<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 26/01/2018
 * Time: 20:22
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'TZ_Theme_Helper' ) ) :

	class TZ_Theme_Helper
	{
		// Menu Helper Function Start
		public static function split_menu($items, $args){
			if ( in_array($args->theme_location, apply_filters( TZ_THEME_PREFIX.'_menu_to_split', array() ) ) ) {
				$header_layout = get_theme_mod( 'header_layout', 'center' );
				if ( class_exists('DOMDocument') && ( $header_layout == 'center' ) && $items ){
					$dom = new DOMDocument();
					if ( function_exists('libxml_use_internal_errors') ) libxml_use_internal_errors(true);
					$dom->loadHTML('<?xml encoding="'.get_bloginfo( 'charset' ).'"?>' .$items);
					foreach ($dom->getElementsByTagName('body')->item(0)->childNodes as $node) {
						if ($node->nodeType === XML_ELEMENT_NODE) {
							$menu_items[] = $dom->saveHTML($node);
						}
					}
					$size = count($menu_items);
					if ( $size ) {
						$half = (int) ceil( $size / 2 );
						$menu_items[$half - 1] .= '</ul>';
						$ul_wrap = sprintf( $args->items_wrap, ( ($args->menu_id) ? $args->menu_id .'-right' : 'menu-'.$args->menu->slug.'-right' ), $args->menu_class.' right-part ', '___' );
						$ul_wrap = str_replace('___</ul>', '', $ul_wrap);
						$menu_items[$half - 1] .= $ul_wrap;
					}
					return implode($menu_items);
				}
			}
			return $items;
		}
		// Menu Helper Function End

		// Layout Helper Functions

		public static function is_blog(){
			return (
				(is_archive() && !self::is_shop() )
				|| is_author()
				|| ( is_category() && !self::is_shop() )
				|| is_home()
				|| ( is_tag() && !self::is_shop() )
			);
		}

		public static function is_blog_post(){
			return (
				self::is_blog() || self::is_post()
			);
		}

		public static function is_post(){
			return is_singular('post');
		}

		public static function is_page(){
			return (
				is_singular('page')
				&& (!self::is_woocommerce())
				&& (!self::is_cart())
				&& (!self::is_checkout())
			);
		}

		public static function is_search(){
			return is_search();
		}

		public static function is_archive(){
			return is_archive();
		}

		public static function is_shop() {
			if ( ! class_exists( 'WooCommerce' ) ) return false;
			return (
				is_shop()
				|| is_product_category()
				|| is_product_tag()
			);
		}

		public static function is_product() {
			if ( ! class_exists( 'WooCommerce' ) ) return false;
			return is_product();
		}

		public static function is_cart() {
			if ( ! class_exists( 'WooCommerce' ) ) return false;
			return is_cart();
		}

		public static function is_checkout(){
			if ( ! class_exists( 'WooCommerce' ) ) return false;
			return is_checkout();
		}

		public static function is_account(){
			if ( ! class_exists( 'WooCommerce' ) ) return false;
			return is_account_page();
		}

		public static function is_woocommerce(){
			if ( ! function_exists('is_woocommerce' ) ) return false;
			return is_woocommerce();
		}

		public static function is_order_tracking(){
			if ( ! function_exists('is_woocommerce' ) ) return false;
			return is_page( 'order' );
		}

		public static function is_elementor(){
			if ( class_exists( 'Elementor\Plugin' ) ) {
				if ( is_singular() && Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() ) ) return true;
			}
			return false;
		}

		public static function is_404(){
			return is_404();
		}

		// Layout Helper Functions End
	}

endif;