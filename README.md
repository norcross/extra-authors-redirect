Extra Authors Redirect
========================

## Contributors
* [Andrew Norcross](https://github.com/norcross)

## About

Adds a checkbox to redirect author profiles. Useful for sites that have occasional authors or user accounts not intended for display.

## Features

* a checkbox on each author profile
* a global setting for site-wide redirect
* filterable redirect location
* includes bbPress support

#### Does this affect posts / pages / admin / ???

No. this only affects people going to the /author/ template page on a site, and only affects those that have been marked to redirect or if the global settings is enabled.

#### Can I change where the redirect goes?

Yes. There is a filter to change the default behavior. Example:

~~~php
/**
 * Change the URL that a redirected author profile goes to.
 *
 * @param  string $location  The current URL set.
 * @param  integer $user_id  The individual user ID being redirected (if not global).
 *
 * @return string            The new updated one.
 */
function set_custom_redirect_url( $location, $user_id ) {
	return 'https://www.google.com';
}
add_filter( 'exar_redirect_url', 'set_custom_redirect_url', 10, 2 );
~~~

#### Can the redirect be something other than a 301?

Sure can. Change it to whatever you want. Example:

~~~php
/**
 * Change the HTTP response code.
 *
 * @param  integer $response_code  The current HTTP response.
 * @param  integer $user_id        The individual user ID being redirected (if not global).
 *
 * @return integer                 The new updated one.
 */
function set_custom_http_response( $response_code, $user_id ) {
	return 302;
}
add_filter( 'exar_redirect_http_code', 'set_custom_http_response', 10, 2 );
~~~
