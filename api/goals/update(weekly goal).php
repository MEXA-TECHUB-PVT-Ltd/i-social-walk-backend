<?php
include('../include/connection.php');
include('../include/functions.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$user_id = $DecodeData['user_id'];
$daily_goal_steps = $DecodeData['daily_goal_steps'];


$user_name = getname($user_id);
$sql = "Select * from goals where user_id='$user_id' order by id desc limit 1";
$query = mysqli_query($conn, $sql);
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $week_uniq_id = $row['week_uniq_id'];
    }
    $sqlquery = "UPDATE goals SET weekly_goal_steps='$weekly_goal_steps ' WHERE  user_id='$user_id' AND week_uniq_id='$week_uniq_id' ";

    $run = mysqli_query($conn, $sqlquery);
    if ($run) {
        $response[] = array(
            "User Name" => $user_name,
            "User ID" => $user_id,
            "message" => 'Weekly  goals updated',

            "Weekly_goal_steps" =>    $weekly_goal_steps,
            "error" => false,
        );
    }
}
echo json_encode($response);
