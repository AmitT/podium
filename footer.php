<?php
/**
* The template for displaying the footer.
*
* Contains the closing of the #content div and all content after
*
* @package podium
*/

?>

<footer id="colophon" class="site-footer row" role="contentinfo">
	<div class="site-info small-12 columns">
		<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'podium' ) ); ?>">
			<?php printf( esc_html__( 'Proudly powered by %s', 'podium' ), 'WordPress' ); ?>
		</a>
		<span class="sep"> | </span>
		<?php
		printf( esc_html__( 'Theme: %1$s by %2$s.', 'podium' ), 'podium', '<a href="http://win-site.co.il/" rel="designer">Winsite</a>' );
		?>
	</div><!-- .site-info -->
</footer><!-- #colophon -->
</div> <!-- inner-wrap -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
