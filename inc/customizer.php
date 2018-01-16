<?php
/**
 * Silver Theme Customizer
 *
 * @package Silver
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function silver_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    $wp_customize->get_section( 'title_tagline' )->priority 	= '10';	
    $wp_customize->get_section( 'title_tagline' )->panel 		= 'silver_header';
    $wp_customize->get_section( 'colors' )->panel 				= 'silver_colors';
    $wp_customize->get_section( 'colors' )->title 				= __( 'General', 'silver');
    $wp_customize->get_section( 'colors' )->priority 			= 9;

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'silver_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'silver_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'silver_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function silver_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function silver_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Kirki
 */
require get_template_directory() . '/inc/kirki/include-kirki.php';
require get_template_directory() . '/inc/kirki/class-silver-kirki.php';

/**
 * Options
 */
Silver_Kirki::add_config( 'silver', array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'theme_mod',
) );

Silver_Kirki::add_panel( 'silver_header', array(
    'priority'    => 10,
    'title'       => __( 'Header', 'silver' ),
) );

Silver_Kirki::add_section( 'silver_header_sections', array(
    'title'       	 => __( 'Header sections', 'silver' ),
    'panel'          => 'silver_header',
    'priority'       => 9,
    'type'			 => 'expanded'
) );

Silver_Kirki::add_field( 'silver', array(
	'type'        => 'sortable',
	'settings'    => 'header_sections_order',
	'label'       => __( 'Order', 'silver' ),
    'description' => __( 'Drag and drop the sections to change the order. Click on the eye icon to enable/disable', 'silver' ),	
	'section'     => 'silver_header_sections',
	'default'     => array(
		'silver_site_identity',
		'silver_menu_bar',
		'silver_header_hero',
		'silver_featured_boxes',
	),
	'choices'     => array(
		'silver_site_identity' 	=> esc_attr__( 'Site identity', 'silver' ),
		'silver_menu_bar' 		=> esc_attr__( 'Menu bar', 'silver' ),
		'silver_header_hero' 	=> esc_attr__( 'Carousel', 'silver' ),
		'silver_featured_boxes' => esc_attr__( 'Featured boxes', 'silver' ),
	),
	'priority'    => 10,
) );

//Carousel
Silver_Kirki::add_section( 'silver_header_carousel', array(
    'title'       	 => __( 'Carousel', 'silver' ),
    'panel'          => 'silver_header',
    'priority'       => 12,
) );

if ( class_exists( 'Kirki_Helper' ) ) {
	Silver_Kirki::add_field( 'silver', array(
		'type'        => 'select',
		'settings'    => 'carousel_categories',
		'label'       => __( 'Categories', 'silver' ),
		'description' => __( 'Pick the categories from which to show posts in the carousel', 'silver' ),
		'section'     => 'silver_header_carousel',
		'default'     => '',
		'priority'    => 10,
		'multiple'    => 99,
		'choices'     => Kirki_Helper::get_terms( array('taxonomy' => 'category') ),
	) );
}

Silver_Kirki::add_field( 'silver', array(
	'type'        => 'select',
	'settings'    => 'carousel_cell_width',
	'label'       => __( 'Cell width', 'silver' ),
	'section'     => 'silver_header_carousel',
	'default'     => '50',
	'choices'     => array(
		'50' 		=> esc_attr__( '50% (one full slide in the center + two partially visible)', 'silver' ),
		'100' 		=> esc_attr__( '100% (one full slide)', 'silver' ),
		'33.33333' 	=> esc_attr__( '33.33% (three full slides)', 'silver' ),
		'25' 		=> esc_attr__( '25% (three full slides in the center + two partially visible)', 'silver' ),
	),
	'priority'    	=> 12,
	'output' => array(
		array(
			'element'  => '.header-carousel .carousel-cell',
			'property' => 'width',
			'units'	   => '%'
		),
	),

) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'number',
	'settings'    => 'carousel_speed',
	'label'       => esc_attr__( 'Carousel speed', 'silver' ),
	'section'     => 'silver_header_carousel',
	'default'     => 4000,
	'choices'     => array(
		'min'  => 1000,
		'max'  => 10000,
		'step' => 500,
	),
) );

//Featured boxes
Silver_Kirki::add_section( 'silver_featured_boxes', array(
    'title'       	 => __( 'Featured boxes', 'silver' ),
    'panel'          => 'silver_header',
    'priority'       => 13,
) );

Silver_Kirki::add_field( 'silver', array(
	'type'        => 'repeater',
	'label'       => esc_attr__( 'Featured boxes', 'silver' ),
	'section'     => 'silver_featured_boxes',
	'priority'    => 10,
	'row_label' => array(
		'type'  => 'field',
		'value' => esc_attr__('box', 'silver' ),
		'field' => 'text',
	),
	'choices' => array(
	    'limit' => 4
	),	
	'settings'    => 'featured_boxes',
	'fields' => array(
		'text' => array(
			'type'        => 'text',
			'label'       => esc_attr__( 'Box title', 'silver' ),
			'description' => esc_attr__( 'The title for this box', 'silver' ),
			'default'     => '',
		),
		'url' => array(
			'type'        => 'text',
			'label'       => esc_attr__( 'Box link', 'silver' ),
			'description' => esc_attr__( 'The link for this box', 'silver' ),
			'default'     => '',
		),
		'image' => array(
			'type'        => 'image',
			'label'       => esc_attr__( 'Image', 'silver' ),
			'description' => esc_attr__( 'A background image for this box', 'silver' ),
			'default'     => '',
		),		
	)
) );

//Logo width
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'number',
	'settings'    => 'logo_width',
	'label'       => esc_attr__( 'Logo width', 'silver' ),
	'section'     => 'title_tagline',
	'default'     => 120,
	'choices'     => array(
		'min'  => 60,
		'max'  => 600,
		'step' => 5,
	),
	'transport'	  => 'auto',
	'output' => array(
		array(
			'element'  => '.custom-logo-link',
			'property' => 'max-width',
			'units'	   => 'px'
		),
	),
) );

//Blog
Silver_Kirki::add_panel( 'silver_blog', array(
    'title'       	 => __( 'Blog options', 'silver' ),
    'priority'       => 14,
) );
Silver_Kirki::add_section( 'silver_blog_index', array(
    'title'       	 => __( 'Index&amp;archives', 'silver' ),
    'priority'       => 10,
    'panel'			 => 'silver_blog'
) );

Silver_Kirki::add_field( 'silver', array(
	'type'        => 'select',
	'settings'    => 'blog_layout',
	'label'       => __( 'Blog layout', 'silver' ),
	'section'     => 'silver_blog_index',
	'default'     => 'default',
	'choices'     => array(
		'default' 	=> esc_attr__( 'Three columns', 'silver' ),
		'twocols' 	=> esc_attr__( 'Two columns', 'silver' ),
		'onecol' 	=> esc_attr__( 'One column', 'silver' ),
		'twocolsid' => esc_attr__( 'Two columns and sidebar', 'silver' ),
		'onecolsid' => esc_attr__( 'One column and sidebar', 'silver' ),
	),
	'priority'    	=> 12,
) );


//Buttons
Silver_Kirki::add_section( 'silver_buttons', array(
    'title'       	 => __( 'Buttons', 'silver' ),
    'priority'       => 15,
) );
Silver_Kirki::add_field( 'silver', array(
	'type'     	  => 'slider',
	'settings'    => 'button_border_radius',
	'label'       => esc_attr__( 'Border radius', 'silver' ),
	'section'     => 'silver_buttons',
	'default'     => '30',
	'priority'    => 10,
	'choices'   => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.button, button, input[type="button"], input[type="reset"], input[type="submit"]',
			'property' => 'border-radius',
			'units'    => 'px',
		),
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'     	  => 'slider',
	'settings'    => 'button_padding_top_bottom',
	'label'       => esc_attr__( 'Top/bottom padding', 'silver' ),
	'section'     => 'silver_buttons',
	'default'     => '15',
	'priority'    => 10,
	'choices'   => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.button, button, input[type="button"], input[type="reset"], input[type="submit"]',
			'property' => 'padding-top',
			'units'    => 'px',
		),
		array(
			'element'  => '.button, button, input[type="button"], input[type="reset"], input[type="submit"]',
			'property' => 'padding-bottom',
			'units'    => 'px',
		),		
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'     	  => 'slider',
	'settings'    => 'button_padding_left_right',
	'label'       => esc_attr__( 'Left/right padding', 'silver' ),
	'section'     => 'silver_buttons',
	'default'     => '30',
	'priority'    => 10,
	'choices'   => array(
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	),
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.button, button, input[type="button"], input[type="reset"], input[type="submit"]',
			'property' => 'padding-left',
			'units'    => 'px',
		),
		array(
			'element'  => '.button, button, input[type="button"], input[type="reset"], input[type="submit"]',
			'property' => 'padding-right',
			'units'    => 'px',
		),		
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'     	  => 'slider',
	'settings'    => 'button_font_size',
	'label'       => esc_attr__( 'Font size', 'silver' ),
	'section'     => 'silver_buttons',
	'default'     => '13',
	'priority'    => 10,
	'choices'   => array(
		'min'  => 10,
		'max'  => 22,
		'step' => 1,
	),
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.button, button, input[type="button"], input[type="reset"], input[type="submit"]',
			'property' => 'font-size',
			'units'    => 'px',
		),	
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'     	  => 'slider',
	'settings'    => 'button_box_shadow',
	'label'       => esc_attr__( 'Shadow opacity', 'silver' ),
	'section'     => 'silver_buttons',
	'default'     => '0.2',
	'priority'    => 10,
	'choices'   => array(
		'min'  => 0,
		'max'  => 1,
		'step' => 0.01,
	),
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.button, button, input[type="button"], input[type="reset"], input[type="submit"]',
			'property' => 'box-shadow',
			'value_pattern'	=> '0 10px 30px rgba(20, 20, 24, $)'
		),
    ),	
) );



Silver_Kirki::add_panel( 'silver_colors', array(
    'title'       	 => __( 'Colors', 'silver' ),
    'priority'       => 20,
) );
Silver_Kirki::add_section( 'silver_header_colors', array(
    'title'       	 => __( 'Header', 'silver' ),
    'panel'        	 => 'silver_colors',
    'priority'       => 11,
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'custom',
	'settings'    => 'zone_title_branding',
	'label'       => '',
	'section'     => 'silver_header_colors',
	'default'     => '<h3 style="background-color:#9aa9bc;color:#fff;padding:5px 10px;text-transform:uppercase;margin-bottom:5px;text-align:center;">' . esc_html__( '1. Branding', 'silver' ) . '</h3>',
	'priority'    => 10,
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'header_background',
	'label'       => __( 'Header background', 'silver' ),
	'section'     => 'silver_header_colors',
	'default'     => '#dee6f1',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.site-branding',
			'property' => 'background-color',
		),
    ),	
) );

Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'site_title_color',
	'label'       => __( 'Site title', 'silver' ),
	'section'     => 'silver_header_colors',
	'default'     => '#000000',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.site-title a',
			'property' => 'color',
		),
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'site_desc_color',
	'label'       => __( 'Site description', 'silver' ),
	'section'     => 'silver_header_colors',
	'default'     => '#adb3bc',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.site-description',
			'property' => 'color',
		),
    ),	
) );
//Menu bar
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'custom',
	'settings'    => 'zone_title_menu',
	'label'       => '',
	'section'     => 'silver_header_colors',
	'default'     => '<h3 style="background-color:#9aa9bc;color:#fff;padding:5px 10px;text-transform:uppercase;margin-bottom:5px;text-align:center;">' . esc_html__( '2. Menu', 'silver' ) . '</h3>',
	'priority'    => 10,
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'menu_bg_color',
	'label'       => __( 'Menu background', 'silver' ),
	'section'     => 'silver_header_colors',
	'default'     => '#f7f7f7',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.top-bar',
			'property' => 'background-color',
		),
    ),	
	'choices'     => array(
		'alpha' => true,
	),    
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'menu_items_top',
	'label'       => __( 'Top level menu items', 'silver' ),
	'section'     => 'silver_header_colors',
	'default'     => '#000000',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.main-navigation a',
			'property' => 'color',
		),
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'menu_items_sub',
	'label'       => __( 'Submenu items', 'silver' ),
	'section'     => 'silver_header_colors',
	'default'     => '#000000',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.main-navigation ul ul a',
			'property' => 'color',
		),
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'menu_sub_bg',
	'label'       => __( 'Submenu background', 'silver' ),
	'section'     => 'silver_header_colors',
	'default'     => '#ffffff',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.main-navigation ul ul li',
			'property' => 'background-color',
		),
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'social_background',
	'label'       => __( 'Social icons background', 'silver' ),
	'section'     => 'silver_header_colors',
	'default'     => '#dee6f1',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.social-navigation a',
			'property' => 'background-color',
		),
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'social_color',
	'label'       => __( 'Social icons color', 'silver' ),
	'section'     => 'silver_header_colors',
	'default'     => '#000',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.social-navigation a',
			'property' => 'color',
		),
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'custom',
	'settings'    => 'zone_title_carousel',
	'label'       => '',
	'section'     => 'silver_header_colors',
	'default'     => '<h3 style="background-color:#9aa9bc;color:#fff;padding:5px 10px;text-transform:uppercase;margin-bottom:5px;text-align:center;">' . esc_html__( '3. Carousel', 'silver' ) . '</h3>',
	'priority'    => 10,
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'carousel_cats_color',
	'label'       => __( 'Carousel categories', 'silver' ),
	'section'     => 'silver_header_colors',
	'default'     => '#fff',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.header-carousel .carousel-cell .carousel-content .first-cat',
			'property' => 'color',
		),
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'carousel_title_color',
	'label'       => __( 'Carousel titles', 'silver' ),
	'section'     => 'silver_header_colors',
	'default'     => '#fff',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.header-carousel .carousel-cell .carousel-content .entry-title a',
			'property' => 'color',
		),
    ),	
) );
//Buttons
Silver_Kirki::add_section( 'silver_buttons_colors', array(
    'title'       	 => __( 'Buttons', 'silver' ),
    'panel'        	 => 'silver_colors',
    'priority'       => 11,
) );

Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'buttons_background',
	'label'       => __( 'Buttons background', 'silver' ),
	'section'     => 'silver_buttons_colors',
	'default'     => '#dee6f1',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.button, button, input[type="button"], input[type="reset"], input[type="submit"]',
			'property' => 'background-color',
		),
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'buttons_color',
	'label'       => __( 'Buttons color', 'silver' ),
	'section'     => 'silver_buttons_colors',
	'default'     => '#000',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.button, button, input[type="button"], input[type="reset"], input[type="submit"]',
			'property' => 'color',
		),
    ),	
) );
//Archives
Silver_Kirki::add_section( 'silver_archives_colors', array(
    'title'       	 => __( 'Index&amp;archives', 'silver' ),
    'panel'        	 => 'silver_colors',
    'priority'       => 12,
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'category_bg_color',
	'label'       => __( 'Category background color', 'silver' ),
	'section'     => 'silver_archives_colors',
	'default'     => '#dee6f1',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.first-cat',
			'property' => 'background-color',
		),
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'category_color',
	'label'       => __( 'Category color', 'silver' ),
	'section'     => 'silver_archives_colors',
	'default'     => '#000',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.first-cat',
			'property' => 'color',
		),
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'index_title_color',
	'label'       => __( 'Post title color', 'silver' ),
	'section'     => 'silver_archives_colors',
	'default'     => '#2a394d',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.entry-title a',
			'property' => 'color',
		),
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'index_title_color_hover',
	'label'       => __( 'Post title color (hover)', 'silver' ),
	'section'     => 'silver_archives_colors',
	'default'     => '#fc254d',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.entry-title a:hover',
			'property' => 'color',
		),
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'index_date_color_hover',
	'label'       => __( 'Post date', 'silver' ),
	'section'     => 'silver_archives_colors',
	'default'     => '#adb3bc',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.posts-loop .posted-on a, .posts-loop .byline a',
			'property' => 'color',
		),
    ),	
) );

//Single posts
Silver_Kirki::add_section( 'silver_single_colors', array(
    'title'       	 => __( 'Single posts/pages', 'silver' ),
    'panel'        	 => 'silver_colors',
    'priority'       => 13,
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'single_meta_color',
	'label'       => __( 'Post meta color', 'silver' ),
	'section'     => 'silver_single_colors',
	'default'     => '#fff',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.cat-links a,.posted-on a, .byline a',
			'property' => 'color',
		),
    ),	
) );
Silver_Kirki::add_field( 'silver', array(
	'type'        => 'color',
	'settings'    => 'single_post_title',
	'label'       => __( 'Post title color', 'silver' ),
	'section'     => 'silver_single_colors',
	'default'     => '#fff',
	'transport'	  => 'auto',
    'output'      => array(
		array(
			'element'  => '.entry-title',
			'property' => 'color',
		),
    ),	
) );


//Footer
Silver_Kirki::add_section( 'silver_footer', array(
    'title'       	 => __( 'Footer', 'silver' ),
    'priority'       => 18,
) );
Silver_Kirki::add_field( 'silver_footer', array(
	'type'     			=> 'text',
	'transport' 		=> 'postMessage',
	'settings' 			=> 'footer_credits',
	'sanitize_callback' => 'wp_kses_post',
	'label'    			=> __( 'Footer credits [HTML allowed]', 'silver' ),
	'section'  			=> 'silver_footer',
	'default'  			=> '',
	'priority' 			=> 10,
	'js_vars'  			=> array(
		array(
			'element'  => '.site-info',
			'function' => 'html',
		),
	),
) );




/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function silver_customize_preview_js() {
	wp_enqueue_script( 'silver-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'silver_customize_preview_js' );
