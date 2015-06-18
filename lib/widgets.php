<?php
/**
 * 
 *
 * This file is centrally included from `wp-content/mu-plugins/wpcom-theme-compat.php`.
 *
 * @package podium
 */

function podium_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'podium' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
		));
	register_sidebar(array(
		'id'			=> 'offcanvas',
		'name'			=> esc_html__('Offcanvas', 'podium'),
		'description' 	=> esc_html__('The offcanvas sidebar.', 'podium'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4 class="widget-title">',
		'after_title'	=> '</h4>',
		));
}
add_action( 'widgets_init', 'podium_widgets_init' );