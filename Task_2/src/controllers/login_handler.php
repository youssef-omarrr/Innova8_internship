<?php
session_start(); // Start session to store login status

include_once "../utils/test_db.php";
$conn = init_db_connection($echo = 0);
// =============================================== //

// Define expected POST fields with default values
$expected_fields = [
    'email' => '',
    'password' => '',

    'user_id' => '',
    'action' => ''
];

// Get input SAFELY
$input = [];

foreach ($expected_fields as $field => $default) 
    $input[$field] = htmlspecialchars(trim($_POST[$field] ?? $default));

// Assign sanitized input to variables
$email    = $input['email'];
$password = $input['password'];
$userId   = (int)$input['user_id']; // cast to integer for safety
$action   = $input['action'];

echo "$email , $password, $userId, $action";
// =============================================== //

// Prepare SQL to prevent SQL injection
$stmt = $conn->prepare("SELECT email, password FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->execute();
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$result = $stmt->get_result();



if ($row = $result->fetch_assoc()) {

    echo "Hashed: " . $row['password'] . "<br>";
    echo "Entered: " . $password . "<br>";

    // Hashed password stored in database
    if (password_verify($password, $row['password'])) {
        // Password is valid - login success

        // Store in session if needed
        $_SESSION['authenticated'] = true;
        $_SESSION['username'] = $username;

        // Redirect based on action
        if ($action === "edit") {
            header("Location: ../views/edit.php?id=" . urlencode($userId));
            exit();
        } elseif ($action === "delete") {
            // Perform deletion from database
            $delStmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $delStmt->bind_param("i", $userId);
            $delStmt->execute();

            // Redirect back to the view page
            header("Location: ../views/view.php?message=deleted");
            exit();
        } else {
            echo "Invalid action.";
        }

    } else {
        // Incorrect password
        echo "Incorrect username or password.";
    }
} else {
    // User not found
    echo "User not found.";
}

// Close connection
$conn->close();

?>