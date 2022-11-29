<?php
/**
 * Register needed scripts and styles.
 *
 * @package Kala
 */

namespace Kala;

/**
 * Register scripts and styles.
 *
 * @return void
 */
function enqueue_scripts() {
    global $wp_styles;

    wp_enqueue_style(
        'theme-styles',
        get_theme_file_uri( 'build/theme.css' ),
        [],
        filemtime( get_theme_file_path( 'build/theme.css' ) )
    );

    wp_enqueue_script(
        'theme-scripts',
        get_theme_file_uri( 'build/main.js' ),
        [],
        filemtime( get_theme_file_path( 'build/main.js' ) ),
        true
    );

    wp_deregister_script( 'wp-embed' );

    // Dequeue Core block styles.
    wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'Kala\enqueue_scripts' );

/**
 * Register scripts and styles for front-end and editor.
 *
 * @return void
 */
function enqueue_block_assets() {
    // Overwrite Core block styles with empty styles.
    wp_deregister_style( 'wp-block-library' );
    wp_register_style( 'wp-block-library', '' ); // phpcs:ignore

    // Overwrite Core theme styles with empty styles.
    wp_deregister_style( 'wp-block-library-theme' );
    wp_register_style( 'wp-block-library-theme', '' ); // phpcs:ignore
}
add_action( 'enqueue_block_assets', 'Kala\enqueue_block_assets' );

/**
 * Preload needed fonts in the head.
 *
 * @return void
 */
function preload_fonts() {
    $fonts = [
        THEME_URI . '/fonts/ibm-plex-sans-v14-latin-regular.woff2' => 'woff2',
        THEME_URI . '/fonts/ibm-plex-sans-v14-latin-700.woff2' => 'woff2',
    ];

    foreach ( $fonts as $font_link => $font_type ) {
        echo '<link rel="preload" href="' . esc_url( $font_link ) . '" as="font" type="font/' . esc_attr( $font_type ) . '" crossorigin>';
    }
}
add_action( 'wp_head', 'Kala\preload_fonts', 1 );

/**
 * Facebook verification.
 *
 * @return void
 */
function facebook_verification() {
    ?>
    <meta name="facebook-domain-verification" content="rfpczpv8grp9pw8dd977qovwpm79zn" />
    <?php
}
add_action( 'wp_head', 'Kala\facebook_verification' );
