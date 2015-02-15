<?php get_header(); ?>

<div id="main" class="content">

<div id="left_side">


<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

<div class="post">
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a>
</h2>


 
<div class="entry">	

<div class="feature"> 
<?php the_post_thumbnail(); ?>
</div>	

<?php the_content('Read the rest of this entry &raquo;'); ?>	
</div>

<div class="clearboth">&nbsp;</div>


</div>

<div class="post">


</div>

	<?php endwhile; else : ?>
	
<div class="post">
		<h2>Not Found</h2>
		<p>Sorry, but you are looking for something that isn't here.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

</div>
<?php endif; ?>

</div>

<?php get_footer(); ?>