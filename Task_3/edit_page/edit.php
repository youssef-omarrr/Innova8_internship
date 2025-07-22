<?php
// Connect to database
include_once "../db.php";
$conn = Database::getConnection();

// Fetch user data from DB
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Convert hobbies string to array
$hobbies = explode(',', $user['hobbies']);


session_start();
// Assert that no one access the page unless logged in
if (!isset($_SESSION['user_id'])) {
    // Not logged in
    header("Location: ../login_page/login_page.php");
    exit;
}
echo "<script>alert('Logged in as " . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "');</script>";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/registration_page.css" />
    <title>Edit User</title>
</head>

<body>
    <!-- =========================================================== -->
    <div id="title">
        <h1>Edit User</h1>
    </div>
    <!-- =========================================================== -->
    <form id="container" method="POST" action="edit_handler.php">
        <!-- Hidden user ID -->
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['user_id']) ?>">

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

        <!-- =========================================================== -->
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

        <!-- =========================================================== -->
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
                    $countries = ['Egypt', 'United States', 'Libya', 'Saudi Arabia'];
                    foreach ($countries as $country) {
                        $selected = ($user['country'] === $ccountry) ? 'selected' : '';
                        echo "<option value='$ccountry' $selected>$ccountry</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <!-- =========================================================== -->
        <!-- Form Buttons -->
        <div id="buttons">
            <button type="submit" class="btn">Save Changes</button>
            <a href="../view_page/view.php" class="btn">Cancel</a>
        </div>
    </form>
</body>

</html>