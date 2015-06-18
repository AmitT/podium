<?php
/**
 * WordPress.com-specific functions and definitions.
 *
 * This file is centrally included from `wp-content/mu-plugins/wpcom-theme-compat.php`.
 *
 * @package podium
 */

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

?>