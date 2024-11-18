<?php
/**
 * Hooking into the WP settings API.
 *
 * @package ExtraAuthorsRedirect
 */

// Call our namepsace.
namespace Norcross\ExtraAuthorsRedirect\SettingsAPI;

// Set our alias items.
use Norcross\ExtraAuthorsRedirect as Core;
use Norcross\ExtraAuthorsRedirect\Helpers as Helpers;

/**
 * Start our engines.
 */
add_action( 'admin_init', __NAMESPACE__ . '\load_global_settings' );

/**
 * Add a checkbox to the reading settings for enabling globally.
 *
 * @return void
 */
function load_global_settings() {

	// Define the args for the setting registration.
	$setup_args = [
		'type'              => 'string',
		'show_in_rest'      => false,
		'default'           => 'no',
		'sanitize_callback' => __NAMESPACE__ . '\sanitize_global_setting',
	];

	// Add out checkbox with a sanitiation callback.
	register_setting( 'reading', Core\OPTION_KEY, $setup_args );

	// Load the actual checkbox field itself.
	add_settings_field( 'exar-global-enable', __( 'Redirect All Authors', 'extra-authors-redirect' ), __NAMESPACE__ . '\display_field', 'reading',  'default', [ 'class' => 'exar-global-enable-wrapper' ] );
}

/**
 * Display a basic checkbox for our setting.
 *
 * @return HTML
 */
function display_field( $args ) {

	// Add a legend output for screen readers.
	echo '<legend class="screen-reader-text"><span>' . esc_html__( 'Redirect All Authors', 'extra-authors-redirect' ) . '</span></legend>';

	// We are wrapping the entire thing in a label.
	echo '<label for="exar-global-enable-checkbox">';

		// Echo out the input name itself.
		echo '<input name="' . esc_attr( Core\OPTION_KEY ) . '" type="checkbox" id="exar-global-enable-checkbox" value="yes" ' . checked( 'yes', Helpers\check_global_enable(), false ) . ' /> ';

		// Echo out the text we just set above.
		echo esc_html__( 'Checking this box will override any individual author setting', 'extra-authors-redirect' );

	// Close up the label.
	echo '</label>';
}

/**
 * Make sure the setting is valid.
 *
 * @param  string $input  The data entered in a settings field.
 *
 * @return string $input  Our cleaned up data.
 */
function sanitize_global_setting( $input ) {
	return ! empty( $input ) && 'yes' === sanitize_text_field( $input ) ? 'yes' : 'no';
}
