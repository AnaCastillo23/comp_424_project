<?php
session_start();

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
    $color = $_POST['color'];
    $food = $_POST['food'];
    $generator = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $shuffle = substr(str_shuffle($generator), 0, 6);

    $_SESSION['fname'] = $fname;
    $_SESSION['lname'] = $lname;
    $_SESSION['bdate'] = $bdate;
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['code'] = $shuffle;
    $_SESSION['food'] = $food;
    $_SESSION['color'] = $color;

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

    if($password != $repassword) {
        echo "<script type=text/javascript>alert('Passwords do not match'); 
                window.location = '/comp_424_project/html/sign-up.html'</script>";
        exit();
    }
    else {
        if ($result->num_rows > 0) {
            echo "<script type='text/javascript'>alert('User already exists');
        window.location = '/comp_424_project/html/sign-up.html';
        </script>";
        } else {
            $stmt = $con->prepare("SELECT * FROM user_t WHERE email=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                echo "<script type='text/javascript'>alert('Email already in use.');
                window.location = '/comp_424_project/html/sign-up.html';
                </script>";
            } else {
                if ($stmt->execute()) {
                    try {
                        $mail->setFrom("noreply@gmail.com");
                        $mail->addAddress($_POST['email']);
                        $mail->isHTML(true);
                        $mail->Subject = 'Email verification';
                        $mail->Body = "Confirmation code: " . $shuffle;
                        $mail->send();
                        header("Location: /comp_424_project/html/confirmation.html");
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
        $con->close();
    }
}
?>