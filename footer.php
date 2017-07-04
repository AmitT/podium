<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package podium
 */

?>
<div class="grid-container">
  <footer id="colophon" class="site-footer grid-x grid-padding-x" role="contentinfo">
   <div class="site-info small-12 cell">
    <a href="<?php echo esc_url(__('http://wordpress.org/', 'podium')); ?>">
     <?php printf(esc_html__('Proudly powered by %s', 'podium'), 'WordPress'); ?>
   </a>
   <span class="sep"> | </span>
   <?php
   printf(esc_html__('Theme: %1$s by %2$s.', 'podium'), 'podium', '<a href="http://win-site.co.il/" rel="designer">Amit Tal</a>');
   ?>
 </div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- .grid-container -->
</div><!-- .off-canvas-content -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
