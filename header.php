<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package podium
 */
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

        <header id="masthead" class="site-header" role="banner" data-sticky-container>

            <div class="show-for-medium top-bar" data-sticky data-margin-top="0">
                <div class="top-bar-right top-bar-menu">
                    <?php $settings->getMenu(new Top_Bar_Walker(), 'onCanvass'); // print menu (source config.php) ?>
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

        </header><!-- #masthead -->

        <div class="off-canvas position-left" id="offCanvas" data-off-canvas>

            <!-- Close button -->
            <button class="close-button" aria-label="Close menu" type="button" data-close>
                <span aria-hidden="true">&times;</span>
            </button>

            <!-- Menu -->
            <?php $settings->getMenu(new Top_Bar_Walker(), 'offCanvas'); // print menu (source config.php) ?>

        </div>
        <div class="off-canvas-content" data-off-canvas-content>
