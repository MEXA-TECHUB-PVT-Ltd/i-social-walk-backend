<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$user_id = $data['user_id'];

$calories_burnt = $data['calories_burnt'];
$distancecovered = $data['distancecovered'];
$time_taken = $data['time_taken'];
$avg_speed = $data['avg_speed'];
$avg_pace = $data['avg_pace'];

$time_taken = $data['time_taken'];
$steps = $data['steps'];
$created_date = date('Y-m-d');

$sql = "Select * from goals where user_id='$user_id' order by id Desc limit 1";
$query = mysqli_query($conn, $sql);
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $week_uniq_id1 = $row['week_uniq_id'];
    }
    $sql = "Select * from daily_steps_records where user_id='$user_id' AND date='$created_date' ";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $stepsprev = $row['steps'];
            $timetakenprev = $row['time_taken'];
            $calories_burntprev = $row['calories_burnt'];
            $distancecoveredprev = $row['distancecovered'];
            $avg_speedprev = $row['avg_speed'];
            $avg_paceprev = $row['avg_pace'];
        }
        $stepsnew = $stepsprev + $steps;
        $timetakennew = $timetakenprev + $time_taken;
        $calories_burntnew = $calories_burntprev + $calories_burnt;
        $distance_coverednew =  $distancecoveredprev +  $distancecovered;
        $avg_speednew = ($avg_speedprev + $avg_speed) / 2;
        $avg_pacenew = ($avg_paceprev + $avg_pace) / 2;
        $sql = "UPDATE  daily_steps_records SET calories_burnt='$calories_burntnew',distancecovered='$distance_coverednew',time_taken='$timetakennew',avg_speed='$avg_speednew',avg_pace='$avg_pacenew',steps='$stepsnew' where  user_id='$user_id' AND date='$created_date' ";
        if (mysqli_query($conn, $sql)) {
            $response = array(
                'distancecovered' =>  $distance_coverednew, 'calories_burnt' => $calories_burntnew, 'time_taken' => $timetakennew, 'created_date' => $created_date, 'steps' => $stepsnew, 'Average Pace' => $avg_pacenew, 'message' => 'Updated', 'error' => false
            );
        }
    } else {
        $sql = "Insert into daily_steps_records(user_id,calories_burnt,distancecovered,time_taken,avg_speed,avg_pace,date,steps,weekly_steps_id) Values ('{$user_id}','{$calories_burnt}','{$distancecovered}','{$time_taken}','{$avg_speed}','{$avg_pace}','{$created_date}','{$steps}','$week_uniq_id1')";
        $query = mysqli_query($conn, $sql);
        $response = array('distancecovered' => $distancecovered, 'calories_burnt' => $calories_burnt, 'time_taken' => $time_taken, 'created_date' => $created_date, 'steps' => $steps, 'Averagepace' => $avg_pace, 'message' => 'Inserted Walk', 'error' => false);
    }
    echo json_encode($response);
}
