<?php
/**
 * The template for displaying search results pages.
 *
 * @package podium
 */
use Podium\Config\Settings as settings;
$settings = new settings(); 

get_header();
?>

	<section id="primary" class="content-area small-12 <?php echo $settings->getContentClass('medium-8', 'medium-12'); ?> columns">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'podium' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'directives/content', 'search' );
				?>

			<?php endwhile; ?>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'directives/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->
	<?php if( $settings->displaySidebar() ){ // has sidebar ?>
		<?php get_template_part( 'directives/sidebar', 'page' ); ?>
	<?php } ?>

<?php get_footer(); ?>
