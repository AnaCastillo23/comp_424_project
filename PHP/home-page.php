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
      <h2 class="welcome-text">Welcome User</h2>
    </div>
    <div class="user-info-wrapper">
      <p>
        <?php
        session_start();
        if (isset($_SESSION['username'])) {
            echo "Hi, " . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . " you have logged in "
            . $_SESSION['num_of_logins'] . " times. <br> Last Login: " . $_SESSION['login_time']; 
        }  
        ?>
      </p>
    </div>
    <div class="file-link-container">
      <p>
        <a href="../company_confidential_file.txt" download>company-confidential-file.txt</a>
      </p>
    </div>
  </body>
</html>
