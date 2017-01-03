<?php
/**
* podium functions and definitions
*
* @package podium
*/

// require array list
$reqire_files = [
	'/lib/enqueue-scripts.php', // Enqueue scripts and styles.
	'/lib/cleanup.php', // cleanup & setup theme.
	'/lib/widgets.php',         // Implement Custom widgets.
	'/lib/template-tags.php',   // Custom template tags for this theme.
	'/lib/extras.php',          // Custom functions that act independently of the theme templates.
	'/lib/customizer.php',      // Customizer additions.
	'/lib/menu-walkers.php',    // TODO -> make comment describing the functionality of the page
	'/lib/menu.php',            // TODO -> make comment describing the functionality of the page
	'/lib/admin.php',           // Code for better handaling the admin area
	'/lib/custom-fields.php',   // Inintialize custom fields (if you prefer to do this without ACF)
	'/lib/custom-post-type.php', // Inintialize unique CPT's and taxonomies for this project
	'/lib/pagination.php', // More flexible pagination function

	'/lib/clean-filenames.php', // Custom functions to clean filenames from Unicode to ASCII
	'/lib/config.php',          // get the settings for the wordpress theme.
	'/lib/media.php',          // Media functions.

	// plugins:
	'/plugins/tgm/podium-tpm.php', // Plugin installation and activation for Podium based themes.

	// this file should be edited to meet the needs of the theme.

];

// require all the files in the $reqire_files array
foreach ( $reqire_files as $file ) {
	require get_template_directory() . $file;
}

// Include array list
$include_files = [
	//'lib/xxxxxxxxxxxxxxxxxxxxxx.php',
];

// Include all the files in the $include_files array
foreach ( $include_files as $file ) {
	include get_template_directory() . $file;
}
