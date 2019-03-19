<?php
/**
 * The functions tied to the author meta.
 *
 * @package ExtraAuthorsRedirect
 */

// Call our namepsace.
namespace ExtraAuthorsRedirect\AuthorMeta;

// Set our alias items.
use ExtraAuthorsRedirect as Core;
use ExtraAuthorsRedirect\Helpers as Helpers;

/**
 * Start our engines.
 */
add_action( 'personal_options', __NAMESPACE__ . '\display_profile_field', 20 );
add_action( 'personal_options_update', __NAMESPACE__ . '\save_user_meta' );
add_action( 'edit_user_profile_update', __NAMESPACE__ . '\save_user_meta' );

/**
 * Display the checkbox for redirecting this author.
 *
 * @param  object $profileuser  The user object on this profile.
 *
 * @return HTML
 */
function display_profile_field( $profileuser ) {

	// First attempt to get the meta value.
	$maybe_meta = Helpers\maybe_user_redirect( $profileuser->ID );

	// Wrap the table.
	echo '<table class="form-table">';

		// Include the action.
		do_action( Core\HOOK_KEY . 'before_profile_field' );

		// Open up the row.
		echo '<tr>';

			// Output the title.
			echo '<th scope="row">' . __( 'Author Redirect', 'extra-authors-redirect' ) . '</th>';

			// Output the checkbox with a label.
			echo '<td>';

				// Wrap it all up and show it.
				echo '<label for="author_redirect">';
					echo '<input type="checkbox" name="author_redirect" id="author_redirect" value="1" ' . checked( $maybe_meta, 1, false ) . ' /> ';
					echo __( 'Redirect this author template page to the home page', 'extra-authors-redirect' );
				echo '</label>';

				// Include the nonce field.
				echo wp_nonce_field( Core\NONCE_PREFIX . 'action', Core\NONCE_PREFIX . 'name', true, false );

			// Close the checkbox.
			echo '</td>';

		// Close the row.
		echo '</tr>';

		// Include the action.
		do_action( Core\HOOK_KEY . 'after_profile_field' );

	// Close up the table.
	echo '</table>';
}

/**
 * Save the redirect flag for a user profile.
 *
 * @param  integer $user_id  The user ID being saved.
 *
 * @return void
 */
function save_user_meta( $user_id ) {

	// Make sure we can save stuff.
	if ( empty( $user_id ) || ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	// Do the nonce check. ALWAYS NONCE CHECKS.
	if ( ! isset( $_POST[ Core\NONCE_PREFIX . 'name' ] ) || ! wp_verify_nonce( $_POST[ Core\NONCE_PREFIX . 'name'], Core\NONCE_PREFIX . 'action' ) ) {
		wp_die( __( 'The nonce verification failed.', 'extra-authors-redirect' ) );
	}

	// Include the action.
	do_action( Core\HOOK_KEY . 'before_user_meta_save' );

	// Check for the posted value.
	if ( ! empty( $_POST['author_redirect'] ) ) {
		update_user_meta( $user_id, Core\META_KEY, 1 );
	} else {
		delete_user_meta( $user_id, Core\META_KEY );
	}

	// Include the action.
	do_action( Core\HOOK_KEY . 'after_user_meta_save' );
}

