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
<div class="grid-container">
<div id="content" class="site-content grid-x grid-padding-x">
  <div id="primary" class="content-area small-12 <?php echo $contentWidth; ?> cell">
    <main id="main" class="site-main" role="main">

      <?php

        while (have_posts()) {

        the_post();

        get_template_part('template-parts/content', 'page');

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
<?php get_footer();?>
