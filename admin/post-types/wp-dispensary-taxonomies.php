<?php
/**
 * The file that defines the taxonomies used by the various custom post types
 *
 * @link       https://www.wpdispensary.com
 * @since      1.0.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin/post-types
 */

/**
 * Product Category Taxonomy
 *
 * Adds the default Category taxonomy to all custom post types
 *
 * @since    4.0
 */
function wp_dispensary_products_categories() {

	$labels = array(
		'name'              => _x( 'Categories', 'taxonomy general name', 'wp-dispensary' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name', 'wp-dispensary' ),
		'search_items'      => __( 'Search Categories', 'wp-dispensary' ),
		'all_items'         => __( 'All Categories', 'wp-dispensary' ),
		'parent_item'       => __( 'Parent Category', 'wp-dispensary' ),
		'parent_item_colon' => __( 'Parent Category:', 'wp-dispensary' ),
		'edit_item'         => __( 'Edit Category', 'wp-dispensary' ),
		'update_item'       => __( 'Update Category', 'wp-dispensary' ),
		'add_new_item'      => __( 'Add New Category', 'wp-dispensary' ),
		'new_item_name'     => __( 'New Category Name', 'wp-dispensary' ),
		'not_found'         => __( 'No categories found', 'wp-dispensary' ),
		'menu_name'         => __( 'Categories', 'wp-dispensary' ),
	);

	register_taxonomy( 'wpd_categories', 'products', array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'product-category',
			'with_front' => true,
		),
	) );

}
add_action( 'init', 'wp_dispensary_products_categories', 0 );

/**
 * Shelf Type
 *
 * Adds the Shelf Type taxonomy to specific custom post types
 *
 * @since    2.1.0
 */
function wp_dispensary_shelf_type() {

	$labels = array(
		'name'              => _x( 'Shelf Type', 'taxonomy general name', 'wp-dispensary' ),
		'singular_name'     => _x( 'Shelf Type', 'taxonomy singular name', 'wp-dispensary' ),
		'search_items'      => __( 'Search Shelf Types', 'wp-dispensary' ),
		'all_items'         => __( 'All Shelf Types', 'wp-dispensary' ),
		'parent_item'       => __( 'Parent Shelf Type', 'wp-dispensary' ),
		'parent_item_colon' => __( 'Parent Shelf Type:', 'wp-dispensary' ),
		'edit_item'         => __( 'Edit Shelf Type', 'wp-dispensary' ),
		'update_item'       => __( 'Update Shelf Type', 'wp-dispensary' ),
		'add_new_item'      => __( 'Add New Shelf Type', 'wp-dispensary' ),
		'new_item_name'     => __( 'New Shelf Type Name', 'wp-dispensary' ),
		'not_found'         => __( 'No shelf types found', 'wp-dispensary' ),
		'menu_name'         => __( 'Shelf Type', 'wp-dispensary' ),
	);

	register_taxonomy( 'shelf_type', 'products', array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'shelf-type',
			'with_front' => false,
		),
	) );

}
add_action( 'init', 'wp_dispensary_shelf_type', 0 );

/**
 * Strain Type
 *
 * Adds the Strain Type taxonomy to specific custom post types
 *
 * @since    2.3.0
 */
function wp_dispensary_strain_type() {

	$labels = array(
		'name'              => _x( 'Strain Type', 'taxonomy general name', 'wp-dispensary' ),
		'singular_name'     => _x( 'Strain Type', 'taxonomy singular name', 'wp-dispensary' ),
		'search_items'      => __( 'Search Strain Types', 'wp-dispensary' ),
		'all_items'         => __( 'All Strain Types', 'wp-dispensary' ),
		'parent_item'       => __( 'Parent Strain Type', 'wp-dispensary' ),
		'parent_item_colon' => __( 'Parent Strain Type:', 'wp-dispensary' ),
		'edit_item'         => __( 'Edit Strain Type', 'wp-dispensary' ),
		'update_item'       => __( 'Update Strain Type', 'wp-dispensary' ),
		'add_new_item'      => __( 'Add New Strain Type', 'wp-dispensary' ),
		'new_item_name'     => __( 'New Strain Type Name', 'wp-dispensary' ),
		'not_found'         => __( 'No strain types found', 'wp-dispensary' ),
		'menu_name'         => __( 'Strain Type', 'wp-dispensary' ),
	);

	register_taxonomy( 'strain_type', 'products', array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'strain-type',
			'with_front' => false,
		),
	) );

}
add_action( 'init', 'wp_dispensary_strain_type', 0 );

/**
 * Vendor Taxonomy
 *
 * Adds the Vendor taxonomy to all custom post types
 *
 * @since    1.9.11
 */
function wp_dispensary_vendor() {

	$labels = array(
		'name'                       => _x( 'Vendors', 'general name', 'wp-dispensary' ),
		'singular_name'              => _x( 'Vendor', 'singular name', 'wp-dispensary' ),
		'search_items'               => __( 'Search Vendors', 'wp-dispensary' ),
		'popular_items'              => __( 'Popular Vendors', 'wp-dispensary' ),
		'all_items'                  => __( 'All Vendors', 'wp-dispensary' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Vendor', 'wp-dispensary' ),
		'update_item'                => __( 'Update Vendor', 'wp-dispensary' ),
		'add_new_item'               => __( 'Add New Vendor', 'wp-dispensary' ),
		'new_item_name'              => __( 'New Vendor Name', 'wp-dispensary' ),
		'separate_items_with_commas' => __( 'Separate vendors with commas', 'wp-dispensary' ),
		'add_or_remove_items'        => __( 'Add or remove vendors', 'wp-dispensary' ),
		'choose_from_most_used'      => __( 'Choose from the most used vendors', 'wp-dispensary' ),
		'not_found'                  => __( 'No vendors found', 'wp-dispensary' ),
		'menu_name'                  => __( 'Vendors', 'wp-dispensary' ),
	);

	register_taxonomy( 'vendor', 'products', array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'show_admin_column'     => true,
		'show_in_nav_menus'     => true,
		'query_var'             => true,
		'update_count_callback' => '_update_post_term_count',
		'rewrite'               => array(
			'slug' => 'vendor',
		),
	) );

}
add_action( 'init', 'wp_dispensary_vendor', 0 );

/**
 * Aroma Taxonomy
 *
 * Adds the Aroma taxonomy to all custom post types
 *
 * @since    1.0.0
 */
function wp_dispensary_aroma() {

	$labels = array(
		'name'                       => _x( 'Aromas', 'general name', 'wp-dispensary' ),
		'singular_name'              => _x( 'Aroma', 'singular name', 'wp-dispensary' ),
		'search_items'               => __( 'Search Aromas', 'wp-dispensary' ),
		'popular_items'              => __( 'Popular Aromas', 'wp-dispensary' ),
		'all_items'                  => __( 'All Aromas', 'wp-dispensary' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Aroma', 'wp-dispensary' ),
		'update_item'                => __( 'Update Aroma', 'wp-dispensary' ),
		'add_new_item'               => __( 'Add New Aroma', 'wp-dispensary' ),
		'new_item_name'              => __( 'New Aroma Name', 'wp-dispensary' ),
		'separate_items_with_commas' => __( 'Separate aromas with commas', 'wp-dispensary' ),
		'add_or_remove_items'        => __( 'Add or remove aromas' , 'wp-dispensary'),
		'choose_from_most_used'      => __( 'Choose from the most used aromas', 'wp-dispensary' ),
		'not_found'                  => __( 'No aromas found', 'wp-dispensary' ),
		'menu_name'                  => __( 'Aromas', 'wp-dispensary' ),
	);

	register_taxonomy( 'aroma', 'products', array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'show_admin_column'     => true,
		'show_in_nav_menus'     => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array(
			'slug' => 'aroma',
		),
	) );

}
add_action( 'init', 'wp_dispensary_aroma', 0 );

/**
 * Flavor Taxonomy
 *
 * Adds the Flavor taxonomy to all custom post types
 *
 * @since    1.0.0
 */
function wp_dispensary_flavor() {

	$labels = array(
		'name'                       => _x( 'Flavors', 'general name', 'wp-dispensary' ),
		'singular_name'              => _x( 'Flavor', 'singular name', 'wp-dispensary' ),
		'search_items'               => __( 'Search Flavors', 'wp-dispensary' ),
		'popular_items'              => __( 'Popular Flavors', 'wp-dispensary' ),
		'all_items'                  => __( 'All Flavors', 'wp-dispensary' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Flavor', 'wp-dispensary' ),
		'update_item'                => __( 'Update Flavor', 'wp-dispensary' ),
		'add_new_item'               => __( 'Add New Flavor', 'wp-dispensary' ),
		'new_item_name'              => __( 'New Flavor Name', 'wp-dispensary' ),
		'separate_items_with_commas' => __( 'Separate flavors with commas', 'wp-dispensary' ),
		'add_or_remove_items'        => __( 'Add or remove flavors', 'wp-dispensary' ),
		'choose_from_most_used'      => __( 'Choose from the most used flavors', 'wp-dispensary' ),
		'not_found'                  => __( 'No flavors found', 'wp-dispensary' ),
		'menu_name'                  => __( 'Flavors', 'wp-dispensary' ),
	);

	register_taxonomy( 'flavor', 'products', array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'show_admin_column'     => true,
		'show_in_nav_menus'     => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array(
			'slug' => 'flavor',
		),
	) );
}
add_action( 'init', 'wp_dispensary_flavor', 0 );

/**
 * Effect Taxonomy
 *
 * Adds the Effect taxonomy to all custom post types
 *
 * @since    1.0.0
 */
function wp_dispensary_effect() {

	$labels = array(
		'name'                       => _x( 'Effects', 'general name', 'wp-dispensary' ),
		'singular_name'              => _x( 'Effect', 'singular name', 'wp-dispensary' ),
		'search_items'               => __( 'Search Effects', 'wp-dispensary' ),
		'popular_items'              => __( 'Popular Effects', 'wp-dispensary' ),
		'all_items'                  => __( 'All Effects', 'wp-dispensary' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Effect', 'wp-dispensary' ),
		'update_item'                => __( 'Update Effect', 'wp-dispensary' ),
		'add_new_item'               => __( 'Add New Effect', 'wp-dispensary' ),
		'new_item_name'              => __( 'New Effect Name', 'wp-dispensary' ),
		'separate_items_with_commas' => __( 'Separate effects with commas', 'wp-dispensary' ),
		'add_or_remove_items'        => __( 'Add or remove effects', 'wp-dispensary' ),
		'choose_from_most_used'      => __( 'Choose from the most used effects', 'wp-dispensary' ),
		'not_found'                  => __( 'No effects found', 'wp-dispensary' ),
		'menu_name'                  => __( 'Effects', 'wp-dispensary' ),
	);

	register_taxonomy( 'effect', 'products', array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'show_admin_column'     => true,
		'show_in_nav_menus'     => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array(
			'slug' => 'effect',
		),
	) );
}
add_action( 'init', 'wp_dispensary_effect', 0 );

/**
 * Symptom Taxonomy
 *
 * Adds the Symptom taxonomy to all custom post types
 *
 * @since    1.0.0
 */
function wp_dispensary_symptom() {

	$labels = array(
		'name'                       => _x( 'Symptoms', 'general name', 'wp-dispensary' ),
		'singular_name'              => _x( 'Symptom', 'singular name', 'wp-dispensary' ),
		'search_items'               => __( 'Search Symptoms', 'wp-dispensary' ),
		'popular_items'              => __( 'Popular Symptoms', 'wp-dispensary' ),
		'all_items'                  => __( 'All Symptoms', 'wp-dispensary' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Symptom', 'wp-dispensary' ),
		'update_item'                => __( 'Update Symptom', 'wp-dispensary' ),
		'add_new_item'               => __( 'Add New Symptom', 'wp-dispensary' ),
		'new_item_name'              => __( 'New Symptom Name', 'wp-dispensary' ),
		'separate_items_with_commas' => __( 'Separate symptoms with commas', 'wp-dispensary' ),
		'add_or_remove_items'        => __( 'Add or remove symptoms', 'wp-dispensary' ),
		'choose_from_most_used'      => __( 'Choose from the most used symptoms', 'wp-dispensary' ),
		'not_found'                  => __( 'No symptoms found', 'wp-dispensary' ),
		'menu_name'                  => __( 'Symptoms', 'wp-dispensary' ),
	);

	register_taxonomy( 'symptom', 'products', array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'show_admin_column'     => true,
		'show_in_nav_menus'     => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array(
			'slug' => 'symptom',
		),
	) );
}
add_action( 'init', 'wp_dispensary_symptom', 0 );

/**
 * Condition Taxonomy
 *
 * Adds the Condition taxonomy to all custom post types
 *
 * @since    1.0.0
 */
function wp_dispensary_condition() {

	$labels = array(
		'name'                       => _x( 'Conditions', 'general name', 'wp-dispensary' ),
		'singular_name'              => _x( 'Condition', 'singular name', 'wp-dispensary' ),
		'search_items'               => __( 'Search Conditions', 'wp-dispensary' ),
		'popular_items'              => __( 'Popular Conditions', 'wp-dispensary' ),
		'all_items'                  => __( 'All Conditions', 'wp-dispensary' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Condition', 'wp-dispensary' ),
		'update_item'                => __( 'Update Condition', 'wp-dispensary' ),
		'add_new_item'               => __( 'Add New Condition', 'wp-dispensary' ),
		'new_item_name'              => __( 'New Condition Name', 'wp-dispensary' ),
		'separate_items_with_commas' => __( 'Separate conditions with commas', 'wp-dispensary' ),
		'add_or_remove_items'        => __( 'Add or remove conditions', 'wp-dispensary' ),
		'choose_from_most_used'      => __( 'Choose from the most used conditions', 'wp-dispensary' ),
		'not_found'                  => __( 'No conditions found', 'wp-dispensary' ),
		'menu_name'                  => __( 'Conditions', 'wp-dispensary' ),
	);

	register_taxonomy( 'condition', 'products', array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'show_admin_column'     => true,
		'show_in_nav_menus'     => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array(
			'slug' => 'condition',
		),
	) );
}
add_action( 'init', 'wp_dispensary_condition', 0 );

/**
 * Ingredient Taxonomy
 *
 * Adds the Ingredient taxonomy to all custom post types
 *
 * @since    1.0.0
 */
function wp_dispensary_ingredient() {

	$labels = array(
		'name'                       => _x( 'Ingredients', 'general name', 'wp-dispensary' ),
		'singular_name'              => _x( 'Ingredient', 'singular name', 'wp-dispensary' ),
		'search_items'               => __( 'Search Ingredients', 'wp-dispensary' ),
		'popular_items'              => __( 'Popular Ingredients', 'wp-dispensary' ),
		'all_items'                  => __( 'All Ingredients', 'wp-dispensary' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Ingredient', 'wp-dispensary' ),
		'update_item'                => __( 'Update Ingredient', 'wp-dispensary' ),
		'add_new_item'               => __( 'Add New Ingredient', 'wp-dispensary' ),
		'new_item_name'              => __( 'New Ingredient Name', 'wp-dispensary' ),
		'separate_items_with_commas' => __( 'Separate ingredients with commas', 'wp-dispensary' ),
		'add_or_remove_items'        => __( 'Add or remove ingredients', 'wp-dispensary' ),
		'choose_from_most_used'      => __( 'Choose from the most used ingredients', 'wp-dispensary' ),
		'not_found'                  => __( 'No ingredients found', 'wp-dispensary' ),
		'menu_name'                  => __( 'Ingredients', 'wp-dispensary' ),
	);

	register_taxonomy( 'ingredients', 'products', array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'show_admin_column'     => true,
		'show_in_nav_menus'     => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array(
			'slug' => 'ingredient',
		),
	) );
}
add_action( 'init', 'wp_dispensary_ingredient', 0 );

/**
 * Allergens Taxonomy
 *
 * Adds the Allergens taxonomy to specific custom post types
 *
 * @since    2.3.0
 */
function wp_dispensary_allergens() {

	$labels = array(
		'name'                       => _x( 'Allergens', 'general name', 'wp-dispensary' ),
		'singular_name'              => _x( 'Allergen', 'singular name', 'wp-dispensary' ),
		'search_items'               => __( 'Search Allergens', 'wp-dispensary' ),
		'popular_items'              => __( 'Popular Allergens', 'wp-dispensary' ),
		'all_items'                  => __( 'All Allergens', 'wp-dispensary' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Allergen', 'wp-dispensary' ),
		'update_item'                => __( 'Update Allergen', 'wp-dispensary' ),
		'add_new_item'               => __( 'Add New Allergen', 'wp-dispensary' ),
		'new_item_name'              => __( 'New Allergen Name', 'wp-dispensary' ),
		'separate_items_with_commas' => __( 'Separate allergens with commas', 'wp-dispensary' ),
		'add_or_remove_items'        => __( 'Add or remove allergens', 'wp-dispensary' ),
		'choose_from_most_used'      => __( 'Choose from the most used allergens', 'wp-dispensary' ),
		'not_found'                  => __( 'No allergens found', 'wp-dispensary' ),
		'menu_name'                  => __( 'Allergens', 'wp-dispensary' ),
	);

	register_taxonomy( 'allergens', 'products', array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'show_admin_column'     => false,
		'show_in_nav_menus'     => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array(
			'slug' => 'allergens',
		),
	) );

}
add_action( 'init', 'wp_dispensary_allergens', 0 );
