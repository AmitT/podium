<?php
/**
 * @package    podium
 * @subpackage TGM-Plugin-Activation
 *
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 */

function podium_register_required_plugins()
{
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
    
    $config = [
        'id'           => 'podium-tgmpa',
        // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',
        // Default absolute path to bundled plugins.
        'menu'         => 'podium-tgmpa-install-plugins',
        // Menu slug.
        'parent_slug'  => 'themes.php',
        // Parent menu slug.
        'capability'   => 'edit_theme_options',
        // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,
        // Show admin notices or not.
        'dismissable'  => false,
        // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',
        // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,
        // Automatically activate plugins after installation or not.
        'message'      => ''
        // Message to output right before the plugins table.
    ];

    tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'podium_register_required_plugins');
