
<?php
session_start();
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);


$user_id = $DecodeData['user_id'];

$sql = "Select * from users WHERE id=$user_id";
$result = mysqli_query($conn, $sql) or die("Query failed");
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $firstname = $row['first_name'];
        $lastname = $row['last_name'];
        $email = $row['email'];
        $active_watch = $row['active_watch'];
        $phoneno = $row['phoneno'];
        $profile_image = $row['profile_image'];
    }
    $response[] = array(
        "message" => 'User Data',
        "email" => $email,
        "password" => $password,
        "profile image" => $profile_image,
        "first_name" => $firstname,
        "phoneno" => $phoneno,
        "last_name" => $lastname,
        "active_watch" => $active_watch,
        "error" => false,
    );
    echo json_encode($response);
}
