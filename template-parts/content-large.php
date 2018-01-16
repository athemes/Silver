<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Silver
 */

?>

<?php $feat = get_the_post_thumbnail_url(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'large-post' ); ?> style="background-image: url(<?php echo esc_url( $feat ); ?>)">

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
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
