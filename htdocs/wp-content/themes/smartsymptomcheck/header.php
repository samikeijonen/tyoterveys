<?php get_template_part( 'partials/header/head' ); ?>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'kala' ); ?></a>

    <header class="site-header x-padding">
        <div class="site-header__container mx-auto width-wide">

            <div class="site-header__title">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php bloginfo( 'name' ); ?>
                </a>
            </div>

            <?php if ( has_nav_menu( 'main' ) ) : ?>
                <button class="site-nav__toggle js-site-nav-toggle">
                    <span class="site-nav__toggle-box" aria-hidden="true">
                        <span class="site-nav__toggle-box-inner"></span>
                    </span>
                    <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'kala' ); ?></span>
                </button>
                <nav class="site-nav">
                    <?php wp_nav_menu(
                        [
                            'theme_location' => 'main',
                            'menu_class'     => 'site-nav__items animated js-site-nav-items',
                            'container'      => false,
                        ]
                    ); ?>
                </nav>
            <?php endif; ?>

        </div>
    </header>

    <main id="content" class="site-main x-padding">
