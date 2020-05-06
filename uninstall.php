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



// Delete database table.
global $table_prefix, $wpdb;

$tablename = 'todo_list';
$todo_list_table = $table_prefix . $tablename;

$sql = "DROP TABLE IF EXISTS `$todo_list_table`";
$wpdb->query($sql);

delete_option("todo_list_plugin_version");