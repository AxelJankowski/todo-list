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
 * Description: Simple ToDo list plugin using AJAX. You may add tasks, delete them or mark as done.
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

		add_action( 'wp_ajax_get_tasks',     array( $this, 'get_tasks' ) );
		add_action( 'wp_ajax_add_task',      array( $this, 'add_task' ) );
	}



	/**
	 * Get tasks.
	 */
	function get_tasks() {

		global $table_prefix, $wpdb;
		$tablename = 'todo_list';
		$todo_list_table = $table_prefix . $tablename;

		$user_id = get_current_user_id();

		$tasks = $wpdb->get_results( "SELECT * FROM {$todo_list_table} WHERE created_user_id = '{$user_id}'" );
		$tasks = json_encode($tasks);

		echo $tasks; // Should pass ajax result to list in admin panel, work in progress...

		wp_die();
	}



	/**
	 * Add new task.
	 */
	function add_task() {

		global $table_prefix, $wpdb;
		$tablename = 'todo_list';
		$todo_list_table = $table_prefix . $tablename;

		$user_id = get_current_user_id();

		$data_array = array(
			'created_user_id' => $user_id,
			'task'            => $_POST['task'],
			'status'          => '',
			'priority'        => ''
		);

		$wpdb->insert( $todo_list_table, $data_array );

		echo $data_array['task'];
	
		wp_die();

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
	public function admin_panel() {
		?>
		
		<div class="container-out">
			<div class="container-in">

				<ul class="list">

					<form method="POST" class="item list-hover item-input" name="new_task_form" id="new_task_form" data-page="true">

						<label class="item-checkbox">
							<input type="checkbox">
							<span class="checkmark"></span>
						</label>
						<label class="input-out">
							<input class="input-in list-hover" type="item-text" name="new_task" id="new_task" placeholder="Enter new task here...">
						</label>

					</form>
					
					<div id="tasks-container">

						<!-- Below should be cleared. -->
						<li class="item list-hover">
							<label class="item-checkbox">
								<input type="checkbox" checked="checked">
								<span class="checkmark"></span>
							</label>
							<label class="item-text list-hover">Ale bardzo się staram serio.</label>
						</li>
						<li class="item list-hover">
							<label class="item-checkbox">
								<input type="checkbox" checked="checked">
								<span class="checkmark"></span>
							</label>
							<label class="item-text list-hover">Niech mnie wezmą chociaż na staż.</label>
						</li>
						<li class="item list-hover">
							<label class="item-checkbox">
								<input type="checkbox">
								<span class="checkmark"></span>
							</label>
							<label class="item-text list-hover">Pan da 3.</label>
						</li>

					</div>

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