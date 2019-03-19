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
add_action( 'personal_options', __NAMESPACE__ . '\display_profile_field', 30 );
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

	// Check our setting.
	$maybe_glbl = Helpers\maybe_set_global();

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
				echo false !== $maybe_glbl ? author_meta_disabled() : author_meta_checkbox( $profileuser->ID );

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
 * Set up the checkbox field for the single authors.
 *
 * @return HTML
 */
function author_meta_checkbox( $user_id = 0 ) {

	// First attempt to get the meta value.
	$maybe_meta = Helpers\maybe_user_redirect( $user_id );

	// Set my empty.
	$field  = '';

	// Wrap it all up and show it.
	$field .= '<label for="author_redirect">';
		$field .= '<input type="checkbox" name="author_redirect" id="author_redirect" value="1" ' . checked( $maybe_meta, 1, false ) . ' /> ';
		$field .= __( 'Redirect this author template page to the home page', 'extra-authors-redirect' );
	$field .= '</label>';

	// Include the nonce field.
	$field .= wp_nonce_field( Core\NONCE_PREFIX . 'action', Core\NONCE_PREFIX . 'name', true, false );

	// Return my field.
	return $field;
}

/**
 * Set up the checkbox field for the disabled.
 *
 * @return HTML
 */
function author_meta_disabled() {

	// Return the paragraph.
	return '<p class="description">' . __( 'This has been enabled globally by the site administrator.', 'extra-authors-redirect' ) . '</p>';
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

