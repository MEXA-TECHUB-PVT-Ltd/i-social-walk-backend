<?php

$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'];
include('../include/connection.php');
$sql = "Select * from user_groups WHERE  name LIKE '%$data[name]%'";

$result = mysqli_query($conn, $sql);

$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $response[] = array('error' => 'false', 'Message' => 'Succesfully fetched groups', 'groups' => $output);
} else {

    $response[] = array(
        "message" => 'No Record found',

        "error" => false

    );
}
echo json_encode($response);
