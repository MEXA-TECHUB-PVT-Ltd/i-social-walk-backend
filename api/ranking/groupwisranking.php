<?php

header('Content-Type: application/json');

include('../include/connection.php');
include('../include/functions.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];
$sql = "SELECT * 
FROM user_groups
";

$run = mysqli_query($conn, $sql);
if (mysqli_num_rows($run)) {
    while ($row = mysqli_fetch_assoc($run)) {
        $group_id = $row['id'];

        $query = "Select * from group_member where group_id='$group_id' AND user_id!='$this_user_id'";
        $run2 = mysqli_query($conn, $query);
        if (mysqli_num_rows($run2) >= 0) {
            while ($row = mysqli_fetch_assoc($run2)) {
                $user_id = $row['user_id'];

                $query = "Select * from daily_steps_records  where  user_id='$user_id'";
                $run2 = mysqli_query($conn, $query);
                if (mysqli_num_rows($run2) >= 0) {
                    while ($row = mysqli_fetch_assoc($run2)) {
                        $id = $row['id'];
                        $calories_burnt = $row['calories_burnt'];
                        $distancecovered = $row['distancecovered'];
                        $user_id = $row['user_id'];
                        $user_name = getname($user_id);
                        $time_taken = $row['time_taken'];
                        $avg_pace = $row['avg_pace'];
                        $created_at = $row['date'];

                        $response[] = array(
                            "Group ID" =>  $group_id,
                            "Group calories_burnt" =>  $calories_burnt,
                            "distancecovered" => $distancecovered,
                            "user_name" => $user_name,
                            "status" => 'Ranking of members in groups ',
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
