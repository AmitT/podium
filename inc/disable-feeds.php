<?php
/**
 *
 *
 *
 *
 * @package podium
 */

// Remove feeds content
/**
 * Remove feed links from wp_head
 */
function podium_remove_feed_links()
{
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
}

add_action('wp_head', 'podium_remove_feed_links', 1);

/**
 * Remove the `feed` endpoint
 */
function podium_kill_feed_endpoint()
{

// This is extremely brittle.
    // $wp_rewrite->feeds is public right now, but later versions of WP might change that

    global $wp_rewrite;
    $wp_rewrite->feeds = [];
}

add_action('init', 'podium_kill_feed_endpoint', 99);

/**
 * prefect actions from firing on feeds when the `do_feed` function is
 * called
 */
function podium_remove_feeds()
{
    // redirect the feeds! don't just kill them
    wp_redirect(home_url(), 301);
    return;
}

foreach (['rdf', 'rss', 'rss2', 'atom'] as $feed) {
    add_action('do_feed_' . $feed, 'podium_remove_feeds', 1);
}

unset($feed);

/**
 * Activation hook
 */
function podium_remove_feeds_activation()
{
    podium_kill_feed_endpoint();
    flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'podium_remove_feeds_activation');

function disable_feed_generator()
{
    return '';
}

add_filter('the_generator', 'disable_feed_generator');
