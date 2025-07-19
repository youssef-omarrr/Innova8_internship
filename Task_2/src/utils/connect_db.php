<?php
include_once 'db.php';

// Tests if the DB was intialized or not and returns the connection
function init_db_connection($echo) {
    try {
        $db = new Database();
        $conn = $db->getConnection();

        // echo only if the echo flag is set
        if ($echo)
            echo "Connection successful and table checked/created successfully.\n";

        return $conn;
    } catch (Exception $e) {
        echo "[Error] " . addslashes($e->getMessage()) . "\n";
        exit;
    }
}