<?php
    // Get data (init to empty if no data was sent)
    $first_name = $_POST['first_name']?? '';
    $last_name = $_POST['last_name']?? '';

    $email = $_POST['email']?? '';
    $password_1 = $_POST['password_1']?? '';
    $password_2 = $_POST['password_2']?? '';

    $gender = $_POST['gender']?? '';
    $hobbies = $_POST['hobbies']?? [];
    $country = $_POST['country']?? '';

    // ===============================================

    // Print data (check if not empty first)
    echo "<h1>Submitted Data:</h1>";

    // names section
    if (!empty($first_name))
        echo "<b>Fisrt Name:</b> $first_name <br>";
    if (!empty($last_name))
        echo "<b>Last Name:</b> $last_name <br><br>";

    // account details section
    if (!empty($email))
        echo "<b>Email address:</b> $email <br>";
    // trigger an error if the 2 passwords are not the same
    if ($password_1 !== $password_2){
        // trigger_error("The 2 passwords entered were not identicall...");
        echo "<b>[WARNING]</b>:The 2 passwords entered were not identicall...<br>";

        // still print them for testing
        if (!empty($password_1))
        echo "<b>Password:</b> $password_1 <br>";
        if (!empty($password_2))
            echo "<b>Confirmed Password:</b> $password_2 <br><br>";
    }

    // details section
    if (!empty($gender))
        echo "<b>Gender:</b> $gender <br>";

    if (!empty($hobbies)){
        $i = count($hobbies);
        echo "<b>Hobbies:</b>: ";
        foreach ($hobbies as $hobby){
            if ($i > 1)
                echo "$hobby, ";
            else
                echo "$hobby <br>"; // no commas at the last hobby
            
            $i--;   
        }
    }
    
    echo "<b>Country:</b> $country <br><br>";

?>