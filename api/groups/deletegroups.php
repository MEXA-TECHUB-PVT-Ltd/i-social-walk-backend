<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);

$group_id = $data['group_id'];


$sql1 = "Delete from user_groups where id='$group_id'";
$query = mysqli_query($conn, $sql1);
if ($query) {
    $response[] = array(
        "message" => 'Successfully Deleted group',
        "Group" => $group_id,

        "error" => false

    );

    $sql = "delete from group_member where group_id='$group_id'";
    $querygroup = mysqli_query($conn, $sql);
    if ($querygroup) {
        $response[] = array(
            "message" => 'Deleted Members ',

            "error" => false

        );
    }
}
echo json_encode($response);
