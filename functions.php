<?php
/**
 * podium functions and definitions
 *
 * @package podium
 */

// TODO move to seperate files
function podium_scripts() {
  if(is_rtl()){
    wp_enqueue_style( 'podium-rtl-style', get_stylesheet_directory_uri() . '/dist/styles/rtl.min.css' );
  } else {
    wp_enqueue_style( 'podium-style', get_stylesheet_directory_uri() . '/dist/styles/main.min.css' );
  }
  
  wp_enqueue_script( 'podium-navigation', get_stylesheet_directory_uri() . '/dist/scripts/main.min.js', array(), '20120206', true );
  //wp_enqueue_script( 'podium-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
  //wp_enqueue_script( 'podium-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'podium_scripts' );

/**
 * Enqueue scripts and styles.
 */
//require get_template_directory() . '/lib/enqueue-scripts.php';

/**
 * cleanup & setup theme.
 */
//require get_template_directory() . '/lib/cleanup.php';

/**
 * Implement Custom widgets.
 */
require get_template_directory() . '/lib/widgets.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/lib/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/lib/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/lib/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/lib/jetpack.php';

/**
 * 
 */
@include get_template_directory() . 'lib/menu-walkers.php';

/**
 * 
 */
@include get_template_directory() . 'lib/menu.php';

/**
 * 
 */
@include get_template_directory() . 'lib/admin.php';