<?php
/**
 * Partial for displaying Social links nav.
 *
 * @package Kala
 */

if ( ! has_nav_menu( 'social-links' ) ) :
    return;
endif;
?>

<nav class="social-links" aria-label="<?php esc_attr_e( 'Social links', 'kala' ); ?>">
    <?php
        wp_nav_menu(
            array(
                'theme_location' => 'social-links',
                'menu_class'     => 'social-links__items',
                'container'      => false,
                'link_before'    => '<span class="screen-reader-text">',
                'link_after'     => '</span>',
            )
        );
        ?>
</nav>
