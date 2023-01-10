<?php
include('../include/connection.php');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);

$id = $DecodeData['id'];
$group_privacy = $DecodeData['group_privacy'];
$sql1 = "SELECT * from user_groups where  id='$id' ";
$group_query = mysqli_query($conn, $sql1);
if ($group_query) {
    while ($row = mysqli_fetch_assoc($group_query)) {
        $id = $row['id'];
        $created_at = $row['created_at'];
        $name = $row['name'];

        $group_visibility = $row['group_visibility'];
        $image = $row['image'];
    }
}
$sql = "UPDATE user_groups SET group_privacy='$group_privacy' WHERE id='$id'";

$run = mysqli_query($conn, $sql);
if ($run) {
    $response[] = array(
        "message" => 'Group Privacy Updated successfully',
        "group_privacy" => $group_privacy,
        'name' => $name,
        'Group Image' => $image,

        'group_privacy' => $group_privacy,
        'created_at' => $created_at,
        'group_visibility' => $group_visibility,
        "error" => 'false'


    );
    echo json_encode($response);
} else {
    $response[] = array(
        "message" => 'not updated',
        "error" => 'true',
    );
    echo json_encode($response);
}
