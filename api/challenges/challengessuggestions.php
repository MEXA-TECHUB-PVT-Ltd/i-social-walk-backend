<?php

header('Content-Type: application/json');

include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$user_id = $DecodeData['user_id'];
$sql = "SELECT * 
FROM challenges
ORDER BY RAND()";

$run = mysqli_query($conn, $sql);
if (mysqli_num_rows($run)) {
    while ($row = mysqli_fetch_assoc($run)) {
        $challenge_id = $row['id'];

        $query = "Select * from challenges_participants where challenge_id='$challenge_id' AND user_id='$user_id'";
        $run2 = mysqli_query($conn, $query);
        if (mysqli_num_rows($run2) <= 0) {
            $id = $row['id'];
            $name = $row['name'];
            $admin = $row['created_by_user_id'];
            $challenge_privacy = $row['challenge_privacy'];
            $challenge_type = $row['challenge_type'];
            $challenge_visibility = $row['challenge_visibility'];
            $start_date = $row['start_date'];

            $response[] = array(
                "challenge ID" =>  $challenge_id,
                "challenge Name" =>  $name,
                "admin" => $admin,
                "start_date" => $start_date,
                "status" => 'challenges for suggestions',
                "challenge type" => $challenge_type,
                "challenge privacy" => $challenge_privacy,
                "challenge visibility" =>  $challenge_visibility,
                "error" => false,
            );
        } else {

            $response[] = array(

                "message" => 'You are added in all challenges',
                "error" => false,
            );
        }
    }
}



echo json_encode($response);
