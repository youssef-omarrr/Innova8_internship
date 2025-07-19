<?php
// Include DB connection
include_once "../utils/connect_db.php";
$conn = init_db_connection($echo = 0);

// Get user ID from URL
$userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch user data from DB
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle case when user not found
if (!$user) {
    die("User not found.");
}

// Convert hobbies string to array
$hobbies = explode(',', $user['hobbies']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../public/assets/css/registration_page.css" />
    <title>Edit User</title>
</head>

<body>
    <!-- Title Section -->
    <div id="title">
        <h1>Edit User</h1>
    </div>

    <!-- Edit Form -->
    <form id="container" method="POST" action="../controllers/edit_handler.php">
        <!-- Hidden user ID -->
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">

        <!-- Name Fields -->
        <div id="names">
            <div class="entry">
                <label class="bolder">First Name:</label>
                <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" />
            </div>
            <div class="entry">
                <label class="bolder">Last Name:</label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" />
            </div>
        </div>

        <!-- Account Section -->
        <div id="account">
            <div class="entry">
                <label class="bolder">Email address:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" />
            </div>
            <div class="entry">
                <label class="bolder">Password:</label>
                <input type="password" name="password_1" placeholder="Leave blank to keep current" />
            </div>
            <div class="entry">
                <label class="bolder">Confirm password:</label>
                <input type="password" name="password_2" placeholder="Leave blank to keep current" />
            </div>
        </div>

        <!-- Additional Details -->
        <div id="details">
            <!-- Gender -->
            <div id="gender">
                <label class="bolder">Gender:</label>
                <div>
                    <input type="radio" name="gender" value="male" <?= $user['gender'] === 'male' ? 'checked' : '' ?> />
                    <label for="male">Male</label>
                </div>
                <div>
                    <input type="radio" name="gender" value="female" <?= $user['gender'] === 'female' ? 'checked' : '' ?> />
                    <label for="female">Female</label>
                </div>
            </div>

            <!-- Hobbies -->
            <div id="hobbies">
                <label class="bolder">Hobbies:</label>
                <?php
                $all_hobbies = ['Reading', 'Traveling', 'Sports'];
                foreach ($all_hobbies as $hobby) {
                    $checked = in_array($hobby, $hobbies) ? 'checked' : '';
                    echo "<div><input type='checkbox' name='hobbies[]' value='$hobby' $checked />
                        <label>$hobby</label></div>";
                }
                ?>
            </div>

            <!-- Country -->
            <div>
                <label class="bolder">Country:</label>
                <select name="country" id="country">
                    <?php
                    $countries = ['Egypt', 'US', 'Libya', 'SA'];
                    foreach ($countries as $c) {
                        $selected = ($user['country'] === $c) ? 'selected' : '';
                        echo "<option value='$c' $selected>$c</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <!-- Form Buttons -->
        <div id="buttons">
            <button type="submit" class="btn">Save Changes</button>
            <a href="view.php" class="btn">Cancel</a>
        </div>
    </form>
</body>
</html>
