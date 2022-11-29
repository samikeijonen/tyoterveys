<?php
/*
 * Plugin name: MEOM Blocks
 * Author: MEOM
 * Description: Custom Gutenberg Blocks
 * Version: 1.2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once plugin_dir_path( __FILE__ ) . 'inc/helpers.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/init.php';

// Setup MEOM Block Generator.
add_filter(
    'meom_blocks_generator_path_to_config',
    function() {
        return __DIR__;
    }
);

/**
 * Load languages
 *
 * @return void
 */
function meom_blocks_load_plugin_textdomain() {
    load_plugin_textdomain(
        'meomblocks',
        false,
        basename( dirname( __FILE__ ) ) . '/languages'
    );
}
add_action( 'plugins_loaded', 'meom_blocks_load_plugin_textdomain' );
