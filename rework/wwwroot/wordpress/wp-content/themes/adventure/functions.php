<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

?>
<?php

// Global Content Width, Kind of a Joke with this theme, lol
	if (!isset($content_width))
		$content_width = 648;
			
// Ladies, Gentalmen, boys and girls let's start our engines
if (!function_exists('adventure_setup')):

    function adventure_setup() {

        global $content_width; 
			
        // Add Callback for Custom TinyMCE editor stylesheets. (editor-style.css)
        add_editor_style();

        // This feature enables post and comment RSS feed links to head
        add_theme_support('automatic-feed-links');

        // This feature enables custom-menus support for a theme
        register_nav_menus(array(
			'bar' => __('The Menu Bar', 'adventure' ) ) );

        // WordPress 3.4+
		if ( function_exists('get_custom_header')) {
        	add_theme_support('custom-background'); } } endif;
			
add_action('after_setup_theme', 'adventure_setup');

// Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link
function adventure_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args; }

add_filter( 'wp_page_menu_args', 'adventure_page_menu_args' );

/**
 * Filter 'get_comments_number'
 * 
 * Filter 'get_comments_number' to display correct 
 * number of comments (count only comments, not 
 * trackbacks/pingbacks)
 *
 * Courtesy of Chip Bennett
 */
function adventure_comment_count( $count ) {  
	if ( ! is_admin() ) {
		global $id;
		$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
		return count($comments_by_type['comment']); }
	else {
		return $count; } }

add_filter('get_comments_number', 'adventure_comment_count', 0);

/**
 * wp_list_comments() Pings Callback
 * 
 * wp_list_comments() Callback function for 
 * Pings (Trackbacks/Pingbacks)
 */
function adventure_comment_list_pings( $comment ) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php }

// Sets the post excerpt length to 250 characters
function adventure_excerpt_length($length) {
    return 250; }

add_filter('excerpt_length', 'adventure_excerpt_length');

// This function adds in code specifically for IE6 to IE9
function adventure_ie_css() {
	echo "\n" . '<!-- IE 6 to 9 CSS Hacking -->' . "\n";
	echo '<!--[if lte IE 8]><style type="text/css">#content li{background: url(' . get_stylesheet_directory_uri() . '/images/75.png);}li#sidebar{background: url(' . get_stylesheet_directory_uri() . '/images/blacktrans.png);}#content li li{background:none;}</style><![endif]-->' . "\n";
	echo '<!--[if lte IE 7]><style type="text/css">#navi li{float:left;width:150px;}</style><![endif]-->' . "\n";
	echo "\n"; }

add_action('wp_head', 'adventure_ie_css');

// This function removes inline styles set by WordPress gallery
function adventure_remove_gallery_css($css) {
    return preg_replace("#<style type='text/css'>(.*?)</style>#s", '', $css); }

add_filter('gallery_style', 'adventure_remove_gallery_css');

// This function removes default styles set by WordPress recent comments widget
function adventure_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) ); }

add_action( 'widgets_init', 'adventure_remove_recent_comments_style' );

// A comment reply
function adventure_enqueue_comment_reply() {
    if ( is_singular() && comments_open() && get_option('thread_comments')) 
            wp_enqueue_script('comment-reply'); }

add_action( 'wp_enqueue_scripts', 'adventure_enqueue_comment_reply' );	

// Wrap Video in a DIV so that videos width and height become reponsive using CSS
function wrap_embed_with_div($html, $url, $attr) {
	if (preg_match("/youtu.be/", $html) || preg_match("/youtube.com/", $html) || preg_match("/vimeo/", $html) || preg_match("/wordpress.tv/", $html) || preg_match("/v.wordpress.com/", $html)) { 
        // Don't see your video host in here? Just add it in, make sure you have the forward slash marks
            $html = '<div class="video-container">' . $html . "</div>"; }
            return $html;}

add_filter('embed_oembed_html', 'wrap_embed_with_div', 10, 3);

// WordPress Widgets start right here.
function adventure_widgets_init() {

	register_sidebars(1, array(
		'name'=>'sidebar',
		'id' => 'widget',
		'description' => 'Widgets in this area will be shown below the the content of every page.',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2>',
		'after_title' => '</h2>', )); }
	
add_action('widgets_init', 'adventure_widgets_init');

// Checks if the Widgets are active
function adventure_is_sidebar_active($index) {
	global $wp_registered_sidebars;
	$widgetcolums = wp_get_sidebars_widgets();
	if ($widgetcolums[$index]) {
		return true; }
		return false; }
		
// Load up links in admin bar so theme is edit
function adventure_theme_options_add_page() {
	add_theme_page('Theme Customizer', 'Theme Customizer', 'edit_theme_options', 'customize.php' );
    add_theme_page('Theme Information', 'Theme Information', 'edit_theme_options', 'theme_options', 'adventure_theme_options_do_page');}
	
// Add link to theme options in Admin bar
function adventure_admin_link() {
	global $wp_admin_bar;
	$wp_admin_bar->add_menu( array( 'id' => 'Adventure_Customizer', 'title' => 'Theme Customizer', 'href' => admin_url( 'customize.php' ) ));
	$wp_admin_bar->add_menu( array( 'id' => 'Adventure_Information', 'title' => 'Theme Information', 'href' => admin_url( 'themes.php?page=theme_options' ) )); }

add_action( 'admin_bar_menu', 'adventure_admin_link', 113 );

// The follow code adds a box to posts and pages to upload images for custom backgrounds
add_action( 'add_meta_boxes', 'featured_background_add_meta_box' );
function featured_background_add_meta_box() {
	add_meta_box( 'featured_background1', 'Featured Background Image', 'featured_background_met_box', 'post', 'side', 'high' ); }

add_action( 'add_meta_boxes', 'featured_background_box' );
function featured_background_box() {
	add_meta_box( 'featured_background1', 'Featured Background Image', 'featured_background_met_box', 'page', 'side', 'high' ); }

// Create the meta box and populate it with the options
function featured_background_met_box( $post ) {
	$values = get_post_custom( $post->ID );
	$featured_background = isset( $values['meta-image'] ) ? esc_attr( $values['meta-image'][0] ) : '';
	wp_nonce_field( 'featured_background_meta_box_nonce', 'meta_box_nonce' );
	?>

	<p>
	<label for="meta-image" class="example-row-title" style="text-align:justify;">Try to keep this image size smaller than 400kb and a resolution around 1920 by 1080.<br><br></label>
    <?php if (empty($featured_background)): else: ?><img alt="Featured Background Image" src="<?php echo $featured_background; ?>" style="box-shadow:0 0 .05em rgba(19,19,19,.5); height:auto; width:100%;"><?php endif; ?>
	<input type="text" name="meta-image" id="meta-image" value="<?php echo $featured_background; ?>" style="width:100%;" />  
	<input type="button" id="meta-image-button" class="button" value="Select Image" style="float:right; margin:.5em 0 0;" />
	</p>
	<div style="clear:both"></div><?php }

// Save the data that is entered into the fields
function featured_background_meta_box_save( $post_id ) {

	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'featured_background_meta_box_nonce' ) ) return;

	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;

	// now we can actually save the data
	$allowed = array( 
		'a' => array( // on allow a tags
			'href' => array()));// and those anchords can only have href attribute
	
	// Probably a good idea to make sure your data is set
	if( isset( $_POST['meta-image'] ) )
		update_post_meta( $post_id, 'meta-image', wp_kses( $_POST['meta-image'], $allowed ) ); }

add_action( 'save_post', 'featured_background_meta_box_save' );

// Loads the image management javascript
function example_image_enqueue() {
    global $typenow;
    if( ($typenow == 'post') || ($typenow == 'page') ) {
        wp_enqueue_media();
 
        // Registers and enqueues the required javascript.
        wp_register_script( 'meta-image', get_template_directory_uri() . '/meta-image.js', array( 'jquery' ) );
        wp_localize_script( 'meta-image', 'meta_image',
            array(
                'title' => 'Choose or Upload a File',
                'button' => 'Use this file',
            )
        );
        wp_enqueue_script( 'meta-image' );
    } // End if
} // End example_image_enqueue()
add_action( 'admin_enqueue_scripts', 'example_image_enqueue' );

// Checks for input and saves if needed
if( isset( $_POST[ 'meta-image' ] ) ) {
    update_post_meta( $post_id, 'meta-image', $_POST[ 'meta-image' ] ); }

// Sets up the Customize.php for Adventure (More to come)
function adventure_customize($wp_customize) {

	// Before we begin let's create a textarea input
	class adventure_Customize_Textarea_Control extends WP_Customize_Control {
    
		public $type = 'textarea';
	 
		public function render_content() { ?>
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="1" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label> <?php } }

	// The Standard Sections for Theme Custimizer
	$wp_customize->add_section( 'header_section', array(
        'title'				=> 'Header',
		'priority'			=> 26, ));

	$wp_customize->add_section( 'nav', array(
        'title'				=> 'Menu',
		'priority'			=> 27, ));

	$wp_customize->add_section( 'background_image', array(
        'title'				=> 'Background',
		'priority'			=> 28, ));

	$wp_customize->add_section( 'content_section', array(
        'title'				=> 'Content',
        'priority'			=> 29, ));

	$wp_customize->add_section( 'sidebar_section', array(
        'title'				=> 'Sidebar',
        'priority'			=> 30, ));

	$wp_customize->add_section( 'links_section', array(
        'title'				=> 'Links',
        'priority'			=> 32, ));

	// Remove the Section Colors for the Sake of making Sense
	$wp_customize->remove_section( 'colors');

	// Background needed to be moved to to the Background Section
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
		'label'				=> 'Background Color',
		'section'			=> 'background_image', )));

	// Change Site Title Color
	$wp_customize->add_setting( 'titlecolor_setting', array(
		'default'			=> '#eee2d6', ));

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'titlecolor_control', array(
		'label'				=> 'Site Title Color - #eee2d6',
		'section'			=> 'title_tagline',
		'settings'			=> 'titlecolor_setting', )));

	// Change Tagline Color
	$wp_customize->add_setting( 'taglinecolor_setting', array(
		'default'			=> '#066ba0', ));

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'taglinecolor_control', array(
		'label'				=> 'Site Title Color - #066ba0',
		'section'			=> 'title_tagline',
		'settings'			=> 'taglinecolor_setting', )));

	// Choose the Different Images for the Banner
	$wp_customize->add_setting('bannerimage_setting', array(
		'default'			=> 'purple.png',
		'capability'		=> 'edit_theme_options',
		'type'				=> 'option', ));

	$wp_customize->add_control('themename_color_scheme', array(
		'label'				=> 'Banner Background',
		'priority'			=> 1,
		'section'			=> 'header_section',
		'settings'			=> 'bannerimage_setting',
		'type'				=> 'radio',
		'choices'			=> array(
			'purple.png'	=> 'Purple (Default)',
			'blue.png'		=> 'Blue',
			'marble.png'	=> 'Marble',
			'green.png'		=> 'Green', ), ));

	// Upload and Customization for the Banner and Header Options
	$wp_customize->add_setting('menu_setting', array(
		'default'			=> 'standard',
		'capability'		=> 'edit_theme_options',
		'type'				=> 'option', ));

	$wp_customize->add_control('menu_control', array(
		'label'				=> 'Menu Display Options',
		'priority'			=> 6,
		'section'			=> 'header_section',
		'settings'			=> 'menu_setting',
		'type'				=> 'radio',
		'choices'			=> array(
			'standard'		=> 'Standard (Default)',
			'notitle'		=> 'No Title',
			'bottom'		=> 'Moves Menu To Bottom', ), ));
			
	// Turn the Search bar in the navigation on or off
	$wp_customize->add_setting( 'navi_search_setting', array(
		'default'           	=> 'off',
		'control'           	=> 'select',));

	$wp_customize->add_control( 'navi_search_control', array(
		'label'					=> 'Search bar in navigaton',
		'section'				=> 'nav',
		'settings'				=> 'navi_search_setting',
		'type'					=> 'select',
		'choices'				=> array(
			'off'				=> 'Do not display search',
			'on'				=> 'Display the search',), ));
			
	// Turn the date / time on post on or off
	$wp_customize->add_setting( 'display_date_setting', array(
		'default'           	=> 'on',
		'control'           	=> 'select',));

	$wp_customize->add_control( 'display_date_control', array(
		'section'				=> 'content_section',
		'label'					=> 'Display the date',
		'settings'				=> 'display_date_setting',
		'type'					=> 'select',
		'choices'				=> array(
			'on'				=> 'Display the dates',
			'off'				=> 'Do not display dates',), ));
			
	// Display an excerpt on the landing page
	$wp_customize->add_setting( 'display_excerpt_setting', array(
		'default'           	=> 'off',
		'control'           	=> 'select',));

	$wp_customize->add_control( 'display_excerpt_control', array(
		'section'				=> 'content_section',
		'label'					=> 'Display excerpt on paged content',
		'settings'				=> 'display_excerpt_setting',
		'type'					=> 'select',
		'choices'				=> array(
			'off'				=> 'Display the content',
			'on'				=> 'Display the excerpt',), ));
			
	// Add Facebook Icon to the navigation
	$wp_customize->add_setting( 'facebook_setting', array(
		'default'			=> 'The url link goes in here.', ));

	$wp_customize->add_control( new adventure_Customize_Textarea_Control( $wp_customize, 'facebook_control', array(
		'label'				=> 'Facebook icon in the Menu',
		'priority'			=> 50,
		'section'			=> 'nav',
		'settings'			=> 'facebook_setting', )));
			
	// Add Twitter Icon to the navigation
	$wp_customize->add_setting( 'twitter_setting', array(
		'default'			=> 'The url link goes in here.', ));

	$wp_customize->add_control( new adventure_Customize_Textarea_Control( $wp_customize, 'twitter_control', array(
		'label'				=> 'Twitter icon in the Menu',
		'priority'			=> 51,
		'section'			=> 'nav',
		'settings'			=> 'twitter_setting', )));
			
	// Add Google+ Icon to the navigation
	$wp_customize->add_setting( 'google_plus_setting', array(
		'default'			=> 'The url link goes in here.', ));

	$wp_customize->add_control( new adventure_Customize_Textarea_Control( $wp_customize, 'google_plus_control', array(
		'label'				=> 'Google Plus icon in the Menu',
		'priority'			=> 52,
		'section'			=> 'nav',
		'settings'			=> 'google_plus_setting', )));
			
	// Add YouTube Icon to the navigation
	$wp_customize->add_setting( 'youtube_setting', array(
		'default'			=> 'The url link goes in here.', ));

	$wp_customize->add_control( new adventure_Customize_Textarea_Control( $wp_customize, 'youtube_control', array(
		'label'				=> 'Youtube icon in the Menu',
		'priority'			=> 54,
		'section'			=> 'nav',
		'settings'			=> 'youtube_setting', )));
			
	// Add Vimeo Icon to the navigation
	$wp_customize->add_setting( 'vimeo_setting', array(
		'default'			=> 'The url link goes in here.', ));

	$wp_customize->add_control( new adventure_Customize_Textarea_Control( $wp_customize, 'vimeo_control', array(
		'label'				=> 'Vimeo icon in the Menu',
		'priority'			=> 55,
		'section'			=> 'nav',
		'settings'			=> 'vimeo_setting', )));
			
	// Add Soundcloud Icon to the navigation
	$wp_customize->add_setting( 'soundcloud_setting', array(
		'default'			=> 'The url link goes in here.', ));

	$wp_customize->add_control( new adventure_Customize_Textarea_Control( $wp_customize, 'soundcloud_control', array(
		'label'				=> 'Soundcloud icon in the Menu',
		'priority'			=> 56,
		'section'			=> 'nav',
		'settings'			=> 'soundcloud_setting', )));

	// Create an Array with a ton of google fonts	
	$google_font_array = array(
			'Default'				=> 'Default',
			'Questrial'				=> 'Questrial',
			'Astloch'				=> 'Astloch',
			'IM+Fell+English+SC'	=> 'IM+Fell+English+SC',
			'Lekton'				=> 'Lekton',
			'Nova+Round'			=> 'Nova+Round',
			'Nova+Oval'				=> 'Nova+Oval',
			'League+Script'			=> 'League+Script',
			'Caudex'				=> 'Caudex',
			'IM+Fell+DW+Pica'		=> 'IM+Fell+DW+Pica',
			'Nova+Script'			=> 'Nova+Script',
			'Nixie+One'				=> 'Nixie+One',
			'IM+Fell+DW+Pica+SC'	=> 'IM+Fell+DW+Pica+SC',
			'Puritan'				=> 'Puritan',
			'Prociono'				=> 'Prociono',
			'Abel'					=> 'Abel',
			'Snippet'				=> 'Snippet',
			'Kristi'				=> 'Kristi',
			'Mako'					=> 'Mako',
			'Ubuntu+Mono'			=> 'Ubuntu+Mono',
			'Nova+Slim'				=> 'Nova+Slim',
			'Patrick+Hand'			=> 'Patrick+Hand',
			'Crafty+Girls'			=> 'Crafty+Girls',
			'Brawler'				=> 'Brawler',
			'Droid+Sans'			=> 'Droid+Sans',
			'Geostar'				=> 'Geostar',
			'Yellowtail'			=> 'Yellowtail',
			'Permanent+Marker'		=> 'Permanent+Marker',
			'Just+Another+Hand'		=> 'Just+Another+Hand',
			'Unkempt'				=> 'Unkempt',
			'Jockey+One'			=> 'Jockey+One',
			'Lato'					=> 'Lato',
			'Arvo'					=> 'Arvo',
			'Cabin'					=> 'Cabin',
			'Playfair+Display'		=> 'Playfair+Display',
			'Crushed'				=> 'Crushed',
			'Asset'					=> 'Asset',
			'Sue+Ellen+Francisco'	=> 'Sue+Ellen+Francisco',
			'Julee'					=> 'Julee',
			'Judson'				=> 'Judson',
			'Neuton'				=> 'Neuton',
			'Sorts+Mill+Goudy'		=> 'Sorts+Mill+Goudy',
			'Mate'					=> 'Mate',
			'News+Cycle'			=> 'News+Cycle',
			'Michroma'				=> 'Michroma',
			'Lora'					=> 'Lora',
			'Give+You+Glory'		=> 'Give+You+Glory',
			'Rammetto+One'			=> 'Rammetto+One',
			'Pompiere'				=> 'Pompiere',
			'PT+Sans'				=> 'PT+Sans',
			'Andika'				=> 'Andika',
			'Cabin+Sketch'			=> 'Cabin+Sketch',
			'Delius+Swash+Caps'		=> 'Delius+Swash+Caps',
			'Coustard'				=> 'Coustard',
			'Cherry+Cream+Soda'		=> 'Cherry+Cream+Soda',
			'Maiden+Orange'			=> 'Maiden+Orange',
			'Syncopate'				=> 'Syncopate',
			'PT+Sans+Narrow'		=> 'PT+Sans+Narrow',
			'Montez'				=> 'Montez',
			'Short+Stack'			=> 'Short+Stack',
			'Poller+One'			=> 'Poller+One',
			'Tinos'					=> 'Tinos',
			'Philosopher'			=> 'Philosopher',
			'Neucha'				=> 'Neucha',
			'Gravitas+One'			=> 'Gravitas+One',
			'Corben'				=> 'Corben',
			'Istok+Web'				=> 'Istok+Web',
			'Federo'				=> 'Federo',
			'Yeseva+One'			=> 'Yeseva+One',
			'Petrona'				=> 'Petrona',
			'Arimo'					=> 'Arimo',
			'Irish+Grover'			=> 'Irish+Grover',
			'Quicksand'				=> 'Quicksand',
			'Paytone+One'			=> 'Paytone+One',
			'Kelly+Slab'			=> 'Kelly+Slab',
			'Nova+Flat'				=> 'Nova+Flat',
			'Vast+Shadow'			=> 'Vast+Shadow',
			'Ubuntu'				=> 'Ubuntu',
			'Smokum'				=> 'Smokum',
			'Ruslan+Display'		=> 'Ruslan+Display',
			'La+Belle+Aurore'		=> 'La+Belle+Aurore',
			'Federant'				=> 'Federant',
			'Podkova'				=> 'Podkova',
			'IM+Fell+French+Canon'	=> 'IM+Fell+French+Canon',
			'PT+Serif+Caption'		=> 'PT+Serif+Caption',
			'The+Girl+Next+Door'	=> 'The+Girl+Next+Door',
			'Artifika'				=> 'Artifika',
			'Marck+Script'			=> 'Marck+Script',
			'Droid+Sans+Mono'		=> 'Droid+Sans+Mono',
			'Contrail+One'			=> 'Contrail+One',
			'Swanky+and+Moo+Moo'	=> 'Swanky+and+Moo+Moo',
			'Wire+One'				=> 'Wire+One',
			'Tenor+Sans'			=> 'Tenor+Sans',
			'Nova+Mono'				=> 'Nova+Mono',
			'Josefin+Sans'			=> 'Josefin+Sans',
			'Bitter'				=> 'Bitter',
			'Supermercado+One'		=> 'Supermercado+One',
			'PT+Serif'				=> 'PT+Serif',
			'Limelight'				=> 'Limelight',
			'Coda+Caption:800'		=> 'Coda+Caption:800',
			'Lobster'				=> 'Lobster',
			'Gentium+Basic'			=> 'Gentium+Basic',
			'Atomic+Age'			=> 'Atomic+Age',
			'Mate+SC'				=> 'Mate+SC',
			'Eater+Caps'			=> 'Eater+Caps',
			'Bigshot+One'			=> 'Bigshot+One',
			'Kreon'					=> 'Kreon',
			'Rationale'				=> 'Rationale',
			'Sniglet:800'			=> 'Sniglet:800',
			'Smythe'				=> 'Smythe',
			'Waiting+for+the+Sunrise' => 'Waiting+for+the+Sunrise',
			'Gochi+Hand'			=> 'Gochi+Hand',
			'Reenie+Beanie'			=> 'Reenie+Beanie',
			'Kameron'				=> 'Kameron',
			'Anton'					=> 'Anton',
			'Holtwood+One+SC'		=> 'Holtwood+One+SC',
			'Schoolbell'			=> 'Schoolbell',
			'Tulpen+One'			=> 'Tulpen+One',
			'Redressed'				=> 'Redressed',
			'Ovo'					=> 'Ovo',
			'Shadows+Into+Light'	=> 'Shadows+Into+Light',
			'Rokkitt'				=> 'Rokkitt',
			'Josefin+Slab'			=> 'Josefin+Slab',
			'Passero+One'			=> 'Passero+One',
			'Copse'					=> 'Copse',
			'Walter+Turncoat'		=> 'Walter+Turncoat',
			'Sigmar+One'			=> 'Sigmar+One',
			'Convergence'			=> 'Convergence',
			'Gloria+Hallelujah'		=> 'Gloria+Hallelujah',
			'Fontdiner+Swanky'		=> 'Fontdiner+Swanky',
			'Tienne'				=> 'Tienne',
			'Calligraffitti'		=> 'Calligraffitti',
			'UnifrakturCook:700'	=> 'UnifrakturCook:700',
			'Tangerine'				=> 'Tangerine',
			'Days+One'				=> 'Days+One',
			'Cantarell'				=> 'Cantarell',
			'IM+Fell+Great+Primer'	=> 'IM+Fell+Great+Primer',
			'Antic'					=> 'Antic',
			'Muli'					=> 'Muli',
			'Monofett'				=> 'Monofett',
			'Just+Me+Again+Down+Here' => 'Just+Me+Again+Down+Here',
			'Geostar+Fill'			=> 'Geostar+Fill',
			'Candal'				=> 'Candal',
			'Cousine'				=> 'Cousine',
			'Merienda+One'			=> 'Merienda+One',
			'Goblin+One'			=> 'Goblin+One',
			'Monoton'				=> 'Monoton',
			'Ubuntu+Condensed'		=> 'Ubuntu+Condensed',
			'EB+Garamond'			=> 'EB+Garamond',
			'Droid+Serif'			=> 'Droid+Serif',
			'Lancelot'				=> 'Lancelot',
			'Cookie'				=> 'Cookie',
			'Fjord+One'				=> 'Fjord+One',
			'Arapey'				=> 'Arapey',
			'Rancho'				=> 'Rancho',
			'Sancreek'				=> 'Sancreek',
			'Butcherman+Caps'		=> 'Butcherman+Caps',
			'Salsa'					=> 'Salsa',
			'Amatic+SC'				=> 'Amatic+SC',
			'Creepster+Caps'		=> 'Creepster+Caps',
			'Chivo'					=> 'Chivo',
			'Linden+Hill'			=> 'Linden+Hill',
			'Nosifer+Caps'			=> 'Nosifer+Caps',
			'Marvel'				=> 'Marvel',
			'Alice'					=> 'Alice',
			'Love+Ya+Like+A+Sister' => 'Love+Ya+Like+A+Sister',
			'Pinyon+Script'			=> 'Pinyon+Script',
			'Stardos+Stencil'		=> 'Stardos+Stencil',
			'Leckerli+One'			=> 'Leckerli+One',
			'Nothing+You+Could+Do'	=> 'Nothing+You+Could+Do',
			'Sansita+One'			=> 'Sansita+One',
			'Poly'					=> 'Poly',
			'Alike'					=> 'Alike',
			'Fanwood+Text'			=> 'Fanwood+Text',
			'Bowlby+One+SC'			=> 'Bowlby+One+SC',
			'Actor'					=> 'Actor',
			'Terminal+Dosis'		=> 'Terminal+Dosis',
			'Aclonica'				=> 'Aclonica',
			'Gentium+Book+Basic'	=> 'Gentium+Book+Basic',
			'Rosario'				=> 'Rosario',
			'Satisfy'				=> 'Satisfy',
			'Sunshiney'				=> 'Sunshiney',
			'Aubrey'				=> 'Aubrey',
			'Jura'					=> 'Jura',
			'Ultra'					=> 'Ultra',
			'Zeyada'				=> 'Zeyada',
			'Changa+One'			=> 'Changa+One',
			'Varela'				=> 'Varela',
			'Black+Ops+One'			=> 'Black+Ops+One',
			'Open+Sans'				=> 'Open+Sans',
			'Alike+Angular'			=> 'Alike+Angular',
			'Prata'					=> 'Prata',
			'Bowlby+One'			=> 'Bowlby+One',
			'Megrim'				=> 'Megrim',
			'Damion'				=> 'Damion',
			'Coda'					=> 'Coda',
			'Vidaloka'				=> 'Vidaloka',
			'Radley'				=> 'Radley',
			'Indie+Flower'			=> 'Indie+Flower',
			'Over+the+Rainbow'		=> 'Over+the+Rainbow',
			'Open+Sans+Condensed:300' => 'Open+Sans+Condensed:300',
			'Abril+Fatface'			=> 'Abril+Fatface',
			'Miltonian'				=> 'Miltonian',
			'Delius'				=> 'Delius',
			'Six+Caps'				=> 'Six+Caps',
			'Francois+One'			=> 'Francois+One',
			'Dorsa'					=> 'Dorsa',
			'Aldrich'				=> 'Aldrich',
			'Buda:300'				=> 'Buda:300',
			'Rochester'				=> 'Rochester',
			'Allerta'				=> 'Allerta',
			'Bevan'					=> 'Bevan',
			'Wallpoet'				=> 'Wallpoet',
			'Quattrocento'			=> 'Quattrocento',
			'Dancing+Script'		=> 'Dancing+Script',
			'Amaranth'				=> 'Amaranth',
			'Unna'					=> 'Unna',
			'PT+Sans+Caption'		=> 'PT+Sans+Caption',
			'Geo'					=> 'Geo',
			'Quattrocento+Sans'		=> 'Quattrocento+Sans',
			'Oswald'				=> 'Oswald',
			'Carme'					=> 'Carme',
			'Spinnaker'				=> 'Spinnaker',
			'MedievalSharp'			=> 'MedievalSharp',
			'Nova+Square'			=> 'Nova+Square',
			'IM+Fell+French+Canon+SC' => 'IM+Fell+French+Canon+SC',
			'Voltaire'				=> 'Voltaire',
			'Raleway:100'			=> 'Raleway:100',
			'Delius+Unicase'		=> 'Delius+Unicase',
			'Shanti'				=> 'Shanti',
			'Expletus+Sans'			=> 'Expletus+Sans',
			'Crimson+Text'			=> 'Crimson+Text',
			'Nunito'				=> 'Nunito',
			'Numans'				=> 'Numans',
			'Hammersmith+One'		=> 'Hammersmith+One',
			'Miltonian+Tattoo'		=> 'Miltonian+Tattoo',
			'Allerta+Stencil'		=> 'Allerta+Stencil',
			'Vollkorn'				=> 'Vollkorn',
			'Pacifico'				=> 'Pacifico',
			'Cedarville+Cursive'	=> 'Cedarville+Cursive',
			'Cardo'					=> 'Cardo',
			'Merriweather'			=> 'Merriweather',
			'Loved+by+the+King'		=> 'Loved+by+the+King',
			'Slackey'				=> 'Slackey',
			'Nova+Cut'				=> 'Nova+Cut',
			'Rock+Salt'				=> 'Rock+Salt',
			'Yanone+Kaffeesatz'		=> 'Yanone+Kaffeesatz',
			'Molengo'				=> 'Molengo',
			'Nobile'				=> 'Nobile',
			'Goudy+Bookletter+1911' => 'Goudy+Bookletter+1911',
			'Bangers'				=> 'Bangers',
			'Old+Standard+TT'		=> 'Old+Standard+TT',
			'Orbitron'				=> 'Orbitron',
			'Comfortaa'				=> 'Comfortaa',
			'Varela+Round'			=> 'Varela+Round',
			'Forum'					=> 'Forum',
			'Maven+Pro'				=> 'Maven+Pro',
			'Volkhov'				=> 'Volkhov',
			'Allan:700'				=> 'Allan:700',
			'Luckiest+Guy'			=> 'Luckiest+Guy',
			'Gruppo'				=> 'Gruppo',
			'Cuprum'				=> 'Cuprum',
			'Anonymous+Pro'			=> 'Anonymous+Pro',
			'UnifrakturMaguntia'	=> 'UnifrakturMaguntia',
			'Covered+By+Your+Grace' => 'Covered+By+Your+Grace',
			'Homemade+Apple'		=> 'Homemade+Apple',
			'Lobster+Two'			=> 'Lobster+Two',
			'Coming+Soon'			=> 'Coming+Soon',
			'Mountains+of+Christmas' => 'Mountains+of+Christmas',
			'Architects+Daughter'	=> 'Architects+Daughter',
			'Dawning+of+a+New+Day'	=> 'Dawning+of+a+New+Day',
			'Kranky'				=> 'Kranky',
			'Adamina'				=> 'Adamina',
			'Carter+One'			=> 'Carter+One',
			'Bentham'				=> 'Bentham',
			'IM+Fell+Great+Primer+SC' => 'IM+Fell+Great+Primer+SC',
			'Chewy'					=> 'Chewy',
			'IM+Fell+English'		=> 'IM+Fell+English',
			'Inconsolata'			=> 'Inconsolata',
			'Vibur'					=> 'Inconsolata',
			'Andada'				=> 'Andada',
			'IM+Fell+Double+Pica'	=> 'IM+Fell+Double+Pica',
			'Kenia'					=> 'Kenia',
			'Meddon'				=> 'Meddon',
			'Metrophobic'			=> 'Metrophobic',
			'Play'					=> 'Play',
			'Special+Elite'			=> 'Special+Elite',
			'IM+Fell+Double+Pica+SC' => 'IM+Fell+Double+Pica+SC',
			'Didact+Gothic'			=> 'Didact+Gothic',
			'Modern+Antiqua'		=> 'Modern+Antiqua',
			'VT323'					=> 'VT323',
			'Annie+Use+Your+Telescope' => 'Annie+Use+Your+Telescope');			
			
	// Adjust the Space Between the Top of the Page and Content
	$wp_customize->add_setting( 'titlefontstyle_setting', array(
		'Default'           => 'Default',
		'control'           => 'select',));

	$wp_customize->add_control( 'titlefontstyle_control', array(
		'label'					=> 'Google Webfonts Site Title',
		'priority'				=> 10,
		'section'				=> 'title_tagline',
		'settings'				=> 'titlefontstyle_setting',
		'type'					=> 'select',
		'choices'				=> $google_font_array, ));
			
	// Adjust the Space Between the Top of the Page and Content
	$wp_customize->add_setting( 'taglinefontstyle_setting', array(
		'Default'           => 'Default',
		'control'           => 'select',));

	$wp_customize->add_control( 'taglinefontstyle_control', array(
		'label'					=> 'Google Webfonts Tagline',
		'priority'				=> 11,
		'section'				=> 'title_tagline',
		'settings'				=> 'taglinefontstyle_setting',
		'type'					=> 'select',
		'choices'				=> $google_font_array, ));

	// Adjust the Space Between the Top of the Page and Content
	$wp_customize->add_setting( 'headerspacing_setting', array(
		'default'           => '35%',
		'control'           => 'select',));

	$wp_customize->add_control( 'headerspacing_control', array(
		'label'				=> 'Adjust the Spacing Between Top and Content',
		'priority'			=> 90,
		'section'			=> 'header_section',
		'settings'			=> 'headerspacing_setting',
		'type'				=> 'select',
		'choices'			=> array(
			'95'			=> '95%',
			'90'			=> '90%',
			'85'			=> '85%',
			'80'			=> '80%',
			'75'			=> '75%',
			'70'			=> '70%',
			'65'			=> '65%',
			'60'			=> '60%',
			'55'			=> '55%',
			'50'			=> '50%',
			'45'			=> '45%',
			'40'			=> '40%',
			'35'			=> '35% Default',
			'30'			=> '30%',
			'25'			=> '25%',
			'20'			=> '20%',
			'15'			=> '15%',
			'10'			=> '10%',
			'5'				=> '5%',), ));

	// Add the option to use the CSS3 property Background-size
	$wp_customize->add_setting( 'backgroundsize_setting', array(
		'default'           => 'auto',
		'control'           => 'select',));

	$wp_customize->add_control( 'backgroundsize_control', array(
		'label'				=> 'Background Size',
		'section'			=> 'background_image',
		'settings'			=> 'backgroundsize_setting',
		'priority'			=> 10,
		'type'				=> 'radio',
		'choices'			=> array(
			'auto'			=> 'Auto (Default)',
			'contain'		=> 'Contain',
			'cover'			=> 'Cover',), ));

	// Change the color of the Content Background
	$wp_customize->add_setting( 'backgroundcolor_setting', array(
		'default'           => '#b4b09d',
		'control'           => 'select',));

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'backgroundcolor_control', array(
		'label'				=> 'Color of the Content Background',
		'section'			=> 'content_section',
		'settings'			=> 'backgroundcolor_setting', )));

	// Change the opacity of the Content Background
	$wp_customize->add_setting( 'contentbackground_setting', array(
		'default'           => '.80',
		'control'           => 'select',));

	$wp_customize->add_control( 'contentbackground_control', array(
		'label'				=> 'Transparency of Content Background',
		'section'			=> 'content_section',
		'settings'			=> 'contentbackground_setting',
		'type'				=> 'select',
		'choices'			=> array(
			'1'				=> '100',
			'.95'			=> '95',
			'.90'			=> '90',
			'.85'			=> '85',
			'.80'			=> '80 (Default)',
			'.75'			=> '75',
			'.70'			=> '70',
			'.65'			=> '65',
			'.60'			=> '60',
			'.55'			=> '55',
			'.50'			=> '50',
			'.45'			=> '45',
			'.40'			=> '40',
			'.35'			=> '35',
			'.30'			=> '30',
			'.25'			=> '25',
			'.20'			=> '20',
			'.15'			=> '15',
			'.10'			=> '10',
			'.05'			=> '5',
			'.00'			=> '0',), ));

	// Settings for the Previous & Next Post Link
	$wp_customize->add_setting( 'previousnext_setting', array(
		'default'           => 'both',
		'control'           => 'radio',));

	$wp_customize->add_control( 'previousnext_control', array(
		'label'				=> 'Previous & Next Links After Content',
		'section'			=> 'content_section',
		'settings'			=> 'previousnext_setting',
		'type'				=> 'radio',
		'choices'			=> array(
			'both'			=> 'Both Pages & Posts',
			'posts'			=> 'Only Posts',
			'pages'			=> 'Only Pages',
			'neither'		=> 'Neither', ), ));

	// Settings for the text about the Author
	$wp_customize->add_setting( 'author_setting', array(
		'default'           => 'on',
		'control'           => 'radio',));

	$wp_customize->add_control( 'author_control', array(
		'label'				=> 'Author Information',
		'section'			=> 'content_section',
		'settings'			=> 'author_setting',
		'type'				=> 'radio',
		'choices'			=> array(
			'on'             => 'On',
			'off'            => 'Off', ), ));
			
	// Comments Choice
	$wp_customize->add_setting( 'comments_setting', array(
		'default'           	=> 'pages_and_posts',
		'control'           	=> 'select',));

	$wp_customize->add_control( 'comments_control', array(
		'section'				=> 'content_section',
		'label'					=> 'Options for Displaying Comments',
		'settings'				=> 'comments_setting',
		'type'					=> 'radio',
		'choices'				=> array(
			'pages_and_posts'	=> 'Comments on both Pages & Posts',
			'posts'				=> 'Comments only on Posts',
			'pages'				=> 'Comments only on Pages',
			'none'				=> 'Comments completely Off',), ));

	// Turn the information for the comments On or Off
	$wp_customize->add_setting( 'commentsclosed_setting', array(
		'default'           => 'on',
		'control'           => 'radio',));

	$wp_customize->add_control( 'commentsclosed_control', array(
		'label'				=> 'Comment Information',
		'section'			=> 'content_section',
		'settings'			=> 'commentsclosed_setting',
		'type'				=> 'radio',
		'choices'			=> array(
			'on'             => 'On',
			'off'            => 'Off', ), ));

	// Adjust the position of the sidebar to be on the left or the right
	$wp_customize->add_setting( 'sidebar_position_setting', array(
		'default'           => 'left',
		'control'           => 'radio',));

	$wp_customize->add_control( 'sidebar_position_control', array(
		'label'				=> 'Sidebar Position',
		'section'			=> 'sidebar_section',
		'settings'			=> 'sidebar_position_setting',
		'type'				=> 'radio',
		'choices'			=> array(
			'right'          => 'Right',
			'left'            => 'Left', ), ));

	// Change the color of the Sidebar Background
	$wp_customize->add_setting( 'sidebarcolor_setting', array(
		'default'           => '#000000',
		'control'           => 'select',));

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebarcolor_control', array(
		'label'				=> 'Color of the Sidebar Background',
		'section'			=> 'sidebar_section',
		'settings'			=> 'sidebarcolor_setting', )));

	// Change the opacity of the Sidebar Background
	$wp_customize->add_setting( 'sidebarbackground_setting', array(
		'default'           => '.50',
		'control'           => 'select',));

	$wp_customize->add_control( 'sidebarbackground_control', array(
		'label'				=> 'Transparency of Sidebar Background',
		'section'			=> 'sidebar_section',
		'settings'			=> 'sidebarbackground_setting',
		'type'				=> 'select',
		'choices'			=> array(
			'1'				=> '100',
			'.95'			=> '95',
			'.90'			=> '90',
			'.85'			=> '85',
			'.75'			=> '75',
			'.70'			=> '70',
			'.65'			=> '65',
			'.60'			=> '60',
			'.55'			=> '55',
			'.50'			=> '50 (Default)',
			'.45'			=> '45',
			'.40'			=> '40',
			'.35'			=> '35',
			'.30'			=> '30',
			'.25'			=> '25',
			'.20'			=> '20',
			'.15'			=> '15',
			'.10'			=> '10',
			'.05'			=> '5',
			'.00'			=> '0',), )); }

add_action('customize_register', 'adventure_customize');

// Preview CSS3 Property Background-size in Customizer
function adventure_customizer_preview() {
	wp_enqueue_script('adventure-customizer', get_template_directory_uri() . '/js/customizer.js', array('jquery'), '1.3', true);}

add_action( 'customize_controls_print_footer_scripts', 'adventure_customizer_preview', 10 );
	
// Inject the Customizer Choices into the Theme
function adventure_inline_css() {
		
		// Convert Content from Hex to RGB
		if ( get_theme_mod('backgroundcolor_setting') != '#b4b09d' ) {
			$hex = str_replace("#", "", get_theme_mod('backgroundcolor_setting'));
			if(strlen($hex) == 3) {
				$r = hexdec(substr($hex,0,1).substr($hex,0,1));
				$g = hexdec(substr($hex,1,1).substr($hex,1,1));
				$b = hexdec(substr($hex,2,1).substr($hex,2,1)); }
			else {
				$r = hexdec(substr($hex,0,2));
				$g = hexdec(substr($hex,2,2));
				$b = hexdec(substr($hex,4,2)); } }

		// Convert Sidebar from Hex to RGB
		if ( ( get_theme_mod('sidebarcolor_setting') != '#000000' ) || ( get_theme_mod('backgroundcolor_setting') != '#b4b09d' ) ) {
		$hexs = str_replace("#", "", get_theme_mod('sidebarcolor_setting'));

		if(strlen($hexs) == 3) {
			$rs = hexdec(substr($hexs,0,1).substr($hexs,0,1));
			$gs = hexdec(substr($hexs,1,1).substr($hexs,1,1));
			$bs = hexdec(substr($hexs,2,1).substr($hexs,2,1)); }
		else {
			$rs = hexdec(substr($hexs,0,2));
			$gs = hexdec(substr($hexs,2,2));
			$bs = hexdec(substr($hexs,4,2)); } }
		
		echo '<!-- Custom Font Styles -->' . "\n";
		if ( ( get_theme_mod('titlefontstyle_setting') != 'Default' ) && ( get_theme_mod('titlefontstyle_setting') != '' ) ) {	echo "<link href='http://fonts.googleapis.com/css?family=" . get_theme_mod('titlefontstyle_setting') . "' rel='stylesheet' type='text/css'>"  . "\n"; }
		if ( ( get_theme_mod('taglinefontstyle_setting') != 'Default' ) && ( get_theme_mod('taglinefontstyle_setting') != 'Default' ) ) {	echo "<link href='http://fonts.googleapis.com/css?family=" . get_theme_mod('taglinefontstyle_setting') . "' rel='stylesheet' type='text/css'>"  . "\n"; }
		echo '<!-- End Custom Fonts -->' . "\n\n";

		echo '<!-- Custom CSS Styles -->' . "\n";
        echo '<style type="text/css" media="screen">' . "\n";
        $featured_background = get_post_meta( get_the_ID(), 'meta-image', true ); if (!empty($featured_background)) echo 'body {background-image:url(' . $featured_background . ');' . "\n";
		if ( ( get_theme_mod('backgroundsize_setting') != 'auto' ) && ( get_theme_mod('backgroundsize_setting') != '' ) ) echo '	body.custom-background {background-size:' . get_theme_mod('backgroundsize_setting') . ';}' . "\n";
		if ( ( get_theme_mod('backgroundcolor_setting') != '#b4b09d' ) && ( get_theme_mod('backgroundcolor_setting') != '' ) ) echo '	#content>li {background: rgba(' . $r . ',' . $g . ', ' . $b . ', ' .  get_theme_mod('contentbackground_setting') .  ');}' . "\n";
		if ( ( get_theme_mod('sidebarcolor_setting') != '#000000'  ) || ( get_theme_mod('backgroundcolor_setting') != '#b4b09d' ) ) echo '	li#sidebar {background: rgba(' . $rs . ',' . $gs . ', ' . $bs . ', ' .  get_theme_mod('sidebarbackground_setting') .  ');}' . "\n";
		if ( ( get_theme_mod('titlecolor_setting') != '#eee2d6' ) && ( get_theme_mod('titlecolor_setting') != '' ) ) echo '	#navi h1 a {color:' . get_theme_mod('titlecolor_setting') . ';}' . "\n";
		if ( ( get_theme_mod('taglinecolor_setting') != '#066ba0' ) && ( get_theme_mod('taglinecolor_setting') != '' ) ) echo '	#navi h1 i {color:' . get_theme_mod('taglinecolor_setting') . ';}' . "\n";
		if ( ( get_option('bannerimage_setting') != 'purple.png' ) && ( get_option('bannerimage_setting') != '' ) ) echo '	#navi {background: bottom url(' . get_template_directory_uri() . '/images/' . get_option('bannerimage_setting') .  ');}'. "\n";
		if ( get_theme_mod('headerspacing_setting') != '35' ) echo '	#spacing {height:' . get_theme_mod('headerspacing_setting') . '%;}'. "\n";
		if ( get_option('menu_setting') == 'notitle' ) { echo '	#navi {position: fixed;margin-top:0px;}' . "\n" . '	.admin-bar #navi {margin-top:28px;}' . "\n" . '#navi h1:first-child, #navi h1:first-child i,  #navi img:first-child {display: none;}' . "\n"; }
		if ( get_option('menu_setting') == 'bottom' ) { echo '	#navi {position: fixed; bottom:0; top:auto;}' . "\n" . '	#navi h1:first-child, #navi h1:first-child i,  #navi img:first-child {display: none;}' . "\n" . '#navi li ul {bottom:2.78em; top:auto;}' . "\n";}
		
		if ( ( get_theme_mod('titlefontstyle_setting') != 'Default' ) && ( get_theme_mod('titlefontstyle_setting') != '' )  ) {
			$q = get_theme_mod('titlefontstyle_setting');
			$q = preg_replace('/[^a-zA-Z0-9]+/', ' ', $q);
		 	echo	"#navi h1 {font-family: '" . $q . "';}" . "\n"; }
		if ( (get_theme_mod('taglinefontstyle_setting') != 'Default') && ( get_theme_mod('taglinefontstyle_setting') != '' )   ) {
			$x = get_theme_mod('taglinefontstyle_setting');
			$x = preg_replace('/[^a-zA-Z0-9]+/', ' ', $x);
			echo	"#navi h1 i {font-family: '" . $x . "';}" . "\n"; }

		echo '</style>' . "\n";
		echo '<!-- End Custom CSS -->' . "\n";
		echo "\n"; }

add_action('wp_head', 'adventure_inline_css');

//	A safe way of adding javascripts to a WordPress generated page
if (!function_exists('adventure_js')) {
	function adventure_js() {
			// JS at the bottom for fast page loading
			wp_enqueue_script('adventure-jquery-easing', get_template_directory_uri() . '/js/jquery.easing.js', array('jquery'), '1.3', true);
            wp_enqueue_script('adventure-menu-scrolling', get_template_directory_uri() . '/js/jquery.menu.scrolling.js', array('jquery'), '1', true);
			wp_enqueue_script('adventure-scripts', get_template_directory_uri() . '/js/jquery.fittext.js', array('jquery'), '1.0', true);
			wp_enqueue_script('adventure-fittext', get_template_directory_uri() . '/js/jquery.fittext.sizing.js', array('jquery'), '1', true);  } }

if (!is_admin()) add_action('wp_enqueue_scripts', 'adventure_js');

// Add some CSS so I can Style the Theme Options Page
function adventure_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style('adventure-theme-options', get_template_directory_uri() . '/theme-options.css', false, '1.0');}

add_action('admin_print_styles-appearance_page_theme_options', 'adventure_admin_enqueue_scripts');
	
// Create the Theme Information page (Theme Options)
function adventure_theme_options_do_page() { ?>
    
    <div class="cover">
    
    <ul id="spacing"></ul>
    
    
    <div class="contain">
            
        <div id="header">
		
			<div class="themetitle">
				<a href="http://schwarttzy.com/shop/adventureplus/" target="_blank" ><h1><?php $my_theme = wp_get_theme(); echo $my_theme->get( 'Name' ); ?></h1>
				<span>- v<?php $my_theme = wp_get_theme(); echo $my_theme->get( 'Version' ); ?></span></a>
			</div>
            
            
			<div class="upgrade">
                <a href="http://schwarttzy.com/shop/adventureplus/" target="_blank" ><h2>Upgrade to Adventure+</h2></a>
            </div>
		
    	</div>
            
        <ul class="info_bar">
			<li><a href="#description">Description</a></li>
			<li><a href="#customizing">Customizing</a></li>
			<li><a href="#features">Features</a></li>
			<li><a href="#faq">FAQ</a></li>
			<!-- <li><a href="#screenshots">Screen Shots</a></li> -->
			<li><a href="#changelog">Changelog</a></li>
			<li><a href="#support">Support</a></li>
		</ul>
        
        <div id="main">
            
            <div id="customizing" class="information">
                <h3>Customizing</h3>
                <p>Basically all I have right now is <a href="https://www.youtube.com/watch?v=IU__-ipUxxc" target="_blank">this video</a> on YouTube. I know the video is for a different theme, but this will change soon. Also, I would embed the video, but regrettably people wiser than me have said that it will introduce security issues. In the future I plan to add stuff here, but for now I just need to get the theme approved.</p>
            </div>
            
            <div id="features" class="information">
                <h3>Features</h3>
                <ul>
                    <li>100% Responsive WordPress Theme</li>
                    <li>Clean and Beautiful Stylized HTML, CSS, JavaScript</li>
                    <li>Change the site Title and Slogan Colors</li>
                    <li>Upload Your Own Background Image</li>
                    <li>Adjust the opacity of the Content from 0 to 100% in 5% intervails</li>
                    <li>Adjust the opacity of the Sidebar from 0 to 100% in 5% intervails</li>
                    <li>Adjust Color of the Background for Content</li>
                    <li>Adjust Color of the Background for Sidebar</li>
                    <li>Multiple Menu Banner Images to Choose From</li>
                    <li>Control wether or not the "Previous" & "Next" shows</li>
                    <li>Adjust the spacing between the top of the page and content</li>
                    <li>Comments on Pages only, Posts only, Both, or Nones</li>
                    <li>Featured Background Image unique to a post or page</li>
                    <li>Choose from 100's of Google fonts for the Title and Slogan</li>
                </ul>
                <p>Don't see a feature the theme needs? <a href="http://schwarttzy.com/contact-me/" target="_blank">Contact me</a> about it.</p>
                <h3>Adventure+ Features</h3>
                <ul>
                    <li>Easily remove the footer with the link to my website</li>
                    <li>Favicon on Your Website</li>
                    <li>Change the Hyper Link Color</li>
                    <li>Change the Link Colors in the Menu</li>
                    <li>Change the Font Color in the Content</li>
                    <li>Upload Your Own Logo in either the Header or above Content</li>
                    <li>Upload Your Own Custom Banner Image</li>
                    <li>Upload your own image for the Background</li>
                    <li>Basic Google Meta for Analytics & Webmaster Verification</li>
                    <li>More to come!</li>
                </ul>
            </div>
            
            <div id="faq" class="information">
                <h3>FAQ</h3>
                <p><b>How do I remove the "Good Old Fashioned Hand Written code by Eric J. Schwarz"</b></p>
                <p>According to the WordPress.org I'm allowed to include one credit link, which you can read about <a href="http://make.wordpress.org/themes/guidelines/guidelines-license-theme-name-credit-links-up-sell-themes/" target="_blank">here</a>. I use this link to spread the word about my coding skills in the hopes I'll get some jobs. Anyway, you can dig through the code and remove it by hand but if you upgrade to the lastest version it will come right back. It's not really a big deal to do it by hand each time I release an update. However if you want to support my theme and get the Adventure+ upgrade, it's just a simple "On or Off" option in the "Theme Customizer."</p>
                <p><b>More FAQ's coming soon!</b></p>
            </div>
            
            <!--- <div id="screenshots" class="information">
                <h3>I'll take some screen shots</h3>
            </div> -->
            
            <div id="changelog" class="information">
                <h3>The Changelog</h3>
                <table>
                    <tbody>
                        <tr>
                            <th>Version</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>2.80</th>
                            <td>Updated the theme information page to a new look. Dropped code I'm not allowed to have in the theme like redirecting to the Theme Infomation page upon activating the theme, google analytics code. Also fix some odd error with using the sidebar and a run on title 52+ letters in a row.</td>
                        </tr>
                        <tr>
                            <th>2.70</th>
                            <td>Created one of the most demanded feature of all time, custom backgrounds. I call it "Featured Background," because you can now upload or select any image to be a background unique to any page or post. Also fixed an issue with comments displaying ordered numbers.</td>
                        </tr>
                        <tr>
                            <th>2.60</th>
                            <td>Added the new option to have the content on the right and the sidebar on the left.</td>
                        </tr>
                        <tr>
                            <th>2.4</th>
                            <td>Added the ablitity to put soical icon and/or a search bar into the menu.  Fixed the issue with the theme display "and comments are closed." Added Google Analytics and Web Master Tool option because everyone should have it and more control of over the comments display too. The option to choose either display excerpts or the entire content of a post or page. You can choose to display dates on posts.</td>
                        </tr>
                        <tr>
                            <th>2.3</th>
                            <td>Minor update to add few things to the theme along with fixes. The custom CSS generated from the theme customizer should only show if you have changed something in the features. Static pages now will not show the pagination or comments. Include the option to do anything you want with the comments. Added Google Fonts to the Header for the Title and Slogan.</td>
                        </tr>
                        <tr>
                            <th>2.2</th>
                            <td>The update this time around was mainly for Adventure+ but in the process I added in a few more features. I included the option to have the menu lock to the top of the screen or the bottom similar to how the theme use to look. A lot of people asked for the ability to remove the “previous” & “next” links that come after content and I you guys one better. You now have the choice to remove the “previous” & “next” from just posts, just page, or both and you still can have it display the same. The slider and the content portion can now change to any color and adjust the opacity from 0% to 100% in 5% intervals. I also spent some time cleaning and organizing the customizer page, which means it is laid out a bit differently now but it works just the same. You now have the option to adjust the the amount of space fromt he top of the page to the where the content begins. I might have missed a thing or two but future updates should come much sooner with this hurdle cleared.</td>
                        </tr>
                        <tr>
                            <th>2.1</th>
                            <td>This is main an update to fix issues that I and others (like you) have found and fixed for the theme. The content no longer shifts to the right after the sidebar and embed video from YouTube and Vimeo are now responsive when embedded, plus some other minor stuff. I have also introduced the ablity change the color of the content of the background of content. In the next update I will include the ablity to change the sidebar.</td>
                        </tr>
                        <tr>
                            <th>1.8</th>
                            <td>The entire code for the WordPress theme "Adventure" has been completely rewritten in Version 1.8 and is a complete re-release of the theme. Not a single shred of code survived, and for good reason. The code was written over 3 years ago, before the HTML5 / CSS3 revolution, and had to be compatible with IE6 back then. Now that its three years later, I'm much better at coding and coupled with the progress made with HTML standards, the theme is back. While "Adventure" looks for the most part the same, there is a lot more happening in the code.</td>
                        </tr>
                    </tbody>
                </table> 
            </div>
            
            <div id="support" class="information">
                <h3>Support Information</h3>
                <p>If you happen to have issues with plugins, writing posts, customizing the theme, and basically anything just shoot me an email on <a href="http://schwarttzy.com/contact-me/" target="_blank">this page</a> I setup for contacting me.</p>
                <p>I have a <a href="https://twitter.com/Schwarttzy" target="_blank">Twitter</a> account, but all I really use it for is posting information on updates to my themes. So if you looking for a new feature, you may be in luck. I'm not really sure what to do with Twitter, but I know a lot of people use it.</p>
                <p>Your always welcome to use the "<a href="http://wordpress.org/support/theme/adventure" target="_blank">Support</a>" forums on WordPress.org for any questions or problems, I just don't check it as often because I don't recieve email notifications on new posts or replies.</p>
            </div>
        
            <div id="description" class="information">
                <h3>Description</h3>
                <p>If you're having trouble with using the WordPress Theme <?php $my_theme = wp_get_theme(); echo $my_theme->get( 'Name' )?> and need some help, <a href="http://schwarttzy.com/contact-me/" target="_blank">contact me</a> about it. But I recommend taking a look at <a href="https://www.youtube.com/watch?v=IU__-ipUxxc" target="_blank">this video</a> before sending me an email. The video is for a different theme, but it will show everything there is to customizing the theme "<?php $my_theme = wp_get_theme(); echo $my_theme->get( 'Name' )?>."</p>
                <p>Now that I have covered contacting me and a how to video, I would like to thank you for downloading and installing this theme. I hope that you enjoy it. I also hope that I can continue to create more beautiful themes like this for years to come, but that requires your help. I have created this Theme, and others, free of charge. And while I'm not looking to get rich, I really like creating these themes for you guys.</p>
                <p>So if you're interested in supporting my work, I can offer you an <a href="http://schwarttzy.com/shop/adventureplus/" target="_blank" >upgrade to Adventure</a>. I have already included a few more features, some of which I'm not allowed include in the free version, and I also offer to write additional code to customize the theme for you. Even if the code will be unique to your website.</p>
                <p>Eric Schwarz<br><a href="http://schwarttzy.com/" targe="_blank">http://schwarttzy.com/</a></p>                
            </div>
        
        </div>
            
    </div>
        
  
        
        
    
    <ul id="finishing"></ul>

    
    </div>
<?php }
add_action('admin_menu', 'adventure_theme_options_add_page'); ?>