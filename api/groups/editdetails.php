<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$id = $DecodeData['id'];
$name = $DecodeData['name'];

$group_visibility = $DecodeData['group_visibility'];
$sql = "UPDATE user_groups SET name='$name',group_visibility='$group_visibility' WHERE id ='$id '";

$run = mysqli_query($conn, $sql);
if ($run) {
    $response[] = array(
        "message" => 'Group Name Updated',
        "name" => $name,
        "group_visibilits" => $group_visibility,
        "error" => 'false'


    );
    echo json_encode($response);
} else {
    $response[] = array(
        "message" => 'Not updated',
        "error" => 'true',
    );
    echo json_encode($response);
}
