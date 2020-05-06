<?php

/**
 * @since 1.0.0
 * @package ToDo List
 */

 class ToDoListDeactivate
 {
    public static function deactivate() {
        flush_rewrite_rules();
    }
 }