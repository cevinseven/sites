<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Omega
 */

get_header(); ?>

	<main class="<?php echo omega_apply_atomic( 'main_class', 'content' );?>" <?php omega_attr( 'content' ); ?>>

		<?php 
		omega_do_atomic( 'before_content' ); // omega_before_content

		while ( have_posts() ) : the_post(); 

			get_template_part( 'partials/content', 'single' ); 
			omega_content_nav( 'nav-below' );
			comments_template(); // Loads the comments.php template. 

		endwhile; // end of the loop. 

		omega_do_atomic( 'after_content' ); // omega_after_content 
		?>

	</main><!-- .content -->

<?php get_footer(); ?>