<?php

/**
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since 1.0.0
 * @package ToDo List
 * 
 * @wordpress-plugin
 * Plugin Name: ToDo List
 * Description: Simple ToDo list plugin created as a recruitment task for MPC.
 * Version:     1.0.0
 * Author:      Axel Jankowski
 * Author URI:  https://axeljankowski.github.io
 * License:     ISC
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}



class ToDoList
{
	function __construct() {
		add_action( 'init', array( $this, 'custom_post_type' ) );
	}

	function activate() {
		//echo 'ToDo List plugin was activated. I hope you will like it. :)';
		$this->custom_post_type();

		flush_rewrite_rules();
	}

	function deactivate() {
		//echo 'ToDo List plugin was deactivated.';
		flush_rewrite_rules();
	}

	function custom_post_type() {
		register_post_type( 'task', ['public' => true, 'label' => 'Tasks'] );
	}
}


if ( class_exists( 'ToDoList' ) ) {
	$toDoList = new ToDoList();
}


// Activation.
register_activation_hook( __FILE__, array( $toDoList, 'activate' ) );

// Deactivation.
register_deactivation_hook( __FILE__, array( $toDoList, 'deactivate' ) );



// Enqueue frontend scripts.
function frontend_scripts() {
	wp_enqueue_script(
	'wds-wwe-frontend-js',
	plugins_url( 'assets/js/frontend.js', __FILE__ ),
	[ 'jquery' ],
	'11272018'
	);
}
add_action( 'wp_enqueue_scripts', 'frontend_scripts' );

// Enqueue admin scripts.
function admin_scripts() {
	wp_enqueue_script(
	'wds-wwe-admin-js',
	plugins_url( 'assets/js/admin.js', __FILE__ ),
	[ 'jquery' ],
	'11272018'
	);
}
add_action( 'admin_enqueue_scripts', 'admin_scripts' );