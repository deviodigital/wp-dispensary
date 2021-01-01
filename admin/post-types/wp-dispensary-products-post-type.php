<?php
/**
 * Adding the Products post type
 *
 * @link       https://www.wpdispensary.com
 * @since      4.0.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Products post type
 *
 * Add custom type for Products
 *
 * @since    4.0.0
 */
function wp_dispensary_products_post_type() {

	// Get permalink base for Products.
	$wpd_products_slug = get_option( 'wpd_products_slug' );

	// If custom base is empty, set default.
	if ( '' == $wpd_products_slug ) {
		$wpd_products_slug = 'products';
	}

	// Capitalize first letter of new slug.
	$wpd_products_slug_cap = ucfirst( $wpd_products_slug );

	$rewrite = array(
		'slug'       => $wpd_products_slug,
		'with_front' => true,
		'pages'      => true,
		'feeds'      => true,
	);

	$labels = array(
		'name'                  => sprintf( esc_html__( '%s', 'Post Type General Name', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'singular_name'         => sprintf( esc_html__( '%s', 'Post Type Singular Name', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'menu_name'             => sprintf( esc_html__( '%s', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'name_admin_bar'        => sprintf( esc_html__( '%s', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'archives'              => sprintf( esc_html__( '%s Archives', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'parent_item_colon'     => sprintf( esc_html__( 'Parent %s:', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'all_items'             => sprintf( esc_html__( 'All %s', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'add_new_item'          => sprintf( esc_html__( 'Add New %s', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'add_new'               => esc_html__( 'Add New', 'wp-dispensary' ),
		'new_item'              => sprintf( esc_html__( 'New %s', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'edit_item'             => sprintf( esc_html__( 'Edit %s', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'update_item'           => sprintf( esc_html__( 'Update %s', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'view_item'             => sprintf( esc_html__( 'View %s', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'search_items'          => sprintf( esc_html__( 'Search %s', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'not_found'             => esc_html__( 'Not found', 'wp-dispensary' ),
		'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'wp-dispensary' ),
		'featured_image'        => esc_html__( 'Featured Image', 'wp-dispensary' ),
		'set_featured_image'    => esc_html__( 'Set featured image', 'wp-dispensary' ),
		'remove_featured_image' => esc_html__( 'Remove featured image', 'wp-dispensary' ),
		'use_featured_image'    => esc_html__( 'Use as featured image', 'wp-dispensary' ),
		'insert_into_item'      => sprintf( esc_html__( 'Insert into %s', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'uploaded_to_this_item' => sprintf( esc_html__( 'Uploaded to this %s', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'items_list'            => sprintf( esc_html__( '%s list', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'items_list_navigation' => sprintf( esc_html__( '%s list navigation', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'filter_items_list'     => sprintf( esc_html__( 'Filter %s list', 'wp-dispensary' ), $wpd_products_slug ),
	);

	$args = array(
		'label'               => sprintf( esc_html__( '%s', 'wp-dispensary' ), $wpd_products_slug_cap ),
		'description'         => sprintf( esc_html__( 'Display the %s from your menu', 'wp-dispensary' ), $wpd_products_slug ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions' ),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => false,
		'show_in_rest'        => true,
		'menu_position'       => 10,
		'menu_icon'           => plugin_dir_url( __FILE__ ) . ( '../images/menu-icon.png' ),
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'post',
	);

	register_post_type( 'products', $args );
}
add_action( 'init', 'wp_dispensary_products_post_type', 0 );
