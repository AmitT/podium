<?php
use Podium\Config\Files as PodiumFiles;

function podium_scripts()
{
    $podiumFiles = new PodiumFiles();
    $podiumFiles->register();

    //remove emoji scripts
    // remove_action('wp_head', 'print_emoji_detection_script', 7);
    // remove_action('admin_print_scripts', 'print_emoji_detection_script');
    // remove_action('wp_print_styles', 'print_emoji_styles');
    // remove_action('admin_print_styles', 'print_emoji_styles');

    // if (is_singular() && comments_open() && get_option('thread_comments')) {
    //     wp_enqueue_script('comment-reply');
    // }
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
        // 'podium-scripts'
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
