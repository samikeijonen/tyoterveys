<?php
/**
 * Partial for displaying hero.
 * Is called also from meomblocks.
 *
 * @package Kala
 */

use function Kala\display_svg;

$image_id       = Kala\get_variable( $image_id );
$image_position = Kala\get_variable( $image_position );
$video_url      = Kala\get_variable( $video_url );
$content        = Kala\get_variable( $content );
$extra_class    = Kala\get_variable( $extra_class );

$image_position_class = ' has-img-position-' . $image_position;
$class = 'hero cover-bg content-row alignfull ' . $extra_class . $image_position_class;

if ( $content ) : ?>
    <div class="<?php echo esc_html( $class ); ?>">
        <div class="hero__container container alignwide x-padding ">
            <div class="hero__content top-margin">
                <?php echo do_blocks( $content ); // phpcs:ignore ?>
            </div>
            <?php if ( $video_url ) : ?>
            <div class="hero__video">
                <video class="cover-img" muted playsinline autoplay loop width="1280" height="720" src="<?php echo esc_url( $video_url ); ?>"></video>
            </div>
            <?php elseif ( $image_id ) : ?>
                <figure class="hero__image">
                    <?php echo wp_get_attachment_image( $image_id, 'full', '', [ 'loading' => 'eager', 'class' => 'cover-img' ] ); ?>
                </figure>
            <?php endif; ?>
        </div>
    </div>
    <?php
endif;
