<?php

include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);

$to_id = $data['to_id'];
$sql = "Select * from notification where to_id='$to_id' and status='unread' ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(array('error' => false, 'Message' => 'All Notifications', 'Notifications' => $output));
} else {
    echo json_encode(array('error' => true, 'Message' => 'No notification found'));
}
