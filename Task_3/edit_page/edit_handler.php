<?php
// Connect to database
require_once "../db.php";
$conn = Database::getConnection();

// Include classes to sanatize new input and update user
require_once "../classes.php";

// Get empty expected fields array for the new data
$new_data = Handle_input::init_expected_fields();

// Clean the input
$new_clean_input = Handle_input::clean_input($new_data);

// Create a Handle_input instance 
$handle_input = new Handle_input;

// Check for required inputs
$required_inputs = ['first_name', 'last_name', 'email', 'gender'];
$handle_input->check_required_inputs($required_inputs, $new_clean_input);

// Validate password (if a new one is entered)
if (!empty($new_clean_input['password_1']))
    $handle_input->check_password($new_clean_input['password_1'], $new_clean_input['password_2']);

// Get user_id from hidden input
$user_id = (int)$_POST['user_id'];

// If all is done and cleaned update the database
$user = new User;
$user ->update_user($user_id, $new_clean_input, $conn);

// Go back to the view page
header("Location: ../view_page/view.php?edited=true");
exit;
