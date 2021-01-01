<?php
/**
 * The file that defines the general helper functions.
 *
 * @link       https://www.wpdispensary.com
 * @since      3.4
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/includes
 */

if ( ! function_exists( 'convert_taxonomies' ) ) {
    /**
     * Convert Taxonomies
     *
     * @param  string $product_type
     * @param  string $old_tax
     * @param  string $new_tax
     * @since  4.0
     * @return void
     */
    function convert_taxonomies( $product_type, $old_tax, $new_tax ) {
        // Get products.
        $products = get_posts( array(
            'post_type'      => $product_type,
            'posts_per_page' => -1,
            'post_status'    => array( 'publish', 'pending', 'draft', 'future', 'private' ),
            'tax_query'      => array( array(
                'taxonomy' => $old_tax,
                'operator' => 'EXISTS'
            ) )
        ) );
        // Loop through products.
        foreach( $products as $product ) {
            $terms      = get_the_terms( $product->ID, $old_tax );
            $term       = array();
            $term_array = array();
            // Loop through terms.
            foreach( $terms as $t ) {
                $term_array[] = $t->name;
                if ( false == get_term_by( 'name', $t->name, $new_tax ) ) {
                   wp_insert_term( $t->name, $new_tax, $args = array() );
                }
                wp_set_object_terms( $product->ID, $term_array, $new_tax ); 
            }
        }
    }
}

if ( ! function_exists( 'convert_metadata' ) ) {
    /**
     * Convert Metadata.
     * 
     * @param  string $post_type
     * @since  4.0
     * @return void
     */
    function convert_metadata( $post_type = '' ) {
        // Bail early if no post type is passed.
        if ( ! isset( $post_type ) ) {
            return;
        }

        // Get products.
        $products = get_posts( array(
            'numberposts' => -1,
            'post_type'   => $post_type,
            'post_status' => array( 'publish', 'pending', 'draft', 'future', 'private' )
        ) );

        // Make sure products exist.
        if ( $products ) {

            // Loop through all posts.
            foreach( $products as $post ) : setup_postdata( $post );

                // Set the Product Type metadata.
                add_post_meta( $post->ID, 'product_type', $post_type );

                // Update Flowers metadata.
                if ( 'flowers' == $post_type ) {
                    // Prices metadata.
                    $gram      = get_post_meta( $post->ID, '_gram', true );
                    $twograms  = get_post_meta( $post->ID, '_twograms', true );
                    $eighth    = get_post_meta( $post->ID, '_eighth', true );
                    $fivegrams = get_post_meta( $post->ID, '_fivegrams', true );
                    $quarter   = get_post_meta( $post->ID, '_quarter', true );
                    $halfounce = get_post_meta( $post->ID, '_halfounce', true );
                    $ounce     = get_post_meta( $post->ID, '_ounce', true );

                    // Top Sellers metadata.
                    $product_featured = get_post_meta( $post->ID, 'wpd_topsellers', true );

                    // Inventory metadata.
                    $inventory_grams   = get_post_meta( $post->ID, '_inventory_flowers', true );
                    $inventory_display = get_post_meta( $post->ID, 'wpd_inventory_display', true );

                    // Update new meta.
                    update_post_meta( $post->ID, 'price_gram', $gram );
                    update_post_meta( $post->ID, 'price_two_grams', $twograms );
                    update_post_meta( $post->ID, 'price_eighth', $eighth );
                    update_post_meta( $post->ID, 'price_five_grams', $fivegrams );
                    update_post_meta( $post->ID, 'price_quarter_ounce', $quarter );
                    update_post_meta( $post->ID, 'price_half_ounce', $halfounce );
                    update_post_meta( $post->ID, 'price_ounce', $ounce );
                    update_post_meta( $post->ID, 'product_featured', $product_featured );
                    update_post_meta( $post->ID, 'inventory_grams', $inventory_grams );
                    update_post_meta( $post->ID, 'inventory_display', $inventory_display );

                    // Delete old meta.
                    delete_post_meta( $post->ID, '_gram' );
                    delete_post_meta( $post->ID, '_twograms' );
                    delete_post_meta( $post->ID, '_eighth' );
                    delete_post_meta( $post->ID, '_fivegrams' );
                    delete_post_meta( $post->ID, '_quarter' );
                    delete_post_meta( $post->ID, '_halfounce' );
                    delete_post_meta( $post->ID, '_ounce' );
                    delete_post_meta( $post->ID, 'wpd_topsellers' );
                    delete_post_meta( $post->ID, '_inventory_flowers' );
                    delete_post_meta( $post->ID, 'wpd_inventory_display' );
                }

                // Update Concentrates metadata.
                if ( 'concentrates' == $post_type ) {
                    // Prices metadata.
                    $price_each = get_post_meta( $post->ID, '_priceeach', true );
                    $halfgram  = get_post_meta( $post->ID, '_halfgram', true );
                    $gram      = get_post_meta( $post->ID, '_gram', true );
                    $twograms  = get_post_meta( $post->ID, '_twograms', true );

                    // Top Sellers metadata.
                    $product_featured = get_post_meta( $post->ID, 'wpd_topsellers', true );

                    // Inventory metadata.
                    $inventory_grams   = get_post_meta( $post->ID, '_inventory_concentrates', true );
                    $inventory_units   = get_post_meta( $post->ID, '_inventory_concentrates_each', true );
                    $inventory_display = get_post_meta( $post->ID, 'wpd_inventory_display', true );

                    // Compounds metadata.
                    $compounds_thc   = get_post_meta( $post->ID, '_thc', true );
                    $compounds_thca  = get_post_meta( $post->ID, '_thca', true );
                    $compounds_cbd   = get_post_meta( $post->ID, '_cbd', true );
                    $compounds_cba   = get_post_meta( $post->ID, '_cba', true );
                    $compounds_cbn   = get_post_meta( $post->ID, '_cbn', true );
                    $compounds_cbg   = get_post_meta( $post->ID, '_cbg', true );
                    $compounds_total = get_post_meta( $post->ID, '_total_compounds', true );

                    // Update new meta.
                    update_post_meta( $post->ID, 'price_each', $price_each );
                    update_post_meta( $post->ID, 'price_half_gram', $halfgram );
                    update_post_meta( $post->ID, 'price_gram', $gram );
                    update_post_meta( $post->ID, 'price_two_grams', $twograms );
                    update_post_meta( $post->ID, 'product_featured', $product_featured );
                    update_post_meta( $post->ID, 'compounds_thc', $compounds_thc );
                    update_post_meta( $post->ID, 'compounds_thca', $compounds_thca );
                    update_post_meta( $post->ID, 'compounds_cbd', $compounds_cbd );
                    update_post_meta( $post->ID, 'compounds_cba', $compounds_cba );
                    update_post_meta( $post->ID, 'compounds_cbn', $compounds_cbn );
                    update_post_meta( $post->ID, 'compounds_cbg', $compounds_cbg );
                    update_post_meta( $post->ID, 'compounds_total', $compounds_total );
                    update_post_meta( $post->ID, 'inventory_grams', $inventory_grams );
                    update_post_meta( $post->ID, 'inventory_units', $inventory_units );
                    update_post_meta( $post->ID, 'inventory_display', $inventory_display );

                    // Delete old meta.
                    delete_post_meta( $post->ID, '_priceeach' );
                    delete_post_meta( $post->ID, '_halfgram' );
                    delete_post_meta( $post->ID, '_gram' );
                    delete_post_meta( $post->ID, '_twograms' );
                    delete_post_meta( $post->ID, 'wpd_topsellers' );
                    delete_post_meta( $post->ID, '_inventory_concentrates' );
                    delete_post_meta( $post->ID, '_inventory_concentrates_each' );
                    delete_post_meta( $post->ID, 'wpd_inventory_display' );
                    delete_post_meta( $post->ID, '_thc' );
                    delete_post_meta( $post->ID, '_thca' );
                    delete_post_meta( $post->ID, '_cbd' );
                    delete_post_meta( $post->ID, '_cba' );
                    delete_post_meta( $post->ID, '_cbn' );
                    delete_post_meta( $post->ID, '_cbg' );
                    delete_post_meta( $post->ID, '_total_compounds' );
                }

                // Update Edibles metadata.
                if ( 'edibles' == $post_type ) {
                    // Prices metadata.
                    $price_each = get_post_meta( $post->ID, '_priceeach', true );
                    $price_pack = get_post_meta( $post->ID, '_priceperpack', true );
                    $pack_units = get_post_meta( $post->ID, '_unitsperpack', true );

                    // Top Sellers metadata.
                    $product_featured = get_post_meta( $post->ID, 'wpd_topsellers', true );

                    // Inventory metadata.
                    $inventory_units   = get_post_meta( $post->ID, '_inventory_edibles', true );
                    $inventory_display = get_post_meta( $post->ID, 'wpd_inventory_display', true );

                    // Compounds metadata.
                    $compounds_thc    = get_post_meta( $post->ID, '_thcmg', true );
                    $compounds_cbd    = get_post_meta( $post->ID, '_cbdmg', true );
                    $product_servings = get_post_meta( $post->ID, '_thccbdservings', true );
                    $product_net_weight = get_post_meta( $post->ID, '_netweight', true );

                    // Update new meta.
                    update_post_meta( $post->ID, 'price_each', $price_each );
                    update_post_meta( $post->ID, 'price_per_pack', $price_pack );
                    update_post_meta( $post->ID, 'units_per_pack', $pack_units );
                    update_post_meta( $post->ID, 'product_featured', $product_featured );
                    update_post_meta( $post->ID, 'product_servings', $product_servings );
                    update_post_meta( $post->ID, 'product_net_weight', $net_weight );
                    update_post_meta( $post->ID, 'compounds_thc', $compounds_thc );
                    update_post_meta( $post->ID, 'compounds_cbd', $compounds_cbd );
                    update_post_meta( $post->ID, 'inventory_units', $inventory_units );
                    update_post_meta( $post->ID, 'inventory_display', $inventory_display );

                    // Delete old meta.
                    delete_post_meta( $post->ID, '_priceeach' );
                    delete_post_meta( $post->ID, '_priceperpack' );
                    delete_post_meta( $post->ID, '_unitsperpack' );
                    delete_post_meta( $post->ID, 'wpd_topsellers' );
                    delete_post_meta( $post->ID, '_inventory_edibles' );
                    delete_post_meta( $post->ID, 'wpd_inventory_display' );
                    delete_post_meta( $post->ID, '_thcmg' );
                    delete_post_meta( $post->ID, '_cbdmg' );
                    delete_post_meta( $post->ID, '_thccbdservings' );
                    delete_post_meta( $post->ID, '_netweight' );
                }

                // Update Pre-rolls metadata.
                if ( 'prerolls' == $post_type ) {
                    // Prices metadata.
                    $price_each = get_post_meta( $post->ID, '_priceeach', true );
                    $price_pack = get_post_meta( $post->ID, '_priceperpack', true );
                    $pack_units = get_post_meta( $post->ID, '_unitsperpack', true );

                    // Top Sellers metadata.
                    $product_featured = get_post_meta( $post->ID, 'wpd_topsellers', true );

                    // Inventory metadata.
                    $inventory_units   = get_post_meta( $post->ID, '_inventory_prerolls', true );
                    $inventory_display = get_post_meta( $post->ID, 'wpd_inventory_display', true );

                    // Compounds metadata.
                    $compounds_thc   = get_post_meta( $post->ID, '_thc', true );
                    $compounds_thca  = get_post_meta( $post->ID, '_thca', true );
                    $compounds_cbd   = get_post_meta( $post->ID, '_cbd', true );
                    $compounds_cba   = get_post_meta( $post->ID, '_cba', true );
                    $compounds_cbn   = get_post_meta( $post->ID, '_cbn', true );
                    $compounds_cbg   = get_post_meta( $post->ID, '_cbg', true );
                    $compounds_total = get_post_meta( $post->ID, '_total_compounds', true );

                    // Pre-roll metadata.
                    $product_weight = get_post_meta( $post->ID, '_preroll_weight', true );
                    $product_flower = get_post_meta( $post->ID, 'selected_flowers', true );

                    // Update new meta.
                    update_post_meta( $post->ID, 'price_each', $price_each );
                    update_post_meta( $post->ID, 'price_per_pack', $price_pack );
                    update_post_meta( $post->ID, 'units_per_pack', $pack_units );
                    update_post_meta( $post->ID, 'product_featured', $product_featured );
                    update_post_meta( $post->ID, 'product_weight', $product_weight );
                    update_post_meta( $post->ID, 'product_flower', $product_flower );
                    update_post_meta( $post->ID, 'compounds_thc', $compounds_thc );
                    update_post_meta( $post->ID, 'compounds_thca', $compounds_thca );
                    update_post_meta( $post->ID, 'compounds_cbd', $compounds_cbd );
                    update_post_meta( $post->ID, 'compounds_cba', $compounds_cba );
                    update_post_meta( $post->ID, 'compounds_cbn', $compounds_cbn );
                    update_post_meta( $post->ID, 'compounds_cbg', $compounds_cbg );
                    update_post_meta( $post->ID, 'compounds_total', $compounds_total );
                    update_post_meta( $post->ID, 'inventory_units', $inventory_units );
                    update_post_meta( $post->ID, 'inventory_display', $inventory_display );

                    // Delete old meta.
                    delete_post_meta( $post->ID, '_priceeach' );
                    delete_post_meta( $post->ID, '_priceperpack' );
                    delete_post_meta( $post->ID, '_unitsperpack' );
                    delete_post_meta( $post->ID, 'wpd_topsellers' );
                    delete_post_meta( $post->ID, '_inventory_prerolls' );
                    delete_post_meta( $post->ID, 'wpd_inventory_display' );
                    delete_post_meta( $post->ID, '_thc' );
                    delete_post_meta( $post->ID, '_thca' );
                    delete_post_meta( $post->ID, '_cbd' );
                    delete_post_meta( $post->ID, '_cba' );
                    delete_post_meta( $post->ID, '_cbn' );
                    delete_post_meta( $post->ID, '_cbg' );
                    delete_post_meta( $post->ID, '_total_compounds' );
                    delete_post_meta( $post->ID, '_preroll_weight' );
                    delete_post_meta( $post->ID, 'selected_flowers' );
                }

                // Update Topicals metadata.
                if ( 'topicals' == $post_type ) {
                    // Prices metadata.
                    $price_each = get_post_meta( $post->ID, '_priceeach', true );
                    $price_pack = get_post_meta( $post->ID, '_priceperpack', true );
                    $pack_units = get_post_meta( $post->ID, '_unitsperpack', true );

                    // Top Sellers metadata.
                    $product_featured = get_post_meta( $post->ID, 'wpd_topsellers', true );

                    // Inventory metadata.
                    $inventory_units   = get_post_meta( $post->ID, '_inventory_topicals', true );
                    $inventory_display = get_post_meta( $post->ID, 'wpd_inventory_display', true );

                    // Compounds metadata.
                    $product_size  = get_post_meta( $post->ID, '_sizetopical', true );
                    $compounds_thc = get_post_meta( $post->ID, '_thctopical', true );
                    $compounds_cbd = get_post_meta( $post->ID, '_cbdtopical', true );

                    // Update new meta.
                    update_post_meta( $post->ID, 'price_each', $price_each );
                    update_post_meta( $post->ID, 'price_per_pack', $price_pack );
                    update_post_meta( $post->ID, 'units_per_pack', $pack_units );
                    update_post_meta( $post->ID, 'product_featured', $product_featured );
                    update_post_meta( $post->ID, 'product_size', $product_size );
                    update_post_meta( $post->ID, 'compounds_thc', $compounds_thc );
                    update_post_meta( $post->ID, 'compounds_cbd', $compounds_cbd );
                    update_post_meta( $post->ID, 'inventory_units', $inventory_units );
                    update_post_meta( $post->ID, 'inventory_display', $inventory_display );

                    // Delete old meta.
                    delete_post_meta( $post->ID, '_priceeach' );
                    delete_post_meta( $post->ID, '_priceperpack' );
                    delete_post_meta( $post->ID, '_unitsperpack' );
                    delete_post_meta( $post->ID, 'wpd_topsellers' );
                    delete_post_meta( $post->ID, '_inventory_topicals' );
                    delete_post_meta( $post->ID, 'wpd_inventory_display' );
                    delete_post_meta( $post->ID, '_sizetopical' );
                    delete_post_meta( $post->ID, '_thctopical' );
                    delete_post_meta( $post->ID, '_cbdtopical' );
                }

                // Update Growers metadata.
                if ( 'growers' == $post_type ) {
                    // Prices metadata.
                    $price_each = get_post_meta( $post->ID, '_priceeach', true );
                    $price_pack = get_post_meta( $post->ID, '_priceperpack', true );
                    $pack_units = get_post_meta( $post->ID, '_unitsperpack', true );

                    // Top Sellers metadata.
                    $product_featured = get_post_meta( $post->ID, 'wpd_topsellers', true );

                    // Inventory metadata.
                    $inventory_clones  = get_post_meta( $post->ID, '_inventory_clones', true );
                    $inventory_seeds   = get_post_meta( $post->ID, '_inventory_seeds', true );
                    $inventory_display = get_post_meta( $post->ID, 'wpd_inventory_display', true );

                    // Growers metadata.
                    $product_flower     = get_post_meta( $post->ID, 'selected_flowers', true );
                    $product_origin     = get_post_meta( $post->ID, '_origin', true );
                    $product_yield      = get_post_meta( $post->ID, '_yield', true );
                    $product_time       = get_post_meta( $post->ID, '_time', true );
                    $product_difficulty = get_post_meta( $post->ID, '_difficulty', true );
                    $clone_count        = get_post_meta( $post->ID, 'clone_count', true );
                    $seed_count         = get_post_meta( $post->ID, 'seed_count', true );

                    // Update new meta.
                    update_post_meta( $post->ID, 'price_each', $price_each );
                    update_post_meta( $post->ID, 'price_per_pack', $price_pack );
                    update_post_meta( $post->ID, 'units_per_pack', $pack_units );
                    update_post_meta( $post->ID, 'product_featured', $product_featured );
                    update_post_meta( $post->ID, 'product_flower', $product_flower );
                    update_post_meta( $post->ID, 'product_origin', $product_origin );
                    update_post_meta( $post->ID, 'product_yield', $product_yield );
                    update_post_meta( $post->ID, 'product_time', $product_time );
                    update_post_meta( $post->ID, 'product_difficulty', $product_difficulty );
                    update_post_meta( $post->ID, 'clone_count', $clone_count );
                    update_post_meta( $post->ID, 'seed_count', $seed_count );
                    update_post_meta( $post->ID, 'inventory_seeds', $inventory_seeds );
                    update_post_meta( $post->ID, 'inventory_display', $inventory_display );

                    // Delete old meta.
                    delete_post_meta( $post->ID, '_priceeach' );
                    delete_post_meta( $post->ID, '_priceperpack' );
                    delete_post_meta( $post->ID, '_unitsperpack' );
                    delete_post_meta( $post->ID, 'wpd_topsellers' );
                    delete_post_meta( $post->ID, '_inventory_clones' );
                    delete_post_meta( $post->ID, '_inventory_seeds' );
                    delete_post_meta( $post->ID, 'wpd_inventory_display' );
                    delete_post_meta( $post->ID, 'selected_flowers' );
                    delete_post_meta( $post->ID, '_origin' );
                    delete_post_meta( $post->ID, '_yield' );
                    delete_post_meta( $post->ID, '_time' );
                    delete_post_meta( $post->ID, '_difficulty' );
                    delete_post_meta( $post->ID, 'clone_count' );
                    delete_post_meta( $post->ID, 'seed_count' );

                }

                // Update Gear metadata.
                if ( 'gear' == $post_type ) {
                    // Prices metadata.
                    $price_each = get_post_meta( $post->ID, '_priceeach', true );
                    $price_pack = get_post_meta( $post->ID, '_priceperpack', true );
                    $pack_units = get_post_meta( $post->ID, '_unitsperpack', true );

                    // Top Sellers metadata.
                    $product_featured = get_post_meta( $post->ID, 'wpd_topsellers', true );

                    // Inventory metadata.
                    $inventory_units   = get_post_meta( $post->ID, '_inventory_gear', true );
                    $inventory_display = get_post_meta( $post->ID, 'wpd_inventory_display', true );

                    // Update new meta.
                    update_post_meta( $post->ID, 'price_each', $price_each );
                    update_post_meta( $post->ID, 'price_per_pack', $price_pack );
                    update_post_meta( $post->ID, 'units_per_pack', $pack_units );
                    update_post_meta( $post->ID, 'product_featured', $product_featured );
                    update_post_meta( $post->ID, 'inventory_units', $inventory_units );
                    update_post_meta( $post->ID, 'inventory_display', $inventory_display );

                    // Delete old meta.
                    delete_post_meta( $post->ID, '_priceeach' );
                    delete_post_meta( $post->ID, '_priceperpack' );
                    delete_post_meta( $post->ID, '_unitsperpack' );
                    delete_post_meta( $post->ID, 'wpd_topsellers' );
                    delete_post_meta( $post->ID, '_inventory_gear' );
                    delete_post_meta( $post->ID, 'wpd_inventory_display' );

                }

                // Update Tinctures metadata.
                if ( 'tinctures' == $post_type ) {
                    // Prices metadata.
                    $price_each = get_post_meta( $post->ID, '_priceeach', true );
                    $price_pack = get_post_meta( $post->ID, '_priceperpack', true );
                    $pack_units = get_post_meta( $post->ID, '_unitsperpack', true );

                    // Top Sellers metadata.
                    $product_featured = get_post_meta( $post->ID, 'wpd_topsellers', true );

                    // Inventory metadata.
                    $inventory_units   = get_post_meta( $post->ID, '_inventory_tinctures', true );
                    $inventory_display = get_post_meta( $post->ID, 'wpd_inventory_display', true );

                    // Tinctures metadata.
                    $product_servings    = get_post_meta( $post->ID, '_thccbdservings', true );
                    $product_servings_ml = get_post_meta( $post->ID, '_mlserving', true );
                    $compounds_thc       = get_post_meta( $post->ID, '_thcmg', true );
                    $compounds_cbd       = get_post_meta( $post->ID, '_cbdmg', true );
                    $product_net_weight  = get_post_meta( $post->ID, '_netweight', true );

                    // Update new meta.
                    update_post_meta( $post->ID, 'price_each', $price_each );
                    update_post_meta( $post->ID, 'price_per_pack', $price_pack );
                    update_post_meta( $post->ID, 'units_per_pack', $pack_units );
                    update_post_meta( $post->ID, 'product_featured', $product_featured );
                    update_post_meta( $post->ID, 'product_servings', $product_servings );
                    update_post_meta( $post->ID, 'product_servings_ml', $product_servings_ml );
                    update_post_meta( $post->ID, 'product_net_weight', $product_net_weight );
                    update_post_meta( $post->ID, 'inventory_units', $inventory_units );
                    update_post_meta( $post->ID, 'inventory_display', $inventory_display );
                    update_post_meta( $post->ID, 'compounds_thc', $compounds_thc );
                    update_post_meta( $post->ID, 'compounds_cbd', $compounds_cbd );
 
                    // Delete old meta.
                    delete_post_meta( $post->ID, '_priceeach' );
                    delete_post_meta( $post->ID, '_priceperpack' );
                    delete_post_meta( $post->ID, '_unitsperpack' );
                    delete_post_meta( $post->ID, 'wpd_topsellers' );
                    delete_post_meta( $post->ID, '_inventory_tinctures' );
                    delete_post_meta( $post->ID, 'wpd_inventory_display' );
                    delete_post_meta( $post->ID, '_thccbdservings' );
                    delete_post_meta( $post->ID, '_mlserving' );
                    delete_post_meta( $post->ID, '_thcmg' );
                    delete_post_meta( $post->ID, '_cbdmg' );
                    delete_post_meta( $post->ID, '_netweight' );

                }

            endforeach;	
        }

    }

}

if ( ! function_exists( 'convert_post_types' ) ) {
    /**
     * Convert Post Types
     *
     * @since  4.0
     * @return void
     */
    function convert_post_types() {
        // Loop through each menu type.
        foreach( wpd_menu_types_simple( true ) as $product_type ) {
            // Get products.
            $products = get_posts( array(
                'post_type'      => $product_type,
                'posts_per_page' => -1,
                'post_status'    => array( 'publish', 'pending', 'draft', 'future', 'private' ),
            ) );
            // Loop through products.
            foreach( $products as $product ) {
                // Get product data.
                $product = get_post( $product->ID );
                // Get featured image ID.
                $featured_image = get_post_thumbnail_id( $product->ID );
                // Add product type metadata.
                add_post_meta( $product->ID, 'product_type', $product_type );
                // Update post type.
                $product->post_type = 'products';
                // Update the product.
                wp_update_post( $product );
                // Update featured image.
                update_post_meta( $product->ID, '_thumbnail_id', $featured_image );
            }
        }
    }
}
