<?php
/**
 * Gutenberg initialization and settings
 *
 * @package Kala
 */

namespace Kala;

/**
 * Register Gutenberg styles and custom Google Font
 * Some Gutenberg settings for js.
 *
 * @link https://www.billerickson.net/wordpress-color-palette-button-styling-gutenberg/
 */
function gutenberg_styles() {
    // Add editor styles.
    wp_enqueue_style(
        'gutenberg-styles-editor',
        get_theme_file_uri( 'build/editor.css' ),
        [],
        filemtime( get_theme_file_path( 'build/editor.css' ) )
    );

    // Editor related JS.
    wp_enqueue_script(
        'gutenberg-scripts-editor',
        get_theme_file_uri( 'build/blocks-editor.js' ),
        [ 'wp-blocks', 'wp-dom' ],
        filemtime( get_theme_file_path( 'build/blocks-editor.js' ) ),
        true
    );
}
add_action( 'enqueue_block_editor_assets', 'Kala\gutenberg_styles' );

/**
 * Add theme support for needed Gutenberg features
 */
function gutenberg_setup() {
    remove_theme_support( 'core-block-patterns' );

    /* @link: https://make.wordpress.org/core/2022/10/04/block-based-template-parts-in-traditional-themes/ */
    add_theme_support( 'block-template-parts' );
}
add_action( 'after_setup_theme', 'Kala\gutenberg_setup' );

/**
 * Determine which blocks are allowed for the whole site and for certain custom post types.
 * If you need to remove block from certain post_type, template etc, you can do it like this:
 * delete_element_by_value( 'meomblocks/block-name', $blocks_to_add );
 *
 * @param array  $allowed_blocks List of allowed blocks.
 * @param object $post Post object.
 * @return array
 */
function gutenberg_allowed_blocks( $allowed_blocks, $post ) {
    // Get MEOM ACF Blocks.
    $meom_acf_blocks = function_exists( 'MEOM\Blocks\meomblocks_acf_blocks' ) ? \MEOM\Blocks\meomblocks_acf_blocks() : false;
    // Get MEOM Native blocks.
    $meom_native_blocks = function_exists( 'MEOM\Blocks\meomblocks_native_blocks' ) ? \MEOM\Blocks\meomblocks_native_blocks() : false;

    // Set allowed core blocks.
    $blocks_to_add = [
        'core/block',
        'core/button',
        'core/buttons',
        'core/embed',
        'core/gallery',
        'core/heading',
        'core/image',
        'core/list',
        'core/list-item',
        'core/paragraph',
        'core/shortcode',
        'core/quote',
        'gravityforms/form',
    ];

    // Set MEOM ACF blocks.
    if ( $meom_acf_blocks ) {
        foreach ( $meom_acf_blocks as $block_name => $settings ) {
            $blocks_to_add[] = 'acf/' . $block_name;
        }
    }
    // Set MEOM Native blocks.
    if ( $meom_native_blocks ) {
        foreach ( $meom_native_blocks as $block ) {
            $blocks_to_add[] = 'meomblocks/' . $block['slug'];
        }
    }

    // If we remove blocks from the array, indexes need to be generated again.
    $allowed_blocks = array_values( $blocks_to_add );

    return $allowed_blocks;
}
add_filter( 'allowed_block_types_all', 'Kala\gutenberg_allowed_blocks', 10, 2 );

/**
 * Set custom Gutenberg templates for post types.
 * If block uses inner blocks and has defined template, the template should be defined again here.
 * If it's not defined here, the first element of the last block will be focused while creating new page.
 *
 * @return void
 */
function register_gutenberg_templates() {
    // Check if native hero block exists.
    if ( meomblocks_block_exists( 'hero' ) ) {
        $page_object           = get_post_type_object( 'page' );
        $page_object->template = [
            [
                'meomblocks/hero',
                [],
                [
                    [ 'core/heading', [ 'level' => 1 ] ],
                    [ 'core/paragraph', [] ],
                ],
            ],
        ];
    }
}
// Comment in if you want to use the templates.
add_action( 'init', 'Kala\register_gutenberg_templates' );

/**
 * Determine which embeds are allowed.
 * By default only youtube is allowed, defined in MEOM Dodo plugin.
 *
 * @param array  $allowed_embeds List of allowed embeds.
 * @return array $allowed_embeds Modified array of allowed embeds.
 */
function gutenberg_allowed_embeds( $allowed_embeds ) {
    $allowed_embeds = [
        'youtube',
        'vimeo',
    ];

    return $allowed_embeds;
}
add_filter( 'meom_dodo_allowed_embed_variants', 'Kala\gutenberg_allowed_embeds' );

// Remove SVG filters from body.
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
