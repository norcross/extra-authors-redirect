<?php
/**
 * Plugin Name:     Extra Authors Redirect
 * Plugin URI:      https://github.com/norcross/extra-authors-redirect
 * Description:     Allow site owners to redirect the author archive pages.
 * Author:          Andrew Norcross
 * Author URI:      http://andrewnorcross.com
 * Text Domain:     extra-authors-redirect
 * Domain Path:     /languages
 * Version:         1.3.0
 *
 * @package         ExtraAuthorsRedirect
 */

// Call our namepsace.
namespace ExtraAuthorsRedirect;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Define our version.
define( __NAMESPACE__ . '\VERS', '1.3.0' );

// Plugin Folder URL.
define( __NAMESPACE__ . '\URL', plugin_dir_url( __FILE__ ) );

// Plugin root file.
define( __NAMESPACE__ . '\FILE', __FILE__ );

// Define our various keys.
define( __NAMESPACE__ . '\META_KEY', 'author_redirect' );
define( __NAMESPACE__ . '\HOOK_KEY', 'extra_author_' );
define( __NAMESPACE__ . '\NONCE_PREFIX', 'extr_athr_redrct_' );

// Go and load our files.
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/author-meta.php';
require_once __DIR__ . '/includes/front-redirects.php';
