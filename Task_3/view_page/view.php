<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/registration_page.css">
    <link rel="stylesheet" href="../css/view_page.css">
    <script src="view_page.js" defer></script>
    <title>View Data</title>
</head>

<body>
    <div id="title">
        <h1>View data page</h1>
    </div>
    <!-- =========================================================== -->

    <?php
    session_start();

    // Assert that no one access the page unless logged in
    if (!isset($_SESSION['user_id'])) {
        // Not logged in
        header("Location: ../login_page/login.php");
        exit;
    }

    // If we came from the delete action: echo that it was successfull
    if (isset($_GET['deleted']) && $_GET['deleted'] === 'true') {
        echo "<script>alert('User was successfully deleted.');</script>";
    } 
    // else if it came from edit action
    else if (isset($_GET['edited']) && $_GET['edited'] === 'true'){
        echo "<script>alert('User data updated successfully.');</script>";
    }
    // else just say who logged in
    else {
        echo "<script>alert('Logged in as " . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "');</script>";
    }
    // =============================================== //
    // Connect to database
    require_once "../db.php";
    $conn = Database::getConnection();

    // Fetch data
    $sql = "SELECT * FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //  Display data in HTML table
    if (count($result) > 0) {
        echo "<table id='container' cellpadding='10'>";
        echo "<tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Hobbies</th>
            <th>Country</th>
            <th>Actions</th>
            </tr>";

        foreach ($result as $row) {
            $id = $row['id'];
            echo "<tr>";
            echo "<td>{$row['first_name']}</td>";
            echo "<td>{$row['last_name']}</td>";
            echo "<td>{$row['gender']}</td>";
            echo "<td>{$row['hobbies']}</td>";
            echo "<td>{$row['country']}</td>";
            echo "<td>
                <button class='btn' id= 'edit-$id'>Edit</button>
                <button class='btn' id='delete-$id'>Delete</button>
                </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<h1 style='text-align:center'>No records found.</h1>";
    }

    ?>

</body>

</html>