<?php

/**
 * @package WP Smush
 * @subpackage NextGen Gallery
 * @version 1.0
 *
 * @author Umesh Kumar <umesh@incsub.com>
 *
 * @copyright (c) 2016, Incsub (http://incsub.com)
 */
if ( ! class_exists( 'WpSmushNextGen' ) ) {


	class WpSmushNextGen {

		/**
		 * @var array Contains the total Stats, for displaying it on bulk page
		 */
		var $stats = array();

		var $is_nextgen_active = false;

		function __construct() {
			global $WpSmush;

			//Auto Smush image, if enabled, runs after Nextgen is finished uploading the image
			//Allows to override whether to auto smush nextgen image or not
			if ( $auto_smush = apply_filters( 'smush_nextgen_auto', $WpSmush->is_auto_smush_enabled() ) ) {
				add_action( 'ngg_added_new_image', array( &$this, 'auto_smush' ) );
			}

			//Single Smush/Manual Smush: Handles the Single/Manual smush request for Nextgen Gallery
			add_action( 'wp_ajax_smush_manual_nextgen', array( $this, 'manual_nextgen' ) );

			//Restore Image: Handles the single/Manual restore image request for NextGen Gallery
			add_action( 'wp_ajax_smush_restore_nextgen_image', array( $this, 'restore_image' ) );

			//Resmush Image: Handles the single/Manual resmush image request for NextGen Gallery
			add_action( 'wp_ajax_smush_resmush_nextgen_image', array( $this, 'resmush_image' ) );

		}

		/**
		 * Queries Nextgen table for a list of image ids
		 * @return mixed Array of ids
		 */
		function get_nextgen_attachments() {
			global $wpdb;

			//Query images from the nextgen table
			$images = $wpdb->get_col( "SELECT pid FROM $wpdb->nggpictures ORDER BY pid ASC" );

			//Return empty array, if there was error querying the images
			if ( empty( $images ) || is_wp_error( $images ) ) {
				$images = array();
			}

			return $images;
		}

		/**
		 * Get the NextGen Image object from attachment id
		 *
		 * @param $pid
		 *
		 * @return mixed
		 */
		function get_nextgen_image_from_id( $pid ) {

			// Registry Object for NextGen Gallery
			$registry = C_Component_Registry::get_instance();

			//Gallery Storage Object
			$storage = $registry->get_utility( 'I_Gallery_Storage' );

			$image = $storage->object->_image_mapper->find( $pid );

			return $image;
		}

		/**
		 * Get the NextGen attachment id from image object
		 *
		 * @param $image
		 *
		 * @return mixed
		 */
		function get_nextgen_id_from_image( $image ) {

			// Registry Object for NextGen Gallery
			$registry = C_Component_Registry::get_instance();

			//Gallery Storage Object
			$storage = $registry->get_utility( 'I_Gallery_Storage' );

			$pid = $storage->object->_get_image_id( $image );

			return $pid;
		}

		/**
		 * Get image mime type
		 *
		 * @param $file_path
		 *
		 * @return bool|string
		 */
		function get_file_type( $file_path ) {
			if ( empty( $file_path ) || !file_exists( $file_path ) ) {
				return false;
			}
			if ( function_exists( 'exif_imagetype' ) ) {
				$image_type = exif_imagetype( $file_path );
				if ( ! empty( $image_type ) ) {
					$image_mime = image_type_to_mime_type( $image_type );
				}
			} else {
				$image_details = getimagesize( $file_path );
				$image_mime    = ! empty( $image_details ) && is_array( $image_details ) ? $image_details['mime'] : '';
			}

			return $image_mime;
		}

		/**
		 * Read the image paths from an attachment's meta data and process each image
		 * with wp_smushit().
		 *
		 * This method also adds a `wp_smushit` meta key for use in the media library.
		 * Called after `wp_generate_attachment_metadata` is completed.
		 *
		 * @param $meta
		 * @param null $ID
		 *
		 * @return mixed
		 */
		function resize_from_meta_data( $image ) {
			global $WpSmush;

			$errors = new WP_Error();
			$stats  = array(
				"stats" => array_merge( $WpSmush->_get_size_signature(), array(
						'api_version' => - 1,
						'lossy'       => - 1
					)
				),
				'sizes' => array()
			);

			$size_before = $size_after = $compression = $total_time = $bytes_saved = 0;

			// Registry Object for NextGen Gallery
			$registry = C_Component_Registry::get_instance();

			//Gallery Storage Object
			$storage = $registry->get_utility( 'I_Gallery_Storage' );

			//File path and URL for original image
			// get an array of sizes available for the $image
			$sizes = $storage->get_image_sizes();

			// If images has other registered size, smush them first
			if ( ! empty( $sizes ) ) {

				if ( class_exists( 'finfo' ) ) {
					$finfo = new finfo( FILEINFO_MIME_TYPE );
				} else {
					$finfo = false;
				}

				foreach ( $sizes as $size ) {

					//Skip Full size, if smush original is not checked
					if( 'full' == $size && !$WpSmush->smush_original ) {
						continue;
					}

					// We take the original image. Get the absolute path using the storage object
					$attachment_file_path_size = $storage->get_image_abspath( $image, $size );

					if ( $finfo ) {
						$ext = file_exists( $attachment_file_path_size ) ? $finfo->file( $attachment_file_path_size ) : '';
					} elseif ( function_exists( 'mime_content_type' ) ) {
						$ext = mime_content_type( $attachment_file_path_size );
					} else {
						$ext = false;
					}
					if ( $ext ) {
						$valid_mime = array_search(
							$ext,
							array(
								'jpg' => 'image/jpeg',
								'png' => 'image/png',
								'gif' => 'image/gif',
							),
							true
						);
						if ( false === $valid_mime ) {
							continue;
						}
					}
					/**
					 * Allows to skip a image from smushing
					 *
					 * @param bool , Smush image or not
					 * @$size string, Size of image being smushed
					 */
					$smush_image = apply_filters( 'wp_smush_nextgen_image', true, $size );
					if ( ! $smush_image ) {
						continue;
					}
					//Store details for each size key
					$response = $WpSmush->do_smushit( $attachment_file_path_size, $image->pid, 'nextgen' );

					if ( is_wp_error( $response ) ) {
						return $response;
					}

					//If there are no stats
					if( empty( $response['data'] ) ) {
						continue;
					}

					//If the image size grew after smushing, skip it
					if( $response['data']->after_size > $response['data']->before_size ) {
						continue;
					}

					$stats['sizes'][ $size ] = (object) $WpSmush->_array_fill_placeholders( $WpSmush->_get_size_signature(), (array) $response['data'] );

					//Total Stats, store all data in bytes
					list( $size_before, $size_after, $total_time, $compression, $bytes_saved )
						= $WpSmush->_update_stats_data( $response['data'], $size_before, $size_after, $total_time, $bytes_saved );

					if ( empty( $stats['stats']['api_version'] ) || $stats['stats']['api_version'] == - 1 ) {
						$stats['stats']['api_version'] = $response['data']->api_version;
						$stats['stats']['lossy']       = $response['data']->lossy;
						$stats['stats']['keep_exif']   = !empty( $response['data']->keep_exif ) ? $response['data']->keep_exif : 0;
					}
				}
			}

			$has_errors = (bool) count( $errors->get_error_messages() );

			list( $stats['stats']['size_before'], $stats['stats']['size_after'], $stats['stats']['time'], $stats['stats']['percent'], $stats['stats']['bytes'] ) =
				array( $size_before, $size_after, $total_time, $compression, $bytes_saved );

			//Set smush status for all the images, store it in wp-smpro-smush-data
			if ( ! $has_errors ) {

				$existing_stats = ( ! empty( $image->meta_data ) && ! empty( $image->meta_data['wp_smush'] ) ) ? $image->meta_data['wp_smush'] : '';

				if ( ! empty( $existing_stats ) ) {
					$e_size_before = !empty( $existing_stats['stats']['size_before'] ) ? $existing_stats['stats']['size_before'] : '';
					$e_size_after = isset( $existing_stats['stats']['size_after'] ) ? $existing_stats['stats']['size_after'] : '';

					//Store Original size before
					$stats['stats']['size_before'] = ( !empty($e_size_before ) && $e_size_before > $stats['stats']['size_before'] ) ? $e_size_before : $stats['stats']['size_before'];

					if ( $size_after == 0 || empty( $stats['stats']['size_after'] ) || $stats['stats']['size_after'] == $stats['stats']['size_before'] ) {
						$stats['stats']['size_after'] = $e_size_after < $stats['stats']['size_before'] ? $e_size_after : $stats['stats']['size_before'];
					}

					//Update total bytes saved, and compression percent
					$stats['stats']['bytes']   = isset( $existing_stats['stats']['bytes'] ) ? $existing_stats['stats']['bytes'] + $stats['stats']['bytes'] : $stats['stats']['bytes'];

					$stats['stats']['percent'] = $WpSmush->calculate_percentage( (object) $stats['stats'], (object) $existing_stats['stats'] );

					//Update stats for each size
					if ( ! empty( $existing_stats['sizes'] ) && ! empty( $stats['sizes'] ) ) {

						foreach ( $existing_stats['sizes'] as $size_name => $size_stats ) {
							//if stats for a particular size doesn't exists
							if ( empty( $stats['sizes'] ) || empty( $stats['sizes'][ $size_name ] ) ) {
								$stats = empty( $stats ) ? array() : $stats;
								if ( empty( $stats['sizes'] ) ) {
									$stats['sizes'] = array();
								}
								$stats['sizes'][ $size_name ] = $existing_stats['sizes'][ $size_name ];
							} else {
								$existing_stats_size = (object)$existing_stats['sizes'][ $size_name ];

								//store the original image size
								$stats['sizes'][ $size_name ]->size_before = ( ! empty( $existing_stats_size->size_before ) && $existing_stats_size->size_before > $stats['sizes'][ $size_name ]->size_before ) ? $existing_stats_size->size_before : $stats['sizes'][ $size_name ]->size_before;

								//Update compression percent and bytes saved for each size
								$stats['sizes'][ $size_name ]->bytes   = $stats['sizes'][ $size_name ]->bytes + $existing_stats_size->bytes;
								//Calculate percentage
								$stats['sizes'][ $size_name ]->percent = $WpSmush->calculate_percentage( $stats['sizes'][ $size_name ], $existing_stats_size );
							}
						}
					}
				}
				//If there was any compression and there was no error in smushing
				if( isset( $stats['stats']['bytes'] ) && $stats['stats']['bytes'] >= 0 && !$has_errors ) {
					/**
					 * Runs if the image smushing was successful
					 *
					 * @param int    $ID   Image Id
					 *
					 * @param array $stats Smush Stats for the image
					 *
					 */
					do_action('wp_smush_image_optimised_nextgen', $image->pid, $stats );
				}
				$image->meta_data['wp_smush'] = $stats;
				nggdb::update_image_meta( $image->pid, $image->meta_data );

				//Allows To get the stats for each image, after the image is smushed
				do_action( 'wp_smush_nextgen_image_stats', $image->pid, $stats );
			}

			return $image->meta_data['wp_smush'];
		}

		/**
		 * Performs the actual smush process
		 *
		 * @usedby: `manual_nextgen`, `auto_smush`, `smush_bulk`
		 *
		 * @param string $pid , NextGen Gallery Image id
		 * @param string $image , Nextgen gallery image object
		 * @param bool|true $echo , Whether to echo the stats or not, false for auto smush
		 */
		function smush_image( $pid = '', $image = '', $echo = true ) {
			global $wpsmushnextgenstats;

			//Get image, if we have image id
			if ( ! empty( $pid ) ) {
				$image = $this->get_nextgen_image_from_id( $pid );
			} elseif ( ! empty( $image ) ) {
				$pid = $this->get_nextgen_id_from_image( $image );
			}

			$metadata = ! empty( $image ) ? $image->meta_data : '';

			if ( empty( $metadata ) ) {
				wp_send_json_error( array( 'error_msg' => '<p class="wp-smush-error-message">' . esc_html__( "We couldn't find the metadata for the image, possibly the image has been deleted.", "wp-smushit" ) . '</p>' ) );
			}

			//smush the main image and its sizes
			$smush = $this->resize_from_meta_data( $image );

			if ( ! is_wp_error( $smush ) ) {
				$status = $wpsmushnextgenstats->show_stats( $pid, $smush, false, true );
			}

			//If we are suppose to send the stats, not required for auto smush
			if ( $echo ) {
				/** Send stats **/
				if ( is_wp_error( $smush ) ) {
					/**
					 * @param WP_Error $smush
					 */
					wp_send_json_error( $smush->get_error_message() );
				} else {
					wp_send_json_success( $status );
				}
			} else {
				if ( is_wp_error( $smush ) ) {
					return $smush;
				} else {
					return $status;
				}
			}
		}

		/**
		 * Handles the smushing of each image and its registered sizes
		 * Calls the function to update the compression stats
		 */
		function manual_nextgen() {
			$pid   = ! empty( $_GET['attachment_id'] ) ? absint( (int) $_GET['attachment_id'] ) : '';
			$nonce = ! empty( $_GET['_nonce'] ) ? $_GET['_nonce'] : '';

			//Verify Nonce
			if ( ! wp_verify_nonce( $nonce, 'wp_smush_nextgen' ) ) {
				wp_send_json_error( array( 'error' => 'nonce_verification_failed' ) );
			}

			//Check for media upload permission
			if ( ! current_user_can( 'upload_files' ) ) {
				wp_die( __( "You don't have permission to work with uploaded files.", 'wp-smushit' ) );
			}

			if ( empty( $pid ) ) {
				wp_die( __( 'No attachment ID was provided.', 'wp-smushit' ) );
			}

			$this->smush_image( $pid, '' );

		}

		/**
		 * Process auto smush request for nextgen gallery images
		 *
		 * @param $image
		 */
		function auto_smush( $image ) {

			$this->smush_image( '', $image, false );

		}

		/**
		 * Checks for file backup, if available for any of the size,
		 * Function returns true
		 *
		 * @param $pid
		 * @param $attachment_data
		 *
		 * @return bool
		 */
		function show_restore_option( $pid, $attachment_data ) {
			global $WpSmush;

			// Registry Object for NextGen Gallery
			$registry = C_Component_Registry::get_instance();

			//Gallery Storage Object
			$storage = $registry->get_utility( 'I_Gallery_Storage' );

			$image = $storage->object->_image_mapper->find( $pid );

			//Get image full path
			$attachment_file_path = $storage->get_image_abspath( $image, 'full' );

			//Get the backup path
			$backup_path = $WpSmush->get_image_backup_path( $attachment_file_path );

			//If one of the backup(Ours/NextGen) exists, show restore option
			if ( file_exists( $backup_path ) || file_exists( $attachment_file_path . '_backup' ) ) {
				return true;
			}

			//Get Sizes, and check for backup
			if ( empty( $attachment_data['sizes'] ) ) {
				return false;
			}
			foreach ( $attachment_data['sizes'] as $size => $size_data ) {
				if ( 'full' == $size ) {
					continue;
				}
				//Get file path
				$attachment_size_file_path = $storage->get_image_abspath( $image, $size );

				//Get the backup path
				$backup_path = $WpSmush->get_image_backup_path( $attachment_size_file_path );

				//If one of the backup(Ours/NextGen) exists, show restore option
				if ( file_exists( $backup_path ) || file_exists( $attachment_size_file_path . '_backup' ) ) {
					return true;
				}
			}

		}

		/**
		 * Handles the ajax request to restore a image from backup and return button HTML
		 *
		 * @uses WpSmushNextGenAdmin::wp_smush_column_options()
		 */
		function restore_image() {
			global $WpSmush, $wpsmushnextgenadmin;

			//Check Empty fields
			if ( empty( $_POST['attachment_id'] ) || empty( $_POST['_nonce'] ) ) {
				wp_send_json_error( array(
					'error'   => 'empty_fields',
					'message' => esc_html__( "Error in processing restore action, Fields empty.", "wp-smushit" )
				) );
			}
			//Check Nonce
			if ( ! wp_verify_nonce( $_POST['_nonce'], "wp-smush-restore-" . $_POST['attachment_id'] ) ) {
				wp_send_json_error( array(
					'error'   => 'empty_fields',
					'message' => esc_html__( "Image not restored, Nonce verification failed.", "wp-smushit" )
				) );
			}

			//Store the restore success/failure for all the sizes
			$restored = array();

			// Registry Object for NextGen Gallery
			$registry = C_Component_Registry::get_instance();

			//Gallery Storage Object
			$storage = $registry->get_utility( 'I_Gallery_Storage' );

			//Process Now
			$image_id = absint( (int) $_POST['attachment_id'] );

			//Get the absolute path for original image
			$image = $this->get_nextgen_image_from_id( $image_id );

			//Get image full path
			$attachment_file_path = $storage->get_image_abspath( $image, 'full' );

			//Get the backup path
			$backup_path = $WpSmush->get_image_backup_path( $attachment_file_path );

			//Restoring the full image
			//If file exists, corresponding to our backup path
			if ( file_exists( $backup_path ) ) {
				//Restore
				$restored[] = @copy( $backup_path, $attachment_file_path );

				//Delete the backup
				@unlink( $backup_path );
			} elseif ( file_exists( $attachment_file_path . '_backup' ) ) {
				//Restore from other backups
				$restored[] = @copy( $attachment_file_path . '_backup', $attachment_file_path );
			}
			//Restoring the other sizes
			$attachment_data = !empty( $image->meta_data['wp_smush'] ) ? $image->meta_data['wp_smush'] : '';
			if( !empty( $attachment_data['sizes'] ) ) {
				foreach ( $attachment_data['sizes'] as $size => $size_data ) {
					if ( 'full' == $size ) {
						continue;
					}
					//Get file path
					$attachment_size_file_path = $storage->get_image_abspath( $image, $size );

					//Get the backup path
					$backup_path = $WpSmush->get_image_backup_path( $attachment_size_file_path );

					//If file exists, corresponding to our backup path
					if ( file_exists( $backup_path ) ) {
						//Restore
						$restored[] = @copy( $backup_path, $attachment_size_file_path );

						//Delete the backup
						@unlink( $backup_path );
					} elseif ( file_exists( $attachment_size_file_path . '_backup' ) ) {
						//Restore from other backups
						$restored[] = @copy( $attachment_size_file_path . '_backup', $attachment_size_file_path );
					}
				}
			}
			//If any of the image is restored, we count it as success
			if ( in_array( true, $restored ) ) {

				//Remove the Meta, And send json success
				$image->meta_data['wp_smush'] = '';
				nggdb::update_image_meta( $image->pid, $image->meta_data );

				//Get the Button html without wrapper
				$button_html = $wpsmushnextgenadmin->wp_smush_column_options( '', $image_id, false );

				wp_send_json_success( array('button' => $button_html ) );
			}
			wp_send_json_error( array( 'message' => '<div class="wp-smush-error">' . __( "Unable to restore image", "wp-smushit" ) . '</div>' ) );
		}

		/**
		 * Handles the Ajax request to resmush a image, if the full image wasn't smushed earlier
		 */
		function resmush_image() {
			//Check Empty fields
			if ( empty( $_POST['attachment_id'] ) || empty( $_POST['_nonce'] ) ) {
				wp_send_json_error( array(
					'error'   => 'empty_fields',
					'message' => '<div class="wp-smush-error">' . esc_html__( "We couldn't process the image, fields empty.", "wp-smushit" ) . '</div>'
				) );
			}
			//Check Nonce
			if ( ! wp_verify_nonce( $_POST['_nonce'], "wp-smush-resmush-" . $_POST['attachment_id'] ) ) {
				wp_send_json_error( array(
					'error'   => 'empty_fields',
					'message' => '<div class="wp-smush-error">' . esc_html__( "Image couldn't be smushed as the nonce verification failed, try reloading the page.", "wp-smushit" ) . '</div>'
				) );
			}

			$image_id = intval( $_POST['attachment_id'] );

			$smushed = $this->smush_image( $image_id, '', false );

			//If any of the image is restored, we count it as success
			if ( ! empty( $smushed ) && !is_wp_error( $smushed ) ) {

				//Send button content
				wp_send_json_success( array( 'button' => $smushed['status'] . $smushed['stats'] ) );

			} elseif ( is_wp_error( $smushed ) ) {

				//Send Error Message
				wp_send_json_error( array( 'message' => sprintf( '<div class="wp-smush-error">' . __( "Unable to smush image, %s", "wp-smushit" ) . '</div>', $smushed->get_error_message() ) ) );

			}
		}

	}//End of Class
}//End Of if class not exists

//Extend NextGen Mixin class to smush dynamic images
if ( class_exists( 'WpSmushNextGen' ) ) {
	global $WpSmush;
	$wpsmushnextgen = new WpSmushNextGen();

	//Extend Nextgen Mixin class and override the generate_image_size, to optimize dynamic thumbnails, generated by nextgen, check for auto smush
	if ( ! class_exists( 'WpSmushNextGenDynamicThumbs' ) && class_exists( 'Mixin' ) && $WpSmush->is_auto_smush_enabled() ) {

		class WpSmushNextGenDynamicThumbs extends Mixin {

			/**
			 * Overrides the NextGen Gallery function, to smush the dynamic images and thumbnails created by gallery
			 *
			 * @param C_Image|int|stdClass $image
			 * @param $size
			 * @param null $params
			 * @param bool|false $skip_defaults
			 *
			 * @return bool|object
			 */
			function generate_image_size( $image, $size, $params = null, $skip_defaults = false ) {
				global $WpSmush;
				$image_id = ! empty( $image->pid ) ? $image->pid : '';
				//Get image from storage object if we don't have it already
				if ( empty( $image_id ) ) {
					//Get metadata For the image
					// Registry Object for NextGen Gallery
					$registry = C_Component_Registry::get_instance();

					//Gallery Storage Object
					$storage = $registry->get_utility( 'I_Gallery_Storage' );

					$image_id = $storage->object->_get_image_id( $image );
				}
				//Call the actual function to generate the image, and pass the image to smush
				$success = $this->call_parent( 'generate_image_size', $image, $size, $params, $skip_defaults );
				if ( $success ) {
					$filename = $success->fileName;
					//Smush it, if it exists
					if ( file_exists( $filename ) ) {
						$response = $WpSmush->do_smushit( $filename, $image_id, 'nextgen' );

						//If the image was smushed
						if ( ! is_wp_error( $response ) && ! empty( $response['data'] ) && $response['data']->bytes_saved > 0 ) {
							//Check for existing stats
							if ( ! empty( $image->meta_data ) && ! empty( $image->meta_data['wp_smush'] ) ) {
								$stats = $image->meta_data['wp_smush'];
							} else {
								//Initialize stats array
								$stats                = array(
									"stats" => array_merge( $WpSmush->_get_size_signature(), array(
											'api_version' => - 1,
											'lossy'       => - 1,
											'keep_exif'   => false
										)
									),
									'sizes' => array()
								);
								$stats['bytes']       = $response['data']->bytes_saved;
								$stats['percent']     = $response['data']->compression;
								$stats['size_after']  = $response['data']->after_size;
								$stats['size_before'] = $response['data']->before_size;
								$stats['time']        = $response['data']->time;
							}
							$stats['sizes'][ $size ]      = (object) $WpSmush->_array_fill_placeholders( $WpSmush->_get_size_signature(), (array) $response['data'] );

							if ( isset( $image->metadata ) ) {
								$image->meta_data['wp_smush'] = $stats;
								nggdb::update_image_meta( $image->pid, $image->meta_data );
							}

							//Allows To get the stats for each image, after the image is smushed
							do_action( 'wp_smush_nextgen_image_stats', $image_id, $stats );
						}
					}
				}

				return $success;
			}
		}
	}
}
if ( class_exists('WpSmushNextGenDynamicThumbs') ) {
	if(! get_option('ngg_options') ) {
		return;
	}
	$storage = C_Gallery_Storage::get_instance();
	$storage->get_wrapped_instance()->add_mixin( 'WpSmushNextGenDynamicThumbs' );
}