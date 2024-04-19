<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home Page</title>
    <link rel="stylesheet" href="../html/styles/styles-home.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
    />
  </head>
  <body>
    <div class="welcome-wrapper">
      <p class="welcome-text">Welcome User</p>
    </div>
    <div class="welcome-wrapper">
    <?php
    session_start();
    if (isset($_SESSION['username'])) {
        echo "Hi, " . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . " you have logged in "
         . $_SESSION['num_of_logins'] . " times.\nLast Login: ";
    } 
    ?>
    </div>
  </body>
</html>
