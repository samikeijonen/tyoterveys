<?php
/**
 * Partial for displaying hero.
 * Is called also from meomblocks.
 *
 * @package Kala
 */

$image_id    = Kala\get_variable( $image_id );
$content     = Kala\get_variable( $content );
$extra_class = Kala\get_variable( $extra_class );
$class       = 'hero content-row width-full x-padding cover-bg module-top-margin ' . $extra_class;

if ( $content ) : ?>
    <div class="<?php echo esc_html( $class ); ?>">
        <div class="hero__container mx-auto width-medium-plus">
            <?php if ( $image_id ) : ?>
                <figure class="hero__image cover-img">
                    <?php echo wp_get_attachment_image( $image_id, 'full', '', [ 'loading' => 'eager', 'class' => 'cover-img' ] ); ?>
                </figure>
            <?php endif; ?>
            <div class="hero__content top-margin">
                <?php echo do_blocks( $content ); // phpcs:ignore ?>
            </div>
        </div>
    </div>
<?php endif;
