<?php
/**
 * @package Silver
 */

//Dynamic styles
function silver_custom_styles($custom) {

	$custom = '';


	//Blog layout
	$layout = get_theme_mod( 'blog_layout', 'default' );
	
	switch ( $layout ) {
	    case 'twocols':
	    case 'twocolsid':
			$custom .= ".posts-loop .hentry,.posts-loop .loop-banner { width: 50%;}"."\n";
	        break;
	    case 'onecol':
	    case 'onecolsid':
			$custom .= ".posts-loop .hentry,.posts-loop .loop-banner { width: 100%;}"."\n";
	        break;
	}


	//Output all the styles
	wp_add_inline_style( 'silver-style', $custom );	
}
add_action( 'wp_enqueue_scripts', 'silver_custom_styles' );