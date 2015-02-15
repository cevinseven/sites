<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?>>
<head>
<?php wp_head(); // Hook required for scripts, styles, and other <head> items. ?>
</head>

<body <?php body_class(); ?> <?php omega_attr( 'body' ); ?>>

<?php omega_do_atomic( 'before' ); // omega_before ?>

<div class="<?php echo omega_apply_atomic( 'site_container_class', 'site-container' );?>">

	<?php omega_do_atomic( 'before_header' ); // omega_before_header ?>
	<?php omega_do_atomic( 'header' ); // omega_header ?>
	<?php omega_do_atomic( 'after_header' ); // omega_after_header ?>

	<div class="site-inner">

		<?php omega_do_atomic( 'before_main' ); // omega_before_main ?>