<?php
/**
 * Our helper functions to use across the plugin.
 *
 * @package ExtraAuthorsRedirect
 */

// Call our namepsace.
namespace Norcross\ExtraAuthorsRedirect\Helpers;

// Set our alias items.
use Norcross\ExtraAuthorsRedirect as Core;

// And pull in any other namespaces.
use WP_Error;

/**
 * Check the setting to see if we have enabled it globally.
 *
 * @param  string $return_type  How to return the option. Accepts "boolean" or "string".
 *
 * @return mixed
 */
function check_global_enable( $return_type = 'string' ) {

	// First get the option key itself.
	$set_option = get_option( Core\OPTION_KEY, 'no' );

	// Switch through our return types.
	switch ( esc_attr( $return_type ) ) {

		// Handle the boolean return.
		case 'bool' :
		case 'boolean' :

			// Check for the stored "yes" to return.
			return ! empty( $set_option ) && 'yes' === sanitize_text_field( $set_option ) ? true : false;

			// Done.
			break;

		// Handle my yes / no string return.
		case 'string' :

			// Check for the stored "yes" to return.
			return ! empty( $set_option ) && 'yes' === sanitize_text_field( $set_option ) ? 'yes' : 'no';

			// Done.
			break;
	}

	// Return an error set because they done messed up.
	return new WP_Error( 'invalid_return_type', __( 'You requested an invalid return type.', 'extra-authors-redirect' ) );
}

/**
 * Check the setting to see if we have enabled it for a single user.
 *
 * @param  integer $user_id      The individual user ID we are checking.
 * @param  string  $return_type  How to return the option. Accepts "boolean" or "string".
 *
 * @return mixed
 */
function check_user_enable( $user_id = 0, $return_type = 'string' ) {

	// Return right away if the user ID is missing.
	if ( empty( $user_id ) ) {
		return 'string' === sanitize_text_field( $return_type ) ? 'no' : false;
	}

	// Now check the user meta.
	$set_option = get_user_meta( $user_id, Core\UMETA_KEY, true );

	// Switch through our return types.
	switch ( sanitize_text_field( $return_type ) ) {

		// Handle the boolean return.
		case 'bool' :
		case 'boolean' :

			// Check for the stored "yes" to return.
			return ! empty( $set_option ) && 'yes' === sanitize_text_field( $set_option ) ? true : false;

			// Done.
			break;

		// Handle my yes / no string return.
		case 'string' :

			// Check for the stored "yes" to return.
			return ! empty( $set_option ) && 'yes' === sanitize_text_field( $set_option ) ? 'yes' : 'no';

			// Done.
			break;
	}

	// Return an error set because they done messed up.
	return new WP_Error( 'invalid_return_type', __( 'You requested an invalid return type.', 'extra-authors-redirect' ) );
}

/**
 * Get the URL that we need to redirect to.
 *
 * @param  integer $user_id  The individual user ID we are checking.
 *
 * @return string
 */
function get_author_redirect_url( $user_id = 0 ) {
	return apply_filters( Core\HOOK_PREFIX . 'redirect_url', home_url( '/' ), $user_id );
}

/**
 * Get the HTTP status code that we need to use.
 *
 * @param  integer $user_id  The individual user ID we are checking.
 *
 * @return string
 */
function get_author_redirect_http_code( $user_id = 0 ) {
	return apply_filters( Core\HOOK_PREFIX . 'redirect_http_code', 301, $user_id );
}
