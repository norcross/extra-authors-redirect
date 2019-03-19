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

	// Never on admin, so bail right away.
	if ( is_admin() ) {
		return;
	}

	// Include the action.
	do_action( Core\HOOK_KEY . 'before_template_redirects' );

	// Check for author archive pages first.
	if ( is_author() ) {

		// Get my author ID from the existing query vars.
		$author_id  = get_query_var( 'author' );

		// Set up our single author redirect.
		Helpers\setup_single_redirect( $author_id, 'author' );
	}

	// Run our bbPress forum member.
	if ( function_exists( 'is_bbpress' ) && bbp_is_single_user_profile() ) {

		// Get my author ID from the existing query vars.
		$member_id  = get_query_var( 'author' );

		// Set up our single author redirect.
		Helpers\setup_single_redirect( $member_id, 'member' );
	}

	// Include the action.
	do_action( Core\HOOK_KEY . 'after_template_redirects' );

	// Nothing left. Return.
	return;
}
