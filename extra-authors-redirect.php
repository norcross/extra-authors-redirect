<?php
/*
Plugin Name: Extra Authors Redirect
Plugin URI: http://andrewnorcross.com/plugins/
Description: Adds a checkbox to author profiles to redirect.
Version: 1.2
Author: Andrew Norcross
Author URI: http://andrewnorcross.com

	Copyright 2013 Andrew Norcross

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Start up the engine
class Extra_Authors_Redirect
{

	/**
	 * Static property to hold our singleton instance
	 *
	 * @since	1.0
	 */
	static $instance = false;

	/**
	 * This is our constructor
	 *
	 * @since	1.0
	 */
	public function __construct() {
		add_action	( 'plugins_loaded', 				array( $this, 'textdomain'				) 			);
		add_action	( 'personal_options',				array( $this, 'author_redirect_show'	),	20		);
		add_action	( 'personal_options_update',		array( $this, 'author_redirect_save'	)			);
		add_action	( 'edit_user_profile_update',		array( $this, 'author_redirect_save'	)			);
		add_action	( 'template_redirect',				array( $this, 'author_redirect_fire'	),	1		);
		add_action	( 'template_redirect',				array( $this, 'forum_redirect_fire'		),	1		);
	}

	/**
	 * If an instance exists, this returns it.  If not, it creates one and
	 * retuns it.
	 *
	 * @since	1.0
	 */

	public static function getInstance() {
		if ( !self::$instance )
			self::$instance = new self;
		return self::$instance;
	}

	/**
	 * load textdomain
	 *
	 * @since	1.0
	 */


	public function textdomain() {

		load_plugin_textdomain( 'exar', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * save new updated item
	 *
	 * @since	1.0
	 */

	public function author_redirect_save( $user_id ) {

		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;

		if ( isset( $_POST['author_redirect'] ) )
			update_usermeta( $user_id, 'author_redirect', $_POST['author_redirect'] );

	}

	/**
	 * display checkbox option
	 *
	 * @since	1.0
	 */

	public function author_redirect_show( $profileuser ) {

		// get potential metadata
	    $redirect = get_user_meta( $profileuser->ID, 'author_redirect', true );
	    ?>
		<table class="form-table">
			<tr>
				<th scope="row"><?php _e( 'Author Redirect', 'exar' ); ?></th>
				<td>
					<label for="author_redirect">
						<input type="checkbox" name="author_redirect" id="author_redirect" value="true" <?php if ( !empty($profileuser->author_redirect) ) checked('true', $profileuser->author_redirect); ?> /> <?php _e('Redirect this author template page to the home page', 'exar'); ?>
					</label>
				</td>
			</tr>
		</table>
	    <?php
	}

	/**
	 * redirect author template if applicable
	 *
	 * @since	1.0
	 */

	public function author_redirect_fire() {

		// bail if we aren't on an author page
		if ( !is_author() )
			return;

		// get author ID of template
		$author_id	= get_query_var('author');

		// bail if we somehow came back with empty
		if ( empty( $author_id ) )
			return;

		$redirect	= get_user_meta( $author_id, 'author_redirect', true );

		if ( empty ($redirect) )
			return;

		// get default URL and apply filter
		$location	= get_bloginfo('url').'/';
		$location	= apply_filters( 'extra_author_redirect_url', $location );

		wp_redirect( esc_url_raw( $location ), 301 );
		exit();

	}

	/**
	 * redirect forum profile template if applicable
	 *
	 * @since	1.0
	 */

	public function forum_redirect_fire() {

		// Bail if no bbPress
		if ( !function_exists( 'is_bbpress') )
			return;

		// bail if we aren't on an author page
		if ( !bbp_is_single_user_profile() )
			return;

		// get author ID of template
		$author_id	= get_query_var('author');

		// bail if we somehow came back with empty
		if ( empty( $author_id ) )
			return;

		$redirect	= get_user_meta( $author_id, 'author_redirect', true );

		if ( empty ($redirect) )
			return;

		// get default URL and apply filter
		$location	= get_bloginfo('url').'/';
		$location	= apply_filters( 'extra_author_redirect_url', $location );

		wp_redirect( esc_url_raw( $location ), 301 );
		exit();

	}

/// end class
}

// Instantiate our class
$Extra_Authors_Redirect = Extra_Authors_Redirect::getInstance();