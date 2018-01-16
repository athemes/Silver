<?php
/**
 * The template for displaying archive pages
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
				if ( ( $i % 6 - 3 === 0 ) || ( $i % 6 - 4 === 0 ) ) {
					get_template_part( 'template-parts/content', 'large' );
				} else {
					get_template_part( 'template-parts/content', get_post_format() );
				}
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
if ( $layout == 'twocolsid' || $layout == 'onecolsid' ) {
	get_sidebar();
}
get_footer();
