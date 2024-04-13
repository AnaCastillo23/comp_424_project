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
        //Increases login counter upon successful login
        $update_login_count = $con->prepare("UPDATE user_t SET num_of_logins = COALESCE(num_of_logins, 0) + 1 WHERE username = ?");
        $update_login_count->bind_param("s", $username);
        $update_login_count->execute();
        $update_login_count->close();

        $user_id = $user['userID'];
        //Tracks when the user logged in. Updates user_login_t
        $login_time = date('Y-m-d H:i:s');
        $insert_login_time = $con->prepare("INSERT INTO user_login_t(userID, login_time) VALUES(?, ?)");
        $insert_login_time->bind_param("is", $user_id, $login_time);
        $insert_login_time->execute();
        $insert_login_time->close();

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