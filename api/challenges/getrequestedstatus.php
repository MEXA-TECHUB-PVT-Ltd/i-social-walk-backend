<?php
include('../include/functions.php');
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);

$user_id = $DecodeData['user_id'];

$sql = "Select * from challenges_participants where user_id='$user_id' AND status='requested' ";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = array(
            "user_id" => $row['user_id'],
            "challenge_id" => $row['challenge_id'],
            "status" => $row['status'],
        );
    }
} else {
    $response[] = array('message' => 'This record doesnot exist in our record', 'error' => 'true');
}
echo json_encode($response);
