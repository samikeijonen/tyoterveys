<?php

namespace Kala;

// https://codex.wordpress.org/Function_Reference/register_post_type
function add_custom_post_type() {
    // Global content.
    $global_labels = [
        'name'          => __( 'Global content', 'kala' ),
        'singular_name' => __( 'Global content', 'kala' ),
    ];

    $global_args = [
        'labels'             => $global_labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'show_in_rest'       => true,
        'supports'           => [ 'title', 'editor', 'thumbnail' ],
        'menu_icon'          => 'dashicons-admin-site-alt3',
    ];

    register_post_type( 'global-content', $global_args );
}
add_action( 'init', 'Kala\add_custom_post_type' );
