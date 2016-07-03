<?php
/**
* podium functions and definitions
*
* @package podium
*/

// Set host name
$host = $_SERVER['SERVER_NAME'];

if ( $host === 'localhost' || $host === 'win-sites.co.il' || $host === 'win-site.info' ) {
	//set development ENV
	define( 'WP_ENV', 'development' ); // remove when you make the site live.
} else {

	// Disable updates on server UPDATE ONLY WITH GIT
	// require get_template_directory() . '/lib/disable-updates.php';
	// Set production ENV
	define( 'WP_ENV', 'production' );
}

if ( ! defined( 'WP_ENV' ) ) {
	// Fallback if WP_ENV isn't defined in your WordPress config
	// Used to check for 'development' or 'production'
	define( 'WP_ENV', 'production' );
}

// TODO move to seperate files
function podium_scripts() {
	if ( is_rtl() ) {
		// Load RTL Styles
		if ( WP_ENV !== 'development' ) {
			wp_enqueue_style( 'podium-rtl-style', get_stylesheet_directory_uri() . '/dist/styles/rtl.min.css' );
		} else {
			wp_enqueue_style( 'podium-rtl-style', get_stylesheet_directory_uri() . '/dist/styles/rtl.css' );
		}
	} else {
		// Load LTR Styles
		if ( WP_ENV !== 'development' ) {
			wp_enqueue_style( 'podium-style', get_stylesheet_directory_uri() . '/dist/styles/main.min.css' );
		} else {
			wp_enqueue_style( 'podium-style', get_stylesheet_directory_uri() . '/dist/styles/main.css' );
		}
	}
	if ( WP_ENV !== 'development' ) {
		wp_enqueue_script( 'podium-navigation', get_stylesheet_directory_uri() . '/dist/scripts/main.min.js', array(), '20120206', true );
	} else {
		wp_enqueue_script( 'podium-navigation', get_stylesheet_directory_uri() . '/dist/scripts/main.js', array(), '20120206', true );
	}
	//wp_enqueue_script( 'podium-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	//wp_enqueue_script( 'podium-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'podium_scripts' );

// require array list
$reqire_files = [
	//'/lib/enqueue-scripts.php', // Enqueue scripts and styles.
	'/lib/cleanup.php', // cleanup & setup theme.
	'/lib/widgets.php',         // Implement Custom widgets.
	'/lib/template-tags.php',   // Custom template tags for this theme.
	'/lib/extras.php',          // Custom functions that act independently of the theme templates.
	'/lib/customizer.php',      // Customizer additions.
	'/lib/jetpack.php',         // /lib/jetpack.php
	'/lib/menu-walkers.php',    // TODO -> make comment describing the functionality of the page
	'/lib/menu.php',            // TODO -> make comment describing the functionality of the page
	'/lib/admin.php',           // TODO -> make comment describing the functionality of the page
	'/lib/custom-fields.php',   // TODO -> make comment describing the functionality of the page
	'/lib/custom-post-type.php', // TODO -> make comment describing the functionality of the page
	'/lib/pagination.php', // More flexible pagination function

	'/lib/clean-filenames.php', // Custom functions to clean filenames from Unicode to ASCII
	'/lib/config.php',          // get the settings for the wordpress theme.
	'/lib/gallery.php',          // get the settings for the wordpress theme.

	// plugins:
	'/plugins/tgm/podium-tpm.php', // Plugin installation and activation for Podium based themes.

	// this file should be edited to meet the needs of the theme.

];

// require all the files in the $reqire_files array
foreach ( $reqire_files as $file ) {
	require get_template_directory() . $file;
}

// include array list
$include_files = [
	//'lib/xxxxxxxxxxxxxxxxxxxxxx.php',
];

// include all the files in the $include_files array
foreach ( $include_files as $file ) {
	@include get_template_directory() . $file;
}
