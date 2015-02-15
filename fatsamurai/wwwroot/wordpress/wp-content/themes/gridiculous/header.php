<?php $bavotasan_theme_options = bavotasan_theme_options(); ?>
<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="page" class="grid<?php echo ' ' . $bavotasan_theme_options['width']; ?>">

		<header id="header" class="row" role="banner">

			<div class="c12">
				<div id="mobile-menu">
					<a href="#" class="left-menu"><i class="icon-reorder"></i></a>
					<a href="#"><i class="icon-search"></i></a>
				</div>
				<div id="drop-down-search"><?php get_search_form(); ?></div>

				<div class="header-wrap">
					<h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php if ( $bavotasan_theme_options['tagline'] ) { ?><h2 id="site-description"><?php bloginfo( 'description' ); ?></h2><?php } ?>
				</div>

				<?php
				// Header Widgetized Area
				dynamic_sidebar( 'header-area' );

				$header_image = get_header_image();
				if ( ! empty( $header_image ) ) :
					?>
					<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img id="header-img" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
					<?php
				endif;
				?>

				<nav id="site-navigation" role="navigation">
					<h3 class="screen-reader-text"><?php _e( 'Main menu', 'gridiculous' ); ?></h3>
					<a class="screen-reader-text" href="#primary" title="<?php esc_attr_e( 'Skip to content', 'gridiculous' ); ?>"><?php _e( 'Skip to content', 'gridiculous' ); ?></a>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => '' ) ); ?>
				</nav><!-- #site-navigation -->

			</div><!-- .c12 -->

		</header><!-- #header .row -->
		<?php
		global $paged;
		if ( $bavotasan_theme_options['home_widget'] && is_front_page() && 2 > $paged ) {
			?>

		<div id="home-page-widgets" class="row">
			<?php if ( ! dynamic_sidebar( 'home-page-top-area' ) ) : ?>

			<?php if ( current_user_can( 'edit_theme_options' ) ) { ?>
				<div class="c12">
					<div class="alert top"><?php printf( __( 'The three boxes below are text widgets that have been added to the <em>Home Page Top Area</em>. Add your own widgets by going to the %sWidgets admin page%s or remove this section completely under the <em>Layout panel</em> on the %sTheme Options page%s.', 'gridiculous' ), '<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">', '</a>', '<a href="' . esc_url( admin_url( 'customize.php' ) ) . '">', '</a>' ); ?></div>
				</div>
			<?php } ?>

			<aside class="home-widget c4 widget_text">
				<h3 class="home-widget-title">Responsive Design</h3>
				<div class="textwidget">
					<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/ex01.jpg" alt="" />
					Built using Gridiculous, a fully responsive grid layout boilerplate. Resize the browser window to see how your site will adjust for desktop viewing, tablets and handheld devices.
				</div>
			</aside>

			<aside class="home-widget c4 widget_text">
				<h3 class="home-widget-title">Fully Customizable</h3>
				<div class="textwidget">
					<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/ex02.jpg" alt="" />
					Use the new theme customizer in <a href="http://wordpress.org/">WordPress 3.4</a> to preview all your changes before putting them live. Select a custom header image, background color, page layout, link color and so much more.
				</div>
			</aside>

			<aside class="home-widget c4 widget_text">
				<h3 class="home-widget-title">Color Options</h3>
				<div class="textwidget">
					<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/ex03.jpg" alt="" />
					With so many colors to choose from, the possibilities are endless. Select one for your header text and your links. If one color isn't enough for your background you can also select any image you choose.
				</div>
			</aside>

			<?php endif; ?>
		</div>

		<?php } ?>

		<?php
		$sticky = get_option( 'sticky_posts' );
		$featured = new WP_Query( array(
			'posts_per_page' => 1,
			'post__in'  => $sticky,
			'ignore_sticky_posts' => 1
		) );
		if ( ! empty( $sticky[0] ) && is_home() && 2 > $paged ) {
		?>

		<div id="featured" class="row">

			<div class="c12">

				<?php
				while ( $featured->have_posts() ) : $featured->the_post();
					get_template_part( 'content', get_post_format() );
				endwhile;

				wp_reset_postdata();
				?>

			</div>

		</div>

		<?php } ?>

		<main id="main" class="row">
			<div id="left-nav"></div>