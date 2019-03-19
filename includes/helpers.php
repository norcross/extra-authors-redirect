<?php
/**
 * Some basic helper functions.
 *
 * @package ExtraAuthorsRedirect
 */

// Call our namepsace.
namespace ExtraAuthorsRedirect\Helpers;

// Set our alias items.
use ExtraAuthorsRedirect as Core;

/**
 * Check to see if the global option is enabled.
 *
 * @return boolean
 */
function maybe_set_global() {

	// Check for the global option in the DB.
	$global_option  = get_option( Core\OPTION_PREFIX . 'global', 0 );

	// Return a false if it isn't set.
	return ! empty( $global_option ) ? true : false;
}

/**
 * Check and see if a user account should be redirected.
 *
 * @param  integer $user_id  The user ID we are checking.
 *
 * @return boolean
 */
function maybe_user_redirect( $user_id = 0 ) {

	// Make sure we have a user ID to check against.
	if ( empty( $user_id ) && ! is_user_logged_in() ) {
		return;
	}

	// Now pull out the ID.
	$author_id  = ! empty( $user_id ) ? $user_id : get_current_user_id();

	// Check for the user meta.
	$maybe_meta = get_user_meta( $author_id, Core\META_KEY, true );

	// Return a false if it isn't set.
	return ! empty( $maybe_meta ) ? true : false;
}

/**
 * Redirect the single author archive pages.
 *
 * @param  integer $user_id    The user ID being done.
 * @param  string  $user_type  Which user type we're doing. Currently only used in the filter.
 *
 * @return void
 */
function setup_single_redirect( $user_id = 0, $user_type = '' ) {

	// Check for the meta flag with the location flag.
	$maybe_send = maybe_user_redirect( $user_id );

	// Redirect if we have a value.
	if ( ! empty( $maybe_send ) ) {
		redirect_on_request( $user_id, $user_type );
	}

	// Nothing left. Return.
	return;
}

/**
 * Do the actual redirect on request.
 *
 * @param  integer $user_id    The user ID we are checking.
 * @param  string  $user_type  Which user type we're doing. Currently only used in the filter.
 *
 * @return void
 */
function redirect_on_request( $user_id = 0, $user_type = 'author' ) {

	// Set my redirect URL.
	$redirect_url   = apply_filters( Core\HOOK_KEY . 'redirect_url', home_url( '/' ), $user_id, $user_type );

	// Make sure we have a URL from the resulting filter.
	if ( empty( $redirect_url ) ) {
		return;
	}

	// Set my status code.
	$status_code    = apply_filters( Core\HOOK_KEY . 'redirect_status_code', 302, $user_id, $user_type );

	// Redirect and bail.
	wp_redirect( $redirect_url, $status_code );
	exit;
}
