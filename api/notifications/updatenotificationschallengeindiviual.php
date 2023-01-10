<?php

include('../include/connection.php');
$data = json_decode(file_get_contents("php://input"), true);

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

$noti_type = "admin to indiviual challenge acception";
$sql = "update individual_challenge_notification  SET status='$status' where noti_type_id='$noti_type_id'";
$query = mysqli_query($conn, $sql);

if ($query) {
    $sql = "Select * from individual_challenge_notification where noti_type_id='$noti_type_id' ";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {

            $noti_type_id = $row['noti_type_id'];
            $challenge_id = $row['challenge_id'];
        }

        //for user

        $uniqid = uniqid();

        $sqlfin = "Insert into notification(noti_type,uniqid,from_id,to_id,date,status) Values ('{$noti_type}','{$uniqid}','$to_id','$from_id','$date','unread')";
        $resultfin = mysqli_query($conn, $sqlfin);

        if ($resultfin) {
            $response[] =
                array('error' => false, 'Message' => 'Request Accepted');
            $sqlfinalquery = "select * from notification where uniqid='$uniqid'";
            $final = mysqli_query($conn, $sqlfinalquery);
            while ($row = mysqli_fetch_assoc($final)) {
                $id = $row['id'];
            }
            $sql = "Insert into individual_challenge_notification(noti_type_id,challenge_id,status,created_date) Values ('{$id}','{$challenge_id}','$status','$date')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
            }

            $sqlch = "update challenges_participants  SET status='$status' where user_id='$from_id' AND challenge_id='$challenge_id'";
            $querych = mysqli_query($conn, $sqlch);
            if ($querych) {
            }
        }
    }
}


echo json_encode($response);
