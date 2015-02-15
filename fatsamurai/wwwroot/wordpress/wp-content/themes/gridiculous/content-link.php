<?php
/**
 * The template for displaying posts in the Link post format
 *
 * @since 1.0.6
 */
$bavotasan_theme_options = bavotasan_theme_options();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h3 class="post-format"><?php _e( 'Link', 'gridiculous' ); ?></h3>

	    <div class="entry-content">
		    <?php the_content( __( 'Read more &rarr;', 'gridiculous' ) ); ?>
	    </div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>
	</article>