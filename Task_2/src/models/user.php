<?php
include "../utils/db.php";

class User{
     // User properties
    private $conn; // Database connection

    // Constructor to initialize DB connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Function to add a new user to the database
    public function add_user( $first_name,
                                $last_name,

                                $email,
                                $password,

                                $gender,
                                $hobbies,
                                $country){

        // Hash password using BCRYPT
        $hashed_password = $this->hash_password($password);

        // Convert hobbies from an array to a string
        $hobbies_str = implode(',', $hobbies);

        // Prepare the SQL qurey to insert entry to the sql table
        $sql = "INSERT INTO users (first_name, last_name, email, password, gender, hobbies, country) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);

        // Check if preparation was successful
        if (!$stmt) {
        die("SQL error: " . mysqli_error($this->conn));
        }

        // Bind the parameters to the statment
        mysqli_stmt_bind_param($stmt, "sssssss", $first_name,
                                                $last_name, 
                                                $email, 
                                                $hashed_password, 
                                                $gender, 
                                                $hobbies_str, 
                                                $country);
        // Execute the query and handle result
        if (!mysqli_stmt_execute($stmt)) {
            die("Execute failed: " . mysqli_stmt_error($stmt));
        }

        // Clean up
        mysqli_stmt_close($stmt);
    }

    // Helper function to hash passwords
    private function hash_password($password){
        return password_hash($password, PASSWORD_BCRYPT);
    }
    
}

?>