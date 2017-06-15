<?php
/**
 * WordPress.com-specific functions and definitions.
 *
 * This file is centrally included from `wp-content/mu-plugins/wpcom-theme-compat.php`.
 *
 * @package podium
 */

// Set host name
$host = $_SERVER['SERVER_NAME'];

// List of our development domains
$dev_domains = [
    'dev.win-site.co.il',
    'win-sites.co.il',
    'win-site.info',
    'localhost',
    'devurl.net'
];

if (in_array($host, $dev_domains)) {

    // Set development ENV
    if (!defined('WP_ENV')) {
        define('WP_ENV', 'development');
    }

    // Enable strict error reporting
    error_reporting(E_ALL | E_STRICT);
    @ini_set('display_errors', 1);

} else {

    // Set production ENV
    if (!defined('WP_ENV')) {
        define('WP_ENV', 'production');
    }


    // Limit post revisions to 5.
    if (!defined('WP_POST_REVISIONS')) {
        define('WP_POST_REVISIONS', 5);
    }


    // disallow wp files editor.
    if (!defined('DISALLOW_FILE_EDIT')) {
        define('DISALLOW_FILE_EDIT', true);
    }

}

if (!defined('WP_ENV')) {

    // Fallback if WP_ENV isn't defined in your WordPress config
    // Used to check for 'development' or 'production'
    if (!defined('WP_ENV')) {
        define('WP_ENV', 'production');
    }

}

// TODO move to seperate files
function podium_scripts()
{

    if (is_rtl()) {

        // Load RTL Styles
        if (WP_ENV !== 'development') {

            wp_enqueue_style('podium-rtl-style', get_stylesheet_directory_uri() . '/dist/styles/rtl.min.css');

        } else {

            wp_enqueue_style('podium-rtl-style', get_stylesheet_directory_uri() . '/dist/styles/rtl.css');

        }

    } else {

        // Load LTR Styles
        if (WP_ENV !== 'development') {

            wp_enqueue_style('podium-style', get_stylesheet_directory_uri() . '/dist/styles/main.min.css');

        } else {

            wp_enqueue_style('podium-style', get_stylesheet_directory_uri() . '/dist/styles/main.css');

        }

    }

    if (WP_ENV !== 'development') {

        wp_enqueue_script('podium-scripts', get_stylesheet_directory_uri() . '/dist/scripts/main.min.js', [], '20120206', true);

    } else {

        wp_enqueue_script('podium-scripts', get_stylesheet_directory_uri() . '/dist/scripts/main.js', [], '20120206', true);

    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {

        wp_enqueue_script('comment-reply');

    }

}

add_action('wp_enqueue_scripts', 'podium_scripts');

// Defer scripts
/**
 * @param  $tag
 * @param  $handle
 * @return mixed
 */
function podium_add_defer_attribute($tag, $handle)
{

    // add script handles to the array below
    $scripts_to_defer = [
        'podium-scripts'
        //  'more-js-handled'
    ];

    foreach ($scripts_to_defer as $defer_script) {

        if ($defer_script === $handle) {

            return str_replace(' src', ' defer="defer" src', $tag);

        }

    }

    return $tag;
}

add_filter('script_loader_tag', 'podium_add_defer_attribute', 10, 2);

// Async scripts
/**
 * @param  $tag
 * @param  $handle
 * @return mixed
 */
function podium_add_async_attribute($tag, $handle)
{
    // add script handles to the array below
    $scripts_to_async = [

//  'my-js-handle',
        //  'more-js-handled'
    ];

    foreach ($scripts_to_async as $async_script) {

        if ($async_script === $handle) {

            return str_replace(' src', ' async="async" src', $tag);

        }

    }

    return $tag;
}

// add_filter('script_loader_tag', 'podium_add_async_attribute', 10, 2);
