<?php
include "dbconnect.php";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $bdate = $_POST['bdate'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    $stmt = $con->prepare("SELECT * FROM user_t WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0) {
        echo "<script type='text/javascript'>alert('User already exists');
        window.location = '/comp_424_project/html/sign-up.html';
        </script>";
    } else {
            $stmt = $con->prepare("SELECT * FROM user_t WHERE email=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0) {
                echo "<script type='text/javascript'>alert('Email already in use.');
                window.location = '/comp_424_project/html/sign-up.html';
                </script>";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $con->prepare("INSERT INTO user_t (firstname, lastname, DOB, email, username, secret) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $fname, $lname, $bdate, $email, $username, $hashed_password);
                if($stmt->execute()) {
                    echo "<script type='text/javascript'>alert('Signup Successful');</script>";
                    header("Location: /comp_424_project/html/log-in.html");
                } else {
                    echo "<script type='text/javascript'>alert('Signup Failed');
                    window.location = '/comp_424_project/html/sign-up.html';
                    </script>";
                }
            }
        }
    $stmt->close();
}
$con->close();
?>