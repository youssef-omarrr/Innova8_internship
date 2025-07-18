<?php
include "../models/user.php";
include_once "../utils/test_db.php";

try{
// initialize the db
$conn = init_db_connection($echo = 1);

// =============================================== //

// Define expected fields with default values being empty strings (or array in case of hobbies)
$expected_fields = [
    'first_name' => '',
    'last_name' => '',

    'email' => '',
    'password_1' => '',
    'password_2' => '',

    'gender' => '',
    'hobbies' => [], // special case
    'country' => '',
];

// Get input SAFELY
$input = [];

foreach ($expected_fields as $field => $default) {
    if ($field == "hobbies") {
        $input[$field] = isset($_POST[$field]) && is_array($_POST[$field]) ?
            array_map('htmlspecialchars', $_POST[$field]) // sanitize each hobby
            : $default;
    } else {
        $input[$field] = htmlspecialchars(trim($_POST[$field] ?? $default));
    }
}

// Make sure required fields are filled
foreach (['first_name', 'last_name', 'email', 'password_1', 'gender'] as $field) {
    if (empty($input[$field])) {
        echo "[ERROR] {$field} is required.\n";
        exit;
    }
}

// Check password matching
if ($input['password_1'] !== $input['password_2']) {
    echo "[ERROR] Passwords do not match.\n";
    exit;
}

// Create a new user instance and add it to the database
$user = new User($conn);
$user->add_user(
    $input['first_name'],
    $input['last_name'],

    $input['email'],
    $input['password_1'],

    $input['gender'],
    $input['hobbies'],
    $input['country']
);

    // echo that the registeration was completed for the js file to be able to clear the form entries
    echo "Registration completed successfully";
} catch (Exception $e) {
    echo "[Error] " . $e->getMessage();
}

// =============================================== //
