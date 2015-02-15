<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title>
<?php if ( is_home() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;<?php bloginfo('description'); ?><?php } ?>
<?php if ( is_search() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Search Results<?php } ?>
<?php if ( is_author() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Author Archives<?php } ?>
<?php if ( is_single() ) { ?><?php wp_title(''); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
<?php if ( is_page() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;<?php wp_title(''); ?><?php } ?>
<?php if ( is_category() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Archive&nbsp;|&nbsp;<?php single_cat_title(); ?><?php } ?>
<?php if ( is_month() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Archive&nbsp;|&nbsp;<?php the_time('F'); ?><?php } ?>
<?php if (function_exists('is_tag')) { if ( is_tag() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Tag Archive&nbsp;|&nbsp;<?php  single_tag_title("", true); } } ?>
</title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/sprinkle.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/menu.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-ui-personalized-1.5.2.packed.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/fns.js"></script>



<?php wp_head(); ?>



</head>

<body onload="javascript: mbSet('menu2');">


<div id="menubar">
<div style="float:right; width:111px; margin-top:5px; margin-bottom:15px; margin-right:22px;">

<a href="http://www.reworkcreative.tumblr.com"><img src="http://reworkcreative.com/wp-content/uploads/2012/01/tumblr1.png" /></a>

<a href="http://www.twitter.com/rework71"><img src="http://reworkcreative.com/wp-content/uploads/2012/01/twitter1.png" /></a>

<a href="http://etsy.com/shop/ReworkCreative"><img src="http://reworkcreative.com/wp-content/uploads/2012/01/etsy1.png" /></a>
</div>
<div style="float:right; font-weight:bold; margin:5px 5px 15px 0; font-size:12px;">Also visit us at:</div>
<ul id="menu" style="padding:0; margin:0;">

<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
</ul>

</div>
<div id="header">
<div id="logo">
<h1><a href="<?php echo get_settings('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
<h2><?php bloginfo('description'); ?></h2>
</div>
</div>



<div id="glider">
<?php include (TEMPLATEPATH . '/glide.php'); ?>
</div>
