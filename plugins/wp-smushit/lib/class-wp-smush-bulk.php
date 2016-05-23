<?php

/**
 * @package WP SmushIt
 * @subpackage Admin
 * @version 1.0
 *
 * @author Saurabh Shukla <saurabh@incsub.com>
 * @author Umesh Kumar <umesh@incsub.com>
 *
 * @copyright (c) 2016, Incsub (http://incsub.com)
 */
if ( ! class_exists( 'WpSmushitBulk' ) ) {

	/**
	 * Methods for bulk processing
	 */
	class WpSmushitBulk {

		/**
		 * Fetch all the unsmushed attachments
		 * @return array $attachments
		 */
		function get_attachments() {
			global $wpsmushit_admin;

			if ( ! isset( $_REQUEST['ids'] ) ) {
				$limit           = apply_filters( 'wp_smush_nextgen_query_limit', 2000 );
				$limit           = intval( $limit );
				$get_posts       = true;
				$unsmushed_posts = array();
				$args            = array(
					'fields'                 => 'ids',
					'post_type'              => 'attachment',
					'post_status'            => 'any',
					'post_mime_type'         => array( 'image/jpeg', 'image/gif', 'image/png' ),
					'orderby'                => 'ID',
					'order'                  => 'DESC',
					'posts_per_page'         => $limit,
					'offset'                 => 0,
					'meta_query'             => array(
						array(
							'key'     => 'wp-smpro-smush-data',
							'compare' => 'NOT EXISTS'
						)
					),
					'update_post_term_cache' => false,
					'no_found_rows'          => true,
				);
				//Loop Over to get all the attachments
				while ( $get_posts ) {

					//Remove the Filters added by WP Media Folder
					$wpsmushit_admin->remove_wmf_filters();

					$query = new WP_Query( $args );

					if( !empty( $query->post_count ) && sizeof( $query->posts ) > 0 ) {
						//Merge the results
						$unsmushed_posts = array_merge( $unsmushed_posts, $query->posts );

						//Update the offset
						$args['offset'] += $limit;
					}else{
						//If we didn't get any posts from query, set $get_posts to false
						$get_posts = false;
					}

					//If total Count is set, and it is alread lesser than offset, don't query
					if ( ! empty( $wpsmushit_admin->total_count ) && $wpsmushit_admin->total_count < $args['offset'] ) {
						$get_posts = false;
					}
				}
			} else {
				return array_map( 'intval', explode( ',', $_REQUEST['ids'] ) );
			}

			return $unsmushed_posts;
		}

	}
}
