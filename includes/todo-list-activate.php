<?php

/**
 * @since 1.0.0
 * @package ToDo List
 */

 class ToDoListActivate
 {
    public static function activate() {
        flush_rewrite_rules();

        // Create database table.
        global $table_prefix, $wpdb;
        $tablename = 'todo_list';
        $todo_list_table = $table_prefix . $tablename;
    
        if ( $wpdb->get_var( "SHOW TABLES LIKE '{$todo_list_table}'" ) != $todo_list_table ) {
    
            $sql = "CREATE TABLE IF NOT EXISTS `" . $todo_list_table . "`  ( ";
            $sql .= "  `id`  int(11)   NOT NULL auto_increment, ";
            $sql .= "  `created_user_id` int(11) NOT NULL, ";
            $sql .= "  `task` text NOT NULL, ";
            $sql .= "  `status` tinyint(1) NOT NULL DEFAULT '0', ";
            $sql .= "  `priority` int(11) NOT NULL DEFAULT '0', ";
            $sql .= "  PRIMARY KEY `id` (`id`) ";
            $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; ";
            require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }
}