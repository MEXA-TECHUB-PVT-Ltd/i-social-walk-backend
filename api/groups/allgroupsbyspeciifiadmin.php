<?php

include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);

$created_by_user_id = $data['created_by_user_id'];
$sql = "Select * from user_groups where created_by_user_id='$created_by_user_id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(array('error' => false, 'Message' => 'Succesfully fetched Groups by Specific Admin', 'Groups' => $output));
} else {
    echo json_encode(array('error' => true, 'Message' => 'No record found'));
}
