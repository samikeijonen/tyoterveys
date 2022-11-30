<?php get_header(); ?>
<div class="content-area">
    <h1 class="entry-title"><?php printf( esc_html__( 'Search Results for: %s', 'kala' ), '<span>' . get_search_query() . '</span>' ); ?></h1>

    <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h2 class="entry-title">
                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <?php the_excerpt(); ?>
            </article>
        <?php endwhile; ?>

    <?php else : ?>

        <p><?php esc_html_e( 'Unfortunately, we didn’t find anything.', 'kala' ); ?></p>

    <?php endif; ?>
</div>
<?php get_footer(); ?>
