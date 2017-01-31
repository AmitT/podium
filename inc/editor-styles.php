<?php

// Adds your styles to the WordPress editor
function add_editor_styles() {
  add_editor_style( get_template_directory_uri() . '/assets/css/style.min.css' );
}
add_action( 'init', 'add_editor_styles' );
