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
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
	<?php wp_head(); ?>
	<!-- Please create favicon files with http://iconogen.com/
	and put them in assets/images/favicon directory -->

	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/favicon-16x16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/android-chrome-192x192.png" sizes="192x192">
	<meta name="msapplication-square70x70logo" content="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/smalltile.png" />
	<meta name="msapplication-square150x150logo" content="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/mediumtile.png" />
	<meta name="msapplication-wide310x150logo" content="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/widetile.png" />
	<meta name="msapplication-square310x310logo" content="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/largetile.png" />
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site off-canvas-wrapper" data-offcanvas>
		<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
			<a class="skip-link screen-reader-text hide" href="#content"><?php esc_html_e( 'Skip to content', 'podium' ); ?></a>

			<header id="masthead" class="site-header" role="banner">

				<div class="top-bar">
					<div class="top-bar-left">
						<?php $settings->getMenu( new Top_Bar_Walker(), 'onCanvass' ); // print menu (source config.php) ?>
						</div>
						<div class="top-bar-right">
							<ul class="menu">
								<li><input type="search" placeholder="Search"></li>
								<li><button type="button" class="button">Search</button></li>
							</ul>
						</div>
					</div>

					<div class="show-for-small-only">
						<nav class="tab-bar">
							<section class="middle tab-bar-section">
								<h1 class="title"><?php bloginfo('name'); ?></h1>
							</section>
							<section class="left-small">
								<a href="#" class="left-off-canvas-toggle menu-icon" ><span></span></a>
							</section>
						</nav>
					</div>

					<aside class="left-off-canvas-menu show-for-small-only">
						<?php $settings->getMenu( new Top_Bar_Walker(), 'offCanvas' ); // print menu (source config.php) ?>
					</aside>

					<a class="exit-off-canvas"></a>

				</header><!-- #masthead -->
