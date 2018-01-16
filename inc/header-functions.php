<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Silver
 */

/*
 * Site identity
 */
function silver_site_identity() {
	?>
	<header id="masthead" class="site-header clearfix">
	
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
		</div><!-- .site-branding -->
	</header><!-- #masthead -->
	<?php
}

/*
 * Menu bar
 */
function silver_menu_bar() {
	?>
		<div class="top-bar clearfix">	
			<div class="container">
				<div class="row">
					<div class="btn-menu col-md-8 col-sm-6 col-xs-12"><i class="icon-menu">wow</i></div>
					<nav id="site-navigation" class="main-navigation col-md-8">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							) );
						?>
						<div class="btn-close-menu">&times;</div>
					</nav><!-- #site-navigation -->
					<?php if ( has_nav_menu( 'social' ) ) : ?>
					<nav class="social-navigation col-md-4 clearfix">
						<?php wp_nav_menu( array( 'theme_location' => 'social', 'link_before' => '<span class="screen-reader-text">', 'link_after' => '</span>', 'menu_class' => 'menu clearfix', 'fallback_cb' => false ) ); ?>
					</nav>
					<?php endif; ?>	
				</div>
			</div>
		</div>
	<?php
}

/*
 * Header hero
 */
function silver_header_hero() {

	if ( !is_home() ) {
		return;
	}	

	//Options
	$number 	= get_theme_mod( 'carousel_posts_number', 5 );
	$cat_ids   	= get_theme_mod( 'carousel_categories' );
	$speed 		= get_theme_mod( 'carousel_speed', 4000 );

	if ( $cat_ids ) {
		$cats = $cat_ids;
	} else {
		$cats = '';
	}

	$query = new WP_Query( array(
		'posts_per_page'      => $number,
		'no_found_rows'       => true,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'cat'				  => $cats
	) );

	if ( $query->have_posts() ) : ?>

		<div class="header-carousel" data-speed="<?php echo absint( $speed ); ?>">
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<div class="carousel-cell">
				<?php if ( has_post_thumbnail() ) : ?>
				<div class="carousel-cell-inner">
					<?php the_post_thumbnail( 'carousel-image' ); ?>
					<div class="carousel-content">
						<div class="carousel-content-inner">
							<?php silver_get_first_cat(); ?>
							<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
							<a class="button" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo esc_html__( 'Read this article', 'silver' ); ?></a>
						</div>
					</div>
				</div>
				<?php endif; ?>			
			</div>
		<?php endwhile; ?>

		</div>
		
	<?php endif;
}

/**
 * Featured boxes
 */
function silver_featured_boxes() {

	if ( !is_home() ) {
		return;
	}

	$boxes = get_theme_mod( 'featured_boxes' );

	if ( !$boxes ) {
		return;
	}

	echo '<div class="featured-categories clearfix">';
	echo 	'<div class="container">';
	echo 		'<div class="row">';

				foreach ( $boxes as $box ) {
					echo '<div class="featured-cat">';
					echo '<div class="featured-cat-inner" style="background-image:url(' . esc_url( wp_get_attachment_image_src( $box['image'] )[0] ) . ')">';
					if ( $box['url'] ) {
						echo '<a href="' . esc_url( $box['url'] ) . '">' . esc_html( $box['text'] ) . '</a>';
					} else {
						echo esc_html( $box['text'] );
					}
					echo '</div>';	
					echo '</div>';
				}

	echo 		'</div>';	
	echo 	'</div>';
	echo '</div>';
}

/*
 * Header sections
 */
function silver_header_sections() {

		$defaults = array(
			'silver_site_identity',
			'silver_menu_bar',
			'silver_header_hero',
			'silver_featured_boxes',
		);

		$sections = get_theme_mod( 'header_sections_order', $defaults );

	foreach ( $sections as $section ) {
		call_user_func( $section );
	}	
}
add_action( 'silver_header', 'silver_header_sections', 9 );