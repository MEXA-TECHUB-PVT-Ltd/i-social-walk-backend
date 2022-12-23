<?php

header('Content-Type: application/json');
include('../include/functions.php');
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$this_user_id = $DecodeData['this_user_id'];
$date = date("Y-m-d");
$sql = "SELECT * 
FROM friend_list 
where this_user_id='$this_user_id'
";

$run = mysqli_query($conn, $sql);
if (mysqli_num_rows($run)) {
    while ($row = mysqli_fetch_assoc($run)) {
        $friend_user_id = $row['friend_user_id'];

        $query = "Select * from daily_steps_records where user_id='$friend_user_id' And date='$date' ";
        $run2query = mysqli_query($conn, $query);
        if (mysqli_num_rows($run2query) > 0) {
            while ($row2 = mysqli_fetch_assoc($run2query)) {
                $friend_user_id = $row['friend_user_id'];
                $id = $row2['id'];
                $calories_burnt = $row2['calories_burnt'];
                $distancecovered = $row2['distancecovered'];
                $steps = $row2['steps'];
                $user_id = $row2['user_id'];
                $date = $row2['date'];
                $user_name = getname($user_id);
                $avg_pace = $row2['avg_pace'];
                $time_taken = $row2['time_taken'];
                $avg_speed = $row2['avg_speed'];
            }
            $response[] = array(
                "Daily Steps Records id" =>  $id,
                "friend user id" => $friend_user_id,
                "Date" => $date,
                "calories_burnt" =>  $calories_burnt,
                "avg_pace" => $avg_pace,
                "avg_speed" =>  $avg_speed,
                "Friend user name" => $user_name,
                "steps" => $steps,
                "distance_covered" => $distancecovered,
                "message" => 'friends ranking',

                "Time Taken" =>    $time_taken,
                "error" => false,
            );
        }
    }
}



echo json_encode($response);
