<?php get_header(); ?>
<div class="content-area">
    <div class="archive width-wide top-margin">
        <?php
        the_archive_title( '<h1 class="archive__title">', '</h1>' );
        the_archive_description( '<div class="archive__description">', '</div>' );
        ?>
    </div>

    <?php if ( has_nav_menu( 'post_categories' ) ) : ?>
        <nav class="taxonomy-nav width-wide module-top-margin" aria-label="<?php esc_attr_e( 'Categories', 'kala' ); ?>">
            <?php
                wp_nav_menu(
                    [
                        'theme_location' => 'post_categories',
                        'menu_class'     => 'taxonomy-nav__items',
                        'container'      => false,
                        'depth'          => 1,
                    ]
                );
            ?>
        </nav>
    <?php endif; ?>

    <?php
    if ( have_posts() ) : ?>
        <div class="posts-list grid-auto width-wide module-top-margin">
            <?php while ( have_posts() ) {
                the_post();
                get_template_part( 'partials/post/post-item' );
            } ?>
        </div>

        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e( 'Unfortunately no posts were found', 'kala' ); ?></p>
    <?php endif; ?>
</div>

<?php get_footer();
