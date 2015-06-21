<?php
namespace Podium\Config;

class PodiumCoreProperties{
	
	function __construct() {
		$this->templateUrl = $this->getTemplateURL(); // set property so that we can access it from child class
	}
	private function getTemplateURL() {
		return basename( get_page_template() ); // get the template file url ( example: test.php )
	}
	
}

class Settings extends PodiumCoreProperties {
	
	// make chnages to this method
	private function excludedSidebarSettings() {
		
		// Sidebars will be displayed by default. to explode some pages change these settings
		
		$excludedRules = array();
		
		// Add to this list to remove the sidebar from template files.
		$excludedRules['excludeByFileName'] = [
			//'test.php',
			'page.php',
		];
		
		// Add to this list to remove the sidebar by post type.
		$excludedRules['excludeByPostByType'] = [
			//'page',
			// 'cart',
		];
		
		// Add to this list to remove the sidebar by taxonomy ID.
		$excludedRules['excludeByTaxonomyID'] = [
			// '43',
			// '1234',
		];
		
		// Add to this list to remove the sidebar from pages by ID.
		// note: NOT recommended to use this feature. Use only if you have no choice.
		//       however you can add dynamic functionality to this file.
		$excludedRules['excludeByPostID'] = [
			// '2',
			// '256',
			// '823',
		];
		
		// Add to this list to remove the sidebar from categories by ID.
		// note: NOT recommended to use this feature. Use only if you have no choice. 
		//       however you can add dynamic functionality to this file.
		$excludedRules['excludeByCategoryID'] = [
			// '3',
			// '5',
			// '12',
		];

		return $excludedRules;
	}
	public function displaySidebar() { // return bool
	
		$rules = $this->excludedSidebarSettings(); // get rules from private function
		$postType = get_post_type( $post );
		$taxonomyID = get_queried_object()->term_id;
		$postID = get_the_ID();
		echo "<pre>";
		var_dump( get_post($postID) );
		echo "</pre>";
		echo get_post_name();
		the_slug();
		die;
		$categoryID = '';
		// echo "<pre>";
		// var_dump( get_post($postID) );
		// echo "</pre>";

		
		//die(the_slug());
		
		$catID = the_category_ID();
		
		if( in_array($this->templateUrl, $rules['excludeByFileName']) ){ // if the current template has been excluded
			return false;
		} elseif( in_array($postType, $rules['excludeByPostByType']) ){
			return false;
		} elseif( in_array($taxonomyID, $rules['excludeByTaxonomyID']) ){
			return false;
		} elseif( in_array($postID, $rules['excludeByPostID']) ){
			return false;
		}  elseif( in_array($postID, $rules['excludeByPostID']) ){
			return false;
		} 
		else {
			//return '1';
		}
		
		echo "<pre>";
		print_r( $rules );
		echo "</pre>";
		die;
		
	}
	
}
