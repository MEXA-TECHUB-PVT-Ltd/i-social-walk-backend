<?php
header('Content-Type:application/json');
header('Acess-Control-Allow-Origin:*');
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$id = $DecodeData['id'];
$sql = "SELECT * FROM groups where id='$id'";
$run = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($run)) {


    $response[] = array(
        "id" => $row['id'],
        "image_link" => $row['image'],
        "name" => $row['name'],
        "Admin id" => $row['created_by_user_id'],
        "group_privacy" => $row['group_privacy'],
        "group_visibility" => $row['group_visibility'],
        "created_at" => $row['created_at'],
    );
}


echo json_encode($response);
