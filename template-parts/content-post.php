<?php
/**
 * Template part for displaying single posts.
 *
 * @package podium
 */

?>

<article id="post-<?php the_ID();?>" <?php post_class();?>>
	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>');?>

		<div class="entry-meta">
			<?php podium_posted_on();?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content();?>
		<?php

wp_link_pages([
    'before' => '<div class="page-links">' . esc_html__('Pages:', 'podium'),
    'after'  => '</div>'
]);

?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php podium_entry_footer();?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

