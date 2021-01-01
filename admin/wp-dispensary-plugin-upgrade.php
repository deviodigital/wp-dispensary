<?php
/**
 * These functions are run conditionally during plugin upgrade
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
 * @todo double check that these upgrades work with post types removed
 * 
 * If they aren't working, create a deprecated-post-types.php file for the old post types to go into
 * 
 * These deprecated files can be deleted when Version 5.0 is released, to make sure all upgrades
 * work witin the time that 4.0 and 5.0 versions are released.
 */

/**
 * Convert Product Data during Version 4.0 upgrade.
 */
function wpd_convert_product_data() {
    // Update category taxonomies.
	convert_taxonomies( 'flowers', 'flowers_category', 'wpd_categories' );
	convert_taxonomies( 'concentrates', 'concentrates_category', 'wpd_categories' );
	convert_taxonomies( 'edibles', 'edibles_category', 'wpd_categories' );
	convert_taxonomies( 'prerolls', 'flowers_category', 'wpd_categories' );
	convert_taxonomies( 'topicals', 'topicals_category', 'wpd_categories' );
	convert_taxonomies( 'growers', 'growers_category', 'wpd_categories' );
	convert_taxonomies( 'gear', 'wpd_gear_category', 'wpd_categories' );
	convert_taxonomies( 'tinctures', 'wpd_tinctures_category', 'wpd_categories' );

    // Update post type metadata.
	convert_metadata( 'flowers' );
	convert_metadata( 'concentrates' );
	convert_metadata( 'edibles' );
	convert_metadata( 'prerolls' );
	convert_metadata( 'topicals' );
	convert_metadata( 'growers' );
	convert_metadata( 'gear' );
	convert_metadata( 'tinctures' );

	// Update post types.
	convert_post_types();
}
