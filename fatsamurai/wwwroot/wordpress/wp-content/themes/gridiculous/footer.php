			<?php get_sidebar(); ?>

	</main> <!-- #main.row -->

</div> <!-- #page.grid -->
<?php $bavotasan_theme_options = bavotasan_theme_options(); ?>
<footer id="footer" role="contentinfo">

	<div id="footer-content" class="grid <?php echo $bavotasan_theme_options['width']; ?>">

		<div class="row">

			<p class="copyright c12">
				<span class="fl">Copyright &copy; <?php echo date("Y"); ?> <a href="<?php echo home_url("/"); ?>"><?php echo bloginfo("name"); ?></a>. All Rights Reserved.</span>
				<span class="credit-link fr"><i class="icon-leaf"></i><?php echo BAVOTASAN_THEME_NAME; ?> created by <a href="https://themes.bavotasan.com/2012/gridiculous/">c.bavota</a>.</span>
			</p><!-- .c12 -->

		</div><!-- .row -->

	</div><!-- #footer-content.grid -->

</footer><!-- #footer -->

<?php wp_footer(); ?>
</body>
</html>