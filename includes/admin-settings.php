<?php
/**
 * Our global wp-admin settings configuration.
 *
 * @package ExtraAuthorsRedirect
 */

// Call our namepsace.
namespace ExtraAuthorsRedirect\AdminSettings;

// Set our alias items.
use ExtraAuthorsRedirect as Core;
use ExtraAuthorsRedirect\Helpers as Helpers;

/**
 * Start our engines.
 */
add_action( 'admin_init', __NAMESPACE__ . '\load_settings' );

/**
 * Register our new settings and load our settings fields.
 *
 * @return void
 */
function load_settings() {

	// Add our global setting checkbox into the general settings.
	register_setting( 'general', Core\OPTION_PREFIX . 'global', __NAMESPACE__ . '\sanitize' );

	// Load the checkbox field.
	add_settings_field( 'enable-global', __( 'Author Archive Redirects', 'extra-authors-redirect' ), __NAMESPACE__ . '\global_field', 'general', 'default' );
}

/**
 * Our field to be added to the discussion settings for listing blacklist source URLs.
 *
 * This is for information purposes only and can't be modified from the settings panel itself.
 *
 * @return HTML  the data field for the list.
 */
function global_field() {

	// Set the field name (also the ID).
	$field_name = Core\OPTION_PREFIX . 'global';

	// Check our setting.
	$maybe_glbl = Helpers\maybe_set_global();

	// Open up the fieldset tag.
	echo '<fieldset>';

		// Handle the screen reader.
		echo '<legend class="screen-reader-text"><span>' . __( 'Author Archive Redirects', 'extra-authors-redirect' ) . '</span></legend>';

		// Wrap the checkbox in a label.
		echo '<label for="extra-authors-redirect-global">';

			// Output the actual checkbox.
			echo '<input name="' . esc_attr( $field_name ) . '" type="checkbox" id="extra-authors-redirect-global" value="1" ' . checked( $maybe_glbl, 1, false ) . '> ' . __( 'Enable author archive redirects for all users.', 'extra-authors-redirect' );

		// Close the label wrap.
		echo '</label>';

	// Close out the fieldset.
	echo '</fieldset>';
}

/**
 * Sanitize the user data list inputs (exclusion and local).
 *
 * @param  string $input  The data entered in a settings field.
 *
 * @return string $input  The exclude list sanitized.
 */
function sanitize( $input ) {
	return absint( $input );
}
