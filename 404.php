<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package podium
 */

use Podium\Config\Settings as settings;

$settings = new settings();

get_header();

?>
<div class="grid-container">
    <div id="content" class="site-content grid-x grid-padding-x">
        <div id="primary" class="content-area small-12 cell">
            <main id="main" class="site-main" role="main">

                <section class="error-404 not-found">
                    <header class="page-header">
                        <h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'podium'); ?></h1>
                    </header><!-- .page-header -->

                    <div class="page-content">
                        <p>
                            <?php _e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'podium'); ?>
                        </p>

                        <?php get_search_form(); ?>

                    </div><!-- .page-content -->
                </section><!-- .error-404 -->

            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- #content -->
</div><!-- .grid-container -->
<?php get_footer();
