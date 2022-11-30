    </main><!-- .site-content -->

    <footer class="site-footer x-padding">
        <div class="site-footer__container mx-auto width-wide">
            <?php
                // Echo from global content CPT.
                // Needs to have slug `footer`.
                $footer_slug = function_exists( 'pll_current_language' ) && pll_current_language() === 'en' ? 'footer' : 'alapalkki';
                $footer_post = get_page_by_path( $footer_slug, '', 'global-content' );

                if ( $footer_post ) :
                    echo apply_filters( 'the_content', get_the_content( null, false, absint( $footer_post->ID )) ); // phpcs:ignore
                endif;
            ?>
        </div>
    </footer>

    <?php if ( function_exists( 'getenv' ) && getenv( 'WP_ENV' ) === 'development' && ! getenv( 'HIDE_SIZE_DEBUGGER' ) ) : ?>
        <div class="size-debugger"></div>
    <?php endif; ?>

    <?php wp_footer(); ?>

</body>
</html>
