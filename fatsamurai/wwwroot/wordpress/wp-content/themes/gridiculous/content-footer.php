<?php
/**
 * The template for displaying article footers
 *
 * @since 1.0.8
 */
 ?>
	<footer class="entry">
	    <?php
	    if ( is_single() ) wp_link_pages( array( 'before' => '<p id="pages">' . __( 'Pages:', 'gridiculous' ) ) );
	    edit_post_link( __( '(edit)', 'gridiculous' ), '<p class="edit-link">', '</p>' );
		if ( is_single() ) the_tags( '<p class="tags">' . __( 'Tags:', 'gridiculous' ), ' ', '</p>' );
	    ?>
	</footer><!-- .entry -->