<?php

// Start session to store login status
// Set session time to be 5 minutes
session_set_cookie_params(60 * 5);
session_start();

// Connect to database
require_once "../db.php";
$conn = Database::getConnection();

// =============================================== //
// Define expected POST fields with default values
$expected_fields = [
    'email' => '',
    'password' => '',
];

// Get input SAFELY
require_once "../classes.php";
$input = Handle_input::clean_input($expected_fields);

$email = $input["email"];
$password = $input["password"];

// =============================================== //
// A class to search for email and password in database
class Login
{
    public static function Authenticate($email, $password, $conn)
    {

        // First search for the user with this email
        // Because the emails are unique this forces the result to either be one or none (empty array)
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // returns all the users data

        // if no user found return
        if (!$user) {
            echo "[ERROR] {$email} not found in the database.\n";
            return false;
        }

        // Then verify that the passwords match
        if (!password_verify($password, $user['password'])) {
            echo "[ERROR] Incorrect password.\n";
            return false;
        }

        // At successfull login, save the user's id to the session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];

        return true;
    }
}
// =============================================== //

if (Login::Authenticate($email, $password, $conn)) {
    // Sent via edit/ delete buttons
    if (!empty($_POST['user_id']) && !empty($_POST['action'])) {

        // Get data
        $user_id = $_POST['user_id'];
        $action = $_POST['action'];

        // Edit
        if ($action === 'edit') {
            header("Location: ../edit_page/edit.php");
            exit;
        }
        // Delete
        else if ($action === 'delete') {
            User::delete_user($user_id, $conn);
            // Tell the view page that we came from the delete action
            header("Location: ../view_page/view.php?deleted=true");
            exit;
        }
    } 
    // No action
    else {
        header("Location: ../view_page/view.php");
        exit;
    }
} else {
    echo "Incorrect username or password";
    exit;
}
