<?php
/////////////////////////////////////////////////////////
// Runs only once to create the database and the table //
/////////////////////////////////////////////////////////
const HOST = 'localhost';
const USER = 'root';
const PASSWORD = '';
const DB_NAME = 'users_db';

// Create a database
try {
    $conn = new PDO("mysql:host=" . HOST, USER, PASSWORD);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS '" . DB_NAME . "'";
    $conn->exec($sql);
    echo "Database created successfully";


    // Create table only if database was created successfully
    try {
        $conn = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME . ";", USER, PASSWORD);

        $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                first_name VARCHAR(100) NOT NULL,
                last_name VARCHAR(100) NOT NULL,
                email VARCHAR(191) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                gender ENUM('male', 'female', 'other') NOT NULL,
                hobbies TEXT,
                country VARCHAR(100),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

        $conn->exec($sql);
        echo "Table users created successfully";
    } catch (PDOException $e) { // Error in table creation
        echo $sql . "<br>" . $e->getMessage();
    }
} catch (PDOException $e) { // Error in database creation
    echo $sql . "<br>" . $e->getMessage();
}

// Close connection
$conn = null;
