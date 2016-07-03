<?php
/**
* The template for displaying archive pages.
*
* Learn more: http://codex.wordpress.org/Template_Hierarchy
*
* @package podium
*/
use Podium\Config\Settings as settings;

$settings = new settings();

get_header();
?>
<div id="content" class="site-content row">
	<div id="primary" class="content-area small-12 <?php echo $settings->getContentClass('medium-8', 'medium-12'); ?> columns">
		<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) { ?>

				<header class="page-header">
					<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) {
					 the_post();

					/*
					* Include the Post-Format-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Format name) and that will be used instead.
					*/
					get_template_part( 'directives/content', get_post_format() );
				} // End while
				?>

				<?php if ( function_exists( "emm_paginate" ) ) {
					emm_paginate();
				} ?>

				<?php } else { ?>

					<?php get_template_part( 'directives/content', 'none' ); ?>

					<?php } ?>

				</main><!-- #main -->
			</div><!-- #primary -->
			<?php if ( $settings->displaySidebar() ) { // has sidebar ?>
				<?php get_template_part( 'directives/sidebar', 'page' ); ?>
				<?php } ?>
			</div><!-- #content -->
			<?php get_footer(); ?>
