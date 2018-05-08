<?php
/**
 * LaunchPad is a weird theme... I'm sorry
 * This file fixes a lot of weirdness so you can simply get rolling with your child theme
 */

/**
 * Ensure that parent template views load automatically
 * @param    string     $dir  views directory path
 * @return   string
 * @since    1.0.0
 * @version  1.0.0
 */
function lp_child_views_dir( $dir ) {
	return str_replace( get_stylesheet_directory(), get_template_directory(), $dir );
}
add_filter( 'launchpad_views_directory', 'lp_child_views_dir', 10, 1 );

/**
 * Allow templates added to resources/views to override default LP views
 * @param    string     $template  full template path
 * @param    string     $name      file name
 * @param    string     $path      path without file name
 * @return   string
 * @since    1.1.0
 * @version  1.1.0
 */
function lp_child_locate_template( $template, $name, $path ) {

	$override = str_replace( get_template_directory(), get_stylesheet_directory(), $template );
	if ( file_exists( $override ) ) {
		return $override;
	}

	return $template;
}
add_filter( 'launchpad_locate_template', 'lp_child_locate_template', 10, 3 );

/**
 * Automatically load parent styles as dependencies to child theme stylesheets
 * @param    array     $styles  default stylesheet dependencies
 * @return   array
 * @since    1.0.0
 * @version  1.0.0
 */
function lp_child_styles( $styles ) {
	if ( ! is_admin() ) {
		$styles[] = array( 'lp-parent-style', get_template_directory_uri() . '/assets/public/css/style.css', );
	} else {
		$styles[] = array( 'lp-parent-admin-style', get_template_directory_uri() . '/assets/admin/css/admin.css', );
	}
	return $styles;
}
add_filter( 'launchpad_stylesheet_dependencies', 'lp_child_styles' );

/**
 * Automatically load parent styles as dependencies to child theme stylesheets
 * @param    array     $styles  default stylesheet dependencies
 * @return   array
 * @since    1.0.0
 * @version  1.0.0
 */
function lp_child_scripts( $scripts ) {
	$suffix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '' : '.min';
	$scripts[] = array( 'launchpad', get_template_directory_uri() . '/js/wp-launchpad' . $suffix . '.js', array('jquery') );
    return $scripts;
}
add_filter( 'launchpad_javascript_dependencies', 'lp_child_scripts' );

/**
 * Ensure images load properly on admin settings screen
 * @param    array     $options  Layout options data
 * @return   array
 * @since    1.0.0
 * @version  1.0.0
 */
function lp_child_layout_options( $options ) {
	foreach ( $options as $key => &$val ) {
		$val = str_replace( get_stylesheet_directory_uri(), get_template_directory_uri(), $val );
	}
	return $options;
}
add_filter( 'launchpad_layout_options', 'lp_child_layout_options' );
