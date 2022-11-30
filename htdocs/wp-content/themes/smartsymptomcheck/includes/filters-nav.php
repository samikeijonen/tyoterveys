<?php
/**
 * General filters related to nav.
 *
 * @package Kala
 */

namespace Kala;

/**
 * Filters the WP nav menu link attributes.
 *
 * @since  1.0.0
 * @access public
 * @param  array    $atts {
 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
 *
 *     @type string $title  Title attribute.
 *     @type string $target Target attribute.
 *     @type string $rel    The rel attribute.
 *     @type string $href   The href attribute.
 * }
 * @param  WP_Post  $item  The current menu item.
 * @param  stdClass $args  An object of wp_nav_menu() arguments.
 * @param  int      $depth Depth of menu item. Used for padding.
 * @return string   $attr
 */
function nav_menu_link_attributes( $atts, $item, $args, $depth ) {
    // Get theme location, fallback for `default`.
    $theme_location = $args->theme_location ? $args->theme_location : 'default';

    // Start adding custom classes.
    $atts['class'] = 'menu-anchor menu-anchor--' . $theme_location;

    // Add is-anchor-level-{$depth} class using $depth parameter.
    $atts['class'] .= ' is-anchor-level-' . $depth;

    // Return custom classes.
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'Kala\nav_menu_link_attributes', 10, 4 );

/**
 * Display SVG icons in social links menu.
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  object  $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function nav_menu_social_icons( $item_output, $item, $depth, $args ) {
    // Get supported social icons.
    $social_icons = social_links_icons();

    // Change SVG icon inside social links menu if there is supported URL.
    if ( 'social-links' === $args->theme_location ) {
        foreach ( $social_icons as $attr => $value ) {
            if ( false !== strpos( $item_output, $attr ) ) {
                $item_output = str_replace( $args->link_after, '</span>' . get_svg( esc_attr( $value ) ), $item_output );
            }
        }
    }

    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'Kala\nav_menu_social_icons', 10, 4 );

/**
 * Returns an array of supported social links (URL and icon name).
 *
 * @return array $social_links_icons
 */
function social_links_icons() {
    // Supported social links icons.
    $social_links_icons = [
        'youtube.com'   => 'youtube',
        'linkedin.com'  => 'linkedin',
        'facebook.com'  => 'facebook',
        'instagram.com' => 'instagram',
        'spotify.com'   => 'spotify',
    ];

    return $social_links_icons;
}
