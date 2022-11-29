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

<p class="entry__meta has-text-align-center">
    <span class="entry__meta-date"><?php Kala\date_with_time_tag(); ?></span>
</p>
