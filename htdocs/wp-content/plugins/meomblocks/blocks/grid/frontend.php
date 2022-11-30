<?php

namespace MEOM\Blocks;

// Adds all the default attributes like `className` or `align`.
// We add our block default class `columns`.
$column_count        = attr( 'columnCount', $attributes, '2' );
$column_class        = 'has-' . $column_count . '-columns ';
$has_smaller_spacing = attr( 'hasSmallerSpacing', $attributes, false );

$has_smaller_spacing_class = $has_smaller_spacing ? ' has-smaller-spacing ' : '';

$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'grid-auto width-wide module-top-margin ' . $column_class . $has_smaller_spacing_class ] );

if ( ! $content ) :
    return;
endif;
?>

<div <?php echo $wrapper_attributes; // phpcs:ignore ?>>
    <?php echo do_blocks( $content ); // phpcs:ignore ?>
</div>
