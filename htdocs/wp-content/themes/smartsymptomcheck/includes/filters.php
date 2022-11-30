<?php
/**
 * General filters used in the theme.
 *
 * @package Kala
 */

namespace Kala;

/**
 * Remove "Archive: " from archive titles
 *
 * @param string $title The title for the archive.
 * @return string
 */
function theme_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    } elseif ( is_home() ) {
        $title = get_the_title( get_option( 'page_for_posts' ) );
    }

    return $title;
}
add_filter( 'get_the_archive_title', 'Kala\theme_archive_title' );

/**
 * Use different description for example in home use content.
 *
 * @param string $description The description for the archive.
 * @return string
 */
function theme_archive_description( $description ) {
    if ( is_home() && ! is_front_page() ) {
        $description = get_post_field( 'post_content', get_queried_object_id(), 'raw' );
    }

    return $description;
}
add_filter( 'get_the_archive_description', 'Kala\theme_archive_description' );

/**
 * Automatically skip the default assigned slug on any attachment.
 * So an attachment that might normally get the slug "services" will now get the slug "services-2".
 */
add_filter( 'wp_unique_post_slug_is_bad_attachment_slug', '__return_true' );

/**
 * Move Yoast to the bottom of the page.
 *
 * @return string
 */
function yoast_to_bottom() {
    return 'low';
}
add_filter( 'wpseo_metabox_prio', 'Kala\yoast_to_bottom', 999, 1 );

/**
 * Skip lazy loading for first 3 images on home and archive.
 *
 * @param  int  $omit_threshold The number of media elements where the `loading` attribute will not be added.
 * @return int  $omit_threshold Mofified value.
 */
function skip_lazyloading_on_first_three_archive_images( $omit_threshold ) {
    if ( is_home() || is_archive() ) {
        return 3;
    }

    return $omit_threshold;
}
add_filter( 'wp_omit_loading_attr_threshold', 'Kala\skip_lazyloading_on_first_three_archive_images' );

/**
 * Change excerpt length.
 *
 * @return number
 */
function excerpt_length( $length ) {
    return 12;
}
add_filter( 'excerpt_length', 'Kala\excerpt_length' );

/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'Kala\excerpt_more' );

/**
 * Determine additional body classes.
 *
 * @param array $classes
 *
 * @return array
 */
function body_class_filters( $classes ) {
    $additional_classes = determine_main_nav_state();

    return array_merge( $classes, $additional_classes );
}
add_filter( 'body_class', 'Kala\body_class_filters' );

/**
 * Determine whether an additional class is necessary to handle main nav state.
 *
 * @return array
 */
function determine_main_nav_state() {
    global $post;

    if ( is_hero_the_first_block( $post ) ) {
        return [ 'has-hero' ];
    } else {
        return [ 'has-no-hero' ];
    }

    return [];
}
