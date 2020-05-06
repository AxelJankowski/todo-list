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



class ToDoListPlugin extends WP_Widget
{
	function __construct() {

		parent::__construct(
            'todo_list_widget',  // Base ID
			'ToDo List',  // Name
			array( 'description' => 'ToDo list widget created for MPC.' )
		);
		
		add_action( 'widgets_init', function() {
            register_widget( 'ToDoListPlugin' );
		});
		
	}



	/**
	 * Load scripts and stuff.
	 */
	function register() {
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'backend_scripts' ) );

		add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
	}



	public function widget( $args, $instance ) {

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		// Widget output.
		echo 'HELLO, WORLD!';

		echo $args['after_widget'];
    }
 

	
    public function form( $instance ) {
 
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
        $text = ! empty( $instance['text'] ) ? $instance['text'] : esc_html__( '', 'text_domain' );
        ?>

		<!-- Title -->
        <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php echo esc_html__( 'Title:', 'text_domain' ); ?>
			</label>

            <input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				type="text"
				value="<?php echo esc_attr( $title ); ?>"
			>
        </p>

		<!-- Text -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'Text' ) ); ?>">
				<?php echo esc_html__( 'Text:', 'text_domain' ); ?>
			</label>

            <textarea
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"
				type="text"
				cols="30"
				rows="10"><?php echo esc_attr( $text ); ?>
			</textarea>
        </p>
        <?php
 
    }
 


	/**
	 * Update
	 */
    public function update( $new_instance, $old_instance ) {
 
        $instance = array();
 
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['text'] = ( !empty( $new_instance['text'] ) ) ? $new_instance['text'] : '';
 
        return $instance;
    }


	
	// Add panel in wp navigation
	public function add_admin_pages() {
		add_menu_page( 'ToDo List', 'ToDo List', 'manage_options', 'todo_list_plugin', array( $this, 'admin_index' ), 'dashicons-format-aside', null );
	}
	public function admin_index() {
		// Work in progress...
	}



	// Enqueue frontend (wp).
	function frontend_scripts() {
		wp_register_script( 'frontend-js', plugins_url( 'dist/js/frontend.js', __FILE__ ), [ 'jquery' ], '11272018' );
		wp_enqueue_script( 'frontend-js' );
	}

	// Enqueue backend (admin).
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

// Deactivation.
require_once plugin_dir_path( __FILE__ ) . 'includes/todo-list-deactivate.php';
register_deactivation_hook( __FILE__, array( 'ToDoListDeactivate', 'deactivate' ) );