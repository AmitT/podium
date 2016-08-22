<?php
/**
* Custom functions that act independently of the theme templates
*
* Eventually, some of the functionality here could be replaced by core features
*
* @package podium
*/

/**
* Adds custom classes to the array of body classes.
*
* @param array $classes Classes for the body element.
* @return array
*/
function podium_body_classes( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'podium_body_classes' );

// Get post Thumb URL
function get_thumb_url($post, $size = 'full'){
	if (has_post_thumbnail( $post->ID ) ){
		$attachment_id = get_post_thumbnail_id($post->ID);

		// thumbnail, medium, large, or full
		$src = wp_get_attachment_image_src( $attachment_id, $size);
		return $src[0];
	}
	return false;
}

// Image in CF7 email
function winsite_wpcf7_special_mail_tag( $output, $name, $html ) {
	$submission = WPCF7_Submission::get_instance();

	if ( ! $submission ) {
		return $output;
	}

	if ( '_post_thumbnail' == $name ) {
		$unit_tag = $submission->get_meta( 'unit_tag' );

		if ( $unit_tag && preg_match( '/^wpcf7-f(\d+)-p(\d+)-o(\d+)$/', $unit_tag, $matches ) ) {
			$post_id = absint( $matches[2] );

			if ( $post = get_post( $post_id ) ) {
				$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
				$image = wp_get_attachment_image_src( $post_thumbnail_id, 'small' );
				if ( isset( $image[0] ) ) {
					return '<img src="' . $image[0] . '" width="120" />';
				}
			}
		}
	}

	return $output;
}
add_filter( 'wpcf7_special_mail_tags', 'winsite_wpcf7_special_mail_tag', 10, 3 );
// usu in mail:
//[_post_thumbnail]

function excerpt( $limit ) {
 $excerpt = explode( ' ', get_the_excerpt(), $limit );
 if ( count( $excerpt )>=$limit ) {
   array_pop($excerpt);
   $excerpt = implode( " ",$excerpt );
 } else {
   $excerpt = implode( " ",$excerpt );
 }
 $excerpt = preg_replace( '`\[[^\]]*\]`','',$excerpt );
 return $excerpt;
}
