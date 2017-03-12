<?php

// changing the logo link from wordpress.org to your site
function podium_login_url()
{
    return home_url();
}

add_filter('login_headerurl', 'podium_login_url');

// changing the alt text on the logo to show your site name
function podium_login_title()
{
    return get_option('blogname');
}

add_filter('login_headertitle', 'podium_login_title');

// Custom logo
function custom_login_logo()
{
    echo '<style type="text/css">
  h1 a {
    display:block; important;
    background-image: url(' . get_bloginfo('template_directory') . '/dist/images/logo.png) !important;
    width:213px!important;
    height:70px!important;
    background-size: 213px 70px!important;
  }
  </style>';
}

add_action('login_head', 'custom_login_logo');
