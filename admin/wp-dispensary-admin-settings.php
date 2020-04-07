<?php
/**
 * Adding the Admin Settings Page
 *
 * @link       https://www.wpdispensary.com
 * @since      2.0.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin
 */

/**
 * Define global constants.
 *
 * @since 2.0
 */
if ( ! defined( 'WPD_ADMIN_SETTINGS_VERSION' ) ) {
	define( 'WPD_ADMIN_SETTINGS_VERSION', WP_DISPENSARY_VERSION );
}
if ( ! defined( 'WPDS_NAME' ) ) {
	define( 'WPDS_NAME', trim( dirname( plugin_basename( __FILE__ ) ), '/' ) );
}
if ( ! defined( 'WPDS_DIR' ) ) {
	define( 'WPDS_DIR', WP_PLUGIN_DIR . '/' . WPDS_NAME );
}
if ( ! defined( 'WPDS_URL' ) ) {
	define( 'WPDS_URL', WP_PLUGIN_URL . '/' . WPDS_NAME );
}

// Required for is_plugin_active function.
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Class `WPD_ADMIN_SETTINGS`.
 *
 * @since 2.0
 */
require_once( WPDS_DIR . '/class-wp-dispensary-admin-settings.php' );

/**
 * Actions/Filters
 *
 * Related to all settings API.
 *
 * @since  2.0
 */
if ( class_exists( 'WPD_ADMIN_SETTINGS' ) ) {

	// Args for pages.
	$args = array(
		'sort_order'   => 'asc',
		'sort_column'  => 'post_title',
		'hierarchical' => 1,
		'exclude'      => '',
		'include'      => '',
		'meta_key'     => '',
		'meta_value'   => '',
		'authors'      => '',
		'child_of'     => 0,
		'parent'       => -1,
		'exclude_tree' => '',
		'number'       => '',
		'offset'       => 0,
		'post_type'    => 'page',
		'post_status'  => 'publish'
	);

	// Get all pages.
	$pages = get_pages( $args );
	// Loop through pages.
	foreach ( $pages as $page ) {
		$pages_array[$page->post_name] = $page->post_title;
	}

	//print_r( $pages_array );

	/**
	 * Object Instantiation.
	 *
	 * Object for the class `WPD_ADMIN_SETTINGS`.
	 */
	$wpdas_obj = new WPD_ADMIN_SETTINGS();

	// Section: Display.
	$wpdas_obj->add_section(
		array(
			'id'    => 'wpdas_display',
			'title' => esc_attr__( 'Display', 'wp-dispensary' ),
		)
	);

	// Section: General.
	$wpdas_obj->add_section(
		array(
			'id'    => 'wpdas_general',
			'title' => esc_attr__( 'General', 'wp-dispensary' ),
		)
	);

	// Check if WPD eCommerce is active.
	if ( is_plugin_active( 'wpd-ecommerce/wpd-ecommerce.php' ) ) {
		// Section: Payments.
		$wpdas_obj->add_section(
			array(
				'id'    => 'wpdas_payments',
				'title' => esc_attr__( 'Payments', 'wp-dispensary' ),
			)
		);

		// Section: Patients.
		$wpdas_obj->add_section(
			array(
				'id'    => 'wpdas_patients',
				'title' => esc_attr__( 'Patients', 'wp-dispensary' ),
			)
		);

		// Section: Pages.
		$wpdas_obj->add_section(
			array(
				'id'    => 'wpdas_pages',
				'title' => esc_attr__( 'Pages', 'wp-dispensary' ),
			)
		);
	}

	// Check if WPD METRC is active.
	if ( is_plugin_active( 'wpd-metrc/wpd-metrc.php' ) ) {
		// Section: Metrc.
		$wpdas_obj->add_section(
			array(
				'id'    => 'wpdas_metrc',
				'title' => esc_attr__( 'Metrc', 'wp-dispensary' ),
			)
		);
	}

	// Check if WPD eCommerce is active.
	if ( ! is_plugin_active( 'wpd-ecommerce/wpd-ecommerce.php' ) ) {
		/**
		 * Add Field: Display a title to help separate fields
		 * Field:     title
		 * Section:   wpdas_display
		 */
		$wpdas_obj->add_field(
			'wpdas_display',
			array(
				'id'   => 'wpd_settings_pricing_table_title',
				'type' => 'title',
				'name' => '<h1>' . esc_attr__( 'Prices table', 'wp-dispensary' ) . '</h1>',
			)
		);

		/**
		 * Add Field: Pricing phrase
		 * Field:     select
		 * Section:   wpdas_display
		 */
		$wpdas_obj->add_field(
			'wpdas_display',
			array(
				'id'      => 'wpd_pricing_phrase',
				'type'    => 'select',
				'name'    => esc_attr__( 'Title', 'wp-dispensary' ),
				'desc'    => esc_attr__( 'Choose the title you would like used', 'wp-dispensary' ),
				'options' => array(
					'Price'    => 'Prices',
					'Donation' => 'Donations',
				),
			)
		);

		/**
		 * Add Field: Custom title
		 * Field:     text
		 * Section:   wpdas_display
		 */
		$wpdas_obj->add_field(
			'wpdas_display',
			array(
				'id'          => 'wpd_pricing_phrase_custom',
				'type'        => 'text',
				'name'        => '',
				'desc'        => esc_attr__( 'or add a custom title', 'wp-dispensary' ),
				'placeholder' => '',
			)
		);

		/**
		 * Add Field: Pricing table display
		 * Field:     select
		 * Section:   wpdas_display
		 */
		$wpdas_obj->add_field(
			'wpdas_display',
			array(
				'id'      => 'wpd_pricing_table_placement',
				'type'    => 'select',
				'name'    => esc_attr__( 'Display', 'wp-dispensary' ),
				'desc'    => esc_attr__( 'Where should the pricing display on single menu items?', 'wp-dispensary' ),
				'options' => array(
					'above' => 'Above Content',
					'below' => 'Below Content',
				),
			)
		);

		/**
		 * Add Field: Hide pricing table
		 * Field:     checkbox
		 * Section:   wpdas_display
		 */
		$wpdas_obj->add_field(
			'wpdas_display',
			array(
				'id'   => 'wpd_hide_pricing',
				'type' => 'checkbox',
				'name' => '',
				'desc' => esc_attr__( 'Remove the price table from data output', 'wp-dispensary' ),
			)
		);

		/**
		 * Add Field: Separator between fields
		 * Field:     separator
		 * Section:   wpdas_display
		 */
		$wpdas_obj->add_field(
			'wpdas_display',
			array(
				'id'   => 'wpd_settings_separator',
				'type' => 'separator',
			)
		);
	}

	/**
	 * Add Field: Display a title to help separate fields
	 * Field:     title
	 * Section:   wpdas_display
	 */
	$wpdas_obj->add_field(
		'wpdas_display',
		array(
			'id'   => 'wpd_settings_compounds_table_title',
			'type' => 'title',
			'name' => '<h1>' . esc_attr__( 'Compounds table', 'wp-dispensary' ) . '</h1>',
		)
	);

	/**
	 * Add Field: Details table placement
	 * Field:     select
	 * Section:   wpdas_display
	 *
	 * @todo make the options filterable for WPD eCommerce to add and set an option on install.
	 */
	$wpdas_obj->add_field(
		'wpdas_display',
		array(
			'id'      => 'wpd_compounds_table_placement',
			'type'    => 'select',
			'name'    => esc_attr__( 'Display', 'wp-dispensary' ),
			'desc'    => esc_attr__( 'Where should the compounds display on single menu items?', 'wp-dispensary' ),
			'options' => array(
				'above' => 'Above Content',
				'below' => 'Below Content',
			),
		)
	);

	/**
	 * Add Field: Display compounds table
	 * Field:     checkbox
	 * Section:   wpdas_display
	 */
	$wpdas_obj->add_field(
		'wpdas_display',
		array(
			'id'   => 'wpd_hide_compounds',
			'type' => 'checkbox',
			'name' => '',
			'desc' => esc_attr__( 'Remove the compounds table from data output', 'wp-dispensary' ),
		)
	);

	/**
	 * Add Field: Separator between fields
	 * Field:     separator
	 * Section:   wpdas_display
	 */
	$wpdas_obj->add_field(
		'wpdas_display',
		array(
			'id'   => 'wpd_settings_separator_compounds',
			'type' => 'separator',
		)
	);

	/**
	 * Add Field: Display a title to help separate fields
	 * Field:     title
	 * Section:   wpdas_display
	 */
	$wpdas_obj->add_field(
		'wpdas_display',
		array(
			'id'   => 'wpd_settings_details_table_title',
			'type' => 'title',
			'name' => '<h1>' . esc_attr__( 'Details table', 'wp-dispensary' ) . '</h1>',
		)
	);

	/**
	 * Add Field: Details phrase
	 * Field:     select
	 * Section:   wpdas_display
	 */
	$wpdas_obj->add_field(
		'wpdas_display',
		array(
			'id'      => 'wpd_details_phrase',
			'type'    => 'select',
			'name'    => esc_attr__( 'Title', 'wp-dispensary' ),
			'desc'    => esc_attr__( 'Choose the title you would like used', 'wp-dispensary' ),
			'options' => array(
				'Details'     => esc_attr__( 'Details', 'wp-dispensary' ),
				'Information' => esc_attr__( 'Information', 'wp-dispensary' ),
			),
		)
	);

	/**
	 * Add Field: Custom title
	 * Field:     text
	 * Section:   wpdas_display
	 */
	$wpdas_obj->add_field(
		'wpdas_display',
		array(
			'id'          => 'wpd_details_phrase_custom',
			'type'        => 'text',
			'name'        => '',
			'desc'        => esc_attr__( 'or add a custom title', 'wp-dispensary' ),
			'placeholder' => '',
		)
	);

	/**
	 * Add Field: Details table placement
	 * Field:     select
	 * Section:   wpdas_display
	 */
	$wpdas_obj->add_field(
		'wpdas_display',
		array(
			'id'      => 'wpd_details_table_placement',
			'type'    => 'select',
			'name'    => esc_attr__( 'Display', 'wp-dispensary' ),
			'desc'    => esc_attr__( 'Where should the details display on single menu items?', 'wp-dispensary' ),
			'options' => array(
				'above' => esc_attr__( 'Above Content', 'wp-dispensary' ),
				'below' => esc_attr__( 'Below Content', 'wp-dispensary' ),
			),
		)
	);

	/**
	 * Add Field: Display details table
	 * Field:     checkbox
	 * Section:   wpdas_display
	 */
	$wpdas_obj->add_field(
		'wpdas_display',
		array(
			'id'   => 'wpd_hide_details',
			'type' => 'checkbox',
			'name' => '',
			'desc' => esc_attr__( 'Remove the details table from data output', 'wp-dispensary' ),
		)
	);

	// Check if WPD eCommerce is active.
	if ( is_plugin_active( 'wpd-ecommerce/wpd-ecommerce.php' ) ) {
		/**
		 * Add Field: Display a title to help separate fields
		 * Field:     title
		 * Section:   wpdas_general
		 */
		$wpdas_obj->add_field(
			'wpdas_general',
			array(
				'id'   => 'wpd_settings_store_general',
				'type' => 'title',
				'name' => '<h1>' . esc_attr__( 'General', 'wp-dispensary' ) . '</h1>',
			)
		);
	}

	/**
	 * Add Field: Currency code
	 * Field:     select
	 * Section:   wpdas_general
	 */
	$wpdas_obj->add_field(
		'wpdas_general',
		array(
			'id'      => 'wpd_pricing_currency_code',
			'type'    => 'select',
			'name'    => esc_attr__( 'Currency', 'wp-dispensary' ),
			'desc'    => esc_attr__( 'Select the currency symbol you would like to use', 'wp-dispensary' ),
			'options' => wpd_pricing_currency_codes()
		)
	);

	// Check if WPD eCommerce is active.
	if ( is_plugin_active( 'wpd-ecommerce/wpd-ecommerce.php' ) ) {
		/**
		 * Add Field: Display a title to help separate fields
		 * Field:     title
		 * Section:   wpdas_general
		 */
		$wpdas_obj->add_field(
			'wpdas_general',
			array(
				'id'   => 'wpd_settings_store_taxes',
				'type' => 'title',
				'name' => '<h1>' . esc_attr__( 'Taxes', 'wp-dispensary' ) . '</h1>',
			)
		);

		/**
		 * Add Field: Sales tax
		 * Field:     select
		 * Section:   wpdas_display
		 */
		$wpdas_obj->add_field(
			'wpdas_general',
			array(
				'id'          => 'wpd_ecommerce_sales_tax',
				'type'        => 'text',
				'name'        => esc_attr__( 'Sales tax', 'wp-dispensary' ),
				'desc'        => esc_attr__( 'Apply sales tax to orders (%)', 'wp-dispensary' ),
				'placeholder' => esc_attr__( '6', 'wp-dispensary' ),
			)
		);

		/**
		 * Add Field: Excise tax
		 * Field:     text
		 * Section:   wpdas_display
		 */
		$wpdas_obj->add_field(
			'wpdas_general',
			array(
				'id'          => 'wpd_ecommerce_excise_tax',
				'type'        => 'text',
				'name'        => esc_attr__( 'Excise tax', 'wp-dispensary' ),
				'desc'        => esc_attr__( 'Apply excise tax to orders (%)', 'wp-dispensary' ),
				'placeholder' => esc_attr__( '10', 'wp-dispensary' ),
			)
		);

		/**
		 * Add Field: Display a title to help separate fields
		 * Field:     title
		 * Section:   wpdas_general
		 */
		$wpdas_obj->add_field(
			'wpdas_general',
			array(
				'id'   => 'wpd_settings_cart_options',
				'type' => 'title',
				'name' => '<h1>' . esc_attr__( 'Cart', 'wp-dispensary' ) . '</h1>',
			)
		);

		/**
		 * Add Field: Hide cart functionality for non-logged in users
		 * Field:     text
		 * Section:   wpdas_general
		 */
		$wpdas_obj->add_field(
			'wpdas_general',
			array(
				'id'   => 'wpd_ecommerce_cart_require_login_to_shop',
				'type' => 'checkbox',
				'name' => esc_attr__( 'Require login to shop', 'wp-dispensary' ),
				'desc' => esc_attr__( 'Hide the add to cart functionality for non-logged in users', 'wp-dispensary' ),
			)
		);

		/**
		 * Add Field: Display a title to help separate fields
		 * Field:     title
		 * Section:   wpdas_general
		 */
		$wpdas_obj->add_field(
			'wpdas_general',
			array(
				'id'   => 'wpd_settings_checkout_options',
				'type' => 'title',
				'name' => '<h1>' . esc_attr__( 'Checkout', 'wp-dispensary' ) . '</h1>',
			)
		);

		/**
		 * Add Field: Minimum order
		 * Field:     text
		 * Section:   wpdas_general
		 */
		$wpdas_obj->add_field(
			'wpdas_general',
			array(
				'id'          => 'wpd_ecommerce_checkout_minimum_order',
				'type'        => 'text',
				'name'        => esc_attr__( 'Minimum order', 'wp-dispensary' ),
				'desc'        => esc_attr__( 'Require a minimum order amount before checkout', 'wp-dispensary' ),
				'placeholder' => 'ex: 50',
			)
		);

		// Check if Coupons add-on is active.
		if ( is_plugin_active( 'dispensary-coupons/dispensary-coupons.php' ) ) {
			/**
			 * Add Field: Checkout coupons
			 * Field:     checkbox
			 * Section:   wpdas_general
			 */
			$wpdas_obj->add_field(
				'wpdas_general',
				array(
					'id'   => 'wpd_ecommerce_checkout_coupons',
					'type' => 'checkbox',
					'name' => esc_attr__( 'Coupons', 'wp-dispensary' ),
					'desc' => esc_attr__( 'Allow patients to apply a coupon to their order', 'wp-dispensary' ),
				)
			);
		}

		/**
		 * Checkout payment options
		 *
		 * @since 2.5
		 */
		$checkout_payments = array(
			'cod'    => esc_attr__( 'Cash on delivery', 'wp-dispensary' ),
			'pop'    => esc_attr__( 'Pay on pickup', 'wp-dispensary' ),
			'ground' => esc_attr__( 'Ground shipping', 'wp-dispensary' ),
		);

		$checkout_payment_options = apply_filters( 'wpd_ecommerce_checkout_payment_options', $checkout_payments );

		foreach ( $checkout_payment_options as $id=>$value ) {

			/**
			 * Add Field: Display a title to help separate fields
			 * Field:     title
			 * Section:   wpdas_payments
			 */
			$wpdas_obj->add_field(
				'wpdas_payments',
				array(
					'id'   => 'wpd_settings_payment_options_' . $id,
					'type' => 'title',
					'name' => '<h1>' . $value . '</h1>',
				)
			);

			/**
			 * Add Field: Checkout payments
			 * Field:     checkbox
			 * Section:   wpdas_payments
			 */
			$wpdas_obj->add_field(
				'wpdas_payments',
				array(
					'id'   => 'wpd_ecommerce_checkout_payments_' . $id . '_checkbox',
					'type' => 'checkbox',
					'name' => 'Enable/Disable',
					'desc' => esc_attr__( 'Enable ' . $value, 'wp-dispensary' ),
				)
			);

			/**
			 * Add Field: Checkout payments
			 * Field:     text
			 * Section:   wpdas_payments
			 */
			$wpdas_obj->add_field(
				'wpdas_payments',
				array(
					'id'          => 'wpd_ecommerce_checkout_payments_' . $id,
					'type'        => 'text',
					'name'        => esc_attr__( 'Charge', 'wp-dispensary' ),
					'placeholder' => esc_attr__( '0', 'wp-dispensary' ),
				)
			);

		} // foreach

		/**
		 * Add Field: Ground shipping instructions
		 * Field:     text
		 * Section:   wpdas_payments
		 */
		$wpdas_obj->add_field(
			'wpdas_payments',
			array(
				'id'   => 'wpd_ecommerce_checkout_payments_ground_textarea',
				'type' => 'textarea',
				'name' => esc_attr__( 'Instructions', 'wp-dispensary' ),
				'desc' => esc_attr__( 'Let the user know how to send payment for the order.', 'wp-dispensary' ),
			)
		);

		/**
		 * Add Field: Display a title to help separate fields
		 * Field:     title
		 * Section:   wpdas_patients
		 */
		$wpdas_obj->add_field(
			'wpdas_patients',
			array(
				'id'   => 'wpd_settings_patients_registration_title',
				'type' => 'title',
				'name' => '<h1>' . esc_attr__( 'Patient Registration', 'wp-dispensary' ) . '</h1>',
			)
		);

		// Update pages array.
		$redirect_pages = $pages_array;
		array_unshift( $redirect_pages, esc_attr__( 'Select a page', 'wp-dispensary' ) );

		/**
		 * Add Field: Redirect after registration
		 * Field:     select
		 * Section:   wpdas_patients
		 */
		$wpdas_obj->add_field(
			'wpdas_patients',
			array(
				'id'      => 'wpd_settings_patients_registration_redirect',
				'type'    => 'select',
				'name'    => esc_attr__( 'Redirect after registration', 'wp-dispensary' ),
				'desc'    => esc_attr__( 'Choose the page patients will be redirected to when registering.', 'wp-dispensary' ),
				'options' => $redirect_pages,
			)
		);

		/**
		 * Add Field: Display a title to help separate fields
		 * Field:     title
		 * Section:   wpdas_patients
		 */
		$wpdas_obj->add_field(
			'wpdas_patients',
			array(
				'id'   => 'wpd_settings_patients_verification_title',
				'type' => 'title',
				'name' => '<h1>' . esc_attr__( 'Patient Verification', 'wp-dispensary' ) . '</h1>',
			)
		);

		/**
		 * Add Field: Hide drivers license upload
		 * Field:     checkbox
		 * Section:   wpdas_patients
		 */
		$wpdas_obj->add_field(
			'wpdas_patients',
			array(
				'id'   => 'wpd_settings_patients_verification_drivers_license',
				'type' => 'checkbox',
				'name' => esc_attr__( 'Drivers license / Valid ID', 'wp-dispensary' ),
				'desc' => esc_attr__( 'Hide the drivers license upload from account details', 'wp-dispensary' ),
			)
		);

		/**
		 * Add Field: Hide doctor recommendation upload
		 * Field:     checkbox
		 * Section:   wpdas_patients
		 */
		$wpdas_obj->add_field(
			'wpdas_patients',
			array(
				'id'   => 'wpd_settings_patients_verification_recommendation_doc',
				'type' => 'checkbox',
				'name' => esc_attr__( 'Doctor recommendation', 'wp-dispensary' ),
				'desc' => esc_attr__( 'Hide the doctor recommendation upload from account details', 'wp-dispensary' ),
			)
		);

		/**
		 * Add Field: Hide recommendation number
		 * Field:     checkbox
		 * Section:   wpdas_patients
		 */
		$wpdas_obj->add_field(
			'wpdas_patients',
			array(
				'id'   => 'wpd_settings_patients_verification_recommendation_num',
				'type' => 'checkbox',
				'name' => esc_attr__( 'Recommendation number', 'wp-dispensary' ),
				'desc' => esc_attr__( 'Hide the recommendation number from account details', 'wp-dispensary' ),
			)
		);

		/**
		 * Add Field: Hide expiration date
		 * Field:     checkbox
		 * Section:   wpdas_patients
		 */
		$wpdas_obj->add_field(
			'wpdas_patients',
			array(
				'id'   => 'wpd_settings_patients_verification_recommendation_exp',
				'type' => 'checkbox',
				'name' => esc_attr__( 'Expiration date', 'wp-dispensary' ),
				'desc' => esc_attr__( 'Hide the expiration date from account details', 'wp-dispensary' ),
			)
		);

		/**
		 * Add Field: Display a title to help separate fields
		 * Field:     title
		 * Section:   wpdas_general
		 */
		$wpdas_obj->add_field(
			'wpdas_pages',
			array(
				'id'   => 'wpd_settings_checkout_options',
				'type' => 'title',
				'name' => '<h1>' . esc_attr__( 'Page Setup', 'wp-dispensary' ) . '</h1>',
			)
		);

		/**
		 * Add Field: Menu page
		 * Field:     select
		 * Section:   wpdas_pages
		 */
		$wpdas_obj->add_field(
			'wpdas_pages',
			array(
				'id'      => 'wpd_pages_setup_menu_page',
				'type'    => 'select',
				'name'    => esc_attr__( 'Menu page', 'wp-dispensary' ),
				'desc'    => esc_attr__( 'Page contents [wpd_menu]', 'wp-dispensary' ),
				'options' => $pages_array,
			)
		);

		/**
		 * Add Field: Cart page
		 * Field:     select
		 * Section:   wpdas_pages
		 */
		$wpdas_obj->add_field(
			'wpdas_pages',
			array(
				'id'      => 'wpd_pages_setup_cart_page',
				'type'    => 'select',
				'name'    => esc_attr__( 'Cart page', 'wp-dispensary' ),
				'desc'    => esc_attr__( 'Page contents [wpd_cart]', 'wp-dispensary' ),
				'options' => $pages_array,
			)
		);

		/**
		 * Add Field: Checkout page
		 * Field:     select
		 * Section:   wpdas_pages
		 */
		$wpdas_obj->add_field(
			'wpdas_pages',
			array(
				'id'      => 'wpd_pages_setup_checkout_page',
				'type'    => 'select',
				'name'    => esc_attr__( 'Checkout page', 'wp-dispensary' ),
				'desc'    => esc_attr__( 'Page contents [wpd_checkout]', 'wp-dispensary' ),
				'options' => $pages_array,
			)
		);

		/**
		 * Add Field: Account page
		 * Field:     select
		 * Section:   wpdas_pages
		 */
		$wpdas_obj->add_field(
			'wpdas_pages',
			array(
				'id'      => 'wpd_pages_setup_account_page',
				'type'    => 'select',
				'name'    => esc_attr__( 'Account page', 'wp-dispensary' ),
				'desc'    => esc_attr__( 'Page contents [wpd_account]', 'wp-dispensary' ),
				'options' => $pages_array,
			)
		);

	}

	// Check if WP Dispensary's Connect for METRC is active.
	if ( is_plugin_active( 'wpd-metrc/wpd-metrc.php' ) ) {
		/**
		 * Add Field: Display a title to help separate fields
		 * Field:     title
		 * Section:   wpdas_metrc
		 */
		$wpdas_obj->add_field(
			'wpdas_metrc',
			array(
				'id'   => 'wpd_settings_metrc',
				'type' => 'title',
				'name' => '<h1>' . esc_attr__( 'Metrc', 'wp-dispensary' ) . '</h1>',
			)
		);
		/**
		 * Add Field: Metrc Vendor API key
		 * Field:     text
		 * Section:   wpdas_metrc
		 */
		$wpdas_obj->add_field(
			'wpdas_metrc',
			array(
				'id'   => 'wpd_ecommerce_metrc_vendor_api_key',
				'type' => 'text',
				'name' => esc_attr__( 'Vendor API Key', 'wp-dispensary' ),
			)
		);
		/**
		 * Add Field: Metrc User API key
		 * Field:     text
		 * Section:   wpdas_metrc
		 */
		$wpdas_obj->add_field(
			'wpdas_metrc',
			array(
				'id'   => 'wpd_ecommerce_metrc_user_api_key',
				'type' => 'text',
				'name' => esc_attr__( 'User API Key', 'wp-dispensary' ),
			)
		);
	}

} // end WPD_ADMIN_SETTINGS check
