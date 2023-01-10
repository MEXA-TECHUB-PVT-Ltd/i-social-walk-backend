<?php
header("Content-Type: application/json");
date_default_timezone_set("Asia/Karachi");
$server = 'localhost';
$username = 'root';
$password = '';
$db = 'isocialwalk';
$conn = mysqli_connect($server, $username, $password, $db);
if (!$conn) {
    //  echo 'error';
} else {
    // echo 'connected';z
}
