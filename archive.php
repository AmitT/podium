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
<div class="grid-container">
    <div id="content" class="site-content grid-x grid-padding-x">
        <div id="primary" class="content-area small-12 <?php echo $settings->getContentClass('medium-8', 'medium-12'); ?> cell">
            <main id="main" class="site-main" role="main">

                <?php

                if (have_posts()) {

                    ?>

                    <header class="page-header">
                        <?php

                        the_archive_title('<h1 class="page-title">', '</h1>');
                        the_archive_description('<div class="taxonomy-description">', '</div>');
                        ?>
                    </header><!-- .page-header -->

                    <?php /* Start the Loop */?>
                    <?php

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

// End while

    if (function_exists('podium_pagination')) {

        podium_pagination();

    }

} else {

    get_template_part('template-parts/content', 'none');

}

?>

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
