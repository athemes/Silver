<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Silver
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function silver_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'silver_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function silver_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'silver_pingback_header' );

/**
 * Excerpt length
 */
function silver_excerpt_length( $length ) {
    
    if ( is_admin() ) {
        return $length;
    }

    $excerpt = get_theme_mod('exc_length', '12');
    return intval( $excerpt );
}
add_filter( 'excerpt_length', 'silver_excerpt_length', 21 );

/**
 * Blog layout
 */
function silver_blog_layout() {
	
	$layout = get_theme_mod( 'blog_layout', 'default' );

	$structure = array();

	$structure[] = $layout;
	
	if ( $layout == 'twocolsid' || $layout == 'onecolsid' ) {
		$structure[] = 'col-md-8';
	} else {
		$structure[] = 'col-md-12';
	}

	return $structure;
}
