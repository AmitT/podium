<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package podium
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<a class="skip-link screen-reader-text hide" href="#content"><?php esc_html_e( 'Skip to content', 'podium' ); ?></a>

		<header id="masthead" class="site-header" role="banner">
			<!--<div class="site-branding">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div> .site-branding -->

			<!-- <nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'podium' ); ?></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
			</nav>#site-navigation -->

			<div class="contain-to-grid sticky">
				<nav class="top-bar" data-topbar role="navigation">
					<ul class="title-area">
						<li class="name">
							<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
						</li>
						<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
						<li class="toggle-topbar menu-icon"><a href="#"><span><?php esc_html_e( 'Primary Menu', 'podium' ); ?></span></a></li>
					</ul>

					<section class="top-bar-section">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
						<!-- Right Nav Section
						<ul class="right">
							<li class="active"><a href="#">Right Button Active</a></li>
							<li class="has-dropdown">
								<a href="#">Right Button Dropdown</a>
								<ul class="dropdown">
									<li><a href="#">First link in dropdown</a></li>
									<li class="active"><a href="#">Active link in dropdown</a></li>
								</ul>
							</li>
						</ul>
 -->
						<!-- Left Nav Section
						<ul class="left">
							<li><a href="#">Left Nav Button</a></li>
						</ul>
						 -->
					</section>
				</nav>
			</div>
		</header><!-- #masthead -->

		<div id="content" class="site-content">
