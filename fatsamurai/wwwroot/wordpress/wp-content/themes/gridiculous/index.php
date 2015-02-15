<?php get_header(); ?>

	<div id="primary" <?php bavotasan_primary_attr(); ?>>

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_format() );
			endwhile;

			bavotasan_pagination();
		else :
			?>
			<article id="post-0" class="post no-results not-found">

			<?php if ( current_user_can( 'edit_posts' ) ) :
				// Show a different message to a logged-in user who can add posts.
				?>
				<h1 class="entry-title"><?php _e( 'No posts to display', 'gridiculous' ); ?></h1>

				<div class="entry-content">
					<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'gridiculous' ), admin_url( 'post-new.php' ) ); ?></p>
				</div><!-- .entry-content -->

				<?php
			else :
				get_template_part( 'content', 'none' );
			endif; // end current_user_can() check
			?>

			</article><!-- #post-0 -->
		    <?php
		endif;
		?>

	</div><!-- #primary.c8 -->

<?php get_footer(); ?>