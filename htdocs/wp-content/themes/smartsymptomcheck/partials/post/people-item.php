<?php
/**
 * Partial for displaying the post item.
 *
 * @package Kala
 */

$people_title        = get_field( 'people_title' );
$people_phone        = get_field( 'people_phone' );
$people_email        = get_field( 'people_email' );
$people_linkedin_url = get_field( 'people_linkedin_url' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'people-item top-margin top-margin--xs' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <figure class="people-item__image aspect-ratio aspect-ratio--4-5"><?php the_post_thumbnail( 'large' ); ?></figure>
    <?php endif; ?>

    <?php if ( $people_title ) : ?>
        <p class="people-item__job"><?php echo esc_html( $people_title ); ?></p>
    <?php endif; ?>

    <h3 class="people-item__title people-item__title--people h5">
        <?php the_title(); ?>
    </h3>

    <?php if ( $people_phone ) : ?>
        <p class="people-item__phone"><?php echo esc_html( $people_phone ); ?></p>
    <?php endif; ?>

    <?php if ( $people_email ) : ?>
        <p class="people-item__email"><a href="mailto:<?php echo esc_url( $people_email ); ?>"><?php echo esc_html( $people_email ); ?></p>
    <?php endif; ?>

    <?php if ( $people_linkedin_url ) : ?>
        <p class="people-item__linkedin"><a href="<?php echo esc_url( $people_linkedin_url ); ?>"><?php esc_attr_e( 'LinkedIn', 'kala' ); ?></a></p>
    <?php endif; ?>
</article>
