<?php
/**
 * The functions tied to the front-end redirects.
 *
 * @package ExtraAuthorsRedirect
 */

// Call our namepsace.
namespace ExtraAuthorsRedirect\FrontRedirects;

// Set our alias items.
use ExtraAuthorsRedirect as Core;
use ExtraAuthorsRedirect\Helpers as Helpers;

/**
 * Start our engines.
 */
add_action( 'template_redirect', __NAMESPACE__ . '\check_for_redirect_args', 1 );

/**
 * Check if we are on various site parts and go.
 *
 * @return void
 */
function check_for_redirect_args() {

	// Include the action.
	do_action( Core\HOOK_KEY . 'before_template_redirects' );

	// Check for author archive pages first.
	if ( is_author() ) {

		// Get my author ID from the existing query vars.
		$author_id  = get_query_var( 'author' );

		// Set up our single author redirect.
		setup_single_redirect( $author_id, 'author' );
	}

	// Run our bbPress forum member.
	if ( function_exists( 'is_bbpress' ) && bbp_is_single_user_profile() ) {

		// Get my author ID from the existing query vars.
		$member_id  = get_query_var( 'author' );

		// Set up our single author redirect.
		setup_single_redirect( $member_id, 'member' );
	}

	// Include the action.
	do_action( Core\HOOK_KEY . 'after_template_redirects' );

	// Nothing left. Return.
	return;
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
	$maybe_send = Helpers\maybe_user_redirect( $user_id );

	// Redirect if we have a value.
	if ( ! empty( $maybe_send ) ) {
		Helpers\redirect_on_request( $maybe_send, $user_type );
	}

	// Nothing left. Return.
	return;
}
