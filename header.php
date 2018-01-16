<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Silver
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'silver' ); ?></a>

	<?php do_action( 'silver_header' ); ?>

	<div id="content" class="site-content">

	<?php if ( !is_front_page() ) : ?>

	<?php $img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>
	<div class="header-banner" style="background-image: url(<?php echo esc_url( $img_url ); ?>)">
		<div class="container">
			<div class="row">
			<?php if ( is_single() ) : ?>
				<header class="entry-header col-md-12">
					<?php
					silver_entry_cats();
					
					the_title( '<h1 class="entry-title">', '</h1>' );

					if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php silver_posted_on(); ?>
					</div><!-- .entry-meta -->
					<?php endif; ?>
				</header><!-- .entry-header -->

					
			<?php elseif ( class_exists( 'Woocommerce') && is_woocommerce() ) : ?>
				<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
			<?php elseif ( is_archive() ) : ?>
				<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
			<?php elseif ( is_search() ) : ?>
				<h1 class="entry-title"><?php printf( esc_html__( 'Search Results for: %s', 'silver' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			<?php elseif ( is_404() ) : ?>	
				<h1 class="entry-title"><?php echo esc_html__( '404', 'silver' ); ?></h1>
			<?php else : ?>
				<h1 class="entry-title"><?php single_post_title(); ?></h1>
			<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<div class="container">
		<div class="row">