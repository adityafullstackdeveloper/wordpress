<?php
/**
 * Prevent switching to Huntor on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Huntor 1.0
 */
function huntor_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'huntor_upgrade_notice' );
}

add_action( 'after_switch_theme', 'huntor_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Huntor on WordPress versions prior to 4.7.
 *
 * @since Huntor 1.0
 *
 * @global string $wp_version WordPress version.
 */
function huntor_upgrade_notice() {
	$message = sprintf( esc_html__( 'Huntor requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'huntor' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @since Huntor 1.0
 *
 * @global string $wp_version WordPress version.
 */
function huntor_customize() {
	wp_die( sprintf( esc_html__( 'Huntor requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'huntor' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}

add_action( 'load-customize.php', 'huntor_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @since Huntor 1.0
 *
 * @global string $wp_version WordPress version.
 */
function huntor_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( esc_html__( 'Huntor requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'huntor' ), $GLOBALS['wp_version'] ) );
	}
}

add_action( 'template_redirect', 'huntor_preview' );
