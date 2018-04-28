<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package podium
 */
use Podium\Config\Settings as settings;

$settings = new settings();

get_header();
?>
<div class="grid-container">
    <div id="content" class="site-content grid-x grid-padding-x">
        <div id="primary" class="content-area small-12 <?php echo $settings->getContentClass('medium-8', ''); ?> cell">
            <main id="main" class="site-main" role="main">
                <?php

                if (have_posts()) {

                    /* Start the Loop */

                    while (have_posts()) {

                        the_post();

/*
 * Include the Post-Format-specific template for the content.
 * If you want to override this in a child theme, then include a file
 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
 */
if (get_post_type() != 'post') {
    get_template_part('template-parts/content', get_post_type());
} else {
    get_template_part('template-parts/content-post', get_post_format());
}

}

if (function_exists('podium_pagination')) {

    podium_pagination();

}

} else {

    get_template_part('template-parts/content', 'none');

}

?>

</main><!-- #main -->
</div>
<?php

if ($settings->displaySidebar()) {

    get_template_part('template-parts/sidebar', 'page');

}

?>
</div><!-- #content -->
</div><!-- .grid-container -->

<?php get_footer();?>
