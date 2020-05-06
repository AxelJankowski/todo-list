<?php

/**
 * Trigger on uninstall.
 * 
 * @since 1.0.0
 * @package ToDo List
 */

 if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
     die;
 }



 // Delete database data.
 $tasks = get_posts( array( 'post_type' => 'task' , 'numberposts' => -1 ) );

 foreach( $tasks as $task ) {
     wp_delete_post( $task->ID, true );
 }