<?php
/**
* Custom functions that handle unicode/non-ASCII characters in filenames
* to avoid occasional server-side issues
*
* @package podium
*/

class PodiumCleanImageFilenames {
	/**
	* Plugin settings.
	*
	* @var array Plugin settings for version, default mime types.
	* @since 1.1
	*/

	public $plugin_settings = array(
		'version' 				=> '1.1',
		'default_mime_types' 	=> array(
			'image/gif',
			'image/jpeg',
			'image/pjpeg',
			'image/png',
			'image/tiff'
		)
	);


	/**
	* Sets up hooks, actions and filters that the plugin responds to.
	*
	* @since 1.0
	*/

	function __construct() {
		add_action( 'wp_handle_upload_prefilter', array($this, 'upload_filter' ));
	}


	/**
	* Checks whether or not the current file should be cleaned.
	*
	* This function runs when files are being uploaded to the WordPress media
	* library. The function checks if the clean_image_filenames_mime_types filter
	* has been used and overrides other settings if it has. Otherwise, the plugin
	* settings are used.
	*
	* If a file shall be cleaned or not is checked by comparing the current file's
	* mime type to the list of mime types to be cleaned.
	*
	* @since 1.1 Added more complex checks and moved the actual cleaning to clean_filename().
	* @since 1.0
	* @param array The file information including the filename in $file['name'].
	* @return array The file information with the cleaned or original filename.
	*/
	function upload_filter( $file ) {

		$mime_types_setting = 'all';
		$default_mime_types = $this->plugin_settings['default_mime_types'];
		$valid_mime_types = apply_filters( 'clean_image_filenames_mime_types', $default_mime_types );

		if ($valid_mime_types !== $default_mime_types) {

			if ( in_array( $file['type'], $valid_mime_types ) ) {
				$file = $this->clean_filename( $file );
			}

		} else {

			if ( 'all' == $mime_types_setting ) {
				$file = $this->clean_filename( $file );
			} elseif ( 'images' == $mime_types_setting && in_array( $file['type'], $default_mime_types ) ) {
				$file = $this->clean_filename( $file );
			}
		}

		// Return cleaned file or input file if it didn't match
		return $file;
	}


	/**
	* Performs the filename cleaning.
	*
	* This function performs the actual cleaning of the filename. It takes an
	* array with the file information, cleans the filename and sends the file
	* information back to where the function was called from.
	*
	* @since 1.1
	* @param array File details including the filename in $file['name'].
	* @return array The $file array with cleaned filename.
	*/
	function clean_filename( $file ) {

		$path = pathinfo( $file['name'] );
		$new_filename = preg_replace( '/.' . $path['extension'] . '$/', '', $file['name'] );
		$file['name'] = sanitize_title( $new_filename ) . '.' . $path['extension'];

		return $file;
	}
}
// inititnowz!
new PodiumCleanImageFilenames;
