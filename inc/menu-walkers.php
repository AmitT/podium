<?php

// Oenu walker for top bar
/**
 * @param $element
 * @param $children_elements
 * @param $max_depth
 * @param $depth
 * @param $args
 * @param $output
 */
final class Top_Bar_Walker extends Walker_Nav_Menu
{
    /**
     * @param $element
     * @param $children_elements
     * @param $max_depth
     * @param $depth
     * @param $args
     * @param $output
     */
    public function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
    {
        $element->has_children = !empty($children_elements[$element->ID]);
        $element->classes[]    = ($element->current || $element->current_item_ancestor) ? 'active' : '';
        $element->classes[]    = ($element->has_children && 1 !== $max_depth) ? 'has-submenu' : '';
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    /**
     * @param $output
     * @param $object
     * @param $depth
     * @param array                $args
     * @param $current_object_id
     */
    public function start_el(&$output, $object, $depth = 0, $args = [], $current_object_id = 0)
    {
        $item_html = '';
        parent::start_el($item_html, $object, $depth, $args);
        //$output .= ( 0 == $depth ) ? '<li class="divider"></li>' : '';
        $classes = empty($object->classes) ? [] : (array) $object->classes;

        if (in_array('label', $classes)) {

            //$output .= '<li class="divider"></li>';
            $item_html = preg_replace('/<a[^>]*>(.*)<\/a>/iU', '<label>$1</label>', $item_html);

        }

        if (in_array('divider', $classes)) {

            $item_html = preg_replace('/<a[^>]*>( .* )<\/a>/iU', '', $item_html);

        }

        $output .= $item_html;
    }

    /**
     * @param $output
     * @param $depth
     * @param array     $args
     */
    public function start_lvl(&$output, $depth = 0, $args = [])
    {
        $output .= "\n<ul class=\"submenu menu vertical\">\n";
    }

}

// Offcanvas menu walker
/**
 * @param $element
 * @param $children_elements
 * @param $max_depth
 * @param $depth
 * @param $args
 * @param $output
 */
final class Offcanvas_Walker extends Walker_Nav_Menu
{
                                                             /**
     * @param $element
     * @param $children_elements
     * @param $max_depth
     * @param $depth
     * @param $args
     * @param $output
     */
    public function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
    {
        $element->has_children = !empty($children_elements[$element->ID]);
        $element->classes[]    = ($element->current || $element->current_item_ancestor) ? 'active' : '';
        $element->classes[]    = ($element->has_children && 1 !== $max_depth) ? 'has-submenu' : '';
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    /**
     * @param $output
     * @param $object
     * @param $depth
     * @param array                $args
     * @param $current_object_id
     */
    public function start_el(&$output, $object, $depth = 0, $args = [], $current_object_id = 0)
    {
        $item_html = '';
        parent::start_el($item_html, $object, $depth, $args);
        $classes = empty($object->classes) ? [] : (array) $object->classes;

        if (in_array('label', $classes)) {

            $item_html = preg_replace('/<a[^>]*>(.*)<\/a>/iU', '<label>$1</label>', $item_html);

        }

        $output .= $item_html;
    }

    /**
     * @param $output
     * @param $depth
     * @param array     $args
     */
    public function start_lvl(&$output, $depth = 0, $args = [])
    {
        $output .= "\n<ul class=\"left-submenu\">\n<li class=\"back\"><a href=\"#\">" . __('Back', 'podium') . "</a></li>\n";
    }

}
