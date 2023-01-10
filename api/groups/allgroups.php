<?php
header('Content-Type:application/json');
header('Acess-Control-Allow-Origin:*');
include('../include/connection.php');

$sql = "SELECT * FROM user_groups";
$run = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($run)) {


    $response[] = array(
        "id" => $row['id'],
        "image_link" => $row['image'],
        "name" => $row['name'],
        "group_privacy" => $row['group_privacy'],
        "group_visibility" => $row['group_visibility'],
        "created_at" => $row['created_at'],
    );
}


echo json_encode($response);
