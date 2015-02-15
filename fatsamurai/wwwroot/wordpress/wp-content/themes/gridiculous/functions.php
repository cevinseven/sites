<?php
$bavotasan_theme_data = wp_get_theme();
define( 'BAVOTASAN_THEME_URL', get_template_directory_uri() );
define( 'BAVOTASAN_THEME_TEMPLATE', get_template_directory() );
define( 'BAVOTASAN_THEME_NAME', $bavotasan_theme_data->Name );
define( 'BAVOTASAN_PRO_UPGRADE_NAME', 'Gridiculous Pro' );

/**
 * Includes
 *
 * @since 1.0.0
 */
require( BAVOTASAN_THEME_TEMPLATE . '/library/theme-options.php' ); // Functions for theme options page
require( BAVOTASAN_THEME_TEMPLATE . '/library/preview-pro.php' ); // Functions for preview pro page
require( BAVOTASAN_THEME_TEMPLATE . '/library/message-bar.php' ); // Functions for message bar

/**
 * Prepare the content width
 *
 * @since 1.0.0
 */
$bavotasan_theme_options = bavotasan_theme_options();
$array_width = array( '' => 1200, 'w960' => 960, 'w640' => 640, 'w320' => 320, 'wfull' => 1200 );
$array_content = array( 'c2' => .17, 'c3' => .25, 'c4' => .34, 'c5' => .42, 'c6' => .5, 'c7' => .58, 'c8' => .66, 'c9' => .75, 'c10' => .83, 'c12' => 1 );
$bavotasan_main_content =  $array_content[$bavotasan_theme_options['primary']] * $array_width[$bavotasan_theme_options['width']] - 40;

if ( ! isset( $content_width ) )
	$content_width = $bavotasan_main_content;

add_action( 'after_setup_theme', 'bavotasan_setup' );
if ( ! function_exists( 'bavotasan_setup' ) ) :
/**
 * Initial setup for Gridiculous theme
 *
 * This function is attached to the 'after_setup_theme' action hook.
 *
 * @uses	load_theme_textdomain()
 * @uses	get_locale()
 * @uses	BAVOTASAN_THEME_TEMPLATE
 * @uses	add_theme_support()
 * @uses	add_editor_style()
 * @uses	add_custom_background()
 * @uses	add_custom_image_header()
 * @uses	register_default_headers()
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_setup() {
	load_theme_textdomain( 'gridiculous', BAVOTASAN_THEME_TEMPLATE . '/library/languages' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'gridiculous' ) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'gallery', 'image', 'video', 'audio', 'quote', 'link', 'status', 'aside' ) );

	// This theme uses Featured Images (also known as post thumbnails) for archive pages
	add_theme_support( 'post-thumbnails' );

	// Add a filter to bavotasan_header_image_width and bavotasan_header_image_height to change the width and height of your custom header.
	$custom_header_support = array(
		'default-text-color' => '333',
		'flex-height' => true,
		'flex-width' => true,
		'random-default' => true,
		'width' => apply_filters( 'bavotasan_header_image_width', 1280 ),
		'height' => apply_filters( 'bavotasan_header_image_height', 288 ),
		'wp-head-callback' => 'bavotasan_header_style',
		'admin-head-callback' => 'bavotasan_admin_header_style',
		'admin-preview-callback' => 'bavotasan_admin_header_image'
	);

	add_theme_support( 'custom-header', $custom_header_support );

	// Add support for custom backgrounds
	$custom_background_support = array(
		'default-image' => BAVOTASAN_THEME_URL . '/library/images/solid.png',
		'admin-head-callback' => 'bavotasan_admin_background_style'
	);

	add_theme_support( 'custom-background', $custom_background_support );

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'froggy' => array(
			'url' => '%s/library/images/froggy.jpg',
			'thumbnail_url' => '%s/library/images/froggy-thumbnail.jpg',
			'description' => __( 'Froggy', 'gridiculous' )
		)
	) );

	// Add HTML5 elements
	add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', ) );
}
endif; // bavotasan_setup

if ( ! function_exists( 'bavotasan_admin_background_style' ) ) :
/**
 * Styles the background displayed on the Appearance > Background admin panel.
 *
 * Referenced via add_custom_background() in bavotasan_setup().
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_admin_background_style() {
	?>
	<style type="text/css">
		#custom-background-image {
			background-image: url(<?php background_image(); ?>) !important;
		}
	</style>
	<?php
}
endif; // bavotasan_admin_background_style

if ( ! function_exists( 'bavotasan_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_header_style() {
	$text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail.
	if ( $text_color == HEADER_TEXTCOLOR )
		return;

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $text_color ) :
		?>
		#site-title,
		#site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
		<?php
		// If the user has set a custom color for the text use that
		else :
		?>
		#site-title a,
		#site-description {
			color: #<?php echo $text_color; ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // bavotasan_header_style

if ( ! function_exists( 'bavotasan_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in bavotasan_setup().
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_admin_header_style() {
	?>
	<style type="text/css">
	@font-face {
		font-family: 'Russo One';
		font-style: normal;
		font-weight: 400;
		src: local('Russo One'), local('RussoOne-Regular'), url('http://themes.googleusercontent.com/static/fonts/russoone/v1/RO6e96EC9m6OLO0tr7J3z7O3LdcAZYWl9Si6vvxL-qU.woff') format('woff');
	}

	.appearance_page_custom-header #headimg {
		border: none;
		}

	#headimg h1 {
		margin: 0;
		}

	#headimg h1 a {
		font-family: 'Russo One', sans-serif;
		text-decoration: none;
		font-size: 60px;
		font-weight: 400;
		line-height: 1;
		}

	#desc {
		font-family: Arial, sans-serif;
		margin: 0 0 30px;
		font-size: 20px;
		line-height: 1;
		font-weight: bold;
		}
	<?php
	// If the user has set a custom color for the text use that
	if ( get_header_textcolor() != HEADER_TEXTCOLOR ) :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	#headimg img {
		max-width: 1140px;
		height: auto;
		width: 100%;
	}
	</style>
	<?php
}
endif; // bavotasan_admin_header_style

if ( ! function_exists( 'bavotasan_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in bavotasan_setup().
 *
 * @uses	get_theme_mod()
 * @uses	bloginfo()
 * @uses	get_header_image()
 * @uses	home_url()
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_admin_header_image() {
	?>
	<div id="headimg">
		<?php
		if ( 'blank' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) || '' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) . ';"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php $header_image = get_header_image();

		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
	<?php
}
endif; // bavotasan_admin_header_image

add_action( 'wp_head', 'bavotasan_styles' );
/**
 * Add a style block to the theme for the current link color.
 *
 * This function is attached to the 'wp_head' action hook.
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_styles() {
	$bavotasan_theme_options = bavotasan_theme_options();
	?>
<style>
.post-meta a, .post-content a, .widget a { color: <?php echo $bavotasan_theme_options['link_color']; ?>; }
</style>
	<?php
}

add_action( 'pre_get_posts', 'bavotasan_home_query' );
if ( ! function_exists( 'bavotasan_home_query' ) ) :
/**
 * Remove sticky posts from home page query
 *
 * This function is attached to the 'pre_get_posts' action hook.
 *
 * @param	array $query
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_home_query( $query = '' ) {
	if ( ! is_home() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() )
		return;

	$query->set( 'post__not_in', get_option( 'sticky_posts' ) );
}
endif;

add_action( 'wp_enqueue_scripts', 'bavotasan_add_js' );
if ( ! function_exists( 'bavotasan_add_js' ) ) :
/**
 * Load all JavaScript to header
 *
 * This function is attached to the 'wp_enqueue_scripts' action hook.
 *
 * @uses	is_admin()
 * @uses	is_singular()
 * @uses	get_option()
 * @uses	wp_enqueue_script()
 * @uses	BAVOTASAN_THEME_URL
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_add_js() {
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_enqueue_script( 'harvey', BAVOTASAN_THEME_URL .'/library/js/harvey.js', '', '', true );
	wp_enqueue_script( 'theme_js', BAVOTASAN_THEME_URL .'/library/js/theme.js', array( 'jquery' ), '', true );

	wp_enqueue_style( 'theme_stylesheet', get_stylesheet_uri() );
	wp_enqueue_style( 'google_fonts', 'http://fonts.googleapis.com/css?family=Lato:300,900|Russo+One', false, null, 'all' );
}
endif; // bavotasan_add_js

add_action( 'widgets_init', 'bavotasan_widgets_init' );
if ( ! function_exists( 'bavotasan_widgets_init' ) ) :
/**
 * Creating the two sidebars
 *
 * This function is attached to the 'widgets_init' action hook.
 *
 * @uses	register_sidebar()
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_widgets_init() {
	register_sidebar( array(
		'name' => __( 'First Sidebar', 'gridiculous' ),
		'id' => 'sidebar',
		'description' => __( 'This is the sidebar widgetized area. All defaults widgets work great here.', 'gridiculous' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Header Area', 'gridiculous' ),
		'id' => 'header-area',
		'description' => __( 'Widgetized area in the header to the right of the site name. Great place for a search box or a banner ad.', 'gridiculous' ),
		'before_widget' => '<aside id="%1$s" class="header-widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="header-widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Home Page Top Area', 'gridiculous' ),
		'id' => 'home-page-top-area',
		'description' => __( 'Widgetized area on the home page directly below the navigation menu. Specifically designed for 3 text widgets. Must be turned on in the Layout options on the Customize Gridiculous admin page.', 'gridiculous' ),
		'before_widget' => '<aside id="%1$s" class="home-widget c4 %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="home-widget-title">',
		'after_title' => '</h3>',
	) );
}
endif; // bavotasan_widgets_init

if ( !function_exists( 'bavotasan_pagination' ) ) :
/**
 * Add pagination
 *
 * @uses	paginate_links()
 * @uses	add_query_arg()
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_pagination() {
	global $wp_query;

	$current = max( 1, get_query_var('paged') );
	$big = 999999999; // need an unlikely integer

	$pagination_return = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => $current,
		'total' => $wp_query->max_num_pages,
		'next_text' => '&raquo;',
		'prev_text' => '&laquo;'
	) );

	if ( ! empty( $pagination_return ) ) {
		echo '<div id="pagination">';
		echo '<div class="total-pages">';
		printf( __( 'Page %1$s of %2$s', 'gridiculous' ), $current, $wp_query->max_num_pages );
		echo '</div>';
		echo $pagination_return;
		echo '</div>';
	}
}
endif; // bavotasan_pagination

add_filter( 'wp_title', 'bavotasan_filter_wp_title', 10, 2 );
if ( !function_exists( 'bavotasan_filter_wp_title' ) ) :
/**
 * Filters the page title appropriately depending on the current page
 *
 * @uses	get_bloginfo()
 * @uses	is_home()
 * @uses	is_front_page()
 *
 * @since Gridiculous 1.0.1
 */
function bavotasan_filter_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'gridiculous' ), max( $paged, $page ) );

	return $title;
}
endif; // bavotasan_filter_wp_title

if ( ! function_exists( 'bavotasan_comment' ) ) :
/**
 * Callback function for comments
 *
 * Referenced via wp_list_comments() in comments.php.
 *
 * @uses	get_avatar()
 * @uses	get_comment_author_link()
 * @uses	get_comment_date()
 * @uses	get_comment_time()
 * @uses	edit_comment_link()
 * @uses	comment_text()
 * @uses	comments_open()
 * @uses	comment_reply_link()
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	switch ( $comment->comment_type ) :
		case '' :
		?>
		<li <?php comment_class(); ?>>
			<div id="comment-<?php comment_ID(); ?>" class="comment-body">
				<div class="comment-avatar">
					<?php echo get_avatar( $comment, 60 ); ?>
				</div>
				<div class="comment-content">
					<div class="comment-author">
						<?php echo get_comment_author_link() . ' '; ?>
					</div>
					<div class="comment-meta">
						<?php
						printf( __( '%1$s at %2$s', 'gridiculous' ), get_comment_date(), get_comment_time() );
						edit_comment_link( __( '(edit)', 'gridiculous' ), '  ', '' );
						?>
					</div>
					<div class="comment-text">
						<?php if ( '0' == $comment->comment_approved ) { echo '<em>' . __( 'Your comment is awaiting moderation.', 'gridiculous' ) . '</em>'; } ?>
						<?php comment_text() ?>
					</div>
					<?php if ( $args['max_depth'] != $depth && comments_open() && 'pingback' != $comment->comment_type ) { ?>
					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php
			break;

		case 'pingback'  :
		case 'trackback' :
		?>
		<li id="comment-<?php comment_ID(); ?>" class="pingback">
			<div class="comment-body">
				<?php _e( 'Pingback:', 'gridiculous' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(edit)', 'gridiculous' ), ' ' ); ?>
			</div>
			<?php
			break;
	endswitch;
}
endif; // bavotasan_comment

/**
 * Custom function to display post/page content pagination links
 *
 * @param	array $args
 *
 * @return	Pagenum links
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_link_pages( $args = '' ) {
	global $page, $numpages, $multipage, $more, $pagenow;

	$defaults = array(
        'before' => '<nav id="post-pagination"><h3 class="screen-reader-text">' . __( 'Post Pages menu', 'gridiculous' ) . '</h3>',
		'after' => '</nav>'
	);

	$output = '';
	$r = wp_parse_args( $args, $defaults );
	$r = apply_filters( 'wp_link_pages_args', $r );
	extract( $r, EXTR_SKIP );

	if ( $multipage ) {
	    $output .= $before;
	    for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
			$j = str_replace( '%', $i, '%' );

			$output .= ' ';
			$output .= ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) ) ? _wp_link_page( $i ) :'<span class="current-post-page">';
			$output .= $j;
			$output .= ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) ) ? '</a>' : '</span>';
	    }
	    $output .= $after;
	}
	return $output;
}

add_filter( 'the_content_more_link', 'bavotasan_remove_more_jump_link' );
if ( ! function_exists( 'bavotasan_remove_more_jump_link' ) ) :
/**
 * Removese the jump link from the content more link
 *
 * @param	string $link
 *
 * @return	Custom read more link
 *
 * @since Gridiculous Pro 1.0.2
 */
function bavotasan_remove_more_jump_link( $link ) {
	$offset = strpos( $link, '#more-' );
	if ( $offset )
		$end = strpos( $link, '"',$offset );

	if ( $end )
		$link = substr_replace( $link, '', $offset, $end - $offset );

	return '<p class="more-link-p">' . $link . '</p>';
}
endif;

add_filter( 'excerpt_more', 'bavotasan_excerpt_more' );
if ( ! function_exists( 'bavotasan_excerpt_more' ) ) :
/**
 * Adds a read more link to all excerpts
 *
 * @param	int $more
 *
 * @return	Custom read more link
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_excerpt_more( $more ) {
	return '&hellip;<p class="more-link-p"><a class="more-link" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Read more &rarr;', 'gridiculous' ) . '</a></p>';
}
endif; // bavotasan_excerpt_more

add_filter( 'excerpt_length', 'bavotasan_excerpt_length', 999 );
if ( ! function_exists( 'bavotasan_excerpt_length' ) ) :
/**
 * Custom excerpt length
 *
 * @param	int $length
 *
 * @return	Custom excerpt length
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_excerpt_length( $length ) {
	return 40;
}
endif;

/*
 * Remove default gallery styles
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Create the required attributes for the #primary container
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_primary_attr() {
	$bavotasan_theme_options = bavotasan_theme_options();

	$column = $bavotasan_theme_options['primary'];
	$layout = $bavotasan_theme_options['layout'];
	$class = ( 3 == $layout ) ? $column . ' centered' : $column;
	$style = ( 1 == $layout ) ? ' style="float: right;"' : '';

	echo 'class="' . $class . '"' . $style;
}

/**
 * Create the required classes for the #secondary sidebar container
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_sidebar_class() {
	$bavotasan_theme_options = bavotasan_theme_options();

	$end = ( 2 == $bavotasan_theme_options['layout'] ) ? ' end' : '';
	$class = str_replace( 'c', '', $bavotasan_theme_options['primary'] );
	$class = 'c' . ( 12 - $class ) . $end;

	echo 'class="' . $class . '"';
}

add_action( 'admin_bar_menu', 'bavotasan_admin_bar_menu', 999 );
/**
 * Add menu item to toolbar
 *
 * This function is attached to the 'admin_bar_menu' action hook.
 *
 * @param	array $wp_admin_bar
 *
 * @since 2.0.4
 */
function bavotasan_admin_bar_menu( $wp_admin_bar ) {
    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() )
    	$wp_admin_bar->add_node( array( 'id' => 'bavotasan_toolbar', 'title' => BAVOTASAN_THEME_NAME, 'href' => esc_url( admin_url( 'customize.php' ) ) ) );
}

add_filter( 'body_class','bavotasan_custom_body_class' );
/**
 * Adds class if first sidebar located on left side
 *
 * @since 1.0.8
 */
function bavotasan_custom_body_class( $classes ) {
	$bavotasan_theme_options = bavotasan_theme_options();
	$arr = array( 1, 3, 5 );
	if ( in_array( $bavotasan_theme_options['layout'], $arr ) )
		$classes[] = 'left-sidebar';

	return $classes;
}

/**
 * Add class to sub-menu parent items
 *
 * @author Kirk Wight <http://kwight.ca/adding-a-sub-menu-indicator-to-parent-menu-items/>
 * @since 1.0.8
 */
class Bavotasan_Page_Navigation_Walker extends Walker_Nav_Menu {
    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( !empty( $children_elements[ $element->$id_field ] ) )
            $element->classes[] = 'sub-menu-parent';

        Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}

add_filter( 'wp_nav_menu_args', 'bavotasan_nav_menu_args' );
/**
 * Set our new walker only if a menu is assigned and a child theme hasn't modified it to one level deep
 *
 * This function is attached to the 'wp_nav_menu_args' filter hook.
 *
 * @author Kirk Wight <http://kwight.ca/adding-a-sub-menu-indicator-to-parent-menu-items/>
 * @since 1.0.8
 */
function bavotasan_nav_menu_args( $args ) {
    if ( 1 !== $args[ 'depth' ] && has_nav_menu( 'primary' ) )
        $args[ 'walker' ] = new Bavotasan_Page_Navigation_Walker;

    return $args;
}

/**
 * Retrieves the IDs for images in a gallery.
 *
 * @uses get_post_galleries() first, if available. Falls back to shortcode parsing,
 * then as last option uses a get_posts() call.
 *
 * @since 1.0.9
 *
 * @return array List of image IDs from the post gallery.
 */
function bavotasan_get_gallery_images() {
	$images = array();

	if ( function_exists( 'get_post_galleries' ) ) {
		$galleries = get_post_galleries( get_the_ID(), false );
		if ( isset( $galleries[0]['ids'] ) )
		 	$images = explode( ',', $galleries[0]['ids'] );
	} else {
		$pattern = get_shortcode_regex();
		preg_match( "/$pattern/s", get_the_content(), $match );
		$atts = shortcode_parse_atts( $match[3] );
		if ( isset( $atts['ids'] ) )
			$images = explode( ',', $atts['ids'] );
	}

	if ( ! $images ) {
		$images = get_posts( array(
			'fields' => 'ids',
			'numberposts' => 999,
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'post_mime_type' => 'image',
			'post_parent' => get_the_ID(),
			'post_type' => 'attachment',
		) );
	}

	return $images;
}