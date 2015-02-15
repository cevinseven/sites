<?php
class Bavotasan_Message_Bar {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'bavotasan_adminbar_enqueue' ) );
		add_action( 'in_admin_header', array( $this, 'bavotasan_adminbar' ), 1 );
		add_action( 'wp_ajax_bavotasan_hide_adminbar', array( $this, 'bavotasan_hide_adminbar' ) );
		add_action( 'after_switch_theme', array( $this, 'bavotasan_theme_activated' ), 10, 2 );
	}

	/**
	 * Enqueue admin bar scripts if there's an admin bar active.
	 *
	 * This function is attached to the 'admin_enqueue_scripts' action hook.
	 *
	 * @since 3.0.4
	 */
	function bavotasan_adminbar_enqueue() {
		wp_enqueue_script( 'bavotasan_admin_bar_js', BAVOTASAN_THEME_URL . '/library/js/bootstrap.js', array( 'jquery' ), '', true );
		wp_enqueue_style( 'bavotasan_admin_bar', BAVOTASAN_THEME_URL . '/library/css/message-bar.css' );
	}

	/**
	 * Display the admin bar
	 *
	 * This function is attached to the 'in_admin_header' action hook.
	 *
	 * @since 3.0.4
	 */
	function bavotasan_adminbar() {
		if ( get_option( 'bavotasan_hide_adminbar' ) )
			return;

		?>
		<div id="bavotasan-admin-bar" class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<p><i class="icon-leaf"></i> <?php printf ( __( 'Thanks for choosing %s. Hope you enjoy using it! %s If you want to see some of the advanced options available in %s, %shere\'s a little preview%s.', 'gridiculous' ), '<em>' . BAVOTASAN_THEME_NAME . '</em>', '<img src="' . home_url( '/wp-includes/images/smilies/icon_smile.gif' ) . '" alt="" />', '<em>' . BAVOTASAN_PRO_UPGRADE_NAME . '</em>', '<a href="' . admin_url( 'themes.php?page=bavotasan_preview_pro' ) . '" class="alert-link">', '</a>' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Set option when admin bar is dismissed
	 *
	 * This function is attached to the 'wp_ajax_bavotasan_hide_adminbar' action hook.
	 *
	 * @since 3.0.4
	 */
	function bavotasan_hide_adminbar() {
		if ( update_option( 'bavotasan_hide_adminbar', true ) )
	        die( '1' );
	    else
	        die( '0' );
	}

	/**
	 * Reset the Bavotasan admin bar option
	 *
	 * This function is attached to the 'after_switch_theme' action hook.
	 *
	 * @since 3.0.4
	 */
	function bavotasan_theme_activated() {
		delete_option( 'bavotasan_hide_adminbar' );
	}
}
$bavotasan_message_bar = new Bavotasan_Message_Bar;