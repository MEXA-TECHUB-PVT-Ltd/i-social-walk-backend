<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$id = $data['id'];
$sqlqu = "Select * from user_watches where id='$id'";
$sqlquery = mysqli_query($conn, $sqlqu);
if (mysqli_num_rows($sqlquery) > 0) {
    $sql = "Delete from user_watches WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        $response = array('message' => 'Device Deleted', 'error' => false);
    } else {
        $response = array('message' => 'Not Seleted', 'error' => true);
    }
} else {

    $response = array('message' => 'This  Watch doesnot Exist', 'error' => true);
}
echo json_encode($response);
