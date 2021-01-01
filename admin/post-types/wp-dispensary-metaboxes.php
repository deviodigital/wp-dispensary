<?php
/**
 * The file that defines the metaboxes used by the various custom post types
 *
 * @link       https://www.wpdispensary.com
 * @since      1.0.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin/post-types
 */

/**
 * Product Type metabox
 *
 * Adds the product type metabox to specific custom post types
 *
 * @since    4.0
 */
function wp_dispensary_add_product_type_meta() {
	add_meta_box(
		'wp_dispensary_product_types',
		esc_html__( 'Product type', 'wp-dispensary' ),
		'wp_dispensary_product_types',
		'products',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'wp_dispensary_add_product_type_meta' );

/**
 * Building the metabox
 */
function wp_dispensary_product_types() {
	global $post;

	/** Noncename needed to verify where the data originated */
	echo '<input type="hidden" name="product_type_meta_noncename" id="product_type_meta_noncename" value="' .
	wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

	/** Get the product type data if its already been entered */
	$product_type = get_post_meta( $post->ID, 'product_type', true );

	$div  = '<div class="wpd-product-type-meta">';
	$div .= '<select name="product_type" id="product_type">';
	$div .= '<option value="">--</option>';
	// Loop through product types.
	foreach ( wpd_menu_types_simple( true ) as $key=>$name ) {
		// Empty var.
		$selected = '';
		// Check if current loop item is the same as the saved product_type.
		if ( $name == $product_type ) {
			$selected = 'selected';
		}
		// Product type display name.
		$product_type_name = wpd_product_type_display_name( $name );
		$div .= '<option ' . $selected . ' value="' . $name . '">' . $product_type_name  . '</option>';
	}
	$div .= '</select>';
	$div .= '</div>';

	echo $div;
}

/**
 * Save the Metabox Data
 */
function wp_dispensary_save_product_type_meta( $post_id, $post ) {

	/**
	 * Verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times
	 */
	if (
		! isset( $_POST['product_type_meta_noncename' ] ) ||
		! wp_verify_nonce( $_POST['product_type_meta_noncename'], plugin_basename( __FILE__ ) )
	) {
		return $post->ID;
	}

	/** Is the user allowed to edit the post or page? */
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post->ID;
	}

	/**
	 * OK, we're authenticated: we need to find and save the data
	 * We'll put it into an array to make it easier to loop though.
	 */

	$product_type_meta['product_type'] = $_POST['product_type'];

	/** Add product type meta as custom fields */

	foreach ( $product_type_meta as $key => $value ) { /** Cycle through the $product_type_meta array! */
		if ( 'revision' === $post->post_type ) { /** Don't store custom data twice */
			return;
		}
		$value = implode( ',', (array) $value ); // If $value is an array, make it a CSV (unlikely)
		if ( get_post_meta( $post->ID, $key, false ) ) { // If the custom field already has a value.
			update_post_meta( $post->ID, $key, $value );
		} else { // If the custom field doesn't have a value.
			add_post_meta( $post->ID, $key, $value );
		}
		if ( ! $value ) { /** Delete if blank */
			delete_post_meta( $post->ID, $key );
		}
	}

}
add_action( 'save_post', 'wp_dispensary_save_product_type_meta', 1, 2 ); // Save the custom fields.


/**
 * Flower Prices metabox
 *
 * Adds the Prices metabox to specific custom post types
 *
 * @since    1.0.0
 */
function wpdispensary_add_prices_metaboxes() {

	add_meta_box(
		'wpdispensary_prices',
		esc_html__( 'Product pricing', 'wp-dispensary' ),
		'wpdispensary_prices',
		'products',
		'normal',
		'default'
	);

}
add_action( 'add_meta_boxes', 'wpdispensary_add_prices_metaboxes' );

/**
 * WP Dispensary Prices
 */
function wpdispensary_prices() {
	global $post;

	/**
	 * @todo add filters for Heavyweights add-on to use.
	 */

	/** Noncename needed to verify where the data originated */
	echo '<input type="hidden" name="pricesmeta_noncename" id="pricesmeta_noncename" value="' .
	wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

	/** Get the prices data if its already been entered */
	$gram          = get_post_meta( $post->ID, 'price_gram', true );
	$two_grams     = get_post_meta( $post->ID, 'price_half_gram', true );
	$eighth        = get_post_meta( $post->ID, 'price_eighth', true );
	$five_grams    = get_post_meta( $post->ID, 'price_five_grams', true );
	$quarter_ounce = get_post_meta( $post->ID, 'price_quarter_ounce', true );
	$half_ounce    = get_post_meta( $post->ID, 'price_half_ounce', true );
	$ounce         = get_post_meta( $post->ID, 'price_ounce', true );

	/** Echo out the fields */
	echo '<div class="pricebox">';
	echo '<p>' . __( '1 g', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="price_gram" value="' . esc_html( $gram ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="pricebox">';
	echo '<p>' . __( '2 g', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="price_two_grams" value="' . esc_html( $two_grams ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="pricebox">';
	echo '<p>' . __( '1/8 oz', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="price_eighth" value="' . esc_html( $eighth ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="pricebox">';
	echo '<p>' . __( '5 g', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="price_five_grams" value="' . esc_html( $five_grams ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="pricebox">';
	echo '<p>' . __( '1/4 oz', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="price_quarter_ounce" value="' . esc_html( $quarter_ounce ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="pricebox">';
	echo '<p>' . __( '1/2 oz', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="price_half_ounce" value="' . esc_html( $half_ounce ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="pricebox">';
	echo '<p>' . __( '1 oz', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="_ounce" value="' . esc_html( $ounce ) . '" class="widefat" />';
	echo '</div>';

}

/**
 * Save the Metabox Data
 */
function wpdispensary_save_prices_meta( $post_id, $post ) {

	/**
	 * Verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times
	 */
	if (
		! isset( $_POST['pricesmeta_noncename' ] ) ||
		! wp_verify_nonce( $_POST['pricesmeta_noncename'], plugin_basename( __FILE__ ) )
	) {
		return $post->ID;
	}

	/** Is the user allowed to edit the post or page? */
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post->ID;
	}

	/**
	 * OK, we're authenticated: we need to find and save the data
	 * We'll put it into an array to make it easier to loop though.
	 */

	$prices_meta['price_gram']          = esc_html( $_POST['price_gram'] );
	$prices_meta['price_half_gram']     = esc_html( $_POST['price_half_gram'] );
	$prices_meta['price_eighth']        = esc_html( $_POST['price_eighth'] );
	$prices_meta['price_five_grams']    = esc_html( $_POST['price_five_grams'] );
	$prices_meta['price_quarter_ounce'] = esc_html( $_POST['price_quarter_ounce'] );
	$prices_meta['price_half_ounce']    = esc_html( $_POST['price_half_ounce'] );
	$prices_meta['price_ounce']         = esc_html( $_POST['price_ounce'] );

	/** Add values of $prices_meta as custom fields */

	foreach ( $prices_meta as $key => $value ) { /** Cycle through the $prices_meta array! */
		if ( 'revision' === $post->post_type ) { /** Don't store custom data twice */
			return;
		}
		$value = implode( ',', (array) $value ); /** If $value is an array, make it a CSV (unlikely) */
		if ( get_post_meta( $post->ID, $key, false ) ) { /** If the custom field already has a value */
			update_post_meta( $post->ID, $key, $value );
		} else { /** If the custom field doesn't have a value */
			add_post_meta( $post->ID, $key, $value );
		}
		if ( ! $value ) { /** Delete if blank */
			delete_post_meta( $post->ID, $key );
		}
	}

}
add_action( 'save_post', 'wpdispensary_save_prices_meta', 1, 2 ); /** Save the custom fields */


/**
 * Concentrate Prices metabox
 *
 * Adds the Prices metabox to Concentrates menu type
 *
 * @since    1.9.6
 */
function wpdispensary_add_concentrateprices_metaboxes() {

	add_meta_box(
		'wpdispensary_concentrateprices',
		__( 'Product pricing', 'wp-dispensary' ),
		'wpdispensary_concentrateprices',
		'products',
		'normal',
		'default'
	);

}
add_action( 'add_meta_boxes', 'wpdispensary_add_concentrateprices_metaboxes' );

/**
 * WP Dispensary Concentrate Prices
 */
function wpdispensary_concentrateprices() {
	global $post;

	/**
	 * @todo add filter for Heavyweights add-on.
	 */

	/** Noncename needed to verify where the data originated */
	echo '<input type="hidden" name="concentratepricesmeta_noncename" id="concentratepricesmeta_noncename" value="' .
	wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

	/** Get the prices data if its already been entered */
	$price_each = get_post_meta( $post->ID, 'price_each', true );
	$half_gram  = get_post_meta( $post->ID, 'price_half_gram', true );
	$gram       = get_post_meta( $post->ID, 'price_gram', true );
	$two_grams  = get_post_meta( $post->ID, 'price_two_grams', true );

	/** Echo out the fields */
	echo '<div class="pricebox">';
	echo '<p>' . __( 'Price each', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="price_each" value="' . esc_html( $price_each ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="pricebox">';
	echo '<p>' . __( '1/2 g', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="price_half_gram" value="' . esc_html( $half_gram ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="pricebox">';
	echo '<p>' . __( '1 g', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="price_gram" value="' . esc_html( $gram ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="pricebox">';
	echo '<p>' . __( '2 g', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="price_two_grams" value="' . esc_html( $two_grams ) . '" class="widefat" />';
	echo '</div>';

}

/**
 * Save the Metabox Data
 */
function wpdispensary_save_concentrateprices_meta( $post_id, $post ) {

	/**
	 * Verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times
	 */
	if (
		! isset( $_POST['concentratepricesmeta_noncename'] ) ||
		! wp_verify_nonce( $_POST['concentratepricesmeta_noncename'], plugin_basename( __FILE__ ) )
	) {
		return $post->ID;
	}

	/** Is the user allowed to edit the post or page? */
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post->ID;
	}

	/**
	 * OK, we're authenticated: we need to find and save the data
	 * We'll put it into an array to make it easier to loop though.
	 */

	$concentrateprices_meta['price_each']      = esc_html( $_POST['price_each'] );
	$concentrateprices_meta['price_half_gram'] = esc_html( $_POST['price_half_gram'] );
	$concentrateprices_meta['price_gram']      = esc_html( $_POST['price_gram'] );
	$concentrateprices_meta['price_two_grams'] = esc_html( $_POST['price_two_grams'] );

	/** Add values of $prices_meta as custom fields */

	foreach ( $concentrateprices_meta as $key => $value ) { /** Cycle through the $prices_meta array! */
		if ( 'revision' === $post->post_type ) { /** Don't store custom data twice */
			return;
		}
		$value = implode( ',', (array) $value ); /** If $value is an array, make it a CSV (unlikely) */
		if ( get_post_meta( $post->ID, $key, false ) ) { /** If the custom field already has a value */
			update_post_meta( $post->ID, $key, $value );
		} else { /** If the custom field doesn't have a value */
			add_post_meta( $post->ID, $key, $value );
		}
		if ( ! $value ) { /** Delete if blank */
			delete_post_meta( $post->ID, $key );
		}
	}

}
add_action( 'save_post', 'wpdispensary_save_concentrateprices_meta', 1, 2 ); /** Save the custom fields */


/**
 * Pre-Roll Flower Type metabox
 *
 * Adds the Flower Type metabox to all the pre-roll custom post type
 *
 * @since    1.0.0
 */
class WPDispensary_Prerolls {
	var $FOR_POST_TYPE     = 'prerolls';
	var $SELECT_POST_TYPE  = 'flowers';
	var $SELECT_POST_LABEL = 'Flower';
	var $box_id;
	var $box_label;
	var $field_id;
	var $field_label;
	var $field_name;
	var $meta_key;
	function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}
	function admin_init() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		$this->meta_key    = "_selected_{$this->SELECT_POST_TYPE}";
		$this->box_id      = "select-{$this->SELECT_POST_TYPE}-metabox";
		$this->field_id    = "selected_{$this->SELECT_POST_TYPE}";
		$this->field_name  = "selected_{$this->SELECT_POST_TYPE}";
		$this->box_label   = __( 'Pre-roll strain', 'wp-dispensary' );
		$this->field_label = __( "Choose {$this->SELECT_POST_LABEL}", 'wp-dispensary' );
	}
	/**
	 * Add meta boxes
	 */
	function add_meta_boxes() {
		add_meta_box(
			$this->box_id,
			$this->box_label,
			array( $this, 'select_box' ),
			$this->FOR_POST_TYPE,
			'side'
		);
	}
	function select_box( $post ) {
		$selected_post_id = get_post_meta( $post->ID, $this->meta_key, true );
		global $wp_post_types;
		$save_hierarchical = $wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical;
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = true;
		wp_dropdown_pages( array(
			'id'               => $this->field_id,
			'name'             => $this->field_name,
			'selected'         => empty( $selected_post_id ) ? 0 : $selected_post_id,
			'post_type'        => $this->SELECT_POST_TYPE,
			'show_option_none' => $this->field_label,
		));
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = $save_hierarchical;
	}
	/**
	 * Save post
	 */
	function save_post( $post_id, $post ) {
		if ( $post->post_type === $this->FOR_POST_TYPE && isset( $_POST[ $this->field_name ] ) ) {
			$prerollflower = sanitize_text_field( $_POST['selected_flowers'] );
			update_post_meta( $post_id, $this->meta_key, $prerollflower );
		}
	}
}
new WPDispensary_Prerolls();

/**
 * Grower Flower Type metabox
 *
 * Adds a drop down of all flowers to the Growers menu type
 *
 * @since    1.7.0
 */
class WPDispensary_Growers {
	var $FOR_POST_TYPE     = 'growers';
	var $SELECT_POST_TYPE  = 'flowers';
	var $SELECT_POST_LABEL = 'Flower';
	var $box_id;
	var $box_label;
	var $field_id;
	var $field_label;
	var $field_name;
	var $meta_key;
	function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}
	function admin_init() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		$this->meta_key    = "_selected_{$this->SELECT_POST_TYPE}";
		$this->box_id      = "select-{$this->SELECT_POST_TYPE}-metabox";
		$this->field_id    = "selected_{$this->SELECT_POST_TYPE}";
		$this->field_name  = "selected_{$this->SELECT_POST_TYPE}";
		$this->box_label   = __( 'Flower Strain', 'wp-dispensary' );
		$this->field_label = __( "Choose {$this->SELECT_POST_LABEL}", 'wp-dispensary' );
	}
	/**
	 * Add meta boxes
	 */
	function add_meta_boxes() {
		add_meta_box(
			$this->box_id,
			$this->box_label,
			array( $this, 'select_box' ),
			$this->FOR_POST_TYPE,
			'side'
		);
	}
	function select_box( $post ) {
		$selected_post_id = get_post_meta( $post->ID, $this->meta_key, true );
		global $wp_post_types;
		$save_hierarchical                                      = $wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical;
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = true;
		wp_dropdown_pages( array(
			'id'               => $this->field_id,
			'name'             => $this->field_name,
			'selected'         => empty( $selected_post_id ) ? 0 : $selected_post_id,
			'post_type'        => $this->SELECT_POST_TYPE,
			'show_option_none' => $this->field_label,
		));
		$wp_post_types[ $this->SELECT_POST_TYPE ]->hierarchical = $save_hierarchical;
	}
	/**
	 * Save post
	 */
	function save_post( $post_id, $post ) {
		if ( $post->post_type === $this->FOR_POST_TYPE && isset( $_POST[ $this->field_name ] ) ) {
			$growerflower = sanitize_text_field( $_POST['selected_flowers'] );
			update_post_meta( $post_id, $this->meta_key, $growerflower );
		}
	}
}
new WPDispensary_Growers();

/**
 * Prices metabox for the following menu types:
 * Pre-rolls, Edibles, Growers
 *
 * Adds a price metabox to all of the above custom post types
 *
 * @since    1.0.0
 */
function wpdispensary_add_singleprices_metaboxes() {

	add_meta_box(
		'wpdispensary_singleprices',
		__( 'Product pricing', 'wp-dispensary' ),
		'wpdispensary_singleprices',
		'products',
		'normal',
		'default'
	);

}
add_action( 'add_meta_boxes', 'wpdispensary_add_singleprices_metaboxes' );

/**
 * Single Prices
 */
function wpdispensary_singleprices() {
	global $post;

	/** Noncename needed to verify where the data originated */
	echo '<input type="hidden" name="singlepricesmeta_noncename" id="singlepricesmeta_noncename" value="' .
	wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

	/** Get the prices data if its already been entered */
	$price_each     = get_post_meta( $post->ID, 'price_each', true );
	$price_per_pack = get_post_meta( $post->ID, 'price_per_pack', true );
	$units_per_pack = get_post_meta( $post->ID, 'units_per_pack', true );

	/** Echo out the fields */
	echo '<div class="pricebox">';
	echo '<p>' . __( 'Price per unit', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="price_each" value="' . esc_html( $price_each ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="pricebox">';
	echo '<p>' . __( 'Price per pack', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="price_per_pack" value="' . esc_html( $price_per_pack ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="pricebox">';
	echo '<p>' . __( 'Units per pack', 'wp-dispensary' ) . '</p>';
	echo '<input type="number" name="units_per_pack" value="' . esc_html( $units_per_pack ) . '" class="widefat" />';
	echo '</div>';

}

/**
 * Save the Metabox Data
 */
function wpdispensary_save_singleprices_meta( $post_id, $post ) {

	/**
	 * Verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times
	 */
	if (
		! isset( $_POST['singlepricesmeta_noncename'] ) ||
		! wp_verify_nonce( $_POST['singlepricesmeta_noncename'], plugin_basename( __FILE__ ) )
	) {
		return $post->ID;
	}

	/** Is the user allowed to edit the post or page? */
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post->ID;
	}

	/**
	 * OK, we're authenticated: we need to find and save the data
	 * We'll put it into an array to make it easier to loop though.
	 */

	$prices_meta['price_each']     = esc_html( $_POST['price_each'] );
	$prices_meta['price_per_pack'] = esc_html( $_POST['price_per_pack'] );
	$prices_meta['units_per_pack'] = esc_html( $_POST['units_per_pack'] );

	/** Add values of $prices_meta as custom fields */

	foreach ( $prices_meta as $key => $value ) { /** Cycle through the $prices_meta array! */
		if ( 'revision' === $post->post_type ) { /** Don't store custom data twice */
			return;
		}
		$value = implode( ',', (array) $value ); /** If $value is an array, make it a CSV (unlikely) */
		if ( get_post_meta( $post->ID, $key, false ) ) { /** If the custom field already has a value */
			update_post_meta( $post->ID, $key, $value );
		} else { /** If the custom field doesn't have a value */
			add_post_meta( $post->ID, $key, $value );
		}
		if ( ! $value ) { /** Delete if blank */
			delete_post_meta( $post->ID, $key );
		}
	}

}
add_action( 'save_post', 'wpdispensary_save_singleprices_meta', 1, 2 ); /** Save the custom fields */


/**
 * Grower Product Details metabox for the following menu types:
 * Growers
 *
 * Adds a product details metabox to all of the above custom post types
 *
 * @since    2.0.0
 */
function wpdispensary_add_grower_product_details_metaboxes() {

	add_meta_box(
		'wpdispensary_grower_product_details',
		__( 'Product Details', 'wp-dispensary' ),
		'wpdispensary_grower_product_details',
		'products',
		'normal',
		'default'
	);

}
add_action( 'add_meta_boxes', 'wpdispensary_add_grower_product_details_metaboxes' );

/**
 * Grower Product Details
 */
function wpdispensary_grower_product_details() {
	global $post;

	/** Noncename needed to verify where the data originated */
	echo '<input type="hidden" name="grower_product_detailsmeta_noncename" id="grower_product_detailsmeta_noncename" value="' .
	wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

	/** Get the clone count data if it has already been entered */
	$clonecount = get_post_meta( $post->ID, 'clone_count', true );

	/** Get the seed count data if it has already been entered */
	$seedcount = get_post_meta( $post->ID, 'seed_count', true );

	echo '<div class="growerbox">';
	echo '<p>' . __( 'Seeds per unit', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="seed_count" value="' . esc_html( $seedcount ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="growerbox">';
	echo '<p>' . __( 'Clones per unit', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="clone_count" value="' . esc_html( $clonecount ) . '" class="widefat" />';
	echo '</div>';

}

/**
 * Save the Metabox Data
 */
function wpdispensary_save_grower_product_details_meta( $post_id, $post ) {

	/**
	 * Verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times
	 */
	if (
		! isset( $_POST['grower_product_detailsmeta_noncename'] ) ||
		! wp_verify_nonce( $_POST['grower_product_detailsmeta_noncename'], plugin_basename( __FILE__ ) )
	) {
		return $post->ID;
	}

	/** Is the user allowed to edit the post or page? */
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post->ID;
	}

	/**
	 * OK, we're authenticated: we need to find and save the data
	 * We'll put it into an array to make it easier to loop though.
	 */

	$grower_product_details['clone_count'] = esc_html( $_POST['clone_count'] );
	$grower_product_details['seed_count']  = esc_html( $_POST['seed_count'] );

	/** Add values of $clonecount as custom fields */

	foreach ( $grower_product_details as $key => $value ) { /** Cycle through the $clonecount array! */
		if ( 'revision' === $post->post_type ) { /** Don't store custom data twice */
			return;
		}
		$value = implode( ',', (array) $value ); /** If $value is an array, make it a CSV (unlikely) */
		if ( get_post_meta( $post->ID, $key, false ) ) { /** If the custom field already has a value */
			update_post_meta( $post->ID, $key, $value );
		} else { /** If the custom field doesn't have a value */
			add_post_meta( $post->ID, $key, $value );
		}
		if ( ! $value ) { /** Delete if blank */
			delete_post_meta( $post->ID, $key );
		}
	}

}
add_action( 'save_post', 'wpdispensary_save_grower_product_details_meta', 1, 2 ); /** Save the custom fields */


/**
 * Edibles THC content metabox
 *
 * Adds a THC content metabox to the edibles custom post type
 *
 * @since    1.0.0
 */
function wpdispensary_add_thc_cbd_mg_metaboxes() {

	add_meta_box(
		'wpdispensary_thc_cbd_mg',
		__( 'Product details', 'wp-dispensary' ),
		'wpdispensary_thc_cbd_mg',
		'products',
		'normal',
		'default'
	);

}
add_action( 'add_meta_boxes', 'wpdispensary_add_thc_cbd_mg_metaboxes' );

/**
 * THC and CBD mg
 */
function wpdispensary_thc_cbd_mg() {
	global $post;

	/** Noncename needed to verify where the data originated */
	echo '<input type="hidden" name="thccbdmgmeta_noncename" id="thccbdmgmeta_noncename" value="' .
	wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

	/** Get the thc mg data if its already been entered */
	$thcmg          = get_post_meta( $post->ID, 'compounds_thc', true );
	$cbdmg          = get_post_meta( $post->ID, 'compounds_cbd', true );
	$thccbdservings = get_post_meta( $post->ID, 'product_servings', true );
	$netweight      = get_post_meta( $post->ID, 'product_net_weight', true );

	/** Echo out the fields */
	echo '<div class="ediblebox">';
	echo '<p>' . __( 'THC mg per serving', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="compounds_thc" value="' . esc_html( $thcmg ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="ediblebox">';
	echo '<p>' . __( 'CBD mg per serving', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="compounds_cbd" value="' . esc_html( $cbdmg ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="ediblebox">';
	echo '<p>' . __( 'Servings', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="product_servings" value="' . esc_html( $thccbdservings ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="ediblebox">';
	echo '<p>' . __( 'Net weight (grams)', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="product_net_weight" value="' . esc_html( $netweight ) . '" class="widefat" />';
	echo '</div>';

}

/**
 * Save the Metabox Data
 */
function wpdispensary_save_thc_cbd_mg_meta( $post_id, $post ) {

	/**
	 * Verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times
	 */
	if (
		! isset( $_POST['thccbdmgmeta_noncename'] ) ||
		! wp_verify_nonce( $_POST['thccbdmgmeta_noncename'], plugin_basename( __FILE__ ) )
	) {
		return $post->ID;
	}

	/** Is the user allowed to edit the post or page? */
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post->ID;
	}

	/**
	 * OK, we're authenticated: we need to find and save the data
	 * We'll put it into an array to make it easier to loop though.
	 */

	$thc_cbd_mg_meta['compounds_thc']      = esc_html( $_POST['compounds_thc'] );
	$thc_cbd_mg_meta['compounds_cbd']      = esc_html( $_POST['compounds_cbd'] );
	$thc_cbd_mg_meta['product_servings']   = esc_html( $_POST['product_servings'] );
	$thc_cbd_mg_meta['product_net_weight'] = esc_html( $_POST['product_net_weight'] );

	/** Add values of $thccbdmg_meta as custom fields */

	foreach ( $thc_cbd_mg_meta as $key => $value ) { /** Cycle through the $thc_cbd_mg_meta array! */
		if ( 'revision' === $post->post_type ) { /** Don't store custom data twice */
			return;
		}
		$value = implode( ',', (array) $value ); /** If $value is an array, make it a CSV (unlikely) */
		if ( get_post_meta( $post->ID, $key, false ) ) { /** If the custom field already has a value */
			update_post_meta( $post->ID, $key, $value );
		} else { /** If the custom field doesn't have a value */
			add_post_meta( $post->ID, $key, $value );
		}
		if ( ! $value ) { /** Delete if blank */
			delete_post_meta( $post->ID, $key );
		}
	}

}
add_action( 'save_post', 'wpdispensary_save_thc_cbd_mg_meta', 1, 2 ); /** Save the custom fields */


/**
 * Topicals THC & CBD content metabox
 *
 * Adds a THC & CBD content metabox to the topicals custom post type
 *
 * @since    1.4.0
 */
function wpdispensary_add_thccbdtopical_metaboxes() {

	add_meta_box(
		'wpdispensary_thccbdtopical',
		__( 'Product details', 'wp-dispensary' ),
		'wpdispensary_thccbdtopical',
		'products',
		'normal',
		'default'
	);

}
add_action( 'add_meta_boxes', 'wpdispensary_add_thccbdtopical_metaboxes' );

/**
 * Building the metabox
 */
function wpdispensary_thccbdtopical() {
	global $post;

	/** Noncename needed to verify where the data originated */
	echo '<input type="hidden" name="thccbdtopical_noncename" id="thccbdtopical_noncename" value="' .
	wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

	/** Get the topical data if its already been entered */
	$compounds_thc = get_post_meta( $post->ID, 'compounds_thc', true );
	$compounds_cbd = get_post_meta( $post->ID, 'compounds_cbd', true );
	$product_size  = get_post_meta( $post->ID, 'product_size', true );

	/** Echo out the fields */
	echo '<div class="topicalbox">';
	echo '<p>' . __( 'Size (oz)', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="product_size" value="' . esc_html( $product_size ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="topicalbox">';
	echo '<p>' . __( 'THC mg', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="compounds_thc" value="' . esc_html( $compounds_thc ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="topicalbox">';
	echo '<p>' . __( 'CBD mg', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="compounds_cbd" value="' . esc_html( $compounds_cbd ) . '" class="widefat" />';
	echo '</div>';

}

/**
 * Save the Metabox Data
 */
function wpdispensary_save_thccbdtopical_meta( $post_id, $post ) {

	/**
	 * Verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times
	 */
	if (
		! isset( $_POST['thccbdtopical_noncename'] ) ||
		! wp_verify_nonce( $_POST['thccbdtopical_noncename'], plugin_basename( __FILE__ ) )
	) {
		return $post->ID;
	}

	/** Is the user allowed to edit the post or page? */
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post->ID;
	}

	/**
	 * OK, we're authenticated: we need to find and save the data
	 * We'll put it into an array to make it easier to loop though.
	 */

	$thcmgtopical_meta['compounds_thc'] = esc_html( $_POST['compounds_thc'] );
	$thcmgtopical_meta['compounds_cbd'] = esc_html( $_POST['compounds_cbd'] );
	$thcmgtopical_meta['product_size']  = esc_html( $_POST['product_size'] );

	/** Add values of $thcmg_meta as custom fields */

	foreach ( $thcmgtopical_meta as $key => $value ) { /** Cycle through the $thcmg_meta array! */
		if ( 'revision' === $post->post_type ) { /** Don't store custom data twice */
			return;
		}
		$value = implode( ',', (array) $value ); /** If $value is an array, make it a CSV (unlikely) */
		if ( get_post_meta( $post->ID, $key, false ) ) { /** If the custom field already has a value */
			update_post_meta( $post->ID, $key, $value );
		} else { /** If the custom field doesn't have a value */
			add_post_meta( $post->ID, $key, $value );
		}
		if ( ! $value ) { /** Delete if blank */
			delete_post_meta( $post->ID, $key );
		}
	}

}
add_action( 'save_post', 'wpdispensary_save_thccbdtopical_meta', 1, 2 ); /** Save the custom fields */

/**
 * Growers Clone Details metabox
 *
 * Adds the clone details metabox to specific custom post types
 *
 * @since    1.9.5
 */
function wpdispensary_add_clonedetails_metaboxes() {

	add_meta_box(
		'wpdispensary_clonedetails',
		__( 'Grow details', 'wp-dispensary' ),
		'wpdispensary_clonedetails',
		'products',
		'normal',
		'default'
	);

}
add_action( 'add_meta_boxes', 'wpdispensary_add_clonedetails_metaboxes' );

/**
 * Building the metabox
 */
function wpdispensary_clonedetails() {
	global $post;

	/** Noncename needed to verify where the data originated */
	echo '<input type="hidden" name="clonedetailsmeta_noncename" id="clonedetailsmeta_noncename" value="' .
	wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

	/** Get the origin data if its already been entered */
	$origin     = get_post_meta( $post->ID, 'product_origin', true );
	$time       = get_post_meta( $post->ID, 'product_time', true );
	$yield      = get_post_meta( $post->ID, 'product_yield', true );
	$difficulty = get_post_meta( $post->ID, 'product_difficulty', true );

	/** Echo out the fields */
	echo '<div class="growerbox">';
	echo '<p>' . __( 'Origin', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="product_origin" value="' . esc_html( $origin ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="growerbox">';
	echo '<p>' . __( 'Grow time', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="product_time" value="' . esc_html( $time ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="growerbox">';
	echo '<p>' . __( 'Yield', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="product_yield" value="' . esc_html( $yield ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="growerbox">';
	echo '<p>' . __( 'Difficulty', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="product_difficulty" value="' . esc_html( $difficulty ) . '" class="widefat" />';
	echo '</div>';

}

/**
 * Save the Metabox Data
 */
function wpdispensary_save_clonedetails_meta( $post_id, $post ) {

	/**
	 * Verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times
	 */
	if (
		! isset( $_POST['clonedetailsmeta_noncename'] ) ||
		! wp_verify_nonce( $_POST['clonedetailsmeta_noncename'], plugin_basename( __FILE__ ) )
	) {
		return $post->ID;
	}

	/** Is the user allowed to edit the post or page? */
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post->ID;
	}

	/**
	 * OK, we're authenticated: we need to find and save the data
	 * We'll put it into an array to make it easier to loop though.
	 */

	$clonedetails_meta['product_origin']     = esc_html( $_POST['product_origin'] );
	$clonedetails_meta['product_time']       = esc_html( $_POST['product_time'] );
	$clonedetails_meta['product_yield']      = esc_html( $_POST['product_yield'] );
	$clonedetails_meta['product_difficulty'] = esc_html( $_POST['product_difficulty'] );

	/** Add values of $clonedetails_meta as custom fields */

	foreach ( $clonedetails_meta as $key => $value ) { /** Cycle through the $thccbd_meta array! */
		if ( 'revision' === $post->post_type ) { /** Don't store custom data twice */
			return;
		}
		$value = implode( ',', (array) $value ); // If $value is an array, make it a CSV (unlikely)
		if ( get_post_meta( $post->ID, $key, false ) ) { // If the custom field already has a value.
			update_post_meta( $post->ID, $key, $value );
		} else { // If the custom field doesn't have a value.
			add_post_meta( $post->ID, $key, $value );
		}
		if ( ! $value ) { /** Delete if blank */
			delete_post_meta( $post->ID, $key );
		}
	}

}
add_action( 'save_post', 'wpdispensary_save_clonedetails_meta', 1, 2 ); // Save the custom fields.


/**
 * Compound Details metabox
 *
 * Adds the compound details metabox to specific custom post types
 *
 * @since    1.9.9
 */
function wpdispensary_add_compounddetails_metaboxes() {
	add_meta_box(
		'wpdispensary_compounds',
		esc_html__( 'Compound details', 'wp-dispensary' ),
		'wpdispensary_compounddetails',
		'products',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'wpdispensary_add_compounddetails_metaboxes' );

/**
 * Building the metabox
 */
function wpdispensary_compounddetails() {
	global $post;

	/** Noncename needed to verify where the data originated */
	echo '<input type="hidden" name="compounddetailsmeta_noncename" id="compounddetailsmeta_noncename" value="' .
	wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

	/** Get the thccbd data if its already been entered */
	$thc   = get_post_meta( $post->ID, 'compounds_thc', true );
	$thca  = get_post_meta( $post->ID, 'compounds_thca', true );
	$cbd   = get_post_meta( $post->ID, 'compounds_cbd', true );
	$cba   = get_post_meta( $post->ID, 'compounds_cba', true );
	$cbn   = get_post_meta( $post->ID, 'compounds_cbn', true );
	$cbg   = get_post_meta( $post->ID, 'compounds_cbg', true );
	$total = get_post_meta( $post->ID, 'compounds_total', true );

	/** Echo out the fields */
	echo '<div class="compoundbox">';
	echo '<p>' . esc_html__( 'THC', 'wp-dispensary' ) . ' %</p>';
	echo '<input type="text" name="compounds_thc" value="' . esc_html( $thc ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="compoundbox">';
	echo '<p>' . esc_html__( 'THCA', 'wp-dispensary' ) . ' %</p>';
	echo '<input type="text" name="compounds_thca" value="' . esc_html( $thca ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="compoundbox">';
	echo '<p>' . esc_html__( 'CBD', 'wp-dispensary' ) . ' %</p>';
	echo '<input type="text" name="compounds_cbd" value="' . esc_html( $cbd ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="compoundbox">';
	echo '<p>' . esc_html__( 'CBA', 'wp-dispensary' ) . ' %</p>';
	echo '<input type="text" name="compounds_cba" value="' . esc_html( $cba ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="compoundbox">';
	echo '<p>' . esc_html__( 'CBN', 'wp-dispensary' ) . ' %</p>';
	echo '<input type="text" name="compounds_cbn" value="' . esc_html( $cbn ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="compoundbox">';
	echo '<p>' . esc_html__( 'CBG', 'wp-dispensary' ) . ' %</p>';
	echo '<input type="text" name="compounds_cbg" value="' . esc_html( $cbg ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="compoundbox">';
	echo '<p>' . esc_html__( 'Total', 'wp-dispensary' ) . ' %</p>';
	echo '<input type="text" name="compounds_total" value="' . esc_html( $total ) . '" class="widefat" />';
	echo '</div>';

}

/**
 * Save the Metabox Data
 */
function wpdispensary_save_compounddetails_meta( $post_id, $post ) {

	/**
	 * Verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times
	 */
	if (
		! isset( $_POST['compounddetailsmeta_noncename' ] ) ||
		! wp_verify_nonce( $_POST['compounddetailsmeta_noncename'], plugin_basename( __FILE__ ) )
	) {
		return $post->ID;
	}

	/** Is the user allowed to edit the post or page? */
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post->ID;
	}

	/**
	 * OK, we're authenticated: we need to find and save the data
	 * We'll put it into an array to make it easier to loop though.
	 */

	$thccbd_meta['compounds_thc']   = $_POST['compounds_thc'];
	$thccbd_meta['compounds_thca']  = $_POST['compounds_thca'];
	$thccbd_meta['compounds_cbd']   = $_POST['compounds_cbd'];
	$thccbd_meta['compounds_cba']   = $_POST['compounds_cba'];
	$thccbd_meta['compounds_cbn']   = $_POST['compounds_cbn'];
	$thccbd_meta['compounds_cbg']   = $_POST['compounds_cbg'];
	$thccbd_meta['compounds_total'] = $_POST['compounds_total'];

	/** Add values of $compounddetails_meta as custom fields */

	foreach ( $thccbd_meta as $key => $value ) { /** Cycle through the $thccbd_meta array! */
		if ( 'revision' === $post->post_type ) { /** Don't store custom data twice */
			return;
		}
		$value = implode( ',', (array) $value ); // If $value is an array, make it a CSV (unlikely)
		if ( get_post_meta( $post->ID, $key, false ) ) { // If the custom field already has a value.
			update_post_meta( $post->ID, $key, $value );
		} else { // If the custom field doesn't have a value.
			add_post_meta( $post->ID, $key, $value );
		}
		if ( ! $value ) { /** Delete if blank */
			delete_post_meta( $post->ID, $key );
		}
	}

}
add_action( 'save_post', 'wpdispensary_save_compounddetails_meta', 1, 2 ); // Save the custom fields.


/**
 * Pre-rolls Weight metabox
 *
 * Adds the weight metabox to specific custom post types
 *
 * @since    2.4.0
 */
function wpdispensary_addproduct_weight_metaboxes() {

	add_meta_box(
		'wpdispensaryproduct_weight',
		__( 'Pre-roll weight', 'wp-dispensary' ),
		'wpdispensaryproduct_weight',
		'products',
		'side',
		'default'
	);

}
add_action( 'add_meta_boxes', 'wpdispensary_addproduct_weight_metaboxes' );

/**
 * Building the metabox
 */
function wpdispensaryproduct_weight() {
	global $post;

	/** Noncename needed to verify where the data originated */
	echo '<input type="hidden" name="preroll_weightmeta_noncename" id="preroll_weightmeta_noncename" value="' .
	wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

	/** Get the origin data if its already been entered */
	$preroll_weight = get_post_meta( $post->ID, 'product_weight', true );

	/** Echo out the fields */
	echo '<div class="weightbox">';
	echo '<p>' . __( 'Weight (g)', 'wp-dispensary' ) . '</p>';
	echo '<input type="text" name="product_weight" value="' . esc_html( $preroll_weight ) . '" class="widefat" />';
	echo '</div>';

}

/**
 * Save the Metabox Data
 */
function wpdispensary_saveproduct_weight_meta( $post_id, $post ) {

	/**
	 * Verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times
	 */
	if (
		! isset( $_POST['preroll_weightmeta_noncename'] ) ||
		! wp_verify_nonce( $_POST['preroll_weightmeta_noncename'], plugin_basename( __FILE__ ) )
	) {
		return $post->ID;
	}

	/** Is the user allowed to edit the post or page? */
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post->ID;
	}

	/**
	 * OK, we're authenticated: we need to find and save the data
	 * We'll put it into an array to make it easier to loop though.
	 */

	$preroll_weight_meta['product_weight'] = esc_html( $_POST['product_weight'] );

	/** Add values of $preroll_weight_meta as custom fields */

	foreach ( $preroll_weight_meta as $key => $value ) { /** Cycle through the $thccbd_meta array! */
		if ( 'revision' === $post->post_type ) { /** Don't store custom data twice */
			return;
		}
		$value = implode( ',', (array) $value ); // If $value is an array, make it a CSV (unlikely)
		if ( get_post_meta( $post->ID, $key, false ) ) { // If the custom field already has a value.
			update_post_meta( $post->ID, $key, $value );
		} else { // If the custom field doesn't have a value.
			add_post_meta( $post->ID, $key, $value );
		}
		if ( ! $value ) { /** Delete if blank */
			delete_post_meta( $post->ID, $key );
		}
	}

}
add_action( 'save_post', 'wpdispensary_saveproduct_weight_meta', 1, 2 ); // Save the custom fields.

/**
 * Details metabox for the Tinctures menu type
 *
 * Adds a details metabox
 *
 * @since    4.0.0
 */
function wp_dispensary_tinctures_details_metaboxes() {

	add_meta_box(
		'wpd_tinctures_details',
		esc_attr__( 'Product Details', 'wpd-tinctures' ),
		'wp_dispensary_tinctures_details',
		'products',
		'normal',
		'default'
	);

}
add_action( 'add_meta_boxes', 'wp_dispensary_tinctures_details_metaboxes' );

/**
 * Tincture Details
 */
function wp_dispensary_tinctures_details() {
	global $post;

	/** Noncename needed to verify where the data originated */
	echo '<input type="hidden" name="tincturesdetailsmeta_noncename" id="tincturesdetailsmeta_noncename" value="' .
	wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

	/** Get the details data if its already been entered */
	$thcmg          = get_post_meta( $post->ID, 'compounds_thc', true );
	$cbdmg          = get_post_meta( $post->ID, 'compounds_cbd', true );
	$mlserving      = get_post_meta( $post->ID, 'product_servings_ml', true );
	$thccbdservings = get_post_meta( $post->ID, 'product_servings', true );
	$netweight      = get_post_meta( $post->ID, 'product_net_weight', true );

	/** Echo out the fields */
	echo '<div class="tincturesdetailsbox">';
	echo '<p>' . esc_attr__( 'Servings', 'wpd-tinctures' ) . '</p>';
	echo '<input type="text" name="product_servings" value="' . esc_html( $thccbdservings ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="tincturesdetailsbox">';
	echo '<p>' . esc_attr__( 'THC mg per serving', 'wpd-tinctures' ) . '</p>';
	echo '<input type="text" name="compounds_thc" value="' . esc_html( $thcmg ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="tincturesdetailsbox">';
	echo '<p>' . esc_attr__( 'CBD mg per serving', 'wpd-tinctures' ) . '</p>';
	echo '<input type="text" name="compounds_cbd" value="' . esc_html( $cbdmg ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="tincturesdetailsbox">';
	echo '<p>' . esc_attr__( 'mL per serving', 'wpd-tinctures' ) . '</p>';
	echo '<input type="text" name="product_servings_ml" value="' . esc_html( $mlserving ) . '" class="widefat" />';
	echo '</div>';
	echo '<div class="tincturesdetailsbox">';
	echo '<p>' . esc_attr__( 'Net weight (ounces)', 'wpd-tinctures' ) . '</p>';
	echo '<input type="text" name="product_net_weight" value="' . esc_html( $netweight ) . '" class="widefat" />';
	echo '</div>';

}

/**
 * Save the Metabox Data
 */
function wp_dispensary_tinctures_details_save_meta( $post_id, $post ) {

	/**
	 * Verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times
	 */
	if ( ! isset( $_POST['tincturesdetailsmeta_noncename' ] ) || ! wp_verify_nonce( $_POST['tincturesdetailsmeta_noncename'], plugin_basename( __FILE__ ) ) ) {
		return $post->ID;
	}

	/** Is the user allowed to edit the post or page? */
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post->ID;
	}

	/**
	 * OK, we're authenticated: we need to find and save the data
	 * We'll put it into an array to make it easier to loop though.
	 */
	$details_meta['compounds_thc']       = esc_html( $_POST['compounds_thc'] );
	$details_meta['compounds_cbd']       = esc_html( $_POST['compounds_cbd'] );
	$details_meta['product_servings_ml'] = esc_html( $_POST['product_servings_ml'] );
	$details_meta['product_servings']    = esc_html( $_POST['product_servings'] );
	$details_meta['product_net_weight']  = esc_html( $_POST['product_net_weight'] );

	/** Add values of $details_meta as custom fields */

	foreach ( $details_meta as $key => $value ) { /** Cycle through the $details_meta array! */
		if ( 'revision' === $post->post_type ) { /** Don't store custom data twice */
			return;
		}
		$value = implode( ',', (array) $value ); /** If $value is an array, make it a CSV (unlikely) */
		if ( get_post_meta( $post->ID, $key, false ) ) { /** If the custom field already has a value */
			update_post_meta( $post->ID, $key, $value );
		} else { /** If the custom field doesn't have a value */
			add_post_meta( $post->ID, $key, $value );
		}
		if ( ! $value ) { /** Delete if blank */
			delete_post_meta( $post->ID, $key );
		}
	}

}
add_action( 'save_post', 'wp_dispensary_tinctures_details_save_meta', 1, 2 ); /** Save the custom fields */
