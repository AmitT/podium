<?php
namespace Podium\Config;

class PodiumCoreProperties
{
    /**
     * @var mixed
     */
    private $templateUrl;

    public function __construct()
    {
        $this->templateUrl = $this->getTemplateURL(); // set property so that we can access it from child class
    }

    private function getTemplateURL()
    {
        return basename(get_page_template()); // get the template file url ( example: test.php )
    }
}

class Settings extends PodiumCoreProperties
{
    public function displaySidebar()
    {
        // return bool

        $rules    = $this->excludedSidebarSettings(); // get rules from private function
        $postType = get_post_type();
        $postID   = get_the_ID();

        foreach (get_the_category() as $category) {
            $taxonomyID = $category->term_id;
            $categoryID = $category->cat_ID;
            break;
        }

        if (in_array($this->templateUrl, $rules['excludeByFileName'], true)) {
            // if the current template has been excluded
            return false;
        } elseif (isset($postType) && in_array($postType, $rules['excludeByPostByType'], true)) {
            return false;
        } elseif (isset($taxonomyID) && in_array($taxonomyID, $rules['excludeByTaxonomyID'], true)) {
            return false;
        } elseif (isset($postID) && in_array($postID, $rules['excludeByPostID'], true)) {
            return false;
        } elseif (isset($categoryID) && in_array($categoryID, $rules['excludeByCategoryID'], true)) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * @param  $contentHasSidebarClass
     * @param  $contentNoSidebarClass
     * @return string
     */
    public function getContentClass($contentHasSidebarClass = 'medium-8', $contentNoSidebarClass = 'medium-12')
    {
// return bool

        if ($this->displaySidebar()) {
            return $contentHasSidebarClass;
        } else {
            return $contentNoSidebarClass;
        }

    }

    /**
     * @param $walker_object
     * @param $canvas
     */
    public function getMenu($walker_object, $canvas = 'onCanvass')
    {
        if (has_nav_menu('main-nav')) {
// check if menu exists
            if ('onCanvass' == $canvas) {
                // check if the menu is off-canvas
                $onCanvas = [
                    'theme_location'  => 'main-nav',
                    'menu'            => '',
                    'container'       => false,
                    'items_wrap'      => '<ul id="%1$s" class="%2$s show-for-medium" data-dropdown-menu>%3$s</ul>',
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => 'dropdown menu',
                    'menu_id'         => '',
                    'echo'            => true,
                    'fallback_cb'     => 'wp_nav_menu',
                    'before'          => '',
                    'after'           => '',
                    'link_before'     => '',
                    'link_after'      => '',
                    'depth'           => 0,
                    'walker'          => $walker_object
                ];

                wp_nav_menu($onCanvas);

            } elseif ('offCanvas' == $canvas) {
                $offCanvas = [
                    'theme_location'  => 'main-nav',
                    'menu'            => '',
                    'container'       => '',
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => 'button-group',
                    'menu_id'         => '',
                    'echo'            => true,
                    'fallback_cb'     => 'wp_nav_menu',
                    'before'          => '',
                    'after'           => '',
                    'link_before'     => '',
                    'link_after'      => '',
                    'items_wrap'      => '<ul class="off-canvas-list %2$s" role="navigation">%3$s</ul>',
                    'depth'           => 0,
                    'walker'          => $walker_object
                ];

                wp_nav_menu($offCanvas);

            } else {
                // if no type - wrong parameter error
                echo "<div class='alert label'>error invalid canvas value use: onCanvass or offCanvas (default: 'onCanvass')</div>";
            }

        } else {
            // no menu
            echo "<div class='alert label'>Menus do not exist please create one</div>";
        }

    }

    // make chnages to this method
    /**
     * @return mixed
     */
    private function excludedSidebarSettings()
    {
        // Sidebars will be displayed by default. to explode some pages change these settings

        $excludedRules = [];

        // Add to this list to remove the sidebar from template files.
        $excludedRules['excludeByFileName'] = [

// 'test.php',
            // 'page.php',
        ];

        // Add to this list to remove the sidebar by post type.
        $excludedRules['excludeByPostByType'] = [

// 'page',
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

// 2,

// '5',
            // '12',
        ];

        return $excludedRules;
    }
}

define('WPCF7_AUTOP', false);
