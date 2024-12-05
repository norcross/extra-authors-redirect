<?php
/**
 * Handle our user settings.
 *
 * @package ExtraAuthorsRedirect
 */

// Call our namepsace.
namespace Norcross\ExtraAuthorsRedirect\UserSettings;

// Set our alias items.
use Norcross\ExtraAuthorsRedirect as Core;
use Norcross\ExtraAuthorsRedirect\Helpers as Helpers;

/**
 * Start our engines.
 */
add_action( 'personal_options', __NAMESPACE__ . '\show_user_meta_setting', 5 );
add_action( 'profile_update', __NAMESPACE__ . '\save_user_meta_setting', 10, 3 );

/**
 * Include a small field for the redirect checkbox.
 *
 * @param  WP_User $profileuser  The WP_User object.
 *
 * @return HTML
 */
function show_user_meta_setting( $profileuser ) {

	// Bail if we don't have any of the right things to check.
	if ( empty( $profileuser ) || empty( $profileuser->ID ) ) {
		return;
	}

	// Check the user meta.
	$maybe_enabled  = Helpers\check_user_enable( $profileuser->ID );

	// Now display the field.
	echo '<tr class="exar-user-enable-wrap">';

		// Show our label side.
		echo '<th scope="row">' . esc_html__( 'Redirect Author Template', 'extra-authors-redirect' ) . '</th>';

		// Show the checkbox portion.
		echo '<td>';

			// Handle the markup like core does.
			echo '<label for="' . esc_attr( Core\UMETA_KEY ) . '">';
				echo '<input name="' . esc_attr( Core\UMETA_KEY ) . '" type="checkbox" id="' . esc_attr( Core\UMETA_KEY ) . '" value="yes" ' . checked( 'yes', $maybe_enabled, false ) . '> ' . esc_html__( 'Redirect this author profile', 'extra-authors-redirect' );
			echo '</label>';

			// And add a nonce field.
			wp_nonce_field( 'exar_user_action', 'exar-user-meta-save', false );

		// Close the checkbox portion.
		echo '</td>';

	// Close out field.
	echo '</tr>';
}

/**
 * Update the meta and the overall array.
 *
 * @param  integer $user_id        User ID.
 * @param  WP_User $old_user_data  Object containing user's data prior to update.
 * @param  array   $userdata       The array of raw data that was passed.
 *
 * @return void
 */
function save_user_meta_setting( $user_id, $old_user_data, $userdata ) {

	// Make sure we have a nonce.
	$confirm_nonce  = filter_input( INPUT_POST, 'exar-user-meta-save', FILTER_SANITIZE_SPECIAL_CHARS ); // phpcs:ignore -- the nonce check is happening after this.

	// Handle the nonce check.
	if ( ! empty( $confirm_nonce ) && ! wp_verify_nonce( $confirm_nonce, 'exar_user_action' ) ) {

		// Let them know they had a failure.
		wp_die( esc_html__( 'There was an error validating the nonce.', 'extra-authors-redirect' ), esc_html__( 'Extra Authors Redirect User Meta', 'extra-authors-redirect' ), [ 'back_link' => true ] );
	}

	// Check if the user meta key was provided.
	$check_usermeta = filter_input( INPUT_POST, 'exar_enable_user', FILTER_SANITIZE_SPECIAL_CHARS );

	// Either update or delete the meta.
	if ( ! empty( $check_usermeta ) && 'yes' === $check_usermeta ) {
		update_user_meta( $user_id, Core\UMETA_KEY, 'yes' );
	} else {
		delete_user_meta( $user_id, Core\UMETA_KEY );
	}
}
