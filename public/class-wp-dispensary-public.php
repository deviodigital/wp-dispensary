<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.wpdispensary.com
 * @since      1.0.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/public
 * @author     WP Dispensary <contact@wpdispensary.com>
 */
class WP_Dispensary_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 *
	 * @param string $plugin_name   The name of the plugin.
	 * @param string $version       The version of this plugin.
	 *
	 * @return void
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-dispensary-public.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-dispensary-public.js', array( 'jquery' ), $this->version, false );
	}
}

/**
 * Register WP Dispensary's oEmbed stylesheet
 */
function wpd_oembed_styles() {

	wp_register_style( 'wpd-oembed', plugin_dir_url( __FILE__ ) . 'css/wp-dispensary-oembed.css', false, $this->version );
	wp_enqueue_style( 'wpd-oembed' );

}
add_action( 'enqueue_embed_scripts', 'wpd_oembed_styles' );

/**
 * Add wp-dispensary body class to related pages.
 * 
 * @since 2.5
 */
function wp_dispensary_body_class( $classes ) {
	global $post;

	// Add classes to a page that has the WP Dispensary shortcode present.
    if ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'wpd_menu' ) ) {
		$classes[] = 'wp-dispensary';
	}
	// Add wp-dispensary class name to multiple areas of the website.
	if ( is_singular( 'products' ) || is_post_type_archive( 'products' ) || is_category( 'wpd_categories' ) ) {
		$classes[] = 'wp-dispensary';
	}
	// Add wpd-single class name to singular products.
	if ( is_singular( 'products' ) ) {
		$classes[] = 'wpd-single';
	}
	// Add wpd-products class name to products and category archives.
	if ( is_post_type_archive( 'products' ) || is_category( 'wpd_categories' ) ) {
		$classes[] = 'wpd-archive';
	}
	return $classes; 
}
add_filter( 'body_class', 'wp_dispensary_body_class' );
