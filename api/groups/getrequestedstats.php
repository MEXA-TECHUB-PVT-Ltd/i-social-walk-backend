<?php
include('../include/functions.php');
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$user_id = $DecodeData['user_id'];


$sql = "Select * from group_member where user_id='$user_id' AND status='requested' ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {

        $user_id = $row['user_id'];
        $group_id = $row['group_id'];
        $status = $row['status'];
    }

    $response[] = array(
        'Group id' =>  $group_id,
        'user_id' => $user_id,
        'status' => $status,

    );
} else {
    $response[] = array('message' => 'No Request Sent', 'error' => 'true');
}
echo json_encode($response);
