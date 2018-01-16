<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Silver
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
	<div class="content-inner">		
		<header class="entry-header">
			<?php
			silver_get_first_cat();

			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>
			<div class="entry-meta">
				<?php silver_post_date(); ?>
			</div><!-- .entry-meta -->
		</header><!-- .entry-header -->	

		<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumb">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></a>
		</div>
		<?php endif; ?>		

		<?php if ( get_theme_mod( 'show_excerpt' ) ) : ?>
		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
