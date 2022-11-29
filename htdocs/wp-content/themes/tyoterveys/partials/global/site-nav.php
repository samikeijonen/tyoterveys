<?php
/**
 * Partial for displaying nav.
 *
 * @package Kala
 */

if ( ! has_nav_menu( 'main' ) ) :
    return;
endif;
?>

<nav class="site-nav js-site-nav" aria-label="<?php esc_attr_e( 'Main', 'kala' ); ?>">
    <button class="site-nav__toggle js-site-nav-toggle" aria-controls="site-nav-items">
        <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'kala' ); ?></span>
        <span class="site-nav__toggle-box" aria-hidden="true">
            <span class="site-nav__toggle-box-inner"></span>
        </span>
    </button>
    <?php
        wp_nav_menu(
            [
                'theme_location' => 'main',
                'menu_id'        => 'site-nav-items',
                'menu_class'     => 'site-nav__items animated js-site-nav-items',
                'container'      => false,
                'depth'          => 2,
            ]
        );
        ?>
</nav>
