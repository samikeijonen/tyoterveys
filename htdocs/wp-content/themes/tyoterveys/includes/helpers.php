<?php
/**
 * General helper functions.
 *
 * @package Kala
 */

namespace Kala;

/**
 * Print the slug
 *
 * @param int $id The post ID.
 * @return void
 */
function the_slug( $id = null ) {
    echo esc_html( get_slug( $id ) );
}

/**
 * Get slug for post.
 *
 * @param int $id The post id.
 * @return string
 */
function get_slug( $id = null ) {
    global $post;
    $id        = $id || $post->ID;
    $post_data = get_post( $id, ARRAY_A );
    return $post_data['post_name'];
}

/**
 * Render a partial file with given arguments. You can use arguments as variables in the partial file.
 * Example:
 * render_partial( 'partials/person-card', [ 'title' => get_the_title(), 'content' => get_the_content() ] );
 *
 * @param string $template Template name (including folder).
 * @param array  $args Arguments that are passed to the template.
 * @return void
 */
function render_partial( $template, $args ) {
    // phpcs:disable
    extract( $args );
    // phpcs:enable
    include locate_template( $template . '.php' );
}

/**
 * Delete element from array by value.
 *
 * @param string $value Value to delete.
 * @param array  $array Array.
 * @return array
 */
function delete_element_by_value( $value, &$array ) {
    $index = array_search( $value, $array, true );
    if ( $index !== false ) {
        unset( $array[ $index ] );
    }
    return $array;
}

/**
 * Check if variable exists or set default
 *
 * @param string $variable Variable to check.
 * @param string $fallback Fallback value if variable not found.
 * @return mixed
 */
function get_variable( &$variable, $fallback = false ) {
    if ( isset( $variable ) ) {
        return $variable;
    }
    return $fallback;
}

/**
 * Check if MEOMblocks block exists.
 *
 * @param string $block_slug Slug for the block.
 * @return boolean
 */
function meomblocks_block_exists( $block_slug ) {
    $meom_native_blocks = function_exists( 'MEOM\Blocks\meomblocks_native_blocks' ) ? \MEOM\Blocks\meomblocks_native_blocks() : false;
    if ( $meom_native_blocks ) {
        $block_index = array_search( $block_slug, array_column( $meom_native_blocks, 'slug' ), true );
        if ( $block_index !== false ) {
            return true;
        }
    }
    return false;
}

/**
 * Display the date on which the post was written and wrap that to the time tag.
 * Select the default date format in Settings -> General -> Date format.
 * wp_kses_post doesn't allow time tags so that can't be used here.
 *
 * @param string     $format PHP date format.
 * @param int|object $post_id Post ID or WP_Post object.
 * @return void
 */
function date_with_time_tag( $format = '', $post_id = null ) {
    echo get_date_with_time_tag( $format, $post_id ); // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Display the date on which the post was written and wrap that to the time tag.
 * Select the default date format in Settings -> General -> Date format.
 *
 * @param string     $format PHP date format.
 * @param int|object $post_id Post ID or WP_Post object.
 * @return string
 */
function get_date_with_time_tag( $format = '', $post_id = null ) {
    $time_string = '<time class="entry-date" datetime="%1$s">%2$s</time>';
    $time_string = sprintf(
        $time_string,
        esc_attr( get_the_date( DATE_W3C, $post_id ) ),
        esc_html( get_the_date( $format, $post_id ) )
    );
    return $time_string;
}

/**
 * Outputs the SVG markup.
 *
 * @param $icon SVG icon name.
 * @param $path path to SVG icons folder.
 * @return void
 */
function display_svg( $icon = '', $path = '/images/icons/' ) {
    echo get_svg( $icon, $path ); // phpcs:ignore
}


/**
 * Return SVG markup.
 *
 * @param $icon SVG icon name.
 * @param $path path to SVG icons folder.
 * @return string SVG markup.
 */
function get_svg( $icon = '', $path = '/images/icons/' ) {
    // Get SVG file path.
    $svg_file = get_theme_file_path( esc_attr( $path ) . esc_attr( $icon ) . '.svg' );

    // Return markup or empty if icon does not exist.
    return file_exists( $svg_file ) ? file_get_contents( $svg_file ) : '';
}

/**
 * Outputs the post terms HTML.
 *
 * @param  array $args
 * @return void
 */
function display_terms( array $args = [] ) {
    echo render_terms( $args ); // phpcs:ignore
}

/**
 * Returns the post terms HTML.
 *
 * @param  array  $args
 * @return string
 */
function render_terms( array $args = [] ) {
    $html = '';

    $args = wp_parse_args(
        $args,
        [
            'taxonomy' => 'category',
            'text'     => '%s',
            'class'    => '',
            // Translators: Separates tags, categories, etc. when displaying a post.
            'sep'      => _x( ', ', 'taxonomy terms separator', 'kala' ),
            'before'   => '',
            'after'    => '',
        ]
    );

    // Append taxonomy to class name.
    if ( ! $args['class'] ) {
        $args['class'] = "entry__terms entry__terms--{$args['taxonomy']}";
    }

    $terms = get_the_term_list( get_the_ID(), $args['taxonomy'], '', $args['sep'], '' );

    if ( $terms ) {
        $html = sprintf(
            '<span class="%s">%s</span>',
            esc_attr( $args['class'] ),
            sprintf( $args['text'], $terms )
        );

        $html = $args['before'] . $html . $args['after'];
    }

    return $html;
}
