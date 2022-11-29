<?php
/**
 * Partial for displaying Social links nav.
 *
 * @package Kala
 */

if ( ! has_nav_menu( 'social_links' ) ) :
    return;
endif;
?>

<nav class="wp-block-social-links-wrapper" aria-label="<?php esc_attr_e( 'Social links', 'kala' ); ?>">
    <?php
        wp_nav_menu(
            array(
                'theme_location' => 'social_links',
                'menu_class'     => 'wp-block-social-links wp-block-social-links--content',
                'container'      => false,
                'link_before'    => '<span class="screen-reader-text">',
                'link_after'     => '</span>',
            )
        );
        ?>
</nav>
