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



class ToDoListPlugin
{

	/**
	 * Load scripts and admin panel.
	 */
	function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'backend_scripts' ) );

		add_action( 'admin_menu',            array( $this, 'add_admin_pages' ) );

		add_action( 'wp_ajax_add_task',      array( $this, 'add_task' ) );
	}



	/**
	 * Add task.
	 */
	function add_task() {

		if( isset($_POST['#todo_list_new_task_input'] ) ) {

			global $wpdb; // Get access to database.
		
			$data_array = array(
				'task' => $_POST['task']
			);
			$table_name = 'wp_todo_list';
		
			$rowResult = $wpdb->insert( $table_name, $data_array, $format=NULL );
		
			// $rowResult returns 1
		
			if( $rowResult == 1 ) {
				echo '<h1>Task added successfully!</h1>';
			} else {
				echo 'Error adding task.';
			}
		
			wp_die();
		}
	}


	
	/**
	 * Add "ToDo List" admin panel in wp navigation
	 */
	public function add_admin_pages() {
		add_menu_page(
			'ToDo List',                   // Page title
			'ToDo List',                   // Menu title
			'manage_options',              // Capability
			'todo_list_plugin',            // Menu slug
			array( $this, 'admin_panel' ), // Function
			'dashicons-format-aside',      // Icon url
			null                           // Position
		);
	}
	public function admin_panel() { // Work in progress...
		?>
		
		<div class="container-out">
			<div class="container-in">

				<ul class="list">
					<form method="POST" action="#" class="item list-hover item-input" id="new_task_form" data-page="true">
						<label class="item-checkbox">
							<input type="checkbox">
							<span class="checkmark"></span>
						</label>
						<label class="input-out">
							<input class="input-in list-hover" type="item-text" id="task" placeholder="Enter new task here...">
						</label>
						<button type="submit">asd</button>
					</form>

					<li class="item list-hover">
						<label class="item-checkbox">
							<input type="checkbox" checked="checked">
							<span class="checkmark"></span>
						</label>
						<label class="item-text list-hover">Ale bardzo się staram serio.<label>
					</li>
					<li class="item list-hover">
						<label class="item-checkbox">
							<input type="checkbox" checked="checked">
							<span class="checkmark"></span>
						</label>
						<label class="item-text list-hover">Niech mnie wezmą chociaż na staż.<label>
					</li>
					<li class="item list-hover">
						<label class="item-checkbox">
							<input type="checkbox">
							<span class="checkmark"></span>
						</label>
						<label class="item-text list-hover">Pan da 3.<label>
					</li>
				</ul>

			</div>
		</div>
	
	    <?php
	}

	// Enqueue frontend.
	function frontend_scripts() {
		wp_register_script( 'frontend-js', plugins_url( 'dist/js/frontend.js', __FILE__ ), [ 'jquery' ], '11272018' );
		wp_enqueue_script( 'frontend-js' );
	}

	// Enqueue backend.
	function backend_scripts() {
		wp_register_script( 'backend-js', plugins_url( 'dist/js/backend.js', __FILE__ ), [ 'jquery' ], '11272018' );
		wp_enqueue_script( 'backend-js' );
	}
}



if ( class_exists( 'ToDoListPlugin' ) ) {
	$toDoList = new ToDoListPlugin();
	$toDoList->register();
}



// Activation (create table in database).
require_once plugin_dir_path( __FILE__ ) . 'includes/todo-list-activate.php';
register_activation_hook( __FILE__, array( 'ToDoListActivate', 'activate' ) );

// Deactivation (IMPORTANT: deleting table only by uninstalling).
require_once plugin_dir_path( __FILE__ ) . 'includes/todo-list-deactivate.php';
register_deactivation_hook( __FILE__, array( 'ToDoListDeactivate', 'deactivate' ) );