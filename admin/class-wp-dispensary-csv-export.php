<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.wpdispensary.com
 * @since      1.0.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin
 * @author     WP Dispensary <contact@wpdispensary.com>
 */
class WP_Dispensary_CSV_Export {
    /**
    * Constructor
    */
    public function __construct() {
        if ( isset( $_GET['export_products'] ) ) {

            // Run generate CSV function.
            $csv = $this->generate_csv();

            header( "Pragma: public" );
            header( "Expires: 0" );
            header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
            header( "Cache-Control: private", false );
            header( "Content-Type: application/octet-stream" );
            header( "Content-Disposition: attachment; filename=\"wp-dispensary-products.csv\";" );
            header( "Content-Transfer-Encoding: binary" );

            echo $csv;
            exit;
        }

        // Create end-points.
        add_filter( 'query_vars', array( $this, 'query_vars' ) );
        add_action( 'parse_request', array( $this, 'parse_request' ) );
    }

    /**
    * Allow for custom query variables
    */
    public function query_vars( $query_vars ) {
        $query_vars[] = 'export_products';
        return $query_vars;
    }

    /**
     * Parse the request
     */
    public function parse_request( &$wp ) {
        if ( array_key_exists( 'export_products', $wp->query_vars ) ) {
            $this->export_products();
            exit;
        }
    }

    /**
     * Export WP Dispensary products
     */
    public function export_products() {
        echo '<div class="wrap">';
        echo '<h2>' . __( 'WP Dispensary\'s Product Export', 'wp-dispensary' ) . '</h2>';
        echo '<p>' . __( 'Export your WP Dispensary products as a CSV file by clicking the button below.', 'wp-dispensary' ) . '</p>';
        echo '<p><a class="button" href="admin.php?page=export_products&export_products&_wpnonce=' . wp_create_nonce( 'download_csv' ) . '">' . __( 'Export', 'wp-dispensary' ) . '</a></p>';
    }

    /**
     * Converting data to CSV
     */
    public function generate_csv() {
        ob_start();

        $domain    = $_SERVER['SERVER_NAME'];
        $file_name = 'wpd-products-' . $domain . '-' . time() . '.csv';

        // Set the headers.
        $header_row = array(
            __( 'ID', 'wp-dispensary' ),
            __( 'Type', 'wp-dispensary' ),
            __( 'Title', 'wp-dispensary' ),
            __( 'Content', 'wp-dispensary' ),
            __( 'Slug', 'wp-dispensary' ),
            __( 'Date', 'wp-dispensary' ),
            __( 'Author', 'wp-dispensary' ),
            __( 'Prices (weight)', 'wp-dispensary' ),
            __( 'Prices (units)', 'wp-dispensary' ),
            __( 'Units per pack', 'wp-dispensary' ),
            __( 'Inventory', 'wp-dispensary' ),
            __( 'Categories', 'wp-dispensary' ),
            __( 'Featured image', 'wp-dispensary' )
        );

        // Filter headers.
        $header_row = apply_filters( 'wpd_csv_export_header_row', $header_row );

        // Data rows.
        $data_rows = array();

        global $wpdb;

        $sql      = 'SELECT * FROM ' . $wpdb->posts . ' AS P WHERE P.post_type IN ( "products" ) and P.post_status = "publish"';
        $products = $wpdb->get_results( $sql, 'ARRAY_A' );

        // Set the rows (matches headers).
        foreach ( $products as $product ) {

            // Cat ID.
            $cat_id = array();

            if ( 'flowers' == get_post_meta( $product['ID'], 'product_type', true ) ) {
                $inventory_amount = get_post_meta( $product['ID'], 'inventory_grams', TRUE );
                $category_name    = wp_get_post_terms( $product['ID'], 'wpd_categories', array( 'fields' => 'names' ) );
                $price_each       = '';
                if ( $category_name && ! is_wp_error( $category_name ) ) {
                    foreach ( $category_name as $cat=>$value ) {
                        $cat_id[] = $value;
                    }
                }
            }
            
            if ( 'concentrates' == get_post_meta( $product['ID'], 'product_type', true ) ) {
                $inventory_amount = get_post_meta( $product['ID'], 'inventory_units', TRUE );
                $category_name    = wp_get_post_terms( $product['ID'], 'wpd_categories', array( 'fields' => 'names' ) );
                $price_each       = get_post_meta( $product['ID'], 'price_each', TRUE );
                if ( $category_name && ! is_wp_error( $category_name ) ) {
                    foreach ( $category_name as $cat=>$value ) {
                        $cat_id[] = $value;
                    }
                }
            }
            
            if ( 'edibles' == get_post_meta( $product['ID'], 'product_type', true ) ) {
                $inventory_amount = get_post_meta( $product['ID'], 'inventory_units', TRUE );
                $category_name    = wp_get_post_terms( $product['ID'], 'wpd_categories', array( 'fields' => 'names' ) );
                $price_each       = get_post_meta( $product['ID'], 'price_each', TRUE );
                if ( $category_name && ! is_wp_error( $category_name ) ) {
                    foreach ( $category_name as $cat=>$value ) {
                        $cat_id[] = $value;
                    }
                }
            }
            
            if ( 'prerolls' == get_post_meta( $product['ID'], 'product_type', true ) ) {
                $inventory_amount = get_post_meta( $product['ID'], 'inventory_units', TRUE );
                $category_name    = wp_get_post_terms( $product['ID'], 'wpd_categories', array( 'fields' => 'names' ) );
                $price_each       = get_post_meta( $product['ID'], 'price_each', TRUE );
                if ( $category_name && ! is_wp_error( $category_name ) ) {
                    foreach ( $category_name as $cat=>$value ) {
                        $cat_id[] = $value;
                    }
                }
            }
            
            if ( 'topicals' == get_post_meta( $product['ID'], 'product_type', true ) ) {
                $inventory_amount = get_post_meta( $product['ID'], 'inventory_units', TRUE );
                $category_name    = wp_get_post_terms( $product['ID'], 'wpd_categories', array( 'fields' => 'names' ) );
                $price_each       = get_post_meta( $product['ID'], 'price_each', TRUE );
                if ( $category_name && ! is_wp_error( $category_name ) ) {
                    foreach ( $category_name as $cat=>$value ) {
                        $cat_id[] = $value;
                    }
                }
            } elseif ( 'growers' == get_post_meta( $product['ID'], 'product_type', true ) ) {
                $inventory_amount = get_post_meta( $product['ID'], 'inventory_units', TRUE );
                $category_name    = wp_get_post_terms( $product['ID'], 'wpd_categories', array( 'fields' => 'names' ) );
                $price_each       = get_post_meta( $product['ID'], 'price_each', TRUE );
                if ( $category_name && ! is_wp_error( $category_name ) ) {
                    foreach ( $category_name as $cat=>$value ) {
                        $cat_id[] = $value;
                    }
                }
            }
            
            if ( 'gear' == get_post_meta( $product['ID'], 'product_type', true ) ) {
                $inventory_amount = get_post_meta( $product['ID'], 'inventory_units', TRUE );
                $category_name    = wp_get_post_terms( $product['ID'], 'wpd_categories', array( 'fields' => 'names' ) );
                $price_each       = get_post_meta( $product['ID'], 'price_each', TRUE );
                if ( $category_name && ! is_wp_error( $category_name ) ) {
                    foreach ( $category_name as $cat=>$value ) {
                        $cat_id[] = $value;
                    }
                }
            } 
            
            if ( 'tinctures' == get_post_meta( $product['ID'], 'product_type', true ) ) {
                $inventory_amount = get_post_meta( $product['ID'], 'inventory_units', TRUE );
                $category_name    = wp_get_post_terms( $product['ID'], 'wpd_categories', array( 'fields' => 'names' ) );
                $price_each       = get_post_meta( $product['ID'], 'price_each', TRUE );
                if ( $category_name && ! is_wp_error( $category_name ) ) {
                    foreach ( $category_name as $cat=>$value ) {
                        $cat_id[] = $value;
                    }
                }
            } else {
                // Do nothing.
            }

            // Empty category ID's.
            $category_ids = '';

            // Get category ID's.
            if ( ! empty( $cat_id ) ) {
                $category_ids = json_encode( $cat_id, JSON_FORCE_OBJECT );
            }

            $prices_by_weight = array(
                __( '1/2 g', 'wp-dispensary' )  => get_post_meta( $product['ID'], 'price_half_gram', TRUE ),
                __( '1 g', 'wp-dispensary' )    => get_post_meta( $product['ID'], 'price_gram', TRUE ),
                __( '2 g', 'wp-dispensary' )    => get_post_meta( $product['ID'], 'price_two_grams', TRUE ),
                __( '1/8 oz', 'wp-dispensary' ) => get_post_meta( $product['ID'], 'price_eighth', TRUE ),
                __( '5 g', 'wp-dispensary' )    => get_post_meta( $product['ID'], 'price_five_grams', TRUE ),
                __( '1/4 oz', 'wp-dispensary' ) => get_post_meta( $product['ID'], 'price_quarter_ounce', TRUE ),
                __( '1/2 oz', 'wp-dispensary' ) => get_post_meta( $product['ID'], 'price_half_ounce', TRUE ),
                __( '1 oz', 'wp-dispensary' )   => get_post_meta( $product['ID'], 'price_ounce', TRUE ),
            );

            // Prices by units array.
            $prices_by_units = array();

            // Add price each.
            if ( $price_each ) {
                $prices_by_units[__( 'price each', 'wp-dispensary' )] = $price_each;
            }

            // Add price per pack.
            if ( get_post_meta( $product['ID'], 'price_per_pack', TRUE ) ) {
                $prices_by_units[__( 'price per pack', 'wp-dispensary' )] = get_post_meta( $product['ID'], 'price_per_pack', TRUE );
            }

            // Create empty variable if array is empty.
            if ( empty( $prices_by_units ) ) {
                $prices_by_units = '';
            }

            // Encode array if array is not empty.
            if ( ! empty( $prices_by_units ) ) {
                $prices_by_units = json_encode( $prices_by_units, JSON_FORCE_OBJECT );
            }

            // Create row.
            $row = array(
                $product['ID'],
                get_post_meta( $product['ID'], 'product_type', true ),
                $product['post_title'],
                $product['post_content'],
                $product['post_name'],
                $product['post_date'],
                $product['post_author'],
                json_encode( $prices_by_weight, JSON_FORCE_OBJECT ),
                $prices_by_units,
                get_post_meta( $product['ID'], 'units_per_pack', TRUE ),
                $inventory_amount,
                $category_ids,
                get_the_post_thumbnail_url( $product['ID'] ),
            );
            $data_rows[] = apply_filters( 'wpd_csv_export_data_row', $row );
        }

        $fh = @fopen( 'php://output', 'w' );

        fprintf( $fh, chr(0xEF) . chr(0xBB) . chr(0xBF) );

        header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
        header( 'Content-Description: File Transfer' );
        header( 'Content-type: text/csv' );
        header( "Content-Disposition: attachment; filename={$file_name}" );
        header( 'Expires: 0' );
        header( 'Pragma: public' );

        fputcsv( $fh, $header_row );

        foreach ( $data_rows as $data_row ) {
            fputcsv( $fh, $data_row );
        }

        fclose( $fh );

        ob_end_flush();

        die();
    }
}

/**
 * Initialize the CSV Export class
 * 
 * @since  4.0
 * @return void
 */
function wpd_csv_export() {
    // Instantiate a singleton of this plugin.
    $csvExport = new WP_Dispensary_CSV_Export();
}
add_action( 'init', 'wpd_csv_export' );
