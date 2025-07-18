<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/registration_page.css">
    <link rel="stylesheet" href="styles/view_page.css">
    <script src="scripts/view_page.js" defer></script>
    <title>View Data</title>
</head>

<body>
    <div id="title">
        <h1>View data page</h1>
    </div>

    <div id="login">
        <button id="close-login" type="button">×</button> <!-- X button -->
        <h2>Log in</h2>
        <form id="login-form" method="POST" action="utils/login_handler.php">
            <div class="entry">
                <label class="bolder">Email address:</label>
                <input type="email" placeholder="Email address" name="email" required />
            </div>
            <div class="entry">
                <label class="bolder">Password:</label>
                <input type="password" placeholder="Enter password" name="password" required />
            </div>

            <!-- Hidden inputs to pass action and user ID -->
            <input type="hidden" name="action" id="login-action" /> <!-- Edit/Delete -->
            <input type="hidden" name="user_id" id="login-user-id" />

            <button class="btn_2" type="submit" id="confirm">Confirm</button>
        </form>
    </div>
    <!-- =========================================================== -->
    <?php
    include_once "utils/test_db.php";

    // initialize the db
    $conn = init_db_connection($echo = 0);

    // Fetch data
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    //  Display data in HTML table
    if ($result->num_rows > 0) {
        echo "<table id='container' cellpadding='10'>";
        echo "<tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Hobbies</th>
            <th>Country</th>
            <th>Actions</th>
            </tr>";

        while ($row = $result->fetch_assoc()) {
            $id = htmlspecialchars($row['id']);
            echo "<tr>";
            echo "<td>{$row['first_name']}</td>";
            echo "<td>{$row['last_name']}</td>";
            echo "<td>{$row['gender']}</td>";
            echo "<td>{$row['hobbies']}</td>";
            echo "<td>{$row['country']}</td>";
            echo "<td>
                <button class='btn' data-id='$id' data-action='edit'>Edit</button>
                <button class='btn' id='delete' data-id='$id' data-action='delete'>Delete</button>
                </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<h1 style='text-align:center'>No records found.</h1>";
    }

    // Close connection
    $conn->close();

    ?>

</body>

</html>