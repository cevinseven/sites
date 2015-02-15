<?php get_header(); ?>

	<section id="primary" <?php bavotasan_primary_attr(); ?>>

		<?php if ( have_posts() ) : ?>

			<header id="archive-header">

				<h1 class="page-title">
					<?php if ( is_category() ) : ?>
						<?php echo single_cat_title( '', false ); ?>
					<?php elseif ( is_author() ) : ?>
						<?php printf( __( 'Author Archive for %s', 'gridiculous' ), get_the_author_meta( 'display_name', get_query_var( 'author' ) ) ); ?>
					<?php elseif ( is_tag() ) : ?>
						<?php printf( __( 'Tag Archive for %s', 'gridiculous' ), single_tag_title( '', false ) ); ?>
					<?php elseif ( is_day() ) : ?>
						<?php printf( __( 'Daily Archives: %s', 'gridiculous' ), get_the_date() ); ?>
					<?php elseif ( is_month() ) : ?>
						<?php printf( __( 'Monthly Archives: %s', 'gridiculous' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'gridiculous' ) ) ); ?>
					<?php elseif ( is_year() ) : ?>
						<?php printf( __( 'Yearly Archives: %s', 'gridiculous' ), get_the_date( _x( 'Y', 'yearly archives date format', 'gridiculous' ) ) ); ?>
					<?php else : ?>
						<?php _e( 'Blog Archives', 'gridiculous' ); ?>
					<?php endif; ?>
				</h1><!-- .page-title -->
				<?php
				if ( is_category() ) :
					if ( $category_description = category_description() )
						echo '<h2 class="archive-meta">' . $category_description . '</h2>';
				endif;

				if ( is_author() ) :
					$curauth = ( get_query_var('author_name') ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var(' author' ) );
					if ( isset( $curauth->description ) )
						echo '<h2 class="archive-meta">' . $curauth->description . '</h2>';
				endif;

				if ( is_tag() ) :
					if ( $tag_description = tag_description() )
						echo '<h2 class="archive-meta">' . $tag_description . '</h2>';
				endif;
				?>
			</header><!-- #archive-header -->

			<?php
			while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'content', get_post_format() );

			endwhile;

			bavotasan_pagination();
		else :
			get_template_part( 'content', 'none' );
		endif;
		?>

	</section><!-- #primary.c8 -->

<?php get_footer(); ?>