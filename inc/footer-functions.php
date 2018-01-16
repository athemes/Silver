<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Silver
 */


function silver_footer_credits() {

	$credits = get_theme_mod( 'footer_credits' );
	?>

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="site-info">
			<?php if ( $credits ) : ?>
				<?php echo wp_kses_post( $credits ); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'silver' ) ); ?>"><?php
					/* translators: %s: CMS name, i.e. WordPress. */
					printf( esc_html__( 'Proudly powered by %s', 'silver' ), 'WordPress' );
				?></a>
				<span class="sep"> | </span>
				<?php
					/* translators: 1: Theme name, 2: Theme author. */
					printf( esc_html__( 'Theme: %2$s by %1$s.', 'silver' ), 'aThemes', '<a href="https://athemes.com/theme/silver">Silver</a>' );
				?>
			<?php endif; ?>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->

	<?php
}
add_action( 'silver_footer', 'silver_footer_credits' );