<?php
use Podium\Config\Settings as settings;

$settings = new settings();

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="//gmpg.org/xfn/11">

    <?php
    wp_head();
    get_template_part('template-parts/layouts/favicon', '');
    ?>

</head>

<body <?php body_class(); ?>>

    <div id="page" class="hfeed site">
        <a class="skip-link show-for-sr" href="#content">
            <?php esc_html_e('Skip to content', 'podium'); ?>
        </a>
<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="https://bulma.io">
      <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
    </a>

    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item">
        Home
      </a>

      <a class="navbar-item">
        Documentation
      </a>

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          More
        </a>

        <div class="navbar-dropdown">
          <a class="navbar-item">
            About
          </a>
          <a class="navbar-item">
            Jobs
          </a>
          <a class="navbar-item">
            Contact
          </a>
          <hr class="navbar-divider">
          <a class="navbar-item">
            Report an issue
          </a>
        </div>
      </div>
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a class="button is-primary">
            <strong>Sign up</strong>
          </a>
          <a class="button is-light">
            Log in
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>
        <!-- <header id="masthead" class="site-header" role="banner" data-sticky-container>

            <div class="show-for-medium top-bar" data-sticky data-margin-top="0">
                <div class="top-bar-right top-bar-menu">
                    <?php $settings->getMenu(new TopBarWalker(), 'onCanvass'); // print menu (source config.php) ?>
                </div>
                <div class="top-bar-left text-left top-bar-logo">
                    <a href="<?php echo get_home_url(); ?>">
                        <span class="title-bar-title"><?php echo get_bloginfo('name'); ?></span>
                    </a>
                </div>
            </div>

            <div class="hide-for-medium">
                <div class="title-bar">
                    <div class="title-bar-right">
                        <a href="<?php echo get_home_url(); ?>">
                            <span class="title-bar-title"><?php echo get_bloginfo('name'); ?></span>
                        </a>
                    </div>
                    <div class="title-bar-left">
                        <button class="menu-icon" type="button" data-open="offCanvas"></button>
                    </div>
                </div>
            </div>

        </header> #masthead -->

        <!--<div class="off-canvas position-left" id="offCanvas" data-off-canvas>

            <button class="close-button" aria-label="Close menu" type="button" data-close>
                <span aria-hidden="true">&times;</span>
            </button>

            <?php $settings->getMenu(new TopBarWalker(), 'offCanvas'); // print menu (source config.php) ?>

        </div> -->
        <!-- <div class="off-canvas-content" data-off-canvas-content> -->
