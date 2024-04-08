<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT secret FROM user_t WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['secret'])) {
        $_SESSION['username'] = $username;
        header("Location: /comp_424_project/html/home-page.html");
        exit;
    } else {
        echo "<script type='text/javascript'>alert('Invalid login credentials.');
        window.location = '/comp_424_project/html/log-in.html';
        </script>";
    }

    $stmt->close();
    $con->close();
}

?>