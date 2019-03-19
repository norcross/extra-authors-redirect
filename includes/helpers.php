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
 * Do the actual redirect on request.
 *
 * @param  integer $user_id    The user ID we are checking.
 * @param  string  $user_type  Which user type we're doing. Currently only used in the filter.
 *
 * @return void
 */
function redirect_on_request( $user_id = 0, $user_type = 'author' ) {

	// Make sure we have a user ID to check against.
	if ( empty( $user_id ) && ! is_user_logged_in() ) {
		return;
	}

	// Set my redirect URL.
	$redirect_url   = apply_filters( Core\HOOK_KEY . 'redirect_url', home_url( '/' ), $user_id, $user_type );

	// Set my status code.
	$status_code    = apply_filters( Core\HOOK_KEY . 'redirect_status_code', 302, $user_id, $user_type );

	// Make sure we have a URL from the resulting filter.
	if ( empty( $redirect_url ) ) {
		return;
	}

	// Redirect and bail.
	wp_redirect( $redirect_url, $status_code );
	exit;
}
