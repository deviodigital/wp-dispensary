<?php
/**
 * The Class responsible for defining the custom permalink settings.
 *
 * @link       https://www.wpdispensary.com
 * @since      2.2
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin
 */
class WP_Dispensary_Permalink_Settings {
	/**
	 * Initialize class.
	 */
	public function __construct() {
		$this->init();
		$this->settings_save();
	}

	/**
	 * Call register fields.
	 */
	public function init() {
		add_filter( 'admin_init', array( &$this, 'register_wpd_settings_fields' ) );
	}

	/**
	 * Add Flowers setting to permalinks page.
	 */
	public function register_wpd_settings_fields() {
		// Register Flowers slug.
		register_setting( 'permalink', 'wpd_products_slug', 'esc_attr' );
		add_settings_field( 'wpd_products_slug', '<label for="wpd_products_slug">' . esc_html__( 'Products Base', 'wp-dispensary' ) . '</label>', array( &$this, 'wpd_products_fields_html' ), 'permalink', 'optional' );
		// Register Flowers slug.
		register_setting( 'permalink', 'wpd_flowers_slug', 'esc_attr' );
		add_settings_field( 'wpd_flowers_slug', '<label for="wpd_flowers_slug">' . esc_html__( 'Flowers Base', 'wp-dispensary' ) . '</label>', array( &$this, 'wpd_flowers_fields_html' ), 'permalink', 'optional' );
		// Register Concentrates slug.
		register_setting( 'permalink', 'wpd_concentrates_slug', 'esc_attr' );
		add_settings_field( 'wpd_concentrates_slug', '<label for="wpd_concentrates_slug">' . esc_html__( 'Concentrates Base', 'wp-dispensary' ) . '</label>', array( &$this, 'wpd_concentrates_fields_html' ), 'permalink', 'optional' );
		// Register Edibles slug.
		register_setting( 'permalink', 'wpd_edibles_slug', 'esc_attr' );
		add_settings_field( 'wpd_edibles_slug', '<label for="wpd_edibles_slug">' . esc_html__( 'Edibles Base', 'wp-dispensary' ) . '</label>', array( &$this, 'wpd_edibles_fields_html' ), 'permalink', 'optional' );
		// Register Pre-rolls slug.
		register_setting( 'permalink', 'wpd_prerolls_slug', 'esc_attr' );
		add_settings_field( 'wpd_prerolls_slug', '<label for="wpd_prerolls_slug">' . esc_html__( 'Pre-rolls Base', 'wp-dispensary' ) . '</label>', array( &$this, 'wpd_prerolls_fields_html' ), 'permalink', 'optional' );
		// Register Topicals slug.
		register_setting( 'permalink', 'wpd_topicals_slug', 'esc_attr' );
		add_settings_field( 'wpd_topicals_slug', '<label for="wpd_topicals_slug">' . esc_html__( 'Topicals Base', 'wp-dispensary' ) . '</label>', array( &$this, 'wpd_topicals_fields_html' ), 'permalink', 'optional' );
		// Register Growers slug.
		register_setting( 'permalink', 'wpd_growers_slug', 'esc_attr' );
		add_settings_field( 'wpd_growers_slug', '<label for="wpd_growers_slug">' . esc_html__( 'Growers Base', 'wp-dispensary' ) . '</label>', array( &$this, 'wpd_growers_fields_html' ), 'permalink', 'optional' );
	}

	/**
	 * HTML for Products permalink setting.
	 */
	public function wpd_products_fields_html() {
		$wpd_products_slug = get_option( 'wpd_products_slug' );
		echo '<input type="text" class="regular-text code" id="wpd_products_slug" name="wpd_products_slug" placeholder="products" value="' . esc_attr( $wpd_products_slug ) . '" />';
	}

	/**
	 * HTML for Flowers permalink setting.
	 */
	public function wpd_flowers_fields_html() {
		$wpd_flowers_slug = get_option( 'wpd_flowers_slug' );
		echo '<input type="text" class="regular-text code" id="wpd_flowers_slug" name="wpd_flowers_slug" placeholder="flowers" value="' . esc_attr( $wpd_flowers_slug ) . '" />';
	}

	/**
	 * HTML for Concentrates permalink setting.
	 */
	public function wpd_concentrates_fields_html() {
		$wpd_concentrates_slug = get_option( 'wpd_concentrates_slug' );
		echo '<input type="text" class="regular-text code" id="wpd_concentrates_slug" name="wpd_concentrates_slug" placeholder="concentrates" value="' . esc_attr( $wpd_concentrates_slug ) . '" />';
	}

	/**
	 * HTML for Edibles permalink setting.
	 */
	public function wpd_edibles_fields_html() {
		$wpd_edibles_slug = get_option( 'wpd_edibles_slug' );
		echo '<input type="text" class="regular-text code" id="wpd_edibles_slug" name="wpd_edibles_slug" placeholder="edibles" value="' . esc_attr( $wpd_edibles_slug ) . '" />';
	}

	/**
	 * HTML for Pre-rolls permalink setting.
	 */
	public function wpd_prerolls_fields_html() {
		$wpd_prerolls_slug = get_option( 'wpd_prerolls_slug' );
		echo '<input type="text" class="regular-text code" id="wpd_prerolls_slug" name="wpd_prerolls_slug" placeholder="prerolls" value="' . esc_attr( $wpd_prerolls_slug ) . '" />';
	}

	/**
	 * HTML for Topicals permalink setting.
	 */
	public function wpd_topicals_fields_html() {
		$wpd_topicals_slug = get_option( 'wpd_topicals_slug' );
		echo '<input type="text" class="regular-text code" id="wpd_topicals_slug" name="wpd_topicals_slug" placeholder="topicals" value="' . esc_attr( $wpd_topicals_slug ) . '" />';
	}

	/**
	 * HTML for Growers permalink setting.
	 */
	public function wpd_growers_fields_html() {
		$wpd_growers_slug = get_option( 'wpd_growers_slug' );
		echo '<input type="text" class="regular-text code" id="wpd_growers_slug" name="wpd_growers_slug" placeholder="growers" value="' . esc_attr( $wpd_growers_slug ) . '" />';
	}

	/**
	 * Save permalink settings.
	 */
	public function settings_save() {
		if ( ! is_admin() ) {
			return;
		}

		// Save settings - Products.
		if ( isset( $_POST['permalink_structure'] ) ||
			 isset( $_POST['wpd_products_slug'] ) &&
			 wp_verify_nonce( wp_unslash( $_POST['wpd_permalinks_nonce'] ), 'wp-dispensary' ) ) {
				$wpd_products_slug = sanitize_title( wp_unslash( $_POST['wpd_products_slug'] ) );
				update_option( 'wpd_products_slug', $wpd_products_slug );
		}
		// Save settings - Flowers.
		if ( isset( $_POST['permalink_structure'] ) ||
			 isset( $_POST['wpd_flowers_slug'] ) &&
			 wp_verify_nonce( wp_unslash( $_POST['wpd_permalinks_nonce'] ), 'wp-dispensary' ) ) {
				$wpd_flowers_slug = sanitize_title( wp_unslash( $_POST['wpd_flowers_slug'] ) );
				update_option( 'wpd_flowers_slug', $wpd_flowers_slug );
		}
		// Save settings - Concentrates.
		if ( isset( $_POST['permalink_structure'] ) ||
			 isset( $_POST['wpd_concentrates_slug'] ) &&
			 wp_verify_nonce( wp_unslash( $_POST['wpd_permalinks_nonce'] ), 'wp-dispensary' ) ) {
				$wpd_concentrates_slug = sanitize_title( wp_unslash( $_POST['wpd_concentrates_slug'] ) );
				update_option( 'wpd_concentrates_slug', $wpd_concentrates_slug );
		}
		// Save settings - Edibles.
		if ( isset( $_POST['permalink_structure'] ) ||
			 isset( $_POST['wpd_edibles_slug'] ) &&
			 wp_verify_nonce( wp_unslash( $_POST['wpd_permalinks_nonce'] ), 'wp-dispensary' ) ) {
				$wpd_edibles_slug = sanitize_title( wp_unslash( $_POST['wpd_edibles_slug'] ) );
				update_option( 'wpd_edibles_slug', $wpd_edibles_slug );
		}
		// Save settings - Pre-rolls.
		if ( isset( $_POST['permalink_structure'] ) ||
			 isset( $_POST['wpd_prerolls_slug'] ) &&
			 wp_verify_nonce( wp_unslash( $_POST['wpd_permalinks_nonce'] ), 'wp-dispensary' ) ) {
				$wpd_prerolls_slug = sanitize_title( wp_unslash( $_POST['wpd_prerolls_slug'] ) );
				update_option( 'wpd_prerolls_slug', $wpd_prerolls_slug );
		}
		// Save settings - Topicals.
		if ( isset( $_POST['permalink_structure'] ) ||
			 isset( $_POST['wpd_topicals_slug'] ) &&
			 wp_verify_nonce( wp_unslash( $_POST['wpd_permalinks_nonce'] ), 'wp-dispensary' ) ) {
				$wpd_topicals_slug = sanitize_title( wp_unslash( $_POST['wpd_topicals_slug'] ) );
				update_option( 'wpd_topicals_slug', $wpd_topicals_slug );
		}
		// Save settings - Growers.
		if ( isset( $_POST['permalink_structure'] ) ||
			 isset( $_POST['wpd_growers_slug'] ) &&
			 wp_verify_nonce( wp_unslash( $_POST['wpd_permalinks_nonce'] ), 'wp-dispensary' ) ) {
				$wpd_growers_slug = sanitize_title( wp_unslash( $_POST['wpd_growers_slug'] ) );
				update_option( 'wpd_growers_slug', $wpd_growers_slug );
		}
	}
}
$wp_dispensary_permalink_settings = new WP_Dispensary_Permalink_Settings();
