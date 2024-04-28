<?php
session_start();

include "dbconnect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
    $color = $_POST['color'];
    $food = $_POST['food'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $newpass = $_POST['newpass'];

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


    $stmt = $con->prepare("SELECT favorite_color, favorite_food, firstname, lastname, email, username, secret FROM user_t WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_assoc();

    $user = $value['username'];

    if($value['favorite_color'] == $color && $value['favorite_food'] == $food && $value['firstname'] == $fname && $value['lastname'] == $lname && $value['email'] == $email) {
        $hashed_password = password_hash($newpass, PASSWORD_DEFAULT);
        $new_stmt = $con->prepare("UPDATE user_t SET secret = '$hashed_password' WHERE email = ?");
        echo "dad";
        $new_stmt->bind_param("s", $email);
        $new_stmt->execute();
        try {
            $mail->setFrom("noreply@gmail.com");
            $mail->addAddress($_POST['email']);
            $mail->isHTML(true);
            $mail->Subject = 'Email verification';
            $mail->Body = "Username: " . $user . "\nPassword: " . $newpass;
            $mail->send();
            header("Location: /comp_424_project/html/log-in.html");
            exit();
        } catch (Exception $e) {
            echo $mail->ErrorException;
        }
    }
    else {
        echo "<script type='text/javascript'>alert('Invalid Information!');
                window.location = '/comp_424_project/html/remember-forgot.html'; </script>";
    }
    $con->close();

?>