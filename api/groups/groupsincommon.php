<?php
header('Content-Type:application/json');
header('Acess-Control-Allow-Origin:*');
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$user_id = $DecodeData['user_id'];
$friend_user_id = $DecodeData['friend_user_id'];
$sql = "SELECT * FROM group_member where user_id='$user_id'";
$run = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($run)) {

    $group_id = $row['group_id'];
    $sql1 = "SELECT * FROM group_member where user_id='$friend_user_id' AND group_id='$group_id'  AND status='membered'";
    $run1 = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($run1) > 0) {

        if ($run1) {
            $sql2 = "SELECT * FROM groups where id='$group_id'";
            $run2 = mysqli_query($conn, $sql2);
            while ($row2 = mysqli_fetch_assoc($run2)) {

                $response[] = array(
                    "Group Id" => $row2['id'],
                    "Group Name" => $row2['name'],
                    "Group privacy" => $row2['group_privacy'],
                    "Group Image" => $row2['image'],
                    "Created By User Id" => $row2['created_by_user_id']
                );
            }
        }
    }
}

echo json_encode($response);
