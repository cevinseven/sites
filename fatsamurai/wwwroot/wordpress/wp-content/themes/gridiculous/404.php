<?php get_header(); ?>

	<div id="primary" <?php bavotasan_primary_attr(); ?>>

		<article id="post-0" class="post error404 not-found">
			<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/404.png" alt="" />
	    	<header>
	    	   	<h1 class="post-title"><?php _e( '404 Error', 'gridiculous' ); ?></h1>
	        </header>
	        <div class="entry">
	            <p><?php _e( "Sorry. We can't seem to find the page you are looking for.", 'gridiculous' ); ?></p>
	        </div>
	    </article>

	</div><!-- #primary.c8 -->

<?php get_footer(); ?>