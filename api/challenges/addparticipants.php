<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$user_id = $data['user_id'];
$date = $data['date'];
$challenge_id = $data['challenge_id'];
$created_by_user_id = $data['created_by_user_id'];
$status = "Membered";

$sqlchallenge = "select * from challenges where id='$challenge_id'";
$finalqu = mysqli_query($conn, $sqlchallenge);
while ($row = mysqli_fetch_assoc($finalqu)) {
    if ($row['challenge_type'] == "indiviual") {
        $noti_type = "admin to user for challenges";

        foreach ($user_id as $user_id_list) {
            $uniqid = uniqid();
            $sql = "Insert into notification(noti_type,uniqid,from_id,to_id,date,status) Values ('{$noti_type}','{$uniqid}','{$created_by_user_id}','{$user_id_list}','{$date}','unread')";
            $query1 = mysqli_query($conn, $sql);
            $challengequery_f = "select * from notification where uniqid='$uniqid'";
            $fbinalquery_fb = mysqli_query($conn, $challengequery_f);
            if ($fbinalquery_fb) {
                while ($row = mysqli_fetch_assoc($fbinalquery_fb)) {
                    $id = $row['id'];
                    $sql11 = "INSERT INTO individual_challenge_notification(noti_type_id,challenge_id,status,created_date)VALUES('$id','$challenge_id','membered','$date')";
                    $mysqlifinal = mysqli_query($conn, $sql11);
                    if ($query1) {
                        $response[] = array(
                            "message" => 'admin to user for challenges',
                            "Challenges" => $challenge_id,
                            "user" => $user_id,
                            "created_by_user_id" => $created_by_user_id,
                            "error" => false

                        );
                    }
                }
            }
        }
        foreach ($user_id as $user_id_list) {
            $sql = "Insert into challenges_participants(challenge_id,user_id,status) Values ('{$challenge_id}','{$user_id_list}','membered')";
            $query = mysqli_query($conn, $sql);
        }

        if ($query) {
            $response[] = array(
                "message" => 'Successfully Added All Participants in Challenge',
                "Challenges" => $challenge_id,

                "error" => false

            );
        } else {
            $response[] = array(
                "message" => 'Not Added',

                "error" => false

            );
        }
    } else {
        $response[] = array(
            "message" => 'this challenge type is not indiviual ',

            "error" => false

        );
    }
}

echo json_encode($response);
