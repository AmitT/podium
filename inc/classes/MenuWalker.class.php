<?php

class TopBarWalker extends Walker_Nav_Menu
{
    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        // https://developer.wordpress.org/reference/classes/walker_nav_menu/end_el/
        return;
    }
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        // https://developer.wordpress.org/reference/classes/walker_nav_menu/end_lvl/
        return;
    }
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        // https://developer.wordpress.org/reference/classes/walker_nav_menu/start_el/
        return;
    }
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        // https://developer.wordpress.org/reference/classes/walker_nav_menu/start_lvl/
        return;
    }
}
