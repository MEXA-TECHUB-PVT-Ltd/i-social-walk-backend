<?php

header('Content-Type: application/json');

include('../include/connection.php');
include('../include/functions.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];
$sql = "SELECT * 
FROM challenges
";

$run = mysqli_query($conn, $sql);
if (mysqli_num_rows($run)) {
    while ($row = mysqli_fetch_assoc($run)) {
        $challenge_id = $row['id'];
        $challenge_name = $row['name'];
        $query = "Select * from challenges_participants where challenge_id='$challenge_id' AND user_id!='$this_user_id'";
        $run2 = mysqli_query($conn, $query);
        if (mysqli_num_rows($run2) >= 0) {
            while ($row = mysqli_fetch_assoc($run2)) {
                $user_id = $row['user_id'];
                $query1 = "Select * from users where  id='$user_id'";
                $run3 = mysqli_query($conn, $query1);
                if (mysqli_num_rows($run3) >= 0) {
                    while ($row = mysqli_fetch_assoc($run3)) {
                        $firstname = $row['first_name'];
                        $last_name = $row['last_name'];
                        $image = $row['image'];
                    }
                }
                $query = "Select * from daily_steps_records  where  user_id='$user_id'";
                $run2 = mysqli_query($conn, $query);
                if (mysqli_num_rows($run2) >= 0) {
                    while ($row1 = mysqli_fetch_assoc($run2)) {
                        $id = $row1['id'];
                        $user_id = $row1['user_id'];
                        $calories_burnt = $row1['calories_burnt'];
                        $distancecovered = $row1['distancecovered'];

                        $user_name = getname($user_id);
                        $time_taken = $row1['time_taken'];
                        $avg_pace = $row1['avg_pace'];
                        $created_at = $row1['date'];

                        $response[] = array(
                            "Challenge ID" =>  $challenge_id,
                            "challengeName" => $challenge_name,
                            "user_name" => $firstname . '' . $last_name,
                            "image" => $image,
                            "Challenge calories_burnt" =>  $calories_burnt,
                            "distancecovered" => $distancecovered,
                            "Image" => $image,
                            "status" => 'Ranking of members in Challenges ',
                            "Time Taken" => $time_taken,
                            "User id" => $user_id,
                            "Average Pace" =>  $avg_pace,
                            "error" => false,
                        );
                    }
                }
            }
        }
    }
}



echo json_encode($response);
