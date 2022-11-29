<?php
/**
 * Template Name: Style Guide
 *
 * @package Kala
 */

get_header();

while ( have_posts() ) :
    the_post();
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'content-area' ); ?>>

        <?php the_content(); ?>

    <?php endwhile;

    $theme_json = file_get_contents( get_theme_file_path( 'theme.json' ) );
    $json_data  = json_decode( $theme_json, true );

    ?>
    <style>
        .tokens {
            list-style-type: none;
            padding-left: 0;
        }

        .tokens__color {
            border: 1px solid #e3e9eb;
            border-radius: 50%;
            display: block;
            height: 5rem;
            width: 5rem;
        }

        .tokens__label--color {
            margin-top: 0.25rem;
        }

        .token__width {
            background-color: #e3e9eb;
            display: inline-block;
            height: 1rem;
            margin-right: 1rem;
        }
    </style>

    <h2>Colors</h2>
    <?php
    $colors = $json_data['settings']['custom']['color'];
    foreach ( $colors as $key => $value ) : ?>
        <h3><?php echo esc_attr( $key ); ?></h3>
        <ul class="tokens tokens--colors grid has-4-columns">
            <?php foreach ( $value as $color ) : ?>
                <li class="tokens__item">
                    <span class="tokens__color" style="background-color: <?php echo esc_attr( $color ); ?>;"></span>
                    <p class="tokens__label tokens__label--color"><?php echo esc_html( $color ); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>

    <h2>Fonts</h2>
    <?php
    $fonts = $json_data['settings']['custom']['font'];
    foreach ( $fonts as $key => $value ) : ?>
        <p><?php echo esc_attr( $key ); ?>: <span style="font-family: <?php echo esc_attr( $value ); ?>;"><?php echo esc_attr( $value ); ?></span></p>
    <?php endforeach; ?>

    <h2>spacing</h2>
    <?php
    $spacing = $json_data['settings']['custom']['spacing'];
    foreach ( $spacing as $key => $value ) : ?>
        <p><span class="token__width" style="width: <?php echo esc_attr( $value ); ?>;"></span><?php echo esc_attr( $value ); ?></p>
    <?php endforeach; ?>

    </article>
<?php
get_footer();
