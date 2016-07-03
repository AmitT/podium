<?php
// This file handles the admin area and functions - You can use this file to make changes to the dashboard.

/************* DASHBOARD WIDGETS *****************/
// Disable default dashboard widgets
function disable_default_dashboard_widgets() {
	// Remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' ); // Comments Widget
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );  // Incoming Links Widget
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );         // Plugins Widget

	Remove_meta_box( 'dashboard_quick_press', 'dashboard', 'core' );  // Quick Press Widget
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );   // Recent Drafts Widget
	remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );         //
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );       //

	// Removing plugin dashboard boxes
	remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );         // Yoast's SEO Plugin Widget

}

/*
Now let's talk about adding your own custom Dashboard widget.
Sometimes you want to show clients feeds relative to their
site's content. For example, the NBA.com feed for a sports
site. Here is an example Dashboard Widget that displays recent
entries from an RSS Feed.

For more information on creating Dashboard Widgets, view:
http://digwp.com/2010/10/customize-wordpress-dashboard/
*/

// RSS Dashboard Widget
function podium_rss_dashboard_widget() {
	if ( function_exists( 'fetch_feed' ) ) {
		include_once( ABSPATH . WPINC . '/feed.php' );               // include the required file
		$feed = fetch_feed( 'http://www.win-site.co.il/feed/' );     // specify the source feed
		$limit = $feed->get_item_quantity( 2 );                      // specify number of items
		$items = $feed->get_items( 0, $limit );                      // create an array of items
	}
	if ( $limit == 0 ) {
		echo '<div>The RSS Feed is either empty or unavailable.</div>';   // fallback message
	}
	else {
		foreach ( $items as $item ) { ?>
			<h4 style="margin-bottom: 0;">
				<a href="<?php echo $item->get_permalink(); ?>" title="<?php echo mysql2date( __( 'j F Y @ g:i a', 'podium' ), $item->get_date( 'Y-m-d H:i:s' ) ); ?>" target="_blank">
					<?php echo $item->get_title(); ?>
				</a>
			</h4>
			<p style="margin-top: 0.5em;">
				<?php echo strip_tags( wp_trim_words( $item->get_description(), 40, '...' ) ); ?>
				<a style="display:block;" href="<?php echo $item->get_permalink(); ?>" title="<?php echo __( 'Read More', 'podium' ); ?>" target="_blank">
					<?php echo __( 'Read More', 'podium' ); ?> >
				</a>
			</p>
			<?php
		}
	}
}

// Calling all custom dashboard widgets
function podium_custom_dashboard_widgets() {
	wp_add_dashboard_widget( 'podium_rss_dashboard_widget', __( 'Recently on Winsite', 'podiumtheme' ), 'podium_rss_dashboard_widget' );

	/*
	Be sure to drop any other created Dashboard Widgets
	in this function and they will all load.
	*/
}

// removing the dashboard widgets
add_action( 'admin_menu', 'disable_default_dashboard_widgets' );

// adding any custom widgets
add_action( 'wp_dashboard_setup', 'podium_custom_dashboard_widgets' );

/************* CUSTOMIZE ADMIN *******************/
// Custom Backend Footer
function podium_custom_admin_footer() {
	_e( '<span id="footer-thankyou">Developed by <a href="http://win-site.co.il" target="_blank">Winsite</a></span>.', 'podium' );
}

// adding it to the admin area
add_filter( 'admin_footer_text', 'podium_custom_admin_footer' );

// get the the role object
$role_object = get_role( 'editor' );

// add $cap capability to this role object
$role_object->add_cap( 'edit_theme_options' );

// Custom logo
function custom_login_logo() {
	echo '<style type="text/css">
	h1 a {
		display:block; important;
		background-image: url('.get_bloginfo('template_directory').'/dist/images/logo.png) !important;
		width:213px!important;
		height:70px!important;
		background-size: 213px 70px!important;
	}
	</style>';
}
add_action( 'login_head', 'custom_login_logo' );

// clean
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'start_post_rel_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

function disable_feed_generator() {
	return '';
}
add_filter( 'the_generator','disable_feed_generator' );

//ADD featured image thumbnail to WordPress admin columns

add_filter( 'manage_posts_columns', 'tcb_add_post_thumbnail_column', 5 );
add_filter( 'manage_pages_columns', 'tcb_add_post_thumbnail_column', 5 );

function tcb_add_post_thumbnail_column( $cols ){
	$cols['tcb_post_thumb'] = __( 'Main image' );
	return $cols;
}

add_action( 'manage_posts_custom_column', 'tcb_display_post_thumbnail_column', 5, 2 );
add_action( 'manage_pages_custom_column', 'tcb_display_post_thumbnail_column', 5, 2 );

function tcb_display_post_thumbnail_column( $col, $id ){
	switch( $col ){
		case 'tcb_post_thumb':
		if( function_exists( 'the_post_thumbnail' ) )
		echo the_post_thumbnail( 'thumbnail' );
		else
		echo 'Not supported in theme';
		break;
	}
}

// Allow svg upload in media
function cc_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

// limit_excerpt
// <?php echo wp_trim_words( get_the_content(), 15, '...' );
