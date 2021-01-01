<?php
/**
 * Adding metaboxes and taxonomy data output in the_content
 *
 * @link       https://www.wpdispensary.com
 * @since      1.6.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin
 */

/**
 * Checking WP Dispensary option to
 * see if the user checked to hide the
 * data from the_content()
 */
if ( ! function_exists( 'wpd_data_output_content' ) ) {

	/**
	 * Creating the menu item
	 *
	 * @access public
	 *
	 * @return string The content to be ouput.
	 */
	function wpd_data_output_content( $content ) {

		global $post;

		/**
		 * Access all settings
		 */
		$wpd_settings = get_option( 'wpdas_display' );

		// Get post type.
		$post_type = get_post_type_object( get_post_type( $post ) );

		/**
		 * Adding the WP Dispensary menu item data
		 */

		$original = '';

		if ( in_array( $post_type, apply_filters( 'wpd_original_array', array( 'products' ) ) ) ) {
			$original = $content;
		}

		if ( in_array( $post_type, apply_filters( 'wpd_content_array', array( 'products' ) ) ) ) {
			$content = '';
		}

		/**
		 * Adding Details table
		 */

		/**
		 * Setting up WP Dispensary menu item data
		 */
		// Required for is_plugin_active function.
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		// Check if WPD eCommerce is active.
		if ( is_plugin_active( 'wpd-ecommerce/wpd-ecommerce.php' ) ) {
			// Make variables empty since they're displayed elsewhere in the eCommerce plugin.
			$wpd_shelf_type  = '';
			$wpd_strain_type = '';
			$wpd_vendors     = '';
		} else {
			if ( get_the_term_list( $post->ID, 'shelf_type', true ) ) {
				$wpd_shelf_type = '<tr><td><span>' . __( 'Shelf', 'wp-dispensary' ) . '</span></td><td>' . get_the_term_list( $post->ID, 'shelf_type', '', ', ', '' ) . '</td></tr>';
			} else {
				$wpd_shelf_type = '';
			}
			if ( get_the_term_list( $post->ID, 'strain_type', true ) ) {
				$wpd_strain_type = '<tr><td><span>' . __( 'Strain', 'wp-dispensary' ) . '</span></td><td>' . get_the_term_list( $post->ID, 'strain_type', '', ', ', '' ) . '</td></tr>';
			} else {
				$wpd_strain_type = '';
			}
			if ( get_the_term_list( $post->ID, 'vendor', true ) ) {
				$wpd_vendors = '<tr><td><span>' . __( 'Vendor', 'wp-dispensary' ) . '</span></td><td>' . get_the_term_list( $post->ID, 'vendor', '', ', ', '' ) . '</td></tr>';
			} else {
				$wpd_vendors = '';
			}
		}

		if ( get_the_term_list( $post->ID, 'aroma', true ) ) {
			$wpd_aroma = '<tr><td><span>' . __( 'Aromas', 'wp-dispensary' ) . '</span></td><td>' . get_the_term_list( $post->ID, 'aroma', '', ', ', '' ) . '</td></tr>';
		} else {
			$wpd_aroma = '';
		}

		if ( get_the_term_list( $post->ID, 'flavor', true ) ) {
			$wpd_flavor = '<tr><td><span>' . __( 'Flavors', 'wp-dispensary' ) . '</span></td><td>' . get_the_term_list( $post->ID, 'flavor', '', ', ', '' ) . '</td></tr>';
		} else {
			$wpd_flavor = '';
		}

		if ( get_the_term_list( $post->ID, 'effect', true ) ) {
			$wpd_effect = '<tr><td><span>' . __( 'Effects', 'wp-dispensary' ) . '</span></td><td>' . get_the_term_list( $post->ID, 'effect', '', ', ', '' ) . '</td></tr>';
		} else {
			$wpd_effect = '';
		}

		if ( get_the_term_list( $post->ID, 'symptom', true ) ) {
			$wpd_symptom = '<tr><td><span>' . __( 'Symptoms', 'wp-dispensary' ) . '</span></td><td>' . get_the_term_list( $post->ID, 'symptom', '', ', ', '' ) . '</td></tr>';
		} else {
			$wpd_symptom = '';
		}

		if ( get_the_term_list( $post->ID, 'condition', true ) ) {
			$wpd_condition = '<tr><td><span>' . __( 'Conditions', 'wp-dispensary' ) . '</span></td><td>' . get_the_term_list( $post->ID, 'condition', '', ', ', '' ) . '</td></tr>';
		} else {
			$wpd_condition = '';
		}

		if ( get_the_term_list( $post->ID, 'ingredients', true ) ) {
			$wpd_ingredients = '<tr><td><span>' . __( 'Ingredients', 'wp-dispensary' ) . '</span></td><td>' . get_the_term_list( $post->ID, 'ingredients', '', ', ', '' ) . '</td></tr>';
		} else {
			$wpd_ingredients = '';
		}

		if ( get_the_term_list( $post->ID, 'allergens', true ) ) {
			$wpd_allergens = '<tr><td><span>' . __( 'Allergens', 'wp-dispensary' ) . '</span></td><td>' . get_the_term_list( $post->ID, 'allergens', '', ', ', '' ) . '</td></tr>';
		} else {
			$wpd_allergens = '';
		}

		if ( get_post_meta( get_the_ID(), 'compounds_thc', true ) ) {
			$wpd_thc = '<td><span>' . __( 'THC', 'wp-dispensary' ) . '</span>' . get_post_meta( get_the_id(), 'compounds_thc', true ) . '%</td>';
		} else {
			$wpd_thc = '';
		}

		if ( get_post_meta( get_the_ID(), 'compounds_thca', true ) ) {
			$wpd_thca = '<td><span>' . __( 'THCA', 'wp-dispensary' ) . '</span>' . get_post_meta( get_the_id(), 'compounds_thca', true ) . '%</td>';
		} else {
			$wpd_thca = '';
		}

		if ( get_post_meta( get_the_ID(), 'compounds_cbd', true ) ) {
			$wpd_cbd = '<td><span>' . __( 'CBD', 'wp-dispensary' ) . '</span>' . get_post_meta( get_the_id(), 'compounds_cbd', true ) . '%</td>';
		} else {
			$wpd_cbd = '';
		}

		if ( get_post_meta( get_the_ID(), 'compounds_cba', true ) ) {
			$wpd_cba = '<td><span>' . __( 'CBA', 'wp-dispensary' ) . '</span>' . get_post_meta( get_the_id(), 'compounds_cba', true ) . '%</td>';
		} else {
			$wpd_cba = '';
		}

		if ( get_post_meta( get_the_ID(), 'compounds_cbn', true ) ) {
			$wpd_cbn = '<td><span>' . __( 'CBN', 'wp-dispensary' ) . '</span>' . get_post_meta( get_the_id(), 'compounds_cbn', true ) . '%</td>';
		} else {
			$wpd_cbn = '';
		}

		if ( get_post_meta( get_the_ID(), 'compounds_cbg', true ) ) {
			$wpd_cbg = '<td><span>' . __( 'CBG', 'wp-dispensary' ) . '</span>' . get_post_meta( get_the_id(), 'compounds_cbg', true ) . '%</td>';
		} else {
			$wpd_cbg = '';
		}

		if ( get_post_meta( get_the_ID(), 'compounds_thc', true ) ) {
			$wpd_thc_mg = '<tr><td><span>' . __( 'THC mg per serving', 'wp-dispensary' ) . '</span></td><td>' . get_post_meta( get_the_id(), 'compounds_thc', true ) . '</td></tr>';
		} else {
			$wpd_thc_mg = '';
		}

		if ( get_post_meta( get_the_ID(), 'compounds_cbd', true ) ) {
			$wpd_cbd_mg = '<tr><td><span>' . __( 'CBD mg per serving', 'wp-dispensary' ) . '</span></td><td>' . get_post_meta( get_the_id(), 'compounds_cbd', true ) . '</td></tr>';
		} else {
			$wpd_cbd_mg = '';
		}

		if ( get_post_meta( get_the_ID(), 'product_servings', true ) ) {
			$wpd_servings = '<tr><td><span>' . __( 'Servings', 'wp-dispensary' ) . '</span></td><td>' . get_post_meta( get_the_id(), 'product_servings', true ) . '</td></tr>';
		} else {
			$wpd_servings = '';
		}

		if ( get_post_meta( get_the_ID(), 'product_net_weight', true ) ) {
			$wpd_net_weight = '<tr><td><span>' . __( 'Net weight', 'wp-dispensary' ) . '</span></td><td>' . get_post_meta( get_the_id(), 'product_net_weight', true ) . 'g</td></tr>';
		} else {
			$wpd_net_weight = '';
		}

		if ( get_post_meta( get_the_ID(), 'compounds_thc', true ) ) {
			$wpd_thc_topical = '<tr><td><span>' . __( 'THC', 'wp-dispensary' ) . '</span></td><td>' . get_post_meta( get_the_id(), 'compounds_thc', true ) . 'mg</td></tr>';
		} else {
			$wpd_thc_topical = '';
		}

		if ( get_post_meta( get_the_ID(), 'compounds_cbd', true ) ) {
			$wpd_cbd_topical = '<tr><td><span>' . __( 'CBD', 'wp-dispensary' ) . '</span></td><td>' . get_post_meta( get_the_id(), 'compounds_cbd', true ) . 'mg</td></tr>';
		} else {
			$wpd_cbd_topical = '';
		}

		if ( get_post_meta( get_the_ID(), 'product_size', true ) ) {
			$wpd_size_topical = '<tr><td><span>' . __( 'Size', 'wp-dispensary' ) . '</span></td><td>' . get_post_meta( get_the_id(), 'product_size', true ) . ' (oz)</td></tr>';
		} else {
			$wpd_size_topical = '';
		}

		if ( get_post_meta( get_the_ID(), 'seed_count', true ) ) {
			$wpd_seed_count = '<tr><td><span>' . __( 'Seeds per unit', 'wp-dispensary' ) . '</span></td><td>' . get_post_meta( get_the_id(), 'seed_count', true ) . '</td></tr>';
		} else {
			$wpd_seed_count = '';
		}

		if ( get_post_meta( get_the_ID(), 'clone_count', true ) ) {
			$wpd_clone_count = '<tr><td><span>' . __( 'Clones per unit', 'wp-dispensary' ) . '</span></td><td>' . get_post_meta( get_the_id(), 'clone_count', true ) . '</td></tr>';
		} else {
			$wpd_clone_count = '';
		}

		if ( get_post_meta( get_the_ID(), 'product_origin', true ) ) {
			$wpd_clone_origin = '<tr><td><span>' . __( 'Origin', 'wp-dispensary' ) . '</span></td><td>' . get_post_meta( get_the_id(), 'product_origin', true ) . '</td></tr>';
		} else {
			$wpd_clone_origin = '';
		}

		if ( get_post_meta( get_the_ID(), 'product_time', true ) ) {
			$wpd_clone_time = '<tr><td><span>' . __( 'Grow time', 'wp-dispensary' ) . '</span></td><td>' . get_post_meta( get_the_id(), 'product_time', true ) . '</td></tr>';
		} else {
			$wpd_clone_time = '';
		}

		if ( get_post_meta( get_the_ID(), 'product_yield', true ) ) {
			$wpd_clone_yield = '<tr><td><span>' . __( 'Yield', 'wp-dispensary' ) . '</span></td><td>' . get_post_meta( get_the_id(), 'product_yield', true ) . '</td></tr>';
		} else {
			$wpd_clone_yield = '';
		}

		if ( get_post_meta( get_the_ID(), 'product_difficulty', true ) ) {
			$wpd_clone_difficulty = '<tr><td><span>' . __( 'Difficulty', 'wp-dispensary' ) . '</span></td><td>' . get_post_meta( get_the_id(), 'product_difficulty', true ) . '</td></tr>';
		} else {
			$wpd_clone_difficulty = '';
		}

		if ( get_post_meta( get_the_ID(), 'product_weight', true ) ) {
			$wpd_preroll_weight = '<tr><td><span>' . __( 'Weight', 'wp-dispensary' ) . '</span></td><td>' . get_post_meta( get_the_id(), 'product_weight', true ) . 'g</td></tr>';
		} else {
			$wpd_preroll_weight = '';
		}

		if ( get_post_meta( get_the_ID(), 'product_flower', true ) ) {
			$preroll_flower = get_post_meta( get_the_id(), 'product_flower', true );
			$wpd_preroll    = '<tr><td><span>' . __( 'Flower', 'wp-dispensary' ) . '</span></td><td><a href=' . get_permalink( $preroll_flower ) . '>' . get_the_title( $preroll_flower ) . '</a></td></tr>';
		} else {
			$wpd_preroll = '';
		}

		if ( get_post_meta( get_the_ID(), 'product_flower', true ) ) {
			$grower_flower = get_post_meta( get_the_id(), 'product_flower', true );
			$wpd_grower    = '<tr><td><span>' . __( 'Flower', 'wp-dispensary' ) . '</span></td><td><a href=' . get_permalink( $grower_flower ) . '>' . get_the_title( $grower_flower ) . '</a></td></tr>';
		} else {
			$wpd_grower = '';
		}

		/**
		 * Details Table Before Action Hook
		 *
		 * @since      1.9.5
		 */
		if ( in_array( get_post_type(), apply_filters( 'wpd_dataoutput_before_array', array( 'products' ) ) ) ) {
			ob_start();
			do_action( 'wpd_dataoutput_before' );
			$wpd_data_before = ob_get_clean();
		}

		/**
		 * Details Table Top Action Hook
		 *
		 * @since      1.9.5
		 */
		if ( in_array( get_post_type(), apply_filters( 'wpd_dataoutput_top_array', array( 'products' ) ) ) ) {
			ob_start();
			do_action( 'wpd_dataoutput_top' );
			$wpd_data_top = ob_get_clean();
		}

		if ( in_array( get_post_type(), apply_filters( 'wpd_dataoutput_title_array', array( 'products' ) ) ) ) {
			$details_table_top = $wpd_data_before . '<table class="wpdispensary-table single details"><thead><tr><td class="wpdispensary-title" colspan="7">' . get_wpd_details_phrase() . '</td></tr></thead><tbody class="wpdispensary-details">' . $wpd_data_top;
		} else {
			$details_table_top = '';
		}

		if ( in_array( get_post_meta( get_the_ID(), 'product_type', true ), array( 'flowers', 'concentrates' ) ) ) {
			$details_flowers_concentrates = $wpd_shelf_type . $wpd_strain_type . $wpd_aroma . $wpd_flavor . $wpd_effect . $wpd_symptom . $wpd_condition . $wpd_vendors;
		} else {
			$details_flowers_concentrates = '';
		}

		if ( 'edibles' == get_post_meta( get_the_ID(), 'product_type', true ) ) {
			$details_edibles = $wpd_servings . $wpd_thc_mg . $wpd_cbd_mg . $wpd_net_weight . $wpd_ingredients . $wpd_allergens . $wpd_vendors;
		} else {
			$details_edibles = '';
		}

		if ( 'prerolls' == get_post_meta( get_the_ID(), 'product_type', true ) ) {
			$details_prerolls = $wpd_shelf_type . $wpd_strain_type . $wpd_preroll . $wpd_preroll_weight . $wpd_vendors;
		} else {
			$details_prerolls = '';
		}

		if ( 'topicals' == get_post_meta( get_the_ID(), 'product_type', true ) ) {
			$details_topicals = $wpd_size_topical . $wpd_thc_topical . $wpd_cbd_topical . $wpd_ingredients . $wpd_vendors;
		} else {
			$details_topicals = '';
		}

		if ( 'growers' == get_post_meta( get_the_ID(), 'product_type', true ) ) {
			$details_growers = $wpd_strain_type . $wpd_seed_count . $wpd_clone_count . $wpd_clone_origin . $wpd_clone_time . $wpd_clone_yield . $wpd_clone_difficulty . $wpd_vendors;
		} else {
			$details_growers = '';
		}

		// Menu types that display compounds.
		$compounds_table = array( 'flowers', 'concentrates', 'prerolls' );

		// Filter menu types that display compounds.
		$compounds_table = apply_filters( 'wpd_data_output_compounds_table', $compounds_table );

		// Compounds table.
		if ( in_array( get_post_meta( get_the_ID(), 'product_type', true ), $compounds_table ) ) {
			if ( empty( $wpd_thc ) && empty( $wpd_thca ) && empty( $wpd_cbd ) && empty( $wpd_cba ) && empty( $wpd_cbn ) && empty( $wpd_cbg ) ) {
				$details_compounds = '';
			} else {
				// Get compounds.
				$compounds = get_wpd_compounds_array( get_the_ID(), $type = '%', array( 'thc', 'thca', 'cbd', 'cba', 'cbn', 'cbg' ) );

				//print_r( $compounds );

				// Create empty variable.
				$showcompounds = '';

				// Loop through each compound, and append it to variable.
				foreach ( $compounds as $compound=>$value ) {
					$showcompounds .= '<td><strong>' . $compound . '</strong> ' . $value . '</td>';
				}

				// Add total compounds.
				if ( get_post_meta( get_the_ID(), '_total_compounds', TRUE ) ) {
					$showcompounds .= '<td><strong>' . __( 'TOTAL', 'wp-dispensary' ) . '</strong> ' . get_post_meta( get_the_ID(), '_total_compounds', TRUE ) . '%</td>';
				}

				// Combine compounds into one variable.
				$showcompounds = $showcompounds;

				// Create compounds table.
				$details_compounds = '<table class="wpdispensary-table single details compound-details"><tr><td class="wpdispensary-title" colspan="6">' . __( 'Compounds', 'wp-dispensary' ) . '</td></tr><tr>' . $showcompounds . '</tr></table>';

				if ( ! is_plugin_active( 'wpd-ecommerce/wpd-ecommerce.php' ) ) {
					if ( ! isset( $wpd_settings['wpd_hide_compounds'] ) ) {
						$details_compounds = $details_compounds;
					} elseif ( isset( $wpd_settings['wpd_hide_compounds'] ) && 'on' !== $wpd_settings['wpd_hide_compounds'] ) {
						$details_compounds = $details_compounds;
					} else {
						$details_compounds = '';
					}
				} else {
					$details_compounds = '';
				}
			}
		} else {
			$details_compounds = '';
		}

		/**
		 * Details Table Bottom Action Hook
		 *
		 * @since      1.8.0
		 */
		if ( in_array( get_post_type(), apply_filters( 'wpd_dataoutput_bottom_array', array( 'products' ) ) ) ) {
			ob_start();
			do_action( 'wpd_dataoutput_bottom' );
			$wpd_data_bottom = ob_get_clean();
		}

		if ( in_array( get_post_type(), apply_filters( 'wpd_dataoutput_end_array', array( 'products' ) ) ) ) {
			$details_table_bottom = $wpd_data_bottom . '</tbody></table>';
		} else {
			$details_table_bottom = '';
		}

		/**
		 * Details table build
		 */
		if ( ! isset( $wpd_settings['wpd_hide_details'] ) ) {
			$wpd_table_details = $details_table_top . $details_flowers_concentrates . $details_prerolls . $details_growers . $details_edibles . $details_topicals . $details_table_bottom;
		} elseif ( isset( $wpd_settings['wpd_hide_details'] ) && 'on' !== $wpd_settings['wpd_hide_details'] ) {
			$wpd_table_details = $details_table_top . $details_flowers_concentrates . $details_prerolls . $details_growers . $details_edibles . $details_topicals . $details_table_bottom;
		} else {
			$wpd_table_details = '';
		}

		/**
		 * Setting up WP Dispensary menu pricing data
		 */
		if ( get_post_meta( get_the_ID(), 'price_each', true ) ) {
			$price_each = '<tr class="priceeach"><td><span>' . esc_attr__( 'Price each:', 'wp-dispensary' ) . '</span></td><td>' . wpd_currency_code() . get_post_meta( get_the_id(), 'price_each', true ) . '</td></tr>';
		} else {
			$price_each = '';
		}

		if ( get_post_meta( get_the_ID(), 'price_per_pack', true ) ) {
			$price_per_pack = '<tr class="priceeach"><td><span>' . get_post_meta( get_the_ID(), 'units_per_pack', true ) . ' ' . __( 'per pack:', 'wp-dispensary' ) . '</span></td><td>' . wpd_currency_code() . get_post_meta( get_the_ID(), 'price_per_pack', true ) . '</td></tr>';
		} else {
			$price_per_pack = '';
		}

		if ( get_post_meta( get_the_ID(), 'price_each', true ) ) {
			$price_per_unit = '<tr class="priceeach"><td><span>' . esc_attr__( 'Price each:', 'wp-dispensary' ) . '</span></td><td>' . wpd_currency_code() . get_post_meta( get_the_id(), 'price_each', true ) . '</td></tr>';
		} else {
			$price_per_unit = '';
		}

		if ( get_post_meta( get_the_ID(), 'price_each', true ) ) {
			$price_topical = '<tr class="priceeach"><td><span>' . esc_attr__( 'Price per unit:', 'wp-dispensary' ) . '</span></td><td>' . wpd_currency_code() . get_post_meta( get_the_id(), 'price_each', true ) . '</td></tr>';
		} else {
			$price_topical = '';
		}

		// Flower prices.
		$flower_prices = '';

		// Add price for each available weight.
		foreach ( wpd_flowers_weights_array() as $id=>$value ) {
			if ( get_post_meta( get_the_ID(), $value, true ) ) {
				$flower_prices .= '<td><span>' . $id . '</span> ' . wpd_currency_code() . get_post_meta( get_the_id(), $value, true ) . '</td>';
			}
		}

		// Concentrate prices.
		$concentrate_prices = '';

		// Add price for each available weight.
		foreach ( wpd_concentrates_weights_array() as $id=>$value ) {
			if ( get_post_meta( get_the_ID(), $value, true ) ) {
				$concentrate_prices .= '<td><span>' . $id . '</span> ' . wpd_currency_code() . get_post_meta( get_the_id(), $value, true ) . '</td>';
			}
		}
		/**
		 * Pricing Table Before Action Hook
		 *
		 * @since      1.9.5
		 */
		if ( in_array( get_post_type(), apply_filters( 'wpd_pricingoutput_before_array', array( 'products' ) ) ) ) {
			ob_start();
			do_action( 'wpd_pricingoutput_before' );
			$wpd_pricing_before = ob_get_clean();
		}

		/**
		 * Pricing Table Top Action Hook
		 *
		 * @since      1.9.5
		 */
		if ( in_array( get_post_type(), apply_filters( 'wpd_pricingoutput_top_array', array( 'products' ) ) ) ) {
			ob_start();
			do_action( 'wpd_pricingoutput_top' );
			$wpd_pricing_top = ob_get_clean();
		}

		/**
		 * Starting to build the Pricing table
		 */
		if ( in_array( get_post_type(), apply_filters( 'wpd_pricingoutput_before_array', array( 'products' ) ) ) ) {
			$pricing_table_top = $wpd_pricing_before . '<table class="wpdispensary-table single pricing"><thead><tr><td class="wpdispensary-title" colspan="7">' . esc_html( get_wpd_pricing_phrase( $singular = false ) ) . '</td></tr></thead><tbody class="wpdispensary-prices">' . $wpd_pricing_top;
		} else {
			$pricing_table_top = '';
		}

		if ( 'flowers' == get_post_meta( get_the_ID(), 'product_type', true ) ) {
			$pricing_table_flowers = '<tr>' . $flower_prices . '</tr>';
		} else {
			$pricing_table_flowers = '';
		}

		if ( 'concentrates' == get_post_meta( get_the_ID(), 'product_type', true ) ) {
			$pricing_table_concentrates = '<tr>' . $concentrate_prices . '</tr>';
		} else {
			$pricing_table_concentrates = '';
		}

		if ( in_array( get_post_meta( get_the_ID(), 'product_type', true ), array( 'prerolls', 'edibles' ) ) ) {
			$pricing_table_prerolls_edibles = $price_each . $price_per_pack;
		} else {
			$pricing_table_prerolls_edibles = '';
		}

		if ( 'topicals' == get_post_meta( get_the_ID(), 'product_type', true ) ) {
			$pricing_table_topicals = $price_topical;
		} else {
			$pricing_table_topicals = '';
		}

		if ( 'growers' == get_post_meta( get_the_ID(), 'product_type', true ) ) {
			$pricing_table_growers = $price_per_unit . $price_per_pack;
		} else {
			$pricing_table_growers = '';
		}

		/**
		 * Pricing Table Bottom Action Hook
		 *
		 * @since      1.8.0
		 */
		if ( in_array( get_post_type(), apply_filters( 'wpd_pricingoutput_bottom_array', array( 'products' ) ) ) ) {
			ob_start();
			do_action( 'wpd_pricingoutput_bottom' );
			$wpd_pricing_bottom = ob_get_clean();
		}

		/**
		 * Pricing Table After Action Hook
		 *
		 * @since      1.9.5
		 */
		if ( in_array( get_post_type(), apply_filters( 'wpd_pricingoutput_after_array', array( 'products' ) ) ) ) {
			ob_start();
			do_action( 'wpd_pricingoutput_after' );
			$wpd_pricing_after = ob_get_clean();
		}

		if ( in_array( get_post_type(), apply_filters( 'wpd_pricingoutput_bottom_array', array( 'products' ) ) ) ) {
			$pricing_table_bottom = $wpd_pricing_bottom . '</tbody></table>' . $wpd_pricing_after;
		} else {
			$pricing_table_bottom = '';
		}

		/**
		 * Price table build
		 */
		if ( ! is_plugin_active( 'wpd-ecommerce/wpd-ecommerce.php' ) ) {
			if ( ! isset( $wpd_settings['wpd_hide_pricing'] ) ) {
				$wpd_table_pricing = $pricing_table_top . $pricing_table_flowers . $pricing_table_concentrates . $pricing_table_prerolls_edibles . $pricing_table_growers . $pricing_table_topicals . $pricing_table_bottom;
			} elseif ( isset( $wpd_settings['wpd_hide_pricing'] ) && 'on' !== $wpd_settings['wpd_hide_pricing'] ) {
				$wpd_table_pricing = $pricing_table_top . $pricing_table_flowers . $pricing_table_concentrates . $pricing_table_prerolls_edibles . $pricing_table_growers . $pricing_table_topicals . $pricing_table_bottom;
			} else {
				$wpd_table_pricing = '';
			}
		} else {
			$wpd_table_pricing = '';
		}

		/**
		 * Conditional statement to output menu
		 * item pricing above or below the_content
		 */
		if ( is_singular( apply_filters( 'wpd_pricing_table_placement_array', array( 'products' ) ) ) ) {

			// Pricing Placement.
			if ( isset( $wpd_settings['wpd_pricing_table_placement'] ) && 'above' !== $wpd_settings['wpd_pricing_table_placement'] ) {
				$wpd_pricing_below = $wpd_table_pricing;
			} else {
				$wpd_pricing_below = '';
			}

			// Pricing Placement.
			if ( ! isset( $wpd_settings['wpd_pricing_table_placement'] ) ) {
				$wpd_pricing_above = $wpd_table_pricing;
			} elseif ( isset( $wpd_settings['wpd_pricing_table_placement'] ) && 'below' !== $wpd_settings['wpd_pricing_table_placement'] ) {
				$wpd_pricing_above = $wpd_table_pricing;
			} else {
				$wpd_pricing_above = '';
			}

			// Compounds Placement (below).
			if ( ! isset( $wpd_settings['wpd_compounds_table_placement'] ) ) {
				$wpd_compound_details_below = $details_compounds;
			} elseif ( isset( $wpd_settings['wpd_compounds_table_placement'] ) && 'above' !== $wpd_settings['wpd_compounds_table_placement'] ) {
				$wpd_compound_details_below = $details_compounds;
			} else {
				$wpd_compound_details_below = '';
			}

			// Compounds Placement (above).
			if ( isset( $wpd_settings['wpd_compounds_table_placement'] ) && 'below' !== $wpd_settings['wpd_compounds_table_placement'] ) {
				$wpd_compound_details_above = $details_compounds;
			} else {
				$wpd_compound_details_above = '';
			}

			// Details Placement (below).
			if ( ! isset( $wpd_settings['wpd_details_table_placement'] ) ) {
				$details_below = $wpd_table_details;
			} elseif ( isset( $wpd_settings['wpd_details_table_placement'] ) && 'above' !== $wpd_settings['wpd_details_table_placement'] ) {
				$details_below = $wpd_table_details;
			} else {
				$details_below = '';
			}

			// Details Placement (above).
			if ( isset( $wpd_settings['wpd_details_table_placement'] ) && 'below' !== $wpd_settings['wpd_details_table_placement'] ) {
				$details_above = $wpd_table_details;
			} else {
				$details_above = '';
			}

			// Apply before.
			$new_content = $wpd_pricing_above . $wpd_compound_details_above . $details_above . $original . $wpd_pricing_below . $wpd_compound_details_below . $details_below;

			return $new_content;
		} else {
			return $content;
		}

	}
	add_filter( 'the_content', 'wpd_data_output_content' );

}
