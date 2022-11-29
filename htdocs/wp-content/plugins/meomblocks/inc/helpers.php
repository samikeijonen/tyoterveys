<?php
/**
 * Helper functions used for rendering Gutenberg blocks
 *
 * @package meomblocks
 */

namespace MEOM\Blocks;

/**
 * Check if attribute exists.
 *
 * @param string $attr Name of the attribute.
 * @param array  $attributes Aray of the attributes.
 * @return boolean
 */
function has_attr( $attr, $attributes ) {
    if ( isset( $attributes[ $attr ] ) ) {
        return true;
    }
    return false;
}

/**
 * Get attribute or set default
 *
 * @param string $attr Needle.
 * @param array  $attributes All attributes.
 * @param string $fallback Fallback value if attribute not found.
 * @return mixed
 */
function attr( $attr, $attributes, $fallback = false ) {
    if ( isset( $attributes[ $attr ] ) ) {
        return $attributes[ $attr ];
    }

    return $fallback;
}

/**
 * Remove empty tags. This makes sure that we are not displaying placeholder elements.
 *
 * @param string $str String where tags should be removed.
 * @return string
 */
function remove_empty_tags_recursive( $str ) {
    // Return if string not given or empty.
    if ( ! is_string( $str ) ) {
        return $str;
    }

    // Recursive empty HTML tags.
    $return_string = preg_replace(
        // Pattern written by Junaid Atari.
        '/<([^<\/>]*)([^<\/>]*)>([\s]*?|(?R))<\/\1>/imsU',
        // Replace with nothing if string empty.
        '',
        // Source string.
        $str
    );

    return trim( $return_string );
}

/**
 * Check if content contains only empty HTML tags
 * That kind of content should not be displayed
 *
 * @param string $content Content to be checked.
 *
 * @return bool
 */
function is_only_html( $content ) {
    // Remove HTML tags from content.
    $trimmed_string = trim( strip_tags( $content, '<img><iframe>' ) );
    if ( $trimmed_string === '' ) {
        return true;
    } else {
        return false;
    }
}
