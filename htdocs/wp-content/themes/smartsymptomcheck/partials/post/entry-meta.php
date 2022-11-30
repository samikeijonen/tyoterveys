<?php
/**
 * Partial for displaying the entry meta for the post.
 * If you need to remove links from the categories, you can do it like this:
 * $entry_categories = wp_strip_all_tags( $entry_categories );
 *
 * @package Kala
 */

$entry_categories = get_the_category_list( ', ' );
?>

<p class="entry-meta">
    <span class="entry-meta__category"><?php echo wp_kses_post( $entry_categories ); ?></span> &middot;
    <span class="entry-meta__date"><?php Kala\date_with_time_tag(); ?></span>
</p>
