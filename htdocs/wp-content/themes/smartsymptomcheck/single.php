<?php get_header();

while ( have_posts() ) :
    the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class( 'content-area' ); ?>>
        <?php if ( has_post_thumbnail() ) : ?>
            <figure class="entry-image"><?php the_post_thumbnail( 'large' ); ?></figure>
        <?php endif; ?>

        <h1 class="entry-title"><?php the_title(); ?></h1>

        <?php get_template_part( 'partials/post/entry-meta' );

        the_content(); ?>

        <div class="entry-single__articles width-wide module-top-margin">
            <div class="entry-single__articles-wrapper top-margin top-margin--2xl">
                <h2 class=""><?php esc_html_e( 'More to read', 'kala' ); ?></h2>

                <?php
                $args_cat = [
                    'post_type'              => 'post',
                    'posts_per_page'         => 3,
                    'no_found_rows'          => true,
                    'update_post_meta_cache' => false,
                    'update_post_term_cache' => false,
                ];

                $latest_posts_cat = new WP_Query( $args_cat );
                ?>

                <div class="entry-single__articles-grid grid-auto">
                    <?php
                        if ( $latest_posts_cat->have_posts() ) :
                            while ( $latest_posts_cat->have_posts() ) :
                                $latest_posts_cat->the_post();

                                get_template_part( 'partials/post/post-item', '', [ 'heading_level' => 'h3' ] );
                            endwhile;
                        endif;
                    ?>
                </div>
                <?php
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </article>

<?php endwhile;
get_footer();
