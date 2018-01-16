<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Silver
 */

get_header();
//Blog layout
$layout = silver_blog_layout();
?>

	<div id="primary" class="content-area <?php echo $layout[1]; ?>">
		<main id="main" class="site-main row">

		<?php
		if ( have_posts() ) : ?>

				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<div class="posts-loop">
			<?php			
			/* Start the Loop */
			$i = 1;

			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */

				get_template_part( 'template-parts/content', get_post_format() );

				if ( ( $i == 3 ) && is_active_sidebar( 'loop-widgets-one' ) ) : ?>
				<div class="loop-banner">
					<?php dynamic_sidebar( 'loop-widgets-one' ); ?>
				</div>
				<?php endif;

				if ( ( $i == 9 ) && is_active_sidebar( 'loop-widgets-two' ) ) : ?>
				<div class="loop-banner looptwo">
					<?php dynamic_sidebar( 'loop-widgets-two' ); ?>
				</div>
				<?php endif;				

				$i++;
			endwhile;
			?>
			</div>
			<?php

			the_posts_pagination( array(
				'mid_size'  => 1,
			) );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
if ( $layout[0] == 'twocolsid' || $layout[0] == 'onecolsid' ) {
	get_sidebar();
}
get_footer();
