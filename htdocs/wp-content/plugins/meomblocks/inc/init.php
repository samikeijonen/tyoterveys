<?php

namespace MEOM\Blocks;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Set Categories
 *
 * @param array $categories Array of the categories.
 * @return array
 */
function block_category( $categories ) {
    $config_json = file_get_contents( __DIR__ . '/../meom-blocks.config.json' );
    $config      = json_decode( $config_json, true );

    return array_merge(
        array(
            array(
                'title' => __( $config['category']['name'], 'meomblocks' ),
                'slug'  => $config['category']['slug'],
            ),
        ),
        $categories
    );
}
add_filter( 'block_categories_all', __NAMESPACE__ . '\block_category', 10 );


/**
 * Register block js for editor
 *
 * @return void
 */
function block_assets() {
    wp_enqueue_script(
        'meomblocks-block-js',
        plugins_url( '/build/blocks/main.js', dirname( __FILE__ ) ),
        apply_filters( 'meom_blocks_js_deps', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components' ) ),
        filemtime( plugin_dir_path( __DIR__ ) . '/build/blocks/main.js' ),
        true // Enqueue the script in the footer.
    );
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\block_assets' );

/**
 * Get native blocks listed in config file
 *
 * @return array
 */
function meomblocks_native_blocks() {
    $config_json = file_get_contents( __DIR__ . '/../meom-blocks.config.json' );
    $config      = json_decode( $config_json, true );

    return $config['blocks'];
}

/**
 * Get acf blocks listed in config file
 *
 * @return array
 */
function meomblocks_acf_blocks() {
    $config_json = file_get_contents( __DIR__ . '/../meom-blocks.config.json' );
    $config      = json_decode( $config_json, true );

    return $config['acf_blocks'];
}

/**
 * Register native gutenberg blocks.
 *
 * @return void
 */
function meomblocks_register_native_block() {
    if ( ! function_exists( 'register_block_type' ) ) {
        return;
    }

    $blocks = meomblocks_native_blocks();

    foreach ( $blocks as $block ) {
        // Register block styles for front end.
        $style_path = '../build/' . $block['slug'] . '-styles.css';
        if ( file_exists( plugin_dir_path( __FILE__ ) . $style_path ) ) {
            wp_register_style(
                'meomblocks-' . $block['slug'],
                plugins_url( $style_path, __FILE__ ),
                array( 'theme-styles' ),
                filemtime( plugin_dir_path( __FILE__ ) . $style_path )
            );
        }

        // Register block custom JS for front end.
        $js_path = '../build/' . $block['slug'] . '-js.js';
        if ( file_exists( plugin_dir_path( __FILE__ ) . $js_path ) ) {
            wp_register_script(
                'meomblocks-js-' . $block['slug'],
                plugins_url( $js_path, __FILE__ ),
                array( 'theme-scripts' ),
                filemtime( plugin_dir_path( __FILE__ ) . $js_path ),
                true
            );
        }

        // Register block styles for dashboard editor.
        $editor_style_path = '../build/' . $block['slug'] . '-editor.css';
        if ( file_exists( plugin_dir_path( __FILE__ ) . $editor_style_path ) ) {
            wp_register_style(
                'meomblocks-' . $block['slug'] . '-editor',
                plugins_url( $editor_style_path, __FILE__ ),
                [ 'wp-edit-blocks' ],
                filemtime( plugin_dir_path( __FILE__ ) . $editor_style_path )
            );
        }

        // Register block.
        register_block_type(
			// Path to the blocks .json file.
            __DIR__ . '/../blocks/' . $block['slug'],
            [
				'editor_style'    => 'meomblocks-' . $block['slug'] . '-editor',
                'render_callback' => function( $attributes, $content = null ) use ( $block ) {
                    // This will load CSS and JS only when block is present in the front-end.
                    wp_enqueue_style( 'meomblocks-' . $block['slug'] );
                    wp_enqueue_script( 'meomblocks-js-' . $block['slug'] );
					return render_native_block( $block['slug'], $attributes, $content );
                },
			]
        );
    }

}
add_action( 'init', __NAMESPACE__ . '\meomblocks_register_native_block' );


/**
 * Register ACF gutenberg blocks.
 *
 * @return void
 */
function meomblocks_register_acf_block() {
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        return;
    }

    $blocks = meomblocks_acf_blocks();
    // Register blocks.
    foreach ( $blocks as $name => $settings ) {
        $block_settings                    = $settings;
        $block_settings['name']            = $name;
        $block_settings['render_template'] = plugin_dir_path( __FILE__ ) . "/../acf-blocks/{$name}/frontend.php";

        // Register block styles and scripts if exists.
        $style_path        = '../build/' . $name . '-styles.css';
        $editor_style_path = '../build/' . $name . '-editor.css';
        $js_path           = '../build/' . $name . '-js.js';
        if ( file_exists( plugin_dir_path( __FILE__ ) . $style_path ) || file_exists( plugin_dir_path( __FILE__ ) . $editor_style_path ) || file_exists( plugin_dir_path( __FILE__ ) . $js_path ) ) {
            $block_settings['enqueue_assets'] = function() use ( $name, $style_path, $editor_style_path, $js_path ) {
                // Register front-end styles.
                if ( file_exists( plugin_dir_path( __FILE__ ) . $style_path ) ) {
                    // Styles for the front end.
                    wp_enqueue_style(
                        'acf-block-' . $name,
                        plugins_url( $style_path, __FILE__ ),
                        array( 'theme-styles' ),
                        filemtime( plugin_dir_path( __FILE__ ) . $style_path )
                    );
				}
                // Register editor styles.
                if ( is_admin() && file_exists( plugin_dir_path( __FILE__ ) . $editor_style_path ) ) {
                    wp_enqueue_style(
                        'acf-block-' . $name . '-editor',
                        plugins_url( $editor_style_path, __FILE__ ),
                        array( 'wp-edit-blocks' ),
                        filemtime( plugin_dir_path( __FILE__ ) . $editor_style_path )
                    );
                }
                // Register JavaScript.
                if ( file_exists( plugin_dir_path( __FILE__ ) . $js_path ) ) {
                    wp_register_script(
                        'acf-block-' . $name,
                        plugins_url( $js_path, __FILE__ ),
                        array( 'theme-scripts' ),
                        filemtime( plugin_dir_path( __FILE__ ) . $js_path ),
                        true
                    );
                    wp_enqueue_script( 'acf-block-' . $name );
                }
            };
        }
        acf_register_block_type( $block_settings );
    }
}
add_action( 'init', __NAMESPACE__ . '\meomblocks_register_acf_block' );

/**
 * Include HTML for dynamic native block.
 *
 * @param string $name Name of the blocks.
 * @param array  $attributes Block attributes.
 * @param string $content HTML content for the block.
 * @return string
 */
function render_native_block( $name, $attributes, $content ) {
    // Variables that are used in the template.
    $attributes = $attributes;
    $content    = $content;

    // Start rendering.
    ob_start();
    require __DIR__ . '/../blocks/' . $name . '/frontend.php';
    $output = ob_get_clean();
    return $output;
}
