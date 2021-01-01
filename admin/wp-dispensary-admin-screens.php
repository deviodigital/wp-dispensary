<?php
/**
 * Adding custom functions and filters for the admin dashboard screens
 *
 * @link       https://www.wpdispensary.com
 * @since      1.9.16
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin
 */

/** Creates new featured image column */
function wp_dispensary_columns( $columns ) {

	$wpd_columns = array();
	$title       = 'cb';

	foreach ( $columns as $key => $value ) {
		$wpd_columns[$key] = $value;
		if ( $key == $title ) {
			$wpd_columns['featured_thumb'] = '<span class="dashicons dashicons-format-image"></span><span class="wpd-admin-screen-featured-image-title">Featured image</span>';
		}
	}

	return $wpd_columns;
}
add_filter( 'wpd_manage_posts_custom_column', 'wp_dispensary_columns' );

/**
 * Adds the featured image to the column
 * 
 * @return void
 */
function wp_dispensary_columns_data( $column ) {
	switch ( $column ) {
		case 'featured_thumb':
			echo '<a href="' . get_edit_post_link() . '">';
			echo the_post_thumbnail( array( 40, 40 ) );
			echo '</a>';
			break;
	}
}

/**
 * Add thumbnails to post_type screen for WPD menu types.
 * 
 * @return void
 */
if ( isset( $_GET['post_type'] ) ) {
	// Get post type.
	$post_type = esc_html( $_GET['post_type'] );
	// Get post types.
	$post_types = wpd_menu_types_simple( true );
	// Add products to post types array.
	$post_types[] = 'products';

	// Add actions and filters if post type is a WPD Menu type.
	if ( in_array( $post_type, apply_filters( 'wpd_admin_screen_thumbnails', $post_types ) ) ) {
		add_filter( 'manage_posts_columns', 'wp_dispensary_columns' );
		add_action( 'manage_posts_custom_column', 'wp_dispensary_columns_data', 10, 1 );
		add_filter( 'manage_pages_columns', 'wp_dispensary_columns' );
		add_action( 'manage_pages_custom_column', 'wp_dispensary_columns_data', 10, 1 );
	}
}

/**
 * Hide specific metaboxes by default.
 * 
 * @return void
 */
function hide_meta_box( $hidden, $screen ) {
	//make sure we are dealing with the correct screen.
	if ( ( 'post' == $screen->base ) && ( 'flowers' == $screen->id ) ) {
		$hidden = array( 'postexcerpt', 'slugdiv', 'postcustom', 'trackbacksdiv', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv' );
	} elseif ( ( 'post' == $screen->base ) && ( 'concentrates' == $screen->id ) ) {
		$hidden = array( 'postexcerpt', 'slugdiv', 'postcustom', 'trackbacksdiv', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv' );
	} elseif ( ( 'post' == $screen->base ) && ( 'edibles' == $screen->id ) ) {
		$hidden = array( 'postexcerpt', 'slugdiv', 'postcustom', 'trackbacksdiv', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv' );
	} elseif ( ( 'post' == $screen->base ) && ( 'prerolls' == $screen->id ) ) {
		$hidden = array( 'postexcerpt', 'slugdiv', 'postcustom', 'trackbacksdiv', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv' );
	} elseif ( ( 'post' == $screen->base ) && ( 'topicals' == $screen->id ) ) {
		$hidden = array( 'postexcerpt', 'slugdiv', 'postcustom', 'trackbacksdiv', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv' );
	} elseif ( ( 'post' == $screen->base ) && ( 'growers' == $screen->id ) ) {
		$hidden = array( 'postexcerpt', 'slugdiv', 'postcustom', 'trackbacksdiv', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv' );
	} else {}
	return $hidden;
}
add_filter( 'default_hidden_meta_boxes', 'hide_meta_box', 10, 2 );

// Rearrange metabox order on Flowers edit screen.
function flowers_metabox_order( $order ) {
	return array(
		'normal' => join(
			',',
			array(
				'wpdispensary_prices',
				'wpdispensary_compounds',
			)
		),
	);
}
add_filter( 'get_user_option_meta-box-order_flowers', 'flowers_metabox_order' );

// Rearrange metabox order on Edibles edit screen.
function edibles_metabox_order( $order ) {
	return array(
		'side' => join(
			',',
			array(
				'submitdiv',
			)
		),
		'normal' => join(
			',',
			array(
				'wpdispensary_singleprices',
			)
		),
	);
}
add_filter( 'get_user_option_meta-box-order_edibles', 'edibles_metabox_order' );

// Rearrange metabox order on Pre-rolls edit screen.
function prerolls_metabox_order( $order ) {
	return array(
		'side' => join(
			',',
			array(
				'submitdiv',
				'select-flowers-metabox',
			)
		),
		'normal' => join(
			',',
			array(
				'wpdispensary_singleprices',
			)
		),
	);
}
add_filter( 'get_user_option_meta-box-order_prerolls', 'prerolls_metabox_order' );

// Rearrange metabox order on Growers edit screen.
function growers_metabox_order( $order ) {
	return array(
		'side' => join(
			',',
			array(
				'submitdiv',
				'select-flowers-metabox',
			)
		),
		'normal' => join(
			',',
			array(
				'wpdispensary_singleprices',
			)
		),
	);
}
add_filter( 'get_user_option_meta-box-order_growers', 'growers_metabox_order' );

/**
 * Remove specific taxonomies from columns on menu type screen.
 * 
 * @since 2.3
 */
function wpd_remove_taxonomies_from_admin_columns( $columns ) {
    // remove aroma taxonomy column.
    unset( $columns['taxonomy-aroma'] );
    // remove flavor taxonomy column.
    unset( $columns['taxonomy-flavor'] );
    // remove effect taxonomy column.
    unset( $columns['taxonomy-effect'] );
    // remove symptom taxonomy column.
    unset( $columns['taxonomy-symptom'] );
    // remove condition taxonomy column.
    unset( $columns['taxonomy-condition'] );
    // remove ingredients taxonomy column.
    unset( $columns['taxonomy-ingredients'] );
    // remove allergens taxonomy column.
	unset( $columns['taxonomy-allergens'] );
	
	/**
	 * @todo add the old category taxonomies to unset list.
	 */

	return $columns;
}
add_filter( 'manage_edit-products_columns', 'wpd_remove_taxonomies_from_admin_columns' );
add_filter( 'manage_edit-flowers_columns', 'wpd_remove_taxonomies_from_admin_columns' );
add_filter( 'manage_edit-concentrates_columns', 'wpd_remove_taxonomies_from_admin_columns' );
add_filter( 'manage_edit-edibles_columns', 'wpd_remove_taxonomies_from_admin_columns' );
add_filter( 'manage_edit-topicals_columns', 'wpd_remove_taxonomies_from_admin_columns' );
