<?php
include "../classes.php"; // To use User and Handle_input classes
require_once "../db.php";
// =============================================== //

// Create a Handle_input instance 
$handle_input = new Handle_input;

// Get empty expected fields array
$expected_fields = Handle_input::init_expected_fields();

// Clean input
$clean_input = Handle_input::clean_input($expected_fields);

// Check for required inputs
$required_inputs = ['first_name', 'last_name', 'email', 'password_1', 'gender'];
$handle_input->check_required_inputs($required_inputs, $clean_input);

// Validate password
$handle_input->check_password($clean_input['password_1'], $clean_input['password_2']);


// If all is done and cleaned add it to the database
// Create a new user instance 
$user = new User;
$user->add_user(
    $clean_input['first_name'],
    $clean_input['last_name'],

    $clean_input['email'],
    $clean_input['password_1'],

    $clean_input['gender'],
    $clean_input['hobbies'],
    $clean_input['country']
);

// echo that the registration was completed 
echo "Registration completed successfully";

header("Location: ../login_page/login_page.php");
exit;
// =============================================== //
