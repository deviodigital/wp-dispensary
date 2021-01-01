<?php
/**
 * Pricing functions
 *
 * @since 2.5
 */

/**
 * Flowers Prices - Simple
 *
 * @see get_wpd_flowers_prices_simple()
 * @since 2.4
 * @return string
 */
function wpd_flowers_prices_simple( $product_id = NULL, $phrase = NULL ) {
    // Filters the displayed flowers prices.
    echo apply_filters( 'wpd_flowers_prices_simple', get_wpd_flowers_prices_simple( $product_id, $phrase ) );
}


/**
 * Concentrates Prices - Simple
 *
 * @since 2.5
 * @return string
 */
function wpd_concentrates_prices_simple( $product_id = NULL, $phrase = NULL ) {
    // Filters the displayed concentrates prices.
    echo apply_filters( 'wpd_concentrates_prices_simple', get_wpd_concentrates_prices_simple( $product_id, $phrase ) );
}

/**
 * Tinctures Prices - Simple
 *
 * @see get_wpd_tinctures_prices_simple()
 * @since 2.4
 * @return string
 */
if ( ! function_exists( 'wpd_tinctures_prices_simple' ) ) {
	function wpd_tinctures_prices_simple( $product_id = NULL, $phrase = NULL ) {
		// Filters the displayed tinctures prices.
		echo apply_filters( 'wpd_tinctures_prices_simple', get_wpd_tinctures_prices_simple( $product_id, $phrase ) );
	}
}

/**
 * Edibles Prices - Simple
 *
 * @since 2.5
 * @return string
 */
function wpd_edibles_prices_simple( $product_id = NULL, $phrase = NULL ) {
    // Filters the displayed edibless prices.
    echo apply_filters( 'wpd_edibless_prices_simple', get_wpd_edibles_prices_simple( $product_id, $phrase ) );
}


/**
 * Pre-rolls Prices - Simple
 *
 * @since 2.5
 * @return string
 */
function wpd_prerolls_prices_simple( $product_id = NULL, $phrase = NULL ) {
    // Filters the displayed prerolls prices.
    echo apply_filters( 'wpd_prerolls_prices_simple', get_wpd_prerolls_prices_simple( $product_id, $phrase ) );
}


/**
 * Topicals Prices - Simple
 *
 * @since 2.5
 * @return string
 */
function wpd_topicals_prices_simple( $product_id = NULL, $phrase = NULL ) {
    // Filters the displayed topicals prices.
    echo apply_filters( 'wpd_topicals_prices_simple', get_wpd_topicals_prices_simple( $product_id, $phrase ) );
}


/**
 * Growers Prices - Simple
 *
 * @since 2.5
 * @return string
 */
function wpd_growers_prices_simple( $product_id = NULL, $phrase = NULL ) {
    // Filters the displayed growers prices.
    echo apply_filters( 'wpd_growers_prices_simple', get_wpd_growers_prices_simple( $product_id, $phrase ) );
}

/**
 * Gear Prices - Simple
 * 
 * @see get_wpd_gear_prices_simple()
 * @since 1.6
 * @return string
 */
if ( ! function_exists( 'get_wpd_gear_prices_simple' ) ) {
	function wpd_gear_prices_simple( $gear_id = NULL, $phrase = NULL ) {
		// Filters the displayed flowers prices.
		echo apply_filters( 'wpd_gear_prices_simple', get_wpd_gear_prices_simple( $gear_id, $phrase ) );
	}
}

/**
 * All Prices - Simple
 *
 * @since 2.5
 * @return string
 */
function wpd_all_prices_simple( $product_id = NULL, $phrase = NULL ) {

	global $post;

	if ( 'flowers' == get_post_meta( $post->ID, 'product_type', true ) ) {
		echo apply_filters( 'wpd_flowers_prices_simple', get_wpd_flowers_prices_simple( $product_id, $phrase ) );
	}

	if ( 'concentrates' == get_post_meta( $post->ID, 'product_type', true ) ) {
		echo apply_filters( 'wpd_concentrates_prices_simple', get_wpd_concentrates_prices_simple( $product_id, $phrase ) );
	}

	if ( 'edibles' == get_post_meta( $post->ID, 'product_type', true ) ) {
		echo apply_filters( 'wpd_edibles_prices_simple', get_wpd_edibles_prices_simple( $product_id, $phrase ) );
	}

	if ( 'prerolls' == get_post_meta( $post->ID, 'product_type', true ) ) {
		echo apply_filters( 'wpd_prerolls_prices_simple', get_wpd_prerolls_prices_simple( $product_id, $phrase ) );
	}

	if ( 'topicals' == get_post_meta( $post->ID, 'product_type', true ) ) {
		echo apply_filters( 'wpd_topicals_prices_simple', get_wpd_topicals_prices_simple( $product_id, $phrase ) );
	}

	if ( 'growers' == get_post_meta( $post->ID, 'product_type', true ) ) {
		echo apply_filters( 'wpd_growers_prices_simple', get_wpd_growers_prices_simple( $product_id, $phrase ) );
	}

	if ( 'gear' == get_post_meta( $post->ID, 'product_type', true ) ) {
		echo apply_filters( 'wpd_gear_prices_simple', get_wpd_gear_prices_simple( $product_id, $phrase ) );
	}

	if ( 'tinctures' == get_post_meta( $post->ID, 'product_type', true ) ) {
		echo apply_filters( 'wpd_tinctures_prices_simple', get_wpd_tinctures_prices_simple( $product_id, $phrase ) );
	}
}


/**
 * Pricing phrase
 *
 * @since 2.4
 * @return string
 */
function wpd_pricing_phrase( $singular ) {
	echo esc_html( apply_filters( 'wpd_pricing_phrase', get_wpd_pricing_phrase( $product_id, $phrase ) ) );
}

/**
 * Get Pricing phrase
 *
 * @since 2.4
 * @return string
 */
function get_wpd_pricing_phrase( $singular ) {
	// Access all WP Dispensary Display Settings.
	$wpd_settings = get_option( 'wpdas_display' );

	// Check pricing phrase settings.
	if ( isset ( $wpd_settings['wpd_pricing_phrase_custom'] ) && '' !== $wpd_settings['wpd_pricing_phrase_custom'] ) {
		$wpd_pricing_phrase = $wpd_settings['wpd_pricing_phrase_custom'];
	} elseif ( isset ( $wpd_settings['wpd_pricing_phrase'] ) && 'Donation' === $wpd_settings['wpd_pricing_phrase'] ) {
		if ( $singular == true ) {
			$wpd_pricing_phrase = esc_attr__( 'Donation', 'wp-dispensary' );
		} else {
			$wpd_pricing_phrase = esc_attr__( 'Donations', 'wp-dispensary' );
		}
	} else {
		if ( $singular == true ) {
			$wpd_pricing_phrase = esc_attr__( 'Price', 'wp-dispensary' );
		} else {
			$wpd_pricing_phrase = esc_attr__( 'Prices', 'wp-dispensary' );
		}
	}

	// Create filterable pricing phrase.
	$wpd_pricing_phrase = apply_filters( 'wpd_pricing_phrase', $wpd_pricing_phrase );

	// Return the pricing phrase.
	return $wpd_pricing_phrase;
}



/**
 * Flowers Prices - Get Simple
 *
 * @since 2.5
 * @return string
 */
function get_wpd_flowers_prices_simple( $product_id = NULL, $phrase = NULL ) {

    global $post;

    // Get currency code.
	$currency_code = wpd_currency_code();

	// Get prices.
	$price_half_gram     = get_post_meta( $product_id, 'price_half_gram', true );
	$price_one_gram      = get_post_meta( $product_id, 'price_gram', true );
	$price_two_grams     = get_post_meta( $product_id, 'price_two_grams', true );
	$price_eighth        = get_post_meta( $product_id, 'price_eighth', true );
	$price_five_grams    = get_post_meta( $product_id, 'price_five_grams', true );
	$price_quarter_ounce = get_post_meta( $product_id, 'price_quarter_ounce', true );
	$price_half_ounce    = get_post_meta( $product_id, 'price_half_ounce', true );
	$price_one_ounce     = get_post_meta( $product_id, 'price_ounce', true );

	/**
	 * Price output - if only one price has been added
	 */
	if ( '' === $price_two_grams && '' === $price_eighth && '' === $price_five_grams && '' === $price_quarter_ounce && '' === $price_half_ounce && '' === $price_one_ounce ) {
		$pricing = $currency_code . $price_one_gram;
	} elseif ( '' === $price_one_gram && '' === $price_eighth && '' === $price_five_grams && '' === $price_quarter_ounce && '' === $price_half_ounce && '' === $price_one_ounce ) {
		$pricing = $currency_code . $price_two_grams;
	} elseif ( '' === $price_one_gram && '' === $price_two_grams && '' === $price_five_grams && '' === $price_quarter_ounce && '' === $price_half_ounce && '' === $price_one_ounce ) {
		$pricing = $currency_code . $price_eighth;
	} elseif ( '' === $price_one_gram && '' === $price_two_grams && '' === $price_eighth && '' === $price_quarter_ounce && '' === $price_half_ounce && '' === $price_one_ounce ) {
		$pricing = $currency_code . $price_five_grams;
	} elseif ( '' === $price_one_gram && '' === $price_two_grams && '' === $price_eighth && '' === $price_five_grams && '' === $price_half_ounce && '' === $price_one_ounce ) {
		$pricing = $currency_code . $price_quarter_ounce;
	} elseif ( '' === $price_one_gram && '' === $price_two_grams && '' === $price_eighth && '' === $price_five_grams && '' === $price_quarter_ounce && '' === $price_one_ounce ) {
		$pricing = $currency_code . $price_half_ounce;
	} elseif ( '' === $price_one_gram && '' === $price_two_grams && '' === $price_eighth && '' === $price_five_grams && '' === $price_quarter_ounce && '' === $price_half_ounce ) {
		$pricing = $currency_code . $price_one_ounce;
	} else {
		$pricing = '';
	}

	/**
	 * Price output - if no prices have been added
	 */
	if ( '' === $price_one_gram && '' === $price_two_grams && '' === $price_eighth && '' === $price_five_grams && '' === $price_quarter_ounce && '' === $price_half_ounce && '' === $price_one_ounce ) {
		$pricing = ' ';
	}

	/**
	 * Price output - low amount
	 */
	$pricinglow = '';

	if ( get_post_meta( $product_id, 'price_gram', true ) ) {
		$pricinglow = $currency_code . $price_one_gram;
	} elseif ( get_post_meta( $product_id, 'price_two_grams', true ) ) {
		$pricinglow = $currency_code . $price_two_grams;
	} elseif ( get_post_meta( $product_id, 'price_eighth', true ) ) {
		$pricinglow = $currency_code . $price_eighth;
	} elseif ( get_post_meta( $product_id, 'price_five_grams', true ) ) {
		$pricinglow = $currency_code . $price_five_grams;
	} elseif ( get_post_meta( $product_id, 'price_quarter_ounce', true ) ) {
		$pricinglow = $currency_code . $price_quarter_ounce;
	} elseif ( get_post_meta( $product_id, 'price_half_ounce', true ) ) {
		$pricinglow = $currency_code . $price_half_ounce;
	} else {
		//Do nothing.
	}

	// Filter the low prices.
	$pricinglow = apply_filters( 'wpd_flowers_pricing_low', $pricinglow );

	// Separator.
	$pricingsep = '-';

	/**
	 * Price output - high amount
	 */
	$pricinghigh = '';

	if ( get_post_meta( $product_id, 'price_ounce', true ) ) {
		$pricinghigh = $currency_code . $price_one_ounce;
	} elseif ( get_post_meta( $product_id, 'price_half_ounce', true ) ) {
		$pricinghigh = $currency_code . $price_half_ounce;
	} elseif ( get_post_meta( $product_id, 'price_quarter_ounce', true ) ) {
		$pricinghigh = $currency_code . $price_quarter_ounce;
	} elseif ( get_post_meta( $product_id, 'price_five_grams', true ) ) {
		$pricinghigh = $currency_code . $price_five_grams;
	} elseif ( get_post_meta( $product_id, 'price_eighth', true ) ) {
		$pricinghigh = $currency_code . $price_eighth;
	} elseif ( get_post_meta( $product_id, 'price_two_grams', true ) ) {
		$pricinghigh = $currency_code . $price_two_grams;
	} elseif ( get_post_meta( $product_id, 'price_gram', true ) ) {
		$pricinghigh = $currency_code . $price_one_gram;
	} else {
		// Do nothing.
	}

	// Filter the high prices.
	$pricinghigh = apply_filters( 'wpd_flowers_pricing_high', $pricinghigh );

	if ( TRUE == $phrase ) {
		$pricing_phrase = '<strong>' . get_wpd_pricing_phrase( TRUE ) . ':</strong> ';
	} else {
		$pricing_phrase = '';
	}

	$phrase_lowhigh = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricinglow . $pricingsep . $pricinghigh . '</span>';
	$phrase_single  = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

	$phrase_final        = $phrase_lowhigh;
	$phrase_single_final = $phrase_single;

	/**
	 * Return Pricing Prices.
	 */
	if ( empty( $pricing ) ) {
		return $phrase_final;
	} elseif ( ' ' === $pricing ) {
		return '';
	} else {
		return $phrase_single_final;
	}

}


/**
 * Concentrates Prices - Get Simple
 *
 * @since 2.5
 * @return string
 */
function get_wpd_concentrates_prices_simple( $product_id = NULL, $phrase = NULL ) {

  global $post;

	// Get currency code.
	$currency_code = wpd_currency_code();

	// Get prices.
	$price_each      = get_post_meta( $product_id, 'price_each', true );
	$price_half_gram = get_post_meta( $product_id, 'price_half_gram', true );
	$price_one_gram  = get_post_meta( $product_id, 'price_gram', true );
	$price_two_grams = get_post_meta( $product_id, 'price_two_grams', true );

	/**
	 * Price output - if only one price has been added
	 */
	if ( '' === $price_one_gram && '' === $price_two_grams ) {
		$pricing = $currency_code . $price_half_gram;
	} elseif ( '' === $price_half_gram && '' === $price_two_grams ) {
		$pricing = $currency_code . $price_one_gram;
	} elseif ( '' === $price_half_gram && '' === $price_one_gram ) {
		$pricing = $currency_code . $price_two_grams;
	} else {
		$pricing = '';
	}

	/**
	 * Price output - if no prices have been added
	 */
	if ( '' === $price_half_gram && '' === $price_one_gram && '' === $price_two_grams ) {
		$pricing = ' ';
	}

	/**
	 * Price output - low amount
	 */
	$pricinglow = '';

	if ( get_post_meta( $product_id, 'price_half_gram', true ) ) {
		$pricinglow = $currency_code . $price_half_gram;
	} elseif ( get_post_meta( $product_id, 'price_gram', true ) ) {
		$pricinglow = $currency_code . $price_one_gram;
	} elseif ( get_post_meta( $product_id, 'price_two_grams', true ) ) {
		$pricinglow = $currency_code . $price_two_grams;
	} else {
		//Do nothing.
	}

	// Filter the low prices.
	$pricinglow = apply_filters( 'wpd_concentrates_pricing_low', $pricinglow );

	// Separator.
	$pricingsep = '-';

	/**
	 * Price output - high amount
	 */
	$pricinghigh = '';

	if ( get_post_meta( $product_id, 'price_two_grams', true ) ) {
		$pricinghigh = $currency_code . $price_two_grams;
	} elseif ( get_post_meta( $product_id, 'price_gram', true ) ) {
		$pricinghigh = $currency_code . $price_one_gram;
	} elseif ( get_post_meta( $product_id, 'price_half_gram', true ) ) {
		$pricinghigh = $currency_code . $price_half_gram;
	} else {
		// Do nothing.
	}

	// Filter the high prices.
	$pricinghigh = apply_filters( 'wpd_concentrates_pricing_high', $pricinghigh );

	/**
	 * Price output - if price each is filled in
	 */
	if ( '' != $price_each ) {
		$pricing = $currency_code . $price_each;
	}

	if ( TRUE == $phrase ) {
		$pricing_phrase = '<strong>' . get_wpd_pricing_phrase( TRUE ) . ':</strong> ';
	} else {
		$pricing_phrase = '';
	}

	$phrase_lowhigh = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricinglow . $pricingsep . $pricinghigh . '</span>';
	$phrase_single  = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

	$phrase_final        = $phrase_lowhigh;
	$phrase_single_final = $phrase_single;

	/**
	 * Return Pricing Prices.
	 */
	if ( empty( $pricing ) ) {
		return $phrase_final;
	} elseif ( ' ' === $pricing ) {
		return '';
	} else {
		return $phrase_single_final;
	}

}

/**
 * Tinctures Prices - Get Simple
 * 
 * @since 4.0
 */
if ( ! function_exists( 'get_wpd_tinctures_prices_simple' ) ) {
	function get_wpd_tinctures_prices_simple( $product_id, $phrase = NULL ) {

		global $post;

		// Get currency code.
		$currency_code = wpd_currency_code();

		// Get prices.
		$price_each     = get_post_meta( $product_id, 'price_each', true );
		$price_per_pack = get_post_meta( $product_id, 'price_per_pack', true );
		$pricingsep     = '-';

		// Check if phrase is set in function.
		if ( TRUE == $phrase ) {
			$pricing_phrase = '<strong>' . get_wpd_pricing_phrase( TRUE ) . ':</strong> ';
		} else {
			$pricing_phrase = '';
		}

		/**
		 * Price output - if only one price has been added
		 */
		if ( '' != $price_each && '' != $price_per_pack ) {

			$pricing = $currency_code . $price_each . $pricingsep . $price_per_pack;
			$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

		} elseif ( '' === $price_each && '' != $price_per_pack ) {

			$pricing = $currency_code . $price_per_pack;
			$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

		} elseif ( '' != $price_each && '' === $price_per_pack ) {

			$pricing = $currency_code . $price_each;
			$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

		} else {
			$phrase_final = '';
		}

		/**
		 * Return Pricing Prices.
		 */
		return $phrase_final;
	}
}

/**
 * Edibles Prices - Get Simple
 *
 * @since 2.5
 * @return string
 */
function get_wpd_edibles_prices_simple( $product_id = NULL, $phrase = NULL ) {

  global $post;

	// Get currency code.
	$currency_code = wpd_currency_code();

	// Get prices.
	$price_each     = get_post_meta( $product_id, 'price_each', true );
	$price_per_pack = get_post_meta( $product_id, 'price_per_pack', true );
	$pricingsep     = '-';

	// Set empty variables.
	$pricing_phrase = '';
	$phrase_final   = '';

	// Check if phrase is set in function.
	if ( TRUE == $phrase ) {
		$pricing_phrase = '<strong>' . get_wpd_pricing_phrase( TRUE ) . ':</strong> ';
	}

	/**
	 * Price output
	 */
	if ( '' != $price_each && '' != $price_per_pack ) {

		$pricing = $currency_code . $price_each . $pricingsep . $price_per_pack;
		$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

	} elseif ( '' === $price_each && '' != $price_per_pack ) {

		$pricing = $currency_code . $price_per_pack;
		$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

	} elseif ( '' != $price_each && '' === $price_per_pack ) {

		$pricing = $currency_code . $price_each;
		$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

	} else {
		// Do nothing.
	}

	/**
	 * Return Pricing Prices.
	 */
	return $phrase_final;

}


/**
 * Pre-rolls Prices - Get Simple
 *
 * @since 2.5
 * @return string
 */
function get_wpd_prerolls_prices_simple( $product_id = NULL, $phrase = NULL ) {

	global $post;

	// Get currency code.
	$currency_code = wpd_currency_code();

	// Get prices.
	$price_each     = get_post_meta( $product_id, 'price_each', true );
	$price_per_pack = get_post_meta( $product_id, 'price_per_pack', true );
	$pricingsep     = '-';

	// Check if phrase is set in function.
	if ( TRUE == $phrase ) {
		$pricing_phrase = '<strong>' . get_wpd_pricing_phrase( TRUE ) . ':</strong> ';
	} else {
		$pricing_phrase = '';
	}

	/**
	 * Price output - if only one price has been added
	 */
	if ( '' != $price_each && '' != $price_per_pack ) {

		$pricing = $currency_code . $price_each . $pricingsep . $price_per_pack;
		$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

	} elseif ( '' === $price_each && '' != $price_per_pack ) {

		$pricing = $currency_code . $price_per_pack;
		$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

	} elseif ( '' != $price_each && '' === $price_per_pack ) {

		$pricing = $currency_code . $price_each;
		$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

	} else {
		$phrase_final = '';
	}

	/**
	 * Return Pricing Prices.
	 */
	return $phrase_final;

}


/**
 * Topicals Prices - Get Simple
 *
 * @since 2.5
 * @return string
 */
function get_wpd_topicals_prices_simple( $product_id = NULL, $phrase = NULL ) {

	global $post;

	// Get currency code.
	$currency_code = wpd_currency_code();

	// Get prices.
	$price_each     = get_post_meta( $product_id, 'price_each', true );
	$price_per_pack = get_post_meta( $product_id, 'price_per_pack', true );
	$pricingsep     = '-';

	// Check if phrase is set in function.
	if ( TRUE == $phrase ) {
		$pricing_phrase = '<strong>' . get_wpd_pricing_phrase( TRUE ) . ':</strong> ';
	} else {
		$pricing_phrase = '';
	}

	/**
	 * Price output - if only one price has been added
	 */
	if ( '' != $price_each && '' != $price_per_pack ) {

		$pricing = $currency_code . $price_each . $pricingsep . $price_per_pack;
		$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

	} elseif ( '' === $price_each && '' != $price_per_pack ) {

		$pricing = $currency_code . $price_per_pack;
		$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

	} elseif ( '' != $price_each && '' === $price_per_pack ) {

		$pricing = $currency_code . $price_each;
		$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

	} else {
		$phrase_final = '';
	}

	/**
	 * Return Pricing Prices.
	 */
	return $phrase_final;

}


/**
 * Growers Prices - Get Simple
 *
 * @since 2.5
 * @return string
 */
function get_wpd_growers_prices_simple( $product_id = NULL, $phrase = NULL ) {

	global $post;

	// Get currency code.
	$currency_code = wpd_currency_code();

	// Get prices.
	$price_each     = get_post_meta( $product_id, 'price_each', true );
	$price_per_pack = get_post_meta( $product_id, 'price_per_pack', true );
	$pricingsep     = '-';

	// Check if phrase is set in function.
	if ( TRUE == $phrase ) {
		$pricing_phrase = '<strong>' . get_wpd_pricing_phrase( TRUE ) . ':</strong> ';
	} else {
		$pricing_phrase = '';
	}

	/**
	 * Price output - if only one price has been added
	 */
	if ( '' != $price_each && '' != $price_per_pack ) {

		$pricing = $currency_code . $price_each . $pricingsep . $price_per_pack;
		$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

	} elseif ( '' === $price_each && '' != $price_per_pack ) {

		$pricing = $currency_code . $price_per_pack;
		$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

	} elseif ( '' != $price_each && '' === $price_per_pack ) {

		$pricing = $currency_code . $price_each;
		$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

	} else {
		$phrase_final = '';
	}

	/**
	 * Return Pricing Prices.
	 */
	return $phrase_final;

}

/**
 * Gear Prices - Get Simple
 * 
 * @since 4.0
 */
if ( ! function_exists( 'get_wpd_gear_prices_simple' ) ) {
	function get_wpd_gear_prices_simple( $product_id, $phrase = NULL ) {
		// Get currency code.
		$currency_code = wpd_currency_code();

		// Get prices.
		$price_each     = get_post_meta( $product_id, 'price_each', TRUE );
		$price_per_pack = get_post_meta( $product_id, 'price_per_pack', TRUE );
		$pricingsep     = '-';

		// Check if phrase is set in function.
		if ( TRUE == $phrase ) {
			$pricing_phrase = '<strong>' . get_wpd_pricing_phrase( TRUE ) . ':</strong> ';
		} else {
			$pricing_phrase = '';
		}

		/**
		 * Price output - if only one price has been added
		 */
		if ( '' != $price_each && '' != $price_per_pack ) {

			$pricing      = $currency_code . $price_each . $pricingsep . $price_per_pack;
			$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

		} elseif ( '' === $price_each && '' != $price_per_pack ) {

			$pricing      = $currency_code . $price_per_pack;
			$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

		} elseif ( '' != $price_each && '' === $price_per_pack ) {

			$pricing      = $currency_code . $price_each;
			$phrase_final = '<span class="wpd-productinfo pricing">' . $pricing_phrase . $pricing . '</span>';

		} else {
			$phrase_final = '';
		}

		/**
		 * Return Pricing Prices.
		 */
		return $phrase_final;
	}
}

/**
 * All Prices - Simple
 *
 * @since 2.5
 * @return string
 */
function get_wpd_all_prices_simple( $product_id = NULL, $phrase = NULL ) {

	global $post;

	$str = '';

	if ( 'flowers' == get_post_meta( $post->ID, 'product_type', true ) ) {
		$str .= apply_filters( 'wpd_flowers_prices_simple', get_wpd_flowers_prices_simple( $product_id, $phrase ) );
	}

	if ( 'concentrates' == get_post_meta( $post->ID, 'product_type', true ) ) {
		$str .= apply_filters( 'wpd_concentrates_prices_simple', get_wpd_concentrates_prices_simple( $product_id, $phrase ) );
	}

	if ( 'edibles' == get_post_meta( $post->ID, 'product_type', true ) ) {
		$str .= apply_filters( 'wpd_edibles_prices_simple', get_wpd_edibles_prices_simple( $product_id, $phrase ) );
	}

	if ( 'prerolls' == get_post_meta( $post->ID, 'product_type', true ) ) {
		$str .= apply_filters( 'wpd_prerolls_prices_simple', get_wpd_prerolls_prices_simple( $product_id, $phrase ) );
	}

	if ( 'topicals' == get_post_meta( $post->ID, 'product_type', true ) ) {
		$str .= apply_filters( 'wpd_topicals_prices_simple', get_wpd_topicals_prices_simple( $product_id, $phrase ) );
	}

	if ( 'growers' == get_post_meta( $post->ID, 'product_type', true ) ) {
		$str .= apply_filters( 'wpd_growers_prices_simple', get_wpd_growers_prices_simple( $product_id, $phrase ) );
	}

	if ( 'gear' == get_post_meta( $post->ID, 'product_type', true ) ) {
		$str .= apply_filters( 'wpd_gear_prices_simple', get_wpd_gear_prices_simple( $product_id, $phrase ) );
	}

	if ( 'tinctures' == get_post_meta( $post->ID, 'product_type', true ) ) {
		$str .= apply_filters( 'wpd_tinctures_prices_simple', get_wpd_tinctures_prices_simple( $product_id, $phrase ) );
	}

	return apply_filters( 'get_wpd_all_prices_simple', $str );
}

/**
 * Get all flower prices.
 *
 * @since 2.5
 * @return array
 */
function wpd_flowers_prices_array( $product_id, $flower_prices = NULL ) {
	$flower_prices = array(
		'1 g'    => esc_html( get_post_meta( $product_id, 'price_gram', true ) ),
		'2 g'    => esc_html( get_post_meta( $product_id, 'price_two_grams', true ) ),
		'1/8 oz' => esc_html( get_post_meta( $product_id, 'price_eighth', true ) ),
		'5 g'    => esc_html( get_post_meta( $product_id, 'price_five_grams', true ) ),
		'1/4 oz' => esc_html( get_post_meta( $product_id, 'price_quarter_ounce', true ) ),
		'1/2 oz' => esc_html( get_post_meta( $product_id, 'price_half_ounce', true ) ),
		'1 oz'   => esc_html( get_post_meta( $product_id, 'price_ounce', true ) ),
	);
	return apply_filters( 'wpd_flowers_prices_array', $flower_prices );
}


/**
 * Get all concentrates prices.
 *
 * @since 3.4
 * @return array
 */
function wpd_concentrates_prices_array( $product_id, $concentrates_prices = NULL ) {
	$concentrates_prices = array(
		'1/2 g' => esc_html( get_post_meta( $product_id, 'price_half_gram', true ) ),
		'1 g'   => esc_html( get_post_meta( $product_id, 'price_gram', true ) ),
		'2 g'   => esc_html( get_post_meta( $product_id, 'price_two_grams', true ) ),
	);
	return apply_filters( 'wpd_concentrates_prices_array', $concentrates_prices );
}
