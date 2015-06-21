<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package podium
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site off-canvas-wrap" data-offcanvas>
		<a class="skip-link screen-reader-text hide" href="#content"><?php esc_html_e( 'Skip to content', 'podium' ); ?></a>

		<header id="masthead" class="site-header" role="banner">
			<div class="sticky show-for-medium-up contain-to-grid">
				<nav class="top-bar" data-topbar>
					<ul class="title-area">
						<!-- Title Area -->
						<li class="name">
							<h1> <a href="<?php echo home_url(); ?>" rel="nofollow"><?php bloginfo('name'); ?></a></h1>
						</li>
					</ul>		
					<section class="top-bar-section right">
						<?php // TODO podium_top_nav(); ?>
					</section>
				</nav>
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
				<ul class="off-canvas-list">
					<li><label>Navigation</label></li>
					<?php // TODO podium_off_canvas(); ?>    
				</ul>
			</aside>
			
			<a class="exit-off-canvas"></a>

		</header><!-- #masthead -->

		<div id="content" class="site-content row">
