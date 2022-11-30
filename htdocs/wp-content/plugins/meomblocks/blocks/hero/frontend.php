<?php

namespace MEOM\Blocks;

use Kala;

global $post;

$image       = attr( 'image', $attributes, null );
$style       = attr( 'style', $attributes, 'setting_1' );
$extra_class = attr( 'className', $attributes, '' );
$content     = remove_empty_tags_recursive( $content );

// Build extra classes from attributes.
$extra_class .= 'hero--style-' . $style;

// Render hero from theme, if available.
$theme_partial = 'partials/global/hero';
if ( $content && function_exists( 'Kala\render_partial' ) && file_exists( get_template_directory() . '/' . $theme_partial . '.php' ) ) :
    Kala\render_partial(
        $theme_partial,
        array(
            'image_id'    => $image && $image['id'] ? $image['id'] : null,
            'style'       => $style,
            'content'     => $content,
            'extra_class' => $extra_class,
        )
    );
endif;
