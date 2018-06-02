<?php

/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package podium
 */

if (!function_exists('podium_posted_on')) {

    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function podium_posted_on()
    {

        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        if (get_the_time('U') !== get_the_modified_time('U')) {

            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';

        }

        $time_string = sprintf($time_string,
                                esc_attr(get_the_date('c')),
                                esc_html(get_the_date()),
                                esc_attr(get_the_modified_date('c')),
                                esc_html(get_the_modified_date())
                                );
        $posted_on = sprintf(
                                esc_html_x('Posted on %s', 'post date', 'podium'),
                                '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
                                );
        $byline = sprintf(
                            esc_html_x('by %s', 'post author', 'podium'),
                            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
                            );
        echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
    }

}

if (!function_exists('podium_entry_footer')) {

    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function podium_entry_footer()
    {

// Hide category and tag text for pages.
        if ('post' === get_post_type()) {

            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'podium'));

            if ($categories_list && podium_categorized_blog()) {

                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'podium') . '</span>', $categories_list); // WPCS: XSS OK.

            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html__(', ', 'podium'));

            if ($tags_list) {

                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'podium') . '</span>', $tags_list); // WPCS: XSS OK.

            }

        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {

            echo '<span class="comments-link">';
            /* translators: %s: post title */
            comments_popup_link(sprintf(wp_kses(__('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'podium'), ['span' => ['class' => []]]), get_the_title()));
            echo '</span> ';

        }

    }

}

if (!function_exists('podium_categorized_blog')) {

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function podium_categorized_blog()
{

    if (false === ($all_the_cool_cats = get_transient('podium_categories'))) {

            // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories([
                                            'fields'     => 'ids',
                                            'hide_empty' => 1, // We only need to know if there is more than one category.
                                            'number'     => 2
                                            ]);

            // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count($all_the_cool_cats);

        set_transient('podium_categories', $all_the_cool_cats);
    }

    if ($all_the_cool_cats > 1) {

            // This blog has more than 1 category so podium_categorized_blog should return true.
        return true;

    } else {

            // This blog has only 1 category so podium_categorized_blog should return false.
        return false;

    }

}

}

if (!function_exists('podium_category_transient_flusher')) {

/**
 * Flush out the transients used in podium_categorized_blog.
 */
function podium_category_transient_flusher()
{

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

        // Like, beat it. Dig?
    delete_transient('podium_categories');
}

}

add_action('edit_category', 'podium_category_transient_flusher');
add_action('save_post', 'podium_category_transient_flusher');

if (!function_exists('podium_archive_title')) {
/**
 * Customized Titles
 * @param  $title
 * @return mixed
 */
function podium_archive_title($title)
{

    if (is_category()) {
        // translators: Category archive title. 1: Category name
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        // translators: Tag archive title. 1: Tag name
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        // translators: Author archive title. 1: Author name
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_year()) {
        // translators: Yearly archive title. 1: Year
        $title = sprintf(__('Year: %s'), get_the_date(_x('Y', 'yearly archives date format')));
    } elseif (is_month()) {
        // translators: Monthly archive title. 1: Month name and year
        $title = sprintf(__('Month: %s'), get_the_date(_x('F Y', 'monthly archives date format')));
    } elseif (is_day()) {
        // translators: Daily archive title. 1: Date
        $title = sprintf(__('Day: %s'), get_the_date(_x('F j, Y', 'daily archives date format')));
    } elseif (is_tax('post_format')) {
        if (is_tax('post_format', 'post-format-aside')) {
            $title = _x('Asides', 'post format archive title');
        } elseif (is_tax('post_format', 'post-format-gallery')) {
            $title = _x('Galleries', 'post format archive title');
        } elseif (is_tax('post_format', 'post-format-image')) {
            $title = _x('Images', 'post format archive title');
        } elseif (is_tax('post_format', 'post-format-video')) {
            $title = _x('Videos', 'post format archive title');
        } elseif (is_tax('post_format', 'post-format-quote')) {
            $title = _x('Quotes', 'post format archive title');
        } elseif (is_tax('post_format', 'post-format-link')) {
            $title = _x('Links', 'post format archive title');
        } elseif (is_tax('post_format', 'post-format-status')) {
            $title = _x('Statuses', 'post format archive title');
        } elseif (is_tax('post_format', 'post-format-audio')) {
            $title = _x('Audio', 'post format archive title');
        } elseif (is_tax('post_format', 'post-format-chat')) {
            $title = _x('Chats', 'post format archive title');
        }
    } elseif (is_post_type_archive()) {
        // translators: Post type archive title. 1: Post type name
        $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
        // $tax = get_taxonomy(get_queried_object()->taxonomy);

        // translators: Taxonomy term archive title. 1: Taxonomy singular name, 2: Current taxonomy term
        $title = single_term_title('', false);
    } else {
        $title = __('Archives');
    }

    return $title;
}
}

add_filter('get_the_archive_title', 'podium_archive_title');
