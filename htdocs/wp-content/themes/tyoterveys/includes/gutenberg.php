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
    /*
    Enqueue fonts that can't be self hosted:
    enqueue_custom_fonts();
    */

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

    /**
     * Filters the allowed embeds.
     *
     * @param array $allowed_embed_variants Default allowed embeds.
     */
    $allowed_embed_variants = \apply_filters( 'personaltrainertalo_allowed_embed_variants', [ 'youtube', 'vimeo' ] );

    // Data to JS.
    $data_array = [
        'allowedEmbedVariants' => $allowed_embed_variants,
    ];

    wp_localize_script( 'gutenberg-scripts-editor', 'kalaGutenbergData', $data_array );
}
add_action( 'enqueue_block_editor_assets', 'Kala\gutenberg_styles' );

/**
 * Add theme support for needed Gutenberg features
 */
function gutenberg_setup() {
    remove_theme_support( 'core-block-patterns' );

    // By adding the `theme.json` file block templates automatically get enabled.
	// because the template editor will need additional QA and work to get right
	// the default is to disable this feature.
	remove_theme_support( 'block-templates' );
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
        'core/buttons',
        'core/button',
        'core/image',
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/embed',
        'core/button',
        'core/quote',
        'core/shortcode',
        'wpforms/form-selector',
        'leadin/hubspot-form-block',
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
        $page_object = get_post_type_object( 'page' );

        $template = [
            [
                'meomblocks/hero',
                [],
                [
                    [ 'core/heading', [ 'level' => 1 ] ],
                    [ 'core/paragraph', [] ],
                ],
            ],
        ];

        $page_object->template = $template;
    }
}
add_action( 'init', 'Kala\register_gutenberg_templates' );


/**
 * Add icon to button block.
 *
 * @param string $block_content  The block content about to be appended.
 * @param array  $block          The full block, including name and attributes.
 *
 * @return string The block contents, rendered (or altered).
 */
function render_block( $block_content, $block ) {
    if ( 'core/button' === $block['blockName'] ) {
            $icon = get_svg( 'arrow' );

            $block_content = str_replace( '</a>', $icon . '</a>', $block_content );
    }
    if ( 'core/file' === $block['blockName'] ) {
        $icon = get_svg( 'arrow' );

        $block_content = str_replace( '</a></div>', $icon . '</a></div>', $block_content );
    }

    return $block_content;
}
add_filter( 'render_block', 'Kala\render_block', 10, 2 );

/**
 * Add reusable blocks to admin menu.
 *
 * @param mixed $type Post type.
 * @param mixed $args Arguments for post type.
 * @return void Modified post type arguments.
 */
function reusable_menu_display( $type, $args ) {
    // Bail if post type is not `wp_block` (reusable blocks).
    if ( 'wp_block' !== $type ) {
        return;
    }

    $args->show_in_menu      = true;
    $args->_builtin          = false;
    $args->labels->name      = esc_html__( 'Global content', 'kala' );
    $args->labels->menu_name = esc_html__( 'Global content', 'kala' );
    $args->menu_icon         = 'dashicons-screenoptions';
    $args->menu_position     = 58;
}
add_action( 'registered_post_type', 'Kala\reusable_menu_display', 10, 2 );
