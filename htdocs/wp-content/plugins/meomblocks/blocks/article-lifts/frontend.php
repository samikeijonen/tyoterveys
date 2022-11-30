<?php

namespace MEOM\Blocks;

$term_id = attr( 'termId', $attributes );

$class_names = [
    'article-lifts',
    'width-wide',
    'module-top-margin',
];

// Arguments.
$args = [
    'post_type'              => 'post',
    'posts_per_page'         => 3,
    'no_found_rows'          => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
];

$latest_posts = new \WP_Query( $args );

// Adds all the default attributes like `className` or `align`.
$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => implode( ' ', $class_names ) ] );

?>
<div <?php echo $wrapper_attributes; // phpcs:ignore ?>>
    <div class="grid-auto">
        <?php
            if ( $latest_posts->have_posts() ) :
                while ( $latest_posts->have_posts() ) :
                    $latest_posts->the_post();
                        get_template_part( 'partials/post/post-item' );
                endwhile;
            endif;
        ?>
    </div>
</div>
<?php
wp_reset_postdata();
