<?php
/**
 * WordPress.com-specific functions and definitions.
 *
 * This file is centrally included from `wp-content/mu-plugins/wpcom-theme-compat.php`.
 *
 * @package podium
 */

function podium_scripts()
{

    if (WP_ENV === 'production') {
        wp_enqueue_style(
            'podium-style',
            get_stylesheet_directory_uri() . '/dist/styles/main.min.css',
            false,
            null
        );
        wp_enqueue_script(
            'podium-scripts',
            get_stylesheet_directory_uri() . '/dist/scripts/main.min.js',
            null,
            null,
            true
        );
    } else {
        wp_enqueue_style(
            'podium-style',
            get_stylesheet_directory_uri() . '/dist/styles/main.css',
            false,
            null
        );
        wp_enqueue_script(
            'podium-scripts',
            get_stylesheet_directory_uri() . '/dist/scripts/main.js',
            null,
            null,
            true
        );
    }

// Add resources for individual page templates
    // if (is_page_template('page-contact.php')) {

    //     wp_enqueue_script(
    //         'contact-page-script',
    //         get_stylesheet_directory_uri() . '/dist/scripts/contact-page.js',
    //         ['jquery'],
    //         false,
    //         true
    //     );
    //     wp_enqueue_script(
    //         'google-recapcha-script',
    //         '//www.google.com/recaptcha/api.js?hl='.pll_current_language(),
    //         ['contact-page-script'],
    //         false,
    //         true
    //     );

    // }

    //remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');

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
