<?php
/**
* The template for displaying all pages.
*
* This is the template that displays all pages by default.
* Please note that this is the WordPress construct of pages
* and that other 'pages' on your WordPress site will use a
* different template.
*
* @package podium
*/
use Podium\Config\Settings as settings;

$settings = new settings();

get_header();

// Get primary area width
$contentWidth = $settings->getContentClass('medium-8', 'medium-12');
?>
<div id="content" class="site-content row">
	<div id="primary" class="content-area small-12 <?php echo $contentWidth; ?> columns">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'directives/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			} // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php
	if ( $settings->displaySidebar() ) { // has sidebar
		get_template_part( 'directives/sidebar', 'page' );
	}
	?>
</div><!-- #content -->

<?php get_footer(); ?>
