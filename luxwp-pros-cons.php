<?php
/**
 * Plugin Name: LuxWP: Pros & Cons
 * Plugin URI: https://luxwp.com/
 * Description: This plugin provides you the shortcode to show pros/cons on any of the page.
 * Version: 1.0.2
 * Author: LuxWP
 * Author URI: https://luxwp.com
 * Text Domain: luxwp-pros-cons
 * Domain Path: /languages/
 *
 * @package Luxwp_Pros_Cons
 */

defined( 'ABSPATH' ) || exit;

define( 'LPC_PLUGIN_FILE', __FILE__ );
define( 'LPC_PATH', plugin_dir_path( LPC_PLUGIN_FILE ) );
define( 'LPC_URL', plugin_dir_url( LPC_PLUGIN_FILE ) );
define( 'LPC_VERSION', '1.0.2' );

require_once LPC_PATH . 'vendor/autoload.php';

$updater = \Puc_v4_Factory::buildUpdateChecker( 'https://github.com/namncn/luxwp-pros-cons/', __FILE__, 'luxwp-pros-cons' );

$updater->setAuthentication( 'b0416839c6f6fd2f11f0fbccc7fed9337fce8c2f' );
$updater->setBranch( 'master' );
$updater->getVcsApi()->enableReleaseAssets();

// Include the main Luxwp_Pros_Cons class.
if ( ! class_exists( 'Luxwp_Pros_Cons', false ) ) {
	include_once dirname( LPC_PLUGIN_FILE ) . '/inc/class-luxwp-pros-cons.php';
}

/**
 * Returns the main instance of LPC.
 *
 * @since  1.0.0
 * @return Luxwp_Pros_Cons
 */
function LPC() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return Luxwp_Pros_Cons::instance();
}

// Global for backwards compatibility.
$GLOBALS['lpc'] = LPC();
