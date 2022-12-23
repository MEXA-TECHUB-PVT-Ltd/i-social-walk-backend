<?php
include('../include/connection.php');
include('../include/functions.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$user_id = $DecodeData['user_id'];
$date = date("Y-m-d");
$user_name = getname($user_id);

$sqlquery = "select * from daily_steps_records where user_id='$user_id'";
$querfinal = mysqli_query($conn, $sqlquery);
if (mysqli_num_rows($querfinal) > 0) {
    while ($row = mysqli_fetch_assoc($querfinal)) {
        $steps = $row['steps'];
    }
    $sql = "select * from goals  where user_id='$user_id' AND date='$date'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row1 = mysqli_fetch_assoc($query)) {
            $daily_goal_steps1 = $row1['daily_goal_steps'];
        }
        if ($steps <= $daily_goal_steps1) {

            $response[] = array(
                "message" => 'Sorry You Didnot reached daily goal.but keep going on',
                "error" => 'false',


            );
        } else {
            $response[] = array(

                "message" => 'You are Doing great carry on!',
                "error" => 'false',

            );
        }
    } else {
        $response[] = array(
            "message" => 'Start Walking Today',
            "error" => 'false',


        );
    }
} else {
    $response[] = array(
        "message" => 'You didnot set any goal yet ',
        "error" => 'false',


    );
}
echo json_encode($response);
