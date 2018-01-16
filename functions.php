<?php
/**
 * Silver functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Silver
 */

if ( ! function_exists( 'silver_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function silver_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Silver, use a find and replace
		 * to change 'silver' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'silver', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'carousel-image', 9999, 500, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'silver' ),
			'social' => esc_html__( 'Social', 'silver' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'silver_custom_background_args', array(
			'default-color' => 'f7f7f7',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 120,
			'width'       => 200,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'silver_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function silver_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'silver_content_width', 640 );
}
add_action( 'after_setup_theme', 'silver_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function silver_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'silver' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'silver' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );


	register_sidebar( array(
		'name'          => esc_html__( 'Blog archives - first position', 'silver' ),
		'id'            => 'loop-widgets-one',
		'description'   => esc_html__( 'Important: please use just one widget in this area in order to keep the design organized.', 'silver' ),
		'before_widget' => '<div id="%1$s" class="loop-banner-inner %2$s"><div>',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Blog archives - second position', 'silver' ),
		'id'            => 'loop-widgets-two',
		'description'   => esc_html__( 'Important: please use just one widget in this area in order to keep the design organized.', 'silver' ),
		'before_widget' => '<div id="%1$s" class="loop-banner-inner %2$s"><div>',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );



}
add_action( 'widgets_init', 'silver_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function silver_scripts() {
	wp_enqueue_style( 'silver-style', get_stylesheet_uri() );

	wp_enqueue_style( 'silver-fonts', '//fonts.googleapis.com/css?family=Poppins:400,400i,600,600i,800|Nunito:400,400i,600,600i', array(), null );
	
	wp_enqueue_style( 'silver-icons', get_template_directory_uri() . '/fonts/css/fontello.css' );

	wp_enqueue_script( 'silver-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'silver-scripts', get_template_directory_uri() . '/js/flickity.js', array( 'jquery' ), '20171215', true );

	wp_enqueue_script( 'silver-sticky', get_template_directory_uri() . '/js/jquery.sticky.js', array( 'jquery' ), '20171215', true );


	wp_enqueue_script( 'silver-main', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '20171215', true );

	wp_enqueue_script( 'silver-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'silver_scripts' );

/**
 * Enqueue Bootstrap
 */
function silver_enqueue_bootstrap() {
	wp_enqueue_style( 'silver-bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css', array(), true );
}
add_action( 'wp_enqueue_scripts', 'silver_enqueue_bootstrap', 9 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/header-functions.php';
require get_template_directory() . '/inc/footer-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Dynamic styles
 */
require get_template_directory() . '/inc/styles.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}