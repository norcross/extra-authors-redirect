=== Extra Authors Redirect ===
Contributors: norcross, jjeaton, reaktivstudios
Website Link: http://andrewnorcross.com/plugins/
Donate link: https://andrewnorcross.com/donate
Tags: author-page, authors, redirects
Requires at least: 3.3
Tested up to: 3.9
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a checkbox to author profiles for redirecting to other parts of the site.

== Description ==

Adds a checkbox to author profiles to redirect. Useful for sites that have occasional authors or user accounts not intended for display.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `extra-authors-redirect` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Check the author(s) you want redirected.

== Frequently Asked Questions ==


= Does this affect posts / pages / admin / ??? =

No. this only affects people going to the /author/ template page on a site, and only affects those that have been marked to redirect.

= Can I change where the redirect goes? =

Yes. There is a filter to change the default behavior. In your functions file, include the following:

`function new_auth_url($location) {
	$location = 'http://google.com';
	return $location;
}
add_filter( 'extra_author_redirect_url', 'new_auth_url' );`

== Screenshots ==

1. The checkbox


== Changelog ==

= 1.2 =
* Will also redirect for bbPress profile pages

= 1.1 =
* Cleaner meta check for adding author meta entry

= 1.0 =
* First release!


== Upgrade Notice ==


= 1.0 =
* First release!
