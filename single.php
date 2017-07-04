<?php
/**
 * The template for displaying all single posts.
 *
 * @package podium
 */
use Podium\Config\Settings as settings;

$settings = new settings();

get_header();

// Get primary area width
$contentWidth = $settings->getContentClass('medium-8', 'medium-12');
?>
<div class="grid-container">
<div id="content" class="site-content grid-x grid-padding-x">
  <div id="primary" class="content-area small-12 <?php echo $contentWidth; ?> cell">
    <main id="main" class="site-main" role="main">

      <?php

        while (have_posts()) {

        the_post();

        if (get_post_type() != 'post') {
            get_template_part('template-parts/content-single', get_post_type());
        } else {
            get_template_part('template-parts/content-single-post', get_post_format());
        }

        the_post_navigation();

        // If comments are open or we have at least one comment, load up the comment template.
        comments_template();

        }

// End of the loop. ?>

</main><!-- #main -->
</div><!-- #primary -->
<?php

if ($settings->displaySidebar()) {

    get_template_part('template-parts/sidebar', 'page');

}

?>
</div><!-- #content -->
</div><!-- .grid-container -->
<?php get_footer(); ?>
