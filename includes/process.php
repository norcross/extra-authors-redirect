<?php
/**
 * Handle our potential redirects.
 *
 * @package ExtraAuthorsRedirect
 */

// Call our namepsace.
namespace Norcross\ExtraAuthorsRedirect\Process;

// Set our alias items.
use Norcross\ExtraAuthorsRedirect as Core;
use Norcross\ExtraAuthorsRedirect\Helpers as Helpers;

/**
 * Start our engines.
 */
add_action( 'template_redirect', __NAMESPACE__ . '\maybe_redirect_author_profile' );
add_action( 'template_redirect', __NAMESPACE__ . '\maybe_redirect_forum_profile' );

/**
 * Possibly redirect a core author profile.
 *
 * @return void
 */
function maybe_redirect_author_profile() {

	// Don't even try to check if this isn't an author profile.
	if ( ! is_author() ) {
		return;
	}

	// Check if this is enabled globally.
	$maybe_global   = Helpers\check_global_enable();

	// If it's global, don't check individual author.
	if ( ! empty( $maybe_global ) && 'yes' === $maybe_global ) {

		// Get the redirect URL.
		$fetch_redirect = Helpers\get_author_redirect_url();

		// And redirect.
		wp_safe_redirect( esc_url( $fetch_redirect ), Helpers\get_author_redirect_http_code() );
		exit();
	}

	// Get the author ID from the query vars.
	$get_author_id  = get_query_var( 'author' );

	// Bail if we somehow came back with empty.
	if ( empty( $get_author_id ) ) {
		return;
	}

	// Check if this is enabled for this user.
	$maybe_enabled  = Helpers\check_user_enable( $get_author_id );

	// If we are not set to "yes" then bail.
	if ( empty( $maybe_enabled ) || 'yes' !== $maybe_enabled ) {
		return;
	}

	// Get the redirect URL.
	$fetch_redirect = Helpers\get_author_redirect_url();

	// And redirect.
	wp_safe_redirect( esc_url( $fetch_redirect ), Helpers\get_author_redirect_http_code() );
	exit();
}

/**
 * Possibly redirect a bbPress forum profile.
 *
 * @return void
 */
function maybe_redirect_forum_profile() {

	// Bail if no bbPress.
	if ( ! function_exists( 'is_bbpress' ) ) {
		return;
	}

	// Bail if we aren't on an forum user page.
	if ( ! bbp_is_single_user_profile() ) {
		return;
	}

	// Check if this is enabled globally.
	$maybe_global   = Helpers\check_global_enable();

	// If it's global, don't check individual author.
	if ( ! empty( $maybe_global ) && 'yes' === $maybe_global ) {

		// Get the redirect URL.
		$fetch_redirect = Helpers\get_author_redirect_url();

		// And redirect.
		wp_safe_redirect( esc_url( $fetch_redirect ), Helpers\get_author_redirect_http_code() );
		exit();
	}

	// Get the author ID from the query vars.
	$get_author_id  = get_query_var( 'author' );

	// Bail if we somehow came back with empty.
	if ( empty( $get_author_id ) ) {
		return;
	}

	// Check if this is enabled for this user.
	$maybe_enabled  = Helpers\check_user_enable( $get_author_id );

	// If we are not set to "yes" then bail.
	if ( empty( $maybe_enabled ) || 'yes' !== $maybe_enabled ) {
		return;
	}

	// Get the redirect URL.
	$fetch_redirect = Helpers\get_author_redirect_url();

	// And redirect.
	wp_safe_redirect( esc_url( $fetch_redirect ), Helpers\get_author_redirect_http_code() );
	exit();
}
