<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package podium
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param  array   $classes Classes for the body element.
 * @return array
 */
function podium_body_classes($classes)
{

// Adds a class of group-blog to blogs with more than 1 published author.
    if (is_multi_author()) {

        $classes[] = 'group-blog';

    }

    return $classes;
}

add_filter('body_class', 'podium_body_classes');

// Get post Thumb URL
/**
 * @param  $post
 * @param  $size
 * @return mixed
 */
function get_thumb_url($post, $size = 'full')
{

    if (has_post_thumbnail($post->ID)) {

        $attachment_id = get_post_thumbnail_id($post->ID);

        // thumbnail, medium, large, or full
        $src = wp_get_attachment_image_src($attachment_id, $size);
        return $src[0];

    }

    return false;
}

/**
 * @param  $limit
 * @return string
 */
function excerpt($limit)
{
    $excerpt = explode(' ', get_the_excerpt(), $limit);

    if (count($excerpt) >= $limit) {

        array_pop($excerpt);
        $excerpt = implode(' ', $excerpt);

    } else {

        $excerpt = implode(' ', $excerpt);

    }

    $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
    return $excerpt;
}

if (!function_exists('floating_direction')) {
    /**
     * @param $reverse
     */
    function floating_direction($reverse = false)
    {

        if ((is_rtl() && !$reverse) || (!is_rtl() && $reverse)) {
            return 'right';
        } else {
            return 'left';
        }

    }

}
