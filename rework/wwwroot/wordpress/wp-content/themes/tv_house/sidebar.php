<div class="right_side">








<div class="extra">



	

<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar('Sidebar') ) : ?>

		Please Use Wordpress Widgets.


				<?php endif; ?>
<?php
$block = get_post_meta($post->ID, 'Block #1');
if(isset($block)){
foreach(($block) as $blocks) {
echo $blocks;
}
}
?>   
		

</div>










</div>

