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
	const VERSION     = '1.0.0';
	const POST_TYPE   = 'todo_list';
	const STATUS_META = 'todo_list_item_status';

	static $instance  = false;

	function __construct() { // Add widget functionality
		parent::__construct(
            'todo_list_widget',      // Base ID
			'ToDo List',             // Name
			array( 'description' => 'ToDo list widget created for MPC.' )
		);
		
		add_action( 'widgets_init', function() {
            register_widget( 'ToDoListPlugin' );
		});

		$this->ajax_hooks();
	}



	/**
	 * Load scripts and admin panel.
	 */
	function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'backend_scripts' ) );

		add_action( 'admin_menu',            array( $this, 'add_admin_pages' ) );
	}



	function ajax_hooks() {
		foreach ( array( 'add_item', 'clear_list', 'delete_item', 'do_item', 'undo_item' ) as $action ) {
			add_action( 'wp_ajax_todo_list_' . $action, array( $this, 'wp_ajax_' . $action ) );
		}
	}



	/**
	 * Widget output.
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		echo 'hello world';

		echo $args['after_widget'];
    }
 

	
	/**
	 * Panel options.
	 */
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
					<form class="item list-hover item-input" action="#" id="ataskmanager_page_add_new_form" data-page="true">
						<label class="item-checkbox">
							<input type="checkbox">
							<span class="checkmark"></span>
						</label>
						<label class="input-out">
							<input class="input-in list-hover" type="item-text" id="ataskmanager_page_new_task" placeholder="Enter new task here...">
						</label>
					</form>

					<li class="item list-hover">
						<label class="item-checkbox">
							<input type="checkbox">
							<span class="checkmark"></span>
						</label>
						<label class="item-text list-hover">zrob kupe<label>
					</li>
					<li class="item list-hover">
						<label class="item-checkbox">
							<input type="checkbox" checked="checked">
							<span class="checkmark"></span>
						</label>
						<label class="item-text list-hover">zjedz kupe<label>
					</li>
					<li class="item list-hover">
						<label class="item-checkbox">
							<input type="checkbox">
							<span class="checkmark"></span>
						</label>
						<label class="item-text list-hover">do mycia maly gnoju<label>
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