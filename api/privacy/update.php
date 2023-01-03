<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$id = $data['id'];
$privacytext = $data['privacytext'];




$sql = "UPDATE privacy SET privacytext='$privacytext' WHERE id='$id'";

$querysql = mysqli_query($conn, $sql);

if ($querysql) {
    $response[] = array(
        'id' => $id, 'Privacy Text' => $privacytext,
        'error' => false,
    );
} else {
    $response = json_encode(array('message' => 'Not Updateds', 'error' => true));
}



echo json_encode($response);
