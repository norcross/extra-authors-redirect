<?php
/**
 * Plugin Name:     Extra Authors Redirect
 * Plugin URI:      https://github.com/norcross/extra-authors-redirect
 * Description:     Adds a checkbox to redirect author profiles.
 * Author:          Andrew Norcross
 * Author URI:      https://andrewnorcross.com
 * Text Domain:     extra-authors-redirect
 * Domain Path:     /languages
 * Version:         2.1.0
 *
 * @package         ExtraAuthorsRedirect
 */

// Call our namepsace.
namespace Norcross\ExtraAuthorsRedirect;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Define our version.
define( __NAMESPACE__ . '\VERS', '2.1.0' );

// Plugin root file.
define( __NAMESPACE__ . '\FILE', __FILE__ );

// Define our file base.
define( __NAMESPACE__ . '\BASE', plugin_basename( __FILE__ ) );

// Plugin Folder URL.
define( __NAMESPACE__ . '\URL', plugin_dir_url( __FILE__ ) );

// Set the prefix for our actions and filters.
define( __NAMESPACE__ . '\HOOK_PREFIX', 'exar_' );

// Set the single option and usermeta keys we store.
define( __NAMESPACE__ . '\OPTION_KEY', 'exar_enable_all' );
define( __NAMESPACE__ . '\UMETA_KEY', 'exar_enable_user' );

// Go and load our files.
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/process.php';
require_once __DIR__ . '/includes/settings-api.php';
require_once __DIR__ . '/includes/user-settings.php';
