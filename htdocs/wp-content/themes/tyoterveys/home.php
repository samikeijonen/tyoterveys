<?php
/**
 * Home template.
 *
 * @package Kala
 */

use function Kala\get_svg;

get_header();
?>

<div class="content-area">
    <?php
    the_archive_title( '<h1 class="entry-title has-text-align-center alignwide">', '</h1>' );
    
    if ( is_home() || is_category() ) :
        get_template_part( 'partials/global/categories-nav' );
    endif;
    
    the_archive_description( '<div class="archive-description has-text-align-center top-margin top-margin--s">', '</div>' );

    if ( have_posts() ) : ?>
        <div class="grid has-3-columns content-row alignwide">
            <?php while ( have_posts() ) {
                the_post();
                get_template_part( 'partials/post/post-item' );
            } ?>
        </div>
        <?php
        the_posts_pagination(
            [
                'prev_text'          => get_svg( 'arrow' ) . '<span class="screen-reader-text">' . esc_html__( 'Previous page', 'kala' ) . '</span>',
                'next_text'          => get_svg( 'arrow' ) . '<span class="screen-reader-text">' . esc_html__( 'Next page', 'kala' ) . '</span>',
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'kala' ) . ' </span>',
            ]
        );
        ?>
    <?php else : ?>
        <p><?php esc_html_e( 'Unfortunately no posts were found', 'kala' ); ?></p>
    <?php endif; ?>
</div>

<?php get_footer();
