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
	<?php wp_head();

	$imagesFolder = get_template_directory_uri().'/dist/images/';

	// Please create favicon files with http://iconogen.com/
	// and put them in assets/images/favicon directory
	?>
	
	<link rel="shortcut icon" href="<?php echo $imagesFolder; ?>favicon/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $imagesFolder; ?>favicon/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $imagesFolder; ?>favicon/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $imagesFolder; ?>favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $imagesFolder; ?>favicon/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $imagesFolder; ?>favicon/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $imagesFolder; ?>favicon/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $imagesFolder; ?>favicon/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $imagesFolder; ?>favicon/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $imagesFolder; ?>favicon/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="<?php echo $imagesFolder; ?>favicon/favicon-16x16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="<?php echo $imagesFolder; ?>favicon/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="<?php echo $imagesFolder; ?>favicon/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="<?php echo $imagesFolder; ?>favicon/android-chrome-192x192.png" sizes="192x192">
	<meta name="msapplication-square70x70logo" content="<?php echo $imagesFolder; ?>favicon/smalltile.png" />
	<meta name="msapplication-square150x150logo" content="<?php echo $imagesFolder; ?>favicon/mediumtile.png" />
	<meta name="msapplication-wide310x150logo" content="<?php echo $imagesFolder; ?>favicon/widetile.png" />
	<meta name="msapplication-square310x310logo" content="<?php echo $imagesFolder; ?>favicon/largetile.png" />
</head>

<body <?php body_class(); ?>>
	<!-- Loader part -->
	<div class="se-pre-con">
		<div class="sk-circle">
			<div class="sk-circle1 sk-child"></div>
			<div class="sk-circle2 sk-child"></div>
			<div class="sk-circle3 sk-child"></div>
			<div class="sk-circle4 sk-child"></div>
			<div class="sk-circle5 sk-child"></div>
			<div class="sk-circle6 sk-child"></div>
			<div class="sk-circle7 sk-child"></div>
			<div class="sk-circle8 sk-child"></div>
			<div class="sk-circle9 sk-child"></div>
			<div class="sk-circle10 sk-child"></div>
			<div class="sk-circle11 sk-child"></div>
			<div class="sk-circle12 sk-child"></div>
		</div>
	</div>
	<!-- end loader part -->

	<div id="page" class="hfeed site off-canvas-wrapper">
		<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
			<a class="skip-link screen-reader-text hide" href="#content"><?php esc_html_e( 'Skip to content', 'podium' ); ?></a>

			<header id="masthead" class="site-header" role="banner">

				<div class="show-for-medium top-bar">
					<div class="row">
						<div class="small-12 columns">
							<div class="top-bar-left">
								<?php $settings->getMenu( new Top_Bar_Walker(), 'onCanvass' ); // print menu (source config.php) ?>
							</div>
							<div class="top-bar-left">

							</div>
						</div>
					</div>
				</div>

				<div class="hide-for-medium">
					<div class="title-bar">
						<div class="title-bar-left">
							<button class="menu-icon" type="button" data-open="offCanvasLeft"></button>
						</div>
						<div class="title-bar-left">

						</div>
					</div>
				</div>

			</header><!-- #masthead -->

			<div class="off-canvas position-left" id="offCanvasLeft" data-off-canvas>
				<?php $settings->getMenu( new Top_Bar_Walker(), 'offCanvas' ); // print menu (source config.php) ?>
			</div>
			<div class="off-canvas-content" data-off-canvas-content>
			</div>

			<a class="exit-off-canvas"></a>
