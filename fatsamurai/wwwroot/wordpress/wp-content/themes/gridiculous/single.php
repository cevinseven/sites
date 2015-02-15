<?php get_header(); ?>

	<div id="primary" <?php bavotasan_primary_attr(); ?>>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', get_post_format() ); ?>

			<div id="posts-pagination">
				<h3 class="screen-reader-text"><?php _e( 'Post navigation', 'gridiculous' ); ?></h3>
				<?php if ( 'attachment' == get_post_type( get_the_ID() ) ) { ?>
					<div class="previous fl"><?php previous_image_link( false, __( '&larr; Previous Image', 'gridiculous' ) ); ?></div>
					<div class="next fr"><?php next_image_link( false, __( 'Next Image &rarr;', 'gridiculous' ) ); ?></div>
				<?php } else { ?>
					<div class="previous fl"><?php previous_post_link( '%link', __( '&larr; %title', 'gridiculous' ) ); ?></div>
					<div class="next fr"><?php next_post_link( '%link', __( '%title &rarr;', 'gridiculous' ) ); ?></div>
				<?php } ?>
			</div><!-- #posts-pagination -->

			<?php comments_template( '', true ); ?>

		<?php endwhile; // end of the loop. ?>

	</div><!-- #primary.c8 -->

<?php get_footer(); ?>