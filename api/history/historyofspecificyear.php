<?php
include('../include/connection.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);

$user_id = $DecodeData['user_id'];
$date = $DecodeData['date'];


$sqlqu = "SELECT * FROM users where id='$user_id' ";
$result = mysqli_query($conn, $sqlqu);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $profile_image = $row['profile_image'];
        $active_watch = $row['active_watch'];
        $phoneno = $row['phoneno'];
        $user_id = $row['id'];
    }
}


$sql = "SELECT * FROM daily_steps_records WHERE year(date)='$date' AND user_id='$user_id' ";

$result = mysqli_query($conn, $sql);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $response[] = array('error' => 'false', 'Message' => 'Succesfully fetched History', 'History' => $output, 'First name' => $first_name, 'Last Name' => $last_name, 'Profile Image' => $profile_image, 'Active Watch' => $active_watch, 'Phone No' => $phoneno);
} else {
    $response[] =  array('message' => 'No record found', 'error' => true);
}
echo json_encode($response);
?>