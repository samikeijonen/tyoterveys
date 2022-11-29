<?php

namespace MEOM\Blocks;

// Adds all the default attributes like `className` or `align`.
// We add our block default class `columns`.
$column_count = attr( 'columnCount', $attributes, '2' );
$column_class = 'has-' . $column_count . '-columns ';
$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'columns grid ' . $column_class ] );

if ( ! $content ) :
    return;
endif;
?>

<div <?php echo $wrapper_attributes; // phpcs:ignore ?>>
    <?php echo do_blocks( $content ); // phpcs:ignore ?>
</div>
