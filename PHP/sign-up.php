<?php
include "dbconnect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $bdate = $_POST['bdate'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Mailer = 'smtp';
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->Username = "aovsepyan929@gmail.com";
    $mail->Password = "ybwlykctponxpfww";

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
                        try {
                            $mail->setFrom("noreply@gmail.com");
                            $mail->addAddress($_POST['email']);
                            $mail->isHTML(true);
                            $mail->Subject = 'Email verification';
                            $mail->Body = "Please verify!";
                            $mail->send();
                            header("Location: /comp_424_project/html/log-in.html");
                        } catch (Exception $e) {
                            echo $mail->ErrorException;
                        }
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