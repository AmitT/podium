<?php
/**
 * WordPress.com-specific functions and definitions.
 *
 * This file is centrally included from `wp-content/mu-plugins/wpcom-theme-compat.php`.
 *
 * @package podium
 */

// TODO clean this functions

if (!function_exists('podium_setup')) {

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function podium_setup()
    {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on podium, use a find and replace
         * to change 'podium' to the name of your theme in all the template files
         */
        load_theme_textdomain('podium', get_template_directory() . '/languages');


        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption'
        ]);

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', [
            'aside',
            'image',
            'video',
            'quote',
            'link'
        ]);

    }

}

// podium_setup
add_action('after_setup_theme', 'podium_setup');

// Fire all our initial functions at the start
add_action('after_setup_theme', 'podium_start', 16);

function podium_start()
{

    // launching operation cleanup
    add_action('init', 'podium_head_cleanup');

    // remove pesky injected css for recent comments widget
    add_filter('wp_head', 'podium_remove_wp_widget_recent_comments_style', 1);

    // clean up comment styles in the head
    add_action('wp_head', 'podium_remove_recent_comments_style', 1);

    // clean up gallery output in wp
    add_filter('gallery_style', 'podium_gallery_style');

}

/* end podium start */

//The default wordpress head is a mess. Let's clean it up by removing all the junk we don't need.
function podium_head_cleanup()
{

    // Remove EditURI link
    remove_action('wp_head', 'rsd_link');

    // Remove Windows live writer
    remove_action('wp_head', 'wlwmanifest_link');

    // Remove index link
    remove_action('wp_head', 'index_rel_link');

    // Remove previous link
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);

    // Remove start link
    remove_action('wp_head', 'start_post_rel_link', 10, 0);

    // Remove links for adjacent posts
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

    // Remove WP version
    remove_action('wp_head', 'wp_generator');

    remove_action('wp_head', 'adjacent_posts_rel_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
}

/* end podium head cleanup */

// Remove injected CSS for recent comments widget
function podium_remove_wp_widget_recent_comments_style()
{

    if (has_filter('wp_head', 'wp_widget_recent_comments_style')) {
        remove_filter('wp_head', 'wp_widget_recent_comments_style');
    }

}

// Remove injected CSS from recent comments widget
function podium_remove_recent_comments_style()
{
    global $wp_widget_factory;

    if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
        remove_action('wp_head', [$wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style']);
    }

}

// Remove injected CSS from gallery
/**
 * @param $css
 */
function podium_gallery_style($css)
{
    return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

//  Stop WordPress from using the sticky class (which conflicts with Foundation), and style WordPress sticky posts using the .wp-sticky class instead
/**
 * @param  $classes
 * @return mixed
 */
function remove_sticky_class($classes)
{
    $classes   = array_diff($classes, ['sticky']);
    $classes[] = 'wp-sticky';
    return $classes;
}

add_filter('post_class', 'remove_sticky_class');

//This is a modified the_author_posts_link() which just returns the link. This is necessary to allow usage of the usual l10n process with printf()
/**
 * @return mixed
 */
function podium_get_the_author_posts_link()
{
    global $authordata;

    if (!is_object($authordata)) {
        return false;
    }

    $link = sprintf(
        '<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
        get_author_posts_url($authordata->ID, $authordata->user_nicename),
        esc_attr(sprintf(__('Posts by %s', 'podium'), get_the_author())), // No further l10n needed, core will take care of this one
        get_the_author()
    );
    return $link;
}
