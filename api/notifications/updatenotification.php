<?php

include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);

$to_id = $data['to_id'];
$sql = "UPDATE notification SET status='read'  WHERE to_id='$to_id'";

$result = mysqli_query($conn, $sql);
if ($result) {

    echo json_encode(array('error' => false, 'Message' => 'Notification Updated'));
} else {
    echo json_encode(array('error' => true, 'Message' => 'No notification found'));
}
