<?php
/**
 * Partial for displaying page content.
 *
 * @package Kala
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-area' ); ?>>
    <h1 class="entry__title has-text-align-center alignwide"><?php the_title(); ?></h1>

    <?php the_content(); ?>
</article>
