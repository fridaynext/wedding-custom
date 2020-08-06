<?php
/*
Plugin Name: San Antonio Weddings - Custom Functionality
Plugin URI:  https://friday-next.com
Description: This plugin enhances the functionality of the San Antonio Weddings website, without altering the child theme's functions.php file, so it will survive theme updates / changes.
Version:     1.1.6
Author:      Friday Next
Author URI:  https://friday-next.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: saw-fn-saw

San Antonio Weddings - Custom Functionality is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

San Antonio Weddings - Custom Functionality is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with San Antonio Weddings - Custom Functionality. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if ( ! class_exists('InstagramUserFeed' ) ):
	/**
	 * Creates the Pinterest feed class instance.
	 * @since 1.2.2
	 */
	require_once dirname(__FILE__) . '/includes/InstagramUserFeed/InstagramUserFeed.php';
endif;


if ( ! class_exists('SawConfig' ) ):
	/**
	 * Creates the SawConfig class instance.
	 * @since 1.2.2
	 */
	require_once dirname( __FILE__ ) . '/includes/Config/SawConfig.php';
endif;

if ( ! function_exists( 'saw_initialize_extension' ) ):
	/**
	 * Creates the extension's main class instance.
	 * @since 1.0.0
	 */
	function saw_initialize_extension() {
		require_once plugin_dir_path( __FILE__ ) . 'functions.php';
	}
	add_action( 'after_setup_theme', 'saw_initialize_extension', 15 );
endif;

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once( __DIR__ . '/vendor/autoload.php' );
}

$fn_saw_dir = dirname( __FILE__ );