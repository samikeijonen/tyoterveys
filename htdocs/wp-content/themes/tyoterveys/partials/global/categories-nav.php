<?php
/**
 * Partial for displaying categories nav.
 *
 * @package Kala
 */

if ( ! has_nav_menu( 'categories' ) ) :
    return;
endif;
?>

<nav class="categories-nav alignwide" aria-label="<?php esc_attr_e( 'Categories', 'kala' ); ?>">
    <?php
        wp_nav_menu(
            [
                'theme_location' => 'categories',
                'menu_id'        => 'categories-nav-items',
                'menu_class'     => 'categories-nav__items entry__terms reset-list',
                'container'      => false,
                'depth'          => 1,
            ]
        );
        ?>
</nav>
