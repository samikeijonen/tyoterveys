<?php
/**
 * Nav related filters.
 *
 * @package Kala
 */

namespace Kala;

/**
 * Filters the CSS classes applied to a menu item's list item element.
 *
 * @since  1.0.0
 * @access public
 * @param  string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
 * @param  WP_Post  $item    The current menu item.
 * @param  stdClass $args    An object of wp_nav_menu() arguments.
 * @param  int      $depth   Depth of menu item.
 */
function nav_menu_css_class( $classes, $item, $args, $depth ) {
    // Get theme location, fallback for `default`.
    $theme_location = $args->theme_location ? $args->theme_location : 'default';

    // Add theme location class.
    $classes[] = 'menu-item--' . $theme_location;

    // Add is-item-level-{$depth} class using $depth parameter.
    $classes[] = 'is-item-level-' . $depth;

    // Return custom classes.
    return $classes;
}
add_filter( 'nav_menu_css_class', 'Kala\nav_menu_css_class', 10, 4 );

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
