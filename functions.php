<?php
/**
 * podium functions and definitions
 *
 * @package podium
 */

// require array list
$reqire_files = [
    '/inc/enqueue-scripts.php',  // Enqueue scripts and styles.
    '/inc/cleanup.php',          // cleanup & setup theme.
    '/inc/widgets.php',          // Implement Custom widgets.
    '/inc/template-tags.php',    // Custom template tags for this theme.
    '/inc/extras.php',           // Custom functions that act independently of the theme templates.
    '/inc/customizer.php',       // Customizer additions.
    '/inc/menu-walkers.php',     // TODO -> make comment describing the functionality of the page
    '/inc/menu.php',             // TODO -> make comment describing the functionality of the page
    '/inc/admin.php',            // Code for better handaling the admin area
    '/inc/custom-fields.php',    // Inintialize custom fields (if you prefer to do this without ACF)
    '/inc/custom-post-type.php', // Inintialize unique CPT's and taxonomies for this project
    '/inc/pagination.php',       // More flexible pagination function
    '/inc/clean-filenames.php',  // Custom functions to clean filenames from Unicode to ASCII
    '/inc/config.php',           // get the settings for the wordpress theme.
    '/inc/media.php',            // Media functions.
    '/inc/vendor/autoload.php',  // Load Composer packages
    '/inc/tgm.php'               // Plugin installation and activation for Podium based themes.
    
    // '/inc/disable-feeds.php'  //   Remove fedds content and links
];

// require all the files in the $reqire_files array
foreach ($reqire_files as $file) {
    require get_template_directory() . $file;
}

// Include array list
$include_files = [
    //'inc/xxxxxxxxxxxxxxxxxxxxxx.php',
];

// Include all the files in the $include_files array
foreach ($include_files as $file) {
    include get_template_directory() . $file;
}
