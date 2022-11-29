<?php
/**
 * Single template.
 *
 * @package Kala
 */

get_header();

while ( have_posts() ) :
    the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class( 'content-area entry' ); ?>>
        <h1 class="entry__title has-text-align-center alignwide"><?php the_title(); ?></h1>
        <?php
            get_template_part( 'partials/post/entry-meta' );
            ?>

            <?php
            $author_id   = get_the_author_meta( 'ID' );
            $author_desc = get_the_author_meta( 'description' );
            ?>
            <div class="profile">
                <figure class="profile__img aspect-ratio aspect-ratio--1-1">
                    <?php echo get_avatar( $author_id, 140); // phpcs:ignore ?>
                </figure>
            
                <div class="profile__content top-margin top-margin--s">
                    <h2 class="profile__title h5"><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></h2> 

                    <?php if ( $author_desc ) : ?>
                        <p class="profile__desc"><?php echo esc_html( $author_desc ); ?></p> 
                    <?php endif; ?>   
                </div>
            </div>

        <?php the_content(); ?>

        <div class="entry__meta mt-2xl">
            <?php Kala\display_terms( [ 'sep' => '' ] ) ?>
        </div>
    </article>

    <?php
endwhile;
get_footer();
