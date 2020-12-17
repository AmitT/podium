<?php
/**
 *
 * podium functions and definitions
 *
 * @package podium
 */

// require array list
$reqire_files = [
    // Composer packages
    '/inc/vendor/autoload.php', // Load Composer packages

    // Classes
    '/inc/classes/MenuWalker.class.php',
    '/inc/classes/Environment.class.php', // Set Eniroment.
    '/inc/classes/Config.class.php', // get the settings for the wordpress theme.
    '/inc/classes/Filenames.class.php', // Custom functions to clean filenames from Unicode to ASCII
    '/inc/classes/Styles.class.php', //
    '/inc/classes/Scripts.class.php', //
    '/inc/classes/Files.class.php', //

    // Theme files
    '/inc/enqueue-scripts.php', // Enqueue scripts and styles.
    '/inc/cleanup.php', // cleanup & setup theme.
    '/inc/widgets.php', // Implement Custom widgets.
    '/inc/extras.php', // Custom functions that act independently of the theme templates.
    '/inc/customizer.php', // Customizer additions.
    '/inc/menu.php', // TODO -> make comment describing the functionality of the page
    '/inc/admin.php', // Code for better handaling the admin area
    '/inc/media.php', // Media functions.
    '/inc/editor-caps.php' // Configure editor role capabilities
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
