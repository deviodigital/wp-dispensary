<?php
/**
 * Adding the Custom Post Type metaboxes and taxonomies
 * to the WordPress REST API
 *
 * @link       https://www.wpdispensary.com
 * @since      1.1.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Adding featured image URL's to REST API endpoint.
 *
 * @access public
 *
 * @param object  $data
 * @param WP_Post $post    The WordPress post object.
 * @param null    $request Unused.
 *
 * @return object The featured image data.
 */
function wpd_rest_featured_image_url( $data, $post, $request ) {
	$_data                       = $data->data;
	$thumbnail_id                = get_post_thumbnail_id( $post->ID );
	$thumbnail                   = wp_get_attachment_image_src( $thumbnail_id, 'full' );
	$_data['featured_image_url'] = $thumbnail[0];
	$data->data                  = $_data;
	return $data;
}
add_filter( 'rest_prepare_products', 'wpd_rest_featured_image_url', 10, 3 );

/**
 * Adding featured image URL's to Flowers Custom Post Type
 *
 * @access public
 *
 * @param object  $data
 * @param WP_Post $post    The WordPress post object.
 * @param null    $request Unused.
 *
 * @return object The featured image data.
 */
function wpd_rest_featured_images( $data, $post, $request ) {
	$_data                             = $data->data;
	$thumbnail_id                      = get_post_thumbnail_id( $post->ID );
	$wpd_default                       = wp_get_attachment_image_src( $thumbnail_id, 'dispensary-image' );
	$wpd_thumbnail                     = wp_get_attachment_image_src( $thumbnail_id, 'wpd-thumbnail' );
	$wpd_small                         = wp_get_attachment_image_src( $thumbnail_id, 'wpd-small' );
	$wpd_medium                        = wp_get_attachment_image_src( $thumbnail_id, 'wpd-medium' );
	$wpd_large                         = wp_get_attachment_image_src( $thumbnail_id, 'wpd-large' );
	$_data['featured_image_default']   = $wpd_default[0];
	$_data['featured_image_thumbnail'] = $wpd_thumbnail[0];
	$_data['featured_image_small']     = $wpd_small[0];
	$_data['featured_image_medium']    = $wpd_medium[0];
	$_data['featured_image_large']     = $wpd_large[0];
	$data->data                        = $_data;
	return $data;
}
add_filter( 'rest_prepare_products', 'wpd_rest_featured_images', 10, 3 );

/**
 * Add 'categories' endpoint for the Products Custom Post Type
 *
 * @since 4.0
 */
function products_category_numbers( $data, $post, $request ) {

	$_data = $data->data;
	$items = wp_get_post_terms( $post->ID, 'product_category' );

	foreach ( $items as $item=>$value ) {
		$_data['categories'][$item]['id']          = $value->term_id;
		$_data['categories'][$item]['slug']        = $value->slug;
		$_data['categories'][$item]['title']       = $value->name;
		$_data['categories'][$item]['description'] = $value->description;
		$_data['categories'][$item]['count']       = $value->count;
	}

	$data->data = $_data;

	return $data;
}
add_filter( 'rest_prepare_products', 'products_category_numbers', 10, 3 );

/**
 * Add 'prices' endpoint for the Custom Post Types
 *
 * @since 2.7
 */
function wpd_product_prices_all( $data, $post, $request ) {
	$_data           = $data->data;
	$_data['prices'] = get_wpd_all_prices_simple( $post->ID, TRUE );
	$data->data      = $_data;
	return $data;
}
add_filter( 'rest_prepare_products', 'wpd_product_prices_all', 10, 3 );

/**
 * Add custom taxonomies to Products
 * 
 * @since 4.0
 */
function products_taxonomies( $data, $post, $request ) {
	$_data                 = $data->data;
	$_data['aromas']       = get_the_term_list( $post->ID, 'aroma', '', ' ', '' );
	$_data['flavors']      = get_the_term_list( $post->ID, 'flavor', '', ' ', '' );
	$_data['effects']      = get_the_term_list( $post->ID, 'effect', '', ' ', '' );
	$_data['symptoms']     = get_the_term_list( $post->ID, 'symptom', '', ' ', '' );
	$_data['conditions']   = get_the_term_list( $post->ID, 'condition', '', ' ', '' );
	$_data['shelf_types']  = get_the_term_list( $post->ID, 'shelf_type', '', ' ', '' );
	$_data['strain_types'] = get_the_term_list( $post->ID, 'strain_type', '', ' ', '' );
	$_data['vendors']      = get_the_term_list( $post->ID, 'vendor', '', ' ', '' );
	$data->data            = $_data;
	return $data;
}
add_filter( 'rest_prepare_products', 'products_taxonomies', 10, 3 );

/**
 * Add 'details' endpoint to Products
 *
 * @since 2.7
 */
function wpd_product_details_all( $data, $post, $request ) {

	// Display product details.
	$product_details = array(
		'thc'         => 'show',
		'thca'        => '',
		'cbd'         => '',
		'cba'         => '',
		'cbn'         => '',
		'cbg'         => '',
		'seed_count'  => 'show',
		'clone_count' => 'show',
		'total_thc'   => 'show',
		'size'        => 'show',
		'servings'    => 'show',
		'weight'      => 'show'
	);

	$details = apply_filters( 'wpd_product_details_all', $product_details );

	$_data            = $data->data;
	$_data['details'] = get_wpd_product_details( $post->ID, $details, 'span' );
	$data->data       = $_data;
	return $data;

}
add_filter( 'rest_prepare_products', 'wpd_product_details_all', 10, 3 );

/**
 * This adds the wpdispensary_prices metafields to the
 * API callback for flowers
 *
 * @since    1.1.0
 */

/**
 * Registering Prices
 */
function slug_register_prices() {
	$productsizes = apply_filters( 'wpd_rest_api_register_flowers_prices', array( 'price_gram', 'price_two_grams', 'price_eighth', 'price_five_grams', 'price_quarter_ounce', 'price_half_ounce', 'price_ounce' ) );
	foreach ( $productsizes as $size ) {
		register_rest_field(
			array( 'flowers' ),
			$size,
			array(
				'get_callback'    => 'slug_get_prices',
				'update_callback' => 'slug_update_prices',
				'schema'          => null,
			)
		);
	} /** /foreach */
}
add_action( 'rest_api_init', 'slug_register_prices' );

/**
 * Get Prices
 */
function slug_get_prices( $object, $field_name, $request ) {
	return get_post_meta( $object->ID, $field_name, true );
}

/**
 * Update Prices
 */
function slug_update_prices( $value, $object, $field_name ) {
	return update_post_meta( $object->ID, $field_name, $value );
}

/**
 * This adds the wpdispensary_prices metafields to the
 * API callback for concentrates
 *
 * @since    1.9.6
 */

/**
 * Registering Prices
 */
function slug_register_concentrateprices() {
	$productsizes = apply_filters( 'wpd_rest_api_register_concentrates_prices', array( 'price_each', 'price_half_gram', 'price_gram', 'price_two_grams' ) );
	foreach ( $productsizes as $size ) {
		register_rest_field(
			array( 'concentrates' ),
			$size,
			array(
				'get_callback'    => 'slug_get_concentrateprices',
				'update_callback' => 'slug_update_concentrateprices',
				'schema'          => null,
			)
		);
	} /** /foreach */
}
add_action( 'rest_api_init', 'slug_register_concentrateprices' );

/**
 * Get Prices
 */
function slug_get_concentrateprices( $object, $field_name, $request ) {
	return get_post_meta( $object->ID, $field_name, true );
}

/**
 * Update Prices
 */
function slug_update_concentrateprices( $value, $object, $field_name ) {
	return update_post_meta( $object->ID, $field_name, $value );
}

/**
 * This adds the metafields to the API
 * callback for edibles
 *
 * @since    1.1.0
 */

/**
 * Register Edible information
 */
function slug_register_edibleinfo() {
	$edibleinformation = apply_filters( 'wpd_rest_api_register_edibles_info', array( 'compounds_thc', 'product_servings', 'price_each', 'units_per_pack', 'price_per_pack' ) );
	foreach ( $edibleinformation as $edibleinfo ) {
		register_rest_field(
			'edibles',
			$edibleinfo,
			array(
				'get_callback'    => 'slug_get_edibleinfo',
				'update_callback' => 'slug_update_edibleinfo',
				'schema'          => null,
			)
		);
	} /** /foreach */
}
add_action( 'rest_api_init', 'slug_register_edibleinfo' );

/**
 * Get Edible info
 */
function slug_get_edibleinfo( $object, $field_name, $request ) {
	return get_post_meta( $object->ID, $field_name, true );
}

/**
 * Update Edible info
 */
function slug_update_edibleinfo( $value, $object, $field_name ) {
	return update_post_meta( $object->ID, $field_name, $value );
}

/**
 * This adds the metafields to the API
 * callback for pre-rolls
 *
 * @since    1.1.0
 */

/**
 * Register Pre-roll info
 */
function slug_register_prerollinfo() {
	$prerollinformation = apply_filters( 'wpd_rest_api_register_prerolls_info', array( 'price_each', 'product_flower', 'units_per_pack', 'price_per_pack', 'product_weight' ) );
	foreach ( $prerollinformation as $prerollinfo ) {
		register_rest_field(
			'prerolls',
			$prerollinfo,
			array(
				'get_callback'    => 'slug_get_prerollinfo',
				'update_callback' => 'slug_update_prerollinfo',
				'schema'          => null,
			)
		);
	} /** /foreach */
}
add_action( 'rest_api_init', 'slug_register_prerollinfo' );

/**
 * Get Pre-roll info
 */
function slug_get_prerollinfo( $object, $field_name, $request ) {
	return get_post_meta( $object->ID, $field_name, true );
}

/**
 * Update Pre-roll info
 */
function slug_update_prerollinfo( $value, $object, $field_name ) {
	return update_post_meta( $object->ID, $field_name, $value );
}

/**
 * This adds the wpdispensary_compounds metafields to the
 * API callback for flowers & concentrates
 *
 * @since    1.9.9
 */

/**
 * Register compound details info
 */
function slug_register_compounds() {
	/**
	 * @todo add function instead of array.
	 */
	$compounds = array( 'compound_thc', 'compound_thca', 'compound_cbd', 'compound_cba', 'compound_cbn', 'compound_cbg' );
	foreach ( $compounds as $compound ) {
		register_rest_field(
			array( 'flowers', 'concentrates' ),
			$compound,
			array(
				'get_callback'    => 'slug_get_compounds',
				'update_callback' => 'slug_update_compounds',
				'schema'          => null,
			)
		);
	} /** /foreach */
}
add_action( 'rest_api_init', 'slug_register_compounds' );

/**
 * Get Compound info
 */
function slug_get_compounds( $object, $field_name, $request ) {
	return get_post_meta( $object->ID, $field_name, true );
}

/**
 * Update Compound info
 */
function slug_update_compounds( $value, $object, $field_name ) {
	return update_post_meta( $object->ID, $field_name, $value );
}

/**
 * This adds the metafields to the API
 * callback for topicals
 *
 * @since    1.4.0
 */

/**
 * Register Topical info
 */
function slug_register_topicalinfo() {
	$topicalinformation = apply_filters( 'wpd_rest_api_register_topicals_info', array( 'price_each', 'units_per_pack', 'price_per_pack', 'compound_thc', 'compound_cbd', 'product_size' ) );
	foreach ( $topicalinformation as $topicalinfo ) {
		register_rest_field(
			'topicals',
			$topicalinfo,
			array(
				'get_callback'    => 'slug_get_topicalinfo',
				'update_callback' => 'slug_update_topicalinfo',
				'schema'          => null,
			)
		);
	} /** /foreach */
}
add_action( 'rest_api_init', 'slug_register_topicalinfo' );

/**
 * Get Topical info
 */
function slug_get_topicalinfo( $object, $field_name, $request ) {
	return get_post_meta( $object->ID, $field_name, true );
}

/**
 * Update Topical info
 */
function slug_update_topicalinfo( $value, $object, $field_name ) {
	return update_post_meta( $object->ID, $field_name, $value );
}

/**
 * This adds the metafields to the API
 * callback for growers
 *
 * @since    1.7.0
 */

/**
 * Register Grower info
 */
function slug_register_growerinfo() {
	$growerinformation = apply_filters( 'wpd_rest_api_register_growers_info', array( 'price_each', 'units_per_pack', 'price_per_pack', 'product_flower', 'seed_count', 'clone_count', 'product_time', 'product_origin', 'product_yield', 'product_difficulty' ) );
	foreach ( $growerinformation as $growerinfo ) {
		register_rest_field(
			'growers',
			$growerinfo,
			array(
				'get_callback'    => 'slug_get_growerinfo',
				'update_callback' => 'slug_update_growerinfo',
				'schema'          => null,
			)
		);
	} /** /foreach */
}
add_action( 'rest_api_init', 'slug_register_growerinfo' );

/**
 * Get Grower info
 */
function slug_get_growerinfo( $object, $field_name, $request ) {
	return get_post_meta( $object->ID, $field_name, true );
}

/**
 * Update Grower info
 */
function slug_update_growerinfo( $value, $object, $field_name ) {
	return update_post_meta( $object->ID, $field_name, $value );
}
