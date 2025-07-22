<?php
// Start session if not set
if (session_start() === PHP_SESSION_NONE)
    session_start();

// If data was sent via GET, from the edit/ delete buttons in the edit page
if (isset($_GET['id']) && isset($_GET['action'])) {
    // Get the id from the url
    $id = (int)$_GET['id'];

    // Get the action from the url
    $action = $_GET['action'];
}

if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
        echo "<script>alert('Session ended. Please log in again.');</script>";
        // Unset all session variables
        session_unset();
        // Destroies the session
        session_destroy();
    } 


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/registration_page.css">
    <title>Document</title>
</head>

<body>

    <!-- =========================================================== -->
    <div id="title-login">
        <h1>Log in</h1>
    </div>
    <!-- =========================================================== -->
    <form id="container" method="POST" action="login_handler.php">
        <div class="entry">
            <label class="bolder">Email address:</label>
            <input type="email" placeholder="Email address" name="email" required />
        </div>
        <div class="entry">
            <label class="bolder">Password:</label>
            <input type="password" placeholder="Enter password" name="password" required />
        </div>

        <!-- Hidden inputs to pass action and user ID -->
        <input type="hidden" name="user_id" 
        value="<?php echo isset($id) ? (int)$id : ''; ?>"/>
        <input type="hidden" name="action"
        value="<?php echo isset($action) ? htmlspecialchars($action) : ''; ?>" /> <!-- Edit/Delete -->
        

        <button class="btn_2" type="submit" id="confirm">Confirm</button>
    </form>


</body>

</html>

