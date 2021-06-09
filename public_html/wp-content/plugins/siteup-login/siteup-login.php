<?php
/*
Plugin Name: Siteup Login
Description: Замена входа в админку сайта
Author: Siteup
Author URI: https://siteup.ru
Version: 1.0
Requires at least: 4.1
Tested up to: 4.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Plugin constants
define( 'WPS_HIDE_LOGIN_VERSION', '1.2.5' );
define( 'WPS_HIDE_LOGIN_FOLDER', 'wps-hide-login' );

define( 'WPS_HIDE_LOGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WPS_HIDE_LOGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPS_HIDE_LOGIN_BASENAME', plugin_basename( __FILE__ ) );

// Function for easy load files
function wps_hide_login_load_files( $dir, $files, $prefix = '' ) {
	foreach ( $files as $file ) {
		if ( is_file( $dir . $prefix . $file . '.php' ) ) {
			require_once( $dir . $prefix . $file . '.php' );
		}
	}
}

// Plugin client classes
wps_hide_login_load_files( WPS_HIDE_LOGIN_DIR . 'classes/', array(
	'plugin',
) );

//register_activation_hook( __FILE__, array( 'WPS_Hide_Login', 'activate' ) );

add_action( 'plugins_loaded', 'plugins_loaded_wps_hide_login_plugin' );
function plugins_loaded_wps_hide_login_plugin() {
	new WPS_Hide_Login;

	load_plugin_textdomain( 'wpserveur-hide-login', false, dirname( WPS_HIDE_LOGIN_BASENAME ) . '/languages' );
}