
<?php

header('Content-Type: application/json');
include('../include/functions.php');
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
if (isset($DecodeData['weekly_goal_steps1'])) {
    $weekly_goal_steps1 = $DecodeData['weekly_goal_steps1'];
}
if (isset($DecodeData['daily_goal_steps1'])) {
    $daily_goal_steps1 = $DecodeData['daily_goal_steps1'];
}

$user_id = $DecodeData['user_id'];
$date = date("Y-m-d");
$day = date('l');
$uniqid = uniqid();

if ($day == "Wednesday") {
    $sql = "Select * from goals where user_id='$user_id' AND date = '$date' order by id desc limit 1 ";
    $query1 = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query1) < 0) {

        while ($row = mysqli_fetch_assoc($query1)) {
            $daily_goal_steps = $row['daily_goal_steps'];
            $weekly_goal_steps = $row['weekly_goal_steps'];
        }
        $goalsinsertion = "Insert into goals(user_id,daily_goal_steps,weekly_goal_steps,date,week_uniq_id)VALUES('$user_id','$daily_goal_steps','$weekly_goal_steps','$date','$uniqid')";
        $query = mysqli_query($conn, $goalsinsertion);
        if ($query) {
            $response[] = array(
                "message" => 'Your Goals are Updated Auto as you didnot update ',
                "weekly_goal_steps" =>    $weekly_goal_steps,
                "daily_goal_steps" =>    $daily_goal_steps,
                "error" => false,
            );
        }
    } else {
        $sql = "Select * from goals where user_id='$user_id' order by id Desc limit 1";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            while ($row = mysqli_fetch_assoc($query)) {
                $week_uniq_id1 = $row['week_uniq_id'];
            }
            $sql = "UPDATE goals SET weekly_goal_steps='$weekly_goal_steps1',daily_goal_steps='$daily_goal_steps1 ' WHERE  user_id='$user_id' AND week_uniq_id='$week_uniq_id1' ";

            $run = mysqli_query($conn, $sql);
            if ($run) {
                $response[] = array(


                    "message" => 'goals updated',
                    "weekly_goal_steps" =>    $weekly_goal_steps1,
                    "daily_goal_steps" =>    $daily_goal_steps1,
                    "error" => false,
                );
            }
        }
    }
} else {
    $sql = "Select * from goals where user_id='$user_id' order by id Desc limit 1";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $week_uniq_id1 = $row['week_uniq_id'];
        }
        $sql = "UPDATE goals SET weekly_goal_steps='$weekly_goal_steps1',daily_goal_steps='$daily_goal_steps1 ' WHERE  user_id='$user_id' AND week_uniq_id='$week_uniq_id1' ";

        $run = mysqli_query($conn, $sql);
        if ($run) {
            $response[] = array(


                "message" => 'goals updated',
                "weekly_goal_steps" =>    $weekly_goal_steps1,
                "daily_goal_steps" =>    $daily_goal_steps1,
                "error" => false,
            );
        }
    }
}


echo json_encode($response);

?>