<?php
/**
 * Partial for displaying Footer nav.
 *
 * @package Kala
 */

if ( ! has_nav_menu( 'footer' ) ) :
    return;
endif;
?>

<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer', 'kala' ); ?>">
    <?php
        wp_nav_menu(
            [
                'theme_location' => 'footer',
                'menu_id'        => 'footer-nav-items',
                'menu_class'     => 'footer-nav__items',
                'container'      => false,
                'depth'          => 1,
            ]
        );
        ?>
</nav>
