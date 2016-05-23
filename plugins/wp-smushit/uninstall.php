<?php
/**
 * Remove plugin settings data
 *
 * @since 1.7
 *
 */

//if uninstall not called from WordPress exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}
global $wpdb;

$smushit_keys = array(
	'auto',
	'original',
	'lossy',
	'backup',
	'nextgen',
	'keep_exif',
	'resmush-list',
	'nextgen-resmush-list',
	'super_smushed',
	'super_smushed_nextgen',
	'settings_updated',
	'skip-redirect',
	'hide_smush_welcome',
	'hide_upgrade_notice',
	'install-type',
	'lossy-updated'
);
foreach ( $smushit_keys as $key ) {
	$key = 'wp-smush-' . $key;
	if ( is_multisite() ) {
		$offset = 0;
		$limit = 100;
		while( $blogs = $wpdb->get_results( "SELECT blog_id FROM {$wpdb->blogs} LIMIT $offset, $limit", ARRAY_A ) ) {
			if ( $blogs ) {
				foreach ( $blogs as $blog ) {
					switch_to_blog( $blog['blog_id'] );
					delete_option( $key );
					delete_site_option( $key );
				}
				restore_current_blog();
			}
			$offset += $limit;
		}
	} else {
		delete_option( $key );
	}
}
//Delete Post meta
$meta_type  = 'post';
$user_id    = 0;
$meta_key   = 'wp-smpro-smush-data';
$meta_value = '';
$delete_all = true;

if ( is_multisite() ) {
	$offset = 0;
	$limit = 100;
	while( $blogs = $wpdb->get_results( "SELECT blog_id FROM {$wpdb->blogs} LIMIT $offset, $limit", ARRAY_A ) ) {
		if ( $blogs ) {
			foreach ( $blogs as $blog ) {
				switch_to_blog( $blog['blog_id'] );
				delete_metadata( $meta_type, $user_id, $meta_key, $meta_value, $delete_all );
				delete_metadata( $meta_type, $user_id, 'wp-smush-lossy', '', $delete_all );
			}
			restore_current_blog();
		}
		$offset += $limit;
	}
} else {
	delete_metadata( $meta_type, $user_id, $meta_key, $meta_value, $delete_all );
	delete_metadata( $meta_type, $user_id, 'wp-smush-lossy', '', $delete_all );
}
//@todo: Add procedure to delete backup files
?>