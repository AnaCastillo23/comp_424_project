<?php

session_start();

include 'dbconnect.php';

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
    $code = $_POST['code'];
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $bdate = $_SESSION['bdate'];
    $email = $_SESSION['email'];
    $username = $_SESSION['username'];
    $color = $_SESSION['color'];
    $food = $_SESSION['food'];

    if($code != $_SESSION['code']) {
        echo "<script type='text/javascript'>alert('Code is wrong! Please try again.');
                window.location = '/comp_424_project/html/confirmation.html'; </script>";
    }
    else {
        $hashed_password = password_hash($_SESSION['password'], PASSWORD_DEFAULT);
        $stmt = $con->prepare("INSERT INTO user_t (firstname, lastname, DOB, email, username, secret, password_confirmation, favorite_food, favorite_color) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $fname, $lname, $bdate, $email, $username, $hashed_password, $code, $food, $color);
        $stmt->execute();

        header("Location: /comp_424_project/html/log-in.html");
    }
}

?>