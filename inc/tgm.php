<?php
/**
 * @package    podium
 * @subpackage TGM-Plugin-Activation
 *
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 */

add_action('tgmpa_register', 'podium_register_required_plugins');

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function podium_register_required_plugins()
{
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = [

        // [
        //     'name'     => 'Redirection',
        //     'slug'     => 'redirection',
        //     'required' => false
        // ],

        // Required Plugins
        [
            'name'             => 'iThemes Security',
            'slug'             => 'better-wp-security',
            'required'         => true,
            'force_activation' => true
        ],
        [
            'name'             => 'Wordpress SEO',
            'slug'             => 'wordpress-seo',
            'required'         => true,
            'force_activation' => true
        ],
        // [
        //     'name'             => 'Wordpress Sitemap Page',
        //     'slug'             => 'wp-sitemap-page',
        //     'required'         => true,
        //     'force_activation' => true
        // ],
        // [
        //     'name'             => 'Advanced Cudtom Fields Pro',
        //     'slug'             => 'advanced-custom-fields-pro',
        //     'required'         => true,
        //     'force_activation' => true
        // ],
        // [
        //     'name'             => 'Winsite Image Optimizer',
        //     'slug'             => 'winsite-image-optimizer',
        //     'required'         => true,
        //     'force_activation' => true
        // ]
        // [
        //     'name'             => 'Polylang',
        //     'slug'             => 'polylang',
        //     'source'           => '',
        //     'required'         => true,
        //     'force_activation' => true
        // ]

    ];

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = [
        'id'           => 'podium-tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                             // Default absolute path to bundled plugins.
        'menu'         => 'podium-tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',                   // Parent menu slug.
        'capability'   => 'edit_theme_options',           // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                           // Show admin notices or not.
        'dismissable'  => false,                          // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                             // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                          // Automatically activate plugins after installation or not.
        'message'      => ''                             // Message to output right before the plugins table.

        /*
    'strings'      => array(
    'page_title'                      => __( 'Install Required Plugins', 'theme-slug' ),
    'menu_title'                      => __( 'Install Plugins', 'theme-slug' ),
    /* translators: %s: plugin name. * /
    'installing'                      => __( 'Installing Plugin: %s', 'theme-slug' ),
    /* translators: %s: plugin name. * /
    'updating'                        => __( 'Updating Plugin: %s', 'theme-slug' ),
    'oops'                            => __( 'Something went wrong with the plugin API.', 'theme-slug' ),
    'notice_can_install_required'     => _n_noop(
    /* translators: 1: plugin name(s). * /
    'This theme requires the following plugin: %1$s.',
    'This theme requires the following plugins: %1$s.',
    'theme-slug'
    ),
    'notice_can_install_recommended'  => _n_noop(
    /* translators: 1: plugin name(s). * /
    'This theme recommends the following plugin: %1$s.',
    'This theme recommends the following plugins: %1$s.',
    'theme-slug'
    ),
    'notice_ask_to_update'            => _n_noop(
    /* translators: 1: plugin name(s). * /
    'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
    'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
    'theme-slug'
    ),
    'notice_ask_to_update_maybe'      => _n_noop(
    /* translators: 1: plugin name(s). * /
    'There is an update available for: %1$s.',
    'There are updates available for the following plugins: %1$s.',
    'theme-slug'
    ),
    'notice_can_activate_required'    => _n_noop(
    /* translators: 1: plugin name(s). * /
    'The following required plugin is currently inactive: %1$s.',
    'The following required plugins are currently inactive: %1$s.',
    'theme-slug'
    ),
    'notice_can_activate_recommended' => _n_noop(
    /* translators: 1: plugin name(s). * /
    'The following recommended plugin is currently inactive: %1$s.',
    'The following recommended plugins are currently inactive: %1$s.',
    'theme-slug'
    ),
    'install_link'                    => _n_noop(
    'Begin installing plugin',
    'Begin installing plugins',
    'theme-slug'
    ),
    'update_link'                       => _n_noop(
    'Begin updating plugin',
    'Begin updating plugins',
    'theme-slug'
    ),
    'activate_link'                   => _n_noop(
    'Begin activating plugin',
    'Begin activating plugins',
    'theme-slug'
    ),
    'return'                          => __( 'Return to Required Plugins Installer', 'theme-slug' ),
    'plugin_activated'                => __( 'Plugin activated successfully.', 'theme-slug' ),
    'activated_successfully'          => __( 'The following plugin was activated successfully:', 'theme-slug' ),
    /* translators: 1: plugin name. * /
    'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'theme-slug' ),
    /* translators: 1: plugin name. * /
    'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'theme-slug' ),
    /* translators: 1: dashboard link. * /
    'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'theme-slug' ),
    'dismiss'                         => __( 'Dismiss this notice', 'theme-slug' ),
    'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'theme-slug' ),
    'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'theme-slug' ),

    'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
    ),
     */
    ];

    tgmpa($plugins, $config);
}
