<?php

// changing the logo link from wordpress.org to your site
function podium_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function podium_login_title() { return get_option('blogname'); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'podium_login_css', 10 );
add_filter('login_headerurl', 'podium_login_url');
add_filter('login_headertitle', 'podium_login_title');
