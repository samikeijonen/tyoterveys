<?php
/**
 * Partial for displaying the post item.
 *
 * @package Kala
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-item' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <figure class="post-item__fig background-image">
            <?php the_post_thumbnail( 'medium_large' ); ?>
        </figure>
    <?php endif; ?>
    <div class="post-item__content top-margin top-margin--xs">
        <h2 class="post-item__title h4">
            <a href="<?php the_permalink(); ?>" rel="bookmark" class="post-item__link">
                <?php the_title(); ?>
            </a>
        </h2>

        <?php if ( get_post_type() === 'professional' ) : ?>
            <div class="post-item__terms-wrapper">
                <?php
                Kala\display_terms(
                    [
                        'taxonomy' => 'professional_category',
                        'sep'      => ', ',
                        'class'    => 'post-item__terms',
                    ]
                );
                ?>
            </div>
        <?php endif; ?>
    </div>
</article>
