<?php

header('Content-Type: application/json');

include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];
$sql = "SELECT * 
FROM user_groups

ORDER BY RAND() limit 10";

$run = mysqli_query($conn, $sql);
if (mysqli_num_rows($run)) {
    while ($row = mysqli_fetch_assoc($run)) {
        $group_id = $row['id'];

        $query = "Select * from group_member where group_id='$group_id' AND user_id='$this_user_id'";
        $run2 = mysqli_query($conn, $query);
        if (mysqli_num_rows($run2) <= 0) {


            $response[] = array(
                "Group ID" =>  $group_id,
                "Group Name" =>  $row['name'],

                "status" => 'user_groups for suggestions',
                "group privacy" => $row['group_privacy'],
                "group visibility" =>  $row['group_visibility'],
                "error" => false,
            );
        }
    }
    if (empty($response)) {
        $response[] = array(
            "message" => "you are added in all  groups",
            "error" => true,
        );
    }
}



echo json_encode($response);
