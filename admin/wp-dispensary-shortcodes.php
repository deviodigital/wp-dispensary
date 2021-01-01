<?php
/**
 * Adding the Shortcodes for easy output of content
 * within any theme
 *
 * @link       https://www.wpdispensary.com
 * @since      1.2.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin
 */

/**
 * Add custom image sizes.
 *
 * @since 1.0
 */
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'dispensary-image', 360, 250, true );
	add_image_size( 'wpd-large', 1200, 1200, true );
	add_image_size( 'wpd-medium', 800, 800, true );
	add_image_size( 'wpd-small', 400, 400, true );
	add_image_size( 'wpd-thumbnail', 50, 50, true );
}

/**
 * WP Dispensary Menu Shortcode
 *
 * @access public
 *
 * @return string HTML markup.
 *
 * @since 2.6
 */
function wp_dispensary_menu_shortcode( $atts ) {

	// Menu types (string).
	$menu_types = implode ( ', ', wpd_menu_types( true ) );

	// Attributes.
	extract( shortcode_atts(
		array(
			'title'       => 'show',
			'posts'       => '100',
			'id'          => '',
			'class'       => '',
			'name'        => 'show',
			'price'       => 'show',
			'info'        => 'show',
			'thc'         => 'show',
			'thca'        => '',
			'cbd'         => '',
			'cba'         => '',
			'cbn'         => '',
			'cbg'         => '',
			'thcmg'       => '',
			'thc_topical' => '',
			'aroma'       => '',
			'flavor'      => '',
			'effect'      => '',
			'symptom'     => '',
			'condition'   => '',
			'vendor'      => '',
			'category'    => '',
			'shelf_type'  => '',
			'strain_type' => '',
			'total_thc'   => 'show',
			'weight'      => 'show',
			'seed_count'  => 'show',
			'clone_count' => 'show',
			'size'        => 'show',
			'servings'    => '',
			'order'       => 'DESC',
			'orderby'     => '',
			'meta_key'    => '',
			'type'        => $menu_types,
			'image'       => 'show',
			'image_size'  => 'wpd-small',
			'viewall'     => '',
			'carousel'    => ''
		),
		$atts,
		'wpd_menu'
	) );

	// Default variables.
	$order_new    = '';
	$wpd_products = '';
	$wpd_image    = '';
	$img_size     = 'dispensary-image';
	$show_title   = '';
	$show_name    = '';
	$show_price   = '';
	$show_info    = '';

	// Create $tax_query variable.
	$tax_query = array(
		'relation' => 'AND',
	);

	// Add aromas to $tax_query.
	if ( '' !== $aroma ) {
		$tax_query[] = array(
			'taxonomy' => 'aroma',
			'field'    => 'slug',
			'terms'    => $aroma,
		);
	}

	// Add flavors to $tax_query.
	if ( '' !== $flavor ) {
		$tax_query[] = array(
			'taxonomy' => 'flavor',
			'field'    => 'slug',
			'terms'    => $flavor,
		);
	}

	// Add effects to $tax_query.
	if ( '' !== $effect ) {
		$tax_query[] = array(
			'taxonomy' => 'effect',
			'field'    => 'slug',
			'terms'    => $effect,
		);
	}

	// Add symptoms to $tax_query.
	if ( '' !== $symptom ) {
		$tax_query[] = array(
			'taxonomy' => 'symptom',
			'field'    => 'slug',
			'terms'    => $symptom,
		);
	}

	// Add conditions to $tax_query.
	if ( '' !== $condition ) {
		$tax_query[] = array(
			'taxonomy' => 'condition',
			'field'    => 'slug',
			'terms'    => $condition,
		);
	}

	// Add vendors to $tax_query.
	if ( '' !== $vendor ) {
		$tax_query[] = array(
			'taxonomy' => 'vendor',
			'field'    => 'slug',
			'terms'    => $vendor,
		);
	}

	// Add shelf types to $tax_query.
	if ( '' !== $shelf_type ) {
		$tax_query[] = array(
			'taxonomy' => 'shelf_type',
			'field'    => 'slug',
			'terms'    => $shelf_type,
		);
	}

	// Add strain types to $tax_query.
	if ( '' !== $strain_type ) {
		$tax_query[] = array(
			'taxonomy' => 'strain_type',
			'field'    => 'slug',
			'terms'    => $strain_type,
		);
	}

	// Create $cat_tax_query variable.
	$cat_tax_query = array(
		'relation' => 'OR',
	);

	// Turn shortcode type="" input into an array.
	$array_type = explode( ', ', $type );

	// Turn shortcode category="" input into an array.
	$new_category = explode( ', ', $category );

	if ( ! empty( $category ) ) {	
		// Add product categories to $cat_tax_query.
		$cat_tax_query[] = array(
			'taxonomy' => 'wpd_categories',
			'field'    => 'name',
			'terms'    => $new_category,
		);
	}

	// Create new tax query.
	$new_tax_query = array_merge( $tax_query, $cat_tax_query );

	// Menu types.
	$menu_types = apply_filters( 'wpd_shortcode_menu_types', $array_type );

	// Loop through menu types.
	foreach ( $menu_types as $key=>$value ) {

		if ( empty( $meta_key ) ) {
			$meta_query = array(
				array(
					'key'     => 'product_type',
					'value'   => $value,
					'compare' => '=',
				)
			);
		} else {
			$meta_query = array(
				array(
					'key' => $meta_key,
				)
			);
		}

		// Create WP_Query args.
		$args = apply_filters( 'wpd_menu_shortcode_args', array(
			'post_type'      => 'products',
			'posts_per_page' => $posts,
			'tax_query'      => $new_tax_query,
			'orderby'        => $orderby,
			'order'          => $order,
			'meta_query'     => $meta_query,
		) );

		// Create new WP_Query.
		$wpd_query = new WP_Query( $args );

		// Menu type name.
		$menu_type_name = wpd_product_type_display_name( $value );

		// Image size.
		if ( $image_size ) {
			$img_size = $image_size;
		}

		// Product details.
		$product_details = array(
			'thc'         => $thc,
			'thca'        => $thca,
			'cbd'         => $cbd,
			'cba'         => $cba,
			'cbn'         => $cbn,
			'cbg'         => $cbg,
			'seed_count'  => $seed_count,
			'clone_count' => $clone_count,
			'total_thc'   => $total_thc,
			'size'        => $size,
			'servings'    => $servings,
			'weight'      => $weight
		);

		// Display Title.
		if ( 'show' === $title ) {
			$show_title = '<h2 class="wpd-title">' . $menu_type_name . '</h2>';
		}

		// Product start wrap.
		if ( 'on' === $carousel ) {
			// Prodfuct wrap start.
			$wpd_products .= '<div id="' . $id . '" class="carouselwrap">' . $show_title . '<div class="wpd-carousel">';
		} else {
			// Product wrap start.
			$wpd_products .= '<div id="' . $id . '" class="wp-dispensary">' . $show_title . '<div class="wpd-menu">';
		}

		// Product loop.
		while ( $wpd_query->have_posts() ) :
			$wpd_query->the_post();

			// Show name.
			if ( 'show' === $name ) {
				$show_name = '<h2 class="wpd-producttitle"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
			}

			// Show Price.
			if ( 'show' === $price ) {
				$show_price = '<span class="wpd-productinfo pricing"><strong>' . esc_html( get_wpd_pricing_phrase( $singular = true ) ) . ':</strong> ' . get_wpd_all_prices_simple( get_the_ID() ) . '</span>';
				// Filter price.
				$show_price = apply_filters( 'wpd_shortcodes_product_price', $show_price );
			}

			// Show info.
			if ( 'show' === $info ) {
				$show_info = get_wpd_product_details( get_the_ID(), $product_details, 'span' );
			}

			// Set image if set to show.
			if ( 'show' === $image ) {
				$wpd_image = get_wpd_product_image( get_the_ID(), $img_size );
			}

			// Shortcode inside top action hook.
			ob_start();
				do_action( 'wpd_shortcode_inside_top' );
				$wpd_inside_top = ob_get_contents();
			ob_end_clean();

			// Shortcode menu top action hook.
			ob_start();
				do_action( 'wpd_shortcode_top_menu' );
				$wpd_menu_top = ob_get_contents();
			ob_end_clean();

			if ( 'on' === $carousel ) {
				// Shortcode item start.
				$wpd_products .= '<div class="carousel-item ' . $class . '">' . $wpd_menu_top . $wpd_inside_top . $wpd_image;
			} else {
				// Shortcode item start.
				$wpd_products .= '<div class="wpd-menu-item ' . $class . '">' . $wpd_menu_top . $wpd_inside_top . $wpd_image;
			}

			// Shortcode inside bottom action hook.
			ob_start();
				do_action( 'wpd_shortcode_inside_bottom' );
				$wpd_inside_bottom = ob_get_contents();
			ob_end_clean();

			// Shortcode menu top action hook.
			ob_start();
				do_action( 'wpd_shortcode_bottom_menu' );
				$wpd_menu_bottom = ob_get_contents();
			ob_end_clean();

			// Shortcode item.
			$wpd_products .= $show_name . $show_price . $show_info . $wpd_inside_bottom . $wpd_menu_bottom;

			// Shortcode item end.
			$wpd_products .= '</div>';

		endwhile;

		wp_reset_postdata();

		// Shortcode inside top action hook.
		$wpd_products .= '</div>';

	}

	// Product wrap end.
	$wpd_products .= '</div>';

	return $wpd_products;
}
add_shortcode( 'wpd_menu', 'wp_dispensary_menu_shortcode' );
