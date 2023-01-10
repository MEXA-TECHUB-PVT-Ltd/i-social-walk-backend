<?php

include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);
$uniqid = uniqid();
//we need status and noti_type_id
$status = $data['status'];
$noti_type_id = $data['noti_type_id'];
$date = $data['date'];
$sql = "Select * from notification where id='$noti_type_id ' ";
$query = mysqli_query($conn, $sql);
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {


        $to_id = $row['to_id'];
        $from_id = $row['from_id'];
    }
}

$noti_type = "admin to group challenge notification";
$sql = "update challenges_groups SET status='$status' where noti_type_id='$noti_type_id'";
$query = mysqli_query($conn, $sql);

if ($query) {
    $sql = "Select * from challenges_groups where noti_type_id='$noti_type_id' ";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {

            $noti_type_id = $row['noti_type_id'];
            $challenge_id = $row['challenge_id'];
        }

        //for user

        $sql = "Insert into notification(noti_type,uniqid,from_id,to_id,date,status) Values ('{$noti_type}','{$uniqid}','$to_id','$from_id','$created_date','unread')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $response[] =
                array('error' => false, 'Message' => 'Request Accepted');
        }
        $sql = "update challenges_participants  SET status='$status' where user_id='$from_id' AND challenge_id='$challenge_id'";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            $response[] =
                array('error' => false, 'Message' => 'Request Accepted');
        }
    }
}

echo json_encode($response);
