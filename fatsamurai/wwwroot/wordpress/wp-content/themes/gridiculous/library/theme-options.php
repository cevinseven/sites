<?php
/**
 * Set up the default theme options
 *
 * @param	string $name  The option name
 *
 * @since Gridiculous 1.0.0
 */
function bavotasan_theme_options() {
	//delete_option( 'gridiculous_theme_options' );
	$default_theme_options = array(
		'width' => 'w960',
		'layout' => '2',
		'primary' => 'c8',
		'tagline' => 'on',
		'display_author' => 'on',
		'display_date' => 'on',
		'display_comment_count' => 'on',
		'display_categories' => 'on',
		'link_color' => '#333333',
		'excerpt_content' => 'content',
		'home_widget' =>'on'
	);

	return get_option( 'gridiculous_theme_options', $default_theme_options );
}

class Bavotasan_Customizer {
	public function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 1000 );
		add_action( 'customize_register', array( $this, 'customize_register' ) );
	}

	/**
	 * Add a 'customize' menu item to the admin bar
	 *
	 * This function is attached to the 'admin_bar_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_bar_menu( $wp_admin_bar ) {
	    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() )
	    	$wp_admin_bar->add_node( array( 'parent' => 'bavotasan_toolbar', 'id' => 'customize_theme', 'title' => __( 'Theme Options', 'gridiculous' ), 'href' => esc_url( admin_url( 'customize.php' ) ) ) );
			$wp_admin_bar->add_node( array( 'parent' => 'bavotasan_toolbar', 'id' => 'documentation_faqs', 'title' => __( 'Documentation & FAQs', 'gridiculous' ), 'href' => 'https://themes.bavotasan.com/documentation', 'meta' => array( 'target' => '_blank' ) ) );
	}

	public function customize_register( $wp_customize ) {
		$bavotasan_theme_options = bavotasan_theme_options();
		$wp_customize->add_setting( 'gridiculous_theme_options[tagline]', array(
			'default'    => $bavotasan_theme_options['tagline'],
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_tagline', array(
			'label'      => __( 'Display Tagline', 'gridiculous' ),
			'section'    => 'title_tagline',
			'settings' => 'gridiculous_theme_options[tagline]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_section( 'bavotasan_layout', array(
			'title' => __( 'Layout', 'gridiculous' ),
			'priority' => 35,
		) );

		$wp_customize->add_setting( 'gridiculous_theme_options[width]', array(
			'default'    => $bavotasan_theme_options['width'],
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_width', array(
			'label'      => __( 'Site Width', 'gridiculous' ),
			'section'    => 'bavotasan_layout',
			'settings' => 'gridiculous_theme_options[width]',
			'type' => 'select',
			'choices' => array(
				'' => '1200px',
				'w960' => __( '960px', 'gridiculous' ),
				'w640' => __( '640px', 'gridiculous' ),
				'wfull' => __( 'Full Width', 'gridiculous' ),
			),
		) );

		$wp_customize->add_setting( 'gridiculous_theme_options[layout]', array(
			'default'    => $bavotasan_theme_options['layout'],
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_site_layout', array(
			'label'      => __( 'Site Layout', 'gridiculous' ),
			'section'    => 'bavotasan_layout',
			'settings' => 'gridiculous_theme_options[layout]',
			'type' => 'radio',
			'choices' => array(
				'1' => __( 'Left Sidebar', 'gridiculous' ),
				'2' => __( 'Right Sidebar', 'gridiculous' ),
				'3' => __( 'No Sidebar', 'gridiculous' ),
			),
		) );

		$wp_customize->add_setting( 'gridiculous_theme_options[primary]', array(
			'default'    => $bavotasan_theme_options['primary'],
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_primary_column', array(
			'label'      => __( 'Main Content', 'gridiculous' ),
			'section'    => 'bavotasan_layout',
			'settings' => 'gridiculous_theme_options[primary]',
			'type' => 'select',
			'choices' => array(
				'c1' => __( '1 Column', 'gridiculous' ),
				'c2' => __( '2 Columns', 'gridiculous' ),
				'c3' => __( '3 Columns', 'gridiculous' ),
				'c4' => __( '4 Columns', 'gridiculous' ),
				'c5' => __( '5 Columns', 'gridiculous' ),
				'c6' => __( '6 Columns', 'gridiculous' ),
				'c7' => __( '7 Columns', 'gridiculous' ),
				'c8' => __( '8 Columns', 'gridiculous' ),
				'c9' => __( '9 Columns', 'gridiculous' ),
				'c10' => __( '10 Columns', 'gridiculous' ),
				'c11' => __( '11 Columns', 'gridiculous' ),
				'c12' => __( '12 Columns', 'gridiculous' ),
			),
		) );

		$wp_customize->add_setting( 'gridiculous_theme_options[excerpt_content]', array(
			'default'    => $bavotasan_theme_options['excerpt_content'],
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_excerpt_content', array(
			'label'      => __( 'Post Content Display', 'gridiculous' ),
			'section'    => 'bavotasan_layout',
			'settings' => 'gridiculous_theme_options[excerpt_content]',
			'type' => 'radio',
			'choices' => array(
				'excerpt' => __( 'Teaser Excerpt', 'gridiculous' ),
				'content' => __( 'Full Content', 'gridiculous' ),
			),
		) );

		$wp_customize->add_setting( 'gridiculous_theme_options[home_widget]', array(
			'default'    => $bavotasan_theme_options['home_widget'],
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_home_widget', array(
			'label'      => __( 'Display Home Page Top Widget Area', 'gridiculous' ),
			'section'    => 'bavotasan_layout',
			'settings' => 'gridiculous_theme_options[home_widget]',
			'type' => 'checkbox',
		) );

		// Posts panel
		$wp_customize->add_section( 'gridiculous_posts', array(
			'title' => __( 'Posts', 'gridiculous' ),
			'priority' => 45,
		) );

		$wp_customize->add_setting( 'gridiculous_theme_options[display_categories]', array(
			'default' => $bavotasan_theme_options['display_categories'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'gridiculous_display_categories', array(
			'label' => __( 'Display Categories', 'gridiculous' ),
			'section' => 'gridiculous_posts',
			'settings' => 'gridiculous_theme_options[display_categories]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'gridiculous_theme_options[display_author]', array(
			'default' => $bavotasan_theme_options['display_author'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'gridiculous_display_author', array(
			'label' => __( 'Display Author', 'gridiculous' ),
			'section' => 'gridiculous_posts',
			'settings' => 'gridiculous_theme_options[display_author]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'gridiculous_theme_options[display_date]', array(
			'default' => $bavotasan_theme_options['display_date'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'gridiculous_display_date', array(
			'label' => __( 'Display Date', 'gridiculous' ),
			'section' => 'gridiculous_posts',
			'settings' => 'gridiculous_theme_options[display_date]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'gridiculous_theme_options[display_comment_count]', array(
			'default' => $bavotasan_theme_options['display_comment_count'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'gridiculous_display_comment_count', array(
			'label' => __( 'Display Comment Count', 'gridiculous' ),
			'section' => 'gridiculous_posts',
			'settings' => 'gridiculous_theme_options[display_comment_count]',
			'type' => 'checkbox',
		) );

		// Color options
		$wp_customize->add_setting( 'gridiculous_theme_options[link_color]', array(
			'default'           => $bavotasan_theme_options['link_color'],
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
			'label'    => __( 'Link Color', 'gridiculous' ),
			'section'  => 'colors',
			'settings' => 'gridiculous_theme_options[link_color]',
		) ) );
	}
}
$bavotasan_customizer = new Bavotasan_Customizer;