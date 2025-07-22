<?php
////////////////////////////////////////////////////////
// Connect to the database, using the same connection //
////////////////////////////////////////////////////////
class Database
{
    const HOST = 'localhost';
    const USER = 'root';
    const PASSWORD = '';
    const DB_NAME = 'users_db';
    private static $conn = null; // Shared static property across all instances 
    // ! `require_once` must be used in order not to redefine the property


    public static function getConnection() // Shared static property across all instances 
    {
        // Checks if there is already a connection or not; Returns connection
        if (self::$conn === null) {
            try {
                self::$conn = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::DB_NAME . ";", self::USER, self::PASSWORD);

                // set the PDO error mode to exception
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "[ERROR] Database connection failed: " . $e->getMessage();
                exit;
            }

            return self::$conn;
        }
    }
}


// $conn = Database::getConnection();