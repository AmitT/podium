<?php
// This file handles the admin area and functions - You can use this file to make changes to the dashboard.

/************* DASHBOARD WIDGETS *****************/
// Disable default dashboard widgets
function disable_default_dashboard_widgets()
{

    remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
    remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget
    remove_meta_box('dashboard_quick_press', 'dashboard', 'core');     // Quick Press Widget
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
    remove_meta_box('dashboard_primary', 'dashboard', 'core');
    remove_meta_box('dashboard_secondary', 'dashboard', 'core');
    remove_meta_box('yoast_db_widget', 'dashboard', 'normal'); // Yoast's SEO Plugin Widget
}

// removing the dashboard widgets
add_action('admin_menu', 'disable_default_dashboard_widgets');

/************* CUSTOMIZE ADMIN *******************/

// Custom Backend Footer
function podium_custom_admin_footer()
{
    $wp_v         = get_bloginfo('version');
    $w_copyrights = _x('<span id="footer-thankyou">Developed by <a href="http://amitt.co.il" target="_blank">Amit Tal</a></span>', 'podium');
    return '<span style="direction:lrt;">v' . $wp_v . ' | ' . $w_copyrights . '</span>';
}

// adding it to the admin area
add_filter('admin_footer_text', 'podium_custom_admin_footer');

//ADD featured image thumbnail to WordPress admin columns

add_filter('manage_posts_columns', 'tcb_add_post_thumbnail_column', 5);
add_filter('manage_pages_columns', 'tcb_add_post_thumbnail_column', 5);

/**
 * @param  $cols
 * @return mixed
 */
function tcb_add_post_thumbnail_column($cols)
{
    $cols['tcb_post_thumb'] = __('Main image');
    return $cols;
}

add_action('manage_posts_custom_column', 'tcb_display_post_thumbnail_column', 5, 2);
add_action('manage_pages_custom_column', 'tcb_display_post_thumbnail_column', 5, 2);

/**
 * @param $col
 * @param $id
 */
function tcb_display_post_thumbnail_column($col, $id)
{

    switch ($col) {
        case 'tcb_post_thumb':

            if (function_exists('the_post_thumbnail')) {
                echo the_post_thumbnail('thumbnail');
            } else {
                echo 'Not supported in theme';
            }

            break;
    }

}

// Allow svg upload in media
/**
 * @param  $mimes
 * @return mixed
 */
function cc_mime_types($mimes)
{
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');


// Set interval beween heartbewats
/**
 * @param  $settings
 * @return mixed
 */
function podium_heartbeat_settings($settings)
{
    $settings['interval'] = 60; //Anything between 15-60
    return $settings;
}

add_filter('heartbeat_settings', 'podium_heartbeat_settings');
