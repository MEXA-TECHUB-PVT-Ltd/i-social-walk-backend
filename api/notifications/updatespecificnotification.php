<?php

include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$sql = "UPDATE notification SET status='read'  WHERE id='$id'";

$result = mysqli_query($conn, $sql);
if ($result) {

    echo json_encode(array('error' => false, 'Message' => 'Notification Updated'));
} else {
    echo json_encode(array('error' => true, 'Message' => 'No notification found'));
}
