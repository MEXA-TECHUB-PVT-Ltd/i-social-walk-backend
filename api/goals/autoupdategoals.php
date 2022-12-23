
<?php

header('Content-Type: application/json');
include('../include/functions.php');
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$user_id = $DecodeData['user_id'];
$date = date("Y-m-d");
$day = date('l');
$uniqid = uniqid();
$sql = "select * from goals where user_id='$user_id' and date != '$date' order by id desc limit 1 ";
$query1 = mysqli_query($conn, $sql);
if (mysqli_num_rows($query1) < 0) {
    if ($day == "Wednesday") {

        $sql = "Select * from goals where user_id='$user_id' order by id desc limit 1 ";
        $query1 = mysqli_query($conn, $sql);
        if ($query1) {
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
        }
    } else {
        $uniqid1 = uniqid();
        $goalsinsertion = "Insert into goals(user_id,daily_goal_steps,weekly_goal_steps,date,week_uniq_id)VALUES('$user_id','1400','1400','$date','$uniqid1')";
        $query = mysqli_query($conn, $goalsinsertion);
        if ($query) {
            $queryfinal = "select * from goals where user_id='$user_id' AND week_uniq_id='$uniqid1' ";
            $query1 = mysqli_query($conn, $queryfinal);
            if ($query1) {
                while ($row = mysqli_fetch_assoc($query))
                    if ($query) {
                        $daily_goal_steps = $row['daily_goal_steps'];
                        $weekly_goal_steps = $row['weekly_goal_steps'];
                    }
            } else {
                $response = array(
                    "daily_goal_steps" => $daily_goal_steps,
                    "weekly_goal_steps" => $weekly_goal_steps,
                    "Message" => "Goal Added",
                    "error" => false
                );
            }
        }
    }
} else {
    $response = array(

        "Message" => "No Goals Updated",
        "error" => false
    );
}


echo json_encode($response);

?>