<?php
//////////////////////////////////////////////
// Contains classes used in multiple files //
/////////////////////////////////////////////
require_once "db.php";

// User class to add a new user to the database, delete one, ot update it
class User
{
    // Function to add a new user to the database
    public function add_user(
        $first_name,
        $last_name,

        $email,
        $password,

        $gender,
        $hobbies,
        $country
    ) {

        // Connect to database
        $conn = Database::getConnection();

        // Hash password using BCRYPT
        $hashed_password = $this->hash_password($password);

        // Convert hobbies from an array to a string
        $hobbies_str = implode(',', $hobbies);

        // Prepare the SQL qurey to insert entry to the sql table
        $sql = "INSERT INTO users (first_name, last_name, email, password, gender, hobbies, country) 
                        VALUES (:first_name, :last_name, :email, :password, :gender, :hobbies, :country)";

        $data = [
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':email' => $email,
            ':password' => $hashed_password,
            ':gender' => $gender,
            ':hobbies' => $hobbies_str,
            ':country' => $country
        ];

        $stmt = $conn->prepare($sql);
        $stmt->execute($data);
    }

    // Helper function to hash passwords
    private function hash_password($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    // Public static function to delete user given its ID in the database
    public static function delete_user($user_id, $conn)
    {
        if (!$conn) {
            echo "[ERROR] Database connection failed.\n";
            exit;
        }

        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "[ERROR] Failed to prepare SQL statement.\n";
            exit;
        }
        $stmt->execute([':id' => $user_id]);
    }

    public static function update_user($user_id, $new_data, $conn)
    {
        // User entered a new password
        if (!empty($new_data['password_1'])) {
            // Hash password using BCRYPT
            $hashed_password = password_hash($new_data['password_1'], PASSWORD_BCRYPT);

            // Convert hobbies from an array to a string
            $hobbies_str = implode(',', $new_data['hobbies']);

            // Prepare the SQL query
            $sql = "UPDATE users SET first_name=:first_name,
                                    last_name=:last_name, 
                                    email=:email,
                                    password=:password,
                                    gender=:gender,
                                    hobbies=:hobbies, 
                                    country=:country WHERE id=:user_id";
            $stmt = $conn->prepare($sql);
            $data = [
                ':first_name' => $new_data['first_name'],
                ':last_name' => $new_data['last_name'],
                ':email' => $new_data['email'],
                ':password' => $hashed_password,
                ':gender' => $new_data['gender'],
                ':hobbies' => $hobbies_str,
                ':country' => $new_data['country'],
                ':user_id' => $user_id
            ];
        }

        // User used the same old password
        else {
            // Convert hobbies from an array to a string
            $hobbies_str = implode(',', $new_data['hobbies']);

            // Convert hobbies from an array to a string
            $sql = "UPDATE users SET first_name=:first_name,
                                    last_name=:last_name, 
                                    email=:email,
                                    gender=:gender,
                                    hobbies=:hobbies, 
                                    country=:country WHERE id=:user_id";
            $stmt = $conn->prepare($sql);
            $data = [
                ':first_name' => $new_data['first_name'],
                ':last_name' => $new_data['last_name'],
                ':email' => $new_data['email'],
                ':gender' => $new_data['gender'],
                ':hobbies' => $hobbies_str,
                ':country' => $new_data['country'],
                ':user_id' => $user_id
            ];
        }

        // Execute statement
        $stmt->execute($data);
    }
}

// =============================================== //
// =============================================== //

// A class that handles cleaning the input
class Handle_input
{
    // Returns an array of empty expected fields
    public static function init_expected_fields()
    {
        return [
            'first_name' => '',
            'last_name' => '',

            'email' => '',
            'password_1' => '',
            'password_2' => '',

            'gender' => '',
            'hobbies' => [], // special case
            'country' => ''
        ];
    }

    // Static function to return sanitized input (used in registration and edit pages)
    public static function clean_input($expected_fields)
    {
        // Get input SAFELY
        $input = [];

        // Loop through every input
        foreach ($expected_fields as $field => $default) {
            // Hobbies are a special case, bec they are an array
            if ($field == "hobbies") {
                $input[$field] = isset($_POST[$field]) && is_array($_POST[$field]) ?
                    array_map('htmlspecialchars', $_POST[$field]) // sanitize each hobby
                    : $default;
            } else {
                $input[$field] = htmlspecialchars(trim($_POST[$field] ?? $default));
            }
        }

        // Return clean input
        return $input;
    }

    // A function that checks if the required inputs all filled or not
    public function check_required_inputs($required_inputs, $input)
    {
        // Make sure required fields are filled
        foreach ($required_inputs as $field) {
            if (empty($input[$field])) {
                echo "[ERROR] {$field} is required.\n";
                exit;
            }
        }
    }

    // A function that checks if the entered passwords meet the requirments or not
    public function check_password($pass_1, $pass_2)
    {
        // Check password matching
        if ($pass_1 !== $pass_2) {
            echo "[ERROR] Passwords do not match.\n";
            exit;
        }

        // Check password length (small value for testing only)
        if (strlen($pass_1) < 5) {
            echo "[ERROR] Password length is too small.\n";
            exit;
        }

        // Check if password has numbers and letters
        if (!preg_match('/[a-zA-Z]/', $pass_1) || !preg_match('/\d/', $pass_1)) {
            // preg_match('/[a-zA-Z]/', $pass_1) checks for any letter.
            // preg_match('/\d/', $pass_1) checks for any digit.

            echo "[ERROR] Password must have both letters and numbers.\n";
            exit;
        }
    }
}
