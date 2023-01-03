<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$id = $data['id'];
$terms = $data['terms'];




$sql = "UPDATE terms SET terms='$terms' WHERE id='$id'";

$querysql = mysqli_query($conn, $sql);

if ($querysql) {
    $response[] = array(
        'id' => $id, 'terms Text' => $terms,
        'error' => false,
    );
} else {
    $response = json_encode(array('message' => 'Not Updateds', 'error' => true));
}



echo json_encode($response);
