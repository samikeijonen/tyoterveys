<?php
/**
 * Polylang related functions.
 *
 * @package Kala
 */

namespace Kala;

function add_cpt_to_pll( $post_types, $is_settings ) {
    if ( $is_settings ) {
        // hides 'global-content' from the list of custom post types in Polylang settings
        unset( $post_types['global-content'] );
    } else {
        // enables language and translation management for 'global-content'
        $post_types['global-content'] = 'global-content';
    }

    return $post_types;
}
add_filter( 'pll_get_post_types', 'Kala\add_cpt_to_pll', 10, 2 );
