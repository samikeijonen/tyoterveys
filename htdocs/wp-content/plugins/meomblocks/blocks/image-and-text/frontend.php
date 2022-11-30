<?php

namespace MEOM\Blocks;

$image_position = attr( 'imagePosition', $attributes, 'left' );
$image          = attr( 'image', $attributes, null );
$content        = remove_empty_tags_recursive( $content );


$class_names = [
    'image-and-text',
    'image-and-text--position-' . $image_position,
    'width-wide',
    'module-top-margin',
];

// Adds all the default attributes like `className` or `align`.
$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => implode( ' ', $class_names ) ] );

if ( $content ) : ?>
    <div <?php echo $wrapper_attributes; // phpcs:ignore ?>>
        <div class="image-and-text__container grid-auto">
            <?php if ( $image ) : ?>
                <figure class="image-and-text__image aspect-ratio aspect-ratio--1-1">
                    <?php echo wp_get_attachment_image( $image['id'], 'large' ); // phpcs:ignore ?>
                </figure>
            <?php endif; ?>
            <div class="image-and-text__content top-margin">
                <?php echo do_blocks( $content ); // phpcs:ignore ?>
            </div>
        </div>
    </div>
<?php endif;
