<?php

include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);

$sql = "Select * from terms";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $terms = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(array('error' => false, 'Message' => 'Terms & Conditions', 'Terms' => $terms));
} else {
    echo json_encode(array('error' => true, 'Message' => 'No notification found'));
}
