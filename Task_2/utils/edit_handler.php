<?php
// Include database connection setup
include_once "test_db.php";
$conn = init_db_connection($cho = 0);

// Collect and sanitize user inputs
$userId = (int)$_POST['user_id'];
$first = trim($_POST['first_name']);
$last = trim($_POST['last_name']);
$email = trim($_POST['email']);
$gender = $_POST['gender'] ?? '';
$hobbies = isset($_POST['hobbies']) ? implode(",", $_POST['hobbies']) : '';
$country = $_POST['country'];

$password1 = $_POST['password_1'];
$password2 = $_POST['password_2'];

// Prepare SQL statement based on whether password is being updated
if ($password1 && $password1 === $password2) {
    $hashed = password_hash($password1, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, password=?, gender=?, hobbies=?, country=? WHERE id=?");
    $stmt->bind_param("sssssssi", $first, $last, $email, $hashed, $gender, $hobbies, $country, $userId);
} else {
    $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, gender=?, hobbies=?, country=? WHERE id=?");
    $stmt->bind_param("ssssssi", $first, $last, $email, $gender, $hobbies, $country, $userId);
}

// Execute and handle the result
if ($stmt->execute()) {
    header("Location: ../view.php?message=updated");
} else {
    echo "Update failed: " . $stmt->error;
}
