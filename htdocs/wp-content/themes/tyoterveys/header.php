<?php
/**
 * Header template.
 *
 * @package Kala
 */

get_template_part( 'partials/header/head' );
?>

<body <?php body_class( 'site' ); ?>>
    <?php wp_body_open(); ?>
    <div class="site__wrapper">
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'kala' ); ?></a>

        <header class="site-header x-padding">
            <div class="site-header__container container alignwide">

                <div class="site-header__title h4">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                </div>

                <?php get_template_part( 'partials/global/site-nav' ); ?>

            </div>
        </header>

        <main id="content" class="site-main x-padding">
            <div class="site-main__container container">
