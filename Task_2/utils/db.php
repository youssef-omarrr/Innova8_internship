<?php
// Define a class to handle database connection and setup
class Database {
    // Database connection parameters
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'users_db';
    private $conn;

    // init construct
    public function __construct()
    {
        // Attempt a mysql connection
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->dbname);

        // If connection fails, terminate the script with an error message
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Create users table if not exist
        $create_table_query = "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                first_name VARCHAR(100) NOT NULL,
                last_name VARCHAR(100) NOT NULL,
                email VARCHAR(191) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                gender ENUM('male', 'female', 'other') NOT NULL,
                hobbies TEXT,
                country VARCHAR(100),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";

        // Execute the query and check for errors
        if (!mysqli_query($this->conn, $create_table_query)){
            die("Error creating table: " . mysqli_error($this->conn));
        }
    }

    // Public method to allow access to the database connection from outside the class
    public function getConnection() {
        return $this->conn;
    }

}

?>