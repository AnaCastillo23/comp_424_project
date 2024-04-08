<?php
$con = mysqli_connect('47.229.188.93', 'alek', 'tEMp1234$', 'comp_424');
if ($con) {
    echo "<script type='text/javascript'>console.log('Connection Successful');</script>";
} else {
    die(mysqli_error($con));
}

?>