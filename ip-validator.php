<?php
/**
 * Plugin Name:       IP validator
 * Description:       The plugin allows to validate the IP of the comments user before sending a comment.
 * Author:            Viktor Ievlev
 * Version:           1.0
 * Author URI:        http://viktor-web.ru
 * Text Domain:       ip-validator
 * Domain Path:       /languages
 */
 
/*  Copyright 2019  Viktor Ievlev  (email: bazz@bk.ru)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Trextdomain loading
function ip_validator_textdomain_load() {
	load_plugin_textdomain( 'ip-validator', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'ip_validator_textdomain_load' );

// Adding a hidden field
add_action( 'comment_form', 'ip_validator_field', 20 );
function ip_validator_field() {
	echo '<input type="hidden" id="ip-validator" name="ip-validator" value="" />';
}

// JS including
add_action( 'comment_form', 'ip_validator_js', 25 );
function ip_validator_js() {
	echo file_get_contents( plugin_dir_path( __FILE__ ) . '/inc/js.inc' );
}

// Comment validation
add_filter( 'preprocess_comment', 'ip_validator_validation' );
function ip_validator_validation( $commentdata ) {
	if ( empty( $_POST['ip-validator'] ) || $_POST['ip-validator'] != $_SERVER['REMOTE_ADDR'] ) {
		wp_die(
			esc_html__( 'Error: You have no right to add a comment.', 'ip-validator' ),
			esc_html__( 'Comment Submission Failure' ),
			[ 'back_link' => true ]
		);
	}
	return $commentdata;
}
