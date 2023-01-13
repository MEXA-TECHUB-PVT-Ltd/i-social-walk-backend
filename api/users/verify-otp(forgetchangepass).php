<?php
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);

$email = $DecodeData['email'];
$newpass = $DecodeData['newpass'];
$confirmpass = $DecodeData['confirmpass'];
$newpassword = md5($newpass);
$sql = "SELECT email FROM users where email='$email'";

$run = mysqli_query($conn, $sql);

if ($newpass == $confirmpass) {
    $sql1 = "UPDATE users SET password='$newpassword' where email = '$email'";
    $run = mysqli_query($conn, $sql1);
    if ($run) {
        $response[] = array(
            'messsage' => 'Password Changed',
            'error' => 'false',
        );
    }
} else {

    $response[] = array(
        'messsage' => 'Password doesnot Match',
        'errors' => 'true',
    );
}

echo json_encode($response);
